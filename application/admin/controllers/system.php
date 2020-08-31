<?php
class System extends CI_Controller {
    private $_title = '系统设置';
    private $_tool = '';
    private $_template = 'system';
    public function __construct() {
        parent::__construct();
        //快捷方式
        $this->_tool = $this->load->view('element/system_tool', array('parent_title'=>'系统管理', 'title'=>$this->_title), TRUE);
        $this->load->model('System_model', '', TRUE);
    }

    public function save() {
        checkPermission($this->_template.'_save');
        if ($_POST) {
            $fields = array(
                'index_name' => $this->input->post('index_name', TRUE),
                'site_name' => $this->input->post('site_name', TRUE),
                'index_site_name' => $this->input->post('index_site_name', TRUE),
                'client_index' => $this->input->post('client_index', TRUE),
                'site_copyright' => $this->input->post('site_copyright', TRUE),
                'site_keycode' => $this->input->post('site_keycode', TRUE),
                'site_description' => $this->input->post('site_description', TRUE),
                'icp_code' => $this->input->post('icp_code', TRUE),
                'html_folder' => $this->input->post('html_folder', TRUE),
                'html_level' => $this->input->post('html_level', TRUE),
                'video_path' => $this->input->post('video_path'),
                'return_address' => $this->input->post('return_address',TRUE),
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/save');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('parent_title'=>'系统管理', 'title'=>'基本设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/save', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //搜索关键词设置
    public function keyword() {
        checkPermission($this->_template.'_save');
        if ($_POST) {
            $fields = array(
                'text_keyword' => $this->input->post('text_keyword', TRUE),
                'link_keyword' => $this->input->post('link_keyword', TRUE)
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/keyword');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('parent_title'=>'系统管理', 'title'=>'搜索关键词设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/keyword', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }
    
    //在线客服设置--用不到
    public function qq_service() {
        if ($_POST) {
            $fields = array(
                'globle_qq_service' => unhtml($this->input->post('globle_qq_service')),
                'left_qq_service' => unhtml($this->input->post('left_qq_service'))
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/qq_service');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '在线客服设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/qq_service', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //在线充值设置--用不到
    public function online_recharge() {
        if ($_POST) {
            $fields = array(
                'online_recharge' => unhtml($this->input->post('online_recharge'))
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/online_recharge');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '在线充值设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/online_recharge', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }
	
    //服务协议设置--用不到
    public function reg_agreement() {
        if ($_POST) {
            $fields = array(
                'reg_agreement' => unhtml($this->input->post('reg_agreement'))
            );
            if ($this->System_model->save($fields, array('id' => 1))) {
                printAjaxSuccess(base_url() . 'admincp.php/system/reg_agreement');
            } else {
                printAjaxError("修改失败！");
            }
        }
        $itemInfo = $this->System_model->get('*', array('id' => 1));
        $data = array(
            'tool' => $this->load->view('element/system_tool', array('title' => '服务协议设置'), TRUE),
            'itemInfo' => $itemInfo
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('system/reg_agreement', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    //推广页面介绍
    public function presenter_text() {
        checkPermission('presenter_text');
    	if ($_POST) {
    		$fields = array(
    				'presenter_is_open'=>$this->input->post("presenter_is_open", TRUE),
    				'parent_presenter_text' => unhtml($this->input->post('parent_presenter_text')),
    				'sub_presenter_text' => unhtml($this->input->post('sub_presenter_text')),
    				'presenter_city_text' => unhtml($this->input->post('presenter_city_text')),
    				'presenter_store_text' => unhtml($this->input->post('presenter_store_text'))
    		);
    		if ($this->System_model->save($fields, array('id' => 1))) {
    			printAjaxSuccess(base_url() . 'admincp.php/system/presenter_text');
    		} else {
    			printAjaxError("修改失败！");
    		}
    	}
    	$itemInfo = $this->System_model->get('*', array('id' => 1));
    	$data = array(
    			'tool' => $this->load->view('element/system_tool', array('parent_title'=>'系统管理', 'title'=>'分销商推广页面设置'), TRUE),
    			'itemInfo' => $itemInfo
    	);
    	$layout = array(
    			'title' => $this->_title,
    			'content' => $this->load->view('system/presenter_text', $data, TRUE)
    	);
    	$this->load->view('layout/default', $layout);
    }

    public function update() {
    	if ($_POST) {
              checkPermissionAjax('system_update');
    		$fields = array(
    			'android_full_update_version'=> $this->input->post('android_full_update_version'),
				'android_full_update_url'=>     $this->input->post('android_full_update_url'),
				'ios_full_update_version'=>     $this->input->post('ios_full_update_version'),
				'ios_full_update_url'=>         $this->input->post('ios_full_update_url'),
    			'wget_version'=>                $this->input->post('wget_version'),
    			'wget_url'=>                    $this->input->post('wget_url')
    		);
    		if ($this->System_model->save($fields, array('id' => 1))) {
    			printAjaxSuccess(base_url() . 'admincp.php/system/update');
    		} else {
    			printAjaxError("修改失败！");
    		}
    	}
    	$itemInfo = $this->System_model->get('*', array('id' => 1));
    	$data = array(
    			'tool' => $this->load->view('element/system_tool', array('parent_title'=>'系统管理', 'title'=>'App更新'), TRUE),
    			'itemInfo' => $itemInfo
    	);
    	$layout = array(
    			'title' => $this->_title,
    			'content' => $this->load->view('system/update', $data, TRUE)
    	);
    	$this->load->view('layout/default', $layout);
    }

    /**
	 * 配置订单信息
	 */
    public function configure_order() {
    	if ($_POST) {
              checkPermissionAjax('system_update');
    		$fields = array(
    			'stock_reduce_type'=>    $this->input->post('stock_reduce_type', TRUE),
				'close_order_time'=>     $this->input->post('close_order_time', TRUE),
				'receiving_order_time'=> $this->input->post('receiving_order_time', TRUE),
    		);
    		if ($this->System_model->save($fields, array('id' => 1))) {
    			printAjaxSuccess(base_url() . 'admincp.php/system/configure_order');
    		} else {
    			printAjaxError("修改失败！");
    		}
    	}
    	$itemInfo = $this->System_model->get('*', array('id' => 1));
    	$data = array(
    			'tool' => $this->load->view('element/system_tool', array('parent_title'=>'系统管理', 'title'=>'订单基本设置'), TRUE),
    			'itemInfo' => $itemInfo
    	);
    	$layout = array(
    			'title' => $this->_title,
    			'content' => $this->load->view('system/configure_order', $data, TRUE)
    	);
    	$this->load->view('layout/default', $layout);
    }
}

/* End of file news.php */
/* Location: ./application/admin/controllers/news.php */