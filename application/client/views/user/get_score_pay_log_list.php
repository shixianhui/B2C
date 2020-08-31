            <div class="member_tab mt20">
                <div class="hd">
                    <ul>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_elephant_log_list/gold.html',$client_index);?>';">金象币消费记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_elephant_log_list/silver.html',$client_index);?>';">银象币消费记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_withdraw_list/gold.html',$client_index);?>';">金象币提现记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_withdraw_list/silver.html',$client_index);?>';">银象币提现记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_score_pay_log_list/gold.html',$client_index);?>';" <?php if ($score_type == 'gold') {echo 'class="on"';} ?>>金象积分充值记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_score_pay_log_list/silver.html',$client_index);?>';" <?php if ($score_type == 'silver') {echo 'class="on"';} ?>>银象积分充值记录</li>
                    </ul>
                </div>
                <div class="bd">
                    <div class="clearfix">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
                            <tbody>
                                <tr>
                                    <th width="12%" class="tal"><strong>充值时间</strong></th>
                                    <th width="12%" ><strong>充值方式</strong></th>
                                    <th width="12%" ><strong>积分数量</strong></th>
                                    <th width="12%" ><strong>应付金额（元）</strong></th>
                                    <th ><strong>充值交易号</strong></th>
                                    <th width="12%" ><strong>状态</strong></th>
                                </tr>
                                <?php
                                if($item_list){
                                    foreach($item_list as $value){
                                ?>
                                <tr>
                                    <td align="left">
                                    <?php echo date('Y-m-d', $value['add_time']); ?>
                                    </td>
                                    <td align="center">
                                    <?php echo $pay_log_payment_type_arr[$value['payment_type']]; ?>
                                    </td>
                                    <td align="center"><?php echo $value['score']; ?></td>
                                    <td align="center"><b class="purple f14"><?php echo $value['total_fee']; ?></b></td>
                                    <td align="center" ><?php echo $value['out_trade_no']; ?></td>
                                    <td align="center" ><?php echo $trade_status_msg[$value['trade_status']]; ?></td>
                                </tr>
                                <?php }}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="pagination">
                <ul><?php echo $pagination; ?></ul>
            </div>