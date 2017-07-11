<?php
class Admin_login_Controller extends Template_Controller {
	public $template;	
	public function __construct(){
        parent::__construct();
        $this->template = new View('templates/'.$this->site['config']['TEMPLATE'].'/Login/index');
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
		$this->template->content = new View('templates/'.$this->site['config']['TEMPLATE'].'/Login/index');
		url::redirect('/admin_login');
	} 
	
	public function index(){
		if(!empty($this->sess_admin['super_id'])){
			url::redirect('/admin');
			die();
		}
		$this->template->titleKiosk = "Site Administration | Login";
		$this->template->content = new View('admin_login/login');
	}

	public function change_password(){
		if(empty($this->sess_admin['super_id'])){
			url::redirect('/admin_login');
		}else{
			if($this->sess_admin['super_change_passwd'] == 1){
				$this->template->titleKiosk   = "Kiosk | Change Password";
				$this->template->jsreadyKiosk = new View('JSReadychangePassword');
				$this->template->content      = new View('admin_login/changePassword');
			}else{
				url::redirect('/admin_login');
			}
			
		}
	}

	public function sm_change_pass(){
		if(empty($this->sess_admin['super_id'])){
			url::redirect('/admin_login');
		}else{
			$this->db->where('super_id', $this->sess_admin['super_id']);
			$account = $this->db->get('super_admin')->result_array(false);

			if(!empty($account)){
				$arr_data = array(
					'super_change_passwd' => 0, 
				);
				$this->db->where('super_id', $this->sess_admin['super_id']);
				$this->db->update('super_admin', $arr_data);

				$_sessData                      = $this->sess_admin;
				$_sessData['super_change_passwd'] = 0;
				$this->session->set('sess_admin', $_sessData);
				url::redirect('admin');
				die();
			}
		}
		url::redirect('admin_login');
		die();
	}

	public function sm_login(){
		$_sessData = $this->sess_admin;
		$txt_email = $this->input->post('txt_email');
		$txt_pass  = $this->input->post('txt_pass');
		
		$this->db->where('super_email', $txt_email);
		//$this->db->where('super_status', 1);
		$dataSuper = $this->db->get('super_admin')->result_array(false);
		if(!empty($dataSuper)){
			if($dataSuper[0]['super_status'] == 2){
				echo json_encode(array(
			   		'msc' => 'account_inactive',
			   		'url' => ''
			   	));
			   	die();
			}

			$password = $dataSuper[0]['super_passwd'];
			//$check    = crypt($txt_pass, $password);
			$check    = md5($txt_pass);
			if ($check === $password) {
				unset($dataSuper[0]['super_passwd']);
				if($dataSuper[0]['super_change_passwd'] == 1){
					$_sessData = array_merge($_sessData, $dataSuper[0]);
					$this->session->set('sess_admin', $_sessData);
				   	echo json_encode(array(
				   		'msc' => true,
				   		'url' => url::base().'admin_login/change_password'
				   	));
				}else{
					$_sessData = array_merge($_sessData, $dataSuper[0]);
					$this->session->set('sess_admin', $_sessData);
				   	echo json_encode(array(
				   		'msc' => true,
				   		'url' => url::base().'admin'
				   	));
				}
				
			   	die();
			}
		}
		echo json_encode(array(
	   		'msc' => false,
	   		'url' => 'admin_login'
	   	));
		die();
	}

	public function logout(){
		$this->session->destroy();
		$this->session->delete('sess_admin');
		url::redirect('/admin_login');
	}
}
?>