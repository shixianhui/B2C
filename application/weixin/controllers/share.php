<?php

class Share extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('System_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Attachment_model', '', TRUE);
        $this->load->model('Color_model', '', TRUE);
        $this->load->model('Size_model', '', TRUE);
        $this->load->model('Postage_way_model', '', TRUE);
        $this->load->model('Product_browse_model', '', TRUE);
        $this->load->model('Free_postage_setting_model', '', TRUE);
        $this->load->model('Promotion_ptkj_model', '', TRUE);
        $this->load->model('Comment_model', '', TRUE);
        $this->load->model('Pintuan_model', '', TRUE);
        $this->load->model('Flash_sale_model', '', TRUE);
    }

    //普通产品分享
    public function product($id = null) {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $systemInfo['client_index'] = 'weixin.php';
        $item_info = $this->Product_model->get('*', array('id' => $id));
        if (!$item_info) {
            $data = array(
                'user_msg' => '此产品不存在或被删除',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        //记录浏览次数
        $this->Product_model->save(array('hits' => $item_info['hits'] + 1), array('id' => $id));

        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        //评论列表
        $comment_list = $this->Comment_model->gets('*', array('product_id' => $id));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $item_info['title'] . $systemInfo['site_name'],
            'keywords' => $item_info['keyword'],
            'description' => $item_info['abstract'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'item_info' => $item_info,
            'attachment_list' => $attachment_list,
            'comment_list' => $comment_list,
        );
        $this->load->view('share/product', $data);
    }

    //全民砍价分享
    public function ptkj($id = 0) {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $systemInfo['client_index'] = 'weixin.php';
        $pintuan_info = $this->Promotion_ptkj_model->get('*', array('id' => $id));
        if (empty($pintuan_info)) {
            $data = array(
                'user_msg' => '不存在该参团活动',
                'user_url' => 'index.php'
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $timestamp = time();
        if ($timestamp > $pintuan_info['end_time'] || $timestamp < $pintuan_info['start_time']) {
            $data = array(
                'user_msg' => '该参团活动暂未开始或已结束',
                'user_url' => 'index.php'
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $item_info = array();
        if ($pintuan_info) {
            $item_info = $this->Product_model->get("*", array('id' => $pintuan_info['product_id']));
        }
        //记录浏览次数
        $this->Product_model->save(array('hits' => $item_info['hits'] + 1), array('id' => $id));

        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        //评论列表
        $comment_list = $this->Comment_model->gets('*', array('product_id' => $id));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '全民砍价分享' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info,
            'attachment_list' => $attachment_list,
            'comment_list' => $comment_list,
        );
        $this->load->view('share/ptkj', $data);
    }

    //限时秒杀分享
    public function xsms($id=null) {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $systemInfo['client_index'] = 'weixin.php';
       $flash_info = $this->Flash_sale_model->get('*', array('id' => $id));
        if (empty($flash_info)) {
            $data = array(
                'user_msg' => '不存在此限时抢购的商品',
                'user_url' => 'index.php'
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        
        $item_info = array();
        if ($flash_info) {
            $item_info = $this->Product_model->get("*", array('id' => $flash_info['product_id']));
        }
          //记录浏览次数
        $this->Product_model->save(array('hits' => $item_info['hits'] + 1), array('id' => $id));

        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        //评论列表
        $comment_list = $this->Comment_model->gets('*', array('product_id' => $id));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '限时秒杀分享' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
             'item_info' => $item_info,
            'attachment_list' => $attachment_list,
            'comment_list' => $comment_list,
        );
        $this->load->view('share/xsms', $data);
    }

    //竞猜分享
    public function jc($id) {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $systemInfo['client_index'] = 'weixin.php';

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '竞猜分享' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html']
        );
        $this->load->view('share/jc', $data);
    }

}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */