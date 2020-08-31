            <div class="member_tab mt20">
                <div class="hd">
                    <ul>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_elephant_log_list/gold.html',$client_index);?>';" <?php if ($score_type == 'gold') {echo 'class="on"';} ?>>金象币消费记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_elephant_log_list/silver.html',$client_index);?>';" <?php if ($score_type == 'silver') {echo 'class="on"';} ?>>银象币消费记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_withdraw_list/gold.html',$client_index);?>';">金象币提现记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_withdraw_list/silver.html',$client_index);?>';">银象币提现记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_score_pay_log_list/gold.html',$client_index);?>';">金象积分充值记录</li>
                        <li onclick="javascript:window.location.href='<?php echo base_url().getBaseUrl(false,'','user/get_score_pay_log_list/silver.html',$client_index);?>';">银象积分充值记录</li>
                    </ul>
                </div>
                <div class="bd">
                    <div class="clearfix">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
                            <tbody>
                                <tr>
                                    <th width="10%" align="center"><strong>消费时间</strong></th>
                                    <th width="12%"  align="center"><strong>数量（币）</strong></th>
                                    <th width="12%"  align="center"><strong>余额（币）</strong></th>
                                    <th width="15%"  align="center"><strong>类型</strong></th>
                                    <th  align="center"><strong>原因</strong></th>
                                </tr>
                                <?php
                                if($item_list){
                                    foreach($item_list as $value){
                                ?>
                                <tr>
                                    <td align="center"><?php echo date('Y-m-d',$value['add_time']);?></td>
                                    <td align="center">
                                    <?php if ($value['score'] < 0) { ?>
									<span class="goods-price" style="color:#00CC00;"><?php echo $value['score']; ?></span>
									<?php } else { ?>
									<span class="goods-price">+<?php echo $value['score']; ?></span>
									<?php } ?>
					                </td>
					                <td align="center" ><?php echo $value['balance'];?></td>
                                    <td align="center"><?php echo $elephant_log_type_arr[$value['type']];?></td>
                                    <td align="center" ><?php echo $value['cause'];?></td>
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