<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>服务协议</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>推广活动是否开启</strong> <br/>
	  </th>
      <td>
      <input type="radio" value="0" name="presenter_is_open" class="radio_style" <?php if($itemInfo){if($itemInfo['presenter_is_open']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 关闭
      <input type="radio" value="1" name="presenter_is_open" class="radio_style" <?php if($itemInfo){if($itemInfo['presenter_is_open']=='1'){echo 'checked="checked"';}} ?> > 开启
	  <font color="red">注：1、城市合伙人、店级合伙人购买商品不产生分成；2、只有顾客的购买产生分成；</font>
	</td>
	</tr>
 	<tr>
      <th width="20%">
      <strong>推广页面介绍[城市合伙人]</strong> <br/>
      <font color="red">注：当用户为城市合伙人时显示</font>
	  </th>
      <td>
<?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
<script id="parent_presenter_text" name="parent_presenter_text" type="text/plain" style="width:800px;height:200px;"><?php if(! empty($itemInfo)){ echo html($itemInfo["parent_presenter_text"]);}else{echo "";} ?></script>
<script type="text/javascript">
    UE.getEditor('parent_presenter_text');
</script>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>推广页面介绍[店级合伙人]</strong> <br/>
      <font color="red">注：当用户为店级合伙人时显示</font>
	  </th>
      <td>
<script id="sub_presenter_text" name="sub_presenter_text" type="text/plain" style="width:800px;height:200px;">
<?php if(! empty($itemInfo)){ echo html($itemInfo["sub_presenter_text"]);}else{echo "";} ?>
</script>
<script type="text/javascript">
    UE.getEditor('sub_presenter_text');
</script>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>店级合伙人加盟</strong>[手机上展示]<br/>
	  </th>
      <td>
<script id="presenter_city_text" name="presenter_city_text" type="text/plain" style="width:800px;height:200px;">
<?php if(! empty($itemInfo)){ echo html($itemInfo["presenter_city_text"]);}else{echo "";} ?>
</script>
<script type="text/javascript">
    UE.getEditor('presenter_city_text');
</script>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>顾客入驻</strong>[手机上展示]<br/>
	  </th>
      <td>
<script id="presenter_store_text" name="presenter_store_text" type="text/plain" style="width:800px;height:200px;">
<?php if(! empty($itemInfo)){ echo html($itemInfo["presenter_store_text"]);}else{echo "";} ?>
</script>
<script type="text/javascript">
    UE.getEditor('presenter_store_text');
</script>
	</td>
	</tr>
	<tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  </td>
    </tr>
   </tbody>
</table>
</form>
<br/><br/>