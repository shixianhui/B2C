<div class="page-header">
  <div class="w">
    <div class="logo Left"><a href="index.html"><img src="images/default/logo.gif"  alt="" /></a></div>
<div class="topArea Left">
<div class="globa-nav">
<script type="text/javascript" src="js/default/jquery.SuperSlide.2.1.js"></script>
<link href="css/default/nav.css" rel="stylesheet" type="text/css" />
<ul id="nav" class="nav allMenu" style=" z-index:99;margin-left:40px;">
	<li id="selected"><a rel='external nofollow' class="nav" href="<?php if ($html){echo 'index.html';} else {echo $client_index;} ?>"><?php echo $index_name; ?></a></li>
    <?php
    $menuList = $this->advdbclass->getNavigationMenu();    
    if ($menuList) {
    foreach ($menuList as $key=>$menu) {
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
    <li class="<?php echo $menu['en_menu_name']; ?>"><a href="<?php echo $url; ?>" class="nav"><?php echo $menu['menu_name']; ?> <i></i></a>
        <?php if ($key == 0) { ?>
        <div class="sub">
            <div class="sub_body">
                <dl id="sub-left">
                    <dt><em>|</em> 魔豆产品</dt>
                    <dd class="sub-dd1"> 企业站系统 <span style="position:absolute; float:right; margin-top:35px; margin-left:-12px;"><img src="images/default/1.gif" width="22" height="10" alt="ecshop最新小鲸懂V5.0版"></span> <a href="" class="font-dd2"   ><i></i>小鲸懂&nbsp;V5.0版</a> <a href="" class="font-dd2"  ><i></i>商之翼多商户&nbsp;V3.0版</a> B2C商城系统 <a href="" class="font-dd2"   > <i></i> 商之翼单商户&nbsp;V3.0版</a> <a href="" class="font-dd2"   > <i></i> 网店系统介绍</a> </dd>
                    <dd class="sub-dd2"  style="position:relative;">
                        <a href="" class="font-dd1"   >触屏移动端</a>
                        <span style="position:absolute; float:right; margin-left:85px; margin-top:0px;"><img src="images/default/1.gif" width="22" height="10" alt="ecshop最新微商城"></span>  
                        <a href="" class="font-dd2"   ><i></i>商之翼微分销</a>
                        <span style="position:absolute; float:right; margin-left:140px; margin-top:0px;"><img src="images/default/1.gif" width="22" height="10" alt="ecshop最新微商城"></span>  
                        <a href="" class="font-dd2"  ><i></i>微商城&nbsp;V3.0（WAP版）</a>
                        <a href="" class="font-dd2"   ><i></i>APP移动端</a>
                        <a href="" class="font-dd2"   ><i></i>IPAD客户端</a> 
                        <a href="" class="font-dd2"   ><i></i>ECSmart手机端</a>
                    </dd>
                	<dd class="sub-dd3" style="border:0;position:relative;"> <span class="font-dd1" >开源ECSHOP</span>
                        <ol>
                            <li><a href="" class="font-dd2"   > <i></i>商业模板</a></li>
                            <li><a href="" class="font-dd2"  > <i></i>免费模板</a></li>
                            <li><a href="" class="font-dd2"   > <i></i>商业插件</a></li>
                            <li><a href="" class="font-dd2"   > <i></i>免费插件</a></li>
                            
                            <li style=" width:180px"> <span class="biao_two"><img src="images/default/1.gif" width="22" height="10" alt="ecshop最新微商城"></span> <a href="article-1730.html" class="font-dd2"   > <i></i>"0"元建站送主机</a></li>
                        </ol>
                	</dd>
                </dl>
                <dl id="sub-right">
                    <dt><em>|</em> 商之翼服务</dt>
                    <dd><a href=""    >电商视觉营销</a></dd>
                    <dd><a href=""   >电商运营外包</a></dd>
                    <dd><a href=""  >主机域名</a></dd>
                    <dd><a href=""  >SEO优化</a></dd>
                    <dd><a href=""   >商业授权</a></dd>
                </dl>
            </div>
        </div>
        <?php } else if ($key == 1) { ?>
        <div class="sub sub1">
            <dl>
                <dt>类别：</dt>
                <?php
			       $get_brand_list = $this->advdbclass->get_product_brand_list();
			       if ($get_brand_list) {
			           foreach ($get_brand_list as $key=>$value) {
			    ?>
                <dd> <a href=""   ><?php echo $value['brand_name']; ?></a> </dd>
                <?php }} ?>
            </dl>
            <dl>
                <dt>平台：</dt>
                <?php
			       $get_device_list = get_device_arr();
			       if ($get_device_list) {
			           foreach ($get_device_list as $key=>$value) {
			     ?>
                <dd> <a href=""   ><?php echo $value; ?></a> </dd>
                <?php }} ?>
            </dl>
            <dl>
                <dt>色系：</dt>
                 <?php
			     $color_style_arr = get_color_style_arr();
			     if ($color_style_arr) { ?>
			     <?php foreach ($color_style_arr as $key=>$value) { ?>
                <dd> <a href=""  > <img src="<?php echo $value[1]; ?>" width="40" height="40" alt="<?php echo $value[0]; ?>"></a> </dd>
                <?php }} ?>
            </dl>
            <dl>
                <dt>行业：</dt>
                <?php
			    $category_list = $this->advdbclass->get_product_category_list();
			    if ($category_list) {
			    	foreach ($category_list as $key=>$value) {
			    		if ($key < 10) {
			    ?>
                <dd><a href=""   ><?php echo $value['product_category_name']; ?></a> </dd>
                <?php }}} ?>
            </dl>
        </div>
        <?php } ?>
    </li>
<?php }} ?>
</ul>
<script type="text/javascript" src="js/default/navdown.js"></script>
</div>
    </div>
</div>
</div>