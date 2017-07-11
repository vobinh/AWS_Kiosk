<?php
class Login_Controller extends Template_Controller {
	public $template;	
	public function __construct(){
        parent::__construct();
        $this->template = new View('templates/'.$this->site['config']['TEMPLATE'].'/index');
		// Init session 
		$this->_get_session_template();
    }

   	private function _get_session_template(){
		if($this->session->get('error_msg'))
			$this->template->error_msg = $this->session->get('error_msg');
		if($this->session->get('warning_msg'))
			$this->template->warning_msg = $this->session->get('warning_msg');
		if($this->session->get('success_msg'))
			$this->template->success_msg = $this->session->get('success_msg');
		if($this->session->get('info_msg'))
			$this->template->info_msg = $this->session->get('info_msg');	
	}

	public function __call($method, $arguments){
		$this->template->content = new View('templates/'.$this->site['config']['TEMPLATE'].'/index');
		url::redirect('/');
	} 
	
	public function index(){
		if(!empty($this->sess_cus['user_id'])) url::redirect('/');
		$this->template = new View('login');
	}

	public function sm_login(){
		echo kohana::Debug($_POST);
		die();
		$password = $this->crypt('123456');
		$check    = crypt($this->input->post('txt_pass'), $password);

		$_sessData              = $this->sess_cus;
		$_sessData['user_id']   = $check;
		$this->session->set('sess_cus', $_sessData);
		if ($check === $password) {
		   url::redirect('/');
		}
		else {
		   url::redirect('/');
		}
	}

	public function logout(){
		$this->session->destroy();
		url::redirect('/');
	}
}
?>