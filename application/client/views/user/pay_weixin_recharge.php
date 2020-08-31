<div class="clear"></div>
<header class="header clearfix" style="border-bottom:#e61d47 2px solid;">
    <div class="warp">
        <a href="<?php echo base_url();?>" class="logo"><img src="images/default/logo.png"></a>
    </div>
</header>
<div class="clear"></div>
<style>
	body{background:#f5f5f5;}
    .arrow_icon {
        width: 14px;
        height: 6px;
        display: inline-block;
        background-position: -368px -74px;
        vertical-align: middle;
        margin-left: 5px;
    }
.order_count{ background:#fff; padding:50px 80px; margin-top:30px;}
</style>
<section style="width: 1200px;margin: 0px auto;padding: 50px 0 10px;">
    <div style="float: left;">
        <p style="font-size:16px;">请您及时付款，以便订单为您及时处理哟！<span>充值交易号：<?php echo $out_trade_no; ?></span></p>
    </div>
    <div style="float: right;">
        <p style="font-size: 20px;">应付金额：<font color="red">￥<?php echo $total; ?></font></p>
    </div>
    <div class="clear"></div>
</section>
<div class="clear"></div>
<section class="warp">
<div class="order_count clearfix">
    <div style="float: left;border-right: #ddd 1px solid;padding: 0 130px 0 40px">
    <img src="images/default/wx3.jpg" style="padding-left: 60px;display: block">
<img alt="模式二扫码支付" src="<?php echo getBaseUrl(false, "", "order/get_weixin_qr", $client_index)."?url=".urlencode($qr_url);?>" style="width:350px;height:350px;"/>
    <img src="images/default/wx2.jpg" style="display: block;padding-left: 60px">
    </div>
    <div style="float: right">
    <img src="images/default/wx1.jpg" style="width: 475px;">
    </div>
<?php if (array_key_exists('result_code', $result) && $result['result_code'] == 'FAIL') {
	echo '&nbsp;原因：'.$result['err_code_des'];
} ?>
</div>
    <div style="padding: 20px 0"><a style="color:#9d9a9a;" href="javascript:history.go(-1);">&lt; 选择其他支付方式</a></div>

</section>
<div class="clear"></div>
<script type="text/javascript">
function weixin_heart() {
	$.post(base_url+"index.php/"+controller+"/get_weixin_heart_recharge",
			{	"out_trade_no":'<?php echo $out_trade_no; ?>'
			},
			function(res){
				if(res.success) {
					if (res.data.trade_status != 'WAIT_BUYER_PAY') {
	                    window.location.href = base_url+'index.php/'+controller+'/pay_result_recharge/'+res.data.id+'.html';
					}
				}
			},
			"json"
	);
}

window.setInterval("weixin_heart()", 1500);
</script>