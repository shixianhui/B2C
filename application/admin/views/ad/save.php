<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>广告位置</strong> <br/>
	  </th>
      <td>
      <input name="select_category_id" id="select_category_id" type="hidden" value="<?php if(! empty($adInfo)){ echo $adInfo['category_id'];} ?>" >
      <select class="input_blur" name="category_id" id="category" valid="required" errmsg="请选择广告位置!">
       <option value="" >请选择广告位置</option>
       <?php if (! empty($adgroupList)): ?>
       <?php foreach ($adgroupList as $adgroup): ?>
       <option value="<?php echo $adgroup['id'] ?>" ><?php echo $adgroup['group_name'] ?></option>
       <?php endforeach; ?>
       <?php endif; ?>
      </select>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>广告类型</strong> <br/>
	  </th>
      <td>
      <input type="radio" value="image" name="ad_type" class="radio_style" <?php if (! empty($adInfo)){if($adInfo['ad_type']=='image'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?>>图片广告
      <input type="radio" value="flash" name="ad_type" class="radio_style" <?php if (! empty($adInfo)){if($adInfo['ad_type']=='flash'){echo 'checked="checked"';}} ?>>Flash广告
	  <input type="radio" value="html" name="ad_type" class="radio_style" <?php if (! empty($adInfo)){if($adInfo['ad_type']=='html'){echo 'checked="checked"';}} ?>>Html广告
	  <input type="radio" value="text" name="ad_type" class="radio_style" <?php if (! empty($adInfo)){if($adInfo['ad_type']=='text'){echo 'checked="checked"';}} ?>>文字广告
	</td>
    </tr>
    <tr id="tr_image_path">
      <th width="20%">
      <strong>广告图片</strong> <br/>
	  </th>
      <td>
    <input name="model" id="model"  value="ad" type="hidden" />
    <input name="path" id="path" size="50" class="input_blur" value="<?php if(! empty($adInfo)){ echo $adInfo['path'];} ?>" type="text" />
    <input class="button_style" name="upload_image" id="upload_image" value="上传图片" style="width: 60px;"  type="button" />  <input class="button_style" value="浏览..."
style="cursor: pointer;" name="select_image" id="select_image" type="button" /> <input class="button_style" style="cursor: pointer;"  name="cut_image" id="cut_image" value="裁剪图片" type="button"  />
    </td>
    </tr>
    <tr id="tr_content" style="display:none;">
      <th width="20%"> <strong>广告内容</strong>
      </th>
      <td>
<?php echo $this->load->view('element/ckeditor_tool', NULL, TRUE); ?>
<script id="content" name="content" type="text/plain" style="width:800px;height:200px;"><?php if(! empty($adInfo)){ echo html($adInfo["content"]);}else{echo "";} ?></script>
<script type="text/javascript">
    var ue = UE.getEditor('content');
</script>
      </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>广告大小</strong> <br/>
	  </th>
      <td>
     宽：<input class="input_blur" name="width" id="width" value="<?php if(! empty($adInfo)){ echo $adInfo['width'];}else{echo '0';} ?>" size="10" valid="isNumber" errmsg="宽只能是数字!" type="text"> <font color="red">px</font>
    高：<input class="input_blur" name="height" id="height" value="<?php if(! empty($adInfo)){ echo $adInfo['height'];}else{echo '0';} ?>" size="10" valid="isNumber" errmsg="高只能是数字!" type="text"> <font color="red">px</font>
	</td>
    </tr>
    <tr>
      <th width="20%">
      <strong>广告状态</strong> <br/>
	  </th>
      <td>
     <input type="radio" value="1" name="display" class="radio_style" <?php if (! empty($adInfo)){if($adInfo['display']=='1'){echo 'checked="checked"';}}else{echo 'checked="checked"';} ?> >开启
	 <input type="radio" value="0" name="display" class="radio_style" <?php if (! empty($adInfo)){if($adInfo['display']=='0'){echo 'checked="checked"';}} ?> >关闭
	  </td>
    </tr>
    <tr>
      <th width="20%">
      <strong>广告词</strong> <br/>
	  </th>
      <td>
      <input name="ad_text" id="ad_text" size="50" class="input_blur" value="<?php if(! empty($adInfo)){ echo $adInfo['ad_text'];} ?>" type="text" />
    </td>
    </tr>
    <tr id="tr_image_path">
      <th width="20%">
      <strong>广告链接</strong> <br/>
	  </th>
      <td>
      <input name="url" id="url" size="70" class="input_blur" value="<?php if(! empty($adInfo)){ echo $adInfo['url'];} ?>" type="text" />
      <br>
      <font color="red">
      注:若是app链接请按要求填写<br>
      跳转到商品详情：product-detail.html?item_id=320&edittype=0  item_id表示商品id;<br>
      跳转到商品列表：product.html?category_id=40&category_type=1&headTitle=单西  每日上新和特价专区需再加一个attribute参数,attribute=b每日上新，attribute=p特价专区 category_id表示分类id，category_id=0表示所有产品，category_type=1表示品牌男装,category_type=2表示箱包配饰,category_type=3表示精品男鞋;headTitle表示商品列表头部标题;<br>
      跳转到拼团砍价活动列表 ： qmkj.html<br>
      跳转到限时秒杀活动列表 ： xsms.html<br>
      每日上新：product.html?category_id=0&category_type=0&attribute=b&headTitle=每日上新&order=sort&by=desc<br>
      特价专区：product.html?category_id=0&category_type=0&attribute=p&headTitle=特价专区<br>
      品牌男装：product.html?category_id=0&category_type=1&headTitle=品牌男装<br>
      箱包配饰：product.html?category_id=0&category_type=2&headTitle=箱包配饰<br>
      精品男鞋：product.html?category_id=0&category_type=3&headTitle=精品男鞋<br>
       唐束专区：product.html?category_id=0&category_type=0&attribute=j&headTitle=唐束专区<br>
  <br/>
  排序备注：产品列表[product.html]后面加上"&order=sort&by=desc"可以进行排序；by=desc从大到小排序；by=asc从小到大排序；order＝[id=产品ID,sort＝排序,stock=库存,sales=销售量,sell_price=销售价,market_price=市场价,hits=浏览量,hits=浏览量,favorite_num=收藏量]；参照“每日上新”的例子
      </font>
    </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody></table>
</div>
</form>