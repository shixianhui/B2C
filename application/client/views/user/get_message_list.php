<div class="clear"></div>
<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right mt20">
        <div class="box_shadow clearfix m_border">
            <div class="member_title"><span class="bt">消息</span></div>
            <div class="m_notice clearfix">
                <?php
                foreach($message_list as $ls){
                ?>
                <dl class="clearfix">
                    <dt><span name="checkWeek" class="CheckBoxNoSel checkbox fl" data-order_id="<?php echo $ls['id'];?>" style="margin-top:3px; margin-right:5px;"></span>来自 
                    <font class="blue">
                    <?php 
                    if($ls['message_type']=='order'){ echo '订单消息';}
                    if($ls['message_type']=='system'){ echo '系统消息';}
                    ?>
                    </font>
                    </dt>
                    <dd>
                        <span class="time"><?php echo date('m月d日 H:i',$ls['add_time']);?></span>
                        <?php echo $ls['content'];?>
                        <em class="all">详情<i class="icon_zhankai icon"></i></em> 
                    </dd>
                </dl>
                <?php }?>
                <div class="delete_cuont mt20" style="padding-left:0px;"><span name="checkWeek" id="selectAll" class="CheckBoxNoSel fl" style="margin-top:2px; margin-right:5px;"></span>全选<a href="javascript:void(0)" id="delete">×删除</a></div>
            </div>
            <div class="clear"></div>
            <div class="pagination"> 
                <ul><?php echo $pagination; ?></ul>
            </div>  
        </div>
    </div>
</div>
<script>
    $('.m_notice dl dd em').on('click', function () {
        var parent = $(this).parent();
        if (!parent.hasClass('hover')) {
            parent.addClass('hover')
            $(this).html(
                    $(this).html().replace('收起', '详情')
                    .replace('icon_shouqi', 'icon_zhankai')
                    );
        } else {
            parent.removeClass('hover');
            $(this).html(
                    $(this).html().replace('详情', '收起')
                    .replace('icon_zhankai', 'icon_shouqi')
                    );
        }
    })
    $(function () {
        $('.m_notice dl dd em').each(function () {
            var dd = $(this).parent();
            if (dd.height() > 26) {
                $(this).show();
                dd.addClass('hover');
            } else {
                $(this).hide()
            }
        })
    });
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
             ids += $(this).data('order_id')+',';
        }
    });
   if(!ids){
       var d = dialog({
                        title: '提示',
                        fixed: true,
                        content: '请选择您要删除的消息'
                    });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);
            return;
   }
   $.post(base_url+"index.php/user/delete_message", 
			{	
				"ids": ids,
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