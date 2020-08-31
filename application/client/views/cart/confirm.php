<div class="clear"></div>
<header class="header clearfix" style="border-bottom:#e61d47 2px solid;">
    <div class="warp">
        <a href="<?php echo base_url(); ?>" class="logo"><img src="images/default/logo.png"></a>
        <div class="cart_step fr">
            <ul class="clearfix">
                <li >我的购物车<em></em><i></i></li>
                <li class="current">填写订单信息<em></em><i></i></li>
                <li>确认订单付款<em></em><i></i></li>
                <li>订单提交成功<em></em><i></i></li>
            </ul>
        </div>
    </div>
</header>
<div class="clear"></div>
<div class="warp">
    <div  class="cart_border mt30">
        <span class="tit">选择收货地址</span>
        <div class="border_d clearfix">
            <ul class="addr-list clearfix" id="addr_list">
                <?php if ($useraddressList) {
                	foreach ($useraddressList as $useraddress) { ?>
                        <li id="list_li_<?php echo $useraddress['id']; ?>" item_id="<?php echo $useraddress['id']; ?>" onclick="javascript:select_address(this);" <?php echo $useraddress['default'] == 1 ? 'class="is_default active"' : ''; ?>>
                            <div class="title">
                                <div class="name" style="width:auto;border:none;background:none;"> <?php echo $useraddress['buyer_name']; ?><span class="space"></span>收</div>
                                <div class="default">
                                    <a onclick="javascript:set_default_user_address(this,'<?php echo $useraddress['id']; ?>');" href="javascript:void(0);" class="set red">设为默认</a>
                                    <span class="ok">默认地址</span>
                                </div>
                            </div>
                            <div class="text-box">
                                <p><?php echo $useraddress['txt_address']; ?></p>
                                <p><?php echo $useraddress['address']; ?></p>
                                <p><?php echo $useraddress['mobile']; ?></p>
                            </div>
                            <div class="opn"><a onclick="javascript:change_user_address('<?php echo $useraddress['id']; ?>');" href="javascript:void(0);">修改</a><span class="space2"></span><a onclick="javascript:delete_item(<?php echo $useraddress['id']; ?>);" href="javascript:void(0);">删除</a></div>
                            <i class="ico-yes icon"></i>
                        </li>
                    <?php }
                }
                ?>
            </ul>
            <div class="addnew"><a onclick="javascript:add_address();" href="javascript:void(0);">+&nbsp;新增收货地址</a></div>
        </div>

    </div>
    <div  class="cart_border mt30">
        <span class="tit">确认订单信息<a href="<?php echo getBaseUrl(false, '', 'cart.html', $client_index); ?>"><font class="f12" color="#e61d47">（返回购物车修改）</font></a></span>
        <div class="border_d clearfix">
            <table width="98%" border="0" cellspacing="0" cellpadding="0" class="order_table">
                <thead>
                    <tr>
                        <td class="tal">商品信息</td>
                        <td width="180" align="center">单价（元）</td>
                        <td width="137" align="center">数量</td>
                        <td width="120" align="center">小计（元）</td>
                        <td width="120" align="center">积分换购</td>
                        <td width="120" align="center">送积分</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($cartList) {
                        foreach ($cartList as $cart) {
                            $url = getBaseUrl(false, "", "product/detail/{$cart['product_id']}.html", $client_index);
                            ?>
                            <tr>
                                <td align="left" valign="middle" class="tal">
                                <div class="product_info">
                                <a   href="<?php echo $url; ?>" class="picture fl"><img src="<?php echo preg_replace('/\./', '_thumb.', $cart['path']); ?>"></a>
                                <p><a   href="<?php echo $url; ?>" ><?php echo $cart['title']; ?></a><br><?php echo $product_type_arr[$cart['product_type']];?>&nbsp;&nbsp;<?php if ($cart['brand_name']) { ?>品牌：<?php echo $cart['brand_name'];?><?php } ?>　<?php if ($cart['color_size_open']) { ?><?php echo $cart['product_size_name']; ?>：<?php echo $cart['size_name']; ?>　<?php echo $cart['product_color_name']; ?>：<?php echo $cart['color_name']; ?><?php } ?></p>
                                </div>
                                </td>
                                <td align="center">
                                <s class="tdl"><?php echo $cart['market_price']; ?></s>
                                <br>
                                <b class="unit purple"><?php echo $cart['sell_price']; ?></b>
                                </td>
                                <td align="center"><?php echo $cart['buy_number']; ?></td>
                                <td align="center"><b class="u-price purple f14"><?php echo number_format($cart['sell_price'] * $cart['buy_number'], 2); ?></b></td>
                                <td align="center"><?php echo $cart['buy_number'].'x'.$cart['consume_score']; ?></td>
                                <td align="center" <?php if ($cart['product_type'] == 'a') {echo 'style="color: #c6c4c7;" title="返银象积分"';}else{echo 'style="color: #ecc319;" title="返金象积分"';} ?>><?php echo $cart['buy_number'].'x'.$cart['give_score']; ?></td>
                            </tr>
	                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
      if($free == 0){
          foreach($postage_way as $key=>$ls){
    ?>
    <div  class="cart_border mt30 <?php echo ($key+1)%2==0 ? 'fr' : 'fl';?>" style="width:49%;">
            <span class="tit">配送方式</span>
            <div class="border_d clearfix">
                <ul class="way_ul">
                    <Li><label><input id="postage_template_id" name="postage_template_id" type="radio" value="<?php echo $ls['id'];?>" <?php echo $key==0 ? 'checked="checked"' : '';?>><span id="postage_template_name"><?php echo $ls['title'];?></span></label></Li>
                </ul>
            </div>
        </div>
      <?php }}else{ ?>
        <div  class="cart_border fl mt30" style="width:49%;">
            <span class="tit">配送方式</span>
            <div class="border_d clearfix">
                <ul class="way_ul">
                    <Li><label><input id="postage_template_id" name="postage_template_id" type="radio" value="0" checked="checked"><span id="postage_template_name"><?php echo $pay_way_str;?></span></label></Li>
                </ul>
            </div>
        </div>
     <?php }?>
        <div  class="cart_border fr mt30" style="width:49%;">
            <span class="tit">积分换购<span style="color: #c6c4c7;">
            <?php if ($use_deductible_score_gold > 0 && $use_deductible_score_silver > 0) { ?>
            (需<?php echo $use_deductible_score_gold;?>金象积分、<?php echo $use_deductible_score_silver;?>银象积分)
            <?php } else if ($use_deductible_score_gold > 0 && $use_deductible_score_silver == 0) {  ?>
            (需<?php echo $use_deductible_score_gold;?>金象积分)
            <?php } else if ($use_deductible_score_gold == 0 && $use_deductible_score_silver > 0) {  ?>
            (需<?php echo $use_deductible_score_silver;?>银象积分)
            <?php } ?>
            </span></span>
            <div class="border_d clearfix">
                <ul class="way_ul">
                    <Li>我的银象积分：<?php if ($userInfo) {echo $userInfo['score_silver'];} ?> 个</Li>
                    <Li>我的金象积分：<?php if ($userInfo) {echo $userInfo['score_gold'];} ?> 个(<font color="#999">可降级作为银象积分使用</font>)</Li>
                    <Li>
                        <label id="label1">
                            <input onchange="javascript:change_checkbox();" name="use_score" type="checkbox" value="1">
                                                                                    使用积分换购(<span style="color: #999;">银象积分不足时会自动用金象积分1:1抵扣</span>)
                        </label>
                    </Li>
                </ul>
            </div>
        </div>
    <div class="clear"></div>
    <div class="cart_conunt">
      <p>可获得金象积分：<i id="gold_give_score" class="purple" style="color: #666;"><?php echo $gold_give_score; ?></i>个</p>
      <p>可获得银象积分：<i id="silver_give_score" class="purple" style="color: #666;"><?php echo $silver_give_score; ?></i>个</p>
      <p class="use_score" style="display: none;"><span>换购所需积分：</span><b id="consume_score_total" class="purple"><?php echo $consume_score_total;?></b>个</p>
      <p class="use_money"><span>商品总金额：</span><b class="purple" id="product_total">+￥<?php echo $product_total;?></b></p>
      <p><span>运费：</span><b class="purple" id="postage_price">+￥<?php echo $postage_price;?></b></p>
      <p><span>应付款：</span><b class="purple" id="total">￥<?php echo $total;?></b><b class="purple use_score" id="consume_score_total_2">+<?php echo $consume_score_total;?>积分</b></p>
      <a onclick="javascript:submit_order();" href="javascript:void(0)" class="btn_pay mt5 fr">提交订单</a>
      <div class="fr">
	      <P><span>寄送至：</span><i id="user_address_i_1"><?php if($default_user_address_info) {echo $default_user_address_info['txt_address'].$default_user_address_info['address'];} ?></i></P>
	      <p><span>收货人：</span><i id="user_address_i_2"><?php if($default_user_address_info) {echo $default_user_address_info['buyer_name'];} ?> <?php if($default_user_address_info) {echo $default_user_address_info['mobile'];} ?></i></p>
      </div>

    </div>
</div>
		<style type="text/css">
			.opover{position:fixed;background:rgba(0,0,0,0.3);top:0;z-index:999;height:100%;width:100%;left:0;display:none;}
			.opover>div{position:absolute;width:660px;height:560px;background:#fff;top:50%;margin-left:-330px;left:50%;margin-top:-280px;}
			.opover>div h5{font-size:18px;font-weight:normal;line-height:50px;padding-left:15px;border-bottom: 1px solid #d5d5d5;}
			.opover>div h5 a{width:50px;text-align:center;color:#545454;}
			.opover>div ul{padding:0;margin:10;}
			.opover>div ul li{padding-bottom:10px;}
			.opover>div ul textarea{resize: none;}
			.opover.active{display:block;}
		</style>
		<div id="add_address" class="opover">
			<div>
				<h5><span id="title_span">添加收货地址</span> <a onclick="javascript:close_address();" class="fr" href="javascript:void(0);">x</a></h5>
				<ul class="m_form" >
		                <li class="clearfix"><span><font color="e61d47"><strong>*</strong></font>收货人姓名：</span><input type="text" id="buyer_name" class="input_txt"></li>
		                <li class="clearfix"><span><font color="e61d47"><strong>*</strong></font>手机号码：</span><input type="text" id="mobile" class="input_txt"></li>
		                <li class="clearfix"><span>固定电话：</span><input type="text" id="phone" class="input_txt"></li>
		                <li class="clearfix"><span><font color="e61d47"><strong>*</strong></font>所在地区：</span>
		                    <div class="xm-select" >
		                        <div class="dropdown">
		                            <label class="iconfont" for="feedbackType"></label>
		                            <select id="province_id" onchange="javascript:get_city('province_id','city_id',0,0,1);">
		                               	<option value="">--选择省--</option>
		                               	<?php if ($areaList) { ?>
		                               	<?php foreach($areaList as $key=>$value) { ?>
			              				<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
			              				<?php }} ?>
		                            </select>
		                        </div>
		                    </div>
		                    <div class="xm-select" >
		                        <div class="dropdown">
		                            <label class="iconfont" for="feedbackType"></label>
		                            <select id="city_id" onchange="javascript:get_city('city_id','area_id',0,0,0);">
		                                 <option value="">--选择市--</option>
		                            </select>
		                        </div>
		                    </div>
		                    <div class="xm-select" >
		                        <div class="dropdown">
		                            <label class="iconfont" for="feedbackType"></label>
		                            <select id="area_id">
		                                 <option value="">--选择区/县--</option>
		                            </select>
		                        </div>
		                    </div>
		                    <div class="clear"></div>
		                    <div style="margin-top:10px;">
		                        <span><font color="e61d47"><strong>*</strong></font>详细地址：</span>
		                        <textarea id="address" class="textarea_txt" placeholder="详细地址"></textarea>
		                    </div>
		                </li>
		                <li class="clearfix"><span>邮编：</span><input type="text" id="zip" maxlength="6" class="input_txt"> </li>
		                <li class="clearfix"><span>邮箱：</span><input type="text" id="email" class="input_txt"> </li>
		                <li class="clearfix"><span>&nbsp;</span><dl class="m_check"><dd><span id="checkWeek" name="checkWeek" class="CheckBoxNoSel CheckBoxSel" style="width:14px"></span>设为默认地址</dd></dl> </li>
		                <li class="clearfix"><span>&nbsp;</span><input onclick="javascript:submit_address();" type="button" value="提交" class="btn_r" style="border:none;"></li>
		           </ul>
            </div>
        </div>
<script type="text/javascript">
	var is_sub_click = false;
	var edit_item_id = 0;
	function add_address() {
		$('#title_span').html('添加收货地址');
		edit_item_id = 0;
		$("#province_id").get(0).options[0].selected = true;
		$('#city_id').html('<option value="">--选择市--</option>');
		$('#area_id').html('<option value="">--选择区/县--</option>');
		$('#address').val('');
		$('#buyer_name').val('');
		$('#mobile').val('');
		$('#phone').val('');
		$('#zip').val('');
		$('#email').val('');
		$('#checkWeek').addClass('CheckBoxSel');
		$('#add_address').addClass('active');
	}
	
	function close_address() {
		$('#add_address').removeClass('active');
	}
	
	function submit_address() {
		var buyer_name = $('#buyer_name').val();
		var mobile = $('#mobile').val();
		var phone = $('#phone').val();		
		var province_id = $('#province_id').val();
		var city_id = $('#city_id').val();
		var area_id = $('#area_id').val();
		var address = $('#address').val();
		var zip = $('#zip').val();
		var email = $('#email').val();
		var is_default = 0;
		if($('#checkWeek').hasClass('CheckBoxSel')) {
			is_default = 1;
		}
		if (!buyer_name) {
			return my_alert('buyer_name', 1, '请输入收货人姓名');
		}
		if (!mobile) {
			return my_alert('mobile', 1, '请输入手机号码');
		}
		var mobile_zz = /^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/;
		if(!mobile_zz.test(mobile)) {
			return my_alert('mobile', 1, '请输入正确的手机号');
		}
		if (phone) {
			var phone_zz = /^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/;
			if(!phone_zz.test(phone)) {
				return my_alert('phone', 1, '请输入正确的固定电话');
			}
		}
		if (!province_id) {
			return my_alert('province_id', 1, '请选择省');
		}
		if (!city_id) {
			return my_alert('city_id', 1, '请选择市');
		}
		if (!address) {
			return my_alert('address', 1, '请输入详细地址');
		}
		if (zip) {
			var zip_zz = /^[1-9]\d{5}$/;
			if(!zip_zz.test(zip)) {
				return my_alert('zip', 1, '请输入正确的邮编');
			}
		}
		if (email) {
			var email_zz = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;
			if(!email_zz.test(email)) {
				return my_alert('email', 1, '请输入正确的邮箱');
			}
		}
		$.post(base_url + "index.php/cart/save_address/"+edit_item_id,
               {'buyer_name' : buyer_name,
                'mobile':mobile,
                'phone':phone,
                'zip':zip,
                'email':email,
                'province_id':province_id,
                'city_id':city_id,
                'area_id':area_id,
                'address':address,
                'default':is_default
               },
                function (res) {
                    if (res.success) {
                    	var str_class = '';
                    	if (res.data.default == 1) {
                    		$("#addr_list li").removeClass("is_default");
                    		str_class = 'class="is_default"';
                    	}
                    	var html = '<li id="list_li_'+res.data.id+'" item_id="'+res.data.id+'" onclick="javascript:select_address(this);" '+str_class+'>';
                            html += '<div class="title">';
                            html += '<div class="name" style="width:auto;border:none;background:none;"> '+res.data.buyer_name+'<span class="space"></span>收</div>';
                            html += '<div class="default">';
                            html += '   <a onclick="javascript:set_default_user_address(this,'+res.data.id+');" href="javascript:void(0);" class="set red">设为默认</a>';
                            html += '   <span class="ok">默认地址</span>';
                            html += '</div>';
                            html += '</div>';
                            html += '<div class="text-box">';
                            html += '<p>'+res.data.txt_address+'</p>';
                            html += '<p>'+res.data.address+'</p>';
                            html += '<p>'+res.data.mobile+'</p>';
                            html += '</div>';
                            html += '<div class="opn"><a onclick="javascript:change_user_address('+res.data.id+');" href="javascript:void(0);">修改</a><span class="space2"></span><a onclick="javascript:delete_item('+res.data.id+');" href="javascript:void(0);">删除</a></div>';
                            html += '<i class="ico-yes icon"></i>';
                            html += '</li>';
                        if (edit_item_id) {
                        	$('#list_li_' + edit_item_id).replaceWith(html);
                        } else {
                        	var size = $('#addr_list').find('li').size();
	                        if (size > 0) {
	                        	$('#addr_list li:last').after(html);
	                        } else {
	                        	$('#addr_list').html(html);
	                        }
                        }
                        $('#add_address').removeClass('active');
                    } else {
                        return my_alert('fail', 0, res.message);
                    }
                },
                "json"
            );
	}
	
	function delete_item(id) {
		is_sub_click = true;
		$.post(base_url + "index.php/cart/delAddress",
               {'id' : id
               },
                function (res) {
                	is_sub_click = false;
                    if (res.success) {
                    	$('#list_li_'+id).remove();
                    	$('#user_address_i_1').html('');
                        $('#user_address_i_2').html('');
                    } else {
                        return my_alert('fail', 0, res.message);
                    }
                },
                "json"
            );
	}
	
	//设置默认的用户地址
	function set_default_user_address(obj, id) {
		is_sub_click = true;
		$.post(base_url+"index.php/cart/setDefault",
				{	"id": id
				},
				function(res){
					is_sub_click = false;
					if(res.success){
						$("#addr_list li").removeClass("is_default");
						$(obj).parent().parent().parent().addClass("is_default");
					}else{
						return my_alert('fail', 0, res.message);
					}
				},
				"json"
		);
	}
	
	function get_city(cur_id, next_id, next_select_val, prev_select_val, is_city) {
		var parent_id = $("#"+cur_id).val();	
		if (prev_select_val) {
			parent_id = prev_select_val;
		}
		$.post(base_url+"index.php/cart/get_city", 
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
						return my_alert('fail', 0, res.message);
					}
				},
				"json"
		);
	}
	
	//修改收货地址
	function change_user_address(id) {
		is_sub_click = true;
		edit_item_id = id;
		$('#title_span').html('修改收货地址');
		$.post(base_url+"index.php/cart/get_user_address",
				{	"id": id
				},
				function(res){
					is_sub_click = false;
					if(res.success){
						$("#province_id>option").each(function(i,n){
							if($(n).val() == res.data.province_id){
								 $("#province_id").get(0).options[i].selected = true;
							}
						});
						get_city('province_id','city_id',res.data.city_id,res.data.province_id,1);
						get_city('city_id','area_id',res.data.area_id,res.data.city_id,0);
						$('#address').val(res.data.address);
						$('#buyer_name').val(res.data.buyer_name);
						$('#mobile').val(res.data.mobile);
						$('#phone').val(res.data.phone);
						$('#zip').val(res.data.zip);
						$('#email').val(res.data.email);
						if (res.data.default == 1) {
							$('#checkWeek').addClass('CheckBoxSel');
						} else {
							$('#checkWeek').removeClass('CheckBoxSel');
						}
						$('#add_address').addClass('active');
					} else {
						return my_alert('fail', 0, res.message);
					}
				},
				"json"
		);
	}
	
	function change_checkbox() {
		get_postage_price();
	}

	change_checkbox();

    function select_address(obj) {
    	if (is_sub_click == true) {
    		return;
    	}
    	$("#addr_list li").removeClass("active");
        $(obj).addClass("active");
        get_postage_price();
    }

    function get_postage_price() {
        var user_address_id = $("#addr_list li.active").attr('item_id');
        var use_score = $('input[name="use_score"]:checked').val();
        if (!use_score) {
        	use_score = 0;
        }
    	$.post(base_url + "index.php/cart/get_postage_price",
               {'address_id' : user_address_id,
                'cart_ids':'<?php echo $cart_ids; ?>',
                'use_score':use_score
               },
                function (res) {
                    if (res.success) {
                    	if (use_score) {
                            $('.use_money').hide();
                            $('.use_score').show();
                        } else {
                        	$('.use_money').show();
                            $('.use_score').hide();
                        }

                        $('#gold_give_score').html(res.data.gold_give_score);
                        $('#silver_give_score').html(res.data.silver_give_score);
                        $('#consume_score_total').html(res.data.consume_score_total);
                        $('#consume_score_total_2').html('+'+res.data.consume_score_total+'积分');
                        $('#product_total').html('+￥'+res.data.product_total);
                        $('#postage_price').html('+￥'+res.data.postage_price);
                        $('#total').html('￥'+res.data.total);
                        $('#postage_template_id').val(res.data.postage_template_id);
                        $('#postage_template_name').html(res.data.postage_template_name);                        
                        $('#user_address_i_1').html(res.data.user_address_info.txt_address+res.data.user_address_info.address);
                        $('#user_address_i_2').html(res.data.user_address_info.buyer_name+' '+res.data.user_address_info.mobile);
                    } else {
                        return my_alert('fail', 0, res.message);
                    }
                },
                "json"
            );
    }

    function submit_order() {
    	var user_address_id = $("#addr_list li.active").attr('item_id');
        var use_score = $('input[name="use_score"]:checked').val();
        if (!use_score) {
        	use_score = 0;
        }

    	$.post(base_url + "index.php/order/add",
               {
    		   user_address_id: user_address_id,
               cart_ids: '<?php echo $cart_ids;?>',
               use_score : use_score
               },
                function (res) {
                    if (res.success) {
                    	my_alert_url(res.field, res.message);
                    } else {
                        return my_alert('fail', 0, res.message);
                    }
                },
                "json"
            );
    }
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
