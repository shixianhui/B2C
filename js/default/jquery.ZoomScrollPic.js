(function($){
	$.fn.ZoomScrollPic = function(Objs){
		var defaults = {
			jqBox:"#scroll-box",
			box_w:120,
			Interval:4000,
			v_num:4,
			bun:true,
			autoplay:true
		}
		var Objs = $.extend(defaults,Objs);
		this.each(function(){
			var that=$(this);
			var star=0,pic_w=Objs.box_w,speed=1,count,pics_w,pics_ws,picsHTML,time,idx=0;
			count=$(that).find("li").length;
			//picsHTML=$(that).html();
			//$(that).append(picsHTML);
			$(that).find("li").eq(0).find(".pic").addClass("active");
			//pics_w=pic_w*count*2;
			//$(that).css({"width":pics_w+"px"});
			function bric(){
			star++;
			//if(star>count) {star=1;$(that).animate({"left":"0px"},0);};
			//if(star==-1) {star=count-1; pics_ws=pics_w*0.5; $(that).animate({"left":-pics_ws+"px"},0);};
			if(star<0){
				star=0;
				//alert("已是第一张");
				}
			else if( star>(count-Objs.v_num)){
				star=count-Objs.v_num;
				//alert("已是最后一张");
				}
			else{
				speed=star*-pic_w;
				$(that).stop(true,false).animate({left:speed+"px"},300);
			}
			
			}
			
			function autoplay(){time=setInterval(bric,Objs.Interval);}
			if(Objs.autoplay==true){autoplay();}
			if(Objs.bun==true){
			var bun_html="<a class='bun lbun' href='#'></a><a class='bun rbun' href='#'></a>";
			$(Objs.jqBox).prepend(bun_html);
			$(Objs.jqBox).find(".rbun").bind({
				click:function(){
					clearInterval(time);
					idx++;
					if(idx<count){
					$(that).find("li .pic").removeClass("active");
					$(that).find("li").eq(idx).find(".pic").addClass("active");
					$(that).find("li").eq(idx).find(".pic").click();
					}
					else{ idx=count-1;}
					bric();
					if(Objs.autoplay==true){autoplay();}
					return false;
					}});
			$(Objs.jqBox).find(".lbun").bind({
				click:function(){
					clearInterval(time);
					star=star-2;
					idx--;
					if(idx>-1){
					$(that).find("li .pic").removeClass("active");
					$(that).find("li").eq(idx).find(".pic").addClass("active");
					$(that).find("li").eq(idx).find(".pic").click();
					}
					else{idx=0;}
					bric();
					if(Objs.autoplay==true){autoplay();}
					return false;
					}});
				}
			
		});
	};
})(jQuery);