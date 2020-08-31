<div class="clear"></div>
<header class="header clearfix" style="border-bottom:#e61d47 2px solid;">
    <div class="warp">
        <a href="<?php echo base_url(); ?>" class="logo"><img src="images/default/logo.png"></a>
        <div class="cart_step fr">
            <ul class="clearfix">
                <li class="current">我的购物车<em></em><i></i></li>
                <li>填写订单信息<em></em><i></i></li>
                <li>确认订单付款<em></em><i></i></li>
                <li>订单提交成功<em></em><i></i></li>
            </ul>
        </div>
    </div>
</header>
<div class="warp">
     <form method="post" action="index.php/cart/confirm.html" name="go_to_submit" id="go_to_submit">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart_table mt20">
        <thead>
            <tr>
                <td width="55"><input onclick="javascript:select_all(this);" type="checkbox" class="choose_all" value=""></td>
                <td width="89" class="tal"><span style="margin-left:-10px;">全选</span></td>
                <td width="464" class="tal">商品信息</td>
                <td width="166">单价（元）</td>
                <td width="166">数量</td>
                <td width="166">金额（元）</td>
                <td width="100">送积分</td>
                <td width="92">操作</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $sumPrice = 0;
            $gold_give_score = 0;
            $silver_give_score = 0;
            ?>
            <?php if ($cartList) { ?>
                <?php
                foreach ($cartList as $cart) {
                    $url = getBaseUrl(false, "", "product/detail/{$cart['product_id']}.html", $client_index);
                    ?>
                    <tr>
                        <td><input name="cart_ids[]" onclick="javascript:select_item(this);" type="checkbox" class="choose" value="<?php echo $cart['id'];?>"></td>
                        <td class="tal" style="text-align: center;"><a href="<?php echo $url; ?>" class="picture" style="display:inline-block;" target="_bank"><img src="<?php echo preg_replace('/\./', '_thumb.', $cart['path']); ?>"></a></td>
                        <td class="tal lh18"><a href="<?php echo $url; ?>" target="_bank"><?php echo $cart['title']; ?></a><p><?php if ($cart['brand_name']) { ?>品牌：<?php echo $cart['brand_name']; ?><?php } ?>&nbsp;&nbsp;&nbsp;<?php if ($cart['color_size_open']) { ?><?php echo $cart['product_size_name']; ?>：<?php echo $cart['size_name']; ?>　<?php echo $cart['product_color_name']; ?>：<?php echo $cart['color_name']; ?><?php } ?></p></td>
                        <td>
                        <s class="tdl"><?php echo $cart['market_price']; ?></s>
                        <br>
                        <b class="unit purple"><?php echo $cart['sell_price']; ?></b>
                        </td>
                <td>
                    <div class="amount">
                        <a href="javascript:void(0);" class="Increase" onclick="javascript:increase(this, '<?php echo $cart['id']; ?>', '<?php echo $cart['sell_price']; ?>');">+</a>
                        <input type="text" value="<?php echo $cart['buy_number']; ?>" class="unum" onchange="javascript:change_num(this, '<?php echo $cart['id']; ?>', '<?php echo $cart['sell_price']; ?>');">
                        <a href="javascript:void(0);" class="Reduce" onclick="javascript:reduce(this, '<?php echo $cart['id']; ?>', '<?php echo $cart['sell_price']; ?>');">-</a>
                    </div>
                </td>
                <td><b class="u-price purple f14"><?php echo number_format($cart['sell_price'] * $cart['buy_number'], 2); ?></b></td>
                <td data-give_score="<?php echo $cart['buy_number']*$cart['give_score']; ?>" class="give_score" <?php if ($cart['product_type'] == 'a') {echo 'style="color: #c6c4c7;" title="返银象积分"';}else{echo 'style="color: #ecc319;" title="返金象积分"';} ?>><?php echo $cart['buy_number'] . 'x' . $cart['give_score']; ?></td>
                <td>
                    <a href="javascript:void(0);" onclick="javascript:move_to_favorite(this, '<?php echo $cart['id']; ?>');">移入收藏夹</a><br><br>
                    <a href="javascript:void(0);" class="btn-del" onclick="javascript:delete_item(this, '<?php echo $cart['id']; ?>');" title="删除">×</a>
                </td>
                </tr>
                <?php
                $sumPrice += $cart['sell_price'] * $cart['buy_number'];
                //银象积分
                if ($cart['product_type'] == 'a') {
                	$silver_give_score += $cart['give_score'] * $cart['buy_number'];
                }
                //金象积分
                else {
                	$gold_give_score += $cart['give_score'] * $cart['buy_number'];
                }
                ?>
            <?php }
        } else {
            ?>
            <tr>
                <td colspan="6" style='color:#f60; font-size:14px;'>&nbsp;您的购物车没有宝贝，快去选购宝贝哦！</td>
            </tr>
<?php } ?>
        </tbody>
        <tfoot class="count mt20">
            <tr>
                <td colspan="6" width="1200">
                    <div class="fl"><label><input onclick="javascript:select_all(this);" type="checkbox" class="choose_all" value=""> 全选</label><a href="javascript:void(0);" onclick="javascript:batch_delete_item();" class="ml20">删除选中商品</a></div>
                    <div class="fr">可获得金象积分<b class="purple" id="gold_score_total"> <?php echo $gold_give_score; ?> </b>个&nbsp;&nbsp;&nbsp;&nbsp;银象积分<b class="purple" id="silver_score_total"> <?php echo $silver_give_score; ?> </b>个<span class="ml10">合计（不含运费）：￥<b class="t-price purple f14" id="totalPrice"><?php echo number_format($sumPrice, 2, '.', ''); ?></b></span><input onclick="javascript:go_buy();" href="javascript:void(0);" type="submit" class="btn_pay" value="结算" style="border:none;"></div>
                </td>
            </tr>
        </tfoot>
    </table>
    </form>
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
                        <Li><div class="picture"><a   href="<?php echo $url; ?>"><img class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $product['path']); ?>"></a></div>
                            <div class="property"><P class="nowrap"><a   href="<?php echo $url; ?>"><?php echo my_substr($product['title'], 30); ?></a></P>
                                <p><span class="price"><small>￥</small><?php echo $product['sell_price']; ?><s>￥<?php echo $product['market_price']; ?></s></span></p>
                            </div>
                        </Li>
                    <?php }
                }
                ?>
            </ul>
            <div class="clear"></div>
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
<script language="javascript" type="text/javascript">
	//减
	function reduce(obj, cart_id, price) {
	    var buy_num = $(obj).parent().find('input[type=text]').val();
	    if (buy_num <= 1) {
		    return my_alert('fail', 0, '数量不能再减了');
	    } else {
	        var ids = '';
	        $('.cart_table.mt20').find("input[type=checkbox].choose:checked").each(function (i, n) {
		        ids += $(this).val() + ',';
		    });
	        $(obj).parent().find('input[type=text]').val(parseInt(parseInt(buy_num) - 1));
	        $.post(base_url + "index.php/" + controller + "/change_buy_number",
	            {
	                "buy_number": parseInt(parseInt(buy_num) - 1),
	                "cart_id": cart_id,
	                "ids": ids.substr(0, ids.length - 1)
	            },
	            function (res) {
	                if (res.success) {
	                	$(obj).parent().find('input[type=text]').val(parseInt(parseInt(buy_num) - 1));
		                $('#gold_score_total').html(res.data.gold_score_total);
		                $('#silver_score_total').html(res.data.silver_score_total);
		                $('#totalPrice').html(res.data.total);
	                } else {
	                	return my_alert('fail', 0, res.message);
	                }
	            },
	            "json"
	        );
	    }
	}

	//加
	function increase(obj, cart_id, price) {
	    var buy_num = $(obj).parent().find('input[type=text]').val();
	    var ids = '';
	    $('.cart_table.mt20').find("input[type=checkbox].choose:checked").each(function (i, n) {
	        ids += $(this).val() + ',';
	    });
	    $.post(base_url + "index.php/" + controller + "/change_buy_number",
	        {
	            "buy_number": parseInt(parseInt(buy_num) + 1),
	            "cart_id": cart_id,
	            "ids": ids.substr(0, ids.length - 1)
	        },
	        function (res) {
	            if (res.success) {
	            	$(obj).parent().find('input[type=text]').val(parseInt(parseInt(buy_num) + 1));
	                $('#gold_score_total').html(res.data.gold_score_total);
	                $('#silver_score_total').html(res.data.silver_score_total);
	                $('#totalPrice').html(res.data.total);
	            } else {
		            return my_alert('fail', 0, res.message);
	            }
	        },
	        "json"
	    );
	}

	//直接修改数量
    function change_num(obj, cart_id, price) {
        var buy_num = $(obj).val();
        if (buy_num < 1) {
        	return my_alert('fail', 0, '数量不能小于1');
        }
        var ids = '';
	    $('.cart_table.mt20').find("input[type=checkbox].choose:checked").each(function (i, n) {
	        ids += $(this).val() + ',';
	    });
        $.post(base_url + "index.php/" + controller + "/change_buy_number",
            {
                "buy_number": buy_num,
                "cart_id": cart_id,
                "ids": ids.substr(0, ids.length - 1)
            },
            function (res) {
                if (res.success) {
                	$('#gold_score_total').html(res.data.gold_score_total);
	                $('#silver_score_total').html(res.data.silver_score_total);
	                $('#totalPrice').html(res.data.total);
                } else {
                	return my_alert('fail', 0, res.message);
                }
            },
            "json"
        );
    }

    //所有
    function select_all(obj) {
        if ($(obj).attr("checked") == "checked") {
            $('input[type=checkbox]').prop('checked', true);
        } else {
            $('input[type=checkbox]').prop('checked', false);
        }
        get_select_num();
    }

    function load_all() {
    	$('input[type=checkbox]').prop('checked', true);
    	get_select_num();
    }
    load_all();

     //获取商品件数
     function get_select_num() {
        var ids = '';
  	    $('.cart_table.mt20').find("input[type=checkbox].choose:checked").each(function (i, n) {
  	        ids += $(this).val() + ',';
  	    });
  	    if (!ids) {
  	    	$('#gold_score_total').html('0');
            $('#silver_score_total').html('0');
            $('#totalPrice').html('0.00');
            return;
  	  	}
        $.post(base_url + "index.php/" + controller + "/get_select_cart_info",
             {
                 "ids": ids.substr(0, ids.length - 1)
             },
             function (res) {
                 if (res.success) {
                	 $('#gold_score_total').html(res.data.gold_score_total);
		             $('#silver_score_total').html(res.data.silver_score_total);
  	                 $('#totalPrice').html(res.data.total);
                 } else {
                	 return my_alert('fail', 0, res.message);
                 }
             },
             "json"
         );
     }

     //商品
     function select_item(obj) {
         if ($(obj).attr("checked") == "checked") {
             //所有
             var all_num = $('.cart_table.mt20').find("input[type=checkbox].choose").size();
             var all_select_num = $('.cart_table.mt20').find("input[type=checkbox].choose:checked").size();
             if (all_num == all_select_num) {
                 $('input[type=checkbox].choose_all').prop('checked', true);
             }
         } else {
             $('input[type=checkbox].choose_all').prop('checked', false);
         }
         get_select_num();
     }

     //删除商品
     function delete_item(obj, delete_ids) {
         var ids = '';
         $('.cart_table.mt20').find("input[type=checkbox].choose:checked").each(function (i, n) {
    	        ids += $(this).val() + ',';
    	 });
         $.post(base_url + "index.php/" + controller + "/delete_cart_product",
             {
                 "select_ids": ids.substr(0, ids.length - 1),
                 "delete_ids": delete_ids
             },
             function (res) {
                 if (res.success) {
                	 $(obj).parent().parent().remove();
                	 $('#gold_score_total').html(res.data.gold_score_total);
		             $('#silver_score_total').html(res.data.silver_score_total);
  	                 $('#totalPrice').html(res.data.total);
                 } else {
                	 return my_alert('fail', 0, res.message);
                 }
             },
             "json"
         );
     }

     //批量删除
     function batch_delete_item() {
         var ids = '';
         $('.cart_table.mt20').find("input[type=checkbox].choose:checked").each(function (i, n) {
	  	     ids += $(this).val() + ',';
	  	 });
         if (!ids) {
        	 return my_alert('fail', 0, '请选择删除项');
         }
         $.post(base_url + "index.php/" + controller + "/batch_delete_cart_product",
             {
                 "delete_ids": ids.substr(0, ids.length - 1)
             },
             function (res) {
                 if (res.success) {
                	 $('.cart_table.mt20').find("input[type=checkbox].choose:checked").each(function (i, n) {
                		 $(this).parent().parent().remove();
                     });
                	 $('#gold_score_total').html(res.data.gold_score_total);
		             $('#silver_score_total').html(res.data.silver_score_total);
  	                 $('#totalPrice').html(res.data.total);
                 } else {
                	 return my_alert('fail', 0, res.message);
                 }
             },
             "json"
         );
     }

     //移入收藏夹
     function move_to_favorite(obj, cart_id) {
         var ids = '';
         $('.cart_table.mt20').find("input[type=checkbox].choose:checked").each(function (i, n) {
	  	     ids += $(this).val() + ',';
	  	 });
         $.post(base_url + "index.php/" + controller + "/move_product_to_favorite",
             {
                 "select_ids": ids.substr(0, ids.length - 1),
                 "cart_id": cart_id
             },
             function (res) {
                 if (res.success) {
                	 $(obj).parent().parent().remove();
                	 $('#gold_score_total').html(res.data.gold_score_total);
		             $('#silver_score_total').html(res.data.silver_score_total);
  	                 $('#totalPrice').html(res.data.total);
                 } else {
                	 return my_alert('fail', 0, res.message);
                 }
             },
             "json"
         );
     }

     function go_buy() {
         var ids = '';
         $('.cart_table.mt20').find("input[type=checkbox].choose:checked").each(function (i, n) {
             ids += $(this).val() + ',';
         });
         if (!ids) {
        	 return my_alert('fail', 0, '请选择结算商品');
         }
         $('#go_to_submit').submit();
     }
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>