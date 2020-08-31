<div class="sub_banner" style="background:url(images/default/sub_bannre.png) no-repeat center top"></div>
<div class="warp">
    <div class="special_tab mt30">
        <ul>
            <Li class="current"><a href="xskj.html"><img src="images/default/img7.png"><span>限时秒杀</span></a></Li>
            <Li ><a href="jcdr.html"><img src="images/default/img7.png"><span>竞猜达人</span></a></Li>
            <Li ><a href="qmkj.html"><img src="images/default/img7.png"><span>全民砍价</span></a></Li>
            <Li><a href="xyzp.html"><img src="images/default/img7.png"><span>幸运转盘</span></a></Li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="floor-tit mt30">
        <div class="bt"><strong><i class="icon xskj_icon"></i>限时秒杀</strong><span>Limited-time seconds kill</span></div>
    </div> 
    <div class="limited_tab">

        <div class="bd">
            <div class="clearfix">
                <ul class="event_bar mt10">
                    <Li class="<?php if (time() > strtotime(date('Y-m-d 17:30:00'))) {
    echo 'finish';
} if (time() >= strtotime(date('Y-m-d 17:00:00')) && time() <= strtotime(date('Y-m-d 17:30:00'))) {
    echo 'current';
} ?>"><span class="icon"></span><?php echo date('m月d日 17:00'); ?> <?php if (time() > strtotime(date('Y-m-d 17:30:00'))) {
    echo '已结束';
} if (time() >= strtotime(date('Y-m-d 17:00:00')) && time() <= strtotime(date('Y-m-d 17:30:00'))) {
    echo '秒杀中';
} if (time() < strtotime(date('Y-m-d 17:00:00'))) {
    echo '待开始';
} ?></Li>
                    <Li class="<?php if (time() > strtotime(date('Y-m-d 21:30:00'))) {
    echo 'finish';
} if (time() >= strtotime(date('Y-m-d 21:00:00')) && time() <= strtotime(date('Y-m-d 21:30:00'))) {
    echo 'current';
} ?>"><span class="icon"></span><?php echo date('m月d日 21:00'); ?> <?php if (time() > strtotime(date('Y-m-d 21:30:00'))) {
    echo '已结束';
} if (time() >= strtotime(date('Y-m-d 21:00:00')) && time() <= strtotime(date('Y-m-d 21:30:00'))) {
    echo '秒杀中';
} if (time() < strtotime(date('Y-m-d 21:00:00'))) {
    echo '待开始';
} ?> </Li>
                    <Li><span class="icon"></span><?php echo date('m月d日 21:00', time() + 24 * 60 * 60); ?> 待开始</Li>
                </ul>
                <div class="limited_item">
                    <ul>
<?php
if ($item_list) {
    foreach ($item_list as $item) {
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
    </div>
</div>
<script>
    function countdown(ele) {
        var t = $(ele).data('time');
        var ID = setInterval(function () {
            t--;
            var m = Math.floor(t / 60 % 60);
            var s = Math.floor(t % 60);
            if (m < 10) {
                m = "0" + m;
            }
            if (s < 10) {
                s = "0" + s;
            }
            $(ele).html('剩余时间: '+m+' 分钟 '+s+' 秒');
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
