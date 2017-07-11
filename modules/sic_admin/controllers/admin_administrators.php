<?php
class Admin_administrators_Controller extends Template_Controller {
	public $template;	
	public function __construct(){
        parent::__construct();
        $this->template = new View('templates/'.$this->site['config']['TEMPLATE'].'/index');
		// Init session 
		$this->_get_session_template();
		if(empty($this->sess_admin['super_id'])){
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){    
				header('HTTP/1.1 302 Found', true, 302);
				die();
			}else
				url::redirect('/admin_login');
		}
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
		url::redirect('/admin_login');
	}
	public function index(){
		$this->template->content = new View('admin_administrators/listAdministrators');
		$this->template->jsKiosk = new View('admin_administrators/jsListAdministrators');
	}

	public function jsDataAdministrators(){

		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		$iDisplayLength = (int)($_POST['length']);
		$iDisplayStart  = (int)($_POST['start']);
		/*$iOrder       = (int)($_POST['order'][0]['column']);
		$iDir           = $_POST['order'][0]['dir'];*/

		$total_items    = $this->db->get('super_admin')->count();
		$total_filter   = $total_items;
		$sEcho          = (int)($_POST['draw']);
		$_data          = array();
		if(!empty($iSearch)){
			$iSearch    = $this->db->escape(trim($iSearch));
			$iSearch    = substr($iSearch, 1, (strlen($iSearch)-2));
			$arr        = explode(' ',trim($iSearch));
			$dem        = count($arr);
			$sql_search = '';
			if($dem > 1){
				$sql_search = "(CONCAT_WS(' ',super_name,super_email) LIKE '%".$arr[0]."%'";
				for ($i=1; $i < ($dem-1) ; $i++) { 
					$sql_search .= "AND CONCAT_WS(' ',super_name,super_email) LIKE '%" .$arr[$i]. "%'";
				}
				$sql_search .= " AND CONCAT_WS(' ',super_name,super_email) LIKE '%" .$arr[$dem-1]. "%')";
			}else{
				$sql_search = "CONCAT_WS(' ',super_name,super_email) LIKE '%" .trim($iSearch). "%'";
			}
			
			$this->db->where($sql_search);
			$total_filter = $this->db->get('super_admin')->count();

			$this->db->where($sql_search);
		}

		$this->db->limit($iDisplayLength,$iDisplayStart);
		$result = $this->db->get('super_admin')->result_array(false);

		if(!empty($result)){
			$dataStatus = array(
				1 => 'Active', 
				2 => 'Inactive'
			);
			foreach ($result as $key => $value) {
				$_data[] = array(
					"tdID"        => $value['super_id'],
					"tdName"      => $value['super_name'],
					"tdEmail"     => $value['super_email'],
					"tdDate"      => date_format(date_create($value['super_regidate']), 'm/d/Y'),
					"tdStatus"    => $dataStatus[$value['super_status']],
					"tdLevel"     => $value['super_level'],
					"DT_RowId"    => $value['super_id'],
		    	);
			}
		}
		
		$records                     = array();
		$records["data"]             = $_data;
		$records["draw"]             = $sEcho;
		$records["recordsTotal"]     = $total_items;
		$records["recordsFiltered"]  = $total_filter;
		echo json_encode($records);
		die();
	}

	public function getAdd(){

		$template = new View('admin_administrators/frmAdministrators');
		$title = 'Add New Admin';
		$template->set(array(
			'title'   => $title,
		));
		$template->render(true);
		die();
	}

	public function getEdit(){
		$template = new View('admin_administrators/frmAdministrators');
		$id = $this->input->post('id');

		$this->db->where('super_id', $id);
		$result = $this->db->get('super_admin')->result_array(false);

		$title    = 'Edit Admin';
		$template->set(array(
			'title' => $title,
			'data'  => !empty($result)?$result[0]:'',

		));
		$template->render(true);
		die();
	}

	public function save(){
		$data = $this->input->post();
		if(!empty($data['txt_hd_id'])){
			$this->db->where('super_id', $data['txt_hd_id']);
			$super = $this->db->get('super_admin')->result_array(false); // Edit
			if(!empty($super)){
				$account_id  = $data['txt_hd_id'];
				$passwd      = !empty($data['txt_login_pass'])?md5($data['txt_login_pass']):$super[0]['super_passwd'];
				//$passwd      = !empty($data['txt_login_pass'])?$this->crypt($data['txt_login_pass']):$super[0]['super_passwd'];
				$change_pass = !empty($data['txt_change_pass'])?'1':$super[0]['super_change_passwd'];
				$regidate    = $super[0]['super_regidate'];
			}else{
				$this->session->set_flash('error_msg', 'Error Save.');
				url::redirect('admin_administrators');
			}
		}else{
			//$passwd   = $this->crypt($data['txt_login_pass']);
			$passwd   = md5($data['txt_login_pass']);
			$regidate = date('Y-m-d H:i:s');
		}
		$super_id    = $this->getGUID();
		$change_pass = !empty($data['txt_change_pass'])?'1':'0';
		$arr = array(
			'super_id'            => $super_id, 
			'super_name'          => $data['txt_login_name'], 
			'super_email'         => $data['txt_login_email'], 
			'super_passwd'        => $passwd, 
			'super_status'        => 1, 
			'super_level'         => 2, 
			'super_change_passwd' => $change_pass, 
			'super_regidate'      => $regidate, 
		);
		try {
			if(empty($data['txt_hd_id'])){
				$this->db->insert('super_admin', $arr);
				$this->session->set_flash('success_msg', 'Changes saved.');
			}else{
				unset($arr['super_level']);
				unset($arr['super_regidate']);
				$this->db->where('super_id', $account_id);
				$this->db->update('super_admin', $arr);    // updateAdministrators
				$this->session->set_flash('success_msg', 'Changes saved.');
			}
		} catch (Exception $e) {
			$this->session->set_flash('error_msg', 'Error Save.');
		}

		url::redirect('admin_administrators');
		die();
	}

	public function checkCode(){
		$txt_code = $this->input->post('txt_code');
		$id_super = $this->input->post('id_super');

		$this->db->where('super_email', $txt_code);
		if(!empty($id_super))
			$this->db->notin('super_id', array($id_super));
		$result = $this->db->get('super_admin')->count();

		if($result >= 1){
			echo json_encode(array('msg' => 'false'));
			die();
		}
		echo json_encode(array('msg' => 'true'));
		die();
	}

	public function getFrmUpload(){
		$template = new View('catalogs/frmUpload');
		$title = 'Crop Image.';
		$template->render(true);
		die();
	}

	public function myprofile(){
		$this->template->content = new View('admin_administrators/myprofile');
		$this->template->jsKiosk = new View('admin_administrators/jsMyprofile');
		$data = array();
		if($this->sess_admin){
			$data = $this->sess_admin;
		}	
		$this->template->content->data = $data;
	}

	public function save_myprofile(){
		$data = $this->input->post();
		$name = round(microtime(true) * 1000);
		if (isset($_FILES) && !empty($_FILES) && $_FILES['txt_icon']['error'] == 0){
			try {
				$logo     = 'User_'.$name.'.png';
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
				'super_name'   => !empty($data['txt_name'])?$data['txt_name']:'',
				'super_email'  => !empty($data['txt_email'])?$data['txt_email']:'',
				'super_passwd' => !empty($data['txt_pass'])?md5($data['txt_pass']):'',//!empty($data['txt_pass'])?$this->crypt($data['txt_pass']):'',
				'file_id'      => $logo
			);
			if(empty($data['txt_pass']) || $data['txt_pass'] == '')
				unset($arr_profile['super_passwd']);
			$this->db->where('super_id',$data['txt_super_id']);
			$this->db->update('super_admin',$arr_profile);        // updateProfile
			// 
			if(isset($arr_profile['super_passwd'])){
				unset($arr_profile['super_passwd']);
			}

			$_sessData = $this->sess_admin;
			$_sessData = array_merge(
				$_sessData,$arr_profile
			);
			$this->session->set('sess_admin', $_sessData);

			$this->session->set_flash('success_msg', 'Changes saved.');
			
			url::redirect('admin_administrators/myprofile');
			exit();
		}
	}

	public function setStatus(){
		$id     = $this->input->post('idAdmin');
		$status = $this->input->post('action');
		if(!empty($id)){
			if(is_array($id)){
				$this->db->in('super_id', $id);
			}else{
				$this->db->where('super_id', $id);
			}
			$this->db->update('super_admin', array('super_status' => $status));

			echo json_encode(array('msg' => true));
		}else{
			echo json_encode(array('msg' => false));
		}
		die();
	}
}
?>