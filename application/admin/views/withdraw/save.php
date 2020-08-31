<?php echo $tool; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" id="jsonForm" >
<input name="id" value="" type="hidden">
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>基本信息</caption>
 	<tbody>
 	<tr>
      <th width="20%"><strong>会员信息</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['username'];} ?>[ID：<?php if(! empty($itemInfo)){ echo $itemInfo['user_id'];} ?>] <a href="admincp.php/user/view/<?php if(! empty($itemInfo)){ echo $itemInfo['user_id'];} ?>">查看会员</a>
	</td>
    </tr>
	<tr>
      <th width="20%"><strong>申请时间</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo date('Y-m-d H:i', $itemInfo['add_time']);} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>账号类型</strong> <br/>
	  </th>
      <td>
      <font color="red"><?php if(! empty($itemInfo)){ echo $type_arr[$itemInfo['type']];} ?></font>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>户名</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['real_name'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>账号</strong> <br/>
	  </th>
      <td>
      <?php if(! empty($itemInfo)){ echo $itemInfo['account'];} ?>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>提现金额</strong> <br/>
	  </th>
      <td>
      <span style="font-size:14px;color:red;">
      <?php if(! empty($itemInfo)){ echo $itemInfo['price'];} ?> 元
      </span>
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>描述</strong> <br/>
	  </th>
      <td>
      提<?php if ($itemInfo) { echo floatval($itemInfo['score_num']);} ?><?php if ($itemInfo) { echo $score_type_arr[$itemInfo['score_type']];} ?>兑换<?php if ($itemInfo) { echo $itemInfo['price'];} ?>元
	</td>
    </tr>
    <tr>
      <th width="20%"><strong>处理状态</strong> <br/>
	  </th>
      <td>
      <font color="red"><?php echo $display_arr[$itemInfo['display']]; ?></font>
      <select valid="required" errmsg="请选择处理状态" name="display" id="display">
      <option value="">请选择处理状态</option>
      <?php if ($display_arr) { ?>
      <?php foreach ($display_arr as $key=>$value) {
            if ($key > 0) {
      	?>
      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
      <?php }}} ?>
      </select>
      <font color="red">注：提现成功会自动修改提现记录状态；提现失败会自动退款</font>
	</td>
    </tr>
    <tr>
      <th width="20%"> <strong>备注</strong> <br/>
	  </th>
      <td>
      <textarea valid="required" errmsg="请写点备注" name="remark" maxlength="400" id="remark" rows="4" cols="50"  class="textarea_style" ><?php if(! empty($itemInfo)){ echo $itemInfo['remark'];} ?></textarea>
     <font color="red">注：请写下备注，方便以后查看</font>
    </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
	  <input class="button_style" name="dosubmit" value=" 保存 " type="submit">
	  &nbsp;&nbsp; <input onclick="javascript:window.location.href='<?php echo $prfUrl; ?>';" class="button_style" name="reset" value=" 返回 " type="button">
	  </td>
    </tr>
</tbody>
</table>
</form>