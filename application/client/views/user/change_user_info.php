<div class="warp">
<?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">资料信息</span></div>
            <div class="member_tab mt20">
                <form action="<?php echo getBaseUrl(false, "", "user/change_user_info.html", $client_index); ?>" id="jsonForm" name="jsonForm" method="post">
                        <ul class="m_form" style="float:left; width:640px; border-right:#e8e8e8 1px solid;">
                            <li class="clearfix"><span>用户名：</span>
                            <?php if ($user_info && $user_info['username']){
                            	echo createMobileBit($user_info['username']);
							} else {?>
							<a style="color: red;" href="<?php echo getBaseUrl(false,"","user/bind_mobile",$client_index);?>">绑定手机</a>
							<?php } ?>
                            </li>
                            <li class="clearfix"><span>昵称：</span><input type="text" value="<?php if ($user_info){echo $user_info['nickname'];} ?>" id="nickname" name="nickname" valid="isNickname" errmsg="请填写正确的昵称" class="input_txt"></li>
                            <li class="clearfix"><span>真实姓名：</span>
                            <?php if ($user_info && $user_info['real_name']){ ?>
                            <?php echo $user_info['real_name']; ?>
                            <?php } else { ?>
                            <input type="text" id="real_name" name="real_name" valid="isChinese" errmsg="请填写正确的姓名" placeholder="提现用，设置后不可修改" class="input_txt">
                            <?php } ?>
                            </li>
                            <li class="clearfix"><span>性别：</span><div class="xm-select" >
                                    <div class="dropdown">
                                        <label class="iconfont" for="feedbackType"></label>
                                        <select id="feedbackType" name="sex">
                                            <?php
                                               foreach($sex_arr as $key=>$val){
                                                   $selected = $user_info&&$user_info['sex']==$key ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $key?>" <?php echo $selected;?>><?php echo $val;?></option>
                                               <?php }?>
                                        </select>
                                    </div>
                                </div></li>
                                <li class="clearfix"><span>支付宝账号：</span>
                                <?php if ($user_info && $user_info['alipay_account']) { ?>
                                <?php echo $user_info['alipay_account']; ?>
                                <?php } else { ?>
                                <input type="text" id="alipay_account" name="alipay_account" placeholder="提现用，设置后不可修改" class="input_txt">
                                <font color="red" style="margin-left: 5px;"> 注：填写与姓名一致的账号</font>
                                <?php } ?>
                                </li>
                                <li class="clearfix"><span>微信账号：</span>
                                <?php if ($user_info && $user_info['weixin_account']) { ?>
                                <?php echo $user_info['weixin_account']; ?>
                                <?php } else { ?>
                                <input type="text" value="<?php if ($user_info){echo $user_info['weixin_account'];} ?>" id="weixin_account" name="weixin_account" placeholder="提现用，设置后不可修改" class="input_txt">
                                <font color="red" style="margin-left: 5px;"> 注：填写与姓名一致的账号</font>
                                <?php } ?>
                                </li>
                                <li style="display: none;" class="clearfix"><span>银联账号：</span>
                                <?php if ($user_info && $user_info['ebank_account']) { ?>
                                <?php echo $user_info['ebank_account']; ?>
                                <?php } else { ?>
                                <input type="text" value="<?php if ($user_info){echo $user_info['ebank_account'];} ?>" id="ebank_account" name="ebank_account" placeholder="提现用，设置后不可修改" class="input_txt">
                                <font color="red" style="margin-left: 5px;">注：填写与姓名一致的账号</font>
                                <?php } ?>
                                </li>
                                <li class="clearfix"><span>&nbsp;</span><input type="submit" value="提交" class="btn_r" style="border:none;"></li>
                        </ul>
                    </form>
                <div class="m_picture">
                    <h5>头像</h5>
                    <a href="javascript:void(0);" class="file_input">
                        <img src="<?php if ($user_info){echo preg_match('/^http/',$user_info['path']) ? $user_info['path'] : preg_replace("/\./","_thumb.",$user_info['path']);} ?>" id="path_src" onerror="this.src='images/default/load.jpg'">
                        <span>上传新图像<i class="m_icon"></i></span>
                        <input style="left:0px;top:0px; background:#000; width:120px;height:120px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file" name="path_file" >
                        <i class="load" id="path_load" style="cursor:pointer;display:none;width:130px;padding-left:0px;position: absolute;top:0px;left:0px;"><img src="images/default/loading_2.gif" style="width:45px;height:45px;margin-top:30px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //形象照片
    $("#path_file").wrap("<form id='path_upload' action='"+base_url+"index.php/upload/uploadImage' method='post' enctype='multipart/form-data'></form>");
    $("#path_file").change(function(){ //选择文件
		$("#path_upload").ajaxSubmit({
			dataType:  'json',
			data: {
                'model': 'path',
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
      			    $("#path_src").attr("src", res.data.file_path.replace('.', '_thumb.')+"?"+res.data.field);
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