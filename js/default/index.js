function my_alert(field, is_focus, msg) {
	if (is_focus == 1) {
		$('#'+field).focus();
	}
	var d = dialog({
		fixed: true,
		width:300,
	    title: '提示',
	    content: msg
	});
	d.show();
	setTimeout(function () {
	    d.close().remove();
	}, 3000);
	return false;
}

function my_alert_flush(field, is_focus, msg) {
	if (is_focus == 1) {
		$('#'+field).focus();
	}
	var d = dialog({
		fixed: true,
		width:300,
	    title: '提示',
	    content: msg
	});
	d.show();
	setTimeout(function () {
		window.location.reload();
	    d.close().remove();
	}, 3000);
	return false;
}

function my_alert_url(url, msg) {
	var d = dialog({
		fixed: true,
		width:300,
	    title: '提示',
	    content: msg
	});
	d.show();
	setTimeout(function () {
		window.location.href=url;
	    d.close().remove();
	}, 3000);
}
$(document).ready(function () {
    /****添加/编辑****/
    var flag = false;
    /****添加/编辑****/
    $('#jsonForm').ajaxForm({
        dataType: 'json',
        beforeSubmit: showRequest,
        success: showReponse
    });
    function showReponse(data) {
        if (data && data.success) {
            if (data.field == 'success_login_go') {
                flag = false;
                var d = dialog({
                    width: 300,
                    title: '提示',
                    fixed: true,
                    content: '恭喜您登录成功'
                });
                d.show();
                setTimeout(function () {
                    window.location.href = data.message;
                    d.close().remove();
                }, 2000);
                return false;
            } else if (data.field == 'success_get_pass') {
                flag = false;
                var d = dialog({
                    width: 300,
                    title: '提示',
                    fixed: true,
                    content: data.message
                });
                d.show();
                setTimeout(function () {
                    window.location.href = base_url + 'index.php/user/login.html';
                    d.close().remove();
                }, 2000);
                return false;
            } else if (data.field == 'success_back') {
                flag = false;
                $("#id_card").val("");
                $("#id_pass").val("");
                var d = dialog({
                    width: 300,
                    title: '提示',
                    fixed: true,
                    content: data.message
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
                return false;
            } else {
                flag = false;
                var d = dialog({
                    width: 300,
                    title: '提示',
                    fixed: true,
                    content: data.message
                });
                d.show();
                setTimeout(function () {
                    if (data.field == 'success') {
                        window.location.reload();
                    } else {
                        window.location.href = data.field;
                    }
                    d.close().remove();
                }, 2000);
                return false;
            }
            return false;
        } else {
            flag = false;
            if (data.field == 'fail_task_recharge') {
                var d = dialog({
                    title: '提示',
                    width: 300,
                    fixed: true,
                    content: data.message,
                    okValue: '确定',
                    ok: function () {
                        window.open(base_url + "index.php/user/advance.html");
                    }
                });
                d.show();
            } else {
                var d = dialog({
                    title: '提示',
                    width: 300,
                    fixed: true,
                    content: data.message,
                    okValue: '确定',
                    ok: function () {
                        if (data.field == 'code_fail') {
                            $("#valid_code_pic").click();
                        }
                        $("#" + data.field).focus();
                    },
                    cancelValue: '取消',
                    cancel: function () {
                        if (data.field == 'code_fail') {
                            $("#valid_code_pic").click();
                        }
                        $("#" + data.field).focus();
                    }
                });
                d.show();
                $("#" + data.field).focus();
            }
            return false;
        }
    }
    function showRequest() {
        if (flag == true) {
            return false;
        }
        if (validator(document.forms['jsonForm'])) {
            flag = true;
            return true;
        } else {
            flag = false;
            return false;
        }
    }
    $(".promo_content").hover(function(){
        $(this).addClass('promo_hover');
        $(this).find('.invisible').stop().slideDown(100);
    },function(){
        $(this).removeClass('promo_hover');
        $(this).find('.invisible').stop().slideUp(100);
    })
});
//最新动态,活动信息
function showNews(id) {
    if (id == 'announcements') {
        $('#announcements').attr("class", "cur");
        $('#newss').attr("class", "air");
        $('#announcement').show();
        $('#news').hide();
    } else {
        $('#announcements').attr("class", "air");
        $('#newss').attr("class", "cur");
        $('#announcement').hide();
        $('#news').show();
    }
}
//新品上市
function showXinPin(id) {
    for (i = 1; i < 5; i++) {
        $('#xinpin_' + i).attr("class", "");
        $('#xinpin_' + i + '_s').hide();
    }
    $('#' + id).attr("class", "on");
    $('#' + id + '_s').show();
}
//显示分类
function showCategory(id) {
    for (i = 0; i < 6; i++) {
        $('#category_' + i).hide();
    }
    $('#' + id).show();
}
//选择尺码
function select_size(_this, size_id, product_id) {
    $("#selectSize a").removeClass('hovered');
    $(_this).find('a').addClass('hovered');
    $("#spec_size_id").val(size_id);
    if ($("#selectColor a.hovered").length > 0) {
        var color_id = $("#selectColor a.hovered").data('color_id');
        getStock(product_id, color_id, size_id);
    }
}
//选择颜色
function select_color(_this, color_id, product_id) {
    $("#selectColor a").removeClass('hovered');
    $(_this).find('a').addClass('hovered');
    $("#spec_color_id").val(color_id);
    if ($("#selectSize a.hovered").length > 0) {
        var size_id = $("#selectSize a.hovered").data('size_id');
        getStock(product_id, color_id, size_id);
    }
}
//获取库存
function getStock(product_id, color_id, size_id) {
    $.post(base_url + 'index.php/product/getStock', {'product_id': product_id, 'color_id': color_id, 'size_id': size_id}, function (data) {
        if (data.success === false) {
            var d = dialog({
                fixed: true,
                title: '提示',
                content: data.message
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);
            return false;
        }
        if (data.data.stock <= 0) {
            $("#stock").css('color', '#e61d47');
            var d = dialog({
                width: 300,
                title: '提示',
                fixed: true,
                content: '已售空，请选择其他款式'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);

        } else {
            $("#stock").removeAttr('style');
        }
        $("#stock").html("库存：" + data.data.stock);
        $("#sellPrice").html("<small>¥</small>" + data.data.price);
    }, 'json');
}