<?php

class Product_favorite_model extends CI_Model {

    private $_tableName = 'product_favorite';
    private $_productTName = 'product';

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

        return $ret > 0 ? $ret : FALSE;
    }

    public function delete($where = '') {
        return $this->db->delete($this->_tableName, $where) > 0 ? TRUE : FALSE;
    }

    public function gets($strWhere = NULL, $limit = NULL, $offset = NULL) {
        $ret = array();
        $this->db->select("{$this->_tableName}.id, {$this->_tableName}.product_id, {$this->_tableName}.add_time, {$this->_productTName}.title, , {$this->_productTName}.sell_price, {$this->_productTName}.market_price,  {$this->_productTName}.path");
        $this->db->order_by("{$this->_tableName}.id", 'DESC');
        $this->db->join($this->_productTName, "{$this->_tableName}.product_id = {$this->_productTName}.id");
        $query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
    }

    public function get_max_id($strWhere = NULL) {
        $this->db->select("max({$this->_tableName}.id) as 'max_id'");
        $this->db->join($this->_productTName, "{$this->_tableName}.product_id = {$this->_productTName}.id");
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            return $ret[0]['max_id'] ? $ret[0]['max_id'] : 0;
        }

        return 0;
    }
    
    /**
     * select info
     *
     * @param $select is string
     * @param $strWhere is string
     * @return array
     */
    public function get($select = '*', $strWhere = NULL) {
        $this->db->select($select);
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            return $ret[0];
        }

        return array();
    }

    /**
     * select
     *
     * @param $strWhere is string
     * @return int
     */
    public function rowCount($strWhere = NULL) {
        $count = 0;
        $this->db->select("count(*) as 'count'");
        $this->db->join($this->_productTName, "{$this->_tableName}.product_id = {$this->_productTName}.id");
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            $count = $ret[0]['count'];
        }
        
        return $count;
    }
}

/* End of file advertising_model.php */
/* Location: ./application/admin/models/advertising_model.php */