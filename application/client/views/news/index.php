<div class="maincat mp ">
  <div class="Location ">
    <ul>
      <li><?php if ($location){echo $location;} ?></li>
    </ul>
  </div>
  <div class="cate-l f mr11">
      <div class="cate-le bor br-m bgwhite" style="padding-bottom:0;">
      <div class="f"><img src="images/default/mune.png" width="150" height="150" style="background:none;"/></div>
      <dl class="cate-tab">     
        <dt><?php if ($parentMenuInfo){echo $parentMenuInfo['menu_name'];} ?></dt>
        <?php
        $itemMenuList = $this->advdbclass->getMenuClass($parentId);
	    if ($itemMenuList) {
	    foreach ($itemMenuList as $key=>$menu) {
	    	if ($menu['menu_type'] == '3') {
	    		$url = $menu['url'];    		
	    	} else {
	    		$url = getBaseUrl($html, "{$menu['html_path']}/index{$menu['id']}.html", "{$menu['template']}/index/{$menu['id']}.html", $client_index);
	    	}
	    	$str_class = '';
	    	if ($menu['id'] == $menuId) {
	    		$str_class = 'class="curr"';
	    	}
	    ?>
        <dd><a <?php echo $str_class; ?> href="<?php echo $url; ?>"><?php echo $menu['menu_name']; ?></a></dd>
        <?php }} ?>
      </dl>
    </div>
    <div class="cate-le ">
    <?php if ($itemList) { ?>
	<?php foreach ($itemList as $item) {
			$url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "{$template}/detail/{$item['id']}.html", $client_index);
	?>
      <div class=" pad bian bgwhite">
        <div class="f">
        	<a href="<?php echo $url; ?>" title="<?php echo clearstring($item['title']); ?>"  >
        		                <img src="images/default/article_img.jpg" width="300" height="160" alt="<?php echo clearstring($item['title']); ?>"/>
            </a>
        </div>
        <div class="cat-r">
          <dl>
            <dt><a href="<?php echo $url; ?>" class="font9 " title="<?php echo clearstring($item['title']); ?>"><?php echo my_substr($item['title'], 40); ?></a></dt>
            <dd class="font10">发布时间:&nbsp;<?php echo date('Y-m-d', $item['add_time']); ?></dd>
            <dd><a href="<?php echo $url; ?>" class="font11"><?php echo $item['abstract']; ?></a></dd>
            <dd>
              <div id="menu">
                <ul>
                  <li><a href="<?php echo $url; ?>">查看详情</a><a href="<?php echo $url; ?>">点击查看</a></li>
                </ul>
              </div>
            </dd>
          </dl>
        </div>
      </div>
<?php }} ?>
      <div class="blank5"></div>
	<div class="pager_title">
	<div style="text-align:center">
	 <div id="pager" class="pagebar" >
	 <?php if ($pagination){echo $pagination;} ?>     
	</div>
	</div>
	</div>
    </div>
  </div>
  <?php echo $this->load->view('element/news_right_tool', '', TRUE); ?>
</div>
<?php echo $this->load->view('element/service_bottom_tool', '', TRUE); ?>