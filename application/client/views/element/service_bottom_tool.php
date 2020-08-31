<div class="aysw-footer">
  <div class="aysw-inner">
    <div class="aysw-footer-section">
      <div class="aysw-footer-goldmetal-directions aysw-footer-section_new"> <span class="title-span">新手指南</span>
        <div class="aysw-left">
        <?php 
            $cus_list = $this->advdbclass->get_cus_list('page', 127, '', 0, 4);
            if ($cus_list) { 
            	foreach ($cus_list as $item) {
				$url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "page/index/{$item['category_id']}/{$item['id']}.html", $client_index);
			?>
          <h2 class="foot-h"><a href="<?php echo $url; ?>" title="<?php echo clearstring($item['title']); ?>"  ><?php echo my_substr($item['title'], 20); ?></a></h2>
          <?php }} ?>
        </div>
      </div>
      <div class="  aysw-footer-goldmetal-supports aysw-footer-section_new"> <span class="title-span">支付购买</span>
        <div class="aysw-left">   
          <?php 
            $cus_list = $this->advdbclass->get_cus_list('page', 98, '', 0, 4);
            if ($cus_list) { 
            	foreach ($cus_list as $item) {
				$url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "page/index/{$item['category_id']}/{$item['id']}.html", $client_index);
			?>
          <h2 class="foot-h"><a href="<?php echo $url; ?>" title="<?php echo clearstring($item['title']); ?>"  ><?php echo my_substr($item['title'], 20); ?></a></h2>
          <?php }} ?>
        </div>
      </div>
      <div class="aysw-footer-goldmetal" id="J_footer-goldmetal">
        <div class="aysw-footer-goldmetal-wrap"> <span class="aysw-footer-goldmetal-img"></span> </div>
      </div>
       <div class="aysw-footer-goldmetal-beian footer_shouhou">
        <div class="aysw-footer-H1">售后服务</div>
        <div class="aysw-left"> 
          <?php 
            $cus_list = $this->advdbclass->get_cus_list('page', 97, '', 0, 4);
            if ($cus_list) { 
            	foreach ($cus_list as $item) {
				$url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "page/index/{$item['category_id']}/{$item['id']}.html", $client_index);
			?>
          <h2 class="foot-h"><a href="<?php echo $url; ?>" title="<?php echo clearstring($item['title']); ?>"  ><?php echo my_substr($item['title'], 20); ?></a></h2>
          <?php }} ?>
        </div>
      </div>
       <div class="aysw-footer-goldmetal-others footer_service">
        <div class="aysw-footer-H1">服务支持</div>
        <div class="aysw-left"> <a rel='external nofollow'  id='chatqq1' href="">售前咨询</a> &nbsp;400-078-5268&nbsp;转1<br>
          <a rel='external nofollow'  id='chatqq2' href=""  >售后服务</a> &nbsp;400-078-5268&nbsp;转2<br>
          <a rel='external nofollow' id='chatqq3' href=""  >客服QQ</a> &nbsp;&nbsp;800007396<br>
          <span class="aysw-gray">工作日：9：00-17：30</span><br>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="footer-xian"></div>