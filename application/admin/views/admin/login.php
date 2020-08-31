<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-CN"/>
<title>后台登录_无忧建站</title>
<base href="<?php echo base_url(); ?>" />
<style type="text/css">
<!--
*{margin:0; padding:0;}
body {font-family: Arial, Helvetica, sans-serif,"宋体"; font-size: 12px;line-height: 210%;font-weight: normal;color: #333333;text-decoration: none;background: #0cf url(images/admin/03.jpg) repeat-x 0 0 ;}
li{ list-style:none;}
input {	font-family:"宋体";	font-size:12px;	border:1px solid #dcdcdc;height:18px;line-height:18px; padding-left:2px;}
#main{ background:url(images/admin/01.jpg) no-repeat 300px 0; width:1059px; min-height:600px; height:600px; overflow:hidden; margin:0 auto; position:relative;}
#login_box{	width:278px; height:138px; background:url(images/admin/02.jpg) no-repeat 0 0;	position:absolute; top:228px; left:380px; padding-left:50px; padding-top:50px;line-height:138px;}
#login_box ul li{ line-height:32px; height:32px;}
.btn{ background:url(images/admin/05.gif) no-repeat 0 0; height:20px; width:58px; border:0; cursor:pointer; color:#fff; line-height:20px;}
-->
</style>
</head>
<body>
<div id="main">
  <div id="login_box">
    <ul>
    <form name="myform" method="post" action="admincp.php/admin/login" >
      <li>用户名：<input class="input_blur" name="username" id="username" type="text" size="20" /></li>
	  <li>密　码：<input class="input_blur" name="password" id="password" type="password" size="20" /></li>
      <li>验证码：<input class="input_blur" style="text-transform: uppercase;text-align:center;" maxlength="4" name="code" id="code" type="text" size="8"> <img width="70" src="admincp.php/verifycode/index/1" style="margin-bottom:-5px;cursor:pointer;" alt="看不清楚换一张?" onclick="javascript:this.src = this.src+1;"></li>
      <li>
	    <input style="margin-left:120px;" type="submit" name="dosubmit" id="dosubmit" value=" 登录 " class="btn">
      </li>
    </form>
    </ul>
  </div>
</div>
</body>
</html>