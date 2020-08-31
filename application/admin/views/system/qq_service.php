<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>在线客服</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>全站QQ在线客服</strong> <br/>
	  </th>
      <td>
    <?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
<script id="globle_qq_service" name="globle_qq_service" type="text/plain" style="width:800px;height:200px;"><?php if(! empty($itemInfo)){ echo html($itemInfo["globle_qq_service"]);}else{echo "";} ?></script>
<script type="text/javascript">
    UE.getEditor('globle_qq_service');
</script>
	</td>
	</tr>
    <tr>
      <th width="20%">
      <strong>单页面左侧在线客服</strong> <br/>
	  </th>
      <td>
     <script id="left_qq_service" name="left_qq_service" type="text/plain" style="width:800px;height:200px;">
<?php if(! empty($itemInfo)){ echo html($itemInfo["left_qq_service"]);}else{echo "";} ?>
</script>
<script type="text/javascript">
    UE.getEditor('left_qq_service');
</script>
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