<div class="clear"></div>
<header class="header clearfix" style="border-bottom:#e61d47 2px solid;">
    <div class="warp">
        <a href="<?php echo base_url();?>" class="logo"><img src="images/default/logo.png"></a>
        <div class="cart_step fr">
            <ul class="clearfix">
                <li >我的购物车<em></em><i></i></li>
                <li >填写订单信息<em></em><i></i></li>
                <li >确认订单付款<em></em><i></i></li>
                <li class="current">订单提交成功<em></em><i></i></li>
            </ul>
        </div>
    </div>
</header>
<div class="clear"></div>
<div class="warp">

    <div  class="cart_border mt30">
        <span class="tit">支付成功</span>
        <div class="border_d clearfix">
            <div class="cart_success clearfix">
                <span class="icon" style="margin-left:416px;"></span><p class="fl">您已成功支付：￥<?php if ($item_info) { echo $item_info['total'];};?><?php if ($item_info) {if ($item_info['pay_mode'] > 0) {echo "+{$item_info['deductible_score']}积分";}} ?><br>您的订单号：<?php echo $item_info['order_number'];?>
                <br>
                <a href="<?php echo getBaseUrl(false,'',"product/index/80.html",$client_index);?>" class="btn mt10">继续购物</a>
                <a href="<?php echo getBaseUrl(false,'',"order.html",$client_index);?>" class="btn mt10" style="margin-left:40px;">查看订单</a>
                </p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="no_product mt20 clearfix">
        <div class="tit"><span>买了的人还买了</span></div>
        <div class="bd">
            <a href="javascript:void(0)" class="prev"></a>
            <a href="javascript:void(0)" class="next"><i class="icon"></i></a>
            <ul class="picList">
              <?php
                if ($hotProductList) {
                    foreach ($hotProductList as $key => $product) {
                        $url = getBaseUrl(false, "", "product/detail/{$product['id']}.html", $client_index);
                        $str_class = '';
                        if (($key + 1) % 6 == 0) {
                            $str_class = 'style="margin-right:0px;"';
                        }
                        ?>
                        <Li><div class="picture"><a href="<?php echo $url; ?>"><img class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $product['path']); ?>"></a></div>
                            <div class="property"><P class="nowrap"><a href="<?php echo $url; ?>"><?php echo my_substr($product['title'], 30); ?></a></P>
                                <p><span class="price"><small>￥</small><?php echo $product['sell_price']; ?><s>￥<?php echo $product['market_price']; ?></s></span></p>
                            </div>
                        </Li>
                    <?php }
                }
                ?>

            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>