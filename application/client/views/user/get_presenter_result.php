<div class="warp">
<?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
<link href="css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<script src="js/admin/jquery.datetimepicker.js" type="text/javascript"></script>
<style>
.input_txt {
    border: 1px solid #e8e8e8;
    border-radius: 2px;
    color: #666;
    font-size: 14px;
    height: 28px;
    padding: 0 10px;
    width: 90px;
}
</style>
    <div class="member_right">
				<div class="box_shadow clearfix mt20 m_border">
					<div class="time clearfix">
            <form id="search_btn" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<input value="<?php if ($start_time) { echo $start_time;} ?>" style="width: 90px;" readonly="readonly" id="start_time" name="start_time" placeholder="开始时间" class="input_txt" type="text">
               <script language="javascript" type="text/javascript">
                        $('#start_time').datetimepicker({
                            datepicker: true,
                            timepicker:false,
                            format: 'Y-m-d'
                        });
                    </script>
              至
              <input value="<?php if ($end_time) { echo $end_time;} ?>" style="width: 90px;" readonly="readonly" id="end_time" name="end_time" placeholder="结束时间"  class="input_txt" type="text">
              <script language="javascript" type="text/javascript">
                        $('#end_time').datetimepicker({
                            datepicker: true,
                            timepicker:false,
                            format: 'Y-m-d'
                        });
                    </script>
						<input value="搜索" class="btn_r" style="border:none; margin-left: 30px;width:100px;" type="submit">
				</form>
					</div>
					<div class="more_info">
						<h3>概况</h3>
						<table width="100%">
							<tbody><tr>
								<td class="info1">
									<a href="javascript:void(0);"><img src="images/default/infoimg1.png"></a>
									<span>商品销量</span>
								</td>
								<?php if ($userInfo) { ?>
								<td class="info2">
									<p><?php echo $yxd_count; ?></p><br>
									<span>已下单</span>
								</td>
								<td class="info3">
									<p><?php echo $yfk_count; ?></p><br>
									<span>已付款</span>
								</td>
								<td class="info4">
									<p><?php echo $ycj_count; ?></p><br>
									<span>已成交</span>
								</td>
								<?php } ?>
							</tr>
							<tr>
								<td class="info1 info1_img2">
									<a href="javascript:void(0);"><img src="images/default/infoimg3.png"></a>
									<span>交易金额</span>
								</td>
								<?php if ($userInfo) { ?>
								<td class="info2">
									<p><?php echo $fk_total; ?></p><br>
									<span>付款金额（￥）</span>
								</td>
								<td class="info3">
									<p><?php echo $cj_total; ?></p><br>
									<span>成交金额（￥）</span>
								</td>
								<td class="info4">
								</td>
								<?php } ?>
							</tr>
							<tr>
								<td class="info1 info1_img3">
									<a href="javascript:void(0);"><img src="images/default/infoimg2.png"></a>
									<span>用户</span>
								</td>
								<?php if ($userInfo) { ?>
								<td class="info2">
									<p><?php echo $user_count; ?></p><br>
									<span>用户数量</span>
								</td>
								<td class="info3">
									<p><?php echo $success_score_total; ?></p><br>
									<span>提成（积分）</span>
								</td>
								<td class="info4">
								&nbsp;
								</td>
								<?php } ?>
							</tr>
						</tbody></table>
					</div>
				</div>
			</div>