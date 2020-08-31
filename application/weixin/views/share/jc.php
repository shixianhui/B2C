<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<base href="<?php echo base_url(); ?>" />
		<title>竟猜</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="js/weixin/mui/css/mui.min.css">
		<link rel="stylesheet" href="js/weixin/mui/css/base.css">
		<link rel="stylesheet" href="js/weixin/mui/css/iconfont.css">
		<script src="js/weixin/mui/js/jquery.js"></script>
	</head>
	<body >
		<div class="mui-bar mui-bar-tab bottom-bar">
			<ul class="float-bar">
				<li class="mui-left mui-col-xs-12">
					<a href="#property-pop" style="background:#f02c8c; display:block; color:#fff; width:100%; line-height:50px;">
						立即竞猜
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
							<img src="images/image1.png">
						</a>
					</div>
					<!-- 第一张 -->
					<div class="mui-slider-item">
						<a href="#">
							<img src="images/image1.png">
						</a>
					</div>
					<!-- 第二张 -->
					<div class="mui-slider-item">
						<a href="#">
							<img src="images/image1.png">
						</a>
					</div>

					<!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
					<div class="mui-slider-item mui-slider-item-duplicate">
						<a href="#">
							<img src="images/image1.png">
						</a>
					</div>
				</div>
				<div class="mui-slider-indicator">
					<div class="mui-indicator mui-active"></div>
					<div class="mui-indicator"></div>

				</div>
			</div>
			<div class="product-property mui-clearfix">
				<p class="mui-ellipsis-2">
					ONLY 2016女装早秋新品针织五分袖连衣裙两件套连衣裙女
				</p>
				<p class="price" style="margin-bottom:0px;">
					<b><small>¥</small>??</b><em>48</em><span class="tag">竞猜</span>
				</p>
				<P>
					剩余 334件
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
				<div class=" mui-content-padded">
					<p>
						品牌名称：ONLY
					</p>
					<p>
						商品名称：针织五分袖连衣裙两件套连衣裙女
					</p>
					<P>
						产地:深圳
					</P>
					<P>
						材质:面料：64.4%腈纶 21%聚酯纤维 14.6%锦纶 拼料：45.8%羊毛 42.8%棉 11.4%聚酯纤维
					</P>
				</div>
			</div>
			<div id="item2" class="mui-control-content ">
				2222
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
								<b><small>¥</small>??</b><em>48</em>
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
				<h4>价格:</h4>
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
				立即竞猜
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