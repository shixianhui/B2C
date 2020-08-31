<?php

class Order extends CI_Controller {
	private $_status_arr = array(
			'0' => '<font color="#ff4200">待付款</font>',
			'1' => '<font color="#cc3333">待发货</font>',
			'2' => '<font color="#ff811f">待收货</font>',
			'3' => '<font color="#066601">交易成功</font>',
			'4' => '<font color="#a0a0a0">交易关闭</font>'
	);
    private $_deliveryTime = array('1' => '工作日、双休日均可(周一至周日)', '2' => '工作日(周一至周五)', '3' => '双休日(周六周日)');

    private $_order_type_arr = array(
        '0' => '我的订单',
        '1' => '拼团砍价订单'
    );
    private $_table = 'orders';
    private $_template = 'order';

    public function __construct() {
        parent::__construct();
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Cart_model', '', TRUE);
        $this->load->model('Payment_way_model', '', TRUE);
        $this->load->model('Area_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Postage_price_model', '', TRUE);
        $this->load->model('Postage_way_model', '', TRUE);
        $this->load->model('Free_postage_setting_model', '', TRUE);
        $this->load->model('Orders_detail_model', '', TRUE);
        $this->load->model('Orders_process_model', '', TRUE);
        $this->load->model('User_address_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Financial_model', '', TRUE);
        $this->load->model('Ptkj_record_model', '', TRUE);
        $this->load->model('Pintuan_model', '', TRUE);
        $this->load->model('Promotion_ptkj_model', '', TRUE);
        $this->load->model('Chop_record_model', '', TRUE);
        $this->load->model('Comment_model', '', TRUE);
        $this->load->model('Exchange_model', '', TRUE);
        $this->load->model('Financial_model', '', TRUE);
        $this->load->model('Flash_sale_record_model', '', TRUE);
        $this->load->model('Score_model', '', TRUE);
        $this->load->model('Message_model', '', TRUE);
        $this->load->model('Score_setting_model', '', TRUE);
        $this->load->model('Product_size_color_model', '', TRUE);
        $this->load->model('Pay_log_model', '', TRUE);

        $this->load->library('Form_validation');
        $this->load->library('Pagination');
        $this->load->helper('my_functionlib');
        $this->load->library('Getuiapiclass');
    }

    public function index($s = 'all', $order_type = 0, $page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        if (!$this->uri->segment(5)) {
            $this->session->unset_userdata(array('search' => ''));
            $this->session->unset_userdata(array('order_txt' => ''));
            $this->session->unset_userdata(array('addtime' => ''));
            $page = 0;
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>订单中心</a> > 我的订单";
        $user_id = get_cookie('user_id');
        $keyword = '';
        $add_time = '';
        $strWhere = "user_id = {$user_id} and is_delete = 0 ";
        if ($s != 'all' && $s != 'pj') {
        	$strWhere .= " and status = {$s} ";
        } else {
        	if ($s == 'pj') {
        		$strWhere .= " and status = 3 and is_comment_to_seller = 0 ";
        	}
        }
        if ($_GET) {
        	$keyword = $this->input->get('keyword', true);
        	$add_time = $this->input->get('add_time', true);

        	if ($keyword) {
        		$strWhere .= " and order_number = '{$keyword}' ";
        	}
        	if ($add_time) {
        		if($add_time == 'one_week') {
        			$time = time()-7*24*60*60;
        			$strWhere .= " and add_time > {$time} ";
        		} else if($add_time == 'one_month'){
        			$time =  time()-30*24*60*60;
        			$strWhere .= " and add_time > {$time} ";
        		} else if($add_time == 'three_week'){
        			$time = time()-90*24*60*60;
        			$strWhere .= " and add_time > {$time} ";
        		}
        	}
        }
        //分页
        $paginationCount = $this->tableObject->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/order/index/{$s}/$order_type/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 5;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->tableObject->gets('*', $strWhere, $paginationConfig['per_page'], $page);
        if ($item_list) {
            foreach ($item_list as $key => $order) {
                $order_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $order['id']));
                foreach ($order_detail_list as $k => $ls) {
                    $count = $this->Comment_model->rowCount(array('order_number' => $order['order_number'], 'product_id' => $ls['product_id']));
                    $exchange_count = $this->Exchange_model->rowCount(array('orders_detail_id' => $ls['id']));
                    if ($count > 0) {
                        $order_detail_list[$k]['comment_status'] = 1;
                    } else {
                        $order_detail_list[$k]['comment_status'] = 0;
                    }
                    if ($exchange_count > 0) {
                        $order_detail_list[$k]['exchange_status'] = 0;
                    } else {
                        $order_detail_list[$k]['exchange_status'] = 1;
                    }
                    $orderList[$key]['expired'] = 0;
                    if ($order['status'] == 3) {
                        $order_period = $this->Orders_process_model->get('add_time', "order_id = {$order['id']} and content like '%交易成功%'");
                        if ($order_period['add_time'] + 7 * 24 * 60 * 60 < time()) {
                            $orderList[$key]['expired'] = 1;
                        }
                    }

                }
                $item_list[$key]['order_detail_list'] = $order_detail_list;
            }
        }
        //统计
        $count_all = $this->tableObject->rowCount(array('user_id' =>$user_id, 'order_type'=>$order_type));
        $count_0 = $this->tableObject->rowCount(array('status' => 0, 'user_id' => $user_id, 'order_type'=>$order_type));
        $count_1 = $this->tableObject->rowCount(array('status' => 1, 'user_id' => $user_id, 'order_type'=>$order_type));
        $count_2 = $this->tableObject->rowCount(array('status' => 2, 'user_id' => $user_id, 'order_type'=>$order_type));
        $count_pj = $this->tableObject->rowCount(array('status' => 3, 'user_id' => $user_id, 'order_type'=>$order_type, 'is_comment_to_seller'=>0));

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '订单列表',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_list' => $item_list,
            'pagination' => $pagination,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'perPage' => $paginationConfig['per_page'],
            'location' => $location,
        	'status_arr' => $this->_status_arr,
            'select_status' => $s,
            'count_all' => $count_all,
            'count_0' =>   $count_0,
            'count_1' =>   $count_1,
            'count_2' =>   $count_2,
        	'count_pj'=>   $count_pj,
        	'keyword'=>    $keyword,
        	'add_time'=>   $add_time,
            'order_type' => $order_type,
            'order_type_arr' => $this->_order_type_arr,
        );
        $layout = array(
            'content' => $this->load->view('order/index', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //查看详情
    public function view($id = NULL) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        checkLogin();
        //判断是否登录
        if (!$id) {
            $data = array(
                'user_msg' => '你访问的页面不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $strWhere = array('user_id' => get_cookie('user_id'), 'id' => $id);
        $orderInfo = $this->tableObject->get('*', $strWhere);
        if (!$orderInfo) {
            $data = array(
                'user_msg' => '此订单信息不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $orderInfo['postage_way'] = '包邮';
        if ($orderInfo['postage_id']) {
            $postage_way = $this->Postage_way_model->get('title', array('id' => $orderInfo['postage_id']));
            $orderInfo['postage_way'] = $postage_way['title'];
        }
        $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $orderInfo['id']));
        $orders_process_list = $this->Orders_process_model->gets('*', array('order_id' => $orderInfo['id']));
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>我的交易</a> > <a href='index.php/order.html'>我的订单</a> > 订单详情";
        
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '订单详细',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'orderInfo' => $orderInfo,
            'location' => $location,
            'deliveryTime' => $this->_deliveryTime,
            'status_arr' => $this->_status_arr,
            'orders_detail_list'=>$orders_detail_list,
            'orders_process_list'=>$orders_process_list
        );
        $layout = array(
            'content' => $this->load->view('order/view', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //收货
    public function receiving() {
        checkLoginAjax();
        if ($_POST) {
    		$id = $this->input->post('id', TRUE);
    		if (!$id) {
    			printAjaxError('fail', "操作异常，刷新重试");
    		}
    		$item_info = $this->tableObject->get('*', array('id' => $id, 'user_id'=>get_cookie('user_id')));
    		if (!$item_info) {
    			printAjaxError('fail', "不存在此订单");
    		}
    		if ($item_info['status'] != 2) {
    			printAjaxError('fail', "此订单状态异常，确认收货失败");
    		}
//     		$exchange_info = $this->Exchange_model->get('*', array('orders_id'=>$id, 'user_id'=>$item_info['user_id']));
//     		if ($exchange_info) {
//     			if ($exchange_info['status'] >= 3) {
//     				printAjaxError('fail', "此订单退款申请成功，不能完成下面的操作");
//     			} else {
//     				if ($exchange_info['status'] != 1) {
//     					printAjaxError('fail', "此订单退款申请审核中，不能完成下面的操作");
//     				}
//     			}
//     		}
    		$userInfo = $this->User_model->getInfo('id, username, score_gold, score_silver', array('id' => $item_info['user_id']));
    		if (!$userInfo) {
    			printAjaxError('fail', "此订单异常，确认收货失败");
    		}
    		$fields = array(
    				'status' => 3
    		);
    		if ($this->tableObject->save($fields, array('id' => $id))) {
    			//操作记录
    			$fields = array(
    					'add_time' => time(),
    					'content' => "确认收货，交易成功",
    					'order_id' => $item_info['id'],
    					'current_status'=>$item_info['status'],
    					'change_status'=>3
    			);
    			$this->Orders_process_model->save($fields);
    			//消费者积分操作
    			//金象积分
    			if ($item_info['gold_score'] > 0) {
    				if (!$this->Score_model->rowCount(array('score_type'=>'gold', 'type' =>'orders_in', 'user_id' =>  $userInfo['id'], 'ret_id' =>   $item_info['id']))) {
    					$balance = $userInfo['score_gold'] + $item_info['gold_score'];
    					if ($this->User_model->save(array('score_gold' =>$balance), array('id' => $userInfo['id']))) {
    						$fields = array(
    								'cause' =>    "订单交易成功-{$item_info['order_number']}",
    								'score' =>    $item_info['gold_score'],
    								'balance' =>  $balance,
    								'score_type'=>'gold',
    								'type' =>     'orders_in',
    								'add_time' => time(),
    								'username' => $userInfo['username'],
    								'user_id' =>  $userInfo['id'],
    								'ret_id' =>   $item_info['id']
    						);
    						$this->Score_model->save($fields);
    					}
    				}
    			}
    			//银象积分
    			if ($item_info['silver_score'] > 0) {
    				if (!$this->Score_model->rowCount(array('score_type'=>'silver', 'type'=>'orders_in', 'user_id'=>$userInfo['id'], 'ret_id'=>$item_info['id']))) {
    					$balance = $userInfo['score_silver'] + $item_info['silver_score'];
    					if ($this->User_model->save(array('score_silver' =>$balance), array('id' => $userInfo['id']))) {
    						$fields = array(
    								'cause' =>    "订单交易成功-{$item_info['order_number']}",
    								'score' =>    $item_info['silver_score'],
    								'balance' =>  $balance,
    								'score_type'=>'silver',
    								'type' =>     'orders_in',
    								'add_time' => time(),
    								'username' => $userInfo['username'],
    								'user_id' =>  $userInfo['id'],
    								'ret_id' =>   $item_info['id']
    						);
    						$this->Score_model->save($fields);
    					}
    				}
    			}
    			/*********************分销-返积分*******************/
    			//一级提成
    			if ($item_info['divide_user_id_1'] > 0) {
    				$user_info_1 = $this->User_model->getInfo('id, username, score_gold, score_silver', array('id' => $item_info['divide_user_id_1']));
    				if ($user_info_1) {
    					if ($item_info['divide_user_score_gold_1'] > 0) {
    						if (!$this->Score_model->rowCount(array('score_type'=>'gold', 'type' =>'presenter_in', 'user_id' =>$user_info_1['id'], 'ret_id' =>$item_info['id']))) {
    							$balance = $user_info_1['score_gold'] + $item_info['divide_user_score_gold_1'];
    							if ($this->User_model->save(array('score_gold' =>$balance), array('id' => $user_info_1['id']))) {
    								$fields = array(
    										'cause' =>    "订单交易成功-订单{$item_info['order_number']}返提成",
    										'score' =>    $item_info['divide_user_score_gold_1'],
    										'balance' =>  $balance,
    										'score_type'=>'gold',
    										'type' =>     'presenter_in',
    										'add_time' => time(),
    										'username' => $user_info_1['username'],
    										'user_id' =>  $user_info_1['id'],
    										'ret_id' =>   $item_info['id'],
    										'from_user_id'=>$item_info['user_id']
    								);
    								$this->Score_model->save($fields);
    							}
    						}
    					}
    					if ($item_info['divide_user_score_silver_1'] > 0) {
    						if (!$this->Score_model->rowCount(array('score_type'=>'silver', 'type' =>'presenter_in', 'user_id' =>$user_info_1['id'], 'ret_id' =>$item_info['id']))) {
    							$balance = $user_info_1['score_silver'] + $item_info['divide_user_score_silver_1'];
    							if ($this->User_model->save(array('score_silver' =>$balance), array('id' => $user_info_1['id']))) {
    								$fields = array(
    										'cause' =>    "订单交易成功-订单{$item_info['order_number']}返提成",
    										'score' =>    $item_info['divide_user_score_silver_1'],
    										'balance' =>  $balance,
    										'score_type'=>'silver',
    										'type' =>     'presenter_in',
    										'add_time' => time(),
    										'username' => $user_info_1['username'],
    										'user_id' =>  $user_info_1['id'],
    										'ret_id' =>   $item_info['id'],
    										'from_user_id'=>$item_info['user_id']
    								);
    								$this->Score_model->save($fields);
    							}
    						}
    					}
    				}

    			}
    			//二级提成
    			if ($item_info['divide_user_id_2'] > 0) {
    				$user_info_2 = $this->User_model->getInfo('id, username, score_gold, score_silver', array('id' => $item_info['divide_user_id_2']));
    				if ($user_info_2) {
    					if ($item_info['divide_user_score_gold_2'] > 0) {
    						if (!$this->Score_model->rowCount(array('score_type'=>'gold', 'type' =>'presenter_in', 'user_id' =>$user_info_2['id'], 'ret_id' =>$item_info['id']))) {
    							$balance = $user_info_2['score_gold'] + $item_info['divide_user_score_gold_2'];
    							if ($this->User_model->save(array('score_gold' =>$balance), array('id' => $user_info_2['id']))) {
    								$fields = array(
    										'cause' =>    "订单交易成功-订单{$item_info['order_number']}返提成",
    										'score' =>    $item_info['divide_user_score_gold_2'],
    										'balance' =>  $balance,
    										'score_type'=>'gold',
    										'type' =>     'presenter_in',
    										'add_time' => time(),
    										'username' => $user_info_2['username'],
    										'user_id' =>  $user_info_2['id'],
    										'ret_id' =>   $item_info['id'],
    										'from_user_id'=>$item_info['user_id']
    								);
    								$this->Score_model->save($fields);
    							}
    						}
    					}
    					if ($item_info['divide_user_score_silver_2'] > 0) {
    						if (!$this->Score_model->rowCount(array('score_type'=>'silver', 'type' =>'presenter_in', 'user_id' =>$user_info_2['id'], 'ret_id' =>$item_info['id']))) {
    							$balance = $user_info_2['score_silver'] + $item_info['divide_user_score_silver_2'];
    							if ($this->User_model->save(array('score_silver' =>$balance), array('id' => $user_info_2['id']))) {
    								$fields = array(
    										'cause' =>    "订单交易成功-订单{$item_info['order_number']}返提成",
    										'score' =>    $item_info['divide_user_score_silver_2'],
    										'balance' =>  $balance,
    										'score_type'=>'silver',
    										'type' =>     'presenter_in',
    										'add_time' => time(),
    										'username' => $user_info_2['username'],
    										'user_id' =>  $user_info_2['id'],
    										'ret_id' =>   $item_info['id'],
    										'from_user_id'=>$item_info['user_id']
    								);
    								$this->Score_model->save($fields);
    							}
    						}
    					}
    				}
    			}
    			//减库存与加销售量
    			$orders_detail_list = $this->Orders_detail_model->gets('product_id, buy_number', array('order_id' => $id));
    			if ($orders_detail_list) {
    				foreach ($orders_detail_list as $key=>$value) {
    					//商品库存与销售量
    					$product_info = $this->Product_model->get('sales', array('id'=>$value['product_id']));
    					if ($product_info) {
    						$fields = array(
    								'sales'=>$product_info['sales'] + $value['buy_number']
    						);
    						$this->Product_model->save($fields, array('id'=>$value['product_id']));
    					}
    				}
    			}
    			printAjaxSuccess('success', '确认收货成功');
    		} else {
    			printAjaxError('fail', "确认收货失败");
    		}
    	}
    }

    public function close_order() {
       //判断是否登录
        checkLoginAjax();
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            $cancel_cause = $this->input->post('cancel_cause', true);
            if (!$id) {
                printAjaxError('fail', '异常操作');
            }
            if (!$cancel_cause) {
            	printAjaxError('fail', '请选择关闭订单理由');
            }
            $order_info = $this->tableObject->get('id, user_id, order_number, status, pay_mode, deductible_score, deductible_score_gold, deductible_score_silver', array('id' => $id, 'user_id' => get_cookie('user_id')));
            if (!$order_info) {
                printAjaxError('fail', '此订单不存在');
            }
            if ($order_info['status'] > 0) {
                printAjaxError('fail', '此状态不可取消订单');
            }
			$user_info = $this->User_model->getInfo('*', array('id' => $order_info['user_id']));
            if (!$user_info) {
            	printAjaxError('fail', "账号信息异常，请重新登录，再试");
            }

            //添加订单信息
            $fields = array(
                'status' => 4,
                'cancel_cause' => $cancel_cause,
            );
            $ret = $this->tableObject->save($fields, array('id' => $id, 'user_id' => get_cookie('user_id')));
            if ($ret) {
            	$fields = array(
            			'current_status'=>$order_info['status'],
            			'change_status'=>4,
            			'add_time' => time(),
            			'content' => '买家取消订单-原因：'.$cancel_cause,
            			'order_id' => $id);
                $this->Orders_process_model->save($fields);
				//判断是不是积分换购
				if ($order_info['pay_mode'] > 0) {
					//退还金象积分部分
					if ($order_info['deductible_score_gold'] > 0) {
						if (!$this->Score_model->rowCount(array('score_type'=>'gold', 'user_id' => $user_info['id'], 'ret_id' => $order_info['id'], 'type' => 'orders_buy_in'))) {
                			$balance = $user_info['score_gold'] + $order_info['deductible_score_gold'];
                			if ($this->User_model->save(array('score_gold'=>$balance), array('id' => $user_info['id']))) {
                				$sFields = array(
                						'score_type'=>'gold',
                						'cause' => "买家取消订单，退还积分-[订单号：{$order_info['order_number']}]",
                						'score' => $order_info['deductible_score_gold'],
                						'balance' => $balance,
                						'type' => 'orders_buy_in',
                						'add_time' => time(),
                						'username' => $user_info['username'],
                						'user_id' => $user_info['id'],
                						'ret_id' => $order_info['id']
                				);
                				$this->Score_model->save($sFields);
                			}
                		}
					}
					//退还银象积分部分
					if ($order_info['deductible_score_silver'] > 0) {
						if (!$this->Score_model->rowCount(array('score_type'=>'silver', 'user_id' => $user_info['id'], 'ret_id' => $order_info['id'], 'type' => 'orders_buy_in'))) {
                			$balance = $user_info['score_silver'] + $order_info['deductible_score_silver'];
                			if ($this->User_model->save(array('score_silver'=>$balance), array('id' => $user_info['id']))) {
                				$sFields = array(
                						'score_type'=>'silver',
                						'cause' => "买家取消订单，退还积分-[订单号：{$order_info['order_number']}]",
                						'score' => $order_info['deductible_score_silver'],
                						'balance' => $balance,
                						'type' => 'orders_buy_in',
                						'add_time' => time(),
                						'username' => $user_info['username'],
                						'user_id' => $user_info['id'],
                						'ret_id' => $order_info['id']
                				);
                				$this->Score_model->save($sFields);
                			}
                		}
					}
				}
				//加库存-下单减库存
				$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
	            if ($systemInfo['stock_reduce_type'] == 0) {
		            $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $id));
		            if ($orders_detail_list) {
		            	foreach ($orders_detail_list as $item) {
		            		if ($item['color_size_open'] == 1) {
		            			$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
		            			if ($product_stock_info) {
		            				$stock = $product_stock_info['stock'] + $item['buy_number'];
		            				$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
		            			}
		            		} else {
		            			$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
		            			if ($product_info) {
		            				$stock = $product_info['stock'] + $item['buy_number'];
		            				$this->Product_model->save(array('stock' =>$stock), array('id' => $item['product_id']));
		            			}
		            		}
		            	}
		            }
	            }
                printAjaxSuccess('success', '交易关闭成功！');
            } else {
                printAjaxError('fail', '交易关闭失败');
            }
        }
    }

    public function buy_again() {
    	checkLoginAjax();
    	if ($_POST) {
    		$user_id = get_cookie('user_id');
    		$order_id = $this->input->post('order_id', true);
    		if (!$order_id) {
    			printAjaxError('fail', '参数不能为空');
    		}
    		$orders_info = $this->tableObject->get('status', array('id' => $order_id, 'user_id'=>$user_id));
    		if (!$orders_info) {
    			printAjaxError('fail', '此订单信息不存在');
    		}
    		$orders_detail_list = $this->Orders_detail_model->gets2(array('orders_detail.order_id' => $order_id));
    		if (!$orders_detail_list) {
    			printAjaxError('fail', '此订单信息不存在');
    		}
    		if ($orders_detail_list) {
    			foreach ($orders_detail_list as $key=>$value) {
    				$strWhere = array(
    						'user_id'=>    $user_id,
    						'product_id'=> $value['product_id'],
    						'size_id'=>    $value['size_id'],
    						'color_id'=>   $value['color_id']
    				);
    				$cart_info = $this->Cart_model->get('buy_number,id', $strWhere);
    				if ($cart_info) {
    					$fields = array(
    							'buy_number' => $cart_info['buy_number']+1
    					);
    					$this->Cart_model->save($fields, array('id'=>$cart_info['id'], 'user_id'=>$user_id));
    				} else {
    					$fields = array(
    							'user_id' =>    $user_id,
    							'product_id' => $value['product_id'],
    							'size_name' =>  $value['size_name'],
    							'size_id' =>    $value['size_id'],
    							'color_name' => $value['color_name'],
    							'color_id' =>   $value['color_id'],
    							'buy_number' => $value['buy_number'],
    							'sell_price' => $value['sell_price']
    					);
    					$this->Cart_model->save($fields);
    				}
    			}
    		}
    		$cart_count = $this->Cart_model->rowSum(array('user_id'=>$user_id));
    		printAjaxData(array('cart_count'=>$cart_count));
    	}
    }

    //普通下单
    public function add() {
        //判断是否登录
        checkLoginAjax();
        if ($_POST) {
            $systemInfo = $this->System_model->get('*', array('id' => 1));
            $user_id = get_cookie('user_id');
            $user_address_id = $this->input->post('user_address_id');
            $use_score = $this->input->post('use_score', true);
            $cart_ids = $this->input->post('cart_ids', true);

            if (!$user_address_id) {
            	printAjaxError('fail', "请选择收货地址");
            }
            if (!$cart_ids) {
            	printAjaxError('fail', "请选择结算商品");
            }
            //收货地址
            $user_address_info = $this->User_address_model->get('*', array('id' => $user_address_id, 'user_id'=>$user_id));
            if (!$user_address_info) {
            	printAjaxError('fail', '收货地址不存在，下单失败');
            }
            $user_info = $this->User_model->getInfo('*', array('id' => $user_id));
            if (!$user_info) {
            	printAjaxError('fail', "您的账号不存在或被管理员删除");
            }

            $pay_way_str = '';//包邮描述
            $total = 0.00;//订单总金额
            $discount_total = 0;//共优惠
            $postage_price = 0;//快递费用
            $product_total = 0;//商品总金额
            $product_number = 0;//商品数量
            $postage_way_ids = '';//商品的快递模板
            $area_name = '';//默认配送地区
            $silver_give_score = 0;//送积分
            $gold_give_score = 0;//送积分
            $postage_template_id = 0;
            $deliveryTime = 1;
            //分销
            $user_info_1 = NULL;
            $user_info_2 = NULL;
            $divide_user_id_1 = 0;
            $divide_user_id_2 = 0;
            $divide_user_score_gold_1 = 0;
            $divide_user_score_silver_1 = 0;
            $divide_user_score_gold_2 = 0;
            $divide_user_score_silver_2 = 0;
            //积分换购
            $pay_mode = 0;//支付方式：0=用钱购买；1=积分换购；
            $use_deductible_score_gold = 0;//需付多少金象积分
            $use_deductible_score_silver = 0;//需付多少银象积分
            $deductible_score_gold = 0;//用了多少金象积分
            $deductible_score_silver = 0;//用了多少银象积分

            if ($use_score) {
            	$pay_mode = 1;
            } else {
            	/********************分销**********************/
            	//一级
            	if ($user_info['presenter_id'] > 0) {
            		$user_info_1 = $this->User_model->getInfo('user_type, id, username, nickname, presenter_id', array('id' => $user_info['presenter_id']));
            		if ($user_info_1) {
            			$divide_user_id_1 = $user_info_1['id'];
            			//二级
            			if ($user_info_1['presenter_id'] > 0) {
            				$user_info_2 = $this->User_model->getInfo('user_type, id, username, nickname', array('id' => $user_info_1['presenter_id']));
            				if ($user_info_2) {
            					$divide_user_id_2 = $user_info_2['id'];
            				}
            			}
            		}
            	}
            }
            $strWhere = "cart.user_id = {$user_id} and cart.id in ($cart_ids)";
            $cartList = $this->Cart_model->gets($strWhere);
            if (!$cartList) {
                printAjaxError('fail', '请选择结算商品');
            }
            foreach ($cartList as $value) {
            	if ($value['color_size_open']) {
            		//有规格的商品
            		$product_stock_info = $this->Product_model->getProductStock($value['product_id'], $value['color_id'], $value['size_id']);
            		if (!$product_stock_info) {
            			printAjaxError('fail', '没有此规格的商品，请删除');
            		}
            		if ($value['buy_number'] > $product_stock_info['stock']) {
            			printAjaxError('fail', "商品：{$value['title']}，{$value['product_size_name']}：{$value['size_name']}，{$value['product_color_name']}：{$value['size_name']}库存不足，请手动删除或购买数量调整为{$product_stock_info['stock']}");
            		}
            	} else {
            		if ($value['buy_number'] > $value['stock']) {
            			printAjaxError('fail', "商品:{$value['title']}。库存不足，请手动删除或购买数量调整为{$value['stock']}");
            		}
            	}
            	//一级
            	if ($user_info_1) {
            		//商家
                    if ($user_info_1['user_type'] == 1) {
                    	//银象积分-A类商品
                    	if ($value['product_type'] == 'a') {
                    		$divide_user_score_silver_1 += $value['divide_seller_score'] * $value['buy_number'];
                    	}
                    	//金象积分-B、C类商品
                    	else {
                    		$divide_user_score_gold_1 += $value['divide_seller_score'] * $value['buy_number'];
                    	}
                    }
                    //会员
                    else {
                    	//银象积分-A类商品
                    	if ($value['product_type'] == 'a') {
                    		$divide_user_score_silver_1 += $value['divide_user_score'] * $value['buy_number'];
                    	}
                    	//金象积分-B、C类商品
                    	else {
                    		$divide_user_score_gold_1 += $value['divide_user_score'] * $value['buy_number'];
                    	}
                    }
            	}
            	//二级
            	if ($user_info_2) {
            		//商家
            		if ($user_info_1['user_type'] == 1) {
            			//银象积分-A类商品
            			if ($value['product_type'] == 'a') {
            				$divide_user_score_silver_2 += $value['divide_seller_score_sub'] * $value['buy_number'];
            			}
            			//金象积分-B、C类商品
            			else {
            				$divide_user_score_gold_2 += $value['divide_seller_score_sub'] * $value['buy_number'];
            			}
            		}
            		//会员
            		else {
            			//银象积分-A类商品
            			if ($value['product_type'] == 'a') {
            				$divide_user_score_silver_2 += $value['divide_user_score_sub'] * $value['buy_number'];
            			}
            			//金象积分-B、C类商品
            			else {
            				$divide_user_score_gold_2 += $value['divide_user_score_sub'] * $value['buy_number'];
            			}
            		}
            	}
            	//银象积分-A类商品
            	if ($value['product_type'] == 'a') {
            		$silver_give_score += $value['give_score'] * $value['buy_number'];
            	}
            	//金象积分-B、C类商品
            	else {
            		$gold_give_score += $value['give_score'] * $value['buy_number'];
            	}
            	$postage_way_ids .= $value['postage_way_id'].',';
            	$product_number += $value['buy_number'];
        		$product_total += $value['sell_price'] * $value['buy_number'];
        		//金象积分-A类商品-需付多少金象积分
        		if ($value['product_type'] == 'a') {
        			$use_deductible_score_gold += $value['consume_score'] * $value['buy_number'];
        		}
        		//银象积分-B、C类商品-需付多少银象积分
        		else {
        			$use_deductible_score_silver += $value['consume_score'] * $value['buy_number'];
        		}
            }
            if ($postage_way_ids) {
            	$postage_way_ids = substr($postage_way_ids, 0, -1);
            }
            //积分换购
            if ($use_score) {
            	//用现金购买才送积分，积分换购不送积分
            	$silver_give_score = 0;
            	$gold_give_score = 0;
            	$product_total = 0;
            	//A,B,C类商品
            	if ($use_deductible_score_gold > 0 && $use_deductible_score_silver > 0) {
            		if ($use_deductible_score_gold > $user_info['score_gold']) {
            			printAjaxError('fail', '金象积分不足，换购失败');
            		}
            		if ($use_deductible_score_silver > $user_info['score_gold'] - $use_deductible_score_gold + $user_info['score_silver']) {
            			printAjaxError('fail', '总积分不足，换购失败');
            		}
            		if ($user_info['score_gold'] >= $use_deductible_score_gold) {
            			$deductible_score_gold = $use_deductible_score_gold;
            		}
            		if ($user_info['score_silver'] >= $use_deductible_score_silver) {
            			$deductible_score_silver = $use_deductible_score_silver;
            		} else {
            			$deductible_score_silver = $user_info['score_silver'];
            			$deductible_score_gold = $deductible_score_gold + $use_deductible_score_silver - $user_info['score_silver'];
            		}
            	}
            	//B,C类商品
            	else if ($use_deductible_score_gold > 0 && $use_deductible_score_silver == 0) {
                    if ($use_deductible_score_gold > $user_info['score_gold']) {
                    	printAjaxError('fail', '金象积分不足，换购失败');
                    }
                    $deductible_score_gold = $use_deductible_score_gold;
                    $deductible_score_silver = 0;
            	}
            	//A类商品
            	else if ($use_deductible_score_gold == 0 && $use_deductible_score_silver > 0) {
            		if ($use_deductible_score_silver > $user_info['score_gold'] + $user_info['score_silver']) {
            			printAjaxError('fail', '总积分不足，换购失败');
            		}
            		if ($use_deductible_score_silver > $user_info['score_silver']) {
            			$deductible_score_gold = $use_deductible_score_silver - $user_info['score_silver'];
            			$deductible_score_silver = $user_info['score_silver'];
            		} else {
            			$deductible_score_gold = 0;
            			$deductible_score_silver = $use_deductible_score_silver;
            		}
            	}
            }
            //现金购买
            else {
            	$use_deductible_score_gold = 0;
            	$use_deductible_score_silver = 0;
            	$deductible_score_gold = 0;
            	$deductible_score_silver = 0;
            }
            $area_info = $this->Area_model->get('name', array('id' => $user_address_info['province_id']));
            if ($area_info) {
            	$area_name = $area_info['name'];
            }
            $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
            if ($free_postage_setting['is_free'] == 1) {
            	$pay_way_str = '全国包邮';
            	$postage_template_id = 0;
            	$postage_price = '0.00';
            } else {
            	if (($product_number >= $free_postage_setting['product_number'] && $free_postage_setting['open_number'] == 1) || ($product_total >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price'] == 1)) {
            		$postage_template_id = 0;
            		$postage_price = '0.00';
            		$pay_way_str = '包邮（已满'.$free_postage_setting['product_number'].'件或已满'.$free_postage_setting['free_postage_price'].'元）';
            	} else {
            		//判断用哪个快递－谁贵给谁的
            		$postage_way_list = $this->Postage_way_model->gets('*', "id in ({$postage_way_ids})");
            		if ($postage_way_list) {
            			foreach ($postage_way_list as $key=>$value) {
            				$tmp_postage_price = $this->advdbclass->get_postage_price($value['id'], $area_name, $product_number);
            				if ($tmp_postage_price > $postage_price) {
            					$postage_price = $tmp_postage_price;
            					$postage_template_id = $value['id'];
            					$pay_way_str = $value['title'];
            				}
            			}
            		}
            	}
            }
            $total = $postage_price + $product_total;
            $orderNumber = $this->advdbclass->get_unique_orders_number();
            //添加订单信息
            $fields = array(
                'user_id' => $user_id,
                'order_number' => $orderNumber,
                'payment_id' => 0,
                'payment_title' => '',
                'payment_price' => 0,
                'postage_id' => $postage_template_id,
                'postage_title' => $pay_way_str,
                'postage_price' => $postage_price,
            	'discount_total'=>0,
            	'product_total'=>$product_total,
            	'total' => $total,
            	'pay_mode'=>$pay_mode,
            	'deductible_score'=>$use_deductible_score_gold+$use_deductible_score_silver,
            	'use_deductible_score_gold'=>$use_deductible_score_gold,
            	'use_deductible_score_silver'=>$use_deductible_score_silver,
            	'deductible_score_gold'=>$deductible_score_gold,
            	'deductible_score_silver'=>$deductible_score_silver,
                'status' => $total > 0?0:1,
                'add_time' => time(),
                'buyer_name' =>  $user_address_info['buyer_name'],
                'province_id' => $user_address_info['province_id'],
                'city_id' =>     $user_address_info['city_id'],
                'area_id' =>     $user_address_info['area_id'],
                'txt_address' => $user_address_info['txt_address'],
                'address' =>     $user_address_info['address'],
                'zip' =>         $user_address_info['zip'],
                'phone' =>       $user_address_info['phone'],
                'mobile' =>      $user_address_info['mobile'],
                'delivery_time' => $deliveryTime,
                'remark' => '',
                'gold_score' =>   $gold_give_score,
            	'silver_score' => $silver_give_score,
                'order_type' => 0,
            	'divide_user_id_1'=>$divide_user_id_1,
            	'divide_user_id_2'=>$divide_user_id_2,
            	'divide_user_score_gold_1'=>$divide_user_score_gold_1,
            	'divide_user_score_silver_1'=>$divide_user_score_silver_1,
            	'divide_user_score_gold_2'=>$divide_user_score_gold_2,
            	'divide_user_score_silver_2'=>$divide_user_score_silver_2
            );
            //添加订单
            $ret = $this->tableObject->save($fields);
            if ($ret) {
                /***************************添加订单详细信息*********************** */
                $succesCount = 0;
                if ($cartList) {
                    foreach ($cartList as $cart) {
                        $detailFields = array(
                            'order_id' => $ret,
                            'product_id' => $cart['product_id'],
                            'product_num' => $cart['product_num'],
                            'product_title' => $cart['title'],
                            'buy_number' => $cart['buy_number'],
                            'buy_price' => $cart['sell_price'],
                        	'old_price' => $cart['sell_price'],
                            'size_name' => $cart['size_name'],
                            'size_id' => $cart['size_id'],
                            'color_name' => $cart['color_name'],
                            'color_id' => $cart['color_id'],
                            'path' => $cart['path'],
                        	'product_type' => $cart['product_type'],
                        	'consume_score' => $cart['consume_score'],
                        	'divide_user_score' => $cart['divide_user_score'],
                        	'divide_user_score_sub' => $cart['divide_user_score_sub'],
                        	'divide_seller_score' => $cart['divide_seller_score'],
                        	'divide_seller_score_sub' => $cart['divide_seller_score_sub'],
                        	'color_size_open' => $cart['color_size_open'],
                        	'product_color_name' => $cart['product_color_name'],
                        	'product_size_name' => $cart['product_size_name']
                        );
                        if ($this->Orders_detail_model->save($detailFields)) {
                            $succesCount++;
                        }
                    }
                }
                if (($succesCount != count($cartList)) || count($cartList) == 0) {
                    //删除订单详细里的数据
                    $this->Orders_detail_model->delete(array('order_id' => $ret));
                    //删除已经添加进去的数据，保持数据统一性
                    $this->tableObject->delete(array('id' => $ret, 'user_id' => $user_id));
                    printAjaxError('fail', '订单提交失败');
                } else {
                    //删除购物车数据
                    $this->Cart_model->delete($strWhere);
                    //订单跟踪记录
                    $msg = $total > 0?'':'-完成支付';
                    $ordersprocessFields = array(
                        'add_time' => time(),
                        'content' => "订单创建成功".$msg,
                        'order_id' => $ret,
                    	'current_status'=>$total > 0?'0':'1',
                    	'change_status'=>$total > 0?'0':'1'
                    );
                    $this->Orders_process_model->save($ordersprocessFields);
                    //积分换购
                    if ($use_score) {
                    	if ($deductible_score_gold > 0) {
                    		if (!$this->Score_model->rowCount(array('score_type'=>'gold', 'user_id' => $user_info['id'], 'ret_id' => $ret, 'type' => 'orders_buy_out'))) {
                    			$balance = $user_info['score_gold'] - $deductible_score_gold;
                    			if ($this->User_model->save(array('score_gold'=>$balance), array('id' => $user_info['id']))) {
                    				$sFields = array(
                    						'score_type'=>'gold',
                    						'cause' => "积分换购-[订单号：{$orderNumber}]",
                    						'score' => -$deductible_score_gold,
                    						'balance' => $balance,
                    						'type' => 'orders_buy_out',
                    						'add_time' => time(),
                    						'username' => $user_info['username'],
                    						'user_id' => $user_info['id'],
                    						'ret_id' => $ret
                    				);
                    				$this->Score_model->save($sFields);
                    			}
                    		}
                    	}
                    	if ($deductible_score_silver > 0) {
                    		if (!$this->Score_model->rowCount(array('score_type'=>'silver', 'user_id' => $user_info['id'], 'ret_id' => $ret, 'type' => 'orders_buy_out'))) {
                    			$balance = $user_info['score_silver'] - $deductible_score_silver;
                    			if ($this->User_model->save(array('score_silver'=>$balance), array('id' => $user_info['id']))) {
                    				$sFields = array(
                    						'score_type'=>'silver',
                    						'cause' => "积分换购-[订单号：{$orderNumber}]",
                    						'score' => -$deductible_score_silver,
                    						'balance' => $balance,
                    						'type' => 'orders_buy_out',
                    						'add_time' => time(),
                    						'username' => $user_info['username'],
                    						'user_id' => $user_info['id'],
                    						'ret_id' => $ret
                    				);
                    				$this->Score_model->save($sFields);
                    			}
                    		}
                    	}
                    }
                    //下单减库存
                    if ($systemInfo['stock_reduce_type'] == 0) {
			            $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id'=>$ret));
			            if ($orders_detail_list) {
			            	foreach ($orders_detail_list as $item) {
			            		if ($item['color_size_open'] == 1) {
			            			$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
			            			if ($product_stock_info) {
			            				$stock = $product_stock_info['stock'] - $item['buy_number'];
			            				$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
			            			}
			            		} else {
			            			$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
			            			if ($product_info) {
			            				$stock = $product_info['stock'] - $item['buy_number'];
			            				$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
			            			}
			            		}
			            	}
			            }
                    }
                    if ($total > 0) {
                    	if($user_info['push_cid']){
                    		$this->_send_push($user_info['push_cid'],"订单{$orderNumber}未付款哦~~,亲赶紧去支付吧！");
                    	}
                    	//发消息
                    	$fields = array(
                    			'message_type' => 'order',
                    			'to_user_id' => $user_id,
                    			'from_user_id' => 0,
                    			'content' => "订单{$orderNumber}未付款哦~~,亲赶紧去支付吧！",
                    			'map_id'=>$ret,
                    			'add_time' => time()
                    	);
                    	$this->Message_model->save($fields);

                    	printAjaxSuccess(base_url() . "index.php/order/pay/{$ret}.html", '订单提交成功');
                    } else {
                    	//付款减库存
                    	if ($systemInfo['stock_reduce_type'] == 1) {
	                    	$orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id'=>$ret));
				            if ($orders_detail_list) {
				            	foreach ($orders_detail_list as $item) {
				            		if ($item['color_size_open'] == 1) {
				            			$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
				            			if ($product_stock_info) {
				            				$stock = $product_stock_info['stock'] - $item['buy_number'];
				            				$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
				            			}
				            		} else {
				            			$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
				            			if ($product_info) {
				            				$stock = $product_info['stock'] - $item['buy_number'];
				            				$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
				            			}
				            		}
				            	}
				            }
                        }
                    	printAjaxSuccess(base_url() . "index.php/order/pay_result/{$orderNumber}", '恭喜您订单提交成功并支付成功!');
                    }
                }
            } else {
                printAjaxError('fail', '订单提交失败');
            }
        }
    }

    //拼团砍价活动订单-下单
    public function ptkj_pay() {
        checkLogin();
        if ($_POST) {
            $distributor_info = get_distributor_info(get_cookie('user_id'));
            $systemInfo = $this->System_model->get('presenter_is_open', array('id' => 1));
            $divide_user_id_1 = 0;
            $divide_user_id_2 = 0;
            $divide_type = '';
            //判断下单用户是否存在
            $userInfo = $this->User_model->get('*', array('user.id' => get_cookie('user_id')));
            if (!$userInfo) {
                printAjaxError('fail', '此用户不存在，订单提交失败');
            }
            //一级分销商
            if ($userInfo['distributor'] == 1 || $userInfo['school_distributor'] == 1 || $userInfo['net_distributor'] == 1) {
            	if ($userInfo['distributor']) {
            		$divide_type = 'distributor';
            	} else if ($userInfo['school_distributor']) {
            		$divide_type = 'school_distributor';
            	} else if ($userInfo['net_distributor']) {
            		$divide_type = 'net_distributor';
            	}
            	//只有正常身份才有提成拿－被禁一级不能拿
            	if ($userInfo['distributor_status'] == 1) {
            		//进货不做提成算，而是直接优惠掉
            		if ($userInfo['distributor'] != 1) {
            			$divide_user_id_1 = $userInfo['id'];
            		}
            	}
            }
            //二级分销商
            else if ($userInfo['distributor'] == 2 || $userInfo['school_distributor'] == 2 || $userInfo['net_distributor'] == 2) {
            	if ($userInfo['distributor']) {
            		$divide_type = 'distributor';
            	} else if ($userInfo['school_distributor']) {
            		$divide_type = 'school_distributor';
            	} else if ($userInfo['net_distributor']) {
            		$divide_type = 'net_distributor';
            	}
                //只有正常身份才有提成拿－被禁，自己没有提成
                if ($userInfo['distributor_status'] == 1) {
                	//进货不做提成算，而是直接优惠掉
                	if ($userInfo['distributor'] != 2) {
                	    $divide_user_id_2 = $userInfo['id'];
                	}
                    //二级分销商正常有提成拿
                	$parent_user_info = $this->User_model->getInfo('id, distributor_status', array('id' => $userInfo['presenter_id']));
                	if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
                		$divide_user_id_1 = $userInfo['presenter_id'];
                	}
                } else {
                	//二级分销商禁用时有提成拿
                	if ($userInfo['distributor_status'] == 3) {
                		$parent_user_info = $this->User_model->getInfo('id, distributor_status', array('id' => $userInfo['presenter_id']));
                		if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
                			$divide_user_id_1 = $userInfo['presenter_id'];
                		}
                	}
                }
            } else {
                //消费者
                if (!$userInfo['distributor'] && !$userInfo['school_distributor'] && !$userInfo['net_distributor']) {
                	//根据二级分销商，查一级分销商-被禁分销商没有提成拿
                	$parent_user_info = $this->User_model->getInfo('id, distributor,school_distributor,net_distributor, presenter_id, distributor_status', array('id' => $userInfo['presenter_id']));
                	if ($parent_user_info) {
                		if ($parent_user_info['distributor']) {
                			$divide_type = 'distributor';
                		} else if ($parent_user_info['school_distributor']) {
                			$divide_type = 'school_distributor';
                		} else if ($parent_user_info['net_distributor']) {
                			$divide_type = 'net_distributor';
                		}
                	}
                	if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
                		$divide_user_id_2 = $parent_user_info['id'];
                	}
                	if ($parent_user_info) {
                		$parent_user_info = $this->User_model->getInfo('id, presenter_id, distributor_status', array('id' => $parent_user_info['presenter_id']));
                		if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
                			$divide_user_id_1 = $parent_user_info['id'];
                		}
                	}
                }
            }
            $address_id = $this->input->post('address_id', true);
            $postage_template_id = 0;//$this->input->post('postage_template_id', true);
            $ptkj_record_id = $this->input->post('ptkj_record_id', true);
            $ptkj_record = $this->Ptkj_record_model->get(array('ptkj_record.id' => $ptkj_record_id, 'ptkj_record.user_id' => get_cookie('user_id')));
            $postage_way = $this->Postage_way_model->get('*', array('id' => $postage_template_id));
            if (empty($ptkj_record)) {
                printAjaxError('fail', '无拼团活动');
            }
            if (time() > $ptkj_record['end_time']) {
                printAjaxError('fail', '此拼团活动已过期！');
            }
            if (!empty($ptkj_record['order_id'])) {
                printAjaxError('fail', '您已经下单，无需重复下单');
            }
            if (empty($postage_way)) {
                $postage_way = $this->Postage_way_model->get('*', array('display' => 1));
                $postage_template_id = $postage_way['id'];
            }
            $tmp_product_info = $this->Product_model->get('postage_way_id,divide_total_ptkj,give_score,divide_store_price_ptkj,divide_school_total_ptkj,divide_school_sub_price_ptkj,divide_net_total_ptkj,divide_net_sub_price_ptkj', array('id' => $ptkj_record['product_id']));
            if (!$tmp_product_info) {
                printAjaxError('fail', '活动产品异常，下单失败');
            }
            //判断库存
            $stock_info = $this->Product_model->getProductStock($ptkj_record['product_id'], $ptkj_record['color_id'], $ptkj_record['size_id']);
            if ($ptkj_record['buy_number'] > $stock_info['stock']) {
                printAjaxError('fail', '对不起，您购买的此尺码及颜色的商品库存不足');
            }
            $UserAddressInfo = $this->User_address_model->get('*', array('user_id' => get_cookie('user_id'), 'id' => $address_id));
            if (!$UserAddressInfo) {
                printAjaxError('fail', '请选择收货地址！');
            }
            $buyerName = $UserAddressInfo['buyer_name'];
            $province_id = $UserAddressInfo['province_id'];
            $city_id = $UserAddressInfo['city_id'];
            $area_id = $UserAddressInfo['area_id'];
            $address = $UserAddressInfo['address'];
            $zip = $UserAddressInfo['zip'];
            $phone = $UserAddressInfo['phone'];
            $mobile = $UserAddressInfo['mobile'];
            $txt_address_str = $UserAddressInfo['txt_address'];
            //送积分
            $orderScore = 0;
            //支付率费用
            $paymentPrice = 0;
            //快递费
            $area_info = $this->Area_model->get('name', array('id' => $province_id));
            if (!$area_info) {
            	printAjaxError('fail', '收货人信息不存在，下单失败');
            }
            $area_name = $area_info['name'];
//             $province = $this->Area_model->get('name', array('id' => $province_id));
//             $postagePrice = $this->advdbclass->_getPostagewayPrice($postage_template_id, $province['name'], $ptkj_record['buy_number']);
//             $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
            //分成
            $divide_total = 0;
            $divide_store_price = 0;
            $divide_school_total = 0;
            $divide_school_sub_price = 0;
            $divide_net_total = 0;
            $divide_net_sub_price = 0;
            //原价
            $total = $ptkj_record['high_price'];
            $pintuan_rule = $this->Pintuan_model->gets(array('ptkj_id' => $ptkj_record['ptkj_id']));
            //拼团后的价格
            foreach ($pintuan_rule as $ls) {
                if ($ptkj_record['pintuan_people'] >= $ls['low'] && $ptkj_record['pintuan_people'] <= $ls['high']) {
                    $total = $ls['money'];
                }
            }
            //砍掉的金额
            $tmp_arr = $this->Chop_record_model->get('sum(chop_price) as sum', "chop_user_id is not null and ptkj_record_id = $ptkj_record_id and user_id = " . get_cookie('user_id'));
            $choped_price = $tmp_arr['sum'] ? $tmp_arr['sum'] : 0;
            $buy_price = $total - $choped_price;
            //包邮设置开启
            $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
            //是否全国包邮
            if($free_postage_setting['is_free_ac'] == 1){
            	$postagePrice = 0;
            	$postage_template_id = 0;
            } else {
            	if ((1 >= $free_postage_setting['product_number'] && $free_postage_setting['open_number_ac']==1) || ($buy_price >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price_ac']==1)) {
            		$postagePrice = 0;
            		$postage_template_id = 0;
            	} else {
            		//判断用哪个快递－谁贵给谁的
            		$postage_template_id = $tmp_product_info['postage_way_id'];
            		$postagePrice = $this->advdbclass->get_postage_price($tmp_product_info['postage_way_id'], $area_name, 1);
            	}
            }
            $discount = '0.00';
            //分销商购买
            if ($distributor_info[0]) {
                //城市合伙人
                if ($distributor_info[1] == 1) {
                    //拼团砍价购买
                    $discount = $tmp_product_info['divide_total_ptkj'];
                }
                //店级合伙人
                else if ($distributor_info[1] == 2) {
                    //拼团砍价购买
                    $discount = $tmp_product_info['divide_store_price_ptkj'];
                }
            }
            $old_price = $buy_price;
            $buy_price = $buy_price-$discount;
            //最终价格
            $total = $buy_price * $ptkj_record['buy_number'] + $postagePrice;
            $discount_total = $discount * $ptkj_record['buy_number'];
            $total = number_format($total, 2, '.', '');
            $orderNumber = $this->advdbclass->get_unique_orders_number();
            //只有被推荐的顾客的购买才产生分成，城市合伙人、店级合伙人的购买不产生分成
            if ($systemInfo['presenter_is_open']) {
                //线下分成总金额
                $divide_total = $tmp_product_info['divide_total_ptkj'] * $ptkj_record['buy_number'];
                //店级合伙人分成金额
                $divide_store_price = $tmp_product_info['divide_store_price_ptkj'] * $ptkj_record['buy_number'];
                //校园分成总金额
                $divide_school_total = $tmp_product_info['divide_school_total_ptkj'] * $ptkj_record['buy_number'];
                //校园二级分销商分成金额
                $divide_school_sub_price = $tmp_product_info['divide_school_sub_price_ptkj'] * $ptkj_record['buy_number'];
                //网络分成总金额
                $divide_net_total = $tmp_product_info['divide_net_total_ptkj'] * $ptkj_record['buy_number'];
                //网络二级分销商分成金额
                $divide_net_sub_price = $tmp_product_info['divide_net_sub_price_ptkj'] * $ptkj_record['buy_number'];
            }
            $orderScore = $tmp_product_info['give_score'] * $ptkj_record['buy_number'];
            //添加订单信息
            $fields = array(
                'user_id' => get_cookie('user_id'),
                'order_number' => $orderNumber,
                'payment_id' => 0,
                'payment_title' => '',
                'payment_price' => $paymentPrice,
                'postage_id' => 0,
                'postage_title' => '',
                'postage_price' => $postagePrice,
                'total' => $total,
            	'discount_total'=>$discount_total,
                'status' => 0,
                'add_time' => time(),
                'buyer_name' => $buyerName,
                'province_id' => $province_id,
                'city_id' => $city_id,
                'area_id' => $area_id,
                'txt_address' => $txt_address_str,
                'address' => $address,
                'zip' => $zip,
                'phone' => $phone,
                'mobile' => $mobile,
                'delivery_time' => 1,
                'remark' => '',
                'invoice' => '',
                'score' => $orderScore,
                'order_type' => 1,
                'divide_total' =>           $divide_type == 'distributor'?$divide_total:0,
                'divide_store_price' =>     $divide_type == 'distributor'?$divide_store_price:0,
                'divide_school_total' =>    $divide_type == 'school_distributor'?$divide_school_total:0,
                'divide_school_sub_price' =>$divide_type == 'school_distributor'?$divide_school_sub_price:0,
            	'divide_net_total' =>       $divide_type == 'net_distributor'?$divide_net_total:0,
            	'divide_net_sub_price' =>   $divide_type == 'net_distributor'?$divide_net_sub_price:0,
            	'divide_user_id_1'=>      $divide_user_id_1,
            	'divide_user_id_2'=>      $divide_user_id_2,
            	'divide_type'=>$divide_type,
                'postage_template_id' => $postage_template_id
            );
            //添加订单
            $ret = $this->tableObject->save($fields);
            if ($ret) {
                /*                 * **************************添加订单详细信息*********************** */
                $detailFields = array(
                    'order_id' => $ret,
                    'product_id' => $ptkj_record['product_id'],
                    'product_num' => '',
                    'product_title' => $ptkj_record['product_title'],
                    'buy_number' => $ptkj_record['buy_number'],
                    'buy_price' => $buy_price,
                	'old_price' => $old_price,
                    'size_name' => $ptkj_record['size_name'],
                    'size_id' => $ptkj_record['size_id'],
                    'color_name' => $ptkj_record['color_name'],
                    'color_id' => $ptkj_record['color_id'],
                    'path' => $ptkj_record['path'],
                    'divide_total' => $tmp_product_info['divide_total_ptkj'],
                    'divide_store_price' => $tmp_product_info['divide_store_price_ptkj'],
                    'divide_school_total' => $tmp_product_info['divide_school_total_ptkj'],
                    'divide_school_sub_price' => $tmp_product_info['divide_school_sub_price_ptkj'],
                	'divide_net_total' =>        $tmp_product_info['divide_net_total_ptkj'],
                	'divide_net_sub_price' =>    $tmp_product_info['divide_net_sub_price_ptkj']
                );
                if (!$this->Orders_detail_model->save($detailFields)) {
                    //删除已经添加进去的数据，保持数据统一性
                    $this->tableObject->delete(array('id' => $ret, 'user_id' => get_cookie('user_id')));
                    printAjaxError('fail', '订单提交失败');
                }
                $this->Ptkj_record_model->save(array('order_id' => $ret), array('id' => $ptkj_record_id));
                //订单跟踪记录
                $ordersprocessFields = array(
                    'add_time' => time(),
                    'content' => "订单创建成功",
                    'order_id' => $ret
                );
                $this->Orders_process_model->save($ordersprocessFields);
                printAjaxSuccess(base_url() . "index.php/order/pay/{$ret}.html", '订单提交成功');
            } else {
                printAjaxError('fail', '订单提交失败');
            }
        }
    }

    //付款结算界面
    public function pay($order_id = NULL) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $user_id = get_cookie('user_id');
        $item_info = $this->tableObject->get('*', array('id' => $order_id, 'user_id'=>$user_id, 'status'=>0));
        if (!$item_info) {
            $data = array(
                'user_msg' => '此订单信息不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        //订单详细
        $order_detail_list = $this->Orders_detail_model->gets('*', "order_id = $order_id");
        //用户信息
        $user_info = $this->User_model->get('total', array('id'=>$user_id));

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '去付款',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'close_order_time'=>$systemInfo['close_order_time'],
            'item_info'=>$item_info,
        	'total'=>$item_info?$item_info['total']:0,
            'order_detail_list' => $order_detail_list,
            'user_info' => $user_info
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/pay", $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //预存款订单结算
    public function yue_pay() {
        checkLoginAjax();
        if ($_POST) {
        	$user_id = get_cookie('user_id');
        	$order_id = $this->input->post('order_id');
        	$pay_password = $this->input->post('pay_password');

        	if (!$order_id) {
        		printAjaxError('fail', '支付异常，刷新重试');
        	}
        	if (!$pay_password) {
        		printAjaxError('fail', '支付密码不能为空');
        	}
            //判断下单用户是否存在
        	$user_info = $this->User_model->get('*', array('id' => $user_id));
        	if (!$user_info) {
        		printAjaxError('fail', '此用户不存在，结算失败');
        	}
            $item_info = $this->tableObject->get('*', array('id'=>$order_id, 'user_id'=>$user_id, 'status'=>0));
            if (!$item_info) {
                printAjaxError('fail', '此订单信息不存在');
            }
            //预存款支付
            if ($item_info['total'] > $user_info['total']) {
            	printAjaxError('fail', '预存款余额不足，请选择其它支付方式');
            }
            if ($this->User_model->getPasswordSalt($user_info['username'], $pay_password) != $user_info['pay_password']) {
                printAjaxError('fail', '支付密码错误，请重新输入');
            }

            //修改订单状态
            $fields = array(
            		'status' => 1,
            		'payment_price' => 0,//费率
            		'payment_title' => '预存款支付',
            		'payment_id' => 1);
            if (!$this->tableObject->save($fields, array('id' => $item_info['id'], 'user_id' => $user_info['id']))) {
            	printAjaxError('fail', '预存款支付失败');
            }
            //追踪记录
            $fields = array(
            		'add_time' => time(),
            		'content' => "订单付款成功--[订单号：{$item_info['order_number']}]",
            		'order_id' => $item_info['id'],
            		'current_status' => $item_info['status'],
            		'change_status' => 1
            );
            $orders_process_id = $this->Orders_process_model->save($fields);
            if (!$orders_process_id) {
            	//支付失败，恢复订单状态
            	$fields = array(
            			'status' => 0,
            			'payment_price' => 0,//费率
            			'payment_title' => '',
            			'payment_id' => 0);
            	$this->tableObject->save($fields, array('id' => $item_info['id'], 'user_id' => $user_info['id']));
            	printAjaxError('fail', '预存款支付失败');
            }
            //进行扣款
            if (!$this->User_model->save(array('total' => $user_info['total'] - $item_info['total']), array('id' => $user_id))) {
            	$fields = array(
            			'status' => 0,
            			'payment_price' => 0,//费率
            			'payment_title' => '',
            			'payment_id' => 0);
            	$this->tableObject->save($fields, array('id' => $item_info['id'], 'user_id' => $user_info['id']));
            	$this->Orders_process_model->delete(array('id' => $orders_process_id));
            	printAjaxError('fail', '预存款支付失败');
            }
            //财务记录还没有添加
            $fields = array(
            		'cause' => "订单付款成功--[订单号：{$item_info['order_number']}]",
            		'price' => -$item_info['total'],
            		'balance' => $user_info['total'] - $item_info['total'],
            		'add_time' => time(),
            		'user_id' => $user_info['id'],
            		'username' => $user_info['username'],
            		'type' => 'order_out',
            		'pay_way' => 1,
            		'ret_id' => $item_info['id'],
            		'from_user_id' => $user_info['id']
            );
            $this->Financial_model->save($fields);
			//付款减库存
			$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
            if ($systemInfo['stock_reduce_type'] == 1) {
	            $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
	            if ($orders_detail_list) {
	            	foreach ($orders_detail_list as $item) {
	            		if ($item['color_size_open'] == 1) {
	            			$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
	            			if ($product_stock_info) {
	            				$stock = $product_stock_info['stock'] - $item['buy_number'];
	            				$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
	            			}
	            		} else {
	            			$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
	            			if ($product_info) {
	            				$stock = $product_info['stock'] - $item['buy_number'];
	            				$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
	            			}
	            		}
	            	}
	            }
            }
            printAjaxSuccess(base_url() . "index.php/{$this->_template}/pay_result/{$item_info['order_number']}.html", '恭喜您支付成功!');
        }
    }

    //付款完成
    public function pay_result($order_number = NULL) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        if (!$order_number) {
        	$data = array(
        			'user_msg' => '此订单信息不存在',
        			'user_url' => base_url()
        	);
        	$this->session->set_userdata($data);
        	redirect('/message/index');
        }
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->tableObject->get('*', array('order_number' => $order_number, 'user_id' =>$user_id, 'status'=>1));
        if (!$item_info) {
            $data = array(
                'user_msg' => '此订单信息不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        //近期热销商品
        $hotProductList = $this->Product_model->gets('*', "product.display = 1", 12, 0, 'product.sales');

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '付款完成' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info,
            'hotProductList' => $hotProductList
        );
        $layout = array(
            'content' => $this->load->view('order/pay_result', $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function delete_order() {
        checkLoginAjax();
        if ($_POST) {
            $user_id = get_cookie('user_id');
            $ids = $this->input->post('ids', true);
            if (!$ids) {
            	printAjaxError('fail', '请选择删除项');
            }
            if ($this->tableObject->rowCount("id in ({$ids}) and status <> 4 and user_id = {$user_id}")) {
            	printAjaxError('fail', '只能操作交易关闭的订单，请检查');
            }
            if (!$this->tableObject->save(array('is_delete'=>1), "id in ({$ids}) and status = 4 and user_id = {$user_id}")) {
            	printAjaxError('fail', '操作失败');
            }
            $ids_arr = explode(',', $ids);
            printAjaxData(array('ids'=>$ids_arr));
        }
    }

    //提醒发货
    public function remind_deliver_goods() {
    	checkLoginAjax();
        if ($_POST) {
            $user_id = get_cookie('user_id');
            $order_id = $this->input->post('order_id', true);
            if (!$order_id) {
            	printAjaxError('fail', '操作异常');
            }
            $order_info = $this->tableObject->get('*', array('id' => $order_id, 'user_id'=>$user_id));
            if (!$order_info) {
            	printAjaxError('fail', '此订单信息不存在');
            }
            if ($order_info['status'] != 1) {
                printAjaxError('fail', '必须是已付款的订单才可以提醒发货');
            }
            $current_time = strtotime(date('Y-m-d 00:00:00'));
            if ($this->Message_model->rowCount("from_user_id = {$user_id} and map_id = {$order_info['id']} and message_type = 'order' and add_time > {$current_time}")) {
                printAjaxError('fail', '每个订单一天内只能提醒一次');
            }
            $fields = array(
            		'message_type' => 'order',
            		'to_user_id' => 0,
            		'from_user_id' => $user_id,
            		'content' => "订单{$order_info['order_number']}已付款，请及时发货",
            		'map_id'=>$order_info['id'],
            		'add_time' => time()
                );
            $this->Message_model->save($fields);
            printAjaxSuccess('success', '提醒发货成功');
        }
    }

    //支付宝支付
    public function alipay_pay($order_id = NULL) {
    	header('Content-type:text/html;charset=utf-8');
    	$gloabPreUrl = $this->session->userdata('gloabPreUrl');
    	checkLogin();
    	if (!$order_id) {
    		$data = array(
    				'user_msg' => '操作异常',
    				'user_url' => $gloabPreUrl
    		);

    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    	$user_id = get_cookie('user_id');
    	//判断下单用户是否存在
    	$user_info = $this->User_model->get('*', array('user.id' => $user_id));
    	if (!$user_info) {
    		$data = array(
    				'user_msg' => '用户信息不存在，结算失败',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    	$orders_info = $this->tableObject->get('*', "id = {$order_id} and user_id = {$user_id} and status = 0");
    	if (!$orders_info) {
    		$data = array(
    				'user_msg' => '此订单信息不存在',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    	$out_trade_no = $orders_info['order_number'];
    	$total_fee = $orders_info['total'];
    	//生成支付记录
    	if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'alipay', 'order_type' => 'orders'))) {
    		$this->tableObject->save(array('order_number' => $out_trade_no), array('id' => $orders_info['id']));
    		$fields = array(
    				'user_id' => $user_id,
    				'total_fee' => $orders_info['total'],
    				'total_fee_give' => 0,
    				'out_trade_no' => $out_trade_no,
    				'order_num' => $orders_info['order_number'],
    				'trade_status' => 'WAIT_BUYER_PAY',
    				'add_time' => time(),
    				'payment_type' => 'alipay',
    				'order_type' => 'orders'
    		);
    		if (!$this->Pay_log_model->save($fields)) {
    			$data = array(
    					'user_msg' => '支付失败，请重试',
    					'user_url' => $gloabPreUrl
    			);
    			$this->session->set_userdata($data);
    			redirect(base_url() . 'index.php/message/index');
    		}
    	}
    	/********************支付***********************/
    	require_once("sdk/alipay/alipay.config.php");
    	require_once("sdk/alipay/lib/alipay_submit.class.php");

    	//构造要请求的参数数组，无需改动
    	$parameter = array(
    			"service" => $alipay_config['service'],
    			"partner" => $alipay_config['partner'],
    			"seller_id" => $alipay_config['seller_id'],
    			"payment_type" => $alipay_config['payment_type'],
    			"notify_url" => base_url() . 'index.php/order/alipay_notify',
    			"return_url" => base_url() . 'index.php/order/alipay_return',

    			"anti_phishing_key" => $alipay_config['anti_phishing_key'],
    			"exter_invoke_ip" => $alipay_config['exter_invoke_ip'],
    			"out_trade_no" => $out_trade_no,
    			"subject" => "携众易购付款",
    			"total_fee" => $total_fee,
    			"body" => '携众易购即时到账支付',
    			"_input_charset" => trim(strtolower($alipay_config['input_charset']))
    	);
    	$alipay_config['notify_url'] = $parameter['notify_url'];
    	$alipay_config['return_url'] = $parameter['return_url'];
    	//建立请求
    	$alipaySubmit = new AlipaySubmit($alipay_config);
    	$html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
    	echo $html_text;
    }

    //支付 宝异步通知
    public function alipay_notify() {
    	if ($_POST) {
    		require_once("sdk/alipay/alipay.config.php");
    		require_once("sdk/alipay/lib/alipay_notify.class.php");
    		//计算得出通知验证结果
    		$alipay_config['notify_url'] = base_url() . 'index.php/order/alipay_notify';
    		$alipay_config['return_url'] = base_url() . 'index.php/order/alipay_return';
    		$alipayNotify = new AlipayNotify($alipay_config);
    		$verify_result = $alipayNotify->verifyNotify();
    		if ($verify_result) {
    			//商户订单号
    			$out_trade_no = $this->input->post('out_trade_no', TRUE);
    			//支付宝交易号
    			$trade_no = $this->input->post('trade_no', TRUE);
    			//交易状态
    			$trade_status = $this->input->post('trade_status', TRUE);
    			//买家支付宝账号
    			$buyer_email = $this->input->post('buyer_email', TRUE);
    			//通知时间
    			$notify_time = strtotime($this->input->post('notify_time', TRUE));
    			$seller_id = $this->input->post('seller_id', TRUE);
    			$total_fee = $this->input->post('total_fee', TRUE);

    			if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
    				$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'orders', 'payment_type' => 'alipay'));
    				if ($pay_log_info && $alipay_config['seller_id'] == $seller_id && $total_fee == $pay_log_info['total_fee']) {
    					if ($pay_log_info['trade_status'] != $trade_status && $pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
    						//支付记录
    						$fields = array(
    								'trade_no' => $trade_no,
    								'trade_status' => $trade_status,
    								'buyer_email' => $buyer_email,
    								'notify_time' => $notify_time
    						);
    						if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
    							$item_info = $this->tableObject->get('*', array('order_number' => $out_trade_no, 'status' => 0));
    							$user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
    							if ($item_info && $user_info) {
    								//修改订单状态
    								$fields = array(
    										'status' => 1,
    										'payment_price' => 0,//费率
    										'payment_title' => '支付宝支付',
    										'payment_id' => 2);
    								if ($this->tableObject->save($fields, array('id' => $item_info['id']))) {
    									//订单追踪记录
    									$fields = array(
    											'add_time' => time(),
    											'content' => "订单付款成功[支付宝支付]",
    											'order_id' => $item_info['id'],
    											'current_status' => $item_info['status'],
    											'change_status' => 1
    									);
    									$this->Orders_process_model->save($fields);
    									//财务记录
    									if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
    										$fields = array(
    												'cause' => "支付成功-[订单号：{$item_info['order_number']}]",
    												'price' => -$item_info['total'],
    												'balance' => $user_info['total'],
    												'add_time' => time(),
    												'user_id' => $user_info['id'],
    												'username' => $user_info['username'],
    												'type' => 'order_out',
    												'pay_way' => '2',
    												'ret_id' => $item_info['id'],
    												'from_user_id' => $user_info['id']
    										);
    										$this->Financial_model->save($fields);
    									}
										//付款减库存
										$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
							            if ($systemInfo['stock_reduce_type'] == 1) {
								            $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
								            if ($orders_detail_list) {
								            	foreach ($orders_detail_list as $item) {
								            		if ($item['color_size_open'] == 1) {
								            			$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
								            			if ($product_stock_info) {
								            				$stock = $product_stock_info['stock'] - $item['buy_number'];
								            				$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
								            			}
								            		} else {
								            			$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
								            			if ($product_info) {
								            				$stock = $product_info['stock'] - $item['buy_number'];
								            				$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
								            			}
								            		}
								            	}
								            }
							            }
    								}
    							}
    						}
    					}
    				}
    			}
    			echo "success";
    		} else {
    			echo "fail";
    		}
    	}
    }

    //支付 宝同步通知
    public function alipay_return() {
    	require_once("sdk/alipay/alipay.config.php");
    	require_once("sdk/alipay/lib/alipay_notify.class.php");
    	$alipay_config['notify_url'] = base_url() . 'index.php/order/alipay_notify';
    	$alipay_config['return_url'] = base_url() . 'index.php/order/alipay_return';

    	$gloabPreUrl = $this->session->userdata('gloabPreUrl');
    	$alipayNotify = new AlipayNotify($alipay_config);
    	$verify_result = $alipayNotify->verifyReturn();
    	if (!$verify_result) {
    		$data = array(
    				'user_msg' => '订单支付失败',
    				'user_url' => $gloabPreUrl
    		);

    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    	$out_trade_no = $_GET['out_trade_no'];
    	//支付宝交易号
    	$trade_no = $_GET['trade_no'];
    	//交易状态
    	$trade_status = $_GET['trade_status'];
    	//买家支付宝账号
    	$buyer_email = $this->input->get('buyer_email', TRUE);
    	//通知时间
    	$notify_time = strtotime($this->input->get('notify_time', TRUE));

    	if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
    		//判断该笔订单是否在商户网站中已经做过处理
    		//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
    		//如果有做过处理，不执行商户的业务程序
    		$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'orders', 'payment_type' => 'alipay'));
    		if (!$pay_log_info) {
    			$data = array(
    					'user_msg' => '此支付记录不存在,支付失败',
    					'user_url' => $gloabPreUrl
    			);
    			$this->session->set_userdata($data);
    			redirect(base_url() . 'index.php/message/index');
    		}
    		if ($pay_log_info['trade_status'] != $trade_status && $pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
    			//支付记录
    			$fields = array(
    					'trade_no' => $trade_no,
    					'trade_status' => $trade_status,
    					'buyer_email' => $buyer_email,
    					'notify_time' => $notify_time
    			);
    			if (!$this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
    				$data = array(
    						'user_msg' => '支付失败，请重试',
    						'user_url' => $gloabPreUrl
    				);
    				$this->session->set_userdata($data);
    				redirect(base_url() . 'index.php/message/index');
    			}
    			$item_info = $this->tableObject->get('*', array('order_number' => $out_trade_no, 'status' => 0));
    			$user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
    			if ($item_info && $user_info) {
    				//修改订单状态
    				$fields = array(
    						'status' => 1,
    						'payment_price' => 0,//费率
    						'payment_title' => '支付宝支付',
    						'payment_id' => 2);
    				if ($this->tableObject->save($fields, array('id' => $item_info['id'], 'status' => 0))) {
    					//订单追踪记录
    					$fields = array(
    							'add_time' => time(),
    							'content' => "订单付款成功[支付宝支付]",
    							'order_id' => $item_info['id'],
    							'current_status' => $item_info['status'],
    							'change_status' => 1
    					);
    					$this->Orders_process_model->save($fields);
    					//财务记录
    					if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
    						$fields = array(
    								'cause' => "支付成功-[订单号：{$item_info['order_number']}]",
    								'price' => -$item_info['total'],
    								'balance' => $user_info['total'],
    								'add_time' => time(),
    								'user_id' => $user_info['id'],
    								'username' => $user_info['username'],
    								'type' => 'order_out',
    								'pay_way' => '2',
    								'ret_id' => $item_info['id'],
    								'from_user_id' => $user_info['id']
    						);
    						$this->Financial_model->save($fields);
    					}
						//付款减库存
						$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
			            if ($systemInfo['stock_reduce_type'] == 1) {
				            $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
				            if ($orders_detail_list) {
				            	foreach ($orders_detail_list as $item) {
				            		if ($item['color_size_open'] == 1) {
				            			$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
				            			if ($product_stock_info) {
				            				$stock = $product_stock_info['stock'] - $item['buy_number'];
				            				$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
				            			}
				            		} else {
				            			$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
				            			if ($product_info) {
				            				$stock = $product_info['stock'] - $item['buy_number'];
				            				$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
				            			}
				            		}
				            	}
				            }
			            }
    				}
    			}
    			redirect(base_url() . "index.php/{$this->_template}/pay_result/{$out_trade_no}.html");
    		} else {
    			$fields = array();
    			if (!$item_info['buyer_email']) {
    				$fields['buyer_email'] = $buyer_email;
    			}
    			if (!$item_info['notify_time']) {
    				$fields['notify_time'] = $notify_time;
    			}
    			if ($fields) {
    				$this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']));
    			}
    			redirect(base_url() . "index.php/{$this->_template}/pay_result/{$out_trade_no}.html");
    		}
    	} else {
    		$data = array(
    				'user_msg' => $this->_trade_status_msg[$trade_status] . '，支付失败，请重试',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    }

    //付款-微信支付界面
    public function pay_weixin($order_id = NULL) {
    	$gloabPreUrl = $this->session->userdata('gloabPreUrl');
    	checkLogin();
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	if (!$order_id) {
    		$data = array(
    				'user_msg' => '操作异常',
    				'user_url' => $gloabPreUrl
    		);

    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    	$user_id = get_cookie('user_id');
    	//判断下单用户是否存在
    	$user_info = $this->User_model->get('*', array('user.id' => $user_id));
    	if (!$user_info) {
    		$data = array(
    				'user_msg' => '用户信息不存在，结算失败',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    	$item_info = $this->tableObject->get('*', "id = {$order_id} and user_id = {$user_id} and status = 0");
    	if (!$item_info) {
    		$data = array(
    				'user_msg' => '此订单信息不存在',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}

    	/********************微信支付**********************/
    	require_once "sdk/weixin_pay/lib/WxPay.Api.php";
    	require_once "sdk/weixin_pay/WxPay.NativePay.php";

    	$product_id = 'O' . $item_info['order_number'];
    	$out_trade_no = $item_info['out_trade_no'];
    	if (!$out_trade_no) {
    		$out_trade_no = 'O' . $this->advdbclass->get_unique_orders_number('out_trade_no');
    		$this->tableObject->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));
    	}
    	$notify = new NativePay();
    	$input = new WxPayUnifiedOrder();
    	$input->SetBody("携众易购付款");
    	$input->SetAttach("{$item_info['order_number']}");
    	$input->SetTotal_fee($item_info['total'] * 100);
    	$input->SetTime_start(date("YmdHis"));
    	$input->SetTime_expire(date("YmdHis", time() + 600));
    	$input->SetNotify_url(base_url() . "index.php/order/weixin_notify");
    	$input->SetTrade_type("NATIVE");
    	$input->SetProduct_id($product_id);
    	$input->SetOut_trade_no($out_trade_no);
    	$result = $notify->GetPayUrl($input);
    	$qr_url = '';
    	if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
    		$qr_url = $result["code_url"];
    		//生成支付记录
    		if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'))) {
    			$fields = array(
    					'user_id' => $user_id,
    					'total_fee' => $item_info['total'],
    					'total_fee_give' => 0,
    					'out_trade_no' => $out_trade_no,
    					'order_num' => $item_info['order_number'],
    					'trade_status' => 'WAIT_BUYER_PAY',
    					'add_time' => time(),
    					'payment_type' => 'weixin',
    					'order_type' => 'orders'
    			);
    			$this->Pay_log_model->save($fields);
    		}
    	} else {
    		if (array_key_exists('result_code', $result) && $result['result_code'] == "FAIL") {
    			//商户号重复时，要重新生成
    			if ($result['err_code'] == 'OUT_TRADE_NO_USED' || $result['err_code'] == 'INVALID_REQUEST') {
    				$out_trade_no = 'O' . $this->advdbclass->get_unique_orders_number('out_trade_no');
    				$this->tableObject->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));

    				$notify = new NativePay();
    				$input = new WxPayUnifiedOrder();
    				$input->SetBody("携众易购付款");
    				$input->SetAttach("{$item_info['order_number']}");
    				$input->SetTotal_fee($item_info['total'] * 100);
    				$input->SetTime_start(date("YmdHis"));
    				$input->SetTime_expire(date("YmdHis", time() + 600));
    				$input->SetNotify_url(base_url() . "index.php/order/weixin_notify");
    				$input->SetTrade_type("NATIVE");
    				$input->SetProduct_id($product_id);
    				$input->SetOut_trade_no($out_trade_no);
    				$result = $notify->GetPayUrl($input);
    				if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
    					$qr_url = $result["code_url"];
    					//生成支付记录
    					if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'))) {
    						$fields = array(
    								'user_id' => $user_id,
    								'total_fee' => $item_info['total'],
    								'total_fee_give' => 0,
    								'out_trade_no' => $out_trade_no,
    								'order_num' => $item_info['order_number'],
    								'trade_status' => 'WAIT_BUYER_PAY',
    								'add_time' => time(),
    								'payment_type' => 'weixin',
    								'order_type' => 'orders'
    						);
    						$this->Pay_log_model->save($fields);
    					}
    				}
    			}
    		}
    	}

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => '去付款',
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'item_info' => $item_info,
    			'total' => $item_info ? $item_info['total'] : '0.00',
    			'qr_url' => $qr_url,
    			'result' => $result,
    			'out_trade_no' => $out_trade_no,
    			'template' => $this->_template
    	);
    	$layout = array(
    			'content' => $this->load->view("{$this->_template}/pay_weixin", $data, TRUE)
    	);
    	$this->load->view('layout/cart_layout', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    //微信支付异步通知
    public function weixin_notify() {
    	/********************微信支付**********************/
    	require_once "sdk/weixin_pay/lib/WxPay.Api.php";

    	$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
    	try {
    		$data = WxPayResults::Init($xml);
    		if (array_key_exists("transaction_id", $data)) {
    			$input = new WxPayOrderQuery();
    			$input->SetTransaction_id($data["transaction_id"]);
    			$result = WxPayApi::orderQuery($input);
    			if (array_key_exists("return_code", $result)
    					&& array_key_exists("result_code", $result)
    					&& $result["return_code"] == "SUCCESS"
    					&& $result["result_code"] == "SUCCESS"
    			) {
    				//订单号
    				$order_num = $result['attach'];
    				//商户订单号
    				$out_trade_no = $result['out_trade_no'];
    				//微信交易号
    				$trade_no = $result['transaction_id'];
    				//通知时间
    				$notify_time = $result['time_end'];
    				$total_fee = $result['total_fee'];

    				$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'orders', 'payment_type' => 'weixin'));
    				if ($pay_log_info && $total_fee == $pay_log_info['total_fee'] * 100) {
    					if ($pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
    						//支付记录
    						$fields = array(
    								'trade_no' => $trade_no,
    								'trade_status' => 'TRADE_SUCCESS',
    								'buyer_email' => '',
    								'notify_time' => strtotime($notify_time)
    						);
    						if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
    							$item_info = $this->tableObject->get('*', array('order_number' => $order_num, 'status' => 0));
    							$user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
    							if ($item_info && $user_info) {
    								//修改订单状态
    								$fields = array(
    										'status' => 1,
    										'payment_price' => 0,//费率
    										'payment_title' => '微信支付',
    										'payment_id' => 3);
    								if ($this->tableObject->save($fields, array('id' => $item_info['id']))) {
    									//订单追踪记录
    									$fields = array(
    											'add_time' => time(),
    											'content' => "订单付款成功[微信支付]",
    											'order_id' => $item_info['id'],
    											'current_status' => $item_info['status'],
    											'change_status' => 1
    									);
    									$this->Orders_process_model->save($fields);
    									//财务记录
    									if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
    										$fields = array(
    												'cause' => "支付成功-[订单号：{$item_info['order_number']}]",
    												'price' => -$item_info['total'],
    												'balance' => $user_info['total'],
    												'add_time' => time(),
    												'user_id' => $user_info['id'],
    												'username' => $user_info['username'],
    												'type' => 'order_out',
    												'pay_way' => '3',
    												'ret_id' => $item_info['id'],
    												'from_user_id' => $user_info['id']
    										);
    										$this->Financial_model->save($fields);
    									}
										//付款减库存
										$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
							            if ($systemInfo['stock_reduce_type'] == 1) {
								            $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
								            if ($orders_detail_list) {
								            	foreach ($orders_detail_list as $item) {
								            		if ($item['color_size_open'] == 1) {
								            			$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
								            			if ($product_stock_info) {
								            				$stock = $product_stock_info['stock'] - $item['buy_number'];
								            				$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
								            			}
								            		} else {
								            			$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
								            			if ($product_info) {
								            				$stock = $product_info['stock'] - $item['buy_number'];
								            				$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
								            			}
								            		}
								            	}
								            }
							            }
    								}
    							}
    						}
    					}
    				}
    			}
    		}
    	} catch (WxPayException $e) {
    		$msg = $e->errorMessage();
    	}
    }

    /***
     * 微信支付心跳程序
     */
    public function get_weixin_heart() {
    	if ($_POST) {
    		$out_trade_no = $this->input->post('out_trade_no');
    		if (!$out_trade_no) {
    			printAjaxError('fail', '参数错误');
    		}
    		$pay_log_info = $this->Pay_log_model->get('trade_status, order_num', array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'));
    		if (!$pay_log_info) {
    			printAjaxError('fail', '支付记录不存在');
    		}
    		printAjaxData($pay_log_info);
    	}
    }

    //获取配送费用
    private function _getPostagewayPrice($postagewayId, $areaName) {
        $postagepriceInfo = $this->Postage_price_model->get('start_price, add_price', "postage_way_id = {$postagewayId} and (area like '{$areaName}%' or area like '%,{$areaName}' or area like '%,{$areaName},%')");
        if (!$postagepriceInfo) {
            $postagepriceInfo = $this->Postage_price_model->get('start_price, add_price', "postage_way_id = {$postagewayId} and area = '其它地区'");
        }
        return number_format($postagepriceInfo['start_price'], 2, '.', '');
    }

    private function query_logistics($num = '') {
        $key = 'mZRQwDVc3377';
        $result = file_get_contents("http://www.kuaidi100.com/autonumber/auto?num=$num&key=$key");
        $arr = json_decode($result, true);
        if (empty($arr)) {
            return array();
        }
        $com = $arr[0]['comCode'];
        $post_data = array();
        $post_data["customer"] = '1FCC0BAA1D04BBDFEB9EE3F96F963265';
        $post_data["param"] = '{"com":"' . $com . '","num":"' . $num . '"}';
        $url = 'http://www.kuaidi100.com/poll/query.do';
        $post_data["sign"] = md5($post_data["param"] . $key . $post_data["customer"]);
        $post_data["sign"] = strtoupper($post_data["sign"]);
        $o = "";
        foreach ($post_data as $k => $v) {
            $o.= "$k=" . urlencode($v) . "&";  //默认UTF-8编码格式
        }
        $post_data = substr($o, 0, -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);
        curl_close($ch);
        $data = str_replace("\&quot;", '"', $result);
        $data = json_decode($data, true);
        return $data;
    }

     //消息推送，只针对手机登录的用户有效
    private function _send_push($cid = '', $message = '') {
           $getui = new Getuiapiclass();
           $getui->send_push($cid, $message);
     }

     /**
      * 生成微信支付二维码
      */
     public function get_weixin_qr() {
     	$url = $_GET['url'];
     	if ($url) {
     		$qr = get_qrcode(urldecode($url), 8);
     		header("Content-type:image/png");
     		imagepng($qr);
     		imagedestroy($qr);
     	}
     }
}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */