
<style type="text/css">
	.m_comment .list{float:left;border-bottom:1px solid #f5f5f5;margin-bottom:20px;height:auto;}
	.m_comment .info{width:300px;background-size:100% 100%;margin-top:25px;height:82px;margin-right:10px;}
	.m_comment .info a span{display:block;overflow:hidden;text-overflow:ellipsis;white-space: normal !important;word-wrap: break-word;-webkit-line-clamp: 2;display:block;width:205px;height:2em;margin:0;}
	.file_input{width:50px;height:50px;background-size:100% 100%;}
	.m_comment .from ul li .up_img{margin-right:20px}
	.m_comment .from ul li .up_img img{width:50px;height:50px;}
	.m_comment .from ul li:first-of-type{float:left;}
	.m_comment .from ul li:nth-of-type(2){float:left;clear:none;}
	.m_comment .from ul li .input_m{height:50px;}
	.m_comment .from ul li span{width:80px;}
	.parentCls{float:left;}
	.start p{top:8px;overflow:hidden;height:60px;}
	.start{width:160px;}
	.m_comment .from{width:580px;}
	.btn_r{margin:0 auto;display:block;clear:both;}
</style>
<div class="warp">
         <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">评价商品</span></div>
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="jsonForm" name="jsonForm" method="post">
	        <div class="m_comment mt20">
	        	<input type="hidden" id="order_id" name="order_id" value="<?php if ($order_info) {echo $order_info['id'];} ?>" />
            	<?php if ($order_detail_list) { ?>
            	<?php foreach($order_detail_list as $key=>$value) { ?>
            	<div class="list">
	                <div class="info fl">
	                	<input type="hidden" name="product_id[]" value="<?php echo $value['product_id']; ?>" />
	                    <a href="javascript:void(0)"><img src="<?php if ($value['path']) {echo preg_replace('/\./', '_thumb.', $value['path']);}else{echo 'images/default/load.jpg';} ?>" class="picture"><?php echo $value['product_title']; ?><p><?php if ($value['color_size_open']) {echo $value['color_name'].'&nbsp;&nbsp;'.$value['size_name'];} ?></p></a>
	                </div>
	                <div class="from fr">
	                    <ul>
	                        <Li class="clearfix" style="overflow:hidden;width:100%;padding-bottom:10px;"><span>满意度：</span>  <div class="start">
	                                <dl>
	                                	<input type="hidden" name="grade[]" valid="required" errmsg="请评分" />
	                                    <dd><a href="javascript:void(0);">1</a></dd>
	                                    <dd><a href="javascript:void(0);">2</a></dd>
	                                    <dd><a href="javascript:void(0);">3</a></dd>
	                                    <dd><a href="javascript:void(0);">4</a></dd>
	                                    <dd><a href="javascript:void(0);">5</a></dd>
	                                </dl>
	                            </div>
	                        </Li>
	                       <li class="clearfix" style="width:100%;padding-bottom:10px;"><span>晒图片：</span>
	                       <a href="javascript:void(0);" class="file_input"><input type="file" accept="image/*;capture=camera" multiple="multiple" name="path_file[]"></a>
	                       <input type="hidden" name="batch_path_ids[]" />
	                       </li>
	                        <Li style="width:100%;">
	                            <span>评论内容：</span>
	                            <textarea name="content[]" cols="" rows="" valid="required" errmsg="评价内容不能为空" class="input_m"></textarea>
	                        </Li>
	                    </ul>
	                </div>
            </div>
            <?php }} ?>
            <div class="list" style="text-align: center;width:100%;border-bottom:none;">
            	<input type="submit" value="评价" class="btn_r" style="border:none;">
            </div>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript" language="javascript" src="js/default/score.js"></script>
<script>
    $(function () {
        var score = new Score({
            callback: function (cfg) {
                $('input[name="grade[]"]').val(cfg.starAmount);
            }
        });
        //形象照片
        var ele = null;
		$("input[name='path_file[]']").wrap("<form class='path_upload' action='<?php echo base_url(); ?>index.php/upload/uploadImage3' method='post' enctype='multipart/form-data'></form>");
	    $("input[name='path_file[]']").change(function(){ //选择文件
	    	ele = this;
	    	var limit = 5;
	    	var cur_ids = $(ele).parent().parent().parent().find('input[name="batch_path_ids[]"]').val();
	    	if (cur_ids) {
	    		var cur_ids_arr = cur_ids.split("_");
	    		limit = 5 - cur_ids_arr.length+1;
	    	}
	    	if (parseInt(limit) <= 0) {
	    		return my_alert('fail', 0, '最多只能上传5张图片');
	    	}
		$(".path_upload").ajaxSubmit({
				dataType:  'json',
				data: {
	                'model': 'exchange',
	                'field': 'path_file',
	                'limit': limit
	            },
				beforeSend: function() {
	    		},
	    		uploadProgress: function(event, position, total, percentComplete) {
	    		},
				success: function(res) {
	    			if (res.success) {
	    				var ids = '';
	    				var html = '';
	    				for(var i = 0; i < res.data.length; i++) {
	        				ids += ""+res.data[i].id+"_";
	        				html += '<a href="javascript:void(0);" class="up_img"><img src="'+res.data[i].file_path.replace('.', '_thumb.')+'"><em onclick="javascript:close_item(this,'+res.data[i].id+');" class="close radius1">×</em></a>';
	        		    }
	        			$(ele).parent().parent().before(html);
	        			$(ele).parent().parent().parent().find('input[name="batch_path_ids[]"]').val($(ele).parent().parent().parent().find('input[name="batch_path_ids[]"]').val()+ids);
		        	} else {
		        		return my_alert('fail', 0, res.message);
		            }
				},
				error:function(xhr){
				}
			});
		});
    });
    
    function close_item(obj, item_id) {
    	$(obj).parent().stop(true,true).fadeOut('300');
    	$("#bg").stop(true,true).fadeOut('300');
    	
    	var tmp_ids = $(obj).parent().parent().find('input[name="batch_path_ids[]"]').val();
    	var reg = new RegExp(item_id+"_" , "g");
    	tmp_ids = tmp_ids.replace(reg, '');
    	$(obj).parent().parent().find('input[name="batch_path_ids[]"]').val(tmp_ids);
    }
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
