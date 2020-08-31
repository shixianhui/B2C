<div class="member_left mt20">
                <div class="member_nav box_shadow">
                <?php
                $user_info = $this->advdbclass->get_user_info(get_cookie('user_id'));
                $c = $this->uri->segment(1);
                $m = $this->uri->segment(2);
                ?>
                    <dl>
                        <dt>订单中心</dt>
                        <dd>
                            <a href="<?php echo getBaseUrl(false,'','order/index/all/0.html',$client_index);?>" <?php echo $c=='order'? 'class="current"' : '';?>>我的订单</a>
                            <!--
                            <a href="<?php echo getBaseUrl(false,'','order/index/all/1.html',$client_index);?>" <?php echo ($c=='order' && isset($order_type) ? $order_type==1 : false) ? 'class="current"' : '';?>>拼团砍价订单</a>
                            <a href="<?php echo getBaseUrl(false,'','order/index/all/2.html',$client_index);?>" <?php echo ($c=='order' && isset($order_type) ? $order_type==2 : false) ? 'class="current"' : '';?>>限时抢购订单</a>
                            <a href="m_wdjc.html">我的竞猜</a>
                            <a href="m_wdcj.html">我的抽奖</a>-->
                            <a href="<?php echo getBaseUrl(false,'','user/get_user_exchange_list.html',$client_index);?>"  <?php echo $m=='get_user_exchange_list' ? 'class="current"' : '';?>>我的退款/退换货</a>
                            <a href="<?php echo getBaseUrl(false,'','user/comment_list.html',$client_index);?>"  <?php echo ($m=='comment_list' || $m=='comment_save') ? 'class="current"' : '';?>>我的评价</a>
                        </dd>
                    </dl>
                    <!--
                    <dl>
                        <dt>我的活动</dt>
                        <dd>
                            <a href="<?php echo getBaseUrl(false,'','user/group_purchase.html',$client_index);?>" <?php echo $m=='group_purchase' ? 'class="current"' : '';?>>我的拼团/砍价</a>
                            <a href="<?php echo getBaseUrl(false,'','user/flash_sale.html',$client_index);?>" <?php echo $m=='flash_sale' ? 'class="current"' : '';?>>我的限时抢购</a>
                          <a href="m_wdjc.html">我的竞猜</a>
                            <a href="m_wdcj.html">我的抽奖</a>
                        </dd>
                    </dl>
                    -->
                    <dl>
                        <dt>收藏</dt>
                        <dd>
                            <a href="<?php echo getBaseUrl(false,'','user/get_favorite_list.html',$client_index);?>" <?php echo $m=='get_favorite_list' ? 'class="current"' : '';?>">我的收藏</a>                            
                        </dd>
                    </dl>
                    <dl>
                        <dt>我的推广</dt>
                        <dd>
                            <a href="<?php echo getBaseUrl(false,'','user/get_presenter_link.html',$client_index);?>" <?php echo $m=='get_presenter_link' ? 'class="current"' : '';?>">我的推广链接</a>
                            <a href="<?php echo getBaseUrl(false,'','user/get_presenter_result.html',$client_index);?>" <?php echo $m=='get_presenter_result' ? 'class="current"' : '';?>">推广效果统计</a>
                            <a href="<?php echo getBaseUrl(false,'','user/get_presenter_sub_list/1.html',$client_index);?>"  <?php echo $m=='get_presenter_sub_list' ? 'class="current"' : '';?>>我发展的用户</a>
                            <a href="<?php echo getBaseUrl(false,'','user/get_presenter_financial_1_list/1.html',$client_index);?>"  <?php echo $m=='get_presenter_financial_1_list' ? 'class="current"' : '';?>>我的推广提成</a>
                       </dd>
                    </dl>
                    <dl>
                        <dt>我的财务</dt>
                        <dd>
                            <a href="<?php echo getBaseUrl(false,'','user/get_score_list.html',$client_index);?>" <?php echo $m=='get_score_list' ? 'class="current"' : '';?>>我的积分</a>
                            <a href="<?php echo getBaseUrl(false,'','user/get_financial_list.html',$client_index);?>" <?php echo ($c == 'user' && ($m=='get_financial_list' || $m == 'get_pay_log_list' || $m == 'recharge')) ? 'class="current"' : '';?>>我的余额</a>
                            <?php if ($user_info && $user_info['user_type']) { ?>
                            <a href="<?php echo getBaseUrl(false,'','user/get_elephant_log_list.html',$client_index);?>" <?php echo ($c == 'user' && ($m=='get_elephant_log_list' || $m=='get_withdraw_list' || $m=='get_score_pay_log_list' || $m=='recharge_score' || $m=='withdraw_elephant')) ? 'class="current"' : '';?>>我的资产</a>
                            <a href="<?php echo getBaseUrl(false,'','user/score_select.html',$client_index);?>" <?php echo $m=='score_select' ? 'class="current"' : '';?>>积分查询</a>
                            <?php } ?>
                        </dd>
                    </dl>
                    <dl>
                        <dt>账号中心</dt>
                        <dd>
                            <a href="<?php echo getBaseUrl(false,'','user/change_user_info.html',$client_index);?>"  <?php echo $m=='change_user_info' ? 'class="current"' : '';?>>资料信息</a>
                            <a href="<?php echo getBaseUrl(false,'','user/bind_pop_code.html',$client_index);?>"  <?php echo $m=='bind_pop_code' ? 'class="current"' : '';?>>绑定邀请码</a>
                            <a href="<?php echo getBaseUrl(false,'','user/get_user_address_list.html',$client_index);?>" <?php echo ($c == 'user' && ($m=='get_user_address_list' || $m=='save_address')) ? 'class="current"' : '';?>>收货地址</a>
                            <a href="<?php echo getBaseUrl(false,'','user/change_pass.html',$client_index);?>" <?php echo $m=='change_pass' ? 'class="current"' : '';?>>修改登录密码</a>
                            <a href="<?php echo getBaseUrl(false,'','user/change_pay_password.html',$client_index);?>" <?php echo $m=='change_pay_password' ? 'class="current"' : '';?>>修改支付密码</a>
                        </dd>
                    </dl>
                </div>
</div>