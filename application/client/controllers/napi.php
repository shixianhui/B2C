<?php
class Napi extends CI_Controller {
	/***********支付宝***********/
	private $_app_id = '2017120600410803';
	private $_rsaPrivateKey = 'MIIEowIBAAKCAQEAqayiYUGdYMhRN4RQ6OPZ464f8CxyeT9tFROppnA/y0BdMj0wSrdN/ZJGc/HvyPaRIe7JpvFOa/RzOTIMeLvahEDZERX7o0XLHF5kcbVu7UYknlml4htxnTGiNhsbv440P7/5Vt8RENdEwu6zdGjYYadb2fVKhWvViBmvgyccl2odES+CcOrxYtCBLprboXtqAU9Zb4tFnlT/IgdovEe4lohSYu3u3CgvDPzQBAWqo7tbeEfKSwcOdbz2hJVKqJEW4vlSKyOxs030FAjjtWX1m4qgcxv/54hoXk/UhB2ynfCwifsJxAOdth1RzNWHEerPIyVj8mvN7HQJUKPEvwVdswIDAQABAoIBAGPA7Q6ExwPZgXZEQlVJcBadjoVjfEGwem9Dyh/iKn9SbfhVZQjoT9/embEc8j6SR61NeBzADb0GUJ+1vwNUXhoXDgcvh2vsYodhL2hypK626Fx4lEAkpl0mixmIQn4SGsHIGc1rA9uE1BZOxA6SfXScMjIoNhHO3hFQGJHg8rxJXv+dKGN4F4uEDhuxoB81oU0tt5Yw1PaUMY3H8qTztwg4j7cJ9clhcuxRG7awuP6UZg9aKH8glp78n+sOwrQk13YklAVyYT/PBbkBX2F8oS/l4jBapF/2N5UtfQAFRopYFfOuk8CGb6QcUM2Ny2pb32rLfEuq00oyMeQGaQ5ouaECgYEA3x3F8Dgs9mqYkPWexm+cn5FYhjR0XckAtNw3cvXzr0Izd809bVLSbTUCa1G6NIRcRsgKXl/Km+Eamwz/pic+WHDlEp9C7M626FQ7PEGoz2LPsetTsbSZPyAiHRaSNnqmUpxbm6dF/hktkKT3eYd1iwbhJYuL32OfMtYQTirpYQkCgYEAwq58FPK/y0sqwkKHCk5ctS8VbFAs4Hm5mX98sURuqpjjhJk2ikIMT3xXaVys0F5LtydGhmuskCL/TaLVZtP0A5CnwtXI/dvblx4CrAtOQOoVKLfvE3XggdBRE1wmCbbkrrkQWE/i5W0m5SQ1iXQjbLOuaRAlxNr/Jbc8Pp2qQ9sCgYBZ/+SMVdytOap5LtrxKKyBIVwYJqiZ/C6wxfQIB3ZYx9eDB+Mzaik/rBZhvAHklU+zrZWhI/rSjibxTHkDSOk5O7DrphqU832Mkg2i7MlvfmhRWJ/WGweGEywvl587IpZc1H2PeBYfvYBHzIOXHjEn94pyXqv5XHInS3ogTeb+IQKBgED2koc2/dMrsQgDxSYmQf9fx8lN87uwQsO66/QHPtqEjB9aNP3rzknT1yNcfnpFjQSAAaOnWHz8gK76cDWQ8rMh2SlFx30WmW8S35djamh09DyTLB8VTaZjyjoonLTPJ/452P9vIOqoAruh2o+UhqGmT8PVVJUc8tk2DM9kM0XTAoGBALtgLNi0iJTj5lO1iw9Qn0Hu41sZIhku/7CW4MnMK5Y/JbeThCnV2/Z0li0IQ4Y6Qc2fYRxQIghu1HQfK7xl3jgt1bnlQvlcU49A8OXhYYOFo10NuqgM4AlPimlYKv62QojDdxTgylQ9WAGD3jMidPACAExK7knLXdQL2R1hVFxL';
	//支付宝公钥，不要用应用公钥
	private $_alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArq5OUONjheO2Z3kvy9QNlj4PqSLTAqvWm3z80iPDCGwL4ts/cR92CYduQwmddJ0XYkaTli+qBZTmfkXCHpG1quLjt8vm9KD1qZrkU6d8Yjkv033ENhIY6jZbDfDe8VaHmVNJh45w+MzEsHnuA4t22IMq/uJPj/BdD7T/gkoHiMbIbJRJaiuz5XBnMraXGGEQ1p+TFCrb6hdyOhd8TFpHL0gAO3sVmcJnpE6fu2/yzKL+TnuEwlzSPkR+Wv9BvZyPaLPkj3fN1N+lCMZmZCvYRo81uDwb53EZdEOYBhHNUzCHze1XJDcfosEuCIY+iLsuwTqh4xumHRg0yWyq8BsZMQIDAQAB';
    private $appid = 'wxa09033ed0c3bb668';
    private $appSecret = '09cfb886a1a025a8bf1cc798376b9e70';
    private $_status_arr = array(
			'0' => '待付款',
			'1' => '待发货',
			'2' => '待收货',
			'3' => '交易成功',
			'4' => '交易关闭'
	);
    private $_order_type = array(
        '0' => '普通订单',
        '1' => '拼团砍价订单',
        '2' => '限时秒杀订单',
        '3' => '我的竞猜订单',
    );
    private $_category_type = array('1'=> '品牌男装','2'=>'箱包配饰','3'=>'精品男鞋');
    private $_exchange_status = array('0' => '待审核', '1' => '审核未通过', '2' => '审核通过');
    private $_distributor_arr = array('1' => '城市合伙人', '2' => '店级合伙人');
    private $_school_distributor_arr = array('1' => '校园一级分销商', '2' => '校园二级分销商');
    private $_net_distributor_arr = array('1' => '网络一级分销商', '2' => '网络二级分销商');
    private $_exchange_type = array('1' => '退货退款', '2' => '换货', '3' => '仅退款');
    private $_financial_type_arr = array(
    		'order_out' => '购物支付',
    		'order_in' => '购物退款',
    		'cargo_order_out'=>'集运支付',
    		'cargo_order_in'=>'集运退款',
    		'demand_out'=>'代购支付',
    		'demand_in'=>'代购退款',
    		'recharge_in' => '充值',
    		'recharge_out' => '扣款',
    		'order_presenter_out' => '购物推广退款',
    		'order_presenter_in' => '购物推广奖励',
    		'cargo_order_presenter_out' => '集运推广退款',
    		'cargo_order_presenter_in' => '集运推广奖励',
    		'demand_presenter_out' => '代购推广退款',
    		'demand_presenter_in' => '代购推广奖励',
    		'withdraw_in'=>'提现退款',
    		'withdraw_out'=>'提现',
    		'third_recharge_in'=>'在线充值',
    		'third_recharge_out'=>'在线充值退款'
    );
    private $_score_type_arr = array(
    		'login_score_in'=>'每日签到奖励',
    		'reg_score_in' => '新用户注册',
    		'join_user_score_in'=>  '发展会员',
    		'join_seller_score_in'=>'发展商家',
    		'orders_out'=>'退交易积分',
    		'orders_in'=>'返交易积分',
    		'presenter_out'=>'退推广提成',
    		'presenter_in'=>'返推广提成',
    		'orders_buy_out'=>'积分换购',
    		'orders_buy_in'=>'退换购积分',
    		'recharge_in'=>'返积分',
    		'recharge_out'=>'扣积分',
    		'convert_in'=>'兑换入账',
    		'convert_out'=>'兑换支付',
    		'cz_in'=>'充值',
    		'cz_out'=>'扣款',
    		'third_recharge_in'=>'在线充值',
    		'third_recharge_out'=>'充值退款'
    );

    private $_message_type_arr = array(
    		'order'=>'订单消息',
    		'system'=>'系统消息',
    );

    private $_product_type_arr = array(
    		'a' => 'A类产品',
    		'b' => 'B类产品',
    		'c' => 'C类产品'
    );

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Ad_model', '', TRUE);
        $this->load->model('User_address_model', '', TRUE);
        $this->load->model('Area_model', '', TRUE);
        $this->load->model('Orders_model', '', TRUE);
        $this->load->model('Orders_detail_model', '', TRUE);
        $this->load->model('Orders_process_model', '', TRUE);
        $this->load->model('Score_model', '', TRUE);
        $this->load->model('Sms_model', '', TRUE);
        $this->load->model('Comment_model', '', TRUE);
        $this->load->model('Exchange_model', '', TRUE);
        $this->load->model('Financial_model', '', TRUE);
        $this->load->model('Guestbook_model', '', TRUE);
        $this->load->model('Flash_sale_model', '', TRUE);
        $this->load->model('Flash_sale_record_model', '', TRUE);
        $this->load->model('Ptkj_record_model', '', TRUE);
        $this->load->model('Pintuan_model', '', TRUE);
        $this->load->model('Product_model', '', TRUE);
        $this->load->model('Brand_model', '', TRUE);
        $this->load->model('Page_model', '', TRUE);
        $this->load->model('Pintuan_model', '', TRUE);
        $this->load->model('Promotion_ptkj_model', '', TRUE);
        $this->load->model('Product_favorite_model', '', TRUE);
        $this->load->model('Product_category_model', '', TRUE);
        $this->load->model('Attachment_model', '', TRUE);
        $this->load->model('Chop_record_model', '', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('Product_category_ids_model', '', TRUE);
        $this->load->model('Cart_model', '', TRUE);
        $this->load->model('Postage_way_model', '', TRUE);
        $this->load->model('Postage_price_model', '', TRUE);
        $this->load->model('Score_setting_model', '', TRUE);
        $this->load->model('Free_postage_setting_model', '', TRUE);
        $this->load->model('Message_model', '', TRUE);
        $this->load->model('Product_size_color_model', '', TRUE);
        $this->load->model('Product_browse_model', '', TRUE);
        $this->load->model('Pay_log_model', '', TRUE);

        $this->load->library('Securitysecoderclass');
        $this->load->library('Getuiapiclass');
        $this->load->library('Form_validation');
        $this->load->helper('My_ajaxerror');
        $this->load->helper('My_fileoperate');
        $this->_beforeFilter();
    }

    /**
     * 登录接口
     * @param username 用户名
     * @param password 密码
     *
     * @return json
     */
    public function login() {
    	if ($_POST) {
    		$username = trim($this->input->post('username', TRUE));
    		$password = $this->input->post('password', TRUE);
    		$push_cid = $this->input->post('push_cid', TRUE);

    		if (!$username) {
    			printAjaxError('username', '手机号不能为空');
    		}
    		if (!$password) {
    			printAjaxError('password', '登录密码不能为空');
    		}
    	    $userInfo = $this->User_model->login($username, $password);
            if (!$userInfo) {
                printAjaxError('fail', "登录用户名或密码错误,登录失败");
            }
            if ($userInfo['display'] == 0) {
                printAjaxError('fail', "你的账户未激活，若有疑问，请联系网站在线客服！");
            }
            if ($userInfo['display'] == 2) {
                printAjaxError('fail', "你的账户被冻结，若有疑问，请联系网站在线客服！");
            }
    		$ip_arr = getUserIPAddress();
    		$fields = array(
    				'login_time' => time(),
    				'ip' => $ip_arr[0],
    				'ip_address' => $ip_arr[1],
    				'push_cid' => $push_cid,
    		);
    	    $cur_time = date('Y-m-d', time());
            if (!$this->Score_model->rowCount("score_type = 'silver' and type = 'login_score_in' and user_id = {$userInfo['id']} and from_unixtime(add_time, '%Y-%m-%d') = '{$cur_time}' ")) {
            	$score_setting_info = $this->Score_setting_model->get('login_score', array('id' => 1));
            	$score = $score_setting_info['login_score'];
            	$balance = $userInfo['score_silver'] + $score_setting_info['login_score'];
            	$fields['score_silver'] = $balance;
            	if ($this->User_model->save($fields, array('id' => $userInfo['id']))) {
            		$sFields = array(
            				'score_type'=>'silver',
            				'cause' => '每日签到送积分-登录成功',
            				'score' => $score,
            				'balance' => $balance,
            				'type' => 'login_score_in',
            				'add_time' => time(),
            				'username' => $username,
            				'user_id' => $userInfo['id'],
            				'ret_id' => $userInfo['id']
            		);
            		$this->Score_model->save($sFields);
            	} else {
            		printAjaxError('fail', '登录失败！');
            	}
            } else {
            	$this->User_model->save($fields, array('id' => $userInfo['id']));
            }
    		$session_id = $this->session->userdata['session_id'];
    		$this->_set_session($userInfo['id']);
    		printAjaxData($this->_tmp_user_info($userInfo['id'], $session_id));
    	}
    }

    //小程序登录
    public function wx_login(){
        if ($_POST){
            $code = $this->input->post("code", true);
            $iv = $this->input->post('iv', TRUE);
            $encryptedData = $this->input->post('encryptedData', TRUE);
            $parent_id = $this->input->post('parent_id',TRUE);
            $parentInfo = array();
            $parentInfo2 =array();

            if($parent_id){
                $parentInfo = $this->User_model->get('*',array('id'=>$parent_id));
                if($parentInfo){
                    $parentInfo2 = $this->User_model->get('*',array('id'=>$parentInfo['presenter_id']));
                }
            }
            if (!$code) {
                printAjaxError('fail', 'DO NOT ACCESS!');
            }
            $appid = $this->appid;
            $appSecret = $this->appSecret;

            $json = file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appSecret}&js_code={$code}&grant_type=authorization_code");
            $obj = json_decode($json);
            if (isset($obj->errmsg)) {
                printAjaxError('fail', 'invalid code!');
            }
            $session_key = $obj->session_key;
            $openid = $obj->openid;

            $param = array('appid'=>$appid,'sessionKey'=>$session_key);
            $this->load->library('WXBizDataCrypt/WXBizDataCrypt',$param);
            $pc = new WXBizDataCrypt($param);
            $errCode = $pc->decryptData($encryptedData, $iv, $data);

            if ($errCode != 0) {
                printAjaxError('fail',$errCode);
            }

            $get_user_info = json_decode($data);

            if (empty($get_user_info->openId)){
                printAjaxError('fail','小程序登录异常！');
            }

            $user_info = $this->User_model->get('*', array('wx_unionid'=>$get_user_info->openId));

            //已绑定用户直接登录
            if ($user_info) {
                if ($user_info['display'] == 2) {
                    printAjaxError('fail', '你的账户被冻结');
                }
                $session_id = $this->session->userdata('session_id');
                $this->_set_session($user_info['id']);
                printAjaxData($this->_tmp_user_info($user_info['id'], $session_id));
            } else {
                //积分
                $addTime = time();
                $fields = array(
                    'user_group_id' => 1,
                    'username' => '',
                    'password' => '',
                    'mobile' => '',
                    'display' => 1,
                    'login_time' => $addTime,
                    'add_time' => $addTime,
                    'nickname' => $get_user_info->nickName,
                    'path' => $get_user_info->avatarUrl,
                    'sex' => $get_user_info->gender,
                    'wx_openid' => $get_user_info->openId,
                    'presenter_id' => $parent_id?$parent_id:'',
                    'presenter_username' => $parentInfo?$parentInfo['nickname']:'',
                    'par_presenter_id' => $parentInfo2?$parentInfo2['id']:'',
                    'par_presenter_username' => $parentInfo2?$parentInfo2['nickname']:'',
                );

                $ret_id = $this->User_model->save($fields);
                if (!$ret_id) {
                    printAjaxError('fail', '登录失败');
                }

                $session_id = $this->session->userdata('session_id');
                $this->_set_session($ret_id);
                printAjaxData($this->_tmp_user_info($ret_id, $session_id));
            }

        }

    }

    //微信-QQ登录-注册新用户
    public function third_login_to_user() {
    	if ($_POST) {
    		$sex = $this->input->post('sex', TRUE);
    		$unionid = $this->input->post('unionid', TRUE);
    		$path_url = $this->input->post('path_url', TRUE);
    		$type = $this->input->post('type', TRUE);
    		$push_cid = $this->input->post('push_cid', TRUE);
    		$nickname = $this->input->post('nickname', TRUE);

    		if (!$unionid || !$type) {
    			printAjaxError('fail', '操作异常');
    		}
    		$user_info = NULL;
    		if ($type == 'weixin') {
    			$user_info = $this->User_model->get('*', array('wx_unionid'=>$unionid));
    		} else if ($type == 'qq') {
    			$user_info = $this->User_model->get('*', array('qq_unionid'=>$unionid));
    		} else {
    			printAjaxError('fail', '无效的登录认证通道');
    		}
    		//已绑定用户直接登录
    		if ($user_info) {
	    		if ($user_info['display'] == 0) {
	    			printAjaxError('fail', '你的账户还未激活，请先激活账户或联系管理员激活');
	    		} else if ($user_info['display'] == 2) {
	    			printAjaxError('fail', '你的账户被冻结，请联系管理员或者网站客服');
	    		}
	    		//登录成功
	    		if ($push_cid) {
	    			if ($user_info['push_cid'] != $push_cid) {
	    				$this->User_model->save(array('push_cid'=>$push_cid), array('id'=>$user_info['id']));
	    			}
	    		}
	    		$session_id = $this->session->userdata['session_id'];
	    		$this->_set_session($user_info['id']);
	    		printAjaxData($this->_tmp_user_info($user_info['id'], $session_id));
    		} else {
    			$addTime = time();
    			$fields = array(
    					'user_group_id' => 1,
    					'user_type'=>0,
    					'username' => '',
    					'password' => '',
    					'mobile' => '',
    					'login_time' => $addTime,
    					'add_time' => $addTime,
    					'nickname' => $nickname,
    					'path' => $path_url,
    					'sex' => $sex,
    					'push_cid'=>$push_cid
    			    );
    			if ($type == 'weixin') {
    				$fields['wx_unionid'] = $unionid;
    			} else if ($type == 'qq') {
    				$fields['qq_unionid'] = $unionid;
    			}
    			//新用户注册-送银象积分
    			$score_setting_info = $this->Score_setting_model->get('reg_score', array('id' => 1));
    			if ($score_setting_info && $score_setting_info['reg_score'] > 0) {
    				$fields['score_silver'] = $score_setting_info['reg_score'];
    			}
    			$ret_id = $this->User_model->save($fields);
    			if (!$ret_id) {
    				printAjaxError('fail', '登录失败');
    			}
    			//新用户注册-送银象积分
    			if ($score_setting_info && $score_setting_info['reg_score'] > 0) {
    				$sFields = array(
    						'cause' => '新用户注册-送积分',
    						'score' => $score_setting_info['reg_score'],
    						'balance' => $score_setting_info['reg_score'],
    						'score_type'=>'silver',
    						'type' => 'reg_score_in',
    						'add_time' => time(),
    						'username' => '',
    						'user_id' => $ret_id,
    						'ret_id' => $ret_id
    				);
    				$this->Score_model->save($sFields);
    				//发消息
    				$fields = array(
    						'message_type' => 'system',
    						'to_user_id' => $ret_id,
    						'from_user_id' => 0,
    						'content' => '恭喜新人注册获得' . $score_setting_info['reg_score'] . '个银象积分，积分可以用来换购哦，赶紧购物吧',
    						'map_id'=>$ret_id,
    						'add_time' => time()
    				);
    				$this->Message_model->save($fields);
    			}
    			$session_id = $this->session->userdata['session_id'];
            	$this->_set_session($ret_id);
            	printAjaxData($this->_tmp_user_info($ret_id, $session_id));
    		}
    	}
    }

    //微信登录-微信版本-公众号登录
    public function weixin_login_h5() {
    	$code = $this->input->get("code", true);
    	if (!$code) {
    		printAjaxError('fail', 'DO NOT ACCESS!');
    	}
    	$appid = 'wx68a6f3973a815d05';
    	$appSecret = '409ffadaaf6d438a15476e3282ba1f2c';
    	$json = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appSecret}&code={$code}&grant_type=authorization_code");
    	$obj = json_decode($json);
    	if (isset($obj->errmsg)) {
    		printAjaxError('fail', 'invalid code!');
    	}
    	$access_token = $obj->access_token;
    	$openid = $obj->openid;
    	$result = file_get_contents("https://api.weixin.qq.com/sns/auth?access_token={$access_token}&openid={$openid}");
    	$access_token_obj = json_decode($result);
    	if ($access_token_obj->errcode != 0) {
    		printAjaxError('fail', $access_token_obj->errmsg);
    	}
    	$res_user_info = file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}");
    	$tmp_user_info = json_decode($res_user_info, true);
    	if (!array_key_exists("unionid", $tmp_user_info)) {
    		printAjaxError('fail', '开放平台与公众号平台没有配置好');
    	}
    	$user_info = $this->User_model->get('*', array('wx_unionid'=>$tmp_user_info['unionid']));
    	//已绑定用户直接登录
    	if ($user_info) {
    		if ($user_info['display'] == 0) {
    			printAjaxError('fail', '你的账户还未激活，请先激活账户或联系管理员激活');
    		} else if ($user_info['display'] == 2) {
    			printAjaxError('fail', '你的账户被冻结，请联系管理员或者网站客服');
    		}
    		//登录成功
    		$session_id = $this->session->userdata['session_id'];
    		$this->_set_session($user_info['id']);
    		redirect(base_url().'wx/member.html?login_type=sf&sid='.$session_id);
    		exit;
    	} else {
    		$addTime = time();
    		$fields = array(
    					'user_group_id' => 1,
    				    'user_type'=>0,
    					'username' => '',
    					'password' => '',
    					'mobile' => '',
    					'login_time' => $addTime,
    					'add_time' => $addTime,
    					'nickname' => $tmp_user_info['nickname'],
    					'path' => $tmp_user_info['headimgurl'],
    					'sex' => $tmp_user_info['sex'],
    				    'wx_unionid'=>$tmp_user_info['unionid']
    			);
    		//新用户注册-送银象积分
    		$score_setting_info = $this->Score_setting_model->get('reg_score', array('id' => 1));
    		if ($score_setting_info && $score_setting_info['reg_score'] > 0) {
    			$fields['score_silver'] = $score_setting_info['reg_score'];
    		}
    		$ret_id = $this->User_model->save($fields);
    		if (!$ret_id) {
    			printAjaxError('fail', '登录失败');
    		}
    		//新用户注册-送银象积分
    		if ($score_setting_info && $score_setting_info['reg_score'] > 0) {
    			$sFields = array(
    					'cause' => '新用户注册-送积分',
    					'score' => $score_setting_info['reg_score'],
    					'balance' => $score_setting_info['reg_score'],
    					'score_type'=>'silver',
    					'type' => 'reg_score_in',
    					'add_time' => time(),
    					'username' => '',
    					'user_id' => $ret_id,
    					'ret_id' => $ret_id
    			);
    			$this->Score_model->save($sFields);
    			//发消息
    			$fields = array(
    					'message_type' => 'system',
    					'to_user_id' => $ret_id,
    					'from_user_id' => 0,
    					'content' => '恭喜新人注册获得' . $score_setting_info['reg_score'] . '个银象积分，积分可以用来换购哦，赶紧购物吧',
    					'map_id'=>$ret_id,
    					'add_time' => time()
    			);
    			$this->Message_model->save($fields);
    		}
    		$session_id = $this->session->userdata['session_id'];
    		$this->_set_session($ret_id);
    		redirect(base_url().'wx/member.html?login_type=sf&sid='.$session_id);
    		exit;
    	}
    }

    /**
     * 用户注册
     * @param username 用户名
     * @param password 密码
     * @param code 短信验证码
     * @return json
     */
    public function reg() {
    	if ($_POST) {
    		$user_type = $this->input->post('user_type', TRUE);
            $username = trim($this->input->post('username', TRUE));
            $password = $this->input->post('password', TRUE);
            $code = $this->input->post('code', TRUE);
            $smscode = $this->input->post('smscode', TRUE);
            $remember = $this->input->post('remember', TRUE);
            $pop_code = trim($this->input->post('pop_code', TRUE));
            $push_cid = trim($this->input->post('push_cid', TRUE));

            if (!$remember) {
            	printAjaxError('fail', '必须同意“服务协议”才能完成注册');
            }
            if (!$this->form_validation->required($user_type)) {
            	printAjaxError('user_type', '请选择注册的用户类型');
            }
            if (!$this->form_validation->required($username)) {
            	printAjaxError('mobile', '请输入用户名');
            }
            if (!$this->form_validation->max_length($username, 32)) {
            	printAjaxError('mobile', '用户名长度不能大于32字符');
            }
            if ($this->User_model->validateUnique($username)) {
            	printAjaxError('username', '用户名已经存在，请换一个');
            }
            if (!$this->form_validation->required($password)) {
            	printAjaxError('password', '请输入登录密码');
            }
            if (!$this->form_validation->required($code)) {
            	printAjaxError('code', '请输入验证码');
            }
	        $securitysecoder = new Securitysecoderclass();
	        if (!$securitysecoder->check(strtolower($code))) {
	         	printAjaxError('code_fail', '验证码错误');
	        }
            //推荐人
            $tmp_user_info = NULL;
            $presenter_id = 0;
            $presenter_username = '';
            $par_presenter_id = 0;
            $par_presenter_username = '';
            if ($pop_code) {
            	$tmp_user_info = $this->User_model->get('id, username, score_silver, presenter_id, presenter_username', array('pop_code' => $pop_code));
            	if (!$tmp_user_info) {
            		printAjaxError('pop_code', '请输入正确的邀请码');
            	}
            	$presenter_id = $tmp_user_info['id'];
            	$presenter_username = $tmp_user_info['username'];
            	$par_presenter_id = $tmp_user_info['presenter_id'];
            	$par_presenter_username = $tmp_user_info['presenter_username'];
            }
            $addTime = time();
            if (!$this->Sms_model->get('id', "smscode = '{$smscode}' and mobile = '{$username}' and add_time > {$addTime} - 15*60")) {
         	    printAjaxError('smscode', '短信验证码错误或者已过期');
            }

            $fields = array(
            		'user_group_id' => 1,
            		'user_type'=>      $user_type,
            		'username' =>      $username,
            		'password' =>      $this->_createPasswordSALT($username, $addTime, $password),
            		'mobile' =>        $username,
            		'add_time' =>      $addTime,
            		'login_time' =>    $addTime,
            		'presenter_id' =>  $presenter_id,
            		'presenter_username' => $presenter_username,
            		'par_presenter_id' =>       $par_presenter_id,
            		'par_presenter_username' => $par_presenter_username,
            		'push_cid' => $push_cid
            );
            //新用户注册-送银象积分
            $score_val = 0;
	        $score_type = '';
            $score_setting_info = $this->Score_setting_model->get('reg_score, join_user_score, join_seller_score', array('id' => 1));
            if ($score_setting_info && $score_setting_info['reg_score'] > 0) {
            	$score_val = $score_setting_info['reg_score'];
                $score_type = 'reg_in';
            	$fields['score_silver'] = $score_setting_info['reg_score'];
            }
            $ret = $this->User_model->save($fields);
            if ($ret) {
            	//新用户注册-送银象积分
            	if ($score_setting_info && $score_setting_info['reg_score'] > 0) {
            		$sFields = array(
            				'cause' => '新用户注册-送积分',
            				'score' => $score_setting_info['reg_score'],
            				'balance' => $score_setting_info['reg_score'],
            				'score_type'=>'silver',
            				'type' => 'reg_score_in',
            				'add_time' => time(),
            				'username' => $username,
            				'user_id' => $ret,
            				'ret_id' => $ret
            		);
            		$this->Score_model->save($sFields);
            		//发消息
            		$fields = array(
            				'message_type' => 'system',
            				'to_user_id' => $ret,
            				'from_user_id' => 0,
            				'content' => '恭喜新人注册获得' . $score_setting_info['reg_score'] . '个银象积分，积分可以用来抵钱哦，赶紧购物吧',
            				'map_id'=>$ret,
            				'add_time' => time()
            		);
            		$this->Message_model->save($fields);
            	}
            	//邀请成功-推广者获得积分
            	if ($tmp_user_info) {
            		$score = 0;
            		$type = '';
            		$cause_str = '';
            		$msg = '';
            		//商家
            		if ($user_type == 1) {
            			if ($score_setting_info && $score_setting_info['join_seller_score'] > 0) {
            				$score = $score_setting_info['join_seller_score'];
            				$cause_str = "推广成功一个商家-送积分";
            				$type = 'join_seller_score_in';
            				$msg = '推广成功一个商家';
            			}
            		}
            		//会员
            		else {
            			if ($score_setting_info && $score_setting_info['join_user_score'] > 0) {
            				$score = $score_setting_info['join_user_score'];
            				$cause_str = "推广成功一个会员-送积分";
            				$type = 'join_user_score_in';
            				$msg = '推广成功一个会员';
            			}
            		}
            		if ($score > 0) {
            			$balance = $tmp_user_info['score_silver'] + $score;
            			if ($this->User_model->save(array('score_silver'=>$balance), array('id'=>$tmp_user_info['id']))) {
            				$fields = array(
            						'cause' => $cause_str,
            						'score' => $score,
            						'balance' => $balance,
            						'score_type'=>'silver',
            						'type' => $type,
            						'add_time' => time(),
            						'username' => $tmp_user_info['username'],
            						'user_id' => $tmp_user_info['id'],
            						'ret_id' => $ret,
            						'from_user_id'=>$ret
            				);
            				$this->Score_model->save($fields);
            				//发消息
            				$fields = array(
            						'message_type' => 'system',
            						'to_user_id' => $tmp_user_info['id'],
            						'from_user_id' => 0,
            						'content' => $msg.',获得' . $score . '个银象积分，积分可以用来抵钱哦，赶紧购物吧',
            						'map_id'=>$ret,
            						'add_time' => time()
            				);
            				$this->Message_model->save($fields);
            			}
            		}
            	}
    			$session_id = $this->session->userdata['session_id'];
    			$this->_set_session($ret);
    			$data = $this->_tmp_user_info($ret, $session_id);
				$data['score_val'] = $score_val;
	            $data['score_type'] = $score_type;
    			printAjaxData($data);
    		} else {
    			printAjaxError('fail', '注册失败');
    		}
    	}
    }

    /*
     * 找回密码
     * @param username 手机号
     * @param password 设置的密码
     */
    public function get_pass() {
    	if ($_POST) {
    		$username = trim($this->input->post('username', TRUE));
    		$password = $this->input->post('password', TRUE);
    		$code = trim($this->input->post('code', TRUE));
    		$smscode = $this->input->post('smscode', TRUE);

    		if (!$username) {
    			printAjaxError('username', "用户名不能为空");
    		}
    		$userInfo = $this->User_model->get('id,username', array('lower(username)' => strtolower($username)));
    		if (!$userInfo) {
    			printAjaxError('fail', "用户名不存在");
    		}
    		if (!$this->form_validation->required($password)) {
    			printAjaxError('password', '请输入新密码');
    		}
    		if (strlen($password) < 6 || strlen($password) > 20) {
    			printAjaxError('password', '密码长度6~20位');
    		}
    		if (!$code) {
    			printAjaxError('code', "图形验证码不能为空");
    		}
    		$securitysecoder = new Securitysecoderclass();
    		if (!$securitysecoder->check(strtolower($code))) {
    			printAjaxError('code_fail', '图形验证码错误');
    		}
    		if (!$smscode) {
    			printAjaxError('smscode', "短信验证码不能为空");
    		}
    		$timestamp = time();
    		if (!$this->Sms_model->get('id', "smscode = '{$smscode}' and mobile = '{$username}' and add_time > {$timestamp} - 15*60")) {
    			printAjaxError('smscode', '短信验证码错误或者已过期');
    		}
    		$fields = array(
    				'password' => $this->User_model->getPasswordSalt($userInfo['username'], $password)
    		);
    		if ($this->User_model->save($fields, array('id' => $userInfo['id']))) {
    			printAjaxSuccess('success', '密码修改成功');
    		} else {
    			printAjaxError('fail', '密码修改失败');
    		}
    	}
    }

    public function get_user_info() {
        $user_id = $this->_check_login();
        $user_info = $this->User_model->get('distributor,school_distributor,net_distributor,distributor_status,distributor_status_time,distributor_client_remark, distributor_admin_remark,old_presenter_id,id,user_type,seller_grade,user_group_id,username,nickname,real_name,add_time,total,score_gold,score_silver,total_gold,total_silver,mobile,phone,sex,path,ad_text,push_cid,total_gold_rmb_pre,total_silver_rmb_pre,alipay_account,weixin_account,ebank_account,gold_card_num,txt_address,birthday', array('id' => $user_id));
        $tmp_path = $this->_fliter_image_path($user_info['path']);
        $user_info['path'] = $tmp_path['path'];
        $user_info['path_thumb'] = $tmp_path['path_thumb'];
        $user_info['total_cart'] = $this->Cart_model->rowSum(array('user_id'=>$user_id));

        $is_distributor = 0;
        $distributor_type_name = '';
        if ($user_info['distributor']) {
            $is_distributor = 1;
            $distributor_type_name = $this->_distributor_arr[$user_info['distributor']];
        } else if ($user_info['school_distributor']) {
            $is_distributor = 1;
            $distributor_type_name = $this->_school_distributor_arr[$user_info['school_distributor']];
        } else if ($user_info['net_distributor']) {
            $is_distributor = 1;
            $distributor_type_name = $this->_net_distributor_arr[$user_info['net_distributor']];
        }
        $user_info['is_distributor'] = $is_distributor;
        $user_info['distributor_type_name'] = $distributor_type_name;
        $user_info['format_distributor_status_time'] = date('Y-m-d H:i', $user_info['distributor_status_time']);

        printAjaxData($user_info);
    }

    /*
 * 修改用户信息
 * 昵称、性别
 */
    public function change_user_info() {
        $user_id = $this->_check_login();
        if ($_POST) {
            $nickname = $this->input->post('nickname', true);
            $sex = $this->input->post('sex', true);
            $weixin_account= $this->input->post('weixin_account', true);
            $birthday = $this->input->post('birthday', TRUE);
            $province_id= $this->input->post('province_id', true);
            $city_id= $this->input->post('city_id', true);
            $area_id= $this->input->post('area_id', true);
            $txt_address= $this->input->post('txt_address', true);

            $fields = NULL;
            if ($nickname) {
                if (!preg_match("/^[\x{4e00}-\x{9fa5}a-zA-Z\d\_]{2,20}$/u", $nickname)) {
                    printAjaxError('nickname', '昵称仅包含汉字、字母、数字、下划线，2~20位');
                };
                $fields['nickname'] = $nickname;
            }
            if ($sex != '') {
                if ($sex != '0' && $sex != '1' && $sex != '2') {
                    printAjaxError('sex', '请选择性别');
                }
                $fields['sex'] = $sex;
            }


            if ($weixin_account){
                if (!preg_match("/^[a-zA-Z]{1}[-_a-zA-Z0-9]{5,19}$/", $weixin_account)) {
                    printAjaxError('weixin_account', '请填写正确的微信号');
                };
                $fields['weixin_account'] = $weixin_account;
            }

            if ($birthday != ''){
                $fields['birthday'] = $birthday;
            }
            if ($province_id != ''){
                $fields['province_id'] = $province_id;
            }
            if ($city_id != ''){
                $fields['city_id'] = $city_id;
            }
            if ($area_id != ''){
                $fields['area_id'] = $area_id;
            }
            if ($txt_address != ''){
                $fields['txt_address'] = $txt_address;
            }



            if (!$fields) {
                printAjaxError('fail', '操作异常');
            }
            if ($this->User_model->save($fields, array('id' => $user_id))) {
                printAjaxSuccess('success', '修改成功');
            } else {
                printAjaxError('fail', '修改失败');
            }
        }
    }

    //绑定手机
    public function change_mobile() {
        $user_id = $this->_check_login();
        if ($_POST) {
            $mobile = trim($this->input->post('mobile', TRUE));
            $smscode = $this->input->post('smscode', TRUE);
            $password = $this->input->post('password', TRUE);
            $user_info = $this->User_model->get('*', "id = " . $user_id);
            if (!$this->form_validation->required($mobile)) {
                printAjaxError('mobile', '请输入手机号码');
            }
            if (!$this->form_validation->required($smscode)) {
                printAjaxError('smscode', '请输入短信验证码');
            }
            if (!preg_match("/^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/", $mobile)) {
                printAjaxError('username', '手机号码格式不正确');
            }
            if ($user_info['password'] != $this->User_model->getPasswordSalt($user_info['username'], $password)) {
                printAjaxError('password', '密码错误');
            }
            $timestamp = time();
            $timestamp_min = $timestamp - 15*60;
            if (!$this->Sms_model->get('id', "smscode = '$smscode' and mobile = '$mobile' and add_time > $timestamp_min")) {
                printAjaxError('smscode', '短信验证码错误或者已过期');
            }
            $addTime = $user_info['add_time'];
            $fields = array(
                'mobile' => $mobile,
                'username' => $mobile,
                'password' => $this->_createPasswordSALT($mobile, $addTime, $password),
            );
            $ret_id = $this->User_model->save($fields, "id = {$user_info['id']}");
            if ($ret_id) {
                printAjaxSuccess('success', '绑定成功');
            } else {
                printAjaxError('fail', '绑定失败');
            }
        }
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
    		$code = $this->input->post('code', TRUE);

    		if (!preg_match('/^1[356789]\d{9}$/', $mobile)) {
    			printAjaxError('mobile', '请输入正确的手机号');
    		}
    		if (!$this->form_validation->required($code)) {
    			printAjaxError('code', '请输入验证码');
    		}
            if ($type != 'change_mobile') {
                $securitysecoder = new Securitysecoderclass();
                if (!$securitysecoder->check(strtolower($code))) {
                    printAjaxError('code', '验证码错误');
                }
            }
    		if ($type == 'reg' || $type == 'change_mobile') {
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
            $sms_content = "【魔豆哥】您的验证码是： {$verify_code} 请不要把验证码泄露给其他人。如非本人操作，可不用理会！";
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
    		if ($reponse > 0) {
    			printAjaxSuccess('success', '验证码已经发送，注意查看手机短信');
    		} else {
    			printAjaxError('fail', '验证码发送失败，请重试');
    		}
    	}
    }

    /**
     * 我的关注
     *
     * @param number $max_id     若指定此参数，则返回ID小于或等于max_id的信息,相当于more
     * @param number $since_id   获取最新信息,相当于下拉刷新
     * @param number $per_page   每页数
     * @param number $page       页数
     */
    public function get_product_favorite_list($max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
    	$user_id = $this->_check_login();
    	$strWhere = "product_favorite.user_id = {$user_id} ";
    	if ($since_id) {
    		$strWhere .= " and product_favorite.id > {$since_id} ";
    	}
    	if ($max_id) {
    		$strWhere .= " and product_favorite.id <= {$max_id} ";
    	}
    	//分页
    	$item_list = $this->Product_favorite_model->gets($strWhere, $per_page, $per_page * ($page - 1));
    	if ($item_list) {
    		foreach ($item_list as $key => $value) {
    			$tmp_image_arr = $this->_fliter_image_path($value['path']);
    			$item_list[$key]['path'] = $tmp_image_arr['path'];
    			$item_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
    		}
    	}
    	// 最大ID
        if (!$max_id && !$since_id) {
        	$max_id = $this->Product_favorite_model->get_max_id(NULL);
        } else {
        	//下拉刷新
        	if (!$max_id && $since_id) {
        		$max_id = $this->Product_favorite_model->get_max_id(NULL);
        	}
        }
    	//是否有下一页
    	$cur_count = $per_page * ($page - 1) + count($item_list);
    	$total_count = $this->Product_favorite_model->rowCount($strWhere);
    	$is_next_page = 0;
    	if ($total_count > $cur_count) {
    		$is_next_page = 1;
    	}
    	printAjaxData(array('item_list' =>$item_list, 'is_next_page' => $is_next_page, 'max_id' => $max_id, 'total_count' => $total_count));
    }

    //删除收藏
    public function delete_favorite() {
        $user_id = $this->_check_login();
        if ($_POST){
            $favorite_ids = $this->input->post('favorite_ids', TRUE);
            if (empty($favorite_ids)) {
                printAjaxError('id', '请选择删除项');
            }
            if(!$this->Product_favorite_model->rowCount("product_favorite.id in ({$favorite_ids}) and product_favorite.user_id = {$user_id} ")){
                printAjaxError('id', '不存在您要删除的项');
            }
            $result = $this->Product_favorite_model->delete("id in ({$favorite_ids}) and user_id = {$user_id} ");
            if ($result) {
                printAjaxSuccess('success', '删除成功');
            } else {
                printAjaxError('fail', '删除失败');
            }
        }
    }

    //收藏商品
    public function save_product_favorite() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$productId = $this->input->post('product_id');

    		if (!$productId) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}
    		$item_info = $this->Product_model->get('favorite_num', array('id' => $productId));
    		if (!$item_info) {
    			printAjaxError('fail', '此商品不存在，收藏失败');
    		}
    		$product_favorite_info = $this->Product_favorite_model->get('id', array('product_id' => $productId, 'user_id' => $user_id));
    		if ($product_favorite_info) {
    			if ($this->Product_favorite_model->delete(array('id' => $product_favorite_info['id'], 'user_id' => $user_id))) {
    				$this->Product_model->save(array('favorite_num' => $item_info['favorite_num'] - 1 ? $item_info['favorite_num'] - 1 : 0), array('id' => $productId));
    				printAjaxData(array('action' => 'delete', 'id' => $product_favorite_info['id']));
    			} else {
    				printAjaxError('fail', '收藏失败');
    			}
    		} else {
    			$fields = array(
    					'product_id' => $productId,
    					'user_id' => $user_id,
    					'add_time' => time()
    			);
    			$retId = $this->Product_favorite_model->save($fields);
    			if ($retId) {
    				$this->Product_model->save(array('favorite_num' => $item_info['favorite_num'] + 1), array('id' => $productId));
    				printAjaxData(array('action' => 'add', 'id' => $retId));
    			} else {
    				printAjaxError('fail', '收藏失败');
    			}
    		}
    	}
    }

    /**
     * 取消收藏
     * @param type $id
     */
    public function delete_product_favorite() {
    	//判断是否登录
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$product_id = $this->input->post('product_id', TRUE);

    		if (!$product_id) {
    			printAjaxError('fail', '操作异常');
    		}
    		if ($this->Product_favorite_model->rowCount(array('product_id' => $product_id, 'user_id' => $user_id)) == 0) {
    			printAjaxError('fail', '未收藏此商品或已删除！');
    		}
    		if ($this->Product_favorite_model->delete(array('product_id' => $product_id, 'user_id' => $user_id))) {
    			printAjaxData(array('action' => 'delete', 'product_id' => $product_id));
    		} else {
    			printAjaxError('fail', '删除失败！');
    		}
    	}
    }

    //收货地址列表
    public function get_user_address_list() {
    	$user_id = $this->_check_login();
    	$item_list = $this->User_address_model->gets('*', array('user_id' => $user_id));
    	printAjaxData(array('item_list' => $item_list));
    }

    //我的默认收货地址
    public function get_default_user_address_info() {
    	$user_id = $this->_check_login();
    	$user_address_info = $this->User_address_model->get('*', array('user_id' => $user_id, 'default' => 1));
    	if (!$user_address_info) {
    		$user_address_info['id'] = '';
    		$user_address_info['buyer_name'] = '';
    		$user_address_info['mobile'] = '';
    		$user_address_info['txt_address'] = '';
    		$user_address_info['address'] = '';
    	}
    	printAjaxData($user_address_info);
    }

    //设置默认地址
    public function set_default_user_address() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$id = $this->input->post('id', TRUE);
    		if (!$id) {
    			printAjaxError('fail', '操作异常');
    		}
    		if (!$this->User_address_model->save(array('default' => 0), array('user_id' => $user_id, 'default' => 1))) {
    			printAjaxError('fail', '操作异常');
    		}
    		if (!$this->User_address_model->save(array('default' => 1), array('user_id' => $user_id, 'id' => $id))) {
    			printAjaxError('fail', '操作失败');
    		}
    		printAjaxSuccess('success', '操作成功');
    	}
    }

    /**
     * 新增或修改收货地址
     *
     * @param number buyer_name  收货人
     * @param string mobile
     * @param number province_id
     * @param number area_id
     * @param number city_id
     * @param number default
     * @param number
     */
    public function save_user_address($id = 0) {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$buyer_name = $this->input->post('buyer_name', TRUE);
    		$mobile = $this->input->post('mobile', TRUE);
    		$phone = $this->input->post('phone', TRUE);
    		$zip = $this->input->post('zip', TRUE);
    		$province_id = $this->input->post('province_id', TRUE);
    		$city_id = $this->input->post('city_id', TRUE);
    		$area_id = $this->input->post('area_id', TRUE);
    		$address = $this->input->post('address', TRUE);
    		$default = $this->input->post('defaults', TRUE);

    		if (!$buyer_name) {
    			printAjaxError('buyer_name', '姓名不能为空');
    		}
    		if (!preg_match("/^1[356789]\d{9}$/", $mobile)) {
    			printAjaxError('mobile', '手机号格式不正确');
    		}
    		if ($zip && !preg_match("/^[1-9]\d{5}$/", $zip)) {
    			printAjaxError('zip', '邮编格式不正确');
    		}
    		if (!$province_id) {
    			printAjaxError('province_id', '选择省');
    		}
    		if (!$city_id) {
    			printAjaxError('city_id', '选择市');
    		}
    		if (!$area_id) {
    			printAjaxError('area_id', '选择区/县');
    		}
    		if (!$address) {
    			printAjaxError('address', '请填写详细地址');
    		}
    		$txt_address_str = '';
    		$area_info = $this->Area_model->get('name', array('id' => $province_id));
    		if ($area_info) {
    			$txt_address_str .= $area_info['name'];
    		}
    		$area_info = $this->Area_model->get('name', array('id' => $city_id));
    		if ($area_info) {
    			$txt_address_str .= ' ' . $area_info['name'];
    		}
    		$area_info = $this->Area_model->get('name', array('id' => $area_id));
    		if ($area_info) {
    			$txt_address_str .= ' ' . $area_info['name'];
    		}
    		$fields = array(
    				'buyer_name' => $buyer_name,
    				'mobile' => $mobile,
    				'phone' => $phone,
    				'zip' => $zip,
    				'province_id' => $province_id,
    				'city_id' => $city_id,
    				'area_id' => $area_id,
    				'txt_address' => $txt_address_str,
    				'address' => $address,
    				'default' => $default,
    				'user_id' => $user_id,
    		);
    		//当收货地址为一个时，设为默认
    		if ($this->User_address_model->rowCount(array('user_id' => $user_id)) == 0) {
    			$fields['default'] = 1;
    		}
    		if ($this->User_address_model->rowCount(array('user_id' => $user_id)) > 10) {
    			printAjaxError('fail', '最多只能设置十个收货地址');
    		}
    		if ($default == 1) {
    			$this->User_address_model->save(array('default' => 0), array('user_id' => $user_id, 'default' => 1));
    		}
    		if ($this->User_address_model->save($fields, $id ? array('id' => $id) : NULL)) {
    			printAjaxSuccess('success', '收货地址操作成功');
    		} else {
    			printAjaxError('fail', '收货地址操作失败');
    		}
    	}
    }

    /*
     * 删除收货地址
     * @param number $address_ids  收货地址id
     */
    public function delete_user_address() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$address_ids = trim($this->input->post('address_ids', true), ',');
    		if (!$address_ids) {
    			printAjaxError('fail', '请选择删除项');
    		}
    		if ($this->User_address_model->delete("id in ({$address_ids}) and user_id = {$user_id}")) {
    			printAjaxSuccess('success', '删除成功!');
    		} else {
    			printAjaxError('fail', '删除失败！');
    		}
    	}
    }

    /*
     * 我的资产
     */
    public function get_financial_info() {
    	$user_id = $this->_check_login();
    	$userInfo = $this->User_model->get('total, score_gold, score_silver, total_gold, total_silver', "id = {$user_id}");
    	if (!$userInfo) {
            printAjaxError('fail', '用户信息不存在');
    	}
    	printAjaxData($userInfo);
    }

    /*
     * 资金记录(分页)
     */

    /**
     *
     * @param type $max_id
     * @param type $since_id
     * @param type $per_page
     * @param type $page
     */
    public function get_financial_list($max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
    	$user_id = $this->_check_login();
    	$strWhere = "financial.user_id = {$user_id} ";
    	if ($since_id) {
    		$strWhere .= " and financial.id > {$since_id} ";
    	}
    	if ($max_id) {
    		$strWhere .= " and financial.id <= {$max_id} ";
    	}
    	$item_list = $this->Financial_model->gets($strWhere, $per_page, $per_page * ($page - 1));
    	if ($item_list) {
    		foreach ($item_list as $key => $value) {
    			$item_list[$key]['add_time_format'] = date('m-d', $value['add_time']);
    			$item_list[$key]['type_format'] = $this->_financial_type_arr[$value['type']];
    		}
    	}
        // 最大ID
        if (!$max_id && !$since_id) {
        	$max_id = $this->Financial_model->get_max_id(NULL);
        } else {
        	//下拉刷新
        	if (!$max_id && $since_id) {
        		$max_id = $this->Financial_model->get_max_id(NULL);
        	}
        }
    	//是否有下一页
    	$cur_count = $per_page * ($page - 1) + count($item_list);
    	$total_count = $this->Financial_model->rowCount($strWhere);
    	$is_next_page = 0;
    	if ($total_count > $cur_count) {
    		$is_next_page = 1;
    	}
    	printAjaxData(array('item_list' => $item_list, 'max_id' => $max_id, 'is_next_page' => $is_next_page));
    }

    /*
     * 我的街呗(分页)
     */
    public function get_score_list($score_type = 'gold', $max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
    	$user_id = $this->_check_login();
    	$strWhere = "user_id = {$user_id} and score_type = '{$score_type}' ";
    	if ($since_id) {
    		$strWhere .= " and id > {$since_id} ";
    	}
    	if ($max_id) {
    		$strWhere .= " and id <= {$max_id} ";
    	}
    	$item_list = $this->Score_model->gets($strWhere, $per_page, $per_page * ($page - 1));
    	if ($item_list) {
    		foreach ($item_list as $key => $value) {
    			$item_list[$key]['add_time_format'] = date('m-d', $value['add_time']);
    			$item_list[$key]['type_format'] = $this->_score_type_arr[$value['type']];
    		}
    	}
    	// 最大ID
        if (!$max_id && !$since_id) {
        	$max_id = $this->Score_model->get_max_id(NULL);
        } else {
        	//下拉刷新
        	if (!$max_id && $since_id) {
        		$max_id = $this->Score_model->get_max_id(NULL);
        	}
        }
    	//是否有下一页
    	$cur_count = $per_page * ($page - 1) + count($item_list);
    	$total_count = $this->Score_model->rowCount($strWhere);
    	$is_next_page = 0;
    	if ($total_count > $cur_count) {
    		$is_next_page = 1;
    	}

//     	$time = date('Y-m-d', time());
//     	//今日消耗的积分
//     	$consume = $this->Score_model->getScoreTotal("user_id = {$user_id} and score < 0 and FROM_UNIXTIME(add_time,'%Y-%m-%d') = '{$time}'");
//     	//今日收入的积分
//     	$earn = $this->Score_model->getScoreTotal("user_id = {$user_id} and score > 0 and FROM_UNIXTIME(add_time,'%Y-%m-%d') = '{$time}'");
//     	//积分余额
//     	$userInfo = $this->User_model->get('score', "id = {$user_id}");

    	printAjaxData(array('item_list' => $item_list, 'score_balance' => 0, 'consume' => 0, 'earn' => 0, 'max_id' => $max_id, 'is_nex_page' => $is_next_page));
    }

    /**
     * 订单列表
     *
     * @param string $s
     * @param number $max_id
     * @param number $since_id
     * @param number $per_page
     * @param number $page
     */
    public function get_order_list($s = 'all', $max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
    	$user_id = $this->_check_login();
    	$strWhere = "user_id = {$user_id} and is_delete = 0 ";
        if ($s != 'all' && $s != 'pj') {
        	$strWhere .= " and status = {$s} ";
        } else {
        	if ($s == 'pj') {
        		$strWhere .= " and status = 3 and is_comment_to_seller = 0 ";
        	}
        }
    	if ($since_id) {
    		$strWhere .= " and id > {$since_id} ";
    	}
    	if ($max_id) {
    		$strWhere .= " and id <= {$max_id} ";
    	}
    	$order_list = $this->Orders_model->gets('*', $strWhere, $per_page, $per_page * ($page - 1));
    	if ($order_list) {
    		foreach ($order_list as $key => $order) {
    			$orderdetailList = $this->Orders_detail_model->gets('*', array('order_id' => $order['id']));
    			$num = 0;
    			foreach ($orderdetailList as $k => $v) {
    				$tmp_image_arr = $this->_fliter_image_path($v['path']);
    				$orderdetailList[$k]['path'] = $tmp_image_arr['path'];
    				$orderdetailList[$k]['path_thumb'] = $tmp_image_arr['path_thumb'];
    				if ($order['status'] == 4) {
    					$count = $this->Comment_model->rowCount(array('order_number' => $order['order_number'], 'product_id' => $v['product_id']));
    					if ($count > 0) {
    						$num++;
    					}
    				}
    			}
    			if ($order['status'] == 4) {
    				if ($num == count($orderdetailList)) {
    					$order_list[$key]['comment_status'] = '已评价';
    				} else {
    					$order_list[$key]['comment_status'] = '立即评价';
    				}
    			}else{
    				$order_list[$key]['comment_status'] = 0;
    			}
    			$order_list[$key]['orderdetailList'] = $orderdetailList;
    			$order_list[$key]['status_format'] = $this->_status_arr[$order['status']];
    			$order_list[$key]['apply_refund'] = 0;
    			if ($order['status'] == 4) {
    				$order_period = $this->Orders_process_model->get('add_time', "order_id = {$order['id']} and content like '%交易成%'");
    				if ($order_period && $order_period['add_time'] + 7 * 24 * 60 * 60 > time()) {
    					$order_list[$key]['apply_refund'] = 1;
    				}
    			}
    			if ($order['status'] == 1 || $order['status'] == 2) {
    				$order_list[$key]['apply_refund'] = 1;
    			}
    			$order_list[$key]['is_expired'] = (time() > $order['expires'] + $order['add_time']) ? 1 : 0;
    			$order_list[$key]['add_time_format'] = date('Y-m-d H:i',$order['add_time']);
    		}
    	}
    	// 最大ID
        if (!$max_id && !$since_id) {
        	$max_id = $this->Orders_model->get_max_id(NULL);
        } else {
        	//下拉刷新
        	if (!$max_id && $since_id) {
        		$max_id = $this->Orders_model->get_max_id(NULL);
        	}
        }
    	//是否有下一页
    	$cur_count = $per_page * ($page - 1) + count($order_list);
    	$total_count = $this->Orders_model->rowCount($strWhere);
    	$is_next_page = 0;
    	if ($total_count > $cur_count) {
    		$is_next_page = 1;
    	}
    	/**************统计*****************/
    	//待付款
    	$count_0 = $this->Orders_model->rowCount(array('status' => 0, 'user_id' => $user_id, 'is_delete'=>0));
    	//待发货
    	$count_1 = $this->Orders_model->rowCount(array('status' => 1, 'user_id' => $user_id, 'is_delete'=>0));
    	//待收货
    	$count_2 = $this->Orders_model->rowCount(array('status' => 2, 'user_id' => $user_id, 'is_delete'=>0));
    	//待评价
    	$count_pj = $this->Orders_model->rowCount(array('status' => 3, 'user_id' => $user_id, 'is_delete'=>0, 'is_comment_to_seller'=>0));

    	printAjaxData(array('item_list' => $order_list, 'max_id' => $max_id, 'is_next_page' => $is_next_page, 'total_count' => $total_count, 'count_0'=>$count_0, 'count_1'=>$count_1, 'count_2'=>$count_2, 'count_pj'=>$count_pj));
    }

	/**
	 * 获取订单详情的商品
	 * @param unknown $id
	 */
    public function get_order_detail_list($id = NULL) {
    	$user_id = $this->_check_login();
    	$orderInfo = $this->Orders_model->get('id, status', array('user_id'=>$user_id, 'id'=>$id));
    	if (!$orderInfo) {
            printAjaxError('fail', '此订单信息不存在');
    	}
    	if ($orderInfo['status'] != 3) {
    		printAjaxError('fail', '此订单状态异常，不能进行评价');
    	}
    	$item_list = $this->Orders_detail_model->gets('*', array('order_id'=>$orderInfo['id']));
    	if ($item_list) {
    		foreach ($item_list as $key=>$value) {
    			$tmp_image_arr = $this->_fliter_image_path($value['path']);
    			$item_list[$key]['path'] = $tmp_image_arr['path'];
    			$item_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
    		}
    	}
    	printAjaxData(array('item_list'=>$item_list));
    }

    /*
     * 订单详情
     */
    public function get_order_detail($id) {
    	$user_id = $this->_check_login();
    	$strWhere = array('user_id' => $user_id, 'id' => $id);
    	$orderInfo = $this->Orders_model->get('*', $strWhere);
    	if ($orderInfo) {
    		$orderInfo['orderdetailList'] = $this->Orders_detail_model->gets('*', array('order_id' => $orderInfo['id']));
    		$orderInfo['ordersprocessList'] = $this->Orders_process_model->gets('*', array('order_id' => $orderInfo['id']));
    		foreach ($orderInfo['orderdetailList'] as $key => $item) {
    			$tmp_image_arr = $this->_fliter_image_path($item['path']);
    			$orderInfo['orderdetailList'][$key]['path'] = $tmp_image_arr['path'];
    			$orderInfo['orderdetailList'][$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
    			$count = $this->Comment_model->rowCount(array('order_number' => $orderInfo['order_number'], 'product_id' => $item['product_id']));
    			if ($count > 0) {
    				$orderInfo['orderdetailList'][$key]['comment_status'] = 1;
    			} else {
    				$orderInfo['orderdetailList'][$key]['comment_status'] = 0;
    			}
    			$exchange_info = $this->Exchange_model->get('id,price,buyer_express_num,remark,seller_recieve_goods,status,exchange_type', array('orders_detail_id' => $item['id']));
    			if ($exchange_info) {
    				$orderInfo['orderdetailList'][$key]['exchange_status'] = $this->_exchange_status[$exchange_info['status']];
    				$orderInfo['orderdetailList'][$key]['exchange_id'] = $exchange_info['id'];
    				if ($exchange_info['status'] == 2 && $exchange_info['exchange_type'] == 1) {
    					$orderInfo['orderdetailList'][$key]['exchange_status'] = '查看退货地址';
    				}
    				if ($exchange_info['status'] == 2 && $exchange_info['exchange_type'] == 2) {
    					$orderInfo['orderdetailList'][$key]['exchange_status'] = '查看换货地址';
    				}
    				if ($exchange_info['status'] == 1) {
    					$orderInfo['orderdetailList'][$key]['exchange_status'] = '再次申请';
    					$orderInfo['orderdetailList'][$key]['refuse_cause'] = $exchange_info['remark'];
    				}
    				if ($exchange_info['status'] == 2 && $exchange_info['exchange_type'] == 1 && $exchange_info['buyer_express_num']) {
    					$orderInfo['orderdetailList'][$key]['exchange_status'] = '退款中';
    				}
    				if ($exchange_info['status'] == 2 && $exchange_info['exchange_type'] == 2 && $exchange_info['buyer_express_num']) {
    					$orderInfo['orderdetailList'][$key]['exchange_status'] = '备货中';
    				}
    				if ($exchange_info['status'] == 2 && $exchange_info['exchange_type'] == 2 && $exchange_info['seller_recieve_goods'] == 1) {
    					$orderInfo['orderdetailList'][$key]['exchange_status'] = '换货成功';
    				}
    				if ($exchange_info['status'] == 0 && $exchange_info['exchange_type'] == 3) {
    					$orderInfo['orderdetailList'][$key]['exchange_status'] = '待审核';
    				}
    				if ($exchange_info['status'] == 2 && $exchange_info['exchange_type'] == 3) {
    					$orderInfo['orderdetailList'][$key]['exchange_status'] = '已退款';
    				}
    				if ($exchange_info['status'] == 2 && $exchange_info['exchange_type'] == 1 && $exchange_info['price'] > 0) {
    					$orderInfo['orderdetailList'][$key]['exchange_status'] = '已退款';
    				}
    			} else {
    				$orderInfo['orderdetailList'][$key]['exchange_status'] = '申请退货/换货';
    				if ($orderInfo['status'] == 1 || $orderInfo['status'] == 2) {
    					$orderInfo['orderdetailList'][$key]['exchange_status'] = '申请退款';
    				}
    			}
    		}
    		$orderInfo['add_time_format'] = date('Y-m-d H:i:s', $orderInfo['add_time']);
    		$orderInfo['status_format'] = $this->_status_arr[$orderInfo['status']];
    	}
    	printAjaxData($orderInfo);
    }

    /**
     * 取消订单
     */
    public function close_order() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$id = $this->input->post('id', TRUE);
    		$cancel_cause = $this->input->post('cancel_cause', true);
    		if (!$id) {
    			printAjaxError('fail', '操作异常');
    		}
    		if (!$cancel_cause) {
    			printAjaxError('fail', '请选择关闭订单理由');
    		}
    		$order_info = $this->Orders_model->get('id, user_id, order_number, status, pay_mode, deductible_score, deductible_score_gold, deductible_score_silver', array('id' => $id, 'user_id' => $user_id));
    		if (!$order_info) {
    			printAjaxError('fail', '此订单不存在');
    		}
    		if ($order_info['status'] > 0) {
    			printAjaxError('fail', '此状态不可取消订单');
    		}
			$user_info = $this->User_model->getInfo('*', array('id' => $order_info['user_id']));
            if (!$user_info) {
            	printAjaxError('fail', "账号信息异常，请重新登录，再试");
            }

    		//添加订单信息
    		$fields = array(
    				'status' => 4,
    				'cancel_cause' => $cancel_cause,
    		);
    		$ret = $this->Orders_model->save($fields, array('id' => $id, 'user_id' => $user_id));
    		if ($ret) {
    			$fields = array(
    					'current_status'=>$order_info['status'],
    					'change_status'=>4,
    					'add_time' => time(),
    					'content' => '买家取消订单-原因：'.$cancel_cause,
    					'order_id' => $id);
    			$this->Orders_process_model->save($fields);
				//判断是不是积分换购
				if ($order_info['pay_mode'] > 0) {
					//退还金象积分部分
					if ($order_info['deductible_score_gold'] > 0) {
						if (!$this->Score_model->rowCount(array('score_type'=>'gold', 'user_id' => $user_info['id'], 'ret_id' => $order_info['id'], 'type' => 'orders_buy_in'))) {
                			$balance = $user_info['score_gold'] + $order_info['deductible_score_gold'];
                			if ($this->User_model->save(array('score_gold'=>$balance), array('id' => $user_info['id']))) {
                				$sFields = array(
                						'score_type'=>'gold',
                						'cause' => "买家取消订单，退还积分-[订单号：{$order_info['order_number']}]",
                						'score' => $order_info['deductible_score_gold'],
                						'balance' => $balance,
                						'type' => 'orders_buy_in',
                						'add_time' => time(),
                						'username' => $user_info['username'],
                						'user_id' => $user_info['id'],
                						'ret_id' => $order_info['id']
                				);
                				$this->Score_model->save($sFields);
                			}
                		}
					}
					//退还银象积分部分
					if ($order_info['deductible_score_silver'] > 0) {
						if (!$this->Score_model->rowCount(array('score_type'=>'silver', 'user_id' => $user_info['id'], 'ret_id' => $order_info['id'], 'type' => 'orders_buy_in'))) {
                			$balance = $user_info['score_silver'] + $order_info['deductible_score_silver'];
                			if ($this->User_model->save(array('score_silver'=>$balance), array('id' => $user_info['id']))) {
                				$sFields = array(
                						'score_type'=>'silver',
                						'cause' => "买家取消订单，退还积分-[订单号：{$order_info['order_number']}]",
                						'score' => $order_info['deductible_score_silver'],
                						'balance' => $balance,
                						'type' => 'orders_buy_in',
                						'add_time' => time(),
                						'username' => $user_info['username'],
                						'user_id' => $user_info['id'],
                						'ret_id' => $order_info['id']
                				);
                				$this->Score_model->save($sFields);
                			}
                		}
					}
				}
				//加库存-下单减库存
				$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
	            if ($systemInfo['stock_reduce_type'] == 0) {
		            $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $id));
		            if ($orders_detail_list) {
		            	foreach ($orders_detail_list as $item) {
		            		if ($item['color_size_open'] == 1) {
		            			$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
		            			if ($product_stock_info) {
		            				$stock = $product_stock_info['stock'] + $item['buy_number'];
		            				$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
		            			}
		            		} else {
		            			$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
		            			if ($product_info) {
		            				$stock = $product_info['stock'] + $item['buy_number'];
		            				$this->Product_model->save(array('stock' =>$stock), array('id' => $item['product_id']));
		            			}
		            		}
		            	}
		            }
	            }
    			printAjaxSuccess('success', '交易关闭成功');
    		} else {
    			printAjaxError('fail', '交易关闭失败');
    		}
    	}
    }

    /**
     * 确认收货
     */
    public function receiving_order() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$id = $this->input->post('id', TRUE);
    		if (!$id) {
    			printAjaxError('fail', "操作异常，请重试");
    		}
    		$item_info = $this->Orders_model->get('*', array('id' => $id, 'user_id'=>$user_id));
    		if (!$item_info) {
    			printAjaxError('fail', "不存在此订单");
    		}
    		if ($item_info['status'] != 2) {
    			printAjaxError('fail', "此订单状态异常，确认收货失败");
    		}
    		//     		$exchange_info = $this->Exchange_model->get('*', array('orders_id'=>$id, 'user_id'=>$item_info['user_id']));
    		//     		if ($exchange_info) {
    		//     			if ($exchange_info['status'] >= 3) {
    		//     				printAjaxError('fail', "此订单退款申请成功，不能完成下面的操作");
    		//     			} else {
    		//     				if ($exchange_info['status'] != 1) {
    		//     					printAjaxError('fail', "此订单退款申请审核中，不能完成下面的操作");
    		//     				}
    		//     			}
    		//     		}
    		$userInfo = $this->User_model->getInfo('id, username, score_gold, score_silver', array('id' => $item_info['user_id']));
    		if (!$userInfo) {
    			printAjaxError('fail', "此订单异常，确认收货失败");
    		}
    		$fields = array(
    				'status' => 3
    		);
    		if ($this->Orders_model->save($fields, array('id' => $id))) {
    			//操作记录
    			$fields = array(
    					'add_time' => time(),
    					'content' => "确认收货，交易成功",
    					'order_id' => $item_info['id'],
    					'current_status'=>$item_info['status'],
    					'change_status'=>3
    			);
    			$this->Orders_process_model->save($fields);
    			//消费者积分操作
    			//金象积分
    			if ($item_info['gold_score'] > 0) {
    				if (!$this->Score_model->rowCount(array('score_type'=>'gold', 'type' =>'orders_in', 'user_id' =>  $userInfo['id'], 'ret_id' =>   $item_info['id']))) {
    					$balance = $userInfo['score_gold'] + $item_info['gold_score'];
    					if ($this->User_model->save(array('score_gold' =>$balance), array('id' => $userInfo['id']))) {
    						$fields = array(
    								'cause' =>    "订单交易成功-{$item_info['order_number']}",
    								'score' =>    $item_info['gold_score'],
    								'balance' =>  $balance,
    								'score_type'=>'gold',
    								'type' =>     'orders_in',
    								'add_time' => time(),
    								'username' => $userInfo['username'],
    								'user_id' =>  $userInfo['id'],
    								'ret_id' =>   $item_info['id']
    						);
    						$this->Score_model->save($fields);
    					}
    				}
    			}
    			//银象积分
    			if ($item_info['silver_score'] > 0) {
    				if (!$this->Score_model->rowCount(array('score_type'=>'silver', 'type'=>'orders_in', 'user_id'=>$userInfo['id'], 'ret_id'=>$item_info['id']))) {
    					$balance = $userInfo['score_silver'] + $item_info['silver_score'];
    					if ($this->User_model->save(array('score_silver' =>$balance), array('id' => $userInfo['id']))) {
    						$fields = array(
    								'cause' =>    "订单交易成功-{$item_info['order_number']}",
    								'score' =>    $item_info['silver_score'],
    								'balance' =>  $balance,
    								'score_type'=>'silver',
    								'type' =>     'orders_in',
    								'add_time' => time(),
    								'username' => $userInfo['username'],
    								'user_id' =>  $userInfo['id'],
    								'ret_id' =>   $item_info['id']
    						);
    						$this->Score_model->save($fields);
    					}
    				}
    			}
    			/*********************分销-返积分*******************/
    			//一级提成
    			if ($item_info['divide_user_id_1'] > 0) {
    				$user_info_1 = $this->User_model->getInfo('id, username, score_gold, score_silver', array('id' => $item_info['divide_user_id_1']));
    				if ($user_info_1) {
    					if ($item_info['divide_user_score_gold_1'] > 0) {
    						if (!$this->Score_model->rowCount(array('score_type'=>'gold', 'type' =>'presenter_in', 'user_id' =>$user_info_1['id'], 'ret_id' =>$item_info['id']))) {
    							$balance = $user_info_1['score_gold'] + $item_info['divide_user_score_gold_1'];
    							if ($this->User_model->save(array('score_gold' =>$balance), array('id' => $user_info_1['id']))) {
    								$fields = array(
    										'cause' =>    "订单交易成功-订单{$item_info['order_number']}返提成",
    										'score' =>    $item_info['divide_user_score_gold_1'],
    										'balance' =>  $balance,
    										'score_type'=>'gold',
    										'type' =>     'presenter_in',
    										'add_time' => time(),
    										'username' => $user_info_1['username'],
    										'user_id' =>  $user_info_1['id'],
    										'ret_id' =>   $item_info['id'],
    										'from_user_id'=>$item_info['user_id']
    								);
    								$this->Score_model->save($fields);
    							}
    						}
    					}
    					if ($item_info['divide_user_score_silver_1'] > 0) {
    						if (!$this->Score_model->rowCount(array('score_type'=>'silver', 'type' =>'presenter_in', 'user_id' =>$user_info_1['id'], 'ret_id' =>$item_info['id']))) {
    							$balance = $user_info_1['score_silver'] + $item_info['divide_user_score_silver_1'];
    							if ($this->User_model->save(array('score_silver' =>$balance), array('id' => $user_info_1['id']))) {
    								$fields = array(
    										'cause' =>    "订单交易成功-订单{$item_info['order_number']}返提成",
    										'score' =>    $item_info['divide_user_score_silver_1'],
    										'balance' =>  $balance,
    										'score_type'=>'silver',
    										'type' =>     'presenter_in',
    										'add_time' => time(),
    										'username' => $user_info_1['username'],
    										'user_id' =>  $user_info_1['id'],
    										'ret_id' =>   $item_info['id'],
    										'from_user_id'=>$item_info['user_id']
    								);
    								$this->Score_model->save($fields);
    							}
    						}
    					}
    				}

    			}
    			//二级提成
    			if ($item_info['divide_user_id_2'] > 0) {
    				$user_info_2 = $this->User_model->getInfo('id, username, score_gold, score_silver', array('id' => $item_info['divide_user_id_2']));
    				if ($user_info_2) {
    					if ($item_info['divide_user_score_gold_2'] > 0) {
    						if (!$this->Score_model->rowCount(array('score_type'=>'gold', 'type' =>'presenter_in', 'user_id' =>$user_info_2['id'], 'ret_id' =>$item_info['id']))) {
    							$balance = $user_info_2['score_gold'] + $item_info['divide_user_score_gold_2'];
    							if ($this->User_model->save(array('score_gold' =>$balance), array('id' => $user_info_2['id']))) {
    								$fields = array(
    										'cause' =>    "订单交易成功-订单{$item_info['order_number']}返提成",
    										'score' =>    $item_info['divide_user_score_gold_2'],
    										'balance' =>  $balance,
    										'score_type'=>'gold',
    										'type' =>     'presenter_in',
    										'add_time' => time(),
    										'username' => $user_info_2['username'],
    										'user_id' =>  $user_info_2['id'],
    										'ret_id' =>   $item_info['id'],
    										'from_user_id'=>$item_info['user_id']
    								);
    								$this->Score_model->save($fields);
    							}
    						}
    					}
    					if ($item_info['divide_user_score_silver_2'] > 0) {
    						if (!$this->Score_model->rowCount(array('score_type'=>'silver', 'type' =>'presenter_in', 'user_id' =>$user_info_2['id'], 'ret_id' =>$item_info['id']))) {
    							$balance = $user_info_2['score_silver'] + $item_info['divide_user_score_silver_2'];
    							if ($this->User_model->save(array('score_silver' =>$balance), array('id' => $user_info_2['id']))) {
    								$fields = array(
    										'cause' =>    "订单交易成功-订单{$item_info['order_number']}返提成",
    										'score' =>    $item_info['divide_user_score_silver_2'],
    										'balance' =>  $balance,
    										'score_type'=>'silver',
    										'type' =>     'presenter_in',
    										'add_time' => time(),
    										'username' => $user_info_2['username'],
    										'user_id' =>  $user_info_2['id'],
    										'ret_id' =>   $item_info['id'],
    										'from_user_id'=>$item_info['user_id']
    								);
    								$this->Score_model->save($fields);
    							}
    						}
    					}
    				}
    			}
    			//减库存与加销售量
    			$orders_detail_list = $this->Orders_detail_model->gets('product_id, buy_number, color_size_open', array('order_id' => $id));
    			if ($orders_detail_list) {
    				foreach ($orders_detail_list as $key=>$value) {
                        if ($value['color_size_open']) {
                            //尺码库存
                            $psc_info = $this->Product_size_color_model->get('id, stock', array('product_id'=>$value['product_id'], 'color_id'=>$value['color_id'], 'size_id'=>$value['size_id']));
                            if ($psc_info) {
                                $stock = $psc_info['stock'] - $value['buy_number'];
                                $fields = array(
                                    'stock'=>$stock?$stock:0
                                );
                                $this->Product_size_color_model->save($fields, array('id'=>$psc_info['id']));
                            }
                        }
                        //商品库存与销售量
                        $product_info = $this->Product_model->get('stock, sales', array('id'=>$value['product_id']));
                        if ($product_info) {
                            $product_stock = $product_info['stock'] - $value['buy_number'];
                            $fields = array(
                                'stock'=>$product_stock?$product_stock:0,
                                'sales'=>$product_info['sales'] + $value['buy_number']
                            );
                            $this->Product_model->save($fields, array('id'=>$value['product_id']));
                        }
    				}
    			}
    			printAjaxSuccess('success', '确认收货成功');
    		} else {
    			printAjaxError('fail', "确认收货失败");
    		}
    	}
    }

    //再次购买
    public function buy_again() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$order_id = $this->input->post('order_id', true);
    		if (!$order_id) {
    			printAjaxError('fail', '参数不能为空');
    		}
    		$orders_info = $this->Orders_model->get('status', array('id' => $order_id, 'user_id'=>$user_id));
    		if (!$orders_info) {
    			printAjaxError('fail', '此订单信息不存在');
    		}
    		$orders_detail_list = $this->Orders_detail_model->gets2(array('orders_detail.order_id' => $order_id));
    		if (!$orders_detail_list) {
    			printAjaxError('fail', '此订单信息不存在');
    		}
    		if ($orders_detail_list) {
    			foreach ($orders_detail_list as $key=>$value) {
    				$strWhere = array(
    						'user_id'=>    $user_id,
    						'product_id'=> $value['product_id'],
    						'size_id'=>    $value['size_id'],
    						'color_id'=>   $value['color_id']
    				);
    				$cart_info = $this->Cart_model->get('buy_number,id', $strWhere);
    				if ($cart_info) {
    					$fields = array(
    							'buy_number' => $cart_info['buy_number']+1
    					);
    					$this->Cart_model->save($fields, array('id'=>$cart_info['id'], 'user_id'=>$user_id));
    				} else {
    					$fields = array(
    							'user_id' =>    $user_id,
    							'product_id' => $value['product_id'],
    							'size_name' =>  $value['size_name'],
    							'size_id' =>    $value['size_id'],
    							'color_name' => $value['color_name'],
    							'color_id' =>   $value['color_id'],
    							'buy_number' => $value['buy_number'],
    							'sell_price' => $value['sell_price']
    					);
    					$this->Cart_model->save($fields);
    				}
    			}
    		}
    		$cart_count = $this->Cart_model->rowSum(array('user_id'=>$user_id));
    		printAjaxData(array('cart_count'=>$cart_count));
    	}
    }

   /**
     * 我的评价
     *
     * @param number $max_id     若指定此参数，则返回ID小于或等于max_id的信息,相当于more
     * @param number $since_id   获取最新信息,相当于下拉刷新
     * @param number $per_page   每页数
     * @param number $page       页数
     */
    public function get_my_comment_list($max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
    	$user_id = $this->_check_login();
    	$strWhere = "comment.user_id = {$user_id} ";
    	if ($since_id) {
    		$strWhere .= " and comment.id > {$since_id} ";
    	}
    	if ($max_id) {
    		$strWhere .= " and comment.id <= {$max_id} ";
    	}
    	$item_list = $this->Comment_model->gets('*', $strWhere, $per_page, $per_page * ($page - 1));
    	if ($item_list) {
    		foreach ($item_list as $key => $value) {
    			$tmp_image_arr = $this->_fliter_image_path($value['path']);
    			$item_list[$key]['path'] = $tmp_image_arr['path'];
    			$item_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
    			$item_list[$key]['add_time_format'] = date('Y-m-d H:i:s', $value['add_time']);
				//晒图
				$attachment_list = array();
		        if ($value['batch_path_ids']) {
		            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $value['batch_path_ids']);
		            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
		            if ($attachment_list) {
		            	foreach ($attachment_list as $key => $ls) {
		            		$tmp_image_arr = $this->_fliter_image_path($ls['path']);
		            		$attachment_list[$key]['path'] = $tmp_image_arr['path'];
		            		$attachment_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
		            	}
		            }
		        }
				$item_list[$key]['attachment_list'] = $attachment_list;
				//昵称
				$nickname = '';
				$user_info = $this->User_model->getInfo('username, nickname', array('id'=>$value['user_id']));
				if ($user_info) {
					if ($user_info['nickname']) {
						$nickname = $user_info['nickname'];
					} else {
						$nickname = createMobileBit($user_info['username']);
					}
				}
				$item_list[$key]['nickname'] = $nickname;
    		}
    	}
    	// 最大ID
    	if (!$max_id && !$since_id) {
    		$max_id = $this->Comment_model->get_max_id(NULL);
    	} else {
    		//下拉刷新
    		if (!$max_id && $since_id) {
    			$max_id = $this->Comment_model->get_max_id(NULL);
    		}
    	}
    	//是否有下一页
    	$cur_count = $per_page * ($page - 1) + count($item_list);
    	$total_count = $this->Comment_model->rowCount($strWhere);
    	$is_next_page = 0;
    	if ($total_count > $cur_count) {
    		$is_next_page = 1;
    	}
    	printAjaxData(array('item_list' => $item_list, 'max_id' => $max_id, 'is_next_page' => $is_next_page));
    }

    /**
     * 订单评价
     */
    public function comment_save() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
            $product_id = json_decode($this->input->post('product_id', TRUE),TRUE);
            $grade = json_decode($this->input->post('grade', TRUE),TRUE);
            $content = json_decode($this->input->post('content', TRUE),TRUE);
            $batch_path_ids = json_decode($this->input->post('batch_path_ids', TRUE),TRUE);
    		$order_id = $this->input->post('order_id', TRUE);

    		if (!$order_id) {
    			printAjaxError('fail', '此订单信息不存在');
    		}
    		if (!$product_id) {
    			printAjaxError('fail', '商品参数不能为空');
    		}
    		if (!$grade) {
    			printAjaxError('fail', '等级参数不能为空');
    		}
    		if ($product_id) {
    			foreach ($product_id as $key=>$value) {
                    if (!$grade[$key]) {
                    	printAjaxError('fail', '评分存在未评项，请检查');
                    }
					if (!$content[$key]) {
                    	printAjaxError('fail', '评价内容存在未评项，请检查');
                    }
    			}
    		}
    		$order_info = $this->Orders_model->get('id, status, order_number, is_comment_to_seller', array('user_id'=>$user_id, 'id'=>$order_id));
    		if (!$order_info) {
    			printAjaxError('fail', '此订单不存在或订单状态异常');
    		}
    		if ($order_info['status'] != 3) {
    			printAjaxError('fail', '此订单状态异常，不能进行评价');
    		}
    		if ($order_info['is_comment_to_seller']) {
    			printAjaxError('fail', '此订单已评价，不用重复评价');
    		}
    		foreach ($product_id as $key=>$value) {
                $product_info = $this->Product_model->get('*', array('id'=>$value));
				if (!$this->Comment_model->rowCount(array('order_id'=>$order_id, 'product_id'=>$value, 'user_id'=>$user_id))) {
                	$fields = array(
                			'order_id' => $order_id,
                			'order_number' => $order_info['order_number'],
                			'product_id' => $value,
                			'user_id' => $user_id,
                			'grade'=>$grade[$key],
                			'content' => $content[$key],
                			'batch_path_ids'=>!empty($batch_path_ids[$key]) ? $batch_path_ids[$key] : '',
                			'add_time' => time(),
                			'product_title' => $product_info['title'],
                			'sell_price'=>$product_info['sell_price'],
                			'path'=>$product_info['path'],
                			'display'=>1
                	);
                	$this->Comment_model->save($fields);
                }
    		}
    		if (!$this->Orders_model->save(array('is_comment_to_seller'=>1), array('id'=>$order_info['id']))) {
    			printAjaxError('fail', '评价失败');
    		}
    		printAjaxSuccess('success', "评价成功");
    	}
    }

    //去退换货－显示某订单进度
    public function get_order_detail_for_exchange($id) {
    	$user_id = $this->_check_login();
    	$strWhere = array('user_id' => $user_id, 'id' => $id);
    	$orderInfo = $this->Orders_model->get('id,order_number,total,status,add_time', $strWhere);
    	if ($orderInfo) {
    		$orderdetailList = $this->Orders_detail_model->gets('*', array('order_id' => $orderInfo['id']));
    		foreach ($orderdetailList as $key => $item) {
    			$tmp_image_arr = $this->_fliter_image_path($item['path']);
    			$orderdetailList[$key]['path'] = $tmp_image_arr['path'];
    			$orderdetailList[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];

    			$exchange_info = $this->Exchange_model->get('*', array('orders_detail_id' => $item['id']));
    			$orderdetailList[$key]['exchange_info'] = $exchange_info?$exchange_info:"";
    		}
    		$orderInfo['orderdetailList'] = $orderdetailList;
    	}
    	printAjaxData($orderInfo);
    }

    //去退换货－显示某订单进度
    public function get_exchange_info($id) {
    	$user_id = $this->_check_login();
    	$strWhere = array('user_id' => $user_id, 'id' => $id);
    	$item_info = $this->Exchange_model->get('*', $strWhere);
    	if (!$item_info) {
    		printAjaxError('fail', '此退换货信息不存在');
    	}
    	//凭证图片
    	$attachment_list = array();
    	if ($item_info['batch_path_ids']) {
    		$attachment_list = $this->Attachment_model->gets2($item_info['batch_path_ids']);
    		if ($attachment_list) {
    			foreach ($attachment_list as $key=>$value) {
    				$tmp_image_arr = $this->_fliter_image_path($value['path']);
    				$attachment_list[$key]['path'] = $tmp_image_arr['path'];
    				$attachment_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
    			}
    		}
    	}
    	$item_info['attachment_list'] = $attachment_list;

    	printAjaxData($item_info);
    }

    //修改密码
    public function change_pass() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$oldPassword = $this->input->post('old_password', TRUE);
    		$newPassword = $this->input->post('new_password', TRUE);
    		$conPassword = $this->input->post('con_password', TRUE);

    		if (!$this->form_validation->required($oldPassword)) {
    			printAjaxError('old_password', '原始密码不能为空');
    		}
    		if (!$this->form_validation->required($newPassword)) {
    			printAjaxError('new_password', '新密码不能为空');
    		}
    		if (!$this->form_validation->required($conPassword)) {
    			printAjaxError('con_password', '确认新密码不能为空');
    		}
    		if ($newPassword != $conPassword) {
    			printAjaxError('con_password', '新密码前后不一致');
    		}
    		//验证密码是否正确
    		$userInfo = $this->User_model->get('password, username', array('user.id' => $user_id));
    		if (!$userInfo) {
    			printAjaxError('fail', '此用户不存在');
    		}
    		if ($userInfo['password'] != $this->User_model->getPasswordSalt($userInfo['username'], $oldPassword)) {
    			printAjaxError('old_password', '原始密码错误');
    		}
    		$fields = array(
    				'password' => $this->User_model->getPasswordSalt($userInfo['username'], $newPassword)
    		);
    		if ($this->User_model->save($fields, array('id' => $user_id))) {
    			printAjaxSuccess('success', '密码修改成功');
    		} else {
    			printAjaxError('fail', '密码修改失败');
    		}
    	}
    }

    //购物车
    public function get_cart_list() {
    	$user_id = $this->_check_login();
    	$item_list = $this->Cart_model->gets(array('cart.user_id' => $user_id));
    	if ($item_list) {
    		foreach ($item_list as $key => $value) {
    			$tmp_image_arr = $this->_fliter_image_path($value['path']);
    			$item_list[$key]['path'] = $tmp_image_arr['path'];
    			$item_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
    		}
    	}
    	$cart_count = $this->Cart_model->rowSum(array('user_id'=>$user_id));

    	printAjaxData(array('item_list' => $item_list, 'cart_count'=>$cart_count));
    }

    /*
     * 修改购物车数量
     */
    public function change_cart_number() {
    	$user_id = $this->_check_login();
        if ($_POST) {
    		$buy_number = $this->input->post('buy_number', TRUE);
    		$cart_id = $this->input->post('cart_id', TRUE);
    		$ids = $this->input->post('ids', TRUE);

    		if (!$buy_number || !$cart_id) {
    			printAjaxError('fail', '操作异常，请重试');
    		}
    		$item_info = $this->Cart_model->get2(array("cart.id" => $cart_id));
    		if (!$item_info) {
    			printAjaxError('fail', '修改信息不存在，请重试');
    		}
    		if ($item_info['color_size_open']) {
    			//有规格的商品
    			$product_stock_info = $this->Product_model->getProductStock($item_info['product_id'], $item_info['color_id'], $item_info['size_id']);
    			if (!$product_stock_info) {
    				printAjaxError('fail', '没有此规格的商品，请删除');
    			}
    			if ($buy_number > $product_stock_info['stock']) {
    				printAjaxError('fail', "此款商品库存不足，库存为：{$product_stock_info['stock']}");
    			}
    		} else {
    			if ($buy_number > $item_info['stock']) {
    				printAjaxError('fail', "此款商品库存不足，库存为：{$item_info['stock']}");
    			}
    		}
    		if (!$this->Cart_model->save(array('buy_number' => $buy_number), array('id' => $cart_id, 'user_id'=>$user_id))) {
    			printAjaxError('fail', '数量修改失败');
    		}

    		printAjaxData($this->_select_cart_info($user_id, $ids));
    	}
    }

    //批量删除购物车中商品
    public function batch_delete_cart_product() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$delete_ids = $this->input->post('delete_ids', TRUE);
    		if (!$delete_ids) {
    			printAjaxError('ids', '请选择删除项');
    		}
    		if (!$this->Cart_model->delete("id in ({$delete_ids}) and user_id = {$user_id} ")) {
    			printAjaxError('fail', '删除失败');
    		}

    		printAjaxData($this->_select_cart_info($user_id, ''));
    	}
    }

    /*
     * 加入购物车
     */
    public function add_cart() {
    	$user_id = $this->_check_login();
       if ($_POST) {
    		$product_id = $this->input->post('product_id');
    		$color_id = $this->input->post('color_id', TRUE);
    		$size_id = $this->input->post('size_id', TRUE);
    		$buy_number = $this->input->post('buy_number');
    		$buy_type = $this->input->post('buy_type');

    		$color_name = '';
    		$size_name = '';
    		$sell_price = '';
    		if (! $this->form_validation->required($product_id)) {
    			printAjaxError('fail', '产品id不能为空');
    		}
    		$item_info = $this->Product_model->get('stock, sell_price, color_size_open, product_color_name, product_size_name', array('id'=>$product_id, 'display'=>1));
    		if (! $item_info) {
    			printAjaxError('fail', '此商品不存在或被删除');
    		}
    		if ($item_info['color_size_open']) {
	    		if (! $this->form_validation->required($color_id)) {
	    			printAjaxError('fail', '请选择'.$item_info['product_color_name']);
	    		}
	    		$color_list = $this->Product_model->getDetailColor($product_id);
	    		if ($color_list) {
	    			foreach ($color_list as $key=>$value) {
	    				if ($value['color_id'] == $color_id) {
	    					$color_name = $value['color_name'];
	    					break;
	    				}
	    			}
	    		}
	    		if (! $color_name) {
	    			printAjaxError('fail', '此'.$item_info['product_color_name'].'不存在');
	    		}
	    		if (! $this->form_validation->required($size_id)) {
	    			printAjaxError('fail', '请选择'.$item_info['product_size_name']);
	    		}
	    		$sizeList = $this->Product_model->getDetailSize($product_id);
	    		if ($sizeList) {
	    			foreach ($sizeList as $key=>$value) {
	    				if ($value['size_id'] == $size_id) {
	    					$size_name = $value['size_name'];
	    				}
	    			}
	    		}
	    		if (!$size_name) {
	    			printAjaxError('fail', '此'.$item_info['product_size_name'].'不存在');
	    		}
    		}
    		if (! $this->form_validation->integer($buy_number)) {
    			printAjaxError('fail', '请填写正确的购买数量');
    		}
    		if ($buy_number < 1) {
    			printAjaxError('fail', '购买数量必须大于零');
    		}
    		//有规格的产品
    		if ($item_info['color_size_open']) {
    			$product_stock_info = $this->Product_model->getProductStock($product_id, $color_id, $size_id);
    			if (!$product_stock_info) {
    				printAjaxError('fail', '没有此规格的商品');
    			}
    			$sell_price = $product_stock_info['price'];
    			if ($buy_number > $product_stock_info['stock']) {
    				printAjaxError('fail', '购买数量不能大于库存');
    			}
    		} else {
    			//没有规格的产品
    			$color_id = 0;
    			$size_id = 0;
                $sell_price = $item_info['sell_price'];
    			//没有规格的产品
    			if ($buy_number > $item_info['stock']) {
    				printAjaxError('fail', '购买数量不能大于库存');
    			}
    		}

    		$strWhere = array(
    				'user_id'=>    $user_id,
    				'product_id'=> $product_id,
    				'size_id'=>    $size_id,
    				'color_id'=>   $color_id
    		);
    		$cartInfo = $this->Cart_model->get('buy_number,id', $strWhere);
    		//已购买的
    		if ($cartInfo) {
    			$edit_fields = array(
    					'buy_number'=>$buy_number+$cartInfo['buy_number']
    			);
    			//是否为立即购买
    			if ($buy_type) {
    				$edit_fields = array(
    						'buy_number'=>$buy_number
    				);
    			}
    			if ($this->Cart_model->save($edit_fields, $strWhere)) {
    				$cart_count = $this->Cart_model->rowSum(array('user_id'=>$user_id));
    				printAjaxData(array('cart_count'=>$cart_count, 'cart_id'=>$cartInfo['id']));
    			} else {
    				printAjaxError('fail', '加入购物车失败');
    			}
    		} else {//第一次购买的
    			$fields = array(
    					'user_id'=>    $user_id,
    					'product_id'=> $product_id,
    					'size_name'=>  $size_name,
    					'size_id'=>    $size_id,
    					'color_name'=> $color_name,
    					'color_id'=>   $color_id,
    					'buy_number'=> $buy_number,
    					'sell_price'=> $sell_price
    			);
    			$ret_id = $this->Cart_model->save($fields);
    			if ($ret_id) {
    				$cart_count = $this->Cart_model->rowSum(array('user_id'=>$user_id));
    				printAjaxData(array('cart_count'=>$cart_count, 'cart_id'=>$ret_id));
    			} else {
    				printAjaxError('fail', '加入购物车失败');
    			}
    		}
    	}
    }

    //获取选定商品信息
    public function get_select_cart_info() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$ids = $this->input->post('ids', TRUE);

    		printAjaxData($this->_select_cart_info($user_id, $ids));
    	}
    }

    //订单确认信息
    public function confirm_cart() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$cart_ids = $this->input->post('cart_ids', TRUE);
    		if (!$cart_ids) {
    			printAjaxError('fail', '请选择结算商品');
    		}
    		$cartList = $this->Cart_model->gets("cart.user_id = {$user_id} and cart.id in ({$cart_ids}) ");
    		if (!$cartList) {
    			printAjaxError('fail', '您的购物车没有宝贝，快去选购宝贝哦！');
    		}
    		//配送方式
    		$postage_way = array('id'=>'', 'title'=>'', 'content'=>'');
    		$free = 0;//是否包邮
    		$total = 0.00;//订单总金额
    		$postage_price = 0;//快递费用
    		$product_total = 0;//商品总金额
    		$consume_score_total = 0;//积分换购积分总数量
    		$product_number = 0;//商品数量
    		$postage_way_ids = '';//商品的快递模板
    		$area_name = '';//默认配送地区
    		$silver_give_score = 0;
    		$gold_give_score = 0;
    		$use_deductible_score_gold = 0;//需付多少金象积分
    		$use_deductible_score_silver = 0;//需付多少银象积分
    		$default_user_address_info = NULL;
    		if ($cartList) {
    			foreach ($cartList as $key=>$value) {
    				$tmp_image_arr = $this->_fliter_image_path($value['path']);
    				$cartList[$key]['path'] = $tmp_image_arr['path'];
    				$cartList[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
    				$cartList[$key]['product_type_format'] = $this->_product_type_arr[$value['product_type']];
    				//银象积分
    				if ($value['product_type'] == 'a') {
    					$silver_give_score += $value['give_score'] * $value['buy_number'];
    				}
    				//金象积分
    				else {
    					$gold_give_score += $value['give_score'] * $value['buy_number'];
    				}
    				$postage_way_ids .= $value['postage_way_id'].',';
    				$product_number += $value['buy_number'];
    				$product_total += $value['sell_price'] * $value['buy_number'];
    				$consume_score_total += $value['consume_score'] * $value['buy_number'];
    				//金象积分-A类商品-需付多少金象积分
    				if ($value['product_type'] == 'a') {
    					$use_deductible_score_gold += $value['consume_score'] * $value['buy_number'];
    				}
    				//银象积分-B、C类商品-需付多少银象积分
    				else {
    					$use_deductible_score_silver += $value['consume_score'] * $value['buy_number'];
    				}
    			}
    		}
    		//默认用户地址
    		$area_name = '';
    		$user_address_info = $this->User_address_model->get('*', array('user_id' => $user_id, 'default' => 1));
    		if ($user_address_info) {
    			$area_info = $this->Area_model->get('name', array('id' => $user_address_info['province_id']));
    			if ($area_info) {
    				$area_name = $area_info['name'];
    			}
    			$user_address_info['txt_address'] = str_replace(' ', '', $user_address_info['txt_address']);
    		} else {
    			$user_address_info['id'] = '';
    			$user_address_info['buyer_name'] = '';
    			$user_address_info['mobile'] = '';
    			$user_address_info['txt_address'] = '';
    			$user_address_info['address'] = '';
    			$user_address_info['zip'] = '';
    			$user_address_info['phone'] = '';
    			$user_address_info['mobile'] = '';
    		}
    		if ($postage_way_ids) {
    			$postage_way_ids = substr($postage_way_ids, 0, -1);
    		}
    		//包邮条件设置
    		$free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
    		//是否全国包邮
    		if($free_postage_setting['is_free'] == 1){
    			$postage_price = 0;
    			$free = 1;
    			$postage_way = array('id'=>'0', 'title'=>'包邮', 'content'=>'全国包邮');
    		} else {
    			if (($product_number >= $free_postage_setting['product_number'] && $free_postage_setting['open_number']==1) || ($product_total >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price']==1)) {
    				$postage_price = 0;
    				$free = 1;
    				$postage_way = array('id'=>'0', 'title'=>'包邮', 'content'=>'包邮（已满'.$free_postage_setting['product_number'].'件或已满'.$free_postage_setting['free_postage_price'].'元）');
    			} else {
    				//判断用哪个快递－谁贵给谁的
    				$postage_way_list = $this->Postage_way_model->gets('*', "id in ({$postage_way_ids})");
    				if ($postage_way_list) {
    					$max_postage_price = 0;
    					$max_key = 0;
    					foreach ($postage_way_list as $key=>$value) {
    						$tmp_postage_price = $this->advdbclass->get_postage_price($value['id'], $area_name, $product_number);
    						if ($tmp_postage_price >$max_postage_price) {
    							$max_postage_price = $tmp_postage_price;
    							$max_key = $key;
    						}
    					}
    					$postage_price = $max_postage_price;
    					$postage_way = $postage_way_list[$max_key];
    				}
    			}
    		}
            //需积分描述
    		$consume_score_total_str = '';
    		if ($use_deductible_score_gold > 0 && $use_deductible_score_silver > 0) {
    		    $consume_score_total_str = "(需{$use_deductible_score_gold}金象积分、{$use_deductible_score_silver}银象积分)";
    		} else if ($use_deductible_score_gold > 0 && $use_deductible_score_silver == 0) {
    		    $consume_score_total_str = "(需{$use_deductible_score_gold}金象积分)";
    		} else if ($use_deductible_score_gold == 0 && $use_deductible_score_silver > 0) {
    		   $consume_score_total_str = "(需{$use_deductible_score_silver}银象积分)";
    		}
    		$user_info = $this->User_model->get('score_silver,score_gold', array('id' => $user_id));

    		$data = array(
    				'cartList' => $cartList,
    				'postage_price' =>number_format($postage_price, 2, '.', ''),
    				'product_total'=>number_format($product_total, 2, '.', ''),
    				'total' => number_format($product_total+$postage_price, 2, '.', ''),
    				'consume_score_total'=>$consume_score_total,
    				'consume_score_total_str'=>$consume_score_total_str,
    				'silver_give_score'=>$silver_give_score,
    				'gold_give_score'=>$gold_give_score,
    				'cart_ids' => $cart_ids,
    				'postage_way' => $postage_way,
    				'free' => $free,
    				'use_deductible_score_gold'=>$use_deductible_score_gold,
    				'use_deductible_score_silver'=>$use_deductible_score_silver,
    				'product_type_arr'=>$this->_product_type_arr,
    				'user_address_info'=>$user_address_info,
    				'user_info'=>$user_info
    		);
    		printAjaxData($data);
    	}
    }

    //计算配送费用
    public function get_postage_price() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$systemInfo = $this->System_model->get('*', array('id' => 1));
    		$cart_ids = $this->input->post('cart_ids',true);
    		$use_score = $this->input->post('use_score',true);

    		$postage_template_id = 0;
    		$postage_template_title = '';//标题
    		$postage_template_content = '';//包邮描述
    		$free = 0;//是否包邮
    		$postage_price = 0;//快递费用
    		$product_total = 0;//商品总金额
    		$total = 0.00;//订单总金额
    		$consume_score_total = 0;//积分换购积分总数量
    		$product_number = 0;//商品数量
    		$postage_way_ids = '';//商品的快递模板
    		$area_name = '';//默认配送地区
    		$silver_give_score = 0;//银象积分
    		$gold_give_score = 0;//金象积分

    		if (!$cart_ids) {
    			printAjaxError('fail', '购物车中没有商品，请选购商品');
    		}
    		$user_address_info = $this->User_address_model->get('*', array('default' => 1, 'user_id'=>$user_id));
    		if (!$user_address_info) {
    			printAjaxError('fail', '收货地址不存在,请设置');
    		}
    		$user_address_info['txt_address'] = str_replace(' ', '', $user_address_info['txt_address']);
    		$area_info = $this->Area_model->get('name',array('id'=>$user_address_info['province_id']));
    		if (!$area_info) {
    			printAjaxError('fail', '收货地址不存在');
    		}
    		$area_name = $area_info['name'];
    		$cart_list = $this->Cart_model->gets("cart.user_id = {$user_id} and cart.id in ({$cart_ids})");
    		if ($cart_list) {
    			foreach ($cart_list as $key=>$value) {
    				//银象积分
    				if ($value['product_type'] == 'a') {
    					$silver_give_score += $value['give_score'] * $value['buy_number'];
    				}
    				//金象积分
    				else {
    					$gold_give_score += $value['give_score'] * $value['buy_number'];
    				}
    				$postage_way_ids .= $value['postage_way_id'].',';
    				$product_number += $value['buy_number'];
    				$product_total += $value['sell_price'] * $value['buy_number'];
    				$consume_score_total += $value['consume_score'] * $value['buy_number'];
    			}
    		}
    		if ($postage_way_ids) {
    			$postage_way_ids = substr($postage_way_ids, 0, -1);
    		}
    		//包邮条件设置
    		$free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
    		//是否全国包邮
    		if($free_postage_setting['is_free'] == 1){
    			$postage_price = 0;
    			$free = 1;
    			$postage_template_id = 0;
    			$postage_template_title = '包邮';
    			$postage_template_content = '全国包邮';
    		} else {
    			if (($product_number >= $free_postage_setting['product_number'] && $free_postage_setting['open_number']==1) || ($product_total >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price']==1)) {
    				$postage_price = 0;
    				$postage_template_id = 0;
    				$postage_template_title = '包邮';
    				$postage_template_content = '包邮（已满'.$free_postage_setting['product_number'].'件或已满'.$free_postage_setting['free_postage_price'].'元）';
    				$free = 1;
    			} else {
    				//判断用哪个快递－谁贵给谁的
    				$postage_way_list = $this->Postage_way_model->gets('*', "id in ({$postage_way_ids})");
    				if ($postage_way_list) {
    					$max_postage_price = 0;
    					$max_key = 0;
    					foreach ($postage_way_list as $key=>$value) {
    						$tmp_postage_price = $this->advdbclass->get_postage_price($value['id'], $area_name, $product_number);
    						if ($tmp_postage_price >$max_postage_price) {
    							$max_postage_price = $tmp_postage_price;
    							$max_key = $key;
    						}
    					}
    					$postage_price = $max_postage_price;
    					$tmp_postage_way = $postage_way_list[$max_key];
    					$postage_template_id = $tmp_postage_way['id'];
    					$postage_template_title = $tmp_postage_way['title'];
    					$postage_template_content = $tmp_postage_way['content'];
    				}
    			}
    		}
    		if ($use_score) {
    			$total = number_format($postage_price, 2, '.', '');
    			$silver_give_score = 0;
    			$gold_give_score = 0;
    		} else {
    			$total = number_format($product_total+$postage_price, 2, '.', '');
    		}

    		$data = array(
    				'postage_price' => number_format($postage_price, 2, '.', ''),
    				'product_total'=>number_format($product_total, 2, '.', ''),
    				'total' => $total,
    				'consume_score_total'=>$consume_score_total,
    				'silver_give_score'=>$silver_give_score,
    				'gold_give_score'=>$gold_give_score,
    				'postage_template_id'=>$postage_template_id,
    				'postage_template_title'=>$postage_template_title,
    				'postage_template_content' => $postage_template_content,
    				'free' => $free,
    				'user_address_info'=>$user_address_info
    		);
    		printAjaxData($data);
    	}
    }

    //获取充值订单号
    public function get_recharge_number() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$money = $this->input->post('money', true);
    		$pay_type = $this->input->post('pay_type', true);
    		if (!preg_match("/^\d+(\.\d+)?$/", $money)) {
    			printAjaxError('fail', '金钱格式有误');
    		}
    		$userInfo = $this->User_model->get('total', array('id' => $user_id));
    		if (empty($userInfo)) {
    			printAjaxError('fail', '此用户不存在');
    		}
    		$order_number = $this->advdbclass->get_unique_orders_number();
    		$fields_data = array(
    				'user_id' => $user_id,
    				'order_number' => $order_number,
    				'add_time' => time(),
    				'status ' => 0,
    				'money ' => $money,
    				'balance ' => $userInfo['total'],
    		);
    		if (!$this->Recharge_record_model->save($fields_data)) {
    			printAjaxError('fail', '充值失败');
    		}
    		printAjaxData(array('WIDout_trade_no' => $order_number, 'WIDsubject' => 'test商品123', 'WIDbody' => '即时到账测试', 'notify_url' => base_url() . 'userapi/alipay',));
    	}
    }

    /*
     * 下单
     */
    public function add_order() {
    	//判断是否登录
    	$user_id = $this->_check_login();
        if ($_POST) {
            $systemInfo = $this->System_model->get('*', array('id' => 1));
            $user_address_id = $this->input->post('user_address_id', TRUE);
            $use_score = $this->input->post('use_score', TRUE);
            $cart_ids = $this->input->post('cart_ids', TRUE);
            $remark = $this->input->post('remark', TRUE);

            if (!$user_address_id) {
            	printAjaxError('fail', "请选择收货地址");
            }
            if (!$cart_ids) {
            	printAjaxError('fail', "请选择结算商品");
            }
            //收货地址
            $user_address_info = $this->User_address_model->get('*', array('id' => $user_address_id, 'user_id'=>$user_id));
            if (!$user_address_info) {
            	printAjaxError('fail', '收货地址不存在，下单失败');
            }
            $user_info = $this->User_model->getInfo('*', array('id' => $user_id));
            if (!$user_info) {
            	printAjaxError('fail', "您的账号不存在或被管理员删除");
            }

            $pay_way_str = '';//包邮描述
            $total = 0.00;//订单总金额
            $discount_total = 0;//共优惠
            $postage_price = 0;//快递费用
            $product_total = 0;//商品总金额
            $product_number = 0;//商品数量
            $postage_way_ids = '';//商品的快递模板
            $area_name = '';//默认配送地区
            $silver_give_score = 0;//送积分
            $gold_give_score = 0;//送积分
            $postage_template_id = 0;
            $deliveryTime = 1;
            //分销
            $user_info_1 = NULL;
            $user_info_2 = NULL;
            $divide_user_id_1 = 0;
            $divide_user_id_2 = 0;
            $divide_user_score_gold_1 = 0;
            $divide_user_score_silver_1 = 0;
            $divide_user_score_gold_2 = 0;
            $divide_user_score_silver_2 = 0;
            //积分换购
            $pay_mode = 0;//支付方式：0=用钱购买；1=积分换购；
            $use_deductible_score_gold = 0;//需付多少金象积分
            $use_deductible_score_silver = 0;//需付多少银象积分
            $deductible_score_gold = 0;//用了多少金象积分
            $deductible_score_silver = 0;//用了多少银象积分

            if ($use_score) {
            	$pay_mode = 1;
            } else {
            	/********************分销**********************/
            	//一级
            	if ($user_info['presenter_id'] > 0) {
            		$user_info_1 = $this->User_model->getInfo('user_type, id, username, nickname, presenter_id', array('id' => $user_info['presenter_id']));
            		if ($user_info_1) {
            			$divide_user_id_1 = $user_info_1['id'];
            			//二级
            			if ($user_info_1['presenter_id'] > 0) {
            				$user_info_2 = $this->User_model->getInfo('user_type, id, username, nickname', array('id' => $user_info_1['presenter_id']));
            				if ($user_info_2) {
            					$divide_user_id_2 = $user_info_2['id'];
            				}
            			}
            		}
            	}
            }
            $strWhere = "cart.user_id = {$user_id} and cart.id in ($cart_ids)";
            $cartList = $this->Cart_model->gets($strWhere);
            if (!$cartList) {
                printAjaxError('fail', '请选择结算商品');
            }
            foreach ($cartList as $value) {
            	if ($value['color_size_open']) {
            		//有规格的商品
            		$product_stock_info = $this->Product_model->getProductStock($value['product_id'], $value['color_id'], $value['size_id']);
            		if (!$product_stock_info) {
            			printAjaxError('fail', '没有此规格的商品，请删除');
            		}
            		if ($value['buy_number'] > $product_stock_info['stock']) {
            			printAjaxError('fail', "商品：{$value['title']}，{$value['product_size_name']}：{$value['size_name']}，{$value['product_color_name']}：{$value['size_name']}库存不足，请手动删除或购买数量调整为{$product_stock_info['stock']}");
            		}
            	} else {
            		if ($value['buy_number'] > $value['stock']) {
            			printAjaxError('fail', "商品:{$value['title']}。库存不足，请手动删除或购买数量调整为{$value['stock']}");
            		}
            	}
            	//一级
            	if ($user_info_1) {
            		//商家
                    if ($user_info_1['user_type'] == 1) {
                    	//银象积分-A类商品
                    	if ($value['product_type'] == 'a') {
                    		$divide_user_score_silver_1 += $value['divide_seller_score'] * $value['buy_number'];
                    	}
                    	//金象积分-B、C类商品
                    	else {
                    		$divide_user_score_gold_1 += $value['divide_seller_score'] * $value['buy_number'];
                    	}
                    }
                    //会员
                    else {
                    	//银象积分-A类商品
                    	if ($value['product_type'] == 'a') {
                    		$divide_user_score_silver_1 += $value['divide_user_score'] * $value['buy_number'];
                    	}
                    	//金象积分-B、C类商品
                    	else {
                    		$divide_user_score_gold_1 += $value['divide_user_score'] * $value['buy_number'];
                    	}
                    }
            	}
            	//二级
            	if ($user_info_2) {
            		//商家
            		if ($user_info_1['user_type'] == 1) {
            			//银象积分-A类商品
            			if ($value['product_type'] == 'a') {
            				$divide_user_score_silver_2 += $value['divide_seller_score_sub'] * $value['buy_number'];
            			}
            			//金象积分-B、C类商品
            			else {
            				$divide_user_score_gold_2 += $value['divide_seller_score_sub'] * $value['buy_number'];
            			}
            		}
            		//会员
            		else {
            			//银象积分-A类商品
            			if ($value['product_type'] == 'a') {
            				$divide_user_score_silver_2 += $value['divide_user_score_sub'] * $value['buy_number'];
            			}
            			//金象积分-B、C类商品
            			else {
            				$divide_user_score_gold_2 += $value['divide_user_score_sub'] * $value['buy_number'];
            			}
            		}
            	}
            	//银象积分-A类商品
            	if ($value['product_type'] == 'a') {
            		$silver_give_score += $value['give_score'] * $value['buy_number'];
            	}
            	//金象积分-B、C类商品
            	else {
            		$gold_give_score += $value['give_score'] * $value['buy_number'];
            	}
            	$postage_way_ids .= $value['postage_way_id'].',';
            	$product_number += $value['buy_number'];
        		$product_total += $value['sell_price'] * $value['buy_number'];
        		//金象积分-A类商品-需付多少金象积分
        		if ($value['product_type'] == 'a') {
        			$use_deductible_score_gold += $value['consume_score'] * $value['buy_number'];
        		}
        		//银象积分-B、C类商品-需付多少银象积分
        		else {
        			$use_deductible_score_silver += $value['consume_score'] * $value['buy_number'];
        		}
            }
            if ($postage_way_ids) {
            	$postage_way_ids = substr($postage_way_ids, 0, -1);
            }
            //积分换购
            if ($use_score) {
            	//用现金购买才送积分，积分换购不送积分
            	$silver_give_score = 0;
            	$gold_give_score = 0;
            	$product_total = 0;
            	//A,B,C类商品
            	if ($use_deductible_score_gold > 0 && $use_deductible_score_silver > 0) {
            		if ($use_deductible_score_gold > $user_info['score_gold']) {
            			printAjaxError('fail', '金象积分不足，换购失败');
            		}
            		if ($use_deductible_score_silver > $user_info['score_gold'] - $use_deductible_score_gold + $user_info['score_silver']) {
            			printAjaxError('fail', '总积分不足，换购失败');
            		}
            		if ($user_info['score_gold'] >= $use_deductible_score_gold) {
            			$deductible_score_gold = $use_deductible_score_gold;
            		}
            		if ($user_info['score_silver'] >= $use_deductible_score_silver) {
            			$deductible_score_silver = $use_deductible_score_silver;
            		} else {
            			$deductible_score_silver = $user_info['score_silver'];
            			$deductible_score_gold = $deductible_score_gold + $use_deductible_score_silver - $user_info['score_silver'];
            		}
            	}
            	//B,C类商品
            	else if ($use_deductible_score_gold > 0 && $use_deductible_score_silver == 0) {
                    if ($use_deductible_score_gold > $user_info['score_gold']) {
                    	printAjaxError('fail', '金象积分不足，换购失败');
                    }
                    $deductible_score_gold = $use_deductible_score_gold;
                    $deductible_score_silver = 0;
            	}
            	//A类商品
            	else if ($use_deductible_score_gold == 0 && $use_deductible_score_silver > 0) {
            		if ($use_deductible_score_silver > $user_info['score_gold'] + $user_info['score_silver']) {
            			printAjaxError('fail', '总积分不足，换购失败');
            		}
            		if ($use_deductible_score_silver > $user_info['score_silver']) {
            			$deductible_score_gold = $use_deductible_score_silver - $user_info['score_silver'];
            			$deductible_score_silver = $user_info['score_silver'];
            		} else {
            			$deductible_score_gold = 0;
            			$deductible_score_silver = $use_deductible_score_silver;
            		}
            	}
            }
            //现金购买
            else {
            	$use_deductible_score_gold = 0;
            	$use_deductible_score_silver = 0;
            	$deductible_score_gold = 0;
            	$deductible_score_silver = 0;
            }
            $area_info = $this->Area_model->get('name', array('id' => $user_address_info['province_id']));
            if ($area_info) {
            	$area_name = $area_info['name'];
            }
            $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
            if ($free_postage_setting['is_free'] == 1) {
            	$pay_way_str = '全国包邮';
            	$postage_template_id = 0;
            	$postage_price = '0.00';
            } else {
            	if (($product_number >= $free_postage_setting['product_number'] && $free_postage_setting['open_number'] == 1) || ($product_total >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price'] == 1)) {
            		$postage_template_id = 0;
            		$postage_price = '0.00';
            		$pay_way_str = '包邮（已满'.$free_postage_setting['product_number'].'件或已满'.$free_postage_setting['free_postage_price'].'元）';
            	} else {
            		//判断用哪个快递－谁贵给谁的
            		$postage_way_list = $this->Postage_way_model->gets('*', "id in ({$postage_way_ids})");
            		if ($postage_way_list) {
            			foreach ($postage_way_list as $key=>$value) {
            				$tmp_postage_price = $this->advdbclass->get_postage_price($value['id'], $area_name, $product_number);
            				if ($tmp_postage_price > $postage_price) {
            					$postage_price = $tmp_postage_price;
            					$postage_template_id = $value['id'];
            					$pay_way_str = $value['title'];
            				}
            			}
            		}
            	}
            }
            $total = $postage_price + $product_total;
            $orderNumber = $this->advdbclass->get_unique_orders_number();
            //添加订单信息
            $fields = array(
                'user_id' => $user_id,
                'order_number' => $orderNumber,
                'payment_id' => 0,
                'payment_title' => '',
                'payment_price' => 0,
                'postage_id' => $postage_template_id,
                'postage_title' => $pay_way_str,
                'postage_price' => $postage_price,
            	'discount_total'=>0,
            	'product_total'=>$product_total,
            	'total' => $total,
            	'pay_mode'=>$pay_mode,
            	'deductible_score'=>$use_deductible_score_gold+$use_deductible_score_silver,
            	'use_deductible_score_gold'=>$use_deductible_score_gold,
            	'use_deductible_score_silver'=>$use_deductible_score_silver,
            	'deductible_score_gold'=>$deductible_score_gold,
            	'deductible_score_silver'=>$deductible_score_silver,
                'status' => $total > 0?0:1,
                'add_time' => time(),
                'buyer_name' =>  $user_address_info['buyer_name'],
                'province_id' => $user_address_info['province_id'],
                'city_id' =>     $user_address_info['city_id'],
                'area_id' =>     $user_address_info['area_id'],
                'txt_address' => $user_address_info['txt_address'],
                'address' =>     $user_address_info['address'],
                'zip' =>         $user_address_info['zip'],
                'phone' =>       $user_address_info['phone'],
                'mobile' =>      $user_address_info['mobile'],
                'delivery_time' => $deliveryTime,
                'remark' =>      $remark,
                'gold_score' =>   $gold_give_score,
            	'silver_score' => $silver_give_score,
                'order_type' => 0,
                'expires' => 24 * 60 * 60,
            	'divide_user_id_1'=>$divide_user_id_1,
            	'divide_user_id_2'=>$divide_user_id_2,
            	'divide_user_score_gold_1'=>$divide_user_score_gold_1,
            	'divide_user_score_silver_1'=>$divide_user_score_silver_1,
            	'divide_user_score_gold_2'=>$divide_user_score_gold_2,
            	'divide_user_score_silver_2'=>$divide_user_score_silver_2
            );
            //添加订单
            $ret = $this->Orders_model->save($fields);
            if ($ret) {
                /***************************添加订单详细信息*********************** */
                $succesCount = 0;
                if ($cartList) {
                    foreach ($cartList as $cart) {
                        $detailFields = array(
                            'order_id' => $ret,
                            'product_id' => $cart['product_id'],
                            'product_num' => $cart['product_num'],
                            'product_title' => $cart['title'],
                            'buy_number' => $cart['buy_number'],
                            'buy_price' => $cart['sell_price'],
                        	'old_price' => $cart['sell_price'],
                            'size_name' => $cart['size_name'],
                            'size_id' => $cart['size_id'],
                            'color_name' => $cart['color_name'],
                            'color_id' => $cart['color_id'],
                            'path' => $cart['path'],
                        	'product_type' => $cart['product_type'],
                        	'consume_score' => $cart['consume_score'],
                        	'divide_user_score' => $cart['divide_user_score'],
                        	'divide_user_score_sub' => $cart['divide_user_score_sub'],
                        	'divide_seller_score' => $cart['divide_seller_score'],
                        	'divide_seller_score_sub' => $cart['divide_seller_score_sub'],
                        	'color_size_open' => $cart['color_size_open'],
                        	'product_color_name' => $cart['product_color_name'],
                        	'product_size_name' => $cart['product_size_name']
                        );
                        if ($this->Orders_detail_model->save($detailFields)) {
                            $succesCount++;
                        }
                    }
                }
                if (($succesCount != count($cartList)) || count($cartList) == 0) {
                    //删除订单详细里的数据
                    $this->Orders_detail_model->delete(array('order_id' => $ret));
                    //删除已经添加进去的数据，保持数据统一性
                    $this->Orders_model->delete(array('id' => $ret, 'user_id' => $user_id));
                    printAjaxError('fail', '订单提交失败');
                } else {
                    //删除购物车数据
                    $this->Cart_model->delete($strWhere);
                    //订单跟踪记录
                    $msg = $total > 0?'':'-完成支付';
                    $ordersprocessFields = array(
                        'add_time' => time(),
                        'content' => "订单创建成功".$msg,
                        'order_id' => $ret,
                    	'current_status'=>$total > 0?'0':'1',
                    	'change_status'=>$total > 0?'0':'1'
                    );
                    $this->Orders_process_model->save($ordersprocessFields);
                    //积分换购
                    if ($use_score) {
                    	if ($deductible_score_gold > 0) {
                    		if (!$this->Score_model->rowCount(array('score_type'=>'gold', 'user_id' => $user_info['id'], 'ret_id' => $ret, 'type' => 'orders_buy_out'))) {
                    			$balance = $user_info['score_gold'] - $deductible_score_gold;
                    			if ($this->User_model->save(array('score_gold'=>$balance), array('id' => $user_info['id']))) {
                    				$sFields = array(
                    						'score_type'=>'gold',
                    						'cause' => "积分换购-[订单号：{$orderNumber}]",
                    						'score' => -$deductible_score_gold,
                    						'balance' => $balance,
                    						'type' => 'orders_buy_out',
                    						'add_time' => time(),
                    						'username' => $user_info['username'],
                    						'user_id' => $user_info['id'],
                    						'ret_id' => $ret
                    				);
                    				$this->Score_model->save($sFields);
                    			}
                    		}
                    	}
                    	if ($deductible_score_silver > 0) {
                    		if (!$this->Score_model->rowCount(array('score_type'=>'silver', 'user_id' => $user_info['id'], 'ret_id' => $ret, 'type' => 'orders_buy_out'))) {
                    			$balance = $user_info['score_silver'] - $deductible_score_silver;
                    			if ($this->User_model->save(array('score_silver'=>$balance), array('id' => $user_info['id']))) {
                    				$sFields = array(
                    						'score_type'=>'silver',
                    						'cause' => "积分换购-[订单号：{$orderNumber}]",
                    						'score' => -$deductible_score_silver,
                    						'balance' => $balance,
                    						'type' => 'orders_buy_out',
                    						'add_time' => time(),
                    						'username' => $user_info['username'],
                    						'user_id' => $user_info['id'],
                    						'ret_id' => $ret
                    				);
                    				$this->Score_model->save($sFields);
                    			}
                    		}
                    	}
                    }
                    //下单减库存
                    if ($systemInfo['stock_reduce_type'] == 0) {
			            $orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id'=>$ret));
			            if ($orders_detail_list) {
			            	foreach ($orders_detail_list as $item) {
			            		if ($item['color_size_open'] == 1) {
			            			$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
			            			if ($product_stock_info) {
			            				$stock = $product_stock_info['stock'] - $item['buy_number'];
			            				$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
			            			}
			            		} else {
			            			$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
			            			if ($product_info) {
			            				$stock = $product_info['stock'] - $item['buy_number'];
			            				$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
			            			}
			            		}
			            	}
			            }
                    }
                    if ($total > 0) {
                    	if($user_info['push_cid']){
                    		$this->_send_push($user_info['push_cid'],"订单{$orderNumber}未付款哦~~,亲赶紧去支付吧！");
                    	}
                    	//发消息
                    	$fields = array(
                    			'message_type' => 'order',
                    			'to_user_id' => $user_id,
                    			'from_user_id' => 0,
                    			'content' => "订单{$orderNumber}未付款哦~~,亲赶紧去支付吧！",
                    			'map_id'=>$ret,
                    			'add_time' => time()
                    	);
                    	$this->Message_model->save($fields);

                    	$data = array(
                    			'status'=>0,
                    			'order_number'=>$orderNumber,
                    			'order_id'=>$ret,
                    			'total'=>$total,
                    			'pay_mode'=>$pay_mode,
                    			'deductible_score'=>$use_deductible_score_gold+$use_deductible_score_silver
                    	);
                    	printAjaxData($data);
                    } else {
                    	//付款减库存
                    	if ($systemInfo['stock_reduce_type'] == 1) {
	                    	$orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id'=>$ret));
				            if ($orders_detail_list) {
				            	foreach ($orders_detail_list as $item) {
				            		if ($item['color_size_open'] == 1) {
				            			$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
				            			if ($product_stock_info) {
				            				$stock = $product_stock_info['stock'] - $item['buy_number'];
				            				$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
				            			}
				            		} else {
				            			$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
				            			if ($product_info) {
				            				$stock = $product_info['stock'] - $item['buy_number'];
				            				$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
				            			}
				            		}
				            	}
				            }
                        }
                    	$data = array(
                    			'status'=>1,
                    			'order_number'=>$orderNumber,
                    			'order_id'=>$ret,
                    			'total'=>$total,
                    			'pay_mode'=>$pay_mode,
                    			'deductible_score'=>$use_deductible_score_gold+$use_deductible_score_silver,
                    	);
                    	printAjaxData($data);
                    }
                }
            } else {
                printAjaxError('fail', '订单提交失败');
            }
        }
    }

    public function order_xcx_wx_pay($order_id = NULL)
    {
        $code = $this->input->post("code", true);

        if (!$code) {
            printAjaxError('fail', 'DO NOT ACCESS!');
        }
        $appid = 'wxecb819ec75f945af';
        $appSecret = '7496d4114eb0a4a016544e8a58ca7e51';
        $json = file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appSecret}&js_code={$code}&grant_type=authorization_code");
        $obj = json_decode($json);
        if (isset($obj->errmsg)) {
            printAjaxError('fail', 'invalid code!');
        }
        $openid = $obj->openid;
        $user_id = $this->_check_login();

        if (!$order_id) {
            printAjaxError('fail','操作异常');
        }

        //判断下单用户是否存在
        $user_info = $this->User_model->get('*', array('user.id' => $user_id));
        if (!$user_info) {
            printAjaxError('fail','用户信息不存在，结算失败');
        }
        $item_info = $this->Orders_model->get('*', "id = {$order_id} and user_id = {$user_id} and status = 0");
        if (!$item_info) {
            printAjaxError('fail','此订单信息不存在');
        }

        /********************微信支付**********************/
        require_once "sdk/weixin_pay/lib/WxPay.Api.php";
        require_once "sdk/weixin_pay/WxPay.JsApiPay.php";

        $product_id = 'O' . $item_info['order_number'];
        $out_trade_no = $item_info['out_trade_no'];
        if (!$out_trade_no) {
            $out_trade_no = 'O' . $this->advdbclass->get_unique_orders_number('out_trade_no');
            $this->Orders_model->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));
        }
        $tools = new JsApiPay();
        $input = new WxPayUnifiedOrder();
        $input->SetAppid($appid);
        $input->SetOpenid($openid);
        $input->SetBody("博和小程序付款");
        $input->SetAttach("{$item_info['order_number']}");
        $input->SetTotal_fee($item_info['total'] * 100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url(base_url() . "index.php/napi/order_xcx_wx_pay_notify");
        $input->SetTrade_type("JSAPI");
        $input->SetProduct_id($product_id);
        $input->SetOut_trade_no($out_trade_no);
        $result = WxPayApi::unifiedOrder($input,6,1);
        $jsApiParameters = array();
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $jsApiParameters = $tools->GetJsApiParameters($result);
            //生成支付记录
            if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'))) {
                $fields = array(
                    'user_id' => $user_id,
                    'total_fee' => $item_info['total'],
                    'total_fee_give' => 0,
                    'out_trade_no' => $out_trade_no,
                    'order_num' => $item_info['order_number'],
                    'trade_status' => 'WAIT_BUYER_PAY',
                    'add_time' => time(),
                    'payment_type' => 'weixin',
                    'order_type' => 'orders',
                );
                $this->Pay_log_model->save($fields);
            }


        } else {
            if (array_key_exists('result_code', $result) && $result['result_code'] == "FAIL") {
                //商户号重复时，要重新生成
                if ($result['err_code'] == 'OUT_TRADE_NO_USED' || $result['err_code'] == 'INVALID_REQUEST') {
                    $out_trade_no = 'O' . $this->advdbclass->get_unique_orders_number('out_trade_no');
                    $this->Orders_model->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));

                    $input = new WxPayUnifiedOrder();
                    $input->SetAppid($appid);
                    $input->SetOpenid($openid);
                    $input->SetBody("博和小程序付款");
                    $input->SetAttach("{$item_info['order_number']}");
                    $input->SetTotal_fee($item_info['total'] * 100);
                    $input->SetTime_start(date("YmdHis"));
                    $input->SetTime_expire(date("YmdHis", time() + 600));
                    $input->SetNotify_url(base_url() . "index.php/napi/order_xcx_wx_pay_notify");
                    $input->SetTrade_type("JSAPI");
                    $input->SetProduct_id($product_id);
                    $input->SetOut_trade_no($out_trade_no);
                    $result = WxPayApi::unifiedOrder($input,6,1);
                    if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
                        $jsApiParameters = $tools->GetJsApiParameters($result);
                        //生成支付记录
                        if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'))) {
                            $fields = array(
                                'user_id' => $user_id,
                                'total_fee' => $item_info['total'],
                                'total_fee_give' => 0,
                                'out_trade_no' => $out_trade_no,
                                'order_num' => $item_info['order_number'],
                                'trade_status' => 'WAIT_BUYER_PAY',
                                'add_time' => time(),
                                'payment_type' => 'weixin',
                                'order_type' => 'orders',
                            );
                            $this->Pay_log_model->save($fields);
                        }
                    } else {
                        printAjaxError('fail', $result['err_code']);
                    }
                } else {
                    printAjaxError('fail', $result['err_code']);
                }
            } else {
                printAjaxError('fail', '交易失败，请重试');
            }
        }
        $jsApiParameters = json_decode($jsApiParameters, true);
        printAjaxData($jsApiParameters);

    }

    //微信支付异步通知
    public function order_xcx_wx_pay_notify(){
        /********************微信支付**********************/
        require_once "sdk/weixin_pay/lib/WxPay.Api.php";
        $msg = '支付通知失败';
        $appid = 'wx41f5cf7ca77cb1a6';
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        try {
            $data = WxPayResults::Init($xml);
            if (array_key_exists("transaction_id", $data)) {
                $input = new WxPayOrderQuery();
                $input->SetTransaction_id($data["transaction_id"]);
                $input->SetAppid($appid);
                $result = WxPayApi::orderQuery($input,6,1);
                if (array_key_exists("return_code", $result)
                    && array_key_exists("result_code", $result)
                    && $result["return_code"] == "SUCCESS"
                    && $result["result_code"] == "SUCCESS"
                ) {
                    //订单号
                    $order_num = $result['attach'];
                    //商户订单号
                    $out_trade_no = $result['out_trade_no'];
                    //微信交易号
                    $trade_no = $result['transaction_id'];
                    //通知时间
                    $notify_time = $result['time_end'];
                    $total_fee = $result['total_fee'];

                    $pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'orders', 'payment_type' => 'weixin'));
                    if ($pay_log_info && $total_fee == $pay_log_info['total_fee'] * 100) {
                        if ($pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
                            //支付记录
                            $fields = array(
                                'payment_type' => 'weixin',
                                'order_type' => 'orders',
                                'trade_no' => $trade_no,
                                'trade_status' => 'TRADE_SUCCESS',
                                'buyer_email' => '',
                                'notify_time' => strtotime($notify_time)
                            );
                            if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
                                $item_info = $this->Orders_model->get('*', array('order_number' => $order_num, 'status' => 0));
                                $user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
                                if ($item_info && $user_info) {
                                    //修改订单状态
                                    $fields = array(
                                        'status' => 1,
                                        'payment_price' => 0,//费率
                                        'payment_title' => '微信支付',
                                        'payment_id' => 3);
                                    if ($this->Orders_model->save($fields, array('id' => $item_info['id']))) {
                                        //订单追踪记录
                                        $fields = array(
                                            'add_time' => time(),
                                            'content' => "订单付款成功[微信小程序支付]",
                                            'order_id' => $item_info['id'],
                                            'order_status' => $item_info['status'],
                                            'change_status' => 1
                                        );
                                        $this->Orders_process_model->save($fields);
                                        //财务记录
                                        if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
                                            $fields = array(
                                                'cause' => "小程序支付成功-[订单号：{$item_info['order_number']}]",
                                                'price' => -$item_info['total'],
                                                'balance' => $user_info['total'],
                                                'add_time' => time(),
                                                'user_id' => $user_info['id'],
                                                'username' => $user_info['username'],
                                                'type' => 'order_out',
                                                'pay_way' => '3',
                                                'ret_id' => $item_info['id'],
                                                'from_user_id' => $user_info['id'],
                                                'seller_id'=>    $item_info['seller_id'],
                                                'store_id'=>    $item_info['store_id'],
                                            );
                                            $this->Financial_model->save($fields);
                                        }
                                        echo $this->returnInfo("SUCCESS", "OK");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (WxPayException $e) {
            $msg = $e->errorMessage();

        }
        echo $this->returnInfo("FAIL", $msg);
    }

    /**
     * 余额支付-普通订单
     */
    public function order_yue_pay() {
    	//判断是否登录
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$order_id = $this->input->post('order_id', TRUE);
    		$pay_password = $this->input->post('pay_password', TRUE);

    		if (!$order_id) {
    			printAjaxError('fail', '支付异常，刷新重试');
    		}
    		if (!$pay_password) {
    			printAjaxError('fail', '支付密码不能为空');
    		}
    		//判断下单用户是否存在
    		$user_info = $this->User_model->get('*', array('id' => $user_id));
    		if (!$user_info) {
    			printAjaxError('fail', '此用户不存在，结算失败');
    		}
    		$item_info = $this->Orders_model->get('*', array('id'=>$order_id, 'user_id'=>$user_id, 'status'=>0));
    		if (!$item_info) {
    			printAjaxError('fail', '此订单信息不存在');
    		}
            if ($item_info['add_time'] + $item_info['expires'] < time()) {
                printAjaxError('fail', '此订单已过期，不能支付');
            }
    		//预存款支付
    		if ($item_info['total'] > $user_info['total']) {
    			printAjaxError('fail', '预存款余额不足，请选择其它支付方式');
    		}
    		if ($this->User_model->getPasswordSalt($user_info['username'], $pay_password) != $user_info['pay_password']) {
    			printAjaxError('fail', '支付密码错误，请重新输入');
    		}

    		//修改订单状态
    		$fields = array(
    				'status' => 1,
    				'payment_price' => 0,//费率
    				'payment_title' => '预存款支付',
    				'payment_id' => 1);
    		if (!$this->Orders_model->save($fields, array('id' => $item_info['id'], 'user_id' => $user_info['id']))) {
    			printAjaxError('fail', '预存款支付失败');
    		}
    		//追踪记录
    		$fields = array(
    				'add_time' => time(),
    				'content' => "订单付款成功--[订单号：{$item_info['order_number']}]",
    				'order_id' => $item_info['id'],
    				'current_status' => $item_info['status'],
    				'change_status' => 1
    		);
    		$orders_process_id = $this->Orders_process_model->save($fields);
    		if (!$orders_process_id) {
    			//支付失败，恢复订单状态
    			$fields = array(
    					'status' => 0,
    					'payment_price' => 0,//费率
    					'payment_title' => '',
    					'payment_id' => 0);
    			$this->Orders_model->save($fields, array('id' => $item_info['id'], 'user_id' => $user_info['id']));
    			printAjaxError('fail', '预存款支付失败');
    		}
    		//进行扣款
    		if (!$this->User_model->save(array('total' => $user_info['total'] - $item_info['total']), array('id' => $user_id))) {
    			$fields = array(
    					'status' => 0,
    					'payment_price' => 0,//费率
    					'payment_title' => '',
    					'payment_id' => 0);
    			$this->Orders_model->save($fields, array('id' => $item_info['id'], 'user_id' => $user_info['id']));
    			$this->Orders_process_model->delete(array('id' => $orders_process_id));
    			printAjaxError('fail', '预存款支付失败');
    		}
    		//财务记录
    		$fields = array(
    				'cause' => "订单付款成功--[订单号：{$item_info['order_number']}]",
    				'price' => -$item_info['total'],
    				'balance' => $user_info['total'] - $item_info['total'],
    				'add_time' => time(),
    				'user_id' => $user_info['id'],
    				'username' => $user_info['username'],
    				'type' => 'order_out',
    				'pay_way' => 1,
    				'ret_id' => $item_info['id'],
    				'from_user_id' => $user_info['id']
    		);
    		$this->Financial_model->save($fields);
    		//付款减库存
    		$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
            if ($systemInfo['stock_reduce_type'] == 1) {
            	$orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
	    		if ($orders_detail_list) {
	    			foreach ($orders_detail_list as $item) {
	    				if ($item['color_size_open'] == 1) {
	    					$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
	    					if ($product_stock_info) {
	    						$stock = $product_stock_info['stock'] - $item['buy_number'];
	    						$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
	    					}
	    				} else {
	    					$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
	    					if ($product_info) {
	    						$stock = $product_info['stock'] - $item['buy_number'];
	    						$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
	    					}
	    				}
	    			}
	    		}
            }
    		printAjaxData(array('id'=>$item_info['id'], 'total'=>$item_info['total'], 'order_number'=>$item_info['order_number']));
    	}
    }

    /**
     * app支付-普通订单
     *
     * @param $order_id 订单ID
     * @param $pay_type alipay=支付宝支付；wxpay=微信支付；
     *
     * @return json
     */
    public function order_app_pay($order_id = NULL, $pay_type = NULL) {
    	//判断是否登录
    	$user_id = $this->_check_login();
    	if (!$order_id || !$pay_type) {
    		printAjaxError('fail', '操作异常');
    	}
    	$orders_info = $this->Orders_model->get('*', "id = {$order_id} and user_id = {$user_id} and status = 0");
    	if (!$orders_info) {
    		printAjaxError('fail', '此订单信息不存在');
    	}
    	if ($pay_type == 'alipay') {
    		$this->_order_alipay_pay($orders_info);
    	} else if ($pay_type == 'wxpay') {
    		$this->_order_weixin_pay($orders_info);
    	} else {
    		printAjaxError('fail', '不支持此支付通道');
    	}
    }

    /**
     * js支付-普通订单
     *
     * @param $order_id 订单ID
     * @param $pay_type alipay=支付宝支付；wxpay=微信支付；
     * @param $open_id 微信支付open_id；
     *
     * @return json
     */
    public function order_app_pay_js($order_id = NULL, $pay_type = NULL, $open_id = NULL) {
    	//判断是否登录
    	$user_id = $this->_check_login();
    	if (!$order_id || !$pay_type) {
    		printAjaxError('fail', '操作异常');
    	}
    	$orders_info = $this->Orders_model->get('*', "id = {$order_id} and user_id = {$user_id} and status = 0");
    	if (!$orders_info) {
    		printAjaxError('fail', '此订单信息不存在');
    	}
    	if ($pay_type == 'alipay') {
    		$this->_order_alipay_pay_js($orders_info);
    	} else if ($pay_type == 'wxpay') {
    		if (!$open_id) {
    			printAjaxError('fail', 'open_id不能为空，支付失败');
    		}
    		$this->_order_weixin_pay_js($orders_info, $open_id);
    	} else {
    		printAjaxError('fail', '不支持此支付通道');
    	}
    }

    public function get_order_openid($order_id = NULL, $total = NULL, $prv_id = NULL, $order_number = NULL, $pay_mode = NULL, $deductible_score = NULL, $sid = NULL) {
    	require_once "sdk/weixin_pay/lib/WxPay.Api.php";
    	require_once "sdk/weixin_pay/WxPay.JsApiPay.php";

    	$tools = new JsApiPay();
    	$open_id = $tools->GetOpenid();
    	if ($open_id) {
    		$url = base_url()."wx/cart_pay.html?open_id={$open_id}&order_id={$order_id}&total={$total}&prv_id={$prv_id}&order_number={$order_number}&pay_mode={$pay_mode}&deductible_score={$deductible_score}&sid={$sid}";
    		redirect($url);
    	}
    }

    //支付宝App支付-普通订单
	private function _order_alipay_pay($orders_info = NULL) {
		$out_trade_no = $orders_info['order_number'];
    	$total_fee = $orders_info['total'];
    	//生成支付记录
    	if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'alipay', 'order_type' => 'orders'))) {
    		$this->Orders_model->save(array('order_number' => $out_trade_no), array('id' => $orders_info['id']));
    		$fields = array(
    				'user_id' => $orders_info['user_id'],
    				'total_fee' => $orders_info['total'],
    				'total_fee_give' => 0,
    				'out_trade_no' => $out_trade_no,
    				'order_num' => $orders_info['order_number'],
    				'trade_status' => 'WAIT_BUYER_PAY',
    				'add_time' => time(),
    				'payment_type' => 'alipay',
    				'order_type' => 'orders'
    		);
    		if (!$this->Pay_log_model->save($fields)) {
    			printAjaxError('fail', '支付失败，请重试');
    		}
    	}
		require_once("sdk/alipay/aop/AopClient.php");
		require_once("sdk/alipay/aop/AlipayTradeAppPayRequest.php");
		require_once 'sdk/alipay/aop/SignData.php';

		$aop = new AopClient();
		$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
		$aop->appId = $this->_app_id;
		$aop->rsaPrivateKey = $this->_rsaPrivateKey;
		$aop->alipayrsaPublicKey=$this->_alipayrsaPublicKey;

		$aop->apiVersion = '1.0';
		$aop->signType = 'RSA2';
		$aop->postCharset='UTF-8';
		$aop->format='json';

		$request = new AlipayTradeAppPayRequest ();
		$request->setNotifyUrl(base_url()."index.php/napi/order_alipay_notify");
		$param = array(
				'body' =>         '携众易购付款',
				'subject' =>      '携众易购即时到账支付',
				'out_trade_no' => $out_trade_no,
				'product_code'=> 'QUICK_MSECURITY_PAY',
				'total_amount' =>$total_fee
		);
		$request->setBizContent(json_encode($param));
		$response = $aop->sdkExecute($request);
		echo $response;
		exit;
	}

	//支付宝js支付-优选订单
	private function _order_alipay_pay_js($orders_info = NULL) {
		$out_trade_no = $orders_info['order_number'];
    	$total_fee = $orders_info['total'];
	    //生成支付记录
    	if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'alipay', 'order_type' => 'orders'))) {
    		$this->Orders_model->save(array('order_number' => $out_trade_no), array('id' => $orders_info['id']));
    		$fields = array(
    				'user_id' => $orders_info['user_id'],
    				'total_fee' => $orders_info['total'],
    				'total_fee_give' => 0,
    				'out_trade_no' => $out_trade_no,
    				'order_num' => $orders_info['order_number'],
    				'trade_status' => 'WAIT_BUYER_PAY',
    				'add_time' => time(),
    				'payment_type' => 'alipay',
    				'order_type' => 'orders'
    		);
    		if (!$this->Pay_log_model->save($fields)) {
    			printAjaxError('fail', '支付失败，请重试');
    		}
    	}
		/********************支付***********************/
		require_once("sdk/alipay/alipay_h5.config.php");
		require_once("sdk/alipay/lib/alipay_submit.class.php");

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service"       => $alipay_config['service'],
				"partner"       => $alipay_config['partner'],
				"seller_id"  => $alipay_config['seller_id'],
				"payment_type"	=> $alipay_config['payment_type'],
				"notify_url"	=> base_url().'index.php/napi/order_alipay_notify_js',
				"return_url"	=> base_url().'index.php/napi/order_alipay_return_js',

				"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> '携众易购付款',
				"total_fee"	=> $total_fee,
				"show_url"	=> '',
				"app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝
				"body"	=> '携众易购即时到账支付'
		);
		$alipay_config['notify_url'] = $parameter['notify_url'];
		$alipay_config['return_url'] = $parameter['return_url'];
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		printAjaxData(array('request_form' => $html_text));
	}

	//微信App支付-普通订单
	private function _order_weixin_pay($item_info = NULL) {
		$product_id = 'O' . $item_info['order_number'];
		$out_trade_no = $item_info['out_trade_no'];
		if (!$out_trade_no) {
			$out_trade_no = 'O' . $this->advdbclass->get_unique_orders_number('out_trade_no');
			$this->Orders_model->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));
		}
		require_once "sdk/wxpayv3/WxPay.Api.php";
		require_once "sdk/wxpayv3/WxPay.Data.php";

		$unifiedOrder = new WxPayUnifiedOrder();
		$unifiedOrder->SetAttach($item_info['order_number']);
		$unifiedOrder->SetBody('携众易购付款'); //商品或支付单简要描述
		$unifiedOrder->SetProduct_id($product_id);
		$unifiedOrder->SetOut_trade_no($out_trade_no);
		$unifiedOrder->SetNotify_url(base_url() . 'index.php/napi/order_wxpay_pay_notify');
		$unifiedOrder->SetTotal_fee($item_info['total']*100);
		$unifiedOrder->SetTrade_type("APP");
		$result = WxPayApi::unifiedOrder($unifiedOrder, 60);
		if (is_array($result)) {
			//生成支付记录
			if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'))) {
				$fields = array(
						'user_id' => $item_info['user_id'],
						'total_fee' => $item_info['total'],
						'total_fee_give' => 0,
						'out_trade_no' => $out_trade_no,
						'order_num' => $item_info['order_number'],
						'trade_status' => 'WAIT_BUYER_PAY',
						'add_time' => time(),
						'payment_type' => 'weixin',
						'order_type' => 'orders'
				);
				$this->Pay_log_model->save($fields);
			}
			echo json_encode($result);
			exit;
		} else {
			$out_trade_no = 'O' . $this->advdbclass->get_unique_orders_number('out_trade_no');
    		$this->Orders_model->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));

			$unifiedOrder = new WxPayUnifiedOrder();
			$unifiedOrder->SetAttach($item_info['order_number']);
			$unifiedOrder->SetBody('携众易购付款'); //商品或支付单简要描述
			$unifiedOrder->SetProduct_id($product_id);
			$unifiedOrder->SetOut_trade_no($out_trade_no);
			$unifiedOrder->SetNotify_url(base_url() . 'index.php/napi/order_wxpay_pay_notify');
			$unifiedOrder->SetTotal_fee($item_info['total']*100);
			$unifiedOrder->SetTrade_type("APP");
			$result = WxPayApi::unifiedOrder($unifiedOrder, 60);
			if (is_array($result)) {
				//生成支付记录
				if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'))) {
					$fields = array(
							'user_id' => $item_info['user_id'],
							'total_fee' => $item_info['total'],
							'total_fee_give' => 0,
							'out_trade_no' => $out_trade_no,
							'order_num' => $item_info['order_number'],
							'trade_status' => 'WAIT_BUYER_PAY',
							'add_time' => time(),
							'payment_type' => 'weixin',
							'order_type' => 'orders'
					);
					$this->Pay_log_model->save($fields);
				}
				echo json_encode($result);
				exit;
			} else {
				printAjaxError('fail', '付款失败，请重试');
			}
		}
	}

	//微信js支付-优选订单
	private function _order_weixin_pay_js($item_info = NULL, $open_id = NULL) {
	    $product_id = 'O' . $item_info['order_number'];
    	$out_trade_no = $item_info['out_trade_no'];
    	if (!$out_trade_no) {
    		$out_trade_no = 'O' . $this->advdbclass->get_unique_orders_number('out_trade_no');
    		$this->Orders_model->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));
    	}

		require_once "sdk/weixin_pay/lib/WxPay.Api.php";
		require_once "sdk/weixin_pay/WxPay.JsApiPay.php";

		$app_id = 'wx68a6f3973a815d05';
		//①、获取用户openid
		$tools = new JsApiPay();
		//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody("携众易购付款");
		$input->SetAttach($item_info['order_number']);
		$input->SetTotal_fee($item_info['total']*100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetNotify_url(base_url()."index.php/napi/order_wxpay_pay_notify_js");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($open_id);
		$input->SetAppid($app_id);
		$input->SetProduct_id($product_id);
		$input->SetOut_trade_no($out_trade_no);
		$result = WxPayApi::unifiedOrder($input);
		$jsApiParameters = "{}";
		if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
			$jsApiParameters = $tools->GetJsApiParameters($result);
			//生成支付记录
			if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'))) {
				$fields = array(
						'user_id' => $item_info['user_id'],
						'total_fee' => $item_info['total'],
						'total_fee_give' => 0,
						'out_trade_no' => $out_trade_no,
						'order_num' => $item_info['order_number'],
						'trade_status' => 'WAIT_BUYER_PAY',
						'add_time' => time(),
						'payment_type' => 'weixin',
						'order_type' => 'orders'
				);
				$this->Pay_log_model->save($fields);
			}
		} else {
			if($result['result_code'] == "FAIL") {
				//商户号重复时，要重新生成
				if($result['err_code'] == 'OUT_TRADE_NO_USED' || $result['err_code'] == 'INVALID_REQUEST') {
					$out_trade_no = 'O' . $this->advdbclass->get_unique_orders_number('out_trade_no');
    				$this->Orders_model->save(array('out_trade_no' => $out_trade_no), array('id' => $item_info['id']));

					//②、统一下单
					$input = new WxPayUnifiedOrder();
					$input->SetBody("携众易购付款");
					$input->SetAttach($item_info['order_number']);
					$input->SetTotal_fee($item_info['total']*100);
					$input->SetTime_start(date("YmdHis"));
					$input->SetTime_expire(date("YmdHis", time() + 600));
					$input->SetNotify_url(base_url()."index.php/napi/order_wxpay_pay_notify_js");
					$input->SetTrade_type("JSAPI");
					$input->SetOpenid($open_id);
					$input->SetAppid($app_id);
					$input->SetProduct_id($product_id);
					$input->SetOut_trade_no($out_trade_no);
					$result = WxPayApi::unifiedOrder($input);
					if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
						$jsApiParameters = $tools->GetJsApiParameters($result);
						//生成支付记录
						if (!$this->Pay_log_model->rowCount(array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'orders'))) {
							$fields = array(
									'user_id' => $item_info['user_id'],
									'total_fee' => $item_info['total'],
									'total_fee_give' => 0,
									'out_trade_no' => $out_trade_no,
									'order_num' => $item_info['order_number'],
									'trade_status' => 'WAIT_BUYER_PAY',
									'add_time' => time(),
									'payment_type' => 'weixin',
									'order_type' => 'orders'
							);
							$this->Pay_log_model->save($fields);
						}
					} else {
						printAjaxError('fail', '支付失败，请重试');
					}
				} else {
					printAjaxError('fail', '支付失败，请重试');
				}
			} else {
				printAjaxError('fail', '支付失败，请重试');
			}
		}
		$jsApiParameters = json_decode($jsApiParameters, true);
		printAjaxData($jsApiParameters);
	}

	//支付宝App支付异步通知-普通订单
	public function order_alipay_notify() {
		if ($_POST) {
			require_once("sdk/alipay/aop/AopClient.php");
			require_once 'sdk/alipay/aop/SignData.php';

			$aop = new AopClient;
			$aop->alipayrsaPublicKey = $this->_alipayrsaPublicKey;
			$verify_result = $aop->rsaCheckV1($_POST, NULL, "RSA2");
			if($verify_result) {
				//商户订单号
    			$out_trade_no = $this->input->post('out_trade_no', TRUE);
    			//支付宝交易号
    			$trade_no = $this->input->post('trade_no', TRUE);
				//交易状态
				$trade_status = $this->input->post('trade_status', TRUE);
				//买家支付宝账号
				$buyer_email  = $this->input->post('buyer_logon_id', TRUE);
				//通知时间
				$notify_time  = strtotime($this->input->post('notify_time', TRUE));
				$app_id  = $this->input->post('app_id', TRUE);
				$total_amount  = $this->input->post('total_amount', TRUE);

				if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
					$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'orders', 'payment_type' => 'alipay'));
					if ($pay_log_info && $app_id == $this->_app_id && $total_amount == $pay_log_info['total_fee']) {
						if ($pay_log_info['trade_status'] != $trade_status && $pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
							//支付记录
							$fields = array(
									'trade_no' => $trade_no,
									'trade_status' => $trade_status,
									'buyer_email' => $buyer_email,
									'notify_time' => $notify_time
							);
							if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
								$item_info = $this->Orders_model->get('*', array('order_number' => $out_trade_no, 'status' => 0));
								$user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
								if ($item_info && $user_info) {
									//修改订单状态
									$fields = array(
											'status' => 1,
											'payment_price' => 0,//费率
											'payment_title' => '支付宝支付',
											'payment_id' => 2);
									if ($this->Orders_model->save($fields, array('id' => $item_info['id']))) {
										//订单追踪记录
										$fields = array(
												'add_time' => time(),
												'content' => "订单付款成功[App支付宝支付]",
												'order_id' => $item_info['id'],
												'current_status' => $item_info['status'],
												'change_status' => 1
										);
										$this->Orders_process_model->save($fields);
										//财务记录
										if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
											$fields = array(
													'cause' => "支付成功-[订单号：{$item_info['order_number']}]",
													'price' => -$item_info['total'],
													'balance' => $user_info['total'],
													'add_time' => time(),
													'user_id' => $user_info['id'],
													'username' => $user_info['username'],
													'type' => 'order_out',
													'pay_way' => '2',
													'ret_id' => $item_info['id'],
													'from_user_id' => $user_info['id']
											);
											$this->Financial_model->save($fields);
										}
										//付款减库存
										$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
								        if ($systemInfo['stock_reduce_type'] == 1) {
								        	$orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
								    		if ($orders_detail_list) {
								    			foreach ($orders_detail_list as $item) {
								    				if ($item['color_size_open'] == 1) {
								    					$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
								    					if ($product_stock_info) {
								    						$stock = $product_stock_info['stock'] - $item['buy_number'];
								    						$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
								    					}
								    				} else {
								    					$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
								    					if ($product_info) {
								    						$stock = $product_info['stock'] - $item['buy_number'];
								    						$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
								    					}
								    				}
								    			}
								    		}
								        }
									}
								}
							}
						}
					}
				}
				echo "success";
			} else {
				echo "fail";
			}
		}
	}

	//微信异步回调认证(付款)-普通订单
	public function order_wxpay_pay_notify() {
		$xmlInfo = $GLOBALS['HTTP_RAW_POST_DATA'];
		//解析xml
		$result = $this->xmlToArray($xmlInfo);
		/* ======================================== */
		if ($result != null) {
			if(array_key_exists("return_code", $result)
					&& array_key_exists("result_code", $result)
					&& $result["return_code"] == "SUCCESS"
					&& $result["result_code"] == "SUCCESS")
			{
				//订单号
				$order_num    = $result['attach'];
				//商户订单号
				$out_trade_no = $result['out_trade_no'];
				//微信交易号
				$trade_no     = $result['transaction_id'];
				//通知时间
				$notify_time  = $result['time_end'];
				$total_fee    = $result['total_fee'];

				$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'orders', 'payment_type' => 'weixin'));
				if ($pay_log_info && $total_fee == $pay_log_info['total_fee'] * 100) {
					if ($pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
						//支付记录
						$fields = array(
								'trade_no' => $trade_no,
								'trade_status' => 'TRADE_SUCCESS',
								'buyer_email' => '',
								'notify_time' => strtotime($notify_time)
						);
						if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
							$item_info = $this->Orders_model->get('*', array('order_number' => $order_num, 'status' => 0));
							$user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
							if ($item_info && $user_info) {
								//修改订单状态
								$fields = array(
										'status' => 1,
										'payment_price' => 0,//费率
										'payment_title' => '微信支付',
										'payment_id' => 3);
								if ($this->Orders_model->save($fields, array('id' => $item_info['id']))) {
									//订单追踪记录
									$fields = array(
											'add_time' => time(),
											'content' => "订单付款成功[App微信支付]",
											'order_id' => $item_info['id'],
											'current_status' => $item_info['status'],
											'change_status' => 1
									);
									$this->Orders_process_model->save($fields);
									//财务记录
									if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
										$fields = array(
												'cause' => "支付成功-[订单号：{$item_info['order_number']}]",
												'price' => -$item_info['total'],
												'balance' => $user_info['total'],
												'add_time' => time(),
												'user_id' => $user_info['id'],
												'username' => $user_info['username'],
												'type' => 'order_out',
												'pay_way' => '3',
												'ret_id' => $item_info['id'],
												'from_user_id' => $user_info['id']
										);
										$this->Financial_model->save($fields);
									}
									//付款减库存
									$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
							        if ($systemInfo['stock_reduce_type'] == 1) {
							        	$orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
							    		if ($orders_detail_list) {
							    			foreach ($orders_detail_list as $item) {
							    				if ($item['color_size_open'] == 1) {
							    					$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
							    					if ($product_stock_info) {
							    						$stock = $product_stock_info['stock'] - $item['buy_number'];
							    						$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
							    					}
							    				} else {
							    					$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
							    					if ($product_info) {
							    						$stock = $product_info['stock'] - $item['buy_number'];
							    						$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
							    					}
							    				}
							    			}
							    		}
							        }
								}
							}
						}
					}
				}
				echo $this->returnInfo("SUCCESS", "OK");
			}
		}
	}

	//微信h5异步回调认证(付款)-优选
	public function order_wxpay_pay_notify_js() {
		/********************微信支付**********************/
		require_once "sdk/weixin_pay/lib/WxPay.Api.php";

		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		try {
			$data = WxPayResults::Init($xml);
			if(array_key_exists("transaction_id", $data)){
				$input = new WxPayOrderQuery();
				$input->SetTransaction_id($data["transaction_id"]);
				$result = WxPayApi::orderQuery($input);
				if(array_key_exists("return_code", $result)
						&& array_key_exists("result_code", $result)
						&& $result["return_code"] == "SUCCESS"
						&& $result["result_code"] == "SUCCESS")
				{
					//订单号
					$order_num    = $result['attach'];
					//商户订单号
					$out_trade_no = $result['out_trade_no'];
					//微信交易号
					$trade_no     = $result['transaction_id'];
					//通知时间
					$notify_time  = $result['time_end'];
					$total_fee    = $result['total_fee'];

					$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'orders', 'payment_type' => 'weixin'));
					if ($pay_log_info && $total_fee == $pay_log_info['total_fee'] * 100) {
						if ($pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
							//支付记录
							$fields = array(
									'trade_no' => $trade_no,
									'trade_status' => 'TRADE_SUCCESS',
									'buyer_email' => '',
									'notify_time' => strtotime($notify_time)
							);
							if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
								$item_info = $this->Orders_model->get('*', array('order_number' => $order_num, 'status' => 0));
								$user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
								if ($item_info && $user_info) {
									//修改订单状态
									$fields = array(
											'status' => 1,
											'payment_price' => 0,//费率
											'payment_title' => '微信支付',
											'payment_id' => 3);
									if ($this->Orders_model->save($fields, array('id' => $item_info['id']))) {
										//订单追踪记录
										$fields = array(
												'add_time' => time(),
												'content' => "订单付款成功[微信支付]",
												'order_id' => $item_info['id'],
												'current_status' => $item_info['status'],
												'change_status' => 1
										);
										$this->Orders_process_model->save($fields);
										//财务记录
										if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
											$fields = array(
													'cause' => "支付成功-[订单号：{$item_info['order_number']}]",
													'price' => -$item_info['total'],
													'balance' => $user_info['total'],
													'add_time' => time(),
													'user_id' => $user_info['id'],
													'username' => $user_info['username'],
													'type' => 'order_out',
													'pay_way' => '3',
													'ret_id' => $item_info['id'],
													'from_user_id' => $user_info['id']
											);
											$this->Financial_model->save($fields);
										}
										//付款减库存
										$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
								        if ($systemInfo['stock_reduce_type'] == 1) {
								        	$orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
								    		if ($orders_detail_list) {
								    			foreach ($orders_detail_list as $item) {
								    				if ($item['color_size_open'] == 1) {
								    					$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
								    					if ($product_stock_info) {
								    						$stock = $product_stock_info['stock'] - $item['buy_number'];
								    						$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
								    					}
								    				} else {
								    					$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
								    					if ($product_info) {
								    						$stock = $product_info['stock'] - $item['buy_number'];
								    						$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
								    					}
								    				}
								    			}
								    		}
								        }
									}
								}
							}
						}
					}
				}
			}
		} catch (WxPayException $e){
			$msg = $e->errorMessage();
		}
	}

	//支付 宝异步通知
	public function order_alipay_notify_js() {
		if ($_POST) {
			require_once("sdk/alipay/alipay_h5.config.php");
			require_once("sdk/alipay/lib/alipay_notify.class.php");
			//计算得出通知验证结果
			$alipay_config['notify_url'] = base_url() . 'index.php/napi/order_alipay_notify_js';
			$alipay_config['return_url'] = base_url() . 'index.php/napi/order_alipay_return_js';
			$alipayNotify = new AlipayNotify($alipay_config);
			$verify_result = $alipayNotify->verifyNotify();
			if ($verify_result) {
				//商户订单号
    			$out_trade_no = $this->input->post('out_trade_no', TRUE);
    			//支付宝交易号
    			$trade_no = $this->input->post('trade_no', TRUE);
				//交易状态
				$trade_status = $this->input->post('trade_status', TRUE);
				//买家支付宝账号
				$buyer_email = $this->input->post('buyer_email', TRUE);
				//通知时间
				$notify_time = strtotime($this->input->post('notify_time', TRUE));
				$seller_id = $this->input->post('seller_id', TRUE);
				$total_fee = $this->input->post('total_fee', TRUE);

				if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
					$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'orders', 'payment_type' => 'alipay'));
					if ($pay_log_info && $alipay_config['seller_id'] == $seller_id && $total_fee == $pay_log_info['total_fee']) {
						if ($pay_log_info['trade_status'] != $trade_status && $pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
							//支付记录
							$fields = array(
									'trade_no' => $trade_no,
									'trade_status' => $trade_status,
									'buyer_email' => $buyer_email,
									'notify_time' => $notify_time
							);
							if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
								$item_info = $this->Orders_model->get('*', array('order_number' => $out_trade_no, 'status' => 0));
								$user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
								if ($item_info && $user_info) {
									//修改订单状态
									$fields = array(
											'status' => 1,
											'payment_price' => 0,//费率
											'payment_title' => '支付宝支付',
											'payment_id' => 2);
									if ($this->Orders_model->save($fields, array('id' => $item_info['id']))) {
										//订单追踪记录
										$fields = array(
												'add_time' => time(),
												'content' => "订单付款成功[支付宝支付]",
												'order_id' => $item_info['id'],
												'current_status' => $item_info['status'],
												'change_status' => 1
										);
										$this->Orders_process_model->save($fields);
										//财务记录
										if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
											$fields = array(
													'cause' => "支付成功-[订单号：{$item_info['order_number']}]",
													'price' => -$item_info['total'],
													'balance' => $user_info['total'],
													'add_time' => time(),
													'user_id' => $user_info['id'],
													'username' => $user_info['username'],
													'type' => 'order_out',
													'pay_way' => '2',
													'ret_id' => $item_info['id'],
													'from_user_id' => $user_info['id']
											);
											$this->Financial_model->save($fields);
										}
										//付款减库存
										$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
								        if ($systemInfo['stock_reduce_type'] == 1) {
								        	$orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
								    		if ($orders_detail_list) {
								    			foreach ($orders_detail_list as $item) {
								    				if ($item['color_size_open'] == 1) {
								    					$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
								    					if ($product_stock_info) {
								    						$stock = $product_stock_info['stock'] - $item['buy_number'];
								    						$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
								    					}
								    				} else {
								    					$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
								    					if ($product_info) {
								    						$stock = $product_info['stock'] - $item['buy_number'];
								    						$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
								    					}
								    				}
								    			}
								    		}
								        }
									}
								}
							}
						}
					}
				}
				echo "success";
			} else {
				echo "fail";
			}
		}
	}

	//支付 宝同步通知
	public function order_alipay_return_js() {
		require_once("sdk/alipay/alipay_h5.config.php");
		require_once("sdk/alipay/lib/alipay_notify.class.php");
		$alipay_config['notify_url'] = base_url() . 'index.php/napi/order_alipay_notify_js';
		$alipay_config['return_url'] = base_url() . 'index.php/napi/order_alipay_return_js';

		$gloabPreUrl = $this->session->userdata('gloabPreUrl');
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if (!$verify_result) {
			printAjaxError('fail', '订单支付失败');
		}
		$out_trade_no = $_GET['out_trade_no'];
    	//支付宝交易号
    	$trade_no = $_GET['trade_no'];
		//交易状态
		$trade_status = $_GET['trade_status'];
		//买家支付宝账号
		$buyer_email = $this->input->get('buyer_email', TRUE);
		//通知时间
		$notify_time = strtotime($this->input->get('notify_time', TRUE));

		if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
			//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
			$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'orders', 'payment_type' => 'alipay'));
			if (!$pay_log_info) {
				printAjaxError('fail', '此支付记录不存在,支付失败');
			}
			if ($pay_log_info['trade_status'] != $trade_status && $pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
				//支付记录
				$fields = array(
						'trade_no' => $trade_no,
						'trade_status' => $trade_status,
						'buyer_email' => $buyer_email,
						'notify_time' => $notify_time
				);
				if (!$this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
					printAjaxError('fail', '支付失败，请重试');
				}
				$item_info = $this->Orders_model->get('*', array('order_number' => $out_trade_no, 'status' => 0));
				$user_info = $this->User_model->get('id, total, username', array('id' => $item_info['user_id']));
				if ($item_info && $user_info) {
					//修改订单状态
					$fields = array(
							'status' => 1,
							'payment_price' => 0,//费率
							'payment_title' => '支付宝支付',
							'payment_id' => 2);
					if ($this->Orders_model->save($fields, array('id' => $item_info['id'], 'status' => 0))) {
						//订单追踪记录
						$fields = array(
								'add_time' => time(),
								'content' => "订单付款成功[支付宝支付]",
								'order_id' => $item_info['id'],
								'current_status' => $item_info['status'],
								'change_status' => 1
						);
						$this->Orders_process_model->save($fields);
						//财务记录
						if (!$this->Financial_model->rowCount(array('type' => 'order_out', 'ret_id' => $item_info['id']))) {
							$fields = array(
									'cause' => "支付成功-[订单号：{$item_info['order_number']}]",
									'price' => -$item_info['total'],
									'balance' => $user_info['total'],
									'add_time' => time(),
									'user_id' => $user_info['id'],
									'username' => $user_info['username'],
									'type' => 'order_out',
									'pay_way' => '2',
									'ret_id' => $item_info['id'],
									'from_user_id' => $user_info['id']
							);
							$this->Financial_model->save($fields);
						}
						//付款减库存
						$systemInfo = $this->System_model->get('stock_reduce_type', array('id' => 1));
				        if ($systemInfo['stock_reduce_type'] == 1) {
				        	$orders_detail_list = $this->Orders_detail_model->gets('*', array('order_id' => $item_info['id']));
				    		if ($orders_detail_list) {
				    			foreach ($orders_detail_list as $item) {
				    				if ($item['color_size_open'] == 1) {
				    					$product_stock_info = $this->Product_model->getProductStock($item['product_id'], $item['color_id'], $item['size_id']);
				    					if ($product_stock_info) {
				    						$stock = $product_stock_info['stock'] - $item['buy_number'];
				    						$this->Product_model->changeStock(array('stock' => $stock), array('product_id' => $item['product_id'], 'color_id' => $item['color_id'], 'size_id' => $item['size_id']));
				    					}
				    				} else {
				    					$product_info = $this->Product_model->get('stock', array('id' => $item['product_id']));
				    					if ($product_info) {
				    						$stock = $product_info['stock'] - $item['buy_number'];
				    						$this->Product_model->save(array('stock' =>$stock>0?$stock:0), array('id' => $item['product_id']));
				    					}
				    				}
				    			}
				    		}
				        }
					}
				}
				redirect(base_url() . "wx/cart_pay_success.html?order_number={$out_trade_no}");
			} else {
				$fields = array();
				if (!$item_info['buyer_email']) {
					$fields['buyer_email'] = $buyer_email;
				}
				if (!$item_info['notify_time']) {
					$fields['notify_time'] = $notify_time;
				}
				if ($fields) {
					$this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']));
				}
				redirect(base_url() . "wx/cart_pay_success.html?order_number={$out_trade_no}");
			}
		} else {
			printAjaxError('fail', '支付失败，请重试');
		}
	}

    //获取物流信息
    public function get_logistics_info($order_id = 0) {
    	$user_id = $this->_check_login();
    	$order_info = $this->Orders_model->get('status,delivery_name,express_number', array('id' => $order_id));
    	if (empty($order_info)) {
    		printAjaxError('fail', '此订单id不存在');
    	}
    	if (!($order_info['status'] == 3 || $order_info['status'] == 4)) {
    		printAjaxError('fail', '订单状态必须是发货中或交易成功');
    	}
    	$num = $order_info['express_number'];
    	$key = 'mZRQwDVc3377';
    	$result = file_get_contents("http://www.kuaidi100.com/autonumber/auto?num=$num&key=$key");
    	$arr = json_decode($result, true);
    	if (empty($arr)) {
    		printAjaxError('fail', '该订单号无法查询快递公司');
    	}
    	$com = $arr[0]['comCode'];
    	$post_data = array();
    	$post_data["customer"] = '1FCC0BAA1D04BBDFEB9EE3F96F963265';
    	$post_data["param"] = '{"com":"' . $com . '","num":"' . $num . '"}';
    	$url = 'http://www.kuaidi100.com/poll/query.do';
    	$post_data["sign"] = md5($post_data["param"] . $key . $post_data["customer"]);
    	$post_data["sign"] = strtoupper($post_data["sign"]);
    	$o = "";
    	foreach ($post_data as $k => $v) {
    		$o.= "$k=" . urlencode($v) . "&";  //默认UTF-8编码格式
    	}
    	$post_data = substr($o, 0, -1);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    	$result = curl_exec($ch);
    	curl_close($ch);
    	$data = str_replace("\&quot;", '"', $result);
    	$data = json_decode($data, true);
    	$data['delivery_name'] = $order_info['delivery_name'];
    	printAjaxData($data);
    }

    //申请退款/退货
    public function save_exchange($id = NULL) {
    	$user_id = $this->_check_login();
    	$item_info = $this->Exchange_model->get('*', array('user_id' => $user_id, 'id' => $id));
    	if ($item_info) {
    		$tmp_path = $this->_fliter_image_path($item_info['path']);
    		$item_info['path'] = $tmp_path['path'];
    		$path_arr = explode('_', $item_info['batch_path_ids']);
    		$batch_path = array();
    		$path_arr = array_filter($path_arr);
    		foreach ($path_arr as $key => $ls) {
    			$tmp_image = $this->Attachment_model->get('path', array('id' => $ls));
    			if($tmp_image){
    				$tmp_path = $this->_fliter_image_path($tmp_image['path']);
    				$batch_path[$key]['id'] = $ls;
    				$batch_path[$key]['path'] = $tmp_path['path'];
    				$batch_path[$key]['path_thumb'] = $tmp_path['path_thumb'];
    			}
    		}
    		$item_info['batch_path'] = $batch_path;
    		$item_info['path_thumb'] = $tmp_path['path_thumb'];
    	}
    	if ($_POST) {
    		$exchange_type = $this->input->post("exchange_type", TRUE);
    		$title = $this->input->post("title", TRUE);
    		$path = $this->input->post("path", TRUE);
    		$content = $this->input->post("content", TRUE);
    		$refund_cause = $this->input->post('refund_cause', TRUE);
    		$batch_path_ids = $this->input->post('batch_path_ids', TRUE);
    		$order_number = $this->input->post('order_number', true);
    		$orders_detail_id = $this->input->post('orders_detail_id', true);
    		$order_info = $this->Orders_model->get('total,postage_price,id', array('order_number' => $order_number, 'user_id' => $user_id));
    		$item_info = $this->Exchange_model->get('*', array('order_number' => $order_number, 'orders_detail_id' => $orders_detail_id));
    		$refund_amount = 0;
    		if (empty($order_info)) {
    			printAjaxError('order_number', '退换货订单号错误');
    		}
    		$order_detail = $this->Orders_detail_model->get('id,buy_price', array('id' => $orders_detail_id, 'order_id' => $order_info['id']));
    		if (empty($order_detail)) {
    			printAjaxError('orders_detail_id', '退换货订单详细id错误');
    		}
    		$orders_detail_count = $this->Orders_detail_model->rowCount(array('order_id' => $order_info['id']));
    		if (!empty($item_info)) {
    			if ($item_info['status'] == 2) {
    				printAjaxError('fail', '此单已处理完成，不能再此申请');
    			}
    		}
    		if (!$order_number) {
    			printAjaxError('order_number', '退换货订单号不能为空');
    		}
    		if (empty($refund_cause)) {
    			printAjaxError('fail', '请选择退换货原因');
    		}

    		$ordersInfo = $this->Orders_model->get('status, total,pay_mode', array('order_number' => $order_number, 'user_id' => $user_id));
    		if (!$ordersInfo) {
    			printAjaxError('fail', '此订单号不存在，请认真确认订单号');
    		}
    		if ($ordersInfo['pay_mode'] == 1) {
    			printAjaxError('fail', '不受理礼品订单退换货，有问题，请联系网站客服！');
    		}
    		if ($exchange_type == 1 || $exchange_type == 3) {
    			$refund_amount = floatval($this->input->post('refund_amount', true));
    			if ($orders_detail_count == 1) {
    				if ($refund_amount > $ordersInfo['total']) {
    					printAjaxError('fail', '退款金额不能大于订单总额');
    				}
    			} else {
    				if ($refund_amount > $order_detail['buy_price']) {
    					printAjaxError('fail', '退款金额不能大于最大退款金额');
    				}
    			}
    		}
    		//未付款
    		if ($ordersInfo['status'] == 0) {
    			printAjaxError('fail', '此订单未付款，不能申请退换货');
    		}
    		//交易关闭
    		if ($ordersInfo['status'] == 5) {
    			printAjaxError('fail', '此订单交易关闭，不能申请退换货');
    		}
    		//退换货成功
    		if ($ordersInfo['status'] == 6) {
    			printAjaxError('fail', '此订单是已退换货订单，不能申请退换货');
    		}
    		$fields = array(
    				'user_id' => $user_id,
    				'order_number' => $order_number,
    				'title' => $title,
    				'exchange_type' => $exchange_type,
    				'path' => $path,
    				'add_time' => time(),
    				'content' => $content,
    				'status' => '0',
    				'refund_cause' => $refund_cause,
    				'orders_detail_id' => $orders_detail_id,
    				'batch_path_ids' => $batch_path_ids,
    				'refund_amount' => $refund_amount
    		);
    		if ($this->Exchange_model->save($fields, !empty($item_info) ? array('order_number' => $order_number, 'orders_detail_id' => $orders_detail_id) : NULL)) {
    			printAjaxSuccess('success', '申请退换货成功');
    		} else {
    			printAjaxError('fail', '申请退换货失败');
    		}
    	}
    	printAjaxData($item_info);
    }

    //申请退款/退货
    public function my_save_exchange($id = NULL) {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$order_number = $this->input->post('order_number', true);
    		$orders_detail_id = $this->input->post('orders_detail_id', true);
    		$exchange_type = $this->input->post("exchange_type", TRUE);
    		$content = $this->input->post("content", TRUE);
    		$refund_cause = $this->input->post('refund_cause', TRUE);
    		$batch_path_ids = $this->input->post('batch_path_ids', TRUE);
    		$refund_amount = $this->input->post('refund_amount', true);

    		if (!$order_number || !$orders_detail_id) {
    			printAjaxError('fail', '参数错误');
    		}
    		if (!$exchange_type) {
    			printAjaxError('exchange_type', '申请服务类型不能为空');
    		}
    		if ($exchange_type != 1 && $exchange_type != 2 && $exchange_type != 3) {
    			printAjaxError('exchange_type', '申请服务类型错误');
    		}
    		if (!$refund_cause) {
    			printAjaxError('refund_cause', '请选择退换货原因');
    		}
    		$order_info = $this->Orders_model->get('status, total, postage_price,id', array('order_number' => $order_number, 'user_id' => $user_id));
    		if (!$order_info) {
    			printAjaxError('fail', '此订单信息不存在，操作失败');
    		}
    		$orders_detail_info = $this->Orders_detail_model->get('id,buy_price', array('id' => $orders_detail_id, 'order_id' => $order_info['id']));
    		if (!$orders_detail_info) {
    			printAjaxError('orders_detail_id', '退换货订单商品信息不存在');
    		}
    		$item_info = $this->Exchange_model->get('*', array('order_number' => $order_number, 'orders_detail_id' => $orders_detail_id));
    		if ($item_info) {
    			if ($item_info['status'] == 2) {
    				printAjaxError('fail', '此单已处理完成，不能再此申请');
    			}
    		}
    		$orders_detail_count = $this->Orders_detail_model->rowCount(array('order_id' => $order_info['id']));
    		if ($exchange_type == 1 || $exchange_type == 3) {
    			if ($orders_detail_count == 1) {
    				if ($refund_amount > $order_info['total']) {
    					printAjaxError('fail', '退款金额不能大于订单总额');
    				}
    			} else {
    				if ($refund_amount > $order_info['buy_price']) {
    					printAjaxError('fail', '退款金额不能大于最大退款金额');
    				}
    			}
    		} else {
    			$refund_amount = 0;
    		}
    		if ($order_info['status'] != 1 && $order_info['status'] != 2 && $order_info['status'] != 4) {
    			printAjaxError('fail', '当前订单状态不能申请退换货');
    		}

    		$fields = array(
    				'user_id' => $user_id,
    				'order_number' => $order_number,
    				'title' => '',
    				'path' => '',
    				'exchange_type' => $exchange_type,
    				'add_time' => time(),
    				'content' => $content,
    				'status' => '0',
    				'refund_cause' => $refund_cause,
    				'orders_detail_id' => $orders_detail_id,
    				'batch_path_ids' => $batch_path_ids,
    				'refund_amount' => $refund_amount
    		);
    		if ($this->Exchange_model->save($fields, $item_info? array('id' => $item_info['id'], 'user_id' => $user_id) : NULL)) {
    			printAjaxSuccess('success', '申请退换货成功');
    		} else {
    			printAjaxError('fail', '申请退换货失败');
    		}
    	}
    }

    public function buyer_post_goods() {
    	$user_id = $this->_check_login();
    	$systemInfo = $this->System_model->get('return_address', array('id' => 1));
    	if ($_POST) {
    		$order_number = $this->input->post('order_number', true);
    		$orders_detail_id = $this->input->post('orders_detail_id', true);
    		$item_info = $this->Exchange_model->get('*', array('user_id' => $user_id, 'orders_detail_id' => $orders_detail_id, 'order_number' => $order_number));
    		if (empty($item_info)) {
    			printAjaxError('fail', '此退款信息不存在');
    		}
    		$user_address = '';
    		if ($item_info['exchange_type'] == 2) {
    			$default_address = $this->User_address_model->get('txt_address,address,buyer_name,mobile', array('default' => 1, 'user_id' => $user_id));
    			if (!$default_address) {
    				printAjaxError('fail', '没有默认地址');
    			}

    			$user_address = "{$default_address['buyer_name']}，{$default_address['mobile']}，{$default_address['txt_address']}{$default_address['address']}";
    		}

    		$fields = array(
    				'buyer_express_num' => $this->input->post('buyer_express_num', true),
    				'buyer_experss_com' => $this->input->post('buyer_express_com', true),
    				'buyer_post_remark' => $this->input->post('buyer_post_remark', true),
    				'user_address' => $user_address,
    		);
    		$this->Exchange_model->save($fields, array('user_id' => $user_id, 'orders_detail_id' => $orders_detail_id, 'order_number' => $order_number));
    		printAjaxSuccess('false', '提交成功');
    	}
    	printAjaxData($systemInfo);
    }

    public function get_my_flash_list($max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
    	$user_id = $this->_check_login();
    	$strWhere = "user_id = {$user_id}";
    	if ($since_id) {
    		$strWhere .= " and id > {$since_id} ";
    	}
    	if ($max_id) {
    		$strWhere .= " and id <= {$max_id} ";
    	}
    	$flash_sale_info = $this->Flash_sale_record_model->gets($strWhere, $per_page, $per_page * ($page - 1));
    	foreach ($flash_sale_info as $key => $ls) {
    		$flash = $this->Flash_sale_model->get('*', array('id' => $ls['flash_sale_id']));
    		$order_info = $this->Orders_model->get('status', array('id' => $ls['order_id']));
    		$order_detail = $this->Orders_detail_model->get('size_name,color_name', array('order_id' => $ls['order_id']));
    		$flash_sale_info[$key]['name'] = $flash['name'];
    		$flash_sale_info[$key]['add_time'] = date('Y-m-d H:i:s', $flash['add_time']);
    		$flash_sale_info[$key]['flash_sale_price'] = $flash['flash_sale_price'];
    		$tmp_path = $this->_fliter_image_path($flash['path']);
    		$flash_sale_info[$key]['path'] = $tmp_path['path'];
    		$flash_sale_info[$key]['path_thumb'] = $tmp_path['path_thumb'];
    		$flash_sale_info[$key]['status'] = $this->_status_arr[$order_info['status']];
    		$flash_sale_info[$key]['size_name'] = $order_detail['size_name'];
    		$flash_sale_info[$key]['color_name'] = $order_detail['color_name'];
    		$flash_sale_info[$key]['end_time'] = date('Y-m-d H:i:s', $flash['end_time']);
    	}
    	// 最大ID
        if (!$max_id && !$since_id) {
        	$max_id = $this->Flash_sale_record_model->get_max_id(NULL);
        } else {
        	//下拉刷新
        	if (!$max_id && $since_id) {
        		$max_id = $this->Flash_sale_record_model->get_max_id(NULL);
        	}
        }
    	//是否有下一页
    	$cur_count = $per_page * ($page - 1) + count($flash_sale_info);
    	$total_count = $this->Flash_sale_record_model->rowCount($strWhere);
    	$is_next_page = 0;
    	if ($total_count > $cur_count) {
    		$is_next_page = 1;
    	}
    	printAjaxData(array('item_list' => $flash_sale_info, 'max_id' => $max_id, 'is_next_page' => $is_next_page));
    }

    //获取我的拼团记录
    public function get_my_pintuan_list($max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
    	//判断是否登录
    	$user_id = $this->_check_login();
    	$strWhere = "ptkj_record.user_id = {$user_id}";
    	if ($since_id) {
    		$strWhere .= " and ptkj_record.id > {$since_id} ";
    	}
    	if ($max_id) {
    		$strWhere .= " and ptkj_record.id <= {$max_id} ";
    	}
    	$group_purchase_list = $this->Ptkj_record_model->gets($strWhere, $per_page, $per_page * ($page - 1));
    	$ids = '';
    	foreach ($group_purchase_list as $key => $ls) {
    		$ids .= $ls['ptkj_id'] . ',';
    		$chop_record = $this->Chop_record_model->get("count(1) as cut_times,sum(chop_price) as sum", "user_id = $user_id and ptkj_record_id = {$ls['id']} and chop_user_id <> ''");
    		$tm_arr = $this->_fliter_image_path($ls['path']);
    		$group_purchase_list[$key]['path'] = $tm_arr['path'];
    		$group_purchase_list[$key]['path_thumb'] = $tm_arr['path_thumb'];
    		$group_purchase_list[$key]['cut_times'] = $chop_record['cut_times'];
    		$group_purchase_list[$key]['sum'] = $chop_record['sum'] ? $chop_record['sum'] : '0.00';
    		$group_purchase_list[$key]['end_time'] = date('Y-m-d H:i:s', $ls['end_time']);
    		if (time() > $ls['end_time']) {
    			$group_purchase_list[$key]['status'] = '已结束';
    		}
    		if (time() <= $ls['end_time']) {
    			$group_purchase_list[$key]['status'] = '进行中';
    		}
    	}
    	$ids = trim($ids, ',');
    	$rule_list = array();
    	if ($ids) {
    		$rule_list = $this->Pintuan_model->gets("ptkj_id in ($ids)");
    	}
    	//拼团砍价规则
    	$rule_arr = array();
    	foreach ($rule_list as $key => $ls) {
    		$rule_arr[$ls['ptkj_id']][] = $ls;
    	}
    	//判断当前拼团人数是否在区间,确定拼团价格
    	if (!empty($rule_arr)) {
    		foreach ($group_purchase_list as $key => $ls) {
    			foreach ($rule_arr[$ls['ptkj_id']] as $value) {
    				if ($ls['pintuan_people'] >= $value['low'] && $ls['pintuan_people'] <= $value['high']) {
    					$group_purchase_list[$key]['pintuan_price'] = $value['money'];
    					$group_purchase_list[$key]['current_price'] = number_format($value['money'] - $ls['sum'], 2);
    				}
    			}
    		}
    	}
    	// 最大ID
        if (!$max_id && !$since_id) {
        	$max_id = $this->Ptkj_record_model->get_max_id(NULL);
        } else {
        	//下拉刷新
        	if (!$max_id && $since_id) {
        		$max_id = $this->Ptkj_record_model->get_max_id(NULL);
        	}
        }
    	//是否有下一页
    	$cur_count = $per_page * ($page - 1) + count($group_purchase_list);
    	$total_count = $this->Ptkj_record_model->rowCount($strWhere);
    	$is_next_page = 0;
    	if ($total_count > $cur_count) {
    		$is_next_page = 1;
    	}
    	printAjaxData(array('item_list' => $group_purchase_list, 'max_id' => $max_id, 'is_next_page' => $is_next_page));
    }

    //获取我的参团信息
    public function get_my_pintuan_info() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$ptkj_record_id = $this->input->post('ptkj_record_id', true);
    		if (empty($ptkj_record_id)) {
    			printAjaxError('fail', '拼团记录id不能空');
    		}
    		$item_info = $this->Ptkj_record_model->get(array('ptkj_record.id' => $ptkj_record_id));
    		if (empty($item_info)) {
    			printAjaxError('fail', '无参团信息');
    		}
    		$choped_list = $this->Chop_record_model->gets('chop_user_id,nickname,chop_price,chop_nickname', "ptkj_record_id = {$ptkj_record_id} and chop_user_id is not null");
    		$choped_price = 0;
    		foreach ($choped_list as $key => $ls) {
    			$user_info = $this->User_model->getInfo('path', array('id' => $ls['chop_user_id']));
    			if ($user_info['path']) {
    				$tem_path = $this->_fliter_image_path($user_info['path']);
    				$choped_list[$key]['path'] = $tem_path['path_thumb'];
    			} else {
    				$choped_list[$key]['path'] = '';
    			}
    			$choped_price += $ls['chop_price'];
    			$choped_list[$key]['nickname'] = hideStar($ls['chop_nickname']);
    		}
    		$pintuan_rule = $this->Pintuan_model->gets(array('ptkj_id' => $item_info['ptkj_id']));
    		$pintuaninfo = $this->Promotion_ptkj_model->get('*', array('id' => $item_info['ptkj_id']));
    		foreach ($pintuan_rule as $ls) {
    			if ($pintuaninfo['pintuan_people'] >= $ls['low'] && $pintuaninfo['pintuan_people'] <= $ls['high']) {
    				$pintuan_price = $ls['money'];
    			}
    		}
    		$tem_path = $this->_fliter_image_path($pintuaninfo['path']);
    		$data = array(
    				'current_time' => time(),
    				'start_time' => $pintuaninfo['start_time'],
    				'end_time' => $pintuaninfo['end_time'],
    				'pintuan_people' => $pintuaninfo['pintuan_people'],
    				'pintuan_price' => $pintuan_price,
    				'path' => $tem_path['path'],
    				'path_thumb' => $tem_path['path_thumb'],
    				'sell_price' => $pintuaninfo['high_price'],
    				'low_price' => $pintuaninfo['low_price'],
    				'choped_price' => $choped_price,
    				'chop_times' => $pintuaninfo['cut_times'],
    				'chop_total_price' => $pintuaninfo['cut_total_money'],
    				'pintuan_rule' => $pintuan_rule,
    				'choped_list' => $choped_list,
    				'title' => $pintuaninfo['name'],
    				'size_name' => $item_info['size_name'],
    				'color_name' => $item_info['color_name'],
    				'current_price' => number_format($pintuan_price - $choped_price, 2),
    				'share_url' => base_url() . 'weixin.php/join/chop_price/' . $ptkj_record_id . '?sign=' . md5('mykey' . $ptkj_record_id)
    		);
    		printAjaxData($data);
    	}
    }

    //获取消息列表
    public function get_message_list($max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
    	//判断是否登录
    	$user_id = $this->_check_login();
    	$strWhere = "to_user_id = {$user_id}";
    	if ($since_id) {
    		$strWhere .= " and id > {$since_id} ";
    	}
    	if ($max_id) {
    		$strWhere .= " and id <= {$max_id} ";
    	}
    	$item_list = $this->Message_model->gets('*', $strWhere, $per_page, $per_page * ($page - 1));
    	if ($item_list) {
    		foreach ($item_list as $key => $item) {
    			$item_list[$key]['message_type_format'] = $this->_message_type_arr[$item['message_type']];
    			$item_list[$key]['add_time_format'] = date('Y/m/d H:i', $item['add_time']);
    		}
    	}
    	// 最大ID
        if (!$max_id && !$since_id) {
        	$max_id = $this->Message_model->get_max_id(NULL);
        } else {
        	//下拉刷新
        	if (!$max_id && $since_id) {
        		$max_id = $this->Message_model->get_max_id(NULL);
        	}
        }
    	//是否有下一页
    	$cur_count = $per_page * ($page - 1) + count($item_list);
    	$total_count = $this->Message_model->rowCount($strWhere);
    	$is_next_page = 0;
    	if ($total_count > $cur_count) {
    		$is_next_page = 1;
    	}
    	printAjaxData(array('item_list' => $item_list, 'max_id' => $max_id, 'is_next_page' => $is_next_page));
    }

    //删除消息
    public function delete_message(){
    	$user_id = $this->_check_login();
    	$ids = trim($this->input->post('ids', true), ',');
    	if (!$ids) {
    		printAjaxError('fail', '消息id不能为空');
    	}
    	if (!$this->Message_model->delete("id in ({$ids}) and to_user_id = {$user_id} ")) {
    		printAjaxError('fail', '消息id不能为空');
    	}
    	printAjaxSuccess('success', '删除成功！');
    }

    /**
     * 获取用户的退换货列表
     *
     * @param number $status
     * @param number $max_id
     * @param number $since_id
     * @param number $per_page
     * @param number $page
     */
    public function get_exchange_list($status = 'all', $max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
    	//判断是否登录
    	$user_id = $this->_check_login();
    	$strWhere = "user_id = {$user_id} ";
    	if ($status != 'all') {
    		$strWhere .= " and status = {$status} ";
    	}
    	if ($since_id) {
    		$strWhere .= " and id > {$since_id} ";
    	}
    	if ($max_id) {
    		$strWhere .= " and id <= {$max_id} ";
    	}
    	$item_list = $this->Exchange_model->gets('*', $strWhere, $per_page, $per_page * ($page - 1));
    	foreach ($item_list as $key => $item) {
    		$orders_total = 0;
    		$expired = 0;
    		$order_info = $this->Orders_model->get('id,total,status', array('order_number' => $item['order_number']));
    		if ($order_info) {
    			$orders_total = $order_info['total'];
    			if ($order_info['status'] == 4) {
    				$op_info = $this->Orders_process_model->get('add_time', "order_id = {$order_info['id']} and content like '%交易成功%'");
    				if ($op_info['add_time'] + 7 * 24 * 60 * 60 < time()) {
    					$expired = 1;
    				}
    			}
    		}
    		$orders_info = $this->Orders_detail_model->get('product_id,product_title,path,buy_number,buy_price,size_name,color_name', array('id' => $item['orders_detail_id']));
    		if ($orders_info) {
    			$tmp_image_arr = $this->_fliter_image_path($orders_info['path']);
    			$orders_info['path'] = $tmp_image_arr['path'];
    			$orders_info['path_thumb'] = $tmp_image_arr['path_thumb'];
    		}
    		$item_list[$key]['orders_info'] = $orders_info;
    		$item_list[$key]['orders_total'] = $orders_total;
    		$item_list[$key]['expired'] = $expired;
    		$item_list[$key]['status_format'] = $this->_exchange_status[$item['status']];
    		$item_list[$key]['exchange_type_format'] = $this->_exchange_type[$item['exchange_type']];
    	}
    	// 最大ID
    	// 第一次加载
    	if (!$max_id && !$since_id) {
    		$max_id = $this->Exchange_model->get_max_id(NULL);
    	} else {
    		//下拉刷新
    		if (!$max_id && $since_id) {
    			$max_id = $this->Exchange_model->get_max_id(NULL);
    		}
    	}
    	//是否有下一页
    	$cur_count = $per_page * ($page - 1) + count($item_list);
    	$total_count = $this->Exchange_model->rowCount($strWhere);
    	$is_next_page = 0;
    	if ($total_count > $cur_count) {
    		$is_next_page = 1;
    	}
    	$count_0 = $this->Exchange_model->rowCount(array('status' => 0, 'user_id' => $user_id));
    	$count_1 = $this->Exchange_model->rowCount(array('status' => 1, 'user_id' => $user_id));
    	$count_2 = $this->Exchange_model->rowCount(array('status' => 2, 'user_id' => $user_id));

    	printAjaxData(array('item_list' => $item_list, 'max_id' => $max_id, 'is_next_page' => $is_next_page, 'count_0'=>$count_0, 'count_1'=>$count_1, 'count_2'=>$count_2));
    }

    //拼团砍价活动订单-下单
    public function ptkj_pay() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$distributor_info = get_distributor_info($user_id);
    		//收货人地址
    		$oDI = $this->input->post('order_delivery_info');
    		$remark = $this->input->post('remark');
    		$postage_template_id = 0;// intval($this->input->post('postage_template_id', true));
    		if (!$oDI) {
    			printAjaxError('fail', "请选择收货地址");
    		}
    		$systemInfo = $this->System_model->get('presenter_is_open', array('id' => 1));
    		//判断下单用户是否存在
    		$divide_user_id_1 = 0;
    		$divide_user_id_2 = 0;
    		$divide_type = '';
    		$userInfo = $this->User_model->get('*', array('user.id' => $user_id));
    		if (!$userInfo) {
    			printAjaxError('fail', '此用户不存在，订单提交失败');
    		}
    		//一级分销商
    		if ($userInfo['distributor'] == 1 || $userInfo['school_distributor'] == 1 || $userInfo['net_distributor'] == 1) {
    			if ($userInfo['distributor']) {
    				$divide_type = 'distributor';
    			} else if ($userInfo['school_distributor']) {
    				$divide_type = 'school_distributor';
    			} else if ($userInfo['net_distributor']) {
    				$divide_type = 'net_distributor';
    			}
    			//只有正常身份才有提成拿－被禁一级不能拿
    			if ($userInfo['distributor_status'] == 1) {
    				//进货不做提成算，而是直接优惠掉
    				if ($userInfo['distributor'] != 1) {
    					$divide_user_id_1 = $userInfo['id'];
    				}
    			}
    		}
    		//二级分销商
    		else if ($userInfo['distributor'] == 2 || $userInfo['school_distributor'] == 2 || $userInfo['net_distributor'] == 2) {
    			if ($userInfo['distributor']) {
    				$divide_type = 'distributor';
    			} else if ($userInfo['school_distributor']) {
    				$divide_type = 'school_distributor';
    			} else if ($userInfo['net_distributor']) {
    				$divide_type = 'net_distributor';
    			}
    			//只有正常身份才有提成拿－被禁，自己没有提成
    			if ($userInfo['distributor_status'] == 1) {
    				//进货不做提成算，而是直接优惠掉
    				if ($userInfo['distributor'] != 2) {
    					$divide_user_id_2 = $userInfo['id'];
    				}
    				//二级分销商正常有提成拿
    				$parent_user_info = $this->User_model->getInfo('id, distributor_status', array('id' => $userInfo['presenter_id']));
    				if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
    					$divide_user_id_1 = $userInfo['presenter_id'];
    				}
    			} else {
    				//二级分销商禁用时有提成拿
    				if ($userInfo['distributor_status'] == 3) {
    					$parent_user_info = $this->User_model->getInfo('id, distributor_status', array('id' => $userInfo['presenter_id']));
    					if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
    						$divide_user_id_1 = $userInfo['presenter_id'];
    					}
    				}
    			}
    		} else {
    			//消费者
    			if (!$userInfo['distributor'] && !$userInfo['school_distributor'] && !$userInfo['net_distributor']) {
    				//根据二级分销商，查一级分销商-被禁分销商没有提成拿
    				$parent_user_info = $this->User_model->getInfo('id, distributor,school_distributor,net_distributor, presenter_id, distributor_status', array('id' => $userInfo['presenter_id']));
    				if ($parent_user_info) {
    					if ($parent_user_info['distributor']) {
    						$divide_type = 'distributor';
    					} else if ($parent_user_info['school_distributor']) {
    						$divide_type = 'school_distributor';
    					} else if ($parent_user_info['net_distributor']) {
    						$divide_type = 'net_distributor';
    					}
    				}
    				if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
    					$divide_user_id_2 = $parent_user_info['id'];
    				}
    				if ($parent_user_info) {
    					$parent_user_info = $this->User_model->getInfo('id, presenter_id, distributor_status', array('id' => $parent_user_info['presenter_id']));
    					if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
    						$divide_user_id_1 = $parent_user_info['id'];
    					}
    				}
    			}
    		}
    		$ptkj_record_id = $this->input->post('ptkj_record_id', true);
    		$ptkj_record = $this->Ptkj_record_model->get(array('ptkj_record.id' => $ptkj_record_id, 'ptkj_record.user_id' => $user_id));
    		if (empty($ptkj_record)) {
    			printAjaxError('fail', '无拼团活动');
    		}
    		if (time() > $ptkj_record['end_time']) {
    			printAjaxError('fail', '此拼团活动已过期！');
    		}
    		if (!empty($ptkj_record['order_id'])) {
    			printAjaxError('fail', '您已经下单，无需重复下单');
    		}
    		$tmp_product_info = $this->Product_model->get('postage_way_id,divide_total_ptkj,divide_store_price_ptkj,divide_school_total_ptkj,divide_school_sub_price_ptkj,divide_net_total_ptkj,divide_net_sub_price_ptkj', array('id' => $ptkj_record['product_id']));
    		if (!$tmp_product_info) {
    			printAjaxError('fail', '活动产品异常，下单失败');
    		}
    		//判断库存
    		$stock_info = $this->Product_model->getProductStock($ptkj_record['product_id'], $ptkj_record['color_id'], $ptkj_record['size_id']);
    		if ($ptkj_record['buy_number'] > $stock_info['stock']) {
    			printAjaxError('fail', '对不起，您购买的此尺码及颜色的商品库存不足');
    		}
    		//用已经存在的收货地址
    		$UserAddressInfo = $this->User_address_model->get('*', array('id' => $oDI));
    		if (!$UserAddressInfo) {
    			printAjaxError('fail', '收货人信息不存在，下单失败');
    		}
    		$buyerName = $UserAddressInfo['buyer_name'];
    		$province_id = $UserAddressInfo['province_id'];
    		$city_id = $UserAddressInfo['city_id'];
    		$area_id = $UserAddressInfo['area_id'];
    		$address = $UserAddressInfo['address'];
    		$zip = $UserAddressInfo['zip'];
    		$phone = $UserAddressInfo['phone'];
    		$mobile = $UserAddressInfo['mobile'];
    		$txt_address_str = $UserAddressInfo['txt_address'];
    		//送积分
    		$orderScore = 0;
    		//支付率费用
    		$paymentPrice = 0;
    		$area_name = '';
    		$postagePrice = 0;
    		//快递费
    		$area_info = $this->Area_model->get('name', array('id' => $province_id));
    		if (!$area_info) {
    			printAjaxError('fail', '收货人信息不存在，下单失败');
    		}
    		$area_name = $area_info['name'];
    		//分成
    		$divide_total = 0;
    		$divide_store_price = 0;
    		$divide_school_total = 0;
    		$divide_school_sub_price = 0;
    		$divide_net_total = 0;
    		$divide_net_sub_price = 0;
    		$product_number = 1;
    		//原价
    		$total = $ptkj_record['high_price'];
    		$pintuan_rule = $this->Pintuan_model->gets(array('ptkj_id' => $ptkj_record['ptkj_id']));
    		//拼团后的价格
    		foreach ($pintuan_rule as $ls) {
    			if ($ptkj_record['pintuan_people'] >= $ls['low'] && $ptkj_record['pintuan_people'] <= $ls['high']) {
    				$total = $ls['money'];
    			}
    		}
    		//砍掉的金额
    		$tmp_arr = $this->Chop_record_model->get('sum(chop_price) as sum', "chop_user_id is not null and ptkj_record_id = $ptkj_record_id and user_id = " . $user_id);
    		$choped_price = $tmp_arr['sum'] ? $tmp_arr['sum'] : 0;
    		$buy_price = $total - $choped_price;
    		//最终价格
    		$discount = '0.00';
    		//分销商购买
    		if ($distributor_info[0]) {
    			//城市合伙人
    			if ($distributor_info[1] == 1) {
    				//拼团砍价购买
    				$discount = $tmp_product_info['divide_total_ptkj'];
    			}
    			//店级合伙人
    			else if ($distributor_info[1] == 2) {
    				//拼团砍价购买
    				$discount = $tmp_product_info['divide_store_price_ptkj'];
    			}
    		}
    		$old_price = $buy_price;
    		$buy_price = $buy_price-$discount;
    		//包邮设置开启
    		$free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
    		//是否全国包邮
    		if($free_postage_setting['is_free_ac'] == 1){
    			$postagePrice = 0;
    			$postage_template_id = 0;
    		} else {
    			if (($product_number >= $free_postage_setting['product_number'] && $free_postage_setting['open_number_ac']==1) || ($old_price >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price_ac']==1)) {
    				$postagePrice = 0;
    				$postage_template_id = 0;
    			} else {
    				//判断用哪个快递－谁贵给谁的
    				$postage_template_id = $tmp_product_info['postage_way_id'];
    				$postagePrice = $this->advdbclass->get_postage_price($tmp_product_info['postage_way_id'], $area_name, $product_number);
    			}
    		}

    		$total = $buy_price * $ptkj_record['buy_number'] + $postagePrice;
    		$discount_total = $discount * $ptkj_record['buy_number'];
    		$total = number_format($total, 2, '.', '');
    		$orderNumber = $this->advdbclass->get_unique_orders_number();
    		//只有被推荐的顾客的购买才产生分成，城市合伙人、店级合伙人的购买不产生分成
    		if ($systemInfo['presenter_is_open']) {
    			//线下分成总金额
    			$divide_total = $tmp_product_info['divide_total_ptkj'] * $ptkj_record['buy_number'];
    			//店级合伙人分成金额
    			$divide_store_price = $tmp_product_info['divide_store_price_ptkj'] * $ptkj_record['buy_number'];
    			//校园分成总金额
    			$divide_school_total = $tmp_product_info['divide_school_total_ptkj'] * $ptkj_record['buy_number'];
    			//校园二级分销商分成
    			$divide_school_sub_price = $tmp_product_info['divide_school_sub_price_ptkj'] * $ptkj_record['buy_number'];
    			//网络分成总金额
    			$divide_net_total = $tmp_product_info['divide_net_total_ptkj'] * $ptkj_record['buy_number'];
    			//网络二级分销商分成
    			$divide_net_sub_price = $tmp_product_info['divide_net_sub_price_ptkj'] * $ptkj_record['buy_number'];
    		}
    		//添加订单信息
    		$fields = array(
    				'user_id' => $user_id,
    				'order_number' => $orderNumber,
    				'payment_id' => 0,
    				'payment_title' => '',
    				'payment_price' => $paymentPrice,
    				'postage_id' => 0,
    				'postage_title' => '',
    				'postage_price' => $postagePrice,
    				'total' => $total,
    				'discount_total'=>$discount_total,
    				'status' => 0,
    				'add_time' => time(),
    				'buyer_name' => $buyerName,
    				'province_id' => $province_id,
    				'city_id' => $city_id,
    				'area_id' => $area_id,
    				'txt_address' => $txt_address_str,
    				'address' => $address,
    				'zip' => $zip,
    				'phone' => $phone,
    				'mobile' => $mobile,
    				'delivery_time' => 1,
    				'remark' => '',
    				'invoice' => '',
    				'score' => $orderScore,
    				'order_type' => 1,
                    'expires' => 5 * 60 * 60,
    				'divide_total' =>           $divide_type == 'distributor'?$divide_total:0,
    				'divide_store_price' =>     $divide_type == 'distributor'?$divide_store_price:0,
    				'divide_school_total' =>    $divide_type == 'school_distributor'?$divide_school_total:0,
    				'divide_school_sub_price' =>$divide_type == 'school_distributor'?$divide_school_sub_price:0,
    				'divide_net_total' =>       $divide_type == 'net_distributor'?$divide_net_total:0,
    				'divide_net_sub_price' =>   $divide_type == 'net_distributor'?$divide_net_sub_price:0,
    				'divide_user_id_1' => $divide_user_id_1,
    				'divide_user_id_2' => $divide_user_id_2,
    				'divide_type'=>$divide_type,
    				'postage_template_id' => $postage_template_id
    		);
    		//添加订单
    		$ret = $this->Orders_model->save($fields);
    		if ($ret) {
    			/*                 * **************************添加订单详细信息*********************** */
    			$detailFields = array(
    					'order_id' => $ret,
    					'product_id' => $ptkj_record['product_id'],
    					'product_num' => '',
    					'product_title' => $ptkj_record['product_title'],
    					'buy_number' => $ptkj_record['buy_number'],
    					'buy_price' => $buy_price,
    					'old_price' => $old_price,
    					'size_name' => $ptkj_record['size_name'],
    					'size_id' => $ptkj_record['size_id'],
    					'color_name' => $ptkj_record['color_name'],
    					'color_id' => $ptkj_record['color_id'],
    					'path' => $ptkj_record['path'],
    					'divide_total' => $tmp_product_info['divide_total_ptkj'],
    					'divide_store_price' => $tmp_product_info['divide_store_price_ptkj'],
    					'divide_school_total' => $tmp_product_info['divide_school_total_ptkj'],
    					'divide_school_sub_price' => $tmp_product_info['divide_school_sub_price_ptkj'],
    					'divide_net_total' => $tmp_product_info['divide_net_total_ptkj'],
    					'divide_net_sub_price' => $tmp_product_info['divide_net_sub_price_ptkj']
    			);
    			if (!$this->Orders_detail_model->save($detailFields)) {
    				//删除已经添加进去的数据，保持数据统一性
    				$this->Orders_model->delete(array('id' => $ret, 'user_id' => $user_id));
    				printAjaxError('fail', '订单提交失败');
    			}
    			$this->Ptkj_record_model->save(array('order_id' => $ret), array('id' => $ptkj_record_id));
    			//订单跟踪记录
    			$ordersprocessFields = array(
    					'add_time' => time(),
    					'content' => "订单创建成功",
    					'order_id' => $ret
    			);
    			$this->Orders_process_model->save($ordersprocessFields);
    			printAjaxData(array('order_id' => $ret, 'order_number' => $orderNumber, 'total_price' => $total));
    		} else {
    			printAjaxError('fail', '订单提交失败');
    		}
    	}
    }

    private function _select_cart_info($user_id = NULL, $ids = '') {
    	//优惠
    	$discount_total = 0;
    	//商品
    	$product_total = 0;
    	//金象积分
    	$gold_score_total = 0;
    	//银象积分
    	$silver_score_total = 0;
    	//总金额
    	$total = 0;
    	//选定数量
    	$select_num = 0;
    	if ($ids) {
    		$cart_list = $this->Cart_model->gets("cart.id in ({$ids}) and cart.user_id = {$user_id}");
    		if ($cart_list) {
    			foreach ($cart_list as $cart) {
    				$select_num += $cart['buy_number'];
    				$product_total += $cart['buy_number']*$cart['sell_price'];
    				//银象积分
    				if ($cart['product_type'] == 'a') {
    					$silver_score_total += $cart['buy_number']*$cart['give_score'];
    				}
    				//金象积分
    				else {
    					$gold_score_total += $cart['buy_number']*$cart['give_score'];
    				}
    			}
    		}
    	}
    	$discount_total = number_format($discount_total, '2', '.', '');
    	$product_total = number_format($product_total, '2', '.', '');
    	$total = number_format($product_total - $discount_total, '2', '.', '');
    	$cart_count = $this->Cart_model->rowSum(array('user_id'=>$user_id));

    	return array('discount_total'=>$discount_total, 'silver_score_total'=>$silver_score_total, 'gold_score_total'=>$gold_score_total, 'product_total'=>$product_total, 'total'=>$total, 'cart_count'=>$cart_count, 'select_num'=>$select_num);
    }

    /*
     * 立即参团
     */
    public function add_ptkj_record() {
    	$user_id = $this->_check_login();
    	$user_info = $this->User_model->get('nickname,username', array('id' => $user_id));
    	if ($_POST) {
    		$product_id = $this->input->post('product_id');
    		$color_id = $this->input->post('color_id', TRUE);
    		$size_id = $this->input->post('size_id', TRUE);
    		$buy_number = $this->input->post('buy_number');
    		$ptkj_id = $this->input->post('ptkj_id');

    		if (!$this->form_validation->required($product_id)) {
    			printAjaxError('fail', '商品id不能为空');
    		}
    		$product_info = $this->Product_model->get('title', array('id' => $product_id, 'display' => 1));
    		if (!$product_info) {
    			printAjaxError('fail', '此产品不存在或被删除');
    		}
    		if (!$this->form_validation->required($color_id)) {
    			printAjaxError('fail', '颜色id不能为空');
    		}
    		$color_name = '';
    		$colorList = $this->Product_model->getDetailColor($product_id);
    		if ($colorList) {
    			foreach ($colorList as $key => $value) {
    				if ($value['color_id'] == $color_id) {
    					$color_name = $value['color_name'];
    					break;
    				}
    			}
    		}
    		if (!$color_name) {
    			printAjaxError('fail', '此颜色id不存在');
    		}
    		if (!$this->form_validation->required($size_id)) {
    			printAjaxError('fail', '尺码id不能为空');
    		}
    		$size_name = '';
    		$sizeList = $this->Product_model->getDetailSize($product_id);
    		if ($sizeList) {
    			foreach ($sizeList as $key => $value) {
    				if ($value['size_id'] == $size_id) {
    					$size_name = $value['size_name'];
    				}
    			}
    		}
    		if (!$size_name) {
    			printAjaxError('fail', '此尺码id不存在');
    		}
    		if (!$this->form_validation->integer($buy_number)) {
    			printAjaxError('fail', '请填写正确的购买数量');
    		}
    		if ($buy_number < 1) {
    			printAjaxError('fail', '购买数量必须大于零');
    		}
    		$item_info = $this->Product_model->getProductStock($product_id, $color_id, $size_id);
    		if ($buy_number > $item_info['stock']) {
    			printAjaxError('fail', '购买数量不能大于库存');
    		}
    		$pintuan_info = $this->Promotion_ptkj_model->get('*', array('id' => $ptkj_id));
    		if (empty($pintuan_info)) {
    			printAjaxError('fail', '没有此项参团活动');
    		}
    		if (time() > $pintuan_info['end_time'] || time() < $pintuan_info['start_time']) {
    			printAjaxError('fail', '参团活动暂未开始或已结束');
    		}
    		if ($this->Ptkj_record_model->rowCount(array('user_id' => $user_id, 'ptkj_id' => $ptkj_id)) > 0) {
    			printAjaxError('fail', '您已参加该参团活动！');
    		}
    		$fields_data = array(
    				'user_id' => $user_id,
    				'ptkj_id' => $ptkj_id,
    				'product_title' => $product_info['title'],
    				'product_id' => $product_id,
    				'size_name' => $size_name,
    				'size_id' => $size_id,
    				'color_name' => $color_name,
    				'color_id' => $color_id,
    				'buy_number' => $buy_number,
    				'add_time' => time(),
    		);
    		$retId = $this->Ptkj_record_model->save($fields_data);
    		if ($retId) {
    			$this->Promotion_ptkj_model->save(array('pintuan_people' => $pintuan_info['pintuan_people'] + 1), array('id' => $ptkj_id));
    			$count = 0;
    			//砍价总金额
    			$total = $pintuan_info['cut_total_money'];
    			// 砍价分成n次，支持n人随机砍
    			$num = $pintuan_info['cut_times'];
    			//每个人最少能砍0.01元
    			$min = 0.01;
    			for ($i = 1; $i < $num; $i++) {
    				//随机安全上限
    				$safe_total = ($total - ($num - $i) * $min) / ($num - $i);
    				$money = mt_rand($min * 100, $safe_total * 100) / 100;
    				$total = $total - $money;
    				$data = array(
    						'user_id' => $user_id,
    						'nickname' => $user_info['nickname'] ? $user_info['nickname'] : $user_info['username'],
    						'chop_price' => $money,
    						'ptkj_record_id' => $retId,
    				);
    				if ($this->Chop_record_model->save($data)) {
    					$count++;
    				}
    			}
    			$data['chop_price'] = $total;
    			if ($this->Chop_record_model->save($data)) {
    				$count++;
    			}
    			//失败回滚
    			if ($count != $num) {
    				$this->Chop_record_model->delete(array('user_id' => $user_id, 'ptkj_record_id' => $retId));
    				$this->Ptkj_record_model->delete(array('id' => $retId));
    				printAjaxError('error', '参团失败');
    			}
    			printAjaxData(array('ptkj_record_id' => $retId));
    		} else {
    			printAjaxError('error', '参团失败');
    		}
    	}
    }

    /*
     * 获取限时秒杀详情
     */

    public function get_xsms_detail($id = null) {
//     	$item_info = $this->Flash_sale_model->get('*', array('id' => $id));
//     	$sizeList = array();
//     	$colorList = array();
//     	if ($item_info) {
//     		$tmp_path = $this->_fliter_image_path($item_info['path']);
//     		$item_info['path'] = $tmp_path['path'];
//     		$item_info['path_thumb'] = $tmp_path['path_thumb'];
//     		$sizeList = $this->Product_model->getDetailSize($item_info['product_id']);
//     		if ($sizeList) {
//     			foreach ($sizeList as $key => $value) {
//     				$tmp_size_info = $this->Size_model->get('tips', array('id' => $value['size_id']));
//     				if ($tmp_size_info) {
//     					$sizeList[$key]['tips'] = $tmp_size_info['tips'];
//     				} else {
//     					$sizeList[$key]['tips'] = '';
//     				}
//     			}
//     		}
//     		$colorList = $this->Product_model->getDetailColor($item_info['product_id']);
//     		if ($colorList) {
//     			foreach ($colorList as $key => $value) {
//     				$tmp_path = $this->_fliter_image_path($value['path']);
//     				$colorList[$key]['path'] = $tmp_path['path'];
//     				$colorList[$key]['path_thumb'] = $tmp_path['path_thumb'];
//     				$tmp_color_info = $this->Color_model->get('tips', array('id' => $value['color_id']));
//     				if ($tmp_color_info) {
//     					$colorList[$key]['tips'] = $tmp_color_info['tips'];
//     				} else {
//     					$colorList[$key]['tips'] = '';
//     				}
//     			}
//     		}
//     		if ($item_info['start_time'] <= time() && $item_info['end_time'] > time()) {
//     			$item_info['status'] = 0;
//     		}
//     		if ($item_info['start_time'] > time()) {
//     			$item_info['status'] = 1;
//     		}
//     		if ($item_info['end_time'] < time()) {
//     			$item_info['status'] = 2;
//     		}
//     	}
//     	printAjaxData(array('item_info' => $item_info, 'size_list' => $sizeList, 'color_list' => $colorList));
    }

    /*
     * 限时秒杀下单
     */

    public function add_xsms_order() {
//     	$user_id = $this->_check_login();
//     	if ($_POST) {
//     		$distributor_info = get_distributor_info($user_id);
//     		$systemInfo = $this->System_model->get('presenter_is_open', array('id' => 1));
//     		//收货人地址
//     		$oDI = $this->input->post('order_delivery_info', true);
//     		$remark = $this->input->post('remark', true);
//     		$postage_template_id = 0;//$this->input->post('postage_template_id ', true);
//     		if (!$oDI) {
//     			printAjaxError('fail', "请选择收货地址");
//     		}
//     		$divide_user_id_1 = 0;
//     		$divide_user_id_2 = 0;
//     		$divide_type = '';
//     		//判断下单用户是否存在
//     		$userInfo = $this->User_model->get('*', array('user.id' => $user_id));
//     		if (!$userInfo) {
//     			printAjaxError('fail', '此用户不存在，订单提交失败');
//     		}
//     		//一级分销商
//     		if ($userInfo['distributor'] == 1 || $userInfo['school_distributor'] == 1 || $userInfo['net_distributor'] == 1) {
//     			if ($userInfo['distributor']) {
//     				$divide_type = 'distributor';
//     			} else if ($userInfo['school_distributor']) {
//     				$divide_type = 'school_distributor';
//     			} else if ($userInfo['net_distributor']) {
//     				$divide_type = 'net_distributor';
//     			}
//     			//只有正常身份才有提成拿－被禁一级不能拿
//     			if ($userInfo['distributor_status'] == 1) {
//     				//进货不做提成算，而是直接优惠掉
//     				if ($userInfo['distributor'] != 1) {
//     					$divide_user_id_1 = $userInfo['id'];
//     				}
//     			}
//     		}
//     		//二级分销商
//     		else if ($userInfo['distributor'] == 2 || $userInfo['school_distributor'] == 2 || $userInfo['net_distributor'] == 2) {
//     			if ($userInfo['distributor']) {
//     				$divide_type = 'distributor';
//     			} else if ($userInfo['school_distributor']) {
//     				$divide_type = 'school_distributor';
//     			} else if ($userInfo['net_distributor']) {
//     				$divide_type = 'net_distributor';
//     			}
//     			//只有正常身份才有提成拿－被禁，自己没有提成
//     			if ($userInfo['distributor_status'] == 1) {
//     				//进货不做提成算，而是直接优惠掉
//     				if ($userInfo['distributor'] != 2) {
//     					$divide_user_id_2 = $userInfo['id'];
//     				}
//     				//二级分销商正常有提成拿
//     				$parent_user_info = $this->User_model->getInfo('id, distributor_status', array('id' => $userInfo['presenter_id']));
//     				if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
//     					$divide_user_id_1 = $userInfo['presenter_id'];
//     				}
//     			} else {
//     				//二级分销商禁用时有提成拿
//     				if ($userInfo['distributor_status'] == 3) {
//     					$parent_user_info = $this->User_model->getInfo('id, distributor_status', array('id' => $userInfo['presenter_id']));
//     					if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
//     						$divide_user_id_1 = $userInfo['presenter_id'];
//     					}
//     				}
//     			}
//     		} else {
//     			//消费者
//     			if (!$userInfo['distributor'] && !$userInfo['school_distributor'] && !$userInfo['net_distributor']) {
//     				//根据二级分销商，查一级分销商-被禁分销商没有提成拿
//     				$parent_user_info = $this->User_model->getInfo('id, distributor,school_distributor,net_distributor, presenter_id, distributor_status', array('id' => $userInfo['presenter_id']));
//     				if ($parent_user_info) {
//     					if ($parent_user_info['distributor']) {
//     						$divide_type = 'distributor';
//     					} else if ($parent_user_info['school_distributor']) {
//     						$divide_type = 'school_distributor';
//     					} else if ($parent_user_info['net_distributor']) {
//     						$divide_type = 'net_distributor';
//     					}
//     				}
//     				if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
//     					$divide_user_id_2 = $parent_user_info['id'];
//     				}
//     				if ($parent_user_info) {
//     					$parent_user_info = $this->User_model->getInfo('id, presenter_id, distributor_status', array('id' => $parent_user_info['presenter_id']));
//     					if ($parent_user_info && $parent_user_info['distributor_status'] == 1) {
//     						$divide_user_id_1 = $parent_user_info['id'];
//     					}
//     				}
//     			}
//     		}
//     		$size_id = $this->input->post('size_id', true);
//     		$color_id = $this->input->post('color_id', true);
//     		$id = $this->input->post('id', true);
//     		$flash_info = $this->Flash_sale_model->get('*', array('id' => $id));
//     		$size_info = $this->Size_model->get('*', array('id' => $size_id));
//     		$color_info = $this->Color_model->get('*', array('id' => $size_id));
//     		if (empty($color_info)) {
//     			printAjaxError('fail', '颜色id不存在');
//     		}
//     		if (empty($size_info)) {
//     			printAjaxError('fail', '尺码id不存在');
//     		}
//     		if (empty($flash_info)) {
//     			printAjaxError('fail', '无此限时抢购活动');
//     		}
//     		if (time() < $flash_info['start_time']) {
//     			printAjaxError('fail', '此限时抢购活动暂未开始，请耐心等待');
//     		}
//     		if (time() > $flash_info['end_time']) {
//     			printAjaxError('fail', '此限时抢购活动已结束！');
//     		}

//     		//判断用户是否下单
//     		if ($this->Flash_sale_record_model->get('id', array('user_id' => $user_id, 'start_time' => $flash_info['start_time'], 'end_time' => $flash_info['end_time'], 'flash_sale_id' => $flash_info['id']))) {
//     			printAjaxError('fail', '每人仅限购一件');
//     		}
//     		//用已经存在的收货地址
//     		$UserAddressInfo = $this->User_address_model->get('*', array('id' => $oDI));
//     		if (!$UserAddressInfo) {
//     			printAjaxError('fail', '收货人信息不存在，下单失败');
//     		}
//     		$buyerName = $UserAddressInfo['buyer_name'];
//     		$province_id = $UserAddressInfo['province_id'];
//     		$city_id = $UserAddressInfo['city_id'];
//     		$area_id = $UserAddressInfo['area_id'];
//     		$address = $UserAddressInfo['address'];
//     		$zip = $UserAddressInfo['zip'];
//     		$phone = $UserAddressInfo['phone'];
//     		$mobile = $UserAddressInfo['mobile'];
//     		$txt_address_str = $UserAddressInfo['txt_address'];
//     		//送积分
//     		$orderScore = 0;
//     		//支付率费用
//     		$paymentPrice = 0;
//     		//快递费
//     		$postagePrice = 0;
//     		//分成
//     		$divide_total = 0;
//     		$divide_store_price = 0;
//     		$divide_school_total = 0;
//     		$divide_school_sub_price = 0;
//     		$divide_net_total = 0;
//     		$divide_net_sub_price = 0;
//     		$area_name = '';

//     		$product_info = $this->Product_model->get('postage_way_id, path,id,title,stock,divide_total_xsms,divide_store_price_xsms,divide_school_total_xsms,divide_school_sub_price_xsms,divide_net_total_xsms,divide_net_sub_price_xsms', array('id' => $flash_info['product_id']));
//     		$stock_info = $this->Product_model->getProductStock($product_info['id'], $color_id, $size_id);
//     		if ($stock_info['stock'] <= 0) {
//     			printAjaxError('fail', '此尺码及颜色的商品已全部售罄');
//     		}
//     		//只有被推荐的顾客的购买才产生分成，城市合伙人、店级合伙人的购买不产生分成
//     		if ($systemInfo['presenter_is_open']) {
//     			$divide_total = $product_info['divide_total_xsms'];
//     			$divide_store_price = $product_info['divide_store_price_xsms'];
//     			$divide_school_total = $product_info['divide_school_total_xsms'];
//     			$divide_school_sub_price = $product_info['divide_school_sub_price_xsms'];
//     			$divide_net_total = $product_info['divide_net_total_xsms'];
//     			$divide_net_sub_price = $product_info['divide_net_sub_price_xsms'];
//     		}
//     		$area_info = $this->Area_model->get('name', array('id' => $province_id));
//     		if (!$area_info) {
//     			printAjaxError('fail', '收货地址信息不存在');
//     		}
//     		$area_name = $area_info['name'];
//     		//包邮设置开启
//     		$free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
//     		//是否全国包邮
//     		if($free_postage_setting['is_free_ac'] == 1){
//     			$postagePrice = '0.00';
//     			$postage_template_id = 0;
//     		} else {
//     			if ((1 >= $free_postage_setting['product_number'] && $free_postage_setting['open_number_ac'] == 1) || ($flash_info['flash_sale_price'] >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price_ac'] == 1)) {
//     				$postagePrice = '0.00';
//     				$postage_template_id = 0;
//     			} else {
//     				//判断用哪个快递－谁贵给谁的
//     				$postagePrice = $this->advdbclass->get_postage_price($product_info['postage_way_id'], $area_name, 1);
//     				$postage_template_id = $product_info['postage_way_id'];
//     			}
//     		}
//     		$discount = '0.00';
//     		//分销商购买
//     		if ($distributor_info[0]) {
//     			//城市合伙人
//     			if ($distributor_info[1] == 1) {
//     				//拼团砍价购买
//     				$discount = $product_info['divide_total_xsms'];
//     			}
//     			//店级合伙人
//     			else if ($distributor_info[1] == 2) {
//     				//拼团砍价购买
//     				$discount = $product_info['divide_store_price_xsms'];
//     			}
//     		}
//     		$total = $flash_info['flash_sale_price'] + $postagePrice - $discount;
//     		$orderNumber = $this->advdbclass->get_unique_orders_number();
//     		//添加订单信息
//     		$fields = array(
//     				'user_id' => $user_id,
//     				'order_number' => $orderNumber,
//     				'payment_id' => 0,
//     				'payment_title' => '',
//     				'payment_price' => $paymentPrice,
//     				'postage_id' => 0,
//     				'postage_title' => '',
//     				'postage_price' => $postagePrice,
//     				'total' => $total,
//     				'discount_total'=>$discount,
//     				'status' => 0,
//     				'add_time' => time(),
//     				'buyer_name' => $buyerName,
//     				'province_id' => $province_id,
//     				'city_id' => $city_id,
//     				'area_id' => $area_id,
//     				'txt_address' => $txt_address_str,
//     				'address' => $address,
//     				'zip' => $zip,
//     				'phone' => $phone,
//     				'mobile' => $mobile,
//     				'delivery_time' => 1,
//     				'remark' => $remark,
//     				'invoice' => '',
//     				'score' => $orderScore,
//     				'order_type' => 2,
//     				'divide_total' =>           $divide_type == 'distributor'?$divide_total:0,
//     				'divide_store_price' =>     $divide_type == 'distributor'?$divide_store_price:0,
//     				'divide_school_total' =>    $divide_type == 'school_distributor'?$divide_school_total:0,
//     				'divide_school_sub_price' =>$divide_type == 'school_distributor'?$divide_school_sub_price:0,
//     				'divide_net_total' =>       $divide_type == 'net_distributor'?$divide_net_total:0,
//     				'divide_net_sub_price' =>   $divide_type == 'net_distributor'?$divide_net_sub_price:0,
//     				'divide_user_id_1' => $divide_user_id_1,
//     				'divide_user_id_2' => $divide_user_id_2,
//     				'divide_type'=>$divide_type,
//     				'postage_template_id' => $postage_template_id
//     		);
//     		//添加订单
//     		$ret = $this->Orders_model->save($fields);
//     		if ($ret) {
//     			/*                 * **************************添加订单详细信息*********************** */
//     			$detailFields = array(
//     					'order_id' => $ret,
//     					'product_id' => $product_info['id'],
//     					'product_num' => '',
//     					'product_title' => $product_info['title'],
//     					'buy_number' => 1,
//     					'buy_price' => $flash_info['flash_sale_price']-$discount,
//     					'old_price' => $flash_info['flash_sale_price'],
//     					'size_name' => $size_info['size_name'],
//     					'size_id' => $size_id,
//     					'color_name' => $color_info['color_name'],
//     					'color_id' => $color_id,
//     					'path' => $product_info['path'],
//     					'divide_total' => $product_info['divide_total_xsms'],
//     					'divide_store_price' => $product_info['divide_store_price_xsms'],
//     					'divide_school_total' => $product_info['divide_school_total_xsms'],
//     					'divide_school_sub_price' => $product_info['divide_school_sub_price_xsms'],
//     					'divide_net_total' => $product_info['divide_net_total_xsms'],
//     					'divide_net_sub_price' => $product_info['divide_net_sub_price_xsms']
//     			);
//     			if (!$this->Orders_detail_model->save($detailFields)) {
//     				//删除已经添加进去的数据，保持数据统一性
//     				$this->Orders_model->delete(array('id' => $ret, 'user_id' => $user_id));
//     				printAjaxError('fail', '订单提交失败');
//     			}
//     			$data = array(
//     					'user_id' => $user_id,
//     					'start_time' => $flash_info['start_time'],
//     					'end_time' => $flash_info['end_time'],
//     					'flash_sale_id' => $flash_info['id'],
//     					'order_id' => $ret,
//     					'add_time' => time(),
//     			);
//     			$this->Flash_sale_record_model->save($data);
//     			//订单跟踪记录
//     			$ordersprocessFields = array(
//     					'add_time' => time(),
//     					'content' => "订单创建成功",
//     					'order_id' => $ret
//     			);
//     			$this->Orders_process_model->save($ordersprocessFields);
//     			printAjaxData(array('order_id' => $ret, 'order_number' => $orderNumber, 'total_price' => $total));
//     		} else {
//     			printAjaxError('fail', '订单提交失败');
//     		}
//     	}
    }

    //运费
    public function get_postage_way_list() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$address_id = $this->input->post('address_id', TRUE);
    		$cart_ids = trim($this->input->post('cart_ids', TRUE), ',');

    		$total_money = 0.00;
    		$product_number = 0;
    		$postage_way_ids = '';//商品的快递模板
    		$area_name = '';//默认配送地区

    		if (!$address_id) {
    			printAjaxError('fail', '请选择收货地址');
    		}
    		if (!$cart_ids) {
    			printAjaxError('fail', '购物车中没有商品，请选购商品');
    		}
    		$cartList = $this->Cart_model->gets("cart.user_id = {$user_id} and cart.id in ({$cart_ids})");
    		if (!$cartList) {
    			printAjaxError('fail', '购物车中没有商品，请选购商品');
    		}
    		$user_address_info = $this->User_address_model->get('province_id', array('user_id' => $user_id, 'id' => $address_id));
    		if (!$user_address_info) {
    			printAjaxError('fail', '收货地址信息不存在');
    		}
    		$area_info = $this->Area_model->get('name', array('id' => $user_address_info['province_id']));
    		if ($area_info) {
    			$area_name = $area_info['name'];
    		}
    		foreach ($cartList as $key=>$value) {
    			$postage_way_ids .= $value['postage_way_id'].',';

    			$product_number += $value['buy_number'];
    			$total_money += $value['sell_price'] * $value['buy_number'];
    		}
    		if ($postage_way_ids) {
    			$postage_way_ids = substr($postage_way_ids, 0, -1);
    		}
    		$postage_way = NULL;
    		//包邮设置开启
    		$free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
    		//是否全国包邮
    		if($free_postage_setting['is_free'] == 1){
    			$postage_way = array(
    					0 => array(
    							'id' => 0,
    							'title' => '全国包邮',
    							'content' => '',
    							'postage_price' => '0.00',
    					)
    			);
    		} else {
    			if (($product_number >= $free_postage_setting['product_number'] && $free_postage_setting['open_number']==1) || ($total_money >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price']==1)) {
    				$postage_way = array(
    						0 => array(
    								'id' => 0,
    								'title' => '包邮（已满'.$free_postage_setting['product_number'].'件或已满'.$free_postage_setting['free_postage_price'].'元）',
    								'content' => '',
    								'postage_price' => '0.00',
    						)
    				);
    			} else {
    				//判断用哪个快递－谁贵给谁的
    				$postage_way_list = $this->Postage_way_model->gets('*', "id in ({$postage_way_ids})");
    				if ($postage_way_list) {
    					$max_postage_price = 0;
    					$max_key = 0;
    					foreach ($postage_way_list as $key=>$value) {
    						$tmp_postage_price = $this->advdbclass->get_postage_price($value['id'], $area_name, $product_number);
    						if ($tmp_postage_price >$max_postage_price) {
    							$max_postage_price = $tmp_postage_price;
    							$max_key = $key;
    						}
    					}
    					$postage_way[0] = $postage_way_list[$max_key];
    					$postage_way[0]['postage_price'] = $max_postage_price;
    				}
    			}
    		}
    		printAjaxData($postage_way);
    	}
    }

    //拼团砍价配送方式
    public function get_ptkj_postage() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$address_id = $this->input->post('address_id', TRUE);
    		$ptkj_record_id = $this->input->post('ptkj_record_id', TRUE);

    		$product_number = 1;
    		$area_name = '';
    		if (!$address_id) {
    			printAjaxError('fail', '请选择收货地址');
    		}
    		if (!$ptkj_record_id) {
    			printAjaxError('fail', '操作异常');
    		}
    		$ptkj_record = $this->Ptkj_record_model->get(array('ptkj_record.id ' => $ptkj_record_id));
    		if (!$ptkj_record) {
    			printAjaxError('false', '不存在此拼团砍价信息');
    		}
    		$product_info = $this->Product_model->get('postage_way_id', array('id'=>$ptkj_record['product_id']));
    		if (!$product_info) {
    			printAjaxError('false', '活动商品信息不存在');
    		}
    		$user_address = $this->User_address_model->get('province_id', array('user_id' => $user_id, 'id' => $address_id));
    		if (!$user_address) {
    			printAjaxError('fail', '收货地址信息不存在');
    		}
    		$pintuan_info = $this->Promotion_ptkj_model->get('pintuan_people', array('id' => $ptkj_record['ptkj_id']));
    		$pintuan_rule = $this->Pintuan_model->gets(array('ptkj_id' => $ptkj_record['ptkj_id']));
    		$chop_arr = $this->Chop_record_model->get('sum(chop_price) as sum', "user_id = {$ptkj_record['user_id']} and ptkj_record_id = $ptkj_record_id and chop_user_id is not null");
    		$choped_price = $chop_arr['sum'] ? $chop_arr['sum'] : '0.00';
    		$pintuan_price = 0;
    		foreach ($pintuan_rule as $ls) {
    			$arr[] = $ls['money'];
    			if ($pintuan_info['pintuan_people'] >= $ls['low'] && $pintuan_info['pintuan_people'] <= $ls['high']) {
    				$pintuan_price = number_format($ls['money'], 2);
    			}
    		}
    		$total_money = $pintuan_price - $choped_price;
    		//配送方式
    		$area_info = $this->Area_model->get('name', array('id' => $user_address['province_id']));
    		if (!$area_info) {
    			printAjaxError('fail', '收货地址信息不存在');
    		}
    		$area_name = $area_info['name'];
    		$postage_way = NULL;
    		//包邮设置开启
    		$free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
    		//是否全国包邮
    		if($free_postage_setting['is_free_ac'] == 1){
    			$postage_way = array(
    					0 => array(
    							'id' => 0,
    							'title' => '全国包邮',
    							'content' => '',
    							'postage_price' => '0.00',
    					)
    			);
    		} else {
    			if (($product_number >= $free_postage_setting['product_number'] && $free_postage_setting['open_number_ac']==1) || ($total_money >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price_ac']==1)) {
    				$postage_way = array(
    						0 => array(
    								'id' => 0,
    								'title' => '包邮（已满'.$free_postage_setting['product_number'].'件或已满'.$free_postage_setting['free_postage_price'].'元）',
    								'content' => '',
    								'postage_price' => '0.00',
    						)
    				);
    			} else {
    				//判断用哪个快递－谁贵给谁的
    				$postage_way_info = $this->Postage_way_model->get('*', array('id'=>$product_info['postage_way_id']));
    				if (!$postage_way_info) {
    					printAjaxError('fail', '配送方式不存在');
    				}
    				$postage_way_info['postage_price'] = $this->advdbclass->get_postage_price($postage_way_info['id'], $area_name, $product_number);
    				$postage_way = array('0'=>$postage_way_info);
    			}
    		}
    		printAjaxData($postage_way);
    	}
    }

    public function get_xsqg_postage() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$address_id = $this->input->post('address_id', TRUE);
    		$flash_sale_id = $this->input->post('flash_sale_id', TRUE);
    		$buy_number = $this->input->post('buy_number', TRUE);

    		$area_name = '';
    		if (!$address_id) {
    			printAjaxError('fail', '请选择收货地址');
    		}
    		if (!$flash_sale_id) {
    			printAjaxError('fail', '操作异常');
    		}
    		$flash_sale_info = $this->Flash_sale_model->get('*', array('id ' => $flash_sale_id));
    		if (!$flash_sale_info) {
    			printAjaxError('false', '不存在此限时抢购活动');
    		}
    		$product_info = $this->Product_model->get('postage_way_id', array('id'=>$flash_sale_info['product_id']));
    		if (!$product_info) {
    			printAjaxError('false', '活动商品信息不存在');
    		}
    		$user_address = $this->User_address_model->get('province_id', array('user_id' => $user_id, 'id' => $address_id));
    		if (!$user_address) {
    			printAjaxError('fail', '用户收货地址不存在');
    		}
    		$area_info = $this->Area_model->get('name', array('id' => $user_address['province_id']));
    		if (!$area_info) {
    			printAjaxError('fail', '用户收货地址不存在');
    		}
    		$area_name = $area_info['name'];

    		$postage_way = NULL;
    		//包邮设置开启
    		$free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
    		//是否全国包邮
    		if($free_postage_setting['is_free_ac'] == 1){
    			$postage_way = array(
    					0 => array(
    							'id' => 0,
    							'title' => '全国包邮',
    							'content' => '',
    							'postage_price' => '0.00',
    					)
    			);
    		} else {
    			if (($buy_number >= $free_postage_setting['product_number'] && $free_postage_setting['open_number_ac'] == 1) || ($flash_sale_info['flash_sale_price'] >= $free_postage_setting['free_postage_price'] && $free_postage_setting['open_price_ac'] == 1)) {
    				$postage_way = array(
    						0 => array(
    								'id' => 0,
    								'title' => '包邮（已满'.$free_postage_setting['product_number'].'件或已满'.$free_postage_setting['free_postage_price'].'元）',
    								'content' => '',
    								'postage_price' => '0.00',
    						)
    				);
    			} else {
    				//判断用哪个快递－谁贵给谁的
    				$postage_way_info = $this->Postage_way_model->get('*', array('id'=>$product_info['postage_way_id']));
    				if (!$postage_way_info) {
    					printAjaxError('fail', '配送方式不存在');
    				}
    				$postage_way_info['postage_price'] = $this->advdbclass->get_postage_price($postage_way_info['id'], $area_name, $buy_number);
    				$postage_way = array('0'=>$postage_way_info);
    			}
    		}
    		printAjaxData($postage_way);
    	}
    }

    //提醒发货
    public function remind_deliver_goods() {
    	$user_id = $this->_check_login();
        if ($_POST) {
            $order_id = $this->input->post('order_id', true);
            if (!$order_id) {
            	printAjaxError('fail', '操作异常');
            }
            $order_info = $this->Orders_model->get('*', array('id' => $order_id, 'user_id'=>$user_id));
            if (!$order_info) {
            	printAjaxError('fail', '此订单信息不存在');
            }
            if ($order_info['status'] != 1) {
                printAjaxError('fail', '必须是已付款的订单才可以提醒发货');
            }
            $current_time = strtotime(date('Y-m-d 00:00:00'));
            if ($this->Message_model->rowCount("from_user_id = {$user_id} and map_id = {$order_info['id']} and message_type = 'order' and add_time > {$current_time}")) {
                printAjaxError('fail', '每个订单一天内只能提醒一次');
            }
            $fields = array(
            		'message_type' => 'order',
            		'to_user_id' => 0,
            		'from_user_id' => $user_id,
            		'content' => "订单{$order_info['order_number']}已付款，请及时发货",
            		'map_id'=>$order_info['id'],
            		'add_time' => time()
                );
            $this->Message_model->save($fields);
            printAjaxSuccess('success', '发货提醒发送成功');
        }
    }

    //设置支付密码--取消
    public function set_pay_password() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$new_pay_password = $this->input->post('new_password');
    		$pay_password = $this->input->post('con_password');

    		$user_info = $this->User_model->get('pay_password,add_time,username,password', array('id' => $user_id));
    		if ($new_pay_password != $pay_password) {
    			printAjaxError('fail', '支付密码前后不一致');
    		}
    		if (strlen($pay_password) < 6 || strlen($pay_password) > 20) {
    			printAjaxError('fail', '支付密码长度6~20位');
    		}
    		if (preg_match("/\s/", $pay_password)) {
    			printAjaxError('fail', '支付密码不能包含空格');
    		}
    		$pay_password = $this->User_model->getPasswordSalt($user_info['username'], $pay_password);
    		$result = $this->User_model->save(array('pay_password' => $pay_password), array('id' => $user_id));
    		if ($result) {
    			printAjaxSuccess('success', '支付密码设置成功');
    		}
    		printAjaxError('fail', '支付密码设置失败');
    	}
    }

    //修改支付密码
    public function change_pay_password(){
    	if ($_POST) {
    		$user_id = $this->_check_login();
    		$old_pay_password = $this->input->post('old_pay_password');
    		$new_pay_password = $this->input->post('new_password');
    		$pay_password = $this->input->post('con_password');
    		$user_info = $this->User_model->get('pay_password,add_time,username,password', array('id' => $user_id));
    		if ($this->User_model->getPasswordSalt($user_info['username'], $old_pay_password) != $user_info['pay_password']) {
    			printAjaxError('fail', '原支付密码错误');
    		}
    		if ($new_pay_password != $pay_password) {
    			printAjaxError('fail', '支付密码前后不一致');
    		}
    		if (strlen($pay_password) < 6 || strlen($pay_password) > 20) {
    			printAjaxError('fail', '支付密码长度6~20位');
    		}
    		if (preg_match("/\s/", $pay_password)) {
    			printAjaxError('fail', '支付密码不能包含空格');
    		}
    		$pay_password = $this->User_model->getPasswordSalt($user_info['username'], $pay_password);
    		$result = $this->User_model->save(array('pay_password' => $pay_password), array('id' => $user_id));
    		if ($result) {
    			printAjaxSuccess('success', '支付密码修改成功');
    		}
    		printAjaxError('fail', '支付密码修改失败');
    	}
    }

    //检测支付密码是否正确
    public function check_pay_password() {
    	if ($_POST) {
    		$user_id = $this->_check_login();
    		$pay_password = $this->input->post('pay_password');

    		$user_info = $this->User_model->getInfo('id, username, pay_password, add_time');
    		if ($this->User_model->getPasswordSalt($user_info['username'], $pay_password) != $user_info['pay_password']) {
    			printAjaxError('fail', '您的支付密码错误，请重新输入');
    		}
    		printAjaxSuccess('success', '支付密码输入成功');
    	}
    }



    public function bind_pop_cod() {
    	$user_id = $this->_check_login();
    	if ($_POST) {
    		$pop_code = trim($this->input->post('pop_code', TRUE));

    		$userInfo = $this->User_model->get('id, username, score, pop_code, presenter_id, presenter_username', array('user.id' => $user_id));
    		if (!$pop_code) {
    			printAjaxError('fail', '请填写邀请码');
    		}
    		if ($userInfo['presenter_id']) {
    			printAjaxError('fail', '邀请码已绑定过，不用重复绑定');
    		}
    		$cur_user_info = $this->User_model->getInfo('id, username, pop_code, distributor, school_distributor, net_distributor', array('pop_code' => $pop_code));
    		if (!$cur_user_info) {
    			printAjaxError('fail', '此邀请码不存在');
    		}
    		if ($cur_user_info['distributor'] != 2 && $cur_user_info['school_distributor'] != 2 && $cur_user_info['net_distributor'] != 2) {
    			printAjaxError('fail', '此邀请码对应的分销商身份不正确，请更换邀请码试下');
    		}
    		$fields = array(
    				'presenter_id' => $cur_user_info['id'],
    				'presenter_username' => $cur_user_info['username'],
    				'remark_time' => time()
    		);
    		if (!$this->User_model->save($fields, array('id' => $user_id))) {
    			printAjaxError('fail', '邀请码绑定失败');
    		}
    		$score = 0;
    		$score_type = '';
    		$score_setting_info = $this->Score_setting_model->get('store_score, school_score, net_score', array('id' => 1));
    		if ($cur_user_info['distributor'] == 2) {
    			$score = $score_setting_info['store_score'];
    			$score_type = 'store_score_in';
    		} else if ($cur_user_info['school_distributor'] == 2) {
    			$score = $score_setting_info['school_score'];
    			$score_type = 'school_score_in';
    		} else if ($cur_user_info['net_distributor'] == 2) {
    			$score = $score_setting_info['net_score'];
    			$score_type = 'net_score_in';
    		}
    		if (!$this->Score_model->rowCount(array('type' => $score_type, 'user_id' => $userInfo['id']))) {
    			if ($this->User_model->save(array('score' => $userInfo['score'] + $score), array('id' => $userInfo['id']))) {
    				$sFields = array(
    						'cause' => '推广消费者入驻-送积分',
    						'score' => $score,
    						'balance' => $userInfo['score'] + $score,
    						'type' => $score_type,
    						'add_time' => time(),
    						'username' => $userInfo['username'],
    						'user_id' => $userInfo['id'],
    						'ret_id' => $cur_user_info['id']
    				);
    				$this->Score_model->save($sFields);
    			}
    		}
    		printAjaxSuccess('success', '绑定邀请码成功，积分已打到你的账户，请在“我的资产”－〉“我的积分”查看');
    	}
    }

    public function get_presenter_info() {
    	$user_id = $this->_check_login();
    	$user_info = $this->User_model->getinfo('id,distributor,school_distributor,net_distributor', "id = {$user_id}");
    	if (!$user_info) {
    		printAjaxError('fail', '此用户信息不存在');
    	}
    	//我的总提成
    	$total = $this->Financial_model->get_Total(array('type' => 'presenter_in', 'user_id' => $user_id));
    	//当月提成
    	$cur_month = date('Y-m', time());
    	$cur_total = $this->Financial_model->get_Total("type = 'presenter_in' and user_id = {$user_id} and FROM_UNIXTIME(add_time,'%Y-%m') = '{$cur_month}' ");
    	//上月提成
    	$prv_month = date('Y-m', strtotime('-1 month'));
    	$prv_total = $this->Financial_model->get_Total("type = 'presenter_in' and user_id = {$user_id} and FROM_UNIXTIME(add_time,'%Y-%m') = '{$prv_month}' ");

    	$is_distributor = 0;
    	$distributor_type_name = '';
    	if ($user_info['distributor']) {
    		$is_distributor = 1;
    		$distributor_type_name = $this->_distributor_arr[$user_info['distributor']];
    	} else if ($user_info['school_distributor']) {
    		$is_distributor = 1;
    		$distributor_type_name = $this->_school_distributor_arr[$user_info['school_distributor']];
    	} else if ($user_info['school_distributor']) {
    		$is_distributor = 1;
    		$distributor_type_name = $this->_net_distributor_arr[$user_info['school_distributor']];
    	}
    	$presenter_path = base_url()."index.php/userapi/get_presenter_path";
    	printAjaxData(array('total' => $total, 'cur_total' => $cur_total, 'prv_total' => $prv_total, 'presenter_path' => $presenter_path, 'is_distributor' => $is_distributor, 'distributor_type_name' => $distributor_type_name));
    }

    public function get_presenter_path() {
    	$user_id = $this->_check_login();
    	$user_info = $this->User_model->getinfo('id,pop_code,path', "id = {$user_id}");
    	$image_arr = $this->_fliter_image_path($user_info['path']);

    	$image = get_qrcode_logo(base_url().getBaseUrl(false, "t/i", "t/i", 'index.php').'/'.$user_info['pop_code'].'.html', $image_arr['path_thumb']);
    	header("Content-type:image/png");
    	imagepng($image);
    	imagedestroy($image);
    }

    public function get_qr_wx_code($user_id = 35, $flush = 1) {
    	//判断是否登录
    	$systemInfo = $this->System_model->get('client_index', array('id' => 1));
    	$userInfo = $this->User_model->get('ad_text, nickname, username, path, pop_code', array('id' => $user_id));
    	$nickname = $userInfo['nickname'] ? $userInfo['nickname'] : $userInfo['username'];
    	$url = base_url() . getBaseUrl(false, "t/i", "t/i", $systemInfo['client_index']) . '/' . $userInfo['pop_code'] . '.html';
    	$image_arr = fliter_image_path($userInfo['path']);
    	$path = $image_arr['path_thumb'];

    	$this->_qr_code_1($nickname, $path, $url);
    }

    private function _qr_code_1($nickname = '', $path = '', $url = '', $is_download = false) {
    	//建立一幅100*30的图像
    	$image = @imagecreatefrompng('./images/default/qr_wx_1.png');
    	imagesavealpha($image, true);
    	$bg_w = imagesx($image);
    	$bg_h = imagesy($image);
    	//设置字体颜色
    	$text_color = imagecolorallocate($image, 208, 163, 98);
    	$font = "./ttfs/dfheiw5-a320.ttf";
    	$text = $nickname;
    	imagettftext($image, 32, 0, 128, 75, $text_color, $font, $text);
    	//生成头像小图
    	if ($path) {
    		$src_img = $this->_create_circle($path, 74, 74);
    		$src_w = imagesx($src_img);
    		$src_h = imagesy($src_img);
    		imagecopyresampled($image, $src_img, ($bg_w - 74) / 2 - 265, 86 - 60, 0, 0, 74, 74, $src_w, $src_h);
    		imagedestroy($src_img);
    	}
    	//二维码图
    	$qr_image = get_qrcode($url, 8);
    	$src_w = imagesx($qr_image);
    	$src_h = imagesy($qr_image);
    	imagecopyresampled($image, $qr_image, 206, 664, 0, 0, 260, 260, $src_w, $src_h);
    	imagedestroy($qr_image);
    	//输出图像
    	if ($is_download == true) {
    		header('Content-Description: File Transfer');
    		header('Content-Type: application/octet-stream');
    		header('Content-Disposition: attachment; filename="qr.png"');
    		header('Expires: 0');
    		header('Cache-Control: must-revalidate');
    		header('Pragma: public');
    		imagepng($image);
    		imagedestroy($image);
    	} else {
    		header("Content-type:image/png");
    		imagepng($image);
    		imagedestroy($image);
    	}
    }

    private function _get_bbox($text, $font_size = 20) {
    	return imagettfbbox($font_size, 0, "./ttfs/dfheiw5-a320.ttf", $text);
    }

    private function _text_height($text, $font_size = 20) {
    	$box = $this->_get_bbox($text, $font_size);
    	$height = $box[3] - $box[5];
    	return $height;
    }

    private function _text_width($text, $font_size = 20) {
    	$box = $this->_get_bbox($text, $font_size);
    	$width = $box[4] - $box[6];
    	return $width;
    }

    private function _create_circle($imgpath = NULL, $w = 74, $h = 74) {
    	$im = imagecreatefromstring(file_get_contents($imgpath));
    	$src_w = imagesx($im); //获取大图片宽度
    	$src_h = imagesy($im); //获取大图片高度
    	$src_img = imagecreatetruecolor($w, $h); //创建缩略图
    	$alpha = imagecolorallocatealpha($src_img, 0, 0, 0, 127);
    	imagefill($src_img, 0, 0, $alpha);
    	imagecopyresampled($src_img, $im, 0, 0, 0, 0, $w, $h, $src_w, $src_h); //复制图像并改变大小
    	imagedestroy($im);

    	//画圆
    	$newpic = imagecreatetruecolor($w, $h);
    	imagesavealpha($newpic, true);
    	imagealphablending($newpic, false);
    	$transparent = imagecolorallocatealpha($newpic, 0, 0, 0, 127);
    	$r = $w / 2;
    	for ($x = 0; $x < $w; $x++) {
    		for ($y = 0; $y < $h; $y++) {
    			$c = imagecolorat($src_img, $x, $y);
    			$_x = $x - $w / 2;
    			$_y = $y - $h / 2;
    			if ((($_x * $_x) + ($_y * $_y)) < ($r * $r)) {
    				imagesetpixel($newpic, $x, $y, $c);
    			} else {
    				imagesetpixel($newpic, $x, $y, $transparent);
    			}
    		}
    	}

    	return $newpic;
    }

    public function radius_img($imgpath = './t.png', $w = '', $h = '', $radius = 10) {
    	$im = imagecreatefromstring(file_get_contents($imgpath));
    	$src_w = imagesx($im); //获取大图片宽度
    	$src_h = imagesy($im); //获取大图片高度
    	$src_img = imagecreatetruecolor($w, $h); //创建缩略图
    	$alpha = imagecolorallocatealpha($src_img, 0, 0, 0, 127);
    	imagefill($src_img, 0, 0, $alpha);
    	imagecopyresampled($src_img, $im, 0, 0, 0, 0, $w, $h, $src_w, $src_h); //复制图像并改变大小
    	imagedestroy($im);

    	$img = imagecreatetruecolor($w, $h);
    	//这一句一定要有
    	imagesavealpha($img, true);
    	//拾取一个完全透明的颜色,最后一个参数127为全透明
    	$bg = imagecolorallocatealpha($img, 228, 0, 127, 127);
    	imagefill($img, 0, 0, $bg);
    	$r = $radius; //圆 角半径
    	for ($x = 0; $x < $w; $x++) {
    		for ($y = 0; $y < $h; $y++) {
    			$rgbColor = imagecolorat($src_img, $x, $y);
    			if (($x >= $radius && $x <= ($w - $radius)) || ($y >= $radius && $y <= ($h - $radius))) {
    				//不在四角的范围内,直接画
    				imagesetpixel($img, $x, $y, $rgbColor);
    			} else {
    				//在四角的范围内选择画
    				//上左
    				$y_x = $r; //圆心X坐标
    				$y_y = $r; //圆心Y坐标
    				if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
    					imagesetpixel($img, $x, $y, $rgbColor);
    				}
    				//上右
    				$y_x = $w - $r; //圆心X坐标
    				$y_y = $r; //圆心Y坐标
    				if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
    					imagesetpixel($img, $x, $y, $rgbColor);
    				}
    				//下左
    				$y_x = $r; //圆心X坐标
    				$y_y = $h - $r; //圆心Y坐标
    				if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
    					imagesetpixel($img, $x, $y, $rgbColor);
    				}
    				//下右
    				$y_x = $w - $r; //圆心X坐标
    				$y_y = $h - $r; //圆心Y坐标
    				if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
    					imagesetpixel($img, $x, $y, $rgbColor);
    				}
    			}
    		}
    	}

    	return $img;
    }

    /**
     * 退出登录
     */
    public function logout() {
    	$this->_check_login();
    	$this->_delete_session();
    	printAjaxSuccess('success', '退出成功');
    }

    public function update() {
    	if ($_POST) {
    		$platform = $this->input->post('platform', TRUE);
    		$version = $this->input->post('version', TRUE);
    		$wget_version = $this->input->post('wget_version', TRUE);

    		$ret = array('is_update' => 0, 'update_url' => '');
    		$item_info = $this->System_model->get('wget_version, wget_url, android_full_update_version, android_full_update_url, ios_full_update_version, ios_full_update_url', array('id' => 1));
    		if ($platform == 'ios') {
    			if ($item_info['ios_full_update_version'] > $version) {
    				$ret['is_update'] = 1;
    				$ret['update_url'] = $item_info['ios_full_update_url'];
    			} else {
    				if ($item_info['wget_version'] > $wget_version) {
    					$ret['is_update'] = 2;
    					$ret['update_url'] = $item_info['wget_url'];
    				}
    			}
    		} else if ($platform == 'android') {
    			if ($item_info['android_full_update_version'] > $version) {
    				$ret['is_update'] = 1;
    				$ret['update_url'] = $item_info['android_full_update_url'];
    			} else {
    				if ($item_info['wget_version'] > $wget_version) {
    					$ret['is_update'] = 2;
    					$ret['update_url'] = $item_info['wget_url'];
    				}
    			}
    		}
    		printAjaxData($ret);
    	}
    }
    //手机扫一扫下载app
    public function download_app(){
    	$item_info = $this->System_model->get('wget_version, wget_url, android_full_update_version, android_full_update_url, ios_full_update_version, ios_full_update_url', array('id' => 1));
    	if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
    		redirect($item_info['ios_full_update_url']);
    	}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
    		redirect($item_info['android_full_update_url']);
    	}else{
    		redirect($item_info['android_full_update_url']);
    	}
    }


    private function send_sms($mobile = NULL, $sms_txt = NULL) {
        $sUrl = 'http://api.qirui.com:7891/mt'; // 接入地址
        $apiKey = '1062030012';    // 请替换为你的帐号编号
        $apiSecret = '5cb005fddc64e0905b8d';  // 请替换为你的帐号密钥
        $nCgid = 1221;   // 请替换为你的通道组编号
        $sMobile = $mobile;    // 请替换为你的手机号码
        $sContent = $sms_txt;   // 请把数字替换为其他4~10位的数字测试，如需测试其他内容，请先联系客服报备发送模板
        $nCsid = 0;    // 签名编号 ,可以为空时，使用系统默认的编号
        $data = array('un' => $apiKey, 'pw' => $apiSecret, 'da' => $sMobile, 'sm' => $sContent,'dc' => 15,'tf' => 3,'rf' => 1,);  //定义参数
        $data = @http_build_query($data);        //把参数转换成URL数据
        $xml = file_get_contents($sUrl . '?' . $data);  // 发送请求
        $xml_val = $this->xmlToArray($xml);
        return $xml_val;
    }

    private function xmlToArray($xml) {
    	//禁止引用外部xml实体
    	libxml_disable_entity_loader(true);
    	$xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    	$val = json_decode(json_encode($xmlstring), true);
    	return $val;
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

    private function _check_login() {
    	if (!$this->session->userdata("user_id")) {
    		printAjaxError('login', '请登录');
    	}
    	$user_id = $this->session->userdata("user_id");
    	//		$item_info = $this->User_model->get('display', array('id'=>$user_id));
    	//		if (!$item_info) {
    	//			printAjaxError('fail', '此账号不存在或被删除');
    	//		}
    	//	    if ($item_info['display'] == 0) {
    	//		    printAjaxError('fail', '你的账户还未激活，请先激活账户或联系管理员激活');
    	//		} else if ($item_info['display'] == 2) {
    	//		    printAjaxError('fail', '你的账户被冻结，请联系管理员或者网站客服');
    	//		}

    	return $user_id;
    }

    /*
     * 获取产品分类
     */
    public function get_category_list() {
        $item_list =  $this->Product_category_model->menuTree();
        if($item_list){
            foreach($item_list as $key=>$item){
                $tmp_image_arr = $this->_fliter_image_path($item['path']);
                $item_list[$key]['path'] = $tmp_image_arr['path'];
                $item_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
                $tmp_image_arr = $this->_fliter_image_path($item['big_path']);
                $item_list[$key]['big_path'] = $tmp_image_arr['path'];
                $item_list[$key]['big_path_thumb'] = $tmp_image_arr['path_thumb'];
                if($item['subMenuList']){
                     foreach($item['subMenuList'] as $subkey=>$subitem){
                         $tmp_image_arr = $this->_fliter_image_path($subitem['path']);
                         $item_list[$key]['subMenuList'][$subkey]['path'] = $tmp_image_arr['path'];
                         $item_list[$key]['subMenuList'][$subkey]['path_thumb'] = $tmp_image_arr['path_thumb'];
                    }
                }
            }
        }
        printAjaxData(array('item_list' => $item_list));
    }

    /**
     * 产品列表
     *
     * @param number $max_id     若指定此参数，则返回ID小于或等于max_id的信息,相当于more
     * @param number $since_id   获取最新信息,相当于下拉刷新
     * @param number $per_page   每页数
     * @param number $page       页数
     */
    public function get_product_list($max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
        $category_id = 0;
        $category_type = 0;
        $brand_id = 0;
        $size_id = 0;
        $keyword = '';
        $order = '';
        $by = '';
        $attribute = '';
        if ($_POST) {
            $category_id = $this->input->post('category_id', true);
            $category_type = $this->input->post('category_type', true);
            $brand_id = $this->input->post('brand_id', true);
            $size_id = $this->input->post('size_id', true);
            $order = $this->input->post('order', true);
            $by = $this->input->post('by', true);
            $keyword = $this->input->post('keyword', true);
            $attribute = $this->input->post('attribute', true);
        }
        $strWhere = "display = 1 ";
        if ($category_id) {
            //判断category_id是否是顶级分类
            $category = $this->Product_category_model->get('parent_id,id,product_category_name', "id = $category_id");
            $categorys_name = $category['product_category_name'];
            if (!$category) {
                $category_ids = 0;
            } else {
                $category_ids = $category_id;

                //表示顶级分类
                if ($category['parent_id'] == 0) {
//                    if ($category_type == 'all') {
//                        $categorys = $this->Product_category_model->gets("parent_id = $category_id");
//                    } else {
//                        $categorys = $this->Product_category_model->gets("parent_id = $category_id and find_in_set({$category_type},category_type)");
//                    }
//
                    $categorys = $this->Product_category_model->gets("parent_id = $category_id");
                    foreach ($categorys as $item) {
                        $category_ids .= ','.$item['id'];
                    }
                }
                $category_ids = trim($category_ids, ',');
            }

            $strWhere .= " and id in (select product_id from product_category_ids where product_category_id in ({$category_ids})) ";
        }else{
              $where = $category_type ? "id > 0 and find_in_set({$category_type},category_type)" : "id > 0 ";
                    $categorys = $this->Product_category_model->gets($where);
                    $category_ids = '';
                    foreach ($categorys as $item) {
                        $category_ids .= $item['id'] . ',';
                    }
                    $category_ids = trim($category_ids, ',');
                    if (empty($category_ids)) {
                        $category_ids = 0;
                    }
                    $strWhere .= " and id in (select product_id from product_category_ids where product_category_id in ({$category_ids})) ";
        }
        if ($brand_id) {
            $brand_info = $this->Brand_model->get('brand_name',array('id'=>$brand_id));
            if ($brand_info) {
                $brand_name = $brand_info['brand_name'];
                $strWhere .= " and brand_name regexp '{$brand_name}' ";
            }
        }
        if ($since_id) {
            $strWhere .= " and product.id > {$since_id} ";
        }
        if ($max_id) {
            $strWhere .= " and product.id <= {$max_id} ";
        }
        if ($keyword) {
            $strWhere .= " and (title like '%{$keyword}%' or keyword like '%{$keyword}%' )";
        }
        if ($attribute) {
            $strWhere .= " and find_in_set('{$attribute}',custom_attribute)";
        }
        if ($order && $by) {
            $item_list = $this->Product_model->gets('product.id,product.title,product.sell_price,product.favorite_num,product.path,product.abstract,product.market_price,product.sales', $strWhere, $per_page, $per_page * ($page - 1), $order, $by);
        } else {
            $item_list = $this->Product_model->gets('product.id,product.title,product.sell_price,product.favorite_num,product.path,product.abstract,product.market_price,product.sales', $strWhere, $per_page, $per_page * ($page - 1), 'id');
        }

        if ($item_list) {
            foreach ($item_list as $key => $item) {
                $tmp_image_arr = $this->_fliter_image_path($item['path']);
                $item_list[$key]['path'] = $tmp_image_arr['path'];
                $item_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
                $user_id = $this->session->userdata('user_id');
                if($user_id){
                    $getone = $this->Product_favorite_model->get('*',array('user_id'=>$user_id,'product_id'=>$item['id']));

                    if($getone){
                        $item_list[$key]['is_favorite'] = 1;
                    }else{
                        $item_list[$key]['is_favorite'] = 0;
                    }
                }else{
                        $item_list[$key]['is_favorite'] = 0;
                }
            }
        }
        // 最大ID
        if (!$max_id && !$since_id) {
        	$max_id = $this->Product_model->get_max_id(NULL);
        } else {
        	//下拉刷新
        	if (!$max_id && $since_id) {
        		$max_id = $this->Product_model->get_max_id(NULL);
        	}
        }
        //是否有下一页
        $cur_count = $per_page * ($page - 1) + count($item_list);
        $total_count = $this->Product_model->rowCount($strWhere);
        $is_next_page = 0;
        if ($total_count > $cur_count) {
            $is_next_page = 1;
        }
        printAjaxData(array('item_list' => $item_list, 'max_id' => $max_id, 'is_next_page' => $is_next_page));
    }

    /**
     * 获取产品详情
     *
     * @param unknown $id
     */
    public function get_product_info($id = NULL) {
    	$user_id = $this->session->userdata('user_id');
        if (!$id) {
            printAjaxError('fail', '参数不能为空');
        }
        $item_info = $this->Product_model->get('*', array('id' => $id));
        if (!$item_info) {
            printAjaxError('no_data', '此产品不存在或被删除');
        }
        //产品分类
        $item_info['product_type_format'] = $this->_product_type_arr[$item_info['product_type']];
        $attachment_list = array();
        if ($item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
            if ($attachment_list) {
            	foreach ($attachment_list as $key => $ls) {
            		$tmp_image_arr = $this->_fliter_image_path($ls['path']);
            		$attachment_list[$key]['path'] = $tmp_image_arr['path'];
            		$attachment_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
            	}
            }
        }
        $item_info['content'] = filter_content(html($item_info['app_content']), base_url());
        $item_info['attachment_list'] = $attachment_list;
        $tmp_image_arr = $this->_fliter_image_path($item_info['path']);
        $item_info['path'] = $tmp_image_arr['path'];
        $item_info['path_thumb'] = $tmp_image_arr['path_thumb'];
        unset($item_info['app_content']);
        //颜色
        $color_list = $this->Product_size_color_model->gets('id, color_id, color_name, color_name_hint, path', array('product_id'=>$id), 'color_id');
        if ($color_list) {
        	foreach ($color_list as $key=>$value) {
        		$tmp_image_arr = $this->_fliter_image_path($value['path']);
        		$color_list[$key]['path'] = $tmp_image_arr['path'];
        		$color_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
        	}
        }
        //尺码
        $size_list = $this->Product_size_color_model->gets('id, size_id, size_name, size_name_hint', array('product_id'=>$id), 'size_id');
        //价格
        $priceInfo = $this->Product_model->getPrice($id);
        if (!$priceInfo['min_price'] && !$priceInfo['max_price']) {
        	$priceInfo['min_price'] = $item_info['sell_price'];
        	$priceInfo['max_price'] = $item_info['sell_price'];
        }
        //评价
        $comment_list = $this->Comment_model->gets('*', "product_id = {$id} and grade > 3",1);
        if ($comment_list){
            foreach ($comment_list as $key => $ls) {
                $comment_list[$key]['add_time'] = date('Y-m-d H:i:s', $ls['add_time']);
                $comment_user_info = $this->User_model->getInfo('username,path,nickname',array('id'=>$ls['user_id']));
                if ($comment_user_info){
                    if ($comment_user_info['nickname']) {
                        $nickname = $comment_user_info['nickname'];
                    } else {
                        $nickname = createMobileBit($comment_user_info['username']);
                    }
                    $comment_list[$key]['username'] = $nickname;
                    $user_image_arr = $this->_fliter_image_path($comment_user_info['path']);
                    $comment_list[$key]['user_path'] = $user_image_arr['path'];
                    $comment_list[$key]['user_path_thumb'] = $user_image_arr['path_thumb'];
                }else{
                    $comment_list[$key]['username'] = '';
                    $comment_list[$key]['user_path'] = '';
                    $comment_list[$key]['user_path_thumb'] = '';
                }

                $attachment_list = array();
                if ($ls['batch_path_ids']) {
                    $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $ls['batch_path_ids']);
                    $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
                    if ($attachment_list) {
                        foreach ($attachment_list as $k => $v) {
                            $tmp_image_arr = $this->_fliter_image_path($v['path']);
                            $attachment_list[$k]['path'] = $tmp_image_arr['path'];
                            $attachment_list[$k]['path_thumb'] = $tmp_image_arr['path_thumb'];
                        }
                    }
                }

                $comment_list[$key]['attachment_list'] = $attachment_list;
            }
        }
        //收藏状态
        $is_favorite = 0;
        $cart_count = 0;
        if ($user_id) {
            if ($this->Product_favorite_model->rowCount(array('user_id' => $user_id, 'product_id' => $id))) {
                $is_favorite = 1;
            }
            $cart_count = $this->Cart_model->rowSum(array('user_id'=>$user_id));
        }
        $item_info['cart_count'] = $cart_count;
        $item_info['is_favorite'] = $is_favorite;
        $item_info['share_product_url'] = base_url() . "weixin.php/share/product/{$id}.html";
        $item_info['share_ptkj_url'] = base_url() . "weixin.php/share/ptkj/{$id}.html";
        $item_info['share_xsms_url'] = base_url() . "weixin.php/share/xsms/{$id}.html";
        $item_info['share_jc_url'] = base_url() . "weixin.php/share/jc/{$id}.html";
        $item_info['product_url'] = base_url() . "index.php/product/detail/{$id}.html";

        $user_info = $this->User_model->get('id, username,nickname, real_name, qq_number, weixin, email, mobile, phone, sex, path', array('id' => $user_id));
        if ($user_info) {
            if (!$user_info['qq_number']) {
                $user_info['qq_number'] = '';
            }
            if (!$user_info['weixin']) {
                $user_info['weixin'] = '';
            }
            if ($user_info['nickname']) {
                $user_info['username'] = $user_info['nickname'];
            }
            if ($user_info['mobile']) {
                $user_info['phone'] = $user_info['mobile'];
            }
            if (!$user_info['phone']) {
                $user_info['phone'] = '';
            }
            if ($user_info['sex'] == 0) {
                $user_info['sex'] = 3;
            } else if ($user_info['sex'] == 1) {
                $user_info['sex'] = 0;
            } else if ($user_info['sex'] == 2) {
                $user_info['sex'] = 1;
            }
            $tmp_image_arr = $this->_fliter_image_path($user_info['path']);
            $user_info['path'] = $tmp_image_arr['path'];
            $user_info['path_thumb'] = $tmp_image_arr['path_thumb'];
            $user_info['skillSetId'] = '';
            $user_info['skillSetName'] = '';
        } else {
            $user_info['id'] = '';
            $user_info['username'] = '';
            $user_info['real_name'] = '';
            $user_info['qq_number'] = '';
            $user_info['weixin'] = '';
            $user_info['email'] = '';
            $user_info['phone'] = '';
            $user_info['sex'] = 3;
            $user_info['path'] = '';
            $user_info['path_thumb'] = '';
            $user_info['skillSetId'] = '';
            $user_info['skillSetName'] = '';
        }
        $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
        //记录浏览次数
        $this->Product_model->save(array('hits' => $item_info['hits'] + 1), array('id' => $id));
        //添加浏览数据-记录用户所有的浏览记录
        if ($id && $user_id) {
        	if (!$this->Product_browse_model->rowCount(array('product_id' => $id, 'user_id' => $user_id))) {
        		$fileds = array(
        				'product_id' => $id,
        				'user_id' => $user_id,
        				'add_time' => time()
        		);
        		$this->Product_browse_model->save($fileds);
        	}
        }

        printAjaxData(array('item_info' => $item_info, 'user_info'=>$user_info, 'size_list'=>$size_list, 'color_list'=>$color_list, 'price_info' => $priceInfo, 'comment_list' => $comment_list, 'comment_count'=>count($comment_list), 'free_postage_setting'=>$free_postage_setting));
    }

    public function get_product_comment_list($id = null){
        if (!$id){
            printAjaxError('fail','参数错误！');
        }
        $comment_list = $this->Comment_model->gets('*', "product_id = {$id}");
        if ($comment_list){
            foreach ($comment_list as $key => $ls) {
                $comment_list[$key]['add_time'] = date('Y-m-d H:i:s', $ls['add_time']);
                $comment_user_info = $this->User_model->getInfo('username,path',array('id'=>$ls['user_id']));
                if ($comment_user_info){
                    if ($comment_user_info['nickname']) {
                        $nickname = $comment_user_info['nickname'];
                    } else {
                        $nickname = createMobileBit($comment_user_info['username']);
                    }
                    $comment_list[$key]['username'] = $nickname;
                    $user_image_arr = $this->_fliter_image_path($comment_user_info['path']);
                    $comment_list[$key]['user_path'] = $user_image_arr['path'];
                    $comment_list[$key]['user_path_thumb'] = $user_image_arr['path_thumb'];
                }else{
                    $comment_list[$key]['username'] = '';
                    $comment_list[$key]['user_path'] = '';
                    $comment_list[$key]['user_path_thumb'] = '';
                }

                $attachment_list = array();
                if ($ls['batch_path_ids']) {
                    $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $ls['batch_path_ids']);
                    $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
                    if ($attachment_list) {
                        foreach ($attachment_list as $k => $v) {
                            $tmp_image_arr = $this->_fliter_image_path($v['path']);
                            $attachment_list[$k]['path'] = $tmp_image_arr['path'];
                            $attachment_list[$k]['path_thumb'] = $tmp_image_arr['path_thumb'];
                        }
                    }
                }

                $comment_list[$key]['attachment_list'] = $attachment_list;
            }
        }

        printAjaxData($comment_list);
    }


    //获取库存
    public function get_stock() {
    	if ($_POST) {
    		$product_id = $this->input->post('product_id');
    		$color_id = $this->input->post('color_id', TRUE);
    		$size_id = $this->input->post('size_id', TRUE);

    		if (!$product_id || !$color_id || !$size_id) {
    			printAjaxError('fail', '操作异常');
    		}
    		if ($product_id && $color_id && $size_id) {
    			$item_info = $this->Product_model->getProductStock($product_id, $color_id, $size_id);
    			if ($item_info) {
    				printAjaxData($item_info);
    			} else {
    				printAjaxError('fail', '获取失败');
    			}
    		}
    	}
    }

    /**
     * 筛选产品
     *
     * @param number $parent_id
     */
    public function product_select($parent_id = 0) {
    	$brand_list = $this->Brand_model->gets_distinct("display = 1");
    	if ($brand_list) {
    		foreach ($brand_list as $key=>$value) {
    			$brand_list[$key]['sub_list'] = $this->Brand_model->gets('*', array('display'=>1, 'first_letter'=>$value['first_letter']));
    		}
    	}
        $size_list = array();// $this->Size_model->gets();
        $category = $this->Product_category_model->gets(array('parent_id' => $parent_id));
        printAjaxData(array('brand_list' => $brand_list, 'size_list' => $size_list, 'category' => $category));
    }

    /*
     * 首页商品列表
     * @param int 分类id
     * return json
     */
    public function get_index_product_list($category_id = 0) {
        $cus_list = $this->advdbclass->get_product_cus_list($category_id, 'c', 100);
        if (!$cus_list) {
            printAjaxData(array('item_list' => array()));
        }
        if ($cus_list) {
        	foreach ($cus_list as $key => $item) {
        		$tmp_image_arr = $this->_fliter_image_path($item['path']);
        		$cus_list[$key]['path'] = $tmp_image_arr['path'];
        		$cus_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
        	}
        }
        printAjaxData(array('item_list' => $cus_list));
    }

    /**
     * 获取首页推荐商品
     */
    public function get_recommend_list() {
        $item_list = $this->Product_model->gets('product.id,product.title,product.sell_price,product.favorite_num,product.path,product.abstract,product.market_price', 'display = 1', 4, 0);
        if ($item_list) {
        	foreach ($item_list as $key => $ls) {
        		$tmp_path = $this->_fliter_image_path($ls['path']);
        		$item_list[$key]['path'] = $tmp_path['path'];
        		$item_list[$key]['path_thumb'] = $tmp_path['path_thumb'];
        	}
        }
        printAjaxData(array('item_list' => $item_list));
    }

    /*
     * 获取广告
     *
     * @param string $ad_id 广告位id
     * @param string $num 数量
     * @return multitype:string
     */
    public function get_ad_list($category_id = NULL, $num = 10) {
    	if (!$category_id) {
            printAjaxError('category_id', '广告位置不能为空');
    	}
        $item_list = $this->Ad_model->gets('id, path, url, ad_text', array('category_id' => $category_id, 'ad_type' => 'image', 'display' => 1), $num, 0);
        if ($item_list) {
        	foreach ($item_list as $key => $value) {
        		$tmp_image_arr = $this->_fliter_image_path($value['path']);
        		$item_list[$key]['path'] = $tmp_image_arr['path'];
        		$item_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
        	}
        }
        printAjaxData(array('item_list' => $item_list));
    }

    /**
     * 获取帮助中心分类列表
     */
    public function get_menu_for_help_list() {
        $item_list = $this->Menu_model->gets('id, menu_name', "parent = 173 and id <> 263");
        printAjaxData(array('item_list' => $item_list));
    }

    /**
     * 最新公告/客户服务列表
     * @$category_id 分类ID
     * @param number $max_id     若指定此参数，则返回ID小于或等于max_id的信息,相当于more
     * @param number $since_id   获取最新信息,相当于下拉刷新
     * @param number $per_page   每页数
     * @param number $page       页数
     */
    public function get_page_list($category_id = 263, $max_id = 0, $since_id = 0, $per_page = 10, $page = 1) {
        $strWhere = "page.category_id = {$category_id} ";
        if ($since_id) {
            $strWhere .= " and page.id > {$since_id} ";
        }
        if ($max_id) {
            $strWhere .= " and page.id <= {$max_id} ";
        }
        $item_list = $this->Page_model->gets($strWhere, $per_page, $per_page * ($page - 1));
        if ($item_list) {
            foreach ($item_list as $key => $value) {
                unset($item_list[$key]['content']);
                unset($item_list[$key]['keyword']);
                unset($item_list[$key]['template']);
            }
        }
        // 最大ID
        if (!$max_id && !$since_id) {
        	$max_id = $this->Page_model->get_max_id(NULL);
        } else {
        	//下拉刷新
        	if (!$max_id && $since_id) {
        		$max_id = $this->Page_model->get_max_id(NULL);
        	}
        }
        //是否有下一页
        $cur_count = $per_page * ($page - 1) + count($item_list);
        $total_count = $this->Page_model->rowCount($strWhere);
        $is_next_page = 0;
        if ($total_count > $cur_count) {
            $is_next_page = 1;
        }
        printAjaxData(array('item_list' => $item_list, 'is_next_page' => $is_next_page, 'max_id' => $max_id));
    }

    /*
     * 公告详情
     */

    public function get_page_info($id = NULL) {
        if (!$id) {
            printAjaxError('fail', '参数错误');
        }
        $item_info = $this->Page_model->get('title,id,content', array('id' => $id, 'display'=>1));
        if (!$item_info) {
            printAjaxError('fail_no_data', '此信息不存在');
        }
        $item_info['content'] = filter_content(html($item_info['content']), base_url());

        printAjaxData($item_info);
    }

    /**
     * 获取地区层级列表
     */
    public function get_area_list() {
        $item_list = $this->Area_model->gets("id as 'value', name as 'text', parent_id", array('parent_id' => 0, 'display' => 1));
        if ($item_list) {
            foreach ($item_list as $key => $value) {
                $sub_item_list = $this->Area_model->gets("id as 'value', name as 'text', parent_id", array('parent_id' => $value['value'], 'display' => 1));
                if ($sub_item_list) {
                    foreach ($sub_item_list as $s_key => $s_value) {
                        $sub_item_list[$s_key]['children'] = $this->Area_model->gets("id as 'value', name as 'text', parent_id", array('parent_id' => $s_value['value'], 'display' => 1));
                    }
                }
                $item_list[$key]['children'] = $sub_item_list;
            }
        }
        printAjaxData(array('item_list' => $item_list));
    }

    /**
     * 获取地区列表
     */
    public function get_areas_list() {
        $provinces = $this->Area_model->gets("id, name", array('parent_id' => 0, 'display' => 1));
        $citys = array();
        $areas = array();
        if ($provinces) {
            foreach ($provinces as $key => $value) {
                $citys_list = $this->Area_model->gets("id, name", array('parent_id' => $value['id'], 'display' => 1));
                if ($citys_list) {
                    foreach ($citys_list as $s_key => $s_value) {
                        $citys_list[$s_key]['province'] = $value['name'];
                        $areas_list = $this->Area_model->gets("id, name", array('parent_id' => $s_value['id'], 'display' => 1));
                        if ($areas_list){
                            foreach ($areas_list as $k =>$v){
                                $areas_list[$k]['city'] = $s_value['name'];
                            }
                        }
                        $areas[] = $areas_list;
                    }
                }
                $citys[] = $citys_list;
            }
        }
        printAjaxData(array('provinces' => $provinces,'citys' => $citys, 'areas'=>$areas));
    }

    /*
     * 获取拼团列表
     *
     */

    public function get_pintuan_list() {
        $current_time = time();
        $today = strtotime(date('Y-m-d 10:00:00'));
        $tomorrow = strtotime(date('Y-m-d 23:59:59')) + 24 * 60 * 60;
        $item_list = $this->Promotion_ptkj_model->gets("start_time >= $today and start_time <= $tomorrow and is_open = 1");
        foreach ($item_list as $key => $item) {
            $product = $this->Product_model->get('sell_price,path', "id = {$item['product_id']}");
            if ($this->session->userdata("user_id")) {
                $user_id = $this->session->userdata("user_id");
                $count = $this->Ptkj_record_model->rowCount(array('user_id' => $user_id, 'ptkj_id' => $item['id']));
                if ($count > 0) {
                    $item_list[$key]['is_cantuan'] = 1;
                }
            } else {
                $item_list[$key]['is_cantuan'] = 0;
            }
            $pintuan_rule = $this->Pintuan_model->gets("ptkj_id = {$item['id']}");
            $item_list[$key]['sell_price'] = $product['sell_price'];
            $item_list[$key]['pintuan_price'] = $product['sell_price'];
            foreach ($pintuan_rule as $ls) {
                if ($item['pintuan_people'] >= $ls['low'] && $item['pintuan_people'] <= $ls['high']) {
                    $item_list[$key]['pintuan_price'] = $ls['money'];
                }
            }
            $tmp_image_arr = $this->_fliter_image_path($product['path']);

            $item_list[$key]['path'] = $tmp_image_arr['path'];
            $item_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
            if ($item['start_time'] <= time() && $item['end_time'] > time()) {
                $item_list[$key]['status'] = 0;
            }
            if ($item['start_time'] > time()) {
                $item_list[$key]['status'] = 1;
            }
            if ($item['end_time'] < time()) {
                $item_list[$key]['status'] = 2;
            }
        }
        $tmp_arr = array(
            'today' => array(
                'date' => date('m月d日') . '<span>10:00</span>',
                'item_list' => array(),
            ),
            'tomorrow' => array(
                'date' => date('m月d日', strtotime(date('Y-m-d 10:00:00')) + 24 * 60 * 60) . '<span>10:00</span>',
                'item_list' => array(),
            ),
        );
        $t1 = strtotime(date('Y-m-d 10:00:00'));
        $t2 = strtotime(date('Y-m-d 23:59:59'));
        $t3 = strtotime(date('Y-m-d 10:00:00')) + 24 * 60 * 60;
        $t4 = strtotime(date('Y-m-d 23:59:59')) + 24 * 60 * 60;
        foreach ($item_list as $ls) {
            if ($ls['start_time'] >= $t1 && $ls['start_time'] <= $t2) {
                $tmp_arr['today']['item_list'][] = $ls;
            }
            if ($ls['start_time'] >= $t3 && $ls['start_time'] <= $t4) {
                $tmp_arr['tomorrow']['item_list'][] = $ls;
            }
        }
        printAjaxData(array('list' => $tmp_arr, 'current_time' => time()));
    }

    /*
     * 获取限时秒杀列表
     */

    public function get_xsms_list() {
        $today = strtotime(date('Y-m-d'));
        $tomorrow = strtotime(date('Y-m-d 23:30:00')) + 24 * 60 * 60;
        $item_list = $this->Flash_sale_model->gets("start_time > $today and start_time <= $tomorrow and is_open = 1");
        foreach ($item_list as $key => $ls) {
            $user_id = $this->session->userdata('user_id');
            if ($user_id) {
                $count = $this->Flash_sale_record_model->rowCount(array('user_id' => $user_id, 'flash_sale_id' => $ls['id'], 'start_time' => $ls['start_time'], 'end_time' => $ls['end_time']));
                if ($count > 0) {
                    $item_list[$key]['is_miaosha'] = 1;
                } else {
                    $item_list[$key]['is_miaosha'] = 0;
                }
            } else {
                $item_list[$key]['is_miaosha'] = 0;
            }
            if ($ls['start_time'] <= time() && $ls['end_time'] > time()) {
                $item_list[$key]['status'] = 0;
            }
            if ($ls['start_time'] > time()) {
                $item_list[$key]['status'] = 1;
            }
            if ($ls['end_time'] < time()) {
                $item_list[$key]['status'] = 2;
            }
            $tmp_arr = $this->_fliter_image_path($ls['path']);
            $item_list[$key]['path'] = $tmp_arr['path'];
            $item_list[$key]['path_thumb'] = $tmp_arr['path_thumb'];
        }
        $date1 = '12:00~13:00';
        $date2 = '20:00~21:00';

        $date3 = '12:00~13:00';
        $date4 = '20:00~21:00';
        $today_list = array(
            'first' => array(
                'date' => $date1,
                'item_list' => array(),
            ),
            'second' => array(
                'date' => $date2,
                'item_list' => array(),
            ),
        );
        $tomorrow_list = array(
            'first' => array(
                'date' => $date3,
                'item_list' => array(),
            ),
            'second' => array(
                'date' => $date4,
                'item_list' => array(),
            ),
        );
        $time1 = strtotime(date('Y-m-d 12:00:00')) + 24 * 60 * 60;
        $time2 = strtotime(date('Y-m-d 20:00:00')) + 24 * 60 * 60;
        foreach ($item_list as $item) {
            if ($item['start_time'] >= strtotime(date('Y-m-d 12:00:00')) && $item['start_time'] <= strtotime(date('Y-m-d 13:00:00'))) {
                $today_list['first']['item_list'][] = $item;
            }
            if ($item['start_time'] >= strtotime(date('Y-m-d 20:00:00')) && $item['start_time'] <= strtotime(date('Y-m-d 21:00:00'))) {
                $today_list['second']['item_list'][] = $item;
            }
            if ($item['start_time'] >= $time1 && $item['start_time'] <= $time1 + 3600) {
                $tomorrow_list['first']['item_list'][] = $item;
            }
            if ($item['start_time'] >= $time2 && $item['start_time'] <= $time2 + 3600) {
                $tomorrow_list['second']['item_list'][] = $item;
            }
        }
        printAjaxData(array('today' => $today_list, 'tomorrow_list' => $tomorrow_list, 'current_time' => time()));
    }

    //获取首页分类商品推荐
    public function get_category_recommend() {
        $tmp_arr = array(
            0 => array(
                'title' => '家居用品',
                'ad_id' => '54',
                'category_id' => '109,127,128'
            ),
            1 => array(
                'title' => '珠宝配饰',
                'ad_id' => '56',
                'category_id' => '123,122,59'
            ),
            3 => array(
                'title' => '车载用品',
                'ad_id' => '55',
                'category_id' => '65,124'
            )
        );
        $item_list = array();
        foreach ($tmp_arr as $item) {
            $product_list = $this->advdbclass->get_product_cus_list($item['category_id'], 's', 100);
            if ($product_list) {
                foreach ($product_list as $key => $ls) {
                    $tmp_image_arr = $this->_fliter_image_path($ls['path']);
                    $product_list[$key]['path'] = $tmp_image_arr['path'];
                    $product_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
                }
            }
            $adList = $this->advdbclass->getAd($item['ad_id'], 2);
            foreach ($adList as $key => $ls) {
                $tmp_image_arr = $this->_fliter_image_path($ls['path']);
                $adList[$key]['path'] = $tmp_image_arr['path'];
                $adList[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
            }
            $item_list[] = array(
                'title' => $item['title'],
                'product_list' => $product_list,
                'ad_list' => $adList
               );
        }
        printAjaxData(array('item_list'=>$item_list));
    }

    //手机 精品推荐
    public function get_prime_product_list($max_id = 0, $since_id = 0, $per_page = 8, $page = 1) {
    	$user_id = $this->session->userdata('user_id');
        $strWhere = "display = 1 and find_in_set('h',custom_attribute)";
        if ($since_id) {
        	$strWhere .= " and id > {$since_id} ";
        }
        if ($max_id) {
        	$strWhere .= " and id <= {$max_id} ";
        }
        $item_list = $this->Product_model->gets('id,path,title,sell_price,market_price,sales', $strWhere, $per_page, $per_page * ($page - 1), 'id');
        if ($item_list) {
            foreach ($item_list as $key => $item) {
                $tmp_image_arr = $this->_fliter_image_path($item['path']);
                $item_list[$key]['path'] = $tmp_image_arr['path'];
                $item_list[$key]['path_thumb'] = $tmp_image_arr['path_thumb'];
                //收藏
                $is_favorite = 0;
                if($user_id){
                    if($this->Product_favorite_model->get('*',array('user_id'=>$user_id, 'product_id'=>$item['id']))){
                        $is_favorite = 1;
                    }
                }
                $item_list[$key]['is_favorite'] = $is_favorite;
            }
        }
        // 最大ID
        // 第一次加载
        if (!$max_id && !$since_id) {
        	$max_id = $this->Product_model->get_max_id(NULL);
        } else {
        	//下拉刷新
        	if (!$max_id && $since_id) {
        		$max_id = $this->Product_model->get_max_id(NULL);
        	}
        }
        //是否有下一页
        $cur_count = $per_page * ($page - 1) + count($item_list);
        $total_count = $this->Product_model->rowCount($strWhere);
        $is_next_page = 0;
        if ($total_count > $cur_count) {
            $is_next_page = 1;
        }

        printAjaxData(array('item_list' => $item_list, 'is_next_page' => $is_next_page, 'max_id' => $max_id));
    }

    //获取视频代码
    public function get_video_path() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $path = preg_replace(array("/height\=\"?\d+\"?/", "/width\=\"?\d+\"?/"), array('height="200"', 'width="340"'), $systemInfo['video_path']);
        printAjaxData($path);
    }

    /*
     * 获取热词
     */

    public function get_hot_keyword_list() {
        $systemInfo = $this->System_model->get('link_keyword', array('id' => 1));
        $keyword_str = $systemInfo['link_keyword'];
        $keyword_list = explode('|', $keyword_str);
        printAjaxData(array('item_list' => $keyword_list));
    }

    /*
     * 获取当前时间戳
     */

    public function get_timestamp() {
        printAjaxData(array('timestamp' => time()));
    }

    public function record_jump_url() {
        $this->session->set_userdata(array('gloabPreUrl' => base_url() . 'wx/member_weixin.html'));
        printAjaxSuccess('success', '记录成功');
    }

	/**
	 * 登录签到领取
	 */
	public function login_receive() {
		$user_id = $this->_check_login();
		$user_info = $this->User_model->get('id, username, score_silver', array('id'=>$user_id));
		if (!$user_info) {
			printAjaxError('fail', '用户不存在，签到失败');
		}
		$cur_time = date('Y-m-d', time());
		if ($this->Score_model->rowCount("score_type = 'silver' and type in ('login_score_in', 'reg_score_in') and user_id = {$user_info['id']} and from_unixtime(add_time, '%Y-%m-%d') = '{$cur_time}' ")) {
			printAjaxError('fail', '今天已签到领取');
		}
		$score_setting_info = $this->Score_setting_model->get('login_score', array('id' => 1));
		if (!$score_setting_info) {
			printAjaxError('fail', '签到操作异常');
		}
        $score = $score_setting_info['login_score'];
        $balance = $user_info['score_silver'] + $score_setting_info['login_score'];
        $fields['score_silver'] = $balance;
        if ($this->User_model->save($fields, array('id' => $user_info['id']))) {
            $fields = array(
            		'score_type'=>'silver',
            		'cause' => '每日签到奖励',
            	    'score' => $score,
            		'balance' => $balance,
            		'type' => 'login_score_in',
            		'add_time' => time(),
            		'username' => $user_info['username'],
            		'user_id' => $user_info['id'],
            		'ret_id' => $user_info['id']
            );
            $this->Score_model->save($fields);
        } else {
            printAjaxError('fail', '签到领取失败');
        }
        printAjaxData(array('login_score'=>$score));
	}

    //信息反馈
    public function add_feedback(){
        $user_id = $this->_check_login();
        if ($_POST){
            $content = trim($this->input->post('content',TRUE));
            if (!$content){
                printAjaxError('fail','请填写反馈内容！');
            }
            $data = array(
                'user_id'=>$user_id,
                'content'=>$content,
                'add_time'=>time()
            );
            if ($this->Guestbook_model->save($data)){
                printAjaxSuccess('success','提交成功！');
            }else{
                printAjaxError('fail','提交失败！');
            }
        }
    }

    //重绘小程序码
    public function get_wx_code()
    {
        $user_id = $this->_check_login();
        $user_info = $this->User_model->get('id,wx_code_path,path', array('user.id' => $user_id));
        if ($user_info['wx_code_path']){
            $tmp_image_arr = $this->_fliter_image_path($user_info['wx_code_path']);
            $path = $tmp_image_arr['path'];
            $path_thumb = $tmp_image_arr['path_thumb'];
            printAjaxData($path);
        }else{

            $tmp_image_arr = $this->_fliter_image_path($user_info['path']);
            $path = $tmp_image_arr['path'];
            //用户头像图片变圆形
            $logo = yuanImg($path);//返回的是图片数据流
            //获取小程序码
            $result = $this->get_wx_qr_code('pages/index/index',$user_id);
            //二维码与头像结合
            $sharePic = qrcodeWithLogo($result,$logo);
            $save_dir='uploads/wxcode/';
            if (!file_exists($save_dir)) {
                mkdir($save_dir, 0777, true);
            }
            $time = time();
            $file_name = $save_dir.$time.'_'.$user_id.".png";
            file_put_contents($file_name, $sharePic);
            $this->User_model->save(array('wx_code_path'=>$file_name),array('id'=>$user_id));

            $tmp_image_arr = $this->_fliter_image_path($file_name);
            $path = $tmp_image_arr['path'];
            $path_thumb = $tmp_image_arr['path_thumb'];
            printAjaxData($path);
        }
    }

    //获取小程序码
    public function get_wx_qr_code($page,$scene)
    {
        $appid = $this->appid;
        $appSecret = $this->appSecret;
        $json = http_curl("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appSecret}");
        $obj = json_decode($json);
        if (isset($obj->errmsg)) {
            printAjaxError('fail', 'invalid appid!');
        }
        $access_token = $obj->access_token;
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$access_token}";
        $encode_id = urlencode($scene);
        $data = array(
            'page'=>"{$page}",
            'scene'=>"{$encode_id}",
            'width'=>430,
            'auto_color'=>false,
        );
        $data=json_encode($data);
        $result = http_curl($url,$data);
        if (json_decode($result)){
            printAjaxError('fail', 'invalid result!');
        }
        return $result;
    }


    //消息推送
    private function _send_push($cid = '', $message = '') {
    	$getui = new Getuiapiclass();
    	$getui->send_push($cid, $message);
    }

    private function _tmp_user_info($user_id = NULL, $session_id = 0) {
    	$user_info = $this->User_model->getinfo('id,distributor,school_distributor,net_distributor,distributor_status,distributor_status_time,distributor_client_remark, distributor_admin_remark,old_presenter_id,id,user_type,seller_grade,user_group_id,username,nickname,real_name,add_time,total,score_gold,score_silver,total_gold,total_silver,mobile,phone,sex,path,ad_text,push_cid,total_gold_rmb_pre,total_silver_rmb_pre,alipay_account,weixin_account,ebank_account,gold_card_num', "id = $user_id");
    	if ($user_info) {
    		$user_info['session_id'] = $session_id;
    		$tmp_image_arr = $this->_fliter_image_path($user_info['path']);
    		$user_info['path'] = $tmp_image_arr['path'];
    		$user_info['path_thumb'] = $tmp_image_arr['path_thumb'];
    		$user_info['total_cart'] = $this->Cart_model->rowCount(array('user_id'=>$user_id));
    		//旧版本
    		$is_distributor = 0;
    		$distributor_type_name = '';
    		if ($user_info['distributor']) {
    			$is_distributor = 1;
    			$distributor_type_name = $this->_distributor_arr[$user_info['distributor']];
    		} else if ($user_info['school_distributor']) {
    			$is_distributor = 1;
    			$distributor_type_name = $this->_school_distributor_arr[$user_info['school_distributor']];
    		} else if ($user_info['school_distributor']) {
    			$is_distributor = 1;
    			$distributor_type_name = $this->_net_distributor_arr[$user_info['school_distributor']];
    		}
    		$user_info['is_distributor'] = $is_distributor;
    		$user_info['distributor_type_name'] = $distributor_type_name;
    	}
    	return $user_info;
    }

    /**
     * 过滤图片路径
     *
     * @param string $image_path
     * @param string $model
     * @return multitype:string
     */
    private function _fliter_image_path($image_path = NULL) {
    	$path = '';
    	$path_thumb = '';
    	if ($image_path) {
    		if (!preg_match('/^http/', $image_path)) {
    			$path = base_url() . $image_path;
    			$path_thumb = base_url() . preg_replace('/\./', '_thumb.', $image_path);
    		} else {
    			$path = $image_path;
    			$path_thumb = $image_path;
    		}
    	}
    	return array('path' => $path, 'path_thumb' => $path_thumb);
    }

    private function _delete_session() {
    	$this->session->unset_userdata("user_id");
    }

    private function _set_session($user_id = "") {
    	$this->session->set_userdata(array('user_id' => $user_id));
    }

    //加盐算法
    private function _createPasswordSALT($user, $salt, $password) {
    	return md5(strtolower($user) . $salt . $password);
    }

    private function _beforeFilter() {
    	$sid = $this->input->get('sid');
    	if ($sid && strlen($sid) > 0) {
    		$this->session->parseSessionId(preg_replace('/sid-/', '', $sid));
    	}
    }
}

/* End of file main.php */
/* Location: ./application/client/controllers/main.php */