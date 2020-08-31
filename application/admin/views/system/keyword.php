<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>搜索关键词</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>搜索框里关键词</strong> <br/>
	  </th>
      <td>
      <input name="text_keyword" id="text_keyword" value="<?php if($itemInfo){echo $itemInfo['text_keyword'];} ?>" size="80"  class="input_blur" type="text">
	</td>
	</tr>
    <tr>
      <th width="20%">
      <strong>搜索框后面关键词</strong> <br/>
	  </th>
      <td>
      <input name="link_keyword" id="link_keyword" value="<?php if($itemInfo){echo $itemInfo['link_keyword'];} ?>" size="80"  class="input_blur" type="text"> <font color="red">注:以"|"分隔，设置多个关键词，如"a|b|c"</font>
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