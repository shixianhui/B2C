(function(w) {
	var immersed = 0;
	var ms = (/Html5Plus\/.+\s\(.*(Immersed\/(\d+\.?\d*).*)\)/gi).exec(navigator.userAgent);
	if(ms && ms.length >= 3) {
		immersed = parseFloat(ms[2]);
	}
	w.immersed = immersed;
	if(immersed) {
		$('#header').attr('style', "height:"+(44+immersed)+'px;padding-top: '+immersed+'px;');
		$('.mui-bar-nav~.mui-content').attr('style', 'padding-top:' + (44 + immersed) + 'px');
	}
})(window);