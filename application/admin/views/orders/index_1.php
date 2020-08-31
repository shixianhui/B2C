<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">
订单编号 <input class="input_blur" name="order_number" id="order_number" size="20" type="text">&nbsp;
收货人姓名 <input class="input_blur" name="buyer_name" id="buyer_name" size="20" type="text">&nbsp;
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
<th width="80">选中</th>
<th width="80">订单编号</th>
<th width="80">收货人信息</th>
<th>订单描述</th>
<th width="120">总金额</th>
<th width="80">下单时间</th>
<th width="80">订单状态</th>
<th width="100">管理操作</th>
</tr>
<?php if (! empty($item_list)): ?>
<?php foreach ($item_list as $key=>$value): ?>
<tr id="id_<?php echo $value['id']; ?>"  onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background=''">
<td><input  class="checkbox_style" name="ids" value="<?php echo $value['id']; ?>" type="checkbox">  <?php echo $value['id']; ?></td>
<td class="align_c">
    <?php echo $value['order_number']; ?><br/>
    <?php echo $value['pay_mode']?'<font color="red">[积分换购]</font>':''; ?>
</td>
<td class="align_c" title="<?php echo clearstring($value['address']); ?>"><?php echo my_substr($value['address'], 4); ?><br/><?php echo $value['buyer_name']; ?></td>
<td class="align_c">
<table  width="100%" cellpadding="0" cellspacing="1">
<?php if ($value['orderdetailList']) { ?>
<?php foreach ($value['orderdetailList'] as $key=>$orderdetail) {
	  $strClass = 'table_td';
      if ($key+1 == count($value['orderdetailList'])) {
          $strClass = '';
      }
	?>
<tr>
<td class="align_c" width="60" class="<?php echo $strClass; ?>">
<img src="<?php if ($orderdetail['path']){ echo preg_replace('/\./', '_thumb.', $orderdetail['path']);;}else{echo 'images/admin/nopic.gif';} ?>" width="50px" height="50px" />
</td>
<td class="<?php echo $strClass; ?>">
<span><?php echo $orderdetail['product_title']; ?></span><br/>
<span style="color: #999;">产品编号：<?php echo $orderdetail['product_num']; ?></span><br/>
<?php if ($orderdetail['color_size_open']) { ?>
<span style="color: #999;"><?php echo $orderdetail['product_color_name']; ?>：<?php echo $orderdetail['color_name']; ?> <?php echo $orderdetail['product_size_name']; ?>：<?php echo $orderdetail['size_name']; ?></span>
<?php } ?>
</td>
<td class="<?php echo $strClass; ?>" style="width: 60px;text-align:center;" title="单价">¥<?php echo number_format($orderdetail['buy_price'], 2, '.', ''); ?></td>
<td class="<?php echo $strClass; ?>" style="width: 40px;text-align:center;" title="换购积分"><?php echo $orderdetail['consume_score']; ?></td>
<td class="<?php echo $strClass; ?>" style="width: 20px;text-align:center;" title="购买数量"><?php echo $orderdetail['buy_number']; ?></td>
</tr>
<?php }} ?>
</table>
</td>
<td class="align_c">
<?php if ($value['pay_mode']) { ?>
<span class="priceColor">¥<?php echo $value['total']; ?></span>+<span class="priceColor" title="换购所需积分"><?php echo $value['deductible_score']; ?>积分</span><br/>
<?php } else { ?>
<span class="priceColor">¥<?php echo $value['total']; ?></span><br/>
<?php } ?>
<?php if ($value['postage_price'] > 0) { ?>
(含运费：¥<?php echo $value['postage_price']; ?>)
<?php } else { ?>
(免运费)
<?php } ?>
</td>
<td class="align_c"><?php echo date("Y-m-d H:i", $value['add_time']); ?></td>
<td class="align_c"><?php echo $status_arr[$value['status']]; ?></td>
<td class="align_c">
<span style="line-height:25px;"><a onclick="javascript:delivery(<?php echo $value['id']; ?>,'<?php echo $value['order_number']; ?>','<?php echo date('Y-m-d H:i:s', $value['add_time']); ?>','<?php echo $value['total']; ?>');" href="javascript:void(0);">发货</a></span><br/>
<span style="line-height:25px;"><a href="admincp.php/<?php echo $table; ?>/view/<?php echo $value['id']; ?>">详情</a></span>
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
</div>
<div id="pages" style="margin-top: 5px;">
<?php echo $pagination; ?>
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
</div>
<br/><br/>
<script  type="text/javascript">
//发货
function delivery(id, order_num, add_time, total) {
	var html = '<table class="table_form" cellpadding="0" cellspacing="1">';
		html += '<tr><th width="25%"><strong>订单编号</strong> <br/></th>';
		html += '<td>'+order_num+'</td></tr>';
		html += '<tr><th width="25%"><strong>下单时间</strong> <br/></th>';
		html += '<td>'+add_time+'</td></tr>';
		html += '<tr><th width="25%"><strong>订单金额</strong> <br/></th>';
		html += '<td>'+total+'元</td></tr>';
		html += '<tr><th width="25%"> <strong>快递名称</strong> <br/></th>';
		html += '<td>';
		html += '<input id="delivery_name" size="20" class="input_blur" type="text" />';
		html += '</td>';
		html += '</tr>';
		html += '<tr><th width="25%"> <strong>快递单号</strong> <br/></th>';
		html += '<td>';
		html += '<input id="express_number" size="20" class="input_blur" type="text" />';
		html += '</td>';
		html += '</tr>';
		html += '<tr><th width="25%"> <strong>备注</strong> <br/></th>';
		html += '<td>';
		html += '<textarea id="remark" placeholder="请输入备注" rows="4" cols="35"  class="textarea_style"></textarea>';
		html += '</td>';
		html += '</tr>';
		html += '</table>';
	var d = dialog({
		width:400,
		fixed: true,
	    title: '修改订单状态提示',
	    content: html,
	    okValue: '确认',
	    ok: function () {
		    var delivery_name = $('#delivery_name').val();
		    var express_number = $('#express_number').val();
		    var remark = $('#remark').val();
		    if (!delivery_name) {
		    	return my_alert('delivery_name', 1, '请输入快递名称');
			}
		    if (!express_number) {
		    	return my_alert('express_number', 1, '请输入快递单号');
			}
	        $.post(base_url+"admincp.php/"+controller+"/delivery",
    				{	"id": id,
				        "delivery_name":delivery_name,
				        "express_number":express_number,
				        "remark":remark
    				},
    				function(res){
    					if(res.success){
                            return my_alert_flush('fail', 0, res.message);
    					} else {
        					if (res.field == 'fail') {
        						return my_alert('fail', 0, res.message);
            				} else {
            					return my_alert(res.field, 1, res.message);
                		    }
    					}
    				},
    				"json"
    		);
		    return false;
	    },
	    cancelValue: '取消',
	    cancel: function () {
	    }
	});
	d.show();
}
</script>