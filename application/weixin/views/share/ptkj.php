<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<base href="<?php echo base_url(); ?>" />
		<title>全民参团</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="js/weixin/mui/css/mui.min.css">
		<link rel="stylesheet" href="js/weixin/mui/css/base.css?v=1.0">
		<link rel="stylesheet" href="js/weixin/mui/css/iconfont.css">
		<script src="js/weixin/mui/js/jquery.js"></script>
	</head>
	<body >
		<div class="mui-bar mui-bar-tab bottom-bar">
			<ul class="float-bar">
				<li class="mui-left mui-col-xs-12">
					<a href="#property-pop" style="background:#f02c8c; display:block; color:#fff; width:100%; line-height:50px;">
						立即参团
					</a>
				</li>
			</ul>
		</div>
		<div class="mui-content no-bg">
			<div id="slider" class="mui-slider home-slider" >
				<a href="#share-pop" class="share iconfont"></a>				
				<div class="mui-slider-group mui-slider-loop">
					<!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
				<div class="mui-slider-item mui-slider-item-duplicate">
					<a href="#">
                                            <img src="<?php echo str_replace('.','_thumb.', $attachment_list[0]['path']);?>">
					</a>
				</div>
				<!-- 第一张 -->
                                <?php foreach($attachment_list as $key=>$ls){?>
				<div class="mui-slider-item">
					<a href="javascript:void(0)">
						<img src="<?php echo str_replace('.','_thumb.', $ls['path']);?>">
					</a>
				</div>
                                <?php }?>
				
				
				<!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
				<div class="mui-slider-item mui-slider-item-duplicate">
					<a href="#">
						<img src="<?php echo str_replace('.','_thumb.', $attachment_list[$key]['path']);?>">
					</a>
				</div>
				</div>
				<div class="mui-slider-indicator">
				                      <?php foreach($attachment_list as $key=>$ls){?>
                                                            <div class="mui-indicator <?php echo $key==0 ? 'mui-active' : '';?>"></div>
                                                        <?php }?>
				
				</div>
			</div>
			<div class="product-property mui-clearfix">
				<p class="mui-ellipsis-2">
					<?php if($item_info){ echo $item_info['title'];};?>
				</p>
				<p class="price" style="margin-bottom:0px;">
					<b><small>¥</small><?php if($item_info){ echo $item_info['sell_price'];};?></b><s>¥<?php if($item_info){ echo $item_info['market_price'];};?></s><span class="tag">拼团</span>
				</p>
				<P>
					剩余<?php if($item_info){ echo $item_info['stock'];};?>件
				</P>
				<a href="" class="collect-btn">
					<span class="iconfont icon-heart"></span>
				</a>
			</div>

			<ul class="mui-table-view mt8 product-view">
				<li class="mui-table-view-cell">
					<a class="mui-navigate-right" href="#property-pop">
						选择：尺码/颜色分类
					</a>
				</li>
			</ul>

			<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-primary product-bar mt8 mui-clearfix">
				<a class="mui-control-item mui-active" href="#item1">
					商品详情
				</a>
				<a class="mui-control-item" href="#item2">
					商品评价
				</a>
			</div>
			<div id="item1" class="mui-control-content mui-active product-info">
				<div class=" mui-content-padded" id="productDetail">
					 <?php if($item_info){ echo html($item_info['content']);};?>
				</div>
			</div>
			<div id="item2" class="mui-control-content ">
				<ul>
                         <?php foreach($comment_list as $key=>$ls){?> 
                  <Li class="mui-clearfix">
                  <div class="author">
                      <span class="name"><?php echo hideStar($ls['username']);?></span>
        <span class="star"><font class="iconfont icon-star active"></font><font class="iconfont icon-star active"></font><font class="iconfont icon-star"></font><font class="iconfont icon-star"></font><font class="iconfont icon-star"></font></span>
        <i class="time"><?php echo date('Y/m/d H:i',$ls['add_time']);?></i>
                  </div>
                  <div class="decs"><?php echo $ls['content'];?></div>
                  </Li>
                         <?php }?>

                 </ul>
			</div>

		</div>

		<div id="property-pop" class="mui-popover mui-popover-action mui-popover-bottom property-pop mui-clearfix">
			<a href="#property-pop" class="close">
				<span class="mui-icon mui-icon-closeempty"></span>
			</a>
			<ul class="mui-table-view horizontal-product" style="padding-top:10px;">
				<li class="mui-table-view-cell mui-media">
					<a href="product-detail.html">
						<img class="mui-media-object mui-pull-left" src="images/image1.png">
						<div class="mui-media-body">
							<p class="mui-ellipsis-2">
								新款简洁时尚蕾丝拼接小西装女新款简洁时尚蕾丝拼接小西装女
							</p>
							<p class="price">
								<b><small>¥</small>56.8</b><s>¥480.00</s>
							</p>
						</div>
					</a>
				</li>
			</ul>
			<ul class="mui-table-view property-select">
				<h4>尺码:</h4>
				<Li class="mui-col-xs-4">
					<a href="" class="current">
						S(155/64A)
					</a>
				</Li>
				<Li class="mui-col-xs-4">
					<a href="">
						S(155/64A)
					</a>
				</Li>
				<Li class="mui-col-xs-4">
					<a href="">
						S(155/64A)
					</a>
				</Li>
				<Li class="mui-col-xs-4">
					<a href="">
						S(155/64A)
					</a>
				</Li>
			</ul>
			<ul class="mui-table-view property-select">
				<h4>颜色:<span>已选择:"白色"</span></h4>
				<Li class="mui-col-xs-4">
					<a href="" class="current">
						蓝色
					</a>
				</Li>
				<Li class="mui-col-xs-4">
					<a href="">
						白色
					</a>
				</Li>

			</ul>
			<ul class="mui-table-view property-select" style="padding-bottom:20px;">
				<h4>数量:</h4>
				<div class="mui-numbox cart-numbox">
					<button class="mui-btn mui-btn-numbox-minus" type="button">
					-
					</button>
					<input class="mui-input-numbox" type="number">
					<button class="mui-btn mui-btn-numbox-plus" type="button">
					+
					</button>
				</div>

			</ul>
			<a href="" class="cart-btn">
				立即购买
			</a>

		</div>

	</body>
</html>
<script src="js/weixin/mui/js/mui.min.js"></script>

<script>(function($) {

		$('.mui-scroll-wrapper').scroll({
			indicators: true //是否显示滚动条
		});
		var scroll = mui('.mui-slider');
		scroll.slider({
					isScroll: true, //是否可滑动
					pageSize: 2, //导航条可显示几条数据 默认为4
					scrollIndex: 1 //最小为-1 最大不能大于pageSize-3});

})(mui);
</script>