        <?php
	$adList = $this->advdbclass->getAd(49, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
<div class="sub_banner" style="background:url(<?php echo $ad['path'];?>) no-repeat center top"></div>
   <?php }} ?>
<div class="warp">
    <div class="clear"></div>
    <div class="floor-tit mt30">
        <div class="bt"><strong><i class="icon xskj_icon"></i>限时抢购</strong><span>Limited-time seconds kill</span></div>
    </div> 
    <div class="limited_tab">
        <div class="hd mt10">
            <ul>
                <li class="on">今日抢购</li>
                <li class="">明日预告</li>
            </ul>
        </div>
        <div class="bd">
            <div class="clearfix" style="display: block;">
                <ul class="event_bar mt10">
                    <li style="width:100%;" class="<?php $str='待开始';if (time() > strtotime(date('Y-m-d 13:00:00'))) { $str = '已结束';echo 'finish';} if (time() >= strtotime(date('Y-m-d 12:00:00')) && time() <= strtotime(date('Y-m-d 13:00:00'))) { $str = '抢购中'; echo 'current';} ?>"><span class="icon"></span>12:00~13:00 <?php echo $str;?></li>
                </ul>
                <div class="limited_item clearfix">
                    <ul>
                        <?php
if ($today_list_am) {
    foreach ($today_list_am as $item) {
        ?>
                                <Li>
                                    <div class="picture"><a href="<?php echo getBaseUrl(false,'','purchase/detail/'.$item['id'].'.html',$client_index);?>"><img class="lazy" data-original="<?php echo str_replace('.', '_thumb.', $item['path']); ?>"></a></div>
                                    <div class="property clearfix">
                                        <P class="name nowrap"><?php echo $item['name']; ?></P>
                                        <p class="price clearfix"><span class="fl">特价：￥<b><?php echo $item['flash_sale_price']; ?></b></span>
                                            <span class="fr c9">专柜价：<s>￥<?php echo $item['market_price']; ?></s></span>
                                        </p>
                                       <P><a href="<?php echo getBaseUrl(false,'','purchase/detail/'.$item['id'].'.html',$client_index);?>" <?php if(time() > $item['end_time'] || time() < $item['start_time'] || $item['stock'] <=0){ echo 'class="btn btn_gray"';}?> <?php if(time() >= $item['start_time'] && time() < $item['end_time'] && $item['stock'] > 0){ echo 'class="btn flash_sale" data-time="'.($item['end_time']-time()).'"';}?>><?php if(time() >= $item['start_time'] && time() < $item['end_time'] && $item['stock'] > 0){echo '剩余时间： 20 分 30 秒';} if(time() > $item['end_time'] && $item['stock'] >0){ echo '已结束';} if(time() < $item['start_time']){ echo '待开始';} if($item['stock'] <= 0){ echo '已抢光';}?></a></P>
                                    </div>
                                </Li>
    <?php }
} ?>
                    </ul>
                </div>
                <ul class="event_bar mt10">
                    <li  style="width:100%;" class="<?php $str='待开始';if (time() > strtotime(date('Y-m-d 21:00:00'))) { $str = '已结束'; echo 'finish';} if (time() >= strtotime(date('Y-m-d 20:00:00')) && time() <= strtotime(date('Y-m-d 21:00:00'))) { $str = '抢购中';echo 'current';} ?>"><span class="icon"></span>20:00~21:00 <?php echo $str;?></li>
                </ul>
                 <div class="limited_item clearfix">
                    <ul>
                        <?php
if ($today_list_pm) {
    foreach ($today_list_pm as $item) {
        ?>
                                <Li>
                                    <div class="picture"><a href="<?php echo getBaseUrl(false,'','purchase/detail/'.$item['id'].'.html',$client_index);?>"><img class="lazy" data-original="<?php echo str_replace('.', '_thumb.', $item['path']); ?>"></a></div>
                                    <div class="property clearfix">
                                        <P class="name nowrap"><?php echo $item['name']; ?></P>
                                        <p class="price clearfix"><span class="fl">特价：￥<b><?php echo $item['flash_sale_price']; ?></b></span>
                                            <span class="fr c9">专柜价：<s>￥<?php echo $item['market_price']; ?></s></span>
                                        </p>
                                        <P><a   href="<?php echo getBaseUrl(false,'','purchase/detail/'.$item['id'].'.html',$client_index);?>" <?php if(time() > $item['end_time'] || time() < $item['start_time'] || $item['stock'] <=0){ echo 'class="btn btn_gray"';}?> <?php if(time() >= $item['start_time'] && time() < $item['end_time'] && $item['stock'] > 0){ echo 'class="btn flash_sale" data-time="'.($item['end_time']-time()).'"';}?>><?php if(time() >= $item['start_time'] && time() < $item['end_time'] && $item['stock'] > 0){echo '剩余时间： 20 分 30 秒';} if(time() > $item['end_time'] && $item['stock'] >0){ echo '已结束';} if(time() < $item['start_time']){ echo '待开始';} if($item['stock'] <= 0){ echo '已抢光';}?></a></P>
                                    </div>
                                </Li>
    <?php }
} ?>
                    </ul>
                </div>
            </div>

            <div class="clearfix" style="display: none;">
                <ul class="event_bar mt10">
                    <li  style="width:100%;"><span class="icon"></span>12:00~13:00 待开始</li>
                </ul>
                <div class="limited_item clearfix">
                    <ul>
                                                <?php
if ($tomorrow_list_am) {
    foreach ($tomorrow_list_am as $item) {
        ?>
                                <Li>
                                    <div class="picture"><a href="<?php echo getBaseUrl(false,'','purchase/detail/'.$item['id'].'.html',$client_index);?>"><img class="lazy" data-original="<?php echo str_replace('.', '_thumb.', $item['path']); ?>"></a></div>
                                    <div class="property clearfix">
                                        <P class="name nowrap"><?php echo $item['name']; ?></P>
                                        <p class="price clearfix"><span class="fl">特价：￥<b><?php echo $item['flash_sale_price']; ?></b></span>
                                            <span class="fr c9">专柜价：<s>￥<?php echo $item['old_price']; ?></s></span>
                                        </p>
         <P><a href="<?php echo getBaseUrl(false,'','purchase/detail/'.$item['id'].'.html',$client_index);?>" <?php if(time() > $item['end_time'] || time() < $item['start_time']){ echo 'class="btn btn_gray"';}?> <?php if(time() >= $item['start_time'] && time() < $item['end_time']){ echo 'class="btn flash_sale" data-time="'.($item['end_time']-time()).'"';}?>><?php if(time() >= $item['start_time'] && time() < $item['end_time']){echo '剩余时间： 20 分 30 秒';} if(time() > $item['end_time']){ echo '已结束';} if(time() < $item['end_time']){ echo '待开始';}?></a></P>
                                    </div>
                                </Li>
    <?php }
} ?>
                    </ul>
                </div>
                <ul class="event_bar mt10">
                    <li  style="width:100%;"><span class="icon"></span>20:00~21:00 待开始</li>
                </ul>
               <div class="limited_item clearfix">
                    <ul>
                                                <?php
if ($tomorrow_list_pm) {
    foreach ($tomorrow_list_pm as $item) {
        ?>
                                <Li>
                                    <div class="picture"><a href="<?php echo getBaseUrl(false,'','purchase/detail/'.$item['id'].'.html',$client_index);?>"><img class="lazy" data-original="<?php echo str_replace('.', '_thumb.', $item['path']); ?>"></a></div>
                                    <div class="property clearfix">
                                        <P class="name nowrap"><?php echo $item['name']; ?></P>
                                        <p class="price clearfix"><span class="fl">特价：￥<b><?php echo $item['flash_sale_price']; ?></b></span>
                                            <span class="fr c9">专柜价：<s>￥<?php echo $item['old_price']; ?></s></span>
                                        </p>
         <P><a href="<?php echo getBaseUrl(false,'','purchase/detail/'.$item['id'].'.html',$client_index);?>" <?php if(time() > $item['end_time'] || time() < $item['start_time']){ echo 'class="btn btn_gray"';}?> <?php if(time() >= $item['start_time'] && time() < $item['end_time']){ echo 'class="btn flash_sale" data-time="'.($item['end_time']-time()).'"';}?>><?php if(time() >= $item['start_time'] && time() < $item['end_time']){echo '剩余时间： 20 分 30 秒';} if(time() > $item['end_time']){ echo '已结束';} if(time() < $item['end_time']){ echo '待开始';}?></a></P>
                                    </div>
                                </Li>
    <?php }
} ?>
                    </ul>
                </div>
            </div>
        </div>
         <div class="clear"></div>
    <div class="special_introduce mt30">
        <h2><span>活动规则</span></h2>
        <p>1、开团时间：<font class="purple">每日12:00-13:00 和 20:00-21:00</font>，限时抢购活动开启！次日活动将在今日12:00进行预告。</p>
        <p>2、活动规则：每款活动产品，<font class="purple">每个ID限购一件</font>，且不享受积分抵扣和包邮等其它优惠政策。</p>
        <p>3、订单支付：活动订单最迟需在提交<font class="purple">订单后30分钟内完成支付</font>，否则视为无效订单。</p>
    </div>
    </div>
</div>
<script>
    function countdown(ele) {
        var t = $(ele).data('time');
        var ID = setInterval(function () {
            t--;
            var h = Math.floor(t / 3600 % 24);
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
            $(ele).html('剩余时间: '+h+' 小时 '+m+' 分钟 '+s+' 秒');
            if (t <= 0) {
                clearInterval(ID);
                $(ele).addClass('btn_gray');
                $(ele).html('已结束');
            }
        }, 1000);
    }
    $(".flash_sale").each(function () {
        countdown(this);
    })
</script>
