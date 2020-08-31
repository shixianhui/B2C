<div class="warp">
<div class="log_box">
<h3>找回密码</h3>
    <form action="<?php echo getBaseUrl(false, "", "user/get_pass.html", $client_index); ?>" method="post" id="jsonForm" name="jsonForm">
 <ul class="log_form">
    <Li><input type="text" placeholder="手机号" valid="required|isMobile" errmsg="手机号不能为空|手机号码格式不正确" name="username" id="username"  class="log_txt"></Li>
    <li>
         <input type="text" class="log_txt" valid="required" errmsg="验证码不能为空" maxlength="4" name="code" id="code" placeholder="输入验证码" style="width:100px;">
         <img style="" id="valid_code_pic" src="<?php echo getBaseUrl(false, "", "verifycode/index/1", $client_index); ?>" alt="看不清，换一张" onclick="javascript:this.src = this.src+1;" />
         <a style="color:#333;" onclick="javascript:document.getElementById('valid_code_pic').src = document.getElementById('valid_code_pic').src+1;" href="javascript:void(0);">换一张</a>
    </li>
    <li><input type="password" name="password" placeholder="输入新密码,密码由6-20位字母、数字和符号组合" valid="required" errmsg="密码不能为空" class="log_txt"></li>
    <li><input type="password" name="ref_password" placeholder="确认密码" valid="required" errmsg="密码不能为空" class="log_txt"></li>
    <li class="clearfix"><input type="text" name="smscode" valid="required" errmsg="短信验证码不能为空" placeholder="短信验证码" class="log_txt" style=" width:140px; float:left; margin-right:20px;"><a href="javascript:void(0)" class="getyzm" id="getyzm">获取验证码</a></li>
    <li><input type="submit" class="btn_r" value="立即找回" style="border:none;"></li>
  </ul>
    </form>
</div>
<div class="log_img"><Img src="images/default/login_img.png"></div>
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
            var mobile = $("input[name=username]").val();
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
                        type: "get_pass",
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