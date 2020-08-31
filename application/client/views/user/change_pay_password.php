<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">修改支付密码</span></div>
            <div class="clear"></div>
            <form action="<?php echo getBaseUrl(false, "", "user/change_pay_password.html", $client_index); ?>" id="jsonForm" name="jsonForm" method="post">
                <ul class="m_form" >
                    <li class="clearfix"><span>手机号：</span>
                    	<?php if ($item_info && $item_info['username']){
                            	echo createMobileBit($item_info['username']);
					    } else {?>
						<a style="color: red;" href="<?php echo getBaseUrl(false,"","user/bind_mobile",$client_index);?>">绑定手机</a>
						<?php } ?>
                    </li>
                    <li class="clearfix">
                        <span>图形验证码：</span><input style="text-transform: uppercase;" type="text" maxlength="4" name="code" id="code" valid="required" errmsg="验证码不能为空" placeholder="请输入图形验证码" class="input_txt w160">
                        <img style="cursor: pointer;margin-left: 10px;" id="valid_code_pic" src="<?php echo getBaseUrl(false, "", "verifycode/index/1", $client_index); ?>" alt="看不清，换一张" title="看不清，换一张" onclick="javascript:this.src = this.src + 1;" /> 
                    </li>
                    <li class="clearfix"><span>短信验证码：</span><input type="text" maxlength="4" id="smscode" name="smscode" valid="required" errmsg="短信验证码不能为空" placeholder="请输入短信验证码" class="input_txt w160 "><a style="cursor: pointer;margin-left: 10px;"  href="javascript:void(0);" class="get_yzm fl" id="getyzm">获取短信验证码</a></li>
                    <li class="clearfix"><span>新密码：</span><input type="password" id="new_password" name="new_password" valid="required" errmsg="新密码不能为空" class="input_txt"></li>
                    <li class="clearfix"><span>确认密码：</span><input type="password" id="con_password" name="con_password" valid="eqaul" eqaulName="con_password" errmsg="密码前后不一致" class="input_txt" >  </li>
                    <li class="clearfix"><span>&nbsp;</span><input type="submit" value="确认修改" style="border:none;margin-top:20px;"  class="btn_r" name="submit"></li>
                </ul>
            </form>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
    var times = 60, cuttime;
    function getyzm(idn) {
        times--;
        if (times > 0 && times < 60) {
            $(idn).text(times + "秒后重新获取");
            $(idn).addClass("fail");
            cuttime = setTimeout(function () {
                getyzm(idn)
            }, 1000);
        }
        else {
            $(idn).text("获取短信验证码");
            times = 60;
            $(idn).removeClass("fail");
            clearTimeout(cuttime);
        }
    }

    $(function () {
        $("#getyzm").bind("click", function () {
            var code = $("#code").val();
            if (!code) {
            	return my_alert('code', 1, '请输入图形验证码');
            }
            if (!/^\w{4}$/.test(code)) {
            	return my_alert('code', 1, '请输入正确的图形验证码');
            }
            if (times == 60) {
                $.ajax({
                    url: base_url + 'index.php/user/get_reg_sms_code',
                    type: 'post',
                    data: {
                        type: "get_pass",
                        mobile: '<?php if ($item_info) {echo $item_info['username'];} ?>',
                        code: code
                    },
                    dataType: 'json',
                    success: function (res) {
                        if (res.success) {
                            getyzm("#getyzm");
                            return my_alert('fail', 0, res.message);
                        } else {
                            if (res.field == 'fail') {
                            	return my_alert('fail', 0, res.message);
                            } else {
                            	return my_alert(res.field, 1, res.message);
                            }
                        }
                    }
                })
            }
            return false;
        });

    });
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

