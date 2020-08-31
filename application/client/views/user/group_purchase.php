<div class="clear"></div>
<div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            <div class="member_title"><span class="bt">我的拼团活动</span></div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt20">
                <colgroup>
                    <col/>
                    <col width="10%"/>
                    <col width="15%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                    <col width="10%"/>
                </colgroup>
                <tr>
                    <td colspan="9">
                        <span style="color:#e61d47;">注：活动期间，请及时支付，过期则不可支付,支付前请确认好收货地址</span>
                    </td>
                </tr>
                <tr>
                    <th><strong>名称</strong></th>
                    <th><strong>图片</strong></th>
                    <th><strong>尺码/颜色/数量</strong></th>
                    <th><strong>拼团人数</strong></th>
                    <th><strong>当前拼团价</strong></th>
                    <th><strong>已砍次数</strong></th>
                    <th><strong>砍掉金额</strong></th>
                    <th><strong>最终价格</strong></th>
                    <th><strong>操作</strong></th>
                </tr>
                <?php
                if ($group_purchase_list) {
                    foreach ($group_purchase_list as $item) {
                        ?>
                        <tr>
                            <td align="center" class="title"><?php echo my_substr($item['name'], 10); ?></td>
                            <td align="center"><img src="<?php echo $item['path']; ?>" style="width:60px;"></td>
                            <td align="left">
                                尺码：<?php echo $item['size_name']; ?><br>
                                颜色：<?php echo $item['color_name']; ?><br>
                                数量：<?php echo $item['buy_number']; ?><br>
                            </td>
                            <td align="center">
                                <?php echo $item['pintuan_people']; ?>
                            </td>
                            <td align="center"><?php echo $item['pintuan_price']; ?></td>
                            <td align="center"><?php echo $item['cut_times']; ?>次</td>
                            <td align="center"><?php echo $item['sum']; ?>元</td>
                            <td align="center"> <span class="payprice"><?php echo number_format(($item['pintuan_price'] - $item['sum']) * $item['buy_number'], 2); ?></span>元</td>
                            <td align="center">
                                <?php
                                if (time() < $item['end_time']) {?>
<!--                                <a href="javascript:void();" class="m_btn" onclick="pay(<?php //echo $item['id']; ?>, $(this).parents('tr').find('.payprice').html())">去支付</a><br>-->
                                <a style="margin:5px 0px;" href="javascript:void(0)" onclick="tcPop(this);" class="m_btn">去砍价</a>
                                <?php }?>
                                <a href="index.php/bargain/chop_price/<?php echo $item['id']; ?>?sign=<?php echo md5('mykey' . $item['id']); ?>" class="url"><font class="c9">查看详情</font></a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9">活动结束时间：<?php
                                echo date('Y-m-d H:i:s', $item['end_time']);
                                ;
                                ?> &nbsp;&nbsp;
                                <?php
                                if (time() > $item['end_time']) {
                                    echo '<span style="color:#e61d47">活动已结束</span>';
                                } else {
                                    echo '<span style="color:#e61d47">进行中...</span>';
                                };
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
               <div class="clear"></div>
            <div class="pagination"> 
                <ul><?php echo $pagination; ?></ul>
            </div>  
        </div>
    </div>
</div>
<div id="bg" class="dn"></div>
<div class="popup_box" id="popup_tip" style="display:none">
    <a class="close" href="javascript:void(0);" id="close">×</a>
    <div class="content">
        <div class="tit"><span class="bt">分享</span></div>
        <div class="pop_kj">
            <h3>请朋友帮忙去砍价</h3>
            <ul style="text-align:center;" id="share">
                <Li><a href="javascript:;"   class="qq_icon"></a></Li>
                <Li><a href="javascript:;"   class="weixin_icon"></a></Li>
                <Li><a href="javascript:;"   class="sina_icon"></a></Li>
                <Li><a href="javascript:;"   class="kongjian_icon"></a></Li>
            </ul>
        </div>
    </div>
</div>
<style>
</style>
<script type="text/javascript">
    $(function () {
        $("img.lazy").lazyload({
            placeholder: "images/default/load.jpg", //加载图片前的占位图片
            effect: "fadeIn" //加载图片使用的效果(淡入)
        });
    });
</script>

<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
<script>
    function tcPop(_this) {
        $("#bg").stop(true, true).fadeIn('300');
        $("#popup_tip").stop(true, true).fadeIn('300');
        var url = base_url + $(_this).siblings('.url').attr('href');
        var title = $(_this).parents('tr').find('.title').html();
        var pic = base_url + $(_this).parents('tr').find('img').attr('src');
        $("#share a.qq_icon").attr('href', 'http://www.jiathis.com/send/?webid=cqq&url=' + url + '&title=' + title + '&pic=' + pic);
        $("#share a.weixin_icon").attr('href', 'http://www.jiathis.com/send/?webid=weixin&url=' + url + '&title=' + title + '&pic=' + pic);
        $("#share a.sina_icon").attr('href', 'http://www.jiathis.com/send/?webid=tsina&url=' + url + '&title=' + title + '&pic=' + pic);
        $("#share a.kongjian_icon").attr('href', 'http://www.jiathis.com/send/?webid=qzone&url=' + url + '&title=' + title + '&pic=' + pic);
    }
    function pay(id, price) {
        var d = dialog({
            width: 200,
            fixed: true,
            title: '提示',
            content: '最终价格为' + price + '元，您确定要支付吗?',
            okValue: '确定',
            ok: function () {
                $.ajax({
                    url: base_url + 'index.php/order/ptkj_pay',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        ptkj_record_id: id,
                    },
                    success: function (data) {
                        if (!data.success) {
                            alert(data.message);
                            return;
                        }
                        location.href=data.field;
                    }
                });
            },
            cancelValue: '取消',
            cancel: function () {

            }
        });
        d.show();
    }
</script>
