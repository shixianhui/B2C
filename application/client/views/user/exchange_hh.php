<div class="warp">
   <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">申请退款/退货</span></div>
            <div class="member_tab mt20">
                   <form action="<?php echo getBaseUrl(false,'','user/save_exchange/'.$exchange_id.'?order_number='.$this->input->get('order_number'),$client_index)?>" id="jsonForm" name="jsonForm" method="post">
                            <ul class="m_form" >
                                <li class="clearfix">
                                    <span>申请服务：</span>
                                    换货
                                    <input type="hidden"  name="order_number" value="<?php echo $this->input->get('order_number',true);?>">
                                    <input type="hidden"  name="orders_detail_id" value="<?php echo $this->input->get('id',true);?>">
                                    <input type="hidden"  name="exchange_type" value="2">
                                </li>
                                <li class="clearfix">
                                    <span><font color="red">*</font>换货原因：</span>
                                     <select name="refund_cause" errmsg="请选择退货退款原因">
                                        <option value="" style="color:#e61d47;">请选择换货原因</option>
                                        <option value="商品质量问题">商品质量问题</option>
                                        <option value="不喜欢/不想要">不喜欢/不想要</option>
                                        <option value="收到商品描述不符">收到商品描述不符</option>
                                        <option value="尺码颜色问题">尺码颜色问题</option>
                                        <option value="其他">其他</option>
                                     </select>
                                </li>
                                 <li class="clearfix">
                                     <span><font color="red">*</font>说明(0/200字)：</span>
                                     <textarea cols="36" rows="3" id="content" name="content" valid="required" errmsg="详细原因描述不能为空"><?php echo $item_info ? $item_info['content'] : '';?></textarea>
                                </li>
                                 <li class="clearfix">
                                    <span>上传凭证图片：</span>
<!--                                    <img style="padding: 2px; border:1px solid #CCC;float:left;" id="path_src" width="104px" height="75px" src="images/default/no_pic.jpg">-->
                                    <a style="position:relative;" >
				    <span style="cursor:pointer;text-align:center;color:#fff;" class="but_4">上传凭证图片<input style="left:0px;top:0px; background:#000; width:105px;height:35px;line-height:30px; position:absolute;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;" type="file" accept=".gif,.jpg,.jpeg,.png" id="path_file" multiple="multiple" name="path_file[]" ></span>
				    <i class="load" id="path_load" style="cursor:pointer;display:none;width:130px;padding-left:0px;"><img src="images/default/loading_2.gif" width="32" height="32"></i>
				    </a>
                                    &nbsp;(最多5张)
<!--                                    <input type="hidden" id="path" name="path"  value="" valid="required" errmsg="凭证图片不能为空" >-->
                                </li>
                                <li id="imgBox">
                                    <span><font color="red" style="opacity: 0;">:</font></span>
                                    <input type="hidden" name="batch_path_ids" value="">
                                </li>
                                <li class="clearfix"><span>&nbsp;</span><input type="submit" value="提交审核" style="border:none;" class="btn_r"></li>  
                            </ul>
                    </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
</script>
<script language="javascript" type="text/javascript">
  $("#path_file").wrap("<form id='path_upload' action='<?php echo base_url(); ?>index.php/upload/uploadImage3' method='post' enctype='multipart/form-data'></form>");
    $("#path_file").change(function(){ //选择文件
        if($("#imgBox img").length > 4){
            alert('最多上传5张图片');
            return false;
        };
        
    $("#path_upload").ajaxSubmit({
    dataType:  'json',
            data: {
            'model': 'exchange',
             'field': 'path_file',
             'limit' : 5
            },
            beforeSend: function() {
            $("#path_load").show();
            },
            uploadProgress: function(event, position, total, percentComplete) {
            },
            success: function(res) {
            $("#path_load").hide();
            var batch_path_ids = $("input[name=batch_path_ids]").val();
              if(res.success){
                  $.each(res.data,function(index){
                      batch_path_ids += res.data[index].id + '_';
                      $("#imgBox").append('<img src="'+res.data[index].file_path.replace(/\./,'_thumb.')+'" style="margin-left:10px;">');
                  });
                  $("input[name=batch_path_ids]").val(batch_path_ids);
              }else{
                    var d = dialog({
                          width: 300,
                          title: '提示',
                          fixed: true,
                          content: res.message
                      });
                      d.show();
              }
            },
            error:function(xhr){}
    });
    });
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>


