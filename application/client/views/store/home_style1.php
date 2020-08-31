<div class="warp">
			<div class="shop-intro mt20">
			<?php if ($item_info) { ?>
				<img src="<?php echo $item_info['store_banner']; ?>">
			<?php } ?>
			<?php if ($item_info) { ?>
				<div class="mask">
					<h2>店铺公告</h2> <?php echo $item_info['business_scope']; ?>
				</div>
			<?php } ?>
			</div>

			<div class="s225 fl">
				<div class="shop-info mt20">
					<div class="tit"><?php if ($item_info) {echo $item_info['store_name'];} ?></div>
					<dl><dt>店主：<?php if ($item_info) {echo $item_info['owner_name'];} ?></dt></dl>
					<dl><dt>工作时间</dt>
						<dd><?php if ($item_info) {echo $item_info['job_time'];} ?></dd>
					</dl>
					<dl><dt>所在地址</dt>
						<dd><?php if ($item_info) {echo $item_info['txt_address'].$item_info['address'];} ?></dd>
					</dl>
					<dl><dt>联系电话</dt>
						<dd><?php if ($item_info) {echo $item_info['mobile'];} ?>
						<?php if ($item_info && $item_info['phone']) { ?>
						<br><?php echo $item_info['phone']; ?>
						<?php } ?>
						</dd>
					</dl>
				</div>
			</div>
			<div class="s960 fr">
				<div class="shop-product mt20">
					<h2>产品展示<br><span>高品质的生活，高品位的享受</span></h2>

					<div class="activityBox">
						<span class="prev"></span>
						<div class="content">
							<div class="contentInner">
								<ul>
								<?php if ($attachment_list) { ?>
								<?php foreach ($attachment_list as $key=>$value) { ?>
									<li>
										<a href="javascript:void(0);"><img alt="<?php echo clearstring($value['alt']);  ?>" src="<?php echo $value['path']; ?>" /></a>
										<p>
											<a href="javascript:void(0);"><?php echo $value['alt']; ?></a>
										</p>
									</li>
								<?php }} ?>
								</ul>
							</div>
						</div>
						<span class="next"></span>
					</div>
				</div>
			</div>
		</div>
<script type="text/javascript">
	jQuery(".activityBox").slide({ mainCell:".contentInner ul", effect:"left",delayTime:400});
</script>