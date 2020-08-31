<div class="warp">
<?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">绑定邀请码</span></div>
            <?php if ($userInfo && !$userInfo['presenter_id']) { ?>
            <div class="member_tab mt20">
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="jsonForm" name="jsonForm" method="post">
                        <ul class="m_form" style="float:left; width:640px;">
                            <li class="clearfix"><span>邀请码：</span><input type="text" id="pop_code" name="pop_code" valid="required" errmsg="请输入正确的邀请码" class="input_txt">
                            <font style="margin-left: 10px;" color="red">注：绑定邀请码有积分送</font>
                            </li>
                            <li class="clearfix"><span>&nbsp;</span><input type="submit" value="提交" class="btn_r" style="border:none;"></li>
                        </ul>
                    </form>
            </div>
            <?php } else { ?>
            <div class="member_tab mt20">
            <ul class="m_form" style="float:left; width:640px;">
                 <li class="clearfix">邀请码已成功绑定，积分已打入你的账户</li>
             </ul>
            </div>
            <?php } ?>
        </div>
    </div>
</div>