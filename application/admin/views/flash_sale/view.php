<?php echo $tool; ?>
<link href="css/admin/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<script src="js/admin/jquery.datetimepicker.js" type="text/javascript"></script>
<table class="table_form" cellpadding="0" cellspacing="1">
        <caption>基本信息</caption>
        <tbody>
            <tr>
                <th>
                    <strong>限时抢购活动名称</strong>
                </th>
                <td>
                <?php echo!empty($itemInfo) ? $itemInfo['name'] : ''; ?>
                <?php
                 if ($itemInfo) {
                     if($itemInfo['start_time'] > time()){ ?>
                <input style="margin-left: 20px;" onclick="javascript:window.location.href='<?php echo base_url()."admincp.php/{$template}/save/{$itemInfo['id']}"; ?>';" class="button_style" name="reset" value=" 修改当前信息 " type="button">
                <?php }}?>
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>限时抢购时间</strong> <br/>
                </th>
                <td>
                  <?php echo !empty($itemInfo) ? date('Y-m-d H:i', $itemInfo['start_time']) : ''; ?>
                    &nbsp;至&nbsp
                   <?php echo !empty($itemInfo) ? date('Y-m-d H:i', $itemInfo['end_time']) : ''; ?>
                   <?php
                 if ($itemInfo) {
                     if($itemInfo['start_time'] < time() &&  $itemInfo['end_time'] > time()){
                       echo  '<font color="red">进行中...</font>';
                     }
                     if($itemInfo['end_time'] < time()){
                         echo  '<font color="red">已结束</font>';
                     }
                     if($itemInfo['start_time'] > time()){
                         echo  '<font color="red">暂未开始</font>';
                     }
                 }
                    ?>
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>是否开启</strong> <br>
                </th>
                <td>
                <?php if ($itemInfo) { echo $itemInfo['is_open'] == 1 ? '开启' : '关闭';} ?>
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
                            <td class="align_c"><img src="<?php if($productInfo){echo $productInfo['path'];}?>" style="max-width:140px;" onerror="this.src='images/default/no_pic.jpg'"></td>
                            <td class="align_c"><span><?php if($productInfo){echo $productInfo['title'];}?></span></td>
                            <td class="align_c"><?php if($productInfo){echo $productInfo['sell_price'];}?></td>
                            <td class="align_c"><?php if($itemInfo){echo $itemInfo['flash_sale_price'];}?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th width="20%">
                    <strong>活动介绍</strong> <br/>
                </th>
                <td>
                    <?php if($itemInfo){echo $itemInfo['description'];}?>
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td>
                <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
                </td>
            </tr>
        </tbody>
    </table>
<br/><br/>