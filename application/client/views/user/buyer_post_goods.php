<div class="warp">
   <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">买家退货给携众易购</span></div>
            <div class="member_tab mt20">
                   <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="jsonForm" name="jsonForm" method="post">
                            <ul class="m_form" >
                                <li class="clearfix" >
                                    <span>退货地址信息：</span>
                                    <p><?php echo $return_address;?></p>
                                </li>
                                <li class="clearfix">
                                    <span><font color="red">*</font>物流公司：</span>
                                    <input type="text" name="buyer_express_com" valid="required" errmsg="物流公司不能为空" class="input_txt mr15" style="width:100px;">
                                </li>
                                 <li class="clearfix">
                                    <span><font color="red">*</font>运单号：</span>
                                    <input type="text" name="buyer_express_num" valid="required|isNumber" errmsg="运单号不能为空|快递单号格式有误" class="input_txt mr15" style="width:100px;">
                                </li>
                                 <li class="clearfix">
                                     <span>发货说明：</span>
                                     <textarea cols="36" rows="3" id="content" name="buyer_post_remark"></textarea>
                                </li>
                                <?php
                                 if($item_info['exchange_type']==2){
                                ?>
                                <li class="clearfix">
                                    <span>收货地址：</span>
                                    默认地址为发货地址　<a href="<?php echo getBaseUrl(false,'','user/get_user_address_list.html',$client_index)?>"  >点我更换地址</a>
                                </li>
                                 <?php }?>
                                <li class="clearfix"><span>&nbsp;</span><input type="submit" value="提交" style="border:none;" class="btn_r"></li>
                            </ul>
                    </form>
            </div>
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
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>


