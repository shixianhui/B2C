<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <script src="<?php echo base_url();?>js/default/jquery.js" type="text/javascript"></script>
    </head>
    <body>
        <div>
        <form name="form2" action="<?php echo $serverUrl ?>" method="post">
	<input type="hidden" name="inputCharset" id="inputCharset" value="<?php echo $inputCharset ?>" />
	<input type="hidden" name="pickupUrl" id="pickupUrl" value="<?php echo $pickupUrl?>"/>
	<input type="hidden" name="receiveUrl" id="receiveUrl" value="<?php echo $receiveUrl?>" />
	<input type="hidden" name="version" id="version" value="<?php echo $version?>"/>
	<input type="hidden" name="language" id="language" value="" />
	<input type="hidden" name="signType" id="signType" value="<?php echo $signType?>"/>
	<input type="hidden" name="merchantId" id="merchantId" value="<?php echo $merchantId?>" />
	<input type="hidden" name="payerName" id="payerName" value=""/>
	<input type="hidden" name="payerEmail" id="payerEmail" value="" />
	<input type="hidden" name="payerTelephone" id="payerTelephone" value="" />
	<input type="hidden" name="payerIDCard" id="payerIDCard" value="" />
	<input type="hidden" name="pid" id="pid" value=""/>
	<input type="hidden" name="orderNo" id="orderNo" value="<?php echo $orderNo?>" />
	<input type="hidden" name="orderAmount" id="orderAmount" value="<?php echo $orderAmount ?>"/>
	<input type="hidden" name="orderCurrency" id="orderCurrency" value="" />
	<input type="hidden" name="orderDatetime" id="orderDatetime" value="<?php echo $orderDatetime?>" />
	<input type="hidden" name="orderExpireDatetime" id="orderExpireDatetime" value=""/>
	<input type="hidden" name="productName" id="productName" value="" />
	<input type="hidden" name="productPrice" id="productPrice" value="" />
	<input type="hidden" name="productNum" id="productNum" value=""/>
	<input type="hidden" name="productId" id="productId" value="" />
	<input type="hidden" name="productDesc" id="productDesc" value="" />
	<input type="hidden" name="ext1" id="ext1" value="" />
	<input type="hidden" name="ext2" id="ext2" value="" />
	<input type="hidden" name="extTL" id="extTL" value="" />
	<input type="hidden" name="payType" value="<?php echo $payType?>" />
	<input type="hidden" name="issuerId" value="" />
	<input type="hidden" name="pan" value="" />
	<input type="hidden" name="tradeNature" value="<?php echo $tradeNature?>" />
	<input type="hidden" name="customsExt" value=""/>
	<input type="hidden" name="signMsg" id="signMsg" value="<?php echo $signMsg?>"/>
	<div align="center"><input type="submit" value="确认付款，到通联支付去啦" align=center/></div>
<!--================= post 方式提交支付请求 end =====================-->
</form>
        </div>
        <script>
           $("input[type=submit]").click();
        </script>
    </body>
</html>

