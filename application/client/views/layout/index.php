<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="sogou_site_verification" content="pAfnFbl8yI"/>
        <title><?php echo $title; ?></title>
        <base href="<?php echo base_url(); ?>" />
        <meta name="title" content="<?php echo clearstring($title); ?>" />
        <meta name="keywords" content="<?php echo clearstring($keywords); ?>" />
        <meta name="description" content="<?php echo clearstring($description); ?>" />
        <link rel="shortcut icon" href="images/default/ico.ico?v=1.01">
        <link href="css/default/rest.css" type="text/css" rel="stylesheet">
        <link href="css/default/base.css?v=1.04" type="text/css" rel="stylesheet">
        <link href="css/default/iconfont/iconfont.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" language="javascript" src="js/default/jquery.js"></script>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="js/default/html5.js"></script>
        <![endif]-->
        <script type="text/javascript" language="javascript" src="js/default/jquery.SuperSlide.js"></script>
        <script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
        <link rel="stylesheet" href="js/default/aui-artDialog/css/ui-dialog.css">
        <script src="js/default/aui-artDialog/dist/dialog-plus-min.js"></script>
        <script src="js/default/jquery.form.js"></script>
        <script src="js/default/formvalid.js?v=2.01" type="text/javascript"></script>
        <script src="js/default/index.js?v=2.0" type="text/javascript"></script>
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
        <?php echo $this->load->view('element/header_tool', '', TRUE); ?>
        <?php echo $content; ?>
        <?php echo $this->load->view('element/footer_tool', '', TRUE); ?>
        <ul class="side_l_pop" >
            <li><span><i class="pop_1"></i>活动</span></li>
            <?php if ($floor_list) { ?>
            <?php foreach($floor_list as $key=>$value) { ?>
            <li><span><i class="pop_<?php echo $key+2; ?>"></i><?php echo $value['title']; ?></span></li>
            <?php }} ?>
            <!-- <li class=""><span>推荐</span></li>-->
            <li class="go_top"><a href="javascript:viod(0)">TOP</a></li>
        </ul>
        <div class="go_top" style="display: none;">
            <a href="javascript:void(0);">回顶部</a>
        </div>
    </body>
</html>





















