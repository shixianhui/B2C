var base_url = 'http://www.xiezhong.xin/weixin.php/';
var network = true;
if(mui.os.plus) {
	mui.plusReady(function() {
		if(plus.networkinfo.getCurrentType() == plus.networkinfo.CONNECTION_NONE) {
			network = false;
		}		
	});
}
var error = function(xhr, type, errorThrown) {
	if(type == 'timeout') {
		mui.toast('请求网络超时，请再次尝试');
	} else if(type == 'parsererror') {
		mui.toast('服务器返回数据格式错误');
	} else {
		mui.toast('请求网络失败:'+type);
	}
	console.log(type);
        document.getElementById('loading').style.display = 'none';
};
var aniShow = "pop-in";
//只有ios支持的功能需要在Android平台隐藏；
if(mui.os.android) {
	var list = document.querySelectorAll('.ios-only');
	if(list) {
		for(var i = 0; i < list.length; i++) {
			list[i].style.display = 'none';
		}
	}
	//Android平台暂时使用slide-in-right动画
	if(parseFloat(mui.os.version)<4.4){
		aniShow = "slide-in-right";
	}
}