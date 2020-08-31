<style>
    .graybg{
        background-color:#F8F8F8;
        height:750px;
    }
    .graybg h2{
        text-align: center;
        height:100px;
        line-height: 100px;
    }
    .wechat_body{
        width:960px;
        padding-top: 60px;
        padding-bottom: 80px;
        background-color: #fff;
        border-top: 4px solid #e61d47;
        margin:0 auto;
    }
    .wechat_body img{
        display:block;
        margin:0 auto;
    }
    .sys{
        width:280px;
        height:100px;
        background:url(images/default/sys.png) no-repeat;
        margin: 0 auto;
    }
    .m-price{
        color: #e61d47;
        font-size:50px;
    }
    .graybg p{
        text-align:center;
        margin-top:30px;
    }
    .m-price .u-yen{
        margin-right:8px;
    }
</style>
<div class="graybg">
    <h2>
        <img src="images/default/wechat_pay.png">
    </h2>
    <div class="wechat_body">
        <img src="<?php echo base_url().'index.php/pay/qrcode?data='.urlencode($wxurl);?>" style="width:260px;height:260px;">
        <input type="hidden" value="<?php echo $orderno;?>" id="orderno">
        <div class="sys"></div>
        <p><span class="m-price  u-highlight"><span class="u-yen">¥</span><span class="u-price"><?php echo $money;?></span></span></p>
    </div>
</div>

<script>
    // 每半秒请求一次数据，然后判断，跳转，增加用户友好性
    $(function(){
        orderno = $('#orderno').val();
        start = window.setInterval("checkstatus(orderno)", 1500);
    });

    function checkstatus(order_no){
        if(order_no == undefined || order_no == ''){
            window.clearInterval(start);
        }else{
            $.ajax({
                url:"<?php echo base_url().'index.php/pay/get_weixin_heart';?>",
                type:'POST',
                dataType:'json',
                data:{out_trade_no:orderno},
                success:function(msg){
                	if (msg.data.trade_status != 'WAIT_BUYER_PAY') {
                        window.clearInterval(start);
                        location.href = base_url+"index.php/order/result?out_trade_no="+msg.data.order_num;
                    }
                }
            });
        }
    }
</script>
