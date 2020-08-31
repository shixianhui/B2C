<?php

class Comment extends CI_Controller {

    private $_title = '商品评价管理';
    private $_tool = '';
    private $_template = 'comment';
    public function __construct() {
        parent::__construct();
        $this->_tool = $this->load->view('element/system_tool', array('parent_title'=>'交易管理', 'title'=>$this->_title), TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Comment_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
    }

    public function index($page=0) {
        checkPermission($this->_template.'_index');
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        //分页
        $strWhere = 'id > 0';
        $this->config->load('pagination_config', TRUE);
        $paginationCount = $this->Comment_model->rowCount($strWhere);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "admincp.php/comment/index/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
        $item_list = $this->Comment_model->gets('*',$strWhere, $paginationConfig['per_page'], $page);
        $data = array(
            'tool' => $this->_tool,
            'itemInfo' => $itemInfo,
            'item_list' => $item_list,
            'pagination' => $pagination,
            'paginationCount' => $paginationCount,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('comment/index', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function save($id = null) {
        if ($id) {
                    checkPermission("{$this->_template}_edit");
                } else {
                    checkPermission("{$this->_template}_add");
                }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->Comment_model->get('*', array('id' => $id));
        if ($_POST) {
            $grade = $this->input->post('grade', true);
            $content = $this->input->post('content', true);
            if (empty($grade) || empty($content)) {
                printAjaxError('fail', '分数和评价内容不能为空');
            }
            $this->Comment_model->save(array('grade' => $grade, 'content' => $content), $id ? array('id' => $id) : $id);
            printAjaxSuccess($_SERVER['REQUEST_URI'], '修改成功');
        }
        $data = array(
            'tool' => $this->_tool,
            'systemInfo' => $systemInfo,
            'itemInfo' => $item_info,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('Comment/save', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function delete() {
        checkPermissionAjax("{$this->_template}_delete");
        $ids = $this->input->post('ids', TRUE);
        if (!empty($ids)) {
            if ($this->Comment_model->delete("id in ($ids)")) {
                printAjaxData(array('ids' => explode(',', $ids)));
            }
        }
        printAjaxError('删除失败！');
    }

}
