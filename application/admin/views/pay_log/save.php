<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<input name="id" value="" type="hidden">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%"><strong>类型</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo $order_type_arr[$itemInfo['order_type']];} ?>
     </td>
    </tr>
 	<tr>
      <th width="20%"><strong>支付方式</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo $payment_type_arr[$itemInfo['payment_type']];} ?>
     </td>
    </tr>
	<tr>
      <th width="20%"><strong>支付时间</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo date('Y-m-d H:i:s', $itemInfo['add_time']);} ?>
     </td>
    </tr>
    <tr>
      <th width="20%"><strong>金额</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo $itemInfo['total_fee'];} ?> 元
     </td>
    </tr>
    <tr>
      <th width="20%"><strong>赠送金额</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo $itemInfo['total_fee_give'];} ?> 元
     </td>
    </tr>
    <tr>
      <th width="20%"><strong>会员信息</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo $itemInfo['username'];} ?> [会员ID：<?php if ($itemInfo){echo $itemInfo['user_id'];} ?>]
     </td>
    </tr>
    <tr>
      <th width="20%"><strong>买家账号</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo $itemInfo['buyer_email'];} ?>
     </td>
    </tr>
    <tr>
      <th width="20%"><strong>商户订单号(订单号)</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo $itemInfo['out_trade_no'];} ?>
      (<?php if ($itemInfo){echo $itemInfo['order_num'];} ?>)
     </td>
    </tr>
    <tr>
      <th width="20%"><strong>第三方平台交易号</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo $itemInfo['trade_no'];} ?>
     </td>
    </tr>
    <tr>
      <th width="20%"><strong>充值状态</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo $trade_status_msg[$itemInfo['trade_status']];} ?>
      <?php if ($itemInfo) { ?>
      <?php if (!$itemInfo['is_arrival'] && ($itemInfo['trade_status'] == 'TRADE_SUCCESS' || $itemInfo['trade_status'] == 'TRADE_FINISHED')) { ?>
（<font color="red">未到账</font>）
      <?php }} ?>
     </td>
    </tr>
    <tr>
      <th width="20%"> <strong>备注</strong> <br/>
	  </th>
      <td>
      <textarea name="remark" maxlength="140" id="remark" rows="4" cols="50"  class="textarea_style" ><?php if(! empty($itemInfo)){ echo $itemInfo['remark'];} ?></textarea>
    </td>
    </tr>
    <?php if ($itemInfo && $itemInfo['rem_time']) { ?>
    <tr>
      <th width="20%"><strong>备注时间</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){echo date('Y-m-d H:i:s', $itemInfo['rem_time']);} ?>
     </td>
    </tr>
    <?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>