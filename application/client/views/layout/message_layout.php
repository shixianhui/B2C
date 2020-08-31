<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo base_url(); ?>" />
<meta name="title" content="<?php echo clearstring($title); ?>" />
<meta name="keywords" content="<?php echo clearstring($keywords); ?>" />
<meta name="description" content="<?php echo clearstring($description); ?>" />
<title><?php echo $title; ?></title>
<script>
var controller = '<?php echo $this->uri->segment(1); ?>';
var method = '<?php echo $this->uri->segment(2); ?>';
var base_url = '<?php echo base_url(); ?>';
</script>
<link rel="shortcut icon" href="images/default/ico.ico?v=1.01">
<link href="css/default/commin.css" rel="stylesheet" type="text/css" />
</head>
<body >
<link href="css/default/pc_login.css" rel="stylesheet" type="text/css" />
<div class="Logo-r">
  <div class="Logo-info-r">
	<a href="<?php echo base_url(); ?>" class="logo"></a>
  </div>
</div>
<?php echo $content; ?>
</div>
<div class="loginfooter">
<?php echo $this->load->view('element/footer_2_tool', '', TRUE); ?>
</div>
</body>
</html>