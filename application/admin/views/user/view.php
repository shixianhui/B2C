<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <strong>用户名</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($userInfo)){ echo $userInfo['username'];} ?>
      <input onclick="javascript:window.location.href='<?php echo base_url().'admincp.php/user/save/'.$id; ?>';" class="button_style" name="back" value=" 修改当前信息 " type="button">
	  </td>
	   <th width="20%">
	   <?php if ($userInfo) { ?>
	   <?php if($userInfo['distributor'] == 0 || $userInfo['school_distributor'] == 0 || $userInfo['net_distributor'] == 0) {  ?>
	   <strong>推荐人</strong> <br/>
	   <?php } else { ?>
	   <strong>上级分销商</strong> <br/>
	   <?php }} ?>
	  </th>
      <td>
     <?php if(! empty($userInfo) && ($userInfo['presenter_username'] || $userInfo['presenter_id'])){ echo $userInfo['presenter_username']."[ID＝{$userInfo['presenter_id']}]";}else{echo '--';} ?>
     <?php if ($userInfo && $userInfo['presenter_id']){ ?><a href="admincp.php/user/view/<?php if ($userInfo){ echo $userInfo['presenter_id'];} ?>">查看</a><?php } ?>
     </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>会员组</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($userInfo)){ echo $userInfo['group_name'];} ?>
	  </td>
	  <th width="20%">
      <strong>会员类型</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['user_type']==1?'商家['.$seller_grade_arr[$userInfo['seller_grade']].']':'会员';} ?>
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>昵称</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['nickname'];} ?>
	</td>
	<th width="20%">
      <strong>真实姓名</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($userInfo)){ echo $userInfo['real_name'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>QQ号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($userInfo)){ echo $userInfo['qq_number'];} ?>
	</td>
	<th width="20%"> <strong>旺旺号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($userInfo)){ echo $userInfo['wangwang_number'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>邮件</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($userInfo)){ echo $userInfo['email'];} ?>
	</td>
	<th width="20%"> <strong>手机号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($userInfo)){ echo $userInfo['mobile'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>固定电话</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($userInfo)){ echo $userInfo['phone'];} ?>
	</td>
	<th width="20%"> <strong>邮编</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($userInfo)){ echo $userInfo['zip'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>账户余额</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($userInfo)){ echo $userInfo['total'];} ?>
	</td>
	<th> <strong>邀请码</strong> <br/>
	  </th>
      <td colspan="3">
      <?php if(! empty($userInfo)){ echo $userInfo['pop_code'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>金象积分</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['score_gold'];} ?>
	</td>
	<th width="20%"> <strong>金象币余额</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['total_gold'];} ?>
     [兑换比例：<?php if(! empty($userInfo)){ echo $userInfo['total_gold_rmb_pre'];} ?>金象币=1元]
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>银象积分</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['score_silver'];} ?>
	</td>
	<th width="20%"> <strong>银象币余额</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['total_silver'];} ?>
     [兑换比例：<?php if(! empty($userInfo)){ echo $userInfo['total_silver_rmb_pre'];} ?>银象币=1元]
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>最后登录时间</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo date('Y-m-d H:i:s', $userInfo['login_time']);} ?>
	</td>
	<th width="20%"> <strong>最后登录IP</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['ip_address'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>地域信息</strong> <br/>
	  </th>
      <td colspan="3">
      <?php if(! empty($userInfo)){ echo $userInfo['txt_address'];} ?>
      <?php if(! empty($userInfo)){ echo $userInfo['address'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>金象卡号</strong> <br/>
	  </th>
      <td colspan="3">
      <?php if(! empty($userInfo)){ echo $userInfo['gold_card_num'];} ?>
	</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">
	  <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="back" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>