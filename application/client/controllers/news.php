<?php
class News extends CI_Controller {
	private $_table = 'news';
	private $_template = 'news';
	public function __construct() {
		parent::__construct();
		$this->load->model(ucfirst($this->_table).'_model', 'tableObject', TRUE);
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
	}
	
	public function index($menuId = NULL, $page = 0) {
		$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
		//关键字信息
		$systemInfo = $this->System_model->get('*', array('id'=>1));
		$menuInfo = $this->Menu_model->get('menu_name, seo_menu_name, keyword, abstract', array('id'=>$menuId));
		if (!$menuInfo) {
			$data = array(
					'user_msg'=>'此栏目不存在',
					'user_url'=> base_url()
			);
			$this->session->set_userdata($data);
			redirect('/message/index');
		}
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
		//新闻列表
		$strWhere = NULL;
		$ids = $this->Menu_model->getChildMenus($menuId);
		$strWhere = "{$this->_table}.category_id in ({$ids}) and {$this->_table}.display=1";
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
		$this->pagination->initialize($paginationConfig);
		$pagination = $this->pagination->create_links();
		
		$itemList = $this->tableObject->gets($strWhere, $paginationConfig['per_page'], $page);
		//左侧分类
		$parentId = $this->Menu_model->getParentMenuId($menuId);
		$parentMenuInfo = $this->Menu_model->get('menu_name', array('id'=>$parentId));
		
		$data = array(
				'site_name'=>$systemInfo['site_name'],
				'index_name'=>$systemInfo['index_name'],
		        'client_index'=>$systemInfo['client_index'],
				'title'=>$menuInfo['seo_menu_name']?$menuInfo['seo_menu_name']:$menuInfo['menu_name'].$systemInfo['site_name'],
		        'keywords'=>$menuInfo['keyword'],
		        'description'=>$menuInfo['abstract'],
				'site_copyright'=>$systemInfo['site_copyright'],
				'icp_code'=>$systemInfo['icp_code'],
				'html'=>$systemInfo['html'],
		        'itemList'=>$itemList,
		        'menuId'=>$menuId,
		        'pagination'=>$pagination,
		        'paginationCount'=>$paginationCount,
		        'pageCount'=>ceil($paginationCount/$paginationConfig['per_page']),
		        'perPage'=>$paginationConfig['per_page'],
		        'template'=>$this->_template,
				'parentId'=>$parentId,
				'parentMenuInfo'=>$parentMenuInfo,
		        'location'=>$location
		        );
	    $layout = array(
				  'content'=>$this->load->view("{$this->_template}/index", $data, TRUE)
			      );
	    $this->load->view('layout/news_layout', $layout);
	    //缓存
	    if ($systemInfo['cache'] == 1) {
	    	$this->output->cache($systemInfo['cache_time']);
	    }
	}
	
    public function detail($id = NULL) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));	
    	$systemInfo = $this->System_model->get('*', array('id'=>1));
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
    	
    	//当前位置
		$location = '';
		if ($systemInfo['html']) {
			$location = "<a href='index.html'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
		} else {
			$location = "<a href='{$systemInfo['client_index']}'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
		}
		$url = $systemInfo['client_index'];
		$url .= $systemInfo['client_index']?'/':'';
		$url = $this->Menu_model->getLocation($itemInfo['category_id'], $systemInfo['html'], $url);
		$location .= $url;
    	//栏目关键词
    	$menuInfo = $this->Menu_model->get('html_path', array('id'=>$itemInfo['category_id']));
    	$ids = $this->Menu_model->getChildMenus($itemInfo['category_id']);
		//上下篇
		$prvInfo = $this->tableObject->getPrv($id, $ids);
		$nextInfo = $this->tableObject->getNext($id, $ids);
		//相关文章
		$relationIds = 0;
		if ($itemInfo && $itemInfo['relation']) {
		    $relationIds = preg_replace(array('/^,/', '/^，/', '/,$/', '/，$/', '/，/'), array('', '', '', '', ','), $itemInfo['relation']);
		}
		$relationList = $this->tableObject->gets("{$this->_table}.id in ({$relationIds})");
		$parentId = $this->Menu_model->getParentMenuId($itemInfo['category_id']);
		
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
				'html_path'=>$menuInfo['html_path'],
				'itemInfo'=>$itemInfo,
		        'prvInfo'=>$prvInfo,
				'nextInfo'=>$nextInfo,
		        'location'=>$location,
		        'template'=>$this->_template,
				'menuId'=>$itemInfo['category_id'],
				'id'=>$id,
				'parentId'=>$parentId,
		        'relationList'=>$relationList
		        );
		$layout = array(
				  'content'=>$this->load->view("{$this->_template}/detail", $data, TRUE)
			      );
	    $this->load->view('layout/page_layout', $layout);
        //缓存
	    if ($systemInfo['cache'] == 1) {
	    	$this->output->cache($systemInfo['cache_time']);
	    }
	}
}
/* End of file main.php */
/* Location: ./application/client/controllers/main.php */