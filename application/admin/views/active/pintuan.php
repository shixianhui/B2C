<?php echo $tool; ?>
<link href="css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<script src="js/admin/jquery.datetimepicker.js" type="text/javascript"></script>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>积分兑换(此功能只开启积分兑换功能，哪些商品参与此活动，请到“产品管理”设置)</caption>
 	<tbody>
            <tr>
      <th width="20%">
      <strong>拼团活动开始时间</strong> <br/>
        </th>
      <td>
      <input name="pintuan_start" id="pintuan_start" value="<?php if($itemInfo){ echo date('Y-m-d H:i',$itemInfo['pintuan_start']);}?>" size="30"  class="input_blur" type="text" valid="required" errmsg="不能为空">
      <script language="javascript" type="text/javascript">
			$('#pintuan_start').datetimepicker({
                                datepicker:true,
                                format:'Y-m-d H:i',
                                step:10
                        });
				 </script>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>拼团活动结束时间</strong> <br/>
	  </th>
      <td>
      <input name="pintuan_end" id="pintuan_end" value="<?php if($itemInfo){ echo date('Y-m-d H:i',$itemInfo['pintuan_end']);}?>" size="30"  class="input_blur" type="text" valid="required" errmsg="不能为空">
	<script language="javascript" type="text/javascript">
			$('#pintuan_end').datetimepicker({
                                datepicker:true,
                                format:'Y-m-d H:i',
                                step:10
                        });
				 </script>
      </td>
	</tr>
        <tr>
      <th width="20%">
      <strong>拼团折扣</strong> <br/>
	  </th>
      <td>
          拼团每满 <input type="text" name="pintuan_number" value="<?php if($itemInfo){ echo $itemInfo['pintuan_number'];}?>" valid="required|isInt" errmsg="人数不能为空|人数为整数" size="10"> 人减 <input type="text" name="pintuan_minus"  size="10" valid="required|isNumber" errmsg="不能为空|折扣为数字" value="<?php if($itemInfo){ echo $itemInfo['pintuan_minus'];}?>"> 元 <font color="red"></font>
	</td>
	</tr>
        <tr>
      <th width="20%">
      <strong>是否开启拼团活动</strong> <br>
	  </th>
      <td>
      <input type="radio" value="0" name="pintuan_open" class="radio_style" <?php if($itemInfo){ echo $itemInfo['pintuan_open']==0 ? 'checked' : '';}?>> 关闭
      <input type="radio" value="1" name="pintuan_open" class="radio_style" <?php if($itemInfo){ echo $itemInfo['pintuan_open']==1 ? 'checked' : '';}?>> 开启
	</td>
	</tr>
	<tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input class="button_style" name="reset" value=" 重置 " type="reset">
	  </td>
    </tr>
   </tbody>
</table>
</form>
<br/><br/>