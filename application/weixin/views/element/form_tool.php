<style>
    .go_top{
        width:52px;
        height:52px;
        background:url(images/default/jiameng/goTop.png) no-repeat center center #fff;
        background-size:100%;
        position:fixed;
        right:15px;
        bottom:50px;
        z-index:100;
        cursor:pointer;
        display:none;
        border-radius: 100%;
    }
</style>
<div class="contentbox9 contentbox">
    <div class="contentbox-top">
        <h1><span>成功属于早行动、敢行动的人<br>一条留言,一次投资,终生收益</span>
            <p style="background:#fcfcfc;margin:0;height:1px;position:absolute;border-bottom:0; width:70%;left:15%; "></p>
        </h1>
        <h3>咨询加盟政策，更多惊喜等你来拿！</h3>
    </div>
    <div class="contentbox-center">
        <div class="mui-input-row">
            <label>姓名:</label>
            <input id="name" type="text" placeholder="">
        </div>
        <div class="mui-input-row">
            <label>电话:</label>
            <input id="phone" type="text" placeholder="">
        </div>
        <div class="mui-input-row">
            <label>地址:</label>
            <input id="adress" type="text" placeholder="">
        </div>
        <div class="mui-input-row">
            <label>留言:</label>
            <textarea id="info" name="" rows="" cols=""></textarea>
        </div>
        <button type="button" onclick="submitClick();" class="mui-btn">提交</button>
    </div>
    <div class="contentbox-bottom" style="margin-top:10px;font-size:8px;">投资有风险，适合自己的才是最好的！</div>
    <div class="contentbox-bottom" style="margin-top:10px;">*电话（手机）只有管理员才能看见！请放心填写！</div>
</div>
<div id="loading"></div>
<style>
    #loading{
        position:fixed;
        top:0px;
        left:0px;
        z-index:1000;
        width:100%;
        height:100%;
        background:url(images/default/loading_2.gif) no-repeat center center rgba(0,0,0,.3);
        display:none;
    }
</style>
<script src="js/weixin/mui/js/mui.js"></script>
<script src="js/weixin/mui/js/index.js" type="text/javascript" charset="UTF-8"></script>
<script src="js/weixin/mui/js/template-native.js" type="text/javascript" charset="utf-8"></script>
<script src="js/weixin/mui/js/jquery.js" type="text/javascript" charset="UTF-8"></script>
<script src="js/weixin/mui/js/immersed.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

            var base_url = '<?php echo base_url(); ?>index.php/';
            window.onload = function () {
                $("#goTop").click(function () {
                    $('body,html').animate({scrollTop: 0}, 500);
                });
                $(window).scroll(function () {
                    if ($(this).scrollTop() > $(document).height() - $(window).height() - 200) {
                        $("#goTop").fadeIn();
                    } else {
                        $("#goTop").fadeOut();
                    }
                });
                if ($("#vedio").length == 0) {
                    return false;
                }
                get_video_path();
            }

            function get_video_path() {
                if (!network) {
                    mui.alert("世界最遥远的距离莫过于断网，请检查网络设置", "提示：");
                    return;
                }
                var url = base_url + 'comapi/get_video_path';
                mui.ajax(url, {
                    data: {},
                    dataType: "json",
                    type: "get",
                    timeout: 10000,
                    success: function (res) {
                        console.log(JSON.stringify(res));
                        if (res.success) {
                            document.getElementById('vedio').innerHTML = res.data;
                        } else {
                            mui.toast(res.message);
                        }
                    },
                    error: error
                });
            }


            function submitClick() {
                var name = document.getElementById('name').value;
                var phone = document.getElementById('phone').value;
                var adress = document.getElementById('adress').value;
                var info = document.getElementById('info').value;
                if (!name) {
                    mui.toast('请输入姓名');
                    return;
                }
                if (!/^((\(\d{2,3}\))|(\d{3}\-))?(13|14|15|16|17|18|19)\d{9}$/.test(phone)) {
                    mui.toast('请输入电话');
                    return;
                }
                if (!adress) {
                    mui.toast('请输入地址');
                    return;
                }
                if (!info) {
                    mui.toast('请输入留言');
                    return;
                }
                if (!network) {
                    mui.alert("世界最遥远的距离莫过于断网，请检查网络设置", "提示：");
                    return;
                }
                var url = base_url + 'jiameng/index';
                mui.ajax(url, {
                    data: {
                        name: name,
                        mobile: phone,
                        address: adress,
                        content: info
                    },
                    dataType: "json",
                    type: "post",
                    timeout: 10000, //超时时间设置为10秒；
                    beforeSend : function(){
                        document.getElementById('loading').style.display = 'block';
                    },
                    success: function (res) {
                        document.getElementById('loading').style.display = 'none';
                        if (res.success) {
                            mui.toast('申请加盟成功!');
                            document.getElementById('name').value = '';
                            document.getElementById('phone').value = '';
                            document.getElementById('adress').value = '';
                            document.getElementById('info').value = '';
                        } else {
                            mui.toast(res.message);
                        }
                    },
                    error: error
                });
            }
</script>