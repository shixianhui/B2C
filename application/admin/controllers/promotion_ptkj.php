<?php
class Promotion_ptkj extends CI_Controller {
    private $_title = '营销活动管理';
    private $_tool = '';
    private $_table = '';
    private $_template = 'promotion_ptkj';

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
        $this->load->model('Pintuan_model', '', TRUE);
        $this->load->model('Ptkj_record_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Flash_sale_model', '', TRUE);
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
        $pintuan_arr = array();
        $itemInfo = array();
        if ($id) {
            $itemInfo = $this->tableObject->get('*', array('id' => $id));
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $itemInfo['product_id']));
            $pintuan_arr = $this->Pintuan_model->gets(array('ptkj_id' => $id));
        } 
        if ($_POST) {
            $name = $this->input->post('name', true);
            $low_price = $this->input->post('low_price', true);
            $product_id = $this->input->post('product_id', true);
            $cut_total_money = $this->input->post('cut_total_money', true);
            $cut_times = $this->input->post('cut_times', true);
            $start_time = strtotime($this->input->post('start_time', true));
            $end_time = strtotime($this->input->post('end_time', true));
            $is_open = $this->input->post('is_open', true);
            $low_arr = $this->input->post('low', TRUE);
            $high_arr = $this->input->post('high', TRUE);
            $money_arr = $this->input->post('money', TRUE);
            if(empty($low_arr) || empty($high_arr) || empty($money_arr)){
                printAjaxError('error', "拼团规则不能为空!");
            }
            foreach($low_arr as $key=>$ls){
                if(!is_numeric($ls) || !is_numeric($high_arr[$key])){
                    printAjaxError('fail','拼团规则人数有一项格式错误');
                }
                if(empty($money_arr[$key])){
                    printAjaxError('fail','金钱不能为空');
                }
            }
           
            if ($end_time <= $start_time) {
                printAjaxError('error', "拼团活动结束时间必须大于拼团活动开始时间");
            }
            if ($end_time < time()) {
                printAjaxError('error', "拼团活动结束时间必须大于当前时间");
            }
            if (!empty($id) && time() > $itemInfo['start_time'] && time() < $itemInfo['end_time']) {
                $count = $this->Ptkj_record_model->rowCount(array('ptkj_id' => $id));
                if ($count > 0) {
                    printAjaxError('error', "活动正在进行,不可修改！");
                }
            }
            if (empty($id)) {
                $tmp_data = $this->tableObject->get('*', array('product_id' => $product_id));
                if (!empty($tmp_data) && time() > $tmp_data['start_time'] && time() < $tmp_data['end_time']) {
                    printAjaxError('error', '活动期间，不可以有两种相同商品设置拼团活动');
                }
            }
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $product_id));
             if($cut_total_money > $productInfo['sell_price'] - $low_price){
                 printAjaxError('fail','砍价总金额设置异常');
            }
            $fields = array(
                'name' => $name,
                'low_price' => $low_price,
                'product_id' => $product_id,
                'cut_total_money' => $cut_total_money,
                'cut_times' => $cut_times,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'is_open' => $is_open,
                'add_time' => time(),
                'path' => $productInfo['path'],
                'high_price' => $productInfo['sell_price'],
            );
            $retId = $this->tableObject->save($fields, $id ? array('id' => $id) : $id);

            if ($retId) {
                $retId = $id ? $id : $retId;
                $this->Pintuan_model->delete(array('ptkj_id' => $retId));
                    foreach ($low_arr as $key => $ls) {
                        $fields_data = array(
                            'low' => $ls,
                            'high' => $high_arr[$key],
                            'money' => $money_arr[$key],
                            'ptkj_id' => $retId,
                            'add_time' => time(),
                        );
                        $this->Pintuan_model->save($fields_data);
                    }    
                printAjaxSuccess($prfUrl, "保存成功");
            } else {
                printAjaxError('fail', "保存失败");
            }
        }
        $data = array(
            'tool' => $this->_tool,
            'itemInfo' => $itemInfo,
            'productInfo' => $productInfo,
            'pintuan_arr' => $pintuan_arr,
        	'prfUrl'=>$prfUrl,
            'id' => $id,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view("{$this->_template}/save", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function view($id = '') {
        checkPermission("{$this->_template}_edit");
    	$prfUrl = $this->session->userdata($this->_template.'RefUrl')?$this->session->userdata($this->_template.'RefUrl'):base_url()."admincp.php/{$this->_template}/index/1";
    	$this->session->set_userdata(array("{$this->_template}RefUrl"=>base_url().'admincp.php/'.uri_string()));
        if ($id) {
            $itemInfo = $this->tableObject->get('*', array('id' => $id));
            $productInfo = $this->Product_model->get('path,title,sell_price', array('id' => $itemInfo['product_id']));
            $pintuan_arr = $this->Pintuan_model->gets(array('ptkj_id' => $id));
        }

        $data = array(
            'tool' => $this->_tool,
            'itemInfo' => $itemInfo,
            'productInfo' => $productInfo,
            'pintuan_arr' => $pintuan_arr,
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
    	    $count = $this->Ptkj_record_model->rowCount("ptkj_id in ($ids)");
    		if ($count > 0) {
    			printAjaxError('fail', '有相关记录,不可删除！');
    		}
    		if ($this->tableObject->delete('id in (' . $ids . ')')) {
    			//删除拼团规则
    			$this->Pintuan_model->delete("ptkj_id in ({$ids})");
    			printAjaxData(array('ids' => explode(',', $ids)));
    		}
    		printAjaxError('fail', '删除失败！');
    	}
    }
}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */