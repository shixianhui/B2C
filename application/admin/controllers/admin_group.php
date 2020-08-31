<?php
class Admin_group extends CI_Controller {
	private $_title = '会员管理';
	private $_tool = '';
	private $_table = 'admin_group';

	public function __construct() {
		parent::__construct();
		//模型名
		$this->_table = $this->uri->segment(1);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'员工管理', 'title'=>'部门'), TRUE);
		$this->load->model('Pattern_model', '', TRUE);
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
	}

	public function index($clear = 0) {
	    checkPermission("{$this->_table}_index");

		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));

		$itemList = $this->tableObject->gets();

		$data = array(
		        'tool'=>$this->_tool,
		        'table'=>$this->_table,
		        'itemList'=>$itemList
		        );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view($this->_table.'/index', $data, TRUE)
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
		    $fields = array(
		        'group_name'=>$this->input->post('group_name', TRUE),
		        'permissions'=>$this->input->post('permissions', TRUE));
		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
		    	printAjaxSuccess($prfUrl, '操作成功');
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$itemInfo = $this->tableObject->get('*', array('id'=>$id));
		//栏目
		$strWhere = 'status = 1';
		$model = '';
		$menuList = $this->Menu_model->gets('model');
		foreach ($menuList as $menu) {
		    $model .= "'{$menu['model']}',";
		}
		if ($model) {
		    $model = substr($model, 0, -1);
		    $strWhere .= " and file_name in ({$model}) ";
		}
		$patternList = $this->Pattern_model->gets('title, file_name', $strWhere);
		//是否开启静态
		$system_info = $this->System_model->get('html', array('id'=>1));

	    $data = array(
		        'tool'=>$this->_tool,
	            'itemInfo'=>$itemInfo,
	            'patternList'=>$patternList,
	            'table'=>$this->_table,
	            'is_html'=>$system_info['html'],
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view($this->_table.'/save', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    public function delete() {
        checkPermissionAjax("{$this->_table}_delete");

	    $ids = $this->input->post('ids', TRUE);

	    if (! empty($ids)) {
	        if ($this->tableObject->delete('id in ('.$ids.')')) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('fail', '删除失败！');
	}
}
/* End of file admingroup.php */
/* Location: ./application/admin/controllers/admingroup.php */