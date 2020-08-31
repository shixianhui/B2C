<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>减库存</strong><br/>
	    </th>
      <td>
      	<label>
      	<input type="radio" value="0" name="stock_reduce_type" class="radio_style" <?php if($itemInfo){if($itemInfo['stock_reduce_type']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 下单减库存
        <input type="radio" value="1" name="stock_reduce_type" class="radio_style" <?php if($itemInfo){if($itemInfo['stock_reduce_type']=='1'){echo 'checked="checked"';}} ?> > 付款减库存
        </label>
        <span style="color:#999;margin-left: 10px;">注：控制商品的库存设置</span>
      </td>
  </tr>
	<tr>
      <th width="20%">
      <strong>自动取消订单</strong><br/>
	    </th>
      <td>
      <input name="close_order_time" id="close_order_time" value="<?php if($itemInfo){echo $itemInfo['close_order_time'];} ?>" size="10" class="input_blur" type="number"> <font color="red">小时</font>
      <?php if($itemInfo && $itemInfo['auto_close_time'] > 0) { ?>
      <span style="color: #999;">(<?php echo date('Y-m-d H:i:s', $itemInfo['auto_close_time']); ?>)</span>
      <?php } ?>
      <span style="color:#999;margin-left: 20px;">注：订单未付款时间超过设置时间系统自动取消订单</span>
      </td>
	</tr>
	<tr>
      <th width="20%">
      <strong>订单确认收货</strong><br/>
	    </th>
      <td>
      <input name="receiving_order_time" id="receiving_order_time" value="<?php if($itemInfo){echo $itemInfo['receiving_order_time'];} ?>" size="10" class="input_blur" type="number"> <font color="red">天</font>
	    <?php if($itemInfo && $itemInfo['auto_receiving_time'] > 0){ ?>
	    <span style="color: #999;">(<?php echo date('Y-m-d H:i:s', $itemInfo['auto_receiving_time']); ?>)</span>
	    <?php } ?>
	    <span style="color:#999;margin-left: 32px;">注：自发货起，用户未确认收货时间超过设置的时间系统自动确认收货</span>
	    </td>
	</tr>

    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  </td>
    </tr>
</tbody>
</table>
</form>
<br/><br/>