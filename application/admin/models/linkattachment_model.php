<?php
class Linkattachment_model extends CI_Model {

	private $_tableName = 'link_attachment';
	private $_attachmentTableName = 'attachment';

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

	public function get($select = '*', $strWhere = NULL) {
		$ret = array();
		$this->db->select($select);
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

	public function gets($strWhere = NULL) {
		$ret = array();
		$this->db->select("{$this->_attachmentTableName}.path");
		$this->db->join($this->_attachmentTableName, "{$this->_attachmentTableName}.id = {$this->_tableName}.attachment_id", 'left');
		$query = $this->db->get_where($this->_tableName, $strWhere);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array();
		}

		return $ret;
	}

	public function getAttachmentPath($articleId) {
		$attachmentPath = $this->gets(array("{$this->_tableName}.article_id"=>$articleId));
	    if (! empty($attachmentPath)) {
	        return $attachmentPath[0]['path'];
	    }

	    return '';
	}
}
/* End of file link_model.php */
/* Location: ./application/admin/models/link_model.php */