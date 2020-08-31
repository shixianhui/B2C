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
    <?php }
} ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="product_info">
            <h2 class="nowrap"><?php if ($item_info) {
    echo $item_info['title'];
} ?></h2>
            <div class="desc">
<?php if ($item_info) {
    echo $item_info['abstract'];
} ?>
            </div>
            <div class="price_box">
                <ul>
                    <li>

                        <div class="fl" style=" margin-top:20px;"><font class="price purple" style="padding-left:20px;"><small>¥</small><?php
        echo number_format($pintuan_price, 2);
?></font><i class="ml20">当前价格范围：<font class="purple">（<?php echo $pintuan_info['low_price'];?>~<?php echo $pintuan_info['high_price'];?>）</font></i></div>

                        <div class="buy_time fr">
                            <div class=" clearfix mb5"><font class="purple">距离拼团砍价结束时间：</font><a id="countdown"><span class="icon">10</span>小时<span class="icon">52</span>小时<span class="icon">30</span>秒</a></div>
                            <b class="purple"><?php echo $pintuan_info['pintuan_people'];?></b>人已参加
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
                            <dd onclick="select_size(this,<?php echo $value['size_id']; ?>,<?php echo $pintuan_info['product_id'];?>)"><a href="javascript:void(0);" title="<?php echo $value['size_name']; ?>" data-size_id="<?php echo $value['size_id']; ?>"><?php echo $value['size_name']; ?><i></i></a></dd>
    <?php }
} ?>
                </dl>
                <input type="hidden" id="spec_size_id" value="">
            </div>
            <div class="clear"></div>
            <div class="ncs-key color clearfix"> 
                <dl id="selectColor">
                    <dt>颜色</dt>
<?php if ($colorList) { ?>
    <?php foreach ($colorList as $key => $value) { ?>
                            <dd onclick="select_color(this,<?php echo $value['color_id']; ?>,<?php echo $pintuan_info['product_id'];?>)"><a href="javascript:void(0);" title="<?php echo $value['color_name']; ?>" data-color_id="<?php echo $value['color_id']; ?>"><img src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>" width="50" height="50"><i></i></a></dd>
    <?php }
} ?>
                </dl>
           <input type="hidden" id="spec_color_id" value="">
            </div>
            <div class="clear"></div>
            <div class="ncs-buy mt15">
                <span>购买数量</span>
                <div class="ncs-figure-input">
                    <a href="javascript:void(0)" class="increase" nctype="increase" id="Reduces">&nbsp;</a>  <input type="text" name=""  value="1" size="3" maxlength="6" class="input-text" readonly="true" id="buy-num" >
                    <a href="javascript:void(0)" class="decrease" nctype="decrease" id="Increases">&nbsp;</a> </div><em class="kc ml20" id="stock">库存： <?php if ($item_info) {
    echo $item_info['stock'];
} ?></em>
            </div>
            <p style="width:245px;text-align:center;margin-top:10px;color:red;font-size:14px;">每人限购一件</p>
            <div class="ncs-btn mt30">
                <a href="javascript:void(0);" onclick="add_group_purchase()" id="takeBtn" class="buynow t-bg" title="<?php echo $button_str;?>"><?php echo $button_str;?></a>
            </div>
        </div>
    </div>
    <div class="clear"></div>
   
    <div class="product_comment fr mt30">
        <div class="hd">
            <ul>
                <Li>商品详情</Li>
                <Li>活动规则</Li>
            </ul>
        </div>
        <div class="bd">
            <div class="product_introduce">
                <?php if ($item_info){echo html($item_info['content']);} ?>
            </div>
            <div class="product_introduce ptkjrule">
                <h2>参团规则:</h2>
                <?php
                   foreach($pintuan_rule as $ls){
                ?>
                <p>当参团人数达到<strong><?php echo $ls['low']?>~<?php echo $ls['high']?></strong>人时可享受到<strong><?php echo $ls['money']?>元</strong>的价格。</p>
                   <?php }?>
                <h2 style="margin-top:10px;">砍价规则:</h2>
                <p>可邀请<strong><?php echo $pintuan_info['cut_times'];?></strong>位好友砍价</p>
                <p>砍价总金额为<strong><?php echo $pintuan_info['cut_total_money'];?></strong>元</p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/default/jquery.ZoomScrollPic.js"></script>
<script type="text/javascript">
     $("#Increase").click(function(){
          var num = $(this).siblings('input').val();
              num++;
              $(this).siblings('input').val(num);
    });
    $("#Reduce").click(function(){
          var num = $(this).siblings('input').val();
              num--;
              if(num<=0){
                  num = 1;
              }
              $(this).siblings('input').val(num);
    });
//放大镜图片切换效果
$("#scrollpic").ZoomScrollPic({
			jqBox:"#zoom_scroll",
			box_w:84,
			Interval:3000,
			bun:true,
			autoplay:false
		});	
$("#scrollpic li .pic").bind({
		click:function(){
			$("#scrollpic li .pic").removeClass("active");
			$(this).addClass("active");
			var smallimg=$(this).attr("smallimg");
			var bigimg=$(this).attr("bigimg");
			$("#MagicZoom img").eq(0).attr("src",smallimg);
			$("#MagicZoom img").eq(1).attr("src",bigimg);
			return false;
			}
		});
$("#fav-btn").bind({
	click:function(){
		if($(this).find(".icon-collect").hasClass("active")){
			$(this).find(".icon-collect").removeClass("active");
			$(this).find("span").text("收藏");
		}
		else{
			$(this).find(".icon-collect").addClass("active");
			$(this).find("span").text("取消收藏");
			}
		return false;
		}
		});
//加入购物车
function add_group_purchase() {
    <?php if($gourl){?>
            location.href='<?php echo $gourl;?>';
            return;
    <?php }?>
	var color_id = $("#spec_color_id").val();
	var size_id = $("#spec_size_id").val();
	var buy_number = $("#buy-num").val();
        
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
    
    //加入购物车
    $.post(base_url+"index.php/bargain/group_purchase", 
			{	"product_id": <?php if ($item_info){ echo $item_info['id']; } ?>,
				"color_id": color_id,
				"size_id": size_id,
				"buy_number": 1,
                                "ptkj_id" : <?php if ($pintuan_info){ echo $pintuan_info['id']; } ?>
			},
			function(res){
				if(res.success){
					var d = dialog({
						width: 350,
						fixed: true,
					    title: '提示',
                                            content : res.message,
					    okValue: '确定',
					    ok: function () {
						  window.location.href = res.field;
					    }
					});
					d.show();
                                                return false;
				}else{
					if (res.field == 'go_login') {
						var d = dialog({
							width:200,
							fixed: true,
						    title: '提示',
						    content: res.message,
						    okValue: '登录',
						    ok: function () {
						    	window.location.href= base_url+'index.php/user/login.html';
						    },
						    cancelValue: '取消',
						    cancel: function () {
						    }
						});
						d.show();
					} else if(res.field == 'already'){
                                            window.location.href= res.message;
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
					}
					return false;
				}
			},
			"json"
	);
}
</script>
    <script>
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
                    $("#takeBtn").html('参团已结束');
                    $("#takeBtn").addClass('buygray');
                }
            }, 1000);
        }
        countdown(<?php echo $pintuan_info['end_time'] - time();?>);
    </script>