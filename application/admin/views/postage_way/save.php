<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody> 	
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>配送方式名称</strong>
	  </th>
      <td>
      <input name="title" id="title_t" value="<?php if(! empty($item_info)){ echo $item_info['title'];} ?>" size="80" maxlength="100" valid="required" errmsg="配送方式名称不能为空!" class="input_blur" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>排序</strong> <br/>
	  </th>
      <td>
      <input name="sort" id="sort" value="<?php if(! empty($item_info)){ echo $item_info['sort'];}else{echo '0';} ?>" size="5" class="input_blur" type="text">
	</td>
    </tr>
     <tr>
      <th width="20%"><font color="red">*</font> <strong>配送方式介绍</strong> <br/>
	  </th>
      <td>
      <textarea name="content" id="content" rows="4" cols="80" valid="required" errmsg="配送方式介绍不能为空!"  class="textarea_style" ><?php if(! empty($item_info)){ echo $item_info['content'];} ?></textarea>
      </td>
    </tr>
    <tr>
      <th width="20%">      
      <strong>配送范围及价格</strong>
	  </th>
      <td>
      <table class="table_form" cellpadding="0" cellspacing="1">
      <?php if ($item_info && $item_info['postagepriceList']) { ?>
      <?php foreach ($item_info['postagepriceList'] as $postagePrice): ?>
      <?php if ($postagePrice['area'] == '其它地区') { ?>
      <tr>
      <td><input type="hidden" name="area_name[]" value="<?php echo $postagePrice['area'] ?>" size="10" />请设置默认快递费：<input type="text" name="start_price[]" value="<?php echo $postagePrice['start_price'] ?>" size="10" />元，     每超过一件需要增加快递费： <input type="text" name="add_price[]" size="10" value="<?php echo $postagePrice['add_price'] ?>" />元</td>
      </tr>
      <?php } else { ?>
      <tr id="id_<?php echo $postagePrice['id'] ?>">
       <td>至 <input type="text" name="area_name[]" size="40" value="<?php echo $postagePrice['area'] ?>" /> 的运费：<input type="text" name="start_price[]" value="<?php echo $postagePrice['start_price'] ?>" size="10" /> 元，    每多一件宝贝加收：<input type="text" name="add_price[]" value="<?php echo $postagePrice['add_price'] ?>" size="10" /> 元       <a href="javascript:deleteL('id_<?php echo $postagePrice['id'] ?>');"> 删除</a></td>
      </tr>
      <?php } ?>
      <?php endforeach; ?>
      <?php } else { ?>
      <tr>
      <td><input type="hidden" name="area_name[]" value="其它地区" size="10" />请设置默认快递费：<input type="text" name="start_price[]" size="10" />元，     每超过一件需要增加快递费： <input type="text" name="add_price[]" size="10" value="0.0" />元</td>
      </tr>
      <?php } ?>
      <tr class="postage_add" id="1">
          <td><a href="javascript:void(0);" class="postage_table" ><img src="images/admin/add.gif"> 为指定地区设置快递费 <font color="red">注：最好不要手动填地区</font></a>
       
       <div id="area_id" style="width:464px; height:260px; border:2px solid #9EBEEC;display:none;" >
       <table cellpadding="0" cellspacing="0">
       <tr>
       <?php if($areaList): ?>
       <?php foreach ($areaList as $key=>$value): ?>
       <?php if (($key+1)%5 == 0) { ?>
       <td width="100px"><label><input  name="area" value="<?php echo $value['name']; ?>" type="checkbox" /> <?php echo $value['name']; ?></label></td>
       </tr>
       <tr>
       <?php } else { ?>
        <td  width="100px"><label><input  name="area" value="<?php echo $value['name']; ?>" type="checkbox" /> <?php echo $value['name']; ?></label></td>
       <?php } ?>      
       <?php endforeach; ?>
       <?php endif; ?>
        </tr>
       </table>
       <input type="button" name="div_submit" value="确定" class="submit_div button_style"  /> <input class="reset_div button_style" type="button" name="div_reset" value="取消" />
	   </div>	   
       </td>
      </tr>
      </table>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>
<br/><br/>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$('.postage_table').click(function(){
		$('#area_id').show();
	});
    $('.reset_div').click(function(){
    	$(this).parents('div').hide();
    });
    var index = 0;
    $('.submit_div').click(function(){
        var area = '';
    	$("input[name='area']:checked").each(function(i,n){
    		area += $(this).val() + ",";
    	});
    	if (! area) {
			alert('请选择配送地区!');
			return false;
        }
        //添加配送区
    	$(this).parents('.postage_add').before(" <tr id='id_"+index+"'>"+
                       "<td>至 <input type=\"text\" name=\"area_name[]\" size=\"40\" value='"+area.substr(0, area.length - 1)+"' /> 的运费：<input type=\"text\" name=\"start_price[]\" size=\"10\" /> 元，    每多一件宝贝加收：<input type=\"text\" name=\"add_price[]\" value='0.0' size=\"10\" /> 元       <a href=\"javascript:deleteL('id_"+index+"');\"> 删除</a></td>"+
                       "</tr>");
    	index = index + 1;
        //重置选定项
    	$("input[name='area']").each(function(i,n){
    		$("input[name='area']").get(i).checked = false;    		
    	});
    	//隐藏div
    	$(this).parents('div').hide();
    	return false;
    });
});
//删除行
function deleteL(trId)
{
	var tr = document.getElementById(trId);
	tr.parentNode.removeChild(tr);
}
</script>

