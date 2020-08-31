<?php

class Product extends CI_Controller {
    private $_table = 'product';
    private $_template = 'product';
    private $_product_type_arr = array(
    		'a' => 'A类产品',
    		'b' => 'B类产品',
    		'c' => 'C类产品'
        );
	private $_score_type_arr = array(
	        'gold'=>array('金象积分', "'a','b','c'"),
	        'silver'=>array('银象积分', "'b','c'"),
	    );

    public function __construct() {
        parent::__construct();
        $this->load->model(ucfirst($this->_table) . '_model', 'tableObject', TRUE);
        $this->load->model('Menu_model', '', TRUE);
        $this->load->model('System_model', '', TRUE);
        $this->load->model('Orders_detail_model', '', TRUE);
        $this->load->model('Orders_model', '', TRUE);
        $this->load->model('Brand_model', '', TRUE);
        $this->load->model('User_model', '', TRUE);
        $this->load->model('Attachment_model', '', TRUE);
        $this->load->model('Product_browse_model', '', TRUE);
        $this->load->model('Product_favorite_model', '', TRUE);
        $this->load->model('Product_category_ids_model', '', TRUE);
        $this->load->model('Product_category_model', '', TRUE);
        $this->load->model('Postage_way_model', '', TRUE);
        $this->load->model('Free_postage_setting_model', '', TRUE);
        $this->load->model('Postage_price_model', '', TRUE);
        $this->load->model('Comment_model', '', TRUE);
        $this->load->model('Product_size_color_model', '', TRUE);
    }

    public function index($menu_str = '80', $page = 0) {
    	$this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $menuInfo = $this->Menu_model->get('menu_name, keyword, abstract', array('id' => 80));
        //当前位置
        $location = '';
        if ($systemInfo['html']) {
            $location = "<a href='index.html'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
        } else {
            $location = "<a href='{$systemInfo['client_index']}'>{$systemInfo['index_name']}</a> <code>&gt;</code> ";
        }
        $url = $systemInfo['client_index'];
        $url .= $systemInfo['client_index'] ? '/' : '';
        $url = $this->Menu_model->getLocation(80, $systemInfo['html'], $url);
        $location .= $url;

        $menu_id = 80;
        $product_venue_id = 0;
        $parent_category_id = 0;
        $parent_category_name = '';
        $category_id = 0;
        $category_name = '';
        $brand_id = 0;
        $brand_name = '';
		$score_type = '0';
		$score_type_name = '';
        $product_count = 0;
        $order = 'id';
        $by = 'desc';
        $search_keyword = '';
        $strWhere = "display = 1";
        $strWhereProductCategory = array('parent_id'=>0, 'display'=>1);
        if ($menu_str) {
            $menu_str_arr = explode('-', $menu_str);
            if ($menu_str_arr) {
            	if (array_key_exists("0", $menu_str_arr)) {
            		$menu_id = $menu_str_arr[0];
            	}
            	if (array_key_exists("1", $menu_str_arr)) {
            		$product_venue_id = $menu_str_arr[1];
            	}
            	if (array_key_exists("2", $menu_str_arr)) {
            		$category_id = $menu_str_arr[2];
            	}
            	if (array_key_exists("3", $menu_str_arr)) {
            		$brand_id = $menu_str_arr[3];
            	}
				if (array_key_exists("4", $menu_str_arr)) {
            		$score_type = $menu_str_arr[4];
            	}
            	if (array_key_exists("5", $menu_str_arr)) {
            		$order = $menu_str_arr[5];
            	}
            	if (array_key_exists("6", $menu_str_arr)) {
            		if ($menu_str_arr[6] == 'desc' || $menu_str_arr[6] == 'asc') {
            			$by = $menu_str_arr[6];
            		}
            	}
            }
            if ($category_id) {
                //判断category_id是否是顶级分类
                $product_category_info = $this->Product_category_model->get('parent_id, id, product_category_name', array('id'=>$category_id, 'display'=>1));
                if ($product_category_info) {
                	$parent_category_id = $product_category_info['parent_id'];
                	$category_name = $product_category_info['product_category_name'];
                	if ($product_category_info['parent_id'] == 0) {
                		$strWhere .= " and id in (select product_id from product_category_ids where parent_id = {$product_category_info['id']}) ";
                	} else {
                		$strWhere .= " and id in (select product_id from product_category_ids where product_category_id = {$product_category_info['id']}) ";
                	}
                	if ($parent_category_id) {
                		$product_category_info = $this->Product_category_model->get('product_category_name', array('id'=>$parent_category_id, 'display'=>1));
                		if ($product_category_info) {
                			$parent_category_name = $product_category_info['product_category_name'];
                		}
                	}
                }
            } else {
                if ($product_venue_id) {
                	$strWhere .= " and id in (select product_id from product_category_ids where product_category_id in (select id from product_category where product_venue_id = {$product_venue_id}))";
                }
            }
            if ($brand_id) {
            	$brand_info = $this->Brand_model->get('brand_name',array('id'=>$brand_id));
            	if ($brand_info) {
            		$brand_name = $brand_info['brand_name'];
            		$strWhere .= " and brand_name regexp '{$brand_name}' ";
            	}
            }
			if ($score_type) {
				$strWhere .= " and product_type in (".$this->_score_type_arr[$score_type][1].") ";
			}
        }
        if ($_GET) {
        	$search_keyword = $this->input->get('search_keyword', TRUE);
        	if ($search_keyword) {
        		$search_keyword = str_replace(array('，', '的'), '', $search_keyword);
        		$strWhere .= " and (title REGEXP '{$search_keyword}' or keyword REGEXP '{$search_keyword}' )";
        	}
        }
        //分页
        $paginationCount = $this->tableObject->rowCount($strWhere);
        $this->config->load('pagination_config', TRUE);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "index.php/product/index/{$menu_str}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $paginationConfig['per_page'] = 20;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $item_list = $this->tableObject->gets('product.id,product.title,product.sell_price,product.favorite_num,product.path,product.abstract,product.market_price', $strWhere, $paginationConfig['per_page'], $page, $order, $by);
        //品牌
        $str_b_where = "display = 1 ";
        if ($product_venue_id) {
        	//子级
        	if ($parent_category_id) {
        		$str_b_where .= " and id in (select brand_id from brand_category_ids where product_category_id = {$category_id}) ";
        	} else {
        		//父级
        		if ($category_id) {
        			$str_b_where .= " and id in (select brand_id from brand_category_ids where parent_id = {$category_id}) ";
        		} else {
        			$str_b_where .= " and id in (select brand_id from brand_category_ids where product_category_id in (select id from product_category where product_venue_id = {$product_venue_id}))";
        		}
        	}
        } else {
        	if ($parent_category_id) {
        		$str_b_where .= " and id in (select brand_id from brand_category_ids where product_category_id = {$category_id} )";
        	} else {
        		if ($category_id) {
        			$str_b_where .= " and id in (select brand_id from brand_category_ids where parent_id = {$category_id} )";
        		}
        	}
        }
        $brand_list = $this->Brand_model->gets('*', $str_b_where);
        //产品分类
        $str_p_c_where = array('parent_id'=>$category_id, 'display'=>1);
        if ($product_venue_id) {
        	$str_p_c_where['product_venue_id'] = $product_venue_id;
        }
        $product_category_list = $this->Product_category_model->gets($str_p_c_where);
        if ($product_category_list) {
        	foreach ($product_category_list as $key=>$value) {
        		$count = 0;
        		if ($value['parent_id'] == 0) {
        			$count = $this->Product_category_ids_model->get_product_count(array('product_category_ids.parent_id'=>$value['id'], 'product.display'=>1));
        			$product_category_list[$key]['product_count'] = $count;
        		} else {
        			$count = $this->Product_category_ids_model->get_product_count(array('product_category_ids.product_category_id'=>$value['id'], 'product.display'=>1));
        			$product_category_list[$key]['product_count'] = $count;
        		}
        		$product_count += $count;
        	}
        }

        $str_category_name = '';
        if ($parent_category_name && $category_name) {
        	$str_category_name = $parent_category_name.'->'.$category_name;
        } else {
        	if ($category_name) {
        		$str_category_name = $category_name;
        	} else {
        		$str_category_name = '全部商品';
        	}
        }

        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $str_category_name.'-'.$systemInfo['site_name'],
            'keywords' => $menuInfo['keyword'],
            'description' => $menuInfo['abstract'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'location' => $location,
            'item_list' => $item_list,
            'brand_list' => $brand_list,
            'product_category_list'=> $product_category_list,
            'product_count' => $product_count,
        	'parent_category_id'=>$parent_category_id,
        	'parent_category_name'=>$parent_category_name,
        	'product_venue_id'=>$product_venue_id,
            'category_id' => $category_id,
        	'category_name' => $category_name,
            'brand_id' => $brand_id,
        	'brand_name' => $brand_name,
        	'score_type'=>$score_type,
        	'score_type_name'=>$score_type?$this->_score_type_arr[$score_type][0]:'',
            'order' => $order,
            'by' => $by,
            'score_type_arr'=>$this->_score_type_arr,
        	'search_keyword'=>$search_keyword,
            'pagination' => $pagination
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

    public function detail($id = NULL, $page = 0) {
        $this->session->set_userdata(array("gloabPreUrl" => base_url() . 'index.php/' . uri_string()));
        $systemInfo = $this->System_model->get('*', array('id' => 1));
        $item_info = $this->tableObject->get('*', array('id' => $id, 'display' => 1));
        if (!$item_info) {
            $data = array(
                'user_msg' => '此产品不存在或被删除',
                'user_url' => base_url()
            );
            $this->session->set_userdata($data);
            redirect('/message/index');
        }
        //记录浏览次数
        $this->tableObject->save(array('hits' => $item_info['hits'] + 1), array('id' => $id));

        $attachment_list = NULL;
        if ($item_info && $item_info['batch_path_ids']) {
            $tmp_atm_ids = preg_replace(array('/^_/', '/_$/', '/_/'), array('', '', ','), $item_info['batch_path_ids']);
            $attachment_list = $this->Attachment_model->gets2($tmp_atm_ids);
        }
        //颜色
        $color_list = $this->Product_size_color_model->gets('id, color_id, color_name, color_name_hint, path', array('product_id'=>$id), 'color_id');
        //尺码
        $size_list = $this->Product_size_color_model->gets('id, size_id, size_name, size_name_hint', array('product_id'=>$id), 'size_id');
        $priceInfo = $this->tableObject->getPrice($id);
        if (!$priceInfo['min_price'] && !$priceInfo['max_price']) {
            $priceInfo['min_price'] = $item_info['sell_price'];
            $priceInfo['max_price'] = $item_info['sell_price'];
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
        $url = $this->Menu_model->getLocation(80, $systemInfo['html'], $url);

        $location .= $url;
        //每种属性都唯一
        $strWhere = "find_in_set('a',custom_attribute)";
        $aProductList = $this->tableObject->gets('*', $strWhere, 18, 0);
        $hotProductList = $this->tableObject->gets('*', $strWhere, 10, 0, 'product.sales');
        //已浏览过的商品
        $browseproductList = $this->Product_browse_model->gets2(array('product_browse.user_id' => get_cookie('user_id')), 20, 0);
        //添加浏览数据-记录用户所有的浏览记录
        if ($id && get_cookie('user_id')) {
            if (!$this->Product_browse_model->rowCount(array('product_id' => $id, 'user_id' => get_cookie('user_id')))) {
                $browseFileds = array(
                    'product_id' => $id,
                    'user_id' => get_cookie('user_id'),
                    'add_time' => time()
                );
                $this->Product_browse_model->save($browseFileds);
            }
        }
        //配送方式
        $postage_way_list = $this->Postage_way_model->gets('*', array('display' => 1, 'id'=>$item_info['postage_way_id']));
        $free_postage_setting = $this->Free_postage_setting_model->get('*', array('id' => 1));
        //评论列表
        $comment_list = $this->Comment_model->gets('*', array('product_id' => $id));
		if ($comment_list) {
			foreach($comment_list as $key=>$value) {
				//昵称
				$nickname = '';
				$user_info = $this->User_model->getInfo('username, nickname', array('id'=>$value['user_id']));
				if ($user_info) {
					if ($user_info['nickname']) {
						$nickname = $user_info['nickname'];
					} else {
						$nickname = createMobileBit($user_info['username']);
					}
				}
				$comment_list[$key]['nickname'] = $nickname;
			}
		}
        $favorate_status = '';
        if (get_cookie('user_id')) {
            if ($this->Product_favorite_model->rowCount(array('user_id' => get_cookie('user_id'), 'product_id' => $id)) > 0) {
                $favorate_status = 'add';
            };
        }
        $data = array(
            'site_name' => $systemInfo['site_name'],
            'index_name' => $systemInfo['index_name'],
            'index_url' => $systemInfo['index_url'],
            'client_index' => $systemInfo['client_index'],
            'title' => $item_info['title'] . $systemInfo['site_name'],
            'keywords' => $item_info['keyword'],
            'description' => $item_info['abstract'],
            'site_copyright' => $systemInfo['site_copyright'],
            'icp_code' => $systemInfo['icp_code'],
            'html' => $systemInfo['html'],
            'systemInfo' => $systemInfo,
            'item_info' => $item_info,
            'aProductList' => $aProductList,
            'hotProductList' => $hotProductList,
            'browseproductList' => $browseproductList,
            'attachment_list' => $attachment_list,
            'location' => $location,
            'color_list' => $color_list,
            'size_list' => $size_list,
            'parentId' => '80',
            'priceInfo' => $priceInfo,
            'comment_list' => $comment_list,
            'postage_way_list' => $postage_way_list,
            'free_postage_setting' => $free_postage_setting,
        	'product_type_arr'=>$this->_product_type_arr,
            'favorate_status' => $favorate_status
        );
        $layout = array(
            'content' => $this->load->view("{$this->_template}/detail", $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
        //缓存
        if ($systemInfo['cache'] == 1) {
            $this->output->cache($systemInfo['cache_time']);
        }
    }

    //清除浏览的商品
    public function clear() {
        checkLoginAjax();
        if ($this->Product_browse_model->delete(array('user_id' => get_cookie('user_id')))) {
            printAjaxSuccess('success', '清除成功');
        } else {
            printAjaxError('fail', '清除失败！');
        }
    }

    //收藏商品
    public function favorite() {
        checkLoginAjax();
        if ($_POST) {
            $productId = $this->input->post('product_id');
            if (!$productId) {
                printAjaxError('fail', '操作异常，刷新重试');
            }
            $item_info = $this->tableObject->get('favorite_num', array('id' => $productId));
            if (!$item_info) {
                printAjaxError('fail', '此商品不存在，收藏失败');
            }
            if ($this->Product_favorite_model->rowCount(array('product_id' => $productId, 'user_id' => get_cookie('user_id')))) {
                printAjaxError('fail', '此商品已收藏，不用重复收藏');
            }
            $favorite_fields = array(
                'product_id' => $productId,
                'user_id' => get_cookie('user_id'),
                'add_time' => time()
            );
            if ($this->Product_favorite_model->save($favorite_fields)) {
                $this->tableObject->save(array('favorite_num' => $item_info['favorite_num'] + 1), array('id' => $productId));
                printAjaxSuccess('success', '收藏成功');
            } else {
                printAjaxError('fail', '收藏失败');
            }
        }
    }

    /**
     * 取消收藏
     * @param type $id
     */
    public function delete_product_favorite() {
        //判断是否登录
        $user_id = get_cookie('user_id');
        if (empty($user_id)) {
            printAjaxError('login', '还没有登录，请先登录');
        }
        if ($_POST) {
            $product_id = $this->input->post('product_id', TRUE);
            if (!$product_id) {
                printAjaxError('fail', '操作异常');
            }
            if ($this->Product_favorite_model->rowCount(array('product_id' => $product_id, 'user_id' => $user_id)) == 0) {
                printAjaxError('fail', '未收藏此商品或已删除！');
            }
            if ($this->Product_favorite_model->delete(array('product_id' => $product_id, 'user_id' => $user_id))) {
                printAjaxData(array('action' => 'delete', 'product_id' => $product_id));
            } else {
                printAjaxError('fail', '删除失败！');
            }
        }
    }

    //获取库存
    public function get_stock() {
    	if ($_POST) {
    		$product_id = $this->input->post('product_id');
    		$color_id = $this->input->post('color_id', TRUE);
    		$size_id = $this->input->post('size_id', TRUE);

    		if (!$product_id || !$color_id || !$size_id) {
    			printAjaxError('fail', '操作异常');
    		}
    		if ($product_id && $color_id && $size_id) {
    			$item_info = $this->tableObject->getProductStock($product_id, $color_id, $size_id);
    			if ($item_info) {
    				printAjaxData($item_info);
    			} else {
    				printAjaxError('fail', '获取失败');
    			}
    		}
    	}
    }

    //分类转移
    private function move_category($from_category_id = 0,$to_category_id = 0){
        set_time_limit(0);
        if(!$from_category_id || !$to_category_id){
            echo '分类id不能为空';
            exit;
        }
        $item_info = $this->Product_category_model->get('parent_id',array('id'=>$to_category_id));
        if(empty($item_info)){
            echo '您要转移分类id不存在';
            exit;
        }
        $item_list = $this->Product_category_ids_model->gets('*',array('product_category_id'=>$from_category_id));
        if(empty($item_list)){
            echo '您要被转移的分类id没有一项数据';
            exit;
        }
        $i = 0;
        foreach($item_list as $item){
            $i++;
            $this->Product_category_ids_model->delete(array('id'=>$item['id']));
             $pc_fields = array(
                                'parent_id' => $item_info['parent_id'],
                                'product_category_id' => $to_category_id,
                                'product_id' => $item['product_id']
                            );
            $this->Product_category_ids_model->save($pc_fields);
        }
        echo '已成功被转移了'.$i.'项数据';
    }

}

/* End of file page.php */
/* Location: ./application/client/controllers/page.php */