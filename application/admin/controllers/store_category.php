<?php
class Store_category extends CI_Controller {
    private $_title = '店铺分类管理';
    private $_tool = '';
    private $_table = '';

    public function __construct() {
        parent::__construct();
        //获取表名
        $this->_table = $this->uri->segment(1);
        //快捷方式
        $this->_tool = $this->load->view("element/save_list_tool", array('table' => $this->_table, 'parent_title' => '店铺管理', 'title' => '店铺分类'), TRUE);
        //获取表对象
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
    }

    public function index() {
    	checkPermission("{$this->_table}_index");
        $this->session->set_userdata(array("{$this->_table}RefUrl" => base_url() . 'admincp.php/' . uri_string()));

        $item_list = $this->tableObject->menuTree();

        $data = array(
            'tool' => $this->_tool,
            'table' => $this->_table,
            'item_list' => $item_list
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_table}/index", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function save($tmp_parent_id = 0, $id = NULL) {
    	if ($id) {
    		checkPermission("{$this->_table}_edit");
    	} else {
    		checkPermission("{$this->_table}_add");
    	}
        $prfUrl = $this->session->userdata("{$this->_table}RefUrl") ? $this->session->userdata("{$this->_table}RefUrl") : base_url() . "admincp.php/{$this->_table}/index";
        if ($_POST) {
            $parent_id = $this->input->post('parent_id', TRUE);
            if ($id) {
                if ($parent_id == $id) {
                    printAjaxError('自己不能是自己的上级分类');
                }
            }
            $path = $this->input->post('path',TRUE);

            if ($id != NULL) {
                $fields = array(
                    'parent_id' => $parent_id,
                    'store_category_name' => $this->input->post('store_category_name', TRUE),
                    'sort' => $this->input->post('sort', TRUE),
                    'path' => $path
                );
                if ($this->tableObject->save($fields, array('id' => $id))) {
                    printAjaxSuccess($prfUrl);
                } else {
                    printAjaxError("操作失败！");
                }
            } else {
                $i = 0;
                $store_category_name = $this->input->post('store_category_name', TRUE);
                $sort = $this->input->post('sort', TRUE);

                $title = preg_replace(array('/^\|+/', '/\|+$/'), array('', ''), $store_category_name);
                $titleArr = explode("|", $title);
                foreach ($titleArr as $key => $title) {
                    $fields = array(
                        'parent_id' => $parent_id,
                        'sort' => $sort + $key,
                        'store_category_name' => trim($title),
                        'path' => $path
                    );
                    if ($this->tableObject->save($fields)) {
                        $i++;
                    }
                }
                if (count($titleArr) == $i) {
                    printAjaxSuccess($prfUrl);
                } else {
                    printAjaxError("操作失败！");
                }
            }
        }
        $item_info = $this->tableObject->get('*', array('id' => $id));
        $item_list = $this->tableObject->gets2(array('parent_id' => 0));

        $data = array(
            'tool' => $this->_tool,
            'tmp_parent_id' => $tmp_parent_id,
            'item_info' => $item_info,
            'item_list' => $item_list,
        	'table' => $this->_table,
            'prfUrl' => $prfUrl
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_table}/save", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function delete() {
    	checkPermissionAjax("{$this->_table}_delete");
    	if ($_POST) {
    		$id = $this->input->post('id', TRUE);

    		if (!empty($id)) {
    			if ($id == 1) {
    				printAjaxError('fail', '默认分类不能删除！');
    			}
    			$ids = $this->tableObject->getChildIds($id);
    			if ($ids != $id) {
    				printAjaxError('fail', '删除失败，请先删除下级分类！');
    			}
    			if ($this->tableObject->delete("id in ($id) and id <> 1")) {
    				printAjaxData(array('id' => $id));
    			}
    		}

    		printAjaxError('fail', '删除失败！');
    	}
    }

    public function sort() {
    	checkPermissionAjax("{$this->_table}_edit");
        $ids = $this->input->post('ids', TRUE);
        $sorts = $this->input->post('sorts', TRUE);

        if (!empty($ids) && !empty($sorts)) {
            $ids = explode(',', $ids);
            $sorts = explode(',', $sorts);

            foreach ($ids as $key => $value) {
                $this->tableObject->save(
                        array('sort' => $sorts[$key]), array('id' => $value));
            }
            printAjaxSuccess('', '排序成功！');
        }

        printAjaxError('排序失败！');
    }

    public function display() {
    	checkPermissionAjax("{$this->_table}_edit");
        $ids = $this->input->post('ids');
        $display = $this->input->post('display');
        if (!empty($ids) && $display != "") {
            if ($this->tableObject->save(array('display' => $display), 'id in (' . $ids . ')')) {
                printAjaxSuccess('', '修改状态成功！');
            }
        }

        printAjaxError('fail', '修改状态失败！');
    }

}

/* End of file admingroup.php */
/* Location: ./application/admin/controllers/admingroup.php */