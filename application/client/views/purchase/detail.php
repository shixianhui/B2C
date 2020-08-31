<link href="css/default/member.css?v=1.0" rel="stylesheet" type="text/css"/>
<div class="warp">
    <div class="seat"></div>
    <div class="product_detail clearfix">
        <div class="product_picture">
            <div id="tsShopContainer">
                                 <div id="tsImgS">
                    <a href="<?php
                    if ($attachment_list) {
                        echo $attachment_list[0]['path'];
                    }
                    ?>" title="Images" class="MagicZoom" id="MagicZoom"><img src="<?php
                       if ($attachment_list) {
                           echo $attachment_list[0]['path'];
                       }
                    ?>" style="width:430px; height:430px;" id="imgs" />
                    </a>
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
    <?php }} ?>
                    </ul>
                </div>
            </div>

        </div>

        <div class="product_info">
            <h2 class="nowrap"><?php if ($item_info) { echo $item_info['title'];} ?></h2>
            <div class="desc"><?php if ($item_info) {
    echo $item_info['abstract'];
} ?></div>
            <div class="price_box">
                <ul>
                    <li><div class="fl" style=" margin-top:20px;"><font class="price purple" style="padding-left:20px;"><small>¥</small><?php echo $flash_info['flash_sale_price'];?></font><i class="ml20"><s>¥<?php echo $item_info['market_price'];?></s></i></div>
                        <div class="buy_time fr">
                            <div class=" clearfix mb5" id="countdown" data-time="<?php echo $flash_info['end_time']-time();?>"> 
                                <?php
                                  if($flash_info['start_time'] > time()){
                                     echo ' <font class="purple">时间：</font>';
                               //echo ' <span class="icon">52</span>分钟<span class="icon">30</span>秒';
                                      echo date('Y-m-d H:i:s',$flash_info['start_time']).' 开始';
                                  }
                                ?>
                                <?php 
                                   if($flash_info['end_time'] < time()){
                                      echo ' <font class="purple">活动结束</font>';
                               //echo ' <span class="icon">52</span>分钟<span class="icon">30</span>秒';
                                      //echo date('H:i:s',$flash_info['start_time']).' 开始';
                                  }
                                ?>
                                 <?php 
                                   if($flash_info['end_time'] >= time() && $flash_info['start_time'] <= time()){
                                      echo '<font class="purple">剩余时间：</font><span class="icon">30</span>分钟<span class="icon">00</span>秒';
                                  }
                                ?>
                            </div>        
                        </div>
                    </li>
                </ul>
            </div>
            <div class="text_box mt10">
                <ul>
                 <?php
                      if ($postage_way) {
                           foreach($postage_way as $key=>$ls){ 
                    ?>
                    <li><span><?php echo $key==0 ? '运费' : '&nbsp;&nbsp;&nbsp;&nbsp;'?></span><font class="free"><?php  echo $ls['title'];?></font> <?php  echo $ls['content'];?></li>
                      <?php }}?>
                </ul>
            </div>
            <div class="ncs-key clearfix"> 
                <dl id="selectSize">
                    <dt>尺码</dt>
                                    <?php
                    if ($sizeList) {
                        foreach ($sizeList as $key => $value) {
                            ?>
                            <dd onclick="select_size(this,<?php echo $value['size_id']; ?>,<?php echo $flash_info['product_id'];?>)"><a href="javascript:void(0);" title="<?php echo $value['size_name']; ?>" data-size_id="<?php echo $value['size_id'];?>"><?php echo $value['size_name']; ?><i></i></a></dd>
    <?php }
} ?>
                </dl>
                <input type="hidden" id="spec_size_id">
            </div>
            <div class="clear"></div>
            <div class="ncs-key color clearfix"> 
                <dl id="selectColor">
                    <dt>颜色</dt>
          <?php if ($colorList) { ?>
    <?php foreach ($colorList as $key => $value) { ?>
                            <dd onclick="select_color(this,<?php echo $value['color_id']; ?>,<?php echo $flash_info['product_id'];?>)"><a href="javascript:void(0);" title="<?php echo $value['color_name']; ?>" data-color_id="<?php echo $value['color_id'];?>"><img src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>" width="50" height="50"><i></i></a></dd>
    <?php }
} ?> 
                </dl>
                 <input type="hidden" id="spec_color_id">
            </div>

            <div class="clear"></div>
            <div class="ncs-buy mt15">
                <span>购买数量</span>
                <div class="ncs-figure-input">
                    <a href="javascript:void(0)" class="increase" nctype="increase" id="Reduce">&nbsp;</a>  <input type="text" name=""  value="1" size="3" maxlength="6" class="input-text" id="buy-num" readonly="true" >
                    <a href="javascript:void(0)" class="decrease" nctype="decrease" id="Increase">&nbsp;</a> </div><em class="kc ml20" id="stock">库存：<?php if ($item_info) {
    echo $item_info['stock'];
} ?></em>
                <p style="width:245px;text-align:center;margin-top:10px;color:red;font-size:14px;">每人限购一件</p>
            </div>
            
            <div class="ncs-btn mt30">
                <a href="javascript:void(0);" id="buynow" class="buynow t-bg <?php if(!($flash_info['start_time'] < time() && $flash_info['end_time'] > time()) || $item_info['stock'] <= 0){ echo 'buygray';}?>" <?php if($flash_info['end_time'] >= time() && $flash_info['start_time'] <= time() && $item_info['stock'] > 0){ ?>onclick="add_group_purchase();"<?php }?>>
                         <?php
                                  if($flash_info['start_time'] > time()){
                                     echo '即将开始...';
                                  }
                                  if($flash_info['end_time'] < time() && $item_info['stock'] > 0){
                                      echo '已结束';
                                  }
                                  if($flash_info['start_time'] < time() && $flash_info['end_time'] > time() && $item_info['stock'] > 0){ 
                                      echo '立即抢购';
                                  }
                                  if($item_info['stock'] <= 0){
                                      echo '已抢光';
                                  }
                                ?>
                </a>
                <p class="purple mt10">亲，秒杀开始之前，请先<a href="<?php echo getBaseUrl(false,'','user/get_user_address_list.html',$client_index)?>"  ><b class="blue">确认收货地址</b></a>,默认地址作为发货地址</p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="product_comment fr mt30">
        <div class="hd">
            <ul>
                <Li>商品详情</Li>
            </ul>
        </div>
        <div class="bd">
            <div class="product_introduce">
                <?php if ($item_info){echo html($item_info['content']);} ?>
            </div>
        </div>
    </div>
</div>
<div id="addHtml" style="display:none;">
<h4 style="padding-left:20px;">收货地址：</h4>
<ul class="addr-list clearfix" id="addr-list" style="width:100%;height:180px;overflow-y:auto;">
                  <?php if ($useraddressList) {
                    ?>
                    <?php foreach ($useraddressList as $useraddress) { ?>
                        <li <?php echo $useraddress['default'] == 1 ? 'class=active' : ''; ?> data-addressid="<?php echo $useraddress['id']; ?>">
                            <div class="title">
                                <div class="name"> <?php echo $useraddress['buyer_name']; ?><span class="space"></span>收</div>
                                <div class="default">
                                    <?php
                                    if ($useraddress['default'] == 1) {
                                        ?>
                                        <span class="ok" style="display:block;">默认地址</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="text-box">
                                <p><?php echo $useraddress['txt_address']; ?></p>
                                <p><?php echo $useraddress['address']; ?></p>
                                <p><?php echo $useraddress['mobile']; ?></p>
                            </div>
                            <i class="ico-yes icon"></i>
                        </li>
                    <?php }
                }
                ?>        
 </ul>
<h4 style="margin-top:10px;padding-left:20px;">选择快递:</h4>
<dl id="select_express">
<dd onclick="select_size(this,38)"><a href="javascript:void(0);" title="165/72A" class="hovered">申通快递<i></i></a></dd>
 </dl>
</div>





<script type="text/javascript" src="js/default/jquery.ZoomScrollPic.js"></script>
<script type="text/javascript">
//         $("#Increase").click(function(){
//          var num = $(this).siblings('input').val();
//              num++;
//              $(this).siblings('input').val(num);
//    });
//    $("#Reduce").click(function(){
//          var num = $(this).siblings('input').val();
//              num--;
//              if(num<=0){
//                  num = 1;
//              }
//              $(this).siblings('input').val(num);
//    });
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
    $("#fav-btn").bind({
        click: function () {
            if ($(this).find(".icon-collect").hasClass("active")) {
                $(this).find(".icon-collect").removeClass("active");
                $(this).find("span").text("收藏");
            }
            else {
                $(this).find(".icon-collect").addClass("active");
                $(this).find("span").text("取消收藏");
            }
            return false;
        }
    });
function add_group_purchase() {
	var color_id = $("#spec_color_id").val();
	var size_id = $("#spec_size_id").val();
        if(<?php echo get_cookie('user_id') ? 'false' : 'true';?>){
        var d = dialog({
					            width:200,
					            fixed: true,
						    title: '提示',
						    content: '您未登录，请先登录',
						    okValue: '登录',
						    ok: function () {
						    	window.location.href= base_url+'index.php/user/login.html';
						    },
						    cancelValue: '取消',
						    cancel: function () {
						    }
						});
						d.show();
                                           return false;
    }
    if (!color_id) {
    	var d = dialog({
		    fixed: true,
		    title: '提示',
		    content: "请选择颜色"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
        return false;
    }
    if (!size_id) {
    	var d = dialog({
			fixed: true,
		    title: '提示',
		    content: "请选择尺码"
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
         return false;
    }
    add_order(color_id,size_id);
}
function add_order(color_id,size_id){
        //加入购物车
    $.post(base_url+"index.php/purchase/add_order", 
			{	"id": <?php echo $id;?>,
				"color_id": color_id,
				"size_id": size_id,
			},
			function(res){
				if(res.success){
					var d = dialog({
						width: 350,
						fixed: true,
					    title: '提示',
                                            content : res.message,
					    okValue: '去付款',
					    ok: function () {
						   window.location.href=res.field;
					    }
					});
                                                d.show();
                                                return false;
				}else{
						var d = dialog({
							fixed: true,
						    title: '提示',
						    content: res.message
						});
						d.show();
						setTimeout(function () {
						    d.close().remove();
						}, 2000);
					return false;
				}
			},
			"json"
	);
}
 function countdown(ele) {
        var t = $(ele).data('time');
        var ID = setInterval(function () {
            t--;
            var h = Math.floor(t / 3600 % 24);
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
            $(ele).html('<font class="purple">剩余时间：</font><span class="icon">'+h+'</span>小时<span class="icon">'+m+'</span>分钟<span class="icon">'+s+'</span>秒');
            if (t <= 0) {
                clearInterval(ID);
                $(ele).html('已结束');
                $("#buynow").html('已结束');
                $("#buynow").addClass('buygray');
            }
        }, 1000);
    }
    
      $("body").delegate('#addr-list li','click',function(){
                  $("#addr-list li").removeClass("active");
                  $(this).addClass("active");
             });
       function select_express(_this){
           $(_this).find('a').addClass('hovered');
           $(_this).siblings('dd').find('a').removeClass('hovered');
       }
                <?php 
                                   if($flash_info['end_time'] >= time() && $flash_info['start_time'] <= time()){
                                      echo 'countdown(document.getElementById("countdown"))';
                                  }
                                ?>
                              
</script>
