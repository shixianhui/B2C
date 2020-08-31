<div class="clear"></div>
<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">我的限时抢购活动</span></div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt20">
<!--                <colgroup>
                    <col/>
                    <col width="10%"/>
                    <col width="15%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                </colgroup>-->
                <tr>
                    <th><strong>名称</strong></th>
                    <th><strong>图片</strong></th>
                    <th><strong>尺码/颜色/数量</strong></th>
                    <th><strong>限时抢购价</strong></th>
                    <th><strong>活动结束时间</strong></th>
                    <th><strong>订单状态</strong></th>
                </tr>
                <?php
                    if($flash_sale_info){
                        foreach($flash_sale_info as $item){
                ?>
                        <tr>
                            <td align="center" class="title"><?php echo my_substr($item['name'],20);?></td>
                            <td align="center"><img src="<?php echo str_replace('.','_thumb.',$item['path']);$item['path'];?>" style="width:60px;"></td>
                            <td align="center"><?php echo $item['size_name'].'/'.$item['color_name'].'/1';?></td>
                            <td align="center">￥<?php echo $item['flash_sale_price'];?></td>
                            <td align="center"><?php echo date('Y-m-d H:i:s',$item['end_time']);?></td>
                            <td align="center"><?php echo $item['status'];?></td>
                        </tr>
                    <?php }}?>
            </table>
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
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

