<div class="warp">
    <div class="seat"><?php echo $location; ?></div>
    <div class="module_box">
        <div class="filter">
            <dl class="clearfix">
                <dt>您已选择：</dt>
                <dd class="list" id="chose">
             <?php if ($brand_name) { ?>
				<li onclick="javascript:window.location.href='<?php echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$category_id}-0-{$score_type}.html",$client_index);?>';" class="selected">品牌:<em><?php echo $brand_name; ?></em><i>×</i></li>
			<?php } ?>
			<?php if ($parent_category_name && $category_name) { ?>
				<li onclick="javascript:window.location.href='<?php echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-0-{$brand_id}-{$score_type}.html",$client_index);?>';" class="selected">分类:<em><?php echo $parent_category_name; ?></em><i>×</i></li>
			   <?php if ($category_name) { ?>
			        <li onclick="javascript:window.location.href='<?php echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$parent_category_id}-{$brand_id}-{$score_type}.html",$client_index);?>';" class="selected">><em><?php echo $category_name; ?></em><i>×</i></li>
				<?php } ?>
			<?php } else { ?>
	            <?php if ($category_name) { ?>
					<li onclick="javascript:window.location.href='<?php echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-0-{$brand_id}-{$score_type}.html",$client_index);?>';" class="selected">分类:<em><?php echo $category_name; ?></em><i>×</i></li>
				<?php } ?>
			<?php } ?>
			<?php if ($score_type_name) { ?>
				<li onclick="javascript:window.location.href='<?php echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$category_id}-{$brand_id}-0.html",$client_index);?>';" class="selected">换购:<em><?php echo $score_type_name; ?></em><i>×</i></li>
			<?php } ?>
                </dd>
            </dl>
            <dl>
                <dt>品牌分类：</dt>
                <dd class="list">
                    <ul class="brand_con">
                         <?php
                           if($brand_list) {
                               foreach($brand_list as $item) {
                                   $url = getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$category_id}-{$item['id']}-{$score_type}.html",$client_index);
                        ?>
                        <li><a href="<?php echo $url;?>" <?php echo $brand_id == $item['id'] ? 'class="current"' : '';?>><img src="<?php echo preg_replace('/\./', '_thumb.', $item['path']);?>" alt="<?php echo $item['brand_name'];?>"> <em <?php echo $brand_id == $item['id'] ? 'class="current"' : '';?>><?php echo $item['brand_name'];?></em></a></li>
                        <?php }}?>
                    </ul>
                    <span class="all">更多<i class="icon_zhankai icon"></i></span>
                </dd>
            </dl>
            <?php if ($product_category_list) { ?>
            <dl>
                <dt>商品分类：</dt>
                <dd class="list">
                    <ul class="category">
                        <li><a href="<?php echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$category_id}-{$brand_id}-{$score_type}.html",$client_index);?>"  <?php echo !$parent_category_id ? 'class="current"' : '';?>>全部</a></li>
                        <?php
                        foreach($product_category_list as $item) {
                        ?>
                        <li><a href="<?php echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$item['id']}-{$brand_id}-{$score_type}.html",$client_index);?>" <?php echo $category_id == $item['id'] ? 'class="current"' : '';?>><?php echo $item['product_category_name'];?></a></li>
                        <?php } ?>
                    </ul>
                    <span class="all">更多<i class="icon_zhankai icon"></i></span>
                </dd>
            </dl>
            <?php } ?>
            <dl>
                <dt>积分换购：</dt>
                <dd class="list">
                    <ul class="category">
                    	<li><a href="<?php echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$category_id}-{$brand_id}-0.html",$client_index);?>"  <?php echo !$score_type ? 'class="current"' : '';?>>全部</a></li>
                        <?php if ($score_type_arr) { ?>
                        <?php foreach($score_type_arr as $key=>$value) { ?>
                        <li><a href="<?php echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$category_id}-{$brand_id}-{$key}.html",$client_index);?>" <?php echo $score_type == $key ? 'class="current"' : '';?>><?php echo $value[0]; ?></a></li>
                        <?php }} ?>
                    </ul>
                </dd>
            </dl>
        </div>
    </div>
    <div class="sort_bar mt10">
        <div class="array">
            <ul>
                <li <?php echo $order == 'id' ? ' class="selected"' : '';?>><a href="<?php echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$category_id}-{$brand_id}-{$score_type}.html",$client_index);?><?php if ($search_keyword) {echo '?search_keyword='.$search_keyword;} ?>" title="综合排序">综合排序</a></li>
                <li <?php echo $order=='sales' ? ' class="selected"' : '';?>><a href="<?php if($by=='asc'){$by_str='desc';}else{$by_str='asc';}echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$category_id}-{$brand_id}-{$score_type}-sales-{$by_str}.html",$client_index);?><?php if ($search_keyword) {echo '?search_keyword='.$search_keyword;} ?>" title="销量">销量<i <?php echo $order=='sales'&& $by=='desc' ? 'style="background-position:0px 3px"' : '';?> <?php echo $order=='sales'&& $by=='asc' ? 'style="background-position:0px -11px"' : '';?>></i></a></li>
                <li <?php echo $order=='sell_price' ? ' class="selected"' : '';?>><a href="<?php if($by=='asc'){$by_str='desc';}else{$by_str='asc';}echo getBaseUrl(false,'',"product/index/80-{$product_venue_id}-{$category_id}-{$brand_id}-{$score_type}-sell_price-{$by_str}.html",$client_index);?><?php if ($search_keyword) {echo '?search_keyword='.$search_keyword;} ?>" title="价格">价格<i <?php echo $order=='sell_price'&& $by=='desc' ? 'style="background-position:0px 3px"' : '';?> <?php echo $order=='sell_price'&& $by=='asc' ? 'style="background-position:0px -11px"' : '';?>></i></a></li>
            </ul>
        </div>
    </div>
    <div class="porduct_item ">
        <ul>
            <?php
                if($item_list){
                    foreach($item_list as $item){
                        $url = getBaseUrl(false,'',"product/detail/{$item['id']}.html",$client_index);
            ?>
            <Li>
                <div class="picture"><a   href="<?php echo $url;?>"><img class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']);?>"></a><!--<span class="tag">拼团</span>--></div>
                <div class="property">
                    <P class="nowrap"><a   href="<?php echo $url;?>"><?php echo $item['title'];?></a></P>
                    <p><span class="price"><small>￥</small><?php echo $item['sell_price'];?><s>￥<?php echo $item['market_price'];?></s></span><a href="<?php echo $url;?>" class="btn">立即抢购</a></p>
                </div>
            </Li>
                    <?php }}else{
                        $keyword = $this->session->userdata('keyword');
                        if($keyword){
                           ?>
                         <h3 class="no_result">没找到“<?php echo $keyword;?>”相关的商品哦。为您推荐如下商品:</h3>;
                           <?php
	            $cus_list = $this->advdbclass->get_product_cus_list('','c',4);
	            if ($cus_list) {
	            	foreach ($cus_list as $item) {
					$url = getBaseUrl(false, "", "product/detail/{$item['id']}.html", $client_index);
				?>
                <Li>
                <div class="picture"><a href="<?php echo $url;?>"><img class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']);?>"></a><!--<span class="tag">拼团</span>--></div>
                <div class="property">
                    <P class="nowrap"><a href="<?php echo $url;?>"><?php echo $item['title'];?></a></P>
                    <p><span class="price"><small>￥</small><?php echo $item['sell_price'];?><s>￥<?php echo $item['market_price'];?></s></span><a href="<?php echo $url;?>" class="btn">立即抢购</a></p>
                </div>
            </Li>
       <?php }} ?>
      <?php }}?>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="pagination">
        <ul><?php echo $pagination;?></ul>
    </div>

</div>
<script>
     //产品排序
var s=$('.sort_bar').offset().top;
	$(window).scroll(function(){
	   var top=$(this).scrollTop()
	    if(top>s){
		   $('.sort_bar').addClass('fix')
		}else{
		   $('.sort_bar').removeClass('fix')
		}
	});
</script>