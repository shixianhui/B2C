<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>积分设置管理</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>每天签到送</strong> <br/>
	  </th>
      <td>
      <input name="login_score" id="login_score" value="<?php if($itemInfo){echo $itemInfo['login_score'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个银象积分</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>新用户注册送</strong> <br/>
	  </th>
      <td>
      <input name="reg_score" id="reg_score" value="<?php if($itemInfo){echo $itemInfo['reg_score'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个银象积分</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>推广成功一个会员送</strong> <br/>
	  </th>
      <td>
      <input name="join_user_score" id="join_user_score" value="<?php if($itemInfo){echo $itemInfo['join_user_score'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个银象积分</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>推广成功一个商家送</strong> <br/>
	  </th>
      <td>
      <input name="join_seller_score" id="join_seller_score" value="<?php if($itemInfo){echo $itemInfo['join_seller_score'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个银象积分</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>一元可以兑换</strong> <br/>
	  </th>
      <td>
      1元 = <input name="rmb_to_score_gold" id="rmb_to_score_gold" value="<?php if($itemInfo){echo $itemInfo['rmb_to_score_gold'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个金象积分</font>
	</td>
	</tr>
	<tr>
      <th width="20%">
      <strong>一元可以兑换</strong> <br/>
	  </th>
      <td>
      1元 = <input name="rmb_to_score_silver" id="rmb_to_score_silver" value="<?php if($itemInfo){echo $itemInfo['rmb_to_score_silver'];} ?>" size="10"  class="input_blur" type="text"> <font color="red">个银象积分</font>
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