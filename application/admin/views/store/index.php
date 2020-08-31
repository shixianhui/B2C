<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="70">选中</th>
<th width="50">排序</th>
<th width="150">店主用户名|店主姓名</th>
<th>店铺名称</th>
<th width="150">所在地</th>
<th width="100">店铺等级</th>
<th width="80">有效期至</th>
<th width="80">状态</th>
<th width="70">管理操作</th>
</tr>
<?php if (! empty($item_list)): ?>
<?php foreach ($item_list as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td class="align_c"><input class="input_blur" name="sort[]" id="sort_<?php echo $value['id']; ?>" value="<?php echo $value['sort']; ?>" size="4" type="text"></td>
<td class="align_c"><?php echo $value['username']; ?>|<?php echo $value['owner_name']; ?></td>
<td><?php echo $value['store_name']; ?></td>
<td class="align_c"><?php echo str_replace(' ', '', $value['txt_address']); ?></td>
<td class="align_c"><?php echo $value['grade_name']; ?></td>
<td class="align_c"><?php if ($value['end_time']) { echo date('Y-m-d', $value['end_time']);}else{echo '无限制';} ?></td>
<td class="align_c"><?php echo $display_arr[$value['display']]; ?></td>
<td class="align_c"><a href="admincp.php/<?php echo $table; ?>/save/<?php echo $value['id']; ?>">修改</a></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div class="button_box">
<span style="width: 60px;"><a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
<a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a></span>
<input class="button_style" name="list_order" id="list_order" value=" 排序 "  type="button">
<input style="margin-left: 10px;" class="button_style" name="delete" id="delete" value=" 删除 "  type="button">
</div>
<div id="pages">
<?php echo $pagination; ?>
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
</div>
<br/><br/>