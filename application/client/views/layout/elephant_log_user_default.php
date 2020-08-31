<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <base href="<?php echo base_url(); ?>" />
        <meta name="title" content="<?php echo clearstring($title); ?>" />
        <meta name="keywords" content="<?php echo clearstring($keywords); ?>" />
        <meta name="description" content="<?php echo clearstring($description); ?>" />
        <link rel="shortcut icon" href="images/default/ico.ico?v=1.01">
        <link href="css/default/rest.css" type="text/css" rel="stylesheet">
        <link href="css/default/base.css?v=1.04" type="text/css" rel="stylesheet">
        <link href="css/default/member.css?v=1.04" type="text/css" rel="stylesheet">
        <script src="js/default/aui-artDialog/lib/jquery-1.10.2.js"></script>
        <link rel="stylesheet" href="js/default/aui-artDialog/css/ui-dialog.css">
        <script src="js/default/aui-artDialog/dist/dialog-plus-min.js"></script>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="js/default/html5.js"></script>
        <![endif]-->
        <script type="text/javascript" language="javascript" src="js/default/jquery.SuperSlide.js"></script>
        <script type="text/javascript" language="javascript" src="js/default/jquery.lazyload.min.js"></script>
        <script src="js/default/jquery.form.js"></script>
        <script src="js/default/formvalid.js?v=2.01" type="text/javascript"></script>
        <script src="js/default/index.js" type="text/javascript"></script>
        <script>
           var controller = '<?php echo $this->uri->segment(1); ?>';
           var method = '<?php echo $this->uri->segment(2); ?>';
           var base_url = '<?php echo base_url(); ?>';
       </script>
    </head>
    <body>
         <?php echo $this->load->view('element/topbar_tool', '', TRUE); ?>
        <div class="member_head">
            <div class="warp">
                <a href="<?php echo base_url();?>" class="logo"><img src="images/default/m_logo.png"></a>
                <ul>
                    <Li><a href="<?php echo getBaseUrl(false,"","user.html",$client_index);?>" <?php if(!($this->uri->segment(2)=='get_financial_list' || $this->uri->segment(2)=='get_score_list' || $this->uri->segment(2)=='get_message_list')){ echo 'class="current"';}?>>用户中心</a></Li>
                    <Li><a href="<?php echo getBaseUrl(false,"","user/get_financial_list.html",$client_index);?>" <?php echo $this->uri->segment(2)=='get_financial_list' || $this->uri->segment(2)=='get_score_list' ? 'class="current"' : '';?>>我的资产</a></Li>
                    <Li><a href="<?php echo getBaseUrl(false,"","user/get_message_list.html",$client_index);?>" <?php echo $this->uri->segment(2)=='get_message_list' ? 'class="current"' : '';?>>消息</a></Li>
                </ul>
                <?php echo $this->load->view('element/cart_tool', '', TRUE); ?>
            </div>
        </div>
         <div class="clear"></div>
             <div class="warp">
    <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
        <?php
        $user_info = $this->advdbclass->get_user_info(get_cookie('user_id'));
        ?>
        			<div class="member_recharge clearfix">
		        		<div>
		        			<p><img src="images/default/xiang-img1.png"/>金象积分</p>
		        			<span id="score_gold_span"><?php if ($user_info) {echo $user_info['score_gold'];} ?></span>
		        			<a href="<?php echo getBaseUrl(false,'','user/recharge_score/gold.html',$client_index);?>">充值</a>
		        			<a onclick="javascript:change_score('gold');" href="javascript:void(0);">兑换</a>
		        		</div>
		        		<div>
		        			<p><img src="images/default/xiang-img2.png"/>银象积分</p>
		        			<span id="score_silver_span"><?php if ($user_info) {echo $user_info['score_silver'];} ?></span>
		        			<a href="<?php echo getBaseUrl(false,'','user/recharge_score/silver.html',$client_index);?>">充值</a>
		        			<a onclick="javascript:change_score('silver');" href="javascript:void(0);">兑换</a>
		        		</div>
		        		<div>
		        			<p><img src="images/default/xiang-img1.png"/>金象币</p>
		        			<span id="total_gold_span"><?php if ($user_info) {echo $user_info['total_gold'];} ?></span>
		        			<a href="<?php echo getBaseUrl(false,'','user/withdraw_elephant/gold.html',$client_index);?>">提现</a>
		        		</div>
		        		<div>
		        			<p><img src="images/default/xiang-img2.png"/>银象币</p>
		        			<span id="total_silver_span"><?php if ($user_info) {echo $user_info['total_silver'];} ?></span>
		        			<a href="<?php echo getBaseUrl(false,'','user/withdraw_elephant/silver.html',$client_index);?>">提现</a>
		        		</div>
		        	</div>
            <?php echo $content; ?>
        </div>
    </div>
</div>
<div id="opover_recharge" class="opover_recharge">
			<img src="images/default/chongzhibg.png"/>
			<div>
				<img onclick="javascript:$('#opover_recharge').removeClass('active');" class="close_btn" src="images/default/chongzhi-close.png"/>
				<div>
				        <input id="score_type" type="hidden" />
						<label id="recharge_score_num_label">金象积分</label>
						<input id="recharge_score_num" type="text" placeholder="" />
					</div>
					<div>
						<label id="recharge_total_label">获得金象币</label>
						<input id="recharge_total" type="text" readonly="readonly"/>
						<p id="recharge_bl">*按1：1比例将金象积分兑换为金象币</p>
					</div>
					<div>
						<label for="">支付密码</label>
						<input id="pay_password" type="password" />
						<p><a href="<?php echo getBaseUrl(false,'','user/change_pay_password', $client_index);?>"  >忘记密码？</a></p>
					</div>
					<div><div class="button"><button onclick="javascript:recharge();">确认兑换</button></div></div>
				<div class="title">
					积分兑换
				</div>
			</div>
		</div>
             <div class="clear"></div>
		    <div class="copyright">
		        <P><?php echo $site_copyright; ?><?php echo $icp_code; ?></P>
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

$('#recharge_score_num').bind('input propertychange', function() {
	var recharge_score_num = $('#recharge_score_num').val();
    $('#recharge_total').val(recharge_score_num);
});

function change_score(score_type) {
	if (score_type == 'gold') {
		var score_gold = $('#score_gold_span').html();
        $('#recharge_score_num_label').html('金象积分');
        $('#recharge_score_num').val('');
        $('#recharge_score_num').attr('placeholder', '最大可兑换'+score_gold+'积分');
        $('#recharge_total_label').html('获得金象币');
        $('#recharge_total').val('');
        $('#pay_password').val('');
        $('#recharge_bl').html('*按1：1比例将金象积分兑换为金象币');
    } else {
    	var score_silver = $('#score_silver_span').html();
    	$('#recharge_score_num_label').html('银象积分');
    	$('#recharge_score_num').val('');
        $('#recharge_score_num').attr('placeholder', '最大可兑换'+score_silver+'积分');
        $('#recharge_total_label').html('获得银象币');
        $('#recharge_total').val('');
        $('#pay_password').val('');
        $('#recharge_bl').html('*按1：1比例将银象积分兑换为银象币');
    }
	$('#score_type').val(score_type);
	$('#opover_recharge').addClass('active');
}

//兑换
function recharge() {
    var score_type = $('#score_type').val();
    var recharge_score_num = $('#recharge_score_num').val();
    var pay_password = $('#pay_password').val();
    if (!score_type) {
        return my_alert('fail', 0, '操作异常，刷新重试');
    }
    if (!recharge_score_num) {
    	return my_alert('recharge_score_num', 1, '请输入兑换积分数量');
    }
    if (!pay_password) {
    	return my_alert('pay_password', 1, '请输入支付密码');
    }

    $.post(base_url+"index.php/"+controller+"/recharge_score_to_total",
			{	"score_type": score_type,
    	        "recharge_score_num": recharge_score_num,
    	        "pay_password": pay_password
			},
			function(res){
				if(res.success){
                    $('#score_gold_span').html(res.data.score_gold);
                    $('#score_silver_span').html(res.data.score_silver);
                    $('#total_gold_span').html(res.data.total_gold);
                    $('#total_silver_span').html(res.data.total_silver);
                    $('#recharge_score_num').val('');
                    $('#recharge_total').val('');
                    $('#pay_password').val('');
                    $('#opover_recharge').removeClass('active');
                    my_alert('fail', 0, '兑换成功');
				}else{
					if (res.field != 'fail') {
						return my_alert(res.field, 1, res.message);
				    } else {
				    	return my_alert('fail', 0, res.message);
					}
				}
			},
			"json"
	);
}
</script>
<script type="text/javascript" language="javascript" src="js/default/main.js"></script>
    </body>
</html>








































