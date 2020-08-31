<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
    <caption>信息管理</caption>
    <tbody>
        <tr class="mouseover">
            <th width="70">选中</th>
            <th width="100">发送人</th>
            <th>内容</th>
            <th width="200">提醒时间</th>
            <th width="100">管理操作</th>
        </tr>
        <?php
        foreach ($item_list as $item) {
            ?>
            <tr id="id_<?php echo $item['id'] ?>"  onMouseOver="this.style.backgroundColor = '#ECF7FE'" onMouseOut="this.style.background = ''">
                <td><input  class="checkbox_style" name="ids" value="<?php echo $item['id'];?>" type="checkbox"> </td>
                <td class="align_c">用户ID:<?php echo $item['from_user_id'];?></td>
                <td class="align_c"><?php echo $item['content'];?></td>
                <td class="align_c">
                          <?php echo date('Y-m-d H:i:s',$item['add_time']);?>
                </td>
                <td class="align_c">
                  <?php echo $item['is_read']==0 ? '<font color="red">未读</font>' : '<font color="green">已读</font>';?> 
                    <?php
                     if($item['is_read']==0){
                    ?>
                    <a href="admincp.php/user_message/index/0/<?php echo $item['id']; ?>">设为已读</a>
                     <?php }?>
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