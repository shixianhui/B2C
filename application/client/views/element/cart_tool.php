<div class="cart_box" id="cart">
            <a href="<?php echo getBaseUrl(false,'',"cart.html",$client_index);?>" class="tit"><i class="icon"></i>我的购物车<b class="sl cartInfo_number" ><?php if(get_cookie('user_id')){ $number = $this->advdbclass->getCartSum(get_cookie('user_id'));echo $number ? $number : 0;}else{ echo 0;}?></b></a>
            <div class="subnav">
                <h3 class="name">最新加入的商品</h3>
                <?php
                if (get_cookie('user_id')) {
                    $cart_list = $this->advdbclass->getCart(get_cookie('user_id'));
                    ?>
                    <?php if (count($cart_list) > 0) { 
                         $sumPrice = 0;
                        ?>
                        <div class="content">
                            <?php
                                foreach($cart_list as $cart){
                                    $url = getBaseUrl(false, "", "product/detail/{$cart['product_id']}.html", $client_index);
                            ?>
                                <dl><dt><img src="<?php echo preg_replace('/\./', '_thumb.', $cart['path']); ?>" width="48" height="48"></dt>
                                    <dd><a href="<?php echo $url;?>"  ><?php echo $cart['title']; ?></a>
                                        <P><font class="yellow">¥<?php echo $cart['sell_price'];?></font>&nbsp;×<?php echo $cart['buy_number'];?></P>
                                        <a href="javascript:;" class="del" onclick="deleteCart(<?php echo $cart['id'];?>);">删除</a>
                                    </dd>
                                </dl>
                             <?php $sumPrice += $cart['sell_price']*$cart['buy_number']; ?>
                                <?php }?>
                        </div>
                        <div class="tali">
                            <P>共<b class="yellow"><?php echo count($cart_list);?></b>种商品  总计金额：<b class="yellow fs16"><small>¥</small><?php echo $sumPrice;?></b></P>
                            <a href="<?php echo getBaseUrl(false,"","cart.html",$client_index);?>" class="fr btn">结算购物车中的商品</a>
                        </div>
                    <?php } else { ?>
                        <div class="content none">您的购物车中暂无商品，赶快选择心爱的商品吧！</div>
                    <?php } ?>
                <?php } ?>
            </div>
</div>
