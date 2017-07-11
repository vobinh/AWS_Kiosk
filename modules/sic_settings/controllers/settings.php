<?php
class Settings_Controller extends Template_Controller {
	
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

		$this->store_model = new Store_Model();
		$this->stage_model = new Stage_Model();
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

	/* DATA IMPORT */
	public function importAPI(){
		$fileId   = '';
		$store_id = base64_decode($this->sess_cus["storeId"]);
		$_temp    = $this->input->post('slt_store_active');
		if(!empty($_temp)){
			$storeId = $_temp;
		}
		if (function_exists('curl_file_create')) { // php 5.5+
		  	$cFile = curl_file_create($_FILES['uploadfile']['tmp_name']);
		} else { // 
		  	$cFile = '@' . realpath($_FILES['uploadfile']['tmp_name']);
		}
		$param = array(
			'store_id'   => $storeId,
			'uploadfile' => $cFile
		);

		$data = $this->kioskAPI->sendImg($param);
		$data = json_decode($data, true);
		if(!empty($data) && $data['responseMsg'] == 'Success'){
			$fileId = $data['data'][0]['file_id'];
			$param = array(
				'store_id' => $storeId,
				'file_id'  => $fileId
			);
			$result = $this->kioskAPI->importCSV($param);
			$result = json_decode($result, true);
			echo kohana::Debug($result);
		}
		die();
	}

	public function importdatabase(){
		if((int)$this->sess_cus['admin_level'] == 2){
			url::redirect(url::base().'settings');
			die();
		}
		$this->template->content = new View('importData/index');
		$this->template->jsKiosk = new View('importData/jsIndex');

		$storeId = base64_decode($this->sess_cus["storeId"]);
		if((string)$storeId == '0'){
			$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
			$this->db->where('status', 1);
			$listStore = $this->store_model->get();
			$storeId = $this->_getStoreUsing();
			if(empty($storeId)){
				$storeId = !empty($listStore)?$listStore[0]['store_id']:'';
				$this->_setStoreUsing($storeId);
			}
		}else{
			$this->_setStoreUsing($storeId);
		}

		$this->template->content->set(array(
			'listStore' => !empty($listStore)?$listStore:''
		));
	}
	/* END DATA IMPORT */
	public function index(){
		$this->general();
	}

	public function deletePr(){
		$this->db->where('admin_id', $this->sess_cus['admin_id']);
		$this->db->delete('privileges');

		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->delete('privileges');
		echo 's';
		die();
	}

	public function general(){
		$this->template->content = new View('general/index');
		$this->template->jsKiosk = new View('general/jsIndex');

		$storeId = base64_decode($this->sess_cus["storeId"]);
		if((string)$storeId == '0'){
			$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
			$this->db->where('status', 1);
			$listStore = $this->store_model->get();
			$storeId = $this->_getStoreUsing();
			if(empty($storeId)){
				$storeId = !empty($listStore)?$listStore[0]['store_id']:'';
				$this->_setStoreUsing($storeId);
			}
		}else{
			$this->_setStoreUsing($storeId);
		}
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$store   = $this->store_model->get($storeId);
		
		$this->template->content->set(array(
			'data'      => !empty($store)?$store[0]:'',
			'listStore' => !empty($listStore)?$listStore:''
		));
	}

	public function getDataMachine(){
		$storeId        = $this->input->post('storeId');
		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		$iDisplayLength = (int)$_POST['length'];
		$iDisplayStart  = (int)$_POST['start'];
		$sEcho          = (int)($_POST['draw']);
		$_data          = array();

		$this->db->where('store_id', $storeId);
		//$this->db->notin('m_status', 3);
		$this->db->orderby('regidate', 'desc');
		$machine      = $this->db->get('machine')->result_array(false);
		$total_items  = count($machine);
		$total_filter = $total_items;
		if(!empty($machine)){
			$arrStatus = array(1 => 'Active', 2 => 'Deactivate', 3 => 'Trouble', 4 => 'Discard');
			foreach ($machine as $key => $value) {
				$_data[] = array(
					"tdID"     => $value['machine_id'],
					"tdName"   => $value['m_name'],
					"tdNo"     => $value['m_serial_no'],
					"tdIP"     => $value['m_ip'],
					"tdMAC"    => $value['pc_id'],
					"tdStatus" => $arrStatus[$value['m_status']],
					"tdDate"   => date('m/d/Y', strtotime($value['regidate'])),
					"DT_RowId" => $value['machine_id']
		    	);
			}
		}
		$records                    = array();
		$records["data"]            = $_data;
		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $total_items;
		$records["recordsFiltered"] = $total_filter;
		echo json_encode($records);
		die();
	}

	public function getUpdateTax(){
		$template = new View('general/frmUpdateTax');
		$template->set(array());
		$template->render(true);
		die();
	}

	public function getAddMachine(){
		$template = new View('general/frmMachine');
		$title    = 'Add Devices';

		$template->set(array(
			'title' => $title
		));

		$template->render(true);
		die();
	}

	public function getEditMachine(){
		$template = new View('general/frmMachine');
		$title    = 'Edit Devices';

		$id = $this->input->post('id');

		$this->db->where('machine_id', $id);
		$machine = $this->db->get('machine')->result_array(false);

		$template->set(array(
			'title' => $title,
			'data'  => !empty($machine)?$machine[0]:''
		));

		$template->render(true);
		die();
	}

	public function setStatusMachine(){
		$id     = $this->input->post('id');
		$status = $this->input->post('action');
		$total  = 0;
		if(!empty($id)){
			if(is_array($id)){
				$this->db->in('machine_id', $id);
			}else{
				$this->db->where('machine_id', $id);
			}

			$result = $this->db->update('machine', array('m_status' => $status));
			$total  = $result->count();
			echo json_encode(array('msg' => true, 'total' => $total));
		}else{
			echo json_encode(array('msg' => false, 'total' => $total));
		}
		die();
	}

	public function saveMachine(){
		$data = $this->input->post();
		if(!empty($data['txt_hd_id'])){
			$this->_updateMachine($data);
		}else{
			$this->_saveMachine($data);
		}
		die();
	}

	private function _updateMachine($data){
		$arrItem = array(
			'm_name'      => $data['txt_name'],
			'm_ip'        => $data['txt_ip'],
			'pc_id'       => $data['txt_mac'],
			'm_serial_no' => $data['txt_serial'],
		);
		try {
			$this->db->where('machine_id', $data['txt_hd_id']);
			$this->db->update('machine', $arrItem);
			$this->session->set_flash('success_msg', 'Changes saved.');
		} catch (Exception $e) {
			$this->session->set_flash('error_msg', 'Could not complete request.');
		}
		url::redirect('settings');
		die();
	}

	private function _saveMachine($data){
		$storeId = $this->_getStoreUsing();
		$arrItem = array(
			'machine_id'  => $this->getGUID(), 
			'store_id'    => $storeId,
			'm_name'      => $data['txt_name'],
			'm_ip'        => $data['txt_ip'],
			'pc_id'       => $data['txt_mac'],
			'm_serial_no' => $data['txt_serial'],
			'm_status'    => 1,
			'regidate'    => date('Y-m-d H:i:s'),
		);
		try {
			$this->db->insert('machine', $arrItem);
			$this->session->set_flash('success_msg', 'Changes saved.');
		} catch (Exception $e) {
			$this->session->set_flash('error_msg', 'Could not complete request.');
		}
		url::redirect('settings');
		die();
	}

	public function updateTaxStore(){
		$store_id = $this->_getStoreUsing();
		$s_tax    = $this->input->post('txt_store_tax');
		$arr_store = array(
			's_tax' => !empty($s_tax)?($s_tax/100):0
		);
		$this->db->where('store_id', $store_id);
		$resulte = $this->store_model->update($arr_store);
		if($resulte->count() > 0){
			$this->session->set_flash('success_msg', 'Changes saved.');
			$this->session->delete('updateTax');
		}	
		url::redirect('settings');
		die();
	}

	public function updateStore($type = ""){
		$data     = $this->input->post();
		$store_id = $data['txt_id_store'];
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$store    = $this->store_model->get($store_id);
		if(!empty($store)){
			switch ($type) {
				case '1':
					$arr_store = array(
						'store' => $store[0]['store'],
						's_pk'  => !empty($data['txt_store_s_pk'])?$data['txt_store_s_pk']:''
					);
					break;
				case '2':
					$arr_store = array(
						'store'           => $store[0]['store'],
						'e_serial_number' => !empty($data['txt_store_e_serial_number'])?$data['txt_store_e_serial_number']:'',
						'e_user_name'     => !empty($data['txt_store_e_user_name'])?$data['txt_store_e_user_name']:'',
						'e_password'      => !empty($data['txt_store_e_password'])?$data['txt_store_e_password']:''
					);
					break;
				default:
					$arr_store = array(
						's_no'            => !empty($data['txt_store_no'])?$data['txt_store_no']:'',
						'store'           => !empty($data['txt_store_name'])?$data['txt_store_name']:'',
						's_first'         => !empty($data['txt_store_first'])?$data['txt_store_first']:'',
						's_last'          => !empty($data['txt_store_last'])?$data['txt_store_last']:'',
						's_address'       => !empty($data['txt_store_address'])?$data['txt_store_address']:'',
						's_address_2'     => !empty($data['txt_store_address2'])?$data['txt_store_address2']:'',
						's_city'          => !empty($data['txt_store_city'])?$data['txt_store_city']:'',
						's_state'         => !empty($data['txt_store_state'])?$data['txt_store_state']:'',
						's_zip'           => !empty($data['txt_store_zip'])?$data['txt_store_zip']:'',
						's_country'       => !empty($data['txt_store_country'])?$data['txt_store_country']:'',
						's_phone'         => !empty($data['txt_store_phone'])?$data['txt_store_phone']:'',
						's_email'         => !empty($data['txt_store_email'])?$data['txt_store_email']:'',
						's_website'       => !empty($data['txt_store_website'])?$data['txt_store_website']:'',
						's_notes'         => !empty($data['txt_store_notes'])?$data['txt_store_notes']:'',
						's_logo'          => !empty($data['uploadfilehd'])?$data['uploadfilehd']:'',
						's_tax'           => !empty($data['txt_store_tax'])?($data['txt_store_tax']/100):0,
						's_tax_country'   => !empty($data['txt_store_tax_country'])?$data['txt_store_tax_country']:'',
						'header'          => $store[0]['header'],
						'footer'          => $store[0]['footer'],
						'time_zone'       => !empty($data['txt_store_timezone'])?$data['txt_store_timezone']:''
					);
					if(empty($store[0]['header']) || empty($store[0]['footer'])){
						$arrTemp   = array();
						$arrTemp[] = $arr_store;
						$arr_store = $this->_getDesign($arrTemp);
						$arr_store = $arr_store[0];
					}
					break;
			}
			try {
				$this->db->where('store_id', $store_id);
				$resulte = $this->store_model->update($arr_store);
				if($resulte->count() > 0){
					$storeId = base64_decode($this->sess_cus["storeId"]);
					if((string)$storeId != '0'){
						$_sessData                = $this->sess_cus;
						$_sessData['store_id']    = $store_id;
						$_sessData['sltLocation'] = base64_encode($arr_store['store']);
						$_sessData['storeId']     = base64_encode($store_id);
						$this->session->set('sess_cus', $_sessData);
					}
				}
				
				$this->session->set_flash('success_msg', 'Changes saved.');
				url::redirect('settings');
				die();
			} catch (Exception $e) {
				$this->session->set_flash('error_msg', 'Could not complete request.');
				url::redirect('settings');
				die();
			}
		}
		url::redirect('settings');
		die();
	} 

	public function updateOptions($type = ""){
		$this->db->where('admin_id', $this->sess_cus['admin_id']);
		$options = $this->db->get('options')->result_array(false);
		if(!empty($options)){
			switch ((int)$type) {
				case 1:
					$arrOptions = array(
						'time_zone' => $this->input->post('txt_timezone')
					);
					break;
				
				default:
					$arrOptions = array(
						'default_format' => $this->input->post('txt_export'),
						'close_session'  => $this->input->post('txt_session'),
						'language'       => $this->input->post('txt_language')
					);
					break;
			}

			try {
				$this->db->where('op_id', $options[0]['op_id']);
				$result = $this->db->update('options', $arrOptions);
				$this->session->set_flash('success_msg', 'Changes saved.');
			} catch (Exception $e) {
				$this->session->set_flash('error_msg', 'Could not complete request.');
			}
		}else{
			switch ((int)$type) {
				case 1:
					$arrOptions = array(
						'op_id'     => $this->getGUID(),
						'admin_id'  => $this->sess_cus['admin_id'],
						'time_zone' => $this->input->post('txt_timezone')
					);
					break;
				
				default:
					$arrOptions = array(
						'op_id'          => $this->getGUID(),
						'admin_id'       => $this->sess_cus['admin_id'],
						'default_format' => $this->input->post('txt_export'),
						'close_session'  => $this->input->post('txt_session'),
						'language'       => $this->input->post('txt_language')
					);
					break;
			}

			try {
				$result = $this->db->insert('options', $arrOptions);
				$this->session->set_flash('success_msg', 'Changes saved.');
			} catch (Exception $e) {
				$this->session->set_flash('error_msg', 'Could not complete request.');
			}
		}

		if(!empty($arrOptions['op_id'])){
			unset($arrOptions['op_id']);
			unset($arrOptions['admin_id']);
		}
		$_sessData = array_merge(
			$this->sess_cus,
			$arrOptions
		);
		$this->session->set('sess_cus', $_sessData);
		url::redirect('settings');
		die();
	}

	/***************************# Receipt Design #**********************************/
	public function receiptdesign(){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['settings_receipt'], 0, 1) == '0')){
			$this->template->content = new View('receiptdesign/index');
		}else{
			$this->template->content = new View('receiptdesign/index');
			$this->template->jsKiosk = new View('receiptdesign/jsIndex');
			
			$storeId = base64_decode($this->sess_cus["storeId"]);
			if((string)$storeId == '0'){
				$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
				$this->db->where('status', 1);
				$listStore = $this->store_model->get();
				$storeId = $this->_getStoreUsing();
				if(empty($storeId)){
					$storeId = !empty($listStore)?$listStore[0]['store_id']:'';
					$this->_setStoreUsing($storeId);
				}
			}
			//$this->db->select('header, footer');
			$this->db->where('store_id', $storeId);
			$result  = $this->store_model->get();
			if(!empty($result) && (empty($result[0]['header']) || empty($result[0]['footer']))){
				$result = $this->_getDesign($result);

			}
			$this->template->content->set(array(
				'data'      => !empty($result)?$result[0]:'',
				'listStore' => !empty($listStore)?$listStore:''
			));
		}
	}

	public function getTemplate(){
		$storeId = $this->input->post('txtStore');
		$type    = $this->input->post('txtType');
		$this->db->where('store_id', $storeId);
		$result  = $this->store_model->get();
		if(!empty($result)){
			$result = $this->_getDesign($result);
		}
		echo json_encode(!empty($result)?$result[0]:false);
		die();
	}

	private function _getDesign($data){
		if(empty($result[0]['header'])){
			$name              = !empty($data[0]['store'])?$data[0]['store'].' ':'';
			$address           = $data[0]['s_address'].' '.$data[0]['s_city'].', '.$data[0]['s_state'].' '.$data[0]['s_zip'];
			if(!empty($data[0]['s_logo'])){
				$templHeader = '#name#<br/>Address: #address#<br/>Phone: #phone#';
			}else{
				$templHeader = '#name#<br/>Address: #address#<br/>Phone: #phone#';
			}
			$templHeader       = str_replace("#name#", $name, $templHeader);
			$templHeader       = str_replace("#address#", $address, $templHeader);
			$templHeader       = str_replace("#phone#", $data[0]['s_phone'], $templHeader);
			//$templHeader       = str_replace("#email#", $data[0]['s_email'], $templHeader);
			$data[0]['header'] = $templHeader;
		}
		if(empty($result[0]['footer'])){
			$templFooter       = 'Thank you very much.';
			$data[0]['footer'] = $templFooter;
		}
		
		return $data;
	}

	public function saveReceiptDesign(){
		$storeId   = $this->input->post('txtStore');
		$txtHeader = $this->input->post('txtHeader');
		$txtFooter = $this->input->post('txtFooter');

		$this->db->where('store_id', $storeId);
		$result = $this->store_model->get();
		if(!empty($result)){
			$arrData = array(
				'header' => $txtHeader,
				'footer' => $txtFooter,
			);
			try {
				$this->db->where('store_id', $storeId);
				$this->store_model->update($arrData);
				echo json_encode(array('msg' => true));
				die();
			} catch (Exception $e) {
				
			}
			
		}
		echo json_encode(array('msg' => false));
		die();
	}

	public function setStore($storeId, $type=''){
		$this->_setStoreUsing($storeId);
		if(empty($type))
			url::redirect('settings');
		else
			url::redirect('settings/'.$type);
		die();
	}
	/***************************# END Receipt Design #******************************/

	/***************************# User Privileges #******************************/
	public function privileges(){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['settings_privileges'], 0, 1) == '0')){
			$this->template->content = new View('privileges/index');
		}else{
			$this->template->content = new View('privileges/index');
			$this->template->jsKiosk = new View('privileges/jsIndex');

			$storeId = base64_decode($this->sess_cus["storeId"]);
			if((string)$storeId == '0'){
				$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
				$this->db->where('status', 1);
				$listStore = $this->store_model->get();
				$storeId   = $this->_getStoreUsing();
				if(empty($storeId)){
					$storeId = !empty($listStore)?$listStore[0]['store_id']:'';
					$this->_setStoreUsing($storeId);
				}
			}

			$this->template->content->set(array(
				'listStore' => !empty($listStore)?$listStore:''
			));
		}
	}

	public function getDataAdmin(){
		$idStore        = $this->_getStoreUsing();
		$_data          = array();
		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		$iDisplayLength = (int)$_POST['length'];
		$iDisplayStart  = (int)$_POST['start'];
		$total_items    = 0;
		$total_filter   = 0;
		$sEcho          = (int)($_POST['draw']);

		if(!empty($idStore)){
			$this->db->select('admin_id', 'admin_first_name', 'admin_name', 'admin_email_login', 'admin_regidate', 'admin_status');
			$this->db->where('store_id', $idStore);
			$listAdmin = $this->db->get('admin')->result_array(false);
			if(!empty($listAdmin)){
				$total_items = $total_filter = count($listAdmin);
				foreach ($listAdmin as $key => $value) {
					$_data[] = array(
						'tdID'         => $value['admin_id'],
						'tdName'       => trim($value['admin_first_name'].' '.$value['admin_name']),
						'tdEmail'      => $value['admin_email_login'],
						'tdDate'       => date_format(date_create($value['admin_regidate']), 'm/d/Y'),
						'tdFreeze'     => $value['admin_status'],
						'tdPrivileges' => '',
						'DT_RowId'     => $value['admin_id']
					);
				}
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

	public function getFrmDefault(){
		$template = new View('privileges/frmPrivileges');
		$userName = '';
		$userId   = '';
		$userType = '2';
		if(isset($_POST) && !empty($_POST)){
			$userType = '2';
			$userName = $this->input->post('userName');
			$userId   = $this->input->post('userId');
			$this->db->where('admin_id', $userId);
			$this->db->where('type', 2);
		}else{
			$userType = '1';
			$userId   = $this->sess_cus['admin_refer_id'];
			$this->db->where('admin_id', $userId);
			$this->db->where('type', 1);
		}
		$data = $this->db->get('privileges')->result_array(false);
		$template->set(array(
			'data'     => !empty($data)?$data[0]:'',
			'userId'   => $userId,
			'userName' => $userName,
			'userType' => $userType
		));
		$template->render(true);
		die();
	}

	public function saveDefaultPrivileges(){
		$data                         = $this->input->post();
		$customers                    = isset($data['txt_customers_w'])?'1|1':(isset($data['txt_customers_r'])?'1|0':'0|0');
		$acc_overview                 = isset($data['txt_acc_overview_w'])?'1|1':(isset($data['txt_acc_overview_r'])?'1|0':'0|0');
		$acc_recon                    = isset($data['txt_acc_recon_w'])?'1|1':(isset($data['txt_acc_recon_r'])?'1|0':'0|0');
		$acc_reimbursements           = isset($data['txt_acc_reimbursements_w'])?'1|1':(isset($data['txt_acc_reimbursements_r'])?'1|0':'0|0');
		$operations_menu              = isset($data['txt_operations_menu_w'])?'1|1':(isset($data['txt_operations_menu_r'])?'1|0':'0|0');
		$operations_inventory         = isset($data['txt_operations_inventory_w'])?'1|1':(isset($data['txt_operations_inventory_r'])?'1|0':'0|0');
		$operation_inventory_registry = isset($data['txt_operation_inventory_registry_w'])?'1|1':(isset($data['txt_operation_inventory_registry_r'])?'1|0':'0|0');
		$operations_category          = isset($data['txt_operations_category_w'])?'1|1':(isset($data['txt_operations_category_r'])?'1|0':'0|0');
		$marketing_dashboard          = isset($data['txt_marketing_dashboard_w'])?'1|1':(isset($data['txt_marketing_dashboard_r'])?'1|0':'0|0');
		$marketing_loyalty            = isset($data['txt_marketing_loyalty_w'])?'1|1':(isset($data['txt_marketing_loyalty_r'])?'1|0':'0|0');
		$marketing_online             = isset($data['txt_marketing_online_w'])?'1|1':(isset($data['txt_marketing_online_r'])?'1|0':'0|0');
		$reports_summary              = isset($data['txt_reports_summary_w'])?'1|1':(isset($data['txt_reports_summary_r'])?'1|0':'0|0');
		$reports_sales                = isset($data['txt_reports_sales_w'])?'1|1':(isset($data['txt_reports_sales_r'])?'1|0':'0|0');
		$reports_products             = isset($data['txt_reports_products_w'])?'1|1':(isset($data['txt_reports_products_r'])?'1|0':'0|0');
		$reports_customers            = isset($data['txt_reports_customers_w'])?'1|1':(isset($data['txt_reports_customers_r'])?'1|0':'0|0');
		$employees_employees          = isset($data['txt_employees_employees_w'])?'1|1':(isset($data['txt_employees_employees_r'])?'1|0':'0|0');
		$employees_scheduling         = isset($data['txt_employees_scheduling_w'])?'1|1':(isset($data['txt_employees_scheduling_r'])?'1|0':'0|0');
		$employees_timecard           = isset($data['txt_employees_timecard_w'])?'1|1':(isset($data['txt_employees_timecard_r'])?'1|0':'0|0');
		$settings_general             = isset($data['txt_settings_general_w'])?'1|1':(isset($data['txt_settings_general_r'])?'1|0':'0|0');
		$settings_privileges          = isset($data['txt_settings_privileges_w'])?'1|1':(isset($data['txt_settings_privileges_r'])?'1|0':'0|0');
		$settings_stage               = isset($data['txt_settings_stage_w'])?'1|1':(isset($data['txt_settings_stage_r'])?'1|0':'0|0');
		$settings_receipt             = isset($data['txt_settings_receipt_w'])?'1|1':(isset($data['txt_settings_receipt_r'])?'1|0':'0|0');
		$admin_id                     = !empty($data['txt_hd_user_id'])?$data['txt_hd_user_id']:$this->sess_cus['admin_refer_id'];
		$type                         = !empty($data['txt_hd_user_type'])?$data['txt_hd_user_type']:'1';

		$dataPrivileges = array(
			'id'                           => $this->getGUID(),
			'customers'                    => $customers,
			'acc_overview'                 => $acc_overview,
			'acc_recon'                    => $acc_recon,
			'acc_reimbursements'           => $acc_reimbursements,
			'operations_menu'              => $operations_menu,
			'operations_inventory'         => $operations_inventory,
			'operation_inventory_registry' => $operation_inventory_registry,
			'operations_category'          => $operations_category,
			'marketing_dashboard'          => $marketing_dashboard,
			'marketing_loyalty'            => $marketing_loyalty,
			'marketing_online'             => $marketing_online,
			'reports_summary'              => $reports_summary,
			'reports_sales'                => $reports_sales,
			'reports_products'             => $reports_products,
			'reports_customers'            => $reports_customers,
			'employees_employees'          => $employees_employees,
			'employees_scheduling'         => $employees_scheduling,
			'employees_timecard'           => $employees_timecard,
			'settings_general'             => $settings_general,
			'settings_privileges'          => $settings_privileges,
			'settings_stage'               => $settings_stage,
			'settings_receipt'             => $settings_receipt,
			'admin_id'                     => $admin_id,
			'type'                         => $type

		);
		if(!empty($data['txt_hd_id'])){
			unset($dataPrivileges['id']);
			try {
				$this->db->where('id', $data['txt_hd_id']);
				$resuly = $this->db->update('privileges', $dataPrivileges);
				$this->session->set_flash('success_msg', 'Changes saved.');
			} catch (Exception $e) {
				$this->session->set_flash('error_msg', 'Could not complete request.');
			}
		}else{
			try {
				$resuly = $this->db->insert('privileges', $dataPrivileges);
				$this->session->set_flash('success_msg', 'Changes saved.');
			} catch (Exception $e) {
				$this->session->set_flash('error_msg', 'Could not complete request.');
			}
		}
		url::redirect('settings/privileges');
		die();
	}

	public function setPrivilegesDefault(){
		$userId = $this->input->post('userId');

		$adminId   = $this->sess_cus['admin_refer_id'];
		$this->db->where('admin_id', $adminId);
		$this->db->where('type', 1);
		$data = $this->db->get('privileges')->result_array(false);
		if(!empty($data)){
			$dataPrivileges = $data[0];

			$this->db->where('admin_id', $userId);
			$this->db->where('type', 2);
			$dataUser = $this->db->get('privileges')->result_array(false);
			
			$dataPrivileges['admin_id'] = $userId;
			$dataPrivileges['type'] = 2;
			if(!empty($dataUser)){
				unset($dataPrivileges['id']);
				try {
					$this->db->where('id', $dataUser[0]['id']);
					$result = $this->db->update('privileges', $dataPrivileges);
					echo json_encode(array(
						'msg'    => 'Changes saved.',
						'status' => true
					));
					die();
				} catch (Exception $e) {}
			}else{
				$dataPrivileges['id'] = $this->getGUID();
				try {
					$result = $this->db->insert('privileges', $dataPrivileges);
					echo json_encode(array(
						'msg'    => 'Changes saved.',
						'status' => true
					));
					die();
				} catch (Exception $e) {}
			}
		}
		echo json_encode(array(
			'msg'    => 'Could not complete request.',
			'status' => false
		));
		die();
		
	}
	/***************************# END User Privileges #******************************/
}
?>