<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * print ajax error
 *
 *
 * @access	public
 * @param	string
 * @return	json
 */
if ( ! function_exists('printAjaxError')) {
    function printAjaxError($field =  '', $message = '') {
		$messageArr = array(
		              'success'=> false,
		              'field'=>   $field,
                      'message'=> $message
                      );
        echo json_encode($messageArr);
        exit;
	}
}

// ------------------------------------------------------------------------

/**
 * print ajax success
 *
 *
 * @access	public
 * @param	string
 * @return	json
 */
if ( ! function_exists('printAjaxSuccess')) {
    function printAjaxSuccess($field, $message = null) {
		$messageArr = array(
		              'success' => true,
		              'field'=>   $field,
                      'message' => $message
                      );
        echo json_encode($messageArr);
        exit;
	}
}

// ------------------------------------------------------------------------

/**
 * print ajax success
 *
 *
 * @access	public
 * @param	array
 * @return	json
 */
if ( ! function_exists('printAjaxData')) {
	function printAjaxData($data) {
		$messageArr = array(
		              'success' => true,
                      'data'   => $data
                      );
        echo json_encode($messageArr);
        exit;
	}
}

// ------------------------------------------------------------------------

/**
 * 获取字的宽度
 *
 *
 */
if ( ! function_exists('getStrWidth')) {
	function getStrWidth($str) {
		$len = mb_strlen($str);
		$letterCount = 0.0;
		for ($i = 0; $i < $len; $i++) {
		    if (strlen(mb_substr($str, $i, 1)) == 3) {
		        $letterCount += 1.0;
		    } else {
		        $letterCount += 0.5;
		    }
		}
		
		return $letterCount;
	}
}


// ------------------------------------------------------------------------

/**
 * Intercept length of the string
 *
 *
 * @access	public
 * @param	string
 * @param	int
 * @param	string
 * @return	string
 */
if ( ! function_exists('my_substr')) {
    function my_substr($str, $length, $encoding = 'utf-8') {
    	if (strlen($str) > $length) {
    	    return mb_substr($str, 0, $length, $encoding).'...';
    	} else {
    	    return $str;
    	}
    }
}
/* End of file my_ajaxerror_helper.php */
/* Location: ./application/admin/helpers/my_ajaxerror_helper.php */