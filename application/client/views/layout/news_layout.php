<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
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
<link href="css/default/category_wide.min.css" rel="stylesheet" type="text/css" />
<link href="css/default/commin.css" rel="stylesheet" type="text/css" />
<link href="css/default/article.css" rel="stylesheet" type="text/css" />
<script src="js/default/aui-artDialog/lib/jquery-1.10.2.js"></script>
<link rel="stylesheet" href="js/default/aui-artDialog/css/ui-dialog.css">
<script src="js/default/aui-artDialog/dist/dialog-plus-min.js"></script>
<script type="text/javascript" src="js/default/jquery-lazyload.js"></script>
</head>
<body class="root_body hui">
<?php echo $this->load->view('element/header_tool', '', TRUE); ?>
<?php echo $this->load->view('element/navigation_tool', '', TRUE); ?>
<?php echo $content; ?>
<?php echo $this->load->view('element/footer_tool', '', TRUE); ?>
<?php echo $this->load->view('element/qq_service_tool', '', TRUE); ?>
<script type="text/javascript" charset="utf-8">
  $(function() {
      $("img.lazy").lazyload({effect: "fadeIn"});
  });
</script>
<script src="js/default/category_wide_b.min.js"></script>
</body>
</html>