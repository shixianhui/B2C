<?php
class T extends CI_Controller {
	private $_distributor_status_arr = array('0'=>'<font color="red">待审核</font>', '1'=>'正常', '2'=>'<font color="red">审核暂无通过</font>', '3'=>'<font color="red">推广被禁用</font>');
	public function __construct() {
		parent::__construct();
		$this->load->model('User_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
	}

	public function i($refereeCode = NULL) {
	    if ($refereeCode) {
        	$itemInfo = $this->User_model->get('id,distributor_status,distributor_client_remark,distributor,school_distributor,net_distributor', array("pop_code"=>$refereeCode));
        	if ($itemInfo) {
        		if ($itemInfo['distributor_status'] != 1) {
        			$canse = $itemInfo['distributor_client_remark'];
        			if ($canse) {
        				$canse .= "[{$canse}]";
        			}
        			$data = array(
        					'user_msg'=>$this->_distributor_status_arr[$itemInfo['distributor_status']].$canse,
        					'user_url'=> base_url()
        			);

        			$this->session->set_userdata($data);
        			redirect(base_url().'index.php/message/index');
        			exit;
        		}
        		$cookie1 = array(
        				'name'  =>'g_pop_code',
        				'value' =>$refereeCode,
        				'expire'=>5184000
        		);
        		set_cookie($cookie1);

        		if (is_mobile_request()) {
        			if($itemInfo['distributor'] == 1 || $itemInfo['school_distributor'] == 1 || $itemInfo['net_distributor'] == 1) {
        				$url = base_url().getBaseUrl(false, "", "join/city.html", 'weixin.php');
        				redirect("{$url}");
						exit;
        			} else if ($itemInfo['distributor'] == 2 || $itemInfo['school_distributor'] == 2 || $itemInfo['net_distributor'] == 2) {
        				$url = base_url().getBaseUrl(false, "", "join/store.html", 'weixin.php');
        				redirect("{$url}");
						exit;
        			}
        		} else {
        			$url = base_url().getBaseUrl(false, "", "user/register.html", 'index.php');
        			redirect("{$url}");
					exit;
        		}
            }
        }
        if (is_mobile_request()) {
        	$url = base_url().'weixin.php';
        	redirect("{$url}");
			exit;
        } else {
        	redirect(base_url());
			exit;
        }
	}
}
/* End of file main.php */
/* Location: ./application/client/controllers/main.php */