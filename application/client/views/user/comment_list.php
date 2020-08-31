<div class="clear"></div>
<div class="warp">
     <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
 <div class="member_right">
   <div class="box_shadow clearfix mt20 m_border">
     <div class="member_title"><span class="bt">我的评价</span></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt20">
  <tbody>
  <tr>
  	<th colspan="3" class="tal"><strong>商品信息</strong></th>
    <th><strong>评分</strong></th>
    <th class="tal"><strong>评价内容</strong></th>
    <th class="tal"><strong>评价时间</strong></th>
  </tr>
  <?php
  if ($comment_list) {
  foreach($comment_list as $item){
      $url = getBaseUrl(false,"","product/detail/{$item['product_id']}.html", $client_index)
  ?>
  <tr>
    <td width="70" align="left">
    	<a href="<?php echo $url;?>"  >
    		<img class="lazy" style="width: 60px;height: 60px;" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']);?>" />
    	</a>
    </td>
    <td align="left">
    	<a style="color: #000000;" href="<?php echo $url;?>"  >
    	<?php echo $item['product_title'];?>
    	</a>
    	sdfasdfa sadfasdf
    </td>
    <td width="60">¥<?php echo $item['sell_price'];?></td>
    <td width="150px" align="center">
    	<div class="start" style="width: 140px;">
            <dl>
            	<?php if ($item['grade'] >= 1) { ?>
                    <dd class="on"><a href="javascript:void(0);">1</a></dd>
                <?php } else { ?>
                	<dd><a href="javascript:void(0);">1</a></dd>
                <?php } ?>
                <?php if ($item['grade'] >= 2) { ?>
                    <dd class="on"><a href="javascript:void(0);">2</a></dd>
                <?php } else { ?>
                	<dd><a href="javascript:void(0);">2</a></dd>
                <?php } ?>
                <?php if ($item['grade'] >= 3) { ?>
                    <dd class="on"><a href="javascript:void(0);">3</a></dd>
                <?php } else { ?>
                	<dd><a href="javascript:void(0);">3</a></dd>
                <?php } ?>
                <?php if ($item['grade'] >= 4) { ?>
                    <dd class="on"><a href="javascript:void(0);">4</a></dd>
                <?php } else { ?>
                	<dd><a href="javascript:void(0);">4</a></dd>
                <?php } ?>
                <?php if ($item['grade'] >= 5) { ?>
                    <dd class="on"><a href="javascript:void(0);">5</a></dd>
                <?php } else { ?>
                	<dd><a href="javascript:void(0);">5</a></dd>
                <?php } ?>
            </dl>
        </div>
    </td>
    <td width="30%" align="left"><div class="info"><?php echo $item['content'];?></div></td>
    <td width="70" align="center"><?php echo date('Y-m-d H:i', $item['add_time']);?></td>
  </tr>
  <?php }} ?>
  </tbody>
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

<script type="text/javascript" language="javascript" src="js/main.js"></script>

