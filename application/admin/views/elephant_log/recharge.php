<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<input name="id" value="" type="hidden">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>充值</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>币种类型</strong> <br/>
	  </th>
      <td>
      <?php if ($score_type_arr) { ?>
      <?php foreach ($score_type_arr as $key=>$value) {
            $selector = '';
            if ($key == 'silver') {
            	$selector = 'valid="requireChecked" errmsg="请选择积分类型"';
            }
      	?>
      <input <?php echo $selector; ?> type="radio" value="<?php echo $key; ?>" name="score_type" class="radio_style"> <?php echo $value; ?>
	  <?php }} ?>
	</td>
	</tr>
 	<tr>
      <th width="20%"><strong>充值用户名</strong> <br/>
	  </th>
      <td>
      <input value="<?php if ($userInfo){ echo $userInfo['username'];} ?>" name="username" id="username" size="30" class="input_blur" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>充值用户ID</strong> <br/>
	  </th>
      <td>
      <input value="<?php if ($userInfo){ echo $userInfo['id'];} ?>" name="user_id" id="user_id" size="30" class="input_blur" type="text">
      <font color="red">注:用户名、用户ID填写其中一项即可</font>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>充值数量</strong> <br/>
	  </th>
      <td>
      <input name="score" id="score" size="10" valid="required|isInt" errmsg="充值数量不能为空!|请输入正确的充值数量!" class="input_blur" type="text">
      <font color="red">注:必须大于零</font>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>充值原因</strong> <br/>
	  </th>
      <td>
      <textarea valid="required" errmsg="充值原因不能为空!" name="cause" id="cause" maxlength="400" rows="4" cols="40"  class="textarea_style" style="width: 50%;" ></textarea>
    </td>
    </tr>
 	<tr>
      <td>
      &nbsp;
      </td>
      <td>
      <input class="button_style" name="dosubmit" value=" 确认充值 " type="submit" onclick="javascript:if(confirm('你确定要对用户进行充值吗,请认真核对资料？')){return true}else{return false};" >
	</td>
	</tr>
</tbody>
</table>
</form>