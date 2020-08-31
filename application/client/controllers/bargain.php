<?php

class Bargain extends CI_Controller {

    private $_table = 'bargain';
    private $_template = 'bargain';

    public function __construct() {
        parent::__construct();
        $this->load->model('System_model', "", TRUE);
        $this->load->model('Product_model', "", TRUE);
        $this->load->model('Promotion_ptkj_model', "", TRUE);
        $this->load->model('Attachment_model', "", TRUE);
        $this->load->model('Comment_model', "", TRUE);
        $this->load->model('Pintuan_model', "", TRUE);
        $this->load->model('Ptkj_record_model', "", TRUE);
        $this->load->model('Chop_record_model', "", TRUE);
        $this->load->model('Postage_way_model', "", TRUE);
        $this->load->model('User_address_model', "", TRUE);
        $this->load->model('User_model', "", TRUE);
        $this->load->model('Free_postage_setting_model', "", TRUE);
        $this->load->library('Form_validation');
    }

    public function index() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $current_time = time();
        $item_list = $this->Promotion_ptkj_model->gets("start_time <= $current_time and end_time > $current_time and is_open = 1");
        foreach ($item_list as $key => $item) {
            $product = $this->Product_model->get('sell_price,path,market_price', "id = {$item['product_id']}");
            $pintuan_rule = $this->Pintuan_model->gets("ptkj_id = {$item['id']}");
            $item_list[$key]['pintuan_price'] = $product['sell_price'];
            foreach ($pintuan_rule as $ls) {
                if ($item['pintuan_people'] >= $ls['low'] && $item['pintuan_people'] <= $ls['high']) {
                    $item_list[$key]['pintuan_price'] = $ls['money'];
                }
            }
            $item_list[$key]['sell_price'] = $product['sell_price'];
            $item_list[$key]['market_price'] = $product['market_price'];
            $item_list[$key]['path'] = $product['path'];
        }
        //当前位置
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => '拼团砍价',
            'keywords' => '拼团砍价',
            'description' => '拼团砍价',
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_list' => $item_list,
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

    public function detail($id = null) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $pintuan_info = $this->Promotion_ptkj_model->get('*', array('id' => $id));
        if (empty($pintuan_info)) {
            $data = array(
                'user_msg' => '不存在该参团活动',
                'user_url' => 'index.php'
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $timestamp = time();
        if ($timestamp > $pintuan_info['end_time'] || $timestamp < $pintuan_info['start_time']) {
            $data = array(
                'user_msg' => '该参团活动暂未开始或已结束',
                'user_url' => 'index.php'
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $item_info = array();
        if ($pintuan_info) {
            $item_info = $this->Product_model->get("*", array('id' => $pintuan_info['product_id']));
        }
        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        if ($item_info) {
            $id = $pintuan_info['product_id'];
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
        }
        $pintuan_rule = $this->Pintuan_model->gets(array('ptkj_id' => $pintuan_info['id']));
        $button_str = '我要参团';
        $info = $this->Ptkj_record_model->get(array('ptkj_record.ptkj_id'=>$pintuan_info['id'],'ptkj_record.user_id'=>get_cookie('user_id')));
        $gourl = '';
        if($info){
            $button_str = '去砍价';
            $gourl = base_url().'index.php/bargain/chop_price/'.$info['id'].'?sign='.md5('mykey'.$info['id']);
        }
        //配送方式
            $postage_way = $this->Postage_way_model->gets('*', array('display' => 1));
            $pintuan_price = $pintuan_info['high_price'];
            foreach ($pintuan_rule as $ls) {
                $arr[] = $ls['money'];
                if ($pintuan_info['pintuan_people'] >= $ls['low'] && $pintuan_info['pintuan_people'] <= $ls['high']) {
                    $pintuan_price = number_format($ls['money'], 2);
                }
            }
              //包邮设置开启
        $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
       if ((1 >= $free_postage_setting['product_number'] && $free_postage_setting['open_number_ac']==1) || ($pintuan_price['flash_sale_price'] >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price_ac']==1)) {
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
        //当前位置
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => '拼团砍价',
            'keywords' => '拼团砍价',
            'description' => '拼团砍价',
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
            'pintuan_info' => $pintuan_info,
            'pintuan_rule' => $pintuan_rule,
            'button_str'=> $button_str,
            'gourl' => $gourl,
            'postage_way' => $postage_way,
            'pintuan_price' => $pintuan_price
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

    public function group_purchase() {
        if ($_POST) {
            if (!get_cookie('user_id')) {
                printAjaxError('go_login', '您还没有登录，请登录');
            }
            $product_id = $this->input->post('product_id');
            $color_id = $this->input->post('color_id', TRUE);
            $size_id = $this->input->post('size_id', TRUE);
            $buy_number = $this->input->post('buy_number');
            $ptkj_id = $this->input->post('ptkj_id');

            if (!$this->form_validation->required($product_id)) {
                printAjaxError('fail', '操作异常，刷新页面重试');
            }
            $product_info = $this->Product_model->get('title', array('id' => $product_id, 'display' => 1));
            if (!$product_info) {
                printAjaxError('fail', '此产品不存在或被删除');
            }
            if (!$this->form_validation->required($color_id)) {
                printAjaxError('fail', '请选择' . getColorName(0));
            }
            $color_name = '';
            $colorList = $this->Product_model->getDetailColor($product_id);
            if ($colorList) {
                foreach ($colorList as $key => $value) {
                    if ($value['color_id'] == $color_id) {
                        $color_name = $value['color_name'];
                        break;
                    }
                }
            }
            if (!$color_name) {
                printAjaxError('fail', '此' . getColorName(0) . '不存在');
            }
            if (!$this->form_validation->required($size_id)) {
                printAjaxError('fail', '请选择' . getSizeName(0));
            }
            $size_name = '';
            $sizeList = $this->Product_model->getDetailSize($product_id);
            if ($sizeList) {
                foreach ($sizeList as $key => $value) {
                    if ($value['size_id'] == $size_id) {
                        $size_name = $value['size_name'];
                    }
                }
            }
            if (!$size_name) {
                printAjaxError('fail', '此' . getSizeName(0) . '不存在');
            }
            if (!$this->form_validation->integer($buy_number)) {
                printAjaxError('fail', '请填写正确的购买数量');
            }
            if ($buy_number < 1) {
                printAjaxError('fail', '购买数量必须大于零');
            }
            $item_info = $this->Product_model->getProductStock($product_id, $color_id, $size_id);
            if ($buy_number > $item_info['stock']) {
                printAjaxError('fail', '购买数量不能大于库存');
            }
            $pintuan_info = $this->Promotion_ptkj_model->get('*', array('id' => $ptkj_id));
            if (empty($pintuan_info)) {
                printAjaxError('fail', '没有此项参团活动');
            }
            if (time() > $pintuan_info['end_time'] || time() < $pintuan_info['start_time']) {
                printAjaxError('fail', '参团活动暂未开始或已结束');
            }
            $exist = $this->Ptkj_record_model->get(array('user_id' => get_cookie('user_id'), 'ptkj_id' => $ptkj_id));
            if ($exist) {
                printAjaxError('already', base_url() . 'index.php/bargain/chop_price/' . $exist['id'] . '?sign=' . md5('mykey' . $exist['id']));
            }
            $fields_data = array(
                'user_id' => get_cookie('user_id'),
                'ptkj_id' => $ptkj_id,
                'product_title' => $product_info['title'],
                'product_id' => $product_id,
                'size_name' => $size_name,
                'color_name' => $color_name,
                'size_id' => $size_id,
                'color_id' => $color_id,
                'buy_number' => $buy_number,
                'add_time' => time(),
            );
            $retId = $this->Ptkj_record_model->save($fields_data);
            if ($retId) {
                $this->Promotion_ptkj_model->save(array('pintuan_people' => $pintuan_info['pintuan_people'] + 1), array('id' => $ptkj_id));
                $count = 0;
                //砍价总金额
                $total = $pintuan_info['cut_total_money'];
                // 砍价分成n次，支持n人随机砍
                $num = $pintuan_info['cut_times'];
                //每个人最少能砍0.01元
                $min = 0.01;
                for ($i = 1; $i < $num; $i++) {
                    //随机安全上限
                    $safe_total = ($total - ($num - $i) * $min) / ($num - $i);
                    $money = mt_rand($min * 100, $safe_total * 100) / 100;
                    $total = $total - $money;
                    $data = array(
                        'user_id' => get_cookie('user_id'),
                        'nickname' => get_cookie('user_username'),
                        'chop_price' => $money,
                        'ptkj_record_id' => $retId,
                    );
                    if ($this->Chop_record_model->save($data)) {
                        $count++;
                    }
                }
                $data['chop_price'] = $total;
                if ($this->Chop_record_model->save($data)) {
                    $count++;
                }
                //失败回滚
                if ($count != $num) {
                    $this->Chop_record_model->delete(array('user_id' => get_cookie('user_id'), 'ptkj_record_id' => $retId));
                    $this->Ptkj_record_model->delete(array('id' => $retId));
                    printAjaxError('error', '参团失败');
                }

                printAjaxSuccess(base_url() . 'index.php/bargain/chop_price/' . $retId . '?sign=' . md5('mykey' . $retId), '参团成功');
            } else {
                printAjaxError('error', '参团失败');
            }
        }
    }

    public function chop_price($ptkj_record_id = '') {
        if (is_mobile_request()) {
            $sign = $this->input->get('sign', true);
            $url = base_url() . getBaseUrl(false, "", "join/chop_price/{$ptkj_record_id}?sign={$sign}", 'weixin.php');
            redirect("{$url}");
            exit;
        } else {
            $distributor_info = get_distributor_info(get_cookie('user_id'));
            $this->session->set_userdata('gloabPreUrl', $_SERVER['REQUEST_URI']);
            $systemInfo = $this->System_model->get('*', array('id' => 1));
            $sign = $this->input->get('sign', true);
            if (md5('mykey' . $ptkj_record_id) !== $sign) {
                $data = array(
                    'user_msg' => 'sign参数不正确',
                    'user_url' => 'index.php'
                );
                $this->session->set_userdata($data);
                redirect('/message/index');
            }
            $ptkj_record = $this->Ptkj_record_model->get(array('ptkj_record.id ' => $ptkj_record_id));
            $item_info = array();
            $pintuan_count = 0;
            if ($ptkj_record) {
                $item_info = $this->Product_model->get("*", array('id' => $ptkj_record['product_id']));
                $pintuan_count = $this->Ptkj_record_model->rowCount(array('ptkj_id' => $ptkj_record['ptkj_id']));
                $pintuan_info = $this->Promotion_ptkj_model->get('*', array('id' => $ptkj_record['ptkj_id']));
                $pintuan_rule = $this->Pintuan_model->gets(array('ptkj_id' => $ptkj_record['ptkj_id']));
                $chop_arr = $this->Chop_record_model->get('sum(chop_price) as sum', "user_id = {$ptkj_record['user_id']} and ptkj_record_id = $ptkj_record_id and chop_user_id is not null");
                $choped_price = $chop_arr['sum'] ? $chop_arr['sum'] : '0.00';
                $chop_record = $this->Chop_record_model->gets('*', "user_id = {$ptkj_record['user_id']} and ptkj_record_id = {$ptkj_record_id} and chop_user_id is not null");
            }
            $attachment_list = NULL;
            if ($item_info && $item_info['batch_path_ids']) {
                $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
                $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
            }
            $pintuan_price = 0;
             foreach ($pintuan_rule as $ls) {
                                $arr[] = $ls['money'];
                                if ($pintuan_count >= $ls['low'] && $pintuan_count <= $ls['high']) {
                                    $pintuan_price = number_format($ls['money'],2);
                                }
                            }
               $total_money = $pintuan_price - $choped_price;
            //配送方式
            $postage_way = $this->Postage_way_model->gets('*', array('display' => 1));
            //包邮设置开启
        $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
       if (($ptkj_record['buy_number'] >= $free_postage_setting['product_number'] && $free_postage_setting['open_number_ac']==1) || ($total_money >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price_ac']==1)) {
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
            $useraddressList = $this->User_address_model->gets('*', array('user_id' => get_cookie('user_id')));
            //将默认地址放在开头
            foreach ($useraddressList as $key => $ls) {
                if ($ls['default'] == 1) {
                    unset($useraddressList[$key]);
                    array_unshift($useraddressList, $ls);
                }
            }
            $discount = '0.00';
            //分销商购买
        	if ($distributor_info[0]) {
        		//城市合伙人
        		if ($distributor_info[1] == 1) {
        			$discount = $item_info['divide_total_ptkj'];
        		}
        		//店级合伙人
        		else if ($distributor_info[1] == 2) {
        			$discount = $item_info['divide_store_price_ptkj'];
        		}
        	}
            //当前位置
            $data = array(
                'site_name' => $systemInfo['site_name'],
                'index_name' => $systemInfo['index_name'],
                'client_index' => $systemInfo['client_index'],
                'title' => '拼团砍价',
                'keywords' => '拼团砍价',
                'description' => '拼团砍价',
                'site_copyright' => $systemInfo['site_copyright'],
                'icp_code' => $systemInfo['icp_code'],
                'html' => $systemInfo['html'],
                'item_info' => $item_info,
                'attachment_list' => $attachment_list,
                'pintuan_count' => $pintuan_count,
                'ptkj_record' => $ptkj_record,
                'pintuan_info' => $pintuan_info,
                'pintuan_rule' => $pintuan_rule,
                'choped_price' => $choped_price,
                'chop_record' => $chop_record,
                'url' => base_url() . 'index.php/bargain/chop_price/' . $ptkj_record_id . '?sign=' . $sign,
                'title' => $item_info['title'],
                'pic' => $item_info['path'],
                'useraddressList' => $useraddressList,
                'postage_way' => $postage_way,
                'pintuan_price' => $pintuan_price,
                'total_money' => $total_money,
                'discount' => $discount,
            );
            $layout = array(
                'content' => $this->load->view("{$this->_template}/chop_price", $data, TRUE)
            );
            $this->load->view('layout/default', $layout);
            //缓存
            if ($systemInfo['cache'] == 1) {
                $this->output->cache($systemInfo['cache_time']);
            }
        }
    }

    public function chop() {
        if ($_POST) {
            $sign = $this->input->post('sign', true);
            $ptkj_record_id = $this->input->post('id', true);
            if (md5('mykey' . $ptkj_record_id) !== $sign) {
                printAjaxError('error', "sign参数不正确");
            }
            if (!get_cookie('user_id')) {
                printAjaxError('login', "您还没有登录，请登录!");
            }
            $ptkj_record = $this->Ptkj_record_model->get(array('ptkj_record.id ' => $ptkj_record_id));
            if (!$ptkj_record) {
                printAjaxError('error', "id错误");
            }
            if (time() > $ptkj_record['end_time']) {
                printAjaxError('error', "砍价活动已结束！");
            }
            if (get_cookie('user_id') == $ptkj_record['user_id']) {
                printAjaxError('error', "请朋友帮您砍，自已不可以砍哦,亲！");
            }
            if ($this->Chop_record_model->gets("*", "ptkj_record_id = $ptkj_record_id and user_id = {$ptkj_record['user_id']} and chop_user_id = " . get_cookie('user_id'))) {
                printAjaxError('error', "您已经砍过了，不可以再砍了，亲！");
            }
            $chop_arr = $this->Chop_record_model->gets("*", "ptkj_record_id = $ptkj_record_id and user_id = {$ptkj_record['user_id']} and chop_user_id is null");
            //砍价
            if (empty($chop_arr)) {
                printAjaxError('fail', "对不起，已经砍完了");
            }
            if (count($chop_arr) == 1) {
                $key = 0;
            } else {
                $key = mt_rand(0, count($chop_arr) - 1);
            }
            if ($this->Chop_record_model->save(array('chop_user_id' => get_cookie('user_id'), 'chop_nickname' => get_cookie('user_username')), array('id' => $chop_arr[$key]['id']))) {
                $userInfo = $this->User_model->get('path',array('id'=>  get_cookie('user_id')));
                $path = preg_match("/^http/", $userInfo['path']) ?  $userInfo['path'] : str_replace('.','_thumb.', $userInfo['path']);
                printAjaxData(array('chop_price' => $chop_arr[$key]['chop_price'],'path'=>$path,'chop_nickname'=>get_cookie('user_username')));
            } else {
                printAjaxError('fail', "砍价失败，请重试一遍");
            }
        }
    }

}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */
