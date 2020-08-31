<?php

class Jiameng extends CI_Controller {
    private $_title = '加盟申请';
    private $_tool = '';
    private $_template = 'jiameng';
    public function __construct() {
        parent::__construct();
        //快捷方式
        $this->_tool = $this->load->view('element/system_tool', array('parent_title'=>'会员管理', 'title'=>$this->_title), TRUE);
        //获取表名
        $this->_table = $this->uri->segment(1);
        //获取表对象
        $this->load->model('Jiameng_model', 'tableObject', TRUE);
    }

    public function index($page = 0) {
    	checkPermission("{$this->_template}_index");
        $strWhere = "id > 0";
        $this->config->load('pagination_config', TRUE);
        $paginationCount = $this->tableObject->rowCount($strWhere);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "admincp.php/jiameng/index/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->tableObject->gets('*', $strWhere, $paginationConfig['per_page'], $page);

        $data = array(
            'tool' => $this->_tool,
            'item_list' => $item_list,
            'pagination' => $pagination,
            'paginationCount' => $paginationCount,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('jiameng/index', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function delete() {
    	checkPermissionAjax("{$this->_template}_index");
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