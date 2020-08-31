<?php
class Postage_way extends CI_Controller {
	private $_title = '配送方式';
	private $_tool = '';
	private $_table = '';
	private $_display_arr = array('0'=>'<font color="#FF0000">隐藏</font>', '1'=>'显示');
	private $_template = 'postage_way';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'系统管理', 'title'=>$this->_title), TRUE);
		$this->load->model('Postage_price_model', '', TRUE);
		$this->load->model('Area_model', '', TRUE);
	}

	public function index() {
               checkPermission($this->_template.'_index');
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$item_list = $this->tableObject->gets();
		if ($item_list) {
		   foreach ($item_list as $key=>$postageway) {
		       $item_list[$key]['postagepriceList'] = $this->Postage_price_model->gets('*', array('postage_way_id'=>$postageway['id']));
		   }
		}

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
			$areaNames = $this->input->post('area_name');
			$startPrices = $this->input->post('start_price');
			$addPrices = $this->input->post('add_price');
		    $fields = array(
			          'title'=>$this->input->post('title', TRUE),
		              'sort'=>$this->input->post('sort'),
		              'content'=>$this->input->post('content', TRUE)
			          );
			$retId = $this->tableObject->save($fields, $id?array('id'=>$id):$id);
		    if ($retId) {
		    	//修改时删除原来所有的
		    	if ($id) {
		    		$this->Postage_price_model->delete(array('postage_way_id'=>$id));
		    	}
		    	//添加数据
		    	if ($areaNames) {
				    foreach ($areaNames as $key=>$areaName) {
				        $data = array(
					    	    'postage_way_id'=>$id?$id:$retId,
					    	    'area'=>$areaNames[$key],
					    	    'start_price'=>$startPrices[$key],
					    	    'add_price'=>$addPrices[$key]
					    	     );
					    $this->Postage_price_model->save($data);
				    }
		    	}
		    	printAjaxSuccess($prfUrl, '操作成功');
			} else {
				printAjaxError("操作失败！");
			}
		}

		$item_info = $this->tableObject->get('*', array('id'=>$id));
		if ($item_info) {
			$item_info['postagepriceList'] = $this->Postage_price_model->gets('*', array('postage_way_id'=>$id));
		}
		$areaList = $this->Area_model->gets('*', array('parent_id'=>0));

	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
	            'areaList'=>$areaList,
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

    public function delete() {
            checkPermissionAjax("{$this->_template}_delete");
	    $ids = $this->input->post('ids', TRUE);
	    if (! empty($ids)) {
	        if ($this->tableObject->delete('id in ('.$ids.')')) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
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