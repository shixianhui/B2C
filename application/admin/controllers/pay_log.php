<?php
class Pay_log extends CI_Controller {
	private $_title = ' 第三方支付管理';
	private $_tool = '';
	private $_table = 'pay_log';
	private $_payment_type_arr = array('alipay'=>'支付宝','weixin'=>'微信', 'ebank'=>'银联');
	private $_order_type_arr = array('orders'=>'购物支付','recharge'=>'余额充值','score_gold'=>'金象积分充值','score_silver'=>'银象积分充值','orders_refund'=>'购物退款', 'recharge_refund'=>'余额充值退款','score_gold_refund'=>'金象积分退款','score_silver_refund'=>'银象积分退款');
	private $_trade_status_msg = array('WAIT_BUYER_PAY'=>'等待买家付款', 'TRADE_CLOSED'=>'交易关闭', 'TRADE_SUCCESS'=>'交易成功', 'TRADE_PENDING'=>'等待卖家收款', 'TRADE_FINISHED'=>'交易成功');

	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/pay_log_tool", array('title'=>''), TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
		$this->load->model('Financial_model', '', TRUE);
		$this->load->model('Orders_model', '', TRUE);
		$this->load->model('Score_model', '', TRUE);
    	$this->load->helper(array('url', 'my_fileoperate', 'file'));
	}

	public function index($clear = 0, $page = 0) {
		checkPermission("{$this->_table}_index");
	    clearSession(array('search'));
	    if ($clear) {
	    	$clear = 0;
		    $this->session->unset_userdata(array('search'=>''));
		}
		$uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
		$uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$page}";
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>$uri_sg));
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):NULL;

	    if ($_POST) {
			$strWhere = "{$this->_table}.id > 0";

			$order_type = $this->input->post('order_type', TRUE);
			$payment_type = $this->input->post('payment_type', TRUE);
			$order_num = trim($this->input->post('order_num', TRUE));
			$user_id = trim($this->input->post('user_id', TRUE));
			$username = trim($this->input->post('username', TRUE));
			$buyer_email = trim($this->input->post('buyer_email', TRUE));
			$out_trade_no = trim($this->input->post('out_trade_no', TRUE));
			$trade_no = trim($this->input->post('trade_no', TRUE));
			$trade_status = $this->input->post('trade_status', TRUE);
		    $startTime = $this->input->post('inputdate_start');
		    $endTime = $this->input->post('inputdate_end');

		    if ($order_type) {
		    	$strWhere .= " and {$this->_table}.order_type = '{$order_type}'";
		    }
		    if ($payment_type) {
		    	$strWhere .= " and {$this->_table}.payment_type = '{$payment_type}'";
		    }
		    if ($order_num) {
		    	$strWhere .= " and {$this->_table}.order_num = '{$order_num}'";
		    }
		    if ($user_id) {
		        $strWhere .= " and {$this->_table}.user_id = '{$user_id}'";
		    }
		    if ($username) {
		        $strWhere .= " and user.username = '{$username}'";
		    }
		    if ($buyer_email) {
		        $strWhere .= " and {$this->_table}.buyer_email = '{$buyer_email}'";
		    }
		    if ($out_trade_no) {
		        $strWhere .= " and {$this->_table}.out_trade_no = '{$out_trade_no}'";
		    }
		    if ($trade_no) {
		        $strWhere .= " and {$this->_table}.trade_no = '{$trade_no}'";
		    }
		    if ($trade_status) {
		        $strWhere .= " and {$this->_table}.trade_status = '{$trade_status}'";
		    }
		    if (! empty($startTime) && ! empty($endTime)) {
		    	$strWhere .= " and {$this->_table}.add_time > ".strtotime($startTime.' 00:00:00')." and {$this->_table}.add_time < ".strtotime($endTime." 23:59:59")." ";
		    }
		    $this->session->set_userdata('search', $strWhere);
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
		        $strWhere = NULL;
				$is_arrival = 0;
				if ($value['order_type'] == 'orders')  {
					$strWhere['type'] = 'order_out';
					$ret_id = 0;
					$orders_info = $this->Orders_model->get('id', array('order_number'=>$value['order_num']));
					if ($orders_info) {
						$ret_id = $orders_info['id'];
					}
					$strWhere['ret_id'] = $ret_id;
					$count = $this->Financial_model->rowCount($strWhere);
					if ($count) {
						$is_arrival = 1;
					}
				} else if ($value['order_type'] == 'recharge')  {
					$strWhere['type'] = 'third_recharge_in';
					$strWhere['ret_id'] = $value['id'];
					$count = $this->Financial_model->rowCount($strWhere);
					if ($count) {
						$is_arrival = 1;
					}
				} else if ($value['order_type'] == 'score_gold' || $value['order_type'] == 'score_silver')  {
					$strWhere['type'] = 'third_recharge_in';
					$strWhere['ret_id'] = $value['id'];
					$count = $this->Score_model->rowCount($strWhere);
					if ($count) {
						$is_arrival = 1;
					}
				}
				$itemList[$key]['is_arrival'] = $is_arrival;
		    }
		}

		$data = array(
		        'tool'      =>$this->load->view("element/pay_log_tool", array('title'=>'支付宝充值记录'), TRUE),
				'itemList'  =>$itemList,
		        'trade_status_msg'=>$this->_trade_status_msg,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		        'table'=>$this->_table,
				'payment_type_arr'=>$this->_payment_type_arr,
				'order_type_arr'=>$this->_order_type_arr
		        );

	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view($this->_table.'/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
		checkPermission("{$this->_table}_edit");
		$prfUrl = $this->session->userdata($this->_table.'RefUrl')?$this->session->userdata($this->_table.'RefUrl'):base_url()."admincp.php/tasktaketime/index/";
		if ($_POST) {
			$remark = $this->input->post('remark', TRUE);

		    $fields = array(
			          'remark'=>  $remark,
		              'rem_time'=>time()
			          );
		    if ($this->tableObject->save($fields, array('id'=>$id))) {
				printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$itemInfo = $this->tableObject->get(array('pay_log.id'=>$id));
		if ($itemInfo) {
			$strWhere = NULL;
			$ret_id = 0;
		    $orders_info = $this->Orders_model->get('id', array('order_number'=>$itemInfo['order_num']));
		    if ($orders_info) {
				$ret_id = $orders_info['id'];
			}
			$strWhere['ret_id'] = $ret_id;
		    $count = $this->Financial_model->rowCount($strWhere);
		    if ($count) {
		        $itemInfo['is_arrival'] = 1;
		    } else {
		        $itemInfo['is_arrival'] = 0;
		    }
		}


		$data = array(
		        'tool'=>$this->load->view("element/pay_log_tool", array('title'=>'处理'), TRUE),
		        'table'=>$this->_table,
		        'itemInfo'=>$itemInfo,
		        'trade_status_msg'=>$this->_trade_status_msg,
				'payment_type_arr'=>$this->_payment_type_arr,
				'order_type_arr'=>$this->_order_type_arr,
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