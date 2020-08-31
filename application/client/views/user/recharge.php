<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right mt20">
        <div class="box_shadow clearfix m_border">
            <div class="member_title"><span class="bt">充值账户</span></div>
            <ul class="m_form" >
                <li class="clearfix"><span>账户余额：</span><b class="f18 purple"><small>￥</small><?php if ($userInfo) { echo $userInfo['total'];}?></b></li>
                <li class="clearfix"><span>充值金额：</span><input type="text" name="total_fee" id="total_fee" class="input_txt mr15" style="width:180px;">元</li>
                <li class="clearfix"><span>付款方式：</span>
                    <div class="bank_pay">
                        <div class="hd">
                            <ul id="togglePay">
                                <li data-type="alipay" class="on">支付宝</li>
                                <li data-type="weixin">微信支付</li>
                            </ul>
                        </div>
                        <div class="bd clearfix">
                            <div class="bank_list" style="display:block;">
                                <dl class="checkbox_item"><dd ><a href="javascript:viod(0);"><img src="images/default/alipay_logo.png"></a></dd></dl>
                            </div>
                            <div class="bank_list">
                                <dl class="checkbox_item"><dd ><a href="javascript:viod(0);"><img src="images/default/pay-weixin.png"></a></dd></dl>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="clearfix">
                    <span>&nbsp;</span><input id="goPay" type="button" class="btn_r" value="确认充值" style="border:none;">
                </li>
            </ul>
        </div>

    </div>
</div>
<script language="javascript" type="text/javascript">
	$(".checkbox_item dd").click(function () {
		$('#bank_list dd').removeClass('clickdd');
	    $(this).addClass("clickdd").siblings().removeClass("clickdd");
	});

    $("#goPay").click(function(){
        var total_fee = $('#total_fee').val();
        var pay_type = $("#togglePay li.on").data('type');
        if (!pay_type) {
            return my_alert('fail', 0, '请选择支付方式');
        }
        if (pay_type != 'alipay' && pay_type != 'weixin') {
        	return my_alert('fail', 0, '请选择正确的支付方式');
        }
        if (!total_fee) {
        	return my_alert('total_fee', 1, '请输入充值金额');
        }
        var total_fee_zz = /^\d+(\.\d+)?$/;
		if(!total_fee_zz.test(total_fee)) {
			return my_alert('total_fee', 1, '请输入正确的充值金额');
        }
        $.ajax({
            url : base_url+'index.php/user/pay_recharge',
            type : 'post',
            data : {
            	payment_type: pay_type,
            	total_fee : total_fee
            },
            dataType : 'json',
            beforeSend : function(){
                $("body").append('<div id="loading"></div>');
            },
            success : function(res){
                $("#loading").remove();
                if(res.success){
                    if (pay_type == 'alipay') {
                        window.location.href = base_url+'index.php/user/alipay_pay_recharge/'+res.data.id+'.html';
                    } else if (pay_type == 'weixin') {
                    	window.location.href = base_url+'index.php/user/pay_weixin_recharge/'+res.data.id+'.html';
                    }
                } else {
                    if (res.field == 'fail') {
                        return my_alert('fail', '0', res.message);
                    } else {
                    	return my_alert(res.field, 1, res.message);
                    }
                }
            }
        });
    });
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>