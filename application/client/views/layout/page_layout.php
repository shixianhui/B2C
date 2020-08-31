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
        <!--[if lt IE 9]>
        <script type="text/javascript" src="js/default/html5.js"></script>
        <![endif]-->
        <script type="text/javascript" language="javascript" src="js/default/jquery.SuperSlide.js"></script>
        <script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
        <script>
            var controller = '<?php echo $this->uri->segment(1); ?>';
            var method = '<?php echo $this->uri->segment(2); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body style="background:#f5f5f5">
             <?php echo $this->load->view('element/header_tool', '', TRUE); ?>
        <div class="warp">
            <div class="help_left box_shadow mt20 clearfix">
                <div class="helpmenu" >
                    <div class="tit">帮助中心</div>
                    <?php $menuTreeList = $this->advdbclass->getMenuClass($parentId); ?>
                                <?php if ($menuTreeList) { ?>
                                    <?php foreach ($menuTreeList as $menuTree) { ?>
                    <h3 <?php echo $this->uri->segment(3)==$menuTree['id'] ? 'class="on"' : '';?>><em></em><?php echo $menuTree['menu_name']; ?></h3>
                    <ul>
                            <?php
                                                    $pageList = $this->advdbclass->getPages($menuTree['id']);
                                                    if ($pageList) {
                                                        foreach ($pageList as $item) {
                                                            if ($item['url']) {
                                                                $url = $item['url'];
                                                            } else {
                                                                $url = getBaseUrl($html, "{$item['html_path']}/{$item['id']}.html", "{$item['template']}/index/{$item['category_id']}/{$item['id']}.html", $client_index);
                                                            }
                                                            $str_class = '';
                                                            if ($itemInfo) {
                                                                if ($itemInfo['id'] == $item['id']) {
                                                                    $str_class = 'class="current"';
                                                                }
                                                            }
                                                            ?>
                        <li><a href="<?php echo $url; ?>" <?php echo $str_class;?>><?php echo $item['title']; ?></a></li>
                         <?php }
                                            } ?>
                    </ul>
    <?php }
} ?>

                </div>
<!--                <div class="helpnotice">
                    <div class="tit">最新公告</div>
                    <ul>
                        <Li class="nowrap"><a href="index.php/news/detail/1.html" >关于G20峰会期间杭州地区...</a></Li>
                        <Li class="nowrap"> <a href="">黄金会员电话预约服务上线黄金会员电话预约服务上线</a></Li>
                        <Li class="nowrap"><a href="">关于G20峰会期间杭州地区...</a></Li>
                    </ul>
                </div>-->
            </div>
        <?php echo $content;?>
        </div>
   <?php echo $this->load->view('element/copyright_tool', '', TRUE); ?>
    </body>
</html>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });

</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
