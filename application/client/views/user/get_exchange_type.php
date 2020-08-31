<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">请选择你要申请的服务</span></div>

            <div class="member_tab mt20">
                <div class="page_left">
                    <dl class="exchange_type">
                        <dd><a href="<?php echo getBaseUrl(false,'','user/exchange_thtk?order_number='.$order_info['order_number'].'&id='.$id,$client_index)?>">退货退款</a></dd> 
                        <dd><a href="<?php echo getBaseUrl(false,'','user/exchange_jtk?order_number='.$order_info['order_number'].'&id='.$id,$client_index)?>">仅退款</a></dd> 
                        <dd><a href="<?php echo getBaseUrl(false,'','user/exchange_hh?order_number='.$order_info['order_number'].'&id='.$id,$client_index)?>">换货</a></dd> 
                    </dl>
                </div>
                <div class="page_right">
                    <h4>订单信息</h4>
                    <p>订单编号:<span style="color:#333;"><?php echo $order_info['order_number'];?></span></p>
                    <p>金　　额:<span style="color:#e61d47;"><?php echo number_format($order_info['total']-$order_info['postage_price'],2);?></span><em style="color:#333;"> 元</em></p>
                    <p>邮　　费:<span style="color:#e61d47;"><?php echo $order_info['postage_price'];?></span><em style="color:#333;"> 元</em></p>
                </div>

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

