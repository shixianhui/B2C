<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 多次调用的方法集成
 *
 */
class Advdbclass {
    //获取友情链接
	public function getLink() {
		$CI = & get_instance();
		$CI->load->model('Link_model', '', TRUE);

	    return $CI->Link_model->gets("display = 1 ");
	}

    //获取头部的栏目
	public function getHeadMenu() {
	    $CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$headWhere = "parent = 0 and hide = 0 and (position like 'head%' or position like '%,head' or position like '%,head,%')";
		return $CI->Menu_model->gets('id, menu_name, model, html_path, template, menu_type, url', $headWhere);
	}

    //获取导航栏目的栏目
    public function getNavigationMenu() {
	    $CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);

		return $CI->Menu_model->menuTree('id, menu_name, model, html_path, template, menu_type, url, cover_function, list_function, detail_function, en_menu_name', 0);
	}

	//获取版权的栏目
	public function getFooterMenu() {
	    $CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$footerWhere = "parent = 0 and hide = 0 and (position like 'footer%' or position like '%,footer' or position like '%,footer,%')";
		return $CI->Menu_model->gets('id, menu_name, model, html_path, template, menu_type, url', $footerWhere);
	}

	//获取产品分类,分类ID为已知
	public function getProductClass($id) {
	    $CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$parentId = $CI->Menu_model->getParentMenuId($id);
		return $CI->Menu_model->getChildMenuTree('id, menu_name, html_path, template', $parentId);
	}

    //获取产品分类,分类ID为已知
	public function getLeftProductClass() {
	    $CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$parentId = $CI->Menu_model->getParentMenuId(80);
		return $CI->Menu_model->getChildMenuTree('id, menu_name, html_path, template', $parentId);
	}

    //获取产品分类,分类ID为已知
    public function getMenuClass($menuId = NULL, $num = 100, $is_all = 1) {
	    $CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$parentId = $CI->Menu_model->getParentMenuId($menuId);

		return $CI->Menu_model->getChildMenuTree('id, menu_name, model, html_path, template, menu_type, url, cover_function, list_function, detail_function, en_menu_name', $parentId, $num, $is_all);
    }

    //获取产品分类,分类ID为已知
	public function getMenuInfo($menuId) {
	    $CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$parentId = $CI->Menu_model->getParentMenuId($menuId);

		return $CI->Menu_model->get('menu_name', array('id'=>$parentId));
    }

    //获取首页通栏广告
    public function getIndexAd() {
        $CI = & get_instance();
        $CI->load->model('Ad_model', '', TRUE);

        return $CI->Ad_model->gets('path, url', array('category_id'=>1, 'ad_type'=>'image', 'display'=>1), 8, 0);
	}

	//获取其它栏目通栏广告
	public function getOthorAd($id = NULL) {
		$CI = & get_instance();
		$CI->load->model('Ad_model', '', TRUE);

        return $CI->Ad_model->gets('path, url, ad_text, ad_type, content', array('category_id'=>$id, 'display'=>1));
	}

    //获取单条广告
	public function getSingleAd($id) {
		$CI = & get_instance();
		$CI->load->model('Ad_model', '', TRUE);
		$adInfo = $CI->Ad_model->gets('path, url', array('category_id'=>$id, 'ad_type'=>'image', 'display'=>1), 1, 0);

        return $adInfo?$adInfo[0]:'';
	}

    //获取单条广告
	public function getSingleAd2($id, $page = 0) {
		$CI = & get_instance();
		$CI->load->model('Ad_model', '', TRUE);
		$adInfo = $CI->Ad_model->gets('path, url, ad_text', array('category_id'=>$id, 'ad_type'=>'image', 'display'=>1), $page+1, $page);

        return $adInfo?$adInfo[0]:'';
	}

	/**
	 * 获取广告
	 *
	 * @param unknown_type $id   分类ID
	 * @param unknown_type $num  数量
	 */
	public function getAd($id, $num = 10) {
		$CI = & get_instance();
		$CI->load->model('Ad_model', '', TRUE);

		return $CI->Ad_model->gets('path, url, ad_text', array('category_id'=>$id, 'ad_type'=>'image', 'display'=>1), $num, 0);
	}

	//获取栏目的url
	public function getMenuUrl($menuId, $isHtml = false, $client_index = '') {
		$CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$url = '';

	    $menuInfo = $CI->Menu_model->get('id, html_path, menu_type, template', array('id'=>$menuId));
	    if ($menuInfo) {
		    if ($menuInfo['menu_type'] == '3') {
	    		$url = $menuInfo['url'];
	    	} else {
		    	if ($isHtml) {
				    $url = $menuInfo['html_path'];
				} else {
				    $url = $client_index;
		    	    $url .= $client_index?'/':'';
		    	    $url .= "{$menuInfo['template']}/index/{$menuInfo['id']}.html";
				}
	    	}
	    }

    	return $url;
	}

    //头条新闻
	public function getHeaderNews() {
		$CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$CI->load->model('News_model', '', TRUE);
		$url = '';
		$ids = $CI->Menu_model->getChildMenus(83);
		$strWhere = "news.display = 1 and news.category_id in ({$ids}) and (news.custom_attribute like '%s' or news.custom_attribute like 's%' or news.custom_attribute like '%,s,%') ";

    	return $CI->News_model->gets($strWhere, 5, 0);
	}

    //获取客服信息
	public function getOnlineQQ() {
		$CI = & get_instance();
		$CI->load->model('Page_model', '', TRUE);

		$pageInfo = $CI->Page_model->get('content', array('id'=>6));

    	return $pageInfo?$pageInfo['content']:'';
	}

    //单页面内容
	public function getFooterPage($menuId) {
		$CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$CI->load->model('Page_model', '', TRUE);
		$url = '';
		$ids = $CI->Menu_model->getChildMenus($menuId);
		$strWhere = "page.display = 1 and page.category_id in ({$ids}) ";

    	return $CI->Page_model->gets($strWhere, 5, 0);
	}

    //单页面内容
	public function getPages($menuId) {
		$CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$CI->load->model('Page_model', '', TRUE);
		$url = '';
		$ids = $CI->Menu_model->getChildMenus($menuId);
		$strWhere = "page.display = 1 and page.category_id in ({$ids}) ";

    	return $CI->Page_model->gets($strWhere);
	}

	//获取推荐产品
	public function getTuJieProduct($menuId) {
	    $CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$CI->load->model('Product_model', '', TRUE);
		$url = '';
		$strWhere = "(product.custom_attribute like '%c' or product.custom_attribute like 'c%' or product.custom_attribute like '%,c,%') and product.display = 0";

		return $CI->Product_model->gets($strWhere, 20, 0);
	}

    //获取特荐产品
	public function getTeJieProduct($menuId) {
	    $CI = & get_instance();
		$CI->load->model('Menu_model', '', TRUE);
		$CI->load->model('Product_model', '', TRUE);
		$url = '';
		$strWhere = "(product.custom_attribute like '%a' or product.custom_attribute like 'a%' or product.custom_attribute like '%,a,%') and product.display = 0";

		return $CI->Product_model->gets($strWhere, 20, 0);
	}

         //获取购物车商品数量
	public function getCartSum($userId = 0) {
	    $CI = & get_instance();
		$CI->load->model('Cart_model', '', TRUE);

		return $CI->Cart_model->rowSum(array('user_id'=>$userId));
	}
        //获取购物车列表
        public function getCart($userId = 0){
            $CI = & get_instance();
		$CI->load->model('Cart_model', '', TRUE);
                return $CI->Cart_model->gets(array('user_id'=>$userId));
        }

	//获取关键词
    public function getKeyword() {
	    $CI = & get_instance();
		$CI->load->model('System_model', '', TRUE);

		return $CI->System_model->get('web_site, text_keyword, link_keyword, globle_qq_service, left_qq_service, online_recharge', array('id'=>1));
	}

	//产品分类
	public function get_product_category_list() {
		$CI = & get_instance();
		$CI->load->model('Product_category_model', '', TRUE);

		return $CI->Product_category_model->menuTree();
	}

	//品牌
	public function get_product_brand_list() {
		$CI = & get_instance();
		$CI->load->model('Brand_model', '', TRUE);

		return $CI->Brand_model->gets('*', array('display'=>1));
	}


	/**
	 * 全局内容调用
	 *
	 * @param $table     模型-news=新闻；cases=案例；teacher=优秀导师；team=优秀团队；download=软件下载；product=产品；video=视频；picture=图库；
	 * @param $menuId    分类ID
	 * @param $type      属性-头条[h]；推荐[c];特荐[a]；幻灯[f]；滚动[s]；加粗[b]；图片[p]；跳转[j]
	 * @param $is_image  1=仅调用图片
	 * @param $num       数量
	 */
	public function get_cus_list($table = 'news', $menuId, $type = 'c', $is_image = 0, $num = 10) {
		$CI = & get_instance();
		$tmp_obj = ucfirst($table).'_model';
		$CI->load->model('Menu_model', '', TRUE);
		$CI->load->model(ucfirst($table).'_model', $tmp_obj, TRUE);
		$url = '';
		$ids = $CI->Menu_model->getChildMenus($menuId);
		$strWhere = "{$table}.display = 1 and {$table}.category_id in ({$ids})";
		if ($type) {
			$strWhere .= " and ({$table}.custom_attribute like '%{$type}' or {$table}.custom_attribute like '{$type}%' or {$table}.custom_attribute like '%,{$type},%') ";
		}
		if ($is_image) {
			$strWhere .= " and {$table}.path <> ''  ";
		}

		return $CI->$tmp_obj->gets($strWhere, $num, 0);
	}
        /**
	 * 产品属性控制
	 *
	 * @param $category_id     分类ID；
	 * @param $type      属性-头条[h]；推荐[c];特荐[a]；幻灯[f]；滚动[s]；加粗[b]；图片[p]；跳转[j]
	 * @param $num       数量
	 */
        public function get_product_cus_list($category_id,$type = 'c',$num){
               $CI = & get_instance();
               $CI->load->model('Product_model', '', TRUE);
               $CI->load->model('Product_category_model', '', TRUE);
               $CI->load->model('Product_category_ids_model', '', TRUE);
               if(empty($category_id)){
                    $product = $CI->Product_model->gets('id,path,title,sell_price,market_price',"display = 1 and find_in_set('$type',custom_attribute)",$num);
                     return $product;
                }
               $category = $CI->Product_category_model->get('parent_id,id',"id = $category_id");
               $ids = '';
               if(empty($category)){
                   return false;
               }
               if($category['parent_id']){
                   $ids = $category_id;
               }else{
                  $categorys = $CI->Product_category_model->gets("parent_id = $category_id");
                  foreach($categorys as $ls){
                      $ids .= $ls['id'].',';
                  }
               }
               $ids = trim($ids,',');
               $result = $CI->Product_category_ids_model->gets('product_id',"product_category_id in ($ids)");
               if(empty($result)){
                   return false;
               }
               $product_ids = '';
               foreach($result as $item){
                   $product_ids .= $item['product_id'].',';
               }
               $product_ids = trim($product_ids,',');
               $product = $CI->Product_model->gets('id,path,title,sell_price,market_price',"display = 1 and id in ($product_ids) and find_in_set('$type',custom_attribute)",$num);
               return $product;
        }

    public function get_user_info($user_id = NULL) {
        $CI = & get_instance();
        $CI->load->model('User_model', '', TRUE);

        return $CI->User_model->get('distributor', array('id'=>$user_id));
    }
}
// END Validateloginclass class

/* End of file Validateloginclass.php */
/* Location: ./system/libraries/Validateloginclass.php */