<?php

class Store extends CI_Controller {
    private $_price_arr = array('1'=>array('0-1000', '0-1000元'), '2'=>array('1000-3000', '1000-3000元'), '3'=>array('3000-5000', '3000-5000元'), '4'=>array('5000-10000', '5000-10000元'), '5'=>array('10000-20000', '10000-20000元'), '6'=>array('20000', '20000元以上'));
    private $_table = 'store';
    private $_template = 'store';
    private $_style = 'style1';

    public function __construct() {
        parent::__construct();
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Store_category_model', '', TRUE);
        $this->load->model('Attachment_model', '', TRUE);
    }

    public function index($menu_str = NULL, $page = 0) {
        $menuId = 0;
        $store_category_id = 0;
        $store_category_name = '';
        if ($menu_str) {
            $menu_str_arr = explode("-", $menu_str);
            if ($menu_str_arr) {
                if (array_key_exists("0", $menu_str_arr)) {
                    $menuId = $menu_str_arr[0];
                }
                if (array_key_exists("1", $menu_str_arr)) {
                    $store_category_id = $menu_str_arr[1];
                    if ($store_category_id) {
                        $sc_info = $this->Store_category_model->get('store_category_name', array('id' => $store_category_id));
                        if ($sc_info) {
                            $store_category_name = $sc_info['store_category_name'];
                        }
                    }
                }
            }
        }
        //关键字信息
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $menuInfo = $this->Menu_model->get('menu_name, seo_menu_name, keyword, abstract', array('id' => $menuId));
        if (!$menuInfo) {
            $data = array(
                'user_msg' => '此栏目不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
            exit;
        }
        //当前位置
        $location = '';
        if ($systemInfo['html']) {
            $location = "<a href='index.html'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
        } else {
            $location = "<a href='{$systemInfo['client_index']}'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
        }
        $url = $systemInfo['client_index'];
        $url .= $systemInfo['client_index'] ? '/' : '';
        $url = $this->Menu_model->getLocation($menuId, $systemInfo['html'], $url);
        $location .= $url;
        //新闻列表
        $strWhere = "display = 1";
        //分页
        $url = $systemInfo['client_index'];
        if ($systemInfo['client_index']) {
            $url .= '/';
        }
        $paginationCount = $this->tableObject->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = "{$url}{$this->_template}/index/{$menuId}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 20;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
        //分类
        $store_category_list = $this->Store_category_model->gets(array('display' => 1));
        //左侧分类
        $parent_id = $this->Menu_model->getParentMenuId($menuId);

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => $menuInfo['seo_menu_name'] ? $menuInfo['seo_menu_name'] : $menuInfo['menu_name'] . $systemInfo['site_name'],
            'keywords' => $menuInfo['keyword'],
            'description' => $menuInfo['abstract'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_list' => $item_list,
            'menuId' => $menuId,
            'pagination' => $pagination,
            'paginationCount' => $paginationCount,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page']),
            'perPage' => $paginationConfig['per_page'],
            'template' => $this->_template,
            'store_category_list' => $store_category_list,
            'location' => $location,
            'parent_id' => $parent_id,
            'store_category_id' => $store_category_id,
            'store_category_name' => $store_category_name
        );

        $layout = array(
            'content' => $this->load->view("{$this->_template}/index", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //店铺首页
    public function home($store_id = NULL) {
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->tableObject->get3(array('store.id' => $store_id, 'store.display' => 1));
        if (!$item_info) {
            $data = array(
                'user_msg' => '此店铺不存在',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
            exit;
        }
        $item_info['des_grade'] = floatval($item_info['des_grade']);
        $item_info['serve_grade'] = floatval($item_info['serve_grade']);
        $item_info['express_grade'] = floatval($item_info['express_grade']);
        if ($item_info['theme']) {
        	$this->_style = $item_info['theme'];
        }
        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
        	$tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
        	$attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'client_index' => $systemInfo['client_index'],
            'title' => $item_info['store_name'] . $systemInfo['site_name'],
            'keywords' => '',
            'description' => '',
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'item_info' => $item_info,
            'template' => $this->_template,
            'store_id' => $store_id,
        	'attachment_list'=>$attachment_list,
            'style' => $this->_style
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/home_{$this->_style}", $data, TRUE)
        );
        $this->load->view('layout/store_layout', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }
}

/* End of file main.php */
/* Location: ./application/client/controllers/main.php */