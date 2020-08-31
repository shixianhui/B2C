<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息(打折:在商品单价上打；返利：在订单总额上返)</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>会员组名称</strong> <br/>
	  </th>
      <td>
      <input name="group_name" id="group_name" value="<?php if(! empty($usergroupInfo)){ echo $usergroupInfo['group_name'];} ?>" size="50" maxlength="50" valid="required" errmsg="管理组名称不能为空!" type="text">
	</td>
    </tr>
    <tr style="display: none;">
      <th width="20%"> <strong>打折</strong> <br/>
	  </th>
      <td>
      <input name="discount" id="discount" value="<?php if(! empty($usergroupInfo)){ echo $usergroupInfo['discount'];}else{echo 100;} ?>" size="50" type="text">
      <font color="red">注：“100”表示不打折，“0”表示商品免费，“95”表示打九五折，“9”表示打九折，以次类推</font>
	</td>
    </tr>
    <tr style="display: none;">
      <th width="20%"> <strong>返利</strong> <br/>
	  </th>
      <td>
      <input name="rebates" id="rebates" value="<?php if(! empty($usergroupInfo)){ echo $usergroupInfo['rebates'];}else{echo 0;} ?>" size="50" type="text">
      <font color="red">注：“100”表示百分之百返利，“8”表示百分之八返利，以次类推</font>
	</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody></table>
</div>
</form>