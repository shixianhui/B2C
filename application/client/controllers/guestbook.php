<?php
class Guestbook extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Menu_model', '', TRUE);
		$this->load->model('System_model', '', TRUE);
		$this->load->model('Guestbook_model', '', TRUE);
		$this->load->library('Form_validation');
		$this->load->helper('my_ajaxerror');
	}

	public function index($menuId = NULL) {
        $systemInfo = $this->System_model->get('*', array('id'=>1));
       //当前位置
		$location = '';
		if ($systemInfo['html']) {
			$location = "<a class='home' href='/index.html'>{$systemInfo['index_name']}</a>";
		} else {
			$location = "<a class='home' href='/{$systemInfo['client_index']}'>{$systemInfo['index_name']}</a>";
		}
		$url = $systemInfo['client_index'];
		$url .= $systemInfo['client_index']?'/':'';
		$url = $this->Menu_model->getLocation3($menuId, $systemInfo['html'], '/'.$url);
		$location .= $url;
       //栏目名称
        $gMenuInfo = $this->Menu_model->get('id, menu_name, html_path, keyword, abstract', array('id'=>$menuId));
		$menuInfo = $this->Menu_model->get('id, menu_name, html_path, keyword, abstract', array('id'=>173));
		
		$data = array(
				'site_name'=>$systemInfo['site_name'],
				'index_name'=>$systemInfo['index_name'],
		        'client_index'=>$systemInfo['client_index'],
		        'title'=>$gMenuInfo['menu_name'],
		        'keywords'=>$gMenuInfo['keyword'],
		        'description'=>$gMenuInfo['abstract'],
		 		'site_copyright'=>$systemInfo['site_copyright'],
				'icp_code'=>$systemInfo['icp_code'],
				'html'=>$systemInfo['html'],
		        'menuInfo'=>$menuInfo,
		        'parentId'=>173,
		        'gMenuInfo'=>$gMenuInfo,
		        'location'=>$location
		        );
	    $layout = array(
				  'content'=>$this->load->view('guestbook/index', $data, TRUE)
			      );
	    $this->load->view('layout/guestbook', $layout);
	    //缓存
	    if ($systemInfo['cache'] == 1) {
	    	$this->output->cache($systemInfo['cache_time']);
	    }
	}
	
	public function add() {
	    if ($_POST) {	    	 
	        $contactName = $this->input->post('contact_name', TRUE);
	        $phone = $this->input->post('phone', TRUE);
	        $mobile = $this->input->post('mobile', TRUE);
	        $qq = $this->input->post('qq', TRUE);
	        $email = $this->input->post('email', TRUE);
	        $content = $this->input->post('content', TRUE);
	        
	        if (! $this->form_validation->required($contactName)) {
	    	    printAjaxError('联系人不能为空!');
	    	}
	    	if (!$phone && !$mobile && !$qq && !$email) {
	    	    printAjaxError('电话、手机、QQ号、邮箱至少填写一个!');
	    	}
	        if ($phone) {
		    	if (! $this->form_validation->regex_match($phone, '/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/')) {
		    	    printAjaxError('电话格式不对！如:0751-88888888');
		    	}
	    	}
	        if ($mobile) {
	    	    if (! $this->form_validation->regex_match($mobile, '/^((\(\d{2,3}\))|(\d{3}\-))?(1)\d{10}$/')) {
		    	    printAjaxError('手机格式不对！如:13888888888');
		    	}
	    	}
	    	if ($qq) {
	    	    if (! $this->form_validation->regex_match($qq, '/^[1-9]\d{4,10}$/')) {
		    	    printAjaxError('QQ格式不对！如:888888');
		    	}
	    	}
	    	if ($email) {
	    	    if (! $this->form_validation->regex_match($email, '/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/')) {
	    	    	printAjaxError('邮箱格式不对！如：8888@126.com');
	    	    }
	    	}	    
	        if (! $this->form_validation->required($content)) {
	    	    printAjaxError('留言内容不能为空!');
	    	}
	        
	        $fields = array(
	                  'contact_name'=>$contactName,
	                  'phone'=>$phone,
	                  'mobile'=>$mobile,
	                  'qq'=>$qq,	        
	                  'email'=>$email,
	                  'content'=>$content,
	                  'type'=>1,
	                  'add_time'=>time()
	                  );
	        if ($this->Guestbook_model->save($fields)) {
		        //发送邮件
			    $this->load->library('email');
			    $this->config->load('mail_config', TRUE);
	    	    $mailConfig = $this->config->item('mail_config');
				$this->email->initialize($mailConfig);
			    
				$this->email->from($mailConfig['smtp_user'], '无忧建站');
				$this->email->to("865270302@qq.com");
				$this->email->subject('在线留言订单-无忧建站');
				$content = "<b>联系人：</b>{$contactName}<br/><b>电话：</b>{$phone}<br/><b>手机：</b>{$mobile}<br/><b>QQ号：</b>{$qq}<br/><b>邮箱：</b>{$email}<br/><b>留言内容：</b>{$content}";
				$this->email->message($content);
				@$this->email->send();
	            printAjaxSuccess('', '留言成功！');
	        } else {
	            printAjaxError('留言失败！');
	        }
	    }
	}
}
/* End of file page.php */
/* Location: ./application/client/controllers/page.php */