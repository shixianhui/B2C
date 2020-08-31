<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>首页楼层设置</caption>
 	<tbody>
 	<tr>
        <th width="20%"><strong>楼层</strong> <br/>
            </th>
         <td>
              第<?php if ($itemInfo){ echo $itemInfo['id'];} ?>楼
          </td>
    </tr>
    	<tr>
      <th width="20%"><strong>楼层名称</strong> <br/>
	  </th>
      <td>
         <input name="title" id="title" size="30" value="<?php if ($itemInfo){ echo $itemInfo['title'];} ?>" valid="required" errmsg="楼层名称不能为空" class="input_blur" type="text">
     </td>
    </tr>
    <tr>
      <th width="20%"><strong>楼层英文名称</strong> <br/></th>
      <td>
        <input name="en_title" id="en_title" size="30" value="<?php if ($itemInfo){ echo $itemInfo['en_title'];} ?>" valid="required" errmsg="楼层英文名称不能为空" class="input_blur" type="text">
     </td>
    </tr>
    <tr>
      <th width="20%"><strong>楼层右侧文本</strong> <br/></th>
      <td>
        <input name="right_title" id="right_title" size="30" value="<?php if ($itemInfo){ echo $itemInfo['right_title'];} ?>" valid="required" errmsg="楼层右侧文本不能为空" class="input_blur" type="text">
     </td>
    </tr>
    <tr>
      <th width="20%"><strong>推送分类id</strong> <br/>
	  </th>
      <td>
            <div class="shop-cat-list">
		<!-- feilv 2012-03-02 店铺分类新加钩子J_ShopCatList -->
		<?php if (! empty($product_category_list)) {
                         $category_id_arr = explode(',',$itemInfo['category_id']);
                    ?>
		<ul class="J_ShopCatList">
			<!-- 一级 -->
			<?php foreach ($product_category_list as $menu) {
			    if ($menu['subMenuList']) {
				?>
			<li>
                <input type="checkbox" value="<?php echo $menu['id']; ?>" <?php echo in_array($menu['id'],$category_id_arr) ? 'checked="checked"' : '';?> name="category_id[]" class="checkbox select_product_class">
                <?php echo $menu['product_category_name']; ?>
				<ul class="category2">
				<!-- 二级 -->
		        <?php foreach ($menu['subMenuList'] as $subMenu) { ?>
		        <li>
		        	&nbsp;&nbsp;<input type="checkbox" value="<?php echo $subMenu['id']; ?>" <?php echo in_array($subMenu['id'],$category_id_arr) ? 'checked="checked"' : '';?> name="category_id[]" class="checkbox select_product_class">
		        	<label for="shopCatId285432655"><?php echo $subMenu['product_category_name']; ?></label>
		        </li>
		        <?php } ?>
				</ul>
			</li>
			<?php } else { ?>
			<li>
				<input <?php echo in_array($menu['id'],$category_id_arr) ? 'checked="checked"' : '';?> type="checkbox" value="<?php $menu['id']; ?>" name="category_id[]" class="checkbox select_product_class">
				<label for="shopCatId411110266"><?php echo $menu['product_category_name']; ?></label>
			</li>
			<?php }} ?>
			</ul>
			<?php } ?>
		</div>
    </td>
    </tr>
        <tr>
            <th width="20%"><strong>跳转链接</strong> <br/></th>
            <td>
              <input name="url" id="url" size="80" value="<?php if ($itemInfo){ echo $itemInfo['url'];} ?>" valid="required" errmsg="跳转链接不能为空" class="input_blur" type="text">
           </td>
        </tr>
 	<tr>
      <td>
      &nbsp;
      </td>
      <td>
        <input class="button_style" name="dosubmit" value="修改" type="submit">
        <input class="button_style" value="返回" type="button" onclick="location.href= 'admincp.php/floor'">
	</td>
	</tr>
</tbody>
</table>
</form>