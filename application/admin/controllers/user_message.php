<?php

class User_message extends CI_Controller {

    private $_title = ' 提醒发货';
    private $_tool = '';
    private $_template = 'user_message';
    public function __construct() {
        parent::__construct();
        //获取表名
        $this->_table = $this->uri->segment(1);
        //获取表对象
        $this->load->model('Message_model', 'tableObject', TRUE);
        $this->_tool = $this->load->view('element/system_tool', array('parent_title'=>'交易管理', 'title'=>$this->_title), TRUE);
    }

    public function index($page = 0, $id = NULL) {
        checkPermission($this->_template . '_index');
        if ($id) {
            $this->tableObject->save(array('is_read' => 1), array('id' => $id));
        }
        $strWhere = "to_user_id = 0";
        $this->config->load('pagination_config', TRUE);
        $paginationCount = $this->tableObject->rowCount($strWhere);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "admincp.php/user_message/index/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
		
        $item_list = $this->tableObject->gets('*', $strWhere, $paginationConfig['per_page'], $page);
        
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '提醒发货列表'), TRUE),
            'item_list' => $item_list,
            'pagination' => $pagination,
            'paginationCount' => $paginationCount,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('user_message/index', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function delete() {
        checkPermissionAjax($this->_template . '_delete');
        $ids = $this->input->post('ids', TRUE);
        if (!empty($ids)) {
            if ($this->tableObject->delete("id in ($ids)")) {
                printAjaxData(array('ids' => explode(',', $ids)));
            }
        }
        printAjaxError('删除失败！');
    }

}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */