<?php echo $tool; ?>
<link href="css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<script src="js/admin/jquery.datetimepicker.js" type="text/javascript"></script>
    <table class="table_form" cellpadding="0" cellspacing="1">
        <caption>积分兑换(此功能只开启积分兑换功能，哪些商品参与此活动，请到“产品管理”设置)</caption>
        <tbody>
            <tr>
                <th>
                    <strong>拼团砍价活动名称</strong>
                </th>
                <td>
                    <input type="text" name="name" size="60" value="<?php if($itemInfo){echo $itemInfo['name'];}?>">
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>设置拼团砍价商品</strong> <br/>
                </th>
                <td>
                    <table class="table_form" cellpadding="0" cellspacing="1" style="width:550px;margin-left:0px;">
                            <tr>
                            <th style="text-align: center;">图片</th>
                            <td style="text-align: center;">产品标题</th>
                            <th style="text-align: center;">原价格</th>
                            <th style="text-align: center;width:100px;">拼团砍价后的最低价</th>
                        </tr>
                        <tr>
                            <td><img src="<?php if($itemInfo){echo $productInfo['path'];}?>" style="max-width:140px;" id="productImg" onerror="this.src='images/default/no_pic.jpg'"></td>
                            <td><span id="productTitle"><?php if($itemInfo){echo $productInfo['title'];}?></span></td>
                            <td id="price"><?php if($itemInfo){echo $productInfo['sell_price'];}?></td>
                            <td><input type="text" name="low_price" size="12" value="<?php if($itemInfo){echo $itemInfo['low_price'];}?>" valid="required|isMoney" errmsg="最低价不能空|价格格式有误"> 元</td>
                        </tr>
                        <td colspan="4">
                            <button type="button" onclick="javascript:window.open('<?php echo base_url(); ?>admincp.php/product/selector/1', 'add', 'top=100, left=200, width=900, height=400, scrollbars=1, resizable=yes');" class="btn"><span>选择商品</span></button>
                            <label style="color:red;">* 设置要拼团砍价的商品，仅能设置一种商品</label>
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
                    <table class="table_form" cellpadding="0" cellspacing="1" style="width:300px;margin-left:0px;">
                        <tr>
                            <th>区间</th>
                            <th>价格</th>
                            <th>操作</th>
                        </tr>
                        <?php
                           if($itemInfo){
                               foreach($pintuan_arr as $ls){
                        ?>
                        <tr>
                            <td>
                                <input type="text" name="low[]" valid="isInt" errmsg="人数为正整数" size="5" value="<?php echo $ls['low'];?>">人～<input type="text" name="high[]" valid="isInt" errmsg="人数为正整数" value="<?php echo $ls['high'];?>" size="5">人
                            </td>
                            <td>
                                <input type="text" name="money[]" value="<?php echo $ls['money'];?>"  valid="isMoney" errmsg="金钱格式不正确" size="10"> 元
                            </td>
                            <td>
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
                    <strong>拼团活动开始时间</strong> <br/>
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
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>拼团活动结束时间</strong> <br/>
                </th>
                <td>
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
        </tbody>
    </table>
<br/><br/>
<script>
    function selectProduct() {
        if(!$("input[name=name]").val()){
            $("input[name=name]").val($("#productTitle").html());
        }
    }
    $("#addPtrule").click(function () {
        var html = '<tr><td>\
                      <input type="text" name="low[]" valid="isInt" errmsg="人数为正整数" size="5">人～<input type="text" valid="isInt" errmsg="人数为正整数" name="high[]" size="5">人\
                  </td>\
                  <td>\
                      <input type="text" name="money[]" size="10" valid="isMoney" errmsg="金钱格式不正确"> 元\
                  </td> <td>\
                       <a href="javascript:;" onclick="$(this).parent().parent().remove();">删除</a>\
                  </td></tr>';
        $("#firstRow").before(html);
    });
</script>