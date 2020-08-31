<?php echo $tool; ?>
    <table class="table_form" cellpadding="0" cellspacing="1">
        <caption>基本信息</caption>
        <tbody>
             <tr>
                <th><strong>状态：</strong></th>
                <td>
                    <?php if($item_info['is_open']==0){
                        echo '关闭';
                    }else{
                        echo '开启';
                    }?>
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <font color="red">*</font> <strong>指定间隔时间段(秒)</strong> <br/>
                </th>
                <td>
                    <input type="text" name="start" value="<?php echo $item_info['start'];?>">——<input type="text" name="end" value="<?php echo $item_info['end'];?>"> 
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <pre style="color:red">
说明：本程序由大量机器人(批量注册的账户)自动
      抢购，每抢购成功时自动减库存，一旦开启
      后，所有限时抢购的商品已被全部抢购时，
      将自动关闭。请不要删除文件或更改程序，
      否则后果自负
                    </pre>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input class="button_style" name="dosubmit" value="保存配置并开启" type="button" id="launch">
                    &nbsp;&nbsp; <input class="button_style" name="reset" value="关闭" type="button" id="shutDown">
                </td>
            </tr>
        </tbody>
    </table>
<br/><br/>
<script>
    $("#launch").click(function(){
        $.ajax({
            url : base_url+'admincp.php/robot/xsqg_launch',
            type : 'post',
            dataType : 'json',
            data : {
                start : $("input[name=start]").val(),
                end : $("input[name=end]").val(),
                is_open : 1,
            },
            success : function(data){
                if(!data.success){
                    alert(data.message);
                } 
            }
        });
        alert("成功开起");
    });
    $("#shutDown").click(function(){
        $.ajax({
            url : base_url+'admincp.php/robot/xsqg_stop',
            type : 'post',
            dataType : 'json',
            data : {
                start : $("input[name=start]").val(),
                end : $("input[name=end]").val(),
                is_open : 0,
            },
            success : function(data){
                if(data.success){
                    alert(data.message);
                    location.reload();
                    return;
                }
                alert(data.message);
            }
        })
    })
</script>