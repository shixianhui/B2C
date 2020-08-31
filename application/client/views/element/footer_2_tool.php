<div class="w footer-copy1">
 <?php
    $footerMenuList = $this->advdbclass->getFooterMenu();
    if ($footerMenuList) {
	foreach ($footerMenuList as $key=>$footerMenu) {
		if ($footerMenu['menu_type'] == '3') {
    		$url = $footerMenu['url'];    		
    	} else {
    		$url = getBaseUrl($html, $footerMenu['html_path'], "{$footerMenu['template']}/index/{$footerMenu['id']}.html", $client_index);
        }
        $str_class = '';
        if ($key != 0) {
        	$str_class = '|';
        }
	?>
  <?php echo $str_class; ?>
  <a href="<?php echo $url; ?>"><?php echo $footerMenu['menu_name'] ?></a> 
  <?php } ?>
  <br />
  <?php } ?>
  <?php echo $site_copyright; ?><?php echo $icp_code; ?>
</div>