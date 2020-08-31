<?php

class User_model extends CI_Model {

    private $_tableName = 'user';
    private $_usergroupTName = 'user_group';
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

        return $ret > 0 ? $ret : FALSE;
    }

    public function delete($where = '') {
        return $this->db->delete($this->_tableName, $where) > 0 ? TRUE : FALSE;
    }

    public function gets($strWhere = NULL, $limit = NULL, $offset = NULL) {
        $ret = array();
        $this->db->select("{$this->_tableName}.*, {$this->_usergroupTName}.group_name");
        $this->db->order_by("{$this->_tableName}.id", 'DESC');
        $this->db->join($this->_usergroupTName, "{$this->_usergroupTName}.id = {$this->_tableName}.user_group_id", 'left');
        $query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
    }

    public function gets_2($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL) {
    	$ret = array();
    	$this->db->select($select);
    	$this->db->order_by("{$this->_tableName}.id", 'DESC');
    	$query = $this->db->get_where($this->_tableName, $strWhere, $limit, $offset);
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
    	}

    	return $ret;
    }

    public function gets_group_by($field = '', $strWhere = NULL, $limit = NULL, $offset = NULL, $by = 'id', $order = 'desc') {
    	$ret = array();
    	$query = $this->db->query("select * from (".
		"SELECT `user`.`id`, `user`.`username`, `user`.`nickname`, `user`.`path`, `user`.`mobile`, `user`.`add_time`, sum(orders.total) as 'order_total', count(orders.id) as 'order_count', sum(orders.{$field}) as 'financial_total' FROM (`user`) ".
		"JOIN `orders` ON `user`.`id` = `orders`.`user_id` WHERE {$strWhere} ".
		"GROUP BY `user`.`id` ".
		") as new_user ORDER BY new_user.{$by} {$order} limit {$offset}, {$limit};");
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
    	}

    	return $ret;
    }

    public function gets_group_by_1($field, $user_id = 0, $strWhere = NULL, $limit = NULL, $offset = NULL, $by = 'id', $order = 'desc') {
    	$ret = array();
    	$query = $this->db->query("select * from (select user.id,  user.username, user.nickname, user.path, user.mobile, user.add_time, user.txt_address,presenter.presenter_user_count, tj_new_orders.orders_count, tj_new_orders.orders_total, tj_new_orders.divide_sub_price from user ".
		"left join ".
		"( ".
		"select presenter_id, count(presenter_id) as 'presenter_user_count' from user group by presenter_id  having presenter_id in (select id from user where presenter_id = {$user_id}) ".
		") as presenter ".
		"on  user.id = presenter.presenter_id ".
		"left join ( ".
		"select user_id, sum(orders_count) as orders_count, sum(orders_total) as orders_total, sum(divide_sub_price) as divide_sub_price from ".
		"(select user_id,count(*) as orders_count,sum(total) as orders_total,sum({$field}) as divide_sub_price from orders where status = 4 and user_id in (select id from user where presenter_id = {$user_id}) group by user_id ".
		"union ".
		"select divide_user_id_2 as user_id ,count(*) as orders_count,sum(total) as orders_total,sum({$field}) as divide_sub_price from orders where status = 4 and divide_user_id_2 in (select id from user where presenter_id = {$user_id}) group by divide_user_id_2) ".
		"new_orders group by user_id ".
		") tj_new_orders ".
		"on user.id = tj_new_orders.user_id ".
		"WHERE {$strWhere}) as new_user order by {$by} {$order} limit {$offset}, {$limit};");
		if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
    	}

    	return $ret;
    }

    public function get($select = '*', $strWhere = NULL) {
        $this->db->select($select);
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            return $ret[0];
        }

        return array();
    }

    public function getInfo($select = '*', $strWhere = NULL) {
        $this->db->select($select);
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            return $ret[0];
        }

        return array();
    }

    public function validateUnique($username) {
        $adminInfo = $this->get('*', array("lower(username)" => strtolower($username)));
        if ($adminInfo) {
            return true;
        }

        return false;
    }

    public function rowCount_2($strWhere = NULL) {
    	$count = 0;
    	$this->db->select("count(*) as 'count'");
    	$query = $this->db->get_where($this->_tableName, $strWhere);
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
    		$count = $ret[0]['count'];
    	}

    	return $count;
    }

    public function rowCount($strWhere = NULL) {
        $count = 0;
        $this->db->select("count(*) as 'count'");
        $this->db->join($this->_usergroupTName, "{$this->_usergroupTName}.id = {$this->_tableName}.user_group_id", 'left');
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            $count = $ret[0]['count'];
        }

        return $count;
    }

    public function rowCount_group_by($strWhere = NULL) {
    	$count = 0;
    	$query = $this->db->query("select count(*) as 'count' from (".
		"SELECT `user`.`id`, `user`.`username`, `user`.`nickname`, `user`.`path`, `user`.`mobile`, `user`.`add_time`, sum(orders.total) as 'order_total', count(orders.id) as 'order_count', sum(orders.divide_store_price) as 'financial_total' FROM (`user`) ".
		"JOIN `orders` ON `user`.`id` = `orders`.`user_id` WHERE {$strWhere} ".
		"GROUP BY `user`.`id` ".
		") as new_user");
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
    		$count = $ret[0]['count'];
    	}

    	return $count;
    }

    public function rowCount_group_by_1($user_id = 0, $strWhere = NULL) {
    	$count = 0;
    	$query = $this->db->query("select count(*) as 'count' from user ".
		"left join ".
		"( ".
		"select presenter_id, count(presenter_id) as 'presenter_user_count' from user group by presenter_id  having presenter_id in (select id from user where presenter_id = {$user_id}) ".
		") as presenter ".
		"on  user.id = presenter.presenter_id ".
		"left join ( ".
		"select user_id, sum(orders_count) as orders_count, sum(orders_total) as orders_total from ".
		"(select user_id,count(*) as orders_count,sum(total) as orders_total from orders where status = 4 and user_id in (select id from user where presenter_id = {$user_id}) group by user_id ".
		"union ".
		"select divide_user_id_2 as user_id ,count(*) as orders_count,sum(total) as orders_total from orders where status = 4 and divide_user_id_2 in (select id from user where presenter_id = {$user_id}) group by divide_user_id_2) ".
		"new_orders group by user_id ".
		") tj_new_orders ".
		"on user.id = tj_new_orders.user_id ".
		"WHERE {$strWhere};");
    	if ($query->num_rows() > 0) {
    		$ret = $query->result_array();
    		$count = $ret[0]['count'];
    	}

    	return $count;
    }

    public function rowCount2($strWhere = NULL) {
        $count = 0;
        $this->db->select("count(*) as 'count'");
        $query = $this->db->get_where($this->_tableName, $strWhere);
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            $count = $ret[0]['count'];
        }

        return $count;
    }

    public function login($username, $password) {
        $userInfo = $this->get('*', array("lower(username)" => strtolower($username)));
        if ($userInfo) {
            if ($userInfo['password'] == $this->getPasswordSalt($username, $password)) {
                return $userInfo;
            }
        }

        return false;
    }

    public function getPasswordSalt($username, $password) {
        $addTime = 0;
        $this->db->select("{$this->_tableName}.add_time");
        $query = $this->db->get_where($this->_tableName, array('lower(username)' => strtolower($username)));
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            $addTime = $ret[0]['add_time'];
        }
        return md5(strtolower($username) . $addTime . $password);
    }
}

/* End of file admin_model.php */
/* Location: ./application/admin/models/admin_model.php */