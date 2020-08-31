<?php
class Active extends CI_Controller {
    private $_title = '营销活动管理';
    private $_tool = '';

    public function __construct() {
        parent::__construct();
        $this->_tool = $this->load->view('element/ptkj_tool', array('title' => ''), TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Pintuan_model', '', TRUE);
        $this->load->model('Ptkj_record_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Promotion_ptkj_model', '', TRUE);
        $this->load->model('Flash_sale_model', '', TRUE);
    }

    public function pintuan_index() {
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $item_list = $this->Promotion_ptkj_model->gets();
        $data = array(
            'tool' => $this->load->view('element/ptkj_tool', array('title' => '基本设置'), TRUE),
            'itemInfo' => $itemInfo,
            'item_list' => $item_list
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('active/pintuan_index', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function pintuan_save($id = null) {
        $prfUrl = base_url() . 'admincp.php/active/pintuan_index/';
        $productInfo = array();
        $pintuan_arr = array();
        if ($id) {
            $itemInfo = $this->Promotion_ptkj_model->get('*', array('id' => $id));
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $itemInfo['product_id']));
            $pintuan_arr = $this->Pintuan_model->gets(array('ptkj_id' => $id));
        } else {
            $itemInfo = array();
        }
        if ($_POST) {
            $name = $this->input->post('name', true);
            $low_price = $this->input->post('low_price', true);
            $product_id = $this->input->post('product_id', true);
            $cut_total_money = $this->input->post('cut_total_money', true);
            $cut_times = $this->input->post('cut_times', true);
            $start_time = strtotime($this->input->post('start_time', true));
            $end_time = strtotime($this->input->post('end_time', true));
            $is_open = $this->input->post('is_open', true);
            if ($end_time <= $start_time) {
                printAjaxError('error', "拼团活动结束时间必须大于拼团活动开始时间");
            }
            if ($end_time < time()) {
                printAjaxError('error', "拼团活动结束时间必须大于当前时间");
            }
            if (!empty($id) && time() > $itemInfo['start_time'] && time() < $itemInfo['end_time']) {
                $count = $this->Ptkj_record_model->rowCount(array('ptkj_id' => $id));
                if ($count > 0) {
                    printAjaxError('error', "活动正在进行,不可修改！");
                }
            }
            if (empty($id)) {
                $tmp_data = $this->Promotion_ptkj_model->get('*', array('product_id' => $product_id));
                if (!empty($tmp_data) && time() > $tmp_data['start_time'] && time() < $tmp_data['end_time']) {
                    printAjaxError('error', '活动期间，不可以有两种相同商品设置拼团活动');
                }
            }
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $product_id));
            $fields = array(
                'name' => $name,
                'low_price' => $low_price,
                'product_id' => $product_id,
                'cut_total_money' => $cut_total_money,
                'cut_times' => $cut_times,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'is_open' => $is_open,
                'add_time' => time(),
                'path' => $productInfo['path'],
                'high_price' => $productInfo['sell_price'],
            );
            $retId = $this->Promotion_ptkj_model->save($fields, $id ? array('id' => $id) : $id);

            if ($retId) {
                $retId = $id ? $id : $retId;
                $this->Pintuan_model->delete(array('ptkj_id' => $retId));
                $low_arr = $this->input->post('low', TRUE);
                $high_arr = $this->input->post('high', TRUE);
                $money_arr = $this->input->post('money', TRUE);
                if (empty($low_arr)) {
                    printAjaxError('error', "拼团规则不能为空!");
                }
                $low_str = implode(',', $low_arr);
                $high_str = implode(',', $high_arr);
                $money_str = implode(',', $money_arr);
                if (!empty($low_str) && !empty($high_str) && !empty($money_str)) {
                    foreach ($low_arr as $key => $ls) {
                        if (!is_numeric($ls) || !is_numeric($high_arr[$key]) || empty($money_arr[$key])) {
                            printAjaxError('error', "拼团规则有一项为空!");
                        }
                        $fields_data = array(
                            'low' => $ls,
                            'high' => $high_arr[$key],
                            'money' => $money_arr[$key],
                            'ptkj_id' => $retId,
                            'add_time' => time(),
                        );
                        $this->Pintuan_model->save($fields_data);
                    }
                } else {
                    printAjaxError('error', "拼团规则有一项为空!");
                }
                printAjaxSuccess($prfUrl, "保存成功");
            } else {
                printAjaxError('fail', "保存失败");
            }
        }
        $data = array(
            'tool' => $this->load->view('element/ptkj_tool', array('title' => '基本设置'), TRUE),
            'itemInfo' => $itemInfo,
            'productInfo' => $productInfo,
            'pintuan_arr' => $pintuan_arr,
            'id' => $id,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('active/pintuan_save', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function pintuan_view($id = '') {
        if ($id) {
            $itemInfo = $this->Promotion_ptkj_model->get('*', array('id' => $id));
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $itemInfo['product_id']));
            $pintuan_arr = $this->Pintuan_model->gets(array('ptkj_id' => $id));
        }
        $data = array(
            'tool' => $this->load->view('element/ptkj_tool', array('title' => '基本设置'), TRUE),
            'itemInfo' => $itemInfo,
            'productInfo' => $productInfo,
            'pintuan_arr' => $pintuan_arr,
            'id' => $id,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('active/pintuan_view', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function flash_sale_index() {
        $item_list = $this->Flash_sale_model->gets();
        $data = array(
            'tool' => $this->load->view('element/flash_sale_tool', array('title' => '基本设置'), TRUE),
            'item_list' => $item_list,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('active/flash_sale_index', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function flash_sale_save($id = null) {
        $prfUrl = base_url() . 'admincp.php/active/flash_sale_index/';
        $productInfo = array();
        if ($id) {
            $itemInfo = $this->Flash_sale_model->get('*', array('id' => $id));
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $itemInfo['product_id']));
        } else {
            $itemInfo = array();
        }
        if ($_POST) {
            $name = $this->input->post('name', true);
            $old_price = $this->input->post('old_price', true);
            $is_open = $this->input->post('is_open', true);
            $flash_sale_price = $this->input->post('flash_sale_price', true);
            $product_id = $this->input->post('product_id', true);
            $description = $this->input->post('description', true);
            $start_time = strtotime($this->input->post('start_time', true));;
            $end_time = strtotime($this->input->post('end_time', true));;
            if ($end_time <= $start_time) {
                printAjaxError('error', "结束时间必须大于活动开始时间");
            }
            if ($end_time < time()) {
                printAjaxError('error', "活动结束时间必须大于当前时间");
            }
            $tmp_data = $this->Flash_sale_model->get('*', array('product_id' => $product_id));
                if (empty($id) && !empty($tmp_data)) {
                    printAjaxError('error', '您已对此商品设为限时抢购活动');
                }
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $product_id));
            $fields = array(
                'name' => $name,
                'old_price' => $productInfo['sell_price'],
                'flash_sale_price' => $flash_sale_price,
                'product_id' => $product_id,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'is_open' => $is_open,
                'add_time' => time(),
                'path' => $productInfo['path'],
                'product_title' => $productInfo['title'],
                'description' => $description,
            );
            $retId = $this->Flash_sale_model->save($fields, $id ? array('id' => $id) : $id);
            if ($retId) {
                printAjaxSuccess($prfUrl, "保存成功");
            } else {
                printAjaxError('fail', "保存失败");
            }
        }
        $data = array(
            'tool' => $this->load->view('element/flash_sale_tool', array('title' => '基本设置'), TRUE),
            'itemInfo' => $itemInfo,
            'productInfo' => $productInfo,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('active/flash_sale_save', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function delete_pintuan() {
        $ids = $this->input->post('ids', TRUE);
        if (!empty($ids)) {
            $count = $this->Ptkj_record_model->rowCount("ptkj_id in ($ids)");
            if ($count > 0) {
                printAjaxError('fail', '有相关记录,不可删除！');
            }
            if ($this->Promotion_ptkj_model->delete('id in (' . $ids . ')')) {
                //删除拼团规则
                $this->Pintuan_model->delete("ptkj_id in ({$ids})");
                printAjaxData(array('ids' => explode(',', $ids)));
            }
        }
        printAjaxError('fail', '删除失败！');
    }

    public function delete_flash_sale(){
        $ids = $this->input->post('ids', TRUE);
        if (!empty($ids)) {
            if ($this->Flash_sale_model->delete('id in (' . $ids . ')')) {
                printAjaxData(array('ids' => explode(',', $ids)));
            }
        }
        printAjaxError('fail', '删除失败！');
    }

}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */

