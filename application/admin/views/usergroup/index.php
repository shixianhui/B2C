<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="30">选中</th>
<th width="40">ID</th>
<th>会员组名称</th>
<th width="70">管理操作</th>
</tr>
<?php if (! empty($usergroupList)): ?>
<?php foreach ($usergroupList as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"></td>
<td><?php echo $value['id']; ?></td>
<td><a href="admincp.php/usergroup/save/<?php echo $value['id']; ?>" ><?php echo $value['group_name']; ?></a></td>
<td class="align_c"><a href="admincp.php/usergroup/save/<?php echo $value['id']; ?>">修改</a></td>
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
<br/><br/>