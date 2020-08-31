<?php

class Ad extends CI_Controller {

    private $_title = '广告内容';
    private $_tool = '';
    private $_template = 'ad';
    private $_table = 'ad';

    public function __construct() {
        parent::__construct();
        $this->_tool = $this->load->view("element/save_list_tool", array('table'=>$this->_table, 'parent_title'=>'广告管理', 'title'=>$this->_title), TRUE);
        $this->load->model('Ad_model', '', TRUE);
        $this->load->model('Ad_group_model', '', TRUE);
    }

    public function index($clear = 0, $page = 0) {
        checkPermission($this->_template . '_index');
        if ($clear) {
        	$clear = 0;
        	$this->session->unset_userdata(array('search'=>''));
        }
        $uri_2 = $this->uri->segment(2)?'/'.$this->uri->segment(2):'/index';
        $uri_sg = base_url().'admincp.php/'.$this->uri->segment(1).$uri_2."/{$clear}/{$page}";
        $this->session->set_userdata(array("{$this->_table}RefUrl"=>$uri_sg));
        $adType = array('image' => '图片广告', 'flash' => '<font color="#077ac7">Flash广告</font>', 'html' => '<font color="#ff0000">Html广告</font>', 'text' => '<font color="#e76e24">文字广告</font>');
        $strWhere = $this->session->userdata('search') ? $this->session->userdata('search') : NULL;
        if ($_POST) {
            $strWhere = "ad.id > 0 ";
            $categoryId = $this->input->post('category_id', TRUE);
            $adTypes = $this->input->post('ad_type', TRUE);
            if ($categoryId) {
                $strWhere .= " and ad.category_id = {$categoryId} ";
            }
            if ($adTypes) {
                $strWhere .= " and ad.ad_type = '{$adTypes}' ";
            }
            $this->session->set_userdata('search', $strWhere);
        }

        //分页
        $this->config->load('pagination_config', TRUE);
        $paginationCount = $this->Ad_model->rowCount($strWhere);
        $paginationConfig = $this->config->item('pagination_config');
        $paginationConfig['base_url'] = base_url() . "admincp.php/ad/index/{$clear}/";
        $paginationConfig['total_rows'] = $paginationCount;
        $paginationConfig['uri_segment'] = 4;
        $this->pagination->initialize($paginationConfig);
        $pagination = $this->pagination->create_links();

        $adList = $this->Ad_model->gets($strWhere, $paginationConfig['per_page'], $page);
        $adgroupList = $this->Ad_group_model->gets();
        $data = array(
            'tool' => $this->_tool,
            'adList' => $adList,
            'adType' => $adType,
            'adgroupList' => $adgroupList,
            'pagination' => $pagination,
            'paginationCount' => $paginationCount,
            'pageCount' => ceil($paginationCount / $paginationConfig['per_page'])
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('ad/index', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function save($id = NULL) {
        if ($id) {
            checkPermission("{$this->_template}_edit");
        } else {
            checkPermission("{$this->_template}_add");
        }
        $prfUrl = $this->session->userdata("{$this->_table}RefUrl") ? $this->session->userdata("{$this->_table}RefUrl") : base_url() . 'admincp.php/ad/index';
        if ($_POST) {
            $fields = array(
                'ad_type' => $this->input->post('ad_type'),
                'content' => unhtml($this->input->post('content')),
                'width' => $this->input->post('width'),
                'height' => $this->input->post('height'),
                'display' => $this->input->post('display'),
                'category_id' => $this->input->post('category_id'),
                'path' => $this->input->post('path', TRUE),
                'ad_text' => $this->input->post('ad_text', TRUE),
                'url' => $this->input->post('url')
            );
            if ($this->Ad_model->save($fields, $id ? array('id' => $id) : $id)) {
                printAjaxSuccess($prfUrl);
            } else {
                printAjaxError('fail', "操作失败！");
            }
        }

        $adInfo = $this->Ad_model->get('*', array('id' => $id));
        $adgroupList = $this->Ad_group_model->gets();
        $data = array(
            'tool' => $this->_tool,
            'adInfo' => $adInfo,
            'adgroupList' => $adgroupList,
            'prfUrl' => $prfUrl
        );
        $layout = array(
            'title' => $this->_title,
            'content' => $this->load->view('ad/save', $data, TRUE)
        );
        $this->load->view('layout/default', $layout);
    }

    public function category() {
        checkPermissionAjax("{$this->_template}_edit");
        $ids = $this->input->post('ids', TRUE);
        $categoryId = $this->input->post('categoryId', TRUE);

        if (!empty($ids) && !empty($categoryId)) {
            if ($this->Ad_model->save(array('category_id' => $categoryId), 'id in (' . $ids . ')')) {
                printAjaxSuccess('', '修改分类成功！');
            }
        }

        printAjaxError('fail', '修改分类失败！');
    }

    public function delete() {
        checkPermissionAjax("{$this->_template}_delete");
        $ids = $this->input->post('ids', TRUE);

        if (!empty($ids)) {
            if ($this->Ad_model->delete('id in (' . $ids . ')')) {
                printAjaxData(array('ids' => explode(',', $ids)));
            }
        }

        printAjaxError('fail', '删除失败！');
    }

    public function sort() {
        checkPermissionAjax("{$this->_template}_edit");
        $ids = $this->input->post('ids', TRUE);
        $sorts = $this->input->post('sorts', TRUE);

        if (!empty($ids) && !empty($sorts)) {
            $ids = explode(',', $ids);
            $sorts = explode(',', $sorts);

            foreach ($ids as $key => $value) {
                $this->Ad_model->save(
                        array('sort' => $sorts[$key]), array('id' => $value));
            }
            printAjaxSuccess('', '排序成功！');
        }

        printAjaxError('fail', '排序失败！');
    }

}

/* End of file link.php */
/* Location: ./application/admin/controllers/link.php */