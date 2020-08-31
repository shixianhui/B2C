<div class="warp">
 <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">新增收货地址</span></div>
            <div class="clear"></div>
             <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="jsonForm" name="jsonForm" method="post">
            <ul class="m_form" >
                <li class="clearfix"><span><font color="e61d47"><strong>*</strong></font>收货人：</span><input type="text" value="<?php if ($item_info){echo $item_info['buyer_name'];} ?>" id="buyer_name" name="buyer_name" valid="required" errmsg="姓名不能为空" class="input_txt"></li>
                <li class="clearfix"><span><font color="e61d47"><strong>*</strong></font>手机号码：</span><input type="text" value="<?php if ($item_info){echo $item_info['mobile'];} ?>" id="mobile" name="mobile" valid="required|isMobile" errmsg="请输入手机号|请输入正确的手机号" class="input_txt"></li>
                <li class="clearfix"><span>固定电话：</span><input type="text" value="<?php if ($item_info){echo $item_info['phone'];} ?>" id="phone" name="phone" valid="isPhone" errmsg="请输入固定电话" class="input_txt"></li>
                <li class="clearfix"><span><font color="e61d47"><strong>*</strong></font>所在地区：</span>
                    <div class="xm-select" >
                        <div class="dropdown">
                            <label class="iconfont" for="feedbackType"></label>
                            <select id="province_id" name="province_id" onchange="javascript:get_city('province_id','city_id',0,0,1);">
                               <option value="">--选择省--</option>
                                <?php if ($areaList) { ?>
	              <?php foreach ($areaList as $area) {
		              	$selector = '';
		              	if ($item_info) {
		              		if ($item_info['province_id'] == $area['id']) {
		              			$selector = 'selected="selected"';
		              		}
		              	}
	              	?>
	              <option <?php echo $selector; ?> value="<?php echo $area['id']; ?>"><?php echo $area['name']; ?></option>
	              <?php }} ?>
                            </select>
                        </div>
                    </div>
                    <div class="xm-select" >
                        <div class="dropdown">
                            <label class="iconfont" for="feedbackType"></label>
                            <select id="city_id" name="city_id" onchange="javascript:get_city('city_id','area_id',0,0,0);">
                                 <option value="">--选择市--</option>
                            </select>
                        </div>
                    </div>
                    <div class="xm-select" >
                        <div class="dropdown">
                            <label class="iconfont" for="feedbackType"></label>
                            <select id="area_id" name="area_id">
                                 <option value="">--选择区/县--</option>
                            </select>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div style="margin-top:10px;">
                        <span><font color="e61d47"><strong>*</strong></font>详细地址：</span>
                        <textarea id="address" name="address" class="textarea_txt" placeholder="详细地址" ><?php if ($item_info){echo $item_info['address'];} ?></textarea>
                    </div>
                </li>
                <li class="clearfix"><span>邮编：</span><input type="text" value="<?php if ($item_info){echo $item_info['zip'];} ?>" id="zip" name="zip" maxlength="6" valid="isZip" errmsg="请输入正确的邮编" class="input_txt"> </li>
                <li class="clearfix"><span>邮箱：</span><input type="text" value="<?php if ($item_info){echo $item_info['email'];} ?>" id="email" name="email"  valid="isEmail" errmsg="请输入正确的邮编" class="input_txt"> </li>
                <li class="clearfix"><span>&nbsp;</span><dl class="m_check"><dd><span name="checkWeek" class="CheckBoxNoSel<?php if($item_info){echo $item_info['default']==1 ? ' CheckBoxSel' : '';}?>" onclick="selectDefault(this)" style="width:14px"></span>设为默认地址<input type="hidden" name="default" value="<?php if ($item_info){echo $item_info['default'];}?>"></dd></dl> </li>
                <li class="clearfix"><span>&nbsp;</span><input type="submit" value="提交" class="btn_r" style="border:none;"></li>  
            </ul>
                  </form>
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
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
<script type="text/javascript">
function get_city(cur_id, next_id, next_select_val, prev_select_val, is_city) {
	var parent_id = $("#"+cur_id).val();	
	if (prev_select_val) {
		parent_id = prev_select_val;
	}
	$.post(base_url+"index.php/user/get_city", 
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
<?php if ($item_info) { ?>
get_city('province_id','city_id','<?php echo $item_info['city_id']; ?>','<?php echo $item_info['province_id']; ?>',1);
get_city('city_id','area_id','<?php echo $item_info['area_id']; ?>','<?php echo $item_info['city_id']; ?>',0);
<?php } ?>
 
function selectDefault(_this){
    if(!$(_this).hasClass('CheckBoxSel')){
        $('input[name=default]').val(1);
    }else{
        $('input[name=default]').val(0);
    }
}
</script>