<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">
留言类别 <select name="type">
	 <option value="">请选择类别</option>
	 <option value="0">客户投诉</option>
	 <option value="1">在线留言</option>
	</select>&nbsp;
会员名ID <input class="input_blur" name="user_id" size="20" type="text">&nbsp;
联系方式 <input class="input_blur" name="title" size="20" type="text">&nbsp;
留言时间 <input class="input_blur" name="inputdate_start" id="inputdate_start" size="10" readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
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
<th width="100">留言类别</th>
<th width="100">会员名ID</th>
<th width="200">联系方式</th>
<th width="120">留言时间</th>
<th>留言内容</th>
<th width="120">回复时间</th>
<th>回复内容</th>
<th width="70">管理操作</th>
</tr>
<?php if (! empty($itemList)): ?>
<?php foreach ($itemList as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background='#FFFFFF'">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td class="align_c"><?php if ($value['type']){ echo '在线留言';}else{echo '客户投诉';} ?></td>
<td class="align_c"><?php if ($value['user_id']){ echo "<a href='admincp.php/user/save/{$value['user_id']}' title='查看详细'>{$value['user_id']}</a>";}else{echo '---';} ?></td>
<td>
<?php if ($value['type']) { ?>
联系人：<?php echo $value['contact_name']; ?><br/>
电话：<?php echo $value['phone']; ?><br/>
手机：<?php echo $value['mobile']; ?><br/>
QQ号：<?php echo $value['qq']; ?><br/>
邮箱：<?php echo $value['email']; ?>
<?php } else { ?>
---
<?php } ?>
</td>
<td class="align_c"><?php echo date("Y-m-d H:i", $value['add_time']); ?></td>
<td><?php echo html($value['content']); ?></td>
<td class="align_c"><?php if($value['rep_time']) { echo date("Y-m-d H:i", $value['rep_time']);} ?></td>
<td><?php echo html($value['rep_content']); ?></td>
<td class="align_c"><a href="admincp.php/<?php echo $table; ?>/save/<?php echo $value['id']; ?>">回复</a></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div class="button_box">
<span style="width: 60px;"><a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
<a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a></span>
<input class="button_style" name="delete" id="delete" value=" 删除 "  type="button">
</div>
<div id="pages" style="margin-top: 5px;">
<?php echo $pagination; ?>
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
</div>