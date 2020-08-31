<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">订单号 <input class="input_blur" name="order_number" id="order_number" size="20" type="text">&nbsp;
<select class="input_blur" name="status">
<option value="">选择状态</option>
<option value="0">待处理</option>
<option value="1">审核未通过</option>
<option value="2">审核通过</option>
</select>&nbsp;
发布时间 <input class="input_blur" name="inputdate_start" id="inputdate_start" size="10" readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
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
<th width="150">退换货订单号</th>
<th>服务类型</th>
<th width="150">申请时间</th>
<th width="150">状态</th>
<th width="150">是否收到用户退货</th>
<th width="100">管理操作</th>
</tr>
<?php if (! empty($itemList)): ?>
<?php foreach ($itemList as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background='#FFFFFF'">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox"> <?php echo $value['id']; ?></td>
<td><a href="admincp.php/<?php echo $table; ?>/save/<?php echo $value['id']; ?>" ><?php echo $value['order_number']; ?></a></td>
<td class="align_c">
    <?php echo $exchange_type[$value['exchange_type']]; ?>
</td>
<td class="align_c"><?php echo date("Y-m-d H:i", $value['add_time']); ?></td>
<td class="align_c"><?php if($value['status'] == 0){echo '<font color="#FF0000">待审核</font>';}else if($value['status'] == 1){echo '审核未通过';}else if($value['status'] == 2){echo '审核通过';} ?></td>
<td class="align_c">
    <?php
     if($value['exchange_type']==1 || $value['exchange_type']==2){
    ?>
    <?php if($value['seller_recieve_goods'] == 0){echo '<font color="#FF0000">未收到货</font>';}else if($value['seller_recieve_goods'] == 1){echo '收到货';}?>
     <?php }?>
</td>
<td class="align_c"><a href="admincp.php/<?php echo $table; ?>/save/<?php echo $value['id']; ?>">处理</a></td>
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
<br/><br/>