<style>
    .kanjiajilu{
        clear:both;
        margin:10px 0px;
}
.kanjiajilu p{
    padding-left:80px;
    font-size:18px;
    margin-bottom: 10px;
}
.mask{background:rgba(0,0,0,0.3);position:fixed;top:0;left:0;z-index:500;display:none;}
        	.alert-box{width:520px;background:#fff;z-index:1000;position:absolute;border:1px solid #e6e6e6;}
        	.alert-box h4{height:40px;line-height:40px;background:#f0f0f0;font-size:16px;color:#666666;padding-left:20px;position:relative;}
        	.alert-box h4 a{width:19px;height:19px;background:url(images/default/close-btn.png) no-repeat;position:absolute;right:20px;top:8px;}
        	.address{margin:20px;height:150px;overflow:auto;}
        	.address-item{border:1px solid #e6e6e6;height:100px;width:90%;margin-bottom:10px;padding:20px;overflow:hidden;cursor:pointer;position: relative;}
        	.address-item p:nth-child(1){font-size:16px;font-weight:bold;color:#262626;margin-bottom:16px;}
        	.address-item p:nth-child(1) span{padding-left:100px;}
        	.address-item p:nth-child(2){height:auto;line-height:26px;font-size:16px;color:#4c4c4c;}
        	.address-item.active{border:2px solid #e61d47;background:url(images/default/true-btn.png) no-repeat right bottom;}
        	.express{border:1px solid #ccc;}
        	.express .express-btn{position:relative;margin:20px;height:32px;padding:0 20px;line-height:32px;display:inline-block;cursor:pointer;font-size:16px;color:#4c4c4c;border:1px solid #ccc;}
        	.express .express-btn:after{width:390%;height:1px;content:" ";background:#ccc;position:absolute;top:50px;left:-20px;}
        	.express .pay-btn{width:130px;height:38px;margin:45px 0 25px 350px;line-height:38px;text-align:center;display:block;background:#e61d47;font-size:18px;color:#fff;}
                .address-item .ok{
                    position: absolute;
                    right:15px;
                    top:10px;
                    z-index:100;
                }
                .express  .selected{
                     background:url(images/default/true-btn.png) no-repeat right bottom;
                     border:1px solid #e61d47;
                }
</style>
<link href="css/default/member.css" rel="stylesheet" type="text/css"/>
<div class="warp">
    <div class="seat"></div>
    <div class="product_detail clearfix">
        <div class="product_picture">
            <div id="tsShopContainer">
                <div id="tsImgS">
                    <a href="<?php
                    if ($attachment_list) {
                        echo preg_replace('/\./', '_thumb.', $attachment_list[0]['path']);
                    }
                    ?>" title="Images" class="MagicZoom" id="MagicZoom"><img src="<?php
                       if ($attachment_list) {
                           echo preg_replace('/\./', '_thumb.', $attachment_list[0]['path']);
                       }
                       ?>" style="width:430px; height:430px;" id="imgs" /></a>
                </div>
                <img class="MagicZoomLoading" width="16" height="16" src="images/default/loading.gif" alt="Loading..." />
            </div>
            <div class="zoom_scroll" id="zoom_scroll">
                <div class="scrollpic" >
                    <ul id="scrollpic">
                        <?php
                        if ($attachment_list) {
                            foreach ($attachment_list as $item) {
                                ?>
                                <li><a href="#" class="pic" bigimg="<?php echo $item['path']; ?>" smallimg="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"><img src="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>" /></a></li>
                            <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product_info">
            <h2 class="nowrap"><?php
                if ($item_info) {
                    echo $item_info['title'];
                }
                ?></h2>
            <div class="desc">
<?php
if ($item_info) {
    echo $item_info['abstract'];
}
?>
            </div>
            <div class="price_box">
                <ul>
                    <li>
                        <div class="fl" style="margin-top:20px;">
                            <font class="price purple" style="padding-left:20px;"><span style="position:absolute;top:10px;left:10px;font-size:16px;">原价：</span><small>¥</small>
                            <?php
                            foreach ($pintuan_rule as $ls) {
                                $arr[] = $ls['money'];
                            }
                            echo $item_info['sell_price'];
                            ?>
                            </font><i class="ml20">当前价格范围：<font class="purple">（<?php echo number_format(min($arr) - $ptkj_record['cut_total_money'], 2); ?>~<?php echo $item_info['sell_price']; ?>）</font></i></div>
                        <div class="buy_time fr">
                            <div class=" clearfix mb5"><font class="purple">距离拼团砍价结束时间：</font><a id="countdown"><span class="icon">01</span>小时<span class="icon">57</span>分<span class="icon">10</span>秒</a></div>
                            <b class="purple"><?php echo $pintuan_count; ?></b>人已参加
                        </div>
                    </li>
                </ul>
            </div>
<!--            <div class="process">已参加<span class="load"><em style="width:40%;"></em></span><font class="purple ml10">人</font></div>-->
            <div class="kanjiajilu">
                <p>拼团人数：<span class="purple"><?php echo $pintuan_count; ?>人</span></p>
                <p>当前拼团价：<span class="purple">   <?php
                            echo $pintuan_price;
                            ?>元</span></p>
                <p>好友砍价次数：<span class="purple"><?php echo count($chop_record);?>次</span></p>
                <p>共砍掉金额：<span class="purple"><?php echo $choped_price;?>元</span></p>
                <?php  $distributor_info = get_distributor_info(get_cookie('user_id'));?>
                    <?php if ($distributor_info[0]) { ?>
                        <p>分销商优惠价格：<span class="purple"><?php echo $discount;?>元</span></p>
                      <?php } ?>
                <p>当前成交价：<span class="purple"><?php echo number_format($pintuan_price-$choped_price-$discount,2);?>元</span></p>
            </div>
            <?php
              if(get_cookie('user_id') == $ptkj_record['user_id']){
            ?>
            <div class="ncs-btn mt30">
                <a class="addcart t-bg" style="cursor:pointer;" onclick="tcPop()">邀请朋友帮忙砍价</a>
                <a class="addcart t-bg buynow" style="cursor:pointer;">立即购买</a>
            </div>
              <?php }else{?>
                        <div class="ncs-btn mt30">
                            <a href="javascript:tcPop();" id="cutBtn" class="addcart t-bg">砍价</a>
                        </div>
              <?php }?>
        </div>
    </div>
    <div class="clear"></div>
    <div class="product_comment mt30" style="width:100%;">
        <div class="hd">
            <ul>
                <Li>砍价记录</Li>
                <Li>商品详情</Li>
                <Li>活动规则</Li>
            </ul>
        </div>
        <div class="bd">
            <div class="bargain_record">
                <ul>
                    <?php
                    if ($chop_record) {
                        foreach ($chop_record as $item) {
                            ?>
                    <Li><b><?php echo hideStar($item['chop_nickname']); ?></b>于2016-10-11 21:12帮<?php echo $item['nickname']; ?>砍了<span class="purple"><?php echo $item['chop_price']; ?>元</span></Li>
                    <?php }
                } ?>
                </ul>
            </div>
            <div class="product_introduce">
                <?php
                if ($item_info) {
                    echo html($item_info['content']);
                }
                ?>
            </div>
            <div class="product_introduce ptkjrule">
                <h2>参团规则:</h2>
<?php
foreach ($pintuan_rule as $ls) {
    ?>
                    <p>当参团人数达到<strong><?php echo $ls['low'] ?>~<?php echo $ls['high'] ?></strong>人时可享受到<strong><?php echo $ls['money'] ?>元</strong>的价格。</p>
<?php } ?>
                <h2 style="margin-top:10px;">砍价规则:</h2>
                <p>可邀请<strong><?php echo $ptkj_record['cut_times']; ?></strong>位好友砍价</p>
                <p>砍价总金额为<strong><?php echo $ptkj_record['cut_total_money']; ?></strong>元</p>
            </div>
        </div>
    </div>
</div>
<div style="height:0px;">
    <a href="index.php/user/login.html"   id="open"></a>
</div>
<div id="bg" class="dn"></div>
<?php
 if(get_cookie('user_id') == $ptkj_record['user_id']){
?>
<div class="popup_box" id="popup_tip" style="display:none">
    <a class="close" href="javascript:void(0);" id="close">×</a>
    <div class="content">
        <div class="tit"><span class="bt">分享</span></div>
        <div class="pop_kj">
            <h3>请朋友帮忙去砍价</h3>
            <ul style="text-align:center;" id="share">
                <Li><a href="http://www.jiathis.com/send/?webid=cqq&url=<?php echo $url;?>&title=<?php echo $title;?>&pic=<?php echo $pic;?>"   class="qq_icon"></a></Li>
                <Li><a href="http://www.jiathis.com/send/?webid=weixin&url=<?php echo $url;?>&title=<?php echo $title;?>&pic=<?php echo $pic;?>"   class="weixin_icon"></a></Li>
                <Li><a href="http://www.jiathis.com/send/?webid=tsina&url=<?php echo $url;?>&title=<?php echo $title;?>&pic=<?php echo $pic;?>"   class="sina_icon"></a></Li>
                <Li><a href="http://www.jiathis.com/send/?webid=qzone&url=<?php echo $url;?>&title=<?php echo $title;?>&pic=<?php echo $pic;?>"   class="kongjian_icon"></a></Li>
            </ul>
        </div>
    </div>
</div>
 <?php }else{ ?>
<div class="popup_box" id="popup_tip" style="display:none">
    <a class="close" href="javascript:void(0);" id="close">×</a>
    <div class="content">
        <div class="hint" id="message">
            恭喜您为朋友已砍掉<b class="purple">0.00元</b>
        </div>
    </div>
</div>
 <?php }?>
 <div class="mask">
        	<div class="alert-box">
  				<h4 class="alert-title">请选择收货地址<a href="javascript:;" class="close-btn"></a></h4>
  				<div class="address" id="addressBox">
  					<ul>
                                            <?php
                                               if($useraddressList){
                                                   foreach($useraddressList as $useraddress){
                                            ?>
  						<li class="address-item <?php echo $useraddress['default'] == 1 ? 'active' : ''; ?>" data-addressid="<?php echo $useraddress['id'];?>">
                                   
  							<p><?php echo $useraddress['buyer_name']; ?><span><?php echo $useraddress['mobile']; ?></span></p>
  							<p>地址：<?php echo $useraddress['txt_address']; ?> <?php echo $useraddress['address']; ?></p>
                                                                           <?php
                                    if ($useraddress['default'] == 1) {
                                        ?>
                                        <span class="ok" style="display:block;">默认地址</span>
                                    <?php } ?>
  						</li>
  					     <?php
                                                   }}else{
                                             ?>
                                                <li style="text-align: center;font-size:18px;line-height: 100px;">无收货地址,<a href="<?php echo getBaseUrl(false,'','user/get_user_address_list.html',$client_index)?>">去添加收货地址</a></li>
                                                   <?php }?>
  					</ul>
  				</div>
  				<div class="express">
<!--  					<h4 class="alert-title">配送方式</h4>-->
                                        <?php
                                           foreach($postage_way as $key=>$ls){
                                        ?>
<!--  					<span class="express-btn <?php echo $key==0 ? 'selected' : '';?>" data-pid="<?php echo $ls['id'];?>"><?php echo $ls['title'];?></span>-->
                                           <?php }?>
  					<a href="javascript:;" class="pay-btn" onclick="pay(<?php echo $ptkj_record['id'];?>,'<?php echo number_format($pintuan_price-$choped_price-$discount,2)?>')">立即支付</a>
  				</div>
  			</div>
        </div>  
<script type="text/javascript" src="js/default/jquery.ZoomScrollPic.js"></script>
<script type="text/javascript">
//放大镜图片切换效果
    $("#scrollpic").ZoomScrollPic({
        jqBox: "#zoom_scroll",
        box_w: 84,
        Interval: 3000,
        bun: true,
        autoplay: false
    });

    $("#scrollpic li .pic").bind({
        click: function () {
            $("#scrollpic li .pic").removeClass("active");
            $(this).addClass("active");
            var smallimg = $(this).attr("smallimg");
            var bigimg = $(this).attr("bigimg");
            $("#MagicZoom img").eq(0).attr("src", smallimg);
            $("#MagicZoom img").eq(1).attr("src", bigimg);
            return false;
        }
    });
    $(".express-btn").click(function(){
        $('.express-btn').removeClass('selected');
        $(this).addClass('selected');
    })
    $('.buynow').on('click',alertMask);
	function alertMask(ev){
		var w=$(window).width();
		var h=$(window).height();
		$('.mask').css({'display':'block','width':w,'height':h})
		var $alertBox=$('.alert-box');
		$alertBox.css({'top':h/2-$alertBox.height()/2,'left':w/2-$alertBox.width()/2});
		return false;
	};
	$('.close-btn').on('click',function(){
		$('.mask').css({'display':'none'});
	});
	$('.address-item').on('click',function(){
		$(this).addClass('active').siblings().removeClass('active');
	});
</script>
<script type="text/javascript">
    <?php if(get_cookie('user_id')  != $ptkj_record['user_id']){?>
    function tcPop() {
        $.ajax({
            url: base_url + 'index.php/bargain/chop',
            type: 'post',
            dataType: 'json',
            data: {
                id: <?php echo $ptkj_record['id']; ?>,
                sign: '<?php echo md5('mykey' . $ptkj_record['id']); ?>',
            },
            success: function (json) {
                if (!json.success) {
                    if (json.field === 'login') {
                        var d = dialog({
                            width: 200,
                            fixed: true,
                            title: '提示',
                            content: json.message,
                            okValue: '登录',
                            ok: function () {
                                var a = $("#open").get(0);
                                var e = document.createEvent('MouseEvents');
                                e.initEvent('click', true, true);
                                a.dispatchEvent(e);
                            },
                            cancelValue: '取消',
                            cancel: function () {
                            }
                        });
                        d.show();
                        return;
                    }
                    var d = dialog({
                        width: 300,
                        title: '提示',
                        fixed: true,
                        content: json.message
                    });
                    d.show();
                    setTimeout(function () {
                        d.close().remove();
                    }, 2000);
                    return;
                }
                $("#message b").html(json.data.chop_price + '元');
                $("#bg").stop(true, true).fadeIn('300');
                $("#popup_tip").stop(true, true).fadeIn('300');
            }
        });
    }
    <?php }else{?>
    function tcPop() {
        $("#bg").stop(true, true).fadeIn('300');
        $("#popup_tip").stop(true, true).fadeIn('300');
    }
        function pay(id, price) {
                var address_id = $("#addressBox").find('li.active').data('addressid');
                var postage_template_id = $(".express .selected").data('pid');
                var d = dialog({
                                      width: 200,
                                      fixed: true,
                                      title: '提示',
                                      content: '当前成交价格为' + price + '元，您确定要支付吗?',
                                      okValue: '确定',
                                      ok: function () {
                                          $.ajax({
                                              url: base_url + 'index.php/order/ptkj_pay',
                                              type: 'post',
                                              dataType: 'json',
                                              data: {
                                                  ptkj_record_id: id,
                                                  address_id: address_id,
                                                  postage_template_id: postage_template_id
                                              },
                                              success: function (data) {
                                                  if (!data.success) {
                                                      alert(data.message);
                                                      return;
                                                  }
                                                  location.href=data.field;
                                              }
                                          });
                                      },
                                      cancelValue: '取消',
                                      cancel: function () {}
                     });
                    d.show();
    }
     $("body").delegate('#addr-list li','click',function(){
                  $("#addr-list li").removeClass("active");
                  $(this).addClass("active");
             });
       function select_express(_this){
           $(_this).find('a').addClass('hovered');
           $(_this).siblings('dd').find('a').removeClass('hovered');
       }
    <?php }?>
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
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
        $("#countdown").html('<span class="icon">' + h + '</span>小时<span class="icon">' + m + '</span>分<span class="icon">' + s + '</span>秒');
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
            $("#countdown").html('<span class="icon">' + h + '</span>小时<span class="icon">' + m + '</span>分<span class="icon">' + s + '</span>秒');
            if (t <= 0) {
                clearInterval(ID);
                $("#countdown").html('<span class="icon">00</span>小时<span class="icon">00</span>分<span class="icon">00</span>秒');
                $("#cutBtn").html('活动已结束');
                $("#cutBtn").addClass('buygray');
                $("#cutBtn").css('background-color', '#ddd');
            }
        }, 1000);
    }
    countdown(<?php echo $ptkj_record['end_time'] - time(); ?>);
    
    
</script>
