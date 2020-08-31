<div class="blank"></div>
<div class="blank"></div>
<div class="w clearfix">  
<?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
  <div class="AreaU_R">
    <div class="clearfix usBox_y">
     <div class="bgwhite">
     <div class="product-body">
      <div class="col-sm-12">
        <div class="ticket-detail ng-scope" style="min-height: 625px;">
          <div class="console-title console-title-border m-b-15 clearfix">
            <h5 class="pull-left">投诉列表</h5>
            <a href="<?php echo getBaseUrl(false, "", "user/save_probleme.html", $client_index); ?>" style="float: right;" class="btn btn-primary comment_btn" >我要投诉</a>
            </div>
            <ul class="comment_detail fl">
        <?php if ($item_list) { ?>
		<?php foreach ($item_list as $key=>$value) { ?>
				<li class="item" id="li_item_<?php echo $value['id']; ?>">
					<div style="width:900px;" class="content">
					<p class="title">
					 <span>
					  <b style="color:#888!important">
					<?php echo date('Y-m-d H:i', $value['add_time']); ?>&nbsp;&nbsp;我问：<?php echo html($value['content']); ?>
					  </b>
					 </span>
					</p>
					<p style="padding-left:4px;" class="coment_content">
					<?php if ($value['rep_content']) { ?>					
					<span class="goods-price">
					<?php echo date('Y-m-d H:i', $value['rep_time']); ?>
					管理员回复：<?php echo html($value['rep_content']); ?>
					</span>
					<?php } ?>
                    </p>
					</div>
                    <a onclick="javascript:deleteProblem(<?php echo $value['id']; ?>);" href="javascript:void(0);" style="margin-left:10px; " class="btn btn-primary comment_btn" >删除</a>
                </li>
        <?php }} ?>
              </ul>
      </div>
      </div>
      </div>
      <div class="blank5"></div>
      <div class="pager_title">
	<div style="text-align:center">
	 <div id="pager" class="pagebar" >
	 <?php if ($pagination){echo $pagination;} ?>     
	</div>
	</div>
	</div>
     </div>            
    </div>
  </div>
</div>
<?php echo $this->load->view('element/service_bottom_tool', '', TRUE); ?>
<script type="text/javascript">
function deleteProblem(id) {
	$.post(base_url+"index.php/user/my_delete_problem", 
			{	
				"id": id
			},
			function(res){
				if(res.success){
					$("#li_item_"+res.data.id).remove();
					return false;
				}else{
					var d = dialog({
					    title: '提示',
					    fixed: true,
					    content: res.message
					});
					d.show();
					setTimeout(function () {
					    d.close().remove();
					}, 2000);
					return false;
				}
			},
			"json"
    );
}
</script>