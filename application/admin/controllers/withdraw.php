<?php
class Withdraw extends CI_Controller {
	private $_title = '提现申请管理';
	private $_tool = '';
	private $_table = 'withdraw';
	private $_user_type_arr = array('0'=>'会员', '1'=>'商家');
	private $_type_arr = array('alipay'=>'支付宝', 'weixin'=>'微信', 'ebank'=>'银联');
	private $_score_type_arr = array('gold'=>'金象币', 'silver'=>'银象币');
	private $_display_arr = array('0'=>'<font color="red">处理中</font>', '1'=>'提现成功', '2'=>'提现失败');
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/withdraw_tool", NULL, TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
		$this->load->model('Elephant_log_model', '', TRUE);
		$this->load->model('User_model', '', TRUE);
    	$this->load->helper(array('url', 'my_fileoperate', 'file'));
	}

	public function index($clear = 0, $page = 0) {
		checkPermission('withdraw_index');
		clearSession(array('search_index'));
        if ($clear) {
        	$clear = 0;
        	$this->session->unset_userdata(array('search_index'=>''));
        }
        $uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
        $uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$page}";
        $this->session->set_userdata(array("{$this->_table}RefUrl"=>$uri_sg));
        $condition = "{$this->_table}.id > 0";
        $strWhere = $this->session->userdata('search_index')?$this->session->userdata('search_index'):$condition;

	    if ($_POST) {
			$strWhere = $condition;

			$username = $this->input->post('username', TRUE);
			$user_id = $this->input->post('user_id', TRUE);
			$real_name = $this->input->post('real_name', TRUE);
			$account = $this->input->post('account', TRUE);
			$type = $this->input->post('type', TRUE);
			$display = $this->input->post('display', TRUE);
		    $startTime = $this->input->post('inputdate_start');
		    $endTime = $this->input->post('inputdate_end');

		    if ($username) {
		        $strWhere .= " and {$this->_table}.username = '{$username}'";
		    }
	        if (! empty($user_id) ) {
		        $strWhere .= " and {$this->_table}.user_id = '{$user_id}'";
		    }
	        if (! empty($real_name) ) {
		        $strWhere .= " and {$this->_table}.real_name = '{$real_name}'";
		    }
		    if (! empty($account) ) {
		        $strWhere .= " and {$this->_table}.account = '{$account}'";
		    }
		    if ($type != "") {
		    	$strWhere .= " and {$this->_table}.type = {$type} ";
		    }
		    if ($display != "") {
		    	$strWhere .= " and {$this->_table}.display = {$display} ";
		    }
		    if (! empty($startTime) && ! empty($endTime)) {
		    	$strWhere .= " and {$this->_table}.add_time > ".strtotime($startTime.' 00:00:00')." and {$this->_table}.add_time < ".strtotime($endTime." 23:59:59")." ";
		    }
		    $this->session->set_userdata('search_index', $strWhere);
		}
	    //分页
		$this->config->load('pagination_config', TRUE);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationCount = $this->tableObject->rowCount($strWhere);
    	$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/index/{$clear}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$itemList = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		if ($itemList) {
		    foreach ($itemList as $key=>$value) {
		    	$user_type = '';
		        $user_info = $this->User_model->getInfo('user_type', array('id'=>$value['user_id']));
		        if ($user_info) {
			    	$user_type = $user_info['user_type'];
		        }
		        $itemList[$key]['user_type'] = $user_type;
		    }
		}

		$data = array(
		        'tool'      =>$this->_tool,
				'itemList'  =>$itemList,
		        'type_arr'=>$this->_type_arr,
		        'display_arr'=>$this->_display_arr,
				'user_type_arr'=>$this->_user_type_arr,
				'score_type_arr'=>$this->_score_type_arr,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		        'table'=>$this->_table
		        );

	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view($this->_table.'/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

    public function save($id = NULL) {
		checkPermission('withdraw_edit');
		$prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index/";
		$itemInfo = $this->tableObject->get('*', array('id'=>$id));
		if ($_POST) {
			if ($itemInfo['display']) {
			    printAjaxError('fail', "提现申请已经处理过，不用重复处理");
			}
			$display = $this->input->post('display', TRUE);
			$fields = array(
			          'display'=>     $display,
			          'rep_time'=>    time(),
			          'remark'=>      $this->input->post('remark', TRUE)
			          );
		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
		    	$elephant_log_info = $this->Elephant_log_model->get(array('ret_id'=>$itemInfo['id'], 'score_type'=>$itemInfo['score_type'], 'type'=>'withdraw_out'));
		    	if ($elephant_log_info) {
			    	//提现成功
			    	if ($display == 1) {
			    		$cause = str_replace('[处理中]', '[提现成功-'.date('Y-m-d H:i', time()).']', $elephant_log_info['cause']);
			    		$this->Elephant_log_model->save(array('cause'=>$cause), array('id'=>$elephant_log_info['id']));
			    	}
			    	//提现失败
			    	else if ($display == 2) {
			    		$cause = str_replace('[处理中]', '[提现失败-'.date('Y-m-d H:i', time()).']', $elephant_log_info['cause']);
			    		$this->Elephant_log_model->save(array('cause'=>$cause), array('id'=>$elephant_log_info['id']));
			    		//退款操作
			    		$user_info = $this->User_model->getInfo('*', array('id'=>$elephant_log_info['user_id']));
			    		if ($user_info) {
                            if ($itemInfo['score_type'] == 'gold') {
                            	//退款记录
                            	$balance = $user_info['total_gold'] + $itemInfo['score_num'];
                            	if ($this->User_model->save(array('total_gold'=>$balance), array('id'=>$user_info['id']))) {
                            		$fields = array(
                            				'cause' => '提现退款-提现失败退款',
                            				'score' =>   $itemInfo['score_num'],
                            				'balance' => $balance,
                            				'score_type'=>'gold',
                            				'type' => 'withdraw_in',
                            				'add_time' => time(),
                            				'username' => $user_info['username'],
                            				'user_id' =>  $user_info['id'],
                            				'ret_id' =>   $itemInfo['id']
                            		);
                            		$this->Elephant_log_model->save($fields);
                            	}
                            } else if ($itemInfo['score_type'] == 'silver') {
                            	//退款记录
                            	$balance = $user_info['total_silver'] + $itemInfo['score_num'];
                            	if ($this->User_model->save(array('total_silver'=>$balance), array('id'=>$user_info['id']))) {
                            		$fields = array(
                            				'cause' => '提现退款-提现失败退款',
                            				'score' =>   $itemInfo['score_num'],
                            				'balance' => $balance,
                            				'score_type'=>'silver',
                            				'type' =>     'withdraw_in',
                            				'add_time' => time(),
                            				'username' => $user_info['username'],
                            				'user_id' =>  $user_info['id'],
                            				'ret_id' =>   $itemInfo['id']
                            		);
                            		$this->Elephant_log_model->save($fields);
                            	}
                            }
			    		}
			    	}
		    	}
				printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$data = array(
		        'tool'=>$this->_tool,
		        'table'=>$this->_table,
		        'itemInfo'=>$itemInfo,
		        'type_arr'=>$this->_type_arr,
		        'display_arr'=>$this->_display_arr,
				'user_type_arr'=>$this->_user_type_arr,
				'score_type_arr'=>$this->_score_type_arr,
		        'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view($this->_table.'/save', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}
}
/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */