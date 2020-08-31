<?php
class Page extends CI_Controller {
	private $_table = 'page';
	private $_template = 'page';
	public function __construct() {
		parent::__construct();
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
	}

	public function index($menuId = NULL, $id = NULL) {
		$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
		$itemInfo = array();
		if ($id) {
			$itemInfo = $this->tableObject->get('*', array('id'=>$id, 'display'=>1));
			if (!$itemInfo) {
				$data = array(
						'user_msg'=>'此文章不存在',
						'user_url'=> base_url()
				);
				$this->session->set_userdata($data);
				redirect('/message/index');
			}
			//记录浏览次数
			$this->tableObject->save(array('hits'=>$itemInfo['hits']+1), array('id'=>$id));
		}  else {
			$menu_info = $this->Menu_model->get('content, menu_name, seo_menu_name, keyword, abstract', array('id'=>$menuId));
			if ($menu_info && $menu_info['content']) {
				$itemInfo['id'] = 0;
				$itemInfo['seo_title'] = $menu_info['seo_menu_name'];
			    $itemInfo['title'] = $menu_info['menu_name'];
			    $itemInfo['content'] = $menu_info['content'];			    
			    $itemInfo['keyword'] = $menu_info['keyword'];
			    $itemInfo['abstract'] = $menu_info['abstract'];
			} else {
				$itemList = $this->tableObject->gets(array('page.category_id'=>$menuId, 'page.display'=>1), 1, 0);
				if ($itemList) {
					$itemInfo = $itemList[0];
				}
			}
		}
        $systemInfo = $this->System_model->get('*', array('id'=>1));
        //当前位置
		$location = '';
		if ($systemInfo['html']) {
			$location = "<a href='index.html'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
		} else {
			$location = "<a href='{$systemInfo['client_index']}'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
		}
		$url = $systemInfo['client_index'];
		$url .= $systemInfo['client_index']?'/':'';
		$url = $this->Menu_model->getLocation($menuId, $systemInfo['html'], $url);
		$location .= $url;       
		//栏目名称
		$menuInfo = $this->Menu_model->get('id, menu_name, html_path', array('id'=>$menuId));		
		//左侧分类
		$parentId = $this->Menu_model->getParentMenuId($menuId);
		$parentMenuInfo = $this->Menu_model->get('menu_name', array('id'=>$parentId));
				
		$data = array(
				'site_name'=>$systemInfo['site_name'],
				'index_name'=>$systemInfo['index_name'],
		        'client_index'=>$systemInfo['client_index'],
		        'title'=>$itemInfo['seo_title']?$itemInfo['seo_title'].$systemInfo['site_name']:$itemInfo['title'].$systemInfo['site_name'],
		        'keywords'=>$itemInfo['keyword'],
		        'description'=>$itemInfo['abstract'],
		 		'site_copyright'=>$systemInfo['site_copyright'],
				'icp_code'=>$systemInfo['icp_code'],
				'html'=>$systemInfo['html'],
		        'menuInfo'=>$menuInfo,
		        'itemInfo'=>$itemInfo,
				'parentId'=>$parentId,
		        'parentMenuInfo'=>$parentMenuInfo,
		        'location'=>$location
		        );
	    $layout = array(
				  'content'=>$this->load->view("{$this->_template}/index", $data, TRUE)
			      );
	    $this->load->view('layout/page_layout', $layout);
	    //缓存
	    if ($systemInfo['cache'] == 1) {
	    	$this->output->cache($systemInfo['cache_time']);
	    }
	}
}
/* End of file page.php */
/* Location: ./application/client/controllers/page.php */