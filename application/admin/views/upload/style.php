<script src="js/admin/uploadify/js/jquery.uploadify.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="js/admin/uploadify/css/uploadify.css">
<table cellpadding="2" cellspacing="1" class="table_form">
    <caption>图片上传</caption>
  <tr>
   <td>
     <input id="image_upload" name="batch_image_upload" type="file" multiple="true">
	</td>
   </tr>
  <tr>
     <td>
      <input type="hidden" name="model" value="<?php echo $model; ?>" />
	 允许上传类型：<?php echo $ext; ?><br />
	 允许上传大小：<?php echo $size; ?><br />
	 缩略图大小：宽 <?php echo $width; ?>px，高 <?php echo $height; ?> px
    </td>
   </tr>
  <tr>
     <td>     
     <img id="previewpic" src="<?php if (isset($filePath)){echo $filePath;}else{echo "images/admin/nopic.gif";} ?>"  />
     <?php if ($model == 'product') { ?>
     <img id="max_previewpic" src="<?php if (isset($filePath)){echo preg_replace("/_thumb/", "_max", $filePath);}else{echo "images/admin/nopic.gif";} ?>"  />
	 <?php } ?>
	 </td>
   </tr>
</table>
<script language="javascript" type="text/javascript">
<?php $timestamp = time();?>
$(function() {
	$('#image_upload').uploadify({
		'formData'     : {
			'timestamp' : '<?php echo $timestamp;?>',
			'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
			'model'     : '<?php echo $model; ?>'
		},
		'fileTypeExts' : '*.jpg; *.jpeg; *.png; *.gif',
	    'method'   : 'post',
		'multi'    : false,
		'fileSizeLimit' : '50MB',//B, KB, MB, or GB
		'uploadLimit' : 999,
		'removeCompleted' : true,
		'queueID'  : 'batch_upload_file_queue',
		'buttonText' : '上传图片',
		'swf'      : 'js/admin/uploadify/flash/uploadify.swf',
		'uploader' : '<?php echo base_url(); ?>admincp.php/upload/uploadImageByW',	
		'onUploadSuccess' : function(file, data, response) {
			json = eval("(" + data + ")");
			if (json.success) {
				 var ele = window.opener.document.getElementById("<?php echo $eleid;?>");
                                    ele.src = json.data.file_path.replace('/\./','_thumb.');
                                 var color_id  = ele.parentNode.getElementsByTagName('label')[0].getElementsByTagName('input')[0].value;
                                    ele.parentNode.getElementsByClassName('path_ids_s')[0].value = color_id + '|' + json.data.file_path;
				$("#previewpic").attr("src", json.data.file_path.replace('.', '_thumb.'));
				<?php if ($model == 'product') { ?>
				$("#max_previewpic").attr("src", json.data.file_path.replace('.', '_max.'));
				<?php } ?>
			} else {
                                         alert(json.message);
			}
			return false;
		}
	});
});
</script>
