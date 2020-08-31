
<div class="warp">
   <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">申请退款/退货</span></div>
            <div class="member_tab mt20">
                   <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="jsonForm" name="jsonForm" method="post">
                            <ul class="m_form" >
                                <li class="clearfix"><span><font color="red">*</font>订单号：</span><input type="text" value="<?php echo $this->input->get('order_number',true);?>" id="order_number" name="order_number" valid="required" errmsg="订单号不能为空" readonly="true" class="input_txt mr15"></li> 
                                <li class="clearfix">
                                    <span><font color="red">*</font>申请退款/退货：</span>
                                    <select name="exchange_type"  errmsg="请选择退款/退货">
<!--                                        <option value="">请选择</option>-->
                                      <?php
                                              foreach($exchange_type as $key=>$ls){
                                      ?>
                                        <option value="<?php echo $key;?>" <?php if($item_info){ echo $key==$item_info['exchange_type'] ? 'selected="selected"' : '';}?>><?php echo $ls;?></option>
                                              <?php }?>
                                    </select>
                                </li>
                                <li class="clearfix">
                                    <span><font color="red">*</font>上传凭证图片：</span>
                                    <img style="padding: 2px; border:1px solid #CCC;float:left;" id="path_src" width="104px" height="75px" src="<?php if($item_info){ echo str_replace('.','_thumb.',$item_info['path']);}else{ echo 'images/default/no_pic.jpg';}?>">
                                    <a style="position:relative;top:25px;" >
				    <span style="cursor:pointer;text-align:center;color:#fff;" class="but_4">上传凭证图片<input style="left:0px;top:0px; background:#000; width:105px;height:35px;line-height:30px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file" name="path_file" ></span>
				    <i class="load" id="path_load" style="cursor:pointer;display:none;width:130px;padding-left:0px;"><img src="images/default/loading_2.gif" width="32" height="32"></i>
				    </a>
                                    <input type="hidden" id="path" name="path"  value="<?php if($item_info){ echo $item_info['path'];}?>" valid="required" errmsg="凭证图片不能为空" >
                                </li>
                                <li class="clearfix">
                                     <span><font color="red">*</font>详细原因描述：</span>
                                     <textarea cols="36" rows="3" id="content" name="content" valid="required" errmsg="详细原因描述不能为空"><?php if($item_info){ echo $item_info['content'];}?></textarea>
                                </li>
                                <li class="clearfix"><span>&nbsp;</span><input type="submit" value="提交修改" style="border:none;" class="btn_r"></li>  
                            </ul>
                    </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
</script>
<script language="javascript" type="text/javascript">
//    var times = 60, cuttime;
//    function getyzm(idn) {
//        times--;
//        if (times > 0 && times < 60) {
//            $(idn).text(times + "秒后重新获取");
//            $(idn).addClass("fail");
//            cuttime = setTimeout(function () {
//                getyzm(idn)
//            }, 1000);
//        }
//        else {
//            $(idn).text("获取短信验证码");
//            times = 60;
//            $(idn).removeClass("fail");
//            clearTimeout(cuttime);
//        }
//    }

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
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

