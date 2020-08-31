<?php
require_once('getui/IGt.Push.php');
require_once('getui/igetui/IGt.AppMessage.php');
require_once('getui/igetui/IGt.APNPayload.php');
require_once('getui/igetui/template/IGt.BaseTemplate.php');
require_once('getui/IGt.Batch.php');
require_once('getui/igetui/utils/AppConditions.php');

class Getuiapiclass{

    public function send_push($cid = NULL, $push_content = NULL) {
    	$HOST = 'http://sdk.open.api.igexin.com/apiex.htm';
    	$APPKEY = '2UvBbVZU2m8kvkOvDOPr57';
    	$APPID = 'u39LRholj69J5xe95J7NH1';
    	$MASTERSECRET = 'TPzTc1cRPk9DB2sOH82o06';

    	$igt = new IGeTui($HOST,$APPKEY,$MASTERSECRET);
    	$template = $this->_IGtNotificationTemplate($APPID, $APPKEY, '携众易购', $push_content);
    	$message = new IGtSingleMessage();

    	$message->set_isOffline(true);//是否离线
    	$message->set_offlineExpireTime(3600*12*1000);//离线时间
    	$message->set_data($template);//设置推送消息类型
    	//$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，2为4G/3G/2G，1为wifi推送，0为不限制推送
    	//接收方
    	$target = new IGtTarget();
    	$target->set_appId($APPID);
    	$target->set_clientId($cid);
    	//$target->set_alias(Alias);

    	try {
    		$igt->pushMessageToSingle($message, $target);
    	}catch(RequestException $e){
    		$requstId = $e.getRequestId();
    		//失败时重发
    		$rep = $igt->pushMessageToSingle($message, $target,$requstId);
    	}
    }

    private function _IGtNotificationTemplate($APPID = NULL, $APPKEY = NULL, $title = '', $content = '') {
    	$template = new IGtNotificationTemplate ();
    	$template->set_appId ( $APPID ); // 应用appid
    	$template->set_appkey ( $APPKEY ); // 应用appkey
    	$template->set_transmissionType ( 1 ); // 透传消息类型
    	$template->set_transmissionContent ( $content ); // 透传内容
    	$template->set_title ( $title ); // 通知栏标题
    	$template->set_text ( $content ); // 通知栏内容
    	$template->set_logo ( "" ); // 通知栏logo
    	$template->set_isRing ( true ); // 是否响铃
    	$template->set_isVibrate ( true ); // 是否震动
    	$template->set_isClearable ( true ); // 通知栏是否可清除
    	//$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    	//iOS推送需要设置的pushInfo字段
    	//        $apn = new IGtAPNPayload();
    	//        $apn->alertMsg = "alertMsg";
    	//        $apn->badge = 11;
    	//        $apn->actionLocKey = "启动";
    	//    //        $apn->category = "ACTIONABLE";
    	//    //        $apn->contentAvailable = 1;
    	//        $apn->locKey = "通知栏内容";
    	//        $apn->title = "通知栏标题";
    	//        $apn->titleLocArgs = array("titleLocArgs");
    	//        $apn->titleLocKey = "通知栏标题";
    	//        $apn->body = "body";
    	//        $apn->customMsg = array("payload"=>"payload");
    	//        $apn->launchImage = "launchImage";
    	//        $apn->locArgs = array("locArgs");
    	//
    	//        $apn->sound=("test1.wav");;
    	//        $template->set_apnInfo($apn);
    	return $template;
    }
}
?>