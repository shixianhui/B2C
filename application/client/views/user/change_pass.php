<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">修改登录密码</span></div>
            <div class="clear"></div>
            <form action="<?php echo getBaseUrl(false, "", "user/change_pass.html", $client_index); ?>" id="jsonForm" name="jsonForm" method="post">
                <ul class="m_form" >
                    <li class="clearfix"><span>旧密码：</span><input type="password" id="old_password" name="old_password" valid="required" errmsg="原密码不能为空" class="input_txt"></li>
                    <li class="clearfix"><span>新密码：</span><input type="password" id="new_password" name="new_password" valid="required" errmsg="新密码不能为空" class="input_txt"></li>
                    <li class="clearfix"><span>确认密码：</span><input type="password" id="con_password" name="con_password" valid="eqaul" eqaulName="con_password" errmsg="密码前后不一致" class="input_txt" >  </li>
                    <li class="clearfix"><span>&nbsp;</span><input type="submit" value="确认修改" style="border:none;margin-top:20px;"  class="btn_r" name="submit"></li>
                </ul>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/load.jpg", //加载图片前的占位图片
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
            if (times == 60) {
                getyzm("#getyzm");
            }
            return false;
        });

    });
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

