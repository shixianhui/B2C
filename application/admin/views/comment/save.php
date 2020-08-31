<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<input name="id" value="" type="hidden">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>会员充值</caption>
 	<tbody>
 	<tr>
      <th width="20%"><strong>商品名称</strong> <br/>
	  </th>
      <td>
      <?php if ($itemInfo){ echo $itemInfo['product_title'];} ?>
	</td>
    </tr>
    	<tr>
      <th width="20%"><strong>评论人</strong> <br/>
	  </th>
      <td>
          用户名：<?php if ($itemInfo){ echo $itemInfo['username'];} ?><br>
          用户id：<?php if ($itemInfo){ echo $itemInfo['user_id'];} ?><br>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>分数</strong> <br/>
	  </th>
      <td>
      <input name="grade" id="price" size="10" value="<?php if ($itemInfo){ echo $itemInfo['grade'];} ?>" valid="required|isInt" errmsg="分数不能空|分数必须是1-5" class="input_blur" type="text">
      <font color="red">注:分数范围1~5</font>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>评论内容</strong> <br/>
	  </th>
      <td>
      <textarea valid="required" errmsg="评论内容不能为空!" name="content" maxlength="400" id="remark" rows="4" cols="40"  class="textarea_style" style="width: 50%;" ><?php if ($itemInfo){ echo $itemInfo['content'];} ?></textarea>
    </td>
    </tr>
 	<tr>
      <td>
      &nbsp;
      </td>
      <td>
      <input class="button_style" name="dosubmit" value="修改" type="submit">
	</td>
	</tr>
</tbody>
</table>
</form>