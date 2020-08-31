<?php
class Store_grade extends CI_Controller {
	private $_title = '店铺等级管理';
	private $_tool = '';
	private $_table = '';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'店铺管理', 'title'=>'店铺等级'), TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Theme_model', '', TRUE);
	}

	public function index() {
		checkPermission("{$this->_table}_index");
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));

		$item_list = $this->tableObject->gets();

		$data = array(
		        'tool'=>$this->_tool,
		        'table'=>$this->_table,
		        'item_list'=>$item_list
		        );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/index", $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
		if ($id) {
			checkPermission("{$this->_table}_edit");
		} else {
			checkPermission("{$this->_table}_add");
		}
		$prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index";
		if ($_POST) {
			$grade_name = trim($this->input->post('grade_name', TRUE));
			$product_limit = $this->input->post('product_limit', TRUE);
			$display = $this->input->post('display', TRUE);
			$theme_ids = $this->input->post('theme_ids', TRUE);
			if (! empty($theme_ids)) {
				$theme_ids = implode($theme_ids, ',');
			} else {
				$theme_ids = '';
			}

			$fields = array(
					'grade_name'=>   $grade_name,
					'product_limit'=>$product_limit,
					'theme_ids'=>  $theme_ids,
					'display'=>      $display
			);
			if ($this->tableObject->save($fields, $id?array('id'=>$id):NULL)) {
				printAjaxSuccess($prfUrl);
			} else {
				printAjaxError("操作失败！");
			}
		}

		$item_info = $this->tableObject->get('*', array("{$this->_table}.id"=>$id));
		$theme_ids_arr = array();
		if ($item_info) {
			$theme_ids_arr = explode(',', $item_info['theme_ids']);
		}
		$theme_list = $this->Theme_model->gets(array('display'=>1));

	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
	    		'theme_list'=>$theme_list,
	    		'theme_ids_arr'=>$theme_ids_arr,
	    		'table'=>$this->_table,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/save", $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    public function delete() {
    	checkPermissionAjax("{$this->_table}_delete");
	    $ids = $this->input->post('ids', TRUE);

	    if (! empty($ids)) {
	        if ($this->tableObject->delete("id in ($ids) and id <> 1")) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
	}
}
/* End of file admingroup.php */
/* Location: ./application/admin/controllers/admingroup.php */