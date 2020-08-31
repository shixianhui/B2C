<style>
    .but_4 {
    background: #f08200 none repeat scroll 0 0;
    border-radius: 6px;
    color: #fff;
    display: inline-block;
    font: 1.2em/32px "微软雅黑";
    height: 32px;
    margin-left: 10px;
    padding: 0 10px;
    position: relative;
}
</style>
<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>免单优惠券图片</strong> <br/>
	  </th>
      <td>
          <img src="<?php if($systemInfo){ echo $systemInfo['free_coupon_path'];}?>" onerror="this.src='images/admin/nopic.gif'" id="img1">
          <a style=" position:relative;">
		    <span style="cursor:pointer;" class="but_4">上传图片<input style="left:0px;top:0px; background:#000; width:80px;height:35px;line-height:30px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="free_coupon_path" name="coupon_img1"></span>
		    <i class="load" id="free_coupon_path_load" style="cursor:pointer;display:none;width:150px;"><img src="images/admin/loading_2.gif" width="32" height="32"></i>
	  </a>
          <input value="<?php if($systemInfo){ echo $systemInfo['free_coupon_path'];}?>" type="hidden" id="free_path" name="free_coupon_path">
      </td>
    </tr>
    	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>半价优惠券图片</strong> <br/>
        </th>
      <td>
          <img src="<?php if($systemInfo){ echo $systemInfo['half_price_coupon_path'];}?>" onerror="this.src='images/admin/nopic.gif'" id="img2">
          <a style=" position:relative;" >
		    <span style="cursor:pointer;" class="but_4">上传图片<input style="left:0px;top:0px; background:#000; width:80px;height:35px;line-height:30px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="half_price" name="coupon_img2"></span>
		    <i class="load" id="half_price_load" style="cursor:pointer;display:none;width:150px;"><img src="images/admin/loading_2.gif" width="32" height="32"></i>
	   </a>
          <input value="<?php if($systemInfo){ echo $systemInfo['half_price_coupon_path'];}?>" type="hidden" name="half_price_coupon_path">
      </td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>半价优惠券满多少元方可使用</strong> <br/>
	  </th>
      <td>
          <input valid="required|isNumber" errmsg="半价优惠券不能为空!|必须是数字" value="<?php if($systemInfo){ echo $systemInfo['half_price_coupon_set_money'];}?>" name="half_price_coupon_set_money"> 元
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>半价优惠券是否允许多件商品使用</strong> <br/>
	 </th>
      <td>
          <?php
               if($coupon_arr){
                   foreach($coupon_arr as $key=>$value){
                               $selected = '';
                          if($systemInfo && $key==$systemInfo['half_price_coupon_limit']){
                                $selected = 'checked';
                          } 
          ?>
          <label> <input type="radio" name="half_price_coupon_limit" value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $value;?></label>
               <?php }}?>
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
<script>
//上传优惠券图片
    $("#free_coupon_path").wrap("<form id='free_coupon_path_upload' action='<?php echo base_url(); ?>admincp.php/upload/uploadImage2' method='post' enctype='multipart/form-data'></form>");
    $("#free_coupon_path").change(function(){ //选择文件 
		$("#free_coupon_path_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                'model': 'coupon',
                'field': 'coupon_img1'
            },
			beforeSend: function() {
            	$("#free_coupon_path_load").show();
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(res) {
    			$("#free_coupon_path_load").hide();
    			if (res.success) {
      			    $("#img1").attr("src", res.data.file_path.replace('.', '_thumb.')+"?"+res.data.field);
      			    $("#free_path").val(res.data.file_path);
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
        
          $("#half_price").wrap("<form id='half_price_upload' action='<?php echo base_url(); ?>admincp.php/upload/uploadImage2' method='post' enctype='multipart/form-data'></form>");
    $("#half_price").change(function(){ //选择文件 
		$("#half_price_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                'model': 'coupon',
                'field': 'coupon_img2'
            },
			beforeSend: function() {
            	$("#half_price_load").show();
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
    		},
			success: function(res) {
    			$("#half_price_load").hide();
    			if (res.success) {
      			    $("#img2").attr("src", res.data.file_path.replace('.', '_thumb.')+"?"+res.data.field);
      			    $("input[name=half_price_coupon_path]").val(res.data.file_path);
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
</script>