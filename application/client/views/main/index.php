<div class="fullSlide">
    <div class="bd">
        <ul>
             <?php
	$adList = $this->advdbclass->getAd(1, 10);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
            <li _src="url(<?php echo $ad['path']; ?>)" style="background:center 0 no-repeat;"><a   href="<?php echo $ad['url']; ?>"></a></li>
    <?php }} ?>
        </ul>
    </div>
    <div class="hd"><ul></ul></div>	
    <span class="prev"></span><span class="next"></span>	
</div>
<section class="warp" id="bd">
    <div class="topic_list"></div>
    <div class="surprised">
        <span class="tit titlebar" index="1"><img src="images/default/hd_tit.png"></span>
        <ul>
                         <?php
	$adList = $this->advdbclass->getAd(37, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
            <Li>
                <img src="<?php echo $ad['path'];?>">
                <div class="popup"><h3>拼团砍价</h3>突破最低价，每天<span class="purple"><strong>10</strong>点准时开抢<a href="<?php echo getBaseUrl(false,"","bargain.html", $client_index)?>" class="btn"   >进入专场</a>
                </div>
            </Li>
             <?php }} ?>
     <?php
	$adList = $this->advdbclass->getAd(38, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
            <Li>
                <img src="<?php echo $ad['path'];?>">
                <div class="popup"><h3>限时抢购</h3>下一个幸运者将会是<strong class="purple">谁</strong>呢？？<a    href="<?php echo getBaseUrl(false,"","purchase.html", $client_index);?>" class="btn">进入专场</a></div>
            </Li>
    <?php }} ?>
                 <?php
	$adList = $this->advdbclass->getAd(39, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
            <Li style="display:none;">
                <img src="<?php echo $ad['path'];?>">
                <div class="popup"><h3>竞猜达人</h3>突破最低价，每天<span class="purple"><strong>8</strong>点<strong>30</strong>分</span>准时开抢<a   href="javascript:alert('建设中...');" class="btn">进入专场</a> </div>
            </Li>
                <?php }} ?>
                         <?php
	$adList = $this->advdbclass->getAd(40, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
            <Li style="display:none;">
                <img src="<?php echo $ad['path'];?>">
                <div class="popup"><h3>幸运转盘</h3>下一个幸运者将会是<strong class="purple">谁</strong>呢？？<a   href="javascript:alert('建设中...');" class="btn">进入专场</a> </div>
            </Li>
                <?php }} ?>
        </ul>
    </div>
    <div class="floor clearfix">
        <div class="floor-tit titlebar" index="2">
            <div class="bt" onclick="location.href='<?php echo $floor_list[0]['url'];?>'" style="cursor:pointer;"><strong><?php echo $floor_list[0]['title'];?></strong><span><?php echo $floor_list[0]['en_title'];?></span></div>
            <a    href="<?php echo $floor_list[0]['url'];?>" class="more"><?php echo $floor_list[0]['right_title'];?><span class="icon"></span></a>
        </div>
        <div class="floor1-ad">
            <ul>
                         <?php
	$adList = $this->advdbclass->getAd(18, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad1"><a     href="<?php echo $ad['url']; ?>"><img src="<?php echo $ad['path']; ?>" class="lazy" ></a></li>
    <?php }} ?>
                                  <?php
	$adList = $this->advdbclass->getAd(20, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad2"><a    href="<?php echo $ad['url']; ?>"><img src="<?php echo $ad['path']; ?>" class="lazy" ></a></li>
    <?php }} ?>
                
                                             <?php
	$adList = $this->advdbclass->getAd(19, 2);
	if ($adList) {
	foreach ($adList as $key=>$ad) {
	?>
                <li class="itme_ad<?php echo $key+3;?>"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy" ></a></li>
    <?php }} ?>
            </ul>
        </div>
        <div class="floor_porduct">
            <ul>
                <?php 
	            $cus_list = $this->advdbclass->get_product_cus_list($floor_list[0]['category_id'],'c',5);
	            if ($cus_list) {
	            	foreach ($cus_list as $item) {
					$url = getBaseUrl(false, "", "product/detail/{$item['id']}.html", $client_index);
				?>
                <Li><div class="picture"><a   href="<?php echo $url;?>"><img class="lazy" data-original="<?php echo preg_replace('/\./','_thumb.',$item['path']);?>"></a></div>
                    <div class="property"><P class="nowrap"><a    href="<?php echo $url;?>"><?php echo $item['title'];?></a></P>
                        <p><span class="price"><small>￥</small><?php echo $item['sell_price'];?><s>￥<?php echo $item['market_price'];?></s></span><a href="<?php echo $url;?>" class="btn">立即抢购</a></p>
                    </div>
                </Li>
       <?php }} ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    <div class="floor clearfix mt25">
        <div class="floor-tit titlebar" index="3" >
            <div class="bt" onclick="location.href='<?php echo $floor_list[1]['url'];?>'" style="cursor:pointer;"><strong><?php echo $floor_list[1]['title'];?></strong><span><?php echo $floor_list[1]['en_title'];?></span></div>
            <a href="<?php echo $floor_list[1]['url'];?>" class="more"><?php echo $floor_list[1]['right_title'];?><span class="icon"></span></a>
        </div>
        <div class="floor2-ad">
            <ul>
                
                                       <?php
	$adList = $this->advdbclass->getAd(21, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad1"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
               
                                                    <?php
	$adList = $this->advdbclass->getAd(22, 2);
	if ($adList) {
	foreach ($adList as $key=>$ad) {
	?>
                <li class="itme_ad<?php echo $key+2;?>"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>"  class="lazy"></a></li>
    <?php }} ?>
               
               
                                                 <?php
	$adList = $this->advdbclass->getAd(23, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad4" style="top:0px;"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
            </ul>
        </div>
        <div class="floor_porduct ">
            <ul>
                     <?php 
	            $cus_list = $this->advdbclass->get_product_cus_list($floor_list[1]['category_id'],'c',5);
	            if ($cus_list) {
	            	foreach ($cus_list as $item) {
					$url = getBaseUrl(false, "", "product/detail/{$item['id']}.html", $client_index);
				?>
                <Li>
                    <div class="picture"><a href="<?php echo $url;?>"><img class="lazy" data-original="<?php echo preg_replace('/\./','_thumb.',$item['path']);?>"></a></div>
                    <div class="property"><P class="nowrap"><a href="<?php echo $url;?>"><?php echo $item['title'];?></a></P>
                        <p><span class="price"><small>￥</small><?php echo $item['sell_price'];?><s>￥<?php echo $item['market_price'];?></s></span><a href="<?php echo $url;?>" class="btn">立即抢购</a></p>
                    </div>
                </Li>
       <?php }} ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    <div class="floor clearfix mt25">
        <div class="floor-tit titlebar" index="4" >
            <div class="bt" onclick="location.href='<?php echo $floor_list[2]['url'];?>'" style="cursor:pointer;"><strong><?php echo $floor_list[2]['title'];?></strong><span><?php echo $floor_list[2]['en_title'];?></span></div>
            <a href="<?php echo $floor_list[2]['url'];?>" class="more"  ><?php echo $floor_list[2]['right_title'];?><span class="icon"></span></a>
        </div>
        <div class="floor3-ad">
            <ul>
                
    <?php
	$adList = $this->advdbclass->getAd(24, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad1"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>                     
                                                     <?php
	$adList = $this->advdbclass->getAd(25, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad2"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
                                                             <?php
	$adList = $this->advdbclass->getAd(36, 2);
	if ($adList) {
	foreach ($adList as $key=>$ad) {
	?>
                <li class="itme_ad<?php echo $key+3;?>"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
            </ul>
        </div>
        <div class="floor_porduct ">
            <ul>
                         <?php 
	            $cus_list = $this->advdbclass->get_product_cus_list($floor_list[2]['category_id'],'c',5);
	            if ($cus_list) {
	            	foreach ($cus_list as $item) {
					$url = getBaseUrl(false, "", "product/detail/{$item['id']}.html", $client_index);
				?>
                <Li><div class="picture"><a href="<?php echo $url;?>"  ><img class="lazy" data-original="<?php echo preg_replace('/\./','_thumb.',$item['path']);?>"></a></div>
                    <div class="property"><P class="nowrap"><a href="<?php echo $url;?>"  ><?php echo $item['title'];?></a></P>
                        <p><span class="price"><small>￥</small><?php echo $item['sell_price'];?><s>￥<?php echo $item['market_price'];?></s></span><a href="<?php echo $url;?>" class="btn">立即抢购</a></p>
                    </div>
                </Li>
       <?php }} ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    <div class="floor clearfix mt25">
        <div class="floor-tit titlebar" index="5" >
            <div class="bt" onclick="location.href='<?php echo $floor_list[3]['url'];?>'" style="cursor:pointer;"><strong><?php echo $floor_list[3]['title'];?></strong><span><?php echo $floor_list[3]['en_title'];?></span></div>
            <a href="<?php echo $floor_list[3]['url'];?>" class="more"  ><?php echo $floor_list[3]['right_title'];?><span class="icon"></span></a>
        </div>
        <div class="floor4-ad">
            <ul>
                                                 <?php
	$adList = $this->advdbclass->getAd(26, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad1"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
               
                                                    <?php
	$adList = $this->advdbclass->getAd(27, 2);
	if ($adList) {
	foreach ($adList as $key=>$ad) {
	?>
                <li class="itme_ad<?php echo $key+2;?>"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
               
               
                                                 <?php
	$adList = $this->advdbclass->getAd(28, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad4"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
            </ul>
        </div>
        <div class="floor_porduct ">
            <ul>
                        <?php 
	            $cus_list = $this->advdbclass->get_product_cus_list($floor_list[3]['category_id'],'c',5);
	            if ($cus_list) {
	            	foreach ($cus_list as $item) {
					$url = getBaseUrl(false, "", "product/detail/{$item['id']}.html", $client_index);
				?>
                <Li>
                    <div class="picture"><a href="<?php echo $url;?>"  ><img class="lazy" data-original="<?php echo preg_replace('/\./','_thumb.',$item['path']);?>"></a></div>
                    <div class="property"><P class="nowrap"><a href="<?php echo $url;?>"  ><?php echo $item['title'];?></a></P>
                        <p><span class="price"><small>￥</small><?php echo $item['sell_price'];?><s>￥<?php echo $item['market_price'];?></s></span><a href="<?php echo $url;?>" class="btn">立即抢购</a></p>
                    </div>
                </Li>
       <?php }} ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    <div class="floor clearfix mt25">
        <div class="floor-tit titlebar" index="6" >
            <div class="bt" onclick="location.href='<?php echo $floor_list[4]['url'];?>'" style="cursor:pointer;"><strong><?php echo $floor_list[4]['title'];?></strong><span><?php echo $floor_list[4]['en_title'];?></span></div>
            <a href="<?php echo $floor_list[4]['url'];?>" class="more"  ><?php echo $floor_list[4]['right_title'];?><span class="icon"></span></a>
        </div>
        <div class="floor5-ad">
            <ul>            
        <?php
	$adList = $this->advdbclass->getAd(29, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad1"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
                                                     <?php
	$adList = $this->advdbclass->getAd(30, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad2"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
                                                             <?php
	$adList = $this->advdbclass->getAd(31, 2);
	if ($adList) {
	foreach ($adList as $key=>$ad) {
	?>
                <li class="itme_ad<?php echo $key+3;?>"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
            </ul>
        </div>
        <div class="floor_porduct ">
            <ul>
                        <?php 
	            $cus_list = $this->advdbclass->get_product_cus_list($floor_list[4]['category_id'],'c',5);
	            if ($cus_list) {
	            	foreach ($cus_list as $item) {
					$url = getBaseUrl(false, "", "product/detail/{$item['id']}.html", $client_index);
				?>
                <Li><div class="picture"><a href="<?php echo $url;?>"  ><img class="lazy" data-original="<?php echo preg_replace('/\./','_thumb.',$item['path']);?>"></a></div>
                    <div class="property"><P class="nowrap"><a href="<?php echo $url;?>"  ><?php echo $item['title'];?></a></P>
                        <p><span class="price"><small>￥</small><?php echo $item['sell_price'];?><s>￥<?php echo $item['market_price'];?></s></span><a href="<?php echo $url;?>" class="btn">立即抢购</a></p>
                    </div>
                </Li>
       <?php }} ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    <!--七楼-->
    <div class="floor clearfix mt25">
        <div class="floor-tit titlebar" index="7" >
            <div class="bt" onclick="location.href='<?php echo $floor_list[5]['url'];?>'" style="cursor:pointer;"><strong><?php echo $floor_list[5]['title'];?></strong><span><?php echo $floor_list[5]['en_title'];?></span></div>
            <a href="<?php echo $floor_list[5]['url'];?>" class="more"><?php echo $floor_list[5]['right_title'];?><span class="icon"></span></a>
        </div>
        <div class="floor2-ad">
            <ul>
                
                                       <?php
	$adList = $this->advdbclass->getAd(59, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad1"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
               
                                                    <?php
	$adList = $this->advdbclass->getAd(60, 2);
	if ($adList) {
	foreach ($adList as $key=>$ad) {
	?>
                <li class="itme_ad<?php echo $key+2;?>"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>"  class="lazy"></a></li>
    <?php }} ?>
               
               
                                                 <?php
	$adList = $this->advdbclass->getAd(61, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad4" style="top:0px;"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
            </ul>
        </div>
        <div class="floor_porduct ">
            <ul>
                     <?php 
	            $cus_list = $this->advdbclass->get_product_cus_list($floor_list[5]['category_id'],'c',5);
	            if ($cus_list) {
	            	foreach ($cus_list as $item) {
					$url = getBaseUrl(false, "", "product/detail/{$item['id']}.html", $client_index);
				?>
                <Li>
                    <div class="picture"><a href="<?php echo $url;?>"><img class="lazy" data-original="<?php echo preg_replace('/\./','_thumb.',$item['path']);?>"></a></div>
                    <div class="property"><P class="nowrap"><a href="<?php echo $url;?>"><?php echo $item['title'];?></a></P>
                        <p><span class="price"><small>￥</small><?php echo $item['sell_price'];?><s>￥<?php echo $item['market_price'];?></s></span><a href="<?php echo $url;?>" class="btn">立即抢购</a></p>
                    </div>
                </Li>
       <?php }} ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    <!--八楼-->
    <div class="floor clearfix mt25">
        <div class="floor-tit titlebar" index="8" >
            <div class="bt" onclick="location.href='<?php echo $floor_list[6]['url'];?>'" style="cursor:pointer;"><strong><?php echo $floor_list[6]['title'];?></strong><span><?php echo $floor_list[6]['en_title'];?></span></div>
            <a href="<?php echo $floor_list[6]['url'];?>" class="more"  ><?php echo $floor_list[6]['right_title'];?><span class="icon"></span></a>
        </div>
        <div class="floor5-ad">
            <ul>            
        <?php
	$adList = $this->advdbclass->getAd(62, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad1"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
                                                     <?php
	$adList = $this->advdbclass->getAd(63, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
                <li class="itme_ad2"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
                                                             <?php
	$adList = $this->advdbclass->getAd(64, 2);
	if ($adList) {
	foreach ($adList as $key=>$ad) {
	?>
                <li class="itme_ad<?php echo $key+3;?>"><a href="<?php echo $ad['url']; ?>"  ><img src="<?php echo $ad['path']; ?>" class="lazy"></a></li>
    <?php }} ?>
            </ul>
        </div>
        <div class="floor_porduct ">
            <ul>
                        <?php 
	            $cus_list = $this->advdbclass->get_product_cus_list($floor_list[6]['category_id'],'c',5);
	            if ($cus_list) {
	            	foreach ($cus_list as $item) {
					$url = getBaseUrl(false, "", "product/detail/{$item['id']}.html", $client_index);
				?>
                <Li><div class="picture"><a href="<?php echo $url;?>"  ><img class="lazy" data-original="<?php echo preg_replace('/\./','_thumb.',$item['path']);?>"></a></div>
                    <div class="property"><P class="nowrap"><a href="<?php echo $url;?>"  ><?php echo $item['title'];?></a></P>
                        <p><span class="price"><small>￥</small><?php echo $item['sell_price'];?><s>￥<?php echo $item['market_price'];?></s></span><a href="<?php echo $url;?>" class="btn">立即抢购</a></p>
                    </div>
                </Li>
       <?php }} ?>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    <div class="recommended">
        <span class="tit"><img src="images/default/hd_tit1.png"></span>
        <ul>
                                                                <?php
	$adList = $this->advdbclass->getAd(32, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
            <li class="item_ad1"><a href="<?php echo $ad['url']; ?>"  ><img class="lazy" data-original="<?php echo $ad['path']; ?>"></a></li>
      <?php }} ?>
            
                                                                      <?php
	$adList = $this->advdbclass->getAd(33, 2);
	if ($adList) {
	foreach ($adList as $key=>$ad) {
	?>
            <li class="item_ad<?php echo $key+2;?>"><a href="<?php echo $ad['url']; ?>"  ><img class="lazy" data-original="<?php echo $ad['path']; ?>"></a></li>
      <?php }} ?>
            
                                                                      <?php
	$adList = $this->advdbclass->getAd(34, 1);
	if ($adList) {
	foreach ($adList as $key=>$ad) {
	?>
            <li class="item_ad4"><a href="<?php echo $ad['url']; ?>"  ><img class="lazy" data-original="<?php echo $ad['path']; ?>"></a></li>
      <?php }} ?>
            
                                                                         <?php
	$adList = $this->advdbclass->getAd(35, 1);
	if ($adList) {
	foreach ($adList as $key=>$ad) {
	?>
            <li class="item_ad5"><a href="<?php echo $ad['url']; ?>"  ><img class="lazy" data-original="<?php echo $ad['path']; ?>"></a></li>
      <?php }} ?>
        </ul>
    </div>
</section>


