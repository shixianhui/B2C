<?php echo $tool; ?>
<form name="search" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <table class="table_form" cellpadding="0" cellspacing="1">
        <caption>信息查询</caption>
        <tbody>
            <tr>
                <td class="align_c"></td>
            </tr>
        </tbody>
    </table>
</form>
<table class="table_list" id="news_list" cellpadding="0" cellspacing="1">
    <caption>信息管理</caption>
    <tbody>
        <tr class="mouseover">
            <th width="70">选中</th>
            <th>名称</th>
            <!--<th width="80">产品编号</th>-->
            <th width="200">活动时间</th>
            <th width="60">状态</th>
            <th width="70">管理操作</th>
        </tr>
         <?php
                foreach ($item_list as $item) {
            ?>
            <tr id="id_<?php echo $item['id'] ?>" onMouseOver="this.style.backgroundColor = '#ECF7FE'" onMouseOut="this.style.background = ''">
                <td><input  class="checkbox_style" name="ids" value="<?php echo $item['id'] ?>" type="checkbox"> </td>
                <td class="align_c"><?php echo $item['name']; ?></td>
                <td class="align_c" width="400">
                    <?php echo date('Y-m-d H:i:s', $item['start_time']) . '～' . date('Y-m-d H:i:s', $item['end_time']); ?>
                    <?php
                     if($item['start_time'] < time() &&  $item['end_time'] > time()){
                       echo  '<font color="red">进行中...</font>';
                     }
                     if( $item['end_time'] < time()){
                         echo  '<font color="red">已结束</font>';
                     }
                     if( $item['start_time'] > time()){
                         echo  '<font color="red">暂未开始</font>';
                     }
                    ?>
                </td>
                <td class="align_c">  <?php echo $item['is_open'] == 0 ? '关闭' : '开启'; ?></td>
                <td class="align_c"><a href="admincp.php/active/flash_sale_save/<?php echo $item['id']; ?>">修改</a></td>
            </tr>
          <?php } ?>
    </tbody>
</table>
<div class="button_box">
    <span style="width: 60px;">
        <a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', true)">全选</a>/
        <a href="javascript:void(0);" onclick="javascript:$('input[type=checkbox]').prop('checked', false)">取消</a>
    </span>
    <input class="button_style" name="list_order" id="list_order" value=" 排序 "  type="button">
    <input class="button_style" name="delete" value=" 删除 "  type="button">
    <select class="input_blur" name="select_display" id="select_display" onchange="#">
        <option value="">选择状态</option>
        <option value=""></option>
    </select>
    <select name="custom_attribute" id="custom_attribute" onchange="#">
        <option value="">选择属性</option>
        <option value="clear">去除属性</option>
        <option value="c">推荐[c]</option>
        <option value="a">特荐[a]</option>
    </select>
    <select name="pay_mode" id="select_pay_mode" onchange="#">
        <option value="">选择活动属性</option>
        <option value="0">不参与活动</option>
        <option value="1">参与限时抢购</option>
        <option value="2">参与积分兑换</option>
    </select>
</div>
<div id="pages" style="margin-top: 5px;">
    <?php //echo $pagination; ?>
    <a>总条数：<?php //echo $paginationCount;  ?></a>
    <a>总页数：<?php //echo $pageCount;  ?></a>
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
            $.post(base_url + "admincp.php/" + controller + "/delete_flash_sale",
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