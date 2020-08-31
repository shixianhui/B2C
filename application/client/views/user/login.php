<div class="warp">
<div class="log_box">
<h3>有账号，快速登录</h3>
    <form action="<?php echo getBaseUrl(false, "", "user/login.html", $client_index); ?>" method="post" id="jsonForm" name="jsonForm">
 <ul class="log_form">
    <Li><input type="text" placeholder="手机号" valid="required|isMobile" errmsg="手机号不能为空|手机号码格式不正确" name="username" id="username"  class="log_txt"></Li>
    <Li><input type="password" placeholder="密码" valid="required" errmsg="密码不能为空" name="password" id="password" class="log_txt"></Li>
    <li>
         <input type="text" class="log_txt" valid="required" errmsg="验证码不能为空" maxlength="4" name="code" id="code" placeholder="输入验证码" style="width:100px;text-transform: uppercase;">
         <img style="" id="valid_code_pic" src="<?php echo getBaseUrl(false, "", "verifycode/index/1", $client_index); ?>" alt="看不清，换一张" onclick="javascript:this.src = this.src+1;" />
         <a style="color:#333;" onclick="javascript:document.getElementById('valid_code_pic').src = document.getElementById('valid_code_pic').src+1;" href="javascript:void(0);">换一张</a>
    </li>
    <li><input type="submit" class="btn_r" value="立即登录" style="border:none;"></li>
    <li><label><input type="checkbox">记住用户名</label> <a href="<?php echo getBaseUrl(false, "", "user/get_pass.html", $client_index); ?>" class="f12 c9">忘记密码?</a><font color="#ccc"> |</font> <a href="<?php echo getBaseUrl(false,'','user/register.html',$client_index);?>"><font class="purple f12">免费注册</font></a></li>
    <div class="other_log mt20"><span class="c9 f14">—  第三方账号登录  —</span>
      <p>
      <a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxc2858411e327df01&redirect_uri=<?php echo urlencode(base_url().'index.php/user/weixin_login')?>&response_type=code&scope=snsapi_login&state=1#wechat_redirect" class="wechat_icon icon"></a>
      <a href="sdk/authlogin/qqlogin/oauth" class="qq_icon icon"></a>
      </p>
    </div>
  </ul>
    </form>
</div>
<div class="log_img">
	<?php
	$adList = $this->advdbclass->getAd(57, 1);
	if ($adList) {
	foreach ($adList as $ad) {
	?>
	<Img src="<?php echo $ad['path'];?>">
	<?php }} ?>
	</div>
</div>
<script type="text/javascript">
        $(function () {
            $("img.lazy").lazyload({
                placeholder: "images/load.jpg", //加载图片前的占位图片
                effect: "fadeIn" //加载图片使用的效果(淡入)
            });
        });

    </script>
<script language="javascript" type="text/javascript">
function count_price(idn){
	var JQ1=$(idn).find(".Choose");
	var JQ2=idn.find(".Choose_all");
	var JQ_Tprice=$(idn).find(".t-price");
	var JQ_Tnumber=$(idn).find(".t-number");
	var Choose_count=JQ1.length;
	var count=0,Uprice,Tnumber=0;
	JQ1.each(function(idx){
		if($(this).is(':checked')){
		Uprice=parseFloat($(idn).find(".unit").eq(idx).text())*parseFloat($(idn).find(".unum").eq(idx).val());
		count+=Uprice;
		Tnumber++;
		}
		});
	if(Tnumber==Choose_count){
		JQ2.attr("checked",true);
		}
	else{
		JQ2.attr("checked",false);
		}

	JQ_Tprice.text(count.toFixed(2));
	JQ_Tnumber.text(Tnumber);
	}

function Choose_all(that,idn){
	var JQ1=idn.find(".Choose");
	var JQ2=idn.find(".Choose_all");
	if($(that).attr("checked")){
	JQ1.attr("checked",true);
	JQ2.attr("checked",true);
	count_price(idn);
	}
	else{
	JQ1.attr("checked",false);
	JQ2.attr("checked",false);
	count_price(idn);
		}
	}

function Choose(that,idn){
	if($(that).attr("checked")){
	$(that).attr("checked",true);
	count_price(idn);
	}
	else{
	$(that).attr("checked",false);
	count_price(idn);
		}
	}

$(document).ready(function(){
$(".Choose_all").bind({
	change:function(){
		var JQ=$(this).parents(".cart_table");
		Choose_all(this,JQ)
		}
	});
$(".Choose").bind({
	change:function(){
		var JQ=$(this).parents(".cart_table");
		Choose(this,JQ)
		}
	});
$(".Increase").bind({
		click:function(){
			var jq=$(this).parents("tr");
			var idn=$(this).parents(".cart_table");
			var num=parseInt($(this).next(".unum").val());
			var units=Number($(jq).find(".unit").text());
			num+=1;
			var count=num*units;
			$(this).next(".unum").val(num);
			$(jq).find(".u-price").text(count.toFixed(2));
			count_price(idn);
			return false;
			}
		});
$(".Reduce").bind({
		click:function(){
			var jq=$(this).parents("tr");
			var idn=$(this).parents(".cart_table");
			var num=parseInt($(this).prev(".unum").val());
			var units=Number($(jq).find(".unit").text());
			num-=1;
			if(num<=0) num=1;
			var count=num*units;
			$(this).prev(".unum").val(num);
			$(jq).find(".u-price").text(count.toFixed(2));
			count_price(idn);
			return false;
			}
		});

$(".unum").val(1);
if($(".Choose_all").attr("checked",false)){
$(".Choose_all").click();
$(".Choose").click();
}

});
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>