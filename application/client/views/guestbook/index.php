<!--搜索input-->
<link href="css/default/global_cms_top.css" rel="stylesheet" type="text/css" />
<div id="index_header">
       <ul class="topnav">
       <li class="welcome">
       <?php $keywordInfo = $this->advdbclass->getKeyword();?>
	     <?php if (get_cookie('user_username')){ ?>
	     <span id="user_name"><?php echo get_cookie('user_username'); ?></span>，欢迎来到<?php echo html($keywordInfo['web_site']) ?>！
	     <span id="logout"><span class="color_blue"><a class="logout" href="index.php/user/logout.html">退出</a></span></span>
	     <?php } else { ?>
	     <span id="user_name">您好</span>，欢迎来到<?php echo html($keywordInfo['web_site']) ?>！
		 <span id="login"><a href="index.php/user/login.html">请登录</a> <span class="gray">|</span> <a href="index.php/user/register.html">免费注册</a></span>
	     <?php } ?>
		 </li>
	     <?php
		    $headerMenuList = $this->advdbclass->getHeadMenu();    
		    if ($headerMenuList) {
		    foreach ($headerMenuList as $key=>$menu) {
		    	if ($menu['menu_type'] == '3') {
		    		$url = $menu['url'];
		    	} else {
		    		$url = getBaseUrl($html, "{$menu['html_path']}", "{$menu['template']}/index/{$menu['id']}.html", $client_index);
		    	}
         ?>
	     <li class="rbor"><a href="<?php echo $url; ?>"><?php echo $menu['menu_name']; ?></a></li>
	     <?php }} ?>	     
		</ul>
	  <div class="clear"></div>
  <div class="dcenter">   	
   	<a class="fl" href="<?php echo base_url(); ?>" >
      <img src="images/default/logo.jpg">
    </a>
 <div class="dnav fr" id="global_menu">
  <?php $menuList = $this->advdbclass->getNavigationMenu();
        $count = 0;
        if ($menuList) {
		    foreach ($menuList as $menu) {
		        if ($menu['id'] == $parentId) {
		    		$count++;
		    	}
		    }		    
        }
        $indexClass = 'select';
        if ($count) {
        	$indexClass = '';
        }
 ?>
	     <span class="<?php echo $indexClass; ?>"><a href="<?php if ($html){echo '/index.html';} else {echo '/'.$client_index;} ?>"><?php echo $index_name; ?> </a></span>
	     <?php
		    if ($menuList) {
		    foreach ($menuList as $key=>$menu) {
		    	if ($menu['menu_type'] == '3') {
		    		$url = $menu['url'];
		    	} else {
		    		$url = getBaseUrl($html, "{$menu['html_path']}", "{$menu['template']}/index/{$menu['id']}.html", $client_index);
		    	}
		    	$strClass = '';
		    	if ($menu['id'] == $parentId) {
		    		$strClass = 'select';
		    	}
		?>
	     <span class="<?php echo $strClass; ?>"><a href="<?php echo $url; ?>"><?php echo $menu['menu_name']; ?> </a></span>
		<?php }} ?>
      </div>
  <span class="clear"></span>
  </div>
        <div class="bottom">
           <div class="category fl color_white_none" id="allCategoryHeader">
           <h2><a href="javascript:void(0);" onmouseover="javascript:showClass();" onmouseout="javascript:hiddenClass();"  >所有商品分类</a></h2>
           <div id="allCategoryHeadert" class="allsort_out_box" style="display:none;" onmouseover="javascript:showClass();" onmouseout="javascript:hiddenClass();">
		    <div class="allsort_out">
		      <ul class="allsort">
		        <?php $itemMenuList = $this->advdbclass->getLeftProductClass(); ?>
				<?php if ($itemMenuList) {
					foreach ($itemMenuList as $key=>$itemMenu) {
					$url = getBaseUrl($html, "{$itemMenu['html_path']}", "{$itemMenu['template']}/index/{$itemMenu['id']}.html", $client_index);
				?>
			     <li>             
		          <h3><a   href="<?php echo $url; ?>" title="<?php echo clearstring($itemMenu['menu_name']); ?>"><?php echo $itemMenu['menu_name']; ?></a></h3>
			      <div style="min-height: 480px; height: 481px;" class="show_sort"></div>
			     </li>
			    <?php }} ?>
		       </ul>
		    </div>
			</div>
			<script type="text/javascript">
			function showClass() {
			    $('#allCategoryHeadert').show();
			}
			function hiddenClass() {
				$('#allCategoryHeadert').hide();
			}
			</script>
           </div>
           <?php echo $this->load->view('element/page_search_tool', '', TRUE); ?>
       </div>
</div>
<div id="container">
   <div class="banner980x60 mt5">
	<u>
	<?php
		$adList = $this->advdbclass->getOthorAd(6);
		if ($adList) {
		foreach ($adList as $ad) {
    ?>
		<li style="margin-top:5px;">
		<a title="<?php echo $ad['ad_text']; ?>" href="<?php echo $ad['url']; ?>"  ><img title="<?php echo $ad['ad_text']; ?>" src="<?php echo $ad['path']; ?>"></a>
		</li>
    <?php }} ?>
	  </u>
	</div>
    <div class="clearfix mt10">
    <div class="left_menu">
    <ul class="column" id="help_list">
    <?php $parentMenuInfo = $this->advdbclass->getMenuInfo($parentId); ?>
        <li><h2><?php echo $parentMenuInfo['menu_name']; ?></h2>
            <ul>
          <?php $menuTreeList = $this->advdbclass->getMenuClass($parentId);?>
          <?php if ($menuTreeList) { ?>
	      <?php foreach ($menuTreeList as $menuTree) { ?>
                <li><h3><?php echo $menuTree['menu_name']; ?></h3>
                <?php 
                $pageList = $this->advdbclass->getPages($menuTree['id']);
                if($pageList) { ?>
                    <ul>
                    <?php foreach ($pageList as $page) {
							if ($page['url']) {
								$url = $page['url'];
							} else {
								$url = getBaseUrl($html, "{$menuInfo['html_path']}/{$page['id']}.html", "page/index/{$menuInfo['id']}/{$page['id']}.html", $client_index);
							}
                    	?>
                        <li><a href="<?php echo $url; ?>"><?php echo $page['title']; ?></a></li>
                    <?php } ?>
                    </ul>
                   <?php } ?>
                </li>
           <?php }} else {
           	//一级
           	$pageList = $this->advdbclass->getPages($parentId);
           	if ($pageList) {
				foreach ($pageList as $page) {
				if ($page['url']) {
					$url = $page['url'];
				} else {
					$url = getBaseUrl($html, "{$menuInfo['html_path']}/{$page['id']}.html", "page/index/{$menuInfo['id']}/{$page['id']}.html", $client_index);
				}
			   ?>
           <li onclick="javascript:window.location.href='<?php echo $url; ?>';" ><h3><?php echo $page['title']; ?></h3></li>
           <?php }}} ?>
            </ul>
        </li>
    </ul>
   <?php echo $this->load->view('element/service_left_tool', '', TRUE); ?>
</div>  
        <div class="right_content">
        	<div class="crumb">
        	<?php if ($location){echo $location;} ?>
        	</div>
            <div class="help_box">
            	<h3><?php if($gMenuInfo){ echo $gMenuInfo['menu_name'];} ?></h3>
                <div class="help_detail">
 <style type="text/css">
.td {font-size: 14px;}
.input{
	border: 1px solid #CFCFCF;
    height: 22px;
    line-height: 20px;
    margin-right: 5px;
    padding-left: 8px;
    vertical-align: middle;
}
</style>
<script src="js/default/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/default/jquery.form.js"></script>
<script src="js/default/formvalid.js" type="text/javascript"></script>
<script src="js/default/guestbook.js" type="text/javascript"></script>
 <form method="post" action="index.php/guestbook/add" name="jsonForm" id="jsonForm">
 <table width="600" border="0">
  <tr>
    <td height="30" width="100" align="right" class="td">联系人：</td>
    <td>&nbsp;<input type="text" name="contact_name" id="contact_name" size="40" class="input"  maxlength="20" valid="required" errmsg="联系人不能为空!" /></td>
  </tr>
  <tr>
    <td height="30" align="right" class="td">电话：</td>
    <td>&nbsp;<input type="text" name="phone" id="phone" size="40" class="input" maxlength="15" valid="isPhone" errmsg="电话格式不正确，如:0571-88888888" /></td>
  </tr>
  <tr>
    <td height="30" align="right" class="td">手机：</td>
    <td>&nbsp;<input type="text" name="mobile" id="mobile" size="40" class="input" maxlength="15" valid="isMobile" errmsg="手机格式不正确，如:13878457845" /></td>
  </tr>
  <tr>
    <td height="30" align="right" class="td">QQ号：</td>
    <td>&nbsp;<input type="text" name="qq" id="qq" size="40" class="input" maxlength="15" valid="isQQ" errmsg="QQ号格式不正确！" /></td>
  </tr>
  <tr>
    <td height="30" align="right" class="td">邮箱：</td>
    <td>&nbsp;<input type="text" name="email" id="email" size="40" class="input" maxlength="100" valid="isEmail" errmsg="邮箱格式不正确，如“8888@126.com”！" /></td>
  </tr>
  <tr>
    <td align="right" class="td">留言内容：</td>
    <td>&nbsp;<textarea name="content" id="content" cols="40" rows="5"  maxlength="400" valid="required" errmsg="留言内容不能为空!"></textarea></td>
  </tr>
   <tr>
    <td height="50" >&nbsp;</td>
    <td>&nbsp;<input type="image" src="images/default/submit_btn.png" name="Submit" value="提交"/></td>
  </tr>  
</table>
</form>
            	</div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->load->view('element/footer_tool', '', TRUE); ?>
<script type="text/javascript">
/*左侧菜单*/
jQuery(function(){
	jQuery("#help_list").find("h3").next("ul").hide();
	jQuery("#help_list").find("h3").eq(0).addClass("on")
	jQuery("#help_list").find("h3").eq(0).next("ul").show();
	jQuery("#help_list").find("h3").click(function(){
		var sub_list2 = jQuery(this).next("ul");
		if(sub_list2.is( ":visible")){
			sub_list2.slideUp();
			jQuery(this).removeClass("on");
		}else{
			jQuery("#help_list").find("h3").removeClass("on");
			jQuery("#help_list").find("h3").next().slideUp();
			sub_list2.slideDown();
			jQuery(this).addClass("on");
		}
	})
})
</script>