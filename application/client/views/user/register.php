<style type="text/css">
.dropdown {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #eaebeb;
    color: #333;
    display: block;
    height: 30px;
    overflow: hidden;
    position: relative;
    transition: border-color 0.2s linear 0s;
    width: 90px;
    float:left;
    margin-right: 5px;
}
.reg_select {
    -moz-appearance: none;
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: 0 none;
    box-sizing: border-box;
    color: #666;
    cursor: pointer;
    font-size: 13px;
    font-weight: 400;
    height: 30px;
    line-height: 30px;
    margin: 0;
    max-width: 80%;
    min-width: 80%;
    outline: medium none;
    overflow: hidden;
    padding: 0 8px;
    vertical-align: middle;
    white-space: nowrap;
    width: 80%;
    text-transform: none;
}
.reg_label {
    background: rgba(0, 0, 0, 0) url("images/default/icon.png") no-repeat scroll -402px -99px;
    color: #b0b0b0;
    cursor: pointer;
    height: 16px;
    pointer-events: none;
    position: absolute;
    right: 5px;
    top: 10px;
    width: 16px;
    z-index: 1;
}
.log_form{display:none;border-left:1px solid #d5d5d5;padding:5px;border-top:0;}
.log_form.active{display:block;}
.reg_btn{border-bottom:1px solid #d5d5d5;}
.reg_btn a{display:inline-block;color:#333;border:1px solid #d5d5d5;font-size:18px;text-align:center;padding:6px 12px;margin-bottom:-1px;background:#fff;}
.reg_btn a.active{color:#e61d47;border-bottom:none;padding-bottom:7px;}
.log_form li {margin-bottom:15px;}
</style>
<div class="warp">
    <div class="log_box">
        <h3 >已注册可<a href="<?php echo getBaseUrl(false, '', 'user/login.html', $client_index); ?>" class="purple">直接登录</a></h3>
        <div class="reg_btn">
        	<a class="active" onclick="javascript:select_tab(this, 0);" href="javascript:void(0);">会员注册</a>
        	<a onclick="javascript:select_tab(this, 1);" href="javascript:void(0);">商家注册</a>
        </div>
        <form action="<?php echo getBaseUrl(false, "", "user/register.html", $client_index); ?>" method="post" id="jsonForm" name="jsonForm">
            <ul class="log_form active">
                <Li>
                <input type="hidden" id="user_type" name="user_type" value="0" />
                <input type="text" name="mobile" id="mobile" placeholder="请输入手机号码" valid="required|isMobile" errmsg="手机号不能为空|请输入正确的手机号" class="log_txt"></Li>
                <Li><input type="password" name="password" id="password" placeholder="密码由6-20位字母、数字和符号组合" errmsg="密码不能为空|密码长度必须在6-20字符之间" valid="required|limit" min="6" max="20" class="log_txt"></Li>
                <Li><input type="password" name="ref_password" id="ref_password" placeholder="请再次输入密码" class="log_txt" valid="eqaul" eqaulName="ref_password" errmsg="密码前后不一致"></Li>
                <Li class="clearfix">
                    <input type="text" class="log_txt" valid="required" errmsg="验证码不能为空" maxlength="4" name="code" id="code" placeholder="输入验证码" style="width:100px;text-transform: uppercase;">
                    <img style="" id="valid_code_pic" src="<?php echo getBaseUrl(false, "", "verifycode/index/1", $client_index); ?>" alt="看不清，换一张" onclick="javascript:this.src = this.src + 1;" />
                    <a style="color:#333;" onclick="javascript:document.getElementById('valid_code_pic').src = document.getElementById('valid_code_pic').src + 1;" href="javascript:void(0);">换一张</a>
                </Li>
                <Li class="clearfix"><input type="text" name="smscode" id="smscode" valid="required" errmsg="短信验证码不能为空" placeholder="短信验证码" class="log_txt" style=" width:140px; float:left; margin-right:20px;"><a href="javascript:void(0)" class="getyzm" id="getyzm">获取验证码</a></Li>
                <Li><input type="text" name="pop_code" id="pop_code" <?php if (get_cookie('g_pop_code')){echo 'readonly="readonly" style="background:#e5e5e5;"';} ?>  value="<?php echo get_cookie('g_pop_code'); ?>" placeholder="请输入邀请码" class="log_txt"></Li>
                <div class="clear"></div>
                <li><label><input type="checkbox" checked="checked" name="remember" value="ok">我已认真阅读并接受<a href="<?php echo getBaseUrl(false,'',"page/index/274/28.html", $client_index);?>" style="color:#e61d47;"  >《携众易购服务条款》</a></label></li>
                <li ><input type="submit" class="btn_r" value="立即注册" style="border: none;"></li>
            </ul>
        </form>
    </div>
    <div class="log_img">
    	<?php
	$adList = $this->advdbclass->getAd(58, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
	<Img src="<?php echo $ad['path'];?>">
	<?php }} ?>
	</div>
    </div>
</div>
<script type="text/javascript">
	function select_tab(obj, val) {
	    $('.reg_btn a').removeClass('active');
	    $(obj).addClass('active');
	    if (val == 1) {
	        $('#user_type').val(1);
	    } else {
	    	$('#user_type').val(0);
	    }
	}
	$('#user_type').val(0);

    var times = 60, cuttime;
    function getyzm(idn) {
        times--;
        if (times > 0 && times < 60) {
            $(idn).text(times + "秒后重新获取");
            $(idn).addClass("fail");
            cuttime = setTimeout(function () {
                getyzm(idn)
            }, 1000);
        } else {
            $(idn).text("获取短信验证码");
            times = 60;
            $(idn).removeClass("fail");
            clearTimeout(cuttime);
        }
    }
    $(function () {
        $("#getyzm").bind("click", function () {
            var message = '';
            var mobile = $("input[name=mobile]").val();
            if (!/^1[356789]\d{9}$/.test(mobile)) {
                message = '手机号码格式不正确';
                var d = dialog({
                    width: 300,
                    title: '提示',
                    fixed: true,
                    content: message
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
                return false;
            }
            var password = $("input[name=password]").val();
            if (password.length < 6 || password.length > 20) {
                message = '密码由6-20位字母、数字和符号组合';
                var d = dialog({
                    width: 300,
                    title: '提示',
                    fixed: true,
                    content: message
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
                return false;
            }
            var ref_password = $("input[name=ref_password]").val();
            if (ref_password != password) {
                message = '密码不一致';
                var d = dialog({
                    width: 300,
                    title: '提示',
                    fixed: true,
                    content: message
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
                return false;
            }
            var code = $("input[name=code]").val();
            if (!/^\w{4}$/.test(code)) {
                message = '请正确填写验证码';
                var d = dialog({
                    width: 300,
                    title: '提示',
                    fixed: true,
                    content: message
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
                return false;
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
                    success: function (json) {
                        if (json.success) {
                            getyzm("#getyzm");
                        }
                        var d = dialog({
                            width: 300,
                            title: '提示',
                            fixed: true,
                            content: json.message
                        });
                        d.show();
                        setTimeout(function () {
                            d.close().remove();
                        }, 2000);
                    }
                })
            }
            return false;
        });
    });
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
