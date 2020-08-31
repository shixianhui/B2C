<?php
class Score_setting extends CI_Controller {
    private $_title = '积分设置';
    private $_tool = '';

    public function __construct() {
        parent::__construct();
        //快捷方式
        $this->_tool = $this->load->view('element/system_tool', array('parent_title'=>'系统管理', 'title'=>$this->_title), TRUE);
        $this->load->model('Score_setting_model', '', TRUE);
    }

    public function save() {
        if ($_POST) {
            checkPermissionAjax('score_setting');
            $fields = array(
                'login_score' =>     $this->input->post('login_score', TRUE),
                'reg_score' =>       $this->input->post('reg_score', TRUE),
            	'join_user_score'=>  $this->input->post('join_user_score', TRUE),
            	'join_seller_score'=>$this->input->post('join_seller_score', TRUE),
            	'rmb_to_score_gold'=>$this->input->post('rmb_to_score_gold', TRUE),
            	'rmb_to_score_silver'=>$this->input->post('rmb_to_score_silver', TRUE)
            );
            if ($this->Score_setting_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/score_setting/save');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->Score_setting_model->get('*', array('id' => 1));

        $data = array(
            'tool' => $this->_tool,
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('score_setting/save', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }
}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */