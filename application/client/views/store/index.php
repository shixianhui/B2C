<link rel="stylesheet" type="text/css" href="css/default/shop.css"/>
<div class="warp">
			<div class="seat"><?php echo $location; ?></div>
			<div class="module_box">
				<div class="filter">
				<?php if ($store_category_id) { ?>
					<dl class="clearfix">
			            <dt>您已选择：</dt>
			            <dd class="list">
			            <?php if ($store_category_id) { ?>
				            <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false, "", "{$template}/index/{$parent_id}-0.html", $client_index); ?>';" class="selected" >店铺分类:<em><?php echo $store_category_name; ?></em><i >×</i></li>
				        <?php } ?>
			            </dd>
			        </dl>
			     <?php } ?>
					<dl>
						<dt>店铺分类：</dt>
						<dd class="list">
							<ul>
								<?php if ($store_category_list) { ?>
						        <?php foreach ($store_category_list as $key=>$item) { ?>
								<li>
									<a href="<?php echo getBaseUrl(false, "", "{$template}/index/{$parent_id}-{$item['id']}.html", $client_index); ?>"><?php echo $item['store_category_name']; ?></a>
								</li>
								<?php }} ?>
							</ul>
							<span class="all">更多<i class="icon_zhankai icon"></i></span>
						</dd>
					</dl>

				</div>
			</div>
			<div class="store">
				<div class="left_box">
<?php if ($item_list) { ?>
<?php foreach ($item_list as $item) {
	$url = getBaseUrl($html, "", "{$template}/home/{$item['id']}.html", $client_index);
?>
					<div class="special_item clearfix">
						<div class="picture"><img alt="<?php echo clearstring($item['store_name']); ?>" src="images/default/load.jpg"  class="lazy" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>"></div>
						<div class="information">
						<h4 class="nowrap"><?php echo $item['store_name']; ?></h4>
						<p class="txt"><?php echo $item['description']; ?></p>
						<div class="address"><i class="address_img"></i><?php echo str_replace(' ', '', $item['txt_address']).$item['address']; ?></div>
						<?php if ($item['mobile']) { ?>
						<div class="phone"><i class="phone_img"></i><?php echo $item['mobile']; ?></div>
						<?php } ?>
						<?php if ($item['job_time']) { ?>
						<div class="open"><i class="open_img"></i><?php echo str_replace(array('<br/>', '<br>'), array('&nbsp;', '&nbsp;'), $item['job_time']); ?></div>
						<?php } ?>
						<a href="<?php echo $url; ?>" class="btn t-f">进入店铺</a>
						</div>
					</div>
<?php }} ?>
				</div>
				<div class="right_box">
					<h4>热门商家推荐</h4>
					<ul>
					<?php
				$store_list = $this->advdbclass->get_cus_store_list('h', 10);
				if ($store_list) {
					foreach ($store_list as $item) {
							$url = getBaseUrl(false, "", "store/home/{$item['id']}.html", $client_index);
					?>
						<li>
							<img class="lazy" alt="<?php echo clearstring($item['store_name']); ?>" data-original="<?php echo preg_replace('/\./', '_thumb.', $item['path']); ?>" src="images/default/load.jpg"/>
							<h5><?php echo $item['store_name']; ?></h5>
							<p><a href="<?php echo $url; ?>">进入店铺</a><span><img src="images/default/address_img.png"/><?php echo filter_address($item['txt_address']); ?></span></p>
							<p class="clear"></p>
						</li>
			<?php }} ?>
					</ul>
				</div>
				<div class="clear"></div>
				<div class="pagination">
			        <ul><?php echo $pagination;?></ul>
			    </div>
			</div>
		</div>