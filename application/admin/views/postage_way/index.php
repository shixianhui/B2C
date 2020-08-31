<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="70">选中</th>
<th width="50">排序</th>
<th width="100">配送方式名称</th>
<th>配送范围及价格</th>
<th width="50">状态</th>
<th width="70">管理操作</th>
</tr>
<?php if (! empty($item_list)): ?>
<?php foreach ($item_list as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td class="align_c"><input class="input_blur" name="sort[]" id="sort_<?php echo $value['id']; ?>" value="<?php echo $value['sort']; ?>" size="4" type="text"></td>
<td><?php echo $value['title']; ?></td>
<td>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<tr>
<th width="10%">运费</th>
<th>运送到</th>
<th width="15%">每多一件宝贝</th>
</tr>
<?php if ($value['postagepriceList']): ?>
<?php foreach ($value['postagepriceList'] as $postagePrice): ?>
<tr>
<td><?php echo number_format($postagePrice['start_price'], 1, '.', ''); ?>元</td>
<td><?php echo $postagePrice['area']; ?></td>
<td>+<?php echo number_format($postagePrice['add_price'], 1, '.', ''); ?>元</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</table>
</td>
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
<input style="margin-left: 10px;" class="button_style" name="list_order" id="list_order" value=" 排序 "  type="button">
<input style="margin-left: 10px;" class="button_style" name="delete" id="delete" value=" 删除 "  type="button">
<select class="input_blur" name="select_display" id="select_display">
<option value="">选择状态</option>
<?php if ($display_arr) { ?>
<?php foreach ($display_arr as $key=>$value) { ?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php }} ?>
</select>
</div>
<br/><br/>