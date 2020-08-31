<div class="warp">
             <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
            <div class="member_right">

                <div class="box_shadow clearfix mt20 m_border">
                    <div class="member_title"><span class="bt">收货地址</span></div>
                    <div class="fr mt20"><a href="<?php echo getBaseUrl(false,'','user/save_address', $client_index)?>" class="btn_r"><i class="icon fb_icon"></i>新增收货地址</a></div>
                    <div class="clear"></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt20">
                        <tbody>
                            <tr>
                                <th colspan="" align="left"></th>
                                <th><strong>收货人</strong></th>
                                <th class="tal"><strong>详细地址</strong></th>
                                <th><strong>邮编</strong></th>
                                <th><strong>联系电话</strong></th>
                                <th><strong>操作</strong></th>
                            </tr>
                              <?php if ($user_address_list) { ?>
		<?php foreach ($user_address_list as $key=>$value) { ?>
                            <tr>
                                <td width="5%" valign="middle"><span name="checkWeek" class="CheckBoxNoSel fl checkbox" style=" margin-right:5px;" data-address_id="<?php echo $value['id'];?>"></span></td>
                                <td width="11%" align="center"><?php echo $value['buyer_name']; ?></td>
                                <td width="40%" align="left"><?php echo $value['txt_address']; ?> <?php echo $value['address']; ?></td>
                                <td width="12%" align="center"><?php echo $value['zip']; ?></td>
                                <td width="14%" align="center" ><?php echo $value['mobile']; ?></td>
                                <td width="18%" align="center"><a href="<?php echo getBaseUrl(false, "", "user/save_address/{$value['id']}.html", $client_index); ?>" class="m_btn mr5 gray">编辑</a><?php if ($value['default']) { ?><a class="m_btn">默认地址</a><?php }else{?><a href="javascript:void(0)" onclick="javascript:changedefault(<?php echo $value['id']; ?>, 1);"  class="m_btn gray">设置默认</a><?php }?></td>
                            </tr>  
             <?php }} ?>    
                        </tbody>
                    </table>
                    <div class="delete_cuont mt20"><span name="checkWeek" class="CheckBoxNoSel fl" style="margin-top:2px; margin-right:5px;" id="selectAll"></span>全选<a href="javascript:;"  id="delete"><span class="icon delete_icon"></span>删除</a></div>
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
function changedefault(id, state) {
	$.post(base_url+"index.php/user/my_change_default", 
			{	
				"id": id,
				"state": state
			},
			function(res){
				if(res.success){
					var d = dialog({
					    title: '提示',
					    fixed: true,
					    content: res.message
					});
					d.show();
					setTimeout(function () {
						window.location.reload();
					    d.close().remove();
					}, 2000);
					return false;
				}else{
					var d = dialog({
					    title: '提示',
					    fixed: true,
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
$("#selectAll").click(function(){
    if(!$(this).hasClass('CheckBoxSel')){
        $(".checkbox").addClass('CheckBoxSel');

    }else{
        $(".checkbox").removeClass('CheckBoxSel');
    };
});
$("#delete").click(function(){
    var ids = '';
    $(".checkbox").each(function(){
        if($(this).hasClass('CheckBoxSel')){
             ids += $(this).data('address_id')+',';
        }
    });
   if(!ids){
       var d = dialog({
                        title: '提示',
                        fixed: true,
                        content: '请选择您要删除的地址'
                    });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);
            return;
   }
   $.post(base_url+"index.php/user/delete_address", 
			{	
				"address_ids": ids,
			},
			function(res){
				if(res.success){
					var d = dialog({
					    title: '提示',
					    fixed: true,
					    content: res.message
					});
					d.show();
					setTimeout(function () {
						window.location.reload();
					    d.close().remove();
					}, 2000);
					return false;
				}else{
					var d = dialog({
					    title: '提示',
					    fixed: true,
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
})
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

