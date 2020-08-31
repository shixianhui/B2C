<?php

class Robot extends CI_Controller {

    private $_title = '机器人管理';
    private $_tool = '';
    private $_table = '';
    private $_template = 'robot';

    public function __construct() {
        parent::__construct();
        //获取表名
        $this->_table = $this->uri->segment(1);
        //模型名
        $this->_template = $this->uri->segment(1);
        $this->_tool = $this->load->view("element/{$this->_table}_tool", array('table' => $this->_table), TRUE);
//        //获取表对象
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Flash_sale_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Ptkj_record_model', '', TRUE);
        $this->load->model('Promotion_ptkj_model', '', TRUE);
        $this->load->model('Flash_sale_record_model', '', TRUE);
        $this->load->model('Orders_model', '', TRUE);
        $this->load->model('Orders_detail_model', '', TRUE);
    }

    public function import_robot() {
        checkPermission($this->_template.'_import');
        clearSession(array('search_index'));
        if ($_FILES) {
            set_time_limit(0);
            ignore_user_abort(true); //检测用户断开
            if (($_FILES["file"]["type"] == "text/plain") && ($_FILES["file"]["size"] < 2000000)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Error: " . $_FILES["file"]["error"] . "<br />";
                    return;
                }
            } else {
                echo "文件太大---或者不是txt文件";
                return;
            }
            $file = file_get_contents($_FILES["file"]["tmp_name"]) or exit("Unable to open file!");
            $times = 0;
            if (preg_match_all("/.+\n/", $file, $arr)) {
                foreach ($arr[0] as $ls) {
                    $ls = trim($ls);
                    if (empty($ls)) {
                        continue;
                    }
                    $encode = mb_detect_encoding($ls, array("ASCII", "UTF-8", "GB2312", "GBK", "BIG5"));
                    if ($encode == "EUC-CN") {
                        $ls = iconv("EUC-CN", "UTF-8", $ls);
                    }
                    $fields = array(
                        'user_group_id' => 1,
                        'username' => '',
                        'login_time' => time(),
                        'ip' => '',
                        'ip_address' => '',
                        'password' => '',
                        'mobile' => '',
                        'add_time' => time(),
                        'nickname' => $ls,
                        'path' => '',
                        'sex' => 0,
                        'is_robot' => 1
                    );
                    $ret = $this->User_model->save($fields);
                    if ($ret) {
                        $times++;
                    }
                }
            }
            //输出自动注册成功条数
            echo "成功批量执行了：" . $times . "条";
            exit;
        }
        $data = array(
            'tool' => $this->_tool,
            'template' => $this->_template,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_template}/import_robot", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function ptkj() {
        checkPermission($this->_template.'_ptkj');
        $json = file_get_contents('./sdk/robot_config/ptkj.json');
        $item_info = json_decode($json, true);
        $data = array(
            'tool' => $this->_tool,
            'template' => $this->_template,
            'item_info' => $item_info
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_template}/ptkj", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function ptkj_launch() {
        checkPermissionAjax($this->_template.'_ptkj');
        $start = intval($this->input->post('start', true));
        $end = intval($this->input->post('end', true));
        $is_open = 1;
        if (!is_numeric($start) || !is_numeric($end) || $start <= 0 || $end <= 0 || $end <= $start) {
            printAjaxError('fail', '时间参数错误');
        }
        $json = json_encode(array(
            'start' => $start,
            'end' => $end,
            'is_open' => $is_open,
        ));
        file_put_contents('./sdk/robot_config/ptkj.json', $json);
        $this->ptkj_run();
    }

    public function ptkj_stop() {
        checkPermissionAjax($this->_template.'_ptkj');
        if ($_POST) {
            $start = intval($this->input->post('start', true));
            $end = intval($this->input->post('end', true));
            $is_open = 0;
            if (!is_numeric($start) || !is_numeric($end) || $start <= 0 || $end <= 0 || $end <= $start) {
                printAjaxError('fail', '时间参数错误');
            }
            $json = json_encode(array(
                'start' => $start,
                'end' => $end,
                'is_open' => $is_open,
            ));
            file_put_contents('./sdk/robot_config/ptkj.json', $json);
            printAjaxSuccess('success', '已关闭');
        }
    }

    public function ptkj_run() {
        checkPermissionAjax($this->_template.'_ptkj');
        ignore_user_abort(true);
        set_time_limit(0);
        #设定从新开起
        while (true) {
            $json = file_get_contents('./sdk/robot_config/ptkj.json');
            $arr = json_decode($json, true);
            #获取配置文件信息判断是否退出
            if ($arr['is_open'] == 0) {
                exit;
            }
            $current_time = time();
            $ptkj_list = $this->Promotion_ptkj_model->gets("start_time <= $current_time and end_time > $current_time and is_open = 1");
            if (empty($ptkj_list)) {
                exit;
            }
            $robot_list = $this->User_model->gets(array('is_robot' => 1));
            if (empty($robot_list)) {
                exit;
            }
            $ptkj_ids = '';
            $robot_ids = '';
            foreach ($ptkj_list as $ls) {
                $ptkj_ids .= $ls['id'] . ',';
            }
            foreach ($robot_list as $ls) {
                $robot_ids .= $ls['id'] . ',';
            }
            $ptkj_ids = trim($ptkj_ids, ',');
            $robot_ids = trim($robot_ids, ',');
            $count = $this->Ptkj_record_model->rowCount("ptkj_id in({$ptkj_ids}) and user_id in({$robot_ids})");
            //判断所有机器人对每个拼团活动是否都已经参团，如果是，则退出并关闭
            if ($count == count($ptkj_list) * count($robot_list)) {
                $arr['is_open'] = 0;
                file_put_contents('./sdk/robot_config/ptkj.json', json_encode($arr));
                exit;
            }
            while (true) {
                //随机取一个机器人
                $rand_robot_key = array_rand($robot_list, 1);
                $robot = $robot_list[$rand_robot_key];
                //随机对某个活动参团
                $rand_ptkj_key = array_rand($ptkj_list, 1);
                $ptkj = $ptkj_list[$rand_ptkj_key];
                if ($this->Ptkj_record_model->rowCount("ptkj_id = {$ptkj['id']} and user_id = {$robot['id']}") == 0) {
                    break;
                }
                continue;
            }
            $product_info = $this->Product_model->get('title', array('id' => $ptkj['product_id']));
            $sizeList = $this->Product_model->getDetailSize($ptkj['product_id']);
            $colorList = $this->Product_model->getDetailColor($ptkj['product_id']);
            //随机取尺码
            $rand_size_key = array_rand($sizeList, 1);
            $size_info = $sizeList[$rand_size_key];
            //随机取颜色
            $rand_color_key = array_rand($colorList, 1);
            $color_info = $colorList[$rand_color_key];
            $fields_data = array(
                'user_id' => $robot['id'],
                'ptkj_id' => $ptkj['id'],
                'product_title' => $product_info['title'],
                'product_id' => $ptkj['product_id'],
                'size_name' => $size_info['size_name'],
                'color_name' => $color_info['color_name'],
                'size_id' => $size_info['size_id'],
                'color_id' => $color_info['color_id'],
                'buy_number' => 1,
                'add_time' => time(),
            );
            $retId = $this->Ptkj_record_model->save($fields_data);
            if ($retId) {
                $this->Promotion_ptkj_model->save(array('pintuan_people' => $ptkj['pintuan_people'] + 1), array('id' => $ptkj['id']));
            }
            #休眠时间
            sleep(rand($arr['start'], $arr['end']));
        }
    }

    public function xsqg() {
        checkPermission($this->_template.'_xsqg');
        $json = file_get_contents('./sdk/robot_config/xsqg.json');
        $item_info = json_decode($json, true);
        $data = array(
            'tool' => $this->_tool,
            'template' => $this->_template,
            'item_info' => $item_info
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_template}/xsqg", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function xsqg_launch() {
        checkPermissionAjax($this->_template.'_xsqg');
        $start = intval($this->input->post('start', true));
        $end = intval($this->input->post('end', true));
        $is_open = 1;
        if (!is_numeric($start) || !is_numeric($end) || $start <= 0 || $end <= 0 || $end <= $start) {
            printAjaxError('fail', '时间参数错误');
        }
        $json = json_encode(array(
            'start' => $start,
            'end' => $end,
            'is_open' => $is_open,
        ));
        file_put_contents('./sdk/robot_config/xsqg.json', $json);
        $this->xsqg_run();
    }

    public function xsqg_stop() {
        checkPermissionAjax($this->_template.'_xsqg');
        if ($_POST) {
            $start = intval($this->input->post('start', true));
            $end = intval($this->input->post('end', true));
            $is_open = 0;
            if (!is_numeric($start) || !is_numeric($end) || $start <= 0 || $end <= 0 || $end <= $start) {
                printAjaxError('fail', '时间参数错误');
            }
            $json = json_encode(array(
                'start' => $start,
                'end' => $end,
                'is_open' => $is_open,
            ));
            file_put_contents('./sdk/robot_config/xsqg.json', $json);
            printAjaxSuccess('success', '已关闭');
        }
    }

    public function xsqg_run() {
        checkPermissionAjax($this->_template.'_xsqg');
        ignore_user_abort(true);
        set_time_limit(0);
        #设定从新开起
        while (true) {
            $json = file_get_contents('./sdk/robot_config/xsqg.json');
            $arr = json_decode($json, true);
            #获取配置文件信息判断是否退出
            if ($arr['is_open'] == 0) {
                exit;
            }
            $current_time = time();
            $xsqg_list = $this->Flash_sale_model->gets("start_time <= $current_time and end_time > $current_time and is_open = 1");
            if (empty($xsqg_list)) {
                exit;
            }
            $robot_list = $this->User_model->gets(array('is_robot' => 1));
            if (empty($robot_list)) {
                exit;
            }
            $xsqg_ids = '';
            $robot_ids = '';
            $start_times = '';
            $end_times = '';
            foreach ($xsqg_list as $ls) {
                $xsqg_ids .= $ls['id'] . ',';
                $start_times .= $ls['start_time'] . ',';
                $end_times .= $ls['end_time'] . ',';
            }
            foreach ($robot_list as $ls) {
                $robot_ids .= $ls['id'] . ',';
            }
            $xsqg_ids = trim($xsqg_ids, ',');
            $robot_ids = trim($robot_ids, ',');
            $start_times = trim($start_times, ',');
            $end_times = trim($end_times, ',');
            $stock = $this->Product_model->get('sum(stock) as total_stock', "id in({$xsqg_ids})");
            //总库存为0时，则退出
            if ($stock['total_stock'] <= 0) {
                $arr['is_open'] = 0;
                file_put_contents('./sdk/robot_config/xsqg.json', json_encode($arr));
                exit;
            }
            $strWhere = "user_id in ({$robot_ids}) and start_time in ($start_times) and end_time in ($end_times) and flash_sale_id in ({$xsqg_ids})";
            if ($this->Flash_sale_record_model->rowCount($strWhere) >= count($robot_list) * count($xsqg_list)) {
                $arr['is_open'] = 0;
                file_put_contents('./sdk/robot_config/xskj.json', json_encode($arr));
                exit;
            }
            while (true) {
                //随机取一个机器人
                $rand_robot_key = array_rand($robot_list, 1);
                $robot = $robot_list[$rand_robot_key];
                //随机对某个商品抢购
                $rand_xsqk_key = array_rand($xsqg_list, 1);
                $xsqg = $xsqg_list[$rand_xsqk_key];
                if ($this->Flash_sale_record_model->rowCount("flash_sale_id = {$xsqg['id']} and user_id = {$robot['id']} and start_time = {$xsqg['start_time']} and end_time = {$xsqg['end_time']}") == 0) {
                    break;
                }
                continue;
            }
            $product_stock = $this->Product_model->get('stock',array('id'=>$xsqg['product_id']));
            if($product_stock['stock'] > 0){
                            $sizeList = $this->Product_model->getDetailSize($xsqg['product_id']);
                            $colorList = $this->Product_model->getDetailColor($xsqg['product_id']);
                            while (true) {
                                //随机取尺码
                                $rand_size_key = array_rand($sizeList, 1);
                                $size_info = $sizeList[$rand_size_key];
                                //随机取颜色
                                $rand_color_key = array_rand($colorList, 1);
                                $color_info = $colorList[$rand_color_key];
                                $get_stock = $this->Product_model->getProductStock($xsqg['product_id'], $color_info['color_id'], $size_info['size_id']);
                                if ($get_stock['stock'] > 0) {
                                    break;
                                }
                                continue;
                            }
                                    //添加订单信息
                                    $fields = array(
                                        'user_id' => $robot['id'],
                                        'order_number' => $this->_getUniqueOrderNumber(),
                                        'payment_id' => 0,
                                        'payment_title' => '',
                                        'payment_price' => 0,
                                        'postage_id' => 0,
                                        'postage_title' => '',
                                        'postage_price' => 0,
                                        'total' => 0,
                                        'status' => 1,
                                        'add_time' => time(),
                                        'buyer_name' => '',
                                        'province_id' => 0,
                                        'city_id' => 0,
                                        'area_id' => 0,
                                        'txt_address' => '',
                                        'address' => '',
                                        'zip' => '',
                                        'phone' => '',
                                        'mobile' => '',
                                        'delivery_time' => 1,
                                        'remark' => '',
                                        'invoice' => '',
                                        'score' => 0,
                                        'order_type' => 2,
                                        'divide_total' =>          0,
                                        'divide_store_price' =>    0,
                                        'divide_school_total'=>    0,
                                        'divide_school_sub_price'=>0,
                                        'postage_template_id' =>   0
                                    );
                                    //添加订单
                                    $ret = $this->Orders_model->save($fields);
                                   if($ret){
                                       $this->Product_model->changeStock(array('stock' => $get_stock['stock'] - 1), array('product_id' => $xsqg['product_id'], 'color_id' => $color_info['color_id'], 'size_id' => $size_info['size_id']));
                                            //订单详细会记录购买此商品时，商品当时分成设置情况
                                            $detailFields = array(
                                                'order_id' => $ret,
                                                'product_id' => $xsqg['product_id'],
                                                'product_num' => '',
                                                'product_title' => $xsqg['product_title'],
                                                'buy_number' => 1,
                                                'buy_price' => $xsqg['flash_sale_price'],
                                                'size_name' => $size_info['size_name'],
                                                'size_id' => $size_info['size_id'],
                                                'color_name' => $color_info['color_name'],
                                                'color_id' => $color_info['color_id'],
                                                'path' => $xsqg['path'],
                                                'divide_total' => 0,
                                                'divide_store_price' => 0,
                                                    'divide_school_total'=> 0,
                                                    'divide_school_sub_price'=> 0
                                            );
                                            $this->Orders_detail_model->save($detailFields);
                                         $data = array(
                                                'user_id' => $robot['id'],
                                                'start_time' => $xsqg['start_time'],
                                                'end_time' => $xsqg['end_time'],
                                                'flash_sale_id' => $xsqg['id'],
                                                'order_id' => $ret,
                                                'add_time' => time(),
                                            );
                                            $this->Flash_sale_record_model->save($data);
                                   }

            }
            #休眠时间
            sleep(rand($arr['start'], $arr['end']));
        }
    }

      //获取唯一的订单号
    private function _getUniqueOrderNumber() {
        //一秒钟一万件的量
        $randCode = '';
        while (true) {
            $randCode = getOrderNumber(5);
            $count = $this->Orders_model->rowCount(array('order_number' => $randCode));
            if ($count > 0) {
                $randCode = '';
                continue;
            } else {
                break;
            }
        }
        return $randCode;
    }

}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */