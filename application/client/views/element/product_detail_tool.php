<div class="product_recommend fl mt30">
    <div class="hd">
        <ul>
            <Li class="on">浏览记录</Li>
            <Li id="browseRecord">精品推荐</Li>
        </ul>
    </div>
    <div class="bd">
        <ul class="recommend_item">
           <?php
            if ($browseproductList) {
                foreach ($browseproductList as $ls) {
                    ?>
                    <Li>
                        <a href="<?php echo getBaseUrl(false, '', 'product/detail/' . $ls['product_id'] . '.html', $client_index); ?>"  >
                            <div class="picture">
                                <img class="lazy" data-original="<?php echo preg_replace("/\./", "_thumb.", $ls['path']); ?>">
                                <span class="mask">
        <?php echo my_substr($ls['title'],25); ?>
                                </span>
                            </div>
                            <span class="price" style="text-align:left;"><small>￥</small><?php echo $ls['sell_price']; ?><em style="font-size:12px;padding-left:10px;position: relative;top:-2px;">销量:<?php echo $ls['sales'];?></em></span>
                        </a>
                    </Li>
         <?php }
         } ?>

        </ul>
        <ul  class="recommend_item" style="display: none;"> 
            <?php
            $cus_list = $this->advdbclass->get_product_cus_list('', 'a', 20);
            if ($cus_list) {
                foreach ($cus_list as $ls) {
                    $url = getBaseUrl(false, "", "product/detail/{$ls['id']}.html", $client_index);
                    ?>
                    <Li>
                        <a href="<?php echo $url; ?>"  >
                            <div class="picture">
                                <img class="lazy" data-original="<?php echo preg_replace("/\./", "_thumb.", $ls['path']); ?>">
                                <span class="mask">
                                     <?php echo my_substr($ls['title'],24); ?>
                                </span>
                            </div>
                            <span class="price" style="text-align:left;"><small>￥</small><?php echo $ls['sell_price']; ?><em style="font-size:12px;padding-left:10px;position: relative;top:-2px;">销量:<?php echo $ls['sales'];?></em></span>
                        </a>
                    </Li>
                <?php }
            } ?>
        </ul>
    </div>
</div>
<div class="product_comment fr mt30">
    <div class="hd">
        <ul>
            <Li>商品详情</Li>
            <Li>商品评价</Li>
        </ul>
    </div>
    <div class="bd">
        <div class="product_introduce">
<?php if ($item_info) {
    echo html($item_info['content']);
} ?>
        </div>
        <div class="comment_detail" style="display:block">
            <div class="classly mt20">
                <a href="javascript:;" class="current">全部评价</a>
                <!--                    <a href="">好评(2)</a><a href="">中评(0)</a><a href="">差评(0)</a>-->
            </div>
            <div class="">
<?php
foreach ($comment_list as $comment) {
    ?>
                    <dl class="clearfix">
                        <dt><p class="start"></p>评论时间<p><?php echo date('Y-m-d H:i', $comment['add_time']); ?></p></dt>
                        <dd><?php echo $comment['content']; ?></dd>
                        <dd class="author"><p><?php echo $comment['nickname']; ?><font class="c9">(匿名)</font></p></dd>
                    </dl>
<?php } ?>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript" src="js/default/jquery.ZoomScrollPic.js"></script>
<script type="text/javascript">
//放大镜图片切换效果
    $("#scrollpic").ZoomScrollPic({
        jqBox: "#zoom_scroll",
        box_w: 84,
        Interval: 3000,
        bun: true,
        autoplay: false
    });
    $("#scrollpic li .pic").bind({
        click: function () {
            $("#scrollpic li .pic").removeClass("active");
            $(this).addClass("active");
            var smallimg = $(this).attr("smallimg");
            var bigimg = $(this).attr("bigimg");
            $("#MagicZoom img").eq(0).attr("src", smallimg);
            $("#MagicZoom img").eq(1).attr("src", bigimg);
            return false;
        }
    });
//$("#fav-btn").bind({
//	click:function(){
//		if($(this).find(".icon-collect").hasClass("active")){
//			$(this).find(".icon-collect").removeClass("active");
//			$(this).find("span").text("收藏");
//		}
//		else{
//			$(this).find(".icon-collect").addClass("active");
//			$(this).find("span").text("取消收藏");
//			}
//		return false;
//		}
//		});
//加入购物车
    function add_cart() {
        var color_id = $("#spec_color_id").val();
        var size_id = $("#spec_size_id").val();
        var buy_number = $("#buy-num").val();
        if (!color_id) {
            var d = dialog({
                fixed: true,
                title: '提示',
                content: "请选择颜色"
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);
            return false;
        }
        if (!size_id) {
            var d = dialog({
                fixed: true,
                title: '提示',
                content: "请选择尺码"
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);
            return false;
        }
        //加入购物车
        $.post(base_url + "index.php/cart/add",
                {"product_id": <?php if ($item_info) {
    echo $item_info['id'];
} ?>,
                    "color_id": color_id,
                    "size_id": size_id,
                    "buy_number": buy_number
                },
        function (res) {
            if (res.success) {
                var path = '<?php if ($item_info) {
    echo preg_replace('/\./', '_thumb.', $item_info['path']);
} ?>';
                var html = '<div class="cartpopDiv"><a class="pic"><img width="60" height="60" src="' + path + '"></a><p>添加成功！</p><p>商品已成功加入购物车</p><div class="clearfix"></div></div>';
                $(".cartInfo_number").html(res.data.cart_count);

                var d = dialog({
                    width: 350,
                    fixed: true,
                    title: '提示',
                    content: html,
                    okValue: '去结算',
                    ok: function () {
                        window.location.href = base_url + 'index.php/cart.html';
                    },
                    cancelValue: '继续购物',
                    cancel: function () {
                    }
                });
                d.show();
                return false;
            } else {
                if (res.field == 'go_login') {
                    var d = dialog({
                        width: 200,
                        fixed: true,
                        title: '提示',
                        content: res.message,
                        okValue: '登录',
                        ok: function () {
                            window.location.href = base_url + 'index.php/user/login.html';
                        },
                        cancelValue: '取消',
                        cancel: function () {
                        }
                    });
                    d.show();
                } else {
                    var d = dialog({
                        fixed: true,
                        title: '提示',
                        content: res.message
                    });
                    d.show();
                    setTimeout(function () {
                        d.close().remove();
                    }, 2000);
                }
                return false;
            }
        },
                "json"
                );
    }
    $("#browseRecord").click(function () {
        if (<?php echo get_cookie('user_id') ? 'false' : 'true'; ?>) {
            var d = dialog({
                            width: 200,
                            fixed: true,
                            title: '提示',
                            content: '您未登录，请登录',
                            okValue: '登录',
                            ok: function () {
                                window.location.href = base_url + 'index.php/user/login.html';
                            },
                            cancelValue: '取消',
                            cancel: function () {
                            }
                        });
                        d.show();
        }
    })
</script>
