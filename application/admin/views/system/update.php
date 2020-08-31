<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>安卓整包更新最新版本号</strong><br/>
	  </th>
      <td>
      <input name="android_full_update_version" id="android_full_update_version" value="<?php if($itemInfo){echo $itemInfo['android_full_update_version'];} ?>" size="10" class="input_blur" type="text"> <font color="red">如："1.0"</font>
	</tr>
	<tr>
      <th width="20%">
      <strong>安卓整包更新下载地址</strong><br/>
	  </th>
      <td>
      <input name="android_full_update_url" id="android_full_update_url" value="<?php if($itemInfo){echo $itemInfo['android_full_update_url'];} ?>" size="100" class="input_blur" type="text">
	</tr>
	<tr>
      <th width="20%">
      <strong>IOS整包更新最新版本号</strong><br/>
	  </th>
      <td>
      <input name="ios_full_update_version" id="ios_full_update_version" value="<?php if($itemInfo){echo $itemInfo['ios_full_update_version'];} ?>" size="10" class="input_blur" type="text">  <font color="red">如："1.0"</font>
	</tr>
	<tr>
      <th width="20%">
      <strong>IOS整包更新下载地址</strong><br/>
	  </th>
      <td>
      <input name="ios_full_update_url" id="ios_full_update_url" value="<?php if($itemInfo){echo $itemInfo['ios_full_update_url'];} ?>" size="100" class="input_blur" type="text">
	</tr>
	<tr>
      <th width="20%">
      <strong style="color: red;">说明</strong><br/>
	  </th>
      <td>
      <font color="red">资源包更新，主要进行小版本的更新，即时生效</font>
	</tr>
	<tr>
      <th width="20%">
      <strong style="color: red;">资源包版本号</strong><br/>
	  </th>
      <td>
      <input name="wget_version" id="wget_version" value="<?php if($itemInfo){echo $itemInfo['wget_version'];} ?>" size="10" class="input_blur" type="text">  <font color="red">如："1.0"</font>
	</tr>
	<tr>
      <th width="20%">
      <strong style="color: red;">资源包更新下载地址</strong><br/>
	  </th>
      <td>
      <input name="wget_url" id="wget_url" value="<?php if($itemInfo){echo $itemInfo['wget_url'];} ?>" size="100" class="input_blur" type="text">
	</tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input class="button_style" name="reset" value=" 重置 " type="reset">
	  </td>
    </tr>
</tbody>
</table>
</form>
<br/><br/>