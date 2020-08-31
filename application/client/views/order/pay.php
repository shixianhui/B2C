<div class="clear"></div>
<header class="header clearfix" style="border-bottom:#e61d47 2px solid;">
    <div class="warp">
        <a href="<?php echo base_url();?>" class="logo"><img src="images/default/logo.png"></a>
        <div class="cart_step fr">
            <ul class="clearfix">
                <li>我的购物车<em></em><i></i></li>
                <li>填写订单信息<em></em><i></i></li>
                <li class="current">确认订单付款<em></em><i></i></li>
                <li>订单提交成功<em></em><i></i></li>
            </ul>
        </div>
    </div>
</header>
<div class="clear"></div>
<div class="warp">
    <div class="cart_repeat mt25">
        <div class="bar clearfix">
            <h3 class="fl">您的订单已提交成功，请尽 快付款！
                <span class="">请您在提交订单后<?php echo $close_order_time;?>小时内完成支付，否则订单会自动取消。</span></h3>
                <span class="price fr">
                    运&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;费：<b class="purple f18"><?php if ($item_info) { echo $item_info['postage_price'];} ?></b>元<br>
                    应付金额：<b class="purple f18"><?php if ($item_info) { echo $item_info['total'];} ?></b>元
      <?php if ($item_info) { ?>
      <?php if ($item_info['pay_mode'] > 0) { ?>
      <br>应付积分：<b class="purple f18"><?php if ($item_info) { echo $item_info['deductible_score'];} ?></b>个(<font color="red">已付</font>)
      <?php }} ?>
                </span>
        </div>
        <P> 收货地址：<?php if ($item_info) { echo $item_info['txt_address']; } ?><?php if ($item_info) { echo $item_info['address'];}?> 收货人：<?php if ($item_info) { echo $item_info['buyer_name'];}?>  <?php if ($item_info) { echo $item_info['mobile'];}?></P>
        <div class="clearfix">
            <h5 style="font-weight: normal;float:left;font-size:12px;">商品名称：</h5>
            <p style="float:left;">
                <?php
                if ($order_detail_list) {
                    foreach($order_detail_list as $value){
                ?>
                <?php echo $value['product_title'];?>
                <?php if ($value['color_size_open']) { ?>
                <?php echo $value['product_size_name']; ?>：<?php echo $value['size_name']; ?> <?php echo $value['product_color_name']; ?>：<?php echo $value['color_name']; ?><br>
                 <?php } ?>
                <?php }} ?>
            </p>
        </div>
    </div>
    <div  class="cart_border mt30">
        <span class="tit">选择支付方式</span>
        <div class="border_d clearfix">
            <div class="cart_pay">
                <div class="bank_pay">
                    <div class="hd clearfix">
                        <ul id="selectPay">
                            <li data-type="yue" <?php if ($user_info) { echo $user_info['total'] >= $total ? 'class = "on"' : '';}?>>余额支付</li>
                            <li data-type="alipay" <?php if ($user_info) { echo $user_info['total'] < $total ? 'class = "on"' : '';}?>>支付宝</li>
                            <li data-type="weixin">微信支付</li>
                        </ul>
                    </div>
                    <div class="bd clearfix">
                        <div class="bank_list" <?php if ($user_info) { echo $user_info['total'] >= $total ? 'style="display:block;"' : '';}?>>
                            <ul class="m_form">
                                <li class="clearfix"><span>账户余额：</span><b class="f18 purple"><small>￥</small><?php if ($user_info) {echo $user_info['total'];}else{echo '0';}?></b></li>
                                <li class="clearfix"><span>支付密码：</span><input type="password" name="pay_password" class="input_txt mr15" style="width:180px;"><a href="<?php echo getBaseUrl(false,'','user/change_pay_password', $client_index);?>"   style="color: #666;">忘记密码?</a></li>
                            </ul>
                        </div>
                        <div class="bank_list" <?php if ($user_info) { echo $user_info['total'] < $total ? 'style="display:block;"' : '';}?>>
                            <dl class="checkbox_item">
                                <dd><a href="javascript:viod(0);"><img src="images/default/alipay_logo.png"></a></dd>
                            </dl>
                        </div>
                       <div class="bank_list">
                            <dl class="checkbox_item">
                                <dd><a href="javascript:viod(0);"><img src="images/default/wechat_pay.png"></a></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <a href="javascript:void(0)" class="btn_pay fr mt30" id="goPay">确认支付</a>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });

</script>

<script language="javascript" type="text/javascript">
    $(function () {
        $(".checkbox_item dd").click(function () {
            $(this).addClass("clickdd").siblings().removeClass("clickdd");
        });
    });
    $("#goPay").click(function(){
        var pay_type = $("#selectPay li.on").data('type');
        if(pay_type == 'yue'){
        	var pay_password = $("input[name=pay_password]").val();
        	if (!pay_password) {
                return my_alert('fail', 0, '请输入支付密码');
            }
            $.ajax({
                    url : base_url+'index.php/'+controller+'/yue_pay.html',
                    type : 'post',
                    data : {
                    	order_id: '<?php if ($item_info) {echo $item_info['id'];} ?>',
                        pay_password : pay_password
                    },
                    dataType : 'json',
                    beforeSend : function(){
                        $("body").append('<div id="loading"></div>');
                    },
                    success : function(res){
                        $("#loading").remove();
                        if(res.success){
                            return my_alert_url(res.field, res.message);
                        } else {
                            return my_alert('fail', 0, res.message);
                        }
                    }
            });
        } else if(pay_type == 'alipay') {
            location.href = base_url+'index.php/'+controller+'/alipay_pay/<?php if ($item_info) {echo $item_info['id'];} ?>.html';
        } else if(pay_type == 'weixin') {
            location.href = base_url+'index.php/'+controller+'/pay_weixin/<?php if ($item_info) {echo $item_info['id'];} ?>.html';
        }
    });
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
