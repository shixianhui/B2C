        <?php
	$adList = $this->advdbclass->getAd(50, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
<div class="sub_banner" style="background:url(<?php echo $ad['path'];?>) no-repeat center top"></div>
   <?php }} ?>
<div class="warp">
<!--    <div class="special_tab mt30">
        <ul>
            <Li class="current"><a href=""><img src="images/default/img7.png"><span>拼团砍价</span></a></Li>
            <Li><a href=""><img src="images/default/img7.png"><span>幸运转盘</span></a></Li>
            <Li><a href=""><img src="images/default/img7.png"><span>竞猜达人</span></a></Li>
            <Li><a href=""><img src="images/default/img7.png"><span>限时秒杀</span></a></Li>
        </ul>
    </div>-->
    <div class="clear"></div>
    <div class="floor-tit mt30">
        <div class="bt"><strong><i class="icon"></i>拼团砍价</strong><span>bargaining </span></div>
<!--        <a href="mryg.html" class="time"><i class="icon"></i>明日预告</a>-->
    </div> 
    <?php
    if ($item_list) {
        foreach ($item_list as $item) {
            ?>
            <div class="special_item clearfix" data-time="<?php echo $item['end_time'] - time(); ?>">
                <div class="picture"><img class="lazy" data-original="<?php echo $item['path']; ?>"></div>
                <div class="information">
                    <h4 class="nowrap"><?php echo $item['name']; ?></h4>
                    <div class="price"><small>¥</small><?php echo $item['pintuan_price']; ?><span class="status">当前价</span><s>¥<?php echo $item['sell_price']; ?></s></div>
                    <div class="process">已参加<font class="purple ml10"><?php echo $item['pintuan_people'];?>人</font></div>
                    <div class="time">距结束：<em>16</em>时<em>38</em>分<em>16</em>秒</div>
                    <a href="<?php echo getBaseUrl(false,"","bargain/detail/".$item['id'],$client_index)?>" class="btn t-f"  >查看详情</a>
                </div>
            </div>
        <?php }
    } ?>
    <div class="clear"></div>
    <div class="special_introduce mt30">
        <h2><span>活动规则</span></h2>
        <p>1、开团时间：<font class="purple">每日10:00-20:00</font>，拼团砍价活动开启！次日活动将在今日12:00进行预告。</p>
        <p>2、拼团规则：活动期间，产品价格将会随参团人数的增加而减少，（如:人数1-99人，价格为100；人数100-199，价格为90，以此类推。）<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当参团人数达最高值时，可享受本次活动的最低参团价格。</p>
        <p>3、砍价规则：参团用户可邀请好友在当前拼团价的基础上进行砍价，砍价金额随机，最高可砍至产品底价。</p>
        <p>4、购买规则：每款活动产品，<font class="purple">每个ID限购一件</font>，且不享受积分抵扣和包邮等其它优惠政策。</p>
        <p>5、订单支付：<font class="purple">支付价格=当前拼团价-好友协助砍价金额</font>，活动订单需在当日完成支付，否则视为无效订单。</p>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
    function countdown(ele) {
        var t = $(ele).data('time');
        var h = Math.floor(t / 60 / 60 % 1000)
        var m = Math.floor(t / 60 % 60);
        var s = Math.floor(t % 60);
        if (h < 10) {
            h = "0" + h;
        }
        if (m < 10) {
            m = "0" + m;
        }
        if (s < 10) {
            s = "0" + s;
        }
        $(ele).find('.time').html('距结束：<em>'+h+'</em>时<em>'+m+'</em>分<em>'+s+'</em>秒');
        var ID = setInterval(function () {
            t--;
            var h = Math.floor(t / 60 / 60 % 1000)
            var m = Math.floor(t / 60 % 60);
            var s = Math.floor(t % 60);
            if (h < 10) {
                h = "0" + h;
            }
            if (m < 10) {
                m = "0" + m;
            }
            if (s < 10) {
                s = "0" + s;
            }
            $(ele).find('.time').html('距结束：<em>'+h+'</em>时<em>'+m+'</em>分<em>'+s+'</em>秒');
            if (t <= 0) {
                clearInterval(ID);
                //  $("#countdown").html('该拼团活动已结束');
            }
        }, 1000);
    }
  $(".special_item").each(function(){
      countdown(this);
  })
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>


