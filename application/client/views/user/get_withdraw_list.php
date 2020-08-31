            <div class="member_tab mt20">
                <div class="hd">
                    <ul>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_elephant_log_list/gold.html',$client_index);?>';">金象币消费记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_elephant_log_list/silver.html',$client_index);?>';">银象币消费记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_withdraw_list/gold.html',$client_index);?>';" <?php if ($score_type == 'gold') {echo 'class="on"';} ?>>金象币提现记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_withdraw_list/silver.html',$client_index);?>';" <?php if ($score_type == 'silver') {echo 'class="on"';} ?>>银象币提现记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_score_pay_log_list/gold.html',$client_index);?>';">金象积分充值记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_score_pay_log_list/silver.html',$client_index);?>';">银象积分充值记录</li>
                    </ul>
                </div>
                <div class="bd">
                    <div class="clearfix">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
                            <tbody>
                                <tr>
                                    <th width="12%" align="center"><strong>申请时间</strong></th>
                                    <th width="12%"  align="center"><strong>账号类型</strong></th>
                                    <th width="12%"  align="center"><strong>户名</strong></th>
                                    <th width="12%"  align="center"><strong>账号</strong></th>
                                    <th width="12%"  align="center"><strong>提现金额(元)</strong></th>
                                    <th width="12%"  align="center"><strong>状态</strong></th>
                                    <th  align="center"><strong>描述</strong></th>
                                </tr>
                                <?php
                                if($item_list){
                                    foreach($item_list as $value){
                                ?>
                                <tr>
                                    <td align="center"><?php echo date('Y-m-d',$value['add_time']);?></td>
                                    <td align="center"><?php echo $pay_log_payment_type_arr[$value['type']];?></td>
                                    <td align="center" ><?php echo $value['real_name'];?></td>
                                    <td align="center" ><?php echo $value['account'];?></td>
                                    <td align="center"><span class="goods-price"><?php echo $value['price']; ?></span></td>
                                   <td align="center" ><?php echo $display_arr[$value['display']];?></td>
                                    <td align="center" >提<?php echo floatval($value['score_num']); ?><?php echo $score_type_arr[$value['score_type']]; ?>兑换<?php echo $value['price']; ?>元</td>
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