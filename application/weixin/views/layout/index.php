<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <base href="<?php echo base_url(); ?>" />
        <meta name="title" content="<?php echo clearstring($title); ?>" />
        <meta name="keywords" content="<?php echo clearstring($keywords); ?>" />
        <meta name="description" content="<?php echo clearstring($description); ?>" />
        <link rel="shortcut icon" href="images/default/favicon.png">
        <link href="css/default/rest.css" type="text/css" rel="stylesheet">
        <link href="css/default/base.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" language="javascript" src="js/default/jquery.js"></script>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="js/html5.js"></script>
        <![endif]-->
        <script type="text/javascript" language="javascript" src="js/default/jquery.SuperSlide.js"></script>
        <script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
        <link rel="stylesheet" href="js/default/aui-artDialog/css/ui-dialog.css">
        <script src="js/default/aui-artDialog/dist/dialog-plus-min.js"></script>
        <script src="js/default/jquery.form.js"></script>
        <script src="js/default/formvalid.js" type="text/javascript"></script>
        <script src="js/default/index.js" type="text/javascript"></script>
        <script>
            var controller = '<?php echo $this->uri->segment(1); ?>';
            var method = '<?php echo $this->uri->segment(2); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>
        <style>
            .category .menu{
                background:rgba(244,239,242,.6);
            }
            .category .hover .class{
                background-color:rgba(255,255,242,.8)
            }
            .category .sub-class{
                background-color:rgba(255,255,242,.8);
            }
        </style>
    </head>
    <body>
    </body>
</html>





















