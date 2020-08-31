<?php

class Jiameng extends CI_Controller {

    private $_table = 'jiameng';
    private $_template = 'jiameng';

    public function __construct() {
        parent::__construct();
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Area_model', '', TRUE);
    }

    public function index() {
        if ($_POST) {
            $name = $this->input->post('name', true);
            $mobile = $this->input->post('mobile', true);
            $address = $this->input->post('address', true);
            $content = $this->input->post('content', true);
            if (!$name) {
                printAjaxError('name', '姓名不能为空');
            }
            if (!$mobile) {
                printAjaxError('name', '电话不能为空');
            }
            if(!preg_match("/^1[356789]\d{9}/",$mobile)){
                printAjaxError('name', '手机格式有误');
            }
            $fields = array(
                'name' => $name,
                'mobile' => $mobile,
                'wechat_number' => '',
                'industry' => '',
                'province' => '',
                'city' => '',
                'region' => '',
                'address' => $address,
                'content' => $content,
                'add_time' => time(),
                'source' => $_SERVER['HTTP_REFERER']
            );
            $result = $this->tableObject->save($fields);
            if ($result) {
                printAjaxSuccess('success', '申请加盟成功');
            } else {
                printAjaxError('success', '申请加盟失败');
            }
        }
        if (is_mobile_request()) {
            $url = base_url() . getBaseUrl(false, "", "jiameng.html", 'weixin.php');
            redirect("{$url}");
            exit;
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
       
        $areaList = $this->Area_model->gets('*', array('parent_id' => 0));
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
            'areaList' => $areaList,
            'video_path' => $systemInfo['video_path']
        );
        $this->load->view('jiameng/index', $data);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }
  
}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */

