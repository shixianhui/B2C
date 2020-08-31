<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt"><?php echo $order_type_arr[$order_type]; ?></span></div>
            <div class="member_tab mt20">
                <?php $adList = $this->advdbclass->getTextAd(52, 10); ?>
                <div style="<?php if (!$adList) {echo 'display: none;';} ?>" class="notice"  id="TextVScroll">
                <ul class="clearfix">
                     <?php
                        if ($adList) {
                            foreach ($adList as $ad) {
                            ?>
                        <li><?php echo strip_tags(html($ad['content']));?></li>
                    <?php }} ?>
                 </ul>
                </div>
                <div class="hd">
                    <ul>
                    <li <?php if ($select_status == 'all') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "order/index/all/{$order_type}.html", $client_index); ?>'">全部<?php if ($count_all > 0) { ?><span>(<?php echo $count_all; ?>)</span><?php } ?></li>
                    <li <?php if ($select_status == '0') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "order/index/0/{$order_type}.html", $client_index); ?>'">待付款<?php if ($count_0 > 0) { ?><span>(<?php echo $count_0; ?>)</span><?php } ?></li>
                    <li <?php if ($select_status == '1') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "order/index/1/{$order_type}.html", $client_index); ?>'">待发货<?php if ($count_1 > 0) { ?><span>(<?php echo $count_1; ?>)</span><?php } ?></li>
                    <li <?php if ($select_status == '2') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "order/index/2/{$order_type}.html", $client_index); ?>'">待收货<?php if ($count_2 > 0) { ?><span>(<?php echo $count_2; ?>)</span><?php } ?></li>
                    <li <?php if ($select_status == 'pj') {echo 'class="on"';} ?> onclick="location.href = '<?php echo base_url().getBaseUrl(false, "", "order/index/pj/{$order_type}.html", $client_index); ?>'">待评价<?php if ($count_pj > 0) { ?><span>(<?php echo $count_pj; ?>)</span><?php } ?></li>
                    </ul>
                </div>
                <div class="search">
                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="get" id="search_form">
                        <div class="input"><input type="text" placeholder="输入订单号搜索" name="keyword" value="<?php echo $keyword; ?>"><button type="submit">搜索</button></div>
                        <div class="select">
                            <label>
                                下单时间：
                                <select name="add_time" onchange="javascript:$('#search_form').submit();">
                                    <option value="">全部</option>
                                    <option value="one_week" <?php echo $add_time == 'one_week' ? 'selected' : ''; ?>>近一个星期</option>
                                    <option value="one_month" <?php echo $add_time == 'one_month' ? 'selected' : ''; ?>>近一个月</option>
                                    <option value="three_month" <?php echo $add_time == 'three_month' ? 'selected' : ''; ?>>近三个月</option>
                                </select>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="bd">
                    <div class="clearfix">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
                            <thead>
                                <tr>
                                    <th width="35%" class="tal">商品信息</th>
                                    <th width="13%">商品属性</th>
                                    <th width="8%">单价</th>
                                    <th width="8%">数量</th>
                                    <th width="8%">小计</th>
                                    <th width="14%">订单状态</th>
                                    <th width="14%">操作</th>
                                </tr>
                                <tr>
                                    <td colspan="7" class="bj">&nbsp;</td>
                                </tr>
                            </thead>
                        </table>
                        <table id="member_table" width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table">
                            <tbody>
                                        <?php if ($item_list) { ?>
                                        <?php foreach ($item_list as $order) { ?>
                                        <tr class="list_tr_<?php echo $order['id']; ?>" style="height:50px;">
                                            <th colspan="7" align="left" style="border-right: #e8e8e8 1px solid;border-bottom:1px solid #e8e8e8;">
                                                <?php if ($order['status'] == 4) { ?>
                                                    <span name="checkWeek" class="CheckBoxNoSel checkbox fl" data-order_id="<?php echo $order['id']; ?>" style="margin-top:10px; margin-right:5px;"></span>
                                                    <font class="c9">下单时间：</font>
                                               <?php } else { ?>
                                                <font class="c9" style="margin-left: 18px;">下单时间：</font><?php } ?><font class="c9"><?php echo date('Y-m-d H:i', $order['add_time']); ?></font>&nbsp;&nbsp;&nbsp;<font class="c9">订单编号：<?php echo $order['order_number']; ?></font>&nbsp;&nbsp;&nbsp;<?php if ($order['pay_mode'] > 0) {echo '<font class="c9">购买方式：积分换购</font>';} ?>
                                                    <?php
                                                    if ($order['gold_score'] > 0 && $order['silver_score'] > 0) {
                                                    ?>
                                                    <span class="c9" style="float:right;">赠送<?php echo $order['gold_score']; ?>金象积分、<?php echo $order['silver_score']; ?>银象积分</span>
                                                    <?php } else if ($order['gold_score'] > 0 && $order['silver_score'] == 0) { ?>
                                                    <span class="c9" style="float:right;">赠送<?php echo $order['gold_score']; ?>金象积分</span>
                                                    <?php } else if ($order['gold_score'] == 0 && $order['silver_score'] > 0) { ?>
                                                    <span class="c9" style="float:right;">赠送<?php echo $order['silver_score']; ?>银象积分</span>
                                                    <?php } ?>
                                            </th>
                                        </tr>
                                        <tr class="list_tr_<?php echo $order['id']; ?>">
                                            <td colspan="7" style="padding:0px;border-bottom:none;">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table child_table">
                                                            <?php if ($order['order_detail_list']) {
                                                            	    foreach ($order['order_detail_list'] as $odl_key => $orderdetail) {
                                                                        $url = getBaseUrl($html, "", "product/detail/{$orderdetail['product_id']}.html", $client_index);
                                                            ?>
                                                            <tr>
                                                                <td width="35%" valign="middle">
                                                                    <div class="info"><a href="<?php echo $url; ?>"  ><img src="<?php if ($orderdetail['path']) { echo preg_replace('/\./', '_thumb.', $orderdetail['path']);}else{echo 'images/default/load.jpg';} ?>"><?php echo $orderdetail['product_title']; ?></a></div>
                                                                </td>
                                                                <td width="13%" align="center">
                                                                <?php if ($orderdetail['color_size_open']) { ?>
                                                                <span style="color: #999;"><?php echo $orderdetail['color_name']; ?> <?php echo $orderdetail['size_name']; ?></span>
                                                                <?php } ?>
                                                                </td>
                                                                <td width="8%" align="center"><small>¥</small><?php echo $orderdetail['buy_price']; ?></td>
                                                                <td width="8%" align="center"><?php echo $orderdetail['buy_number']; ?></td>
                                                                <td width="8%" align="center"><span class="purple"><small>¥</small><?php echo number_format($orderdetail['buy_price'] * $orderdetail['buy_number'], 2, '.', ''); ?></span></td>
                                                                <?php
                                                                    if ($odl_key == 0) {
                                                                        ?>
                                                                    <td width="14%" align="center" rowspan="<?php echo count($order['order_detail_list']); ?>" style="border-left:1px solid #e8e8e8;">
                                                                        <span class="padding"><font class="c9" style="font-size:12px;"><?php echo $status_arr[$order['status']]; ?></font></span>
                                                                    </td>
                                                                    <td  width="14%" align="center" rowspan="<?php echo count($order['order_detail_list']); ?>" style="border-left:1px solid #e8e8e8;">
	                                                                <?php if ($order['status'] == 0) { ?>
	                                                                <span class="padding"> <a href="<?php echo getBaseUrl(false, "", "order/pay/{$order['id']}.html", $client_index); ?>"   class="m_btn">立即付款</a></span>
	                                                                <span class="padding"> <a onclick="javascript:open_layer(<?php echo $order['id']; ?>);" href="javascript:void(0);" class="m_btn">取消订单</a></span>
	                                                                <?php } else if ($order['status'] == 1) { ?>
	                                                                <span class="padding"> <a href="javascript:void(0);" onclick="javascript:remind(<?php echo $order['id']; ?>)" class="m_btn">提醒发货</a></span>
	                                                                <?php } else if ($order['status'] == 2) { ?>
	                                                                <span class="padding"><a href="javascript:void(0);" onclick="javascript:changeReceiving(<?php echo $order['id']; ?>)" class="m_btn">确认收货</a></span>
	                                                                <?php } else if ($order['status'] == 3) { ?>
		                                                                <?php if ($order['is_comment_to_seller'] == 0) { ?>
		                                                                <span class="padding"> <a href="<?php echo getBaseUrl(false, "", "user/comment_save/{$order['id']}.html", $client_index); ?>" class="m_btn">去评价</a></span>
		                                                                <?php } ?>
		                                                                <span class="padding"><a href="javascript:void(0);" onclick="javascript:buy_again('<?php echo $order['id']; ?>');" class="m_btn">再次购买</a></span>
	                                                                <?php } else if ($order['status'] == 4) { ?>
	                                                                	<span class="padding"><a href="javascript:void(0);" onclick="javascript:buy_again('<?php echo $order['id']; ?>');" class="m_btn">再次购买</a></span>
	                                                                <?php } ?>
	                                                                <span class="padding"><a href="<?php echo getBaseUrl(false, "", "order/view/{$order['id']}.html", $client_index); ?>" class="c9">查看详情</a></span>
                                                                    </td>
                                                                <?php } ?>
                                                            </tr>
                                                    <?php }
                                                }
                                                ?>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="list_tr_<?php echo $order['id']; ?>" style="height:40px;border-right: #e8e8e8 1px solid;">
                                            <td colspan="7" style="border-right: #e8e8e8 1px solid;padding-left:10px;">
                                                <span style="color:#e61d47;">实付款：<strong>￥<?php echo $order['total']; ?><?php if ($order['pay_mode'] > 0) { ?>+<?php echo $order['deductible_score']; ?>积分<?php } ?></strong>（含运费：<?php echo $order['postage_price']; ?> 元）</span>
                                                <?php if ($order['status'] == 4) { ?>
                                                <div class="delete_cuont" style="display:inline-block;width:50px;float:right;"><a href="javascript:javascript:del_order(<?php echo $order['id']; ?>);"><span class="icon delete_icon"></span></a></div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr class="list_tr_<?php echo $order['id']; ?>" style="border:1px solid #fff;"><td colspan="7" style="border:0px;"></td></tr>
							    <?php }
							}
							?>
                            </tbody>
                        </table>
				<?php
				if ($select_status == 'all' || $select_status == 4) {
				    ?>
                <div class="delete_cuont mt20"><span name="checkWeek" class="CheckBoxNoSel fl" id="selectAll" style="margin-top:2px; margin-right:5px;"></span>全选<a href="javascript:void(0);" id="delete"><span class="icon delete_icon"></span>删除</a></div>
                <?php } ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="pagination">
                <ul><?php echo $pagination; ?></ul>
            </div>
        </div>
    </div>
</div>
<!-- 关闭原因开始 -->
<div id="bg" class="dn"></div>
<div class="popup_box" id="popup_tip" style="display:none">
    <a class="close" href="javascript:void(0);" id="close">×</a>
    <div class="content">
        <div class="tit"><span class="bt">提示</span></div>
        <div class="pop_kj">
            <h2>您确认要取消订单吗？订单取消不能恢复！</h2>
            <div class="cancel_cause">
                <label>
                    请选择理由：
                    <select id="cause">
                        <option value="">-请选择关闭理由-</option>
                        <option value="收货人信息有误">收货人信息有误</option>
                        <option value="商品数量或款式需调整">商品数量或款式需调整</option>
                        <option value="有更优惠的购买方案">有更优惠的购买方案</option>
                        <option value="商品缺货">商品缺货</option>
                        <option value="我不想买了">我不想买了</option>
                        <option value="其他理由">其他理由</option>
                    </select>
                </label>
                <a href="javascript:void(0)" class="btn_r" id="confirm">确定</a>
            </div>
        </div>
    </div>
</div>
<!-- 关闭原因结束 -->
<style>
    span.padding{
        display:inline-block;width:100px;height:24px;padding:8px 0px;
    }
    input.choose{
        position: absolute;
        left:0px;
        top:12px;
    }
    .member_tab .hd ul li{
        width:135px;
        font-weight: bold;
    }
    .member_tab .hd ul li span{
        color:#e61d47;
        padding-left:5px;
    }
    .member_table tbody td{
        padding:10px 0px;
    }
    .member_table tbody td .info{
        width:280px;
        padding-left:10px;
    }
    .pop_kj h2{
        text-align:center;
        font-size:20px;
        margin-top:60px;
    }
    .cancel_cause{
        margin-top:30px;
        text-align:center;
    }
    .cancel_cause label{
        font-size:14px;
        color:#333;
    }
    .cancel_cause .btn_r{
        width:70px;
        height:30px;
        line-height:30px;
        margin-left:10px;
    }
    .search{
        height:40px;
        margin-top:10px;
        margin-bottom: 20px;
    }
    .search .input{
        width:245px;
        height:30px;
        float:left;
        overflow: hidden;
        margin-top:10px;
    }
    .search .input input{
        display:block;
        float:left;
        width:197px;
        height:28px;
        border:1px solid #e8e8e8;
        padding-left:5px;
    }
    .search .input button{
        display:block;
        float:right;
        width:41px;
        height:30px;
        border:1px solid #e8e8e8;
        background-color:#F7F7F7;
        border-left:none;
    }
    .search .input button:active{
        background-color:#f2f2f2;
    }
    .search .select{
        width:185px;
        height:30px;
        float:right;
        margin-top:10px;
    }
    .search .select select{
        width:120px;
        height:30px;
        border:1px solid #e8e8e8;
    }
    .notice{
        height:50px;
        border:1px solid #e8e8e8;
        margin:20px 0px;
        background: url(images/default/laba.png) no-repeat 20px center #FFF8DB;
        background-size:20px 20px;
        overflow: hidden;
        position:relative;
    }
    .notice ul {
        width: 100%;
        height: auto;
        position: absolute;
        left: 0px;
        top: 0px;
    }
    .notice ul li{
        width:100%;
        height:50px;
        line-height: 50px;
        text-indent:50px;
        font-size:14px;
        color:#333;
    }
</style>
<script src="js/default/jquery.TextVScroll.js" type="text/javascript"></script>
<script type="text/javascript">
	$("#TextVScroll").TextVScroll();

	$(function() {
		$("img.lazy").lazyload({
			placeholder: "images/default/load.jpg", //加载图片前的占位图片
			effect: "fadeIn" //加载图片使用的效果(淡入)
		});
	});

	$("#selectAll").click(function() {
		if(!$(this).hasClass('CheckBoxSel')) {
			$(".checkbox").addClass('CheckBoxSel');
		} else {
			$(".checkbox").removeClass('CheckBoxSel');
		};
	});

	$("#delete").click(function() {
		var ids = '';
		$(".checkbox").each(function() {
			if($(this).hasClass('CheckBoxSel')) {
				ids += $(this).data('order_id') + ',';
			}
		});
		if(!ids) {
			var d = dialog({
				title: '提示',
				fixed: true,
				content: '请选择您要删除的订单'
			});
			d.show();
			setTimeout(function() {
				d.close().remove();
			}, 2000);
			return;
		}
		var d = dialog({
			title: '提示',
			width: 300,
			fixed: true,
			content: '您确定要删除所选订单吗',
			okValue: '确定',
			ok: function() {
					$.post(base_url + "index.php/order/delete_order", {
						"ids": ids.substr(0, ids.length - 1)
					},
					function(res) {
						if(res.success) {
							for (var i = 0, data = res.data.ids, len = data.length; i < len; i++){
								$(".list_tr_"+data[i]).remove();
							}
							var size = $('#member_table tr').size();
							if (size == 0) {
		                        window.location.reload();
						    }
						} else {
							var d = dialog({
								title: '提示',
								fixed: true,
								content: res.message
							});
							d.show();
							setTimeout(function() {
								d.close().remove();
							}, 2000);
							return false;
						}
					},
					"json"
				);
			},
			cancelValue: '取消',
			cancel: function() {}
		});
		d.show();
	});

	function del_order(ids) {
		var d = dialog({
			title: '提示',
			width: 300,
			fixed: true,
			content: '您确定要删除此订单吗',
			okValue: '确定',
			ok: function() {
				$.post(base_url + "index.php/order/delete_order", {
						"ids": ids,
					},
					function(res) {
						if(res.success) {
							for (var i = 0, data = res.data.ids, len = data.length; i < len; i++){
								$(".list_tr_"+data[i]).remove();
							}
							var size = $('#member_table tr').size();
							if (size == 0) {
		                        window.location.reload();
						    }
						} else {
							var d = dialog({
								title: '提示',
								fixed: true,
								content: res.message
							});
							d.show();
							setTimeout(function() {
								d.close().remove();
							}, 2000);
							return false;
						}
					},
					"json"
				);
			},
			cancelValue: '取消',
			cancel: function() {}
		});
		d.show();
	}

	function open_layer(id) {
		$("#bg").stop(true, true).fadeIn('300');
		$("#popup_tip").stop(true, true).fadeIn('300');
		$("#confirm").attr('onclick', 'close_order(' + id + ')');
	}

	function close_order(id) {
		if(!$("#cause").val()) {
			return my_alert('fail', 0, '请选择关闭理由');
		}
		$.post(base_url + 'index.php/order/close_order', {
			'id': id,
			'cancel_cause': $("#cause").val()
		}, function(data) {
			if(data.success) {
				$("#bg").hide();
				$("#popup_tip").hide();
				return my_alert_flush('fail', 0, '交易关闭成功');
			}
			alert(data.message);
		}, 'json');
	}
	//确认收货
	function changeReceiving(id) {
		var d = dialog({
			title: '提示',
			width: 300,
			fixed: true,
			content: '您确认已经收到货，进行”确认收货“操作？',
			okValue: '确认收货',
			ok: function() {
				$.post(base_url + "index.php/order/receiving", {
					"id": id
				},
				function(res) {
					if(res.success) {
						window.location.reload();
					} else {
						return my_alert('fail', 0, res.message);
					}
				},
				"json"
			);
			}
		});
		d.show();
	}

	//提醒发货
	function remind(id) {
		$.post(base_url + "index.php/order/remind_deliver_goods", {
				"order_id": id
			},
			function(res) {
				return my_alert('fail', 0, res.message);
			},
			"json"
		);
	}
	
	//再次购买
	function buy_again(order_id) {
		$.post(base_url + "index.php/order/buy_again", {
				"order_id": order_id
			},
			function(res) {
				if(res.success) {
					$('.cartInfo_number').html(res.data.cart_count);
					return my_alert('fail', 0, '再次购买成功');
				} else {
					return my_alert('fail', 0, res.message);
				}
			},
			"json"
		);
	}
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>