<?php

class Purchase extends CI_Controller {

    private $_table = 'flash_sale';
    private $_template = 'purchase';

    public function __construct() {
        parent::__construct();
        $this->load->model('System_model', "", TRUE);
        $this->load->model('Postage_way_model', "", TRUE);
        $this->load->model('Postage_price_model', "", TRUE);
        $this->load->model('Product_model', "", TRUE);
        $this->load->model('Promotion_ptkj_model', "", TRUE);
        $this->load->model('Attachment_model', "", TRUE);
        $this->load->model('Area_model', "", TRUE);
        $this->load->model('Comment_model', "", TRUE);
        $this->load->model('Flash_sale_model', "", TRUE);
        $this->load->model('Free_postage_setting_model', "", TRUE);
        $this->load->model('Flash_sale_record_model', "", TRUE);
        $this->load->model('User_model', "", TRUE);
        $this->load->model('User_address_model', "", TRUE);
        $this->load->model('Orders_model', "", TRUE);
        $this->load->model('Orders_detail_model', "", TRUE);
        $this->load->model('Orders_process_model', "", TRUE);
        $this->load->library('Form_validation');
    }

    public function index() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $today = strtotime(date('Y-m-d'));
        $tomorrow = strtotime(date('Y-m-d 23:59:00')) + 24 * 60 * 60;
        $item_list = $this->Flash_sale_model->gets("start_time > $today and start_time <= $tomorrow and is_open = 1");
        foreach($item_list as $key=>$item){
           $productInfo = $this->Product_model->get('market_price,stock',array('id'=>$item['product_id']));
           $item_list[$key]['market_price'] = $productInfo['market_price'];
           $item_list[$key]['stock'] = $productInfo['stock'];
        }
        $today_list_am = array();
        $today_list_pm = array();
        $tomorrow_list_am = array();
        $tomorrow_list_pm = array();
        foreach ($item_list as $item) {
            if ($item['start_time'] < strtotime(date('Y-m-d 13:00:00'))) {
                $today_list_am[] = $item;
            }
            if ($item['start_time'] < strtotime(date('Y-m-d 21:00:00')) && $item['start_time'] > strtotime(date('Y-m-d 13:00:00'))) {
                $today_list_pm[] = $item;
            }
            if ($item['start_time'] < (strtotime(date('Y-m-d 13:00:00')) + 24 * 60 * 60) && $item['start_time'] > (strtotime(date('Y-m-d 08:00:00')) + 24 * 60 * 60)) {
                $tomorrow_list_am[] = $item;
            }
            if ($item['start_time'] < (strtotime(date('Y-m-d 21:00:00')) + 24 * 60 * 60) && $item['start_time'] > (strtotime(date('Y-m-d 13:00:00')) + 24 * 60 * 60)) {
                $tomorrow_list_pm[] = $item;
            }

        }
        //当前位置
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => '限时抢购',
            'keywords' => '限时抢购',
            'description' => '限时抢购',
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'today_list_am' => $today_list_am,
            'today_list_pm' => $today_list_pm,
            'tomorrow_list_am' => $tomorrow_list_am,
            'tomorrow_list_pm' => $tomorrow_list_pm,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/index", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function detail($flash_sale_id = null) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $flash_info = $this->Flash_sale_model->get('*', array('id' => $flash_sale_id));
        if (empty($flash_info)) {
            $data = array(
                'user_msg' => '不存在此限时抢购的商品',
                'user_url' => 'index.php'
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }

        $item_info = array();
        if ($flash_info) {
            $item_info = $this->Product_model->get("*", array('id' => $flash_info['product_id']));
        }
        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        if ($item_info) {
            $id = $item_info['id'];
            $colorList = $this->Product_model->getDetailColor($id);
            if ($colorList) {
                foreach ($colorList as $key => $value) {
                    $tmp_color_info = $this->Color_model->get('tips', array('id' => $value['color_id']));
                    if ($tmp_color_info) {
                        $colorList[$key]['tips'] = $tmp_color_info['tips'];
                    } else {
                        $colorList[$key]['tips'] = '';
                    }
                }
            }
            $sizeList = $this->Product_model->getDetailSize($id);
            if ($sizeList) {
                foreach ($sizeList as $key => $value) {
                    $tmp_size_info = $this->Size_model->get('tips', array('id' => $value['size_id']));
                    if ($tmp_size_info) {
                        $sizeList[$key]['tips'] = $tmp_size_info['tips'];
                    } else {
                        $sizeList[$key]['tips'] = '';
                    }
                }
            }
            $priceInfo = $this->Product_model->getPrice($id);
            if (!$priceInfo['min_price'] && !$priceInfo['max_price']) {
                $priceInfo['min_price'] = $item_info['sell_price'];
                $priceInfo['max_price'] = $item_info['sell_price'];
            }
            $comment_list = $this->Comment_model->gets('*', array('product_id' => $id));
            //配送方式
            $postage_way = $this->Postage_way_model->gets('*', array('display' => 1));
        }
               //包邮设置开启
        $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
       if ((1 >= $free_postage_setting['product_number'] && $free_postage_setting['open_number_ac']==1) || ($flash_info['flash_sale_price'] >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price_ac']==1)) {
                $postage_price = '0.00';
                $postage_way = array(
                    0 => array(
                            'id' => 0,
                            'title' => '包邮',
                            'sort' => 0,
                            'content' => '满'.$free_postage_setting['free_postage_price'].'元包邮或满'.$free_postage_setting['product_number'].'件包邮',
                            'display' => 1 ,
                    )
                );
        }
        //是否全国包邮
        if($free_postage_setting['is_free_ac']==1){
                $postage_price = '0.00';
                $postage_way = array(
                    0 => array(
                            'id' => 0,
                            'title' => '全国包邮',
                            'sort' => 0,
                            'content' => '全国包邮',
                            'display' => 1 ,
                    )
                );
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => '限时抢购',
            'keywords' => '限时抢购',
            'description' => '限时抢购',
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info,
            'attachment_list' => $attachment_list,
            'colorList' => $colorList,
            'sizeList' => $sizeList,
            'parentId' => '80',
            'priceInfo' => $priceInfo,
            'comment_list' => $comment_list,
            'flash_info' => $flash_info,
            'id' => $flash_sale_id,
            'postage_way' => $postage_way,
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/detail", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function add_order() {
        if ($_POST) {
            if (!get_cookie('user_id')) {
                printAjaxError('go_login', '您还没有登录，请登录');
            }
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
            $size_id = $this->input->post('size_id', true);
            $color_id = $this->input->post('color_id', true);
            $id = $this->input->post('id', true);
            $flash_info = $this->Flash_sale_model->get('*', array('id' => $id));
            $size_info = $this->Size_model->get('*', array('id' => $size_id));
            $color_info = $this->Color_model->get('*', array('id' => $color_id));
            $postage_way = $this->Postage_way_model->get('*', array('display' => 1));
            $postage_template_id = $postage_way['id'];
            if (empty($color_info)) {
                printAjaxError('fail', '颜色id不存在');
            }
            if (empty($size_info)) {
                printAjaxError('fail', '尺码id不存在');
            }
            if (empty($flash_info)) {
                printAjaxError('fail', '无此限时抢购活动');
            }
            if (time() < $flash_info['start_time']) {
                printAjaxError('fail', '此限时抢购活动暂未开始，请耐心等待');
            }
            if (time() > $flash_info['end_time']) {
                printAjaxError('fail', '此限时抢购活动已过期！');
            }
            $systemInfo = $this->System_model->get('presenter_is_open', array('id' => 1));
            //判断用户是否下单
            if ($this->Flash_sale_record_model->get('id', array('user_id' => get_cookie('user_id'), 'start_time' => $flash_info['start_time'], 'end_time' => $flash_info['end_time'], 'flash_sale_id' => $flash_info['id']))) {
                printAjaxError('fail', '每人仅限购一件');
            }
            $UserAddressInfo = $this->User_address_model->get('*', array('user_id' => get_cookie('user_id'), 'default' => 1));
            if (!$UserAddressInfo) {
                printAjaxError('fail', '没有默认收货地址！');
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
            $postagePrice = 0;
            //分成
            $divide_total = 0;
            $divide_store_price = 0;
            $divide_school_total = 0;
            $divide_school_sub_price = 0;
            $divide_net_total = 0;
            $divide_net_sub_price = 0;
            $product_info = $this->Product_model->get('postage_way_id,path,id,title,stock,divide_total_xsms,divide_store_price_xsms,divide_school_total_xsms,divide_school_sub_price_xsms,divide_net_total_xsms,divide_net_sub_price_xsms', array('id' => $flash_info['product_id']));
            $stock_info = $this->Product_model->getProductStock($product_info['id'], $color_id, $size_id);
            if ($stock_info['stock'] <= 0) {
                printAjaxError('fail', '此尺码及颜色的商品已全部售罄');
            }
            //只有被推荐的顾客的购买才产生分成，城市合伙人、店级合伙人的购买不产生分成
            if ($systemInfo['presenter_is_open']) {
            	$divide_total = $product_info['divide_total_xsms'];
            	$divide_store_price = $product_info['divide_store_price_xsms'];
            	$divide_school_total = $product_info['divide_school_total_xsms'];
            	$divide_school_sub_price = $product_info['divide_school_sub_price_xsms'];
            	$divide_net_total =  $product_info['divide_net_total_xsms'];
            	$divide_net_sub_price  = $product_info['divide_net_sub_price_xsms'];
            }
            $distributor_info = get_distributor_info(get_cookie('user_id'));
            $discount = '0.00';
            //分销商购买
            if ($distributor_info[0]) {
                //城市合伙人
                if ($distributor_info[1] == 1) {
                    //拼团砍价购买
                    $discount = $product_info['divide_total_xsms'];
                }
                //店级合伙人
                else if ($distributor_info[1] == 2) {
                    //拼团砍价购买
                    $discount = $product_info['divide_store_price_xsms'];
                }
            }
            $area_info = $this->Area_model->get('name', array('id' => $province_id));
            if (!$area_info) {
            	printAjaxError('fail', '收货地址信息不存在');
            }
            $area_name = $area_info['name'];
            //包邮设置开启
            $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
            //是否全国包邮
            if($free_postage_setting['is_free_ac'] == 1){
            	$postagePrice = '0.00';
                $postage_template_id = 0;
            } else {
            	if ((1 >= $free_postage_setting['product_number'] && $free_postage_setting['open_number_ac'] == 1) || ($flash_info['flash_sale_price'] >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price_ac'] == 1)) {
            		$postagePrice = '0.00';
                    $postage_template_id = 0;
            	} else {
            		//判断用哪个快递－谁贵给谁的
            		$postagePrice = $this->advdbclass->get_postage_price($product_info['postage_way_id'], $area_name, 1);
            		$postage_template_id = $product_info['postage_way_id'];
            	}
            }
            $total = $flash_info['flash_sale_price'] + $postagePrice - $discount;
            $orderNumber = $this->advdbclass->get_unique_orders_number();
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
            	'discount_total'=>$discount,
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
                'order_type' => 2,
            	'divide_total' =>           $divide_type == 'distributor'?$divide_total:0,
                'divide_store_price' =>     $divide_type == 'distributor'?$divide_store_price:0,
                'divide_school_total' =>    $divide_type == 'school_distributor'?$divide_school_total:0,
                'divide_school_sub_price' =>$divide_type == 'school_distributor'?$divide_school_sub_price:0,
            	'divide_net_total' =>       $divide_type == 'net_distributor'?$divide_net_total:0,
            	'divide_net_sub_price' =>   $divide_type == 'net_distributor'?$divide_net_sub_price:0,
            	'divide_user_id_1'=>       $divide_user_id_1,
            	'divide_user_id_2'=>       $divide_user_id_2,
            	'divide_type'=>$divide_type,
                'postage_template_id' => $postage_template_id
            );
            //添加订单
            $ret = $this->Orders_model->save($fields);
            if ($ret) {
                /*                 * **************************添加订单详细信息*********************** */
                $detailFields = array(
                    'order_id' => $ret,
                    'product_id' => $product_info['id'],
                    'product_num' => '',
                    'product_title' => $product_info['title'],
                    'buy_number' => 1,
                    'buy_price' => $flash_info['flash_sale_price']-$discount,
                	'old_price' => $flash_info['flash_sale_price'],
                    'size_name' => $size_info['size_name'],
                    'size_id' => $size_id,
                    'color_name' => $color_info['color_name'],
                    'color_id' => $color_id,
                    'path' => $product_info['path'],
                	'divide_total' =>           $product_info['divide_total_xsms'],
                	'divide_store_price' =>     $product_info['divide_store_price_xsms'],
                	'divide_school_total'=>     $product_info['divide_school_total_xsms'],
                	'divide_school_sub_price'=> $product_info['divide_school_sub_price_xsms'],
                	'divide_net_total'=>        $product_info['divide_net_total_xsms'],
                	'divide_net_sub_price'=>    $product_info['divide_net_sub_price_xsms']
                );
                if (!$this->Orders_detail_model->save($detailFields)) {
                    //删除已经添加进去的数据，保持数据统一性
                    $this->Orders_model->delete(array('id' => $ret, 'user_id' => get_cookie('user_id')));
                    printAjaxError('fail', '订单提交失败');
                }
                $data = array(
                    'user_id' => get_cookie('user_id'),
                    'start_time' => $flash_info['start_time'],
                    'end_time' => $flash_info['end_time'],
                    'flash_sale_id' => $flash_info['id'],
                    'order_id' => $ret,
                    'add_time' => time(),
                );
                $this->Flash_sale_record_model->save($data);
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

    //获取配送费用
    private function _getPostagewayPrice($postagewayId, $areaName) {
        $postagepriceInfo = $this->Postage_price_model->get('start_price, add_price', "postage_way_id = {$postagewayId} and (area like '{$areaName}%' or area like '%,{$areaName}' or area like '%,{$areaName},%')");
        if (!$postagepriceInfo) {
            $postagepriceInfo = $this->Postage_price_model->get('start_price, add_price', "postage_way_id = {$postagewayId} and area = '其它地区'");
        }
        return number_format($postagepriceInfo['start_price'], 2, '.', '');
    }

}
