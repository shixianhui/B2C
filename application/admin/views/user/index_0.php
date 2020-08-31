<?php echo $tool; ?>
<form name="search" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">
编号 <input class="input_blur" name="id" id="id" size="10" type="text">
用户名 <input class="input_blur" name="username" id="username" size="10" type="text">
金象卡号 <input class="input_blur" name="gold_card_num" size="10" type="text">
昵称 <input class="input_blur" name="nickname" id="nickname" size="10" type="text">
姓名 <input class="input_blur" name="real_name" id="real_name" size="10" type="text">
推荐者ID <input class="input_blur" name="presenter_id" id="presenter_id" size="10" type="text">
推荐者 <input class="input_blur" name="presenter_username" id="presenter_username" size="10" type="text">
<select name="category_id">
<option value="">--选择管理组--</option>
<?php if (! empty($usergroupList)): ?>
<?php foreach ($usergroupList as $usergroup): ?>
<option value="<?php echo $usergroup['id'] ?>" ><?php echo $usergroup['group_name'] ?></option>
<?php endforeach; ?>
<?php endif; ?>
</select>
<select class="input_blur" name="display">
<option value="">选择状态</option>
<option value="1">开启</option>
<option value="0">禁用</option>
</select>&nbsp;
添加时间 <input class="input_blur" name="inputdate_start" id="inputdate_start" size="10" readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
					date = new Date();
					Calendar.setup({
						inputField     :    "inputdate_start",
						ifFormat       :    "%Y-%m-%d",
						showsTime      :    false,
						timeFormat     :    "24"
					});
				 </script> - <input class="input_blur" name="inputdate_end"
id="inputdate_end" size="10"  readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
					date = new Date();
					Calendar.setup({
						inputField     :    "inputdate_end",
						ifFormat       :    "%Y-%m-%d",
						showsTime      :    false,
						timeFormat     :    "24"
					});
				 </script>&nbsp;
<input class="button_style" name="dosubmit" value=" 查询 " type="submit">
</td>
</tr>
</tbody>
</table>
</form>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="70">选中</th>
<th>用户名</th>
<th width="100">会员级别</th>
<th width="80">真实姓名</th>
<th width="80">昵称</th>
<th width="80">手机</th>
<th width="80">卡号</th>
<th width="60">账户余额</th>
<th width="60">金象积分</th>
<th width="60">银象积分</th>
<th width="80">推荐人数</th>
<th width="80">推荐者</th>
<th width="60">状态</th>
<th width="80">邀请码</th>
<th width="80">添加时间</th>
<th width="70">管理操作</th>
</tr>
<?php if (! empty($userList)): ?>
<?php foreach ($userList as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td>
<a title="查看详情" href="admincp.php/user/view/<?php echo $value['id']; ?>" >
<?php
if ($value['username']) {
	echo $value['username'];
} else {
    if ($value['wx_unionid']) {
    	echo '微信登录';
    } else if ($value['wb_uid']) {
    	echo '微博登录';
    } else if ($value['qq_unionid']) {
    	echo 'QQ登录';
    }
}
?> [查看]</a>
</td>
<td class="align_c"><?php echo $value['group_name']; ?></td>
<td class="align_c"><?php echo $value['real_name']; ?></td>
<td class="align_c"><?php echo $value['nickname']; ?></td>
<td class="align_c"><?php echo $value['mobile']; ?></td>
<td class="align_c"><?php echo $value['gold_card_num']; ?></td>
<td class="align_c"><?php echo $value['total']; ?></td>
<td class="align_c"><?php echo $value['score_gold']; ?></td>
<td class="align_c"><?php echo $value['score_silver']; ?></td>
<td class="align_c"><?php echo $value['presenter_count']; ?></td>
<td class="align_c"><?php if ($value['presenter_username']) { echo $value['presenter_username']."[{$value['presenter_id']}]";}else{echo '---';} ?></td>
<td class="align_c"><?php echo $value['display']?'开启':'<font color="#FF0000">禁用</font>'; ?></td>
<td class="align_c"><?php echo $value['pop_code']; ?></td>
<td class="align_c"><?php echo date('Y-m-d H:i:s', $value['add_time']); ?></td>
<td class="align_c">
<a href="admincp.php/financial/recharge/<?php echo $value['id']; ?>">充值</a>
<a href="admincp.php/financial/debit/<?php echo $value['id']; ?>">扣款</a><br/>
<a href="admincp.php/financial/index/1/<?php echo $value['id']; ?>">财务</a>
<a href="admincp.php/user/save/<?php echo $value['id']; ?>">修改</a>
</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div class="button_box">
<span style="width: 60px;"><a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
<a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a></span>
<input class="button_style" name="delete" id="delete" value=" 删除 "  type="button">
<select class="input_blur" name="select_display" id="select_display" onchange="#">
<option value="">选择状态</option>
<option value="1">开启</option>
<option value="0">禁用</option>
</select>
</div>
<div id="pages" style="margin-top: 5px;">
<?php echo $pagination; ?>
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
</div>
<br/><br/>