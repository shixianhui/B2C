<div class="clear"></div>
<header class="header clearfix" style="border-bottom:#e61d47 2px solid;">
    <div class="warp">
        <a href="<?php echo base_url();?>" class="logo"><img src="images/default/logo.png"></a>
    </div>
</header>
<div class="clear"></div>
<div class="warp">
    <div  class="cart_border mt30">
        <span class="tit">充值成功</span>
        <div class="border_d clearfix">
            <div class="cart_success clearfix">
                <span class="icon" style="margin-left:416px;"></span><p class="fl">您已成功充值：￥<?php if ($item_info) {echo $item_info['total_fee'];} ?>
                <br>您的交易单号：<?php if ($item_info) {echo $item_info['out_trade_no'];} ?>
                <br>
                <a href="<?php echo getBaseUrl(false, "", "user/get_pay_log_list.html",$client_index);?>" class="btn mt10" style="margin-left:40px;">查看充值记录</a>
                </p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>