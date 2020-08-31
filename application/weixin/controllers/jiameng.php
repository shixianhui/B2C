<?php

class Jiameng extends CI_Controller {

    private $_table = 'jiameng';
    private $_template = 'jiameng';

    public function __construct() {
        parent::__construct();
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
    }

    public function index() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'],
//            'keywords' => $systemInfo['keyword'],
//            'description' => $systemInfo['abstract'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
        );
        $this->load->view('jiameng/index', $data);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }
    public function page1() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'],
//            'keywords' => $systemInfo['keyword'],
//            'description' => $systemInfo['abstract'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
        );
        $this->load->view('jiameng/page1', $data);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }
    public function page2() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'],
//            'keywords' => $systemInfo['keyword'],
//            'description' => $systemInfo['abstract'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
        );
        $this->load->view('jiameng/page2', $data);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }
  
}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */

