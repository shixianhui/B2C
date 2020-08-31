<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>信息查询</caption>
<tbody>
<tr>
<td class="align_c">
用户ID <input class="input_blur" name="user_id" id="user_id" size="20" type="text">&nbsp;
用户名 <input class="input_blur" name="username" id="username" size="20" type="text">&nbsp;
消费时间 <input class="input_blur" name="inputdate_start" id="inputdate_start" size="10" readonly="readonly" type="text">&nbsp;<script language="javascript" type="text/javascript">
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
<div class="tag_menu" style="width: 99%; margin-top: 10px;">
<ul>
  <li><a href="admincp.php/score/index/1/0/gold" <?php if ($score_type == 'gold') {echo 'class="selected"';} ?>>金象积分</a></li>
  <li><a href="admincp.php/score/index/1/0/silver" <?php if ($score_type == 'silver') {echo 'class="selected"';} ?>>银象积分</a></li>
</ul>
</div>
<div style="border-top:2px solid #99d3fb;" >
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="80">消费时间</th>
<th width="100">用户名</th>
<th width="100">积分</th>
<th width="100">积分余额</th>
<th width="100">类型</th>
<th>描述</th>
</tr>
<?php if (! empty($itemList)): ?>
<?php foreach ($itemList as $key=>$value): ?>
<tr onMouseOver="this.style.backgroundColor='#ECF7FE'" onMouseOut="this.style.background='#FFFFFF'">
<td class="align_c"><?php echo date("Y-m-d H:i", $value['add_time']); ?></td>
<td class="align_c">
<?php echo $value['username']; ?>
<br/>
[ID:<?php echo $value['user_id']; ?>]
</td>
<td class="align_c">
<?php if ($value['score'] > 0) { ?>
<span style="color:#1E88CC; font-size:14px;font-weight:bold;"><?php echo $value['score']; ?></span>
<?php } else { ?>
<span style="color:#FF7B0E; font-size:14px;font-weight:bold;"><?php echo $value['score']; ?></span>
<?php } ?>
</td>
<td class="align_c"><?php echo $value['balance']; ?></td>
<td class="align_c"><?php echo $type_arr[$value['type']]; ?></td>
<td class="align_c"><?php echo $value['cause']; ?></td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
<div id="pages" style="margin-top: 5px;">
<?php echo $pagination; ?>
<a>总条数：<?php echo $paginationCount; ?></a>
<a>总页数：<?php echo $pageCount; ?></a>
</div>
<div style="font-size:14px">
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
  <tr>
    <th class="align_c">类型</th>
    <th class="align_c">条数</th>
    <th class="align_c">积分</th>
  </tr>
  <tr>
    <td class="align_c">收入</td>
    <td class="align_c">&nbsp;<?php echo $count0; ?></td>
    <td class="align_c">&nbsp;<?php echo $sumprice0; ?></td>
  </tr>
  <tr>
    <td class="align_c">支出</td>
    <td class="align_c">&nbsp;<?php echo $count1; ?></td>
    <td class="align_c">&nbsp;<?php echo $sumprice1; ?></td>
  </tr>
  <tr>
    <td class="align_c"><strong>总计</strong></td>
    <td class="align_c"><strong><?php echo ($count0+$count1); ?></strong></td>
    <td class="align_c"><strong><?php echo number_format($sumprice0+$sumprice1, 2, '.', ''); ?></strong></td>
  </tr>
</table>
</div>
</div>
<br/><br/>