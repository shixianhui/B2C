<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right mt20">
        <div class="box_shadow clearfix m_border">
            <div class="member_title"><span class="bt"><?php echo $score_type_str; ?>提现</span></div>
            <ul class="m_form" >
                <?php if ($score_type == 'gold') { ?>
                <li class="clearfix"><span>金象币：</span><b class="f18 purple"><?php if ($user_info) { echo $user_info['total_gold'];}?></b></li>
                <?php } else { ?>
                <li class="clearfix"><span>银象币：</span><b class="f18 purple"><?php if ($user_info) { echo $user_info['total_silver'];}?></b></li>
                <?php } ?>
                <li class="clearfix"><span>提现数量：</span><input type="text" id="score_num" name="score_num" class="input_txt mr15" style="width:120px;"><?php echo $score_type_str; ?>
                <?php if ($score_type == 'gold') { ?>
                (<?php if ($score_setting_info && $user_info){echo "<font color='#e61d47'>{$user_info['total_gold_rmb_pre']}金象币可兑换1元</font>";}; ?>)
                <?php } else { ?>
                (<?php if ($score_setting_info && $user_info){echo "<font color='#e61d47'>{$user_info['total_silver_rmb_pre']}银象币可兑换1元</font>";}; ?>)
                <?php } ?>
                </li>
                <li class="clearfix"><span>提现金额：</span><i id="money">0</i> <font color="#e61d47">元</font></li>
                <li class="clearfix"><span>提现到：</span>
                <input onclick="javascript:select_account_type('alipay');" name="account_type" value="alipay" type="radio"> 支付宝账号
                <input onclick="javascript:select_account_type('weixin');" name="account_type" value="weixin" type="radio"> 微信账号
                <a style="margin-left: 20px;color:#e61d47;" href="<?php echo getBaseUrl(false,'','user/change_user_info.html',$client_index);?>"  >绑定提现账号</a>
                </li>
                <li class="user_account" style="display: none;" class="clearfix"><span id="user_account_real_name">户名：</span><i><?php if($user_info) {echo $user_info['real_name'];} ?></i></li>
                <li class="user_account" style="display: none;" class="clearfix"><span id="user_account_account">账号：</span><i id="user_account"></i></li>
                <li class="clearfix">
                    <span>&nbsp;</span><input onclick="javascript:submit();" type="button" class="btn_r" value="确认提现" style="border:none;">
                </li>
            </ul>
        </div>

    </div>
</div>
<script language="javascript" type="text/javascript">
	$('#score_num').bind('input propertychange', function() {
		var bl = '';
		<?php if ($score_type == 'gold' && $user_info) { ?>
		bl = '<?php echo $user_info['total_gold_rmb_pre']; ?>';
		<?php } else if ($user_info) { ?>
		bl = '<?php echo $user_info['total_silver_rmb_pre']; ?>';
		<?php } ?>
	    var score_num = $('#score_num').val();
	    $('#money').html(parseFloat(parseInt(score_num)/parseInt(bl)).toFixed(2));
	});

	function select_account_type(account_type) {
		var alipay_account = '<?php if ($user_info) {echo $user_info['alipay_account'];} ?>';
		var weixin_account = '<?php if ($user_info) {echo $user_info['weixin_account'];} ?>';
		if (account_type == 'alipay') {
			$('.user_account').show();
            $('#user_account').html(alipay_account);
            $('#user_account_real_name').html('支付宝户名：');
            $('#user_account_account').html('支付宝账号：');
	    } else if (account_type == 'weixin') {
	    	$('.user_account').show();
	    	$('#user_account').html(weixin_account);
	    	$('#user_account_real_name').html('微信户名：');
            $('#user_account_account').html('微信账号：');
		}
	}

	//提现
	var is_submit = false;
	function submit() {
        var score_num = $('#score_num').val();
        var account_type = $('input[name="account_type"]:checked').val();
        if (!score_num) {
            return my_alert('score_num', 1, '请输入提现数量');
        }
        if (!account_type) {
        	return my_alert('fail', 0, '请选择账号类型');
        }
        if (is_submit) {
            return false;
        }
        is_submit = true;
        $.post(base_url+"index.php/"+controller+"/add_withdraw",
    			{	"account_type": account_type,
        	        "score_type": '<?php echo $score_type; ?>',
    		        "score_num": score_num
    			},
    			function(res){
    				is_submit = false;
    				if(res.success){
    					my_alert_url(res.field, res.message);
    				}else{
    					if (res.field != 'fail') {
    						return my_alert(res.field, 1, res.message);
    				    } else {
    				    	return my_alert('fail', 0, res.message);
    					}
    				}
    			},
    			"json"
    	);
    }
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>