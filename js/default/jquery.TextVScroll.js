(function($){
	$.fn.TextVScroll = function(Objs){
    
		var defaults = {
			Interval:3000,
			box_h:50
		}
		var Objs = $.extend(defaults,Objs);
		this.each(function(){
			var that=$(this);
			var star=0,speed=1,T_max,T_HTML,times;
			var JQUL=$(that).find("ul");
			var JQLI=$(JQUL).find("li");
			T_max=$(JQLI).length;
			T_HTML=$(JQUL).html();
			$(JQUL).append(T_HTML);
		function bric(){
			star++;
			if(star>T_max) {star=1;$(JQUL).animate({"top":"0px"},0);};
			speed=(star)*-Objs.box_h;
			$(JQUL).animate({top:speed+"px"});
			}
		times=setInterval(bric,Objs.Interval);
	
		});
	};
})(jQuery);
(function($){
	$.fn.billBoard = function(Objs){
    
		var defaults = {
			Interval:3000,
			box_h:92
		}
		var Objs = $.extend(defaults,Objs);
		this.each(function(){
			var that=$(this);
			var star=0,speed=1,T_max,T_HTML,times;
			var JQUL=$(that).find("ul");
			var JQLI=$(JQUL).find("li");
			T_max=$(JQLI).length;
			T_HTML=$(JQUL).html();
			$(JQUL).append(T_HTML);
		function bric(){
			star++;
			if(star>T_max) {star=1;$(JQUL).animate({"top":"0px"},0);};
			speed=(star)*-Objs.box_h;
			$(JQUL).animate({top:speed+"px"});
			}
		times=setInterval(bric,Objs.Interval);
	
		});
	};
})(jQuery);
(function($){
	$.fn.shareScroll = function(Objs){
    
		var defaults = {
			Interval:3000,
			box_h:155,
		}
		var Objs = $.extend(defaults,Objs);
		this.each(function(){
			var that=$(this);
			var star=0,speed=1,T_max,T_HTML,times;
			var JQUL=$(that).find("ul");
			var JQLI=$(JQUL).find("li");
			T_max=$(JQLI).length;
			T_HTML=$(JQUL).html();
			$(JQUL).append(T_HTML);
		function bric(){
			star++;
			if(star>T_max) {star=1;$(JQUL).animate({"top":"0px"},0);};
			speed=(star)*-Objs.box_h;
			$(JQUL).animate({top:speed+"px"});
			}
		times=setInterval(bric,Objs.Interval);
	
		});
	};
})(jQuery);