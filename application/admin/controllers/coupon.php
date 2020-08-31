<?php
class Coupon extends CI_Controller {
	private $_title = '优惠券相关设置';
	private $_tool = '';
	private $_table = 'coupon';
	private $_template = 'coupon';
	private $_coupon_arr =  array( '1'=>'免单优惠券', '2'=>'半价优惠券');
	private $_coupon_limit =  array( '1'=>'单件', '2'=>'多件');
	public function __construct() {
		parent::__construct();
         $this->load->model('System_model', '', TRUE);
		//获取表对象
		$this->load->model(ucfirst($this->_template).'_model', 'tableObject', TRUE);
		$this->_tool = $this->load->view('element/coupon_tool', array('table'=>$this->_table, 'title'=>$this->_title), TRUE);
	}

	public function index($clear = 0, $coupon_type = 1, $page = 0) {
        clearSession(array('search_index'));
        if ($clear) {
        	$clear = 0;
        	$this->session->unset_userdata(array('search_index'=>''));
        }
        $uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
        $uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$coupon_type}/{$page}";
        $this->session->set_userdata(array("{$this->_template}RefUrl"=>$uri_sg));
        $condition = "coupon_type = 1";
        if($coupon_type == 2){
        	$condition = "coupon_type = 2";
        }
        $strWhere = $this->session->userdata('search_index')?$this->session->userdata('search_index'):$condition;

        //分页
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationCount = $this->tableObject->rowCount($strWhere);
        $paginationConfig['base_url'] = base_url()."admincp.php/{$this->_template}/index/{$clear}/{$coupon_type}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 5;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);

		$data = array(
		            'tool'=>$this->_tool,
					'template'=>       $this->_template,
					'pagination'=>     $pagination,
					'paginationCount'=>$paginationCount,
					'pageCount'=>      ceil($paginationCount/$paginationConfig['per_page']),
					'item_list' =>     $item_list
		              );
	    $layout = array(
			      'title'=>$this->_title,
                  'content'=>$this->load->view($this->_template.'/index', $data, TRUE),
			      );
	    $this->load->view('layout/default', $layout);
	}

	public function save($id = NULL) {
            $prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index";
            if($_POST){
                 $lifetime = intval($this->input->post('lifetime',true));
                 $number = intval($this->input->post('number',true));
                 $coupon_type = $this->input->post('coupon_type',true);

                 if($lifetime < 0 || $number < 0){
                     printAjaxError('fail','使用期限或张数不能为0!');
                 }
                 $fields = array(
                     'coupon_type'  => $coupon_type,
                     'add_time'  => time(),
                     'uid'  => 0,
                     'lifetime'  => $lifetime*24*60*60,
                     'use_time'  => 0,
                 );
                 for($i=0;$i < $number;$i++){
                       $fields['coupon_number'] = $this->_getRandnum();
                       $this->tableObject->save($fields);
                 }

                 printAjaxSuccess(base_url().'admincp.php/coupon','生成成功！');
            }
            $data = array(
		        'tool'=>$this->_tool,
                'template'=>$this->_template,
                'coupon_arr'=>$this->_coupon_arr,
	            'prfUrl'=>$prfUrl
		        );
            $layout = array(
                      'title'=>$this->_title,
                      'content'=>$this->load->view($this->_template.'/save', $data, TRUE)
                      );
	   $this->load->view('layout/default', $layout);
	}

       public function rule(){
           $prfUrl = $this->session->userdata("{$this->_table}RefUrl")?$this->session->userdata("{$this->_table}RefUrl"):base_url()."admincp.php/{$this->_table}/index";
           $systemInfo = $this->System_model->get('free_coupon_path,half_price_coupon_path,half_price_coupon_limit,half_price_coupon_set_money');
           if($_POST){
                        $free_coupon_path = $this->input->post('free_coupon_path');
			$half_price_coupon_path = $this->input->post('half_price_coupon_path');
			$half_price_coupon_limit = $this->input->post('half_price_coupon_limit');
			$half_price_coupon_set_money = $this->input->post('half_price_coupon_set_money');
                        if(empty($free_coupon_path) || empty($half_price_coupon_path)){
                            printAjaxError('fail', '图片路径不能为空!');
                        }
                        if(intval($half_price_coupon_set_money) <= 0){
                            printAjaxError('fail', '金钱不能为空或不能小于0!');
                        }
                        $fields = array(
                            'free_coupon_path' => $free_coupon_path,
                            'half_price_coupon_path' => $half_price_coupon_path,
                            'half_price_coupon_limit' => $half_price_coupon_limit,
                            'half_price_coupon_set_money' => $half_price_coupon_set_money,

                        );
                        $result = $this->System_model->save($fields,'id = 1');
                        if($result){
                            printAjaxSuccess(base_url().'admincp.php/coupon/rule','保存成功！');
                        }else{
                            printAjaxError('fail','保存失败！');
                        }

           }
          $data = array(
		        'tool'=>$this->_tool,
                        'template'=>$this->_template,
                        'prfUrl' => $prfUrl,
                        'systemInfo' => $systemInfo,
                        'coupon_arr' => $this->_coupon_limit
		        );
         $layout = array(
                          'title'=>$this->_title,
                          'content'=>$this->load->view($this->_template.'/rule', $data, TRUE)
                  );
		$this->load->view('layout/default', $layout);

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
       //获取唯一的订单号
	private function _getRandnum() {
		//一秒钟一万件的量
		$randCode = '';
	    while (true) {
	    	$randCode = getRandCode(11);
	    	$count = $this->tableObject->rowCount(array('coupon_number'=>$randCode));
	    	if ($count > 0) {
	    		$randCode = '';
	    	    continue;
	    	} else {
	    		break;
	    	}
	    }

	    return $randCode;
	}
}
/* End of file admin.php */
/* Location: ./application/admin/controllers/admin.php */
