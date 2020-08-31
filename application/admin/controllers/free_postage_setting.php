<?php
class Free_postage_setting extends CI_Controller {
    private $_title = '包邮条件设置';
    private $_tool = '';

    public function __construct() {
        parent::__construct();
        //获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view('element/system_tool', array('parent_title'=>'系统管理', 'title'=>$this->_title), TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
    }

    public function save() {
        if ($_POST) {
            checkPermissionAjax('free_postage_setting_edit');
            $fields = array(
                'free_postage_price' =>     $this->input->post('free_postage_price', TRUE),
                'product_number' =>     $this->input->post('product_number', TRUE),
            	'open_price' =>         $this->input->post('open_price', TRUE),
            	'open_number' =>         $this->input->post('open_number', TRUE),
            	'is_free' =>         $this->input->post('is_free', TRUE),
                'open_price_ac' =>         $this->input->post('open_price_ac', TRUE),
            	'open_number_ac' =>         $this->input->post('open_number_ac', TRUE),
            	'is_free_ac' =>         $this->input->post('is_free_ac', TRUE),
            );
            if ($this->tableObject->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/free_postage_setting/save');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->tableObject->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '包邮条件设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('free_postage_setting/save', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }
}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */