<?php

class Store_model extends CI_Model {

    private $_tableName = 'store';
    private $_storeGradeTName = 'store_grade';
    private $_userTName = 'user';

    public function __construct() {
        parent::__construct();
    }

    /**
     * save data
     *
     * @param $data is array
     * @param $where is array or string
     * @return boolean
     */
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

    /**
     * delete data
     *
     * @param $where is array or string
     * @return boolean
     */
    public function delete($where = '') {
        return $this->db->delete($this->_tableName, $where) > 0 ? TRUE : FALSE;
    }

    /**
     * select data
     *
     * @param $strWhere is string
     * @param $limit is int
     * @param $offset is int
     * @return array
     */
    public function gets($strWhere = NULL, $limit = NULL, $offset = NULL) {
        $ret = array();
        $this->db->select("{$this->_tableName}.store_name, {$this->_tableName}.job_time,{$this->_tableName}.mobile,{$this->_tableName}.txt_address,{$this->_tableName}.theme,{$this->_tableName}.store_banner,{$this->_tableName}.path,{$this->_tableName}.description,{$this->_tableName}.business_scope,{$this->_tableName}.id,{$this->_tableName}.address");
        $this->db->order_by("{$this->_tableName}.id", 'DESC');
        $query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
    }

    public function getsRand($strWhere = NULL, $limit = NULL, $offset = NULL) {
        $ret = array();
        $this->db->select("{$this->_tableName}.*");
        $this->db->order_by("RAND()", '');
        $query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
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

    public function get2($strWhere = NULL) {
        $this->db->select("{$this->_tableName}.id, {$this->_tableName}.store_name, {$this->_tableName}.theme, {$this->_storeGradeTName}.theme_ids");
        $this->db->join($this->_storeGradeTName, "{$this->_storeGradeTName}.id = {$this->_tableName}.store_grade_id", 'left');
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            return $ret[0];
        }

        return array();
    }

    public function get3($strWhere = NULL) {
        $this->db->select("{$this->_tableName}.*, {$this->_userTName}.username, {$this->_userTName}.nickname");
        $this->db->join($this->_userTName, "{$this->_userTName}.id = {$this->_tableName}.user_id");
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            return $ret[0];
        }

        return array();
    }

    public function attribute($attributeStr = 'h,c') {
        $strAttribute = '';
        $attribute = array(
            'h' => '<font color=#FF0000>头条</font>',
            'c' => '<font color=#FF0000>推荐</font>',
            'a' => '<font color=#FF0000>特荐</font>',
            'f' => '<font color=#FF0000>幻灯</font>',
            's' => '<font color=#FF0000>滚动</font>',
            'b' => '<font color=#FF0000>加粗</font>',
            'p' => '<font color=#FF0000>图片</font>',
            'j' => '<font color=#FF0000>跳转</font>'
        );
        if (!empty($attributeStr)) {
            $attributeArray = explode(',', $attributeStr);
            $strAttribute = '[';
            foreach ($attributeArray as $key => $value) {
                $strAttribute .= '&nbsp;' . $attribute[$value];
            }
            $strAttribute .= ']';
        }
        return $strAttribute;
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

}

/* End of file live_model.php */
/* Location: ./application/admin/models/live_model.php */