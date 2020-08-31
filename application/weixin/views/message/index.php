<link href="css/default/message.css" rel="stylesheet" type="text/css"/>
<div class="zczh">
	<h2>信息提示<a href="javascript:;" onclick="window.history.go(-1);">返回上一步</a></h2>
	<div class="inbox_yy">
    	<div class="tit" style="text-align: center;"><?php if (isset($msg)){echo $msg;} ?></div>
        <div class="yjbtn"><a href="<?php echo $url;?>">如果您的浏览器没有自动跳转，请点击这里</a></div>
            <script>window.setTimeout("window.location.href='<?php echo $url;?>'",3000);</script>
        </div>  
</div>
