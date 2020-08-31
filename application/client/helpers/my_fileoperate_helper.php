<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * get unique file name
 *
 * @access	public
 * @param	string example './uploads/'
 * @return	string
 */
if ( ! function_exists('getUniqueFileName')) {
    function getUniqueFileName($savePath) {
		$randFileName = date('YmdHis', time()) . rand(100000, 999999);
		if (file_exists ( $savePath . '/' . $randFileName )) {
		    while ( true ) {
		    	$randFileName = date('YmdHis', time()) . rand(100000, 999999);
				if (! file_exists ( $savePath . '/' . $randFileName )) {
					break;
				}
			}
		}
		
		return $randFileName;
	}
}

// ------------------------------------------------------------------------

/**
 * get file size
 *
 * @access	public
 * @param	int example:1073741824
 * @return	string
 */
if ( ! function_exists('getFileSize')) {
    function getFileSize($fileSize) {
		$ret = 0;
		if ($fileSize >= 1073741824) {//G
		    $ret = round($fileSize/1073741824) . ' G';
		} else if ($fileSize >= 1048576) {//mb
		    $ret = round($fileSize/1048576) . ' MB';
		} else if ($fileSize >= 1024) {//kb
		    $ret = round($fileSize/1024) . ' KB';
		} else {//byte
		    $ret = $fileSize.' byte';
		}
	    return $ret;
	}
}

// ------------------------------------------------------------------------

/**
 * get file size
 *
 * @access	public
 * @param	string example:g.zip
 * @return	string
 */
if ( ! function_exists('getFileExt')) {
    function getFileExt($fileName) {
	    $fileInfo = pathinfo($fileName);
		return $fileInfo['extension'];
	}
}

// ------------------------------------------------------------------------

/**
 * create dir
 *
 * @access	public
 * @param	string example:'./uploads/'
 * @return	string
 */
if ( ! function_exists('createDir')) {
    function createDir($filePath) {
	    if (! file_exists ( $filePath )) {
			if (! mkdir($filePath, 0777))
			    return false;
		}
		
		return $filePath;
	}
}

// ------------------------------------------------------------------------

/**
 * create dirs
 *
 * @access	public
 * @param	string example:'./uploads/'
 * @return	string
 */
if ( ! function_exists('mkdirs')) {
	function mkdirs($dir) {
		if(!is_dir($dir)){
			if(!mkdirs(dirname($dir))) {
				return false;
			}
			if(!mkdir($dir, 0777)) {
				return false;
			}
		}
		
		return true;
	}
}

// ------------------------------------------------------------------------

/**
 * create dir of date time
 *
 * @access	public
 * @param	string example:'./uploads/'
 * @return	string
 */
if ( ! function_exists('createDateTimeDir')) {
    function createDateTimeDir($savePath) {
		$filePath = $savePath. '/' . date ('Y', time());
		if (createDir($filePath)) {
		    $filePath = $filePath . '/' . date ('md', time());
		    if (createDir($filePath))
		    	return $filePath;
		}
		
	    return false;
	}
}

/**
 * 在二维码的中间区域镶嵌图片
 * @param $QR 二维码数据流。比如file_get_contents(imageurl)返回的东东,或者微信给返回的东东
 * @param $logo 中间显示图片的数据流。比如file_get_contents(imageurl)返回的东东
 * @return  返回图片数据流
 */
function qrcodeWithLogo($QR,$logo){
    $QR   = imagecreatefromstring ($QR);
    $logo = imagecreatefromstring ($logo);
    $QR_width    = imagesx ( $QR );//二维码图片宽度
    $QR_height   = imagesy ( $QR );//二维码图片高度
    $logo_width  = imagesx ( $logo );//logo图片宽度
    $logo_height = imagesy ( $logo );//logo图片高度
    $logo_qr_width  = $QR_width / 2.2;//组合之后logo的宽度(占二维码的1/2.2)
    $scale  = $logo_width / $logo_qr_width;//logo的宽度缩放比(本身宽度/组合后的宽度)
    $logo_qr_height = $logo_height / $scale;//组合之后logo的高度
    $from_width = ($QR_width - $logo_qr_width) / 2;//组合之后logo左上角所在坐标点
    /**
     * 重新组合图片并调整大小
     * imagecopyresampled() 将一幅图像(源图象)中的一块正方形区域拷贝到另一个图像中
     */
    imagecopyresampled ( $QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height );
    /**
     * 如果想要直接输出图片，应该先设header。header("Content-Type: image/png; charset=utf-8");
     * 并且去掉缓存区函数
     */
    //获取输出缓存，否则imagepng会把图片输出到浏览器
    ob_start();
    imagepng ($QR);
    imagedestroy($QR);
    imagedestroy($logo);
    $contents =  ob_get_contents();
    ob_end_clean();
    return $contents;
}
/**
 * 剪切图片为圆形
 * @param  $picture 图片数据流 比如file_get_contents(imageurl)返回的东东
 * @return 图片数据流
 */
function yuanImg($avatarUrl) {
    $src_img = imagecreatefromstring(file_get_contents($avatarUrl));
    $w   = imagesx($src_img);
    $h   = imagesy($src_img);
    $w   = min($w, $h);
    $h   = $w;
    $img = imagecreatetruecolor($w, $h);
    //这一句一定要有
    imagesavealpha($img, true);
    //拾取一个完全透明的颜色,最后一个参数127为全透明
    $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
    imagefill($img, 0, 0, $bg);
    $r   = $w / 2; //圆半径
    $y_x = $r; //圆心X坐标
    $y_y = $r; //圆心Y坐标
    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            $rgbColor = imagecolorat($src_img, $x, $y);
            if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                imagesetpixel($img, $x, $y, $rgbColor);
            }
        }
    }
    /**
     * 如果想要直接输出图片，应该先设header。header("Content-Type: image/png; charset=utf-8");
     * 并且去掉缓存区函数
     */
    //获取输出缓存，否则imagepng会把图片输出到浏览器
    ob_start();
    imagepng ($img);
    imagedestroy($img);
    $contents =  ob_get_contents();
    ob_end_clean();

    return $contents;
}
/* End of file html_helper.php */
/* Location: ./application/admin/helpers/My_firstletter.php */