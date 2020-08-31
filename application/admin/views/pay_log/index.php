<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">
<select class="input_blur" name="order_type">
<option value="">请选择类型</option>
<?php if($order_type_arr) { ?>
<?php foreach ($order_type_arr as $key=>$value) { ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php }} ?>
</select>&nbsp;
<select class="input_blur" name="payment_type">
<option value="">请选择支付方式</option>
<?php if($payment_type_arr) { ?>
<?php foreach ($payment_type_arr as $key=>$value) { ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php }} ?>
</select>&nbsp;
买家账号 <input class="input_blur" name="buyer_email" id="buyer_email" size="20" type="text">&nbsp;
商户订单号 <input class="input_blur" name="out_trade_no" id="out_trade_no" size="20" type="text">&nbsp;
订单号 <input class="input_blur" name="order_num" id="order_num" size="20" type="text">&nbsp;
第三方平台交易号 <input class="input_blur" name="trade_no" id="trade_no" size="30" type="text">&nbsp;
<select class="input_blur" name="trade_status">
<option value="">充值状态</option>
<?php if($trade_status_msg) { ?>
<?php foreach ($trade_status_msg as $key=>$value) { ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php }} ?>
</select>&nbsp;
会员ID <input class="input_blur" name="user_id" id="user_id" size="10" type="text">&nbsp;
会员名 <input class="input_blur" name="username" id="username" size="15" type="text">&nbsp;
支付时间 <input class="input_blur" name="inputdate_start" id="inputdate_start" size="10" readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
					date = new Date();
					Calendar.setup({
						inputField     :    "inputdate_start",
						ifFormat       :    "%Y-%m-%d",
						showsTime      :    false,
						timeFormat     :    "24"
					});
				 </script> - <input class="input_blur" name="inputdate_end"
id="inputdate_end" size="10"  readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
					date = new Date();
					Calendar.setup({
						inputField     :    "inputdate_end",
						ifFormat       :    "%Y-%m-%d",
						showsTime      :    false,
						timeFormat     :    "24"
					});
				 </script>&nbsp;
<input class="button_style" name="dosubmit" value=" 查询 " type="submit">
</td>
</tr>
</tbody>
</table>
</form>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="80">类型</th>
<th width="80">支付方式</th>
<th width="80">支付时间</th>
<th width="80">金额</th>
<th width="80">赠送金额</th>
<th width="120">会员信息</th>
<th width="150">买家账号</th>
<th width="150">商户订单号(订单号)</th>
<th >第三方平台交易号</th>
<th width="120">充值状态</th>
<th width="90">交易完成时间</th>
<th width="70">操作</th>
</tr>
<?php if (! empty($itemList)): ?>
<?php foreach ($itemList as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background='#FFFFFF'">
<td class="align_c"><?php echo $order_type_arr[$value['order_type']]; ?></td>
<td class="align_c"><?php echo $payment_type_arr[$value['payment_type']]; ?></td>
<td class="align_c"><?php echo date('Y-m-d H:i:s', $value['add_time']); ?></td>
<td class="align_c"><?php echo number_format($value['total_fee'], 2, '.', ''); ?></td>
<td class="align_c"><?php echo $value['total_fee_give']; ?></td>
<td class="align_c">
<?php echo $value['username']; ?><br/>
[会员ID：<?php echo $value['user_id']; ?>]
</td>
<td class="align_c"><?php echo $value['buyer_email']; ?></td>
<td class="align_c">
<?php echo $value['out_trade_no']; ?>
<?php if ($value['order_num']) { ?>
<br/>
(<font color="red"><?php echo $value['order_num']; ?></font>)
<?php } ?>
</td>
<td class="align_c"><?php echo $value['trade_no']; ?></td>
<td class="align_c"><?php echo $trade_status_msg[$value['trade_status']]; ?>
<br/>
<?php if ($value['trade_status'] == 'TRADE_SUCCESS' || $value['trade_status'] == 'TRADE_FINISHED') { ?>
<?php if (!$value['is_arrival']) { ?>
（<font color="red">未到账</font>）
<?php }} ?>
</td>
<td class="align_c"><?php if ($value['notify_time']){ echo date('Y-m-d H:i:s', $value['notify_time']);}else{echo '----';} ?></td>
<td class="align_c"><a href="admincp.php/<?php echo $table; ?>/save/<?php echo $value['id']; ?>">处理</a></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div id="pages">
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
<?php echo $pagination; ?>
</div>