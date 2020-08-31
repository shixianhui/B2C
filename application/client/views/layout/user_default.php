<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <base href="<?php echo base_url(); ?>" />
        <meta name="title" content="<?php echo clearstring($title); ?>" />
        <meta name="keywords" content="<?php echo clearstring($keywords); ?>" />
        <meta name="description" content="<?php echo clearstring($description); ?>" />
        <link rel="shortcut icon" href="images/default/ico.ico?v=1.01">
        <link href="css/default/rest.css" type="text/css" rel="stylesheet">
        <link href="css/default/base.css?v=1.04" type="text/css" rel="stylesheet">
        <link href="css/default/member.css?v=1.04" type="text/css" rel="stylesheet">
        <script src="js/default/aui-artDialog/lib/jquery-1.10.2.js"></script>
        <link rel="stylesheet" href="js/default/aui-artDialog/css/ui-dialog.css">
        <script src="js/default/aui-artDialog/dist/dialog-plus-min.js"></script>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="js/default/html5.js"></script>
        <![endif]-->
        <script type="text/javascript" language="javascript" src="js/default/jquery.SuperSlide.js"></script>
        <script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
        <script src="js/default/jquery.form.js"></script>
        <script src="js/default/formvalid.js?v=2.01" type="text/javascript"></script>
        <script src="js/default/index.js" type="text/javascript"></script>
        <script>
           var controller = '<?php echo $this->uri->segment(1); ?>';
           var method = '<?php echo $this->uri->segment(2); ?>';
           var base_url = '<?php echo base_url(); ?>';
       </script>
    </head>
    <body>
         <?php echo $this->load->view('element/topbar_tool', '', TRUE); ?>
        <div class="member_head">
            <div class="warp">
                <a href="<?php echo base_url();?>" class="logo"><img src="images/default/m_logo.png"></a>
                <ul>
                    <Li><a href="<?php echo getBaseUrl(false,"","user.html",$client_index);?>" <?php if(!($this->uri->segment(2)=='get_financial_list' || $this->uri->segment(2)=='get_score_list' || $this->uri->segment(2)=='get_message_list')){ echo 'class="current"';}?>>用户中心</a></Li>
                    <Li><a href="<?php echo getBaseUrl(false,"","user/get_financial_list.html",$client_index);?>" <?php echo $this->uri->segment(2)=='get_financial_list' || $this->uri->segment(2)=='get_score_list' ? 'class="current"' : '';?>>我的资产</a></Li>
                    <Li><a href="<?php echo getBaseUrl(false,"","user/get_message_list.html",$client_index);?>" <?php echo $this->uri->segment(2)=='get_message_list' ? 'class="current"' : '';?>>消息</a></Li>
                </ul>
                <?php echo $this->load->view('element/cart_tool', '', TRUE); ?>
            </div>
        </div>
         <div class="clear"></div>
             <?php echo $content; ?>
             <div class="clear"></div>
		    <div class="copyright">
		        <P><?php echo $site_copyright; ?><?php echo $icp_code; ?></P>
		    </div>
    </body>
</html>








































