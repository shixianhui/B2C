<?php
class Flash_sale extends CI_Controller {
    private $_title = '限时抢购活动管理';
    private $_tool = '';
    private $_table = '';
    private $_template = 'flash_sale';

    public function __construct() {
        parent::__construct();
        //获取表名
        $this->_table = $this->uri->segment(1);
        //模型名
        $this->_template = $this->uri->segment(1);
        $this->_tool = $this->load->view("element/{$this->_table}_tool", array('table'=>$this->_table), TRUE);
        //获取表对象
        $this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Flash_sale_model', '', TRUE);
        $this->load->model('Flash_sale_record_model', '', TRUE);
    }

    public function index($clear = 0, $page = 0) {
        checkPermission("{$this->_template}_index");
        clearSession(array('search_index'));
	    if ($clear) {
	    	$clear = 0;
		    $this->session->unset_userdata(array('search_index'=>''));
		}
		$uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
		$uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$page}";
		$this->session->set_userdata(array("{$this->_template}RefUrl"=>$uri_sg));
    	$strWhere = $this->session->userdata('search_index')?$this->session->userdata('search_index'):NULL;

    	//分页
    	$this->config->load('pagination_config', TRUE);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationCount = $this->tableObject->rowCount($strWhere);
    	$paginationConfig['base_url'] = base_url()."admincp.php/{$this->_template}/index/{$clear}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
    	$this->pagination->initialize($paginationConfig);
    	$pagination = $this->pagination->create_links();

    	$item_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);

        $data = array(
            'tool' =>          $this->_tool,
        	'template'=>       $this->_template,
        	'pagination'=>     $pagination,
        	'paginationCount'=>$paginationCount,
        	'pageCount'=>      ceil($paginationCount/$paginationConfig['per_page']),
            'item_list' =>     $item_list
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_template}/index", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function save($id = NULL) {
         if ($id) {
                    checkPermission("{$this->_template}_edit");
                } else {
                    checkPermission("{$this->_template}_add");
                }
        $prfUrl = $this->session->userdata($this->_template.'RefUrl')?$this->session->userdata($this->_template.'RefUrl'):base_url()."admincp.php/{$this->_template}/index/1";
        $productInfo = array();
        if ($id) {
            $itemInfo = $this->Flash_sale_model->get('*', array('id' => $id));
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $itemInfo['product_id']));
        } else {
            $itemInfo = array();
        }
        if ($_POST) {
            $name = $this->input->post('name', true);
            $old_price = $this->input->post('old_price', true);
            $is_open = $this->input->post('is_open', true);
            $flash_sale_price = $this->input->post('flash_sale_price', true);
            $product_id = $this->input->post('product_id', true);
            $description = $this->input->post('description', true);
            $start_time = strtotime($this->input->post('start_time', true));;
            $end_time = strtotime($this->input->post('end_time', true));;
            if ($end_time <= $start_time) {
                printAjaxError('error', "结束时间必须大于活动开始时间");
            }
            if ($end_time < time()) {
                printAjaxError('error', "活动结束时间必须大于当前时间");
            }
            $tmp_data = $this->Flash_sale_model->get('*', array('product_id' => $product_id));
                if (empty($id) && !empty($tmp_data)) {
                    printAjaxError('error', '您已对此商品设为限时抢购活动');
                }
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $product_id));
            $fields = array(
                'name' => $name,
                'old_price' => $productInfo['sell_price'],
                'flash_sale_price' => $flash_sale_price,
                'product_id' => $product_id,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'is_open' => $is_open,
                'add_time' => time(),
                'path' => $productInfo['path'],
                'product_title' => $productInfo['title'],
                'description' => $description,
            );
            $retId = $this->Flash_sale_model->save($fields, $id ? array('id' => $id) : $id);
            if ($retId) {
                printAjaxSuccess($prfUrl, "保存成功");
            } else {
                printAjaxError('fail', "保存失败");
            }
        }
        $data = array(
            'tool' => $this->_tool,
            'itemInfo' => $itemInfo,
            'productInfo' => $productInfo,
        	'prfUrl'=>$prfUrl
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_template}/save", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function view($id = '') {
        checkPermission("{$this->_template}_index");
    	$prfUrl = $this->session->userdata($this->_template.'RefUrl')?$this->session->userdata($this->_template.'RefUrl'):base_url()."admincp.php/{$this->_template}/index/1";
    	$this->session->set_userdata(array("{$this->_template}RefUrl"=>base_url().'admincp.php/'.uri_string()));
        if ($id) {
            $itemInfo = $this->tableObject->get('*', array('id' => $id));
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $itemInfo['product_id']));
        }

        $data = array(
            'tool' => $this->_tool,
            'itemInfo' => $itemInfo,
            'productInfo' => $productInfo,
        	'template'=>     $this->_template,
        	'prfUrl'=>$prfUrl,
            'id' => $id,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_template}/view", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function delete() {
        checkPermissionAjax("{$this->_template}_delete");
    	if ($_POST) {
    		$ids = $this->input->post('ids', TRUE);
    		if (!$ids) {
    			printAjaxError('fail', '请选择删除项');
    		}
                $record = $this->Flash_sale_record_model->gets('flash_sale_id in ('.$ids.')');
                if($record){
                    printAjaxError('fail','有相关记录无法删除');
                }
    		if ($this->tableObject->delete('id in (' . $ids . ')')) {
    			printAjaxData(array('ids' => explode(',', $ids)));
    		}
    		printAjaxError('fail', '删除失败！');
    	}
    }
}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */