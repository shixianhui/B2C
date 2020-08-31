<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <base href="<?php echo base_url(); ?>" />
    <title>全民砍价</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="js/weixin/mui/css/mui.min.css"/>
    <link rel="stylesheet" type="text/css" href="js/weixin/mui/css/iconfont.css"/>
    <link rel="stylesheet" href="js/weixin/mui/css/base.css" />
    <style type="text/css">
    	header.mui-bar{height:44px;-webkit-box-shadow:none;box-shadow:none;}
    	header.mui-bar .mui-title{font-weight:bold;}
    	div.mui-content{margin-top:0;padding-top:0px;top: 0px;}
    	.ct-time{background:#fff; padding:15px 0px; border-bottom:1px solid #cbcecf; border-top:1px solid #cbcecf;margin-top:0px;}
    	.ct-time h2{font-size:14px; text-align: center; margin-bottom:17px;}
    	.ct-time h2 span{background:#f02387;margin:0px 3px; padding:0px 2px;color:#fff; border-radius:2px;}
    	.ct-time h3{font-size:14px; text-align: center;}
    	.ct-time h3 span{margin:0px 3px; padding:0px 2px;color:#f02387; border-radius:2px;}

    	.cj-commodity{ margin-top:10px;background:#fff; border-bottom:1px solid #cbcecf;}
    	.cj-commodity .picture{background:#f9f9fb; text-align:center;}
    	.cj-commodity .picture img{width:50%; margin:0px; padding:0px;}
    	.cj-commodity .txt{ margin-top:-8px; padding:10px 12px; background:#fff;}
    	.cj-commodity .txt h4{font-size:16px; margin-bottom:13px;}
    	.cj-commodity .txt h5{font-size:14px; color:#f02387; font-weight: bold;}
    	.cj-commodity .txt h5 span{text-decoration: line-through;margin-right:50px;}
    	.cj-commodity .txt p{margin:0px; padding:0px; text-align: center;}
    	.cj-commodity .txt p button{margin:25px 0px 5px; padding:0;height:30px; font-size:16px;background:#be9336;border-color:#be9336; width:270px; border-radius:0px;}
    	.cj-commodity .txt h6{text-align:center;}
    	.cj-commodity .txt h6 button{margin:15px 15px 5px;padding:0; height:30px;font-size:16px; width:110px;background:#f02387;border-color:#f02387;}

    	.cj-new{margin-top:10px;border-bottom:1px solid #cbcecf;}
    	.cj-new .tit{border-left:3px solid #f02387; background:#fff; padding:10px 8px; margin-bottom:5px;}
    	.cj-new .tit h2{font-size:16px;display: inline-block;}
    	.cj-new .tit span{color:#f02387;}

    	.cj-new ul li{padding:10px 0px 10px 11px;}
    	.cj-new ul li a img{border-radius: 100%; width:55px;height:55px;margin-left:11px; margin-right:13px;}
    	.cj-new ul li .mui-media-body h4{font-size:16px; margin:4px 0px 10px ; padding:0px;}
    	.cj-new ul li .mui-media-body p{color:#000;margin:0px; padding:0px;}
    	.cj-new ul li .mui-media-body p span{ color:#f02387;}

    	.cj-active{margin-top:10px;border-bottom:1px solid #cbcecf;}
    	.cj-active .tit{border-left:3px solid #f02387; background:#fff; padding:10px 8px; margin-bottom:5px;}
    	.cj-active .tit h2{font-size:16px;}
    	.cj-active .txt{background:#fff;padding:14px 12px;}
    	.cj-active .txt h5{font-size:14px;color:#000;}
    	.cj-active .txt p{font-size:14px;color:#000; margin:4px 0px 4px 18px;}

    	#sheet{background:#fff; padding:15px 13px 36px;}
    	#sheet .mui-input-group{border-bottom:1px solid #dbdbdb; padding:0px 25px;}
    	#sheet p{color:#000;margin:0px; font-size:16px; margin-bottom:5px;}
    	#sheet .mui-input-group:before,#sheet .mui-input-group:after{height:0;}
    	#sheet .mui-input-group .mui-input-row{margin:12px 0px 0px; padding:0;}
    	#sheet .mui-input-group .mui-input-row:after{height:0;}
    	#sheet .mui-input-group .mui-input-row .mui-input-clear ~ .mui-icon-clear{right:20%; top:5px;}
    	#sheet .mui-input-group label{ font-size:14px;margin:0px 8px 0px 0px; padding-right:0px;padding-left:0px;width:35px;}
    	#sheet .mui-input-group input{font-size:14px;border:1px solid #f0f0f6;height:31px; float:left;padding:0px 25px 0px 5px;}
    	#sheet .mui-input-group .mui-input-row .yzm.mui-input-clear ~ .mui-icon-clear{right:35%; top:5px;}
    	.mui-input-group p .mui-btn-red{ background:#f02387; border-color:#f02387;height:36px; padding:0px; margin-top:10px;}
    	#sheet .mui-input-group .mui-input-row button{border-color:#f02387;color:#f02387;float:right;height:25px;margin-left:5px; padding:0; width:54px;}
    	#sheet .mui-input-group .mui-input-row .mui-btn-red:enabled:active,#sheet .mui-input-group .mui-input-row .mui-btn-red.mui-active:enabled{color: #fff;border: 1px solid #f02387;background-color: #f02387;}
    	#sheet .box{padding:50px 25px 38px;}
    	#sheet .box .login{position:absolute;background:#fff;margin-top:-60px;left:40%;}
    	#sheet .box a{color:#000; width:33%; float: left; text-align: center;}
    	#sheet .box a p.mui-icon-weixin{width:50px; height:50px; border:1px solid #35cd35; border-radius:100%;color:#35cd35;font-size:45px; text-align:center;vertical-align:bottom;}
    	#sheet .box a p.mui-icon-weibo{width:50px; height:50px; border:1px solid #e9474d; border-radius:100%;color:#e9474d;font-size:50px; text-align:center;vertical-align:bottom;}
    	#sheet .box a p.mui-icon-qq{width:50px; height:50px; border:1px solid #49a3fc; border-radius:100%;color:#49a3fc;font-size:45px;}
    	.share-pop ul li{ width:25%;}
    	.share-pop ul li a span{font-size:37px;}
    	.mui-btn-red:enabled:active, .mui-btn-red.mui-active:enabled{color: #fff;border: 1px solid #e11377;background-color: #e11377;}

    </style>
</head>
<body style="background:#eaeeef;">
    <header class="mui-bar mui-bar-nav" style="background:#fff;">
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color:#000;"></a>
        <h1 class="mui-title">全民砍价</h1>
    </header>
    <div class="mui-content">
        <div class="ct-time">
        	<h2 id="countdown">距活动结束还剩<span style="margin-left:5px;">02</span>小时:<span>02</span>分钟:<span>02</span>秒</h2>
        	<h3>当前参团人数已有<span><?php echo $pintuan_info['pintuan_people'];?>人</span>,拼团价为<span><?php echo $pintuan_price;?>元</span></h3>
        </div>
        <div class="cj-commodity">
        	<div class="picture">
				<img src="<?php echo $pic;?>">
        	</div>
        	<div class="txt">
        		<h4><?php echo $item_info['title'];?></h4>
        		<h5><span>原价:<?php echo $pintuan_info['high_price'];?></span>最低价:<?php echo $pintuan_info['low_price'];?></h5>
                        <p><button type="button" class="mui-btn mui-btn-yellow">宝贝已被砍掉至<span id="chopedPrice"><?php echo number_format($pintuan_price-$choped_price,2);?></span>元</button></p>
        		<h6>
        			<a href="javascript:void(0)" id="openPopover"><button type="button" class="mui-btn mui-btn-red">帮TA砍价</button></a>
        			<a href="javascript:void(0)" id="openSheet"><button type="button" class="mui-btn mui-btn-red">帮TA分享</button></a>
<!--                                <a href="#popover" id="openPopover"><button type="button" class="mui-btn mui-btn-red">帮TA砍价</button></a>
        			<a href="#sheet" id="openSheet"><button type="button" class="mui-btn mui-btn-red">帮TA分享</button></a>-->
        		</h6>
        	</div>
        </div>
       	<div class="cj-new">
       		<div class="tit">
       			<h2>最新砍价</h2><span class="mui-icon mui-icon-reload mui-pull-right"></span>
       		</div>
       		<ul class="mui-table-view" id="chopRecord">
                    <?php
                    if ($chop_record) {
                        foreach ($chop_record as $item) {
                            ?>
       		    <li class="mui-table-view-cell mui-media">
       		        <a href="javascript:;">
       		            <img class="mui-pull-left" src="<?php echo $item['path'];?>" onerror="this.src='js/weixin/mui/images/60x60.gif'">
       		            <div class="mui-media-body">
       		                <h4><?php echo $item['nickname'];?></h4>
       		                <p class="mui-ellipsis">成功帮TA砍掉了<span><?php echo $item['chop_price'];?></span>元</p>
       		            </div>
       		        </a>
       		    </li>
                    <?php }}?>
       		</ul>
       	</div>
       	<div class="cj-active">
       		<div class="tit">
       			<h2>活动说明</h2>
       		</div>
       		<div class="txt">
       			<h5>参团规则</h5>
                                 <?php
                                   foreach($pintuan_rule as $key=>$ls){
                                 ?>
                                <p><?php echo $key+1;?>、当参团人数达到<span><?php echo $ls['low'];?>~<?php echo $ls['high'];?>人</span>时可享受到<span><?php echo $ls['money'];?>元</span>的价格。</p>
                                   <?php }?>
				<h5>砍价规则</h5>
       			<p>1、可邀请<span><?php echo $pintuan_info['cut_times'];?>位</span>好友砍价</p>
			<p>2、砍价总金额为<span><?php echo $pintuan_info['cut_total_money'];?>元</span></p>
       		</div>
       	</div>
    </div>
	<div id="sheet" class="mui-popover mui-popover-bottom mui-popover-action">
	    <p>您还不是本站会员，无法参与砍价活动~ <a href="javascript:void(0);" style="color:#000;"><span class="mui-icon mui-icon-closeempty close mui-pull-right" data-close="sheet"></span></a></p>
	    <p>请注册成为会员</p>
	   	<form class="mui-input-group">
	        <div class="mui-input-row">
	       	    <label>手机:</label>
	            <input type="text" class="mui-input-clear" name="mobile" placeholder="手机号码">
                </div>
       	    <div class="mui-input-row">
       	        <label>密码:</label>
       	        <input type="password" class="mui-input-clear" name="confpassword" placeholder="密码">
       	    </div>
             <div class="mui-input-row">
       	        <label style="width: auto;">验证码:</label>
       	        <input style="width:100px;" type="text" name="codes"  class="mui-input-clear yzm" placeholder="验证码">  &nbsp;
                <img style="width:80px;height:30px;" id="valid_code_pic" src="<?php echo getBaseUrl(false, "", "verifycode/index/1", $client_index); ?>" alt="看不清，换一张" onclick="javascript:this.src = this.src+1;" />
            </div>
       	    <div class="mui-input-row">
       	        <label style="width: auto;">短信验证码:</label>
       	        <input style="width:100px;" type="text" name="smscode" class="mui-input-clear yzm" placeholder="">
                <button type="button" class="mui-btn mui-btn-danger send"  id="send">点击发送</button>
       	    </div>
       	    <p><button type="button" class="mui-btn mui-btn-red mui-btn-block" id="register">立即注册</button></p>
       	    <div class="mui-input-row" style="text-align:right;">
       	        <span style="line-height:25px;font-size:14px;">已有账号?</span>
       	       	<button type="button" class="mui-btn mui-btn-red mui-btn-outlined" id="gologin">登录</button>
       	    </div>
       	</form>
       	<div class="box" style="text-align: center;">
       		<span class="login">第三方登录</span>
       		<a href="<?php echo $code_url;?>" style="width:50%;"><p class="mui-icon mui-icon-weibo"></p><h5>微博登录</h5></a>
       		<a href="<?php echo base_url();?>sdk/authlogin/qqlogin/oauth" style="width:50%;"><p class="mui-icon mui-icon-qq"></p><h5>QQ登录</h5></a>
                </div>
       	</div>
    </div>
    <div id="share_pop" class="mui-popover mui-popover-action mui-popover-bottom share-pop mui-clearfix">
	    <ul class="mui-clearfix"style=" border-bottom:1px solid #f0f0f6;margin:0px 15px;padding:10px 0px;">
		    <Li><a href="http://www.jiathis.com/send/?webid=weixin&url=<?php echo $url;?>&title=<?php echo $title;?>&pic=<?php echo $pic;?>"style="color:#39cc42;"><span class="mui-icon mui-icon-weixin"></span><h5>微信好友</h5></a></Li>
<!--		    <Li><a href="http://www.jiathis.com/send/?webid=weixin&url=<?php //echo $url;?>&title=<?php //echo $title;?>&pic=<?php //echo $pic;?>"><span class="mui-icon mui-icon-pengyouquan"></span><h5>朋友圈</h5></a></Li>-->
		    <Li><a href="http://www.jiathis.com/send/?webid=tsina&url=<?php echo $url;?>&title=<?php echo $title;?>&pic=<?php echo $pic;?>"style="color:#e9474d;"><span class="mui-icon iconfont icon-sina-circle"></span><h5>新浪微博</h5></a></Li>
		    <Li><a href="http://www.jiathis.com/send/?webid=cqq&url=<?php echo $url;?>&title=<?php echo $title;?>&pic=<?php echo $pic;?>" style="color:#00b3f0;"><span class="mui-icon mui-icon-qq"></span><h5>QQ好友</h5></a></Li>
		    <Li><a href="http://www.jiathis.com/send/?webid=qzone&url=<?php echo $url;?>&title=<?php echo $title;?>&pic=<?php echo $pic;?>"style="color:#f5bc3f;"><span class="mui-icon iconfont icon-qzone-circle"></span><h5>QQ空间</h5></a></Li>
<!--		    <Li><a href="javascript:void(0);" style="color:#999;" id="copyUrl"><span class="mui-icon iconfont icon-link"></span><h5>复制链接</h5></a></Li>-->
    	</ul>
    		<p style="text-align:center; padding:15px 0px 5px;"><a href="javascript:void(0)" class="close" data-close="share_pop" id="close" >取消</a></p>
	</div>
  <style type="text/css">
  		#popover,#login{padding:0px 12px; height:75%; position:fixed;}
  		#popover .box,#login .box{background: #fff;height:250px;border-radius:15px;padding:10px 25px 35px;}
  		#popover .box h4,#login .box h4{font-weight:normal;color:#323232;margin:35px 0px 112px;}
  		#popover .box h4 span,#login .box h4 span{color:#f02387; font-size:16px;}
  		#popover .box button,#login .box button{background:#f02387;border-color:#f02387; border-radius:7px;height:40px; padding:0px;}
                #login .mui-input-group:before,#sheet .mui-input-group:after{height:0;}
                #login .mui-input-group .mui-input-row{margin:12px 0px 0px; padding:0;}
                #login .mui-input-group .mui-input-row:after{height:0;}
                #login .mui-input-group .mui-input-row .mui-input-clear ~ .mui-icon-clear{right:20%; top:5px;}
                #login .mui-input-group label{ font-size:14px;margin:0px 8px 0px 0px; padding-right:0px;padding-left:0px;width:35px;}
                #login .mui-input-group input{font-size:14px;border:1px solid #f0f0f6;height:31px; float:left;padding:0px 25px 0px 5px;}
                #login .mui-input-group .mui-input-row .yzm.mui-input-clear ~ .mui-icon-clear{right:35%; top:5px;}
               #sheet .mui-input-group .mui-input-row .send {
                   background-color:#f02387;
                   font-size:12px;
                   color:#fff;
                }
               #sheet .mui-input-group .mui-input-row .fail{
                    background-color:#ccc;
                    border-color:#ccc;
                }
  </style>
  <div id="popover" class="mui-popover mui-popover-action">
  	<div class="box">
  		<a href="javascript:void(0);" style="color:#323232;"><span class="mui-icon mui-icon-closeempty mui-pull-right close" data-close="popover"></span></a>
  		<h4>已经成功为好友砍掉<span>0.00</span>元</h4>
  		<a href="javascript:;" class="close" data-close="popover"><button type="button" class="mui-btn mui-btn-red mui-btn-block">确定</button></a>
  	</div>
  </div>
  <div id="login" class="mui-popover mui-popover-action">
  	<div class="box">
            <div style="height:10px;"><a href="javascript:void(0);" style="color:#323232;"><span class="mui-icon mui-icon-closeempty mui-pull-right close" data-close="login"></span></a></div>
            	<form class="mui-input-group">
	        <div class="mui-input-row">
	       	    <label>手&nbsp;&nbsp;&nbsp;机:</label>
	            <input type="text" name="username" class="mui-input-clear" placeholder="请输入手机号">
                </div>
       	    <div class="mui-input-row">
       	        <label>密&nbsp;&nbsp;&nbsp;码:</label>
       	        <input type="password" name="password"  class="mui-input-clear" placeholder="请输入密码">
       	    </div>
       	    <div class="mui-input-row">
       	        <label style="width: auto;">验证码:</label>
       	        <input style="width:100px;" type="text" name="code"  class="mui-input-clear yzm" placeholder="验证码">  &nbsp;
                <img style="width:80px;height:30px;" id="valid_code_pic" src="<?php echo getBaseUrl(false, "", "verifycode/index/1", $client_index); ?>" alt="看不清，换一张" onclick="javascript:this.src = this.src+1;" />
            </div>
       	</form>
            <button type="button" class="mui-btn mui-btn-red mui-btn-block" style="margin-top:20px;">登录</button>
  	</div>
  </div>
    <script src="js/weixin/mui/js/mui.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    var login_status = <?php echo get_cookie('user_id') ? 'false' : 'true';?> ;
    mui.init();
        function countdown(t) {
            var h = Math.floor(t / 60 / 60 % 1000)
            var m = Math.floor(t / 60 % 60);
            var s = Math.floor(t % 60);
            if (h < 10) {
                h = "0" + h;
            }
            if (m < 10) {
                m = "0" + m;
            }
            if (s < 10) {
                s = "0" + s;
            }
             document.getElementById("countdown").innerHTML = '距活动结束还剩<span style="margin-left:5px;">'+h+'</span>:小时<span>'+m+'</span>:分钟<span>'+s+'</span>秒';
            var ID = setInterval(function () {
                t--;
                var h = Math.floor(t / 60 / 60 % 1000)
                var m = Math.floor(t / 60 % 60);
                var s = Math.floor(t % 60);
                if (h < 10) {
                    h = "0" + h;
                }
                if (m < 10) {
                    m = "0" + m;
                }
                if (s < 10) {
                    s = "0" + s;
                }
                document.getElementById("countdown").innerHTML = '距活动结束还剩<span style="margin-left:5px;">'+h+'</span>:小时<span>'+m+'</span>:分钟<span>'+s+'</span>秒';
                if (t <= 0) {
                    clearInterval(ID);
                    document.getElementById("countdown").innerHTML = '此拼团活动已结束';
//                    $("#takeBtn").html('参团已结束');
//                    $("#takeBtn").addClass('buygray');
                }
            }, 1000);
        }
        countdown(<?php echo $pintuan_info['end_time'] - time();?>);
        document.getElementById("openPopover").addEventListener('tap',function(){
              if(login_status){
                  //传入toggle参数，用户无需关心当前是显示还是隐藏状态，mui会自动识别处理；
                        mui('#sheet').popover('toggle');
              }else{
                    mui.post('<?php echo base_url().'index.php/bargain/chop'?>',{
                                  sign: '<?php echo $sign;?>',
                                  id:'<?php echo $ptkj_record_id;?>'
                          },function(data){
                                if(data.success==false){
                                     mui.alert(data.message);
                                     return;
                                 }
                                mui("#popover h4 span")[0].innerHTML = data.data.chop_price;
                                var choped_price = mui("#chopedPrice")[0].innerHTML;
                                mui("#chopedPrice")[0].innerHTML = (parseFloat(choped_price)-parseFloat(data.data.chop_price)).toFixed(2);
                                var li = document.createElement('li');
                                var html = '<a href="javascript:;">\
                                            <img class="mui-pull-left" src="'+data.data.path+'" onerror="this.src=\'js/weixin/mui/images/60x60.gif\'">\
                                            <div class="mui-media-body">\
                                                <h4>'+data.data.chop_nickname+'</h4>\
                                                <p class="mui-ellipsis">成功帮TA砍掉了<span>'+data.data.chop_price+'</span>元</p>\
                                            </div>\
                                        </a>';
                                    li.innerHTML = html;
                                    mui("#chopRecord")[0].insertBefore(li,mui("#chopRecord")[0].childNodes[0]);
                                    mui('#popover').popover('toggle');
                      },'json');
              }
        },false);

        mui("#openSheet")[0].addEventListener('tap',function(){
             mui('#share_pop').popover('toggle');
        },false);
         mui('.close').each(function(){
             this.addEventListener('tap',function(){
                 mui('#'+this.dataset.close).popover('toggle');
             },false);
         });
          mui("#gologin")[0].addEventListener('tap',function(){
             mui('#share_pop').popover('toggle');
             mui('#login').popover('toggle');
        },false);
//         var height = window.clientHeight
//         window.addEventListener('resize',function(){
//
//         },false)
          document.querySelector("#login button").addEventListener('tap',function(){
              mui.post('<?php echo base_url().'index.php/user/login'?>',{
		username:document.querySelector("input[name=username]").value,
		password:document.querySelector("input[name=password]").value,
                code : document.querySelector("input[name=code]").value
                        },function(data){
                               if(data.success==false){
                                   mui.toast(data.message);
                                   return;
                               }
                               mui.alert('登录成功', function() {
                                        login_status = false;
					mui('#login').popover('toggle');
				});
                        },'json'
                );
          },false);
          var times = 60, cuttime;
    function getyzm(idn) {
        times--;
        if (times > 0 && times < 60) {
            idn.innerText = times + "秒";
            idn.classList.add("fail");
            cuttime = setTimeout(function () {
                getyzm(idn)
            }, 1000);
        } else {
            idn.innerText = "点击发送";
            times = 60;
             idn.classList.remove("fail");
            clearTimeout(cuttime);
        }
    }
    mui("#send")[0].addEventListener('tap',function(){
        if (times == 60) {
                 mui.post('<?php echo base_url().'index.php/user/get_reg_sms_code'?>',{
		type:'reg',
		mobile:document.querySelector("input[name=mobile]").value,
                code : document.querySelector("input[name=codes]").value
                        },function(data){
                               if(data.success==false){
                                   mui.toast(data.message);
                                   return;
                               }
                               getyzm(mui("#send")[0]);
                               mui.toast(data.message);
                        },'json'
                );
            }
    },false);
    mui("#register")[0].addEventListener('tap',function(){
        mui.post('<?php echo base_url().'index.php/user/register'?>',{
		mobile:document.querySelector("input[name=mobile]").value,
		password:document.querySelector("input[name=confpassword]").value,
		ref_password:document.querySelector("input[name=confpassword]").value,
                code : document.querySelector("input[name=codes]").value,
                smscode : document.querySelector("input[name=smscode]").value,
                remember : 1,
                        },function(data){
                               if(data.success==false){
                                   mui.toast(data.message);
                                   return;
                               }
                               mui.alert('注册成功', function() {
                                        login_status = false;
					mui('#sheet').popover('toggle');
				});
                        },'json'
                );
    },false);
    //解决因键盘弹出输入框不可见
    var height = window.innerHeight;
    window.addEventListener('resize',function(){
        if(document.getElementById('sheet').style.display == 'block'){
            document.getElementById('sheet').style.bottom = '-'+(height-window.innerHeight)+'px';
        }else{
            document.getElementById('sheet').style.bottom = '0px';
        };
    });
    </script>
</body>
</html>