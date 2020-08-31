<!doctype html>
<html>
    <head>
		<meta charset="UTF-8">
		<title>注册页面</title>
	        <base href="<?php echo base_url(); ?>" />
                <title>注册页面</title>
                <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
                <link rel="stylesheet" type="text/css" href="js/weixin/mui/css/mui.min.css"/>
		<style type="text/css">
			body{background:#ff4646;}
			.mui-bar.mui-bar-nav{box-shadow:none;}
			.mui-title{color:#333;font-weight:700;}
			.mui-content{padding:12px;background-color:inherit;}
			.guangg{width:100%;margin-top:12px;}
			.wrap{width:73.778%;margin:17px auto 26px;}
			.wrap .mui-input-row{position:relative;}
			.wrap .mui-input-row input{padding-left:70px;font-size:14px;line-height:20px;border:none;border-radius:10px;margin-bottom:7px;height:45px;}
			.wrap .mui-input-row span{position:absolute;height:27px;display:block;padding-right:12px;top:9px;left:12px;border-right:1px solid #272636;}
			.wrap .mui-input-row span img{height:100%;}
			.wrap .phone-yz{position:relative;}
			.wrap .phone-yz input{font-size:14px;line-height:20px;padding-left:20px;width:64%;border:none;border-radius:10px; height:45px;}
			.wrap .phone-yz a{float:right;height:45px;line-height:41px;border:2px solid #fff; background:#00a0e9;color:#fff;width:34%;text-align: center;border-radius:7px;font-size:14px;}
			.wrap .phone-yz img{position:absolute;left:3px;top:-5px;width:11px;}
			.hr{border-bottom:5px solid #fff; margin-left:-12px;margin-right:-12px;}
			.wrap2 p{color:#fff;margin-top:22px;font-size:12px;}
			.wrap2 p span{color:#fec00f;}
			.wrap2 p a{color:#fec00f;text-decoration: underline;}
			.wrap2 div{width:73.778%;padding:0 12px;margin:21px auto 0px;}
			.wrap2 div .goin,.wrap2 div .down{color:#fff;background:#fec00f;height:42px;line-height:42px;padding:0 10px;border-radius:6px;margin-bottom:64px;}

		</style>
	</head>
	<body>
		<header class="mui-bar mui-bar-nav ">
		    <h1 class="mui-title">注册活动</h1>
		</header>
		<div class="mui-content no-bg">
		    <img src="js/weixin/mui/images/guangg.png" class="guangg"/>
		    <div class="wrap">
			    <div class="mui-input-row" style="overflow:visible;">
			        <span><img src="js/weixin/mui/images/userphone.png"/></span><input id="username" type="text" class="mui-input-clear" placeholder="请输入手机号码">
			        <img src="js/weixin/mui/images/jin2.png" style="position:absolute;right:2px;top:-7px;width:15px;"/>
			    </div>
			    <div class="mui-input-row" style="display:none;">
			        <span><img src="js/weixin/mui/images/username.png"/></span><input type="text" placeholder="请输入您的姓名">
			    </div>
			    <div class="phone-yz">
			        <input id="code" type="text" class="mui-input-clear" placeholder="请输入短信验证码"><a id="code_btn">获取验证码</a>
			        <img src="js/weixin/mui/images/jin1.png"/>
			    </div>
			    <a href="javascript:void(0)" id="reg_btn"><img src="js/weixin/mui/images/click-btn.png" style="width:100%;"/></a>

		    </div>
		    <div class="hr"></div>
		    <div class="wrap2">
		    	<p><span>注：</span>如已有账号，请复制下面的邀请码，到会员中心绑定领取积分邀请码：<a id="invitation"><?php echo $pop_code; ?></a></p>
		    	<div><a href="<?php echo base_url();?>" class="goin mui-pull-left">进入携众易购</a><a href="javascript:void(0)"  id="download_btn" class="down mui-pull-right">下载携众易购</a></div>
		    </div>
		</div>
                <script src="js/weixin/mui/js/mui.js" type="text/javascript" charset="utf-8"></script>
                <script src="js/weixin/mui/js/jquery.js" type="text/javascript" charset="utf-8"></script>
                <script src="js/weixin/mui/js/index.js?v=1.0" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			mui.init();
                         var times = 60,cuttime;
                        function code(idn) {
                                times--;
                                if(times > 0 && times < 60) {
                                        $(idn).text(times + "秒后获取");
                                      //  $(idn).attr('class', 'mui-btn mui-btn-grey');
                                        cuttime = setTimeout(function() {
                                                code(idn)
                                        }, 1000);
                                } else {
                                        $(idn).text("获取验证码");
                                        times = 60;
                                       // $(idn).attr('class', 'mui-btn mui-btn-blue');
                                        clearTimeout(cuttime);
                                }
                        }

                    //获取验证码
                    document.getElementById('code_btn').addEventListener('tap', function() {
                            if(times == 60) {
                                    var username = document.getElementById("username").value;
                                    if(!username) {
                                            mui.toast('请输入您的手机号');
                                            return;
                                    }
                                    var reg = /^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/;
                                    if(!reg.test(username)) {
                                            mui.toast('请输入正确的手机号');
                                            return;
                                    }
                                    var url = base_url + 'join/get_reg_sms_code';
                                    mui.ajax(url, {
                                            data: {
                                                    type: "reg",
                                                    mobile: username
                                            },
                                            dataType: "json",
                                            type: "post",
                                            timeout: 10000, //超时时间设置为10秒；
                                            success: function(res) {
                                                    if(res.success) {
                                                            code("#code_btn");
                                                            mui.toast(res.message);
                                                    } else {
                                                            mui.toast(res.message);
                                                    }
                                            },
                                            error: error
                                    });
                            }
                            return false;
                    });

    document.getElementById('reg_btn').addEventListener('tap',function () {
        var username = $('#username').val();
        var code = $('#code').val();

        if(!username) {
			mui.toast('请输入您的手机号');
			return;
		}
		var reg = /^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/;
		if(!reg.test(username)) {
			mui.toast('请输入正确的手机号');
			return;
		}
		if (!code) {
			mui.toast('请输入短信验证码');
			return;
		}

		var url = base_url + 'join/reg';
		mui.ajax(url, {
			data: {
				username: username,
				type: '0',
				code: code,
				pop_code:'<?php echo $pop_code; ?>'
			},
			dataType: "json",
			type: "post",
			timeout: 10000, //超时时间设置为10秒；
			success: function(res) {
				if(res.success) {
					var btnArray = ['取消', '下载携众易购APP'];
					mui.confirm(res.message, '提示：', btnArray, function(e) {
						if(e.index == 1) {
							if (mui.os.android) {
								window.location.href = '<?php echo $systemInfo['android_full_update_url']; ?>';
							} else if (mui.os.ios) {
								window.location.href = '<?php echo $systemInfo['ios_full_update_url']; ?>';
							} else {
								window.location.href = '<?php echo base_url(); ?>';
							}
						}
					});
				} else {
					mui.toast(res.message);
				}
			},
			error: error
		});
    });

    document.getElementById('download_btn').addEventListener('tap',function () {
        if (mui.os.android) {
			window.location.href = '<?php echo $systemInfo['android_full_update_url']; ?>';
		} else if (mui.os.ios) {
			window.location.href = '<?php echo $systemInfo['ios_full_update_url']; ?>';
		} else {
			window.location.href = '<?php echo base_url(); ?>';
		}
    });
		</script>
	</body>

</html>