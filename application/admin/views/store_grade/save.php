<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>等级名称</strong> <br/>
	  </th>
      <td>
      <input valid="required" errmsg="等级名称不能为空!" name="grade_name" id="grade_name" value="<?php if(! empty($item_info)){ echo $item_info['grade_name'];} ?>" size="80" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>允许发布商品数</strong> <br/>
	  </th>
      <td>
      <input name="product_limit" id="product_limit" value="<?php if(! empty($item_info)){ echo $item_info['product_limit'];} ?>" size="20" type="text">
      <font color="#9c9c9c">注：0表示没有限制</font>
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>需要审核</strong> <br/>
	  </th>
      <td>
      <input type="radio" value="0" name="display" class="radio_style" <?php if($item_info){if($item_info['display']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 否
      <input type="radio" value="1" name="display" class="radio_style" <?php if($item_info){if($item_info['display']=='1'){echo 'checked="checked"';}} ?> > 是
	</td>
	</tr>
	<tr>
    <th width="20%">
    <strong>店铺模板</strong> <br/>
	</th>
    <td>
    <?php if ($theme_list) { ?>
    <?php foreach ($theme_list as $key=>$value) { ?>
    <label><input class="checkbox_style" name="theme_ids[]" value="<?php echo $value['id']; ?>" <?php if(! empty($item_info)){if(in_array($value['id'], $theme_ids_arr)){echo "checked=true";}} ?> type="checkbox"/> <?php echo $value['theme_name']; ?>[<?php echo $value['alias']; ?>]</label>
	<?php }} ?>
	</td>
    </tr>
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