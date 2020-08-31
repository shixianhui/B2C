<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right mt20">
        <div class="box_shadow clearfix m_border">
            <div class="member_title"><span class="bt">充值账户</span></div>
            <form id="yourForm" action="index.php/pay/ebank" method="post">
            <ul class="m_form" >
                <li class="clearfix"><span>账户余额：</span><b class="f18 purple"><small>￥</small><?php echo $userInfo['total'];?></b></li>
                <li class="clearfix"><span>充值金额：</span><input type="text" name="money" class="input_txt mr15" style="width:180px;">元</li>
                <li class="clearfix"><span>付款方式：</span>
                    <div class="bank_pay">
                        <div class="hd">
                            <ul id="togglePay">
                                <Li data-action="index.php/pay/ebank">网银支付</Li>
                                <Li data-action="index.php/pay/weixin">微信支付</Li>
                                <Li data-action="index.php/pay/alipay">支付宝</Li>
                            </ul>
                        </div>
                        <div class="bd clearfix">
                            <div class="bank_list">
                                <dl class="checkbox_item">
                                    <dd><a href="javascript:viod(0);"><img src="images/default/bank_logo/abc.gif"></a></dd>
                                    <dd><a href="javascript:viod(0);"><img src="images/default/bank_logo/b1552.gif"></a></dd> 
                                    <dd><a href="javascript:viod(0);"><img src="images/default/bank_logo/b1608.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/b1629.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/b1669.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/boc.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/bos.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/ccb.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/ceb_old.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/cgb.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/cib.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/citic.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/cmb.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/cmbc.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/comm.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/hxb.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/icbc.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/pingan.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/psbc.gif"></a></dd> 
                                    <dd ><a href="javascript:viod(0);"><img src="images/default/bank_logo/spdb.gif"></a></dd> 
                                </dl>
                            </div>
                            <div class="bank_list">
                                <dl class="checkbox_item"><dd ><a href="javascript:viod(0);"><img src="images/default/pay-weixin.png"></a></dd></dl>
                            </div>
                            <div class="bank_list">
                                <dl class="checkbox_item"><dd ><a href="javascript:viod(0);"><img src="images/default/alipay_logo.png"></a></dd></dl>
                            </div>
                        </div>
                    </div>
                </li>
<!--                <li class="clearfix"><span>&nbsp;</span><dl class="m_check"><dd><span name="checkWeek" class="CheckBoxNoSel CheckBoxSel"></span>我同意<a href="" style="color:#e61d47;">《资金管理协议》</a></dd></dl> </li>-->
                <li class="clearfix">
                    <span>&nbsp;</span><input type="submit" class="btn_r" value="提交" style="border:none;">
                </li>  
            </ul>
            </form>
        </div>

    </div>
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
    $(function () {
        $(".checkbox_item dd").click(function () {
            $(this).addClass("clickdd").siblings().removeClass("clickdd");
        })
    });
    $("#togglePay li").click(function(){
        $("#yourForm").attr('action',$(this).data('action'));
    })
    $("#yourForm").submit(function(e){
        var money = $('input[name=money]').val();
        if(!/^\d+(\.\d+)?$/.test(money)){
            alert('金钱格式不正确');
            return false;
        }
        if(money < 1){
            alert('充值金额最少1元起充');
            return false;
        }
    }); 
</script>

<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

