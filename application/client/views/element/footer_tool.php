<div class="clear"></div>
<footer class="mt20">
    <div class="cti clearfix">
        <dl><dt class="c_ico1"></dt><dd>正品保证  优质服务</dd></dl>
        <dl><dt class="c_ico2"></dt><dd>多仓直发  快速配送</dd></dl>
        <dl><dt class="c_ico3"></dt><dd>品质护航  轻松购物</dd></dl>
        <dl><dt class="c_ico4"></dt><dd>天天低价  畅选无忧</dd></dl>
    </div>
    <div class="faq">
         <?php $menuTreeList = $this->advdbclass->getMenuClass(173);?>
    <?php if ($menuTreeList) { ?>
	<?php foreach ($menuTreeList as $menuTree) { ?>
        <dl>
            <dt><?php echo $menuTree['menu_name']; ?></dt>
            <dd>
                    <?php
          $pageList = $this->advdbclass->getPages($menuTree['id']);
          if($pageList) {
          	  foreach ($pageList as $item) {
				if ($item['url']) {
					$url = $item['url'];
				} else {
					$url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "{$item['template']}/index/{$item['category_id']}/{$item['id']}.html", $client_index);
				}
       ?>
                <a href="<?php echo $url;?>"><?php echo $item['title']; ?></a>
      <?php }} ?>
            </dd>
        </dl>
 <?php }} ?>
        <dl class="service">
            <dt>
            <i class="icon"></i><p class="tel">400-800-4090</p>
            <p style="text-align:center;color:#666;">携众易购全国服务热线</p>
            </dt>
            <dd>
                <div class="wx"><img src="images/default/download.png"></div>下载携众易购APP
            </dd>
            <dd>
            </dd>
        </dl>
    </div>
<?php echo $this->load->view('element/copyright_tool', '', TRUE); ?>
</footer>
      <?php echo $this->load->view('element/right_sidebar_tool', '', TRUE); ?>
<script type="text/javascript">
        $(function () {
            $("img.lazy").lazyload({
                placeholder: "images/default/load.jpg", //加载图片前的占位图片
                effect: "fadeIn" //加载图片使用的效果(淡入)
            });
        });
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
