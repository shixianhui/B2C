<?php
class Theme extends CI_Controller {
	private $_title = '店铺模板管理';
	private $_tool = '';
	private $_table = '';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'店铺管理', 'title'=>'店铺模板'), TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
	}

	public function index() {
		checkPermission("{$this->_table}_index");
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$strWhere = array('display'=>1);
	    if ($_POST) {
			$strWhere = "{$this->_table}.id > 0";
			$brand_category_id = $this->input->post('brand_category_id', true);

		    if (! empty($brand_category_id) ) {
		        $strWhere .= " and {$this->_table}.brand_category_id = {$brand_category_id} ";
		    }
		}

		$item_list = $this->tableObject->gets($strWhere);

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
			$theme_name = trim($this->input->post('theme_name', TRUE));
			$alias = trim($this->input->post('alias', TRUE));

			if ($id) {
				if ($this->tableObject->rowCount("alias = '{$alias}' and id <> {$id}")) {
					printAjaxError('fail', '别名已经存在');
				}
			} else {
				if ($this->tableObject->rowCount("alias = '{$alias}'")) {
					printAjaxError('fail', '别名已经存在');
				}
			}

			$fields = array(
					'theme_name'=>  $theme_name,
					'alias'=>       $alias,
					'path'=>        $this->input->post('path', TRUE),
					'sort'=>        $this->input->post('sort', TRUE),
					'display'=>     $this->input->post('display', TRUE)
			);
			if ($this->tableObject->save($fields, $id?array('id'=>$id):NULL)) {
				printAjaxSuccess($prfUrl);
			} else {
				printAjaxError("操作失败！");
			}
		}

		$item_info = $this->tableObject->get('*', array("{$this->_table}.id"=>$id));

	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
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
	        if ($this->tableObject->delete("id in ($ids)")) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
	}

    public function sort() {
    	checkPermissionAjax("{$this->_table}_edit");
		$ids = $this->input->post('ids', TRUE);
		$sorts = $this->input->post('sorts', TRUE);

		if (! empty($ids) && ! empty($sorts)) {
			$ids = explode(',', $ids);
			$sorts = explode(',', $sorts);

			foreach ($ids as $key=>$value) {
				$this->tableObject->save(
				                   array('sort'=>$sorts[$key]),
				                   array('id'=>$value));
			}
			printAjaxSuccess('', '排序成功！');
		}
		printAjaxError('排序失败！');
	}

	public function display() {
		checkPermissionAjax("{$this->_table}_edit");
		$ids = $this->input->post('ids');
		$display = $this->input->post('display');

		if (! empty($ids) && $display != "") {
			if($this->tableObject->save(array('display'=>$display), 'id in ('.$ids.')')) {
				printAjaxSuccess('', '修改状态成功！');
			}
		}

		printAjaxError('fail', '修改状态失败！');
	}
}
/* End of file admingroup.php */
/* Location: ./application/admin/controllers/admingroup.php */