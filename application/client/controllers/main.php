<?php
class main extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
		$this->load->model('Product_model', '', TRUE);
		$this->load->model('Floor_model', '', TRUE);
		$this->load->model('News_model', '', TRUE);
	}

	public function index() {
		$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
		$this->load->library('user_agent');
        if ($this->agent->is_mobile()) {
            redirect(base_url().'wx/index_weixin.html');
        }
		$systemInfo = $this->System_model->get('*', array('id'=>1));
		$menuList = $this->Menu_model->gets('id, menu_name, model, template, html_path', array('hide'=>'0', 'parent'=>0));
        //促销精选
		$hot_product_list = $this->Product_model->gets('product.id,product.title,product.sell_price,product.favorite_num,product.path,product.abstract', array('display'=>1), 8, 0, 'product.sales');
        $floor_list = $this->Floor_model->gets();
		
		$data = array(
				'site_name'=>$systemInfo['index_site_name'],
				'index_name'=>$systemInfo['index_name'],
		        'client_index'=>$systemInfo['client_index'],
				'title'=>$systemInfo['index_site_name'],
		        'keywords'=>$systemInfo['site_keycode'],
		        'description'=>$systemInfo['site_description'],
		        'site_copyright'=>$systemInfo['site_copyright'],
				'icp_code'=>$systemInfo['icp_code'],
				'html'=>$systemInfo['html'],
				'parentId'=>'0',
		        'hot_product_list'=>$hot_product_list,
                        'floor_list' => $floor_list
		        );

	    $layout = array(
				  'content'=>$this->load->view('main/index', $data, TRUE)
			      );
	    $this->load->view('layout/index', $layout);
	    //缓存
	    if ($systemInfo['cache'] == 1) {
	    	$this->output->cache($systemInfo['cache_time']);
	    }
	}
}
/* End of file main.php */
/* Location: ./application/client/controllers/main.php */