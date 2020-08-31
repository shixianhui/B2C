<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>用户名</strong> <br/>
	  </th>
      <td>
      <input class="input_blur" name="username" id="username" value="<?php if(! empty($itemInfo)){ echo $itemInfo['username'];} ?>" <?php if(! empty($itemInfo)){ echo 'readonly="true"';} ?> size="50" maxlength="50" valid="required" errmsg="用户名不能为空!" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>密&nbsp;码</strong> <br/>
	  </th>
      <td>
      <input class="input_blur" name="password" id="password" value="" size="50" maxlength="50" <?php if(empty($itemInfo)){ echo 'valid="required" errmsg="密码不能为空!"';} ?> type="password">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>确认密码</strong> <br/>
	  </th>
      <td>
      <input class="input_blur" name="ref_password" id="ref_password" value="" size="50" maxlength="50" valid="eqaul" eqaulName="password" errmsg="前后密码不一致!" type="password">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>所属部门</strong> <br/>
	  </th>
      <td>
      <input name="select_category_id" id="select_category_id" type="hidden" value="<?php if(! empty($itemInfo)){ echo $itemInfo['admin_group_id'];} ?>" >
      <select class="input_blur" name="admin_group_id" id="category" valid="required" errmsg="请选择部门!">
       <option value="" >请选择部门</option>
       <?php if (! empty($admingroupList)): ?>
       <?php foreach ($admingroupList as $admingroup): ?>
       <option value="<?php echo $admingroup['id'] ?>" ><?php echo $admingroup['group_name'] ?></option>
       <?php endforeach; ?>
       <?php endif; ?>
      </select>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>身份</strong> <br/>
	  </th>
      <td>
      <input type="radio" value="0" name="is_boss" class="radio_style" <?php if($itemInfo){if($itemInfo['is_boss']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 员工
      <input type="radio" value="1" name="is_boss" class="radio_style" <?php if($itemInfo){if($itemInfo['is_boss']=='1'){echo 'checked="checked"';}} ?> > 部门经理&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">注:部门经理能看到部门里所有的数据</font>
	</td>
	</tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>昵&nbsp;&nbsp;称</strong> <br/>
	  </th>
      <td>
     <input class="input_blur" name="nickname" id="nickname" value="<?php if(! empty($itemInfo)){ echo $itemInfo['nickname'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>真实姓名</strong> <br/>
	  </th>
      <td>
     <input class="input_blur" name="real_name" id="real_name" value="<?php if(! empty($itemInfo)){ echo $itemInfo['real_name'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>QQ号</strong> <br/>
	  </th>
      <td>
     <input class="input_blur" name="qq_number" id="qq_number" value="<?php if(! empty($itemInfo)){ echo $itemInfo['qq_number'];} ?>" size="50" valid="isQQ" errmsg="QQ号格式错误!" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>邮&nbsp;&nbsp;件</strong> <br/>
	  </th>
      <td>
     <input class="input_blur" name="email" id="email" value="<?php if(! empty($itemInfo)){ echo $itemInfo['email'];} ?>" size="50" type="text">
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