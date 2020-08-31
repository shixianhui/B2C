<?php

class Score_model extends CI_Model {

    private $_tableName = 'score';
    private $_userTName = 'user';

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
    	$this->db->select("{$this->_tableName}.*, {$this->_userTName}.user_type,{$this->_userTName}.username,{$this->_userTName}.path,{$this->_userTName}.presenter_id,{$this->_userTName}.presenter_username");
    	$this->db->order_by("{$this->_tableName}.id", 'DESC');
    	$this->db->join($this->_userTName, "{$this->_tableName}.from_user_id = {$this->_userTName}.id");
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

    public function getTodayTotal($user_id = NULL) {
    	$count = 0;
    	$time = date('Y-m-d', time());
    	$this->db->select("sum(score) as 'total'");
    	$query = $this->db->get_where($this->_tableName, "user_id = {$user_id} and type = 'login_score_in' and FROM_UNIXTIME(add_time,'%Y-%m-%d') = '{$time}'");
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
            $count = $ret[0]['total'];
    	}

    	return $count?$count:0;
    }

	public function getScoreTotal($strWhere = NULL) {
    	$count = 0;
    	$time = date('Y-m-d', time());
    	$this->db->select("sum(score) as 'total'");
    	$query = $this->db->get_where($this->_tableName, $strWhere);
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
            $count = $ret[0]['total'];
    	}

    	return $count?$count:0;
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

    /**
     * 总分成
     * @return multitype:
     */
    public function get_divide_score($user_id = 0, $cur_user_id = 0){
    	$ret = array();
    	$query = $this->db->query("select sum(score) as 'total' from score where user_id = {$user_id} and from_user_id in (select id from user where presenter_id = {$cur_user_id} or id = {$cur_user_id}) and type in ('presenter_out','presenter_in','join_user_score_in','join_seller_score_in')");
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();

    		return $ret[0]['total'] ? $ret[0]['total'] : 0;
    	}

    	return $ret;
    }

    public function get_Total($strWhere = NULL) {
    	$this->db->select("sum({$this->_tableName}.score) as 'sum_score'");
    	$query = $this->db->get_where($this->_tableName, $strWhere);
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
    		return $ret[0]['sum_score'] ? $ret[0]['sum_score'] : 0;
    	}
    	return 0;
    }
}

/* End of file admin_model.php */
/* Location: ./application/admin/models/admin_model.php */