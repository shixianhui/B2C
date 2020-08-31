<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>用户名</strong> <br/>
	  </th>
      <td>
      <?php if ($userInfo) {
      	echo $userInfo['username']?$userInfo['username']:'<font color="red">第三方登录</font>';
      } else { ?>
      <input name="username" id="username" value="<?php if(! empty($userInfo)){ echo $userInfo['username'];} ?>" size="50" maxlength="50" valid="required|isMobile" errmsg="用户名不能为空!|请输入正确的手机号" placeholder="请输入手机号" type="text">
	  <?php } ?>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>密&nbsp;码</strong> <br/>
	  </th>
      <td>
      <input name="password" id="password" value="" size="50" maxlength="50" <?php if(empty($userInfo)){ echo 'valid="required" errmsg="密码不能为空!"';} ?> type="password">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>确认密码</strong> <br/>
	  </th>
      <td>
      <input name="ref_password" id="ref_password" value="" size="50" maxlength="50" valid="eqaul" eqaulName="password" errmsg="前后密码不一致!" type="password">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>会员组</strong> <br/>
	  </th>
      <td>
      <input name="select_category_id" id="select_category_id" type="hidden" value="<?php if(! empty($userInfo)){ echo $userInfo['user_group_id'];} ?>" >
      <select name="user_group_id" id="category" valid="required" errmsg="请选择会员组!">
       <option value="" >请选择会员组</option>
       <?php if (! empty($usergroupList)): ?>
       <?php foreach ($usergroupList as $usergroup): ?>
       <option value="<?php echo $usergroup['id'] ?>" ><?php echo $usergroup['group_name'] ?></option>
       <?php endforeach; ?>
       <?php endif; ?>
      </select>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>会员类型</strong> <br/>
	  </th>
      <td>
      <input onclick="javascript:select_user_type();" type="radio" value="0" name="user_type" class="radio_style" <?php if($userInfo){if($userInfo['user_type']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 会员
      <input onclick="javascript:select_user_type();" type="radio" value="1" name="user_type" class="radio_style" <?php if($userInfo){if($userInfo['user_type']=='1'){echo 'checked="checked"';}} ?> > 商家
	</td>
    </tr>
    <tr style="display: none;" class="seller_grade">
      <th width="20%">
      <strong>商家类别</strong> <br/>
	  </th>
      <td>
      <?php if ($seller_grade_arr) { ?>
      <?php foreach ($seller_grade_arr as $key=>$value) {  ?>
      <input type="radio" value="<?php echo $key; ?>" name="seller_grade" class="radio_style" <?php if($userInfo){if($userInfo['seller_grade'] == $key){echo 'checked="checked"';}} ?> > <?php echo $value; ?>
      <?php }} ?>
      <br/>
      <span style="color: #999;">
1、A类商家，消费者只能使用金象积分消费；
2、BC类商家，消费者可以使用金象积分、银象积分消费；
      </span>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>金象卡号</strong> <br/>
	  </th>
      <td>
     <input name="gold_card_num" id="gold_card_num" value="<?php if(! empty($userInfo)){ echo $userInfo['gold_card_num'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>昵&nbsp;&nbsp;称</strong> <br/>
	  </th>
      <td>
     <input name="nickname" id="nickname" value="<?php if(! empty($userInfo)){ echo $userInfo['nickname'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>真实姓名</strong> <br/>
	  </th>
      <td>
     <input name="real_name" id="real_name" value="<?php if(! empty($userInfo)){ echo $userInfo['real_name'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>QQ号</strong> <br/>
	  </th>
      <td>
     <input name="qq_number" id="qq_number" value="<?php if(! empty($userInfo)){ echo $userInfo['qq_number'];} ?>" size="50" valid="isQQ" errmsg="QQ号格式错误!" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>旺旺号</strong> <br/>
	  </th>
      <td>
     <input name="wangwang_number" id="wangwang_number" value="<?php if(! empty($userInfo)){ echo $userInfo['wangwang_number'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>邮&nbsp;&nbsp;件</strong> <br/>
	  </th>
      <td>
     <input name="email" id="email" value="<?php if(! empty($userInfo)){ echo $userInfo['email'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>手机号</strong> <br/>
	  </th>
      <td>
     <input name="mobile" id="mobile" value="<?php if(! empty($userInfo)){ echo $userInfo['mobile'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>固定电话</strong> <br/>
	  </th>
      <td>
     <input name="phone" id="phone" value="<?php if(! empty($userInfo)){ echo $userInfo['phone'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>邮编</strong> <br/>
	  </th>
      <td>
     <input name="zip" id="zip" value="<?php if(! empty($userInfo)){ echo $userInfo['zip'];} ?>" maxlength="6" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>地域</strong> <br/>
	  </th>
      <td>
      <input id="txt_address" name="txt_address" type="hidden" value="<?php if(! empty($userInfo)){ echo $userInfo['txt_address'];} ?>" />
     <select class="input_blur" id="province_id" name="province_id" onchange="javascript:get_city('province_id','city_id',0,0,1);">
    <option value="">选择省</option>
    <?php if ($item_list) { ?>
    <?php foreach ($item_list as $key=>$value) {
          $selector = '';
          if ($userInfo) {
              if ($userInfo['province_id'] == $value['id']) {
                  $selector = 'selected="selected"';
              }
          }
        ?>
    <option <?php echo $selector; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
    <?php }} ?>
    </select>
    <select class="input_blur" id="city_id" name="city_id" onchange="javascript:get_city('city_id','area_id',0,0,0);">
    <option>选择市</option>
    </select>
    <select onchange="javascript:change_area();" class="input_blur" id="area_id" name="area_id">
    <option>选择区/县</option>
    </select>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>详细地址</strong> <br/>
	  </th>
      <td>
     <input name="address" id="address" value="<?php if(! empty($userInfo)){ echo $userInfo['address'];} ?>" size="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>账户余额</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['total'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>金象积分</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['score_gold'];} ?>
     <span style="margin-left: 10px;color:#999;">注：金象积分可以换购 A、B、C类产品</span>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>银象积分</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['score_silver'];} ?>
     <span style="margin-left: 10px;color:#999;">注：银象积分可以换购 B、C类产品</span>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>金象币余额</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['total_gold'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>银象币余额</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['total_silver'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>提现兑换比例</strong> <br/>
	  </th>
      <td>
     <input name="total_gold_rmb_pre" id="total_gold_rmb_pre" value="<?php if(! empty($userInfo)){ echo $userInfo['total_gold_rmb_pre'];} ?>" size="10" type="text"> 金象币=1元
     </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>提现兑换比例</strong> <br/>
	  </th>
      <td>
     <input name="total_silver_rmb_pre" id="total_silver_rmb_pre" value="<?php if(! empty($userInfo)){ echo $userInfo['total_silver_rmb_pre'];} ?>" size="10" type="text"> 银象币=1元
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>最后登录时间</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo date('Y-m-d H:i:s', $userInfo['login_time']);} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>最后登录IP</strong> <br/>
	  </th>
      <td>
     <?php if(! empty($userInfo)){ echo $userInfo['ip_address'];} ?>
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
<script type="text/javascript">
function select_user_type() {
    var user_type = $('input[name="user_type"]:checked').val();
    if (user_type == 1) {
        $('.seller_grade').show();
    } else {
    	$('.seller_grade').hide();
    }
}
select_user_type();

function change_area() {
	//省 市 县
	var province_id_txt = $("#province_id").find("option:selected").text();
	var city_id_txt = $("#city_id").find("option:selected").text();
	var area_id_txt = $("#area_id").find("option:selected").text();
	$("#txt_address").val(province_id_txt+' '+city_id_txt+' '+area_id_txt);
}

function get_city(cur_id, next_id, next_select_val, prev_select_val, is_city) {
	var parent_id = $("#"+cur_id).val();
	if (prev_select_val) {
		parent_id = prev_select_val;
	}
	$.post(base_url+"admincp.php/user/get_city",
			{	"parent_id": parent_id
			},
			function(res){
				if(res.success){
					var html = '<option value="">--选择市--</option>';
					if (is_city == 0) {
						html = '<option value="">--选择区/县--</option>';
					}
					for (var i = 0, data = res.data, len = data.length; i < len; i++){
						if (data[i]['id'] == next_select_val) {
							html += '<option selected="selected" value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
						} else {
							html += '<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
						}
					}
					$("#"+next_id).html(html);
					return false;
				}else{
					alert(res.message);
					return false;
				}
			},
			"json"
	);
}
<?php if ($userInfo) { ?>
get_city('province_id','city_id',<?php echo $userInfo['city_id']; ?>,<?php echo $userInfo['province_id']; ?>,1);
get_city('city_id','area_id',<?php echo $userInfo['area_id']; ?>,<?php echo $userInfo['city_id']; ?>,0);
<?php } ?>
</script>
<br/><br/>