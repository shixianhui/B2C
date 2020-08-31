<?php
class Floor extends CI_Controller {
    private $_title = '首页楼层设置';
    private $_tool = '';
    private $_template = 'floor';
    private $_category_type = array('1'=> '品牌男装','2'=>'箱包配饰','3'=>'精品男鞋');
    public function __construct() {
        parent::__construct();
        //快捷方式
        $this->_tool = $this->load->view('element/system_tool', array('parent_title'=>'系统管理', 'title'=>$this->_title), TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Floor_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Product_category_model', '', TRUE);
    }

    public function index($page=0) {
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        //分页
        $strWhere = 'id > 0';
        $item_list = $this->Floor_model->gets('*');
        $data = array(
            'tool' => $this->_tool,
            'itemInfo' => $itemInfo,
            'item_list' => $item_list,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('floor/index', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function save($id = null) {
        checkPermission("{$this->_template}_save");
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->Floor_model->get('*', array('id' => $id));
        $product_category_list = $this->Product_category_model->menuTree();
        if ($_POST) {
            $title = $this->input->post('title', true);
            $en_title = $this->input->post('en_title', true);
            $right_title = $this->input->post('right_title', true);
            $category_id_arr = $this->input->post('category_id', true);
            $url = $this->input->post('url', true);
            if(!$title){
                printAjaxError('title','楼层名称不能为空');
            }
            if(!$en_title){
                printAjaxError('en_title','楼层英文名称不能为空');
            }
            if(!$right_title){
                printAjaxError('right_title','楼层右侧文本不能为空');
            }
            if(!$category_id_arr){
                printAjaxError('category_id','推送分类id不能为空');
            }
            if(!$url){
                printAjaxError('url','url地址不能为空');
            }
            $fields = array(
                 'title' => $title,
                 'en_title' => $en_title,
                 'right_title' => $right_title,
                 'category_id' => implode(',',$category_id_arr),
                 'url' => $url,
            );
            $this->Floor_model->save($fields,array('id' => $id));
            printAjaxSuccess($_SERVER['REQUEST_URI'], '修改成功');
        }
        $data = array(
            'tool' => $this->_tool,
            'systemInfo' => $systemInfo,
            'itemInfo' => $item_info,
            'product_category_list' => $product_category_list,
             'category_type' => $this->_category_type
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('floor/save', $data, TRUE)
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
