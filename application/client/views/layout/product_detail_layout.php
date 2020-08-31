<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<base href="<?php echo base_url(); ?>" />
<meta name="title" content="<?php echo clearstring($title); ?>" />
<meta name="keywords" content="<?php echo clearstring($keywords); ?>" />
<meta name="description" content="<?php echo clearstring($description); ?>" />
<title><?php echo $title; ?></title>
<script>
var controller = '<?php echo $this->uri->segment(1); ?>';
var method = '<?php echo $this->uri->segment(2); ?>';
var base_url = '<?php echo base_url(); ?>';
</script>
<link rel="shortcut icon" href="images/default/ico.ico?v=1.01">
<link href="css/default/goods.css" rel="stylesheet" type="text/css" />
<link href="css/default/peijian.css" rel="stylesheet" type="text/css" />
<script src="js/default/jwplayer.js"></script>
<script type="text/javascript" src="js/default/player.js"></script>
<SCRIPT src="js/default/mz-packed.js" type=text/javascript></SCRIPT>
<script type="text/javascript" src="js/default/common1.js"></script>
<script type="text/javascript" src="js/default/utils.js"></script>
<link href="css/default/commin.css" rel="stylesheet" type="text/css" />
<script src="js/default/aui-artDialog/lib/jquery-1.10.2.js"></script>
<link rel="stylesheet" href="js/default/aui-artDialog/css/ui-dialog.css">
<script src="js/default/aui-artDialog/dist/dialog-plus-min.js"></script>
<script type="text/javascript" src="js/default/jquery-lazyload.js"></script>
<script type="text/javascript" src="js/default/jquery.json.js"></script>
<script type="text/javascript" src="js/default/transport2.js"></script>
<script type="text/javascript" src="js/default/scrollpic.js"></script>
</head>
<body class="root_body" style="background:#f4f4f4">
<?php echo $this->load->view('element/header_tool', '', TRUE); ?>
<?php echo $this->load->view('element/navigation_tool', '', TRUE); ?>
<SCRIPT src="js/default/gw_totop.js" type=text/javascript></SCRIPT>
<?php echo $content; ?>
<?php echo $this->load->view('element/footer_tool', '', TRUE); ?>
<?php echo $this->load->view('element/qq_service_tool', '', TRUE); ?>
<script type="text/javascript" charset="utf-8">
  $(function() {
      $("img.lazy").lazyload({effect: "fadeIn"});
  });
</script>
<script type="text/javascript">
$(".goods .list").each(function(){
	var self = $(this), delay;
	self.mouseover(function(){
		self.addClass("hover");
		delay = setTimeout(function(){ delay = null; self.find(".Woqu_68").stop().animate({"bottom":0}, 300);},300);
	}).mouseout(function(){
		self.removeClass("hover");
		if(delay){
			clearTimeout(delay);
		}else{
			setTimeout(function(){self.find(".Woqu_68").stop().animate({"bottom":-70}, 300);},300);
		}
	});
});
</script>
<script language="JavaScript" type="text/javascript">
<!--
function deleteCookie(name){
var date=new Date();
date.setTime(date.getTime()-10000);
document.cookie=name+"=v; expires="+date.toGMTString();
}
//-->
</script>
<script>
if ( cookiedata.indexOf("shaixuan_on=done") > 0 )
{
	$('#close-sidebar').removeClass("shaixuan_on");
	$(".sidebar").animate({left: '-289px'}, "slow");
	$("#close-sidebar").animate({left: '0px'}, "slow");
	$('#content').animate({width: "1210px"}, "slow");
	$(".goods .list:nth-child(3n)").removeClass("first");
	$(".goods .list:nth-child(4n)").addClass("first");


}
else
{
	$('#close-sidebar').addClass("shaixuan_on");
	$(".sidebar").animate({left: '0px'}, "slow");
	$("#close-sidebar").animate({left: '289px'}, "slow");
	$('#content').animate({width: "903px"}, "slow");
	$(".goods .list:nth-child(4n)").removeClass("first");
	$(".goods .list:nth-child(3n)").addClass("first");
}
$('#close-sidebar').click(function(){
if($(this).hasClass("shaixuan_on")){
	$(this).removeClass("shaixuan_on");
 	$(".sidebar").animate({left: '-289px'}, "slow");
	$("#close-sidebar").animate({left: '0px'}, "slow");
	$('#content').animate({width: "1210px"}, "slow");
	$(".goods .list:nth-child(3n)").removeClass("first");
	$(".goods .list:nth-child(4n)").addClass("first");
		setCookie1("shaixuan_on", "done" , 7);
}else
{
	$(this).addClass("shaixuan_on");
	$(".sidebar").animate({left: '0px'}, "slow");
	$("#close-sidebar").animate({left: '289px'}, "slow");
	$('#content').animate({width: "903px"}, "slow");
	$(".goods .list:nth-child(4n)").removeClass("first");
	$(".goods .list:nth-child(3n)").addClass("first");
	deleteCookie("shaixuan_on");
	}
});
</script>
<script src="js/default/category_wide_b.min.js"></script>
</body>
</html>