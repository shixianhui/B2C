<?php
class User extends CI_Controller {
	private $_title = '会员管理';
	private $_tool = '';
	private $_distributor_arr = array('0'=>'普通会员', '1'=>'城市合伙人', '2'=>'店级合伙人');
	private $_school_distributor_arr = array('0'=>'普通会员', '1'=>'校园一级分销商', '2'=>'校园二级分销商');
	private $_net_distributor_arr = array('0'=>'普通会员', '1'=>'网络一级分销商', '2'=>'网络二级分销商');
	private $_distributor_status_arr = array('0'=>'<font color="red">待审核</font>', '1'=>'正常', '2'=>'<font color="red">审核拒绝</font>', '3'=>'<font color="red">禁用当前身份</font>');
	private $_user_type_arr = array('0'=>'会员', '1'=>'商家');
	private $_seller_grade_arr = array(''=>'未设置', 'a'=>'A类', 'b'=>'B类', 'c'=>'C类');
	private $_template = 'user';
	public function __construct() {
		parent::__construct();
		$this->_tool = $this->load->view('element/user_tool', '', TRUE);
		$this->load->model('User_model', '', TRUE);
		$this->load->model('Usergroup_model', '', TRUE);
		$this->load->model('Area_model', '', TRUE);
		$this->load->model('Admin_model', '', TRUE);
		$this->load->library('pagination');
	}

	public function index($flush = 0, $page = 0) {
		checkPermission("{$this->_template}_index");
		if ($flush) {
			$flush = 0;
		    $this->session->unset_userdata(array('search'=>''));
		}
		$this->session->set_userdata(array('userRefUrl'=>base_url().'admincp.php/'.uri_string()));
		$condition = "user.id > 0";
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):$condition;

	    if ($_POST) {
		    $strWhere = $condition;
		    $categoryId = $this->input->post('category_id', TRUE);
		    $display = $this->input->post('display');
		    $startTime = $this->input->post('inputdate_start');
		    $endTime = $this->input->post('inputdate_end');
		    $id = trim($this->input->post('id', TRUE));
		    $username = trim($this->input->post('username', TRUE));
		    $real_name = trim($this->input->post('real_name', TRUE));
		    $mobile = trim($this->input->post('mobile', TRUE));
		    $nickname = trim($this->input->post('nickname', TRUE));
		    $presenter_id = trim($this->input->post('presenter_id', TRUE));
		    $presenter_username = trim($this->input->post('presenter_username', TRUE));
		    $gold_card_num = trim($this->input->post('gold_card_num', TRUE));

		    if ($gold_card_num) {
		    	$strWhere .= " and user.gold_card_num = '{$gold_card_num}' ";
		    }
		    if ($presenter_id) {
		    	$strWhere .= " and user.presenter_id = '{$presenter_id}' ";
		    }
		    if ($presenter_username) {
		    	$strWhere .= " and user.presenter_username = '{$presenter_username}' ";
		    }
		    if ($id) {
		    	$strWhere .= " and user.id = '{$id}' ";
		    }
		    if ($username) {
		    	$strWhere .= " and user.username = '{$username}' ";
		    }
		    if ($real_name) {
		    	$strWhere .= " and user.real_name REGEXP '{$real_name}' ";
		    }
		    if ($mobile) {
		    	$strWhere .= " and user.mobile REGEXP '{$mobile}' ";
		    }
		    if ($nickname) {
		    	$strWhere .= " and user.nickname REGEXP '{$nickname}' ";
		    }
	        if ($categoryId) {
		        $strWhere .= " and user.user_group_id = '{$categoryId}' ";
		    }
		    if ($display != "") {
		        $strWhere .= " and user.display={$display} ";
		    }
		    if (! empty($startTime) && ! empty($endTime)) {
		    	$strWhere .= ' and user.add_time > '.strtotime($startTime.' 00:00:00').' and user.add_time < '.strtotime($endTime.' 23:59:59').' ';
		    }
		    $this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->User_model->rowCount($strWhere);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url()."admincp.php/user/index/{$flush}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$userList = $this->User_model->gets($strWhere, $paginationConfig['per_page'], $page);
		$usergroupList = $this->Usergroup_model->gets();
		$data = array(
		              'tool'=>$this->_tool,
				      'flush'=>$flush,
				      'distributor_arr'=>$this->_distributor_arr,
		              'userList'=>$userList,
		              'usergroupList'=>$usergroupList,
		              'pagination'=>$pagination,
		              'paginationCount'=>$paginationCount,
		              'pageCount'=>ceil($paginationCount/$paginationConfig['per_page'])
		              );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view('user/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function index_0($flush = 0, $page = 0) {
		checkPermission("{$this->_template}_index_0");
		if ($flush) {
			$flush = 0;
			$this->session->unset_userdata(array('search'=>''));
		}
		$this->session->set_userdata(array('userRefUrl'=>base_url().'admincp.php/'.uri_string()));
		$condition = "user.user_type = 0 ";
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):$condition;

		if ($_POST) {
			$strWhere = $condition;

			$categoryId = $this->input->post('category_id', TRUE);
			$display = $this->input->post('display');
			$startTime = $this->input->post('inputdate_start');
			$endTime = $this->input->post('inputdate_end');
			$id = trim($this->input->post('id', TRUE));
			$username = trim($this->input->post('username', TRUE));
			$real_name = trim($this->input->post('real_name', TRUE));
			$mobile = trim($this->input->post('mobile', TRUE));
			$nickname = trim($this->input->post('nickname', TRUE));
			$presenter_id = trim($this->input->post('presenter_id', TRUE));
			$presenter_username = trim($this->input->post('presenter_username', TRUE));
			$gold_card_num = trim($this->input->post('gold_card_num', TRUE));

			if ($gold_card_num) {
				$strWhere .= " and user.gold_card_num = '{$gold_card_num}' ";
			}
			if ($presenter_id) {
				$strWhere .= " and user.presenter_id = '{$presenter_id}' ";
			}
			if ($presenter_username) {
				$strWhere .= " and user.presenter_username = '{$presenter_username}' ";
			}
			if ($id) {
				$strWhere .= " and user.id = '{$id}' ";
			}
			if ($username) {
				$strWhere .= " and user.username = '{$username}' ";
			}
			if ($real_name) {
				$strWhere .= " and user.real_name REGEXP '{$real_name}' ";
			}
			if ($mobile) {
				$strWhere .= " and user.mobile REGEXP '{$mobile}' ";
			}
			if ($nickname) {
				$strWhere .= " and user.nickname REGEXP '{$nickname}' ";
			}
			if ($categoryId) {
				$strWhere .= " and user.user_group_id = '{$categoryId}' ";
			}
			if ($display != "") {
				$strWhere .= " and user.display={$display} ";
			}
			if (! empty($startTime) && ! empty($endTime)) {
				$strWhere .= ' and user.add_time > '.strtotime($startTime.' 00:00:00').' and user.add_time < '.strtotime($endTime.' 23:59:59').' ';
			}
			$this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->User_model->rowCount($strWhere);
		$paginationConfig = $this->config->item('pagination_config');
		$paginationConfig['base_url'] = base_url()."admincp.php/user/index_0/{$flush}/";
		$paginationConfig['total_rows'] = $paginationCount;
		$paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$userList = $this->User_model->gets($strWhere, $paginationConfig['per_page'], $page);
		if ($userList) {
			foreach ($userList as $key=>$value) {
				$userList[$key]['presenter_count'] = $this->User_model->rowCount(array('presenter_id'=>$value['id']));
			}
		}
		$usergroupList = $this->Usergroup_model->gets();
		$data = array(
				'tool'=>$this->_tool,
				'flush'=>$flush,
				'userList'=>$userList,
				'usergroupList'=>$usergroupList,
				'pagination'=>$pagination,
				'paginationCount'=>$paginationCount,
				'pageCount'=>ceil($paginationCount/$paginationConfig['per_page'])
		);
		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view('user/index_0', $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}

	public function index_1($flush = 0, $page = 0) {
		checkPermission("{$this->_template}_index_1");
		if ($flush) {
			$flush = 0;
			$this->session->unset_userdata(array('search'=>''));
		}
		$this->session->set_userdata(array('userRefUrl'=>base_url().'admincp.php/'.uri_string()));
		$condition = "user.user_type = 1 ";
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):$condition;

		if ($_POST) {
			$strWhere = $condition;
			$categoryId = $this->input->post('category_id', TRUE);
			$display = $this->input->post('display');
			$startTime = $this->input->post('inputdate_start');
			$endTime = $this->input->post('inputdate_end');
			$id = trim($this->input->post('id', TRUE));
			$username = trim($this->input->post('username', TRUE));
			$real_name = trim($this->input->post('real_name', TRUE));
			$mobile = trim($this->input->post('mobile', TRUE));
			$nickname = trim($this->input->post('nickname', TRUE));
			$presenter_id = trim($this->input->post('presenter_id', TRUE));
			$presenter_username = trim($this->input->post('presenter_username', TRUE));
			$gold_card_num = trim($this->input->post('gold_card_num', TRUE));

			if ($gold_card_num) {
				$strWhere .= " and user.gold_card_num = '{$gold_card_num}' ";
			}
			if ($presenter_id) {
				$strWhere .= " and user.presenter_id = '{$presenter_id}' ";
			}
			if ($presenter_username) {
				$strWhere .= " and user.presenter_username = '{$presenter_username}' ";
			}
			if ($id) {
				$strWhere .= " and user.id = '{$id}' ";
			}
			if ($username) {
				$strWhere .= " and user.username = '{$username}' ";
			}
			if ($real_name) {
				$strWhere .= " and user.real_name REGEXP '{$real_name}' ";
			}
			if ($mobile) {
				$strWhere .= " and user.mobile REGEXP '{$mobile}' ";
			}
			if ($nickname) {
				$strWhere .= " and user.nickname REGEXP '{$nickname}' ";
			}
			if ($categoryId) {
				$strWhere .= " and user.user_group_id = '{$categoryId}' ";
			}
			if ($display != "") {
				$strWhere .= " and user.display={$display} ";
			}
			if (! empty($startTime) && ! empty($endTime)) {
				$strWhere .= ' and user.add_time > '.strtotime($startTime.' 00:00:00').' and user.add_time < '.strtotime($endTime.' 23:59:59').' ';
			}
			$this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->User_model->rowCount($strWhere);
		$paginationConfig = $this->config->item('pagination_config');
		$paginationConfig['base_url'] = base_url()."admincp.php/user/index_1/{$flush}/";
		$paginationConfig['total_rows'] = $paginationCount;
		$paginationConfig['uri_segment'] = 4;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$userList = $this->User_model->gets($strWhere, $paginationConfig['per_page'], $page);
		if ($userList) {
			foreach ($userList as $key=>$value) {
                $userList[$key]['presenter_count'] = $this->User_model->rowCount(array('presenter_id'=>$value['id']));
			}
		}
		$usergroupList = $this->Usergroup_model->gets();
		$data = array(
				'tool'=>$this->_tool,
				'flush'=>$flush,
				'userList'=>$userList,
				'distributor_status_arr'=>$this->_distributor_status_arr,
				'seller_grade_arr'=>$this->_seller_grade_arr,
				'usergroupList'=>$usergroupList,
				'pagination'=>$pagination,
				'paginationCount'=>$paginationCount,
				'pageCount'=>ceil($paginationCount/$paginationConfig['per_page'])
		);
		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view('user/index_1', $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}

	public function select($flush = 0, $type = 0, $page = 0) {
		if ($flush) {
			$flush = 0;
			$this->session->unset_userdata(array('search_index'=>''));
		}
		$uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
		$uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/0/{$type}/{$page}";
		$this->session->set_userdata(array('userRefUrl'=>$uri_sg));
		//只显示未推荐普通会员
		$condition = NULL;
		if ($type == 1) {
			$condition = "user.distributor = 1 and user.presenter_id = 0 and user.school_distributor = 0 and user.net_distributor = 0 and user.distributor_status = 1";
		} else if ($type == 2) {
			$condition = "user.distributor = 2 and user.presenter_id = 0 and user.school_distributor = 0 and user.net_distributor = 0 and user.distributor_status = 1 ";
		} else if ($type == 21) {
			$condition = "user.school_distributor = 1 and user.presenter_id = 0 and user.distributor = 0 and user.net_distributor = 0 and user.distributor_status = 1 ";
		} else if ($type == 22) {
			$condition = "user.school_distributor = 2 and user.presenter_id = 0 and user.distributor = 0 and user.net_distributor = 0 and user.distributor_status = 1 ";
		} else if ($type == 31) {
			$condition = "user.net_distributor = 1 and user.presenter_id = 0 and user.distributor = 0 and user.school_distributor = 0 and user.distributor_status = 1 ";
		} else if ($type == 32) {
			$condition = "user.net_distributor = 2 and user.presenter_id = 0 and user.distributor = 0 and user.school_distributor = 0 and user.distributor_status = 1  ";
		} else {
            if ($type == 'tjr') {
            	$condition = "(user.distributor = 2 or user.school_distributor = 2 or user.net_distributor = 2)  and user.distributor_status = 1 ";
            } else if ($type == 'kf') {
            	//实体分销商
            	$condition = "user.distributor = 0 and user.school_distributor = 0 and user.net_distributor = 0 and user.presenter_id = 0 ";
            } else {
            	$condition = "user.id > 0 ";
            }
		}
		$strWhere = $this->session->userdata('search_index')?$this->session->userdata('search_index'):$condition;
		if ($_POST) {
			$strWhere = $condition;

			$id = trim($this->input->post('id', TRUE));
			$username = trim($this->input->post('username', TRUE));
			$real_name = trim($this->input->post('real_name', TRUE));
			$mobile = trim($this->input->post('mobile', TRUE));
			$nickname = trim($this->input->post('nickname', TRUE));

			if ($id) {
				$strWhere .= " and user.id = '{$id}' ";
			}
			if ($username) {
				$strWhere .= " and user.username = '{$username}' ";
			}
			if ($real_name) {
				$strWhere .= " and user.real_name REGEXP '{$real_name}' ";
			}
			if ($mobile) {
				$strWhere .= " and user.mobile REGEXP '{$mobile}' ";
			}
			if ($nickname) {
				$strWhere .= " and user.nickname REGEXP '{$nickname}' ";
			}

			$this->session->set_userdata('search_index', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationConfig = $this->config->item('pagination_config');
		$paginationCount = $this->User_model->rowCount($strWhere);
		$paginationConfig['base_url'] = base_url()."admincp.php/user/select/{$flush}/{$type}/";
		$paginationConfig['total_rows'] = $this->User_model->rowCount($strWhere);
		$paginationConfig['uri_segment'] = 5;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$itemList = $this->User_model->gets($strWhere, $paginationConfig['per_page'], $page);

		$data = array(
				'tool'=>$this->_tool,
				'flush'=>$flush,
				'type'=>$type,
				'itemList'=>$itemList,
				'pagination'=>$pagination,
				'paginationCount'=>$paginationCount,
				'pageCount'=>ceil($paginationCount/$paginationConfig['per_page'])
		);
		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view('user/select', $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
		if ($id) {
			checkPermission("{$this->_template}_edit");
		} else {
			checkPermission("{$this->_template}_add");
		}
		$prfUrl = $this->session->userdata('userRefUrl')?$this->session->userdata('userRefUrl'):base_url().'admincp.php/user/index';
		$userInfo = $this->User_model->get(array('user.id'=>$id));
		if ($_POST) {
			$province_id = $this->input->post('province_id', TRUE);
			$city_id = $this->input->post('city_id', TRUE);
			$area_id = $this->input->post('area_id', TRUE);
			$txt_address = $this->input->post('txt_address', TRUE);
			$username = trim($this->input->post('username', TRUE));
			$total_gold_rmb_pre = $this->input->post('total_gold_rmb_pre', TRUE);
			$total_silver_rmb_pre = $this->input->post('total_silver_rmb_pre', TRUE);
			$user_type = $this->input->post('user_type', TRUE);
			$seller_grade = $this->input->post('seller_grade', TRUE);
			$gold_card_num = trim($this->input->post('gold_card_num', TRUE));

			if ($user_type == 1) {
                if (!$seller_grade) {
                    printAjaxError('fail', '请选择商家类别');
                }
			}

			$fields = array(
			          'user_group_id'=>$this->input->post('user_group_id'),
			          'nickname'=>      $this->input->post('nickname', TRUE),
			          'real_name'=>     $this->input->post('real_name', TRUE),
			          'qq_number'=>     $this->input->post('qq_number', TRUE),
			          'wangwang_number'=>     $this->input->post('wangwang_number', TRUE),
			          'mobile'=>     $this->input->post('mobile', TRUE),
			          'phone'=>      $this->input->post('phone', TRUE),
			          'zip'=>        $this->input->post('zip', TRUE),
			          'address'=>    $this->input->post('address', TRUE),
			          'email'=>      $this->input->post('email', TRUE),
					  'province_id'=>$province_id?$province_id:0,
					  'city_id'=>    $city_id?$city_id:0,
					  'area_id'=>    $area_id?$area_id:0,
					  'txt_address'=>$txt_address,
					  'total_gold_rmb_pre'=>$total_gold_rmb_pre,
					  'total_silver_rmb_pre'=>$total_silver_rmb_pre,
					  'user_type'=>   $user_type,
					  'seller_grade'=>$user_type == 1?$seller_grade:'',
					  'gold_card_num'=>$gold_card_num
			          );
			if(!$id) {
				$fields['username'] = $username;
			}
		    $password = $this->input->post('password', TRUE);
			if ($id && $password) {
			    $fields['password'] = $this->User_model->getPasswordSalt($userInfo['username'], $password);
			}
			if (!$id && $password) {
				$addTime = time();
				$fields['add_time'] = $addTime;
				$fields['login_time'] = $addTime;
				$fields['ip_address'] = '';
			    $fields['password'] = $this->createPasswordSALT($username, $addTime, $password);
			}
			if (empty($id)) {
			    if ($this->User_model->validateUnique($username)) {
			        printAjaxError('fail', "用户名已经存在，请换个用户名！");
			    }
			}

		    if ($this->User_model->save($fields, $id?array('id'=>$id):$id)) {
		    	printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$usergroupList = $this->Usergroup_model->gets();
		$item_list = $this->Area_model->gets('id, name', array('parent_id'=>0, 'display'=>1));
	    $data = array(
		        'tool'=>$this->_tool,
	            'userInfo'=>$userInfo,
	    		'id'=>$id,
	    		'distributor_arr'=>$this->_distributor_arr,
	            'usergroupList'=>$usergroupList,
	    		'item_list'=>$item_list,
	    		'user_type_arr'=>$this->_user_type_arr,
	    		'seller_grade_arr'=>$this->_seller_grade_arr,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view('user/save', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

	public function view($id = NULL, $page = 0) {
		checkPermission("{$this->_template}_view");
		$prfUrl = $this->session->userdata('userRefUrl')?$this->session->userdata('userRefUrl'):base_url().'admincp.php/user/index';
		$this->session->set_userdata(array('userRefUrl'=>base_url().'admincp.php/'.uri_string()));
		$userInfo = $this->User_model->get(array('user.id'=>$id));

		$data = array(
				'tool'=>$this->_tool,
				'id'=>$id,
				'userInfo'=>$userInfo,
				'seller_grade_arr'=>$this->_seller_grade_arr,
				'prfUrl'=>$prfUrl
		);
		$layout = array(
				'title'=>$this->_title,
				'content'=>$this->load->view('user/view', $data, TRUE)
		);
		$this->load->view('layout/default', $layout);
	}

    //加盐算法
	private function createPasswordSALT($user, $salt, $password) {

	    return md5(strtolower($user).$salt.$password);
	}

    public function category() {
    	checkPermissionAjax("{$this->_template}_edit");
	    $ids = $this->input->post('ids', TRUE);
		$categoryId = $this->input->post('categoryId', TRUE);

		if (! empty($ids) && ! empty($categoryId)) {
			if($this->User_model->save(array('user_group_id'=>$categoryId), 'id in ('.$ids.')')) {
			    printAjaxSuccess('修改管理组成功！');
			}
		}

		printAjaxError('fail', '修改管理组失败！');
	}

    public function delete() {
    	checkPermissionAjax("{$this->_template}_delete");
	    $ids = $this->input->post('ids', TRUE);
	    //购物车
	    $this->load->model('Cart_model', '', TRUE);
	    if ($this->Cart_model->rowCount("user_id in ({$ids})")) {
	        printAjaxError('fail', '购物车存在关联数据，删除失败！');
	    }
	    //退换货
	    $this->load->model('Exchange_model', '', TRUE);
	    if ($this->Exchange_model->rowCount("user_id in ({$ids})")) {
	        printAjaxError('fail', '退换货存在关联数据，删除失败！');
	    }
	    //订单
	    $this->load->model('Orders_model', '', TRUE);
	    if ($this->Orders_model->rowCount("user_id in ({$ids})")) {
	        printAjaxError('fail', '订单存在关联数据，删除失败！');
	    }
	    //投诉问题
//	    $this->load->model('Problem_model', '', TRUE);
//	    if ($this->Problem_model->rowCount("user_id in ({$ids})")) {
//	        printAjaxError('fail', '投诉存在关联数据，删除失败！');
//	    }
	    if (! empty($ids)) {
	        if ($this->User_model->delete('id in ('.$ids.')')) {
	        	//浏览
	        	$this->load->model('Product_browse_model', '', TRUE);
	        	$this->Product_browse_model->delete("user_id in ({$ids})");
	        	//收藏
	        	$this->load->model('Product_favorite_model', '', TRUE);
	        	$this->Product_favorite_model->delete("user_id in ({$ids})");
	        	//收货地址
	        	$this->load->model('User_address_model', '', TRUE);
	        	$this->User_address_model->delete("user_id in ({$ids})");

	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('fail', '删除失败！');
	}

	public function validateUnique() {
		$username = $this->input->post('username', TRUE);
		if (! empty($username)) {
		    if ($this->User_model->validateUnique($username)) {
		        printAjaxError('fail', '用户名已经存在，请换个用户名！');
		    } else {
		        printAjaxSuccess('fail', '用户名可使用！');
		    }
		}
	}

    public function display() {
    	checkPermissionAjax("{$this->_template}_edit");
	    $ids = $this->input->post('ids');
		$display = $this->input->post('display');

		if (! empty($ids) && $display != "") {
			if($this->User_model->save(array('display'=>$display), 'id in ('.$ids.')')) {
			    printAjaxSuccess('', '修改状态成功！');
			}
		}

		printAjaxError('fail', '修改状态失败！');
	}

	//撤销用户
	public function delete_item() {
		checkPermissionAjax("{$this->_template}_delete_item");
		if ($_POST) {
			$id = $this->input->post('id');
			if (!$id) {
				printAjaxError('fail', '操作异常');
			}
			$userInfo = $this->User_model->get(array('user.id'=>$id));
			if (!$userInfo) {
				printAjaxError('fail', '此用户信息不存在');
			}
			if ($this->User_model->rowCount(array('presenter_id'=>$id))) {
				printAjaxError('fail', '存在关联数据，撤销失败');
			}
			$fields = array(
					'pop_code'=>'',
					'distributor_status_time'=>time(),
					'distributor_admin_remark'=>'管理员直接设置',
					'presenter_id'=>      0,
					'presenter_username'=>'',
					'remark_time'=>       0,
					'remark'=>            ''
			);
			if($this->User_model->save($fields, array('id'=>$id))) {
				if ($userInfo['distributor'] == 2 || $userInfo['school_distributor'] == 2 || $userInfo['net_distributor'] == 2) {
					$distributor = '';
					if ($userInfo['distributor'] == 2) {
						$distributor = 'distributor';
					} else if ($userInfo['school_distributor'] == 2) {
						$distributor = 'school_distributor';
					} else if ($userInfo['net_distributor'] == 2) {
						$distributor = 'net_distributor';
					}
					$fields = array(
							'pop_code'=>$this->_create_pop_code($id, $distributor, 2),
							'distributor_status_time'=>time(),
							'distributor_admin_remark'=>'管理员直接设置'
					);
					$this->User_model->save($fields, array('id'=>$id));
				}
				printAjaxSuccess('success', '操作成功');
			}

			printAjaxError('fail', '操作失败');
		}
	}

	public function get_city() {
		if ($_POST) {
			$parent_id = $this->input->post('parent_id', TRUE);
			$item_list = $this->Area_model->gets('id, name', array('parent_id'=>$parent_id, 'display'=>1));
			printAjaxData($item_list);
		}
	}

	public function user_login() {
		if ($_POST) {
			$username = trim($this->input->post('username', TRUE));
			$password = trim($this->input->post('password', TRUE));

			if(!$username || !$password) {
				printAjaxError('fail', '用户名或密码不能为空');
			}
			$item_info = $this->User_model->getInfo('id, user_type, username, password', array('username'=>$username));
			if (!$item_info) {
				printAjaxError('fail', '登录失败');
			}
			if ($item_info['user_type'] != 1) {
				printAjaxError('fail', '只有商家账号才能添加店铺');
			}
			if ($this->User_model->getPasswordSalt($username, $password) != $item_info['password']) {
				printAjaxError('fail', '登录失败');
			}
			unset($item_info['password']);
			printAjaxData(array('item_info'=>$item_info));
		}
	}
}
/* End of file admin.php */
/* Location: ./application/admin/controllers/admin.php */