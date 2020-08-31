<style type="text/css">
	.inner_box{height:auto;margin-top:0;transform:translateY(-50%);-moz-transform:translateY(-50%);-webkit-transform:translateY(-50%);}
	.sidebar .myorder strong .img_bg{background:url("images/default/backimg.png") no-repeat;background-size:24px 24px;display:block;height:24px;width:24px;margin:0 8px;}
	.sidebar .myorder.curr strong .img_bg{background:url("images/default/backimg2.png") no-repeat;background-size:24px 24px;display:block;height:24px;width:24px;margin:0 8px;}
	.sidebar .myorder span .img_bg{background:url("images/default/backimg2.png") no-repeat;background-size:24px 24px;display:block;height:24px;width:24px;margin:0 8px;}
	.back span{}
	.sidebar .myorder{margin-top:5px;}
</style>
<div class="sidebar">
    <div class="inner_box">
    		<a href="javascript:void(0);" onclick="back();" item="back" class="myorder back curr" style="height:auto;">
                <strong class="iconfont" style="font-size:16px;height:auto;line-height:22px;padding:5px 0;"><i class="img_bg"></i>返<br>回</strong>
            </a>
            <a href="<?php echo getBaseUrl(false, '', 'cart.html',$client_index)?>" class="cart">
                <strong class="iconfont">&#x343f;</strong>
                <span>购物车</span>
                <em class="cartInfo_number"><?php echo get_cookie('user_id') ? $this->advdbclass->getCartSum(get_cookie('user_id')) : 0;?></em>
            </a>
            <a href="<?php echo getBaseUrl(false, '', 'order/index/all/0.html',$client_index)?>" class="myorder">
                <strong class="iconfont">&#xe9a6;</strong>
                <span>我的订单</span>
            </a>
            <a href="<?php echo getBaseUrl(false, '', 'user/get_favorite_list',$client_index)?>" class="myorder">
                <strong class="iconfont">&#xe612;</strong>
                <span>我的收藏</span>
            </a>
            <a href="<?php echo getBaseUrl(false, '', 'user/get_score_list',$client_index)?>" class="myorder">
                <strong class="iconfont">&#xe620;</strong>
                <span>我的积分</span>
            </a>
            <a href="javascript:void(0);" class="myorder">
                <strong class="iconfont">&#xe644;</strong>
                <span>我的活动</span>
            </a>
            <!--<div class="empty" style="background:#37383c;"></div>-->
            <div class="myorder kefu_div">
                <strong class="iconfont">&#xe658;</strong>
                <span style="height:auto !important;background:#37383c; top:0px;width:auto;text-align:left;">
                	<div style="width:180px;border-bottom:1px solid #fff;padding-left:10px;">服务热线：400-800-4090</div>
                	<a title="在线咨询" href="http://wpa.qq.com/msgrd?uin=1269829527&amp;menu=yes" rel="nofollow" target="_blank" style="color:#fff;padding-left:10px;">服务QQ：1269829527</a>
                </span>
            </div>
			
            <div class="empty" style="background:#37383c;"></div>
            <a href="#" class="myorder erweima">
                <strong class="iconfont">&#xe60c;</strong>
                <div class="ewm">
                    <img src="images/default/download.png">
                    <p>下载携众易购APP</p>
                </div>
            </a>
            <a href="javascript:void()" class="myorder" onclick="$('body,html').animate({scrollTop:0},500);">
                <strong class="iconfont">&#xe618;</strong>
                <span>返回顶部</span>
            </a>
    </div>
        </div>
<script>
      $(".myorder").hover(function(){
      	        if ($(this).hasClass('back') == false) {
                    $(this).addClass('curr');
                }
               if ($(this).hasClass('kefu_div')) {
               		$(this).find('span').stop().animate({
	                   	left : '-180px'
	               	},'normal');
               } else if ($(this).hasClass('back')) {
               		$(this).find('span').stop().animate({
	                   	left : '-45px'
	               	},'normal');
               } else{
	               	$(this).find('span').stop().animate({
	                   	left : '-80px'
	               	},'normal');
               }
               
           },function(){
           	    if ($(this).hasClass('back') == false) {
                    $(this).removeClass('curr');
                }
                $(this).find('span').stop().animate({
                   left : '40px'
                },'normal');
           })
    function back(){
    	window.history.back();
    }
</script>
