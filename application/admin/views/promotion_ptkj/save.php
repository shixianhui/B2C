<?php echo $tool; ?>
<link href="css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<script src="js/admin/jquery.datetimepicker.js" type="text/javascript"></script>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
    <table class="table_form" cellpadding="0" cellspacing="1">
        <caption>积分兑换(此功能只开启积分兑换功能，哪些商品参与此活动，请到“产品管理”设置)</caption>
        <tbody>
            <tr>
                <th>
                    <strong>拼团砍价活动名称</strong>
                </th>
                <td>
                    <input type="text" name="name" size="100" value="<?php if($itemInfo){echo $itemInfo['name'];}?>">
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>设置拼团砍价商品</strong> <br/>
                </th>
                <td>
                    <table class="table_form" cellpadding="0" cellspacing="1" style="width:700px;margin-left:0px;">
                        <tr>
                            <th width="150px" class="align_c"><strong>产品图片</strong></th>
                            <th class="align_c"><strong>产品标题</strong></th>
                            <th width="90px" class="align_c"><strong>原价（元）</strong></th>
                            <th width="90px" class="align_c"><strong>底价（元）</strong></th>
                        </tr>
                        <tr>
                            <td class="align_c"><img src="<?php if($itemInfo){echo $productInfo['path'];}?>" style="max-width:140px;" id="productImg" onerror="this.src='images/default/no_pic.jpg'"></td>
                            <td class="align_c"><span id="productTitle"><?php if($itemInfo){echo $productInfo['title'];}?></span></td>
                            <td class="align_c" id="price"><?php if($itemInfo){echo $productInfo['sell_price'];}?></td>
                            <td class="align_c">
                                <input type="text" name="low_price" size="6" value="<?php if($itemInfo){echo $itemInfo['low_price'];}?>" valid="required|isMoney" errmsg="最低价不能空|价格格式有误"><br>
                            </td>
                        </tr>
                        <td colspan="4">
                            <button class="button_style" type="button" onclick="javascript:window.open('<?php echo base_url(); ?>admincp.php/product/selector/1', 'add', 'top=100, left=200, width=900, height=400, scrollbars=1, resizable=yes');"><span>请选择活动商品</span></button>
                            <label style="color:red;">注： 请选择拼团砍价活动商品，每次仅能设置一种商品,底价不要高于原价</label>
                            <input type="hidden" name="product_id" value="<?php if($itemInfo){echo $itemInfo['product_id'];}?>" id="productId" onchange="selectProduct()" valid="required" errmsg="请选择商品">
                        </td>
                    </table>
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>拼团规则</strong> <br/>
                </th>
                <td>
                    <table class="table_form" cellpadding="0" cellspacing="1" style="width:400px;margin-left:0px;">
                        <tr>
                            <th class="align_c"><strong>区间</strong></th>
                            <th width="80px" class="align_c"><strong>价格(元)</strong></th>
                            <th width="60px" class="align_c"><strong>操作</strong></th>
                        </tr>
                        <?php
                           if($itemInfo){
                               foreach($pintuan_arr as $ls){
                        ?>
                        <tr>
                            <td>
                                <input type="text" name="low[]" valid="isInt" errmsg="人数为正整数" size="5" value="<?php echo $ls['low'];?>"> 人 ～ <input type="text" name="high[]" valid="isInt" errmsg="人数为正整数" value="<?php echo $ls['high'];?>" size="5"> 人
                            </td>
                            <td class="align_c">
                                <input type="text" name="money[]" value="<?php echo $ls['money'];?>"  valid="isMoney" errmsg="金钱格式不正确" size="8">
                            </td>
                            <td class="align_c">
                                <a href="javascript:;" onclick="$(this).parent().parent().remove();">删除</a>
                            </td>
                        </tr>
                           <?php }}?>
                        <tr  id="firstRow">
                            <td colspan="3"><button type="button" class="button_style" id="addPtrule" style="margin-top:10px;"><span>添加</span></button></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th><strong>砍价规则</strong> <br/></th>
                <td>
                    <table class="" cellpadding="0" cellspacing="1">
                        <tr>
                            <th>砍价总额</th>
                            <td><input type="text" size="10" name="cut_total_money" value="<?php if($itemInfo){echo $itemInfo['cut_total_money'];}?>" valid="required|isMoney" errmsg="砍价总额|砍价总额格式有误"> 元</td>
                        </tr>
                        <tr>
                            <th>砍价次数</th>
                            <td><input type="text" size="10"  name="cut_times" value="<?php if($itemInfo){echo $itemInfo['cut_times'];}?>" valid="required|isInt" errmsg="砍价次数不能空|砍价次数为正整数"> 次</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>活动时间</strong> <br/>
                </th>
                <td>
                    <input name="start_time" value="<?php if($itemInfo){echo date('Y-m-d H:i:s',$itemInfo['start_time']);}?>" id="start_time" size="30"  class="input_blur" type="text" valid="required" errmsg="拼团活动开始时间不能为空">
                    <script language="javascript" type="text/javascript">
                        $('#start_time').datetimepicker({
                            datepicker: true,
                            format: 'Y-m-d H:i',
                            step: 10
                        });
                    </script>
                    至
                    <input name="end_time" id="end_time" size="30" value="<?php if($itemInfo){echo date('Y-m-d H:i:s',$itemInfo['end_time']);}?>" class="input_blur" type="text" valid="required" errmsg="拼团活动结束时间不能为空">
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
                    <strong>是否开启拼团砍价活动</strong> <br>
                </th>
                <td>
                    <input type="radio" value="0" name="is_open" class="radio_style" <?php if($itemInfo){ echo $itemInfo['is_open']==0 ? 'checked' : '';}else{ echo "checked";} ?>> 关闭
                    <input type="radio" value="1" name="is_open" class="radio_style" <?php if($itemInfo){ echo $itemInfo['is_open']==1 ? 'checked' : '';} ?>> 开启
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
        if(!$("input[name=name]").val()){
            $("input[name=name]").val($("#productTitle").html());
        }
    }
    $("#addPtrule").click(function () {
        var html = '<tr><td>\
                      <input type="text" name="low[]" valid="isInt" errmsg="人数为正整数" size="5"> 人 ～ <input type="text" valid="isInt" errmsg="人数为正整数" name="high[]" size="5"> 人\
                  </td>\
                  <td>\
                      <input type="text" name="money[]" size="10" valid="isMoney" errmsg="金钱格式不正确">\
                  </td> <td>\
                       <a href="javascript:;" onclick="$(this).parent().parent().remove();">删除</a>\
                  </td></tr>';
        $("#firstRow").before(html);
    });
    $("#jsonForm").submit(function(e){
         if(!confirm('您确定您已检查配置的参团规则？，保存后，将不可修改')){
             e.preventDefault();
         };    
    })
</script>
</script>