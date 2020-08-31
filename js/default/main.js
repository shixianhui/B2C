(function(a){
	a.fn.hoverClass=function(b){
		var a=this;
		a.each(function(c){
			a.eq(c).hover(function(){
				$(this).addClass(b)
			},function(){
				$(this).removeClass(b)
			})
		});
		return a
	};
})(jQuery);

$(function(){
	$("#link1").hoverClass("current");
	$("#link2").hoverClass("current");
	$("#link3").hoverClass("current");
	$("#link4").hoverClass("current");
	$("#link5").hoverClass("current");
	$("#cart").hoverClass("current");
	$("#activity").hoverClass("current");
});




//产品详情推荐
jQuery(".product_recommend").slide({trigger:"click"});
$('.recommend_item li').mouseenter(function(){
			$(this).find('.mask').stop().animate({bottom:'0px',height:'40px'});
			
			
		})
		$('li').mouseleave(function(){
			$(this).find('.mask').stop().animate({bottom:'-10px',height:'0px'});
			
			
		})
		
jQuery(".product_comment").slide({});
jQuery(".limited_tab").slide({trigger:"click"});
jQuery(".no_product").slide({ mainCell:".picList", effect:"left",vis:5, pnLoop:false, scroll:1, autoPage:true});
jQuery(".bank_pay").slide({trigger:"click"});
jQuery(".member_product").slide({ mainCell:".picList", effect:"left",vis:4, pnLoop:false, scroll:1, autoPage:true});
//jQuery(".member_tab").slide({effect:"fold",trigger:"click"});
jQuery(".helpmenu").slide({titCell:"h3", targetCell:"ul",defaultIndex:0,effect:"slideDown",delayTime:300,trigger:"click"});

//首页左侧分类菜单
$(function(){
	$(".category ul.menu").find("li").each(
		function() {
			$(this).hover(
				function() {
				    var cat_id = $(this).attr("cat_id");
					var menu = $(this).find("div[cat_menu_id='"+cat_id+"']");
					menu.show();
					$(this).addClass("hover");					
					var menu_height = menu.height();
					if (menu_height < 60) menu.height(80);
					menu_height = menu.height();
					var li_top = $(this).position().top;
					$(menu).css("top",-li_top + 0);
				},
				function() {
					$(this).removeClass("hover");
				    var cat_id = $(this).attr("cat_id");
					$(this).find("div[cat_menu_id='"+cat_id+"']").hide();
				}
			);
		}
	);
	
});

//焦点图
jQuery(".fullSlide").find(function(){ jQuery(this).find(".prev,.next").stop(true,true).fadeTo("show",1) },function(){ jQuery(this).find(".prev,.next").fadeOut() });				jQuery(".fullSlide").slide({ titCell:".hd ul", mainCell:".bd ul", effect:"fold",  autoPlay:true, autoPage:true, trigger:"click",			startFun:function(i){				var curLi = jQuery(".fullSlide .bd li").eq(i); 				if( !!curLi.attr("_src") ){					curLi.css("background-image",curLi.attr("_src")).removeAttr("_src") 				}			}		});	

$(function(){
	_bodyH = $("body").height();
	$("#bg").height(_bodyH - 0);
});
var _bodyH;
var headSmallJudeg = true;
function Hover(obj, calssName) {
	obj.hover(function(){
		$(this).addClass(calssName);
	},function(){
		$(this).removeClass(calssName);
	})
}





//首页精彩活动
$('li').mouseenter(function(){
			$(this).find('.popup').stop().animate({bottom:'40px',height:'150px'});
			$(this).children('.popup').find('a.btn').css({opacity: '100'})
			
		})
		$('li').mouseleave(function(){
			$(this).find('.popup').stop().animate({bottom:'30px',height:'110px'});
			$(this).children('.popup').find('a.btn').css({opacity: '0'})
			
		})

 //选择删除复选框 
$("span[name='checkWeek']").click(function(){ 
if($(this).hasClass('CheckBoxSel')){ 
$(this).removeClass('CheckBoxSel'); 
}else{ 
$(this).addClass('CheckBoxSel'); 
} 
}); 

//首页左侧楼层快捷
$(function () {
$('.side_l_pop li').hover(function(){
                    $(this).addClass('hover');
                },function(){
                    $(this).removeClass('hover');
                });

                var _tlen = $('.titlebar').length;
                for (var i = 0; i < _tlen; i++) {
                    $($('.titlebar').get(i)).attr('index',i);
                };

                $('.side_l_pop li').on('click',function(){
                    $('.side_l_pop li').not($(this).addClass('on')).removeClass('on');
                    var top = document.documentElement.scrollTop || document.body.scrollTop;
                    var index = $(this).index();
                    var _dtop = $($('.titlebar').get(index)).offset().top;

                    if (top > _dtop) {
                        setInterval(function(){
                            if (top > _dtop) {
                                top -= 100;
                                if((top - _dtop) <=100 ){
                                    $(window).scrollTop(_dtop);
                                }else{
                                    $(window).scrollTop(top);
                                }
                            };
                        },1);
                    };
                    if(top <= _dtop){
                        setInterval(function(){
                            if (top < _dtop) {
                                top += 100;
                                if((_dtop-top) <=100 ){
                                    $(window).scrollTop(_dtop);
                                }else{
                                    $(window).scrollTop(top);
                                }
                            };
                        },1);
                    }
                });

                var out_top = document.documentElement.scrollTop || document.body.scrollTop;
                if($('.topic_list').length > 0){
                    var out_tag_top = $('.topic_list').offset().top;
                if(out_top > out_tag_top){
                    $('.side_l_pop').fadeIn();
                }else{
                    $('.side_l_pop').fadeOut();
                };
                }
                

                var _body_w = $('body').width();
                if (_body_w <= 1270) {
                    $('.side_l_pop').css({'left':'0','margin-left':'0'});
                }else{
                    $('.side_l_pop').css({'left':'50%','margin-left':'-680px'});
                };

                
                $(window).scroll(function(){
                    if($('.topic_list').length == 0){
                          return false;
                    }
                    var top = document.documentElement.scrollTop || document.body.scrollTop;

                    var tag_top = $('.topic_list').offset().top;

                    var hd_top = $('#bd').offset().top;

              

                    if(top > tag_top){
                        $('.side_l_pop').fadeIn();
                    }else{
                        $('.side_l_pop').fadeOut();
                    }

                    $('.titlebar').each(function () {
                        var _top = $(this).offset().top - 100;
                        var _height = $(this).parent().height();
                        if ((_top - top) <= 0 && (_top + _height) > top) {
                            var index = parseFloat($(this).attr('index'));
                            $('.side_l_pop li').not($($('.side_l_pop li').get(index)).addClass('on')).removeClass('on');
                        };
                    });

                   

                });

               
              
			  $('.go_top a').on('click',function(){
                    var top = document.documentElement.scrollTop || document.body.scrollTop;
                    setInterval(function(){
                        if (top > 10) {
                            top -= 40;
                            $(window).scrollTop(top);
                        };
                    },1);
                });
			  
        });




//产品分类筛选
$('.filter dl dd span').on('click',function(){
	var parent = $(this).parent();
	if( !parent.hasClass('hover') ){
		parent.addClass('hover')
		$(this).html(
			$(this).html().replace('收起','更多')
				.replace('icon_shouqi','icon_zhankai') 
		);
	}else{
		parent.removeClass('hover');
		$(this).html( 
			$(this).html().replace('更多','收起')
				.replace('icon_zhankai','icon_shouqi')
		);
	}
})
$(function(){
	$('.filter dl dd span').each(function(){
		var dd = $(this).parent();
		if( dd.height() > 65 ){
			$(this).show();
			dd.addClass('hover');
		}else{
			$(this).hide()
		}
	})	
});





