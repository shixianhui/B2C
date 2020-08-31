<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right mt20">
        <div class="member_headline box_shadow clearfix">
            <div class="info" style="display:flex; align-items:center;">
                <div style="width:100px; height:100px;margin-right:15px; overflow:hidden; border-radius:50%;"><img style="margin:0;width:100%;" src="<?php if ($userInfo){echo preg_match('/^http/',$userInfo['path']) ? $userInfo['path'] : preg_replace("/\./","_thumb.",$userInfo['path']);} ?>" onerror="this.src='images/default/defluat.png'"></div>
                <p style="margin:0;width:280px;">
                	<b><?php echo get_cookie('user_username');?><?php if ($userInfo && !$userInfo['username']){ ?><a style="display:inline;margin-left: 20px;color: red;" href="<?php echo getBaseUrl(false,"","user/bind_mobile",$client_index);?>">绑定手机</a><?php } ?></b>
                	上次登录时间：<?php if ($userInfo) { echo date('Y-m-d H:i:s',$userInfo['login_time']); } ?><br />
                	上次登录IP：<?php if ($userInfo) { echo $userInfo['ip'].' '.$userInfo['ip_address']; } ?><br />
                	<a href="<?php echo getBaseUrl(false,"","user/change_user_info",$client_index);?>">修改资料/图像</a>
                </p>
            </div>
            <ul class="short">
                <Li><b><a href="<?php echo getBaseUrl(false,'','user/get_financial_list.html',$client_index);?>">我的余额</a></b>
                    <span class="purple"><small>￥</small><?php echo $userInfo['total'];?></span><a href="<?php echo getBaseUrl(false,"","user/recharge.html",$client_index);?>" class="m_btn" id="recharge">充值</a>
                </Li>
                <Li><b><a href="<?php echo getBaseUrl(false,'','user/get_score_list/gold.html',$client_index);?>">我的金象积分</a></b>
                    <span><?php if ($userInfo) { echo $userInfo['score_gold'];}?></span>
                </Li>
                <Li><b><a href="<?php echo getBaseUrl(false,'','user/get_score_list/silver.html',$client_index);?>">我的银象积分</a></b>
                    <span><?php if ($userInfo) { echo $userInfo['score_silver'];}?></span>
                </Li>
            </ul>
            <?php
             if(empty($userInfo['pay_password'])){
            ?>
            <div class="ui-tooltips arrow-top-left"><a href="javascript:$(this).fadeOut();" rel="nofollow" role="button" class="close">×</a><p>您尚未设置支付密码，前去<a href="<?php echo getBaseUrl(false,'','user/change_pay_password',$client_index);?>" data-track="done">设置</a>，让支付更安全！</p></div>
             <?php }?>
        </div>
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">最近订单</span><a href="<?php echo getBaseUrl($html, "", "order.html", $client_index); ?>" class="more">查看全部订单</a></div>
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

                             <tbody>
<?php if ($orderList) { ?>
    <?php foreach ($orderList as $order) { ?>
                                        <tr style="height:50px;">
                                            <th colspan="7" align="left" style="border-right: #e8e8e8 1px solid;">
                                                <font class="c9">下单时间：</font><?php echo date('Y-m-d', $order['add_time']); ?>&nbsp;&nbsp;&nbsp;订单编号：<?php echo $order['order_number']; ?><?php if ($order['status'] == 4) { ?>
                                                  <?php
                                                    if($order['exchange_status']==-1){
                                                  ?>
                                                <a href="<?php echo getBaseUrl(false, "", "user/save_exchange.html?order_number={$order['order_number']}", $client_index); ?>" class="btn" style="float:right;position:relative;left:-20px;color:#e61d47;" target="_blank;">申请退款/退货</a>
                                                  <?php }else{?>
                                                <a href="javascript:;" class="btn" style="float:right;position:relative;left:-20px;color:#e61d47;" target="_blank;"><?php echo $order['exchange_status'];?></a>
                                                    <?php }?>

                                                    <?php  } ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table child_table">
                                                <?php if ($order['orderdetailList']) { ?>
                                                    <?php
                                                    foreach ($order['orderdetailList'] as $odl_key => $orderdetail) {
                                                        $url = getBaseUrl($html, "", "product/detail/{$orderdetail['product_id']}.html", $client_index);
                                                        ?>
                                                <tr>
                                                    <td width="35%" valign="middle" style="border-bottom: #fff;">
                                                    	<div class="info">
                                                    		<a href="<?php echo $url; ?>"><img src="<?php echo preg_replace('/\./', '_thumb.', $orderdetail['path']); ?>"><?php echo $orderdetail['product_title']; ?></a>
                                                    	</div>
                                                    </td>
                                                    <td width="13%" align="center" style="border-bottom: #fff;">
                                                        <?php if ($orderdetail['color_size_open']) { ?>
                                                        <?php echo $orderdetail['color_name']; ?> <?php echo $orderdetail['size_name']; ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td width="8%" align="center" <?php echo 'style="border-bottom: #fff;"';?>>
                                                     <?php if ($order['discount_total'] > 0) { ?>
                                                     <s style="color: #999;"><small>¥</small><?php echo $orderdetail['old_price']; ?></s><br/>
                                                     <?php } ?>
                                                    <small>¥</small><?php echo $orderdetail['buy_price']; ?>
                                                    </td>
                                                    <td width="8%" align="center" style="border-bottom: #fff;"><?php echo $orderdetail['buy_number']; ?></td>
                                                    <td width="8%" align="center" style="border-bottom: #fff;"><span class="purple"><small>¥</small><?php echo $orderdetail['buy_price']*$orderdetail['buy_number']; ?></span></td>
                                                    <td width="14%" align="center" style="border-bottom: #fff;">
                                                        <font class="c9"><?php echo $status[$order['status']] ?></font><br><a href="<?php echo getBaseUrl(false, "", "order/view/{$order['id']}.html", $client_index); ?>"><font class="c9">查看详情</font></a>
                                                     <?php
                if ($order['status'] == 4) {
                    ?>
                                                        <?php if($orderdetail['comment_status']==0){?>
                                                        <br> <a style="margin-top:5px;" href="<?php echo getBaseUrl(false, "", "user/comment_save?order_number={$order['order_number']}&product_id={$orderdetail['product_id']}", $client_index); ?>" class="m_btn">评价</a>
                                                        <?php }?>
                                                         <?php if($orderdetail['comment_status']==1){?>
                                                        <br> <a style="margin-top:5px;color:#999;border-color:#999;" href="javascript:void(0);" class="m_btn">已评价</a>
                                                        <?php }?>
                                                            <?php
                }
                ?>
                                                    </td>
                                                    <?php
                                                        if($odl_key==0){
                                                    ?>
                                                    <td width="14%" align="center" style="border-bottom: #fff;" rowspan="<?php echo count($order['orderdetailList']);?>">
                                                        <?php
		                                                if ($order['status'] == 0) {
		                                                ?>
		                                                        <a href="index.php/order/pay/<?php echo $order['id'];?>.html"   style="margin-bottom:20px;"  class="m_btn">立即付款</a>
		                                                <?php }?>          
                                                    </td>
                                                    <?php }?>
                                                </tr>
            <?php }
        } ?>
                                                </table>
                                                </td>
                                                </tr>
                                                <tr style="height:40px;border-right: #e8e8e8 1px solid;">
                                                    <td colspan="7" style="border-right: #e8e8e8 1px solid;">
                                                        <span style="color:#e61d47;">实付款：<strong>￥<?php echo $order['total']; ?><?php if ($order['pay_mode'] > 0) { ?>+<?php echo $order['deductible_score']; ?>积分<?php } ?></strong>（含运费：<?php echo $order['postage_price'];?> 元）</span>
                                                    </td>
                                                </tr>
                                                <tr style="border:1px solid #fff;"><td colspan="7" style="border:0px;"></td></tr>
    <?php }
} ?>
                            </tbody>
            </table>
        </div>
<!--        <div class="box_shadow clearfix mt20 m_border member_product">
            <div class="member_title"><span class="bt">猜您喜欢的产品</span></div>
            <div class="bd">
                <a href="javascript:void(0)" class="prev"></a>
                <a href="javascript:void(0)" class="next"><i class="icon"></i></a>
                <ul class="picList">
                    <Li>
                        <div class="picture"><a href="product_detail.html"><img class="lazy" data-original="images/default/img5.png"></a></div>
                        <div class="property"><P class="nowrap"><a href="product_detail.html">夏季时尚女灰色修身连衣裙</a></P>
                            <p><span class="price"><small>￥</small>168<s>￥598</s></span></p>
                        </div>
                    </Li>
                </ul>
            </div>
        </div>-->
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
  $("#recharge").click(function(){
      var flag = <?php echo empty($userInfo['pay_password']) ? 'true' : 'false';?>;
      if(flag){
           var d = dialog({
                width: 200,
                fixed: true,
                title: '提示',
                content: '您尚未设置支付密码',
                okValue: '去设置',
                ok: function () {
                    window.location.href = base_url + 'index.php/user/change_pay_password.html';
                },
            });
            d.show();
            return false;
      }
  });
  <?php if ($userInfo && !$userInfo['username']) { ?>
  	var d_bind = dialog({
                width: 300,
                fixed: true,
                title: '提示',
                content: '为确保您账户的安全及正常使用，依《网络安全法》相关要求，会员账户需绑定手机。如您还未绑定，请尽快完成，感谢您的理解及支持！',
                okValue: '去绑定手机',
                ok: function () {
                    window.location.href = base_url + 'index.php/user/bind_mobile.html';
                },
    });
    d_bind.show();
  <?php } ?>
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>

