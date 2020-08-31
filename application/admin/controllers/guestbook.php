<?php
class Guestbook extends CI_Controller {
	private $_title = '留言管理';
	private $_tool = '';
	private $_table = '';
	public function __construct() {
		parent::__construct();
		//获取表名
		$this->_table = $this->uri->segment(1);		
		//快捷方式
		$this->_tool = $this->load->view("element/guestbook_tool", null, TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Menu_model', '', TRUE);
	}

	public function index($page = 0) {
	    if (! $this->uri->segment(2)) {
		    $this->session->unset_userdata(array('search'=>''));
		}
		$this->session->set_userdata(array("{$this->_table}RefUrl"=>base_url().'admincp.php/'.uri_string()));
		$strWhere = $this->session->userdata('search')?$this->session->userdata('search'):NULL;

		if ($_POST) {
			$strWhere = "{$this->_table}.id > 0";
			
			$type = $this->input->post('type');
			$userId = $this->input->post('user_id');
			$title = $this->input->post('title');
		    $startTime = $this->input->post('inputdate_start');
		    $endTime = $this->input->post('inputdate_end');

		    if ($type != NULL && $type != '') {
		        $strWhere .= " and type = {$type} ";
		    }
		    if (! empty($userId) ) {
		        $strWhere .= " and user_id = {$userId} ";
		    }
		    if ($title) {
		        $strWhere .= " and (contact_name = '{$title}' or phone = '{$title}' or mobile = '{$title}' or qq = '{$title}' or email = '{$title}' ) ";
		    }
		    if (! empty($startTime) && ! empty($endTime)) {
		    	$strWhere .= " and {$this->_table}.add_time > ".strtotime($startTime.' 00:00:00')." and {$this->_table}.add_time < ".strtotime($endTime.' 23:59:59')." ";
		    }
		    $this->session->set_userdata('search', $strWhere);
		}

		//分页
		$this->config->load('pagination_config', TRUE);
		$paginationCount = $this->tableObject->rowCount($strWhere);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_table}/index/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 3;
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();

		$itemList = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		$data = array(
		        'tool'      =>$this->_tool,
				'itemList'  =>$itemList,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		        'table'=>$this->_table
		        );

	    $layout = array(
			      'title'=>$this->_title,
				  'content'=>$this->load->view($this->_table.'/index', $data, TRUE)
			      );
	    $this->load->view('layout/default', $layout);	   
	}

	public function save($id = NULL) {
		$prfUrl = $this->session->userdata($this->_table.'RefUrl')?$this->session->userdata($this->_table.'RefUrl'):base_url()."admincp.php/{$this->_table}/index/";
		if ($_POST) {
			$fields = array(
			          'rep_content'=> $this->input->post('rep_content'),
			          'rep_time'=> time()
			          );
		    if ($this->tableObject->save($fields, $id?array('id'=>$id):$id)) {
				printAjaxSuccess($prfUrl);
			} else {
				printAjaxError("操作失败！");
			}
		}

		$itemInfo = $this->tableObject->get(array("{$this->_table}.id"=>$id));

		$data = array(
		        'tool'=>$this->_tool,
		        'table'=>$this->_table,
		        'itemInfo'=>$itemInfo,
		        'prfUrl'=>$prfUrl
		        );
		$layout = array(
		          'title'=>$this->_title,
				  'content'=>$this->load->view($this->_table.'/save', $data, TRUE)
		          );
		$this->load->view('layout/default', $layout);
	}
	
    public function delete() {
	    $ids = $this->input->post('ids', TRUE);

	    if (! empty($ids)) {
	        if ($this->tableObject->delete('id in ('.$ids.')')) {
	            printAjaxData(array('ids'=>explode(',', $ids)));
	        }
	    }

	    printAjaxError('删除失败！');
	}	
}
/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */