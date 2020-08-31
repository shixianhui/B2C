<div class="warp">
      <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">收藏产品</span></div>
            <div class="member_product">
                <ul>
                     <?php if ($item_list) { ?>
		<?php foreach ($item_list as $key=>$value) {
			  $url = getBaseUrl($html, "", "product/detail/{$value['product_id']}.html", $client_index);
			?>
                    <Li><div class="picture"><a href="<?php echo $url;?>"><img class="lazy" src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>"></a></div>
                        <div class="property"><P class="nowrap"><a href="<?php echo $url;?>"><?php echo $value['title']; ?></a></P>
                            <p><span class="price"><small>￥</small><?php echo $value['sell_price']; ?><s>￥<?php echo $value['market_price']; ?></s></span></p>
                            <div class="btn"><a href="<?php echo $url;?>" class="m_btn">购买</a><a href="javascript:void(0)" class="m_btn gray" onclick="javascript:delete_favorite('<?php echo $value['id']; ?>');">取消</a></div>
                        </div>
                    </Li>
                 <?php }} ?>
                </ul>   
            </div>
                <div class="clear"></div>
                        <div class="pagination"> 
                            <ul><?php echo $pagination; ?></ul>
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
    function delete_favorite(id) {
	var con = confirm("您确定要删除此收藏吗 ？删除后将不可恢复！");
	if (con == true) {
		$.post(base_url+"index.php/user/my_delete_favorite", 
				{	"id": id
				},
				function(res){
					if(res.success){
						for (var i = 0, data = res.data.id, len = data.length; i < len; i++){
							$("#li_item_"+data[i]).remove();
						}
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
                                                    location.reload();
						}, 2000);
						return false;
						return false;
					}
				},
				"json"
		);
	}
}
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>