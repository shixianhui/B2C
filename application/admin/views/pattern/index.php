<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="70">选中</th>
<th width="50">排序</th>
<th>模型名称</th>
<th>别名</th>
<th>模型文件</th>
<th>类型</th>
<th>状态</th>
<th width="120">发布时间</th>
<th width="120">管理操作</th>
</tr>
<?php if (! empty($itemList)): ?>
<?php foreach ($itemList as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background='#FFFFFF'">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td class="align_c"><input class="input_blur" name="sort[]" id="sort_<?php echo $value['id']; ?>" value="<?php echo $value['sort']; ?>" size="4" type="text"></td>
<td><a href="admincp.php/<?php echo $template; ?>/save/<?php echo $value['id']; ?>" ><font color="<?php echo $value['title_color']; ?>"><?php echo $value['title']; ?></font></a> </td>
<td class="align_c"><?php echo $value['alias']; ?></td>
<td class="align_c"><?php echo $value['file_name']; ?></td>
<td class="align_c"><?php echo $value['type']; ?></td>
<td class="align_c"><?php if ($value['status']){echo '启用';}else{echo '<font color="#FF0000">禁用</font>';}; ?></td>
<td class="align_c"><?php echo date("Y-m-d H:i", $value['add_time']); ?></td>
<td class="align_c">
<a title="复制模型" href="javascript:void(0);" onclick="javascript:copy_pattern('<?php echo $value['id']; ?>');">复制</a>
&nbsp;
<a href="admincp.php/<?php echo $template; ?>/save/<?php echo $value['id']; ?>">修改</a>
<br/>
<label style="line-height: 25px;">
<a title="会删除模型相关的文件与表" href="javascript:void(0);" onclick="javascript:delete_pattern('<?php echo $value['id']; ?>', '<?php echo $value['title']; ?>');">删除数据与文件</a>
</label>
</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div class="button_box">
<span style="width: 60px;"><a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
<a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a></span>
<input style="margin-left: 10px;" class="button_style" name="list_order" id="list_order" value=" 排序 "  type="button">
<input style="margin-left: 10px;" title="不会删除关联文件与模型表" class="button_style" name="delete" id="delete" value=" 只删除数据不删除文件 "  type="button">
</div>