<div class="warp">
     <?php echo $this->load->view('element/user_menu_left_tool', '', TRUE); ?>
    <div class="member_right">
        <div class="box_shadow clearfix mt20 m_border">
            		<div class="member_title"><span class="bt">顾客积分查询</span></div>
					<div class="member_integral_select clearfix">
						<div class="input_box">
							<input type="text" name="username" id="username" placeholder="请输入顾客账号/手机号" />
							<i class="clear_num" id="clear_num" style="cursor: pointer;display:none;" onclick="javascript:clear_num();"><img src="images/default/chongzhi-close.png"/></i>
							<button onclick="javascript:select_user_score();" type="button">查询</button>
						</div>
						<div id="user_info_tit" style="display: none;" class="tit">
						    <input type="hidden" id="to_user_id">
							<div id="user_info" class="txt">
							</div>
							<button onclick="javascrpt:reduce_score();">扣积分</button>
							<button onclick="javascrpt:add_score();">返积分</button>
						</div>
					</div>
        </div>
    </div>
</div>
<div id="reduce_div" class="opover_deduction">
			<img src="images/default/chongzhibg.png"/>
			<div>
				<img onclick="javascript:$('#reduce_div').removeClass('active');" class="close_btn" src="images/default/chongzhi-close.png"/>
				<div class="select-box">
						<label for="">积分类型</label>
						<select id="reduce_score_type">
						    <option value="">-请选择积分类型-</option>
							<option value="gold">金象积分</option>
							<option value="silver">银象积分</option>
						</select>
					</div>
					<div>
						<label for="">积分数量</label>
						<input id="reduce_score" type="text" placeholder="" />
					</div>
					<div class="phone_pwd">
						<label for="">验证码</label>
						<input id="reduce_code" type="text" placeholder="" />
						<button>发送验证码</button>
					</div>
					<div><div class="button"><button onclick="javascript:reduce_user_score();" >确认扣除</button></div></div>
					<div>
						<label for="">提示内容</label>
						<textarea id="reduce_remark" placeholder="尊敬的顾客您好，您在xx店使用积分抵现服务，扣除金象积分xx分。"></textarea>
					</div>
				<div class="title">
					扣除积分
				</div>
			</div>
		</div>
		<div id="add_div" class="opover_return">
			<img src="images/default/chongzhibg.png"/>
			<div>
				<img onclick="javascript:$('#add_div').removeClass('active');" class="close_btn" src="images/default/chongzhi-close.png"/>
					<div class="select-box">
						<label for="">积分类型</label>
						<select id="add_score_type">
						    <option value="">-请选择积分类型-</option>
							<option value="gold">金象积分</option>
							<option value="silver">银象积分</option>
						</select>
					</div>
					<div>
						<label for="">积分数量</label>
						<input id="add_score" type="text" placeholder="" />
					</div>
					<div>
						<label for="">提示内容</label>
						<textarea id="add_remark" placeholder="尊敬的顾客您好，感谢您对我们xx旗舰店产品的支持与信赖，现返还您金象积分xx分，期待您的下次光临。"></textarea>
					</div>
					<div><div class="button"><button  onclick="javascript:add_user_score();">确认返还</button></div></div>
				<div class="title">
					返还积分
				</div>
			</div>
		</div>
<script type="text/javascript">
function select_user_score() {
    var username = $('#username').val();
    if (!username) {
        return my_alert('username', 1, '请输入顾客账号/手机号');
    }
    $.post(base_url+"index.php/"+controller+"/my_user_score_search",
			{	"username": username
			},
			function(res){
				if(res.success){
                    var html = '<i></i>';
                    html += '<p>账号：'+res.data.username+'</p>';
                    html += '<p>姓名：'+res.data.real_name+'</p>';
                    html += '<p>金象积分：'+res.data.score_gold+'</p>';
                    html += '<p>银象积分：'+res.data.score_silver+'</p>';
                    $('#user_info').html(html);
                    $('#user_info_tit').show();
                    $('#to_user_id').val(res.data.id);
				}else{
					return my_alert('fail', 0, res.message);
				}
			},
			"json"
	);
}

function clear_num() {
	$('#username').val('');
	$('#clear_num').hide();
}

//实时监听输入框值变化
$('#username').bind('input propertychange', function() {
	var username = $('#username').val();
	if (username) {
		$('#clear_num').show();
    }
});

//扣积分
function reduce_score() {
    $('#reduce_div').addClass('active');
    $('#add_div').removeClass('active');
}

//加积分
function add_score() {
	$('#add_div').addClass('active');
	$('#reduce_div').removeClass('active');
}

var is_reduce = false;
//扣用户积分
function reduce_user_score() {
	var to_user_id = $('#to_user_id').val();
    var reduce_score_type = $('#reduce_score_type').val();
    var reduce_score = $('#reduce_score').val();
    var reduce_code = $('#reduce_code').val();
    var reduce_remark = $('#reduce_remark').val();

    if (!to_user_id) {
    	return my_alert('fail', 0, '操作异常，请重新查询顾客信息');
    }
    if (!reduce_score_type) {
        return my_alert('reduce_score_type', 1, '请选择积分类型');
    }
    if (!reduce_score) {
        return my_alert('reduce_score', 1, '请输入积分数量');
    }
    if (!reduce_code) {
        return my_alert('reduce_code', 1, '请输入短信验证码');
    }
    if (!reduce_remark) {
        return my_alert('reduce_remark', 1, '请输入提示内容');
    }
    if (is_reduce) {
        return false;
    }
	is_reduce = true;
    $.post(base_url+"index.php/"+controller+"/my_reduce_user_score",
			{	"reduce_score_type": reduce_score_type,
		        "reduce_score": reduce_score,
		        "reduce_code": reduce_code,
		        "reduce_remark": reduce_remark,
		        "to_user_id":to_user_id
			},
			function(res){
				is_reduce = false;
				if(res.success){
					my_alert('fail', 0, '扣积分成功');

					var html = '<i></i>';
                    html += '<p>账号：'+res.data.username+'</p>';
                    html += '<p>姓名：'+res.data.real_name+'</p>';
                    html += '<p>金象积分：'+res.data.score_gold+'</p>';
                    html += '<p>银象积分：'+res.data.score_silver+'</p>';
                    $('#user_info').html(html);

                    $('#add_div').removeClass('active');
                	$('#reduce_div').removeClass('active');
				}else{
					if (res.field != 'fail') {
						return my_alert(res.field, 1, res.message);
				    } else {
				    	return my_alert('fail', 0, res.message);
					}
					return false;
				}
			},
			"json"
	);
}

//返用户积分
var is_add = false;
function add_user_score() {
	var to_user_id = $('#to_user_id').val();
	var add_score_type = $('#add_score_type').val();
    var add_score = $('#add_score').val();
    var add_remark = $('#add_remark').val();

    if (!to_user_id) {
    	return my_alert('fail', 0, '操作异常，请重新查询顾客信息');
    }
    if (!add_score_type) {
        return my_alert('add_score_type', 1, '请选择积分类型');
    }
    if (!add_score) {
        return my_alert('add_score', 1, '请输入积分数量');
    }
    if (!add_remark) {
        return my_alert('add_remark', 1, '请输入提示内容');
    }
    if (is_add) {
        return false;
    }
	is_add = true;
    $.post(base_url+"index.php/"+controller+"/my_add_user_score",
			{	"add_score_type": add_score_type,
		        "add_score": add_score,
		        "add_remark": add_remark,
		        "to_user_id":to_user_id
			},
			function(res){
				is_add = false;
				if(res.success){
					my_alert('fail', 0, '返积分成功');

					var html = '<i></i>';
                    html += '<p>账号：'+res.data.username+'</p>';
                    html += '<p>姓名：'+res.data.real_name+'</p>';
                    html += '<p>金象积分：'+res.data.score_gold+'</p>';
                    html += '<p>银象积分：'+res.data.score_silver+'</p>';
                    $('#user_info').html(html);

                    $('#add_div').removeClass('active');
                	$('#reduce_div').removeClass('active');
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