<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<base href="<?php echo base_url(); ?>" />
<title></title>
<style type="text/css">
body {
	margin: 0;
	padding: 0;
	background: #80BDCB;
	cursor: E-resize;
	background-color: #cadff3;
}
html,body{
    margin:0px;
    height:100%;
}
</style>
<script type="text/javascript" language="JavaScript">
<!--
function toggleMenu()
{
  frmBody = parent.document.getElementById('frame-body');
  imgArrow = document.getElementById('img');

  if (frmBody.cols == "0, 10, *")
  {
    frmBody.cols="185, 10, *";
    imgArrow.src = "images/admin/arrow_left.gif";
  }
  else
  {
    frmBody.cols="0, 10, *";
    imgArrow.src = "images/admin/arrow_right.gif";
  }
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body onselect="return false;">
<table height="100%" cellspacing="0" cellpadding="0" id="tbl">
  <tr><td><a href="javascript:toggleMenu();"><img align="absmiddle" src="images/admin/arrow_left.gif" id="img" border="0" /></a></td></tr>
</table>
</body>
</html>