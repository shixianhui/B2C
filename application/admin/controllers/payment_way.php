<?php
class Payment_way extends CI_Controller {
	private $_title = '支付方式';
	private $_tool = '';
	private $_table = '';
	private $_display_arr = array('0'=>'<font color="#FF0000">隐藏</font>', '1'=>'显示');
	private $_template = 'payment_way';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'系统管理', 'title'=>$this->_title), TRUE);
	}

	public function index($page = 0) {
                checkPermission($this->_template.'_index');
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$item_list = $this->tableObject->gets();

		$data = array(
		              'tool'=>$this->_tool,
				      'table'=>$this->_table,
				      'display_arr'=>$this->_display_arr,
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
                    checkPermission("{$this->_template}_edit");
                } else {
                    checkPermission("{$this->_template}_add");
                }
		$prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index";
		if ($_POST) {
		    $fields = array(
			          'title'=>$this->input->post('title', TRUE),
		              'sort'=>$this->input->post('sort'),
		              'percent'=>$this->input->post('percent'),
		    	      'content'=>$this->input->post('content', TRUE),
		              'remark'=>$this->input->post('remark', TRUE)
			          );
		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
		    	printAjaxSuccess($prfUrl, '操作成功');
			} else {
				printAjaxError("操作失败！");
			}
		}

		$item_info = $this->tableObject->get('*', array('id'=>$id));

	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
	            'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view("{$this->_table}/save", $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

	public function sort() {
            checkPermissionAjax("{$this->_template}_edit");
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
            checkPermissionAjax("{$this->_template}_edit");
		$ids = $this->input->post('ids');
		$display = $this->input->post('display');

		if (! empty($ids) && $display != "") {
			if($this->tableObject->save(array('display'=>$display), 'id in ('.$ids.')')) {
				printAjaxSuccess('', '修改状态成功！');
			}
		}

		printAjaxError('修改状态失败！');
	}
}
/* End of file link.php */
/* Location: ./application/admin/controllers/link.php */