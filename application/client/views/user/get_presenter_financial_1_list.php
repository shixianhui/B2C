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
					<div class="member_title"><span class="bt">我的推广提成</span></div>
					<div class="btn_wrap mt20 clearfix">
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
						<div class="search_box fr" style="width:675px">
							<input name="keycode" type="text" class="fl" placeholder="请输入用户名" />
							<a onclick="javascript:$('#search_btn').submit();" href="javascript:void(0);" class="fl search_btn"></a>
						</div>
				</form>
					</div>
					<div class="table_box mt20" style="width:100%;margin-top:20px;">
						<table>
							<thead>
								<tr>
									<th width="15%">生产时间</th>
									<th width="15%">昵称</th>
									<th width="15%">会员类型</th>
									<th width="15%">生产积分</th>
									<th>描述</th>
								</tr>
							</thead>
							<tbody>
			<?php
                if ($itemList) {
                    foreach ($itemList as $item) { ?>
								<tr>
									<td><?php echo date('Y-m-d', $item['add_time']); ?></td>
									<td><?php echo createMobileBit($item['username']); ?></td>
									<td><?php echo $item['user_type']?'商家':'会员'; ?></td>
									<td><?php echo $item['score']; ?></td>
									<td><?php echo $item['cause']; ?></td>
								</tr>
			<?php }} ?>
							</tbody>
						</table>
					</div>
					<div class="page">
						<ul class="fr">
							<?php echo $pagination;?>
						</ul>
					</div>
				</div>
			</div>
</div>