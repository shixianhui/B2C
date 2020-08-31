<form name="search" method="post" action="admincp.php/user/select/1/<?php echo $type; ?>/0" >
<table style="margin-top:5px;" class="table_form" cellpadding="0" cellspacing="1">
<tbody>
<tr>
<td class="align_c">
编号 <input class="input_blur" name="id" id="id" size="10" type="text">&nbsp;
用户名 <input class="input_blur" name="username" id="username" size="10" type="text">&nbsp;
昵称 <input class="input_blur" name="nickname" id="nickname" size="20" type="text">&nbsp;
姓名 <input class="input_blur" name="real_name" id="real_name" size="10" type="text">&nbsp;
手机 <input class="input_blur" name="mobile" id="mobile" size="10" type="text">&nbsp;
<input class="button_style" name="dosubmit" value=" 查询 " type="submit">
</td>
</tr>
</tbody></table>
</form>
<table style="margin-top:5px;" class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<tbody>
<tr class="mouseover">
<th width="80">编号</th>
<th width="100">用户名</th>
<th width="100">昵称</th>
<th width="100">姓名</th>
<th width="100">手机号</th>
</tr>
<?php if (! empty($itemList)): ?>
<?php foreach ($itemList as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background='#FFFFFF'">
<td><input onclick="javascript:selectUser('<?php echo $value['id']; ?>', '<?php echo $value['username']; ?>', '<?php echo $value['real_name']; ?>', '<?php echo $value['nickname']; ?>');"  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="radio"> <?php echo $value['id']; ?></td>
<td class="align_c"><?php echo $value['username']; ?></td>
<td class="align_c"><?php echo $value['nickname']; ?></td>
<td class="align_c"><?php echo $value['real_name']; ?></td>
<td class="align_c"><?php echo $value['mobile']; ?></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div id="pages">
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
<?php echo $pagination; ?>
</div>
<script type="text/javascript">
function selectUser(userId, username, real_name, nickname) {
	window.opener.document.getElementById("to_user_id").value=userId;
	window.opener.document.getElementById("to_username").value=username;
	window.opener.document.getElementById("span_to_username").innerHTML = username;
	window.opener.document.getElementById("span_real_name").innerHTML = real_name;
	window.opener.document.getElementById("span_nickname").innerHTML = nickname;
	window.close();
}
</script>