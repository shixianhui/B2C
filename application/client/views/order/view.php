<style>
  .order_step li span {
    width: 155px;
}
</style>
<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">我的订单</span></div>
            <div class="m_order_head mt20 f13">
                <span class="fl">订单编号：<b class="c3 mr20"> <?php if ($orderInfo){ echo $orderInfo['order_number'];} ?></b>  订单金额：<b class="purple f14 mr20">¥<?php if ($orderInfo){ echo $orderInfo['total'];} ?></b> 状态： <?php if ($orderInfo){ echo $status_arr[$orderInfo['status']];} ?></span>
               <?php if($orderInfo['status'] == 2){ ?>
                <span class="fr"><a href="javascript:void(0)" class="btn" onclick="javascript:changeReceiving(<?php echo $orderInfo['id'];?>)">确认收货</a></span>
               <?php }?>
            </div>
            <div class="clear"></div>
            <div class="m_title mt20"><span></span>订单信息</div>
            <div class="m_order_adder">
                <P><span>收货地址：</span><font class="purple"><?php if ($orderInfo){ echo $orderInfo['buyer_name'];} ?></font>&nbsp;&nbsp;<?php if ($orderInfo){ echo $orderInfo['mobile'];} ?>&nbsp;&nbsp;  <?php if ($orderInfo){ echo $orderInfo['txt_address'];} ?><?php if ($orderInfo){ echo $orderInfo['address'];} ?>&nbsp;&nbsp;<?php if ($orderInfo){ echo $orderInfo['zip'];} ?></P>
                <P>
                <i class="fl">
                       购买方式：<?php if ($orderInfo){if ($orderInfo['pay_mode'] == 0){echo '现金购买';}else{echo '积分换购';}} ?><br>
                       支付方式：<?php if ($orderInfo){ echo $orderInfo['payment_title'];} ?><br>
                        配送方式：	<?php if ($orderInfo){ echo $orderInfo['postage_way'];} ?></i>
                </P>
                <P><span>买家留言：</span><?php if ($orderInfo){ echo $orderInfo['remark'];} ?></P>
            </div>
            <div class="m_title mt20"><span></span>商品信息</div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table">
                <tbody>
                    <tr>
                        <th class="tal"><b>属性</b></th>
                        <th ><b>单价（元）</b></th>
                        <th ><b>数量</b></th>
                        <th><b>优惠</b></th>
                        <th width="13%"><b>状态</b></th>
                    </tr>
							    <?php if ($orders_detail_list) { ?>
									<?php foreach ($orders_detail_list as $orderdetail) {
										      $url = getBaseUrl($html, "", "product/detail/{$orderdetail['product_id']}.html", $client_index);
										?>
                    <tr>
                        <td width="37%" valign="middle"><div class="info"><a href="<?php echo $url; ?>"  ><img src="<?php if ($orderdetail['path']) { echo preg_replace("/\./","_thumb.", $orderdetail['path']); }else{echo 'images/default/load.jpg';}?>"><?php echo $orderdetail['product_title']; ?> <?php if($orderdetail['color_size_open']) { ?><br/><?php echo $orderdetail['product_color_name']; ?>：<?php echo $orderdetail['color_name']; ?> <?php echo $orderdetail['product_size_name']; ?>：<?php echo $orderdetail['size_name']; ?><?php } ?></a></div></td>
                        <td width="19%" align="center">
                        <?php if ($orderInfo) { ?>
                        <?php if ($orderInfo['discount_total'] > 0) { ?>
                        <s style="color: #999;"><small>¥</small><?php echo $orderdetail['old_price']; ?></s><br/>
                        <?php }} ?>
                        <small>¥</small><?php echo $orderdetail['buy_price']; ?>
                         <?php if ($orderInfo) { ?>
                        <?php if ($orderInfo['discount_total'] > 0) { ?>
                        <br/>
                         <div class="promo_content">
                           <h4>进货价</h4>
                           <span class="promo_arrow"></span>
                           <div class="invisible">
                           <p>销售价：￥<?php echo $orderdetail['old_price']; ?></p>
                           <p>优　惠：￥<?php echo number_format($orderdetail['old_price']-$orderdetail['buy_price'], 2, '.', ''); ?>
                           </p>
                           </div>
                         </div>
                        <?php }} ?>
                        </td>
                        <td width="13%" align="center"><?php echo $orderdetail['buy_number']; ?></td>
                        <td width="18%" align="center">
                        <small>¥</small>0.00
                        </td>
                        <td width="13%" align="center"><font> <?php if ($orderInfo){ echo $status_arr[$orderInfo['status']];} ?></font></td>
                    </tr>
                    <?php }} ?>
                    <?php if ($orderInfo) { ?>
                    	<?php if ($orderInfo['pay_mode'] == 0) { ?>
                    <tr>
                      <td colspan="5" align="right">
                        <span>商品总额：</span>
                        <span class="f14 mr20">¥<?php if ($orderInfo){ echo $orderInfo['product_total'];} ?></span>
                      </td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td colspan="5" align="right">
                        <span>积分换购：</span>
                        <span class="f14 mr20"><?php if ($orderInfo){ echo $orderInfo['deductible_score'];} ?></span>
                      </td>
                    </tr>
                    <?php }} ?>
                    <tr>
                      <td colspan="5" align="right">
                        <span>运费：</span>
                        <span class="f14 mr20">¥<?php if ($orderInfo){ echo $orderInfo['postage_price'];} ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="right">
                        <span>优惠：</span>
                        <span class="f14 mr20">-¥<?php if ($orderInfo){ echo $orderInfo['discount_total'];} ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="right">
                      	<span style="font-size: 12px;">送金象积分：<?php if ($orderInfo){ echo $orderInfo['gold_score'];} ?></span>
                      	<span style="margin-left: 20px;font-size: 12px;">送银象积分:<?php if ($orderInfo){ echo $orderInfo['silver_score'];} ?></span>
                        <span style="margin-left: 20px;">实付款：</span>
                        <b class="purple f14 <?php if ($orderInfo && $orderInfo['pay_mode'] == 0) {echo 'mr20';} ?>">¥<?php if ($orderInfo){ echo $orderInfo['total'];} ?></b>
                        <?php if ($orderInfo) { ?>
                        <?php if ($orderInfo['pay_mode'] > 0) { ?>
                        <b class="purple f14 mr20">+<?php echo $orderInfo['deductible_score']; ?>积分</b>
                        <?php }} ?>
                      </td>
                    </tr>
                </tbody>
            </table>
            <div class="m_title mt20"><span></span>订单状态跟踪</div>
            <div class="m_order_logistics">
                <ul>
                	<?php if ($orders_process_list) { ?>
                	<?php foreach ($orders_process_list as $key=>$value) { ?>
                    <li style="padding: 10px 15px 10px 15px;">
                    	<P>
                    		<?php echo date('Y-m-d H:i', $value['add_time']); ?>
                    		&nbsp;&nbsp;
                    		<?php echo $value['content']; ?>
                    		</P>
                    </li>
                  <?php }} ?>
                </ul>
            </div>
            <?php if($orderInfo['express_number']){ ?>
            <div class="m_title mt20"><span></span>物流信息</div>
            <div class="m_order_logistics">
                <ul>
                    <li><P><span>快递公司：</span><?php echo $orderInfo['delivery_name'];?>&nbsp;</P>
                        <P><span>快递单号：</span><?php echo $orderInfo['express_number'];?>&nbsp;</P>
                    </li>
                </ul>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<script>
//确认收货
function changeReceiving(id) {
	var d = dialog({
		title: '提示',
		width: 300,
		fixed: true,
		content: '您确认已经收到货，进行”确认收货“操作？',
		okValue: '确认收货',
		ok: function() {
			$.post(base_url + "index.php/order/receiving", {
				"id": id
			},
			function(res) {
				if(res.success) {
					window.location.reload();
				} else {
					return my_alert('fail', 0, res.message);
				}
			},
			"json"
		);
		}
	});
	d.show();
}
</script>