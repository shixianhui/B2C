<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody> 	
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>支付方式名称</strong> <br/>
	  </th>
      <td>
      <input name="title" id="title" value="<?php if(! empty($item_info)){ echo $item_info['title'];} ?>" size="50" maxlength="50" valid="required" errmsg="支付方式名称不能为空!" class="input_blur" type="text">
	</td>
    </tr>    
    <tr>
      <th width="20%">
      <strong>支付费率</strong> <br/>
	  </th>
      <td>
      <input name="percent" id="percent" value="<?php if(! empty($item_info)){ echo $item_info['percent'];}else{echo '0';} ?>" size="5" class="input_blur" type="text"> % 格式:"1.5" <br/> <font color="red">注:支付手续费 = (商品总价+配送费用)x支付费率</font>
	</td>
	</tr>
    <tr>
      <th width="20%">
      <strong>排序</strong> <br/>
	  </th>
      <td>
      <input name="sort" id="sort" value="<?php if(! empty($item_info)){ echo $item_info['sort'];}else{echo '0';} ?>" size="5" class="input_blur" type="text">
	</td>
    </tr>
     <tr>
      <th width="20%"><font color="red">*</font> <strong>支付方式介绍</strong> <br/>
	  </th>
      <td>
      <textarea maxlength="400" name="content" id="content" rows="4" cols="80" valid="required" errmsg="支付方式介绍不能为空!"  class="textarea_style" ><?php if(! empty($item_info)){ echo $item_info['content'];} ?></textarea>
      </td>
    </tr>
    <tr>
      <th width="20%"> <strong>备注</strong> <br/>
	  </th>
      <td>
      <textarea name="remark" id="remark" rows="4" cols="80" maxlength="400" class="textarea_style" ><?php if(! empty($item_info)){ echo $item_info['remark'];} ?></textarea>
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