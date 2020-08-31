<div class="warp">
     <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">我的积分</span></div>
            <div class="member_surplus clearfix">
						<div>
							<div>
								<img src="images/default/xiang-img1.png"/>
							</div>
							<span><?php if ($user_info) {echo $user_info['score_gold'];} ?></span>
							<p>金象积分</p>
						</div>
						<div>
							<div>
								<img src="images/default/xiang-img2.png"/>
							</div>
							<span><?php if ($user_info) {echo $user_info['score_silver'];} ?></span>
							<p>银象积分</p>
						</div>
					</div>
            <div class="member_tab mt20">
                <div class="hd">
                    <ul>
                        <li <?php if ($score_type == 'gold') {echo 'class="on"';} ?> onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_score_list/gold.html',$client_index);?>';">金象积分记录</li>
                        <Li <?php if ($score_type == 'silver') {echo 'class="on"';} ?> onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_score_list/silver.html',$client_index);?>';">银象积分记录</Li>
                    </ul>
                </div>
                <div class="bd">
                    <div class="clearfix mt10">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table">
                            <tbody>
                                <tr>
                                    <th width="15%" ><strong>日期</strong></th>
                                    <th width="12%" ><strong>积分</strong></th>
                                    <th width="12%" ><strong>积分余额</strong></th>
                                    <th width="15%" ><strong>分类</strong></th>
                                    <th ><strong>备注</strong></th>
                                </tr>
                                  <?php if ($item_list) { ?>
                                  <?php foreach ($item_list as $key=>$value) { ?>
                                <tr>
                                    <td align="center"><?php echo date('Y-m-d', $value['add_time']); ?></td>
                                    <td align="center">
                                    <?php if ($value['score'] < 0) { ?>
									<span class="goods-price" style="color:#00CC00;"><?php echo $value['score']; ?></span>
									<?php } else { ?>
									<span class="goods-price">+<?php echo $value['score']; ?></span>
									<?php } ?>
					                </td>
                                    <td align="center"><?php echo $value['balance']; ?></td>
                                    <td align="center"><?php echo $score_type_arr[$value['type']]; ?></td>
                                    <td align="center" ><?php echo $value['cause']; ?></td>
                                </tr>
                                     <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="pagination">
                <ul><?php echo $pagination; ?></ul>
            </div>
        </div>
    </div>
</div>