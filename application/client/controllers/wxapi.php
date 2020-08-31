<?php
/**
 * 微信息接口开发
 * @author xzp
 *
 */
class Wxapi extends CI_Controller{
    private $_distributor_arr = array('0' => '普通会员', '1' => '城市合伙人', '2' => '店级合伙人');
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Score_model', '', TRUE);
        $this->load->model('Score_setting_model', '', TRUE);
        $this->load->library('session');
    }
    private function _create_circle($imgpath = NULL, $w = 74, $h = 74) {
    	$ch = curl_init();
    	curl_setopt ($ch, CURLOPT_URL, $imgpath);
    	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
    	$result = curl_exec($ch);
    	curl_close($ch);

        $im = imagecreatefromstring($result);
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
    public function index(){
        //获得参数 signature nonce token timestamp echostr
        $nonce     = $_GET['nonce'];
        $token     = 'yizhejie';
        $timestamp = $_GET['timestamp'];
        $echostr   = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1( implode( $array ) );
        if( $str  == $signature && $echostr ) {
            //第一次接入weixin api接口的时候
            echo $echostr;
            exit;
        }else{
            $this->reponseMsg();
        }
    }
    //获取带参数的二维码
    public function get_ticket($userinfo = NULL){
        //推荐人信息
        $userInfo = $this->User_model->get('*', "wx_unionid = '{$userinfo['unionid']}'");
        if ($userInfo['distributor'] == 2 || $userInfo['school_distributor'] == 2 || $userInfo['net_distributor'] == 2) {
            $save_dir='uploads/qrcode/';
            $ext = '.png';
            if($dir_handle = opendir($save_dir)){
                while (false !== ($filename = readdir($dir_handle))){
                    if ($filename == $userInfo['pop_code'].$ext){
                        $path = $save_dir.$filename;
                        return $path;
                    }
                }
                closedir($dir_handle);
            }
            //获取access_token
            $this->session->unset_userdata('access_token');
            $access_token = $this->get_access_token();
            $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
            $postArr = array(
//            'expire_seconds' => 604800, //7day
                'action_name' => 'QR_LIMIT_STR_SCENE',
                'action_info' => array(
                    'scene' => array(
                        'scene_str' => $userInfo['pop_code']
                    )
                )
            );
            $postJson = json_encode($postArr);
            $res = $this->http_curl($url, $postJson);
            $ticket = $res['ticket'];
            //使用ticket获取二维码图片
            $url2 = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);

            //建立一幅100*30的图像
            $image = @imagecreatefrompng('./images/default/qr_wx_1.png');
            imagesavealpha($image, true);
            $bg_w = imagesx($image);
            $bg_h = imagesy($image);
            //设置字体颜色
            $text_color = imagecolorallocate($image, 208, 163, 98);
            $font = "./ttfs/dfheiw5-a320.ttf";
            $text = $userInfo['nickname'];
            imagettftext($image, 32, 0, 128, 75, $text_color, $font, $text);
            //生成头像小图
            $image_arr = fliter_image_path($userInfo['path']);
            $path = $image_arr['path_thumb'];
            if ($path) {
                $src_img = $this->_create_circle($path, 74, 74);
                $src_w = imagesx($src_img);
                $src_h = imagesy($src_img);
                imagecopyresampled($image, $src_img, ($bg_w - 74) / 2 - 265, 86 - 60, 0, 0, 74, 74, $src_w, $src_h);
                imagedestroy($src_img);
            }
            //二维码图
            $qr_image = imagecreatefromstring(file_get_contents($url2));
            // $qr_image = get_qrcode($im, 8);
            $src_w = imagesx($qr_image);
            $src_h = imagesy($qr_image);
            imagecopyresampled($image, $qr_image, 206, 664, 0, 0, 260, 260, $src_w, $src_h);
            imagedestroy($qr_image);

            //保存到本地
            $filename = $postArr['action_info']['scene']['scene_str'] . $ext;
            //创建保存目录
            if (!file_exists($save_dir)) {
                mkdir($save_dir, 0777, true);
            }
            clearstatcache();
            imagepng($image, $save_dir . $filename);
            imagedestroy($image);
            //展示二维码
//        echo "<img src='/".$save_dir.$filename."'>";
            return $save_dir . $filename;
        }else{
            $errmsg = '您还不是二级分销商';
            return array('errmsg'=>$errmsg);
        }
    }

    //获取带参数的二维码
    public function get_download_ticket($userinfo = NULL,$size = 30){
        //推荐人信息
        $userInfo = $this->User_model->get('*', "wx_unionid = '{$userinfo['unionid']}'");
        if ($userInfo['distributor'] == 2 || $userInfo['school_distributor'] == 2 || $userInfo['net_distributor'] == 2) {
            $save_dir='uploads/qrcode/';
            $ext = '.png';
            if($dir_handle = opendir($save_dir)){
                while (false !== ($filename = readdir($dir_handle))){
                    if ($filename == $userInfo['pop_code'].'_'.$size.$ext){
                        $path = $save_dir.$filename;
                        return $path;
                    }
                }
                closedir($dir_handle);
            }
            //获取access_token
            $this->session->unset_userdata('access_token');
            $access_token = $this->get_access_token();
            $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
            $postArr = array(
                'action_name' => 'QR_LIMIT_STR_SCENE',
                'action_info' => array(
                    'scene' => array(
                        'scene_str' => $userInfo['pop_code']
                    )
                )
            );
            $postJson = json_encode($postArr);
            $res = $this->http_curl($url, $postJson);
            $url2 = $res['url'];
            $qr_image = get_qrcode($url2, $size);


            //保存到本地
            $filename = $postArr['action_info']['scene']['scene_str'].'_'.$size.$ext;
            //创建保存目录
            if (!file_exists($save_dir)) {
                mkdir($save_dir, 0777, true);
            }
            clearstatcache();
            imagepng($qr_image, $save_dir . $filename);
            imagedestroy($qr_image);
            //展示二维码
//        echo "<img src='/".$save_dir.$filename."'>";
            return $save_dir . $filename;
        }else{
            $errmsg = '您还不是二级分销商';
            return array('errmsg'=>$errmsg);
        }
    }

    public function reponseMsg()
    {
        //获取微信推送过来的post数据（xml格式）
        $post_arr = $GLOBALS['HTTP_RAW_POST_DATA'];
        //处理消息类型
        $post_obj = simplexml_load_string($post_arr);
        //获取access_token
        $this->session->unset_userdata('access_token');
        $access_token = $this->get_access_token();
        //获取用户信息
        $openid = $post_obj->FromUserName;
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $userinfo = $this->http_curl($url);
        //判断该数据包是否是订阅的事件推送
        if (strtolower($post_obj->MsgType) == 'event') {
            //如果是关注 subscribe 事件
            if (strtolower($post_obj->Event) == 'subscribe') {
                if (strpos($post_obj->EventKey, "qrscene_") === 0) {
                    //注册会员并绑定推荐者
                    $pop_code = substr($post_obj->EventKey, 8);
                    $result = $this->reg($userinfo,$pop_code);

                    //回复用户消息(纯文本格式)
                    if (array_key_exists('errmsg', $result)){
                        $content = $result['errmsg'];
                        $info = $this->respond_text($post_obj, $content);
                        echo $info;
                        exit;
                    }else{
//                         $content = $userinfo['nickname'] . '欢迎关注携众易购';
//                         $info = $this->respond_text($post_obj, $content);
//                         echo $info;
                    	//关注成功出来免费送广告
                    	$info = $this->respond_news($post_obj);
                    	echo $info;
                    	exit;
                    }
                } else {
                	//关注成功出来免费送广告
                	$info = $this->respond_news($post_obj);
                	echo $info;
                	exit;
                }
            }

            if (strtolower($post_obj->Event) == 'scan'){
                $content = '请先取消关注后再扫码';
                $info = $this->respond_text($post_obj, $content);
                echo $info;
            }

            //如果是自定义菜单中的event->click
            if(strtolower($post_obj->Event) == 'click'){
                if(strtolower($post_obj->EventKey) == 'contact'){
                    $content = '联系电话：400-100-3611
招商邮箱：zs@yizhejie.com
携众易购官网：www.yizhejie.com';
                    $info = $this->respond_text($post_obj, $content);
                    echo $info;
                }

                if (strtolower($post_obj->EventKey) == 'qrcode'){
                        $media = $this->get_media($access_token,$userinfo);
                        if (array_key_exists('errcode', $media)) {
                            $content = '出错了！错误码：' . $media['errcode'];
                            $info = $this->respond_text($post_obj, $content);
                            echo $info;
                        } elseif (array_key_exists('errmsg', $media)){
                            $content = $media['errmsg'];
                            $info = $this->respond_text($post_obj, $content);
                            echo $info;
                        }else{
                            $media_id = $media['media_id'];
                            $info = $this->respond_image($post_obj, $media_id);
                            echo $info;
                        }
                }

//                $evenkey = explode('_', strtolower($post_obj->EventKey));
                if (strtolower($post_obj->EventKey) == 'download'){
                    $media = $this->get_download_media($access_token,$userinfo);
                    if (array_key_exists('errcode', $media)) {
                        $content = '出错了！错误码：' . $media['errcode'];
                        $info = $this->respond_text($post_obj, $content);
                        echo $info;
                    } elseif (array_key_exists('errmsg', $media)){
                        $content = $media['errmsg'];
                        $info = $this->respond_text($post_obj, $content);
                        echo $info;
                    }else{
                        $media_id = $media['media_id'];
                        $info = $this->respond_image($post_obj, $media_id);
                        echo $info;
                    }
                }
            }
        }
    }
    //回复文本消息模板
    public function respond_text($post_obj, $content)
    {
        $toUser = $post_obj->FromUserName;
        $fromUser = $post_obj->ToUserName;
        $createTime = time();
        $msgType = 'text';
        $template = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>";
        $info = sprintf($template, $toUser, $fromUser, $createTime, $msgType, $content);
        return $info;
    }
    //回复图片消息模板
    public function respond_image($post_obj, $media_id)
    {
        $toUser = $post_obj->FromUserName;
        $fromUser = $post_obj->ToUserName;
        $createTime = time();
        $msgType = 'image';
        $template = "<xml>
                     <ToUserName><![CDATA[%s]]></ToUserName>
                     <FromUserName><![CDATA[%s]]></FromUserName>
                     <CreateTime>%s</CreateTime>
                     <MsgType><![CDATA[%s]]></MsgType>
                     <Image>
                     <MediaId><![CDATA[%s]]></MediaId>
                     </Image>
                     </xml>";
        $info = sprintf($template, $toUser, $fromUser, $createTime, $msgType, $media_id);
        return $info;
    }

    //回复图文消息
    public function respond_news($post_obj) {
    	$toUser = $post_obj->FromUserName;
    	$fromUser = $post_obj->ToUserName;
    	$createTime = time();
    	$msgType = 'link';
    	$title = '夏季新款男士T恤，携众易购免费送！！ ';
    	$description = '夏至未至，清凉衣服却如约而至,随机播放的气候也是让人各种懵圈,步步紧逼的炎热感让人开始置购新衣,来携众易购，免费送你夏季新衣！';
    	$url = 'http://www.xiezhong.xin/wx/product-detail.html?item_id=385&edittype=0';
    	$picurl = 'http://www.xiezhong.xin/images/default/wxad.jpg';

    	$template = "<xml>
					<ToUserName><![CDATA[{$toUser}]]></ToUserName>
					<FromUserName><![CDATA[{$fromUser}]]></FromUserName>
					<CreateTime>{$createTime}</CreateTime>
					<MsgType><![CDATA[news]]></MsgType>
					<ArticleCount>1</ArticleCount>
					<Articles>
					<item>
					<Title><![CDATA[{$title}]]></Title>
					<Description><![CDATA[{$description}]]></Description>
					<PicUrl><![CDATA[{$picurl}]]></PicUrl>
					<Url><![CDATA[{$url}]]></Url>
					</item>
					</Articles>
					</xml>";
    	return $template;
    }

    public function get_media($access_token,$userinfo)
    {

        if ($this->session->userdata($userinfo['unionid'].'media_id')){
            return array('media_id'=>$this->session->userdata($userinfo['unionid'].'media_id'));
        }else{
            $path = $this->get_ticket($userinfo);
            if (is_array($path)){
                $errmsg = $path['errmsg'];
                return array('errmsg'=>$errmsg);
            }
            $media = $this->media_upload($access_token,$path);
            if (array_key_exists('media_id',$media)){
                $this->session->set_userdata($userinfo['unionid'].'media_id', $media['media_id']);
            }
            return $media;
        }
    }

    public function get_download_media($access_token,$userinfo,$size = 30)
    {

        if ($this->session->userdata($userinfo['unionid'].'media_id')){
            return array('media_id'=>$this->session->userdata($userinfo['unionid'].'media_id'));
        }else{
            $path = $this->get_download_ticket($userinfo,$size);
            if (is_array($path)){
                $errmsg = $path['errmsg'];
                return array('errmsg'=>$errmsg);
            }
            $media = $this->media_upload($access_token,$path);
            if (array_key_exists('media_id',$media)){
                $this->session->set_userdata($userinfo['unionid'].'media_id', $media['media_id']);
            }
            return $media;
        }
    }

    //增加临时素材
    public function media_upload($access_token,$path){
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$access_token&type=image";
        if (class_exists('\CURLFile')) {
            $json = array('media' => new \CURLFile($path));
        } else {
            $json = array('media' => '@' . $path);
        }
//        $json= json_encode($data);
        $res = $this->http_curl($url,$json);
        return $res;
    }
    //获取临时素材
    public function media_get()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=MEDIA_ID";
        $res = $this->http_curl($url);
        return $res;
    }

    public function definded_menu()
    {
        $this->session->unset_userdata('access_token');
        $access_token = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $post_arr = array(
            "button"=>array(
                array(
                    'name'=>urlencode('携众易购'),
                    'sub_button'=>array(
                       array(
                           'type'=>'click',
                           'name'=>urlencode('推广二维码'),
                           'key'=>'qrcode'
                       ),//第一个二级菜单
                        array(
                            'type'=>'click',
                            'name'=>urlencode('下载推广码素材'),
                            'key'=>'download'
                        ),//第一个二级菜单
                        array(
                            'type'=>'click',
                            'name'=>urlencode('联系我们'),
                            'key'=>'contact'
                        ),//第二个二级菜单
                        array(
                            'type'=>'view',
                            'name'=>urlencode('申请加盟'),
                            'url'=>'http://www.xiezhong.xin/weixin.php/jiameng',
                        ),//第三个二级菜单
                        array(
                            'type'=>'view',
                            'name'=>urlencode('APP下载'),
                            'url'=>'http://a.app.qq.com/o/simple.jsp?pkgname=com.zjmzsw.yizhejie',
                        ),//第四个二级菜单
                    )
                ),//第一个一级菜单
                array(
                    'type'=>'view',
                    'name'=>urlencode('进入商城'),
                    'url'=>'http://www.yizhejie.com',
                ),//第二个一级菜单
                array(
                    'type'=>'view',
                    'name'=>urlencode('用户中心'),
                    'url'=>'http://www.xiezhong.xin/wx/member_weixin.html',
                ),//第三个一级菜单
            ),
        );
        $post_json = urldecode(json_encode($post_arr));
        $res = $this->http_curl($url,$post_json);
        var_dump($res);
    }


    /**
     * curl post/get
     * @param $url
     * @param string $data
     * @return mixed
     */
    public function http_curl($url, $data = '')
    {
        //2初始化
        $ch = curl_init();
        //3.设置参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    //不验证证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);    //不验证证书
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }
        //4.调用接口
        $res = curl_exec($ch);
        //5.关闭curl
        curl_close( $ch );
//        if(curl_errno($ch)){
//            return curl_error($ch);
//        }else{
//            //5.关闭curl
//        curl_close( $ch );
            $arr = json_decode($res, true);
            return $arr;
//        }
    }

    //返回access_token
    public function get_access_token(){
        if ($this->session->userdata('access_token') && $this->session->userdata('expire_time') > time()){
            return $this->session->userdata('access_token');
        }else{
            //如果session中不存在或者已过期，重新获取
            $appid = 'wxe734eec75f484eb9';
            $appSecret = '43edf4bdf46a53fdb35cb4264c62d1e6';
//            $appid = 'wxc381b233c720731f';
//            $appSecret = '39f99b9afed8e1cc223e9c2ea6416b81';
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appSecret";
            $res = $this->http_curl($url);
            $access_token = $res['access_token'];
            //将重新获取的access_token存到session
            $this->session->set_userdata('access_token', $access_token);
            $this->session->set_userdata('expire_time', time()+7000);
            return $access_token;
        }
    }

    //注册会员并绑定上级
    public function reg($userinfo,$pop_code = '')
    {
        $exist = $this->User_model->get('*', "wx_unionid = '{$userinfo['unionid']}'");
        if (!$exist) {
            //推荐人
            $presenter_id = 0;
            $presenter_username = '';
            $distributor = 0;
            $school_distributor = 0;
            $net_distributor = 0;
            if ($pop_code) {
                $tmp_user_info = $this->User_model->get('id, username, distributor_status,distributor, school_distributor, net_distributor', array('pop_code' => $pop_code));
                if (!$tmp_user_info) {
                    $errmsg = '邀请码错误';
                    return array('errmsg'=>$errmsg);
                }
                if ($tmp_user_info['distributor_status'] == 0) {
                    $errmsg = '此分销商还在审核中，暂时不能推广用户';
                    return array('errmsg'=>$errmsg);
                } else if ($tmp_user_info['distributor_status'] == 2 || $tmp_user_info['distributor_status'] == 3) {
                    $errmsg = '此分销商没有推广用户的权限';
                    return array('errmsg'=>$errmsg);
                }
                if ($tmp_user_info['distributor'] == 1) {
                    $errmsg = '此分销商不是店级合伙人';
                    return array('errmsg'=>$errmsg);
//                    $presenter_id = $tmp_user_info['id'];
//                    $presenter_username = $tmp_user_info['username'];
//                    $distributor = 2;
                } else if ($tmp_user_info['distributor'] == 2) {
                    $presenter_id = $tmp_user_info['id'];
                    $presenter_username = $tmp_user_info['username'];
                    $distributor = 0;
                } else if ($tmp_user_info['school_distributor'] == 1) {
                    $errmsg = '此分销商不是校园二级分销商';
                    return array('errmsg'=>$errmsg);
//                    $presenter_id = $tmp_user_info['id'];
//                    $presenter_username = $tmp_user_info['username'];
//                    $school_distributor = 2;
                } else if ($tmp_user_info['school_distributor'] == 2) {
                    $presenter_id = $tmp_user_info['id'];
                    $presenter_username = $tmp_user_info['username'];
                    $school_distributor = 0;
                } else if ($tmp_user_info['net_distributor'] == 1) {
                    $errmsg = '此分销商不是网络二级分销商';
                    return array('errmsg'=>$errmsg);
//                    $presenter_id = $tmp_user_info['id'];
//                    $presenter_username = $tmp_user_info['username'];
//                    $net_distributor = 2;
                } else if ($tmp_user_info['net_distributor'] == 2) {
                    $presenter_id = $tmp_user_info['id'];
                    $presenter_username = $tmp_user_info['username'];
                    $net_distributor = 0;
                }
            }
//            if ($distributor == 2) {
//                if (!$province_id) {
//                    printAjaxError('province_id', '请选择省');
//                }
//                if (!$city_id) {
//                    printAjaxError('city_id', '请选择市');
//                }
//                if (!$area_id) {
//                    printAjaxError('area_id', '请选择县');
//                }
//                if (!$txt_address) {
//                    printAjaxError('fail', '请选择地区');
//                }
//                if (!$address) {
//                    printAjaxError('fail', '请输入详细地址');
//                }
//            }
            $addTime = time();
            $url_arr = explode("/",$userinfo['headimgurl']);
            $url_arr[5] = 132;
            $newurl = implode("/", $url_arr);
            $fields = array(
                'user_group_id' => 1,
                'username' => '',
                'login_time' => time(),
                'password' => '',
                'mobile' => '',
                'add_time' => $addTime,
                'nickname' => $userinfo['nickname'],
                'path' => $newurl,
                'sex' => $userinfo['sex'],
                'wx_unionid' => $userinfo['unionid'],
                'presenter_id' => $presenter_id,
                'presenter_username' => $presenter_username,
                'distributor' => $distributor,
                'school_distributor' => $school_distributor,
                'net_distributor' => $net_distributor,
//                'province_id' => $province_id ? $province_id : 0,
//                'city_id' => $city_id ? $city_id : 0,
//                'area_id' => $area_id ? $area_id : 0,
//                'txt_address' => $txt_address ? $txt_address : '',
//                'address' => $address ? $address : ''
            );
            $cause = '注册成功-送积分';
            $score = 0;
            $type = '';
            $score_setting_info = $this->Score_setting_model->get('reg_score, store_score, school_score, net_score', array('id' => 1));
            if ($score_setting_info) {
                $score = $score_setting_info['reg_score'];
                $type = 'reg_score_in';
                $cause = '注册成功-送积分';
                $fields['score'] = $score_setting_info['reg_score'];
                if ($pop_code) {
                    if ($tmp_user_info['distributor'] == 2) {
                        //店级合伙人推荐的客户送积分
                        $score = $score_setting_info['store_score'];
                        $type = 'store_score_in';
                        $cause = '注册成功-送积分[推荐入驻]';
                        $fields['score'] = $score_setting_info['store_score'];
                    } else {
                        if ($tmp_user_info['school_distributor'] == 2) {
                            //校园二级分销商推荐的客户送积分
                            $score = $score_setting_info['school_score'];
                            $type = 'school_score_in';
                            $cause = '注册成功-送积分[推荐入驻]';
                            $fields['score'] = $score_setting_info['school_score'];
                        } else {
                            if ($tmp_user_info['net_distributor'] == 2) {
                                //网络二级分销商推荐的客户送积分
                                $score = $score_setting_info['net_score'];
                                $type = 'net_score_in';
                                $cause = '注册成功-送积分[推荐入驻]';
                                $fields['score'] = $score_setting_info['net_score'];
                            }
                        }
                    }
                }
            }
            $ret = $this->User_model->save($fields);
            if ($ret) {
                if ($score_setting_info) {
                    $sFields = array(
                        'cause' => $cause,
                        'score' => $score,
                        'balance' => $score,
                        'type' => $type,
                        'add_time' => time(),
                        'username' => '',
                        'user_id' => $ret,
                        'ret_id' => $ret
                    );
                    $this->Score_model->save($sFields);
                }
            }
        } else {
            $errmsg = '您已经注册过微信会员';
            return array('errmsg'=>$errmsg);
        }
        return array(
            'tmp_user_name'=>$tmp_user_info['username'],
            'distributor'=>$distributor,
            );
    }
}