<?php echo $tool; ?>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
    <caption>信息管理</caption>
    <tbody>
        <tr class="mouseover">
            <th width="70">选中</th>
            <th width="100">姓名</th>
            <th width="200">手机</th>
            <th>地址</th>
            <th>留言</th>
            <th>来源</th>
            <th width="100">申请时间</th>
        </tr>
        <?php
        foreach ($item_list as $item) {
            ?>
            <tr id="id_<?php echo $item['id'] ?>"  onMouseOver="this.style.backgroundColor = '#ECF7FE'" onMouseOut="this.style.background = ''">
                <td><input  class="checkbox_style" name="ids" value="<?php echo $item['id'];?>" type="checkbox"> </td>
                <td class="align_c"><?php echo $item['name'] ?></td>
                <td class="align_c"><?php echo $item['mobile'] ?></td>
                <td class="align_c">
                    <?php echo $item['address'];?>
                </td>
                 <td class="align_c">
                      <?php echo $item['content'];?>
                </td>
                 <td class="align_c">
                     <a href="<?php echo $item['source'];?>" target="_blank"><?php echo my_substr($item['source'],20) ?></a>
                </td>
                <td class="align_c">
                  <?php echo date('Y-m-d H:i:s',$item['add_time']); ?> 
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
    <select class="input_blur" name="select_display" id="select_display" onchange="#">
        <option value="">选择状态</option>
        <option value=""></option>
    </select>
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