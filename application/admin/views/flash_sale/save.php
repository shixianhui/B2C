<?php echo $tool; ?>
<link href="css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<script src="js/admin/jquery.datetimepicker.js" type="text/javascript"></script>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
   <table class="table_form" cellpadding="0" cellspacing="1">
        <caption>基本信息</caption>
        <tbody>
            <tr>
                <th>
                    <strong>限时抢购活动名称</strong>
                </th>
                <td>
                    <input type="text" name="name" size="100" value="<?php echo!empty($itemInfo) ? $itemInfo['name'] : ''; ?>">
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>限时抢购时间</strong> <br/>
                </th>
                <td>
                    <input name="start_time" id="start_time" size="30" value="<?php echo !empty($itemInfo) ? date('Y-m-d H:i', $itemInfo['start_time']) : ''; ?>" class="input_blur" type="text" valid="required" errmsg="拼团活动结束时间不能为空">
                    <script language="javascript" type="text/javascript">
                        $('#start_time').datetimepicker({
                            datepicker: true,
                            format: 'Y-m-d H:i',
                            step: 10
                        });
                    </script>
                    &nbsp;至&nbsp
                    <input name="end_time" id="end_time" size="30" value="<?php echo !empty($itemInfo) ? date('Y-m-d H:i', $itemInfo['end_time']) : ''; ?>" class="input_blur" type="text" valid="required" errmsg="拼团活动结束时间不能为空">
                    <script language="javascript" type="text/javascript">
                        $('#end_time').datetimepicker({
                            datepicker: true,
                            format: 'Y-m-d H:i',
                            step: 10
                        });
                    </script>
                </td>
            </tr>

            <tr>
                <th width="20%">
                    <strong>是否开启</strong> <br>
                </th>
                <td>
                    <input type="radio" value="0" name="is_open" <?php if ($itemInfo) { echo $itemInfo['is_open'] == 0 ? 'checked' : '';} else { echo 'checked';} ?> class="radio_style"> 关闭
                    <input type="radio" value="1" name="is_open" <?php if ($itemInfo) { echo $itemInfo['is_open'] == 1 ? 'checked' : '';} ?> class="radio_style"> 开启
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>设置限时抢购商品</strong> <br/>
                </th>
                <td>
                    <table class="table_form" cellpadding="0" cellspacing="1" style="width:700px;margin-left:0px;">
                        <tr>
                            <th width="150px" class="align_c"><strong>图片</strong></th>
                            <th class="align_c"><strong>产品标题</strong></th>
                            <th width="90px" class="align_c"><strong>出售价（元）</strong></th>
                            <th width="90px" class="align_c"><strong>抢购价（元）</strong></th>
                        </tr>
                        <tr>
                            <td class="align_c"><img src="<?php if($itemInfo){echo $productInfo['path'];}?>" style="max-width:140px;" id="productImg" onerror="this.src='images/default/no_pic.jpg'"></td>
                            <td class="align_c"><span id="productTitle"><?php if($itemInfo){echo $productInfo['title'];}?></span></td>
                            <td class="align_c" id="price"><?php if($itemInfo){echo $productInfo['sell_price'];}?></td>
                            <td class="align_c"><input type="text" name="flash_sale_price" size="6" value="<?php if($itemInfo){echo $itemInfo['flash_sale_price'];}?>" valid="required|isMoney" errmsg="最低价不能空|价格格式有误"></td>
                        </tr>
                        <td colspan="4">
                            <button type="button" onclick="javascript:window.open('<?php echo base_url(); ?>admincp.php/product/selector/1', 'add', 'top=100, left=200, width=900, height=400, scrollbars=1, resizable=yes');" class="button_style"><span>请选择活动商品</span></button>
                            <label><font color="red">注： 请选择限时抢购活动商品，每次仅能设置一种商品</font></label>
                            <input type="hidden" name="product_id" value="<?php if($itemInfo){echo $itemInfo['product_id'];}?>" id="productId" onchange="selectProduct()" valid="required" errmsg="请选择商品">
                        </td>
                    </table>
                </td>
            </tr>
<!--             <tr>
                <th width="20%">
                    <strong>限购数量</strong> <br>
                </th>
                <td>
                    <input type="text" name="limit" value="<?php //if ($itemInfo) { echo $itemInfo['limit'];} else { echo 1;} ?>" class="input_blur"> 件
                </td>
            </tr>-->
            <tr>
                <th width="20%">
                    <strong>活动介绍</strong> <br/>
                </th>
                <td>
                    <textarea cols="80" rows="4" name="description"><?php if($itemInfo){echo $itemInfo['description'];}?></textarea>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
                    &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
                </td>
            </tr>
        </tbody>
    </table>
</form>
<br/><br/>
<script>
    function selectProduct() {
        if (!$("input[name=name]").val()) {
            $("input[name=name]").val($("#productTitle").html());
        }
    }
</script>