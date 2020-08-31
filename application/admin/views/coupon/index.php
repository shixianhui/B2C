<?php echo $tool; ?>
<table cellspacing="1" cellpadding="0" style="width:100%;">
  <tbody>
  <tr>
    <td>
    <div class="tag_menu" style="width: 99%; margin-top: 10px;">
<ul>
  <li><a href="admincp.php/admin/view/13/1/0" class="selected">免单优惠券</a></li>
  <li><a href="admincp.php/admin/view/13/1/6">半价优惠券</a></li>
 </ul>
</div>
    </td>
  </tr>
</tbody>
</table>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
<caption>信息管理</caption>
<tbody>
<tr class="mouseover">
<th width="100">选中</th>
<th>优惠券码</th>
<th width="50">状态</th>
<th width="70">管理操作</th>
</tr>
<?php
if ($item_list) {
        foreach ($item_list as $item) {
            ?>
            <tr id="id_<?php echo $item['id'] ?>"  onMouseOver="this.style.backgroundColor = '#ECF7FE'" onMouseOut="this.style.background = ''">
                <td><input  class="checkbox_style" name="ids" value="<?php echo $item['id'] ?>" type="checkbox"> </td>
                <td class="align_c"><?php echo $item['id'] ?></td>
                <td class="align_c"><?php echo $item['id'] ?></td>
                <td class="align_c"><?php echo $item['id'] ?></td>
                <td class="align_c">
                &nbsp;
                </td>
            </tr>
<?php }} ?>
</tbody>
</table>
<div class="button_box">
    <span style="width: 60px;">
        <a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
        <a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a>
    </span>
    <input id="delete" class="button_style" name="delete" value=" 删除 "  type="button">
</div>
<div id="pages" style="margin-top: 5px;">
    <?php echo $pagination; ?>
    <a>总条数：<?php echo $paginationCount;  ?></a>
    <a>总页数：<?php echo $pageCount;  ?></a>
</div>
<br/>
<br/>