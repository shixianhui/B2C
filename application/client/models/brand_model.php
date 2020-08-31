<?php
class Brand_model extends CI_Model {

	private $_tableName = 'brand';

	public function __construct() {
		 parent::__construct();
	}

    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
		$ret = array();
		$this->db->select($select);
		$this->db->order_by("{$this->_tableName}.sort", 'ASC');
		$this->db->order_by("{$this->_tableName}.id", 'DESC');
		$query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
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

	public function gets_distinct($strWhere = NULL) {
		$ret = array();
		if ($strWhere) {
			$strWhere = " where {$strWhere}";
		}
		$query = $this->db->query("select distinct first_letter from {$this->_tableName}  {$strWhere} order by first_letter ASC");
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}
}
/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */