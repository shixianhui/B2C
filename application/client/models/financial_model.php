<?php

class Financial_model extends CI_Model {

    private $_tableName = 'financial';
    private $_userTName = 'user';
    private $_ordersTName = 'orders';

    public function __construct() {
        parent::__construct();
    }

    public function save($data, $where = NULL) {
        $ret = 0;

        if (!empty($where)) {
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
        $this->db->select("*");
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
    }

    public function gets2($strWhere = NULL, $limit = NULL, $offset = NULL) {
    	$ret = array();
    	$this->db->select("{$this->_tableName}.*,{$this->_userTName}.username,{$this->_userTName}.path,{$this->_userTName}.txt_address,{$this->_userTName}.presenter_id,{$this->_userTName}.presenter_username,{$this->_ordersTName}.total,{$this->_ordersTName}.order_number");
    	$this->db->order_by("{$this->_tableName}.id", 'DESC');
    	$this->db->join($this->_userTName, "{$this->_tableName}.from_user_id = {$this->_userTName}.id");
    	$this->db->join($this->_ordersTName, "{$this->_tableName}.ret_id = {$this->_ordersTName}.id");
    	$query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
    	}

    	return $ret;
    }

    public function get($strWhere = NULL) {
        $ret = array();
        $this->db->select('*');
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            return $ret[0];
        }

        return $ret;
    }

    public function rowCount($strWhere = NULL) {
        $count = 0;
        $this->db->select("count(*) as 'count'");
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            $count = $ret[0]['count'];
        }

        return $count;
    }

    public function rowCount2($strWhere = NULL) {
    	$count = 0;
    	$this->db->select("count(*) as 'count'");
    	$this->db->join($this->_userTName, "{$this->_tableName}.from_user_id = {$this->_userTName}.id");
    	$this->db->join($this->_ordersTName, "{$this->_tableName}.ret_id = {$this->_ordersTName}.id");
    	$query = $this->db->get_where($this->_tableName, $strWhere);
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
    		$count = $ret[0]['count'];
    	}

    	return $count;
    }

    public function get_max_id($strWhere = NULL) {
        $this->db->select("max({$this->_tableName}.id) as 'max_id'");
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            return $ret[0]['max_id'] ? $ret[0]['max_id'] : 0;
        }
        return 0;
    }

    public function get_Total($strWhere = NULL) {
    	$this->db->select("sum({$this->_tableName}.price) as 'sum_price'");
    	$query = $this->db->get_where($this->_tableName, $strWhere);
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
    		return $ret[0]['sum_price'] ? $ret[0]['sum_price'] : 0;
    	}
    	return 0;
    }
}

/* End of file admin_model.php */
/* Location: ./application/admin/models/admin_model.php */