<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
    <caption>信息管理</caption>
    <tbody>
        <tr class="mouseover">
            <th width="70">楼层</th>
            <th width="200">楼层名称</th>
            <th width="150">楼层英文名称</th>
            <th width="150">楼层右侧文本</th>
            <th width="150">推送分类id</th>
            <th>跳转url</th>
            <th width="70">操作</th>
        </tr>
        <?php
        foreach ($item_list as $item) {
            ?>
            <tr id="id_<?php echo $item['id'] ?>"  onMouseOver="this.style.backgroundColor = '#ECF7FE'" onMouseOut="this.style.background = ''">
                <td class="align_c">第<?php echo $item['id'];?>楼</td>
                <td class="align_c"><?php echo $item['title'];?></td>
                <td class="align_c"><?php echo $item['en_title'];?></td>
                <td class="align_c"><?php echo $item['right_title'];?></td>
                <td class="align_c"><?php echo $item['category_id'];?></td>
                <td class="align_c"><?php echo $item['url'];?></td>
                <td class="align_c">
                   <a href="admincp.php/floor/save/<?php echo $item['id']; ?>">修改</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

