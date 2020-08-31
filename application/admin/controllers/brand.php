<?php
class Brand extends CI_Controller {
	private $_title = '品牌管理';
	private $_tool = '';
	private $_table = '';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//快捷方式
		$this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'商品管理', 'title'=>'品牌'), TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Product_category_model', '', TRUE);
		$this->load->model('Brand_category_ids_model', '', TRUE);
		$this->load->library('ChineseToPinyinclass');
	}

	public function index($clear = 0) {
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
		if ($item_list) {
			foreach ($item_list as $key=>$value) {
				//分类
				$product_category_str = '';
				$b_c_i_list = $this->Brand_category_ids_model->gets('*', array('brand_id' => $value['id']));
				if ($b_c_i_list) {
					foreach ($b_c_i_list as $p_c_i_key => $p_c_i_value) {
						$product_category_str .= $this->Product_category_model->getLocation($p_c_i_value['product_category_id']) . '<br/>';
					}
					if ($product_category_str) {
						$product_category_str = substr($product_category_str, 0, -1);
					}
				}
				$item_list[$key]['product_category_str'] = $product_category_str;
			}
		}

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
		    if ($id) {
		    	$first_letter = trim($this->input->post('first_letter', TRUE));
		    	$brand_name = trim($this->input->post('brand_name', TRUE));
		    	$tag = trim($this->input->post('tag', TRUE));
		    	$product_category_id_arr = $this->input->post('product_category_id', TRUE);

				$fields = array(
				          'brand_name'=>  $brand_name,
						  'tag'=>         $tag,
				          'path'=>        $this->input->post('path', TRUE),
				          'first_letter'=>$first_letter?strtoupper(substr($first_letter, 0, 1)):strtoupper(substr($this->_get_pinyin($brand_name), 0, 1)),
		    		      'sort'=>        $this->input->post('sort', TRUE)
				          );
			    if ($this->tableObject->save($fields, array('id'=>$id))) {
			    	/*****************添加分类ID******************** */
			    	$this->Brand_category_ids_model->delete(array('brand_id' => $id));
			    	if ($product_category_id_arr) {
			    		foreach ($product_category_id_arr as $key => $value) {
			    			$id_arr = explode(",", $value);
			    			if ($id_arr && count($id_arr) > 1) {
			    				$pc_fields = array(
			    						'parent_id' => $id_arr[0],
			    						'product_category_id' => $id_arr[1],
			    						'brand_id' => $id
			    				);
			    				$this->Brand_category_ids_model->save($pc_fields);
			    			}
			    		}
			    	}
					printAjaxSuccess($prfUrl);
				} else {
					printAjaxError("操作失败！");
				}
			} else {
				$i = 0;
				$tag = trim($this->input->post('tag', TRUE));
				$brand_name = $this->input->post('brand_name', TRUE);
				$sort = $this->input->post('sort', TRUE);
				$brand_name = preg_replace(array('/^\|+/', '/\|+$/'), array('', ''), $brand_name);
				$brand_name_arr = explode("|", $brand_name);
				foreach ($brand_name_arr as $key=>$value) {
					$fields = array(
				          'sort'=>$sort+$key,
						  'tag'=>         $tag,
						  'path'=>$this->input->post('path', TRUE),
						  'first_letter' =>  strtoupper(substr($this->_get_pinyin(trim($value)), 0, 1)),
				          'brand_name'=>trim($value)
				          );
					 $ret_id = $this->tableObject->save($fields);
			         if ($ret_id) {
			         	/*****************添加分类ID******************** */
			         	if ($product_category_id_arr) {
			         		foreach ($product_category_id_arr as $key => $value) {
			         			$id_arr = explode(",", $value);
			         			if ($id_arr && count($id_arr) > 1) {
			         				$pc_fields = array(
			         						'parent_id' => $id_arr[0],
			         						'product_category_id' => $id_arr[1],
			         						'brand_id' => $ret_id
			         				);
			         				$this->Brand_category_ids_model->save($pc_fields);
			         			}
			         		}
			         	}
			             $i++;
			         }
				}
				if (count($brand_name_arr) == $i) {
				    printAjaxSuccess($prfUrl);
				} else {
				    printAjaxError("操作失败！");
				}
			}
		}

		$item_info = $this->tableObject->get('*', array("{$this->_table}.id"=>$id));
		//产品分类
		$product_category_list = $this->Product_category_model->menuTree();
		$bci_info = $this->Brand_category_ids_model->gets('product_category_id', array('brand_id' => $id));

	    $data = array(
		        'tool'=>$this->_tool,
	            'item_info'=>$item_info,
	    		'table'=>$this->_table,
	    		'product_category_list'=>$product_category_list,
	    		'bci_info'=>$bci_info,
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

	private function _get_pinyin($str = NULL) {
		$ret = '';
		if (!empty($str)) {
			$chineseToPinyinclass = new ChineseToPinyinclass();
			$ret = @$chineseToPinyinclass->Pinyin(strtolower($str), 'utf-8');
		}

		return $ret;
	}
}
/* End of file admingroup.php */
/* Location: ./application/admin/controllers/admingroup.php */