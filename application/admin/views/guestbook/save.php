<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<input name="id" value="" type="hidden">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%"><strong>留言类别</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){if($itemInfo['type']){echo '在线留言';}else{echo '客户投诉';}} ?>
	</td>
    </tr>
    <?php if(! empty($itemInfo)){if($itemInfo['type']){ ?>
    <tr>
      <th width="20%"><strong>联系人</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['contact_name'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>电话</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['phone'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>手机</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['mobile'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>QQ号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['qq'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>邮箱</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['email'];} ?>
	</td>
    </tr>
    <?php } else { ?>
    <tr>
      <th width="20%"><strong>会员名ID</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['user_id'];} ?> <a href="admincp.php/user/save/<?php if(! empty($itemInfo)){ echo $itemInfo['user_id'];} ?>">查看详细</a>
	</td>
    </tr>
    <?php }} ?>
    <tr>
      <th width="20%"><strong>留言时间</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo date('Y-m-d H:i', $itemInfo['add_time']);} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>留言内容</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $itemInfo['content']);} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>回复时间</strong> <br/>
	  </th>
      <td>
	<?php if(! empty($itemInfo) && $itemInfo['rep_time']){ echo date('Y-m-d H:i:s', $itemInfo['rep_time']);} ?>
	 </td>
    </tr>
	<tr>
      <th width="20%"> <strong>回复内容</strong> <br/>
	  </th>
      <td>
      <textarea name="rep_content" maxlength="400" id="rep_content" rows="4" cols="30"  class="textarea_style" style="width: 80%;" ><?php if(! empty($itemInfo)){ echo $itemInfo['rep_content'];} ?></textarea>
    </td>
    </tr>
	
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>