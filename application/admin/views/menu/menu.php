<html>
<head>
<base href="<?php echo base_url(); ?>" />
<link rel="stylesheet" href="css/admin/menu.css">
<script src="js/admin/jquery-1.4.2.min.js"></script>
  <script type="text/javascript">
  var cookieName = 'cwsaMenuCookie';

 /* if(top.location == self.location)
  {
          self.location.replace("index.php")
  }*/

  function setCookie(Cookie, value, expiredays)
  {
          var ExpireDate = new Date ();
          ExpireDate.setTime(ExpireDate.getTime() + (expiredays * 24 * 3600 * 1000));
          document.cookie = Cookie + "=" + escape(value) +
          ((expiredays == null) ? "" : "; expires=" + ExpireDate.toGMTString());
  }

  function getCookie(Cookie)
  {
          if (document.cookie.length > 0)
          {
                  begin = document.cookie.indexOf(Cookie+"=");
                  if (begin != -1)
                  {
                          begin += Cookie.length+1;
                          end = document.cookie.indexOf(";", begin);
                          if (end == -1) end = document.cookie.length;
                          return unescape(document.cookie.substring(begin, end));
                  }
          }
          return null;
  }

  function LoadMenu()
  {
          cookieMenu = getCookie(cookieName);
          if(cookieMenu != null)
          {
                  for(i = 0; i < divNames.length; i++)
                  {
                          if(cookieMenu.indexOf(divNames[i]) >= 0)
                          {
                                  document.getElementById('div_' + divNames[i]).style.display = 'block';
                                  document.getElementById('img_' + divNames[i]).src = 'images/admin/closed.gif';
                          }
                          else
                          {
                                  document.getElementById('div_' + divNames[i]).style.display = 'none';
                                  document.getElementById('img_' + divNames[i]).src = 'images/admin/open.gif';
                          }
                  }
          }
  }

  function SaveMenu()
  {
          var cookiestring = '';

          for(i = 0; i < divNames.length; i++)
          {
                  var block = document.getElementById('div_' + divNames[i]);

                  if(block.style.display != 'none')
                  {
                          cookiestring += divNames[i] + '|';
                  }
          }

          setCookie(cookieName,cookiestring,1);
  }

  function ToggleDiv(className)
  {
          var img = document.getElementById('img_' + className);
          var div = document.getElementById('div_' + className);

          if(div.style.display == 'none')
          {
                  img.src = 'images/admin/closed.gif';
                  div.style.display = 'block';
          }
          else
          {
                  img.src = 'images/admin/open.gif';
                  div.style.display = 'none';
          }
  }

  function nav_goto(targeturl)
  {
          parent.frames.mainFrame.location = targeturl;
  }

  function add_class(obj) {
	  $("#table_menu").find("a").removeClass("a_cur");
      $(obj).attr("class", "a_cur");
  }
  </script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<br/>
<?php $admingroupInfo = $this->advdbclass->getPermissionsStr(get_cookie('admin_group_id'));
if ($admingroupInfo) {
?>
<table id="table_menu" align="center" border="0" cellpadding="0" cellspacing="0" width="150">
<tbody><tr>
  <td align="center" valign="top">
  <!-- 频道管理开始 -->
  <?php if (isPermissions($admingroupInfo, 'menu_add') || isPermissions($admingroupInfo, 'menu_menuList') || isPermissions($admingroupInfo, 'news_index') || isPermissions($admingroupInfo, 'page_index') || isPermissions($admingroupInfo, 'link_index')) { ?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
     <tbody>
	  <tr>
       <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
		 <div class="menutitle" onClick="ToggleDiv('menu_manage');">
		  <img id="img_menu_manage" src="images/admin/closed.gif" align="absmiddle" border="0">&nbsp;&nbsp;网站管理
		 </div>
		 <div id="div_menu_manage">
		 <?php if (isPermissions($admingroupInfo, 'menu_add')) { ?>
		  <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		  <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/menu/save"  target="main-frame">添加栏目</a>
		  </div>
		 <?php } ?>
		 <?php if (isPermissions($admingroupInfo, 'menu_menuList')) { ?>
		  <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		  <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/menu/menuList"  target="main-frame">栏目列表</a>
		  </div>
		  <?php } ?>
		  <?php if (isPermissions($admingroupInfo, 'news_index')) { ?>
		  <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		  <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/news/index/1"  target="main-frame">新闻管理</a>
		  </div>
		  <?php } ?>
		  <?php if (isPermissions($admingroupInfo, 'page_index')) { ?>
		  <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		  <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/page/index/1"  target="main-frame">文章管理</a>
		  </div>
		  <?php } ?>
		  <?php if (isPermissions($admingroupInfo, 'link_index')) { ?>
          <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		  <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/link/index/1"  target="main-frame">友情链接</a>
		  </div>
		  <?php } ?>
		 </div>
		 </td>
        </tr>
      </tbody>
	</table>
    <div style="margin-bottom: 10px;"></div>
    <?php } ?>
    <!-- 频道管理结束 -->
    <!-- 商品管理开始 -->
    <?php if (isPermissions($admingroupInfo, 'product_venue_index') || isPermissions($admingroupInfo, 'product_category_index') || isPermissions($admingroupInfo, 'brand_index') || isPermissions($admingroupInfo, 'product_index')) { ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
		 <tr>
          <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
		   <div class="menutitle" onClick="ToggleDiv('product_manage');">
			<img id="img_product_manage" src="images/admin/closed.gif" align="absmiddle" border="0">&nbsp;&nbsp;商品管理
		   </div>
		   <div id="div_product_manage">
		   <?php if (isPermissions($admingroupInfo, 'product_venue')) { ?>
		    <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			<img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/product_venue/index/1" target="main-frame">场馆管理</a>
			</div>
		   <?php } ?>
		   <?php if (isPermissions($admingroupInfo, 'product_category_index')) { ?>
		    <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			<img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/product_category/index/1" target="main-frame">分类管理</a>
			</div>
		   <?php } ?>
		   <?php if (isPermissions($admingroupInfo, 'brand_index')) { ?>
			<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/brand/index/1" target="main-frame">品牌管理</a>
			</div>
			<?php } ?>
			<?php if (isPermissions($admingroupInfo, 'product_index')) { ?>
		    <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/product/index/1" target="main-frame">商品管理</a>
			</div>
			<?php } ?>
		   </div>
		 </td>
       </tr>
      </tbody>
	</table>
	<div style="margin-bottom: 10px;"></div>
	<?php } ?>
	 <!-- 商品管理结束 -->
	 <?php if (isPermissions($admingroupInfo, 'theme_index') || isPermissions($admingroupInfo, 'store_grade_index') || isPermissions($admingroupInfo, 'store_category_index') || isPermissions($admingroupInfo, 'store_index')) { ?>
	 <!-- 店铺管理开始 -->
	 <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
		 <tr>
          <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
		   <div class="menutitle" onClick="ToggleDiv('store_manage');">
			<img id="img_store_manage" src="images/admin/closed.gif" align="absmiddle" border="0">&nbsp;&nbsp;店铺管理
		   </div>
		   <div id="div_store_manage">
		   <?php if (isPermissions($admingroupInfo, 'theme_index')) { ?>
		    <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			<img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/theme" target="main-frame">店铺模板管理</a>
			</div>
		   <?php } ?>
		   <?php if (isPermissions($admingroupInfo, 'store_grade_index')) { ?>
		    <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			<img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/store_grade" target="main-frame">店铺等级</a>
			</div>
			<?php } ?>
			<?php if (isPermissions($admingroupInfo, 'store_category_index')) { ?>
			<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/store_category" target="main-frame">店铺分类</a>
			</div>
			<?php } ?>
			<?php if (isPermissions($admingroupInfo, 'store_index')) { ?>
		    <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/store/index/1" target="main-frame">店铺管理</a>
			</div>
			<?php } ?>
		   </div>
		 </td>
       </tr>
      </tbody>
	</table>
	<div style="margin-bottom: 10px;"></div>
	<?php } ?>
	<!-- 店铺管理结束 -->
	<?php if (isPermissions($admingroupInfo, 'orders_index') || isPermissions($admingroupInfo, 'exchange_index') || isPermissions($admingroupInfo, 'comment_index') || isPermissions($admingroupInfo, 'user_message_index')) { ?>
	   <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
		 <tr>
          <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
		   <div class="menutitle" onClick="ToggleDiv('orders_manage');">
			<img id="img_orders_manage" src="images/admin/closed.gif" align="absmiddle" border="0">&nbsp;&nbsp;交易管理
		   </div>
		   <div id="div_orders_manage" >
		    <?php if (isPermissions($admingroupInfo, 'orders_index')) { ?>
            <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/orders/index/1" target="main-frame">订单列表</a>
			</div>
			<?php } ?>
			<?php if (isPermissions($admingroupInfo, 'exchange_index')) { ?>
			<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/exchange" target="main-frame">退换货申请管理</a>
			</div>
			<?php } ?>
			<?php if (isPermissions($admingroupInfo, 'comment_index')) { ?>
			<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/comment" target="main-frame">商品评价列表</a>
			</div>
			<?php } ?>
			<?php if (isPermissions($admingroupInfo, 'user_message_index')) { ?>
            <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/user_message" target="main-frame">用户提醒发货</a>
			</div>
			<?php } ?>
		   </div>
		 </td>
       </tr>
      </tbody>
	</table>
    <div style="margin-bottom: 10px;"></div>
    <?php } ?>
    <?php if (isPermissions($admingroupInfo, 'admin_index') || isPermissions($admingroupInfo, 'admin_group_index')) { ?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
	   <tr>
        <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
		<div class="menutitle" onClick="ToggleDiv('admin_manage');">
		 <img id="img_admin_manage" src="images/admin/open.gif" align="absmiddle" border="0">&nbsp;&nbsp;员工管理
		</div>
		<div id="div_admin_manage" style="display: none;">
		<?php if (isPermissions($admingroupInfo, 'admin_index')) { ?>
		 <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		  <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/admin/index/1" target="main-frame">员工列表</a>
		 </div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'admin_group_index')) { ?>
		<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/admin_group/index/1" target="main-frame">部门列表</a>
		</div>
		<?php } ?>
		</div>
        </td>
       </tr>
      </tbody>
	</table>
	<div style="margin-bottom: 10px;"></div>
    <?php } ?>
    <?php if (isPermissions($admingroupInfo, 'user_index') ||
    		isPermissions($admingroupInfo, 'user_index_0') ||
    		isPermissions($admingroupInfo, 'user_index_1_all') || isPermissions($admingroupInfo, 'user_index_1_self') ||
    		isPermissions($admingroupInfo, 'user_index_2_all') || isPermissions($admingroupInfo, 'user_index_2_self') ||
    		isPermissions($admingroupInfo, 'user_index_21_all') || isPermissions($admingroupInfo, 'user_index_21_self') ||
    		isPermissions($admingroupInfo, 'user_index_22_all') || isPermissions($admingroupInfo, 'user_index_22_self') ||
    		isPermissions($admingroupInfo, 'user_index_31_all') || isPermissions($admingroupInfo, 'user_index_31_self') ||
    		isPermissions($admingroupInfo, 'usergroup_index') ||
    		isPermissions($admingroupInfo, 'elephant_log_index') ||
    		isPermissions($admingroupInfo, 'financial_index') ||
    		isPermissions($admingroupInfo, 'score_index') ||
    		isPermissions($admingroupInfo, 'pay_log_index') ||
    		isPermissions($admingroupInfo, 'withdraw_index') ||
    		isPermissions($admingroupInfo, 'jiameng_index')) { ?>
	 <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
	   <tr>
        <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
		<div class="menutitle" onClick="ToggleDiv('user_manage');">
		 <img id="img_user_manage" src="images/admin/open.gif" align="absmiddle" border="0">&nbsp;&nbsp;会员管理
		</div>
		<div id="div_user_manage" style="display: none;">
		<?php if (isPermissions($admingroupInfo, 'user_index')) { ?>
		 <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		  <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/user/index/1" target="main-frame">所有会员列表</a>
		 </div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'user_index_0')) { ?>
		 <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		  <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/user/index_0/1" target="main-frame">普通会员列表</a>
		 </div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'user_index_1')) { ?>
		 <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		  <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/user/index_1/1" target="main-frame">商家会员列表</a>
		 </div>
		 <?php } ?>
		 <?php if (isPermissions($admingroupInfo, 'usergroup_index')) { ?>
		<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/usergroup" target="main-frame">会员组列表</a>
		</div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'financial_index')) { ?>
		<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/financial/index/1" target="main-frame">会员财务记录</a>
		</div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'elephant_log_index')) { ?>
		<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/elephant_log/index/1" target="main-frame">金/银象币消费记录</a>
		</div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'score_index')) { ?>
		<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/score/index/1" target="main-frame">积分消费记录</a>
		</div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'pay_log_index')) { ?>
		<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
	    <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/pay_log/index/1" target="main-frame">第三方支付记录管理</a>
		</div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'withdraw_index')) { ?>
		<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
	    <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/withdraw/index/1" target="main-frame">金/银象币提现管理</a>
		</div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'jiameng_index')) { ?>
         <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/jiameng/index" target="main-frame">加盟申请列表</a>
		</div>
		<?php } ?>
            <?php if (isPermissions($admingroupInfo, 'guestbook_index')) { ?>
                <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
                    <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/guestbook"  target="main-frame">信息反馈管理</a>
                </div>
            <?php } ?>
		</div>
		</td>
       </tr>
       </tbody>
	  </table>
	  <div style="margin-bottom: 10px;"></div>
     <?php } ?>
	<?php if (isPermissions($admingroupInfo, 'user_index_10') || isPermissions($admingroupInfo, 'user_index_20') || isPermissions($admingroupInfo, 'user_index_30')) { ?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
	   <tr>
        <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
		<div class="menutitle" onClick="ToggleDiv('user_manage_2');">
		 <img id="img_user_manage_2" src="images/admin/closed.gif" align="absmiddle" border="0">&nbsp;&nbsp;二级分销商审核
		</div>
		<div id="div_user_manage_2">
		<?php if (isPermissions($admingroupInfo, 'user_index_10')) { ?>
		<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/user/index_10/1" target="main-frame">店级合伙人审核</a>
		</div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'user_index_20')) { ?>
		<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/user/index_20/1" target="main-frame">校园二级分销商审核</a>
		</div>
		<?php } ?>
		<?php if (isPermissions($admingroupInfo, 'user_index_30')) { ?>
		<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/user/index_30/1" target="main-frame">网络二级分销商审核</a>
		</div>
		<?php } ?>
		</div>
		</td>
       </tr>
       </tbody>
	  </table>
	<div style="margin-bottom: 10px;"></div>
	<?php } ?>
    <!-- 生成静态开始 -->
	<?php if (isPermissions($admingroupInfo, 'html_index')) { ?>
	 <table style="display: none;" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
	   <tr>
        <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
		<div class="menutitle" onClick="ToggleDiv('html_manage');">
		 <img id="img_html_manage" src="images/admin/open.gif" align="absmiddle" border="0">&nbsp;&nbsp;生成静态
		</div>
		<div id="div_html_manage" style="display: none;">
		 <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		  <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/html" target="main-frame">生成html页面</a>
		 </div>
		</div>
        </td>
       </tr>
       </tbody>
	  </table>
	<div style="margin-bottom: 10px;"></div>
	<?php } ?>
	<!-- 生成静态结束 -->
	<!-- 广告管理开始 -->
	<?php if (isPermissions($admingroupInfo, 'ad_index') || isPermissions($admingroupInfo, 'ad_group_index')) { ?>
	   <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
		 <tr>
          <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
		   <div class="menutitle" onClick="ToggleDiv('ad_manage');">
			<img id="img_ad_manage" src="images/admin/open.gif" align="absmiddle" border="0">&nbsp;&nbsp;广告管理
		   </div>
		   <div id="div_ad_manage" style="display: none;">
		   <?php if (isPermissions($admingroupInfo, 'ad_index')) { ?>
		    <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/ad/index/1" target="main-frame">广告内容管理</a>
			</div>
			<?php } ?>
			<?php if (isPermissions($admingroupInfo, 'ad_group_index')) { ?>
			<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			<img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/ad_group/index/1" target="main-frame">广告位管理</a>
			</div>
			<?php } ?>
		   </div>
		 </td>
       </tr>
      </tbody>
	</table>
	<div style="margin-bottom: 10px;"></div>
	<?php } ?>
	<!-- 广告管理结束 -->
	   <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
		 <tr>
          <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
           <div class="menutitle" onClick="ToggleDiv('active_manage');">
			<img id="img_active_manage" src="images/admin/open.gif" align="absmiddle" border="0">&nbsp;&nbsp;营销活动管理
		   </div>
		   <div id="div_active_manage" style="display: none;">
		    <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/promotion_ptkj/index/1" target="main-frame">拼团砍价活动列表</a>
			</div>
			<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/flash_sale/index/1" target="main-frame">限时抢购活动列表</a>
			</div>
		   </div>
           <div class="menutitle" onClick="ToggleDiv('robot_manage');">
			<img id="img_robot_manage" src="images/admin/open.gif" align="absmiddle" border="0">&nbsp;&nbsp;机器人管理
		   </div>
            <div id="div_robot_manage" style="display: none;">
		    <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/robot/import_robot" target="main-frame">机器人账号批量注册</a>
			</div>
			<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/robot/ptkj" target="main-frame">拼团砍价机器人设置</a>
			</div>
            <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/robot/xsqg" target="main-frame">限时抢购机器人设置</a>
			</div>
		   </div>
</td>
       </tr>
      </tbody>
	</table>
	  <div style="margin-bottom: 10px;"></div>
	  <!-- 系统管理开始 -->
	  <?php if (isPermissions($admingroupInfo, 'system_save') || isPermissions($admingroupInfo, 'watermark_save') || 
	  		isPermissions($admingroupInfo, 'backup_index') || isPermissions($admingroupInfo, 'file_index') || 
	  		isPermissions($admingroupInfo, 'system_configure_order') || isPermissions($admingroupInfo, 'system_update') ||
	  		isPermissions($admingroupInfo, 'systemloginlog_index')) { ?>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tbody>
	    <tr>
          <td style="padding: 2px 2px 0px;" bgcolor="#ffffff">
          <!-- 系统设置开始 -->
	      <?php if (isPermissions($admingroupInfo, 'system_save') || isPermissions($admingroupInfo, 'watermark_save')) { ?>
		  <div class="menutitle" onClick="ToggleDiv('system_settings');">
		  <img id="img_system_settings" src="images/admin/open.gif" align="absmiddle" border="0">&nbsp;&nbsp;系统管理</div>
          <div id="div_system_settings" style="display: none;">
		   <?php if (isPermissions($admingroupInfo, 'system_save')) { ?>
		   <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/save" target="main-frame">基本设置</a>
		   </div>
		   <?php } ?>
		   <?php if (isPermissions($admingroupInfo, 'system_configure_order')) { ?>
		   <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/configure_order" target="main-frame">订单基本设置</a>
		   </div>
		   <?php } ?>
		    <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			 <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/area" target="main-frame">配送地区管理</a>
			</div>
			<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			<img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/postage_way" target="main-frame">配送方式管理</a>
			</div>
            <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			<img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/payment_way" target="main-frame">支付方式管理</a>
			</div>
			<div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
			<img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/free_postage_setting/save" target="main-frame">包邮条件设置</a>
			</div>
           <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/floor" target="main-frame">首页楼层设置</a>
		   </div>
		   <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/keyword" target="main-frame">搜索关键词设置</a>
		   </div>
		   <div style="display:none;" class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/qq_service" target="main-frame">在线客服设置</a>
		   </div>
		   <div style="display:none;" class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/online_recharge" target="main-frame">在线充值设置</a>
		   </div>
		   <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/score_setting/save" target="main-frame">积分设置</a>
		   </div>
		   <div style="display:none;" class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/pay_mode" target="main-frame">支付方式设置</a>
		   </div>
		   <div style="display:none;" class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/discount" target="main-frame">限时抢购设置</a>
		   </div>
           <div style="display:none;" class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/free_postage" target="main-frame">免运费设置</a>
		   </div>
		   <div style="display: none;" class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/reg_agreement" target="main-frame">服务协议设置</a>
		   </div>
		   <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/presenter_text" target="main-frame">分销商推广页面设置</a>
		   </div>
		   <?php if (isPermissions($admingroupInfo, 'system_update')) { ?>
		   <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system/update" target="main-frame">App更新</a>
		   </div>
		   <?php } ?>
       <?php if (isPermissions($admingroupInfo, 'watermark_save')) { ?>
		   <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/watermark/save" target="main-frame">图片水印设置</a>
		   </div>
		   <?php } ?>
		   <?php if (isPermissions($admingroupInfo, 'backup_index')) { ?>
		   <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/backup" target="main-frame">数据库备份</a>
		   </div>
		   <?php } ?>
		   <?php if (isPermissions($admingroupInfo, 'file_index')) { ?>
		   <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		   <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/file" target="main-frame">文件管理</a>
		   </div>
		   <?php } ?>
		   <?php if (isPermissions($admingroupInfo, 'systemloginlog_index')) { ?>
		     <div class="menulink-normal" onmouseover="this.className='menulink-hover';" onmouseout="this.className='menulink-normal'">
		       <img src="images/admin/menu_1.gif" align="absmiddle" border="0">&nbsp;<a onclick="javascript:add_class(this);" href="admincp.php/system_login_log/index/1" target="main-frame">登录日志管理</a>
		     </div>
		     <?php } ?>
		   </div>
		   <?php } ?>
       </td>
       </tr>
     </tbody>
	</table>
	<div style="margin-bottom: 10px;"></div>
	<?php } ?>
	<br/>
	<br/>
  </td>
</tr>
</tbody>
</table>
<?php } ?>
</body>
</html>