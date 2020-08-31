<?php

class Exchange extends CI_Controller {

    private $_title = '退换货管理';
    private $_tool = '';
    private $_table = '';
    private $_exchange_type = array('1' => '退货退款', '2' => '换货', '3' => '仅退款');
    private $_template = 'exchange';

    public function __construct() {
        parent::__construct();
        //获取表名
        $this->_table = $this->uri->segment(1);
        //快捷方式
        $this->_tool = $this->load->view('element/exchange_tool', '', TRUE);
        //获取表对象
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('Attachment_model', '', TRUE);
        $this->load->model('Orders_detail_model', '', TRUE);
        $this->load->model('User_address_model', '', TRUE);
        $this->load->model('Orders_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Financial_model', '', TRUE);
        $this->load->library('Getuiapiclass');
        //订单处理跟踪
        $this->load->model('Orders_process_model', '', TRUE);
    }

    public function index($page = 0) {
        checkPermission($this->_template . '_index');
        if (!$this->uri->segment(2)) {
            $this->session->unset_userdata(array('search' => ''));
        }
        $this->session->set_userdata(array("{$this->_table}RefUrl" => base_url() . 'admincp.php/' . uri_string()));
        $strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : NULL;
        if ($_POST) {
            $strWhere = "{$this->_table}.id > 0";
            $order_number = $this->input->post('order_number');
            $title = $this->input->post('title');
            $status = $this->input->post('status');
            $startTime = $this->input->post('inputdate_start');
            $endTime = $this->input->post('inputdate_end');
            if (!empty($order_number)) {
                $strWhere .= " and {$this->_table}.order_number = '{$order_number}' ";
            }
            if (!empty($title)) {
                $strWhere .= " and {$this->_table}.title like '%" . $title . "%'";
            }
            if ($status != "") {
                $strWhere .= " and {$this->_table}.status={$status} ";
            }
            if (!empty($startTime) && !empty($endTime)) {
                $strWhere .= ' and add_time > ' . strtotime($startTime . ' 00:00:00') . ' and add_time < ' . strtotime($endTime . ' 23:59:59') . ' ';
            }
            $this->session->set_userdata('search', $strWhere);
        }

        //分页
        $this->config->load('pagination_config', TRUE);
        $paginationCount = $this->tableObject->rowCount($strWhere);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "admincp.php/{$this->_table}/index/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 3;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();
        $itemList = $this->tableObject->gets('*', $strWhere, $paginationConfig['per_page'], $page);
        $data = array(
            'tool' => $this->_tool,
            'itemList' => $itemList,
            'pagination' => $pagination,
            'paginationCount' => $paginationCount,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'table' => $this->_table,
            'exchange_type' => $this->_exchange_type,
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view($this->_table . '/index', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function save($id = NULL) {
        checkPermission($this->_template . '_edit');
        $prfUrl = $this->session->userdata($this->_table . 'RefUrl') ? $this->session->userdata($this->_table . 'RefUrl') : base_url() . "admincp.php/{$this->_table}/index/";
        $itemInfo = $this->tableObject->get('*', array('id' => $id));
        if (!$itemInfo) {
            printAjaxError('fail', '此退换货申请不存在！');
        }
        //查询订单信息
        $ordersInfo = $this->Orders_model->get('*', array('order_number' => $itemInfo['order_number']));
        if (!$ordersInfo) {
            printAjaxError('fail', '此订单不存在，处理失败！');
        }

        $userInfo = $this->User_model->getInfo('*', array('user.id' => $itemInfo['user_id']));
        if (!$userInfo) {
            printAjaxError('fail', '退换货申请的用户已经不存在，处理异常！');
        }

        $user_address = '';
        if ($_POST) {
            $status = $this->input->post('status', TRUE);
            $price = $this->input->post('price', TRUE);
            $remark = $this->input->post('remark', TRUE);
            $seller_recieve_goods = $this->input->post('seller_recieve_goods', TRUE);
            //退货退款
            if ($itemInfo['exchange_type'] == 1) {
                if ($itemInfo['price'] > 0 || $itemInfo['status'] == 1) {
                    printAjaxError('fail', '此退货订单已处理');
                }
                $fields = array(
                    'remark' => $remark,
                    'seller_recieve_goods' => $seller_recieve_goods,
                    'last_time' => time()
                );
                if (!empty($status)) {
                    $fields['status'] = $status;
                }
                if ($itemInfo['status'] == 1 && $price > 0) {
                    printAjaxError('fail', '审核未通过不能打款');
                }
                if ($itemInfo['status'] == 2 && $seller_recieve_goods == 0 && $price > 0) {
                    printAjaxError('fail', '审核通过未收到货不能打款');
                }
                if ($itemInfo['status'] == 2 && $seller_recieve_goods == 1 && $price <= 0) {
                    printAjaxError('fail', '请填写退款金额');
                }
                if ($itemInfo['status'] == 2 && $seller_recieve_goods == 1 && $price > 0) {
                    $fields['price'] = $price;
                }
                if ($price > $ordersInfo['total']) {
                    printAjaxError('fail', '退款金额不能大于订单总额');
                }
                if ($this->tableObject->save($fields, array('id' => $id))) {
                    if(isset($fields['status']) && $fields['status'] == 2){
                        $this->sendmessge($userInfo['id'],"订单号：{$ordersInfo['order_number']},退货退款审核通过");
                    }
                    if ($itemInfo['status'] == 2 && $seller_recieve_goods == 1 && $price > 0) {
                        $out_refund_no = '';
                        $cause = "";
                        //预存款支付退款
                        if ($ordersInfo['payment_id'] == 1) {
                            $this->User_model->save(array('total' => $userInfo['total'] + $price), array('id' => $userInfo['id']));
                            $cause = "退款成功--[订单号：{$itemInfo['order_number']}]退回账户余额";
                        }
                        //支付宝退款
                        if ($ordersInfo['payment_id'] == 2) {
                            $out_refund_no = 'ZFB' . date('YmdHis');
                            $result = $this->alipay_refund($itemInfo['order_number'], $ordersInfo['alipay_trade_no'], $out_refund_no, $price);
                            if ($result !== true) {
                                $this->tableObject->save(array('price' => 0, 'status' => 0), array('id' => $id));
                                printAjaxError('fail', $result);
                            }
                            $cause = "退款成功--{$itemInfo['order_number']}退回支付宝，支付宝交易单号：{$ordersInfo['alipay_trade_no']}";
                        }
                        //微信退款 (以下代码重要，请不要删掉)
                        if ($ordersInfo['payment_id'] == 3) {
                            $out_refund_no = 'WX' . date('YmdHis');
                            $result = $this->wx_refund($itemInfo['order_number'], $out_refund_no, $ordersInfo['total'] * 100, $price * 100, get_cookie('admin_username'));
                            if ($result['return_code'] == 'FAIL' || $result['result_code'] == 'FAIL') {
                                $this->tableObject->save(array('price' => 0, 'status' => 0), array('id' => $id));
                                printAjaxError('fail', isset($result['err_code_des']) ? $result['err_code_des'] : $result['return_msg']);
                            }
                            $cause = "退款成功--{$itemInfo['order_number']}退回微信，微信交易单号：{$ordersInfo['transaction_id']}";
                        }
                        //网银退款
                         if ($ordersInfo['payment_id'] == 4) {
                             $result = $this->ebank_refund($itemInfo['order_number'], $ordersInfo['ebank_date'], $price);
                             if ($result !== true) {
                                $this->tableObject->save(array('price' => 0, 'status' => 0), array('id' => $id));
                                printAjaxError('fail', $result);
                            }
                            $cause = "退款成功--{$itemInfo['order_number']}退回网银，网银订单交易日期：{$ordersInfo['ebank_date']}";
                         }
                        $this->sendmessge($userInfo['id'],"订单号：{$ordersInfo['order_number']},退货退款成功,退款金额为{$price}元");
                        //财务记录还没有添加
                        $fFields = array(
                            'cause' => $cause,
                            'price' => $price,
                            'add_time' => time(),
                            'username' => $userInfo['username'],
                            'user_id' => $userInfo['id'],
                            'type' => 'order_in',
                            'balance' => $ordersInfo['payment_id'] == 1 ? $userInfo['total'] + $price : $userInfo['total'],
                            'pay_way' => 1,
                        );
                        $this->Financial_model->save($fFields);
                        $this->tableObject->save(array('out_refund_no' => $out_refund_no), array('id' => $id));
                    }
                }
                $this->change_order_status($ordersInfo['id'], $itemInfo['order_number']);
                printAjaxSuccess($prfUrl, '操作成功！');
            }
            //换货
            if ($itemInfo['exchange_type'] == 2) {
                if ($itemInfo['status'] == 1) {
                    printAjaxError('fail', '此退货订单已处理');
                }
                if ($itemInfo['status'] == 2 && $itemInfo['seller_recieve_goods'] == 1) {
                    printAjaxError('fail', '此退货订单已处理');
                }
                $fields = array(
                    'remark' => $remark,
                    'seller_recieve_goods' => $seller_recieve_goods,
                    'last_time' => time()
                );
                if (!empty($status)) {
                    $fields['status'] = $status;
                }
                if ($this->tableObject->save($fields, array('id' => $id))) {
                    $this->change_order_status($ordersInfo['id'], $itemInfo['order_number']);
                    printAjaxSuccess($prfUrl, '操作成功！');
                }
            }
            //仅退款
            if ($itemInfo['exchange_type'] == 3) {
                if ($itemInfo) {
                    if ($itemInfo['status'] == 1 || $itemInfo['status'] == 2) {
                        printAjaxError('fail', '此退货订单已处理');
                    }
                }
                $fields = array(
                    'remark' => $remark,
                    'last_time' => time()
                );
                if ($this->form_validation->required($status)) {
                    if ($status == 2) {
                        if (!$this->form_validation->required($price)) {
                            printAjaxError('fail', '审核通过，必须得填写退换货金额！');
                        }
                        if ($price <= 0) {
                            printAjaxError('fail', '退款金额不能小于0');
                        }
                        $fields['price'] = $price;
                    }
                    $fields['status'] = $status;
                }
                if ($price > $ordersInfo['total']) {
                    printAjaxError('fail', '退款金额不能大于订单总额');
                }
                if ($this->tableObject->save($fields, array('id' => $id))) {
                    if ($this->form_validation->required($status) && $status == 2) {
                        $out_refund_no = '';
                        $cause = "";
                        //预存款支付退款
                        if ($ordersInfo['payment_id'] == 1) {
                            $this->User_model->save(array('total' => $userInfo['total'] + $price), array('id' => $userInfo['id']));
                            $cause = "退款成功--[订单号：{$itemInfo['order_number']}]退回账户余额";
                        }
                        //支付宝退款
                        if ($ordersInfo['payment_id'] == 2) {
                            $out_refund_no = 'ZFB' . date('YmdHis');
                            $result = $this->alipay_refund($itemInfo['order_number'], $ordersInfo['alipay_trade_no'], $out_refund_no, $price);
                            if ($result !== true) {
                                $this->tableObject->save(array('price' => 0, 'status' => 0), array('id' => $id));
                                printAjaxError('fail', $result);
                            }
                            $cause = "退款成功--{$itemInfo['order_number']}退回支付宝，支付宝交易单号：{$ordersInfo['alipay_trade_no']}";
                        }
                        //微信退款
                        if ($ordersInfo['payment_id'] == 3) {
                            $out_refund_no = 'WX' . date('YmdHis');
                            $result = $this->wx_refund($itemInfo['order_number'], $out_refund_no, $ordersInfo['total'] * 100, $price * 100, get_cookie('admin_username'));
                            if ($result['return_code'] == 'FAIL' || $result['result_code'] == 'FAIL') {
                                $this->tableObject->save(array('price' => 0, 'status' => 0), array('id' => $id));
                                printAjaxError('fail', isset($result['err_code_des']) ? $result['err_code_des'] : $result['return_msg']);
                            }
                            $cause = "退款成功--{$itemInfo['order_number']}退回微信，微信交易单号：{$ordersInfo['transaction_id']}";
                        }
                        //网银退款
                         if ($ordersInfo['payment_id'] == 4) {
                             $result = $this->ebank_refund($itemInfo['order_number'], $ordersInfo['ebank_date'], $price);
                             if ($result !== true) {
                                $this->tableObject->save(array('price' => 0, 'status' => 0), array('id' => $id));
                                printAjaxError('fail', $result);
                            }
                            $cause = "退款成功--{$itemInfo['order_number']}退回网银，网银订单交易日期：{$ordersInfo['ebank_date']}";
                         }
                         $this->sendmessge($userInfo['id'],"订单号：{$ordersInfo['order_number']},退款成功,退款金额为{$price}元");
                        //财务记录还没有添加
                        $fFields = array(
                            'cause' => $cause,
                            'price' => $price,
                            'add_time' => time(),
                            'username' => $userInfo['username'],
                            'user_id' => $userInfo['id'],
                            'type' => 'order_in',
                            'balance' => $ordersInfo['payment_id'] == 1 ? $userInfo['total'] + $price : $userInfo['total'],
                            'pay_way' => 1,
                        );
                        $this->Financial_model->save($fFields);
                        $this->tableObject->save(array('out_refund_no' => $out_refund_no), array('id' => $id));
                        //最后修改状态
                        $this->change_order_status($ordersInfo['id'], $itemInfo['order_number']);
                    }
                    printAjaxSuccess($prfUrl, '操作成功！');
                } else {
                    printAjaxError('fail', "操作失败！");
                }
            }
        }


        $attachmentList = array();
        if ($itemInfo['batch_path_ids']) {
            $attachmentList = $this->Attachment_model->gets('id, path, alt', 'id in (' . preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $itemInfo['batch_path_ids']) . ')');
        }
        $product = $this->Orders_detail_model->get('product_title,path,color_name,size_name', array('id' => $itemInfo['orders_detail_id']));
        $data = array(
            'tool' => $this->_tool,
            'table' => $this->_table,
            'itemInfo' => $itemInfo,
            'prfUrl' => $prfUrl,
            'exchange_type' => $this->_exchange_type,
            'attachmentList' => $attachmentList,
            'product' => $product,
            'ordersInfo' => $ordersInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view($this->_table . '/save', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function delete() {
        checkPermissionAjax("{$this->_template}_delete");
        $ids = $this->input->post('ids', TRUE);
        if (!empty($ids)) {
            if ($this->tableObject->delete('id in (' . $ids . ')')) {
                printAjaxData(array('ids' => explode(',', $ids)));
            }
        }
        printAjaxError('删除失败！');
    }

    private function change_order_status($order_id, $order_number) {
        //最后修改状态
        $orders_detail = $this->Orders_detail_model->gets('id', array('order_id' => $order_id));
        $orders_detail_count = count($orders_detail);
        $orders_de_ids = '';
        if ($orders_detail) {
            foreach ($orders_detail as $ls) {
                $orders_de_ids .= $ls['id'] . ',';
            }
            $orders_de_ids = trim($orders_de_ids, ',');
            $count1 = $this->tableObject->rowCount("orders_detail_id in ($orders_de_ids) and status = 2 and price > 0 and (exchange_type = 1 or exchange_type = 3)");
            $count2 = $this->tableObject->rowCount("orders_detail_id in ($orders_de_ids) and status = 2 and seller_recieve_goods = 1 and exchange_type = 2");
        }
        if ($count1 + $count2 == $orders_detail_count) {
            if ($this->Orders_model->save(array('status' => 6), "order_number = '{$order_number}' and status < 6")) {
                $content = '退换货成功';
                $fields = array(
                    'add_time' => time(),
                    'content' => $content,
                    'order_id' => $order_id
                );
                $this->Orders_process_model->save($fields);
            }
        }
    }

    private function wx_refund($order_number, $refund_no, $total_fee, $refund_mount, $op_user_id = '') {
        require 'application/client/config/wxpay_config.php';
        require 'application/client/libraries/Wechatpay.php';
        $wechatpay = new WechatPay($config);
        $result = $wechatpay->refund($order_number, $refund_no, $total_fee, $refund_mount, $op_user_id);
        return $result;
    }

    private function alipay_refund($order_number, $alipay_trade_no, $refund_no, $refund_mount) {
        require 'sdk/alipay/aop/AopClient.php';
        require 'sdk/alipay/aop/AlipayTradeRefundRequest.php';
        require_once 'sdk/alipay/aop/signData.php';
        $aop = new AopClient ();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = '';//2016123004731350
        $aop->rsaPrivateKeyFilePath = 'sdk/alipay/aop/private_key.pem';
        $aop->alipayPublicKey = 'sdk/alipay/aop/public_key.pem';
        $aop->apiVersion = '1.0';
        $aop->postCharset = 'UTF-8';
        $aop->format = 'json';
        $request = new AlipayTradeRefundRequest ();
        $param = array(
            'out_trade_no' => $order_number,
            'trade_no' => $alipay_trade_no,
            'refund_amount' => $refund_mount,
            'refund_reason' => '正常退款',
            'out_request_no' => $refund_no,
        );
        $request->setBizContent(json_encode($param));
        $result = $aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if (!empty($resultCode) && $resultCode == 10000) {
            return true;
        } else {
            return $result->$responseNode->msg;
        }
    }
    private function ebank_refund($order_no,$ebank_date,$refund_amount){
            require_once('sdk/ebank/php_rsa.php');  //请修改参数为php_rsa.php文件的实际位置
            require_once('sdk/ebank/HashMap.class.php'); //请修改参数为HashMap.class.php文件的实际位置
            $serverUrl = "https://service.allinpay.com/gateway/index.do?";
            $serverIP = "service.allinpay.com"; //ceshi.allinpay.com
            $key = 'yizhejiediancom';
            $merchantId = '';//109115711607012
            $version = 'v1.3';
            $signType = '0';
            $orderNo = $order_no;
            $orderDatetime = $ebank_date;
            $refundAmount = $refund_amount*100;
            //组签名原串
            $bufSignSrc = "";
            if ($version != "")
                $bufSignSrc = $bufSignSrc . "version=" . $version . "&";
            if ($signType != "")
                $bufSignSrc = $bufSignSrc . "signType=" . $signType . "&";
            if ($merchantId != "")
                $bufSignSrc = $bufSignSrc . "merchantId=" . $merchantId . "&";
            if ($orderNo != "")
                $bufSignSrc = $bufSignSrc . "orderNo=" . $orderNo . "&";
            if ($refundAmount != "")
                $bufSignSrc = $bufSignSrc . "refundAmount=" . $refundAmount . "&";
            if ($orderDatetime != "")
                $bufSignSrc = $bufSignSrc . "orderDatetime=" . $orderDatetime . "&";
            if ($key != "")
                $bufSignSrc = $bufSignSrc . "key=" . $key;
                //生成签名串
                $signMsg = strtoupper(md5($bufSignSrc));
                $argv = array(
                    'version' => $version,
                    'signType' => $signType,
                    'merchantId' => $merchantId,
                    'orderNo' => $orderNo,
                    'refundAmount' => $refundAmount,
                    'orderDatetime' => $orderDatetime,
                    'signMsg' => $signMsg
                );
                $index = 0;
                $params = "";
                foreach ($argv as $key => $value) {
                    if ($index != 0) {
                        $params .= '&';
                    }
                    $params .= $key . '=';
                    $params .= urlencode($value); //对字符串进行编码转换
                    $index += 1;
                }
                $length = strlen($params);

                $urlhost = $serverIP;
                $urlpath = '/gateway/index.do';

                $header = array();
                $header[] = 'POST ' . $urlpath . ' HTTP/1.0';
                $header[] = 'Host: ' . $urlhost;
                $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html,text/plain,image/png,image/jpeg,image/gif,*/*';
                $header[] = 'Accept-encoding: gzip';
                $header[] = 'Accept-language: en-us';
                $header[] = 'Content-Type: application/x-www-form-urlencoded';
                $header[] = 'Content-Length: ' . $length;
                $request = implode("\r\n", $header) . "\r\n\r\n" . $params;

                $pageContents = "";

                 if(!$fp= pfsockopen('ssl://'.$urlhost, 443, $errno, $errstr, 10)){
                    echo "can not connect to {$urlhost}. $errstr($errno) <br/>";
                    echo $fp;
                } else {
                    fwrite($fp, $request);
                    $inHeaders = true; //是否在返回头
                    $atStart = true; //是否返回头第一行
                    $ERROR = false;
                    $responseStatus; //返回头状态
                    while (!feof($fp)) {
                        $line = fgets($fp, 2048);
                        if ($atStart) {
                            $atStart = false;
                            preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m);
                            $responseStatus = $m[2];
                            //print_r("<div style='padding-left:40px;'>");
                          //  print_r("<div>" . $line . "</div>");
                           // print_r("</div>");
                            continue;
                        }

                        if ($inHeaders) {
                            if (strLen(trim($line)) == 0) {
                                $inHeaders = false;
                            }
                            continue;
                        }

                        if (!$inHeaders and $responseStatus == 200) {
                            //获得参数串
                            $pageContents = $line;
                        }
                    }
                    fclose($fp);
                }
                $map = new HashMap();
                //echo $pageContents."<br>";
                $result = explode('&', $pageContents);
                if (is_array($result)) {
                    foreach ($result as $element) {
                        $temp = explode('=', $element);
                        if (count($temp) == 2) {
                            $map->put($temp[0], $temp[1]);
                        }
                    }
                }
                //开始组验签源串
                $bufVerifySrc = "";
                if ($map->get("merchantId") != "")
                    $bufVerifySrc = $bufVerifySrc . "merchantId=" . ($map->get("merchantId")) . "&";   //merchantId

                if ($map->get("version") != "")
                    $bufVerifySrc = $bufVerifySrc . "version=" . ($map->get("version")) . "&";  //version

                if ($map->get("signType") != "")
                    $bufVerifySrc = $bufVerifySrc . "signType=" . ($map->get("signType")) . "&";  //signType

                if ($map->get("orderNo") != "")
                    $bufVerifySrc = $bufVerifySrc . "orderNo=" . ($map->get("orderNo")) . "&";  ///orderNo

                if ($map->get("orderAmount") != "")
                    $bufVerifySrc = $bufVerifySrc . "orderAmount=" . ($map->get("orderAmount")) . "&";  //orderAmount

                if ($map->get("orderDatetime") != "")
                    $bufVerifySrc = $bufVerifySrc . "orderDatetime=" . ($map->get("orderDatetime")) . "&";  //orderDatetime

                if ($map->get("refundAmount") != "")
                    $bufVerifySrc = $bufVerifySrc . "refundAmount=" . ($map->get("refundAmount")) . "&";  //refundAmount

                if ($map->get("refundDatetime") != "")
                    $bufVerifySrc = $bufVerifySrc . "refundDatetime=" . ($map->get("refundDatetime")) . "&";  //refundDatetime

                if ($map->get("refundResult") != "")
                    $bufVerifySrc = $bufVerifySrc . "refundResult=" . ($map->get("refundResult")) . "&";  //refundResult

                if ($map->get("errorCode") != "")
                    $bufVerifySrc = $bufVerifySrc . "errorCode=" . ($map->get("errorCode")) . "&";  //errorCode

                if ($map->get("returnDatetime") != "")
                    $bufVerifySrc = $bufVerifySrc . "returnDatetime=" . ($map->get("returnDatetime")) . "&";  //returnDatetime

                $bufVerifySrc = $bufVerifySrc . "key=" . 'yizhejiediancom';  //key
                //验签源串组装完成
                //print_r("-------------------<br>");
                //print_r("<br>bufVerifySrc:".$bufVerifySrc);
                //print_r("<br>-------------------<br>");
                //取签名串
                if(!isset($result[10])){
                    return $result[1];
                }
                $verifyMsgArray = explode('=', $result[10]);
                $verifyMsg = urldecode($verifyMsgArray[1]);
                //echo "<br>verifyMsg=".$verifyMsg;
                //取交易结果量
                $refundResultArray = explode('=', $result[8]);

                $refundResult = $refundResultArray[1];   //交易状态 refundResult=20表示退款申请成功

                //echo "<br>".$refundResult;
                //验签,联机退款响应报文使用md5生成签名串
                //生成响应签名串
                $genVerifyMsg = strtoupper(md5($bufVerifySrc));
                //echo "<br>genVerifyMsg=".$genVerifyMsg;
                $verifyResult = 0;
                if ($genVerifyMsg == $verifyMsg) {
                    $verifyResult = 1;
                } else {
                    $verifyResult = 0;
                }

                //判断交易结果，判断验签结果
                $resultMsg = '';
                if ($refundResult == 20) {
                    if ($verifyResult == 1) {
                        $resultMsg = "联机退款申请成功，验签成功！";
                        return true;
                    } else {
                        $resultMsg = "联机退款申请成功，验签失败！";
                        return $resultMsg;
                    }
                } else {
                    $resultMsg = "联机退款申请失败！";
                    return $resultMsg;
                }
    }
    private function sendmessge($uid,$message) {
            $user_info = $this->User_model->get(array('user.id'=>$uid));
                if($user_info['push_cid']){
                    $this->_send_push($user_info['push_cid'],$message);
                }
                 $this->advdbclass->send_message($uid,0,'订单消息',$message);
    }
    //消息推送，只针对手机登录的用户有效
    private function _send_push($cid = '', $message = '') {
           $getui = new Getuiapiclass();
           $getui->send_push($cid, $message);
     }

}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */