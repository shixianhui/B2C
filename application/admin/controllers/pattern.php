<?php
class Pattern extends CI_Controller {
	private $_title = '模型管理';
	private $_tool = '';
	private $_table = '';
	private $_template = '';
	
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);
		//模型名
		$this->_template = $this->uri->segment(1);
		//获取表对象
		$this->load->model(ucfirst($this->_template).'_model', 'tableObject', TRUE);		
		$this->_tool = $this->load->view('element/pattern_tool.php', '', TRUE);
		$this->load->library('Pagination');
		$this->load->library('Session');
	}

	public function index() {
		checkPermission("{$this->_template}_index");
		$this->session->set_userdata(array("{$this->_template}RefUrl"=>base_url().'admincp.php/'.uri_string()));
				
		$itemList = $this->tableObject->gets('*');
		
		$data = array(
		             'tool'      =>   $this->_tool,
		             'template'=>     $this->_template,
				     'itemList'  =>   $itemList
		             );

	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view($this->_template.'/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);	   
	}

	public function save($id = NULL) {
		if ($id) {
			checkPermission("{$this->_template}_edit");
		} else {
			checkPermission("{$this->_template}_add");
		}
		$prfUrl = $this->session->userdata("{$this->_template}RefUrl")?$this->session->userdata("{$this->_template}RefUrl"):base_url()."admincp.php/{$this->_template}/index/";
		if ($_POST) {
			$fileName = $this->input->post('file_name', TRUE);
			$strWhere = "file_name = '{$fileName}'";
			if ($id) {
			    $strWhere .= " and id <> {$id}";
			}
			$count = $this->tableObject->rowCount($strWhere);
			if ($count > 0) {
			    printAjaxError('fail', "模型文件已经存在！");
			}
			$fields = array(
			          'title'=>$this->input->post('title', TRUE),
			          'alias'=>$this->input->post('alias', TRUE),
			          'title_color'=>$this->input->post('title_color', TRUE),
			          'file_name'=>$fileName,
			          'type'=>$this->input->post('type'),
			          'status'=>$this->input->post('status'),
			          'description'=>$this->input->post('description', TRUE),			        
			          'add_time'=>strtotime($this->input->post('add_time', TRUE))
			          );			
		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
				printAjaxSuccess($prfUrl);
			} else {
				printAjaxError('fail', "操作失败！");
			}
		}

		$itemInfo = $this->tableObject->get('*', array('id'=>$id));
		
		$data = array(
		        'tool'=>$this->_tool,
		        'itemInfo'=>$itemInfo,
		        'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view($this->_template.'/save', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}

	public function getKeycode() {
		$title = $this->input->post('title', TRUE);
		if ($title) {
			$splitword = new Splitwordclass();
			$keycode = $splitword->SplitRMM(iconv("UTF-8", "gbk", $title));
			$splitword->Clear();
			$keycode = iconv("gbk","UTF-8", $keycode);
			printAjaxData(array('keycode'=>$keycode));
		}
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

		printAjaxError('fail', '排序失败！');
	}

    public function delete() {
    	checkPermissionAjax("{$this->_template}_delete");
	    $ids = $this->input->post('ids', TRUE);

	    if (! empty($ids)) {
	        if ($this->tableObject->delete('id in ('.$ids.')')) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('fail', '删除失败！');
	}
	
	public function copy() {
		checkPermissionAjax("{$this->_template}_copy");
	    if ($_POST) {
	        $id = $this->input->post('id', TRUE);
	        $title = trim($this->input->post('title', TRUE));
	        $alias = trim($this->input->post('alias', TRUE));
	        $file_name = strtolower(trim($this->input->post('file_name', TRUE)));
	        
	        if (!$title) {
	            printAjaxError('fail', '请填写模型名称！');
	        }
	        if (!$alias) {
	            printAjaxError('fail', '请填写别名！');
	        }
	        if (!$file_name) {
	            printAjaxError('fail', '请填写模型文件名！');
	        }
	        if ($this->tableObject->rowCount(array('title'=>$title))) {
	            printAjaxError('fail', '模型名称已经存在！');
	        }
	        if ($this->tableObject->rowCount(array('alias'=>$alias))) {
	            printAjaxError('fail', '别名已经存在！');
	        }
	        if ($this->tableObject->rowCount(array('file_name'=>$file_name))) {
	            printAjaxError('fail', '模型文件名已经存在！');
	        }
	        $item_info = $this->tableObject->get('*', array('id'=>$id));
	        if (!$item_info) {
	            printAjaxError('fail', '被复制的模型不存在');
	        }
	        /***************************复制文件*****************************/
	        //控制器
	        $c_src_file = APPPATH."controllers/{$item_info['file_name']}.php";
	        $c_tag_file = APPPATH."controllers/{$file_name}.php";
	        if (copy($c_src_file, $c_tag_file)) {
	            $old_con = file_get_contents($c_tag_file);
		        $new_con = str_replace(ucfirst($item_info['file_name']), ucfirst($file_name), $old_con);
		        file_put_contents($c_tag_file, $new_con);
	        } else {
	            printAjaxError('fail', '复制控制器文件失败');
	        }
	        //模型
	        $m_src_file = APPPATH."models/{$item_info['file_name']}_model.php";
	        $m_tag_file = APPPATH."models/{$file_name}_model.php";
	        if (copy($m_src_file, $m_tag_file)) {
	            $old_con = file_get_contents($m_tag_file);
		        $new_con = str_replace(array(ucfirst($item_info['file_name']), $item_info['file_name']), array(ucfirst($file_name), $file_name), $old_con);
		        file_put_contents($m_tag_file, $new_con);
	        } else {
	        	@unlink($c_tag_file);
	            printAjaxError('fail', '复制控制器文件失败');
	        }
	        //视图
	        $v_src_file = APPPATH."views/{$item_info['file_name']}";
	        $v_tag_file = APPPATH."views/{$file_name}";
	        $this->_recurse_copy($v_src_file, $v_tag_file);	        
	        //添加模型
	        $fields = array(
			          'title'=>      $title,
			          'alias'=>      $alias,
			          'file_name'=>  $file_name,
			          'type'=>       '模块',
			          'status'=>     1,
			          'description'=>'',			        
			          'add_time'=>time()
			          );			
		    if ($this->tableObject->save($fields)) {
		    	//创建表
		    	$this->tableObject->create_table($item_info['file_name'], $file_name);
				printAjaxSuccess('success', '操作成功');
			} else {
				printAjaxError('fail', "操作失败！");
			}
	    }
	}
	
	public function delete_pattern() {
		checkPermissionAjax("{$this->_template}_delete_pattern");
		if ($_POST) {
		    $id = $this->input->post('id', TRUE);
		    
		    $item_info = $this->tableObject->get('*', array('id'=>$id));
	        if (!$item_info) {
	            printAjaxError('fail', '此模型不存在，删除失败');
	        }
	        //删除控制器
	        $c_src_file = APPPATH."controllers/{$item_info['file_name']}.php";
	        @unlink($c_src_file);
	        //删除模型
	        $m_src_file = APPPATH."models/{$item_info['file_name']}_model.php";
	        @unlink($m_src_file);
	        //删除视图
	        $v_src_file = APPPATH."views/{$item_info['file_name']}";
	        $this->deldir($v_src_file);
	        //删除表
		    if ($this->tableObject->delete(array('id'=>$id))) {
		    	$this->tableObject->del_table($item_info['file_name']);
	            printAjaxSuccess('success', '删除成功');
	        }
	        
	        printAjaxError('fail', '删除失败');
		}
	}
	
	 // 原目录，复制到的目录
    private function _recurse_copy($src, $dst) {
		$dir = opendir ( $src );
		@mkdir ( $dst );
		while ( false !== ($file = readdir ( $dir )) ) {
			if (($file != '.') && ($file != '..')) {
				if (is_dir ( $src . '/' . $file )) {
					recurse_copy ( $src . '/' . $file, $dst . '/' . $file );
				} else {
					copy ( $src . '/' . $file, $dst . '/' . $file );
				}
			}
		}
		closedir ( $dir );
	}
	
    private function deldir($dir) {
		//先删除目录下的文件：
		$dh = @opendir ( $dir );
		while ( $file = @readdir ( $dh ) ) {
			if ($file != "." && $file != "..") {
				$fullpath = $dir . "/" . $file;
				if (! is_dir ( $fullpath )) {
					@unlink ( $fullpath );
				} else {
					deldir ( $fullpath );
				}
			}
		}
		
		closedir ( $dh );
		//删除当前文件夹：
		if (rmdir ( $dir )) {
			return true;
		} else {
			return false;
		}
	}
}
/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */