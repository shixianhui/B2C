<style>
    .select_file {
        display: inline;
        width: 50px;
        height: 20px;
        margin-left: 10px;
        padding: 1px 10px;
        line-height: 30px;
        text-align: center;
        border: 1px solid #e6e7ec;
        background-color: #f1f1f1;
        border-radius: 3px;
        margin-right: 10px;
        cursor: pointer;
        background-image: linear-gradient(to bottom,#f1f1f1 0,#f1f1f1 100%);
    }
</style>

<?php echo $tool; ?>
<table <?php if ($item_info) {echo 'style="display:none;"';} ?> id="user_login_div" class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>用户名</strong> <br/>
	  </th>
      <td>
      <input id="username" size="20" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>密码</strong> <br/>
	  </th>
      <td>
      <input id="password" size="20" type="password">
      </td>
    </tr>
    <tr>
      <th width="20%">
      &nbsp;
	  </th>
      <td>
      <button onclick="javascript:user_login();" class="button_style" >登录</button>
      </td>
    </tr>
  </tbody>
</table>
<form <?php if (!$item_info) {echo 'style="display:none;"';} ?> method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<div class="tag_menu" style="width: 99%; margin-top: 10px;">
<ul>
  <li><a href="javascript:void(0);" id="basic" class="selected">基本信息</a></li>
  <li><a href="javascript:void(0);" id="advanced" >其它信息</a></li>
</ul>
</div>
<div id="basics" style="border-top:2px solid #99d3fb;" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <strong>用户名</strong> <br/>
	  </th>
      <td>
      <input type="hidden" id="user_id" name="user_id" value="<?php if(! empty($item_info)){ echo $item_info['user_id'];} ?>" />
      <span id="span_username"><?php if(! empty($item_info)){ echo $item_info['username'];} ?></span>
      </td>
    </tr>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>店主姓名</strong> <br/>
	  </th>
      <td>
      <input valid="required" errmsg="店主姓名不能为空!" name="owner_name" id="owner_name" value="<?php if(! empty($item_info)){ echo $item_info['owner_name'];} ?>" size="20" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>店主身份证号</strong> <br/>
	  </th>
      <td>
      <input valid="required|isIdCard" errmsg="店主身份证号不能为空|请输入正确的身份证号" name="owner_card" id="owner_card" value="<?php if(! empty($item_info)){ echo $item_info['owner_card'];} ?>" size="20" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>店铺名称</strong> <br/>
	  </th>
      <td>
      <input valid="required" errmsg="店铺名称不能为空!" name="store_name" id="store_name" value="<?php if(! empty($item_info)){ echo $item_info['store_name'];} ?>" size="80" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>所属店铺分类</strong> <br/>
	  </th>
      <td>
      <select class="input_blur" name="store_category_id" id="store_category_id" valid="required" errmsg="请选择所属店铺分类">
       <option value="">请选择所属店铺分类</option>
       <?php if (! empty($store_category_list)) { ?>
       <!-- 一级 -->
       <?php foreach ($store_category_list as $key=>$value) {
       	$selector = '';
       	if ($item_info) {
       		if ($item_info['store_category_id'] == $value['id']) {
       			$selector = 'selected="selected"';
       		}
       	}
       	?>
       <option <?php echo $selector; ?> <?php if ($value['subMenuList']) {echo 'disabled="disabled"';} ?> value="<?php echo $value['id']; ?>"><?php echo $value['store_category_name']; ?></option>
       <!-- 二级 -->
       <?php foreach ($value['subMenuList'] as $subMenu) {
                 if ($item_info) {
                 	if ($item_info['store_category_id'] == $subMenu['id']) {
                 		$selector = 'selected="selected"';
                 	}
                 }
       	?>
       <option <?php echo $selector; ?> value="<?php echo $subMenu['id']; ?>">&nbsp;&nbsp;┣<?php echo $subMenu['store_category_name']; ?></option>
       <?php }}} ?>
      </select>
      </td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>所在地</strong> <br/>
	  </th>
      <td>
      <input id="txt_address" name="txt_address" type="hidden" value="<?php if(! empty($item_info)){ echo $item_info['txt_address'];} ?>" />
    <select valid="required" errmsg="请选择省" class="input_blur" id="province_id" name="province_id" onchange="javascript:get_city('province_id','city_id',0,0,1);">
    <option value="">选择省</option>
    <?php if ($area_list) { ?>
    <?php foreach ($area_list as $key=>$value) {
	    	$selector = '';
	    	if ($item_info) {
	    		if ($item_info['province_id'] == $value['id']) {
	    			$selector = 'selected="selected"';
	    		}
	    	}
    	?>
    <option <?php echo $selector; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
    <?php }} ?>
    </select>
    <select valid="required" errmsg="请选择市" class="input_blur" id="city_id" name="city_id" onchange="javascript:get_city('city_id','area_id',0,0,2);">
    <option>选择市</option>
    </select>
    <select onchange="javascript:change_area();" valid="required" errmsg="选择区/县" class="input_blur" id="area_id" name="area_id">
    <option>选择区/县</option>
    </select>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>详细地址</strong> <br/>
	  </th>
      <td>
      <input name="address" id="address" value="<?php if(! empty($item_info)){ echo $item_info['address'];} ?>" size="80" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>手机号</strong> <br/>
	  </th>
      <td>
      <input name="mobile" id="mobile" value="<?php if(! empty($item_info)){ echo $item_info['mobile'];} ?>" size="20" type="text" valid="isMobile" errmsg="请输入正确的手机号" />
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>固定电话</strong> <br/>
	  </th>
      <td>
      <input name="phone" id="phone" value="<?php if(! empty($item_info)){ echo $item_info['phone'];} ?>" size="20" type="text" valid="isPhone" errmsg="请输入正确的固定电话" />
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>QQ号</strong> <br/>
	  </th>
      <td>
      <input name="im_qq" id="im_qq" value="<?php if(! empty($item_info)){ echo $item_info['im_qq'];} ?>" size="20" type="text" valid="isQQ" errmsg="请输入正确的QQ号" />
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>微信号</strong> <br/>
	  </th>
      <td>
      <input name="im_weixin" id="im_weixin" value="<?php if(! empty($item_info)){ echo $item_info['im_weixin'];} ?>" size="20" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>旺旺号</strong> <br/>
	  </th>
      <td>
      <input name="im_ww" id="im_ww" value="<?php if(! empty($item_info)){ echo $item_info['im_ww'];} ?>" size="20" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>工作时间</strong> <br/>
	  </th>
      <td>
      <input name="job_time" id="job_time" value="<?php if(! empty($item_info)){ echo $item_info['job_time'];} ?>" size="100" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>所属店铺等级</strong> <br/>
	  </th>
      <td>
       <select onchange="javascript:get_theme_list(this);" class="input_blur" name="store_grade_id" id="store_grade_id" valid="required" errmsg="请选择店铺等级!">
       <option value="" >请选择店铺等级</option>
       <?php if ($store_grade_list) { ?>
       <?php foreach ($store_grade_list as $key=>$value) {
       	$selector = '';
       	if ($item_info) {
       		if ($item_info['store_grade_id'] == $value['id']) {
       			$selector = 'selected="selected"';
       		}
       	}
       	?>
       <option <?php echo $selector; ?> value="<?php echo $value['id']; ?>"><?php echo $value['grade_name']; ?></option>
       <?php }} ?>
      </select>
	  </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>当前主题</strong> <br/>
	  </th>
      <td id="theme_div">
      <?php if ($theme_list) { ?>
      <?php foreach ($theme_list as $key=>$value) {
      	$selector = '';
            if ($item_info) {
            	if ($item_info['theme'] == $value['alias']) {
                    $selector = 'checked="checked"';
            	}
            }
      	?>
      <label>
      <input <?php echo $selector; ?> type="radio" value="<?php echo $value['alias']; ?>" name="theme" class="radio_style"> <?php echo $value['theme_name']; ?>[<?php echo $value['alias']; ?>]
      </label>
      <?php }} else { ?>
     <span style="color: red;">请在"店铺管理 "->"店铺模板管理"->"添加店铺模板"</span>
      <?php } ?>
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>有效期至</strong> <br/>
	  </th>
      <td>
      <input name="end_time" id="end_time" value="<?php if(! empty($item_info) && $item_info['end_time']){ echo date('Y-m-d', $item_info['end_time']);} ?>" size="10" type="text">
      <font color="#9c9c9c">注：留空表示不限制</font>
      <script language="javascript" type="text/javascript">
	    datetime = "<?php if(! empty($item_info) && $item_info['end_time']){ echo date('Y-m-d', $item_info['end_time']);} ?>";
		date = new Date();
		document.getElementById ("end_time").value =datetime;
		Calendar.setup({
			inputField     :    "end_time",
			ifFormat       :    "%Y-%m-%d",
			showsTime      :    false,
			timeFormat     :    "24",
			align          :    "Tr"
		});
	</script>
      </td>
    </tr>
    <tr style="display: none;">
      <th width="20%">
      <strong style="color: red;">意向类型</strong> <br/>
	  </th>
      <td>
      <?php if ($item_info) {echo $store_type_arr[$item_info['store_type']];} ?>
	  </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>实名认证</strong> <br/>
	  </th>
      <td>
      <label>
      <input type="radio" value="1" name="real_name_auth" class="radio_style" <?php if($item_info){if($item_info['real_name_auth']=='1'){echo 'checked="checked"';}} ?> > 已认证
      </label>
      <label>
      <input type="radio" value="0" name="real_name_auth" class="radio_style" <?php if($item_info){if($item_info['real_name_auth']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 未认证
	  </label>
	  </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>实力电商认证</strong> <br/>
	  </th>
      <td>
      <label>
      <input type="radio" value="1" name="retailer_auth" class="radio_style" <?php if($item_info){if($item_info['retailer_auth']=='1'){echo 'checked="checked"';}} ?> > 已认证
      </label>
      <label>
      <input type="radio" value="0" name="retailer_auth" class="radio_style" <?php if($item_info){if($item_info['retailer_auth']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 未认证
	  </label>
	  </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>实体店铺认证</strong> <br/>
	  </th>
      <td>
      <label>
      <input type="radio" value="1" name="store_auth" class="radio_style" <?php if($item_info){if($item_info['store_auth']=='1'){echo 'checked="checked"';}} ?> > 已认证
      </label>
      <label>
      <input type="radio" value="0" name="store_auth" class="radio_style" <?php if($item_info){if($item_info['store_auth']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 未认证
	  </label>
	  </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>实体厂家认证</strong> <br/>
	  </th>
      <td>
      <label>
      <input type="radio" value="1" name="producer_auth" class="radio_style" <?php if($item_info){if($item_info['producer_auth']=='1'){echo 'checked="checked"';}} ?> > 已认证
      </label>
      <label>
      <input type="radio" value="0" name="producer_auth" class="radio_style" <?php if($item_info){if($item_info['producer_auth']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 未认证
	  </label>
	  </td>
    </tr>
    <tr style="display: none;">
      <th width="20%">
      <strong>推荐</strong> <br/>
	  </th>
      <td>
      <input type="radio" value="0" name="recommended" class="radio_style" <?php if($item_info){if($item_info['recommended']=='0'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> > 否
      <input type="radio" value="1" name="recommended" class="radio_style" <?php if($item_info){if($item_info['recommended']=='1'){echo 'checked="checked"';}} ?> > 是
	  </td>
    </tr>
    <tr>
    <th width="20%">
    <strong>自定义属性</strong> <br/>
	</th>
    <td>
    <label><input class="checkbox_style" name="custom_attribute[]" id="h"  value="h" <?php if(! empty($item_info)){if(substr_count($item_info['custom_attribute'], "h")>0){echo "checked=true";}} ?> type="checkbox"/> 热门商家[h]</label>
    </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>排序</strong> <br/>
	  </th>
      <td>
      <input name="sort" id="sort" value="<?php if(! empty($item_info)){ echo $item_info['sort'];}else{echo '0';} ?>" size="10" type="text">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>信誉值</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($item_info)){ echo $item_info['credit_value'];}else{echo '0';} ?>
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>好评率</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($item_info)){ echo $item_info['praise_rate'];}else{echo '0';} ?>
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>申请时间</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($item_info)){ echo date('Y-m-d H:i', $item_info['add_time']);} ?>
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>审核时间</strong> <br/>
	  </th>
      <td>
      <?php if($item_info && $item_info['display_time']){ echo date('Y-m-d H:i', $item_info['display_time']);} ?>
      </td>
    </tr>
    <tr style="display: none;">
        <th width="20%">
            <strong>认证类型</strong> <br/>
        </th>
        <td>
            <?php if($item_info && $item_info['auth_store_type']){ echo $store_type_arr[$item_info['auth_store_type']];} ?>
        </td>
    </tr>
    <tr style="display: none;">
        <th width="20%">
            <strong>认证文档</strong> <br/>
        </th>
        <td>
            <?php if($item_info && $item_info['auth_file_path'] && $item_info['auth_store_type']){ ?>查看 <a href="<?php echo $item_info['auth_file_path']; ?>"><?php echo $auth_file_type_arr[$item_info['auth_store_type']]; ?></a><?php } ?>
                <div class="select_file" onclick="$('input[name=auth_file]').click();">选择文件</div>
                <p style="display: inline;" id="clientName"><?php if ($item_info) { echo $item_info['auth_file_path'];} ?></p>
                <input type="file" accept=".docx,.doc" name="auth_file" model="upload_auth" class="auth_file_path" style="display:none;">
                <input type="hidden" name="auth_file_path" value="<?php if ($item_info) { echo $item_info['auth_file_path'];} ?>">
        </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>状态</strong> <br/>
	  </th>
      <td>
      <?php if ($display_arr) { ?>
      <?php foreach ($display_arr as $key=>$value) {
      	    $selector = '';
            if ($item_info) {
            	if ($item_info['display'] == $key) {
            		$selector = 'checked="checked"';
            	}
            } else {
            	$selector = 'checked="checked"';
            }
      	?>
      <label>
      <input type="radio" value="<?php echo $key; ?>" name="display" class="radio_style" <?php echo $selector; ?> > <?php echo $value; ?>
      </label>
      <?php }} ?>
	  </td>
    </tr>
    <tr>
      <th width="20%"> <strong>前端备注</strong> <br/>
	  </th>
      <td>
      <textarea name="close_reason" id="close_reason" rows="4" cols="50"  class="textarea_style"><?php if(! empty($item_info)){ echo $item_info['close_reason'];} ?></textarea>
     </td>
    </tr>
    <tr>
      <th width="20%"> <strong>后台备注</strong> <br/>
	  </th>
      <td>
      <textarea name="admin_remark" id="admin_remark" rows="4" cols="50"  class="textarea_style"><?php if(! empty($item_info)){ echo $item_info['admin_remark'];} ?></textarea>
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
</div>
<div id="advanceds" style="display: none;border-top:2px solid #99d3fb;">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>其它信息</caption>
 	<tbody>
 	<tr>
       <th width="20%">
         <strong>店铺banner</strong>
       </th>
       <td>
         <a id="store_banner_src_a" title="点击查看大图" href="<?php if ($item_info && $item_info['store_banner']){echo $item_info['store_banner'];}else{echo 'images/admin/no_pic.png';} ?>" target="_blank" style="float:left;"><img id="store_banner_src" width="60px" height="60px" src="<?php if ($item_info && $item_info['store_banner']){echo preg_replace('/\./', '_thumb.', $item_info['store_banner']);}else{echo 'images/admin/no_pic.png';} ?>" /></a>

         <div style="float:left; margin-top:22px;">
         <a style=" position:relative; width:auto; " >
		 <span style="cursor:pointer;" class="but_4">上传照片<input style="left:0px;top:0px; background:#000; width:100%;height:36px;line-height:36px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="store_banner_file" name="store_banner_file" ></span>
		 <i class="load" id="store_banner_load" style="cursor:pointer;display:none;width:auto;padding-left:0px; left:50%; margin-left:-16px;"><img src="images/admin/loading_2.gif" width="32" height="32"></i>
		 </a>

		 <input value="<?php if ($item_info){echo $item_info['store_banner'];} ?>" type="hidden" id="store_banner" name="store_banner">
		 <input name="model" id="model"  value="<?php echo $table; ?>" type="hidden" />
		 <span style="color:#9c9c9c;margin-left:30px;">注：原图大小＝1200x300</span>
         </div>
      </td>
    </tr>
 	<tr>
      <th width="20%">
       <strong>店铺logo</strong>
      </th>
      <td>
        <a id="path_src_a" title="点击查看大图" href="<?php if ($item_info && $item_info['path']){echo $item_info['path'];}else{echo 'images/admin/no_pic.png';} ?>" target="_blank" style="float:left;"><img id="path_src" width="60px" src="<?php if ($item_info && $item_info['path']){echo preg_replace('/\./', '_thumb.', $item_info['path']);}else{echo 'images/admin/no_pic.png';} ?>" onerror="javascript:this.src='images/admin/no_pic.png';" /></a>
        <div style="float:left; margin-top:22px;">
          <a style=" position:relative; width:auto; " >
		   <span style="cursor:pointer;" class="but_4">上传照片<input style="left:0px;top:0px; background:#000; width:100%;height:36px;line-height:36px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file" name="path_file" ></span>
		   <i class="load" id="path_load" style="cursor:pointer;display:none;width:auto;padding-left:0px; left:50%; margin-left:-16px;"><img src="images/admin/loading_2.gif" width="32" height="32"></i>
		   </a>
		   <input value="<?php if ($item_info){echo $item_info['path'];} ?>" type="hidden" id="path" name="path">
		   <span id="cut_image" style="cursor:pointer;" class="but_4">裁剪图片</span>
		   <span style="color:#9c9c9c;margin-left:30px;">注：缩略图大小＝300x220</span>
         </div>
        </td>
    </tr>
    <tr>
       <th width="20%">
        <strong>批量上传展示图片</strong>
       </th>
        <td>
	    <input readonly="readonly" name="batch_path_ids" id="batch_path_ids" value="<?php if ($item_info){echo $item_info['batch_path_ids'];} ?>" size="50" class="input_blur" type="text" />
	    <input class="button_style" name="batch_upload_image" id="batch_upload_image" value="批量添加" style="width: 60px;"  type="button" />
	    <span style="color:#9c9c9c;margin-left:30px;">注：原图大小＝580x580</span>
	    </td>
    </tr>
    <tr style="display: none;">
      <th width="20%">
       <strong>首页推荐店铺logo</strong>
      </th>
      <td>
        <a id="logo_path_src_a" title="点击查看大图" href="<?php if ($item_info && $item_info['logo_path']){echo $item_info['logo_path'];}else{echo 'images/admin/no_pic.png';} ?>" target="_blank" style="float:left;"><img id="logo_path_src" width="60px" src="<?php if ($item_info && $item_info['logo_path']){echo preg_replace('/\./', '_thumb.', $item_info['logo_path']);}else{echo 'images/admin/no_pic.png';} ?>" onerror="javascript:this.src='images/admin/no_pic.png';" /></a>
        <div style="float:left; margin-top:22px;">
          <a style=" position:relative; width:auto; " >
		   <span style="cursor:pointer;" class="but_4">上传照片<input style="left:0px;top:0px; background:#000; width:100%;height:36px;line-height:36px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="logo_path_file" name="logo_path_file" ></span>
		   <i class="load" id="logo_path_load" style="cursor:pointer;display:none;width:auto;padding-left:0px; left:50%; margin-left:-16px;"><img src="images/admin/loading_2.gif" width="32" height="32"></i>
		   </a>
		   <input value="<?php if ($item_info){echo $item_info['logo_path'];} ?>" type="hidden" id="logo_path" name="logo_path">
		   <span id="cut_image_logo_path" style="cursor:pointer;display:none;" class="but_4">裁剪图片</span>
		   <span style="color:#9c9c9c;margin-left:30px;">注：缩略图大小＝88x44</span>
         </div>
        </td>
    </tr>
    <tr style="display: none;">
      <th width="20%">
       <strong>首页推荐店铺背景图</strong>
      </th>
      <td>
        <a id="index_path_src_a" title="点击查看大图" href="<?php if ($item_info && $item_info['index_path']){echo $item_info['index_path'];}else{echo 'images/admin/no_pic.png';} ?>" target="_blank" style="float:left;"><img id="index_path_src" width="60px" src="<?php if ($item_info && $item_info['index_path']){echo preg_replace('/\./', '_thumb.', $item_info['index_path']);}else{echo 'images/admin/no_pic.png';} ?>" onerror="javascript:this.src='images/admin/no_pic.png';" /></a>
        <div style="float:left; margin-top:22px;">
          <a style=" position:relative; width:auto; " >
		   <span style="cursor:pointer;" class="but_4">上传照片<input style="left:0px;top:0px; background:#000; width:100%;height:36px;line-height:36px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="index_path_file" name="index_path_file" ></span>
		   <i class="load" id="index_path_load" style="cursor:pointer;display:none;width:auto;padding-left:0px; left:50%; margin-left:-16px;"><img src="images/admin/loading_2.gif" width="32" height="32"></i>
		   </a>
		   <input value="<?php if ($item_info){echo $item_info['index_path'];} ?>" type="hidden" id="index_path" name="index_path">
		   <span id="cut_image_index_path" style="cursor:pointer;display:none;" class="but_4">裁剪图片</span>
		   <span style="color:#9c9c9c;margin-left:30px;">注：缩略图大小＝296x160</span>
          </div>
        </td>
    </tr>

    <tr>
      <th width="20%"> <strong>店铺公告</strong> <br/>
	  </th>
      <td>
      <textarea maxlength="140" name="business_scope" id="business_scope" rows="4" cols="50"  class="textarea_style" style="width: 80%;" ><?php if(! empty($item_info)){ echo $item_info['business_scope'];} ?></textarea>
 </td>
    </tr>
 	<tr>
      <th width="20%">
      <strong>店铺介绍</strong>
      </th>
      <td>
      <textarea maxlength="140" name="description" id="description" rows="4" cols="50"  class="textarea_style" style="width: 80%;" ><?php if(! empty($item_info)){ echo $item_info['description'];} ?></textarea>
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
</div>
</form>
<script type="text/javascript">
function user_login() {
	var username = $('#username').val();
	var password = $('#password').val();
	if (!username || !password) {
		var d = dialog({
			fixed:true,
		    title: '提示',
		    content: '用户名或密码为空'
		});
		d.show();
		setTimeout(function () {
		    d.close().remove();
		}, 2000);
		return false;
	}
	$.post(base_url+"admincp.php/user/user_login",
			{	"username": username,
		        "password": password
			},
			function(res){
				if(res.success){
                    $('#user_id').val(res.data.item_info.id);
                    $('#span_username').html(res.data.item_info.username);
                    $('#user_login_div').hide();
                    $('#jsonForm').show();
				}else{
					var d = dialog({
						fixed:true,
					    title: '提示',
					    content: res.message
					});
					d.show();
					setTimeout(function () {
					    d.close().remove();
					}, 2000);
					return false;
				}
			},
			"json"
	);
}
function change_area() {
	//国 省 市 县
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
	$.post(base_url+"admincp.php/store/get_city",
			{	"parent_id": parent_id
			},
			function(res){
				if(res.success){
					var html = '';
					if (is_city == 1) {
						html = '<option value="">--选择市--</option>';
					} else if (is_city == 2) {
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
<?php if ($item_info) { ?>
get_city('province_id','city_id',<?php echo $item_info['city_id']; ?>,<?php echo $item_info['province_id']; ?>,1);
get_city('city_id','area_id',<?php echo $item_info['area_id']; ?>,<?php echo $item_info['city_id']; ?>,2);
<?php } ?>
//参数mulu
$(function () {
	//banner
	$("#store_banner_file").wrap("<form id='store_banner_upload' action='<?php echo base_url(); ?>admincp.php/upload/uploadImage2' method='post' enctype='multipart/form-data'></form>");
    $("#store_banner_file").change(function(){ //选择文件
		$("#store_banner_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                'model': 'store',
                'field': 'store_banner_file'
            },
			beforeSend: function() {
            	$("#store_banner_load").show();
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(res) {
    			$("#store_banner_load").hide();
    			if (res.success) {
    				$("#store_banner_src_a").attr("href", res.data.file_path);
      			    $("#store_banner_src").attr("src", res.data.file_path.replace('.', '_thumb.')+"?"+res.data.field);
      			    $("#store_banner").val(res.data.file_path);
        		} else {
        			var d = dialog({
        				fixed: true,
    				    title: '提示',
    				    content: res.message
    				});
    				d.show();
    				setTimeout(function () {
    				    d.close().remove();
    				}, 2000);
            	}
			},
			error:function(xhr){
			}
		});
	});
    //logo
	$("#path_file").wrap("<form id='path_upload' action='<?php echo base_url(); ?>admincp.php/upload/uploadImage2' method='post' enctype='multipart/form-data'></form>");
    $("#path_file").change(function(){ //选择文件
		$("#path_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                'model': 'store',
                'field': 'path_file'
            },
			beforeSend: function() {
            	$("#path_load").show();
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(res) {
    			$("#path_load").hide();
    			if (res.success) {
    				$("#path_src_a").attr("href", res.data.file_path);
      			    $("#path_src").attr("src", res.data.file_path.replace('.', '_thumb.')+"?"+res.data.field);
      			    $("#path").val(res.data.file_path);
        		} else {
        			var d = dialog({
        				fixed: true,
    				    title: '提示',
    				    content: res.message
    				});
    				d.show();
    				setTimeout(function () {
    				    d.close().remove();
    				}, 2000);
            	}
			},
			error:function(xhr){
			}
		});
	});
    //首页推荐logo
	$("#logo_path_file").wrap("<form id='logo_path_upload' action='<?php echo base_url(); ?>admincp.php/upload/uploadImage2' method='post' enctype='multipart/form-data'></form>");
    $("#logo_path_file").change(function(){ //选择文件
		$("#logo_path_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                'model': 'store_logo_path',
                'field': 'logo_path_file'
            },
			beforeSend: function() {
            	$("#logo_path_load").show();
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(res) {
    			$("#logo_path_load").hide();
    			if (res.success) {
    				$("#logo_path_src_a").attr("href", res.data.file_path);
      			    $("#logo_path_src").attr("src", res.data.file_path.replace('.', '_thumb.')+"?"+res.data.field);
      			    $("#logo_path").val(res.data.file_path);
        		} else {
        			var d = dialog({
        				fixed: true,
    				    title: '提示',
    				    content: res.message
    				});
    				d.show();
    				setTimeout(function () {
    				    d.close().remove();
    				}, 2000);
            	}
			},
			error:function(xhr){
			}
		});
	});
    //首页推荐店铺背景图片
	$("#index_path_file").wrap("<form id='index_path_upload' action='<?php echo base_url(); ?>admincp.php/upload/uploadImage2' method='post' enctype='multipart/form-data'></form>");
    $("#index_path_file").change(function(){ //选择文件
		$("#index_path_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                'model': 'store_index_path',
                'field': 'index_path_file'
            },
			beforeSend: function() {
            	$("#index_path_load").show();
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(res) {
    			$("#index_path_load").hide();
    			if (res.success) {
    				$("#index_path_src_a").attr("href", res.data.file_path);
      			    $("#index_path_src").attr("src", res.data.file_path.replace('.', '_thumb.')+"?"+res.data.field);
      			    $("#index_path").val(res.data.file_path);
        		} else {
        			var d = dialog({
        				fixed: true,
    				    title: '提示',
    				    content: res.message
    				});
    				d.show();
    				setTimeout(function () {
    				    d.close().remove();
    				}, 2000);
            	}
			},
			error:function(xhr){
			}
		});
	});
});
load_image();
function load_image() {
	var store_banner = $('#store_banner').val();
	if (store_banner) {
		$("#store_banner_src_a").attr("href", store_banner);
	    $("#store_banner_src").attr("src", store_banner.replace('.', '_thumb.'));
	}
	var path = $('#path').val();
	if (path) {
		$("#path_src_a").attr("href", path);
	    $("#path_src").attr("src", path.replace('.', '_thumb.'));
	}
}

function get_theme_list(obj) {
	var store_grade_id = $('#store_grade_id').val();
	$.post(base_url+"admincp.php/store/get_theme_list",
			{	"store_grade_id": store_grade_id
			},
			function(res){
				if(res.success){
					var html = '';
					for (var i = 0, data = res.data.theme_list, len = data.length; i < len; i++){
						html += '<label>';
						html += '<input  type="radio" value="'+data[i].alias+'" name="theme" class="radio_style"> '+data[i].theme_name+'['+data[i].alias+']';
						html += '</label>';
					}
					$('#theme_div').html(html);
				}
			},
			"json"
	);
}

$(".auth_file_path").wrap("<form class='file_path' action='<?php echo base_url(); ?>admincp.php/upload/upload_auth_file' method='post' enctype='multipart/form-data'></form>");
$(".auth_file_path").change(function() { //选择文件
    var field = $(this).attr('name');
    $(this).parents('.file_path').ajaxSubmit({
        dataType: 'json',
        data: {
            'field': field
        },
        beforeSend: function() {
            $('body').append($('<div id="loading"></div>'));
        },
        uploadProgress: function(event, position, total, percentComplete) {},
        success: function(res) {
            $("#loading").remove();
            if(res.success) {
                $("#clientName").html(res.data.file_path);
                $("input[name=auth_file_path]").val(res.data.file_path);
            } else {
                var d = dialog({
                    fixed: true,
                    title: '提示',
                    content: res.message
                });
                d.show();
                setTimeout(function() {
                    d.close().remove();
                }, 2000);
            }
        },
        error: function(xhr) {}
    });
});
</script>