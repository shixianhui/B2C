<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
    <table class="table_form" cellpadding="0" cellspacing="1">
        <caption>基本信息</caption>
        <tbody>
            <tr>
                <th width="20%">
                    <font color="red">*</font> <strong>选择文件</strong> <br/>
                </th>
                <td>
                    <input type="file" name="file"/>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <pre style="color:red">
注：上传txt文本（昵称）
一条记录完后必须换行
例子：
像风一样的人
紫伊梦
伍木壹一
乐乐他爸 
                    </pre>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input class="button_style" name="dosubmit" value="上传并批量注册" type="submit">
                    &nbsp;&nbsp; <input onclick="javascript:window.location.href = '<?php echo ''; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
                </td>
            </tr>
        </tbody>
    </table>
</form>
<br/><br/>