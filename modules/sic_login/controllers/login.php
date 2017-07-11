<?php
class Login_Controller extends Template_Controller {
	public $template;	
	public function __construct(){
        parent::__construct();
        $this->template = new View('templates/'.$this->site['config']['TEMPLATE'].'/Login/index');
		// Init session 
		$this->_get_session_template();
		$this->employee_model = new Employee_Model();
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
		url::redirect('/');
	} 
	
	public function setTimeZone(){
		$time = $this->input->post('timeZone');
		$this->session->set('mTimeZone', $time);
		die();
	}

	public function index(){
		if(!empty($this->sess_cus['admin_id'])){
			$_step = (int)$this->sess_cus['step'];
			switch ($_step) {
				case 2:
					url::redirect('/login/location');
					break;
				case 3:
					url::redirect('/');
					break;
				default:
					url::redirect('/login');
					break;
			}
		}
		$this->template->titleKiosk = "Kiosk | Login";
		$this->template->content = new View('login');
	}

	public function sm_change_pass(){
		if(empty($this->sess_cus['admin_id'])){
			url::redirect('/login');
		}else{
			$this->db->where('admin_id', $this->sess_cus['admin_id']);
			$account = $this->db->get('admin')->result_array(false);

			if(!empty($account)){
				$arr_data = array(
					'admin_change_pass' => 0, 
					'admin_passwd'      => md5($this->input->post('txt_pass'))//$this->crypt($this->input->post('txt_pass'))
				);

				$this->db->where('admin_id', $this->sess_cus['admin_id']);
				$this->db->update('admin', $arr_data);
				
				if($this->sess_cus['admin_level'] == 1){
					$_sessData                      = $this->sess_cus;
					$_sessData['step']              = 2;
					$_sessData['admin_change_pass'] = 0;
					$this->session->set('sess_cus', $_sessData);
					url::redirect('/login/location');
				}else{
					if(!empty($this->sess_cus['storeId'])){
						$_sessData = $this->sess_cus;
						$_sessData['step'] = 3;
						$_sessData['admin_change_pass'] = 0;
						$this->session->set('sess_cus', $_sessData);
						url::redirect('/');
					}else{
						url::redirect('/login');
					}
				}
			}
		}
		url::redirect('/login');
	}

	private function _privileges($data){
		if(!empty($data)){
			$this->db->where('admin_id', $data[0]['admin_refer_id']);
			$this->db->where('type', 1);
			$dataDefault = $this->db->get('privileges')->result_array(false);
			if(empty($dataDefault)){
				$this->db->where('admin_id', 0);
				$this->db->where('type', 0);
				$siteDefault             = $this->db->get('privileges')->result_array(false);
				$siteDefault             = !empty($siteDefault)?$siteDefault[0]:'';
				$siteDefault['id']       = $this->getGUID();
				$siteDefault['admin_id'] = $data[0]['admin_refer_id'];
				$siteDefault['type']     = 1;
				$this->db->insert('privileges', $siteDefault);
			}
			if((string)$data[0]['admin_level'] == '2'){
				$this->db->where('admin_id', $data[0]['admin_id']);
				$this->db->where('type', 2);
				$dataUser = $this->db->get('privileges')->result_array(false);
				if(empty($dataUser)){
					if(empty($dataDefault)){
						$this->db->where('admin_id', $data[0]['admin_refer_id']);
						$this->db->where('type', 1);
						$dataDefault = $this->db->get('privileges')->result_array(false);
					}
					$dataDefault             = !empty($dataDefault)?$dataDefault[0]:'';
					$dataDefault['id']       = $this->getGUID();
					$dataDefault['admin_id'] = $data[0]['admin_id'];
					$dataDefault['type']     = 2;
					$this->db->insert('privileges', $dataDefault);
				}
			}
		}
	}

	public function sm_login(){

		$_sessData = $this->sess_cus;
		$txt_email = $this->input->post('txt_email');
		$txt_pass  = $this->input->post('txt_pass');

		$this->db->select('admin.*,store.status AS store_status,(SELECT count(store_id) AS total_store FROM store WHERE admin.admin_refer_id = store.admin_id) AS count_store');
		$this->db->join('store', array('store.store_id' => 'admin.store_id'),'','left');
		$this->db->where('admin_email_login', $txt_email);
		$dataEmployee = $this->db->get('admin')->result_array(false);

		if(!empty($dataEmployee)){
			$password = $dataEmployee[0]['admin_passwd'];
			//$check    = crypt($txt_pass, $password);
			$check    = md5($txt_pass);
			if ($check === $password) {

				$this->_privileges($dataEmployee);
				
				unset($dataEmployee[0]['admin_passwd']);

				try { // try *
				    if($dataEmployee[0]['admin_status'] == 2){ // check active
				    	$error = 'account_inactive';
    					throw new Exception($error);
				    }else if($dataEmployee[0]['admin_level'] == 2 && $dataEmployee[0]['admin_status'] == 3){ // check lv2 dong bang, nguoc lai zo duoc het
					    $error = 'account_freeze';
					    throw new Exception($error);
				    }else{  // all admin_status = 1
				    	
				    	// check store
				    	// 1: co the vao thang
				    	// 2: (parent 1) active / inactive (parent 3) in store
				    	// 3: khong co store, co store active / inactive
				    	$count_store = 0; 
				    	if($dataEmployee[0]['count_store'] > 0){
				    		$count_store = $dataEmployee[0]['count_store'];
				    	}
				    	$this->db->where('admin_id', $dataEmployee[0]['admin_refer_id']);
						$this->db->where('status',1);
						$this->db->where('s_default',1);
						$_Store_ac_in = $this->db->get('store')->result_array(false);

						$this->db->where('admin_id',$dataEmployee[0]['admin_refer_id']);
						$_parent = $this->db->get('admin')->result_array(false);


				    	if($dataEmployee[0]['admin_level'] == 3){
							if($count_store > 0){ // active / inactive
								if(empty($_Store_ac_in)){
									$error = 'ac_in_store';
					    			throw new Exception($error);
								}
							}else{     // khong co store      
								$error = 'lv3_no_store';
					    		throw new Exception($error);
							}
						}else if($dataEmployee[0]['admin_level'] == 2){	
							if($_parent[0]['admin_status'] == 2){ // set active parent before
								$error = 'account_inactive';
    							throw new Exception($error);
							}else if($_parent[0]['admin_level'] == 1 && $dataEmployee[0]['store_status'] != 1){ // parent level 1 and set s
								$error = 'ac_in_store';
				    			throw new Exception($error);
							}else if($_parent[0]['admin_level'] == 3){
								if(empty($_Store_ac_in) || ($dataEmployee[0]['store_id'] != $_Store_ac_in[0]['store_id'])){
									$error = 'ac_in_store';
					    			throw new Exception($error);
								}
							}
						}

						// OK
						if($dataEmployee[0]['admin_change_pass'] == 1){

							if($dataEmployee[0]['admin_level'] == 2){
								$this->db->where('store_id', $dataEmployee[0]['store_id']);
								$store = $this->db->get('store')->result_array(false);
							}elseif($dataEmployee[0]['admin_level'] == 3){
								$store = $_Store_ac_in;
							}else if($dataEmployee[0]['admin_level'] == 1){
								$_sessData = $dataEmployee[0];
								$_sessData['step'] = 1;
								$_sessData['_parent_level'] = !empty($_parent[0]['admin_level'])?$_parent[0]['admin_level']:'';
								$this->session->set('sess_cus', $_sessData);
								echo json_encode(array(
							   		'msc' => true,
							   		'url' => '/login/change_password'
							   	));
							   	die();
							}
					
							if(!empty($store)){
								$_sessData                  = $dataEmployee[0];
								$_sessData['step']          = 1;
								$_sessData['_parent_level'] = !empty($_parent[0]['admin_level'])?$_parent[0]['admin_level']:'';
								$_storeName = $store[0]['store'];
								if(empty($_storeName)){
									$_storeName = $store[0]['s_first'].' '.$store[0]['s_last'];
								}
								$_sessData = array_merge(
									$_sessData, 
									array(
										'sltLocation' => base64_encode($_storeName),
										'storeId'     => base64_encode($store[0]['store_id'])
									)
								);
								$this->session->set('sess_cus', $_sessData);
								echo json_encode(array(
							   		'msc' => true,
							   		'url' => '/login/change_password'
							   	));
							   	die();
							}	

						}else{

							if($dataEmployee[0]['admin_level'] == 1){
								$_sessData = array_merge($_sessData, $dataEmployee[0], array('step' => 2));
								$_sessData['_parent_level'] = !empty($_parent[0]['admin_level'])?$_parent[0]['admin_level']:'';
								$this->session->set('sess_cus', $_sessData);
								echo json_encode(array(
							   		'msc' => true,
							   		'url' => '/login/location'
							   	));
							   	die();
							}else{
								if($dataEmployee[0]['admin_level'] == 2){
									$this->db->where('store_id', $dataEmployee[0]['store_id']);
									$store = $this->db->get('store')->result_array(false);
								}elseif($dataEmployee[0]['admin_level'] == 3){
									$store = $_Store_ac_in;
								}
								if(!empty($store)){
									$_sessData                  = $dataEmployee[0];
									$_sessData['step']          = 3;
									$_sessData['_parent_level'] = !empty($_parent[0]['admin_level'])?$_parent[0]['admin_level']:'';
									$_storeName = $store[0]['store'];
									if(empty($_storeName)){
										$_storeName = $store[0]['s_first'].' '.$store[0]['s_last'];
									}
									$_sessData = array_merge(
										$_sessData, 
										array(
											'sltLocation' => base64_encode($_storeName),
											'storeId'     => base64_encode($store[0]['store_id'])
										)
									);
									$this->session->set('sess_cus', $_sessData);
									echo json_encode(array(
								   		'msc' => true,
								   		'url' => url::base()
								   	));
									die();
								}	
							}
						}
					    
				    }
				} catch (Exception $e) {
				    echo json_encode(array(
				   		'msc' => $e->getMessage(),
				   		'url' => '/login'
				   	));
				   	die();
				}
			}
		}

		// email false
		echo json_encode(array(
	   		'msc' => false,
	   		'url' => 'login'
	   	));
		die();
	}

	public function getSupport(){
		$template = new View('frmSupport');
		$template->set(array(
			//'title' => $title
		));

		$template->render(true);
		die();
	}

	public function sm_Support(){
		$Email   = $this->input->post('email');
		$Title   = $this->input->post('txt_serial');
		$Content = $this->input->post('txtContent');

		$to      = $Email;
		$subject = ''.$Title.'';
		$message = ''.$Content.'';
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: ".MasterEmail."" . "\r\n";

		try {
			$sendMail = mail($to, $subject, $message, $headers);
			echo json_encode(array(
				'status' => true, 'msg' => 'Send email success.'
			));
		} catch (Exception $e) {
			echo json_encode(array(
				'status' => false, 'msg' => 'Could not complete request.'
			));
		}
		
		die();
	}

	public function resetPass(){
		$email = $this->input->post('email');
		$this->db->where('admin_email_login', $email);
		$user  = $this->db->get('admin')->result_array(false);
		if(!empty($user)){
			$newPass = substr(md5(rand()), 0, 7);

			$to      = $email;
			$subject = 'KIOSK - PASSWORD RESET';
			$message = '<div>You have requested to reset your password. Please navigate to the below link to reset your password.</div>';
			$message .= "<div><a href='".url::base()."login'>Click Here</a></div>";
			$message .= '<div>New Password: '.$newPass.'</div>';
			
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: ".MasterEmail."" . "\r\n";

			
			try {
				$sendMail = mail($to, $subject, $message, $headers);
				$arr_data = array(
					'admin_change_pass' => 1, 
					'admin_passwd'      => md5($newPass)//$this->crypt($newPass)
				);
				$this->db->where('admin_id', $user[0]['admin_id']);
				$this->db->update('admin', $arr_data);
			} catch (Exception $e) {
				echo json_encode(array(
					'status' => false, 'msg' => 'Could not complete request.'
				));
			}
			echo json_encode(array(
				'status' => true, 'msg' => $sendMail
			));
		}else{
			echo json_encode(array(
				'status' => false, 'msg' => 'This e-mail does not exist in our system.'
			));
		}
		die();
	}

	public function change_password(){
		if(empty($this->sess_cus['admin_id'])){
			url::redirect('/login');
		}else{
			if($this->sess_cus['admin_change_pass'] == 1){
				$this->template->titleKiosk   = "Kiosk | Select your location";
				$this->template->jsreadyKiosk = new View('JSReadychangePassword');
				$this->template->content      = new View('changePassword');
			}else{
				url::redirect('/login');
			}
			
		}
	}

	public function location(){
		if(empty($this->sess_cus['admin_id'])){
			url::redirect('/login');
		}else{
			if($this->sess_cus['admin_level'] == 1){
				$_step = (int)$this->sess_cus['step'];
				switch ($_step) {
					case 1:
						url::redirect('/login/change_password');
						break;
					case 2:
						$this->template->titleKiosk = "Kiosk | Select your location";
						$this->template->content = new View('location');
						break;
					case 3:
						url::redirect('/');
						break;
					default:
						url::redirect('/login');
						break;
				}
			}else{
				url::redirect('/login');
			}
			
		}
	}

	public function credentials(){
		if(empty($this->sess_cus['employee_id'])){
			url::redirect('/login');
		}else{
			$_step = (int)$this->sess_cus['step'];
			switch ($_step) {
				case 1:
					url::redirect('/login/location');
					break;
				case 2:
					kohana::Debug($this->sess_cus);
					$storeId = base64_decode($this->sess_cus['storeId']);

					$typeLogin = ($storeId == '0')?'Admin':'Store';
					/* get User in Store */
					$dataUser = array(
						array(
							'u_id'    => 'user_01',
							'u_name'  => 'John Smith',
							'u_level' => 1
						),
						array(
							'u_id'    => 'user_02',
							'u_name'  => 'Karen Smith',
							'u_level' => 2
						),
						array(
							'u_id'    => 'user_03',
							'u_name'  => 'Lena Schweinsteiger',
							'u_level' => 2
						)
					);

					$this->template->titleKiosk   = "Kiosk | Select your login credentials";
					$this->template->jsreadyKiosk = new View('JSReadycredentials');
					$this->template->content      = new View('credentials');
					$this->template->content->set(array(
						'dataUser'  => $dataUser,
						'typeLogin' => $typeLogin
					));

					break;
				case 3:
					url::redirect('/');
					break;
				default:
					url::redirect('/login');
					break;
			}
		}
	}

	public function select_stores(){
		if(empty($this->sess_cus['admin_id'])){
			url::redirect('/login');
		}else{
			if($this->sess_cus['admin_level'] == 1){
				$this->template->titleKiosk   = "Kiosk | Select a store panel";
				$this->template->content      = new View('selectStore');
				$this->db->where('admin_id', $this->sess_cus['admin_id']);
				$dataStore = $this->db->get('store')->result_array(false);
				$this->template->content->set(array(
					'dataStore'  => $dataStore,
				));
			}else{
				url::redirect('/login');
			}
		}
	}
	public function option($type = 'QWRkbWluaXN0cmF0b3I='){
		if(empty($this->sess_cus['admin_id'])){
			url::redirect('/login');
		}else{
			if($this->sess_cus['admin_level'] == 1){
				$type  = base64_decode($type);
				if($type == 'Addministrator'){

					/* login Addministrator */
					$type    = 'Administrator Panel';
					
					$storeId = $type;
					$data    = array();

					/* get Store */
					$data['store'] = array(
						'id'   => 0,
						'name' => 'Administrator Panel'
					);

					$_sessData = $this->sess_cus;
					$_sessData['step'] = 3;
					$_sessData = array_merge(
						$_sessData, 
						array(
							'sltLocation' => base64_encode($data['store']['name']),
							'storeId' => base64_encode($data['store']['id'])
						)
					);
					$this->session->set('sess_cus', $_sessData);
					url::redirect('/');

				}elseif($type == 'Store'){
					url::redirect('/login/select_stores');
				}else{
					if(!empty($type)){
						$this->db->where('store_id', $type);
						$store = $this->db->get('store')->result_array(false);
						if(!empty($store)){
							$_sessData         = $this->sess_cus;
							$_sessData['step'] = 3;
							$_storeName        = $store[0]['store'];
							if(empty($_storeName)){
								$_storeName = $store[0]['s_first'].' '.$store[0]['s_last'];
							}
							$_sessData = array_merge(
								$_sessData, 
								array(
									'sltLocation' => base64_encode($_storeName),
									'storeId'     => base64_encode($store[0]['store_id'])
								)
							);
							$this->session->set('sess_cus', $_sessData);
							url::redirect('/');
							die();
						}
					}
					url::redirect('/login');
				}
			}else{
				url::redirect('/login');
			}	
		}
	}

	public function checkPin(){
		$id   = base64_decode($this->input->post('_id'));
		$pin  = $this->input->post('_pin');
		$type = $this->input->post('typeLogin');
		if($pin == '1234'){
			$_sessData = $this->sess_cus;
			$_sessData['step'] = 3;
			$_sessData = array_merge(
				$_sessData,
				array(
					'u_login' =>  base64_encode($id),
					'u_level' => 1,
					'u_type'  => $type
				)
			);
			$this->session->set('sess_cus', $_sessData);
			echo json_encode(array(
		   		'msc' => true,
		   		'url' => ''
		   	));
		   	die();
		}
		echo json_encode(array(
	   		'msc' => false,
	   		'url' => ''
	   	));
	   	die();
	}

	public function logout(){
		$this->session->destroy();
		if(isset($_POST) && !empty($_POST)){
			echo json_encode(array('msg' => true));
			die();
		}
		url::redirect('/login');
	}
}
?>