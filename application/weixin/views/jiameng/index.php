<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>-折街加盟</title>
                <base href="<?php echo base_url();?>">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="js/weixin/mui/css/mui.min.css"/>
		<style type="text/css">
			.clearfix{zoom:1;}
			.clearfix::after{display:block;clear:both;content:"";}

			.contentbox{width:100%;}
			.contentbox1{margin:15px 0;float:left;}
			.contentbox1 .contentbox-left{width:30%;float:left;}
			.contentbox1 .contentbox-left img{width:80%;margin-left:10%;}
			.contentbox1 .contentbox-right{text-align: center;width:70%;float:left;margin-top:7%;}
			.contentbox1 .contentbox-right p{color:#4d4d4d;font-size:12px;}

			.contentbox2{background:url(js/weixin/mui/images/bg1.png) no-repeat;background-size:100% 100%;clear:both;padding:15px 0px;}
			.contentbox2 .contentbox-top{color:#fff;text-align:center;padding:12px 0px;}
			.contentbox2 .contentbox-top h1{font-size:15px;font-weight:900;margin:0;}
			.contentbox2 .contentbox-top h2{font-size:13px; font-weight:900; margin:0;}
			.contentbox2 .contentbox-bottom{width:90%;margin-left:5%;padding:5px 0px 10px;}
			.contentbox2 .contentbox-bottom p{color:#fff; font-size:12px;margin:0;line-height:1.7em;}

			.contentbox3{background:url(js/weixin/mui/images/bg2.png) no-repeat;background-size:100% 100%;float:left;padding:15px 0;}
			.contentbox3 .contentbox-top{color:#141414;text-align:center;padding:15px 0px;}
			.contentbox3 .contentbox-top h1{font-size:15px;font-weight:900;margin:0;}
			.contentbox3 .contentbox-top h2{font-size:13px; font-weight:900; margin:0;}

			.contentbox3 .contentbox-center{float:left;}
			.contentbox3 .contentbox-center .contentbox-body{width:42%;margin-left:5%; float:left;}
			.contentbox3 img{box-shadow:2px 2px 7px rgba(0,0,0,.25);-webkit-box-shadow:2px 2px 7px rgba(0,0,0,.25);}
			.contentbox3 .contentbox-center .contentbox-body:first-child{margin-right:1%;}
			.contentbox3 .contentbox-center .contentbox-body .contentbox-bodytop{text-align:center;}
			.contentbox3 .contentbox-center .contentbox-body .contentbox-bodytop h3{font-size:12px; margin:0;color:#4d4d4d;}
			.contentbox3 .contentbox-center .contentbox-body .contentbox-bodytop p{font-size:12px; padding-top:5px;color:#666;}
			.contentbox3 .contentbox-center .contentbox-body .contentbox-bodycenter img{ float:left;width:48%;margin:2% 0;}
			.contentbox3 .contentbox-center .contentbox-body .contentbox-bodycenter img:first-child{margin-left:0;margin-right:4%;}
			.contentbox3 .contentbox-center .contentbox-body .contentbox-bodycenter img:last-child{margin-top:0px;}
			.contentbox3 .contentbox-bottom{width:90%;margin-left:5%;float:left;padding:5px 0px 10px;}
			.contentbox3 .contentbox-bottom img{margin-right:2.5%; width:18%; float:left;}
			.contentbox3 .contentbox-bottom img:last-child{margin-right:0;}
			.contentbox3 .contentbox-bottom span{margin-top:15px;float:right;font-size:14px;color:#444;}


                        .contentbox4{background:#e61d47; color:#fff; padding:20px 5%; clear:both;float:left;}
			.contentbox4 h1{font-size:15px;text-align:center;padding-bottom:15px;}
			.contentbox4 .contentbox-top h2{font-size:12px;}
			.contentbox4 .contentbox-top p{font-size:12px;color:#fff; padding-top:5px;padding-bottom:8px;}
			.contentbox4 .contentbox-center .picture{float:left; width:47.5%;}

			.contentbox4 .contentbox-center .picture img{width:100%;border-radius: 8px;box-shadow:2px 2px 9px rgba(0,0,0,.25);-webkit-box-shadow:2px 2px 9px rgba(0,0,0,.25);}
			.contentbox4 .contentbox-center .picture:first-child{margin-right:5%;}
			.contentbox4 .contentbox-center .picture p{color:#fff;text-align:center;margin:10px 0 0;font-size:12px;}

			.contentbox5{background:url(js/weixin/mui/images/bg3.png) no-repeat; padding:20px 5% 20px; clear:both;}
			.contentbox5 .contentbox-top h2{font-size:12px;color:#4d4d4d;}
			.contentbox5 .contentbox-top p{font-size:12px;color:#4d4d4d;padding-top:5px;}
			.contentbox5 .contentbox-center{padding-top:5px;}
			.contentbox5 .contentbox-center img{border-radius:8px;box-shadow:2px 2px 9px rgba(0,0,0,.25);-webkit-box-shadow:2px 2px 9px rgba(0,0,0,.25); width:100%;}
			.contentbox5 .contentbox-center p{text-align: center; color:#444;padding-top:7px; margin:0; font-size: 14px;}

			.contentbox6{ background:url(js/weixin/mui/images/bg4.png) no-repeat;color:#fff; padding:20px 3% 10px; clear:both;}
			.contentbox6 .contentbox-left{width:49%;float:left;margin-right:3%;padding-top:20px;}
			.contentbox6 .contentbox-left img{ width:100%;border-radius: 8px;box-shadow:2px 2px 9px rgba(0,0,0,.25);-webkit-box-shadow:2px 2px 9px rgba(0,0,0,.25);}
			.contentbox6 .contentbox-right{width:48%; float:left;}
			.contentbox6 .contentbox-right h2{font-size:12px;}
			.contentbox6 .contentbox-right p{color:#fff; font-size:12px;}

                        .contentbox7{background:url(js/weixin/mui/images/bg5.png) no-repeat; padding:20px 5% 20px; clear:both; float:left;}
			.contentbox7 .contentbox-top h2{font-size:12px;color:#4d4d4d;}
			.contentbox7 .contentbox-top p{font-size:12px;color:#4d4d4d;padding-top:5px;padding-bottom:10px;}
			.contentbox7 .contentbox-center .contentbox-body{width:48%; float:left;}
			.contentbox7 .contentbox-center .contentbox-body:first-child{margin-right:4%;}
			.contentbox7 img{box-shadow:2px 2px 7px rgba(0,0,0,.25);-webkit-box-shadow:2px 2px 7px rgba(0,0,0,.25);}
			.contentbox7 .contentbox-center .contentbox-body .contentbox-bodytop h3{font-size:12px; color:#4d4d4d;text-align: center;}
			.contentbox7 .contentbox-center .contentbox-body .contentbox-bodytop p{font-size:12px;color:#666;text-align:center;}
			.contentbox7 .contentbox-center .contentbox-body .contentbox-bodycenter img{ float:left;width:30%;margin:2% 3% 2% 0;}

			.contentbox8{background:#e61d47; color:#fff; padding:20px 5% 20px; clear:both;}
			.contentbox8 .contentbox-top h2{font-size:13px;}
			.contentbox8 .contentbox-top p{font-size:12px;padding-top:5px;color:#fff; padding-bottom:8px;}
			.contentbox8 .contentbox-center img{border-radius:8px;box-shadow:2px 2px 9px rgba(0,0,0,.25);-webkit-box-shadow:2px 2px 9px rgba(0,0,0,.25); width:100%;}

			.contentbox9{background:url(js/weixin/mui/images/bg6.png) no-repeat; padding:20px 5% 10px; clear:both;}
			.contentbox9 .contentbox-top{color:#e4007e;text-align:center;}
			.contentbox9 .contentbox-top h1{font-size:13px; border-bottom:1px solid#e4007e;position:relative;margin-bottom:30px; margin-top:35px;}
			.contentbox9 .contentbox-top h1 span{ position:absolute;left:17%;margin-top:-9%;z-index:99;line-height:1.8em;right:17%;}
			.contentbox9 .contentbox-top h3{font-size:12px;font-weight:normal;margin-left:10px;}
			.contentbox9 .contentbox-center{ width:78%;margin-left:8%;}

			.contentbox9 .contentbox-center .mui-input-row:first-child{margin-top:30px;}
			.contentbox9 .contentbox-center .mui-input-row{margin-top:5px;}
			.contentbox9 .contentbox-center .mui-input-row label{height:30px;width:35%;padding-top: 5px;}
			.contentbox9 .contentbox-center .mui-input-row input{background:#fff; border:1px solid #999; border-radius:0; height:30px; width:70%;margin-left:-5%;padding-left:12px;}
			.contentbox9 .contentbox-center .mui-input-row textarea{background:#fff; border:1px solid #999; border-radius:0;width:70%;margin-left:-5%;padding:5px;height:75px;padding-left:12px;}
			.contentbox9 .contentbox-center button.mui-btn{ padding:4px 16px;background:#e4007e;border-color:#e4007e; color:#fff;margin:25px 45%;}
			.contentbox9 .contentbox-bottom{font-size:12px;text-align:center; clear:both;margin-bottom:32px;}
                        .go_top{
                                    width:52px;
                                    height:52px;
                                    background:url(images/default/jiameng/goTop.png) no-repeat center center #fff;
                                    background-size:100%;
                                    position:fixed;
                                    right:15px;
                                    bottom:50px;
                                    z-index:100;
                                    cursor:pointer;
                                    display:none;
                                    border-radius: 100%;
                               }
                               .mui-content {
                                            background-color: #fff;
                               }
		</style>
	</head>

	<body style="background:#fff;">
		<div class="mui-content no-bg">
		    <img src="js/weixin/mui/images/top01.png" style="width:100%"/>
		    <div class="contentbox1 contentbox">
		    	<div class="contentbox-left"><img src="js/weixin/mui/images/shouji.jpg"/></div>
		    	<div class="contentbox-right" style="">
		    		<p>如何开一家门店,结合电商卖几十倍商品？</p>
		    		<p>如何用渠道分销,让几十家门店帮你赚钱？</p>
		    		<p style="font-size:14px;padding-top:8px;font-weight:700;">携众易购，为你揭晓！</p>
		    	</div>
		    </div>
		    <div class="contentbox2 contentbox">
		    	<div class="contentbox-top">
		    		<h1>携众易购·平台介绍</h1>
		    		<h2>Platform is introduced</h2>
		    	</div>
		    	<div id="vedio" class="contentbox-center" style="text-align: center;"></div>
		    	<div class="contentbox-bottom ">
		    		<p style="text-indent:2em;">携众易购隶属于浙江美折电子商务有限公司，总部设在“中
国电子商务之都”浙江杭州；是一个把线下店商和线上电
商整合为一体的新零售平台。专注提供品牌折扣商品，满
足消费者既能线下体验式购物，也能线上便捷式消费的需
求。携众易购秉承合作、共赢的经营理念，致力于打造城市
合伙人“店商”+“电商”+“分销”的多平台合作模式。
				</p>
		    	</div>
		    </div>
		    <div class="contentbox3 contentbox">
		    	<div class="contentbox-top">
		    		<h1>携众易购·产品体系</h1>
		    		<h2>Product system</h2>
		    	</div>
		    	<div class="contentbox-center">
		    		<div class="contentbox-body" >
		    			<div class="contentbox-bodytop">
		    				<h3>首期产品体系</h3>
		    				<p>服装,配饰,箱包,鞋帽</p>
		    			</div>
		    			<div class="contentbox-bodycenter">
		    				<img src="js/weixin/mui/images/cp1.png"/>
		    				<img src="js/weixin/mui/images/cp2.png"/>
		    				<img src="js/weixin/mui/images/cp3.png"/>
		    			</div>
		    		</div>
		    		<div class="contentbox-body">
		    			<div class="contentbox-bodytop">
		    				<h3>第一期加盟产品</h3>
		    				<p>品牌男装</p>
		    			</div>
		    			<div class="contentbox-bodycenter">
		    				<img src="js/weixin/mui/images/cp4.png"/>
		    				<img src="js/weixin/mui/images/cp5.png"/>
		    				<img src="js/weixin/mui/images/cp6.png"/>
		    			</div>
		    		</div>
		    	</div>
<!--		    	<div class="contentbox-bottom">
		    		<img src="js/weixin/mui/images/pp5.png"/>
		    		<img src="js/weixin/mui/images/pp4.png"/>
		    		<img src="js/weixin/mui/images/pp3.png"/>
		    		<img src="js/weixin/mui/images/pp2.png"/>
		    		<img src="js/weixin/mui/images/pp1.png" style="margin-right:0;"/>
		    		<span style="display:block;text-align: right; font-size: 14px;">—— 共有20多个知名品牌</span>
		    	</div>-->
		    </div>
			<div class="contentbox4 contentbox">
				<h1>携众易购·收益五步走</h1>
				<div class="contentbox-top">
					<h2><span style="float:left;background:url(js/weixin/mui/images/arrow1.png)no-repeat; background-size:100% 100%; width:14px;height:14px;margin-right:5px;"></span>第一步  店面收益：</h2>
					<p>携众易购的产品具有品牌过硬、价格亲民的特点，又是以目前市场上利润最高的男装作为切入点，在满足消费者高品低价需求的同时，赚取收益。</p>
				</div>
				<div class="contentbox-center">
					<div class="picture">
						<img src="js/weixin/mui/images/cp7.png"/>
						<p>店面展示图一</p>
					</div>
					<div class="picture">
						<img src="js/weixin/mui/images/cp18.png"/>
						<p>店面展示图二</p>
					</div>
				</div>
			</div>
			<div class="contentbox5 contentbox">
				<div class="contentbox-top">
					<h2><span style="float:left;background:url(js/weixin/mui/images/arrow2.png)no-repeat; background-size:100% 100%; width:14px;height:14px;margin-right:5px;"></span>第二步  电商收益：</h2>
					<p>男装是门店前期主打品类，而携众易购线上品类不仅包括服装，还涵盖了配饰、箱包、百货、美妆、个护等，款式也是门店的数十倍，消费者有更多的选择空间和消费机会。引导消费者在线上购物，能获得收益。</p>
				</div>
				<div class="contentbox-center">
						<img src="js/weixin/mui/images/cp9.png"/>
						<p>携众易购购物商城</p>
				</div>
			</div>
			<div class="contentbox6 contentbox clearfix">

				<div class="contentbox-left">
						<img src="js/weixin/mui/images/cp8.png"/>
				</div>
				<div class="contentbox-right">
					<h2><span style="float:left;background:url(js/weixin/mui/images/arrow1.png)no-repeat; background-size:100% 100%; width:14px;height:14px;margin-right:5px;"></span>第三步  渠道收益：</h2>
					<p>城市合伙人可在授权区域内发展店级合
伙人（加盟店和授权店），店级合伙人
发展的消费者每一笔消费，都会为城市
合伙人带来提成收益。</p>
				</div>
			</div>
			<div class="contentbox7 contentbox">
		    	<div class="contentbox-top">
		    		<h2><span style="float:left;background:url(js/weixin/mui/images/arrow2.png)no-repeat; background-size:100% 100%; width:14px;height:14px;margin-right:5px;"></span>第四步  平台收益：</h2>
					<p>平台会不定期做线上活动，把客户引流至实体门店，让客户增多！平台会陆续对接保险、充值、广告等周边生活服务，让收益增多！</p>
		    	</div>
		    	<div class="contentbox-center">
		    		<div class="contentbox-body" >
		    			<div class="contentbox-bodytop">
		    				<h3>平台引流活动</h3>
		    				<p>拼团、免单、限时抢购</p>
		    			</div>
		    			<div class="contentbox-bodycenter">
		    				<img src="js/weixin/mui/images/cp11.png"/>
		    				<img src="js/weixin/mui/images/cp12.png"/>
		    				<img src="js/weixin/mui/images/cp13.png"/>
		    			</div>
		    		</div>
		    		<div class="contentbox-body">
		    			<div class="contentbox-bodytop">
		    				<h3>规划中的生活服务</h3>
		    				<p>充值、保险、广告</p>
		    			</div>
		    			<div class="contentbox-bodycenter">
		    				<img src="js/weixin/mui/images/cp14.png"/>
		    				<img src="js/weixin/mui/images/cp16.png"/>
		    				<img src="js/weixin/mui/images/cp17.png"/>
		    			</div>
		    		</div>
		    	</div>
		    </div>
			<div class="contentbox8 contentbox">
				<div class="contentbox-top">
					<h2><span style="float:left;background:url(js/weixin/mui/images/arrow1.png)no-repeat; background-size:100% 100%; width:14px;height:14px;margin-right:5px;"></span>第五步 股权收益：</h2>
					<p><span style="font-weight: 900; font-size: 12px;">携众易购承诺: </span> 对所有合伙人根据贡献度派发相应的股权收益，让合伙人共享公司上市的成果。</p>
				</div>
				<div class="contentbox-center">
						<img src="js/weixin/mui/images/cp10.png"/>
				</div>
			</div>
			<div class="contentbox9 contentbox">
				<div class="contentbox-top">
					<h1><span>成功属于早行动、敢行动的人<br>
一条留言,一次投资,终生收益</span>
					<p style="background:#fcfcfc;margin:0;height:1px;position:absolute;border-bottom:0; width:70%;left:15%; "></p>
					</h1>
					<h3>咨询加盟政策，更多惊喜等你来拿！</h3>
				</div>
				<div class="contentbox-center">
					<div class="mui-input-row">
					    <label>姓名:</label>
					    <input id="name" type="text" placeholder="">
					</div>
					<div class="mui-input-row">
					    <label>电话:</label>
					    <input id="phone" type="text" placeholder="">
					</div>
					<div class="mui-input-row">
					    <label>地址:</label>
					    <input id="adress" type="text" placeholder="">
					</div>
					<div class="mui-input-row">
					    <label>留言:</label>
					    <textarea id="info" name="" rows="" cols=""></textarea>
					</div>
					<button type="button" onclick="submitClick();" class="mui-btn">提交</button>
				</div>
                                <div class="contentbox-bottom" style="margin-top:10px;font-size:8px;">投资有风险，适合自己的才是最好的！</div>
				<div class="contentbox-bottom" style="margin-top:10px;">*电话（手机）只有管理员才能看见！请放心填写！</div>
			</div>
		</div>
                        <div class="go_top" id="goTop"></div>

	</body>
</html>
<script src="js/weixin/mui/js/mui.js"></script>
<script src="js/weixin/mui/js/index.js" type="text/javascript" charset="UTF-8"></script>
<script src="js/weixin/mui/js/template-native.js" type="text/javascript" charset="utf-8"></script>
<script src="js/weixin/mui/js/jquery.js" type="text/javascript" charset="UTF-8"></script>
<script src="js/weixin/mui/js/immersed.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
   $("#goTop").click(function(){
        $('body,html').animate({scrollTop:0},500);
     });
     $(window).scroll(function(){
         if($(this).scrollTop() > $(document).height() - $(window).height() - 200){
             $("#goTop").fadeIn();
         }else{
              $("#goTop").fadeOut();
         }
     });

var base_url = '<?php echo base_url();?>index.php/';
window.onload = function() {

	get_video_path();
}

function get_video_path(){
	if(!network) {
		mui.alert("世界最遥远的距离莫过于断网，请检查网络设置", "提示：");
		return;
	}
	var url = base_url+'comapi/get_video_path';
	mui.ajax(url, {
		data: {},
		dataType: "json",
		type: "get",
		timeout: 10000,
		success: function(res) {
			console.log(JSON.stringify(res));
			if(res.success) {
				document.getElementById('vedio').innerHTML = res.data;
			} else {
				mui.toast(res.message);
			}
		},
		error: error
	});
}


function submitClick() {
	var name = document.getElementById('name').value;
	var phone = document.getElementById('phone').value;
	var adress = document.getElementById('adress').value;
	var info = document.getElementById('info').value;
	if (!name) {
		mui.toast('请输入姓名');
		return;
	}
	if (!/^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/.test(phone)) {
		mui.toast('请输入电话');
		return;
	}
	if (!adress) {
		mui.toast('请输入地址');
		return;
	}
	if (!info) {
		mui.toast('请输入留言');
		return;
	}
	if(!network) {
		mui.alert("世界最遥远的距离莫过于断网，请检查网络设置", "提示：");
		return;
	}
	var url = base_url + 'jiameng/index';
	mui.ajax(url, {
		data: {
			name: name,
			mobile: phone,
			address: adress,
			content: info
		},
		dataType: "json",
		type: "post",
		timeout: 10000, //超时时间设置为10秒；
		success: function(res) {
			console.log(JSON.stringify(res));
			if(res.success) {
				mui.toast('申请加盟成功!');
				mui.back();
			} else {
				mui.toast(res.message);
                                setTimeout(function(){
                                    location.reload();
                                },3000)

			}
		},
		error: error
	});
}

</script>