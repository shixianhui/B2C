<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right mt20">
        <div class="box_shadow clearfix m_border">
            <div class="member_title"><span class="bt"><?php echo $score_type_str; ?>充值</span></div>
            <ul class="m_form" >
                <?php if ($score_type == 'gold') { ?>
                <li class="clearfix"><span>金象积分 ：</span><b class="f18 purple"><?php if ($user_info) { echo $user_info['score_gold'];}?></b></li>
                <?php } else { ?>
                <li class="clearfix"><span>银象积分：</span><b class="f18 purple"><?php if ($user_info) { echo $user_info['score_silver'];}?></b></li>
                <?php } ?>
                <li class="clearfix"><span>充值数量：</span><input type="text" id="score_num" name="score_num" class="input_txt mr15" style="width:120px;"><?php echo $score_type_str; ?>
                <?php if ($score_type == 'gold') { ?>
                (<?php if ($score_setting_info){echo "<font color='#e61d47'>一元可以兑换{$score_setting_info['rmb_to_score_gold']}金象积分</font>";}; ?>)
                <?php } else { ?>
                (<?php if ($score_setting_info){echo "<font color='#e61d47'>一元可以兑换{$score_setting_info['rmb_to_score_silver']}银象积分</font>";}; ?>)
                <?php } ?>
                </li>
                <li class="clearfix"><span>应付金额：</span><i id="money">0</i> <font color="#e61d47">元</font></li>
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

	$('#score_num').bind('input propertychange', function() {
		var bl = '';
		<?php if ($score_type == 'gold') { ?>
		bl = '<?php echo $score_setting_info['rmb_to_score_gold']; ?>';
		<?php } else { ?>
		bl = '<?php echo $score_setting_info['rmb_to_score_silver']; ?>';
		<?php } ?>
	    var score_num = $('#score_num').val();
	    $('#money').html(parseFloat(parseInt(score_num)/parseInt(bl)).toFixed(2));
	});

	$("#goPay").click(function(){
        var score_num = $('#score_num').val();
        var pay_type = $("#togglePay li.on").data('type');
        if (!pay_type) {
            return my_alert('fail', 0, '请选择支付方式');
        }
        if (pay_type != 'alipay' && pay_type != 'weixin') {
        	return my_alert('fail', 0, '请选择正确的支付方式');
        }
        if (!score_num) {
        	return my_alert('score_num', 1, '请输入充值金额');
        }
        var score_num_zz = /^[-\+]?\d+$/;
		if(!score_num_zz.test(score_num)) {
			return my_alert('score_num', 1, '请输入正确的充值数量');
        }
        $.ajax({
            url : base_url+'index.php/user/pay_recharge_score',
            type : 'post',
            data : {
            	payment_type: pay_type,
            	score_type:'<?php echo $score_type; ?>',
            	score_num : score_num
            },
            dataType : 'json',
            beforeSend : function(){
                $("body").append('<div id="loading"></div>');
            },
            success : function(res){
                $("#loading").remove();
                if(res.success){
                    if (pay_type == 'alipay') {
                        window.location.href = base_url+'index.php/user/alipay_pay_recharge_score/'+res.data.id+'.html';
                    } else if (pay_type == 'weixin') {
                    	window.location.href = base_url+'index.php/user/pay_weixin_recharge_score/'+res.data.id+'.html';
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