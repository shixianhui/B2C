<?php echo $tool;?>
<style>
    .table_form th,.table_form td{
        text-align: center;
    }
</style>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>包邮条件设置</caption>
 	<tbody>
            <tr>
      <th width="30%">
         &nbsp;
	</th>
      <th>
         非活动商品
      </th>
      <th>
         活动商品
      </th>
	</tr>
	<tr>
      <th width="30%" style="text-align: right;">
       <strong>满</strong>
       <input name="free_postage_price" id="free_postage_price" value="<?php if($itemInfo){ echo $itemInfo['free_postage_price'];} ?>" valid="required|isMoney" errmsg="此项不能为空|金钱格式有误" size="10"  class="input_blur" type="text"> <font color="red"> 元</font>
       <strong>包邮</strong>
	</th>
      <td>
      <label> <input type="radio" value="0" name="open_price" class="radio_style" <?php if($itemInfo){if($itemInfo['open_price']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭</label>
      <label><input type="radio" value="1" name="open_price" class="radio_style" <?php if($itemInfo){if($itemInfo['open_price']=='1'){echo 'checked="checked"';}} ?> > 开启</label>
      </td>
      <td>

      <label><input type="radio" value="0" name="open_price_ac" class="radio_style" <?php if($itemInfo){if($itemInfo['open_price_ac']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭</label>
      <label><input type="radio" value="1" name="open_price_ac" class="radio_style" <?php if($itemInfo){if($itemInfo['open_price_ac']=='1'){echo 'checked="checked"';}} ?> > 开启</label>
      </td>
	</tr>
	<tr>
      <th width="30%" style="text-align: right;">
      <strong>满</strong>
      <input name="product_number" id="product_number" value="<?php if($itemInfo){ echo $itemInfo['product_number'];} ?>" valid="required|isInt" errmsg="此项不能为空|件数为正整数" size="10"  class="input_blur" type="text"> <font color="red">件</font>
      <strong>包邮</strong>
	 </th>
      <td>
	<label><input type="radio" value="0" name="open_number" class="radio_style" <?php if($itemInfo){if($itemInfo['open_number']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭</label>
        <label><input type="radio" value="1" name="open_number" class="radio_style" <?php if($itemInfo){if($itemInfo['open_number']=='1'){echo 'checked="checked"';}} ?> > 开启</label>
      </td>
       <td>
	<label><input type="radio" value="0" name="open_number_ac" class="radio_style" <?php if($itemInfo){if($itemInfo['open_number_ac']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭</label>
        <label><input type="radio" value="1" name="open_number_ac" class="radio_style" <?php if($itemInfo){if($itemInfo['open_number_ac']=='1'){echo 'checked="checked"';}} ?> > 开启</label>
      </td>
	</tr>
              	<tr>
        <th width="30%" style="text-align: right;">
      <strong>是否开启所有商品全国包邮</strong> <br/>
        </th>
      <td>
	<label><input type="radio" value="0" name="is_free" class="radio_style" <?php if($itemInfo){if($itemInfo['is_free']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭</label>
        <label><input type="radio" value="1" name="is_free" class="radio_style" <?php if($itemInfo){if($itemInfo['is_free']=='1'){echo 'checked="checked"';}} ?> > 开启</label>
      </td>
      <td>
	<label><input type="radio" value="0" name="is_free_ac" class="radio_style" <?php if($itemInfo){if($itemInfo['is_free_ac']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭</label>
        <label><input type="radio" value="1" name="is_free_ac" class="radio_style" <?php if($itemInfo){if($itemInfo['is_free_ac']=='1'){echo 'checked="checked"';}} ?> > 开启</label>
      </td>
            </tr>
    <tr>
        <td colspan="3">
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input class="button_style" name="reset" value=" 重置 " type="reset">
	 </td>
    </tr>
</tbody>
</table>
</form>
<br/><br/>