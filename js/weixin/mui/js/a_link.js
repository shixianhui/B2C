//有动画效果，有参数；列表->详细页面；传对象：格式{xx:xx,xxx:xxx};
function go_to_view(page_id, items) {
	var curWebview = plus.webview.getWebviewById(page_id);
	if(curWebview) {
		curWebview.show(aniShow, 150);
		//刷新方式
		if (page_id == 'm-new.html') {
			mui.fire(curWebview, 'go_to_parameter', items);
		} else if (page_id == 'qtzw.html') {
			var self = plus.webview.getWebviewById('qtzw-sub.html');
			mui.fire(self, 'page_init', {is_init: '1'});
		} else if (page_id == 'wsdpj.html') {
			mui.fire(curWebview, 'page_init', {is_init: '1'});
		} else {
			mui.fire(curWebview, 'go_to_parameter', items);
		}
	} else {
		var open_style = {
			popGesture: "hide"
		};
		//不显示滚动条
		if (page_id == 'hxrgl-detail.html' || page_id == 'rongyu.html') {
			open_style = {
					popGesture: "hide",
					scrollIndicator: 'none'
			};
		}
		var nativeWaiting = plus.nativeUI.showWaiting();
		curWebview = mui.preload({
			url: page_id,
			id: page_id,
			styles: open_style
		});
		curWebview.addEventListener("loaded", function() {
			nativeWaiting.close();
			curWebview.show(aniShow, 150);
			mui.fire(curWebview, 'go_to_parameter', items);
		}, false);
	}
}
//有动画效果，没有参数,如列表页面
function go_to_active(id) {
	var curWebview = plus.webview.getWebviewById(id);
	if(curWebview) {
		curWebview.show(aniShow, 150);
		if (id == 'notice.html') {
			var self = plus.webview.getWebviewById('notice-sub.html');
			mui.fire(self, 'page_init', {is_init: '1'});
		} else if (id == 'm-wdgz.html') {
			var self = plus.webview.getWebviewById('m-wdgz-sub.html');
			mui.fire(self, 'page_init', {is_init: '1'});
		} else if (id == 'cart1.html') {
			mui.fire(curWebview, 'page_init', {is_init: '1'});
		} else if (id == 'm-adder.html') {
			mui.fire(curWebview, 'refresh', {is_init: '1'});
		}
	} else {
		var open_style = {
			popGesture: "hide"
		};
		//不显示滚动条
		if (id == 'reg.html' || id == 'login.html' || id == 'index.html') {
			open_style = {
					popGesture: "none",
					scrollIndicator: 'none'
			};
		}
		var nativeWaiting = plus.nativeUI.showWaiting();
		curWebview = mui.preload({
			url: id,
			id: id,
			styles: open_style
		});
		curWebview.addEventListener("loaded", function() {
			nativeWaiting.close();
			curWebview.show(aniShow, 150);
		}, false);
	}
}
//没有动画效果，也没有参数
function go_to_active_unani(id) {
	var curWebview = plus.webview.getWebviewById(id);
	if(curWebview) {
		curWebview.show('none', 150);
	} else {
		var open_style = {
			popGesture: "hide"
		};
		var nativeWaiting = plus.nativeUI.showWaiting();
		curWebview = mui.preload({
			url: id,
			id: id,
			styles: open_style
		});
		curWebview.addEventListener("loaded", function() {
			nativeWaiting.close();
			curWebview.show('none', 150);
		}, false);
	}
}
//有参数
mui('#content').on('tap', 'a', function() {
	var item_id = this.getAttribute("item_id");
	var id = this.getAttribute('href');	
	if (id && ~id.indexOf('.html')) {
		if (id == 'm-new.html') {
			var menu_name = this.getAttribute("menu_name");
			go_to_view(id, {item_id:item_id, menu_name:menu_name});
		} else {
			go_to_view(id, {item_id:item_id});
		}		
	}
});
//没有参数
mui('#list_content').on('tap', 'a', function() {
	var id = this.getAttribute('href');
	if (id && ~id.indexOf('.html')) {
		go_to_active(id);
	}
});