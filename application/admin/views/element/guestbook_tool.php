<div id="position" >
<strong>当前位置：</strong>
<a href="<?php echo $_SERVER['REQUEST_URI']; ?>#x">内容管理</a>
<?php $patternInfo = $this->advdbclass->getControllerName('guestbook'); ?>
<a href="<?php echo $_SERVER['REQUEST_URI']; ?>#x"><?php echo $patternInfo['title']; ?></a>
</div>
<br />
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>快捷方式</caption>
  <tbody>
  <tr>
    <td>
    <a href="javascript:void(0);"><span id="guestbook_save">回复留言</span></a> |
    <a href="admincp.php/guestbook"><span id="guestbook_">客户留言列表</span></a>
    </td>
  </tr>
</tbody>
</table>