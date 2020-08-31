<?php

class Product_model extends CI_Model {

    private $_tableName = 'product';

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
    public function gets($select = '*', $strWhere = NULL, $limit = NULL, $offset = NULL, $order = 'id', $by = 'DESC') {
        $ret = array();
        $this->db->select($select);
        if ($order == 'all') {
            $this->db->order_by('sort', 'DESC');
            $this->db->order_by('id', $by);
        } else {
            $this->db->order_by($order, $by);
        }
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

    public function getBrand($strWhere = '', $limit = "limit 10") {
        $ret = array();
        $query = $this->db->query("select id, brand_name from (select brand_id from product where category_id in ({$strWhere}) group by brand_id) as pb join brand on pb.brand_id = brand.id {$limit}");
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
    }

    public function getColor($strWhere = '', $limit = "limit 10") {
        $ids = '';
        $this->db->select("id");
        $query = $this->db->get_where($this->_tableName, "category_id in ({$strWhere})");
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            foreach ($ret as $value) {
                $ids .= $value['id'] . ',';
            }
        }
        if (!empty($ids)) {
            $ids = substr($ids, 0, -1);
        } else {
            $ids = 0;
        }

        $ret = array();
        $query = $this->db->query("select color_name from product_a_size_color where product_id in ({$ids}) group by color_name {$limit}");
        if ($query->num_rows() > 0) {
            $bmpRet = $query->result_array();
            foreach ($bmpRet as $key => $value) {
                $ret[$key] = $value['color_name'];
            }
        }

        return $ret;
    }

    public function getSize($strWhere = '', $limit = "limit 10") {
        $ids = '';
        $this->db->select("id");
        $query = $this->db->get_where($this->_tableName, "category_id in ({$strWhere})");
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            foreach ($ret as $value) {
                $ids .= $value['id'] . ',';
            }
        }
        if (!empty($ids)) {
            $ids = substr($ids, 0, -1);
        } else {
            $ids = 0;
        }
        $ret = array();
        $query = $this->db->query("select size_name from product_a_size_color where product_id in ({$ids}) group by size_name {$limit}");
        if ($query->num_rows() > 0) {
            $bmpRet = $query->result_array();
            foreach ($bmpRet as $key => $value) {
                $ret[$key] = $value['size_name'];
            }
        }

        return $ret;
    }

    public function getIdsBySize($strWhere = '', $limit = '') {
        $ids = '';
        $query = $this->db->query("select product_id from product_a_size_color where size_name = '{$strWhere}' group by product_id {$limit}");
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            foreach ($ret as $value) {
                $ids .= $value['product_id'] . ',';
            }
        }
        if (!empty($ids)) {
            $ids = substr($ids, 0, -1);
        }

        return $ids;
    }

    public function getIdsByColor($strWhere = '', $limit = '') {
        $ids = '';
        $query = $this->db->query("select product_id from product_a_size_color where color_name = '{$strWhere}' group by product_id {$limit}");
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
            foreach ($ret as $value) {
                $ids .= $value['product_id'] . ',';
            }
        }
        if (!empty($ids)) {
            $ids = substr($ids, 0, -1);
        }

        return $ids;
    }

    public function getDetailColor($productId = 0) {
        $ret = array();
        $query = $this->db->query("select distinct color_id, color_name,path from product_a_size_color where product_id = {$productId} order by color_id ASC");
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
    }

    public function getDetailSize($productId = 0) {
        $ret = array();
        $query = $this->db->query("select distinct size_id, size_name from product_a_size_color where product_id = {$productId} order by size_id ASC");
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret;
    }

    public function getProductStock($product_id = 0, $color_id = 0, $size_id = 0) {
        $ret = array();
        $query = $this->db->query("select stock, price, product_num from product_a_size_color where product_id = {$product_id} and color_id = {$color_id} and size_id = {$size_id} limit 1");
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret ? $ret[0] : $ret;
    }

    public function getPrice($productId) {
        $ret = array();
        $query = $this->db->query("select min(price) as min_price, max(price) as max_price from product_a_size_color where product_id = {$productId}");
        if ($query->num_rows() > 0) {
            $ret = $query->result_array();
        }

        return $ret ? $ret[0] : $ret;
    }

    public function getDetailPrice($productId = 0) {
        $ret = array();
        $query = $this->db->query("select * from product_a_size_color where product_id = {$productId} order by id ASC");
        if ($query->num_rows() > 0) {
            $bmpRet = $query->result_array();
            foreach ($bmpRet as $key => $value) {
                $ret[$key] = $value;
            }
        }
        //print_r($ret);
        return $ret;
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
   * @param type $data
   * @param type $where
   * @return type
   */
    public function changeStock($data,$where=null){
        $ret = 0;
        if (!empty($where)) {
            $ret = $this->db->update('product_a_size_color', $data, $where);
        } else {
            $this->db->insert($this->_tableName, $data);
            $ret = $this->db->insert_id();
        }
        return $ret > 0 ? TRUE : FALSE;
    }

}

/* End of file product_model.php */
/* Location: ./application/admin/models/product_model.php */