<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right mt20">
        <div class="member_headline box_shadow clearfix">
            <ul class="short1">
                <Li><b>账户余额</b>
                    <span class="purple"><small>￥</small><?php echo $user_info['total'];?></span>
                </Li>
                <Li style="margin-top:15px;"><a href="<?php echo getBaseUrl(false,'','user/recharge.html',$client_index);?>" class="m_btn purple mr20" id="recharge">充值</a><!--<a href="m_tx.html" class="m_btn">提现</a>--></Li>
            </ul>
        </div>
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_tab">
                <div class="hd">
                    <ul>
                        <li onclick="javascript:window.location.href='<?php echo getBaseUrl(false,'','user/get_financial_list.html',$client_index);?>';" class="on">财务消费记录</li>
                        <li onclick="javascript:window.location.href='<?php echo getBaseUrl(false,'','user/get_pay_log_list.html',$client_index);?>';" >在线充值记录</li>
                    </ul>
                </div>
                <div class="bd">
                    <div class="clearfix">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt10">
                            <tbody>
                                <tr>
                                    <th class="tal"><strong>操作时间</strong></th>
                                    <th ><strong>类型</strong></th>
                                    <th ><strong>金额（元）</strong></th>
                                    <th ><strong>原因</strong></th>
                                </tr>
                                <?php
                                if($item_list){
                                    foreach($item_list as $item){
                                ?>
                                <tr>
                                    <td width="22%" align="left"><?php echo date('Y-m-d H:i:s',$item['add_time']);?></td>
                                    <td width="19%" align="center">
                                        <?php echo $financial_type_arr[$item['type']];?>
                                    </td>
                                    <td width="14%" align="center"><b class="purple f14"><?php echo $item['price'];?></b></td>
                                    <td width="45%" align="center" ><?php echo $item['cause'];?></td>
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
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
      $("#recharge").click(function(){
      var flag = <?php echo empty($user_info['pay_password']) ? 'true' : 'false';?>;
      if(flag){
                       var d = dialog({
                            width: 200,
                            fixed: true,
                            title: '提示',
                            content: '您尚未设置支付密码',
                            okValue: '去设置',
                            ok: function () {
                                window.location.href = base_url + 'index.php/user/change_pay_password.html';
                            },
                        });
                        d.show();
          return false;
      }
  });
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
