<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <base href="<?php echo base_url(); ?>" />
        <meta name="title" content="<?php echo clearstring($title); ?>" />
        <meta name="keywords" content="<?php echo clearstring($keywords); ?>" />
        <meta name="description" content="<?php echo clearstring($description); ?>" />
         <link rel="shortcut icon" href="images/default/favicon.png">
        <link href="css/default/rest.css" type="text/css" rel="stylesheet">
        <link href="css/default/base.css?v=1.04" type="text/css" rel="stylesheet">
        <link href="css/default/member.css?v=1.04" type="text/css" rel="stylesheet">
        <link href="css/default/iconfont/iconfont.css" type="text/css" rel="stylesheet">
        <script src="js/default/jquery.js"></script>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="js/default/html5.js"></script>
        <![endif]-->
        <script type="text/javascript" language="javascript" src="js/default/jquery.SuperSlide.js"></script>
        <script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
        <link rel="stylesheet" href="js/default/aui-artDialog/css/ui-dialog.css">
        <script src="js/default/aui-artDialog/dist/dialog-plus-min.js"></script>
        <script src="js/default/jquery.form.js"></script>
        <script src="js/default/formvalid.js?v=2.01" type="text/javascript"></script>
        <script src="js/default/index.js?v=1.0" type="text/javascript"></script>
        <script>
            var controller = '<?php echo $this->uri->segment(1); ?>';
            var method = '<?php echo $this->uri->segment(2); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body>
        <?php echo $this->load->view('element/topbar_tool', '', TRUE); ?>
        <?php echo $content; ?>
        <?php echo $this->load->view('element/copyright_tool', '', TRUE); ?>
        <?php echo $this->load->view('element/right_sidebar_tool', '', TRUE); ?>
    </body>
</html>

