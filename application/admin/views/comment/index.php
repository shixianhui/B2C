<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
    <caption>信息管理</caption>
    <tbody>
        <tr class="mouseover">
            <th width="70">选中</th>
            <th width="200">商品名称</th>
            <th width="50">分数</th>
            <th>评论内容</th>
            <th width="200">评论人</th>
            <th width="70">管理操作</th>
        </tr>
        <?php
        foreach ($item_list as $item) {
            ?>
            <tr id="id_<?php echo $item['id'] ?>"  onMouseOver="this.style.backgroundColor = '#ECF7FE'" onMouseOut="this.style.background = ''">
                <td><input  class="checkbox_style" name="ids" value="<?php echo $item['id'];?>" type="checkbox"> </td>
                <td class="align_c"><?php echo $item['product_title'];?></td>
                <td class="align_c"><?php echo $item['grade'];?></td>
                <td class="align_c"><?php echo $item['content'];?></td>
                <td class="align_c">
                    用户名：<?php echo $item['username'];?><br>
                    用户id：<?php echo $item['user_id'];?><br>
                </td>
                <td class="align_c">
                   <a href="admincp.php/comment/save/<?php echo $item['id']; ?>">修改</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="button_box">
    <span style="width: 60px;">
        <a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
        <a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a>
    </span>
    <input class="button_style" name="delete" value=" 删除 "  type="button">
</div>
<div id="pages" style="margin-top: 5px;">
    <?php echo $pagination; ?>
    <a>总条数：<?php echo $paginationCount;  ?></a>
    <a>总页数：<?php echo $pageCount;  ?></a>
</div>
<br/>
<br/>
<script>
    $("input[name=delete]").click(function () {
        var con = confirm("你确定要删除数据吗？删除后将不可恢复！");
        if (con == true) {
            $ids = "";
            $("input[name='ids']:checked").each(function (i, n) {
                $ids += $(this).val() + ",";
            });
            if (!$ids) {
                alert("请选定值!");
                return false;
            }
            $.post(base_url + "admincp.php/" + controller + "/delete",
                    {"ids": $ids.substr(0, $ids.length - 1)
                    },
            function (res) {
                if (res.success) {
                    for (var i = 0, data = res.data.ids, len = data.length; i < len; i++) {
                        $("#id_" + data[i]).remove();
                    }
                    return false;
                } else {
                    alert(res.message);
                    return false;
                }
            },
                    "json"
                    );
        }
    });
</script>