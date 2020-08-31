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
					<div class="member_title"><span class="bt"><?php echo $tab_title; ?></span></div>
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
							<input name="keycode" type="text" class="fl" placeholder="请输入用户昵称/手机号" />
							<a onclick="javascript:$('#search_btn').submit();" href="javascript:void(0);" class="fl search_btn"></a>
						</div>
				</form>
					</div>
					<div class="table_box" style="width:100%;margin-top:20px;">
						<table>
							<tr>
								<th>头像</th>
								<th>昵称</th>
								<th>会员类型</th>
								<th>团队人数</th>
								<th>生产积分</th>
								<th>加入时间</th>
							</tr>
			<?php
                if ($itemList) {
                    foreach ($itemList as $item) { ?>
							<tr>
								<td><img width="30px" height="30px" src="<?php if ($item['path']) { echo preg_replace('/\./', '_thumb.', $item['path']);}else{echo 'images/default/defluat.png';}?>"/></td>
								<td><?php if ($item['nickname']) { echo $item['nickname'];}else{echo createMobileBit($item['username']);} ?></td>
								<td><?php echo $item['user_type']?'商家':'会员'; ?></td>
								<td><?php echo $item['presenter_user_count']; ?></td>
								<td><?php echo $item['divide_score']; ?></td>
								<td><?php echo date('Y-m-d', $item['add_time']); ?></td>
							</tr>
			<?php }} ?>
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