<?php
class Menu_model extends CI_Model {

	private $_tableName = 'menu';

    public function __construct() {
		parent::__construct();
	}

	public function gets($select = '*', $strWhere = NULL) {
		$ret = array();
		$this->db->select($select);
		$this->db->order_by('sort', 'ASC');
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

	public function get($select = '*', $strWhere = NULL) {
		$ret = array();
		$this->db->select($select);
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0){
			$ret = $query->result_array();
			return $ret[0];
		}

		return $ret;
	}

	/**
	 *
	 * 获取所有的menu id
	 * @param int $id 上级id
	 * return string
	 */
	public function getChildMenus($id) {
		$ids = $id.',';
		$menuList5 = $this->gets('id', array('parent'=>$id));
		foreach ($menuList5 as $menu5) {
		    $ids .= $menu5['id'].',';
		    $menuList4 = $this->gets('id', array('parent'=>$menu5['id']));
		    foreach ($menuList4 as $menu4) {
		    	$ids .= $menu4['id'].',';
		    	$menuList3 = $this->gets('id', array('parent'=>$menu4['id']));
		    	foreach ($menuList3 as $menu3) {
		    	    $ids .= $menu3['id'].',';
		    	    $menuList2 = $this->gets('id', array('parent'=>$menu3['id']));
		    	    foreach ($menuList2 as $menu2) {
		    	        $ids .= $menu2['id'].',';
		    	    }
		    	}
		    }
		}

		return substr($ids, 0, -1);
	}

	/**
	 * 获取一级栏目id
	 *
	 * @param int $childId 子栏目
	 * return id int
	 */
	public function getParentMenuId($childId) {
		$id = $childId;
		while (true) {
			$menuInfo = $this->get('id, parent', array('id'=>$id));
			if ($menuInfo) {
				if ($menuInfo['parent'] == 0) {
					return $menuInfo['id'];
				} else {
					$id = $menuInfo['parent'];
				}
			} else {
				return NULL;
			}
		}
	}
	
	//获取导航栏树结构
    public function menuTree($select = '*', $parentId = NULL) {
    	$strWhere = "hide = 0 and (position like 'navigation%' or position like '%,navigation' or position like '%,navigation,%')";
	    $menuList = $this->gets($select, $strWhere." and parent = {$parentId}");
	    foreach ($menuList as $key=>$value) {
	        $subMenuList = $this->gets($select, $strWhere." and parent = {$value['id']}");
	        foreach ($subMenuList as $sKey=>$sValue) {
	            $sSubMenuList = $this->gets($select, $strWhere." and parent = {$sValue['id']}");
	            $subMenuList[$sKey]['subMenuList'] = $sSubMenuList;
	        }
	        $menuList[$key]['subMenuList'] = $subMenuList;
	    }

	    return $menuList;
	}
	
    public function menuTreeByModel($select = '*', $model = NULL) {
		$whereArray = array('parent'=>0);
		if (! empty($model)) {
		    $whereArray['model'] = $model;
		}
	    $menuList = $this->gets($select, $whereArray);
	    foreach ($menuList as $key=>$value) {
	    	$subWhereArray = array('parent'=>$value['id']);
	    	if (! empty($model)) {
	    	    $subWhereArray['model'] = $model;
	    	}
	        $subMenuList = $this->gets($select, $subWhereArray);
	        foreach ($subMenuList as $sKey=>$sValue) {
	        	$sSubWhereArray = array('parent'=>$sValue['id']);
		        if (! empty($model)) {
		    	    $sSubWhereArray['model'] = $model;
		    	}
	            $sSubMenuList = $this->gets($select, $sSubWhereArray);
	            $subMenuList[$sKey]['subMenuList'] = $sSubMenuList;
	        }
	        $menuList[$key]['subMenuList'] = $subMenuList;
	    }

	    return $menuList;
	}
	
    //获取网站地图
    public function getSitemap($select = '*', $parentId = NULL) {
    	$menuList = $this->gets($select, array('parent'=>$parentId));
	    foreach ($menuList as $key=>$value) {
	        $subMenuList = $this->gets($select, array('parent'=>$value['id']));
	        foreach ($subMenuList as $sKey=>$sValue) {
	            $sSubMenuList = $this->gets($select, array('parent'=>$sValue['id']));
	            $subMenuList[$sKey]['subMenuList'] = $sSubMenuList;
	        }
	        $menuList[$key]['subMenuList'] = $subMenuList;
	    }

	    return $menuList;
	}
	
    //获取子级栏目树结构,不包括父级
    public function getChildMenuTree($select = '*', $parentId = NULL) {
    	$retList = array();
        $whereArray['id'] = $parentId;
	    $menuList = $this->gets($select, $whereArray);
	    foreach ($menuList as $key=>$value) {
	    	$subWhereArray = array('parent'=>$value['id']);
	        $subMenuList = $this->gets($select, $subWhereArray);
	        foreach ($subMenuList as $sKey=>$sValue) {
	        	$sSubWhereArray = array('parent'=>$sValue['id']);
	            $sSubMenuList = $this->gets($select, $sSubWhereArray);
	            $subMenuList[$sKey]['subMenuList'] = $sSubMenuList;
	        }
	        $retList = $subMenuList;
	    }

	    return $retList;
	}
	
	public function getLocation($id = NULL, $html = false, $url = '') {
		$str = '';
	    if ($id) {
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$id));
	        if (! $info) {
	            return $str;
	        }
	        if ($html) {
	        	$str = "<a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a> <code>&gt;</code> ";
	        } else {
	            $str = "<a href='{$url}{$info['template']}/index/{$info['id']}.html'>{$info['menu_name']}</a> <code>&gt;</code> ";
	        }
	        if ($info['parent'] == 0) {
	            return $str;
	        }	        
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$info['parent']));
		    if ($html) {
		        $str = "<a  href='{$info['html_path']}/index.html'>{$info['menu_name']}</a> <code>&gt;</code> ".$str;
		    } else {
		        $str = "<a  href='{$url}{$info['template']}/index/{$info['id']}.html'>{$info['menu_name']}</a> <code>&gt;</code> ".$str;
		    }
	        if ($info['parent'] == 0) {
	            return $str;
	        }
	        //三级
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$info['parent']));
		    if ($html) {
		        $str = "<a  href='{$info['html_path']}/index.html'>{$info['menu_name']}</a> <code>&gt;</code> ".$str;
		    } else {
		        $str = "<a  href='{$url}{$info['template']}/index/{$info['id']}.html'>{$info['menu_name']}</a> <code>&gt;</code> ".$str;
		    }
	    }
	    
	    return $str;
	}
	
    public function getLocation4($id = NULL, $html = false, $url = '') {
		$str = '';
	    if ($id) {
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$id));
	        if (! $info) {
	            return $str;
	        }
	        if ($html) {
	        	$str = "<a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a> <code>&gt;</code> ";
	        } else {
	            $str = "<a href='{$url}gift/index/{$info['id']}.html'>{$info['menu_name']}</a> <code>&gt;</code> ";
	        }
	        if ($info['parent'] == 0) {
	            return $str;
	        }	        
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$info['parent']));
		    if ($html) {
		        $str = "<a  href='{$info['html_path']}/index.html'>{$info['menu_name']}</a> <code>&gt;</code> ".$str;
		    } else {
		        $str = "<a  href='{$url}gift/index/{$info['id']}.html'>{$info['menu_name']}</a> <code>&gt;</code> ".$str;
		    }
	        if ($info['parent'] == 0) {
	            return $str;
	        }
	        //三级
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$info['parent']));
		    if ($html) {
		        $str = "<a  href='{$info['html_path']}/index.html'>{$info['menu_name']}</a> <code>&gt;</code> ".$str;
		    } else {
		        $str = "<a  href='{$url}gift/index/{$info['id']}.html'>{$info['menu_name']}</a> <code>&gt;</code> ".$str;
		    }
	    }
	    
	    return $str;
	}
	
    public function getLocation2($id = NULL, $html = false, $url = '') {
		$str = '';
	    if ($id) {
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$id));
	        if (! $info) {
	            return $str;
	        }
	        if ($html) {
	        	$str = "<span><a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>";
	        } else {
	            $str = "<span><a href='{$url}{$info['template']}/index/{$info['id']}.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>";
	        }
	        if ($info['parent'] == 0) {
	            return $str;
	        }	        
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$info['parent']));
		    if ($html) {
		        $str = "<span><a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>".$str;
		    } else {
		        $str = "<span><a href='{$url}{$info['template']}/index/{$info['id']}.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>".$str;
		    }
	        if ($info['parent'] == 0) {
	            return $str;
	        }
	        //三级
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$info['parent']));
		    if ($html) {
		        $str = "<span><a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>".$str;
		    } else {
		        $str = "<span><a href='{$url}{$info['template']}/index/{$info['id']}.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>".$str;
		    }
	    }
	    
	    return $str;
	}
	
    public function getLocation22($id = NULL, $html = false, $url = '') {
		$str = '';
	    if ($id) {
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$id));
	        if (! $info) {
	            return $str;
	        }
	        if ($html) {
	        	$str = "<span><a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>";
	        } else {
	            $str = "<span><a href='{$url}gift/index/{$info['id']}.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>";
	        }
	        if ($info['parent'] == 0) {
	            return $str;
	        }	        
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$info['parent']));
		    if ($html) {
		        $str = "<span><a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>".$str;
		    } else {
		        $str = "<span><a href='{$url}gift/index/{$info['id']}.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>".$str;
		    }
	        if ($info['parent'] == 0) {
	            return $str;
	        }
	        //三级
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$info['parent']));
		    if ($html) {
		        $str = "<span><a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>".$str;
		    } else {
		        $str = "<span><a href='{$url}gift/index/{$info['id']}.html'>{$info['menu_name']}</a></span><span class='arrow'>&gt;</span>".$str;
		    }
	    }
	    
	    return $str;
	}
	
    public function getLocation3($id = NULL, $html = false, $url = '') {
		$str = '';
	    if ($id) {
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$id));
	        if (! $info) {
	            return $str;
	        }
	        if ($html) {
	        	$str = "<a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a>";
	        } else {
	            $str = "<a href='{$url}{$info['template']}/index/{$info['id']}.html'>{$info['menu_name']}</a>";
	        }
	        if ($info['parent'] == 0) {
	            return $str;
	        }	        
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$info['parent']));
		    if ($html) {
		        $str = "<a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a>".$str;
		    } else {
		        $str = "<a href='{$url}{$info['template']}/index/{$info['id']}.html'>{$info['menu_name']}</a>".$str;
		    }
	        if ($info['parent'] == 0) {
	            return $str;
	        }
	        //三级
	        $info = $this->get('id, parent, menu_name, html_path, template', array('id'=>$info['parent']));
		    if ($html) {
		        $str = "<a href='{$info['html_path']}/index.html'>{$info['menu_name']}</a>".$str;
		    } else {
		        $str = "<a href='{$url}{$info['template']}/index/{$info['id']}.html'>{$info['menu_name']}</a>".$str;
		    }
	    }
	    
	    return $str;
	}
}
/* End of file menu_model.php */
/* Location: ./application/admin/models/menu_model.php */