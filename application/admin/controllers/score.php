<?php
class Score extends CI_Controller {
	private $_title = '会员积分消费记录';
	private $_type_arr = array(
    		'login_score_in'=>'每日签到奖励',
    		'reg_score_in' => '新用户注册',
    		'join_user_score_in'=>  '发展会员',
    		'join_seller_score_in'=>'发展商家',
    		'orders_out'=>'退交易积分',
    		'orders_in'=>'返交易积分',
    		'presenter_out'=>'退推广提成',
    		'presenter_in'=>'返推广提成',
    		'orders_buy_out'=>'积分换购',
    		'orders_buy_in'=>'退换购积分',
    		'recharge_in'=>'返积分',
    		'recharge_out'=>'扣积分',
    		'convert_in'=>'兑换入账',
    		'convert_out'=>'兑换支付',
			'cz_in'=>'充值',
			'cz_out'=>'扣款',
			'third_recharge_in'=>'在线充值',
			'third_recharge_out'=>'充值退款'
        );
	private $_tool = '';
	private $_table = '';
	private $_template = 'score';
	private $_score_type_arr = array('gold'=>'金象积分', 'silver'=>'银象积分');

	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/score_tool", NULL, TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('User_model', '', TRUE);
	}

	public function index($clear = 0, $userId = 0, $score_type = 'gold', $page = 0) {
		checkPermission("{$this->_template}_index");
	    if ($clear) {
	    	$clear = 0;
		    $this->session->unset_userdata(array('search'=>''));
		}
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$contion = "{$this->_table}.score_type = '{$score_type}' ";
		if ($userId) {
		    $contion .= " and {$this->_table}.user_id = '{$userId}' ";
		}
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):$contion;

		if ($_POST) {
			$strWhere = $contion;

			$user_id = trim($this->input->post('user_id', TRUE));
			$username = trim($this->input->post('username', TRUE));
		    $startTime = $this->input->post('inputdate_start');
		    $endTime = $this->input->post('inputdate_end');

		    if (! empty($user_id) ) {
		    	$strWhere .= " and user_id = '{$user_id}'";
		    }
		    if (! empty($username) ) {
		        $strWhere .= " and username = '{$username}'";
		    }
		    if (! empty($startTime) && ! empty($endTime)) {
		    	$strWhere .= " and add_time > ".strtotime($startTime.' 00:00:00')." and add_time < ".strtotime($endTime.' 23:59:59').' ';
		    }
		    $this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->tableObject->rowCount($strWhere);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/index/{$clear}/{$userId}/{$score_type}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 6;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$itemList = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		$count0 = 0;
		$count1 = 0;
		$sumprice0 = 0;
		$sumprice1 = 0;
		foreach ($itemList as $item) {
			//支付
		    if ($item['score'] < 0) {
		        $count1++;
		        $sumprice1+=$item['score'];
		    } else {
		        $count0++;
		        $sumprice0+=$item['score'];
		    }
		}

		$data = array(
		        'tool'      =>$this->_tool,
				'itemList'  =>$itemList,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		        'count0'=>$count0,
		        'count1'=>$count1,
		        'sumprice0'=>$sumprice0,
		        'sumprice1'=>$sumprice1,
				'type_arr'=>$this->_type_arr,
				'score_type'=>$score_type,
		        'table'=>$this->_table
		        );

	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view($this->_table.'/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function recharge($userId = NULL) {
		checkPermission("{$this->_template}_recharge");
		if ($_POST) {
			$score_type = $this->input->post('score_type', TRUE);
			$username = trim($this->input->post('username', TRUE));
			$user_id = trim($this->input->post('user_id', TRUE));
			$score = $this->input->post('score', TRUE);
			$cause = $this->input->post('cause', TRUE);

			if (!$score_type) {
				printAjaxError('score_type', "请选择积分类型");
			}
			if ($score_type != 'gold' && $score_type != 'silver') {
				printAjaxError('score_type', "请选择正确的积分类型");
			}
			if (!$username && !$user_id) {
				printAjaxError('user_id', "用户名与用户ID必须填写一个");
			}
			if (!$score) {
				printAjaxError('score', "请输入充值积分数量");
			}
			if (!preg_match('/^[-\+]?\d+$/', $score)) {
				printAjaxError('score', '请输入正确的充值积分数量');
			}
			if ($score <= 0) {
				printAjaxError('score', "充值积分数量必须大于零！");
			}
			$userInfo = NULL;
			if ($username) {
				$userInfo = $this->User_model->getInfo('*', array('username'=>$username));
			} else {
                if ($user_id) {
                	$userInfo = $this->User_model->getInfo('*', array('id'=>$user_id));
                }
			}
			if (! $userInfo) {
				printAjaxError('fail', "充值用户信息不存在，充值失败");
			}
			if ($score_type == 'gold') {
				$balance = $score + $userInfo['score_gold'];
				$fields = array('score_gold'=>$balance);
				if ($this->User_model->save($fields, array('id'=>$userInfo['id']))) {
					$fields = array(
							'cause'=>'充值成功-'.$cause,
							'score'=>$score,
							'balance'=>$balance,
							'score_type'=>'gold',
							'type'=>'cz_in',
							'add_time'=>time(),
							'user_id'=>$userInfo['id'],
							'username'=>$userInfo['username']
					);
					$this->tableObject->save($fields);
					printAjaxSuccess(base_url().'admincp.php/score/index/1/0/gold', '充值成功！');
				} else {
					printAjaxError('fail', "操作失败！");
				}
			} else if ($score_type == 'silver') {
				$balance = $score + $userInfo['score_silver'];
				$fields = array('score_silver'=>$balance);
				if ($this->User_model->save($fields, array('id'=>$userInfo['id']))) {
					$fields = array(
							'cause'=>'充值成功-'.$cause,
							'score'=>$score,
							'balance'=>$balance,
							'score_type'=>'silver',
							'type'=>'cz_in',
							'add_time'=>time(),
							'user_id'=>$userInfo['id'],
							'username'=>$userInfo['username']
					);
					$this->tableObject->save($fields);
					printAjaxSuccess(base_url().'admincp.php/score/index/1/0/silver', '充值成功！');
				} else {
					printAjaxError('fail', "操作失败！");
				}
			}
		}
		$userInfo = array();
		if ($userId) {
			$userInfo = $this->User_model->getInfo('username, id', array('id'=>$userId));
		}
		$data = array(
				'tool'      =>$this->_tool,
				'table'=>$this->_table,
				'score_type_arr'=>$this->_score_type_arr,
				'userInfo'=>$userInfo
		);

		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view($this->_table.'/recharge', $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}

	public function debit($userId = NULL) {
		checkPermission("{$this->_template}_debit");
		if ($_POST) {
			$score_type = $this->input->post('score_type', TRUE);
			$username = trim($this->input->post('username', TRUE));
			$user_id = trim($this->input->post('user_id', TRUE));
			$score = $this->input->post('score', TRUE);
			$cause = $this->input->post('cause', TRUE);

			if (!$score_type) {
				printAjaxError('score_type', "请选择积分类型");
			}
			if ($score_type != 'gold' && $score_type != 'silver') {
				printAjaxError('score_type', "请选择正确的积分类型");
			}
			if (!$username && !$user_id) {
				printAjaxError('user_id', "用户名与用户ID必须填写一个");
			}
			if (!$score) {
				printAjaxError('score', "请输入扣款积分数量");
			}
			if (!preg_match('/^[-\+]?\d+$/', $score)) {
				printAjaxError('score', '请输入正确的扣款积分数量');
			}
			if ($score <= 0) {
				printAjaxError('score', "扣款积分数量必须大于零！");
			}
			$userInfo = NULL;
			if ($username) {
				$userInfo = $this->User_model->getInfo('*', array('username'=>$username));
			} else {
                if ($user_id) {
                	$userInfo = $this->User_model->getInfo('*', array('id'=>$user_id));
                }
			}
			if (! $userInfo) {
				printAjaxError('fail', "扣款用户信息不存在，扣款失败");
			}
			if ($score_type == 'gold') {
				$balance = $userInfo['score_gold'] - $score;
				if ($balance < 0) {
					printAjaxError('fail', "金象积分余额不足，扣款失败");
				}
				$fields = array('score_gold'=>$balance);
				if ($this->User_model->save($fields, array('id'=>$userInfo['id']))) {
					$fields = array(
							'cause'=>'扣款成功-'.$cause,
							'score'=>-$score,
							'balance'=>$balance,
							'score_type'=>'gold',
							'type'=>'cz_out',
							'add_time'=>time(),
							'user_id'=>$userInfo['id'],
							'username'=>$userInfo['username']
					);
					$this->tableObject->save($fields);
					printAjaxSuccess(base_url().'admincp.php/score/index/1/0/gold', '扣款成功！');
				} else {
					printAjaxError('fail', "操作失败！");
				}
			} else if ($score_type == 'silver') {
				$balance = $userInfo['score_silver'] - $score;
				if ($balance < 0) {
					printAjaxError('fail', "银象积分余额不足，扣款失败");
				}
				$fields = array('score_silver'=>$balance);
				if ($this->User_model->save($fields, array('id'=>$userInfo['id']))) {
					$fields = array(
							'cause'=>'扣款成功-'.$cause,
							'score'=>-$score,
							'balance'=>$balance,
							'score_type'=>'silver',
							'type'=>'cz_out',
							'add_time'=>time(),
							'user_id'=>$userInfo['id'],
							'username'=>$userInfo['username']
					);
					$this->tableObject->save($fields);
					printAjaxSuccess(base_url().'admincp.php/score/index/1/0/silver', '扣款成功！');
				} else {
					printAjaxError('fail', "操作失败！");
				}
			}
		}
		$userInfo = array();
		if ($userId) {
			$userInfo = $this->User_model->getInfo('username, id', array('id'=>$userId));
		}
		$data = array(
				'tool'      =>$this->_tool,
				'table'=>$this->_table,
				'score_type_arr'=>$this->_score_type_arr,
				'userInfo'=>$userInfo
		);

		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view($this->_table.'/debit', $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}
}
/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */