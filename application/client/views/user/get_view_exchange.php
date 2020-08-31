<div class="blank"></div>
<div class="blank"></div>
<div class="w clearfix">  
<?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
  <div class="AreaU_R">
     <div class="bgwhite clearfix">
      <div class="product-body">
      <div style="padding-left:0px; padding-right:0px;" class="col-sm-12">
        <div class="ticket-detail ng-scope" style="height: 630px;">
          <div class="console-title console-title-border m-b-15 clearfix">
            <h5 class="pull-left">查看退换货详情</h5>
            </div>
            <div class="blank"></div>
		    <table width="100%" cellspacing="1" cellpadding="5" border="0" bgcolor="#dddddd">
                <tbody>
                <tbody>
                <tr>
			      <td width="20%" bgcolor="#FFFFFF" align="right">处理状态：</td>
			      <td bgcolor="#FFFFFF" align="left" style="color: red;"><?php if($item_info){echo $status[$item_info['status']];} ?></td>
			    </tr>
			    <tr>
			      <td width="20%" bgcolor="#FFFFFF" align="right">处理时间：</td>
			      <td bgcolor="#FFFFFF" align="left" style="color: red;"><?php if($item_info){echo date('Y-m-d H:i', $item_info['last_time']);} ?></td>
			    </tr>
			    <?php if ($item_info && $item_info['status']) { ?>
			    <tr>
			      <td width="20%" bgcolor="#FFFFFF" align="right">退款金额：</td>
			      <td bgcolor="#FFFFFF" align="left" style="color: red;"><?php if($item_info){echo $item_info['price'];} ?></td>
			    </tr>
			    <?php } ?>
                <tr>
			      <td width="20%" bgcolor="#FFFFFF" align="right">退换货服务标题：</td>
			      <td bgcolor="#FFFFFF" align="left"><?php if($item_info){echo $item_info['title'];} ?></td>
			    </tr>
			    <tr>
			      <td width="20%" bgcolor="#FFFFFF" align="right">退换货订单号：</td>
			      <td bgcolor="#FFFFFF" align="left"><?php if($item_info){echo $item_info['order_number'];} ?></td>
			    </tr>
			    <tr>
			      <td width="20%" bgcolor="#FFFFFF" align="right">上传凭证图片：</td>
			      <td bgcolor="#FFFFFF" align="left">
			      <a id="path_src_a" title="点击查看大图" href="<?php if ($item_info && $item_info['path']){echo $item_info['path'];}else{echo 'images/default/no_pic.jpg';} ?>"  ><img style="padding: 2px; border:1px solid #CCC;" id="path_src" width="104px" height="75px" src="<?php if ($item_info && $item_info['path']){echo preg_replace('/\./', '_thumb.', $item_info['path']);}else{echo 'images/default/no_pic.jpg';} ?>" /></a>
			      </td>
			    </tr>
			    <tr>
			      <td width="20%" bgcolor="#FFFFFF" align="right">详细原因描述：</td>
			      <td bgcolor="#FFFFFF" align="left"><?php if($item_info){echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $item_info['content']);} ?></td>
			    </tr>
			    <tr>
			      <td width="20%" bgcolor="#FFFFFF" align="right">申请时间：</td>
			      <td bgcolor="#FFFFFF" align="left" style="color: red;"><?php if($item_info){echo date('Y-m-d H:i', $item_info['add_time']);} ?></td>
			    </tr>
                <tr>
                  <td bgcolor="#ffffff" colspan="2">
                  <input style="margin-top:20px;margin-left:200px;"  onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" type="button" value="返回" class="btn btn-primary" name="back">
                  </td>
                </tr>
              </tbody>
              </table>
          </div>
      </div>
    </div>
    </div>
  </div>
  <div class="blank"></div>
</div>
<?php echo $this->load->view('element/service_bottom_tool', '', TRUE); ?>
<script type="text/javascript">
//参数mulu
$(function () {
	//形象照片
	$("#path_file").wrap("<form id='path_upload' action='"+base_url+"index.php/upload/uploadImage' method='post' enctype='multipart/form-data'></form>");
    $("#path_file").change(function(){ //选择文件 
		$("#path_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                'model': 'exchange',
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
});
</script>
<style type="text/css">
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
.load {
    background: #fff none repeat scroll 0 0;
    left: 0;
    margin-top: -11px;
    opacity: 0.7;
    padding-left: 0px;
    position: absolute;
    top: 0;
    width: 63px;
}
</style>