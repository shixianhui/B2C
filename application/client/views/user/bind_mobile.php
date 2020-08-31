<div class="warp">
   <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">绑定手机</span></div>
            <div class="member_tab mt20">
            	<div class="assets">
					<ul class="clearfix">
						<li>温馨提示：<span>绑定成功后，用户可以用手机号进行登录</span></li>
					</ul>
				</div>
                   <form action="<?php echo getBaseUrl(false, "", "user/bind_mobile.html", $client_index); ?>" id="jsonForm" name="jsonForm" method="post">
                            <ul class="m_form" >
                                <li class="clearfix"><span>手机号：</span><input maxlength="11" type="text" id="mobile" name="mobile" valid="required|isMobile" errmsg="请输入手机号|请输入正确的手机号" placeholder="请输入手机号" class="input_txt"></li>
                                <li class="clearfix">
                                    <span>图形验证码：</span><input style="text-transform: uppercase;" type="text" maxlength="4" name="code" id="code" valid="required" errmsg="验证码不能为空" placeholder="请输入图形验证码" class="input_txt w160">
                                    <img style="cursor: pointer;margin-left: 10px;" id="valid_code_pic" src="<?php echo getBaseUrl(false, "", "verifycode/index/1", $client_index); ?>" alt="看不清，换一张" title="看不清，换一张" onclick="javascript:this.src = this.src + 1;" /> 
                                </li>
                                <li class="clearfix"><span>短信验证码：</span><input type="text" maxlength="4" id="smscode" name="smscode" valid="required" errmsg="短信验证码不能为空" placeholder="请输入短信验证码" class="input_txt w160 "><a style="cursor: pointer;margin-left: 10px;"  href="javascript:void(0);" class="get_yzm fl" id="getyzm">获取短信验证码</a></li>
                                <li class="clearfix"><span>登录密码：</span><input type="password" id="password" name="password" valid="required" errmsg="请输入登录密码" placeholder="请输入登录密码" class="input_txt"></li>
                                <li class="clearfix"><span>确认密码：</span><input type="password" id="ref_password" name="ref_password" valid="required" errmsg="请输入确认密码" placeholder="请输入确认密码" class="input_txt"></li>
                                <li class="clearfix"><span>&nbsp;</span><input type="submit" value="提交绑定" style="border:none;" class="btn_r"></li>  
                            </ul>
                    </form>
            </div>
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
            var mobile = $('#mobile').val();
            if (!mobile) {
            	return my_alert('mobile', 1, '手机号不能为空');
            }
            var reg = /^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/;
			if(!reg.test(mobile)) {
				return my_alert('mobile', 1, '请输入正确的手机号');
            }
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
                        type: "reg",
                        mobile: mobile,
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

