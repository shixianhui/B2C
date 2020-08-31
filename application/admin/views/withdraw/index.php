<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">
会员用户名 <input class="input_blur" name="username" id="username" size="15" type="text">&nbsp;
会员ID <input class="input_blur" name="user_id" id="user_id" size="15" type="text">&nbsp;
户名 <input class="input_blur" name="real_name" id="real_name" size="15" type="text">&nbsp;
账号 <input class="input_blur" name="account" id="account" size="15" type="text">&nbsp;
<select class="input_blur" name="type" id="type">
<option value="">--选择账号类型--</option>
<?php if ($type_arr) { ?>
<?php foreach ($type_arr as $key=>$value) { ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php }} ?>
</select>&nbsp;
<select class="input_blur" name="display">
<option value="">--选择处理状态--</option>
<?php if ($display_arr) { ?>
<?php foreach ($display_arr as $key=>$value) { ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php }} ?>
</select>&nbsp;
申请时间 <input class="input_blur" name="inputdate_start" id="inputdate_start" size="10" readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
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
<th  width="80">申请时间</th>
<th width="80">会员信息</th>
<th width="80">会员类型</th>
<th width="80">账号类型</th>
<th width="80">户名</th>
<th width="120">账号</th>
<th width="100">提现金额(元)</th>
<th>描述</th>
<th width="80">状态</th>
<th width="80">处理时间</th>
<th width="70">操作</th>
</tr>
<?php if (! empty($itemList)): ?>
<?php foreach ($itemList as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background='#FFFFFF'">
<td class="align_c"><?php echo $value['id']; ?></td>
<td class="align_c"><?php echo date('Y-m-d H:i', $value['add_time']); ?></td>
<td class="align_c"><?php echo $value['username']; ?><br/>(ID:<?php echo $value['user_id']; ?>)</td>
<td class="align_c"><?php echo $user_type_arr[$value['user_type']]; ?></td>
<td class="align_c"><?php echo $type_arr[$value['type']]; ?></td>
<td class="align_c"><?php echo $value['real_name']; ?></td>
<td class="align_c"><?php echo $value['account']; ?></td>
<td class="align_c" style="font-size:14px;color:#fe5500;"><?php echo $value['price']; ?></td>
<td class="align_c">
提<?php echo floatval($value['score_num']); ?><?php echo $score_type_arr[$value['score_type']]; ?>兑换<?php echo $value['price']; ?>元</td>
<td class="align_c"><?php echo $display_arr[$value['display']]; ?></td>
<td class="align_c"><?php if ($value['rep_time']){ echo date('Y-m-d H:i', $value['rep_time']);}else{echo '----';} ?></td>
<td class="align_c"><a href="admincp.php/<?php echo $table; ?>/save/<?php echo $value['id']; ?>">处理</a></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div class="button_box">
&nbsp;
</div>
<div id="pages">
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
<?php echo $pagination; ?>
</div>