<?php echo $this->load->view('element/topbar_tool', '', TRUE); ?>
<div class="clear"></div>
<div class="header clearfix">
    <div class="warp">
        <a href="<?php echo base_url(); ?>" class="logo"><img src="images/default/logo.png"></a>
        <?php echo $this->load->view('element/cart_tool', '', TRUE); ?>
        <div class="seach">
            <form action="<?php echo getBaseUrl(false, "", "product/index/80.html", $client_index); ?>" method="get" name="search_form">
            <input type="text" id="search" placeholder="请输入关键字搜索"  name="search_keyword" autocomplete="off" value="<?php if (isset($search_keyword)) {echo $search_keyword;} ?>"><input type="submit" value="搜索" style="border:0;" class="btn">
            <div class="keyword">热销特卖：
                <?php
                $tmp_arr = $this->advdbclass->getKeyword();
                $keyword_list = explode('|',$tmp_arr['link_keyword']);
                if($keyword_list){
                    foreach($keyword_list as $word){
                ?>
                <a href="javascript:;"><?php echo $word;?></a>
                <?php }}?>
            </div>
            <script>
                $('.keyword a').click(function(){
                     $('#search').val($(this).html());
                     $("form[name=search_form]").trigger('submit');
                });
            </script>
            </form>
        </div>
    </div>
</div>
<div class="menu">
    <nav class="nav">
        <div class="all-category">
            <div class="title"><a href="javascript:void(0);">全部分类<i class="icon"></i></a></div>
            <div class="category">
                <ul class="menu">
               <?php
                    $product_category_list = $this->advdbclass->get_product_category_list();
                    if ($product_category_list) {
                        foreach ($product_category_list as $key => $product_category) {
                            $url = getBaseUrl($html, "", "product/index/80-{$product_category['product_venue_id']}-{$product_category['id']}.html", $client_index);
                            ?>
                            <li cat_id="<?php echo $product_category['id']; ?>">
                                <div class="class">
                                    <a href="<?php echo $url; ?>"  ><i class="menu_<?php echo $key+1;?>" style="background-image:url(images/default/pzg_icon.png);"></i><?php echo $product_category['product_category_name']; ?></a>
                                </div>
                                <div class="sub-class" cat_menu_id="<?php echo $product_category['id']; ?>" >
                                    <dl>
                                        <?php
                                        if ($product_category['subMenuList']) {
                                            foreach ($product_category['subMenuList'] as $k => $sub_product_category) {
                                                $url = getBaseUrl($html, "", "product/index/80-{$product_category['product_venue_id']}-{$sub_product_category['id']}.html", $client_index);
                                                ?>
                                                <dd><a href="<?php echo $url; ?>"  ><?php echo $sub_product_category['product_category_name']; ?></a></dd>
                                            <?php }
                                        } ?>
                                    </dl>
                                </div>
                            </li>
               <?php }} ?>
                </ul>
            </div>
        </div>
        <ul class="site-menu">
            <li><a href="<?php echo base_url(); ?>" <?php echo !$this->uri->segment(1) ? 'class="current"' : '';?>>首页</a></li>
            <?php
            $menuList = $this->advdbclass->getNavigationMenu();
            if ($menuList) {
                foreach ($menuList as $key => $menu) {
                    if ($menu['menu_type'] == '3') {
                        $url = $menu['url'];
                    } else {
                        if ($menu['menu_type'] == 1 && $menu['cover_function']) {
                            $url = getBaseUrl($html, "{$menu['html_path']}/{$menu['cover_function']}{$menu['id']}.html", "{$menu['template']}/{$menu['cover_function']}/{$menu['id']}.html", $client_index);
                        } else {
                            $url = getBaseUrl($html, "{$menu['html_path']}/index{$menu['id']}.html", "{$menu['template']}/index/{$menu['id']}.html", $client_index);
                        }
                    }
                    ?>
                    <li><a href="<?php echo $url; ?>"   <?php echo $_SERVER['REQUEST_URI'] == '/'.$url ? 'class="current"' : '';?>><?php echo $menu['menu_name']; ?></a></li>
    <?php }
} ?>
            <li class="activity" id="activity">
                <a href="" class="tit"><i class="icon"></i>活动<em class="arrow"></em></a>
                <div class="subnav" style="height:100px;">
                    <ul>
                                            <?php
	$adList = $this->advdbclass->getAd(37, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                        <li><a href="<?php echo getBaseUrl(false,'','bargain.html',$client_index);?>"  ><img src="<?php echo $ad['path'];?>" style="width:130px;"><span>拼团砍价</span></a></li>
                         <?php }} ?>
<!--                        <li><a href="javascript:alert('建设中...');"><img src="images/default/img1.png"><span>幸运转盘</span></a></li>
                        <li><a href="javascript:alert('建设中...');"><img src="images/default/img1.png"><span>竞猜达人</span></a></li>-->
                             <?php
	$adList = $this->advdbclass->getAd(38, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                        <li><a href="<?php echo getBaseUrl(false,'','purchase.html',$client_index);?>"  ><img src="<?php echo $ad['path'];?>" style="width:130px;"><span>限时抢购</span></a></li>
                     <?php }} ?>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</div>
<script>
  function deleteCart(id) {
        $.post(base_url + "index.php/cart/delBuyNumber",
                {
                    "id": id
                },
        function (res) {
            if (res.success) {
                window.location.reload();
                return false;
            } else {
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
</script>