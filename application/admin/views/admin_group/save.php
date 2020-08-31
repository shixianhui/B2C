<?php echo $tool; ?>
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
	<tr>
      <th width="20%">
      <font color="red">*</font> <strong>部门名称</strong> <br/>
	  </th>
      <td>
      <input name="id" id="id" value="<?php if(! empty($itemInfo)){ echo $itemInfo['id'];} ?>" type="hidden">
      <input class="input_blur" name="group_name" id="group_name" value="<?php if(! empty($itemInfo)){ echo $itemInfo['group_name'];} ?>" size="50" maxlength="50" type="text">
	</td>
    </tr>
    <tr>
      <th width="20%">
      <font color="red">*</font> <strong>设置权限</strong> <br/>
	  </th>
      <td>
      <font color="red">注：查看权限优先；删除，修改等权限一般在列表上才能看到</font><br/>
      <div id="permissions_tree"></div>
	</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="btn_admin_group_save" id="btn_admin_group_save" value=" 保存 " type="button">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</div>
<script type="text/javascript" src="js/admin/jquery.tree.js"></script>
<script type="text/javascript" src="js/admin/jquery.tree.checkbox.js"></script>
<script>
    //==================================管理员组权限====================================
	var permissions = "<?php if(! empty($itemInfo)){ echo $itemInfo['permissions'];} ?>".split(',');
    var permissionsList = [{
		data: '网站管理',
		attributes:{'permission':'content_manage'},
		state: "close",
		children:[{
					data: '频道管理 ',
					attributes:{'permission':'menu'},
					state: "open",
					children:[{data: '查看',attributes:{'permission':'menu_menuList'}},
						  	  {data: '添加',attributes:{'permission':'menu_add'}},
					          {data: '修改',attributes:{'permission':'menu_edit'}},
					          {data: '删除',attributes:{'permission':'menu_delete'}},
					          {data: '排序',attributes:{'permission':'menu_sort'}}]
				},
			  	<?php if ($patternList) { ?>
			  	<?php foreach ($patternList as $key=>$value) {
			  	      $str_class = ',';
			  	      if (count($patternList) == $key+1) {
			  	          $str_class = '';
			  	      }
			  	    ?>
			  		{
			       data: '<?php echo $value['title']; ?>',
				   attributes:{'permission':'<?php echo $value['file_name']; ?>'},
				   state: "open",
				   children:[
                             <?php if ($value['file_name'] == 'sitemap') { ?>
                             {data: '查看',attributes:{'permission':'<?php echo $value['file_name']; ?>_index'}}
                             <?php } else if ($value['file_name'] == 'guestbook') { ?>
                             {data: '查看',attributes:{'permission':'<?php echo $value['file_name']; ?>_index'}},
				             {data: '修改',attributes:{'permission':'<?php echo $value['file_name']; ?>_edit'}},
				             {data: '删除',attributes:{'permission':'<?php echo $value['file_name']; ?>_delete'}}
                             <?php } else { ?>
							 {data: '查看',attributes:{'permission':'<?php echo $value['file_name']; ?>_index'}},
						     {data: '添加',attributes:{'permission':'<?php echo $value['file_name']; ?>_add'}},
				             {data: '修改',attributes:{'permission':'<?php echo $value['file_name']; ?>_edit'}},
				             {data: '删除',attributes:{'permission':'<?php echo $value['file_name']; ?>_delete'}}
				             <?php if ($value['file_name'] != 'link' && $value['file_name'] != 'job' && $is_html) { ?>
				             ,
				             {data: '查看html',attributes:{'permission':'<?php echo $value['file_name']; ?>_html'}},
				             {data: '更新html',attributes:{'permission':'<?php echo $value['file_name']; ?>_htmlUpdate'}},
				             {data: '删除html',attributes:{'permission':'<?php echo $value['file_name']; ?>_htmlDelete'}}
				             <?php }} ?>
				             ]
			      }
                <?php echo $str_class; }} ?>
			      ]
		},{
			data: '商品管理 ',
			attributes:{'permission':'product_manage'},
			state: "close",
			children:[{
				    data: '场馆管理',
					attributes:{'permission':'product_venue'},
					state: "open",
					children:[{data: '查看',attributes:{'permission':'product_venue_index'}},
		                      {data: '添加',attributes:{'permission':'product_venue_add'}},
		                      {data: '修改',attributes:{'permission':'product_venue_edit'}},
		                      {data: '删除',attributes:{'permission':'product_venue_delete'}}]
				   },{
				    data: '分类管理',
					attributes:{'permission':'product_category'},
					state: "open",
					children:[{data: '查看',attributes:{'permission':'product_category_index'}},
		                      {data: '添加',attributes:{'permission':'product_category_add'}},
		                      {data: '修改',attributes:{'permission':'product_category_edit'}},
		                      {data: '删除',attributes:{'permission':'product_category_delete'}}]
				   },{
	                    data: '品牌管理',
	                    attributes:{'permission':'brand'},
	                    state : "open",
	                    children:[{data: '查看',attributes:{'permission':'brand_index'}},
	                              {data: '添加',attributes:{'permission':'brand_add'}},
	                              {data: '修改',attributes:{'permission':'brand_edit'}},
	                              {data: '删除',attributes:{'permission':'brand_delete'}}]
	               }
            ]
		},{
			data: '店铺管理',
			attributes:{'permission':'store_manage'},
			state: "close",
			children:[{
				    data: '店铺模板管理',
					attributes:{'permission':'theme'},
					state: "open",
					children:[{data: '查看',attributes:{'permission':'theme_index'}},
		                      {data: '添加',attributes:{'permission':'theme_add'}},
		                      {data: '修改',attributes:{'permission':'theme_edit'}},
		                      {data: '删除',attributes:{'permission':'theme_delete'}}]
				   },{
					    data: '店铺等级',
						attributes:{'permission':'store_grade'},
						state: "open",
						children:[{data: '查看',attributes:{'permission':'store_grade_index'}},
			                      {data: '添加',attributes:{'permission':'store_grade_add'}},
			                      {data: '修改',attributes:{'permission':'store_grade_edit'}},
			                      {data: '删除',attributes:{'permission':'store_grade_delete'}}]
				  },{
	                    data: '店铺分类',
	                    attributes:{'permission':'store_category'},
	                    state : "open",
	                    children:[{data: '查看',attributes:{'permission':'store_category_index'}},
	                              {data: '添加',attributes:{'permission':'store_category_add'}},
	                              {data: '修改',attributes:{'permission':'store_category_edit'}},
	                              {data: '删除',attributes:{'permission':'store_category_delete'}}]
	               },{
	                    data: '店铺管理',
	                    attributes:{'permission':'store'},
	                    state : "open",
	                    children:[{data: '查看',attributes:{'permission':'store_index'}},
	                              {data: '添加',attributes:{'permission':'store_add'}},
	                              {data: '修改',attributes:{'permission':'store_edit'}},
	                              {data: '删除',attributes:{'permission':'store_delete'}}]
	               }
            ]
		},{
			data: '交易管理',
			attributes:{'permission':'orders'},
			state: "close",
			children:[{
                        data: '订单列表 ',
                        attributes:{'permission':'orders_manage'},
                        state: "open",
                        children:[
	                          {data: '查看列表',attributes:{'permission':'orders_index'}},
	                          {data: '查看详细',attributes:{'permission':'orders_view'}},
	                          {data: '删除',attributes:{'permission':'orders_delete'}},
	                          {data: '修改价格',attributes:{'permission':'orders_change_price'}},
	                          {data: '交易关闭',attributes:{'permission':'orders_close_order'}},
	                          {data: '修改状态',attributes:{'permission':'orders_change_pay'}},
	                          {data: '发货',attributes:{'permission':'orders_delivery'}},
	                          {data: '收货',attributes:{'permission':'orders_receiving'}},

	    	    			  {data: '查看物流',attributes:{'permission':'orders_logistics'}}
    	    			  ]
                   },{
                        data: '退换货申请管理',
                        attributes:{'permission':'exchange_manage'},
                        state: "open",
                        children:[{data: '查看',attributes:{'permission':'exchange_index'}},
                                  {data: '处理',attributes:{'permission':'exchange_edit'}},
                                  {data: '删除',attributes:{'permission':'exchange_delete'}}]
                 },{
         			data: '商品评价列表',
        			attributes:{'permission':'comment_manage'},
        			state: "open",
        			children:[{data: '查看',attributes:{'permission':'comment_index'}},
                              {data: '修改',attributes:{'permission':'comment_edit'}},
                              {data: '删除',attributes:{'permission':'comment_delete'}}]
        		},{
        			data: '用户提醒发货',
        			attributes:{'permission':'user_message_manage'},
        			state: "open",
        			children:[{data: '查看',attributes:{'permission':'user_message_index'}},
                              {data: '删除',attributes:{'permission':'user_message_delete'}}]
        		}
            ]
		},{
	        data: '员工管理',
			attributes:{'permission':'admin_manage'},
			state: "close",
			children:[{
				       data: '管理员列表',
				       attributes:{'permission':'admin'},
				       state: "open",
				       children:[{data: '查看',attributes:{'permission':'admin_index'}},
							     {data: '添加',attributes:{'permission':'admin_add'}},
							     {data: '修改',attributes:{'permission':'admin_edit'}},
							     {data: '删除',attributes:{'permission':'admin_delete'}}]
			          },{
				       data: '管理组列表',
				       attributes:{'permission':'admin_group'},
				       state: "open",
		               children:[{data: '查看',attributes:{'permission':'admin_group_index'}},
			      	             {data: '添加',attributes:{'permission':'admin_group_add'}},
					             {data: '修改',attributes:{'permission':'admin_group_edit'}},
					             {data: '删除',attributes:{'permission':'admin_group_delete'}}]
					 }]
		},{
		    data: '会员管理 ',
			attributes:{'permission':'user_g'},
			state: "close",
			children:[{
    			data: '会员列表',
    			attributes:{'permission':'user'},
    			state: "open",
    			children:[{data: '查看所有会员列表',attributes:{'permission':'user_index'}},
    			          {data: '查看普通会员列表',attributes:{'permission':'user_index_0'}},
    			          {data: '查看商家会员列表',attributes:{'permission':'user_index_1'}},
    			          {data: '添加',attributes:{'permission':'user_add'}},
    			          {data: '修改',attributes:{'permission':'user_edit'}},
    			          {data: '删除',attributes:{'permission':'user_delete'}},
    			          {data: '详细',attributes:{'permission':'user_view'}},
    			          {data: '会员充值',attributes:{'permission':'financial_recharge'}},
    			          {data: '会员扣款',attributes:{'permission':'financial_debit'}},
    			          {data: '会员财务记录',attributes:{'permission':'financial_index'}},
    			          {data: '加盟申请列表',attributes:{'permission':'jiameng_index'}},
    			          {data: '店级合伙人审核',attributes:{'permission':'user_index_10'}},
    			          {data: '校园二级分销商审核',attributes:{'permission':'user_index_20'}},
    			          {data: '网络二级分销商审核',attributes:{'permission':'user_index_30'}}]
    		},{
    			data: '会员组列表',
    			attributes:{'permission':'usergroup'},
    			state: "open",
    			children:[{data: '查看',attributes:{'permission':'usergroup_index'}},
    	    			  {data: '添加',attributes:{'permission':'usergroup_add'}},
    	    			  {data: '修改',attributes:{'permission':'usergroup_edit'}},
    	    			  {data: '删除',attributes:{'permission':'usergroup_delete'}}]
    		},{
    			data: '金/银象币消费管理',
    			attributes:{'permission':'elephant_log_manage'},
    			state: "open",
    			children:[{data: '查看',attributes:{'permission':'elephant_log_index'}},
    	    			  {data: '充值',attributes:{'permission':'elephant_log_recharge'}},
    	    			  {data: '扣款',attributes:{'permission':'elephant_log_debit'}}]
    		},{
    			data: '积分消费管理',
    			attributes:{'permission':'score_manage'},
    			state: "open",
    			children:[{data: '查看',attributes:{'permission':'score_index'}},
    	    			  {data: '充值',attributes:{'permission':'score_recharge'}},
    	    			  {data: '扣款',attributes:{'permission':'score_debit'}}]
    		},{
    			data: '第三方支付记录管理',
    			attributes:{'permission':'pay_log'},
    			state: "open",
    			children:[{data: '查看',attributes:{'permission':'pay_log_index'}},
    			          {data: '处理',attributes:{'permission':'pay_log_edit'}}]
    		},{
    			data: '金/银象币提现管理',
    			attributes:{'permission':'withdraw'},
    			state: "open",
    			children:[{data: '查看',attributes:{'permission':'withdraw_index'}},
    					  {data: '处理',attributes:{'permission':'withdraw_edit'}}]
    		},{
                data: '信息反馈列表',
                attributes:{'permission':'guestbook'},
                state: "open",
                children:[{data: '查看',attributes:{'permission':'guestbook_index'}},
                    {data: '修改',attributes:{'permission':'guestbook_edit'}},
                    {data: '删除',attributes:{'permission':'guestbook_delete'}}]
            }]
		},{
		    data: '广告管理  ',
			attributes:{'permission':'ad_manage'},
			state: "close",
			children:[{
				       data: '广告内容管理',
				       attributes:{'permission':'ad'},
				       state: "open",
				       children:[{data: '查看',attributes:{'permission':'ad_index'}},
							     {data: '添加',attributes:{'permission':'ad_add'}},
							     {data: '修改',attributes:{'permission':'ad_edit'}},
							     {data: '删除',attributes:{'permission':'ad_delete'}},
							     {data: '排序',attributes:{'permission':'ad_sort'}}]
			          },{
				       data: '广告位管理',
				       attributes:{'permission':'ad_group'},
				       state: "open",
		               children:[{data: '查看',attributes:{'permission':'ad_group_index'}},
			      	             {data: '添加',attributes:{'permission':'ad_group_add'}},
					             {data: '修改',attributes:{'permission':'ad_group_edit'}},
					             {data: '删除',attributes:{'permission':'ad_group_delete'}}]
					 }]
		},{
			data: '营销活动管理',
			attributes:{'permission':'promotion'},
			state: "close",
			children:[
                            {data: '查看拼团活动',attributes:{'permission':'promotion_ptkj_index'}},
                            {data: '添加拼团活动',attributes:{'permission':'promotion_ptkj_add'}},
                            {data: '修改拼团活动',attributes:{'permission':'promotion_ptkj_edit'}},
                            {data: '删除拼团活动',attributes:{'permission':'promotion_ptkj_delete'}},
                            {data: '限时抢购活动查看',attributes:{'permission':'flash_sale_index'}},
                            {data: '限时抢购活动添加',attributes:{'permission':'flash_sale_add'}},
                            {data: '限时抢购活动修改',attributes:{'permission':'flash_sale_edit'}},
                            {data: '限时抢购活动删除',attributes:{'permission':'flash_sale_delete'}}]
		},{
			data: '机器人管理',
			attributes:{'permission':'robot'},
			state: "close",
			children:[
                            {data: '机器人账号批量注册',attributes:{'permission':'robot_import'}},
                            {data: '拼团砍价机器人设置',attributes:{'permission':'robot_ptkj'}},
                            {data: '限时抢购活动机器人设置',attributes:{'permission':'robot_xsqg'}}]
		},{
			data: '生成静态 ',
			attributes:{'permission':'html'},
			state: "close",
			children:[{data: '生成静态 ',attributes:{'permission':'html_index'}}]
		},{
			data: '系统管理',
			attributes:{'permission':'system'},
			state: "close",
			children:[{
			       data: '系统设置',
			       attributes:{'permission':'system_manage'},
			       state: "open",
			       children:[{data: '基本设置',attributes:{'permission':'system_save'}},
		               {data: '楼层管理设置',attributes:{'permission':'floor_save'}},
					         {data: '图片水印设置',attributes:{'permission':'watermark_save'}},
					         {data: '积分设置',attributes:{'permission':'score_setting'}},
					         {data: '分销商推广页面设置',attributes:{'permission':'presenter_text'}},
					         {data: 'APP更新',attributes:{'permission':'system_update'}},
					         {data: '订单基本设置',attributes:{'permission':'system_configure_order'}},
					         {data: '登录日志管理',attributes:{'permission':'system_login_log_index'}},
					         {data: '包邮条件设置',attributes:{'permission':'free_postage_setting_edit'}}]
		          },{
				       data: '配送地区管理',
				       attributes:{'permission':'area'},
				       state: "open",
		               children:[{data: '查看',attributes:{'permission':'area_index'}},
		                         {data: '添加',attributes:{'permission':'area_add'}},
		                         {data: '修改',attributes:{'permission':'area_edit'}},
		                         {data: '删除',attributes:{'permission':'area_delete'}}]
				  },{
				       data: '配送方式管理',
				       attributes:{'permission':'postage_way'},
				       state: "open",
		               children:[ {data: '查看',attributes:{'permission':'postage_way_index'}},
		                          {data: '添加',attributes:{'permission':'postage_way_add'}},
		                          {data: '修改',attributes:{'permission':'postage_way_edit'}},
		                          {data: '删除',attributes:{'permission':'postage_way_delete'}}]
				  },{
				       data: '支付方式管理',
				       attributes:{'permission':'payment_way'},
				       state: "open",
		               children:[
			  		           {data: '查看',attributes:{'permission':'payment_way_index'}},
                               {data: '添加',attributes:{'permission':'payment_way_add'}},
                               {data: '修改',attributes:{'permission':'payment_way_edit'}},
                               {data: '删除',attributes:{'permission':'payment_way_delete'}}]
				  },{
				       data: '数据库备份',
				       attributes:{'permission':'backup'},
				       state: "open",
		               children:[{data: '查看',attributes:{'permission':'backup_index'}},
			      	             {data: '优化',attributes:{'permission':'backup_optimize'}},
				      	         {data: '修复',attributes:{'permission':'backup_repair'}},
					      	     {data: '备份',attributes:{'permission':'backup_backupDatabase'}}]
				  },{
				       data: '文件管理',
				       attributes:{'permission':'file'},
				       state: "open",
		               children:[{data: '查看',attributes:{'permission':'file_index'}},
			      	             {data: '删除',attributes:{'permission':'file_deleteFile'}}]
			      }]
		},{
			data: '模型权限',
			attributes:{'permission':'pattern'},
			state: "close",
			children:[{data: '查看',attributes:{'permission':'pattern_index'}},
                      {data: '添加',attributes:{'permission':'pattern_add'}},
			          {data: '修改',attributes:{'permission':'pattern_edit'}},
			          {data: '只删除数据不删除文件',attributes:{'permission':'pattern_delete'}},
			          {data: '复制',attributes:{'permission':'pattern_copy'}},
			          {data: '删除数据与文件',attributes:{'permission':'pattern_delete_pattern'}}]
		}];
	if ($("#permissions_tree").size()) {
	$("#permissions_tree").tree({
		data: {
			'type': "json",
			opts: {
				'static': {
					data: "所有权限",
					children: permissionsList,
					state: "open"
				}
			}
		},
		ui: {
			theme_name: "checkbox"
		},
		plugins: {
			checkbox: {}
		},
		types: {
			'default':{
				draggable	: false,
			}
		}
	});
	if(permissions){
		$.each($("#permissions_tree li"),function(i,n){
		    if(jQuery.inArray($(n).attr('permission'),permissions)!=-1){
		        $(n).children('a')[0].className = 'checked';
				}
		});

	}
	}
$(document).ready(function() {
	$("#btn_admin_group_save").click(function(){
		var $id = $("#id").val();
		var $group_name = $("#group_name").val();
		var $permission = '';
		$.each($("#permissions_tree a.checked"),function(i,n){
    		if($(n).parent().attr('permission')){
    			$permission += $(n).parent().attr('permission')+',';
    		}
		})
		if (! $group_name) {
			alert('部门名称不能为空！');
			$("#group_name").focus();
			return false;
		}
		if (! $permission) {
			alert('权限设置不能为空！');
			return false;
		}
		$.post(base_url+"admincp.php/"+controller+"/save/"+$id,
				{	"group_name": $group_name,
			        "permissions": $permission.substr(0, $permission.length-1)
				},
				function(res){
					if(res.success){
						window.location.href = res.field;
						return false;
					}else{
						alert(res.message);
						return false;
					}
				},
				"json"
		);
	});
});
</script>