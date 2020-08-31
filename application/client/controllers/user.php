<?php

class User extends CI_Controller {

    private $_table = 'user';
    private $_template = 'user';
    private $_status = array(
            '0' => '<font color="#ff4200">待付款</font>',
			'1' => '<font color="#cc3333">待发货</font>',
			'2' => '<font color="#ff811f">待收货</font>',
			'3' => '<font color="#066601">交易成功</font>',
			'4' => '<font color="#a0a0a0">交易关闭</font>'
    );
    private $_order_type = array(
        '0' => '我的订单',
        '1' => '拼团砍价订单',
        '2' => '限时秒杀订单',
        '3' => '我的竞猜订单',
    );
    private $_sex_arr = array('0' => '保密', '1' => '男', '2' => '女');
    private $_exchange_type = array('1' => '退货退款', '2' => '换货', '3' => '仅退款');
    private $_exchange_status = array('0' => '待审核', '1' => '审核未通过', '2' => '审核通过');
    private $_distributor_arr = array('1' => '城市合伙人', '2' => '店级合伙人');
    private $_school_distributor_arr = array('1' => '校园一级分销商', '2' => '校园二级分销商');
    private $_net_distributor_arr = array('1' => '网络一级分销商', '2' => '网络二级分销商');
    private $_financial_type_arr = array(
        'order_out' => '订单支付',
        'order_in' => '订单退款',
        'recharge_in' => '充值',
        'recharge_out' => '扣款',
        'presenter_in' => '推广分成',
        'presenter_out' => '推广退款',
    	'third_recharge_in'=>'在线充值',
    	'third_recharge_out'=>'充值退款'
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
    private $_elephant_log_type_arr = array(
    		'recharge_in'=>'充值',
    		'recharge_out'=>'扣款',
    		'convert_out'=>'兑换支付',
    		'convert_in'=>'兑换入账',
    		'withdraw_in'=>'提现退款',
    		'withdraw_out'=>'提现支付');
    private $_trade_status_msg = array('WAIT_BUYER_PAY'=>'等待买家付款', 'TRADE_CLOSED'=>'交易关闭', 'TRADE_SUCCESS'=>'交易成功', 'TRADE_PENDING'=>'等待卖家收款', 'TRADE_FINISHED'=>'交易成功');
    private $_pay_log_payment_type_arr = array('alipay'=>'支付宝','weixin'=>'微信');
    private $_seller_grade_arr = array(''=>'未设置', 'a'=>'A类', 'b'=>'B类', 'c'=>'C类');
    private $_score_type_2_arr = array('gold'=>'金象积分', 'silver'=>'银象积分');

    public function __construct() {
        parent::__construct();
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('User_address_model', '', TRUE);
        $this->load->model('Area_model', '', TRUE);
        $this->load->model('Orders_model', '', TRUE);
        $this->load->model('Orders_detail_model', '', TRUE);
        $this->load->model('Score_model', '', TRUE);
        $this->load->model('Sms_model', '', TRUE);
        $this->load->model('Comment_model', '', TRUE);
        $this->load->model('Exchange_model', '', TRUE);
        $this->load->model('Financial_model', '', TRUE);
        $this->load->model('Guestbook_model', '', TRUE);
        $this->load->model('Ptkj_record_model', '', TRUE);
        $this->load->model('Pintuan_model', '', TRUE);
        $this->load->model('Promotion_ptkj_model', '', TRUE);
        $this->load->model('Product_favorite_model', '', TRUE);
        $this->load->model('Flash_sale_record_model', '', TRUE);
        $this->load->model('Orders_process_model', '', TRUE);
        $this->load->model('Flash_sale_model', '', TRUE);
        $this->load->model('Chop_record_model', '', TRUE);
        $this->load->model('Score_setting_model', '', TRUE);
        $this->load->model('Message_model', '', TRUE);
        $this->load->model('Elephant_log_model', '', TRUE);
        $this->load->model('Withdraw_model', '', TRUE);
        $this->load->model('Pay_log_model', '', TRUE);
		$this->load->model('Product_model', '', TRUE);

        $this->load->library('Securitysecoderclass');
        $this->load->library('Form_validation');
    }

    public function index() {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
		$systemInfo = $this->System_model->get('*', array('id' => 1));
        $userInfo = $this->User_model->get('*', array('user.id' => get_cookie('user_id')));
        //所有订单数量
        $countStatusAll = $this->Orders_model->rowCount(array('user_id' => get_cookie('user_id')));
        //待确认订单数量
        $countStatus_0 = $this->Orders_model->rowCount(array('status' => 0, 'user_id' => get_cookie('user_id')));
        //已付款订单数量
        $countStatus_1 = $this->Orders_model->rowCount(array('status' => 1, 'user_id' => get_cookie('user_id')));
        //当前位置
        $location = "会员中心";
        //收藏列表
        $item_list = $this->Product_favorite_model->gets(array('product_favorite.user_id' => get_cookie('user_id')), 12, 0);
        //订单
        $orderList = $this->Orders_model->gets('*', "user_id = " . get_cookie('user_id') . " and status in (0) ", 5, 0);
        foreach ($orderList as $key => $order) {
            $orderList[$key]['orderdetailList'] = $this->Orders_detail_model->gets('*', "order_id = {$order['id']}");
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '会员中心',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'userInfo' => $userInfo,
            'item_list' => $item_list,
            'orderList' => $orderList,
            'countStatusAll' => $countStatusAll,
            'countStatus_0' => $countStatus_0,
            'countStatus_1' => $countStatus_1,
            'status' => $this->_status,
            'location' => $location
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/index", $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function login() {
        $prfUrl = $this->session->userdata('gloabPreUrl') ? $this->session->userdata('gloabPreUrl') : base_url() . "index.php/user";
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        if ($_POST) {
            $username = trim($this->input->post('username', TRUE));
            $password = $this->input->post('password', TRUE);
            $code = $this->input->post('code', TRUE);
            $remember = $this->input->post('remember', TRUE);

            if (!$this->form_validation->required($username)) {
                printAjaxError('username', '输入用户名');
            }
            if (!$this->form_validation->required($password)) {
                printAjaxError('username', '输入密码');
            }
            if (!$this->form_validation->required($code)) {
                printAjaxError('code', '输入验证码');
            }
            $securitysecoder = new Securitysecoderclass();
            if (!$securitysecoder->check(strtolower($code))) {
                printAjaxError('code_fail', '验证码错误');
            }
            $count = $this->User_model->rowCount(array('lower(username)' => strtolower($username)));
            if (!$count) {
                printAjaxError('fail', "用户名不存在,登录失败");
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
                'ip_address' => $ip_arr[1]
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
            $this->_setCookie($userInfo, $remember ? 604800 : 0);
            //登录成功
            printAjaxSuccess('success_login_go', $prfUrl);
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => '登录' . $systemInfo['site_name'],
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/login", $data, TRUE)
        );
        $this->load->view('layout/login_reg_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function qq_login(){
        require("sdk/authlogin/qqlogin/API/qqConnectAPI.php");
        $qc = new QC();
        $access_token = $qc->qq_callback();
        $openid = $qc->get_openid();
        $qc2 = new QC($access_token, $openid);
        $qq_user_info = $qc2->get_user_info();
        if ($qq_user_info['gender'] == '男') {
            $sex = 1;
        } else if ($qq_user_info['gender'] == '女') {
            $sex = 2;
        } else {
            $sex = 0;
        }
        $user_info = $this->User_model->get('*', "qq_unionid = '{$openid}'");
        $is_mobile = is_mobile_request();
        $this->first_auth_login('qq', $user_info, $qq_user_info['nickname'], $qq_user_info['figureurl_qq_2'], $sex, $openid, $is_mobile);
    }

    //微信登录
    public function weixin_login() {
        $code = $this->input->get("code", true);
        if (empty($code)) {
            exit("DO NOT ACCESS!");
        }
        $appid = 'wxc2858411e327df01';
        $appSecret = '943d7d3216d1836110bd7487ac0000c6';
        $json = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appSecret&code=$code&grant_type=authorization_code");
        $obj = json_decode($json);
        if (isset($obj->errmsg)) {
            exit("invalid code");
        }
        $access_token = $obj->access_token;
        $openid = $obj->openid;
        $result = file_get_contents("https://api.weixin.qq.com/sns/auth?access_token=$access_token&openid=$openid");
        $access_token_obj = json_decode($result);
        if ($access_token_obj->errcode != 0) {
            exit($access_token_obj->errmsg);
        }
        $ret_user_info = file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid");
        $ret_user_info = json_decode($ret_user_info, true);
        $user_info = $this->User_model->get('*', "wx_unionid = '{$ret_user_info['unionid']}'");
        $this->first_auth_login('wechat', $user_info, $ret_user_info['nickname'], $ret_user_info['headimgurl'], $ret_user_info['sex'], $ret_user_info['unionid']);
    }

    public function register() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $prfUrl = $this->session->userdata('gloabPreUrl') ? $this->session->userdata('gloabPreUrl') : base_url() . "index.php/user";
        if ($_POST) {
        	$user_type = $this->input->post('user_type', TRUE);
            $username = trim($this->input->post('mobile', TRUE));
            $password = $this->input->post('password', TRUE);
            $refPassword = $this->input->post('ref_password', TRUE);
            $code = $this->input->post('code', TRUE);
            $smscode = $this->input->post('smscode', TRUE);
            $remember = $this->input->post('remember', TRUE);
            $pop_code = trim($this->input->post('pop_code', TRUE));

            if (!$remember) {
                printAjaxError('fail', '必须同意“服务协议”才能完成注册');
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
            if (!$this->form_validation->required($refPassword)) {
                printAjaxError('ref_password', '请输入确认密码');
            }
            if ($password != $refPassword) {
                printAjaxError('ref_password', '前后密码不一致');
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
            $timestamp = time();
            if (!$this->Sms_model->get('id', "smscode = '{$smscode}' and mobile = '{$username}' and add_time > {$timestamp} - 15*60")) {
                printAjaxError('smscode', '短信验证码错误或者已过期');
            }
            $addTime = time();
            $ip_arr = getUserIPAddress();
            $fields = array(
                'user_group_id' => 1,
            	'user_type'=>      $user_type,
                'username' =>      $username,
            	'password' =>      $this->_createPasswordSALT($username, $addTime, $password),
                'login_time' =>    $addTime,
                'ip' =>            $ip_arr[0],
                'ip_address' =>    $ip_arr[1],
                'mobile' =>        $username,
                'add_time' =>      $addTime,
                'presenter_id' =>  $presenter_id,
                'presenter_username' => $presenter_username,
            	'par_presenter_id' =>       $par_presenter_id,
            	'par_presenter_username' => $par_presenter_username
            );
            //新用户注册-送银象积分
            $score_setting_info = $this->Score_setting_model->get('reg_score, join_user_score, join_seller_score', array('id' => 1));
            if ($score_setting_info && $score_setting_info['reg_score'] > 0) {
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
                $user_info = $this->User_model->get('*', array('user.id' => $ret));
                $this->_setCookie($user_info, 0);
                printAjaxSuccess($prfUrl, '恭喜您注册成功!');
            } else {
                printAjaxError('fail', '注册失败！');
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '注册',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/register", $data, TRUE)
        );
        $this->load->view('layout/login_reg_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    /**
     * 第三方登录代码复用
     * @param type $auth_type 微信wechat，微博weibo,腾讯QQ qq
     * @param type $user_info
     * @param type $nickname
     * @param type $headimgurl
     * @param type $unique_str
     */
    private function first_auth_login($auth_type = '', $user_info = NULL, $nickname = '', $headimgurl = '', $sex = 0, $unique_str = '', $is_mobile = false) {
    	if (!$user_info) {
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
    				'path' => $headimgurl,
    				'sex' => $sex
    		);
    		switch ($auth_type) {
    			case 'wechat' :
    				$fields['wx_unionid'] = $unique_str;
    				break;
    			default :
    				$fields['qq_unionid'] = $unique_str;
    		}
    		//新用户注册-送银象积分
    		$score_setting_info = $this->Score_setting_model->get('reg_score', array('id' => 1));
    		if ($score_setting_info && $score_setting_info['reg_score'] > 0) {
    			$fields['score_silver'] = $score_setting_info['reg_score'];
    		}
    		$ret_id = $this->User_model->save($fields);
    		if ($ret_id) {
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
            	//QQ登录并且用手机登录
            	if ($auth_type == 'qq' && $is_mobile) {
            		$session_id = $this->session->userdata['session_id'];
            		$this->session->set_userdata(array('user_id' => $ret_id));
            		redirect(base_url().'wx/member.html?login_type=sf&sid='.$session_id);
            		exit;
            	} else {
            		$this->_setCookie(array('id'=>$ret_id, 'nickname'=>'', 'username'=>'', 'login_time'=>time(), 'ip'=>'', 'ip_address'=>''), 0);
            	}
    		} else {
    			printAjaxError('fail', '登录失败！');
    		}
    	} else {
    		$login_time = time();
    		$fields = array(
    				'login_time' => $login_time
    		);
    		$cur_time = date('Y-m-d', time());
    		$score = 0;
    		$balance = 0;
    		if (!$this->Score_model->rowCount("score_type = 'silver' and type = 'login_score_in' and user_id = {$user_info['id']} and from_unixtime(add_time, '%Y-%m-%d') = '{$cur_time}' ")) {
    			$score_setting_info = $this->Score_setting_model->get('login_score', array('id' => 1));
    			$score = $score_setting_info['login_score'];
    			$balance = $user_info['score_silver'] + $score_setting_info['login_score'];
    			$fields['score_silver'] = $balance;
    		}
    		if ($this->User_model->save($fields, array('id' => $user_info['id']))) {
    			$sFields = array(
    					'score_type'=>'silver',
    					'cause' => '每日签到送积分-登录成功',
    					'score' => $score,
    					'balance' => $balance,
    					'type' => 'login_score_in',
    					'add_time' => time(),
    					'username' => $user_info['username'],
    					'user_id' => $user_info['id'],
    					'ret_id' => $user_info['id']
    			);
    			$this->Score_model->save($sFields);
    			//发消息
    			$fields = array(
    					'message_type' => 'system',
    					'to_user_id' => $user_info['id'],
    					'from_user_id' => 0,
    					'content' => '恭喜您签到成功，获得' . $score . '个银象积分，积分可以用来换购商品哦，赶紧购物吧',
    					'map_id'=>$user_info['id'],
    					'add_time' => time()
    			);
    			$this->Message_model->save($fields);
    			//QQ登录并且用手机登录
    			if ($auth_type == 'qq' && $is_mobile) {
    				$session_id = $this->session->userdata['session_id'];
    				$this->session->set_userdata(array('user_id' => $user_info['id']));
    				redirect(base_url().'wx/member.html?login_type=sf&sid='.$session_id);
    				exit;
    			} else {
    				$this->_setCookie(array('id'=>$user_info['id'], 'nickname'=>$user_info['nickname'], 'username'=>$user_info['username'], 'login_time'=>$login_time, 'ip'=>'', 'ip_address'=>''), 0);
    			}
    		} else {
    			printAjaxError('fail', '登录失败！');
    		}
    	}
        if (!$is_mobile) {
        	redirect(base_url() . "index.php/user/index");
        }
    }

    /**
     * 注册获取短信验证码
     * @param mobile 手机号
     * @return json
     */
    public function get_reg_sms_code() {
        if ($_POST) {
            $type = $this->input->post('type', TRUE);
            $mobile = $this->input->post('mobile', TRUE);
            $code = $this->input->post('code', TRUE);
            if (!preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/', $mobile)) {
                printAjaxError('mobile', '请输入正确的手机号');
            }
            if (!$this->form_validation->required($code)) {
                printAjaxError('code', '请输入验证码');
            }
            $securitysecoder = new Securitysecoderclass();
            if (!$securitysecoder->check(strtolower($code))) {
                printAjaxError('code_fail', '验证码错误');
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
            if ($reponse > 0) {
                printAjaxSuccess('success', '验证码已经发送，注意查看手机短信');
            } else {
                printAjaxError('fail', '验证码发送失败，请重试');
            }
        }
    }

    public function logout() {
        $this->_deleteCookie();
        redirect(base_url() . 'index.php/user/login.html');
    }

    //找回密码
    public function get_pass() {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        if ($_POST) {
            $username = $this->input->post('username', TRUE);
            $code = $this->input->post('code', TRUE);
            $password = $this->input->post('password', TRUE);
            $refPassword = $this->input->post('ref_password', TRUE);
            $smscode = $this->input->post('smscode', TRUE);
            if (!$username) {
                printAjaxError('username', "手机号不能为空");
            }
            if (!$code) {
                printAjaxError('code', "验证码不能为空");
            }
            if (!$this->form_validation->required($password)) {
                printAjaxError('password', '请输入新密码');
            }
            if (!$this->form_validation->required($refPassword)) {
                printAjaxError('ref_password', '请输入确认密码');
            }
            if ($password != $refPassword) {
                printAjaxError('ref_password', '前后密码不一致');
            }
            $securitysecoder = new Securitysecoderclass();
            if (!$securitysecoder->check(strtolower($code))) {
                printAjaxError('code_fail', '验证码错误');
            }
            $userInfo = $this->User_model->get('id,username', array('lower(username)' => strtolower($username)));
            if (!$userInfo) {
                printAjaxError('fail', "手机号不存在");
            }
            $timestamp = time();
            if (!$this->Sms_model->get('id', "smscode = '$smscode' and mobile = $username and add_time > $timestamp - 15*60")) {
                printAjaxError('smscode', '短信验证码错误或者已过期');
            }
            $fields = array(
                'password' => $this->User_model->getPasswordSalt($userInfo['username'], $refPassword)
            );
            if ($this->User_model->save($fields, array('id' => $userInfo['id']))) {
                printAjaxSuccess('success_get_pass', '密码修改成功');
            } else {
                printAjaxError('fail', '密码修改失败');
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '找回密码',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/get_pass", $data, TRUE)
        );
        $this->load->view('layout/login_reg_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //修改个人资料
    public function change_user_info() {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>个人信息管理</a> > 编辑个人资料";
        $user_info = $this->User_model->get('*', array('user.id' => get_cookie('user_id')));
        if ($_POST) {
            $sex = $this->input->post("sex", TRUE);
            $nickname = trim($this->input->post("nickname", TRUE));
            $real_name = trim($this->input->post("real_name", TRUE));
            $alipay_account = trim($this->input->post("alipay_account", TRUE));
            $weixin_account = trim($this->input->post("weixin_account", TRUE));
            $ebank_account = trim($this->input->post("ebank_account", TRUE));

            if ($alipay_account || $weixin_account || $ebank_account) {
                if (!$real_name && !$user_info['real_name']) {
                    printAjaxError('fail', '请填写与账号对应的真实姓名');
                }
            }

            $fields = array(
                'sex' => $sex,
                'nickname' => $nickname
            );
            if (!$user_info['real_name']) {
            	$fields['real_name'] = $real_name;
            }
            if (!$user_info['alipay_account']) {
            	$fields['alipay_account'] = $alipay_account;
            }
            if (!$user_info['weixin_account']) {
            	$fields['weixin_account'] = $weixin_account;
            }
            if (!$user_info['ebank_account']) {
            	$fields['ebank_account'] = $ebank_account;
            }
            $ret = $this->User_model->save($fields, array('id' => get_cookie('user_id')));
            if ($ret) {
            	set_cookie('user_username', $nickname, 0);
                printAjaxSuccess('success', '修改成功');
            } else {
                printAjaxError('fail', '修改失败');
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '编辑个人资料',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'user_info' => $user_info,
            'location' => $location,
            'sex_arr' => $this->_sex_arr,
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/change_user_info', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    /**
	 * 绑定手机-实现手机与第三方账号同步登录
	 */
    public function bind_mobile() {
    	$prfUrl = $this->session->userdata('gloabPreUrl') ? $this->session->userdata('gloabPreUrl') : base_url() . "index.php/user";
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $userInfo = $this->User_model->get('*', array('user.id' => get_cookie('user_id')));
        if ($userInfo['username']) {
        	$data = array(
        			'user_msg' => '手机号已绑定，不用重复操作',
        			'user_url' => $prfUrl
        	);
        	$this->session->set_userdata($data);
        	redirect(base_url() . 'index.php/message/index');
        }
        if ($_POST) {
            $username = trim($this->input->post('mobile', TRUE));
            $code = $this->input->post('code', TRUE);
            $smscode = $this->input->post('smscode', TRUE);			
			$password = $this->input->post('password', TRUE);
			$ref_password = $this->input->post('ref_password', TRUE);
			
            if (!$this->form_validation->required($username)) {
                printAjaxError('mobile', '请输入手机号码');
            }
            if (!preg_match("/1[356789]\d{9}/", $username)) {
                printAjaxError('mobile', '请输入正确的手机号码');
            }
            if ($this->User_model->validateUnique($username)) {
                printAjaxError('mobile', '手机号码已经存在，请换一个');
            }
            if (!$this->form_validation->required($code)) {
                printAjaxError('code', '请输入图形验证码');
            }
            $securitysecoder = new Securitysecoderclass();
            if (!$securitysecoder->check(strtolower($code))) {
                printAjaxError('code_fail', '图形验证码错误');
            }
			if (!$smscode) {
				printAjaxError('smscode', '请输入短信验证码');
			}
            $timestamp = time();
            if (!$this->Sms_model->get('id', "smscode = '{$smscode}' and mobile = '{$username}' and add_time > {$timestamp} - 15*60")) {
                printAjaxError('smscode', '短信验证码错误或者已过期');
            }
			if (!$this->form_validation->required($password)) {
                printAjaxError('password', '请输入登录密码');
            }
            if (!$this->form_validation->required($ref_password)) {
                printAjaxError('ref_password', '请输入确认密码');
            }
            if ($password != $ref_password) {
                printAjaxError('ref_password', '前后密码不一致');
            }
			$addTime = $userInfo['add_time'];
            $fields = array(
                'mobile' => $username,
                'username' => $username,
                'password' => $this->_createPasswordSALT($username, $addTime, $password),
            );
            $ret_id = $this->User_model->save($fields, "id = {$userInfo['id']} and username = '' ");
            if ($ret_id) {
            	printAjaxSuccess($prfUrl, '恭喜您绑定手机号成功!');
            } else {
                printAjaxError('fail', '绑定手机号失败！');
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '绑定手机',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'userInfo' => $userInfo
        );
        $layout = array(
            'content' => $this->load->view('user/bind_mobile', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    /**
     * 修改登录密码
     */
    public function change_pass() {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>个人信息管理</a> > 修改密码";
        if ($_POST) {
            $oldPassword = $this->input->post('old_password', TRUE);
            $newPassword = $this->input->post('new_password', TRUE);
            $conPassword = $this->input->post('con_password', TRUE);

            //检测
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
            if (strlen($conPassword) < 6) {
                printAjaxError('con_password', '密码长度不能小于6位');
            }

            //验证密码是否正确
            $userInfo = $this->User_model->get('password, username', array('user.id' => get_cookie('user_id')));
            if (!$userInfo) {
                printAjaxError('fail', '此用户不存在');
            }
            if ($userInfo['password'] != $this->User_model->getPasswordSalt($userInfo['username'], $oldPassword)) {
                printAjaxError('old_password', '旧密码错误');
            }
            if ($this->User_model->getPasswordSalt($userInfo['username'], $conPassword) == $userInfo['password']) {
                printAjaxError('old_password', '旧密码不能与新密码一样');
            }
            $fields = array(
                'password' => $this->User_model->getPasswordSalt($userInfo['username'], $newPassword)
            );
            if ($this->User_model->save($fields, array('id' => get_cookie('user_id')))) {
                printAjaxSuccess('success', '密码修改成功');
            } else {
                printAjaxError('fail', '密码修改失败');
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '编辑个人资料',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'location' => $location,
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/change_pass', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    /**
     * 修改支付密码
     */
    public function change_pay_password() {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>个人信息管理</a> > 修改支付密码";
        $item_info = $this->User_model->getInfo('*', array('id'=>get_cookie('user_id')));
        if ($_POST) {
            $code = $this->input->post('code', TRUE);
			$smscode = $this->input->post('smscode', TRUE);
            $new_password = $this->input->post('new_password', TRUE);
            $con_password = $this->input->post('con_password', TRUE);

            if (!$this->form_validation->required($code)) {
                printAjaxError('code', '请输入图形验证码');
            }
            $securitysecoder = new Securitysecoderclass();
            if (!$securitysecoder->check(strtolower($code))) {
                printAjaxError('code_fail', '图形验证码错误');
            }
			if (!$smscode) {
				printAjaxError('smscode', '请输入短信验证码');
			}
            $timestamp = time();
            if (!$this->Sms_model->get('id', "smscode = '{$smscode}' and mobile = '{$item_info['username']}' and add_time > {$timestamp} - 15*60")) {
                printAjaxError('smscode', '短信验证码错误或者已过期');
            }
            if (!$this->form_validation->required($new_password)) {
                printAjaxError('new_password', '新密码不能为空');
            }
            if (!$this->form_validation->required($con_password)) {
                printAjaxError('con_password', '确认新密码不能为空');
            }
            if ($new_password != $con_password) {
                printAjaxError('con_password', '密码前后不一致');
            }
            if (strlen($con_password) < 6) {
                printAjaxError('con_password', '密码长度不能小于6位');
            }
            $fields = array(
                'pay_password' => $this->_createPasswordSALT($item_info['username'], $item_info['add_time'], $new_password)
            );
            if ($this->User_model->save($fields, array('id' => $item_info['id']))) {
                printAjaxSuccess('success', '支付密码修改成功');
            } else {
                printAjaxError('fail', '支付密码修改失败');
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '编辑个人资料',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'location' => $location,
            'html' => $systemInfo['html'],
            'item_info'=>$item_info,
        );
        $layout = array(
            'content' => $this->load->view('user/change_pay_password', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //产品收藏列表
    public function get_favorite_list($page = 0) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='" . base_url() . "index.php/user'>会员中心</a> > <a>我的交易</a> > 我的退换货";

        $strWhere = array('product_favorite.user_id' => get_cookie('user_id'));
        //分页
        $paginationCount = $this->Product_favorite_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/get_favorite_list/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
        $item_list = $this->Product_favorite_model->gets($strWhere, $paginationConfig['per_page'], $page);

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '我的收藏',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'item_list' => $item_list,
            'pagination' => $pagination,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'perPage' => $paginationConfig['per_page'],
            'location' => $location,
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/get_favorite_list', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_delete_favorite() {
        //判断是否登录
        checkLoginAjax();
        if ($_POST) {
            $id = $this->input->post('id', TRUE);
            if (!$id) {
                printAjaxError('fail', '操作异常');
            }

            if ($this->Product_favorite_model->delete(array('id' => $id, 'user_id' => get_cookie('user_id')))) {
                printAjaxData(array('id' => $id));
            } else {
                printAjaxError('fail', '删除失败！');
            }
        }
    }

    public function delete_address() {
        checkLoginAjax();
        if ($_POST) {
            $uid = get_cookie('user_id');
            $address_ids = trim($this->input->post('address_ids', true), ',');
            $result = $this->User_address_model->delete("id in ($address_ids) and user_id = $uid");
            if ($result) {
                printAjaxSuccess('success', '删除成功!');
            } else {
                printAjaxError('fail', '删除失败！');
            }
        }
    }

    //投诉列表
    public function get_user_probleme_list($page = 0) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='" . base_url() . "index.php/user'>会员中心</a> > <a>我的交易</a> > 我的退换货";
        $status = array(0 => '待审核', 1 => '审核未通过', 2 => '审核通过');

        //分页
        $paginationCount = $this->Guestbook_model->rowCount(array('user_id' => get_cookie('user_id')));
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/get_user_probleme_list/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->Guestbook_model->gets('*', array('user_id' => get_cookie('user_id')), $paginationConfig['per_page'], $page);

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '投诉列表',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'status' => $status,
            'item_list' => $item_list,
            'pagination' => $pagination,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'perPage' => $paginationConfig['per_page'],
            'location' => $location,
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/get_user_probleme_list', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //我要投诉
    public function save_probleme() {
        $prfUrl = $this->session->userdata('gloabPreUrl');
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>我的交易</a> > <a href='index.php/user/get_user_probleme_list.html'>我的投诉</a> > 我要投诉";

        if ($_POST) {
            $content = $this->input->post("content", TRUE);
            if (!$content) {
                printAjaxError('fail', '投诉内容不能为空');
            }

            $fields = array(
                'content' => $content,
                'add_time' => time(),
                'user_id' => get_cookie('user_id')
            );
            if ($this->Guestbook_model->save($fields)) {
                printAjaxSuccess($prfUrl, '投诉成功');
            } else {
                printAjaxError('fail', '投诉失败');
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '我要投诉',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'location' => $location,
            'prfUrl' => $prfUrl,
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/save_probleme', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //退换货列表
    public function get_user_exchange_list($exchange_status = 'all',$page = 0) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='" . base_url() . "index.php/user'>会员中心</a> > <a>我的交易</a> > 我的退换货";
        $status = array(0 => '待审核', 1 => '审核未通过', 2 => '审核通过');
           if($exchange_status == 'all'){
            $strWhere = "user_id = ".get_cookie('user_id');
        }else{
            $exchange_status = intval($exchange_status);
            $strWhere = "user_id = ".get_cookie('user_id')." and status = {$exchange_status}";
        }
        //分页
        $paginationCount = $this->Exchange_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/get_user_exchange_list/{$exchange_status}";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
        $item_list = $this->Exchange_model->gets('*',$strWhere, $paginationConfig['per_page'], $page);
        foreach ($item_list as $key => $ls) {
            $order_info = $this->Orders_model->get('id,total,status', array('order_number' => $ls['order_number']));
            $orders_detail = $this->Orders_detail_model->get('product_id,product_title,path', array('id' => $ls['orders_detail_id']));
            $item_list[$key]['product'] = $orders_detail;
            $item_list[$key]['total_price'] = $order_info['total'];
            $item_list[$key]['expired'] = 0;
            if ($order_info['status'] == 4) {
                $order_period = $this->Orders_process_model->get('add_time', "order_id = {$order_info['id']} and content like '%交易成功%'");
                if ($order_period['add_time'] + 7 * 24 * 60 * 60 < time()) {
                    $item_list[$key]['expired'] = 1;
                }
            }
        }
        $count_0 = $this->Exchange_model->rowCount(array('status' => 0, 'user_id' => get_cookie('user_id')));
        $count_1 = $this->Exchange_model->rowCount(array('status' => 1, 'user_id' => get_cookie('user_id')));
        $count_2 = $this->Exchange_model->rowCount(array('status' => 2, 'user_id' => get_cookie('user_id')));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '退换货列表',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'status' => $status,
            'item_list' => $item_list,
            'pagination' => $pagination,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'perPage' => $paginationConfig['per_page'],
            'location' => $location,
            'html' => $systemInfo['html'],
            'exchange_type_arr' => $this->_exchange_type,
            'exchange_status' => $exchange_status,
            'count_0' => $count_0,
            'count_1' => $count_1,
            'count_2' => $count_2,
        );
        $layout = array(
            'content' => $this->load->view('user/get_user_exchange_list', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function buyer_post_goods($id = null) {
        //判断是否登录
        checkLogin();
        $go_url = $this->session->userdata('gloabPreUrl');
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->Exchange_model->get('*', array('user_id' => get_cookie('user_id'), 'id' => $id));
        if (empty($item_info)) {
            $data = array(
                'user_msg' => '此退款信息不存在',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        if ($_POST) {
            $default_address = $this->User_address_model->get('txt_address,address,buyer_name,mobile', array('default' => 1, 'user_id' => $user_id));
            if (!$default_address) {
                printAjaxError('fail', '没有默认地址');
            }
            $user_address = "{$default_address['buyer_name']}，{$default_address['mobile']}，{$default_address['txt_address']}{$default_address['address']}";
            $fields = array(
                'buyer_express_num' => $this->input->post('buyer_express_num', true),
                'buyer_experss_com' => $this->input->post('buyer_express_com', true),
                'buyer_post_remark' => $this->input->post('buyer_post_remark', true),
                'user_address' => $user_address,
            );
            $this->Exchange_model->save($fields, array('id' => $id));
            printAjaxSuccess(getBaseUrl(false, '', 'user/get_user_exchange_list', $systemInfo['client_index']), '提交成功');
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '买家退货给卖家',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info,
            'return_address' => $systemInfo['return_address']
        );
        $layout = array(
            'content' => $this->load->view('user/buyer_post_goods', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_delete_problem() {
        //判断是否登录
        checkLoginAjax();
        if ($_POST) {
            $id = $this->input->post("id", TRUE);
            if (!$id) {
                printAjaxError('fail', '操作异常');
            }

            if ($this->Guestbook_model->delete(array('id' => $id, 'user_id' => get_cookie('user_id')))) {
                printAjaxData(array('id' => $id));
            } else {
                printAjaxError('fail', '删除失败！');
            }
        }
    }

    //申请退换货
    public function save_exchange($id = NULL) {
        $prfUrl = $this->session->userdata('gloabPreUrl');
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $tabTitle = '申请';
        if ($id) {
            $tabTitle = '修改';
        }
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>我的交易</a> > <a href='index.php/user/get_user_exchange_list.html'>我的退换货</a> > {$tabTitle}申请退换货";
        $item_info = $this->Exchange_model->get('*', array('user_id' => get_cookie('user_id'), 'id' => $id));
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
            if (empty($order_info)) {
                printAjaxError('order_number', '退换货订单号错误');
            }
            $order_detail = $this->Orders_detail_model->get('id,buy_price', array('id' => $orders_detail_id, 'order_id' => $order_info['id']));
            if (empty($order_detail)) {
                printAjaxError('orders_detail_id', '退换货订单详细id错误');
            }
            $orders_detail_count = $this->Orders_detail_model->rowCount(array('order_id' => $order_info['id']));
            if ($id) {
                if ($item_info['status'] == 2) {
                    printAjaxError('fail', '此单已处理完成，不能再修改');
                }
            }
            if (!$order_number) {
                printAjaxError('order_number', '退换货订单号不能为空');
            }
            if (empty($refund_cause)) {
                printAjaxError('fail', '请选择退换货原因');
            }
            $ordersInfo = $this->Orders_model->get('status, total,pay_mode', array('order_number' => $order_number, 'user_id' => get_cookie('user_id')));
            if (!$ordersInfo) {
                printAjaxError('fail', '此订单号不存在，请认真确认订单号');
            }
            if ($ordersInfo['pay_mode'] == 1) {
                printAjaxError('fail', '不受理礼品订单退换货，有问题，请联系网站客服！');
            }
            if ($exchange_type == 1) {
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
            //备货中
            if ($ordersInfo['status'] == 2) {
                printAjaxError('fail', '此订单备货中，不能申请退换货');
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
                'user_id' => get_cookie('user_id'),
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
            );
            if ($exchange_type == 1) {
                $fields['refund_amount'] = floatval($this->input->post('refund_amount', true));
            }
            if ($this->Exchange_model->save($fields, $id ? array('id' => $id, 'user_id' => get_cookie('user_id')) : NULL)) {
                printAjaxSuccess(getBaseUrl(false, '', 'user/get_user_exchange_list', $systemInfo['client_index']), '申请退换货成功');
            } else {
                printAjaxError('fail', '申请退换货失败');
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '申请退换货',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'item_info' => $item_info,
            'tabTitle' => $tabTitle,
            'location' => $location,
            'prfUrl' => $prfUrl,
            'exchange_type' => $this->_exchange_type,
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/save_exchange', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //查看退换货详情
    public function get_view_exchange($id = NULL) {
        $prfUrl = $this->session->userdata('gloabPreUrl');
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>我的交易</a> > <a href='index.php/user/get_user_exchange_list.html'>我的退换货</a> > 查看退换货详情";
        $status = array(0 => '待审核', 1 => '审核未通过', 2 => '审核通过');
        $item_info = $this->Exchange_model->get('*', array('user_id' => get_cookie('user_id'), 'id' => $id));

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '申请退换货',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'item_info' => $item_info,
            'location' => $location,
            'prfUrl' => $prfUrl,
            'status' => $status,
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/get_view_exchange', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //删除退换货申请
    public function my_delete_exchange() {
        //判断是否登录
        checkLoginAjax();
        if ($_POST) {
            $id = $this->input->post("id", TRUE);
            if (!$id) {
                printAjaxError('fail', '操作异常');
            }
            if ($this->Exchange_model->delete(array('id' => $id, 'status' => 0, 'user_id' => get_cookie('user_id')))) {
                printAjaxData(array('id' => $id));
            } else {
                printAjaxError('fail', '删除失败！');
            }
        }
    }

    //收货地址列表
    public function get_user_address_list() {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>个人信息管理</a> > 收货地址";
        $user_address_list = $this->User_address_model->gets('*', array('user_id' => get_cookie('user_id')));

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '收货地址列表',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'user_address_list' => $user_address_list,
            'location' => $location,
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/get_user_address_list', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //编辑收货地址
    public function save_address($id = NULL) {
        $prfUrl = $this->session->userdata('gloabPreUrl');
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $tabTitle = '添加';
        if ($id) {
            $tabTitle = '修改';
        }
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>个人信息管理</a> > <a href='index.php/user/get_user_address_list.html'>收货地址 </a> > {$tabTitle}收货地址";
        if ($_POST) {
            $buyer_name = $this->input->post('buyer_name', TRUE);
            $mobile = $this->input->post('mobile', TRUE);
            $phone = $this->input->post('phone', TRUE);
            $zip = $this->input->post('zip', TRUE);
			$email = $this->input->post('email', TRUE);
            $province_id = $this->input->post('province_id', TRUE);
            $city_id = $this->input->post('city_id', TRUE);
            $area_id = $this->input->post('area_id', TRUE);
            $address = $this->input->post('address', TRUE);
            $default = $this->input->post('default', TRUE);

            if (!$buyer_name) {
                printAjaxError('buyer_name', '姓名不能为空');
            }
            if (!$mobile) {
                printAjaxError('mobile', '手机号不能为空');
            }
			if ($phone) {
				if (!preg_match("/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/", $phone)) {
	                printAjaxError('phone', '请输入正确的固定电话');
	            }
			}
            if (!$province_id) {
                printAjaxError('province_id', '选择省');
            }
            if (!$city_id) {
                printAjaxError('city_id', '选择市');
            }
            if (!$address) {
                printAjaxError('address', '请填写详细地址');
            }
            $txt_address_str = '';
            $area_info = $this->Area_model->get('name', array('id' => $province_id));
            if ($area_info) {
                $txt_address_str .= $area_info['name'];
				$area_info = $this->Area_model->get('name', array('id' => $city_id));
	            if ($area_info) {
	                $txt_address_str .= ' ' . $area_info['name'];
					$area_info = $this->Area_model->get('name', array('id' => $area_id));
		            if ($area_info) {
		                $txt_address_str .= ' ' . $area_info['name'];
		            }
	            }
            }
			if ($zip && !preg_match("/^[1-9]\d{5}$/", $zip)) {
                printAjaxError('zip', '请输入正确的邮编');
            }
			if ($email && !preg_match("/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/", $email)) {
                printAjaxError('email', '请输入正确的邮箱');
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
                'email'=> $email,
                'user_id' => get_cookie('user_id'),
            );
            //当收货地址为一个时，设为默认
            if ($this->User_address_model->rowCount(array('user_id' => get_cookie('user_id'))) == 0) {
                $fields['default'] = 1;
            }
            if ($this->User_address_model->rowCount(array('user_id' => get_cookie('user_id'))) > 10) {
                printAjaxError('fail', '最多只能设置十个收货地址');
            }
            if ($default == 1) {
                $this->User_address_model->save(array('default' => 0), array('user_id' => get_cookie('user_id'), 'default' => 1));
            }
            if ($this->User_address_model->save($fields, $id ? array('id' => $id) : NULL)) {
                printAjaxSuccess($prfUrl, '收货地址操作成功');
            } else {
                printAjaxError('fail', '收货地址操作失败');
            }
        }
        $item_info = $this->User_address_model->get('*', array('user_id' => get_cookie('user_id'), 'id' => $id));
        $areaList = $this->Area_model->gets('*', array('parent_id' => 0));
		
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '编辑收货地址',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'item_info' => $item_info,
            'areaList' => $areaList,
            'tabTitle' => $tabTitle,
            'location' => $location,
            'prfUrl' => $prfUrl,
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/save_address', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function my_change_default() {
        //判断是否登录
        checkLoginAjax();
        if ($_POST) {
            $state = $this->input->post('state', TRUE);
            $id = $this->input->post('id', TRUE);
            if ($state != NULL && $state != "" && $id) {
                //设置成默认
                if ($state) {
                    $fields = array(
                        'default' => $state
                    );
                    $this->User_address_model->save($fields, array('id' => $id, 'user_id' => get_cookie('user_id')));

                    $fields = array(
                        'default' => 0
                    );
                    if ($this->User_address_model->save($fields, "user_id = " . get_cookie('user_id') . " and id <> {$id} ")) {
                        printAjaxSuccess('success', '操作成功');
                    } else {
                        printAjaxError('fail', '操作失败');
                    }
                } else {
                    $fields = array(
                        'default' => $state
                    );
                    if ($this->User_address_model->save($fields, array('id' => $id, 'user_id' => get_cookie('user_id')))) {
                        printAjaxSuccess('success', '操作成功');
                    } else {
                        printAjaxError('fail', '操作失败');
                    }
                }
            } else {
                printAjaxError('fail', '操作异常');
            }
        }
    }

    public function get_score_list($score_type = 'gold', $page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $user_id = get_cookie('user_id');
        $strWhere = "user_id = {$user_id} and score_type = '{$score_type}' ";
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>我的积分</a> > 消费记录";
        //分页
        $paginationCount = $this->Score_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/get_score_list/{$score_type}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->Score_model->gets($strWhere, $paginationConfig['per_page'], $page);
        $user_info = $this->User_model->get('*', array('user.id' =>$user_id));

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '积分消费记录',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'item_list' => $item_list,
            'html' => $systemInfo['html'],
            'location' => $location,
            'user_info' => $user_info,
        	'score_type_arr'=>$this->_score_type_arr,
            'pagination' => $pagination,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'perPage' => $paginationConfig['per_page'],
        	'score_type'=>$score_type
        );
        $layout = array(
            'content' => $this->load->view('user/get_score_list', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //积分查询
    public function score_select() {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	//判断是否登录
    	checkLogin();
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	$cur_user_info = $this->User_model->get('id,user_type', array('id'=>get_cookie('user_id')));
    	if (!$cur_user_info) {
    		printAjaxError('fail', '您的账户信息不存在');
    	}
    	if ($cur_user_info['user_type'] != 1) {
    		printAjaxError('fail', '此功能只有商家才能使用');
    	}

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => $systemInfo['site_name'] . '_' . '积分查询',
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html']
    	);
    	$layout = array(
    			'content' => $this->load->view('user/score_select', $data, TRUE)
    	);
    	$this->load->view('layout/user_default', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    public function my_user_score_search() {
        checkLoginAjax();
        if ($_POST) {
        	$user_id = get_cookie('user_id');
            $username = trim($this->input->post('username', TRUE));
            if (!$username) {
                printAjaxError('fail', '请输入顾客账号/手机号');
            }
            $cur_user_info = $this->User_model->get('id,user_type', array('id'=>$user_id));
            if (!$cur_user_info) {
            	printAjaxError('fail', '您的账户信息不存在');
            }
            if ($cur_user_info['user_type'] != 1) {
            	printAjaxError('fail', '此功能只有商家才能使用');
            }
            $user_info = $this->User_model->get('id, display, username, nickname, real_name, total, score_gold, score_silver, total_gold, total_silver', array('username'=>$username));
            if (!$user_info) {
            	printAjaxError('fail', '顾客账户信息不存在');
            }
            if ($user_info['display'] == 0) {
            	printAjaxError('fail', '顾客账户未激活，请联系网站客服');
			} else if ($user_info['display'] == 2) {
				printAjaxError('fail', '顾客账户被冻结，请联系网站客服');
			} else if ($user_info['display'] == 3) {
				printAjaxError('fail', '顾客账户被冻结，请联系网站客服');
			}
			if ($user_id == $user_info['id']) {
				printAjaxError('fail', '只能查询顾客信息');
			}
            printAjaxData($user_info);
        }
    }

    //扣积分
    public function my_reduce_user_score() {
    	checkLoginAjax();
    	if ($_POST) {
    		$user_id = get_cookie('user_id');
    		$to_user_id = $this->input->post('to_user_id', TRUE);
    		$reduce_score_type = $this->input->post('reduce_score_type', TRUE);
    		$reduce_score = $this->input->post('reduce_score', TRUE);
    		$reduce_code = $this->input->post('reduce_code', TRUE);
    		$reduce_remark = $this->input->post('reduce_remark', TRUE);

    		$cur_user_info = $this->User_model->get('id,user_type, seller_grade, username, score_gold, score_silver', array('id'=>$user_id));
    		if (!$cur_user_info) {
    			printAjaxError('fail', '您的账户信息不存在');
    		}
    		if ($cur_user_info['user_type'] != 1) {
    			printAjaxError('fail', '此功能只有商家才能使用');
    		}
    		if (!$to_user_id) {
    			printAjaxError('to_user_id', '操作异常，请重新查询顾客信息');
    		}
    		$user_info = $this->User_model->get('id, display, username, nickname, real_name, total, score_gold, score_silver, total_gold, total_silver', array('id'=>$to_user_id));
    		if (!$user_info) {
    			printAjaxError('fail', '顾客账户信息不存在');
    		}
    		if ($user_info['display'] == 0) {
    			printAjaxError('fail', '顾客账户未激活，请联系网站客服');
    		} else if ($user_info['display'] == 2) {
    			printAjaxError('fail', '顾客账户被冻结，请联系网站客服');
    		} else if ($user_info['display'] == 3) {
    			printAjaxError('fail', '顾客账户被冻结，请联系网站客服');
    		}
    		if ($user_id == $user_info['id']) {
    			printAjaxError('fail', '不能自己操作自己');
    		}
    		if (!$reduce_score_type) {
    			printAjaxError('reduce_score_type', '请选择积分类型');
    		}
    		if ($reduce_score_type != 'gold' && $reduce_score_type != 'silver') {
    			printAjaxError('reduce_score_type', '请选择正确的积分类型');
    		}
    		if ($cur_user_info['seller_grade'] == 'a') {
    		    if ($reduce_score_type != 'gold') {
    		    	printAjaxError('fail', 'A类商家，消费者只能使用金象积分消费');
    		    }
    		}
    		if (!$reduce_score) {
    			printAjaxError('reduce_score', '请输入积分数量');
    		}
    		if (!$this->form_validation->integer($reduce_score)) {
    			printAjaxError('reduce_score', '请输入正确的积分数量');
    		}
    		if (!$reduce_code) {
    			printAjaxError('reduce_code', '请输入短信验证码');
    		}
    		if (!$reduce_remark) {
    			printAjaxError('reduce_remark', '请输入提示内容');
    		}
    		if ($reduce_score_type == 'gold') {
                if ($reduce_score > $user_info['score_gold']) {
                	printAjaxError('fail', '顾客金象积分余额不足');
                }
                //扣顾客积分
                $balance = $user_info['score_gold'] - $reduce_score;
                if ($this->User_model->save(array('score_gold'=>$balance), array('id'=>$user_info['id']))) {
                	$fields = array(
                			'cause' => '扣金象积分-用积分在实体店换购',
                			'score' => -$reduce_score,
                			'balance' => $balance,
                			'score_type'=>'gold',
                			'type' => 'recharge_out',
                			'add_time' => time(),
                			'username' => $user_info['username'],
                			'user_id' =>  $user_info['id'],
                			'ret_id' =>   $cur_user_info['id']
                	);
                	$this->Score_model->save($fields);
                }
                //商家加积分
                $balance = $cur_user_info['score_gold'] + $reduce_score;
                if ($this->User_model->save(array('score_gold'=>$balance), array('id'=>$cur_user_info['id']))) {
                	$fields = array(
                			'cause' => '返金象积分-顾客在实体店用积分消费',
                			'score' => $reduce_score,
                			'balance' => $balance,
                			'score_type'=>'gold',
                			'type' => 'recharge_in',
                			'add_time' => time(),
                			'username' => $cur_user_info['username'],
                			'user_id' =>  $cur_user_info['id'],
                			'ret_id' =>  $cur_user_info['id']
                	);
                	$this->Score_model->save($fields);
                }
    		} else if ($reduce_score_type == 'silver') {
    			if ($reduce_score > $user_info['score_silver']) {
    				printAjaxError('fail', '顾客银象积分余额不足');
    			}
    			//扣顾客积分
    			$balance = $user_info['score_silver'] - $reduce_score;
    			if ($this->User_model->save(array('score_silver'=>$balance), array('id'=>$user_info['id']))) {
    				$fields = array(
    						'cause' => '扣银象积分-用积分在实体店换购',
    						'score' => -$reduce_score,
    						'balance' => $balance,
    						'score_type'=>'silver',
    						'type' => 'recharge_out',
    						'add_time' => time(),
    						'username' => $user_info['username'],
    						'user_id' =>  $user_info['id'],
    						'ret_id' =>  $cur_user_info['id']
    				);
    				$this->Score_model->save($fields);
    			}
    			//商家加积分
    			$balance = $cur_user_info['score_silver'] + $reduce_score;
    			if ($this->User_model->save(array('score_silver'=>$balance), array('id'=>$cur_user_info['id']))) {
    				$fields = array(
    						'cause' => '返银象积分-用积分在实体店换购',
    						'score' =>  $reduce_score,
    						'balance' => $balance,
    						'score_type'=>'silver',
    						'type' => 'recharge_in',
    						'add_time' => time(),
    						'username' => $cur_user_info['username'],
    						'user_id' =>  $cur_user_info['id'],
    						'ret_id' =>  $user_info['id']
    				);
    				$this->Score_model->save($fields);
    			}
    		}
    		$user_info = $this->User_model->get('id, display, username, nickname, real_name, total, score_gold, score_silver, total_gold, total_silver', array('id'=>$to_user_id));
    	    printAjaxData($user_info);
    	}
    }

    //提现-金象、银象币提现
    public function withdraw_elephant($score_type = 'gold') {
    	$go_url = $this->session->userdata('gloabPreUrl');
    	//判断是否登录
    	checkLogin();
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	$score_setting_info = $this->Score_setting_model->get('*', array('id' => 1));
    	//当前位置
    	$user_id = get_cookie('user_id');
    	$location = "<a href='index.php/user.html'>会员中心</a> > <a>我的财务</a> > <a>我的资产</a> > 提现";
    	$user_info = $this->User_model->get('*', array('id' =>$user_id));
    	$score_type_str = $score_type == 'gold'?'金象币':'金象币';
    	if (!$user_info) {
    		$data = array(
    					'user_msg' => '您的账户信息不存在',
    					'user_url' => $go_url
    			);
    		$this->session->set_userdata($data);
    		redirect('/message/index');
    	}
    	if ($user_info['user_type'] != 1) {
    		$data = array(
    				'user_msg' => '此功能只有商家才能使用',
    				'user_url' => $go_url
    		);
    		$this->session->set_userdata($data);
    		redirect('/message/index');
    	}

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => '提现_' . $systemInfo['site_name'],
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'location' => $location,
    			'score_type'=>$score_type,
    			'score_type_str'=>$score_type_str,
    			'score_setting_info'=>$score_setting_info,
    			'user_info' => $user_info
    	);
    	$layout = array(
    			'content' => $this->load->view('user/withdraw_elephant', $data, TRUE)
    	);
    	$this->load->view('layout/user_default', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    //申请提现
    public function add_withdraw() {
    	checkLoginAjax();
    	$go_url = base_url().'index.php/user/get_elephant_log_list.html';
    	if ($_POST) {
    		$user_id = get_cookie('user_id');
    		$account_type = $this->input->post('account_type', TRUE);
    		$score_type = $this->input->post('score_type', TRUE);
    		$score_num = $this->input->post('score_num', TRUE);

    		$user_info = $this->User_model->get('*', array('id' =>$user_id));
    		if (!$user_info) {
    			printAjaxError('fail', '您的账户信息不存在');
    		}
    		if ($user_info['user_type'] != 1) {
    			printAjaxError('fail', '此功能只有商家才能使用');
    		}
    		if (!$user_info['total_gold_rmb_pre'] || !$user_info['total_silver_rmb_pre']) {
    			printAjaxError('fail', '还未设置签约提现兑换比例，联系网站客服以解决');
    		}
    		if (!$score_type) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}
    		if (!$score_num) {
    			printAjaxError('score_num', '请输入提现数量');
    		}
    		if (!$account_type) {
    			printAjaxError('fail', '请选择账号类型');
    		}
    		$account = '';
    		$real_name = '';
    		if ($account_type == 'alipay') {
    			$account = $user_info['alipay_account'];
    			$real_name = $user_info['real_name'];
    			if (!$account || !$real_name) {
    				printAjaxError('fail', '支付宝账号未绑定');
    			}
    		} else if ($account_type == 'weixin') {
    			$account = $user_info['weixin_account'];
    			$real_name = $user_info['real_name'];
    			if (!$account || !$real_name) {
    				printAjaxError('fail', '微信账号未绑定');
    			}
    		} else if ($account_type == 'ebank') {
    			$account = $user_info['ebank_account'];
    			$real_name = $user_info['real_name'];
    			if (!$account || !$real_name) {
    				printAjaxError('fail', '银联账号未绑定');
    			}
    		} else {
    			printAjaxError('fail', '请选择正确的账号类型');
    		}
    		if ($score_type == 'gold') {
    			if ($score_num > $user_info['total_gold']) {
    				printAjaxError('fail', '金象币超过最大提现数量，提现失败');
    			}
    			//提现记录
    			$fields = array(
    					'type'=>$account_type,
    					'account'=>$account,
    					'real_name'=>$real_name,
    					'price'=>$score_num/$user_info['total_gold_rmb_pre'],
    					'add_time'=>time(),
    					'user_id'=>$user_info['id'],
    					'username'=>$user_info['username'],
    					'score_type'=>$score_type,
    					'score_num'=>$score_num
    			);
    			$ret_id = $this->Withdraw_model->save($fields);
    			//扣币记录
    			$balance = $user_info['total_gold'] - $score_num;
    			if ($this->User_model->save(array('total_gold'=>$balance), array('id'=>$user_info['id']))) {
    				$fields = array(
    						'cause' => '提现支付-对金象币进行提现&nbsp;[处理中]',
    						'score' => -$score_num,
    						'balance' => $balance,
    						'score_type'=>'gold',
    						'type' => 'withdraw_out',
    						'add_time' => time(),
    						'username' => $user_info['username'],
    						'user_id' =>  $user_info['id'],
    						'ret_id' =>  $ret_id
    				);
    				$this->Elephant_log_model->save($fields);
    			}
    		} else if ($score_type == 'silver') {
    			if ($score_num > $user_info['total_silver']) {
    				printAjaxError('fail', '银象币超过最大提现数量，提现失败');
    			}
    			//提现记录
    			$fields = array(
    					'type'=>$account_type,
    					'account'=>$account,
    					'real_name'=>$real_name,
    					'price'=>$score_num/$user_info['total_silver_rmb_pre'],
    					'add_time'=>time(),
    					'user_id'=>$user_info['id'],
    					'username'=>$user_info['username'],
    					'score_type'=>$score_type,
    					'score_num'=>$score_num
    			);
    			$ret_id = $this->Withdraw_model->save($fields);
    			//扣币记录
    			$balance = $user_info['total_silver'] - $score_num;
    			if ($this->User_model->save(array('total_silver'=>$balance), array('id'=>$user_info['id']))) {
    				$fields = array(
    						'cause' => '提现支付-对银象币进行提现&nbsp;[处理中]',
    						'score' => -$score_num,
    						'balance' => $balance,
    						'score_type'=>'silver',
    						'type' => 'withdraw_out',
    						'add_time' => time(),
    						'username' => $user_info['username'],
    						'user_id' =>  $user_info['id'],
    						'ret_id' =>  $ret_id
    				);
    				$this->Elephant_log_model->save($fields);
    			}
    		} else {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}

    		printAjaxSuccess($go_url, '提现申请已提交，请等待审核');
    	}
    }

    //返积分
    public function my_add_user_score() {
    	checkLoginAjax();
    	if ($_POST) {
    		$user_id = get_cookie('user_id');
    		$to_user_id = $this->input->post('to_user_id', TRUE);
    		$add_score_type = $this->input->post('add_score_type', TRUE);
    		$add_score = $this->input->post('add_score', TRUE);
    		$add_remark = $this->input->post('add_remark', TRUE);

    		$cur_user_info = $this->User_model->get('id,user_type, seller_grade, username, score_gold, score_silver', array('id'=>$user_id));
    		if (!$cur_user_info) {
    			printAjaxError('fail', '您的账户信息不存在');
    		}
    		if ($cur_user_info['user_type'] != 1) {
    			printAjaxError('fail', '此功能只有商家才能使用');
    		}
    		if (!$to_user_id) {
    			printAjaxError('to_user_id', '操作异常，请重新查询顾客信息');
    		}
    		$user_info = $this->User_model->get('id, display, username, nickname, real_name, total, score_gold, score_silver, total_gold, total_silver', array('id'=>$to_user_id));
    		if (!$user_info) {
    			printAjaxError('fail', '顾客账户信息不存在');
    		}
    		if ($user_info['display'] == 0) {
    			printAjaxError('fail', '顾客账户未激活，请联系网站客服');
    		} else if ($user_info['display'] == 2) {
    			printAjaxError('fail', '顾客账户被冻结，请联系网站客服');
    		} else if ($user_info['display'] == 3) {
    			printAjaxError('fail', '顾客账户被冻结，请联系网站客服');
    		}
    		if ($user_id == $user_info['id']) {
    			printAjaxError('fail', '不能自己操作自己');
    		}
    		if (!$add_score_type) {
    			printAjaxError('add_score_type', '请选择积分类型');
    		}
    		if ($add_score_type != 'gold' && $add_score_type != 'silver') {
    			printAjaxError('add_score_type', '请选择正确的积分类型');
    		}
    		if ($cur_user_info['seller_grade'] == 'a') {
    			if ($add_score_type != 'gold') {
    				printAjaxError('fail', 'A类商家只能返金象积分');
    			}
    		}
    		if (!$add_score) {
    			printAjaxError('add_score', '请输入积分数量');
    		}
    		if (!$this->form_validation->integer($add_score)) {
    			printAjaxError('add_score', '请输入正确的积分数量');
    		}
    		if (!$add_remark) {
    			printAjaxError('add_remark', '请输入提示内容');
    		}
    		if ($add_score_type == 'gold') {
    			if ($add_score > $cur_user_info['score_gold']) {
    				printAjaxError('fail_recharge', '商家金象积分余额不足，请充值');
    			}
    			//扣商家积分
    			$balance = $cur_user_info['score_gold'] - $add_score;
    			if ($this->User_model->save(array('score_gold'=>$balance), array('id'=>$cur_user_info['id']))) {
    				$fields = array(
    						'cause' => '扣金象积分-消费者在实体店消费返积分',
    						'score' => -$add_score,
    						'balance' => $balance,
    						'score_type'=>'gold',
    						'type' => 'recharge_out',
    						'add_time' => time(),
    						'username' => $cur_user_info['username'],
    						'user_id' =>  $cur_user_info['id'],
    						'ret_id' =>  $user_info['id']
    				);
    				$this->Score_model->save($fields);
    			}
    			//顾客加积分
    			$balance = $user_info['score_gold'] + $add_score;
    			if ($this->User_model->save(array('score_gold'=>$balance), array('id'=>$user_info['id']))) {
    				$fields = array(
    						'cause' => '返金象积分-在实体店消费返积分',
    						'score' => $add_score,
    						'balance' => $balance,
    						'score_type'=>'gold',
    						'type' => 'recharge_in',
    						'add_time' => time(),
    						'username' => $user_info['username'],
    						'user_id' =>  $user_info['id'],
    						'ret_id' =>  $cur_user_info['id']
    				);
    				$this->Score_model->save($fields);
    			}
    		} else if ($add_score_type == 'silver') {
    			if ($add_score > $cur_user_info['score_silver']) {
    				printAjaxError('fail_recharge', '商家银象积分余额不足,请充值');
    			}
    			//扣商家积分
    			$balance = $cur_user_info['score_silver'] - $add_score;
    			if ($this->User_model->save(array('score_silver'=>$balance), array('id'=>$cur_user_info['id']))) {
    				$fields = array(
    						'cause' => '扣银象积分-消费者在实体店消费返积分',
    						'score' => -$add_score,
    						'balance' => $balance,
    						'score_type'=>'silver',
    						'type' => 'recharge_out',
    						'add_time' => time(),
    						'username' => $cur_user_info['username'],
    						'user_id' =>  $cur_user_info['id'],
    						'ret_id' =>  $user_info['id']
    				);
    				$this->Score_model->save($fields);
    			}
    			//顾客加积分
    			$balance = $user_info['score_silver'] + $add_score;
    			if ($this->User_model->save(array('score_silver'=>$balance), array('id'=>$user_info['id']))) {
    				$fields = array(
    						'cause' => '返银象积分-在实体店消费返积分',
    						'score' =>  $add_score,
    						'balance' => $balance,
    						'score_type'=>'silver',
    						'type' => 'recharge_in',
    						'add_time' => time(),
    						'username' => $user_info['username'],
    						'user_id' =>  $user_info['id'],
    						'ret_id' =>  $cur_user_info['id']
    				);
    				$this->Score_model->save($fields);
    			}
    		}
    		$user_info = $this->User_model->get('id, display, username, nickname, real_name, total, score_gold, score_silver, total_gold, total_silver', array('id'=>$to_user_id));
    		printAjaxData($user_info);
    	}
    }

    public function get_financial_list($page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $strWhere = "user_id = '" . get_cookie('user_id') . "'";
        //当前位置
        $location = "<a href='index.php/user'>会员中心</a> > <a>预存款</a> > 财务记录";
        //分页
        $paginationCount = $this->Financial_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/get_financial_list/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->Financial_model->gets($strWhere, $paginationConfig['per_page'], $page);
        $user_info = $this->User_model->get('total,pay_password', array('user.id' => get_cookie('user_id')));

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '积分消费记录',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'item_list' => $item_list,
            'html' => $systemInfo['html'],
        	'financial_type_arr'=>$this->_financial_type_arr,
            'location' => $location,
            'user_info' => $user_info,
            'pagination' => $pagination,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'perPage' => $paginationConfig['per_page']
        );
        $layout = array(
            'content' => $this->load->view('user/get_financial_list', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    /**
     * 金象币、银象币消费记录
     * @param string $score_type
     * @param number $page
     */
    public function get_elephant_log_list($score_type = 'gold', $page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	//判断是否登录
    	checkLogin();
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	//当前位置
    	$location = "<a href='index.php/user'>会员中心</a> > <a>预存款</a> > 财务记录";
    	$user_id = get_cookie('user_id');
    	$strWhere = "user_id = {$user_id} and score_type = '{$score_type}' ";
    	//分页
    	$paginationCount = $this->Elephant_log_model->rowCount($strWhere);
    	$this->config->load('pagination_config', TRUE);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url() . "index.php/user/get_elephant_log_list/{$score_type}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
    	$this->pagination->initialize($paginationConfig);
    	$pagination = $this->pagination->create_links();

    	$item_list = $this->Elephant_log_model->gets($strWhere, $paginationConfig['per_page'], $page);

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => $systemInfo['site_name'] . '_金/银象币消费记录',
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'item_list' => $item_list,
    			'html' => $systemInfo['html'],
    			'score_type'=>$score_type,
    			'elephant_log_type_arr'=>$this->_elephant_log_type_arr,
    			'location' => $location,
    			'pagination' => $pagination,
    			'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
    			'perPage' => $paginationConfig['per_page']
    	);
    	$layout = array(
    			'content' => $this->load->view('user/get_elephant_log_list', $data, TRUE)
    	);
    	$this->load->view('layout/elephant_log_user_default', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    /**
     * 金象、银象币提现记录
     *
     * @param string $score_type
     * @param number $page
     */
    public function get_withdraw_list($score_type = 'gold', $page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	//判断是否登录
    	checkLogin();
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	//当前位置
    	$location = "<a href='index.php/user'>会员中心</a> > <a>预存款</a> > 财务记录";
    	$user_id = get_cookie('user_id');
    	$strWhere = "user_id = {$user_id} and score_type = '{$score_type}' ";
    	//分页
    	$paginationCount = $this->Withdraw_model->rowCount($strWhere);
    	$this->config->load('pagination_config', TRUE);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url() . "index.php/user/get_withdraw_list/{$score_type}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
    	$this->pagination->initialize($paginationConfig);
    	$pagination = $this->pagination->create_links();

    	$item_list = $this->Withdraw_model->gets($strWhere, $paginationConfig['per_page'], $page);

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => $systemInfo['site_name'] . '_金象币_银象币提现记录',
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'item_list' => $item_list,
    			'html' => $systemInfo['html'],
    			'score_type'=>$score_type,
    			'score_type_arr'=>$this->_score_type_2_arr,
    			'pay_log_payment_type_arr'=>$this->_pay_log_payment_type_arr,
    			'display_arr'=>array('0'=>'<font color="red">处理中</font>', '1'=>'提现成功', '2'=>'提现失败'),
    			'location' => $location,
    			'pagination' => $pagination,
    			'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
    			'perPage' => $paginationConfig['per_page']
    	);
    	$layout = array(
    			'content' => $this->load->view('user/get_withdraw_list', $data, TRUE)
    	);
    	$this->load->view('layout/elephant_log_user_default', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    /**
     * 金象、银象积分充值记录
     *
     * @param string $score_type
     * @param number $page
     */
    public function get_score_pay_log_list($score_type = 'gold', $page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	//判断是否登录
    	checkLogin();
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	//当前位置
    	$location = "<a href='index.php/user'>会员中心</a> > <a>预存款</a> > 财务记录";
    	$user_id = get_cookie('user_id');
    	$strWhere = "user_id = {$user_id} and order_type = 'score_{$score_type}' ";
    	//分页
    	$paginationCount = $this->Pay_log_model->rowCount($strWhere);
    	$this->config->load('pagination_config', TRUE);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url() . "index.php/user/get_score_pay_log_list/{$score_type}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
    	$this->pagination->initialize($paginationConfig);
    	$pagination = $this->pagination->create_links();

    	$item_list = $this->Pay_log_model->gets($strWhere, $paginationConfig['per_page'], $page);

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => $systemInfo['site_name'] . '_金象、银象积分充值记录',
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'item_list' => $item_list,
    			'html' => $systemInfo['html'],
    			'score_type'=>$score_type,
    			'elephant_log_type_arr'=>$this->_elephant_log_type_arr,
    			'pay_log_payment_type_arr' => $this->_pay_log_payment_type_arr,
    			'trade_status_msg'=>$this->_trade_status_msg,
    			'location' => $location,
    			'pagination' => $pagination,
    			'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
    			'perPage' => $paginationConfig['per_page']
    	);
    	$layout = array(
    			'content' => $this->load->view('user/get_score_pay_log_list', $data, TRUE)
    	);
    	$this->load->view('layout/elephant_log_user_default', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    //积分兑换成币[金象币、银象币]
    public function recharge_score_to_total() {
        checkLoginAjax();
        if ($_POST) {
        	$user_id = get_cookie('user_id');
        	$score_type = $this->input->post('score_type', TRUE);
        	$recharge_score_num = $this->input->post('recharge_score_num', TRUE);
        	$pay_password = trim($this->input->post('pay_password', TRUE));

        	if (!$score_type) {
        		printAjaxError('fail', '操作异常，刷新重试');
        	}
        	if ($score_type != 'gold' && $score_type != 'silver') {
        		printAjaxError('fail', '操作异常，刷新重试');
        	}
        	if (!$recharge_score_num) {
        		printAjaxError('recharge_score_num', '请输入兑换积分数量');
        	}
        	if (!$pay_password) {
        		printAjaxError('pay_password', '请输入支付密码');
        	}
        	$cur_user_info = $this->User_model->get('id,pay_password,add_time,username,user_type,seller_grade,score_gold,score_silver,total_gold,total_silver', array('id'=>$user_id));
        	if (!$cur_user_info) {
        		printAjaxError('fail', '您的账户信息不存在');
        	}
        	if ($cur_user_info['user_type'] != 1) {
        		printAjaxError('fail', '此功能只有商家才能使用');
        	}
        	if ($this->User_model->getPasswordSalt($cur_user_info['username'], $pay_password) != $cur_user_info['pay_password']) {
        		printAjaxError('fail', '支付密码错误，兑换失败');
        	}
        	if ($score_type == 'gold') {
                if ($recharge_score_num > $cur_user_info['score_gold']) {
                	printAjaxError('fail', '金象积分余额不足，兑换失败');
                }
                //扣积分
                $ret_id = 0;
                $balance = $cur_user_info['score_gold'] - $recharge_score_num;
                if ($this->User_model->save(array('score_gold'=>$balance), array('id'=>$cur_user_info['id']))) {
                	$fields = array(
                			'cause' => '兑换支付-金象积分兑换成金象币',
                			'score' => -$recharge_score_num,
                			'balance' => $balance,
                			'score_type'=>'gold',
                			'type' => 'convert_out',
                			'add_time' => time(),
                			'username' => $cur_user_info['username'],
                			'user_id' =>  $cur_user_info['id']
                	);
                	$ret_id = $this->Score_model->save($fields);
                }
                //转为币
                $balance = $cur_user_info['total_gold'] + $recharge_score_num;
                if ($this->User_model->save(array('total_gold'=>$balance), array('id'=>$cur_user_info['id']))) {
                	$fields = array(
                			'cause' =>   '兑换入帐-金象积分兑换成金象币',
                			'score' =>   $recharge_score_num,
                			'balance' => $balance,
                			'score_type'=>'gold',
                			'type' => 'convert_in',
                			'add_time' => time(),
                			'username' => $cur_user_info['username'],
                			'user_id' =>  $cur_user_info['id'],
                			'ret_id'=>$ret_id
                	);
                	$this->Elephant_log_model->save($fields);
                }
        	} else if ($score_type == 'silver') {
        		if ($recharge_score_num > $cur_user_info['score_silver']) {
        			printAjaxError('fail', '银象积分余额不足，兑换失败');
        		}
        		//扣积分
        		$ret_id = 0;
        		$balance = $cur_user_info['score_silver'] - $recharge_score_num;
        		if ($this->User_model->save(array('score_silver'=>$balance), array('id'=>$cur_user_info['id']))) {
        			$fields = array(
        					'cause' => '兑换支付-银象积分兑换成银象币',
        					'score' => -$recharge_score_num,
        					'balance' => $balance,
        					'score_type'=>'silver',
        					'type' => 'convert_out',
        					'add_time' => time(),
        					'username' => $cur_user_info['username'],
        					'user_id' =>  $cur_user_info['id']
        			);
        			$ret_id = $this->Score_model->save($fields);
        		}
        		//转为币
        		$balance = $cur_user_info['total_silver'] + $recharge_score_num;
        		if ($this->User_model->save(array('total_silver'=>$balance), array('id'=>$cur_user_info['id']))) {
        			$fields = array(
        					'cause' =>   '兑换入帐-银象积分兑换成银象币',
        					'score' =>   $recharge_score_num,
        					'balance' => $balance,
        					'score_type'=>'silver',
        					'type' => 'convert_in',
        					'add_time' => time(),
        					'username' => $cur_user_info['username'],
        					'user_id' =>  $cur_user_info['id'],
        					'ret_id'=>$ret_id
        			);
        			$this->Elephant_log_model->save($fields);
        		}
        	}
        	$cur_user_info = $this->User_model->get('id,username,user_type,seller_grade,score_gold,score_silver,total_gold,total_silver', array('id'=>$user_id));
        	printAjaxData($cur_user_info);
        }
    }

    //评论
    public function comment_save($id = NULL) {
    	$go_url = $this->session->userdata('gloabPreUrl');
    	//判断是否登录
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
		$user_id = get_cookie('user_id');
        $order_info = $this->Orders_model->get('id, is_comment_to_seller', "id = '{$id}' and status = 3 and user_id = " . $user_id);
        if (!$order_info) {
            $data = array(
                'user_msg' => '此订单不存在或订单状态异常',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
		if ($order_info['is_comment_to_seller']) {
            $data = array(
                'user_msg' => '此订单已评价，不用重复评价',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        $order_detail_list = $this->Orders_detail_model->gets2(array('orders_detail.order_id' => $order_info['id']));
        if (!$order_detail_list) {
            $data = array(
                'user_msg' => '您购买的商品不存在',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        if ($_POST) {
    		$product_id = $this->input->post('product_id', TRUE);
    		$grade = $this->input->post('grade', TRUE);
    		$content = $this->input->post('content', TRUE);
    		$batch_path_ids = $this->input->post('batch_path_ids', TRUE);
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
                			'batch_path_ids'=>$batch_path_ids[$key],
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
    		printAjaxSuccess($go_url, "评价成功");
    	}

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '评论',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'order_info'=>$order_info,
            'order_detail_list' => $order_detail_list
        );
        $layout = array(
            'content' => $this->load->view('user/comment_save', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //评论列表
    public function comment_list($page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $strWhere = array('user_id' => get_cookie('user_id'));
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //分页
        $paginationCount = $this->Comment_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/comment_list/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
		
        $comment_list = $this->Comment_model->gets("*", $strWhere, $paginationConfig['per_page'], $page);
        
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '评论',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'comment_list' => $comment_list,
            'pagination' => $pagination,
        );
        $layout = array(
            'content' => $this->load->view('user/comment_list', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //我的拼团活动
    public function group_purchase($page = 0) {
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $strWhere = 'user_id = ' . $user_id;
        //分页
        $paginationCount = $this->Ptkj_record_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/group_purchase";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
        $group_purchase_list = $this->Ptkj_record_model->gets($strWhere, $paginationConfig['per_page'], $page);
        $ids = '';
        foreach ($group_purchase_list as $key => $ls) {
            $ids .= $ls['ptkj_id'] . ',';
            $chop_record = $this->Chop_record_model->get("count(1) as cut_times,sum(chop_price) as sum", "user_id = $user_id and ptkj_record_id = {$ls['id']} and chop_user_id <> ''");
            $group_purchase_list[$key]['cut_times'] = $chop_record['cut_times'];
            $group_purchase_list[$key]['sum'] = $chop_record['sum'] ? $chop_record['sum'] : '0.00';
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
                    }
                }
            }
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '我的拼团活动',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'group_purchase_list' => $group_purchase_list,
            'rule_arr' => $rule_arr,
            'pagination' => $pagination
        );
        $layout = array(
            'content' => $this->load->view('user/group_purchase', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //我的限时抢购
    public function flash_sale($page = 0) {
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $strWhere = 'user_id = ' . $user_id;
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        //分页
        $paginationCount = $this->Flash_sale_record_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/flash_sale";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
        $flash_sale_info = $this->Flash_sale_record_model->gets($strWhere, $paginationConfig['per_page'], $page);
        foreach ($flash_sale_info as $key => $ls) {
            $flash = $this->Flash_sale_model->get('*', array('id' => $ls['flash_sale_id']));
            $order_info = $this->Orders_model->get('status', array('id' => $ls['order_id']));
            $order_detail = $this->Orders_detail_model->get('size_name,color_name', array('order_id' => $ls['order_id']));
            $flash_sale_info[$key]['name'] = $flash['name'];
            $flash_sale_info[$key]['flash_sale_price'] = $flash['flash_sale_price'];
            $flash_sale_info[$key]['path'] = $flash['path'];
            $flash_sale_info[$key]['status'] = $this->_status[$order_info['status']];
            $flash_sale_info[$key]['size_name'] = $order_detail['size_name'];
            $flash_sale_info[$key]['color_name'] = $order_detail['color_name'];
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '我的拼团活动',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'flash_sale_info' => $flash_sale_info,
            'pagination' => $pagination
        );
        $layout = array(
            'content' => $this->load->view('user/flash_sale', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //我的推广链接
    public function get_presenter_link() {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $this->session->set_userdata(array('ad_text' => ''));
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $pop_code = '';
        $userInfo = $this->User_model->get('username, pop_code, path, user_type, seller_grade', array('id' => $user_id));
        if ($userInfo && $userInfo['pop_code']) {
        	$pop_code = $userInfo['pop_code'];
        } else {
        	$pop_code = $this->advdbclass->get_unique_pop_code();
        	if ($pop_code) {
        		$this->User_model->save(array('pop_code'=>$pop_code), array('id'=>$user_id));
        	}
        }
        //我的总提成
        $total = $this->Financial_model->get_Total(array('type' => 'presenter_in', 'user_id' => $user_id));
        //当月提成
        $cur_month = date('Y-m', time());
        $cur_total = $this->Financial_model->get_Total("type = 'presenter_in' and user_id = {$user_id} and FROM_UNIXTIME(add_time,'%Y-%m') = '{$cur_month}' ");
        //上月提成
        $prv_month = date('Y-m', strtotime('-1 month'));
        $prv_total = $this->Financial_model->get_Total("type = 'presenter_in' and user_id = {$user_id} and FROM_UNIXTIME(add_time,'%Y-%m') = '{$prv_month}' ");

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '我的推广链接',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'userInfo' => $userInfo,
        	'seller_grade_arr'=>$this->_seller_grade_arr,
            'total' => $total,
            'cur_total' => $cur_total,
            'prv_total' => $prv_total,
            'pop_code' => $pop_code
        );
        $layout = array(
            'content' => $this->load->view('user/get_presenter_link', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //我发展的会员
    public function get_presenter_sub_list($clear = 0, $page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $userInfo = $this->User_model->get('*', array('id' => $user_id));
        $tab_title = '我发展的用户';
        if ($clear) {
            $clear = 0;
            $this->session->unset_userdata(array('search_index' => ''));
            $this->session->unset_userdata(array('search_start_time' => ''));
            $this->session->unset_userdata(array('search_end_time' => ''));
        }
        $condition = "presenter_id = {$user_id} ";
        $strWhere = $this->session->userdata('search_index') ? $this->session->userdata('search_index') : $condition;
        if ($_POST) {
            $strWhere = $condition;
            $keycode = $this->input->post('keycode', TRUE);
            $start_time = $this->input->post('start_time', TRUE);
            $end_time = $this->input->post('end_time', TRUE);

            if ($keycode) {
                $strWhere .= " and (user.username regexp '{$keycode}' or user.nickname regexp '{$keycode}' or user.mobile regexp '{$keycode}')  ";
            }
            if (!empty($start_time) && !empty($end_time)) {
                $this->session->set_userdata('search_start_time', $start_time);
                $this->session->set_userdata('search_end_time', $end_time);
                $strWhere .= " and user.add_time > " . strtotime($start_time . ' 00:00:00') . " and user.add_time < " . strtotime($end_time . " 23:59:59") . " ";
            }
            $this->session->set_userdata('search_index', $strWhere);
        }
        //分页
        $this->config->load('pagination_2_config', TRUE);
        $paginationCount = $this->User_model->rowCount_2($strWhere);
        $paginationConfig = $this->config->item('pagination_2_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/get_presenter_sub_list/{$clear}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 20;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $itemList = $this->User_model->gets_2('id,user_type,username,nickname,path,add_time', $strWhere, $paginationConfig['per_page'], $page);
        if ($itemList) {
        	foreach ($itemList as $key=>$value) {
        		$presenter_user_count = $this->User_model->rowCount_2("presenter_id = {$value['id']} or par_presenter_id = {$value['id']}");
        		$divide_score = $this->Score_model->get_divide_score($user_id, $value['id']);
        		$itemList[$key]['presenter_user_count'] = $presenter_user_count+1;
        		$itemList[$key]['divide_score'] = $divide_score;
        	}
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $tab_title,
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'itemList' => $itemList,
            'pagination' => $pagination,
            'paginationCount' => $paginationCount,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'clear' => $clear,
            'tab_title' => $tab_title,
            'start_time' => $this->session->userdata('search_start_time') ? $this->session->userdata('search_start_time') : '',
            'end_time' => $this->session->userdata('search_end_time') ? $this->session->userdata('search_end_time') : '',
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/get_presenter_sub_list', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //我的推广提成-城市分销商-校园一级分销商
    public function get_presenter_financial_1_list($clear = 0, $page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $userInfo = $this->User_model->get('*', array('id' => $user_id));
        if ($clear) {
            $clear = 0;
            $this->session->unset_userdata(array('search_index' => ''));
            $this->session->unset_userdata(array('search_start_time' => ''));
            $this->session->unset_userdata(array('search_end_time' => ''));
        }

        $condition = "score.type in ('presenter_out','presenter_in','join_user_score_in','join_seller_score_in') and score.user_id = {$user_id} ";
        $strWhere = $this->session->userdata('search_index') ? $this->session->userdata('search_index') : $condition;
        if ($_POST) {
            $strWhere = $condition;

            $keycode = $this->input->post('keycode', TRUE);
            $start_time = $this->input->post('start_time', TRUE);
            $end_time = $this->input->post('end_time', TRUE);

            if ($keycode) {
                $strWhere .= " and (user.username regexp '{$keycode}' or user.presenter_username regexp '{$keycode}') )  ";
            }
            if (!empty($start_time) && !empty($end_time)) {
                $this->session->set_userdata('search_start_time', $start_time);
                $this->session->set_userdata('search_end_time', $end_time);
                $strWhere .= " and (financial.add_time > " . strtotime($start_time . ' 00:00:00') . " and financial.add_time < " . strtotime($end_time . " 23:59:59") . ") ";
            }
            $this->session->set_userdata('search_index', $strWhere);
        }
        //分页
        $this->config->load('pagination_2_config', TRUE);
        $paginationCount = $this->Score_model->rowCount2($strWhere);
        $paginationConfig = $this->config->item('pagination_2_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/get_presenter_financial_1_list/{$clear}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 20;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $itemList = $this->Score_model->gets2($strWhere, $paginationConfig['per_page'], $page);
        if ($itemList) {
            foreach ($itemList as $key => $value) {
                if ($value['presenter_id'] != $user_id) {
                    $itemList[$key]['username'] = $value['presenter_username'];
                }
            }
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '我的推广提成',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'itemList' => $itemList,
            'pagination' => $pagination,
            'paginationCount' => $paginationCount,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'clear' => $clear,
            'start_time' => $this->session->userdata('search_start_time') ? $this->session->userdata('search_start_time') : '',
            'end_time' => $this->session->userdata('search_end_time') ? $this->session->userdata('search_end_time') : '',
            'html' => $systemInfo['html']
        );
        $layout = array(
            'content' => $this->load->view('user/get_presenter_financial_1_list', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //效果统计
    public function get_presenter_result() {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $go_url = $this->session->userdata('gloabPreUrl');
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $userInfo = $this->User_model->get('*', array('id' => $user_id));
        //已下单
        $yxd_count = 0;
        //已付款
        $yfk_count = 0;
        //已成交
        $ycj_count = 0;
        //付款金额
        $fk_total = 0;
        //成交金额
        $cj_total = 0;
        //客户数量
        $user_count = 0;
        //提成
        $success_financial_total = 0;
        $start_time = '';
        $end_time = '';
        if ($_POST) {
            $start_time = $this->input->post('start_time', TRUE);
            $end_time = $this->input->post('end_time', TRUE);
        }
        $strWhere = "(divide_user_id_1 = {$user_id} or divide_user_id_2 = {$user_id}) ";
        if ($start_time && $end_time) {
        	$strWhere .= " and (add_time > " . strtotime($start_time . ' 00:00:00') . " and add_time <= " . strtotime($end_time . " 23:59:59") . ") ";
        }
        $yxd_count = $this->Orders_model->rowCount($strWhere);

        $strWhere = "(divide_user_id_1 = {$user_id} or divide_user_id_2 = {$user_id}) and status > 0 ";
        if ($start_time && $end_time) {
        	$strWhere .= " and (add_time > " . strtotime($start_time . ' 00:00:00') . " and add_time <= " . strtotime($end_time . " 23:59:59") . ") ";
        }
        $yfk_count = $this->Orders_model->rowCount($strWhere);

        $strWhere = "(divide_user_id_1 = {$user_id} or divide_user_id_2 = {$user_id}) and status = 3 ";
        if ($start_time && $end_time) {
        	$strWhere .= " and (add_time > " . strtotime($start_time . ' 00:00:00') . " and add_time <= " . strtotime($end_time . " 23:59:59") . ") ";
        }
        $ycj_count = $this->Orders_model->rowCount($strWhere);

        $strWhere = "(divide_user_id_1 = {$user_id} or divide_user_id_2 = {$user_id}) and status > 0 ";
        if ($start_time && $end_time) {
        	$strWhere .= " and (add_time > " . strtotime($start_time . ' 00:00:00') . " and add_time <= " . strtotime($end_time . " 23:59:59") . ") ";
        }
        $fk_total = $this->Orders_model->get_Total($strWhere);

        $strWhere = "(divide_user_id_1 = {$user_id} or divide_user_id_2 = {$user_id}) and status = 3 ";
        if ($start_time && $end_time) {
        	$strWhere .= " and (add_time > " . strtotime($start_time . ' 00:00:00') . " and add_time <= " . strtotime($end_time . " 23:59:59") . ") ";
        }
        $cj_total = $this->Orders_model->get_Total($strWhere);
        //以时间为准，有可能会修改成以审核时间为准
        $strWhere = "(presenter_id = {$user_id} or par_presenter_id = {$user_id}) ";
        if ($start_time && $end_time) {
        	$strWhere .= " and (add_time > " . strtotime($start_time . ' 00:00:00') . " and add_time <= " . strtotime($end_time . " 23:59:59") . ") ";
        }
        $user_count = $this->User_model->rowCount2($strWhere);

        $strWhere = "type in ('presenter_out','presenter_in','join_user_score_in','join_seller_score_in') and user_id = {$user_id} ";
        if ($start_time && $end_time) {
            $strWhere .= " and (add_time > " . strtotime($start_time . ' 00:00:00') . " and add_time <= " . strtotime($end_time . " 23:59:59") . ") ";
        }
        $success_score_total = $this->Score_model->get_Total($strWhere);


        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '效果统计',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'status' => $this->_status,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'html' => $systemInfo['html'],
            'yxd_count' => $yxd_count,
            'yfk_count' => $yfk_count,
            'ycj_count' => $ycj_count,
            'fk_total' => $fk_total,
            'cj_total' => $cj_total,
            'user_count' => $user_count,
            'userInfo' => $userInfo,
            'success_score_total' => $success_score_total ? $success_score_total : 0
        );
        $layout = array(
            'content' => $this->load->view('user/get_presenter_result', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function get_user_rq() {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	checkLogin();
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	$userInfo = $this->User_model->get('id, pop_code, path', array('user.id' => get_cookie('user_id')));
        if ($userInfo['pop_code']) {
    	    create_qrcode(base_url().getBaseUrl(false, "t/i", "t/i", $systemInfo['client_index']).'/'.$userInfo['pop_code'].'.html', $userInfo['path']);
        }
    }

    public function bind_pop_code() {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        checkLogin();
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $userInfo = $this->User_model->get('id, username, score_gold, score_silver, pop_code, presenter_id, presenter_username, par_presenter_id, par_presenter_username', array('user.id' => get_cookie('user_id')));
        if ($_POST) {
            $pop_code = trim($this->input->post('pop_code', TRUE));

            if (!$pop_code) {
                printAjaxError('fail', '请填写邀请码');
            }
            if ($userInfo['presenter_id']) {
                printAjaxError('fail', '邀请码已绑定过，不用重复绑定');
            }
            $cur_user_info = $this->User_model->getInfo('id, username, pop_code, presenter_id, presenter_username', array('pop_code' => $pop_code));
            if (!$cur_user_info) {
                printAjaxError('fail', '此邀请码不存在');
            }

            $fields = array(
                'presenter_id' => $cur_user_info['id'],
                'presenter_username' => $cur_user_info['username'],
                'remark_time' => time()
            );
            if (!$this->User_model->save($fields, array('id' => get_cookie('user_id')))) {
                printAjaxError('fail', '邀请码绑定失败');
            }
            $score = 0;
            $score_type = '';
            $score_setting_info = $this->Score_setting_model->get('store_score, school_score, net_score', array('id' => 1));

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

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '绑定邀请码',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'userInfo' => $userInfo
        );
        $layout = array(
            'content' => $this->load->view('user/bind_pop_code', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //我的消息
    public function get_message_list($page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        //判断是否登录
        checkLogin();
        $go_url = $this->session->userdata('gloabPreUrl');
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $strWhere = 'to_user_id = ' . $user_id;
        //分页
        $paginationCount = $this->Message_model->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/user/get_message_list/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $paginationConfig['per_page'] = 10;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
        $message_list = $this->Message_model->gets('*', $strWhere, $paginationConfig['per_page'], $page);
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '我的消息',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'message_list' => $message_list,
            'pagination' => $pagination,
        );
        $layout = array(
            'content' => $this->load->view('user/get_message_list', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function get_city() {
        if ($_POST) {
            $parent_id = $this->input->post('parent_id', TRUE);
            $item_list = $this->Area_model->gets('id, name', array('parent_id' => $parent_id, 'display' => 1));
            printAjaxData($item_list);
        }
    }

    public function get_exchange_type() {
        //判断是否登录
        checkLogin();
        $go_url = $this->session->userdata('gloabPreUrl');
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $order_number = $this->input->get('order_number', true);
        $order_detail_id = $this->input->get('id', true);
        $order_info = $this->Orders_model->get("order_number,postage_price,total", array('order_number' => $order_number));
        if (empty($order_info)) {
            $data = array(
                'user_msg' => '此订单号不存在',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $order_detail = $this->Orders_detail_model->get('id', array('id' => $order_detail_id));
        if (empty($order_detail)) {
            $data = array(
                'user_msg' => '订单详细id不存在',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . ' 申请退款/退换货',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'order_info' => $order_info,
            'id' => $order_detail_id,
        );
        $layout = array(
            'content' => $this->load->view('user/get_exchange_type', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //退货退款
    public function exchange_thtk($exchange_id = null) {
        //判断是否登录
        checkLogin();
        $go_url = $this->session->userdata('gloabPreUrl');
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $order_number = $this->input->get('order_number', true);
        $order_detail_id = $this->input->get('id', true);
        $order_info = $this->Orders_model->get('total,postage_price,id', array('order_number' => $order_number, 'user_id' => $user_id));
        $item_info = $this->Exchange_model->get('*', array('id' => $exchange_id, 'user_id' => $user_id, 'order_number' => $order_number));
        if ($exchange_id) {
            if (empty($item_info)) {
                $data = array(
                    'user_msg' => '此订单id不存在',
                    'user_url' => $go_url
                );
                $this->session->set_userdata($data);
                redirect(base_url() . 'index.php/message/index');
            }
        }

        if (empty($order_info)) {
            $data = array(
                'user_msg' => '此订单号不存在',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $order_detail = $this->Orders_detail_model->get('id,buy_price', array('id' => $order_detail_id, 'order_id' => $order_info['id']));
        if (empty($order_detail)) {
            $data = array(
                'user_msg' => '订单详细id不存在',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $order_detail_count = $this->Orders_detail_model->rowCount(array('order_id' => $order_info['id']));
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '退货退款',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'order_info' => $order_info,
            'order_detail' => $order_detail,
            'order_detail_count' => $order_detail_count,
            'id' => $exchange_id,
            'item_info' => $item_info
        );
        $layout = array(
            'content' => $this->load->view('user/exchange_thtk', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //仅退款
    public function exchange_jtk($exchange_id = null) {
        //判断是否登录
        checkLogin();
        $go_url = $this->session->userdata('gloabPreUrl');
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $order_detail_id = $this->input->get('id', true);
        $order_number = $this->input->get('order_number', true);
        $order_info = $this->Orders_model->get('total,postage_price,id', array('order_number' => $order_number, 'user_id' => $user_id));
        $item_info = $this->Exchange_model->get('*', array('id' => $exchange_id, 'user_id' => $user_id, 'order_number' => $order_number));
        if ($exchange_id) {
            if (empty($item_info)) {
                $data = array(
                    'user_msg' => '此订单id不存在',
                    'user_url' => $go_url
                );
                $this->session->set_userdata($data);
                redirect(base_url() . 'index.php/message/index');
            }
        }
        if (empty($order_info)) {
            $data = array(
                'user_msg' => '此订单号不存在',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $order_detail = $this->Orders_detail_model->get('id,buy_price', array('id' => $order_detail_id, 'order_id' => $order_info['id']));
        if (empty($order_detail)) {
            $data = array(
                'user_msg' => '订单详细id不存在',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '仅退款',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info,
            'id' => $exchange_id
        );
        $layout = array(
            'content' => $this->load->view('user/exchange_jtk', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //换款
    public function exchange_hh($exchange_id = null) {
        //判断是否登录
        checkLogin();
        $go_url = $this->session->userdata('gloabPreUrl');
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $order_number = $this->input->get('order_number', true);
        $order_info = $this->Orders_model->get('total,postage_price,id', array('order_number' => $order_number, 'user_id' => $user_id));
        $item_info = $this->Exchange_model->get('*', array('id' => $exchange_id, 'user_id' => $user_id, 'order_number' => $order_number));
        if ($exchange_id) {
            if (empty($item_info)) {
                $data = array(
                    'user_msg' => '此订单id不存在',
                    'user_url' => $go_url
                );
                $this->session->set_userdata($data);
                redirect(base_url() . 'index.php/message/index');
            }
        }
        if (empty($order_info)) {
            $data = array(
                'user_msg' => '此订单号不存在',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $order_detail_id = $this->input->get('id', true);
        $order_detail = $this->Orders_detail_model->get('id,buy_price', array('id' => $order_detail_id, 'order_id' => $order_info['id']));
        if (empty($order_detail)) {
            $data = array(
                'user_msg' => '订单详细id不存在',
                'user_url' => $go_url
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php/message/index');
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $systemInfo['site_name'] . '_' . '换货',
            'keywords' => $systemInfo['site_keycode'],
            'description' => $systemInfo['site_description'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info,
            'exchange_id' => $exchange_id
        );
        $layout = array(
            'content' => $this->load->view('user/exchange_hh', $data, TRUE)
        );
        $this->load->view('layout/user_default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    public function delete_message() {
        checkLogin();
        $ids = trim($this->input->post('ids', true), ',');
        if (empty($ids)) {
            printAjaxError('fail', '消息id不能为空');
        }
        $this->Message_model->delete("id in ($ids) and to_user_id = " . get_cookie('user_id'));
        printAjaxSuccess('success', '删除成功！');
    }

    private function _deleteCookie() {
        delete_cookie('user_id');
        delete_cookie('user_username');
        delete_cookie('user_login_time');
        delete_cookie('user_ip');
        delete_cookie('user_ip_address');
    }

    private function _setCookie($data, $expire = 0) {
        $cookie1 = array(
            'name' => 'user_id',
            'value' => $data['id'],
            'expire' => $expire
        );
        set_cookie($cookie1);
        $cookie2 = array(
            'name' => 'user_username',
            'value' => $data['nickname'] ? $data['nickname'] : $data['username'],
            'expire' => $expire
        );
        set_cookie($cookie2);
        $cookie4 = array(
            'name' => 'user_login_time',
            'value' => $data['login_time'],
            'expire' => $expire
        );
        set_cookie($cookie4);
        $cookie5 = array(
            'name' => 'user_ip',
            'value' => $data['ip'],
            'expire' => $expire
        );
        set_cookie($cookie5);
        $cookie6 = array(
            'name' => 'user_ip_address',
            'value' => $data['ip_address'],
            'expire' => $expire
        );
        set_cookie($cookie6);
    }

    //加盐算法
    private function _createPasswordSALT($user, $salt, $password) {
        return md5(strtolower($user) . $salt . $password);
    }

    private function send_sms($mobile = NULL, $sms_txt = NULL) {
        $sUrl = 'http://101.37.79.158/OpenPlatform/OpenApi'; // 接入地址
        $sAccount = '1001@901022360002';    // 请替换为你的帐号编号
        $sAuthkey = '0CA01638D10426DB22DDD5D3E0D46F7C';  // 请替换为你的帐号密钥
        $nCgid = 7310;      // 请替换为你的通道组编号
        $sMobile = $mobile;    // 请替换为你的手机号码
        $sContent = $sms_txt;   // 请把数字替换为其他4~10位的数字测试，如需测试其他内容，请先联系客服报备发送模板
        $nCsid = 0;    // 签名编号 ,可以为空时，使用系统默认的编号
        $data = array('action' => 'sendOnce', 'ac' => $sAccount, 'authkey' => $sAuthkey, 'cgid' => $nCgid, 'm' => $sMobile, 'c' => $sContent, 'csid' => $nCsid);  //定义参数
        $data = @http_build_query($data);        //把参数转换成URL数据
        $xml = file_get_contents($sUrl . '?' . $data);  // 发送请求
        $xml_array = $this->xmlToArray($xml);
        return $xml_array['@attributes']['result'];
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

    public function save_ad_qr_code() {
        checkLoginAjax();
        if ($_POST) {
            $ad_text = $this->input->post('ad_text', TRUE);
            if ($this->User_model->save(array('ad_text' => $ad_text), array('id' => get_cookie('user_id')))) {
                printAjaxSuccess('success', '保存成功');
            } else {
                printAjaxError('fail', '保存失败');
            }
        }
    }

    public function create_ad_qr_code() {
        checkLoginAjax();
        if ($_POST) {
            $ad_text = trim($this->input->post('ad_text', TRUE));
            $this->session->set_userdata(array('ad_text' => $ad_text));

            printAjaxData(array('r' => "" . rand(10000, 99999), 'ad_text' => $ad_text));
        }
    }

    public function cancel_ad_qr_code() {
        checkLoginAjax();
        if ($_POST) {
            $this->session->set_userdata(array('ad_text' => ''));

            printAjaxData(array('r' => "" . rand(10000, 99999), 'ad_text' => ''));
        }
    }

    public function get_qr_code($type = 1, $flush = 1) {
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('client_index', array('id' => 1));
        $userInfo = $this->User_model->get('ad_text, nickname, username, path, pop_code', array('id' => $user_id));
        $nickname = $userInfo['nickname'] ? $userInfo['nickname'] : $userInfo['username'];
        $url = base_url() . getBaseUrl(false, "t/i", "t/i", $systemInfo['client_index']) . '/' . $userInfo['pop_code'] . '.html';
        $image_arr = fliter_image_path($userInfo['path']);
        $path = $image_arr['path_thumb'];

        $ad_text = $this->session->userdata('ad_text');
        if (!$ad_text) {
            $ad_text = $userInfo['ad_text'];
        }
        if ($type == 1) {
            $this->_qr_code_1($nickname, $path, $url, $ad_text);
        } else if ($type == 2) {
            $this->_qr_code_2($nickname, $path, $url, $ad_text);
        } else if ($type == 3) {
            $this->_qr_code_3($nickname, $path, $url, $ad_text);
        }
    }

    public function download_qr_code() {
        //判断是否登录
        checkLogin();
        if ($_POST) {
            $type = $this->input->post('qr_type', TRUE);
            $user_id = get_cookie('user_id');
            $systemInfo = $this->System_model->get('client_index', array('id' => 1));
            $userInfo = $this->User_model->get('ad_text, nickname, username, path, pop_code', array('id' => $user_id));
            $nickname = $userInfo['nickname'] ? $userInfo['nickname'] : $userInfo['username'];
            $url = base_url() . getBaseUrl(false, "t/i", "t/i", $systemInfo['client_index']) . '/' . $userInfo['pop_code'] . '.html';
            $image_arr = fliter_image_path($userInfo['path']);
            $path = $image_arr['path_thumb'];

            if ($type == 1) {
                $this->_qr_code_1($nickname, $path, $url, $userInfo['ad_text'], true);
            } else if ($type == 2) {
                $this->_qr_code_2($nickname, $path, $url, $userInfo['ad_text'], true);
            } else if ($type == 3) {
                $this->_qr_code_3($nickname, $path, $url, $userInfo['ad_text'], true);
            }
        }
    }

    //样式1
    private function _qr_code_1($nickname = '', $path = '', $url = '', $ad_text = '', $is_download = false) {
        //建立一幅100*30的图像
        $image = @imagecreatefrompng('./images/default/qr_code_1.png');
        imagesavealpha($image, true);
        $bg_w = imagesx($image);
        $bg_h = imagesy($image);
        //设置字体颜色
        $text_color = imagecolorallocate($image, 255, 234, 151);
        $font = "./ttfs/dfheiw5-a320.ttf";
        $text = '我是' . $nickname;
        imagettftext($image, 20, 0, 104, 50, $text_color, $font, $text);
        //广告词
        $ad_text_font_size = 16;
        $ad_text_color = imagecolorallocate($image, 228, 0, 127);
        $ad_text_1 = '';
        $ad_text_2 = '';
        $ad_len = mb_strlen($ad_text, 'utf-8');
        if ($ad_len <= 15) {
            $ad_text_1 = $ad_text;
        } else {
            $ad_text_1 = mb_substr($ad_text, 0, 15);
            $ad_text_2 = mb_substr($ad_text, 15);
        }
        //两行
        if ($ad_text_1 && $ad_text_2) {
            $ad_text_1_w = $this->_text_width($ad_text_1, $ad_text_font_size);
            $ad_text_2_w = $this->_text_width($ad_text_2, $ad_text_font_size);
            imagettftext($image, $ad_text_font_size, 0, ($bg_w - $ad_text_1_w) / 2, 276, $ad_text_color, $font, $ad_text_1);
            imagettftext($image, $ad_text_font_size, 0, ($bg_w - $ad_text_2_w) / 2, 306, $ad_text_color, $font, $ad_text_2);
        }
        //一行
        else {
            if ($ad_text_1) {
                $ad_text_1_w = $this->_text_width($ad_text_1, $ad_text_font_size);
                imagettftext($image, $ad_text_font_size, 0, ($bg_w - $ad_text_1_w) / 2, 290, $ad_text_color, $font, $ad_text_1);
            }
        }
        //生成头像小图
        if ($path) {
	        $src_img = $this->radius_img($path, 74, 74, 8);
	        $src_w = imagesx($src_img);
	        $src_h = imagesy($src_img);
	        imagecopyresampled($image, $src_img, 16, 16, 0, 0, 74, 74, $src_w, $src_h);
	        imagedestroy($src_img);
        }
        //二维码图
        $qr_image = get_qrcode($url, 8);
        $src_w = imagesx($qr_image);
        $src_h = imagesy($qr_image);
        imagecopyresampled($image, $qr_image, 128, 354, 0, 0, 160, 160, $src_w, $src_h);
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

    //样式2
    private function _qr_code_2($nickname = '', $path = '', $url = '', $ad_text = '', $is_download = false) {
        //建立一幅100*30的图像
        $image = @imagecreatefrompng('./images/default/qr_code_2.png');
        $bg_w = imagesx($image);
        $bg_h = imagesy($image);
        imagesavealpha($image, true);
        //设置字体颜色
        $text_color = imagecolorallocate($image, 62, 60, 82);
        $font = "./ttfs/dfheiw5-a320.ttf";
        $text = '我是' . $nickname;
        imagettftext($image, 20, 0, 106, 68, $text_color, $font, $text);
        //广告词
        $ad_text_font_size = 16;
        $ad_text_color = imagecolorallocate($image, 255, 255, 255);
        $ad_text_1 = '';
        $ad_text_2 = '';
        $ad_len = mb_strlen($ad_text, 'utf-8');
        if ($ad_len <= 15) {
            $ad_text_1 = $ad_text;
        } else {
            $ad_text_1 = mb_substr($ad_text, 0, 15);
            $ad_text_2 = mb_substr($ad_text, 15);
        }
        //两行
        if ($ad_text_1 && $ad_text_2) {
            $ad_text_1_w = $this->_text_width($ad_text_1, $ad_text_font_size);
            $ad_text_2_w = $this->_text_width($ad_text_2, $ad_text_font_size);
            imagettftext($image, $ad_text_font_size, 0, ($bg_w - $ad_text_1_w) / 2, 218, $ad_text_color, $font, $ad_text_1);
            imagettftext($image, $ad_text_font_size, 0, ($bg_w - $ad_text_2_w) / 2, 245, $ad_text_color, $font, $ad_text_2);
        }
        //一行
        else {
            if ($ad_text_1) {
                $ad_text_1_w = $this->_text_width($ad_text_1, $ad_text_font_size);
                imagettftext($image, $ad_text_font_size, 0, ($bg_w - $ad_text_1_w) / 2, 229, $ad_text_color, $font, $ad_text_1);
            }
        }
        //生成头像小图
        if ($path) {
        	$src_img = $this->radius_img($path, 74, 74, 8);
        	$src_w = imagesx($src_img);
        	$src_h = imagesy($src_img);
        	imagecopyresampled($image, $src_img, 16, 35, 0, 0, 74, 74, $src_w, $src_h);
        	imagedestroy($src_img);
        }
        //二维码图
        $qr_image = get_qrcode($url, 8);
        $src_w = imagesx($qr_image);
        $src_h = imagesy($qr_image);
        imagecopyresampled($image, $qr_image, 44, 296, 0, 0, 196, 196, $src_w, $src_h);
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

    //样式3
    private function _qr_code_3($nickname = '', $path = '', $url = '', $ad_text = '', $is_download = false) {
        //建立一幅100*30的图像
        $image = @imagecreatefrompng('./images/default/qr_code_3.png');
        imagesavealpha($image, true);
        $bg_w = imagesx($image);
        $bg_h = imagesy($image);
        //设置字体颜色
        $text_color = imagecolorallocate($image, 62, 60, 82);
        $font = "./ttfs/dfheiw5-a320.ttf";
        $text = '我是' . $nickname;
        $text_width = $this->_text_width($text);
        imagettftext($image, 20, 0, ($bg_w - $text_width) / 2, 176, $text_color, $font, $text);
        //广告词
        $ad_text_font_size = 16;
        $ad_text_color = imagecolorallocate($image, 228, 0, 127);
        $ad_text_1 = '';
        $ad_text_2 = '';
        $ad_len = mb_strlen($ad_text, 'utf-8');
        if ($ad_len <= 15) {
            $ad_text_1 = $ad_text;
        } else {
            $ad_text_1 = mb_substr($ad_text, 0, 15);
            $ad_text_2 = mb_substr($ad_text, 15);
        }
        //两行
        if ($ad_text_1 && $ad_text_2) {
            $ad_text_1_w = $this->_text_width($ad_text_1, $ad_text_font_size);
            $ad_text_2_w = $this->_text_width($ad_text_2, $ad_text_font_size);
            imagettftext($image, $ad_text_font_size, 0, ($bg_w - $ad_text_1_w) / 2, 268, $ad_text_color, $font, $ad_text_1);
            imagettftext($image, $ad_text_font_size, 0, ($bg_w - $ad_text_2_w) / 2, 296, $ad_text_color, $font, $ad_text_2);
        }
        //一行
        else {
            if ($ad_text_1) {
                $ad_text_1_w = $this->_text_width($ad_text_1, $ad_text_font_size);
                imagettftext($image, $ad_text_font_size, 0, ($bg_w - $ad_text_1_w) / 2, 290, $ad_text_color, $font, $ad_text_1);
            }
        }
        //画圆边框
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefilledellipse($image, ($bg_w - 74) / 2 + 37, 86, 80, 80, $white);
        //生成头像小图
        if ($path) {
        	$src_img = $this->_create_circle($path, 74, 74);
        	$src_w = imagesx($src_img);
        	$src_h = imagesy($src_img);
        	imagecopyresampled($image, $src_img, ($bg_w - 74) / 2, 86 - 37, 0, 0, 74, 74, $src_w, $src_h);
        	imagedestroy($src_img);
        }
        //二维码图
        $qr_image = get_qrcode($url, 8);
        $src_w = imagesx($qr_image);
        $src_h = imagesy($qr_image);
        imagecopyresampled($image, $qr_image, 132, 352, 0, 0, 160, 160, $src_w, $src_h);
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

    public function download_qr($size = 8) {
        //判断是否登录
        checkLogin();
        $user_id = get_cookie('user_id');
        $systemInfo = $this->System_model->get('client_index', array('id' => 1));
        $userInfo = $this->User_model->get('distributor_status, distributor_status_time, distributor_client_remark, username, pop_code, distributor, school_distributor, net_distributor, path', array('id' => $user_id));
        download_qrcode(base_url() . getBaseUrl(false, "t/i", "t/i", $systemInfo['client_index']) . '/' . $userInfo['pop_code'] . '.html', $userInfo['path'], $size);
    }
     private function _tmp_user_info($user_id = NULL, $session_id = 0) {
        $user_info = $this->User_model->getinfo('id,path,total,score,nickname,sex,distributor,school_distributor,net_distributor', "id = $user_id");
        if ($user_info) {
            $user_info['session_id'] = $session_id;
            $user_info['path'] = $this->_fliter_image_path($user_info['path']);
            $user_info['nickname'] = $user_info['nickname'];
            $user_info['sex'] = $user_info['sex'];
            $user_info['score'] = $user_info['score'];
            $user_info['total_cart'] = $this->Cart_model->rowCount("user_id = $user_id");
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
    /*******************************积分充值开始**********************************/
    //在线充值-充积分
    public function recharge_score($score_type = 'gold') {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	//判断是否登录
    	checkLogin();
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	$score_setting_info = $this->Score_setting_model->get('*', array('id' => 1));
    	//当前位置
    	$user_id = get_cookie('user_id');
    	$location = "<a href='index.php/user.html'>会员中心</a> > <a>我的财务</a> > <a>我的资产</a> > 积分充值";
    	$user_info = $this->User_model->get('*', array('id' =>$user_id));
    	$score_type_str = $score_type == 'gold'?'金象积分':'银象积分';

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => '积分充值' . $systemInfo['site_name'],
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'location' => $location,
    			'score_type'=>$score_type,
    			'score_type_str'=>$score_type_str,
    			'score_setting_info'=>$score_setting_info,
    			'user_info' => $user_info
    	);
    	$layout = array(
    			'content' => $this->load->view('user/recharge_score', $data, TRUE)
    	);
    	$this->load->view('layout/user_default', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    //提交充值-生成充值记录-充积分
    public function pay_recharge_score() {
    	checkLoginAjax();
    	if ($_POST) {
    		$score_num = $this->input->post('score_num', TRUE);
    		$payment_type = $this->input->post('payment_type', TRUE);
    		$score_type = $this->input->post('score_type', TRUE);
    		$user_id = get_cookie('user_id');

    		$user_info = $this->User_model->get('*', array('user.id' => $user_id));
    		if (!$user_info) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}
    		if (!$payment_type || !$score_type) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}
    		if ($payment_type != 'alipay' && $payment_type != 'weixin') {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}
    		if ($score_type != 'gold' && $score_type != 'silver') {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}
    		if (!$score_num) {
    			printAjaxError('score_num', '充值数量不能为空');
    		}
    		if (!preg_match('/^[-\+]?\d+$/', $score_num)) {
    			printAjaxError('score_num', '请输入正确的充值数量');
    		}
    		if ($score_num <= 0) {
    			printAjaxError('score_num', '充值数量必须大于零');
    		}
    		$total_fee = 0;
    		$score_setting_info = $this->Score_setting_model->get('*', array('id' => 1));
    		if ($score_type == 'gold') {
    			$total_fee = $score_num/$score_setting_info['rmb_to_score_gold'];
    		} else if ($score_type == 'silver') {
    			$total_fee = $score_num/$score_setting_info['rmb_to_score_silver'];
    		}
    		$out_trade_no = $this->advdbclass->get_unique_pay_log_number();
    		//生成充值记录
    		$fields = array(
    				'user_id' => $user_id,
    				'total_fee' => $total_fee,
    				'total_fee_give' => 0,
    				'score'=>$score_num,
    				'out_trade_no' => $out_trade_no,
    				'order_num' => '',
    				'trade_status' => 'WAIT_BUYER_PAY',
    				'add_time' => time(),
    				'payment_type' => $payment_type,
    				'order_type' => "score_{$score_type}"
    		);
    		$ret_id = $this->Pay_log_model->save($fields);
    		if (!$ret_id) {
    			printAjaxError('fail', '充值提交失败');
    		}
    		printAjaxData(array('id'=>$ret_id));
    	}
    }

    //支付宝支付-充积分
    public function alipay_pay_recharge_score($pay_log_id = NULL) {
    	header('Content-type:text/html;charset=utf-8');
    	$gloabPreUrl = $this->session->userdata('gloabPreUrl');
    	checkLogin();
    	$user_id = get_cookie('user_id');
    	$pay_log_info = $this->Pay_log_model->get('*', array('id'=>$pay_log_id, 'user_id'=>$user_id, 'payment_type' =>'alipay', 'trade_status'=>'WAIT_BUYER_PAY'));
    	if (!$pay_log_info) {
    		$data = array(
    				'user_msg' => '此充值记录不存在',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}

    	/********************支付***********************/
    	require_once("sdk/alipay/alipay.config.php");
    	require_once("sdk/alipay/lib/alipay_submit.class.php");

    	//构造要请求的参数数组，无需改动
    	$parameter = array(
    			"service" => $alipay_config['service'],
    			"partner" => $alipay_config['partner'],
    			"seller_id" => $alipay_config['seller_id'],
    			"payment_type" => $alipay_config['payment_type'],
    			"notify_url" => base_url() . 'index.php/user/alipay_notify_recharge_score',
    			"return_url" => base_url() . 'index.php/user/alipay_return_recharge_score',

    			"anti_phishing_key" => $alipay_config['anti_phishing_key'],
    			"exter_invoke_ip" => $alipay_config['exter_invoke_ip'],
    			"out_trade_no" => $pay_log_info['out_trade_no'],
    			"subject" => "携众易购积分充值",
    			"total_fee" => $pay_log_info['total_fee'],
    			"body" => '积分充值即时到账支付',
    			"_input_charset" => trim(strtolower($alipay_config['input_charset']))
    	);
    	$alipay_config['notify_url'] = $parameter['notify_url'];
    	$alipay_config['return_url'] = $parameter['return_url'];
    	//建立请求
    	$alipaySubmit = new AlipaySubmit($alipay_config);
    	$html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
    	echo $html_text;
    }

    //支付 宝异步通知-充积分
    public function alipay_notify_recharge_score() {
    	if ($_POST) {
    		require_once("sdk/alipay/alipay.config.php");
    		require_once("sdk/alipay/lib/alipay_notify.class.php");
    		//计算得出通知验证结果
    		$alipay_config['notify_url'] = base_url() . 'index.php/user/alipay_notify_recharge_score';
    		$alipay_config['return_url'] = base_url() . 'index.php/user/alipay_return_recharge_score';

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
    				$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'payment_type' => 'alipay'));
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
    							$user_info = $this->User_model->get('id, score_gold, score_silver, username', array('id' => $pay_log_info['user_id']));
    							if ($user_info) {
    								//积分记录
    								if (!$this->Score_model->rowCount(array('type' => 'third_recharge_in', 'ret_id' => $pay_log_info['id'], 'user_id'=>$pay_log_info['user_id']))) {
    									$balance = 0;
				    					$score_type = '';
				    					$fields = array();
				    					if ($pay_log_info['order_type'] == 'score_gold') {
				    						$score_type = 'gold';
				    						$balance = $user_info['score_gold'] + $pay_log_info['score'];
				    						$fields['score_gold'] = $balance;
				    					} else if ($pay_log_info['order_type'] == 'score_silver') {
				    						$score_type = 'silver';
				    						$balance = $user_info['score_silver'] + $pay_log_info['score'];
				    						$fields['score_silver'] = $balance;
				    					}
				    					if ($this->User_model->save($fields, array('id'=>$pay_log_info['user_id']))) {
    										$fields = array(
    												'cause' => "充值成功-[充值交易号：{$pay_log_info['out_trade_no']}]",
    												'score' =>   $pay_log_info['score'],
    												'balance' => $balance,
    												'score_type'=>$score_type,
    												'add_time' => time(),
    												'user_id' => $user_info['id'],
    												'username' => $user_info['username'],
    												'type' => 'third_recharge_in',
    												'ret_id' => $pay_log_info['id']
    										);
    										$this->Score_model->save($fields);
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

    //支付 宝同步通知-充积分
    public function alipay_return_recharge_score() {
    	require_once("sdk/alipay/alipay.config.php");
    	require_once("sdk/alipay/lib/alipay_notify.class.php");
    	$alipay_config['notify_url'] = base_url() . 'index.php/user/alipay_notify_recharge_score';
    	$alipay_config['return_url'] = base_url() . 'index.php/user/alipay_return_recharge_score';

    	$gloabPreUrl = $this->session->userdata('gloabPreUrl');
    	$alipayNotify = new AlipayNotify($alipay_config);
    	$verify_result = $alipayNotify->verifyReturn();
    	if (!$verify_result) {
    		$data = array(
    				'user_msg' => '充值支付失败',
    				'user_url' => $gloabPreUrl
    		);

    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
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
    		$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'payment_type' => 'alipay'));
    		if (!$pay_log_info) {
    			$data = array(
    					'user_msg' => '此充值记录不存在,支付失败',
    					'user_url' => $gloabPreUrl
    			);
    			$this->session->set_userdata($data);
    			redirect(base_url() . 'index.php/message/index');
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
    				$data = array(
    						'user_msg' => '充值失败，请重试',
    						'user_url' => $gloabPreUrl
    				);
    				$this->session->set_userdata($data);
    				redirect(base_url() . 'index.php/message/index');
    			}
    		    $user_info = $this->User_model->get('id, score_gold, score_silver, username', array('id' => $pay_log_info['user_id']));
    			if ($user_info) {
    				//积分记录
    				if (!$this->Score_model->rowCount(array('type' => 'third_recharge_in', 'ret_id' => $pay_log_info['id'], 'user_id'=>$pay_log_info['user_id']))) {
    					$balance = 0;
    					$score_type = '';
    					$fields = array();
    					if ($pay_log_info['order_type'] == 'score_gold') {
    						$score_type = 'gold';
    						$balance = $user_info['score_gold'] + $pay_log_info['score'];
    						$fields['score_gold'] = $balance;
    					} else if ($pay_log_info['order_type'] == 'score_silver') {
    						$score_type = 'silver';
    						$balance = $user_info['score_silver'] + $pay_log_info['score'];
    						$fields['score_silver'] = $balance;
    					}
    					if ($this->User_model->save($fields, array('id'=>$pay_log_info['user_id']))) {
    						$fields = array(
    								'cause' => "充值成功-[充值交易号：{$pay_log_info['out_trade_no']}]",
    								'score' =>   $pay_log_info['score'],
    								'balance' => $balance,
    								'score_type'=>$score_type,
    								'add_time' => time(),
    								'user_id' => $user_info['id'],
    								'username' => $user_info['username'],
    								'type' => 'third_recharge_in',
    								'ret_id' => $pay_log_info['id']
    						);
    						$this->Score_model->save($fields);
    					}
    				}
    			}
    			redirect(base_url() . "index.php/user/pay_result_recharge_score/{$pay_log_info['id']}.html");
    		} else {
    			$fields = array();
    			if (!$pay_log_info['buyer_email']) {
    				$fields['buyer_email'] = $buyer_email;
    			}
    			if (!$pay_log_info['notify_time']) {
    				$fields['notify_time'] = $notify_time;
    			}
    			if ($fields) {
    				$this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']));
    			}
    			redirect(base_url() . "index.php/user/pay_result_recharge_score/{$pay_log_info['id']}.html");
    		}
    	} else {
    		$data = array(
    				'user_msg' => $this->_trade_status_msg[$trade_status] . '，支付失败，请重试',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    }

    //付款-微信支付界面-充积分
    public function pay_weixin_recharge_score($pay_log_id = NULL) {
    	$gloabPreUrl = $this->session->userdata('gloabPreUrl');
    	checkLogin();
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	if (!$pay_log_id) {
    		$data = array(
    				'user_msg' => '操作异常',
    				'user_url' => $gloabPreUrl
    		);

    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    	$user_id = get_cookie('user_id');
    	//判断下单用户是否存在
    	$user_info = $this->User_model->get('*', array('user.id' => $user_id));
    	if (!$user_info) {
    		$data = array(
    				'user_msg' => '用户信息不存在，充值失败',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    	$pay_log_info = $this->Pay_log_model->get('*', array('id'=>$pay_log_id, 'user_id'=>$user_id, 'payment_type' =>'weixin', 'trade_status'=>'WAIT_BUYER_PAY'));
    	if (!$pay_log_info) {
    		$data = array(
    				'user_msg' => '此充值记录不存在',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}

    	/********************微信支付**********************/
    	require_once "sdk/weixin_pay/lib/WxPay.Api.php";
    	require_once "sdk/weixin_pay/WxPay.NativePay.php";

    	$product_id = $pay_log_info['out_trade_no'];
    	$out_trade_no = $pay_log_info['out_trade_no'];

    	$notify = new NativePay();
    	$input = new WxPayUnifiedOrder();
    	$input->SetBody("携众易购积分充值");
    	$input->SetAttach($out_trade_no);
    	$input->SetTotal_fee($pay_log_info['total_fee'] * 100);
    	$input->SetTime_start(date("YmdHis"));
    	$input->SetTime_expire(date("YmdHis", time() + 600));
    	$input->SetNotify_url(base_url() . "index.php/user/weixin_notify_recharge_score");
    	$input->SetTrade_type("NATIVE");
    	$input->SetProduct_id($product_id);
    	$input->SetOut_trade_no($out_trade_no);
    	$result = $notify->GetPayUrl($input);
    	$qr_url = '';
    	if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
    		$qr_url = $result["code_url"];
    	} else {
    		if (array_key_exists('result_code', $result) && $result['result_code'] == "FAIL") {
    			//商户号重复时，要重新生成
    			if ($result['err_code'] == 'OUT_TRADE_NO_USED' || $result['err_code'] == 'INVALID_REQUEST') {
    				$out_trade_no = $this->advdbclass->get_unique_pay_log_number();
    				$product_id = $out_trade_no;
    				//生成充值记录
    				$fields = array(
    						'out_trade_no' => $out_trade_no,
    						'add_time' => time(),
    				);
    				if($this->Pay_log_model->save($fields, array('id'=>$pay_log_info['id']))) {
    					$notify = new NativePay();
    					$input = new WxPayUnifiedOrder();
    					$input->SetBody("携众易购积分充值");
    					$input->SetAttach($out_trade_no);
    					$input->SetTotal_fee($pay_log_info['total'] * 100);
    					$input->SetTime_start(date("YmdHis"));
    					$input->SetTime_expire(date("YmdHis", time() + 600));
    					$input->SetNotify_url(base_url() . "index.php/user/weixin_notify_recharge_score");
    					$input->SetTrade_type("NATIVE");
    					$input->SetProduct_id($product_id);
    					$input->SetOut_trade_no($out_trade_no);
    					$result = $notify->GetPayUrl($input);
    					if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
    						$qr_url = $result["code_url"];
    					}
    				}
    			}
    		}
    	}
    	$pay_log_info = $this->Pay_log_model->get('*', array('id'=>$pay_log_id));

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => '充值付款',
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'pay_log_info' => $pay_log_info,
    			'total' => $pay_log_info ? $pay_log_info['total_fee'] : '0.00',
    			'qr_url' => $qr_url,
    			'result' => $result,
    			'out_trade_no' => $out_trade_no,
    			'template' => $this->_template
    	);
    	$layout = array(
    			'content' => $this->load->view("{$this->_template}/pay_weixin_recharge_score", $data, TRUE)
    	);
    	$this->load->view('layout/cart_layout', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    //微信支付异步通知-充积分
    public function weixin_notify_recharge_score() {
    	/********************微信支付**********************/
    	require_once "sdk/weixin_pay/lib/WxPay.Api.php";

    	$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
    	try {
    		$data = WxPayResults::Init($xml);
    		if (array_key_exists("transaction_id", $data)) {
    			$input = new WxPayOrderQuery();
    			$input->SetTransaction_id($data["transaction_id"]);
    			$result = WxPayApi::orderQuery($input);
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

    				$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin'));
    				if ($pay_log_info && $total_fee == $pay_log_info['total_fee'] * 100) {
    					if ($pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
    						//支付记录
    						$fields = array(
    								'trade_status' => 'TRADE_SUCCESS',
    								'buyer_email' => '',
    								'notify_time' => strtotime($notify_time)
    						);
    						if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
    							$user_info = $this->User_model->get('id, score_gold, score_silver, username', array('id' => $pay_log_info['user_id']));
    							if ($user_info) {
    								//积分记录
    								if (!$this->Score_model->rowCount(array('type' => 'third_recharge_in', 'ret_id' => $pay_log_info['id'], 'user_id'=>$pay_log_info['user_id']))) {
    									$balance = 0;
    									$score_type = '';
    									$fields = array();
    									if ($pay_log_info['order_type'] == 'score_gold') {
    										$score_type = 'gold';
    										$balance = $user_info['score_gold'] + $pay_log_info['score'];
    										$fields['score_gold'] = $balance;
    									} else if ($pay_log_info['order_type'] == 'score_silver') {
    										$score_type = 'silver';
    										$balance = $user_info['score_silver'] + $pay_log_info['score'];
    										$fields['score_silver'] = $balance;
    									}
    									if ($this->User_model->save($fields, array('id'=>$pay_log_info['user_id']))) {
    										$fields = array(
    												'cause' => "充值成功-[充值交易号：{$pay_log_info['out_trade_no']}]",
    												'score' =>   $pay_log_info['score'],
    												'balance' => $balance,
    												'score_type'=>$score_type,
    												'add_time' => time(),
    												'user_id' => $user_info['id'],
    												'username' => $user_info['username'],
    												'type' => 'third_recharge_in',
    												'ret_id' => $pay_log_info['id']
    										);
    										$this->Score_model->save($fields);
    									}
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
    }

    /***
     * 微信支付心跳程序-充积分
     */
    public function get_weixin_heart_recharge_score() {
    	if ($_POST) {
    		$out_trade_no = $this->input->post('out_trade_no');
    		if (!$out_trade_no) {
    			printAjaxError('fail', '参数错误');
    		}
    		$pay_log_info = $this->Pay_log_model->get('id, trade_status', array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin'));
    		if (!$pay_log_info) {
    			printAjaxError('fail', '支付记录不存在');
    		}
    		printAjaxData($pay_log_info);
    	}
    }

    //付款完成-充积分
    public function pay_result_recharge_score($pay_log_id = NULL) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	//判断是否登录
    	checkLogin();
    	if (!$pay_log_id) {
    		$data = array(
    				'user_msg' => '此充值记录信息不存在',
    				'user_url' => base_url()
    		);
    		$this->session->set_userdata($data);
    		redirect('/message/index');
    	}
    	$user_id = get_cookie('user_id');
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	$item_info = $this->Pay_log_model->get('*', "trade_status in ('TRADE_SUCCESS','TRADE_FINISHED') and user_id = {$user_id} and id = {$pay_log_id} ");
    	if (!$item_info) {
    		$data = array(
    				'user_msg' => '此充值记录信息不存在',
    				'user_url' => base_url()
    		);
    		$this->session->set_userdata($data);
    		redirect('/message/index');
    	}

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => '积分充值完成' . $systemInfo['site_name'],
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'item_info' => $item_info
    	);
    	$layout = array(
    			'content' => $this->load->view('user/pay_result_recharge_score', $data, TRUE)
    	);
    	$this->load->view('layout/cart_layout', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    /*******************************积分充值结束**********************************/
    /*******************************账户余额充值开始**********************************/
    //在线充值界面
    public function recharge() {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	//判断是否登录
    	checkLogin();
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	//当前位置
    	$location = "<a href='index.php/user'>会员中心</a> > <a>预存款</a> > 在线充值";
    	$userInfo = $this->User_model->get('total', array('id' => get_cookie('user_id')));

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => '在线充值' . $systemInfo['site_name'],
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'location' => $location,
    			'userInfo' => $userInfo
    	);
    	$layout = array(
    			'content' => $this->load->view('user/recharge', $data, TRUE)
    	);
    	$this->load->view('layout/user_default', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    //提交充值-生成充值记录
    public function pay_recharge() {
    	checkLoginAjax();
    	if ($_POST) {
    		$total_fee = $this->input->post('total_fee', TRUE);
    		$payment_type = $this->input->post('payment_type', TRUE);
    		$user_id = get_cookie('user_id');

    		$user_info = $this->User_model->get('*', array('user.id' => $user_id));
    		if (!$user_info) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}
    		if (!$payment_type) {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}
    		if ($payment_type != 'alipay' && $payment_type != 'weixin') {
    			printAjaxError('fail', '操作异常，刷新重试');
    		}
    		if (!$total_fee) {
    			printAjaxError('total_fee', '充值金额不能为空');
    		}
    		if (!preg_match('/^\d+(\.\d+)?$/', $total_fee)) {
    			printAjaxError('total_fee', '请输入正确的充值金额');
    		}
    		if ($total_fee <= 0) {
    			printAjaxError('total_fee', '充值金额必须大于零');
    		}
    		$out_trade_no = $this->advdbclass->get_unique_pay_log_number();
    		//生成充值记录
    		$fields = array(
    				'user_id' => $user_id,
    				'total_fee' => $total_fee,
    				'total_fee_give' => 0,
    				'out_trade_no' => $out_trade_no,
    				'order_num' => '',
    				'trade_status' => 'WAIT_BUYER_PAY',
    				'add_time' => time(),
    				'payment_type' => $payment_type,
    				'order_type' => 'recharge'
    		);
    		$ret_id = $this->Pay_log_model->save($fields);
    		if (!$ret_id) {
    			printAjaxError('fail', '充值提交失败');
    		}
    		printAjaxData(array('id'=>$ret_id));
    	}
    }

    //支付宝支付-充值
    public function alipay_pay_recharge($pay_log_id = NULL) {
    	header('Content-type:text/html;charset=utf-8');
    	$gloabPreUrl = $this->session->userdata('gloabPreUrl');
    	checkLogin();
    	$user_id = get_cookie('user_id');
    	$pay_log_info = $this->Pay_log_model->get('*', array('id'=>$pay_log_id, 'user_id'=>$user_id, 'payment_type' =>'alipay', 'trade_status'=>'WAIT_BUYER_PAY'));
    	if (!$pay_log_info) {
    		$data = array(
    				'user_msg' => '此充值记录不存在',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}

    	/********************支付***********************/
    	require_once("sdk/alipay/alipay.config.php");
    	require_once("sdk/alipay/lib/alipay_submit.class.php");

    	//构造要请求的参数数组，无需改动
    	$parameter = array(
    			"service" => $alipay_config['service'],
    			"partner" => $alipay_config['partner'],
    			"seller_id" => $alipay_config['seller_id'],
    			"payment_type" => $alipay_config['payment_type'],
    			"notify_url" => base_url() . 'index.php/user/alipay_notify_recharge',
    			"return_url" => base_url() . 'index.php/user/alipay_return_recharge',

    			"anti_phishing_key" => $alipay_config['anti_phishing_key'],
    			"exter_invoke_ip" => $alipay_config['exter_invoke_ip'],
    			"out_trade_no" => $pay_log_info['out_trade_no'],
    			"subject" => "携众易购账户余额充值",
    			"total_fee" => $pay_log_info['total_fee'],
    			"body" => '账户余额充值即时到账支付',
    			"_input_charset" => trim(strtolower($alipay_config['input_charset']))
    	);
    	$alipay_config['notify_url'] = $parameter['notify_url'];
    	$alipay_config['return_url'] = $parameter['return_url'];
    	//建立请求
    	$alipaySubmit = new AlipaySubmit($alipay_config);
    	$html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
    	echo $html_text;
    }

    //支付 宝异步通知
    public function alipay_notify_recharge() {
    	if ($_POST) {
    		require_once("sdk/alipay/alipay.config.php");
    		require_once("sdk/alipay/lib/alipay_notify.class.php");
    		//计算得出通知验证结果
    		$alipay_config['notify_url'] = base_url() . 'index.php/user/alipay_notify_recharge';
    		$alipay_config['return_url'] = base_url() . 'index.php/user/alipay_return_recharge';

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
    				$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'recharge', 'payment_type' => 'alipay'));
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
    							$user_info = $this->User_model->get('id, total, username', array('id' => $pay_log_info['user_id']));
    							if ($user_info) {
    								//财务记录
    								if (!$this->Financial_model->rowCount(array('type' => 'third_recharge_in', 'ret_id' => $pay_log_info['id'], 'user_id'=>$pay_log_info['user_id']))) {
    									$balance = $user_info['total'] + $pay_log_info['total_fee'];
    									if ($this->User_model->save(array('total'=>$balance), array('id'=>$pay_log_info['user_id']))) {
    										$fields = array(
    												'cause' => "充值成功-[充值交易号：{$pay_log_info['out_trade_no']}]",
    												'price' =>   $pay_log_info['total_fee'],
    												'balance' => $balance,
    												'add_time' => time(),
    												'user_id' => $user_info['id'],
    												'username' => $user_info['username'],
    												'type' => 'third_recharge_in',
    												'pay_way' => '2',
    												'ret_id' => $pay_log_info['id']
    										);
    										$this->Financial_model->save($fields);
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
    public function alipay_return_recharge() {
    	require_once("sdk/alipay/alipay.config.php");
    	require_once("sdk/alipay/lib/alipay_notify.class.php");
    	$alipay_config['notify_url'] = base_url() . 'index.php/user/alipay_notify_recharge';
    	$alipay_config['return_url'] = base_url() . 'index.php/user/alipay_return_recharge';

    	$gloabPreUrl = $this->session->userdata('gloabPreUrl');
    	$alipayNotify = new AlipayNotify($alipay_config);
    	$verify_result = $alipayNotify->verifyReturn();
    	if (!$verify_result) {
    		$data = array(
    				'user_msg' => '充值支付失败',
    				'user_url' => $gloabPreUrl
    		);

    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
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
    		$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'recharge', 'payment_type' => 'alipay'));
    		if (!$pay_log_info) {
    			$data = array(
    					'user_msg' => '此充值记录不存在,支付失败',
    					'user_url' => $gloabPreUrl
    			);
    			$this->session->set_userdata($data);
    			redirect(base_url() . 'index.php/message/index');
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
    				$data = array(
    						'user_msg' => '充值失败，请重试',
    						'user_url' => $gloabPreUrl
    				);
    				$this->session->set_userdata($data);
    				redirect(base_url() . 'index.php/message/index');
    			}
    			$user_info = $this->User_model->get('id, total, username', array('id' => $pay_log_info['user_id']));
    			if ($user_info) {
    				//财务记录
    				if (!$this->Financial_model->rowCount(array('type' => 'third_recharge_in', 'ret_id' => $pay_log_info['id'], 'user_id'=>$pay_log_info['user_id']))) {
    					$balance = $user_info['total'] + $pay_log_info['total_fee'];
    					if ($this->User_model->save(array('total'=>$balance), array('id'=>$pay_log_info['user_id']))) {
    						$fields = array(
    								'cause' => "充值成功-[充值交易号：{$pay_log_info['out_trade_no']}]",
    								'price' =>   $pay_log_info['total_fee'],
    								'balance' => $balance,
    								'add_time' => time(),
    								'user_id' => $user_info['id'],
    								'username' => $user_info['username'],
    								'type' => 'third_recharge_in',
    								'pay_way' => '2',
    								'ret_id' => $pay_log_info['id']
    						);
    						$this->Financial_model->save($fields);
    					}
    				}
    			}
    			redirect(base_url() . "index.php/user/pay_result_recharge/{$pay_log_info['id']}.html");
    		} else {
    			$fields = array();
    			if (!$pay_log_info['buyer_email']) {
    				$fields['buyer_email'] = $buyer_email;
    			}
    			if (!$pay_log_info['notify_time']) {
    				$fields['notify_time'] = $notify_time;
    			}
    			if ($fields) {
    				$this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']));
    			}
    			redirect(base_url() . "index.php/user/pay_result_recharge/{$pay_log_info['id']}.html");
    		}
    	} else {
    		$data = array(
    				'user_msg' => $this->_trade_status_msg[$trade_status] . '，支付失败，请重试',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    }

    //付款-微信支付界面
    public function pay_weixin_recharge($pay_log_id = NULL) {
    	$gloabPreUrl = $this->session->userdata('gloabPreUrl');
    	checkLogin();
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	if (!$pay_log_id) {
    		$data = array(
    				'user_msg' => '操作异常',
    				'user_url' => $gloabPreUrl
    		);

    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    	$user_id = get_cookie('user_id');
    	//判断下单用户是否存在
    	$user_info = $this->User_model->get('*', array('user.id' => $user_id));
    	if (!$user_info) {
    		$data = array(
    				'user_msg' => '用户信息不存在，充值失败',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}
    	$pay_log_info = $this->Pay_log_model->get('*', array('id'=>$pay_log_id, 'user_id'=>$user_id, 'payment_type' =>'weixin', 'trade_status'=>'WAIT_BUYER_PAY'));
    	if (!$pay_log_info) {
    		$data = array(
    				'user_msg' => '此充值记录不存在',
    				'user_url' => $gloabPreUrl
    		);
    		$this->session->set_userdata($data);
    		redirect(base_url() . 'index.php/message/index');
    	}

    	/********************微信支付**********************/
    	require_once "sdk/weixin_pay/lib/WxPay.Api.php";
    	require_once "sdk/weixin_pay/WxPay.NativePay.php";

    	$product_id = $pay_log_info['out_trade_no'];
    	$out_trade_no = $pay_log_info['out_trade_no'];

    	$notify = new NativePay();
    	$input = new WxPayUnifiedOrder();
    	$input->SetBody("携众易购账户余额充值");
    	$input->SetAttach($out_trade_no);
    	$input->SetTotal_fee($pay_log_info['total_fee'] * 100);
    	$input->SetTime_start(date("YmdHis"));
    	$input->SetTime_expire(date("YmdHis", time() + 600));
    	$input->SetNotify_url(base_url() . "index.php/user/weixin_notify_recharge");
    	$input->SetTrade_type("NATIVE");
    	$input->SetProduct_id($product_id);
    	$input->SetOut_trade_no($out_trade_no);
    	$result = $notify->GetPayUrl($input);
    	$qr_url = '';
    	if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
    		$qr_url = $result["code_url"];
    	} else {
    		if (array_key_exists('result_code', $result) && $result['result_code'] == "FAIL") {
    			//商户号重复时，要重新生成
    			if ($result['err_code'] == 'OUT_TRADE_NO_USED' || $result['err_code'] == 'INVALID_REQUEST') {
    				$out_trade_no = $this->advdbclass->get_unique_pay_log_number();
    				$product_id = $out_trade_no;
    				//生成充值记录
    				$fields = array(
    						'out_trade_no' => $out_trade_no,
    						'add_time' => time(),
    				);
    				if($this->Pay_log_model->save($fields, array('id'=>$pay_log_info['id']))) {
    					$notify = new NativePay();
    					$input = new WxPayUnifiedOrder();
    					$input->SetBody("携众易购账户余额充值");
    					$input->SetAttach($out_trade_no);
    					$input->SetTotal_fee($pay_log_info['total'] * 100);
    					$input->SetTime_start(date("YmdHis"));
    					$input->SetTime_expire(date("YmdHis", time() + 600));
    					$input->SetNotify_url(base_url() . "index.php/user/weixin_notify_recharge");
    					$input->SetTrade_type("NATIVE");
    					$input->SetProduct_id($product_id);
    					$input->SetOut_trade_no($out_trade_no);
    					$result = $notify->GetPayUrl($input);
    					if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
    						$qr_url = $result["code_url"];
    					}
    				}
    			}
    		}
    	}
    	$pay_log_info = $this->Pay_log_model->get('*', array('id'=>$pay_log_id));

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => '充值付款',
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'pay_log_info' => $pay_log_info,
    			'total' => $pay_log_info ? $pay_log_info['total_fee'] : '0.00',
    			'qr_url' => $qr_url,
    			'result' => $result,
    			'out_trade_no' => $out_trade_no,
    			'template' => $this->_template
    	);
    	$layout = array(
    			'content' => $this->load->view("{$this->_template}/pay_weixin_recharge", $data, TRUE)
    	);
    	$this->load->view('layout/cart_layout', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    //微信支付异步通知
    public function weixin_notify_recharge() {
    	/********************微信支付**********************/
    	require_once "sdk/weixin_pay/lib/WxPay.Api.php";

    	$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
    	try {
    		$data = WxPayResults::Init($xml);
    		if (array_key_exists("transaction_id", $data)) {
    			$input = new WxPayOrderQuery();
    			$input->SetTransaction_id($data["transaction_id"]);
    			$result = WxPayApi::orderQuery($input);
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

    				$pay_log_info = $this->Pay_log_model->get('*', array('out_trade_no' => $out_trade_no, 'order_type' => 'recharge', 'payment_type' => 'weixin'));
    				if ($pay_log_info && $total_fee == $pay_log_info['total_fee'] * 100) {
    					if ($pay_log_info['trade_status'] != 'TRADE_FINISHED' && $pay_log_info['trade_status'] != 'TRADE_SUCCESS' && $pay_log_info['trade_status'] != 'TRADE_CLOSED') {
    						//支付记录
    						$fields = array(
    								'trade_status' => 'TRADE_SUCCESS',
    								'buyer_email' => '',
    								'notify_time' => strtotime($notify_time)
    						);
    						if ($this->Pay_log_model->save($fields, array('id' => $pay_log_info['id']))) {
    							$user_info = $this->User_model->get('id, total, username', array('id' => $pay_log_info['user_id']));
    							if ($user_info) {
    								//财务记录
    								if (!$this->Financial_model->rowCount(array('type' => 'third_recharge_in', 'ret_id' => $pay_log_info['id'], 'user_id'=>$pay_log_info['user_id']))) {
    									$balance = $user_info['total'] + $pay_log_info['total_fee'];
    									if ($this->User_model->save(array('total'=>$balance), array('id'=>$pay_log_info['user_id']))) {
    										$fields = array(
    												'cause' => "充值成功-[充值交易号：{$pay_log_info['out_trade_no']}]",
    												'price' =>   $pay_log_info['total_fee'],
    												'balance' => $balance,
    												'add_time' => time(),
    												'user_id' => $user_info['id'],
    												'username' => $user_info['username'],
    												'type' => 'third_recharge_in',
    												'pay_way' => '3',
    												'ret_id' => $pay_log_info['id']
    										);
    										$this->Financial_model->save($fields);
    									}
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
    }

    /***
     * 微信支付心跳程序
     */
    public function get_weixin_heart_recharge() {
    	if ($_POST) {
    		$out_trade_no = $this->input->post('out_trade_no');
    		if (!$out_trade_no) {
    			printAjaxError('fail', '参数错误');
    		}
    		$pay_log_info = $this->Pay_log_model->get('id, trade_status', array('out_trade_no' => $out_trade_no, 'payment_type' => 'weixin', 'order_type' => 'recharge'));
    		if (!$pay_log_info) {
    			printAjaxError('fail', '支付记录不存在');
    		}
    		printAjaxData($pay_log_info);
    	}
    }

    //付款完成
    public function pay_result_recharge($pay_log_id = NULL) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	//判断是否登录
    	checkLogin();
    	if (!$pay_log_id) {
    		$data = array(
    				'user_msg' => '此充值记录信息不存在',
    				'user_url' => base_url()
    		);
    		$this->session->set_userdata($data);
    		redirect('/message/index');
    	}
    	$user_id = get_cookie('user_id');
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	$item_info = $this->Pay_log_model->get('*', "trade_status in ('TRADE_SUCCESS','TRADE_FINISHED') and user_id = {$user_id} and id = {$pay_log_id} ");
    	if (!$item_info) {
    		$data = array(
    				'user_msg' => '此充值记录信息不存在',
    				'user_url' => base_url()
    		);
    		$this->session->set_userdata($data);
    		redirect('/message/index');
    	}

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => '充值完成' . $systemInfo['site_name'],
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'item_info' => $item_info
    	);
    	$layout = array(
    			'content' => $this->load->view('user/pay_result_recharge', $data, TRUE)
    	);
    	$this->load->view('layout/cart_layout', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }

    //充值记录
    public function get_pay_log_list($clear = '1',$page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
    	//判断是否登录
    	checkLogin();
    	//当前位置
    	$location = "<a href='index.php/user.html'>会员中心</a> > <a href='javascript:void(0);'>我的账户</a> > 提现记录";
    	$user_id = get_cookie('user_id');
    	$systemInfo = $this->System_model->get('*', array('id' => 1));
    	if ($clear) {
    		$clear = 0;
    		$this->session->unset_userdata(array('search' => ''));
    	}
    	$condition = "user_id = '{$user_id}' and order_type = 'recharge' ";
    	$strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : $condition;
    	//分页
    	$paginationCount = $this->Pay_log_model->rowCount($strWhere);
    	$this->config->load('pagination_config', TRUE);
    	$paginationConfig = $this->config->item('pagination_config');
    	$paginationConfig['base_url'] = base_url() . "index.php/user/get_pay_log_list/{$clear}/";
    	$paginationConfig['total_rows'] = $paginationCount;
    	$paginationConfig['uri_segment'] = 4;
    	$this->pagination->initialize($paginationConfig);
    	$pagination = $this->pagination->create_links();

    	$item_list = $this->Pay_log_model->gets($strWhere, $paginationConfig['per_page'], $page);
    	$user_info = $this->User_model->get('total,pay_password', array('user.id' => get_cookie('user_id')));

    	$data = array(
    			'site_name' => $systemInfo['site_name'],
    			'index_name' => $systemInfo['index_name'],
    			'index_url' => $systemInfo['index_url'],
    			'client_index' => $systemInfo['client_index'],
    			'title' => '提现记录_会员中心' . $systemInfo['site_name'],
    			'keywords' => $systemInfo['site_keycode'],
    			'description' => $systemInfo['site_description'],
    			'site_copyright' => $systemInfo['site_copyright'],
    			'icp_code' => $systemInfo['icp_code'],
    			'html' => $systemInfo['html'],
    			'item_list' => $item_list,
    			'location' => $location,
    			'user_info'=>$user_info,
    			'template' => $this->_template,
    			'pay_log_payment_type_arr' => $this->_pay_log_payment_type_arr,
    			'trade_status_msg'=>$this->_trade_status_msg,
    			'pagination' => $pagination
    	);
    	$layout = array(
    			'content' => $this->load->view('user/get_pay_log_list', $data, TRUE)
    	);
    	$this->load->view('layout/user_default', $layout);
    	//缓存
    	if ($systemInfo['cache'] == 1) {
    		$this->output->cache($systemInfo['cache_time']);
    	}
    }
    /*******************************账户余额充值结束**********************************/
}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */