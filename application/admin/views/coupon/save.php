<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>选择优惠券类型</strong> <br/>
	  </th>
      <td>
      <select class="input_blur" name="coupon_type" id="coupon_type" valid="required" errmsg="选择优惠券类型!">
        <option value="" >选择优惠券类型</option>
        <?php if (! empty($coupon_arr)) { ?>
		<?php foreach ($coupon_arr as $key=>$value) {?>
		<option  value="<?php echo $key; ?>"><?php echo $value; ?></option>
		<?php }} ?>
      </select>
      </td>
    </tr>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>有效期限</strong> <br/>
	  </th>
      <td>
      <input valid="required|isNumber" errmsg="有效期不能为空!|有效期为数字"  size="10" type="text" name="lifetime"> 天
	</td>
    </tr>
      <tr>
    <th width="20%">
    <font color="red">*</font> <strong>生成张数</strong> <br/>
	</th>
    <td>
        <input valid="required|isNumber" errmsg="生成张数不能为空!|张数必须是数字"  size="10" type="text" name="number"> 张
    </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value="生成 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>