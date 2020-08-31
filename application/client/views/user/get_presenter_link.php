<script type="text/javascript" src="js/default/zclip/jquery.zclip.js"></script>
<div class="warp">
<?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
				<div class="box_shadow clearfix mt20 m_border">
					<div class="member_title"><span class="bt">我的推广管理</span></div>
	                 <div class="member_tab mt20">
						<div class="assets">
							<ul class="clearfix">
								<li>我的总提成：<span><?php echo number_format($total, 2, '.', ''); ?>元</span></li>
								<li>当月提成：<span><?php echo number_format($cur_total, 2, '.', ''); ?>元</span></li>
								<li>上月提成：<span><?php echo number_format($prv_total, 2, '.', ''); ?>元</span></li>
								<?php if ($userInfo) { ?>
								<?php if (!$userInfo['path']) { ?>
								<li style="float: right;"><a style="color:red;font-size:16px;" href="<?php echo getBaseUrl(false, "", "user/change_user_info.html", $client_index); ?>">您还未上传头像，请上传头像</a></li>
							   <?php }} ?>
							</ul>
						</div>

						<div class="link_box mt20">
							<div class="link_code fl mt5">
								<ul class="clearfix">
									<li>我的授权级别：<span><?php if ($userInfo) {if ($userInfo['user_type'] == 1){echo '商家['.$seller_grade_arr[$userInfo['seller_grade']].']';}else{echo '会员';}} ?></span></li>
									<li style="position: relative;">我的推广链接：<span><?php echo base_url().getBaseUrl($html, "t/i", "t/i", $client_index).'/'.$pop_code.'.html'; ?></span><a class="cpycomment" href="javascript:void(0);">复制链接</a></li>
									<li style="position: relative;">&nbsp;&nbsp;&nbsp;我的邀请码：<span><?php echo $pop_code; ?></span><a class="cpycomment_code" href="javascript:void(0);">复制邀请码</a></li>
								</ul>
							</div>
							<div class="down_load fr">
							<?php if ($userInfo) { ?>
							<a href="<?php echo getBaseUrl(false, "", "user/get_user_rq", $client_index); ?>"  ><img class="code_img" src="<?php echo getBaseUrl(false, "", "user/get_user_rq", $client_index); ?>" width="118px" height="118px" /></a>
		                    <?php } ?>
								<a href="javascript:void(0);" class="down_btn">下载更多尺寸</a>
							</div>
							<div class="mask"></div>
							<div class="alert_box" style="z-index: 1000;">
								<h3>更多尺寸<a onclick="javascript:close_div();" href="javascript:void(0);" class="close_btn fr"></a></h3>
								<div class="table_box">
									<table>
										<tr>
											<th width="33%">二维码边长（cm）</th>
											<th width="42%">建议扫描距离（米）</th>
											<th width="25%">下载链接</th>
										</tr>
										<tr>
											<td  width="33%">8cm</td>
											<td width="42%">0.5m</td>
											<td width="25%">
											<form id="download_qr_1" method="post" action="index.php/user/download_qr/8">
											<input type="hidden" value="1">
											<a onclick="javascript:$('#download_qr_1').submit();" href="javascript:void(0);"></a>
											</form>
											</td>
										</tr>
										<tr>
											<td  width="33%">12cm</td>
											<td width="42%">0.8m</td>
											<td width="25%">
											<form id="download_qr_2" method="post" action="index.php/user/download_qr/12">
											<input type="hidden" value="1">
											<a onclick="javascript:$('#download_qr_2').submit();" href="javascript:void(0);"></a>
											</form>
											</td>
										</tr>
										<tr>
											<td  width="33%">15cm</td>
											<td width="42%">1m</td>
											<td width="25%">
											<form id="download_qr_3" method="post" action="index.php/user/download_qr/15">
											<input type="hidden" value="1">
											<a onclick="javascript:$('#download_qr_3').submit();" href="javascript:void(0);"></a>
											</form>
											</td>
										</tr>
										<tr>
											<td  width="33%">30cm</td>
											<td width="42%">1.5m</td>
											<td width="25%">
											<form id="download_qr_4" method="post" action="index.php/user/download_qr/30">
											<input type="hidden" value="1">
											<a onclick="javascript:$('#download_qr_4').submit();" href="javascript:void(0);"></a>
											</form>
											</td>
										</tr>
										<tr>
											<td  width="33%">50cm</td>
											<td width="42%">2.5m</td>
											<td width="25%">
											<form id="download_qr_5" method="post" action="index.php/user/download_qr/50">
											<input type="hidden" value="1">
											<a onclick="javascript:$('#download_qr_5').submit();" href="javascript:void(0);"></a>
											</form>
											</td>
										</tr>
									</table>

								</div>
								<p>二维码尺寸请按照43像素的整数倍进行缩放，以保持最佳效果</p>
								<div class="close_box">
									<a onclick="javascript:close_div();" href="javascript:void(0);">关闭</a>
								</div>
							</div>
						</div>

					</div>

					<div class="member_title mt20"><span class="bt">二维码设置</span></div>
					<div class="member_tab">
						<div class="code_action">
							<div class="ad_text">推广语：<i class="icon_star">*</i><input id="ad_text" maxlength="30" onchange="javascript:change_ad_text(this);" type="text" placeholder="填写广告语"/><span>30字以内</span></div>
							<p class="band">样式选择：<span>此处使用的是带参数的二维码，扫描后注册将与本合伙人账号进行绑定</span></p>
							<form id="download_qr" method="post" action="index.php/user/download_qr_code.html">
							<div class="code_down">
								<p>图片下载：<span>推广图</span><a onclick="javascript:$('#download_qr').submit();" href="javascript:void(0);">点击下载</a></p>
								<div class="code_pic mt15">
									<div class="code_bg">
										<div class="bg_img"><img id="path_1" src="<?php echo getBaseUrl($html, "user/get_qr_code/1/1", "user/get_qr_code/1/1", $client_index); ?>"/></div>
										<label><input name="qr_type" value="1" type="radio" />样式一</label>
									</div>
									<div class="code_bg">
										<div class="bg_img"><img id="path_2"  src="<?php echo getBaseUrl($html, "user/get_qr_code/2/1", "user/get_qr_code/2/1", $client_index); ?>"/></div>
										<label><input name="qr_type" value="1" type="radio" />样式二</label>
									</div>
									<div class="code_bg">
										<div class="bg_img"><img id="path_3"  src="<?php echo getBaseUrl($html, "user/get_qr_code/3/1", "user/get_qr_code/3/1", $client_index); ?>"/></div>
										<label><input name="qr_type" value="1" type="radio" />样式三</label>
									</div>
								</div>
								<div class="code_btn">
									<a onclick="javascript:save_ad_qr_code();" href="javascript:void(0);" class="btn1">保存</a>
									<a onclick="javascript:cancel_ad_qr_code();" href="javascript:void(0);" class="btn2">取消</a>
								</div>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
</div>
<script type="text/javascript">
	$('.mask').css({
		'width':$(window).width(),
		'height':$(window).height()
	});
	var $alertBox=$('.alert_box')
	$('.down_btn').on('click',function(){
		$('.mask').css('display','block');
		$('.alert_box').css({
			'display':'block',
			'marginTop':-$alertBox.height()/2,
			'marginLeft':-$alertBox.width()/2
		});
		return false;
	})

	function close_div() {
		$('.mask').css('display','none');
		$alertBox.css('display','none');
	}

	function change_ad_text(obj) {
		var ad_text = $(obj).val();
        $.post(base_url+"index.php/"+controller+"/create_ad_qr_code",
				{	"ad_text": ad_text
				},
				function(res){
					if(res.success){
						document.getElementById('path_1').src = base_url+'index.php/user/get_qr_code/1/'+res.data.r;
						document.getElementById('path_2').src = base_url+'index.php/user/get_qr_code/2/'+res.data.r;
						document.getElementById('path_3').src = base_url+'index.php/user/get_qr_code/3/'+res.data.r;
					}else{
						var d = dialog({
						    title: '提示',
						    content: res.message
						});
						d.show();
						setTimeout(function () {
						    d.close().remove();
						}, 2000);
					}
				},
				"json"
		);
	}

	function save_ad_qr_code() {
		var ad_text = $('#ad_text').val();
        $.post(base_url+"index.php/"+controller+"/save_ad_qr_code",
				{	"ad_text": ad_text
				},
				function(res){
					if(res.success){
						var d = dialog({
						    title: '提示',
						    content: res.message
						});
						d.show();
						setTimeout(function () {
						    d.close().remove();
						}, 2000);
					}else{
						var d = dialog({
						    title: '提示',
						    content: res.message
						});
						d.show();
						setTimeout(function () {
						    d.close().remove();
						}, 2000);
					}
				},
				"json"
		);
	}

	function cancel_ad_qr_code() {
        $.post(base_url+"index.php/"+controller+"/cancel_ad_qr_code",
				{	"ad_text": ''
				},
				function(res){
					if(res.success){
						$('#ad_text').val('');
						document.getElementById('path_1').src = base_url+'index.php/user/get_qr_code/1/'+res.message;
						document.getElementById('path_2').src = base_url+'index.php/user/get_qr_code/2/'+res.message;
						document.getElementById('path_3').src = base_url+'index.php/user/get_qr_code/3/'+res.message;
					}else{
						alert(res.message);
						return false;
					}
				},
				"json"
		);
	}
</script>
<script type="text/javascript">
$(document).ready(function(){
    /* 定义所有class为copy标签，点击后可复制被点击对象的文本 */
    $(".cpycomment").zclip({
		path: "<?php echo base_url(); ?>js/default/zclip/ZeroClipboard.swf",
		copy: function() {
		    var txt_url = '<?php echo base_url().getBaseUrl($html, "t/i", "t/i", $client_index).'/'.$pop_code.'.html'; ?>';
    	    return txt_url;
		},
		beforeCopy:function() {/* 按住鼠标时的操作 */
			$(this).css("color","orange");
		},
		afterCopy:function(){/* 复制成功后的操作 */
			var d = dialog({
			    title: '提示',
			    content: '复制成功！按 Ctrl+V 粘贴'
			});
			d.show();
			setTimeout(function () {
			    d.close().remove();
			}, 2000);
        }
	});
    $(".cpycomment_code").zclip({
		path: "<?php echo base_url(); ?>js/default/zclip/ZeroClipboard.swf",
		copy: function() {
		    var txt_url = '<?php echo $pop_code; ?>';
    	    return txt_url;
		},
		beforeCopy:function() {/* 按住鼠标时的操作 */
			$(this).css("color","orange");
		},
		afterCopy:function(){/* 复制成功后的操作 */
			var d = dialog({
			    title: '提示',
			    content: '复制成功！按 Ctrl+V 粘贴'
			});
			d.show();
			setTimeout(function () {
			    d.close().remove();
			}, 2000);
        }
	});
});
</script>