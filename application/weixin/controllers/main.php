<?php
class main extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('System_model', '', TRUE);
	}

	public function index() {
		$systemInfo = $this->System_model->get('*', array('id'=>1));
		$systemInfo['client_index'] = 'weixin.php';
		
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