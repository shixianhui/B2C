<div class="cate-r f">
    <div class="cate-r">
                 <div class="dabaoad"><a href="http://www.68ecshop.com/article-1734.html"  >
    <img src="images/default/dabaoad.jpg" alt="商之翼ecshop打包版下载" /></a>
    </div>
     <div class="blank10" style="margin-top:5px;"></div>
    	<div class="xiazai">
    <dl>
        <dt class="font3">ECSHOP下载</dt>
        <dt class="font4">最新ECSHOP V2.7.3 正式版</dt>
        <dd class="button"><a href="http://www.68ecshop.com/ecshop_topic/ecshop_about/"  >点击下载</a></dd>
    </dl>
</div>             <div class="blank10"></div>
    <div class="xiazai-1" style="margin-top:5px;">
      <dl>
        <dt class="font5">补丁下载专区</dt>
                <dd><a href="article-1750.html" class="font6">【补丁下载】发布 ECShop V2.7.3...</a></dd>
                <dd><a href="article-1319.html" class="font6">【补丁下载】发布 ECShop V2.7.3...</a></dd>
                <dd><a href="article-987.html" class="font6">【补丁下载】发布ECShop V2.7.3 ...</a></dd>
              </dl>
    </div>
         <div class="blank10"></div>
    <div class="chanpin">
    <h4 class="font5">产品专区</h4>
    <dl class="chanpin1">
        <dd class="link"><a href="http://www.68ecshop.com/ecshop_topic/brand/"  >电商视觉营销</a></dd>
        <dd class="link"><a href="http://www.68ecshop.com/ecshop_topic/xjd/" target="">小京东</a></dd>
        <dd class="link"><a href="http://www.68ecshop.com/ecshop_topic/szy_ecshop/index_dsh.html"  >商之翼单商户</a></dd>
        <dd class="link"><a href="http://www.68ecshop.com/ecshop_topic/szy_ecshop/"  >商之翼多商户</a></dd>
        <dd class="link"><a href="http://www.68ecshop.com/ecshop_topic/appv3/"  >APP V3.0</a></dd>
        <dd class="link"><a href="http://www.68ecshop.com/vecshop.html"  >微商城</a></dd>
    </dl>
</div>    </div>
    <div style="height:0px; line-height:0px; clear:both;"></div>
    
    <div class="bor bgwhite t">
    <div class="cate-r">
        <h2 class="art-t"><i class="icon"></i>人气文章</h2>
        <ul class="art">
            <ul>
            <?php 
            $cus_list = $this->advdbclass->get_cus_list($template, $menuId, 'c', 0, 10);
            if ($cus_list) {
            	foreach ($cus_list as $key=>$item) {
				$url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "{$template}/detail/{$item['id']}.html", $client_index);
			    $str_class = '';
			    if ($key > 2) {
			    	$str_class = 'class="hui"';
			    }
				?>
            <li><span <?php echo $str_class; ?>><?php echo $key+1; ?></span><a href="<?php echo $url; ?>" title="<?php echo clearstring($item['title']); ?>"><?php echo my_substr($item['title'], 40); ?></a></li>
            <?php }} ?>
            </ul>
        </ul>
    </div>
    </div>
    </div>