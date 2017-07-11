<?php
class Myprofile_Controller extends Template_Controller {
	
	public $template;	

	public function __construct()
    {
        parent::__construct();
       	$this->template = new View('templates/'.$this->site['config']['TEMPLATE'].'/index');
		$this->_get_session_template();
		if(empty($this->sess_cus['admin_id']) || $this->sess_cus['step'] != 3){
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){    
				header('HTTP/1.1 302 Found', true, 302);
				die();
			}else
				url::redirect('login');
		}
    }
    
   	private function _get_session_template()
	{
		if($this->session->get('error_msg'))
			$this->template->error_msg = $this->session->get('error_msg');
		if($this->session->get('warning_msg'))
			$this->template->warning_msg = $this->session->get('warning_msg');
		if($this->session->get('success_msg'))
			$this->template->success_msg = $this->session->get('success_msg');
		if($this->session->get('info_msg'))
			$this->template->info_msg = $this->session->get('info_msg');	
	}
	public function __call($method, $arguments)
	{
		url::redirect('/');
	}

	public function index(){
		$this->template->content = new View('myprofile/index');
		$this->template->jsKiosk = new View('myprofile/index_js');
		$mdata  = array();
		$mstore = array();
		if($this->sess_cus){
			$mdata = $this->sess_cus;
			if(!empty($mdata['store_id'])){
				/* API store (store.xlsx) */
				$this->db->where('store_id', $mdata['store_id']);
				$mstore = $this->db->get('store')->result_array(false);
			}else{
				/* API storeAdmin (setting.xlsx) */
				$this->db->where('admin_id', $mdata['admin_refer_id']);
				$mstore = $this->db->get('store')->result_array(false);
			}
		}	
		
		$this->template->content->mdata  = $mdata;
		$this->template->content->mstore = $mstore;
	}

	public function save(){
		$data = $this->input->post();
		if (isset($_FILES) && !empty($_FILES) && $_FILES['txt_icon']['error'] == 0){
			try {
				$logo     = 'User_'.round(microtime(true) * 1000).'.png';
				$filename = upload::save($_FILES['txt_icon'], NULL, DOCROOT.'themes/kiosk/pages/img/');
				Image::factory($filename)
						->resize(250, 250,Image::AUTO)
						->save(DOCROOT.'themes/kiosk/pages/img/'.$logo);
			} catch (Exception $e) {
				$logo = "";
			}
			
		}else{
			$logo = !empty($data['txt_icon'])?$data['txt_icon']:'';
		}
		if($_POST){
			$arr_profile = array(
				'admin_first_name'  => !empty($data['txt_first'])?$data['txt_first']:'',
				'admin_name'        => !empty($data['txt_last'])?$data['txt_last']:'',
				'admin_address'     => !empty($data['txt_address'])?$data['txt_address']:'',
				'admin_address_2'   => !empty($data['txt_address_2'])?$data['txt_address_2']:'',
				'admin_city'        => !empty($data['txt_city'])?$data['txt_city']:'',
				'admin_state'       => !empty($data['txt_state'])?$data['txt_state']:'',
				'admin_zip'         => !empty($data['txt_zip'])?$data['txt_zip']:'',
				'admin_country'     => !empty($data['txt_country'])?$data['txt_country']:'',
				'admin_phone'       => !empty($data['txt_phone'])?$data['txt_phone']:'',
				'admin_email'       => !empty($data['txt_email'])?$data['txt_email']:'',
				'admin_email_login' => !empty($data['txt_email_login'])?$data['txt_email_login']:'',
				'admin_passwd'      => !empty($data['txt_password'])?md5($data['txt_password']):'',//!empty($data['txt_password'])?$this->crypt($data['txt_password']):'',
				'admin_website'     => !empty($data['txt_website'])?$data['txt_website']:'',
				'admin_notes'       => !empty($data['txt_notes'])?$data['txt_notes']:'',
				'file_id'           => $logo
			);
			if(empty($data['txt_password']) || $data['txt_password'] == '')
				unset($arr_profile['admin_passwd']);

			/* API updateAdmin (store.xlsx) */
			$this->db->where('admin_id',$data['txt_admin_id']);
			$this->db->update('admin',$arr_profile);

			// 
			if(isset($arr_profile['admin_passwd'])){
				unset($arr_profile['admin_passwd']);
			}

			$_sessData = $this->sess_cus;
			$_sessData = array_merge(
				$_sessData,$arr_profile
			);
			$this->session->set('sess_cus', $_sessData);

			$this->session->set_flash('success_msg', 'Changes saved.');
			
			url::redirect('myprofile');
			exit();
		}
	}

}
?>