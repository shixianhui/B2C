<?php

class Join extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('System_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Sms_model', '', TRUE);
        $this->load->model('Score_setting_model', '', TRUE);
        $this->load->model('Score_model', '', TRUE);
        $this->load->model('Ptkj_record_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Promotion_ptkj_model', '', TRUE);
        $this->load->model('Pintuan_model', '', TRUE);
        $this->load->model('Chop_record_model', '', TRUE);
        $this->load->model('Attachment_model', '', TRUE);
		$this->load->model('Area_model', '', TRUE);
		$this->load->model('Jiameng_model', '', TRUE);
        $this->load->helper('my_ajaxerror');
        $this->load->library('Form_validation');
        $this->load->library('Securitysecoderclass');
    }

    public function add() {
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
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
    		$result = $this->Jiameng_model->save($fields);
    		if ($result) {
    			printAjaxSuccess('success', '申请加盟成功');
    		} else {
    			printAjaxError('success', '申请加盟失败');
    		}
    	}

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => '商家加盟' . $systemInfo['site_name'],
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'systemInfo' => $systemInfo,
    			'html' => $systemInfo['html']
    	);
    	$this->load->view('join/add', $data);
    }

    public function city() {
        $refereeCode = get_cookie('g_pop_code');
        if (!$refereeCode) {
            $data = array(
                'user_msg' => '你访问的页面不存在',
                'user_url' => base_url() . "weixin.php"
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'weixin.php/message/index');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $systemInfo['client_index'] = 'weixin.php';
        $itemInfo = $this->User_model->get('id,distributor_status,distributor_client_remark,distributor, school_distributor, net_distributor', array("pop_code" => $refereeCode));
        if (!$itemInfo) {
            $data = array(
                'user_msg' => '你访问的页面不存在',
                'user_url' => base_url() . "weixin.php"
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'weixin.php/message/index');
            exit;
        }
        if ($itemInfo['distributor_status'] != 1) {
        	$canse = $itemInfo['distributor_client_remark'];
        	if ($canse) {
        		$canse .= "[{$canse}]";
        	}
        	$data = array(
        			'user_msg'=>$this->_distributor_status_arr[$itemInfo['distributor_status']].$canse,
        			'user_url'=> base_url() . "weixin.php"
        	);

        	$this->session->set_userdata($data);
        	redirect(base_url().'index.php/message/index');
        	exit;
        }
        if ($itemInfo['distributor'] != 1 && $itemInfo['school_distributor'] != 1 && $itemInfo['net_distributor'] != 1) {
            $data = array(
                'user_msg' => '你访问的页面不存在',
                'user_url' => base_url() . "weixin.php"
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'weixin.php/message/index');
            exit;
        }
        $title_str = '';
        $title_str_2 = '';
        if ($itemInfo['distributor'] == 1) {
        	$title_str = '店级合伙人加盟';
        	$title_str_2 = '店级合伙人';
        }
        if ($itemInfo['school_distributor'] == 1) {
        	$title_str = '校园二级分销商加盟';
        	$title_str_2 = '校园二级分销商';
        }
        if ($itemInfo['net_distributor'] == 1) {
        	$title_str = '网络二级分销商加盟';
        	$title_str_2 = '网络二级分销商';
        }
		$item_list = $this->Area_model->gets("id as 'value', name as 'text'", array('parent_id'=>0, 'display'=>1));
	    if ($item_list) {
	        foreach ($item_list as $key=>$value) {
	            $sub_item_list = $this->Area_model->gets("id as 'value', name as 'text'", array('parent_id'=>$value['value'], 'display'=>1));
	            if ($sub_item_list) {
	                foreach ($sub_item_list as $s_key=>$s_value) {
	                    $sub_item_list[$s_key]['children'] = $this->Area_model->gets("id as 'value', name as 'text'", array('parent_id'=>$s_value['value'], 'display'=>1));
	                }
	            }
	            $item_list[$key]['children'] = $sub_item_list;
	        }
	    }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $title_str . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'pop_code' => $refereeCode,
            'systemInfo' => $systemInfo,
            'item_list'=>$item_list,
        	'title_str'=>$title_str,
        	'title_str_2'=>$title_str_2,
            'html' => $systemInfo['html']
        );
        $this->load->view('join/city', $data);
    }

    public function store() {
        $refereeCode = get_cookie('g_pop_code');
        if (!$refereeCode) {
            $data = array(
                'user_msg' => '你访问的页面不存在',
                'user_url' => base_url() . "weixin.php"
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'weixin.php/message/index');
        }
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $systemInfo['client_index'] = 'weixin.php';
        $itemInfo = $this->User_model->get('id,distributor_status,distributor_client_remark,distributor, school_distributor, net_distributor', array("pop_code" => $refereeCode));
        if (!$itemInfo) {
            $data = array(
                'user_msg' => '你访问的页面不存在',
                'user_url' => base_url() . "weixin.php"
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'weixin.php/message/index');
        }
        if ($itemInfo['distributor_status'] != 1) {
        	$canse = $itemInfo['distributor_client_remark'];
        	if ($canse) {
        		$canse .= "[{$canse}]";
        	}
        	$data = array(
        			'user_msg'=>$this->_distributor_status_arr[$itemInfo['distributor_status']].$canse,
        			'user_url'=> base_url() . "weixin.php"
        	);

        	$this->session->set_userdata($data);
        	redirect(base_url().'index.php/message/index');
        	exit;
        }
        if ($itemInfo['distributor'] != 2 && $itemInfo['school_distributor'] != 2 && $itemInfo['net_distributor'] != 2) {
            $data = array(
                'user_msg' => '你访问的页面不存在',
                'user_url' => base_url() . "weixin.php"
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'weixin.php/message/index');
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '客户推荐' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'systemInfo' => $systemInfo,
            'pop_code' => $refereeCode,
            'presenter_store_text' => $systemInfo['presenter_store_text'],
            'html' => $systemInfo['html']
        );
        $this->load->view('join/store', $data);
    }

    //砍价界面
    public function chop_price($ptkj_record_id = '') {
        if (!is_mobile_request()) {
            //跳转到pc
            $sign = $this->input->get('sign', true);
            $url = base_url() . getBaseUrl(false, "", "bargain/chop_price/{$ptkj_record_id}?sign={$sign}", 'index.php');
            redirect("{$url}");
            exit;
        } else {
            include_once( 'sdk/authlogin/wblogin/config.php' );
            include_once( 'sdk/authlogin/wblogin/saetv2.ex.class.php' );
            $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
            $code_url = $o->getAuthorizeURL(WB_CALLBACK_URL);
            $systemInfo = $this->System_model->get('*', array('id' => 1));
            $systemInfo['client_index'] = 'weixin.php';
            $this->session->set_userdata('gloabPreUrl', base_url().$_SERVER['REQUEST_URI']);
            $sign = $this->input->get('sign', true);
            if (md5('mykey' . $ptkj_record_id) !== $sign) {
                $data = array(
                    'user_msg' => 'sign参数不正确',
                    'user_url' => 'index.php'
                );
                $this->session->set_userdata($data);
                redirect('/message/index');
            }
            $ptkj_record = $this->Ptkj_record_model->get(array('ptkj_record.id ' => $ptkj_record_id));
            $item_info = array();
            $pintuan_count = 0;
            if ($ptkj_record) {
                $item_info = $this->Product_model->get("*", array('id' => $ptkj_record['product_id']));
                $pintuan_count = $this->Ptkj_record_model->rowCount(array('ptkj_id' => $ptkj_record['ptkj_id']));
                $pintuan_info = $this->Promotion_ptkj_model->get('*', array('id' => $ptkj_record['ptkj_id']));
                $pintuan_rule = $this->Pintuan_model->gets(array('ptkj_id' => $ptkj_record['ptkj_id']));
                $chop_arr = $this->Chop_record_model->get('sum(chop_price) as sum', "user_id = {$ptkj_record['user_id']} and ptkj_record_id = $ptkj_record_id and chop_user_id is not null");
                $choped_price = $chop_arr['sum'] ? $chop_arr['sum'] : '0.00';
                  //判断当前拼团人数是否在区间,确定拼团价格
                if (!empty($pintuan_rule)) {
                    foreach ($pintuan_rule as $value) {
                        if ($pintuan_info['pintuan_people'] >= $value['low'] && $pintuan_info['pintuan_people'] <= $value['high']) {
                            $pintuan_price = $value['money'];
                            $current_price = number_format($value['money'] - $choped_price, 2);
                        }
                    }
                }
                $chop_record = $this->Chop_record_model->gets('*', "user_id = {$ptkj_record['user_id']} and ptkj_record_id = {$ptkj_record_id} and chop_user_id is not null");
                foreach($chop_record as $key=>$ls){
                    $chopUserInfo = $this->User_model->get('path,nickname,username',array('id'=>$ls['chop_user_id']));
                    $chop_record[$key]['path'] = preg_match("/^http/",$chopUserInfo['path']) ? $chopUserInfo['path'] : str_replace('.','_thumb.', $chopUserInfo['path']);
                    $chop_record[$key]['nickname'] = $chopUserInfo['nickname'] ? $chopUserInfo['nickname'] : hideStar($chopUserInfo['username']);
                }
            }

            $attachment_list = NULL;
            if ($item_info && $item_info['batch_path_ids']) {
                $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
                $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
            }
            $data = array(
                'site_name' => $systemInfo['site_name'],
                'index_name' => $systemInfo['index_name'],
                'index_url' => $systemInfo['index_url'],
                'client_index' => $systemInfo['client_index'],
                'title' => '拼团砍价' . $systemInfo['site_name'],
                'keywords' => $systemInfo['site_keycode'],
                'description' => $systemInfo['site_description'],
                'site_copyright' => $systemInfo['site_copyright'],
                'icp_code' => $systemInfo['icp_code'],
                'html' => $systemInfo['html'],
                'item_info' => $item_info,
                'attachment_list' => $attachment_list,
                'pintuan_count' => $pintuan_count,
                'ptkj_record' => $ptkj_record,
                'pintuan_info' => $pintuan_info,
                'pintuan_rule' => $pintuan_rule,
                'choped_price' => $choped_price,
                'chop_record' => $chop_record,
                'url' => base_url() . 'weixin.php/join/chop_price/' . $ptkj_record_id . '?sign=' . $sign,
                'title' => $item_info['title'],
                'pic' => $item_info['path'],
                'pintuan_price' => $pintuan_price,
                'current_price' => $current_price,
                'code_url' => $code_url,
                'sign' => $sign,
                'ptkj_record_id' => $ptkj_record_id,
            );
            $this->load->view('join/chop_price', $data);
        }
    }

    public function reg() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        if ($_POST) {
            $username = trim($this->input->post('username', TRUE));
            $code = trim($this->input->post('code', TRUE));
            $type = $this->input->post('type', TRUE);
			$province_id = $this->input->post('province_id', TRUE);
			$city_id = $this->input->post('city_id', TRUE);
			$area_id = $this->input->post('area_id', TRUE);
			$txt_address = $this->input->post('txt_address', TRUE);
			$address = $this->input->post('address', TRUE);

            if ($type == 2) {
            	if (!$province_id || !$city_id || !$area_id) {
            		printAjaxError('txt_address', '请选择地区');
            	}
            	if (!$txt_address) {
            		printAjaxError('txt_address', '请选择地区');
            	}
				if (!$address) {
            		printAjaxError('address', '请填写详细地址');
            	}
            }
            if (!$this->form_validation->required($username)) {
                printAjaxError('username', '请输入手机号码');
            }
            if (!$this->form_validation->max_length($username, 32)) {
                printAjaxError('username', '用户名长度不能大于32字符');
            }
            if ($this->User_model->validateUnique($username)) {
                printAjaxError('username', '手机号已经存在，请换一个');
            }
            if (!$this->form_validation->required($code)) {
                printAjaxError('code', '请输入短信验证码');
            }
            if (!get_cookie('g_pop_code')) {
                if ($type == 2) {
                    printAjaxError('fail', '操作页面异常，加盟失败');
                } else {
                    printAjaxError('fail', '操作页面异常，积分领取失败');
                }
            }
            if ($type != '2' && $type != '0') {
                printAjaxError('fail', '操作页面异常');
            }
            //推荐人
            $presenter_id = 0;
            $presenter_username = '';
            $distributor = 0;
            $score_type = '';
            $password = '123456';
            $tmp_user_info = $this->User_model->get('id, username,distributor_status,distributor, school_distributor, net_distributor', array('pop_code' => get_cookie('g_pop_code')));
            if (!$tmp_user_info) {
                printAjaxError('fail', '操作页面异常，注册失败');
            }
            if ($tmp_user_info['distributor_status'] == 0) {
            	printAjaxError('fail', '此分销商还在审核中，暂时不能推广用户');
            } else if ($tmp_user_info['distributor_status'] == 2 || $tmp_user_info['distributor_status'] == 3) {
            	printAjaxError('fail', '此分销商没有推广用户的权限');
            }
            if ($type == '2') {
                if ($tmp_user_info['distributor'] != 1 && $tmp_user_info['school_distributor'] != 1 && $tmp_user_info['net_distributor'] != 1) {
                    printAjaxError('fail', '操作页面异常，加盟失败');
                }
            } else if ($type == '0') {
                if ($tmp_user_info['distributor'] != 2 && $tmp_user_info['school_distributor'] != 2 && $tmp_user_info['net_distributor'] != 2) {
                    printAjaxError('fail', '操作页面异常，积分领取失败');
                }
            }
            $timestamp = time();
            if (!$this->Sms_model->get('id', "smscode = '{$code}' and mobile = '{$username}' and add_time > {$timestamp} - 15*60")) {
                printAjaxError('code', '短信验证码错误或者已过期');
            }
            $addTime = time();
            $ip_arr = getUserIPAddress();
            $fields = array(
                'user_group_id' => 1,
                'username' => $username,
                'login_time' => time(),
                'ip' => $ip_arr[0],
                'ip_address' => $ip_arr[1],
                'password' => $this->_createPasswordSALT($username, $addTime, $password),
                'mobile' => $username,
                'add_time' => $addTime,
                'presenter_id' => $presenter_id,
                'presenter_username' => $presenter_username
            );
			if ($type == 2) {
				$fields['province_id'] = $province_id;
				$fields['city_id'] =     $city_id;
				$fields['area_id'] =     $area_id;
				$fields['txt_address'] = $txt_address;
				$fields['address'] =     $address;
			}
            $score_setting_info = $this->Score_setting_model->get('reg_score, store_score, school_score, net_score', array('id' => 1));
            if ($tmp_user_info['distributor'] == 1) {
            	$presenter_id = $tmp_user_info['id'];
            	$presenter_username = $tmp_user_info['username'];
            	$distributor = 2;
            	$fields['distributor'] = 2;
            	$fields['score'] = $score_setting_info['reg_score'];
            	$score_type = 'reg_score_in';
            } else if ($tmp_user_info['distributor'] == 2) {
            	$presenter_id = $tmp_user_info['id'];
            	$presenter_username = $tmp_user_info['username'];
            	$distributor = 0;
            	$fields['distributor'] = 0;
            	$fields['score'] = $score_setting_info['store_score'];
            	$score_type = 'store_score_in';
            } else if ($tmp_user_info['school_distributor'] == 1) {
            	$presenter_id = $tmp_user_info['id'];
            	$presenter_username = $tmp_user_info['username'];
            	$distributor = 2;
            	$fields['school_distributor'] = 2;
            	$fields['score'] = $score_setting_info['reg_score'];
            	$score_type = 'reg_score_in';
            } else if ($tmp_user_info['school_distributor'] == 2) {
            	$presenter_id = $tmp_user_info['id'];
            	$presenter_username = $tmp_user_info['username'];
            	$distributor = 0;
            	$fields['school_distributor'] = 0;
            	$fields['score'] = $score_setting_info['school_score'];
            	$score_type = 'school_score_in';
            } else if ($tmp_user_info['net_distributor'] == 1) {
            	$presenter_id = $tmp_user_info['id'];
            	$presenter_username = $tmp_user_info['username'];
            	$distributor = 2;
            	$fields['net_distributor'] = 2;
            	$fields['score'] = $score_setting_info['reg_score'];
            	$score_type = 'reg_score_in';
            } else if ($tmp_user_info['net_distributor'] == 2) {
            	$presenter_id = $tmp_user_info['id'];
            	$presenter_username = $tmp_user_info['username'];
            	$distributor = 0;
            	$fields['net_distributor'] = 0;
            	$fields['score'] = $score_setting_info['net_score'];
            	$score_type = 'net_score_in';
            }
            $tmp_score = $distributor ? $score_setting_info['reg_score'] : $score_setting_info['store_score'];
            $ret = $this->User_model->save($fields);
            if ($ret) {
                if ($score_setting_info) {
                    $sFields = array(
                        'cause' => $distributor ? '分销商加盟-送积分' : '推广消费者入驻-送积分',
                        'score' => $distributor ? $score_setting_info['reg_score'] : $score_setting_info['store_score'],
                        'balance' => $distributor ? $score_setting_info['reg_score'] : $score_setting_info['store_score'],
                        'type' =>    $score_type,
                        'add_time' => time(),
                        'username' => $username,
                        'user_id' => $ret,
                        'ret_id' => $ret
                    );
                    $this->Score_model->save($sFields);
                }
                $ret = $this->User_model->get('*', array('user.id' => $ret));
                if ($type == '2') {
                    printAjaxSuccess('success', "申请已提交成功，我们会尽快处理你的申请，登录密码[123456]，登录后记得修改密码哦！");
                } else {
                    printAjaxSuccess('success', "恭喜您注册成功，{$tmp_score}积分已送到您账户，请登录领取，默认密码[123456]，登录后记得修改密码哦！");
                }
            } else {
                printAjaxError('fail', '注册失败');
            }
        }
    }

    //加盐算法
    private function _createPasswordSALT($user, $salt, $password) {
        return md5(strtolower($user) . $salt . $password);
    }

    /**
     * 注册，找回获取短信验证码
     * @param mobile 手机号
     * @return json
     */
    public function get_reg_sms_code() {
        if ($_POST) {
            $type = $this->input->post('type', TRUE);
            $mobile = $this->input->post('mobile', TRUE);

            if (!preg_match('/^1[356789]\d{9}$/', $mobile)) {
                printAjaxError('mobile', '请输入正确的手机号');
            }
            if ($type == 'reg') {
                $count = $this->User_model->rowCount(array("username" => $mobile));
                if ($count) {
                    printAjaxError('mobile', '此手机号已被使用，请换一个');
                }
            } else if ($type == 'get_pass') {
                $count = $this->User_model->rowCount(array("username" => $mobile));
                if ($count == 0) {
                    printAjaxError('mobile', '您注册的手机号不存在!');
                }
            } else {
                printAjaxError('type', 'type值异常!');
            }

            $add_time = time();
            $sms_info = $this->Sms_model->get('*', "mobile = '{$mobile}' and {$add_time} - add_time < 60  ");
            if ($sms_info) {
                printAjaxError('fail', '操作太频繁，请至少间隔一分钟再发');
            }
            $verify_code = getRandCode(4);
            $sms_content = "您的验证码是：{$verify_code}。请不要把验证码泄露给其他人。如非本人操作，可不用理会！";
            /*             * *************************半小时限制**************************** */
            $cur_time = $add_time - 1800;
            //30分钟内最多5次
            $count = $this->Sms_model->rowCount("mobile = '{$mobile}' and add_time > {$cur_time} ");
            if ($count >= 4) {
                printAjaxError('fail', '半小时内只能发4次，等一下再来');
            }
            /*             * ************************一天限制*************************** */
            $start_time = strtotime(date('Y-m-d 00:00:00', $add_time));
            $end_time = strtotime(date('Y-m-d 23:59:59', $add_time));
            $count = $this->Sms_model->rowCount("mobile = '{$mobile}' and add_time > {$start_time} and add_time <= {$end_time} ");
            //同一手机一天最多20次
            if ($count >= 15) {
                printAjaxError('fail', '你的手机号发送验证码次数超限，请更换手机号或明天再来');
            }
            $fields = array(
                'mobile' => $mobile,
                'smscode' => $verify_code,
                'sms_content' => $sms_content,
                'add_time' => $add_time
            );
            if (!$this->Sms_model->save($fields)) {
                printAjaxError('fail', '发送验证码失败');
            }
            $reponse = $this->send_sms($mobile, $sms_content);
            if ($reponse == 0) {
                printAjaxSuccess('success', '验证码已经发送，注意查看手机短信');
            } else {
                printAjaxError('fail', '验证码发送失败，请重试');
            }
        }
    }

    private function send_sms($mobile, $msg, $needstatus = 'false', $extno = '') {
        //创蓝发送短信接口URL, 如无必要，该参数可不用修改
        $chuanglan_config['api_send_url'] = 'http://sapi.253.com/msg/HttpBatchSendSM';
        //创蓝短信余额查询接口URL, 如无必要，该参数可不用修改
        $chuanglan_config['api_balance_query_url'] = 'http://sapi.253.com/msg/QueryBalance';
        //创蓝账号 替换成你自己的账号
        $chuanglan_config['api_account'] = 'Meizhe123';
        //创蓝密码 替换成你自己的密码
        $chuanglan_config['api_password'] = 'Meizhe123';
        //创蓝接口参数
        $postArr = array(
            'account' => $chuanglan_config['api_account'],
            'pswd' => $chuanglan_config['api_password'],
            'msg' => $msg,
            'mobile' => $mobile,
            'needstatus' => $needstatus,
            'extno' => $extno
        );

        $result = $this->curlPost($chuanglan_config['api_send_url'], $postArr);
        $arr = preg_split("/[,\r\n]/", $result);
        return $arr[1];
    }

    private function curlPost($url, $postFields) {
        $postFields = http_build_query($postFields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */