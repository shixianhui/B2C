<?php
class Store_model extends CI_Model {

	private $_tableName = 'store';
	private $_userTName = 'user';
	private $_store_gradeTName = 'store_grade';

	public function __construct() {
		 parent::__construct();
	}

	public function save($data, $where = NULL) {
		$ret = 0;

		if (! empty($where)) {
			$ret = $this->db->update($this->_tableName, $data, $where);
		} else {
			$this->db->insert($this->_tableName, $data);
			$ret = $this->db->insert_id();
		}

		return $ret > 0 ? TRUE : FALSE;

	}

	public function delete($where = '') {
		return $this->db->delete($this->_tableName, $where) > 0 ? TRUE : FALSE;
	}

    public function gets($strWhere = NULL, $limit = NULL, $offset = NULL) {
		$ret = array();
		$this->db->select("{$this->_tableName}.*, {$this->_userTName}.username, {$this->_store_gradeTName}.grade_name");
		$this->db->order_by("{$this->_tableName}.id", 'DESC');
		$this->db->join($this->_userTName, "{$this->_userTName}.id = {$this->_tableName}.user_id");
		$this->db->join($this->_store_gradeTName, "{$this->_store_gradeTName}.id = {$this->_tableName}.store_grade_id");
		$query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
	    if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
	}

    public function get($strWhere = NULL) {
		$ret = array();
		$this->db->select("{$this->_tableName}.*, {$this->_userTName}.username");
		$this->db->join($this->_userTName, "{$this->_userTName}.id = {$this->_tableName}.user_id");
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0){
			$ret = $query->result_array();
			return $ret[0];
		}

		return $ret;
	}

	public function get2($select = '*', $strWhere = NULL) {
		$ret = array();
		$this->db->select($select);
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0){
			$ret = $query->result_array();
			return $ret[0];
		}

		return $ret;
	}

    public function rowCount($strWhere = NULL) {
		$count = 0;
		$this->db->select("count(*) as 'count'");
		$this->db->join($this->_userTName, "{$this->_userTName}.id = {$this->_tableName}.user_id");
		$query = $this->db->get_where($this->_tableName, $strWhere);
	    if ($query->num_rows() > 0) {
			$ret = $query->result_array();
			$count = $ret[0]['count'];
		}

		return $count;
	}

	public function attribute($attributeStr = 'h,c') {
		$strAttribute = '';
		$attribute = array(
				'h'=>'<font color=#FF0000>热门商家</font>',
				'c'=>'<font color=#FF0000>首页实体商家</font>',
				'a'=>'<font color=#FF0000>首页实力电商</font>',
				'f'=>'<font color=#FF0000>幻灯</font>',
				's'=>'<font color=#FF0000>滚动</font>',
				'b'=>'<font color=#FF0000>加粗</font>',
				'p'=>'<font color=#FF0000>图片</font>',
				'j'=>'<font color=#FF0000>跳转</font>'
		);
		if (! empty($attributeStr)) {
			$attributeArray = explode(',', $attributeStr);
			$strAttribute = '[';
			foreach ($attributeArray as $key=>$value) {
				$strAttribute .= '&nbsp;'.$attribute[$value];
			}
			$strAttribute .= ']';
		}
		return $strAttribute;
	}
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */