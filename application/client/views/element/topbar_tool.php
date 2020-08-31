<div class="topbar">
    <div class="warp">
        <div class="wel">您好，欢迎来到携众易购！<?php if (get_cookie('user_id')) {?> <a href="<?php echo getBaseUrl(false,'','user/index.html',$client_index);?>"><?php echo get_cookie('user_username'); ?></a><a href="<?php echo getBaseUrl(false,'','user/logout.html',$client_index);?>">退出</a><?php }else{?><a href="<?php echo getBaseUrl(false,'','user/login.html',$client_index);?>">请登录</a><a href="<?php echo getBaseUrl(false,'','user/register.html',$client_index);?>"><font class="purple">快速注册</font></a><?php }?></div>
        <div class="smlink">
            <ul>
                <li class="pop_box" id="link0"><a href="<?php echo getBaseUrl(false,'','user.html',$client_index);?>" class="tit">我的携众易购</a></li>
                <li>|</li>
                <li class="pop_box" id="link1"><a href="<?php echo getBaseUrl(false,'','order/index/all.html',$client_index);?>" class="tit">我的订单<i class="arrow icon"></i></a>
                    <ul class="subnav">
                        <Li><a href="<?php echo getBaseUrl(false,'','order/index/0.html',$client_index);?>">待付款</a></Li>
                        <Li><a href="<?php echo getBaseUrl(false,'','order/index/1.html',$client_index);?>">待发货</a></Li>
                        <Li><a href="<?php echo getBaseUrl(false,'','order/index/2.html',$client_index);?>">待收货</a></Li>
                        <Li><a href="<?php echo getBaseUrl(false,'','order/index/pj.html',$client_index);?>">待评价</a></Li>
                    </ul>
                </li>
                 <li>|</li>
                <li class="pop_box" id="link9"><a href="<?php echo getBaseUrl(false,'','user/get_favorite_list.html',$client_index);?>" class="tit">我的收藏</a>
                </li>
                <li>|</li>
                <li class="ml15 mobile_box" id="link4"><a href="javascript:void(0);" class="tit"><i class="icon icon_mobile mr5"></i>手机版</a>
                    <div class="wechat"><img src="images/default/download.png" width="130" height="130"></div>
                </li>
            </ul>
        </div>
    </div>
</div>

