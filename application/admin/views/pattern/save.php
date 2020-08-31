<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<input name="id" value="" type="hidden">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%"><font color="red">*</font> <strong>模型名称</strong> <br/>
	  </th>
      <td>
      <input name="title" id="title" value="<?php if(! empty($itemInfo)){ echo $itemInfo['title'];} ?>" size="50" maxlength="50" valid="required" errmsg="模型名称不能为空!" class="input_blur" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"><font color="red">*</font> <strong>别名</strong> <br/>
	  </th>
      <td>
      <input name="alias" id="alias" value="<?php if(! empty($itemInfo)){ echo $itemInfo['alias'];} ?>" size="50" maxlength="50" valid="required" errmsg="别名不能为空!" class="input_blur" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>颜色</strong> <br/>
	  </th>
      <td>
    <select class="input_blur" name="title_color" id="title_color">
	<option value="<?php if(! empty($itemInfo)){echo $itemInfo['title_color'];} ?>" selected="selected">颜色</option>
	<option value="#000000" class="bg1"></option>
	<option value="#ffffff" class="bg2"></option>
	<option value="#008000" class="bg3"></option>
	<option value="#800000" class="bg4"></option>
	<option value="#808000" class="bg5"></option>
	<option value="#000080" class="bg6"></option>
	<option value="#800080" class="bg7"></option>
	<option value="#808080" class="bg8"></option>
	<option value="#ffff00" class="bg9"></option>
	<option value="#00ff00" class="bg10"></option>
	<option value="#00ffff" class="bg11"></option>
	<option value="#ff00ff" class="bg12"></option>
	<option value="#ff0000" class="bg13"></option>
	<option value="#0000ff" class="bg14"></option>
	<option value="#008080" class="bg15"></option>
	</select>
   </td>
  </tr>
    <tr>
      <th width="20%"><strong>模型文件</strong> <br/>
	  </th>
      <td>
      <input name="file_name" id="file_name" value="<?php if(! empty($itemInfo)){ echo $itemInfo['file_name'];} ?>" size="50" maxlength="50" valid="required" errmsg="模型文件不能为空!" class="input_blur" type="text"><br/>
      <font color="red">注:填写控制文件的文件名,如"product.php",填写"product"</font>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>类型</strong> <br/>
	  </th>
      <td>
      <select class="input_blur" name="type" id="type">
       <option value="模块" <?php if($itemInfo){if($itemInfo['type']=='模块'){echo 'selected="selected"';}} ?> >模块</option>
       <option value="小插件" <?php if($itemInfo){if($itemInfo['type']=='小插件'){echo 'selected="selected"';}} ?> >小插件</option>
      </select>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>状态</strong> <br/>
	  </th>
      <td>
      <input type="radio" value="1" name="status" class="radio_style" <?php if($itemInfo){if($itemInfo['status']=='1'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 启用
      <input type="radio" value="0" name="status" class="radio_style" <?php if($itemInfo){if($itemInfo['status']=='0'){echo 'checked="checked"';}} ?> > 禁用
	</td>
    </tr>
	<tr>
      <th width="20%"> <strong>模块包含的文件</strong> <br/>
	  </th>
      <td>
      <textarea name="description" id="description" rows="4" cols="50"  class="textarea_style" style="width: 80%;" ><?php if(! empty($itemInfo)){ echo $itemInfo['description'];} ?></textarea>
    </td>
    </tr>
	<tr>
      <th width="20%"> <strong>发布时间</strong> <br/>
	  </th>
      <td>
	<input class="input_blur" name="add_time" id="add_time"  size="21" readonly="readonly" type="text"/>&nbsp;
	<script language="javascript" type="text/javascript">
	    datetime = "<?php if(! empty($itemInfo)){ echo date('Y-m-d H:i:s', $itemInfo['add_time']);} ?>";
		date = new Date();
		if (datetime == "" || datetime == null) {
			datetime = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
		}
		document.getElementById ("add_time").value =datetime;
		Calendar.setup({
			inputField     :    "add_time",
			ifFormat       :    "%Y-%m-%d %H:%M:%S",
			showsTime      :    true,
			timeFormat     :    "24"
		});
	</script>
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