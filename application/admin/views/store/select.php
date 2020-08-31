<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="70">选中</th>
<th>店铺名称</th>
<th width="150">所在地</th>
<th width="100">店铺等级</th>
<th width="80">有效期至</th>
</tr>
<?php if (! empty($item_list)): ?>
<?php foreach ($item_list as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input onclick="javascript:select_store('<?php echo $value['id']; ?>', '<?php echo $value['store_name']; ?>');"  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="radio"> <?php echo $value['id']; ?></td>
<td class="align_c"><?php echo $value['store_name']; ?></td>
<td class="align_c"><?php echo str_replace(' ', '', $value['txt_address']); ?></td>
<td class="align_c"><?php echo $value['grade_name']; ?></td>
<td class="align_c"><?php if ($value['end_time']) { echo date('Y-m-d', $value['end_time']);}else{echo '无限制';} ?></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div id="pages">
<?php echo $pagination; ?>
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
</div>
<br/><br/>
<script type="text/javascript">
function select_store(id, store_name) {
	window.opener.document.getElementById("store_id").value=id;
	window.opener.document.getElementById("span_store_name").innerHTML = store_name;
        $(window.opener.document.getElementById("clickHere")).click();
	window.close();
}
</script>