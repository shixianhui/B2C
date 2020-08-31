<?php

class Cart extends CI_Controller {
	private $_product_type_arr = array(
			'a' => 'A类产品',
			'b' => 'B类产品',
			'c' => 'C类产品'
	    );
    public function __construct() {
        parent::__construct();
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Score_setting_model', '', TRUE);
        $this->load->model('Cart_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Payment_way_model', '', TRUE);
        $this->load->model('Postage_price_model', '', TRUE);
        $this->load->model('Postage_way_model', '', TRUE);
        $this->load->model('Free_postage_setting_model', '', TRUE);
        $this->load->model('Area_model', '', TRUE);
        $this->load->model('User_address_model', '', TRUE);
        $this->load->model('Product_favorite_model', '', TRUE);
        $this->load->library('Form_validation');
    }

    public function index() {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $cartList = $this->Cart_model->gets(array('cart.user_id' => get_cookie('user_id')));
        //近期热销商品
        $hotProductList = $this->Product_model->gets('*', "product.display = 1", 12, 0, 'product.sales');

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '购物车' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'cartList' => $cartList,
            'hotProductList' => $hotProductList
        );
        $layout = array(
            'content' => $this->load->view('cart/index', $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function confirm() {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $cart_ids = $this->input->post('cart_ids', TRUE);
        if (!$cart_ids) {
        	$data = array(
        			'user_msg' => '请选择结算商品',
        			'user_url' => base_url() . getBaseUrl(false, "cart.html", "cart.html", $systemInfo['client_index'])
        	);
        	$this->session->set_userdata($data);
        	redirect('/message/index');
        	exit;
        }
        //获取结算的商品
        $cart_ids = implode(',', $cart_ids);
        $userInfo = $this->User_model->get('*', array('id' => $user_id));
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $cartList = $this->Cart_model->gets("cart.user_id = {$user_id} and cart.id in ({$cart_ids}) ");
        if (!$cartList) {
            $data = array(
                'user_msg' => '您的购物车没有宝贝，快去选购宝贝哦！',
                'user_url' => base_url() . getBaseUrl(false, "", "cart.html", $systemInfo['client_index'])
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $areaList = $this->Area_model->gets('*', array('parent_id' => 0));
        //所有的收货地址
        $useraddressList = $this->User_address_model->gets('*', array('user_id' => $user_id));
        //配送方式
        $pay_way_str = '';//包邮描述
        $postage_way = NULL;
        $free = 0;//是否包邮
        $total = 0.00;//订单总金额
        $postage_price = 0;//快递费用
        $product_total = 0;//商品总金额
        $consume_score_total = 0;//积分换购积分总数量
        $product_number = 0;//商品数量
        $postage_way_ids = '';//商品的快递模板
        $area_name = '';//默认配送地区
        $silver_give_score = 0;
        $gold_give_score = 0;
        $use_deductible_score_gold = 0;//需付多少金象积分
        $use_deductible_score_silver = 0;//需付多少银象积分
        $default_user_address_info = NULL;
        if ($cartList) {
        	foreach ($cartList as $key=>$value) {
        		//银象积分
        		if ($value['product_type'] == 'a') {
        			$silver_give_score += $value['give_score'] * $value['buy_number'];
        		}
        		//金象积分
        		else {
        			$gold_give_score += $value['give_score'] * $value['buy_number'];
        		}
        		$postage_way_ids .= $value['postage_way_id'].',';
        		$product_number += $value['buy_number'];
        		$product_total += $value['sell_price'] * $value['buy_number'];
        		$consume_score_total += $value['consume_score'] * $value['buy_number'];
        		//金象积分-A类商品-需付多少金象积分
        		if ($value['product_type'] == 'a') {
        			$use_deductible_score_gold += $value['consume_score'] * $value['buy_number'];
        		}
        		//银象积分-B、C类商品-需付多少银象积分
        		else {
        			$use_deductible_score_silver += $value['consume_score'] * $value['buy_number'];
        		}
        	}
        }
        if ($postage_way_ids) {
        	$postage_way_ids = substr($postage_way_ids, 0, -1);
        }
        if ($useraddressList) {
        	foreach ($useraddressList as $ls) {
        		if ($ls['default'] == 1) {
        			$default_user_address_info = $ls;
        			$area_info = $this->Area_model->get('name', array('id' => $ls['province_id']));
        			if ($area_info) {
        				$area_name = $area_info['name'];
        			}
        		}
        	}
        }
        //包邮条件设置
        $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
        //是否全国包邮
        if($free_postage_setting['is_free'] == 1){
        	$postage_price = 0;
        	$free = 1;
        	$pay_way_str = '全国包邮';
        } else {
        	if (($product_number >= $free_postage_setting['product_number'] && $free_postage_setting['open_number']==1) || ($product_total >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price']==1)) {
        		$postage_price = 0;
        		$pay_way_str = '包邮（已满'.$free_postage_setting['product_number'].'件或已满'.$free_postage_setting['free_postage_price'].'元）';
        		$free = 1;
        	} else {
        		//判断用哪个快递－谁贵给谁的
        		$postage_way_list = $this->Postage_way_model->gets('*', "id in ({$postage_way_ids})");
        		if ($postage_way_list) {
        			$max_postage_price = 0;
        			$max_key = 0;
        			foreach ($postage_way_list as $key=>$value) {
        				$tmp_postage_price = $this->advdbclass->get_postage_price($value['id'], $area_name, $product_number);
        				if ($tmp_postage_price >$max_postage_price) {
        					$max_postage_price = $tmp_postage_price;
        					$max_key = $key;
        				}
        			}
        			$postage_price = $max_postage_price;
        			$postage_way[0] = $postage_way_list[$max_key];
        		}
        	}
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '订单信息' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'free_postage' => $systemInfo['free_postage'],
            'html' => $systemInfo['html'],
            'cartList' => $cartList,
            'areaList' => $areaList,
            'useraddressList' => $useraddressList,
        	'default_user_address_info'=>$default_user_address_info,
            'postage_price' => $postage_price,
        	'product_total'=>number_format($product_total, 2, '.', ''),
        	'total' => number_format($product_total+$postage_price, 2, '.', ''),
        	'consume_score_total'=>$consume_score_total,
        	'silver_give_score'=>$silver_give_score,
        	'gold_give_score'=>$gold_give_score,
            'cart_ids' => $cart_ids,
            'postage_way' => $postage_way,
        	'pay_way_str' => $pay_way_str,
            'free' => $free,
        	'use_deductible_score_gold'=>$use_deductible_score_gold,
        	'use_deductible_score_silver'=>$use_deductible_score_silver,
        	'product_type_arr'=>$this->_product_type_arr,
        	'userInfo'=>$userInfo
        );
        $layout = array(
            'content' => $this->load->view('cart/confirm', $data, TRUE)
        );
        $this->load->view('layout/cart_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //计算配送费用
    public function get_postage_price() {
    	checkLoginAjax();
        if ($_POST) {
        	$systemInfo = $this->System_model->get('*', array('id' => 1));
        	$address_id = $this->input->post('address_id', true);
        	$cart_ids = $this->input->post('cart_ids',true);
        	$use_score = $this->input->post('use_score',true);

        	$user_id = get_cookie('user_id');
        	$postage_template_id = 0;
        	$postage_template_name = '';//包邮描述
        	$free = 0;//是否包邮
        	$postage_price = 0;//快递费用
        	$product_total = 0;//商品总金额
        	$total = 0.00;//订单总金额
        	$consume_score_total = 0;//积分换购积分总数量
        	$product_number = 0;//商品数量
        	$postage_way_ids = '';//商品的快递模板
        	$area_name = '';//默认配送地区
        	$silver_give_score = 0;//银象积分
        	$gold_give_score = 0;//金象积分

        	if (!$address_id) {
        		printAjaxError('fail', '请选择收货地址');
        	}
        	if (!$cart_ids) {
        		printAjaxError('fail', '购物车中没有商品，请选购商品');
        	}
        	$user_address_info = $this->User_address_model->get('*', array('id'=> $address_id, 'user_id'=>$user_id));
        	if (!$user_address_info) {
        		printAjaxError('fail', '收货地址不存在');
        	}
			$user_address_info['txt_address'] = str_replace(' ', '', $user_address_info['txt_address']);
        	$area_info = $this->Area_model->get('name',array('id'=>$user_address_info['province_id']));
        	if (!$area_info) {
        		printAjaxError('fail', '收货地址不存在');
        	}
        	$area_name = $area_info['name'];
        	$cart_list = $this->Cart_model->gets("cart.user_id = {$user_id} and cart.id in ({$cart_ids})");
        	if ($cart_list) {
        		foreach ($cart_list as $key=>$value) {
        			//银象积分
        			if ($value['product_type'] == 'a') {
        				$silver_give_score += $value['give_score'] * $value['buy_number'];
        			}
        			//金象积分
        			else {
        				$gold_give_score += $value['give_score'] * $value['buy_number'];
        			}
        			$postage_way_ids .= $value['postage_way_id'].',';
        			$product_number += $value['buy_number'];
        			$product_total += $value['sell_price'] * $value['buy_number'];
        			$consume_score_total += $value['consume_score'] * $value['buy_number'];
        		}
        	}
        	if ($postage_way_ids) {
        		$postage_way_ids = substr($postage_way_ids, 0, -1);
        	}
        	//包邮条件设置
        	$free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
        	//是否全国包邮
        	if($free_postage_setting['is_free'] == 1){
        		$postage_price = 0;
        		$free = 1;
        		$postage_template_id = 0;
        		$postage_template_name = '全国包邮';
        	} else {
        		if (($product_number >= $free_postage_setting['product_number'] && $free_postage_setting['open_number']==1) || ($product_total >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price']==1)) {
        			$postage_price = 0;
        			$postage_template_id = 0;
        			$postage_template_name = '包邮（已满'.$free_postage_setting['product_number'].'件或已满'.$free_postage_setting['free_postage_price'].'元）';
        			$free = 1;
        		} else {
        			//判断用哪个快递－谁贵给谁的
        			$postage_way_list = $this->Postage_way_model->gets('*', "id in ({$postage_way_ids})");
        			if ($postage_way_list) {
        				$max_postage_price = 0;
        				$max_key = 0;
        				foreach ($postage_way_list as $key=>$value) {
        					$tmp_postage_price = $this->advdbclass->get_postage_price($value['id'], $area_name, $product_number);
        					if ($tmp_postage_price >$max_postage_price) {
        						$max_postage_price = $tmp_postage_price;
        						$max_key = $key;
        					}
        				}
        				$postage_price = $max_postage_price;
        				$tmp_postage_way = $postage_way_list[$max_key];
        				$postage_template_id = $tmp_postage_way['id'];
        				$postage_template_name = $tmp_postage_way['title'];
        			}
        		}
        	}
        	if ($use_score) {
        		$total = number_format($postage_price, 2, '.', '');
        		$silver_give_score = 0;
        		$gold_give_score = 0;
        	} else {
        		$total = number_format($product_total+$postage_price, 2, '.', '');
        	}

        	$data = array(
        			'postage_price' => number_format($postage_price, 2, '.', ''),
        			'product_total'=>number_format($product_total, 2, '.', ''),
        			'total' => $total,
        			'consume_score_total'=>$consume_score_total,
        			'silver_give_score'=>$silver_give_score,
        			'gold_give_score'=>$gold_give_score,
        			'postage_template_id'=>$postage_template_id,
        			'postage_template_name' => $postage_template_name,
        			'free' => $free,
        			'user_address_info'=>$user_address_info
        	    );
            printAjaxData($data);
        }
    }

    //不用了
    public function cal_postage() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        checkLogin();
        $address_id = $this->input->post('address_id', true);
        $postage_template_id = $this->input->post('postage_template_id', true);
        $cart_ids = $this->input->post('cart_ids',true);
        $product_number = 1;
        if($cart_ids){
           $product_number = $this->Cart_model->rowSum("id in ($cart_ids)");
        }
        if (empty($address_id)) {
            printAjaxError('fail', '请收货地址');
        }
         if (empty($postage_template_id)) {
            printAjaxError('fail', '请选择配送方式');
        }
        $address = $this->User_address_model->get('*', array('id' => $address_id));
        if (empty($address)) {
            printAjaxError('fail', '不存在此收货地址');
        }
        $province = $this->Area_model->get('name',array('id'=>$address['province_id']));
        $postage_price = $this->advdbclass->_getPostagewayPrice($postage_template_id,$province['name'],$product_number);
        printAjaxData(array('postage_price' => $postage_price));
    }

    public function add() {
    	if (! get_cookie('user_id')) {
    		printAjaxError('go_login', '您还没有登录，请登录');
    	}
    	if ($_POST) {
    		$product_id = $this->input->post('product_id');
    		$color_id = $this->input->post('color_id', TRUE);
    		$size_id = $this->input->post('size_id', TRUE);
    		$buy_number = $this->input->post('buy_number');
    		$buy_type = $this->input->post('buy_type');

    		$color_name = '';
    		$size_name = '';
    		$sell_price = '';
    		if (! $this->form_validation->required($product_id)) {
    			printAjaxError('fail', '操作异常，刷新页面重试');
    		}
    		$item_info = $this->Product_model->get('stock, sell_price, color_size_open, product_color_name, product_size_name', array('id'=>$product_id, 'display'=>1));
    		if (! $item_info) {
    			printAjaxError('fail', '此商品不存在或被删除');
    		}
    		if ($item_info['color_size_open']) {
	    		if (! $this->form_validation->required($color_id)) {
	    			printAjaxError('fail', '请选择'.$item_info['product_color_name']);
	    		}
	    		$color_list = $this->Product_model->getDetailColor($product_id);
	    		if ($color_list) {
	    			foreach ($color_list as $key=>$value) {
	    				if ($value['color_id'] == $color_id) {
	    					$color_name = $value['color_name'];
	    					break;
	    				}
	    			}
	    		}
	    		if (! $color_name) {
	    			printAjaxError('fail', '此'.$item_info['product_color_name'].'不存在');
	    		}
	    		if (! $this->form_validation->required($size_id)) {
	    			printAjaxError('fail', '请选择'.$item_info['product_size_name']);
	    		}
	    		$sizeList = $this->Product_model->getDetailSize($product_id);
	    		if ($sizeList) {
	    			foreach ($sizeList as $key=>$value) {
	    				if ($value['size_id'] == $size_id) {
	    					$size_name = $value['size_name'];
	    				}
	    			}
	    		}
	    		if (!$size_name) {
	    			printAjaxError('fail', '此'.$item_info['product_size_name'].'不存在');
	    		}
    		}
    		if (! $this->form_validation->integer($buy_number)) {
    			printAjaxError('fail', '请填写正确的购买数量');
    		}
    		if ($buy_number < 1) {
    			printAjaxError('fail', '购买数量必须大于零');
    		}
    		//有规格的产品
    		if ($item_info['color_size_open']) {
    			$product_stock_info = $this->Product_model->getProductStock($product_id, $color_id, $size_id);
    			if (!$product_stock_info) {
    				printAjaxError('fail', '没有此规格的商品');
    			}
    			$sell_price = $product_stock_info['price'];
    			if ($buy_number > $product_stock_info['stock']) {
    				printAjaxError('fail', '购买数量不能大于库存');
    			}
    		} else {
    			//没有规格的产品
    			$color_id = 0;
    			$size_id = 0;
                $sell_price = $item_info['sell_price'];
    			//没有规格的产品
    			if ($buy_number > $item_info['stock']) {
    				printAjaxError('fail', '购买数量不能大于库存');
    			}
    		}

    		$strWhere = array(
    				'user_id'=>    get_cookie('user_id'),
    				'product_id'=> $product_id,
    				'size_id'=>    $size_id,
    				'color_id'=>   $color_id
    		);
    		$cartInfo = $this->Cart_model->get('buy_number,id', $strWhere);
    		//已购买的
    		if ($cartInfo) {
    			$edit_fields = array(
    					'buy_number'=>$buy_number+$cartInfo['buy_number']
    			);
    			//是否为立即购买
    			if ($buy_type) {
    				$edit_fields = array(
    						'buy_number'=>$buy_number
    				);
    			}
    			if ($this->Cart_model->save($edit_fields, $strWhere)) {
    				$cart_count = $this->Cart_model->rowSum(array('user_id'=>get_cookie('user_id')));
    				printAjaxData(array('cart_count'=>$cart_count, 'cart_id'=>$cartInfo['id']));
    			} else {
    				printAjaxError('fail', '加入购物车失败');
    			}
    		} else {//第一次购买的
    			$fields = array(
    					'user_id'=>    get_cookie('user_id'),
    					'product_id'=> $product_id,
    					'size_name'=>  $size_name,
    					'size_id'=>    $size_id,
    					'color_name'=> $color_name,
    					'color_id'=>   $color_id,
    					'buy_number'=> $buy_number,
    					'sell_price'=> $sell_price
    			);
    			$ret_id = $this->Cart_model->save($fields);
    			if ($ret_id) {
    				$cart_count = $this->Cart_model->rowSum(array('user_id'=>get_cookie('user_id')));
    				printAjaxData(array('cart_count'=>$cart_count, 'cart_id'=>$ret_id));
    			} else {
    				printAjaxError('fail', '加入购物车失败');
    			}
    		}
    	}
    }

    //修改数量
    public function change_buy_number() {
    	checkLoginAjax();
    	if ($_POST) {
    		$buy_number = $this->input->post('buy_number', TRUE);
    		$cart_id = $this->input->post('cart_id', TRUE);
    		$ids = $this->input->post('ids', TRUE);
    		$user_id = get_cookie('user_id');

    		if (!$buy_number || !$cart_id) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}
    		$item_info = $this->Cart_model->get2(array("cart.id" => $cart_id));
    		if (!$item_info) {
    			printAjaxError('fail', '修改信息不存在，刷新重试');
    		}
    		if ($item_info['color_size_open']) {
    			//有规格的商品
    			$product_stock_info = $this->Product_model->getProductStock($item_info['product_id'], $item_info['color_id'], $item_info['size_id']);
    			if (!$product_stock_info) {
    				printAjaxError('fail', '没有此规格的商品，请删除');
    			}
    			if ($buy_number > $product_stock_info['stock']) {
    				printAjaxError('fail', "此款商品库存不足，库存为：{$product_stock_info['stock']}");
    			}
    		} else {
    			if ($buy_number > $item_info['stock']) {
    				printAjaxError('fail', "此款商品库存不足，库存为：{$item_info['stock']}");
    			}
    		}
    		if (!$this->Cart_model->save(array('buy_number' => $buy_number), array('id' => $cart_id, 'user_id'=>$user_id))) {
    			printAjaxError('fail', '数量修改失败');
    		}

    		printAjaxData($this->_select_cart_info($user_id, $ids));
    	}
    }

    //删除商品
    public function delete_cart_product() {
        checkLoginAjax();
        if ($_POST) {
        	$select_ids = $this->input->post('select_ids', TRUE);
            $delete_ids = $this->input->post('delete_ids', TRUE);
            $user_id = get_cookie('user_id');

            if (!$delete_ids) {
                printAjaxError('fail', '操作异常，刷新重试');
            };
            if (!$this->Cart_model->delete("id in ({$delete_ids}) and user_id = {$user_id} ")) {
                printAjaxError('fail', '删除失败');
            }

            printAjaxData($this->_select_cart_info($user_id, $select_ids));
        }
    }

    //批量删除商品
    public function batch_delete_cart_product() {
    	checkLoginAjax();
    	if ($_POST) {
    		$delete_ids = $this->input->post('delete_ids', TRUE);
    		$user_id = get_cookie('user_id');

    		if (!$delete_ids) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		};
    		if (!$this->Cart_model->delete("id in ({$delete_ids}) and user_id = {$user_id} ")) {
    			printAjaxError('fail', '删除失败');
    		}

    		printAjaxData($this->_select_cart_info($user_id, ''));
    	}
    }

    //删除收货地址-用不到
    public function delAddress() {
        checkLoginAjax();
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            if (!$id) {
                printAjaxError('fail', '操作异常');
            }

            if ($this->User_address_model->delete(array('id' => $id, 'user_id' => get_cookie('user_id')))) {
                printAjaxData(array('id' => $id));
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }

    //设置默认收货地址-用不到
    public function setDefault() {
        checkLoginAjax();
        if ($_POST) {
            $ret = 0;
            $id = $this->input->post('id', TRUE);
            if (!$id) {
                printAjaxError('fail', '操作异常');
            }
            $userId = get_cookie('user_id');
            if ($this->User_address_model->save(array('default' => 0), "id <> {$id} and user_id = {$userId}")) {
                if ($this->User_address_model->save(array('default' => 1), array('id' => $id, 'user_id' => $userId))) {
                    $ret = 1;
                }
            }
            if ($ret) {
                printAjaxSuccess('success', '设置成功');
            } else {
                printAjaxError('fail', '设置失败');
            }
        }
    }

    //编辑收货地址-用不到
    public function editDelivery() {
        $id = $this->input->post('id', TRUE);
        $useraddressInfo = $this->User_address_model->get('*', array('id' => $id, 'user_id' => get_cookie('user_id')));
        if ($useraddressInfo) {
            printAjaxData($useraddressInfo);
        }
    }

    //移入收藏夹
    public function move_product_to_favorite() {
    	checkLoginAjax();
    	if ($_POST) {
    		$select_ids = $this->input->post('select_ids', TRUE);
    		$cart_id = $this->input->post('cart_id', TRUE);
    		$user_id = get_cookie('user_id');

    		if (!$cart_id) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		};
    		$item_info = $this->Cart_model->get('product_id', array('id'=>$cart_id));
    		if (!$item_info) {
    			printAjaxError('fail', '删除信息不存在');
    		}
    		if (!$this->Cart_model->delete("id in ({$cart_id}) and user_id = {$user_id} ")) {
    			printAjaxError('fail', '删除失败');
    		}
    		//收藏
    		if (!$this->Product_favorite_model->rowCount(array('user_id'=>$user_id, 'product_id'=>$item_info['product_id']))) {
    			$fields = array(
    					'user_id'=>$user_id,
    					'product_id'=>$item_info['product_id'],
    					'add_time'=>time()
    			);
    			$this->Product_favorite_model->save($fields);
    		}

    		printAjaxData($this->_select_cart_info($user_id, $select_ids));
    	}
    }

    //获取选定商品信息
    public function get_select_cart_info() {
    	checkLoginAjax();
    	if ($_POST) {
    		$user_id = get_cookie('user_id');
    		$ids = $this->input->post('ids', TRUE);

    		printAjaxData($this->_select_cart_info($user_id, $ids));
    	}
    }
	
	//编辑收货地址
    public function save_address($id = NULL) {
        checkLoginAjax();
        if ($_POST) {
            $buyer_name = $this->input->post('buyer_name', TRUE);
            $mobile = $this->input->post('mobile', TRUE);
            $phone = $this->input->post('phone', TRUE);
            $zip = $this->input->post('zip', TRUE);
			$email = $this->input->post('email', TRUE);
            $province_id = $this->input->post('province_id', TRUE);
            $city_id = $this->input->post('city_id', TRUE);
            $area_id = $this->input->post('area_id', TRUE);
            $address = $this->input->post('address', TRUE);
            $default = $this->input->post('default', TRUE);

            if (!$buyer_name) {
                printAjaxError('buyer_name', '请输入收货人姓名');
            }
            if (!$mobile) {
                printAjaxError('mobile', '请输入手机号');
            }
			if (!preg_match("/^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/", $mobile)) {
	            printAjaxError('mobile', '请输入正确的手机号');
	        }
			if ($phone) {
				if (!preg_match("/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/", $phone)) {
	                printAjaxError('phone', '请输入正确的固定电话');
	            }
			}
            if (!$province_id) {
                printAjaxError('province_id', '选择省');
            }
            if (!$city_id) {
                printAjaxError('city_id', '选择市');
            }
            if (!$address) {
                printAjaxError('address', '请填写详细地址');
            }
            $txt_address_str = '';
            $area_info = $this->Area_model->get('name', array('id' => $province_id));
            if ($area_info) {
                $txt_address_str .= $area_info['name'];
				$area_info = $this->Area_model->get('name', array('id' => $city_id));
	            if ($area_info) {
	                $txt_address_str .= ' ' . $area_info['name'];
					$area_info = $this->Area_model->get('name', array('id' => $area_id));
		            if ($area_info) {
		                $txt_address_str .= ' ' . $area_info['name'];
		            }
	            }
            }
			if ($zip && !preg_match("/^[1-9]\d{5}$/", $zip)) {
                printAjaxError('zip', '请输入正确的邮编');
            }
			if ($email && !preg_match("/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/", $email)) {
                printAjaxError('email', '请输入正确的邮箱');
            }
			
            $fields = array(
                'buyer_name' => $buyer_name,
                'mobile' => $mobile,
                'phone' => $phone,
                'zip' => $zip,
                'province_id' => $province_id,
                'city_id' => $city_id,
                'area_id' => $area_id,
                'txt_address' => $txt_address_str,
                'address' => $address,
                'default' => $default,
                'email'=> $email,
                'user_id' => get_cookie('user_id'),
            );
            //当收货地址为一个时，设为默认
            if ($this->User_address_model->rowCount(array('user_id' => get_cookie('user_id'))) == 0) {
                $fields['default'] = 1;
            }
            if ($this->User_address_model->rowCount(array('user_id' => get_cookie('user_id'))) > 10) {
                printAjaxError('fail', '最多只能设置十个收货地址');
            }
            if ($default == 1) {
                $this->User_address_model->save(array('default' => 0), array('user_id' => get_cookie('user_id'), 'default' => 1));
            }
			$ret_id = $this->User_address_model->save($fields, $id ? array('id' => $id) : NULL);
            if (!$ret_id) {
                printAjaxError('fail', '收货地址操作失败');
            }
			$item_info = $this->User_address_model->get('*', array('id'=>$id?$id:$ret_id));
			printAjaxData($item_info);
        }
    }

    public function get_city() {
        if ($_POST) {
            $parent_id = $this->input->post('parent_id', TRUE);
            $item_list = $this->Area_model->gets('id, name', array('parent_id' => $parent_id, 'display' => 1));
            printAjaxData($item_list);
        }
    }
	
	//获取用户地址
    public function get_user_address() {
    	checkLoginAjax();
    	if ($_POST) {
    		$user_id = get_cookie('user_id');
	    	$id = $this->input->post('id', TRUE);

	    	$item_info = $this->User_address_model->get('*', array('id' => $id, 'user_id' => $user_id));
	    	if (!$item_info) {
	    		printAjaxError('fail','此收货地址不存在');
	    	}
	    	printAjaxData($item_info);
    	}
    }

    private function _select_cart_info($user_id = NULL, $ids = '') {
    	//优惠
    	$discount_total = 0;
    	//商品
    	$product_total = 0;
    	//金象积分
    	$gold_score_total = 0;
    	//银象积分
    	$silver_score_total = 0;
    	//总金额
    	$total = 0;
    	//选定数量
    	$select_num = 0;
    	if ($ids) {
    		$cart_list = $this->Cart_model->gets("cart.id in ({$ids}) and cart.user_id = {$user_id}");
    		if ($cart_list) {
    			foreach ($cart_list as $cart) {
    				$select_num += $cart['buy_number'];
    				$product_total += $cart['buy_number']*$cart['sell_price'];
    				//银象积分
    				if ($cart['product_type'] == 'a') {
    					$silver_score_total += $cart['buy_number']*$cart['give_score'];
    				}
    				//金象积分
    				else {
    					$gold_score_total += $cart['buy_number']*$cart['give_score'];
    				}
    			}
    		}
    	}
    	$discount_total = number_format($discount_total, '2', '.', '');
    	$product_total = number_format($product_total, '2', '.', '');
    	$total = number_format($product_total - $discount_total, '2', '.', '');

    	return array('discount_total'=>$discount_total, 'silver_score_total'=>$silver_score_total, 'gold_score_total'=>$gold_score_total, 'product_total'=>$product_total, 'total'=>$total, 'select_num'=>$select_num);
    }
}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */