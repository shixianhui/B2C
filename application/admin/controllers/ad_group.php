<?php
class Ad_group extends CI_Controller {
	private $_title = '广告位管理';
	private $_tool = '';
	private $_template = 'ad_group';
	private $_table = 'ad_group';
	public function __construct() {
		parent::__construct();
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'广告管理', 'title'=>$this->_title), TRUE);
		$this->load->model('Ad_group_model', '', TRUE);
	}

	public function index() {
        checkPermission($this->_template.'_index');
		if (! $this->uri->segment(2)) {
		    $this->session->unset_userdata(array('search'=>''));
		}
		$this->session->set_userdata(array('adGroupRefUrl'=>base_url().'admincp.php/'.uri_string()));
		$adgroupList = $this->Ad_group_model->gets();

		$data = array(
		                'tool'=>$this->_tool,
		                'adgroupList'=>$adgroupList
		                );
	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view('ad_group/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
       if ($id) {
           checkPermission("{$this->_template}_edit");
       } else {
            checkPermission("{$this->_template}_add");
       }
		$prfUrl = $this->session->userdata('adGroupRefUrl')?$this->session->userdata('adGroupRefUrl'):base_url().'admincp.php/adgroup/index';
		if ($_POST) {
		    $fields = array('group_name'=>$this->input->post('group_name', TRUE));
		    if ($this->Ad_group_model->save($fields, $id?array('id'=>$id):$id)) {
		    	printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$adgroupInfo = $this->Ad_group_model->get('*', array('id'=>$id));

	    $data = array(
		        'tool'=>$this->_tool,
	            'adgroupInfo'=>$adgroupInfo,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view('ad_group/save', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

    public function delete() {
        checkPermissionAjax("{$this->_template}_delete");
	    $ids = $this->input->post('ids', TRUE);
	    if (! empty($ids)) {
	        if ($this->Ad_group_model->delete('id in ('.$ids.')')) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('fail', '删除失败！');
	}
}
/* End of file admingroup.php */
/* Location: ./application/admin/controllers/admingroup.php */