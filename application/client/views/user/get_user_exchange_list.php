<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">申请退换货</span></div>
            <div class="member_tab mt20">
                <div class="hd">
                    <ul>
                        <li <?php if ($exchange_status === 'all') {echo 'class="on"';} ?> onclick="location.href = '<?php echo getBaseUrl(false, "", "user/get_user_exchange_list", $client_index); ?>'">全部</li>
                        <li <?php if ($exchange_status == '0') { echo 'class="on"'; } ?> onclick="location.href = '<?php echo getBaseUrl(false, "", "user/get_user_exchange_list/0.html", $client_index); ?>'">待审核<span><?php echo $count_0; ?></span></li>
                        <li <?php if ($exchange_status == 1) {echo 'class="on"';} ?> onclick="location.href = '<?php echo getBaseUrl(false, "", "user/get_user_exchange_list/1.html", $client_index); ?>'">审核未通过<span><?php echo $count_1; ?></span></li>
                        <li <?php if ($exchange_status == 2) {echo 'class="on"';} ?> onclick="location.href = '<?php echo getBaseUrl(false, "", "user/get_user_exchange_list/2.html", $client_index); ?>'">审核通过<span><?php echo $count_2; ?></span></li>
                    </ul>
                </div>
                <div class="bd">
                    <div class="clearfix">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
                            <thead>
                                <tr>
                                    <th width="35%">商品</th>
                                    <th width="10%">订单总额</th>
                                    <th width="10%">申请时间</th>
                                    <th width="10%">服务类型</th>
                                    <th width="10%">退款金额</th>
                                    <th width="10%">退款/退换货状态</th>
                                    <th>操作</th>
                                </tr>
                                <tr>
                                    <td colspan="6" class="bj">&nbsp;</td>
                                </tr>
                            </thead>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table">
                            <tbody>
                                                       <?php if ($item_list) { ?>
		<?php foreach ($item_list as $key=>$value) {
                       $url = getBaseUrl(false,'','user/save_exchange/'.$value['id'].'?order_number='.$value['order_number'],$client_index);
                    ?>
                                <tr style="border-top:1px solid #e8e8e8;border-bottom: 1px solid #e8e8e8;">
                                    <th colspan="7" align="left"><font class="c9">下单时间：</font><?php echo date('Y-m-d',$value['add_time']);?>&nbsp;&nbsp;&nbsp;订单编号：<?php echo $value['order_number'];?></th>
                                </tr>
                                <tr>
                                    <td width="35%" align="center" style="border-left:none;">
                                        <table class="refund_product">
                                            <?php
                                             if($value['product']){
                                            ?>
                                            <tr>
                                                <td style="padding-left:10px;"><img src="<?php echo str_replace('.','_thumb.',$value['product']['path']);?>"></td>
                                                <td style="padding-left:10px;"><?php echo $value['product']['product_title'];?></td>
                                            </tr>
                                             <?php }?>
                                        </table>
                                    </td>
                                    <td width="10%" align="center" style="border-left:none;"><?php echo $value['total_price'];?>元</td>
                                    <td width="10%" align="center" style="border-left:none;"><?php echo date('Y-m-d',$value['add_time']);?></td>
                                    <td width="10%" align="center" ><?php echo $exchange_type_arr[strval($value['exchange_type'])];?></td>
                                    <td width="10%" align="center" ><?php echo $value['price'];?>元</td>
                                    <td width="10%" align="center" style="position: relative;">
                                        
                                        <span class="padding"><?php echo $status[intval($value['status'])];?></span>  
                                        <?php 
                                            if($value['price'] > 0){
                                                echo '<span class="refund_status padding">已退款</span>';
                                            } ?>
                                        <?php
                                        if($value['buyer_express_num'] > 0 && $value['price']==0 && $value['exchange_type'] == 1){
                                                echo '<span class="refund_status padding">等待退款</span>';
                                            }
                                        ?>
                                         <?php
                                        if($value['buyer_express_num'] > 0 && $value['seller_recieve_goods']==0 && $value['exchange_type'] == 2){
                                                echo '<span class="refund_status padding">等待换货</span>';
                                            }
                                        ?>
                                         <?php
                                        if($value['buyer_express_num'] > 0 && $value['seller_recieve_goods']==1 &&$value['status']==2 && $value['exchange_type'] == 2){
                                                echo '<span class="refund_status padding">换货成功</span>';
                                            }
                                        ?>
                                        <?php if($value['status']==1){?>
                                        <span class="refuse_cause" style="display:inline-block;width:14px;height:14px;border:1px solid #ccc;background-color:#fff;line-height: 14px;text-align:center;border-radius: 100%;font-size:12px;">?</span>
                                        <div class="ui-tooltips arrow-top-left" style="left:-40px;top:90px;display:none;"><p><?php echo $value['remark'];?></p></div>
                                        <?php }?>
                                    </td>
                                    <td align="center">
                                        
                                       <?php
                                         if($value['exchange_type']==1 && $value['status']==2 && empty($value['buyer_express_num'])){
                                       ?>
                                        <a href="<?php echo getBaseUrl(false,'','user/buyer_post_goods/'.$value['id'],$client_index);?>" class="m_btn">去退货</a>
                                         <?php }?>
                                        
                                          <?php
                                         if($value['exchange_type']==2 && $value['status']==2 && empty($value['buyer_express_num'])){
                                       ?>
                                        <a href="<?php echo getBaseUrl(false,'','user/buyer_post_goods/'.$value['id'],$client_index);?>" class="m_btn">去退货</a>
                                         <?php }?>
                                             <?php
                                         if($value['status']==1 && $value['expired'] == 0){
                                             if($value['exchange_type']==1){
                                                 $url = getBaseUrl(false,'','user/exchange_thtk/'.$value['id'].'.html?order_number='.$value['order_number'].'&id='.$value['orders_detail_id'],$client_index);
                                             }
                                             if($value['exchange_type']==2){
                                                 $url = getBaseUrl(false,'','user/exchange_hh/'.$value['id'].'.html?order_number='.$value['order_number'].'&id='.$value['orders_detail_id'],$client_index);
                                             }
                                             if($value['exchange_type']==3){
                                                 $url = getBaseUrl(false,'','user/exchange_jtk/'.$value['id'].'.html?order_number='.$value['order_number'].'&id='.$value['orders_detail_id'],$client_index);
                                             }
                                       ?>
                                        <a href="<?php echo $url;?>" class="m_btn">再次申请</a>
                                         <?php }?>
                                        
                                            <?php
                                         if($value['status']==0){
                                             if($value['exchange_type']==1){
                                                 $url = getBaseUrl(false,'','user/exchange_thtk/'.$value['id'].'.html?order_number='.$value['order_number'].'&id='.$value['orders_detail_id'],$client_index);
                                             }
                                             if($value['exchange_type']==2){
                                                 $url = getBaseUrl(false,'','user/exchange_hh/'.$value['id'].'.html?order_number='.$value['order_number'].'&id='.$value['orders_detail_id'],$client_index);
                                             }
                                             if($value['exchange_type']==3){
                                                 $url = getBaseUrl(false,'','user/exchange_jtk/'.$value['id'].'.html?order_number='.$value['order_number'].'&id='.$value['orders_detail_id'],$client_index);
                                             }
                                       ?>
                                        <a href="<?php echo $url;?>" class="m_btn">编辑</a>
                                         <?php }?>
                                    </td>
                                </tr>
                                <tr style="border:1px solid #fff;border-bottom:none;"><td colspan="6" style="border:0px;"></td></tr>
        <?php }} ?> 
                            </tbody>
                        </table>
                        <div class="delete_cuont mt20"></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="pagination"> 
                <ul><?php echo $pagination; ?></ul>
            </div>  
        </div>
    </div>
</div>
<style>
    .ui-tooltips.arrow-top-left:before{
            border-right-color: transparent;
            border-bottom-color: #d6d6d6;
            top:-12px;
            left:50%;
    }
    .member_tab .hd ul li{
        width:135px;
        font-weight: bold;
    }
    .member_tab .hd ul li span{
        color:#e61d47;
        padding-left:5px;
    }
    .member_table tbody td{
        padding:10px 0px;
        border-left:1px solid #e8e8e8;
    }
    .member_table tbody td .info{
       width:280px;
       padding-left:10px;
    }
    .refund_status{
        color:#e61d47;
    }
     span.padding{
      display:inline-block;width:100px;height:24px;padding:8px 0px;
    }
</style>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
</script>
<script type="text/javascript">
    $(".refuse_cause").hover(function(){
        $(this).siblings('.ui-tooltips').show();
    },function(){
        $(this).siblings('.ui-tooltips').hide();
    })
function deleteExchange(id) {
	$.post(base_url+"index.php/user/my_delete_exchange", 
			{	
				"id": id
			},
			function(res){
				if(res.success){		
                                        location.reload();
					return false;
				}else{
					var d = dialog({
					    title: '提示',
					    fixed: true,
					    content: res.message
					});
					d.show();
					setTimeout(function () {
					    d.close().remove();
					}, 2000);
					return false;
				}
			},
			"json"
    );
}
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

