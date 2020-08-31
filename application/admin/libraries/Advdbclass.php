<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 多次调用的方法集成
 *
 */
class Advdbclass {
	//获取路径地址名称
	public function getControllerName($controller = NULL) {
		$CI = & get_instance();
		$CI->load->model('Pattern_model', '', TRUE);
		$patternInfo = $CI->Pattern_model->get('title, alias', array('file_name'=>$controller));

	    return $patternInfo;
	}

	//获取关键词
	public function getSystem() {
		$CI = & get_instance();
		$CI->load->model('System_model', '', TRUE);

		return $CI->System_model->get('html', array('id'=>1));
	}

	//获取文章数
	public function getArticle($id = NULL) {
		$CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);

		return $CI->Menu_model->getArticle($id);
	}

	public function getPermissionsStr($adminGroupId = NULL) {
		$ret = false;
		$CI = & get_instance();
		$CI->load->model('Admin_group_model', '', TRUE);
		return $CI->Admin_group_model->get('permissions', array('id'=>$adminGroupId));
	}

	//获取权限
	public function getPermissions($adminGroupId = NULL, $permissionsItem = NULL) {
		$ret = false;
		$CI = & get_instance();
		$CI->load->model('Admin_group_model', '', TRUE);
		$admingroupInfo = $CI->Admin_group_model->get('permissions', array('id'=>$adminGroupId));
		if ($admingroupInfo) {
			$permissionArr = explode(',', $admingroupInfo['permissions']);
			if (in_array($permissionsItem, $permissionArr)) {
				$ret = true;
			}
		}

		return $ret;
	}
        /**
     * 发送消息
     * @param type $to_user_id
     * @param type $from_user_id
     * @param type $title
     * @param type $content
     * @param type $message_type
     * @return type
     */
    public function send_message($to_user_id = 0, $from_user_id = 0, $title = '', $content = '', $message_type = 'order') {
        $CI = & get_instance();
        $CI->load->model('Message_model', '', TRUE);
        $fields = array(
            'to_user_id' => $to_user_id,
            'from_user_id' => $from_user_id,
            'title' => $title,
            'content' => $content,
            'message_type' => $message_type,
            'is_read' => 0,
            'add_time' => time(),
        );
        $result = $CI->Message_model->save($fields);
        return $result;
    }

    //获取唯一邀请码
    public function get_unique_pop_code($field = 'pop_code'){
    	$CI = & get_instance();
    	$CI->load->model('User_model', '', TRUE);

    	$randCode = '';
    	while (true) {
    		$randCode = getRandCode(9);
    		$count = $CI->User_model->rowCount(array("{$field}" => $randCode));
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
// END Validateloginclass class

/* End of file Advdbclass.php */
/* Location: ./system/libraries/Advdbclass.php */