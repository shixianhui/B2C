<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<base href="<?php echo base_url(); ?>" />
<link rel="stylesheet" href="css/admin/system.css">
<title>顶部</title>
</head>
<body>
<!--head-->
<div id="header">
  <div class="logo">
  <a href="<?php echo base_url(); ?>" target="_blank"><img src="images/admin/logo.jpg" border="0" height="58" width="220"></a>
  </div>
  <p id="info_bar"> 
  用户名：<strong class="font_arial white"><?php echo $username; ?>    </strong>，角色：    <?php echo $group_name; ?>     | 
  <a href="admincp.php/admin/logout" class="white" target="_top">退出登录</a> |   <a href="<?php echo base_url(); ?>" class="white" target="_blank">网站首页</a>
  </p>
  <div id="menu">
    <ul>
      <li><a href="admincp.php/menu/main" target="main-frame" class="menu" alt="我的面板"><span>我的面板</span></a></li>
	  <li><a href="admincp.php/menu/menuList" target="main-frame" class="menu" ><span>栏目列表</span></a></li>
	  <li><a href="admincp.php/admin" target="main-frame" class="menu" ><span>管理员列表</span></a></li>
	  <li><a href="admincp.php/system/save" target="main-frame" class="menu" ><span>基本设置</span></a></li>
	  <li><a href="admincp.php/html" target="main-frame" class="menu" ><span>生成html页面</span></a></li>	
    </ul>
  </div>
</div>
</body>
</html>