<?php
class Usergroup extends CI_Controller {
	private $_title = '会员管理';
	private $_tool = '';
	private $_template = 'usergroup';
	public function __construct() {
		parent::__construct();
		$this->_tool = $this->load->view('element/usergroup_tool', '', TRUE);
		$this->load->model('Usergroup_model', '', TRUE);
	}

	public function index() {
		checkPermission("{$this->_template}_index");
		if (! $this->uri->segment(2)) {
		    $this->session->unset_userdata(array('search'=>''));
		}
		$this->session->set_userdata(array('userGroupRefUrl'=>base_url().'admincp.php/'.uri_string()));

		$usergroupList = $this->Usergroup_model->gets();

		$data = array(
		        'tool'=>$this->_tool,
		        'usergroupList'=>$usergroupList
		        );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view('usergroup/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
		if ($id) {
			checkPermission("{$this->_template}_edit");
		} else {
			checkPermission("{$this->_template}_add");
		}
		$prfUrl = $this->session->userdata('userGroupRefUrl')?$this->session->userdata('userGroupRefUrl'):base_url().'admincp.php/usergroup/index';
		if ($_POST) {
		    $fields = array('group_name'=>$this->input->post('group_name', TRUE));
		    if ($this->Usergroup_model->save($fields, $id?array('id'=>$id):$id)) {
		    	printAjaxSuccess($prfUrl);
			} else {
				printAjaxError("操作失败！");
			}
		}

		$usergroupInfo = $this->Usergroup_model->get('*', array('id'=>$id));

	    $data = array(
		        'tool'=>$this->_tool,
	            'usergroupInfo'=>$usergroupInfo,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view('usergroup/save', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    public function delete() {
    	checkPermissionAjax("{$this->_template}_delete");
    	$this->load->model('User_model', '', TRUE);
	    $ids = $this->input->post('ids', TRUE);
	    $count = $this->User_model->rowCount('user_group_id in ('.$ids.')');
	    if ($count) {
	        printAjaxError('存在关联数据，删除失败！');
	    }
	    if (! empty($ids)) {
	        if ($this->Usergroup_model->delete('id in ('.$ids.')')) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
	}
}
/* End of file admingroup.php */
/* Location: ./application/admin/controllers/admingroup.php */