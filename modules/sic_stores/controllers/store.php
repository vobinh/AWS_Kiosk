<?php
class Store_Controller extends Template_Controller {
	
	public $template;	

	public function __construct(){
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
		if(empty($this->sess_cus['admin_id']) || $this->sess_cus['admin_id'] != $this->sess_cus['admin_refer_id'] || !empty($this->sess_cus['store_id'])){
			url::redirect('/');
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
		url::redirect('/');
	}

	public function index(){
		$this->template->content = new View('/store/index');
		$this->template->jsKiosk = new View('/store/indexJS');
		$this->db->select('count(store_id) AS total_store');
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$total_store = $this->db->get('store')->result_array(false);
		$this->template->jsKiosk->set(array(
			'total_store' => !empty($total_store[0])?$total_store[0]['total_store']:0,
			'admin_id'    => $this->sess_cus['admin_refer_id']
		));
	}

	public function getStore(){
		$template = new View('store/frmStore');
		$title    = 'Add New Store';
		$template->set(array(
			'title'    => $title,
			'admin_id' => $this->input->post('admin_id')
		));
		$template->render(true);
		die();
	}

	public function frmAdd_admin(){
		$template = new View('store/frmAdd_admin');
		$title    = 'Manage User Credentials';
		$template->set(array(
			'title' => $title,
			'data'  => $_POST
		));
		$template->render(true);
		die();
	}

	public function del_admin(){
		$txt_admin_id = $this->input->post('txt_admin_id');
		$this->db->where('admin_id',$txt_admin_id);
		$del_admin = $this->db->delete('admin');
		if($del_admin){
			echo json_encode(array('msg' => 'true'));
			die();
		}
		echo json_encode(array('msg' => 'false'));
		die();
	}

	public function addItem_admin(){
		$template = new View('store/frmAdd_admin_item');
		$template->set(array());
		$template->render(true);
		die();
	}

	public function save_add_admin(){
		//echo kohana::Debug($_POST);
		//die();
		$flag      = true;
		$arr_exist = array();
		if($_POST && !empty($_POST['txt_add_email'])){
			foreach ($_POST['txt_add_email'] as $key => $value) {
				if(!empty($_POST['txt_add_adminId'][$key]) && $_POST['txt_add_adminId'][$key] != ''){
					$this->db->where('admin_email_login',$value);
					$this->db->notin('admin_id', '"'.$_POST['txt_add_adminId'][$key].'"');
					$chk_admin = $this->db->get('admin')->result_array(false);
					if(!empty($chk_admin)){
						$flag = false;
						break;
					}
				}else{
					$this->db->where('admin_email_login',$value);
					$chk_admin = $this->db->get('admin')->result_array(false);
					if(!empty($chk_admin)){
						$flag = false;
						break;
					}
				}
				if(in_array($value, $arr_exist)){
					$flag = false;
					break;
				}else{
					array_push($arr_exist, $value);
				}
			}
		}
		if($flag){
			$data = $this->input->post();
			if(!empty($data['txt_id_store']))
				$data = $this->_saveUser($data);
			echo json_encode($data);	
		}
		else
			echo json_encode(array());
		exit();	
	}
	
	public function _saveUser($data){
		$admin_parent = !empty($data['txt_admin_id'])?$data['txt_admin_id']:$this->sess_cus['admin_refer_id'];
		$store_id     = $data['txt_id_store'];
		if(isset($data['txt_add_email']) && !empty($data['txt_add_email'])){
			foreach ($data['txt_add_email'] as $key => $value) {
				$admin = $this->getGUID();
				if(isset($data['freeze_user'])){
					if($data['freeze_user'][$key] == 3)
						$freeze_user = 3; // check freeze trong store add admin
					else
						$freeze_user = 1; // no check freeze trong store add admin
				}
				if(isset($data['allow_user'])){
					if($data['allow_user'][$key] == 1)
						$allow_user = 1; // check allow user trong store add admin
					else
						$allow_user = 0; // no check allow user trong store add admin
				}
				$arr_admin = array(
					'admin_id'          => $admin,
					'admin_refer_id'    => $admin_parent,
					'admin_first_name'  => !empty($data['txt_add_first'][$key])?$data['txt_add_first'][$key]:'',
					'admin_name'        => !empty($data['txt_add_last'][$key])?$data['txt_add_last'][$key]:'',
					'admin_email'       => $value,
					'admin_email_login' => $value,
					'admin_status'      => $freeze_user,
					'admin_change_pass' => $allow_user,
					'admin_level'       => 2,
					'admin_regidate'    => date("Y-m-d H:i:s"),
					'admin_passwd'      => md5($data['txt_add_password'][$key]),//$this->crypt($data['txt_add_password'][$key]),
					'store_id'          => $store_id,
				);
				if(isset($data['txt_add_adminId'][$key]) && $data['txt_add_adminId'][$key] != ''){
					unset($arr_admin['admin_id']);
					unset($arr_admin['admin_refer_id']);
					unset($arr_admin['store_id']);
					unset($arr_admin['admin_regidate']);
					if($data['txt_add_password'][$key] == '')
						unset($arr_admin['admin_passwd']);
					$this->db->where('admin_id',$data['txt_add_adminId'][$key]);
					$update_admin = $this->db->update('admin',$arr_admin);
				}else{
					$save_admin = $this->db->insert('admin',$arr_admin);
					$data['txt_add_adminId'][$key] = $admin;
					if(!empty($data['txt_add_priveileges'][$key])){
						$dataPrivileges                    = json_decode($data['txt_add_priveileges'][$key], true);
						$dataPrivileges['admin_id']        = $admin;
						$result                            = $this->db->insert('privileges', $dataPrivileges);
						$data['txt_add_priveileges'][$key] = json_encode($dataPrivileges);
					}else{
						$this->db->where('admin_id', $admin_parent);
						$this->db->where('type', 1);
						$result = $this->db->get('privileges')->result_array(false);
						if(!empty($result)){
							$dataPrivileges             = $result[0];
							$dataPrivileges['admin_id'] = $admin;
							$dataPrivileges['type']     = 2;
							$dataPrivileges['id']       = $this->getGUID();
							try {
								$result = $this->db->insert('privileges', $dataPrivileges);
								$data['txt_add_priveileges'][$key] = json_encode($dataPrivileges);
							} catch (Exception $e) {}
						}
					}
				}
			}	
		}
		return $data;
	}

	public function exportStore(){
		require Kohana::find_file('vendor/PHPExcleReader','PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()
					->setTitle("Export Store")
					->setCategory("Export Store");
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'Store #')
		->setCellValue('B1', 'Name')
		->setCellValue('C1', 'Address')
		->setCellValue('D1', 'Phone')
		->setCellValue('E1', 'E-mail')
		->setCellValue('F1', 'Added Date')
		->setCellValue('G1', 'Notes')
		->setCellValue('H1', 'Login Credentials')
		->setCellValue('I1', 'Employees')
		->setCellValue('J1', 'Status');

		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';

		$admin_id = $this->sess_cus['admin_id'];
		$strSql = "SELECT store_id, s_no, s_address, s_address_2, store, s_city, s_state, s_zip, s_phone, s_email, regidate, s_notes, status, ";
		$strSql .= "(SELECT COUNT(admin_id) FROM admin WHERE admin.store_id = store.store_id) as total_admin, ";
		$strSql .= "(SELECT COUNT(access_id) FROM access WHERE access.store_id = store.store_id) as total_employees ";
		$strSql .= "FROM store ";
		$strSql .= "WHERE store.admin_id = '".$admin_id."' ";
		$strSql .= "AND store_id IN(".$idSelected.")";
		$result = $this->db->query($strSql)->result_array(false);
		if(!empty($result)){
			$rowCount = 2;
			$column   = 'A';
			foreach ($result as $key => $value) {
				$address = $value['s_address'].' '.$value['s_address_2'].' '.$value['s_city'].', '.$value['s_state'].' '.$value['s_zip'];
				$address = preg_replace('/\s\s+/', ' ', $address);

				$objPHPExcel->getActiveSheet()->setCellValue("A".$rowCount, !empty($value['s_no'])?$value['s_no']:'');
				$objPHPExcel->getActiveSheet()->setCellValue("B".$rowCount, $value['store']);
				$objPHPExcel->getActiveSheet()->setCellValue("C".$rowCount, $address);
				$objPHPExcel->getActiveSheet()->setCellValue("D".$rowCount, !empty($value['s_phone'])?$value['s_phone']:'');
				$objPHPExcel->getActiveSheet()->setCellValue("E".$rowCount, !empty($value['s_email'])?$value['s_email']:'');
				$objPHPExcel->getActiveSheet()->setCellValue("F".$rowCount, !empty($value['regidate'])?date_format(date_create($value['regidate']), "m/d/Y"):'');
				$objPHPExcel->getActiveSheet()->setCellValue("G".$rowCount, !empty($value['s_notes'])?$value['s_notes']:'');
				$objPHPExcel->getActiveSheet()->setCellValue("H".$rowCount, !empty($value['total_admin'])?$value['total_admin']:0);
				$objPHPExcel->getActiveSheet()->setCellValue("I".$rowCount, !empty($value['total_employees'])?$value['total_employees']:0);
				$objPHPExcel->getActiveSheet()->setCellValue("J".$rowCount, (!empty($value['status']) && $value['status'] == 2)?'Inactive':'Active');
				$rowCount++;
			}
		}
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="ExportStore_'.date("mdYhs").'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
		die();
	}

	public function jsStore(){

		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		$iDisplayLength = (int)($_POST['length']);
		$iDisplayStart  = (int)($_POST['start']); 
		$sEcho          = (int)($_POST['draw']);
		$_data          = array();
		$total_items    = (int)($_POST['_main_count']);
		$total_filter   = $total_items;
		$admin_id       = $this->sess_cus['admin_id'];
		$sql_where      = "WHERE store.admin_id = '".$admin_id."'";
		$sql_select     = "SELECT *";
		$sql_from       = "FROM store ";
		

		$_sql_search = '';
		if(!empty($iSearch)){
   			$iSearch = $this->db->escape(trim($iSearch));
   			$iSearch    = substr($iSearch, 1, (strlen($iSearch)-2));
   			$arr        = explode(' ',trim($iSearch));
   			$dem        = count($arr);
   			if($dem > 1){
    			$_sql_search = " AND (CONCAT_WS(' ',store.s_no, store.s_first, store.s_last, store.s_address, store.s_address_2, store.s_city, store.s_state, store.s_zip, store.s_phone, store.s_email, store.s_notes, store.s_website, store.s_country) LIKE '%".$arr[0]."%'";
			    for ($i=1; $i < ($dem-1) ; $i++) { 
			      $_sql_search .= " AND CONCAT_WS(' ',store.s_no, store.s_first, store.s_last, store.s_address, store.s_address_2, store.s_city, store.s_state, store.s_zip, store.s_phone, store.s_email, store.s_notes, store.s_website, store.s_country) LIKE '%" .$arr[$i]. "%'";
			    }
			    $_sql_search .= " AND CONCAT_WS(' ',store.s_no, store.s_first, store.s_last, store.s_address, store.s_address_2, store.s_city, store.s_state, store.s_zip, store.s_phone, store.s_email, store.s_notes, store.s_website, store.s_country) LIKE '%" .$arr[$dem-1]. "%')";
   			}else{
    			$_sql_search = " AND CONCAT_WS(' ',store.s_no, store.s_first, store.s_last, store.s_address, store.s_address_2, store.s_city, store.s_state, store.s_zip, store.s_phone, store.s_email, store.s_notes, store.s_website, store.s_country) LIKE '%" .trim($iSearch). "%'";
   			}

   			$sql_query      = $sql_select.$sql_from.$sql_where.$_sql_search;
			$total_filter = $this->db->query($sql_query)->count();
		}


		$_sql_limit     = " LIMIT ".$iDisplayStart.", ".$iDisplayLength;
		$sql_query      = $sql_select.$sql_from.$sql_where.$_sql_search.$_sql_limit;
		$m_store        = $this->db->query($sql_query)->result_array(false);

		foreach ($m_store as $key => $value) {
			$last_name = ' '.$value['s_last'];
			$name      = $value['store'];
			$address   = $value['s_address'].' '.$value['s_address_2'].' '.$value['s_city'].', '.$value['s_state'].' '.$value['s_zip'];

			// table admin
			$this->db->select('COUNT(admin_id) AS Total_Admin');
			$this->db->where('store_id',$value['store_id']);
			$t_admin = $this->db->get('admin')->result_array(false);

			if(!empty($t_admin[0]))
				$total_admin = $t_admin[0]['Total_Admin'];
			else
				$total_admin = 0;

			// table access
			$this->db->select('COUNT(access_id) AS Total_Employees');
			$this->db->where('store_id',$value['store_id']);
			$t_Employees = $this->db->get('access')->result_array(false);

			if(!empty($t_Employees[0]))
				$total_Employees = $t_Employees[0]['Total_Employees'];
			else
				$total_Employees = 0;
			$sNote = text::limit_words($value['s_notes'], 5, '&nbsp;');
			$_data[] = array(
				"tdID"            => !empty($value['store_id'])?$value['store_id']:'',
				"td_No"           => !empty($value['s_no'])?$value['s_no']:'',
				"td_Name"         => $name,
				"td_Address"      => $address,
				"td_Phone"        => !empty($value['s_phone'])?$value['s_phone']:'',
				"td_Email"        => !empty($value['s_email'])?$value['s_email']:'',
				"td_Date"         => !empty($value['regidate'])?date_format(date_create($value['regidate']), "m/d/Y"):'',
				"td_Note"         => (strlen($value['s_notes']) != strlen($sNote))?$sNote.'...':$sNote,
				"DT_RowId"        => !empty($value['store_id'])?$value['store_id']:'',
				"td_Status"       => (!empty($value['status']) && $value['status'] == 2)?'Inactive':'Active',
				"total_admin"     => $total_admin,
				"total_Employees" => $total_Employees,
	    	);
		}

		$records                     = array();
		$records["data"]             = $_data;
		$records["draw"]             = $sEcho;
		$records["recordsTotal"]     = $total_items;
		$records["recordsFiltered"]  = $total_filter;
		echo json_encode($records);
		die();
	}

	public function changePrivileges($data=""){
		$dataPrivileges = array(
			'id'                           => '',
			'customers'                    => '0|0',
			'acc_overview'                 => '0|0',
			'acc_recon'                    => '0|0',
			'acc_reimbursements'           => '0|0',
			'operations_menu'              => '0|0',
			'operations_inventory'         => '0|0',
			'operation_inventory_registry' => '0|0',
			'operations_category'          => '0|0',
			'marketing_dashboard'          => '0|0',
			'marketing_loyalty'            => '0|0',
			'marketing_online'             => '0|0',
			'reports_summary'              => '0|0',
			'reports_sales'                => '0|0',
			'reports_products'             => '0|0',
			'reports_customers'            => '0|0',
			'employees_employees'          => '0|0',
			'employees_scheduling'         => '0|0',
			'employees_timecard'           => '0|0',
			'settings_general'             => '0|0',
			'settings_privileges'          => '0|0',
			'settings_stage'               => '0|0',
			'settings_receipt'             => '0|0',
			'admin_id'                     => '',
			'type'                         => '2'
		);

		if(!empty($data)){
			$dataPrivileges = array_merge($dataPrivileges, $data);
		}
		return json_encode($dataPrivileges);
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
		$type                         = '2';

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
		if($data['txt_hd_user_id'] != 'add'){
			$this->db->where('admin_id', $data['txt_hd_user_id']);
			$this->db->where('type', 2);
			$dataUser = $this->db->get('privileges')->result_array(false);
			if(!empty($dataUser)){
				unset($dataPrivileges['id']);
				$this->db->where('id', $dataUser[0]['id']);
				$result = $this->db->update('privileges', $dataPrivileges);
				$dataPrivileges['id'] = $dataUser[0]['id'];
			}else{
				$result = $this->db->insert('privileges', $dataPrivileges);
			}
		}

		echo json_encode($dataPrivileges); 

		die();
	}

	public function getFrmDefault(){
		$template = new View('store/frmPrivileges');
		$userName = '';
		$userId   = '';
		$userType = '2';
		
		$userName = $this->input->post('userName');
		$userId   = $this->input->post('userId');
		$data     = $this->input->post('userPrivileges');
		$data     = !empty($data)?json_decode($data, true):'';
		
		if($userId != 'add'){
			$this->db->where('admin_id', $userId);
			$this->db->where('type', 2);
			$result = $this->db->get('privileges')->result_array(false);
			if(!empty($result))
				$data = $result[0];
		}
		$template->set(array(
			'data'     => $data,
			'userId'   => $userId,
			'userName' => $userName,
			'userType' => $userType
		));
		$template->render(true);
		die();
	}

	public function getEditStore(){
		$template = new View('store/frmStore');
		$store_id = $this->input->post('store_id');
		$title    = 'Edit Store';

		$this->db->where('store_id', $store_id);
		$Store = $this->db->get('store')->result_array(false);
		$Store = $Store[0];

		$this->db->where('store_id', $store_id);
		$Admin = $this->db->get('admin')->result_array(false);

		foreach ($Admin as $key => $item) {
			$this->db->where('admin_id', $item['admin_id']);
			$data                      = $this->db->get('privileges')->result_array(false);
			$privileges                = $this->changePrivileges(!empty($data)?$data[0]:array('admin_id' => $item['admin_id']));
			$Admin[$key]['privileges'] = $privileges;
		}

		$total_admin = count($Admin);

		$data = array(
			"store_id"        => $store_id,
			"admin_id"        => !empty($Store['admin_id'])?$Store['admin_id']:'',
			"s_no"            => !empty($Store['s_no'])?$Store['s_no']:'',
			"store"           => !empty($Store['store'])?$Store['store']:'',
			"s_first"         => !empty($Store['s_first'])?$Store['s_first']:'',
			"s_last"          => !empty($Store['s_last'])?$Store['s_last']:'',
			"s_address"       => !empty($Store['s_address'])?$Store['s_address']:'',
			"s_address_2"     => !empty($Store['s_address_2'])?$Store['s_address_2']:'',
			"s_city"          => !empty($Store['s_city'])?$Store['s_city']:'',
			"s_state"         => !empty($Store['s_state'])?$Store['s_state']:'',
			"s_zip"           => !empty($Store['s_zip'])?$Store['s_zip']:'',
			"s_country"       => !empty($Store['s_country'])?$Store['s_country']:'',
			"s_phone"         => !empty($Store['s_phone'])?$Store['s_phone']:'',
			"tdAreaCode"      => !empty($Store['account_area_code'])?$Store['account_area_code']:'',
			"s_email"         => !empty($Store['s_email'])?$Store['s_email']:'',
			"s_website"       => !empty($Store['s_website'])?$Store['s_website']:'',
			"s_notes"         => !empty($Store['s_notes'])?$Store['s_notes']:'',
			"s_pk"            => !empty($Store['s_pk'])?$Store['s_pk']:'',
			"e_serial_number" => !empty($Store['e_serial_number'])?$Store['e_serial_number']:'',
			"e_user_name"     => !empty($Store['e_user_name'])?$Store['e_user_name']:'',
			"e_password"      => !empty($Store['e_password'])?$Store['e_password']:'',
			"time_zone"       => !empty($Store['time_zone'])?$Store['time_zone']:'0'
		);

		$template->set(array(
			'data'        => $data,
			'total_admin' => $total_admin,
			'Admin'       => $Admin,
			'title'       => $title,
			'subtitle'    => 'Edit the details for the store or branch location here. User access for store employees can also be managed on this page.',
			'admin_id'    => $this->input->post('admin_id')
		));
		$template->render(true);
		exit();
	}

	public function delete(){
		print_r($_POST);
		// $user_id = $this->input->post('chk_customer');
		// $this->db->in('user_id',$user_id);
		// $result = $this->db->update('user',array('u_status' => '0'));
		// if($result){
		//    	echo json_encode(array(
		//     	'msg' => true,
		//    	));
		// }else{
		//    	echo json_encode(array(
		//     	'msg' => false,
		//    	));
		// }
		die();
	}

	public function checkCode(){
		$txt_code = $this->input->post('txt_code');
		$admin_id = $this->sess_cus['admin_id'];
		$chk_code = array();
		if(!empty($txt_code)){
			$this->db->where('s_no',$txt_code);
			$this->db->where('admin_id',$admin_id);
			$chk_code = $this->db->get('store')->result_array(false);
		}
		if(!empty($chk_code)){
			echo json_encode(array('msg' => 'false'));
			die();
		}
		echo json_encode(array('msg' => 'true'));
		die();
	}

	public function nextCode(){
		$admin_id = $this->sess_cus['admin_id'];
		$this->db->select('MAX(store.s_no) AS max_no');
		$this->db->where('store.admin_id',$admin_id);
		$max_no = $this->db->get('store')->result_array(false);
		$max_no_continue = 1000;
		if(!empty($max_no[0]['max_no']))
			$max_no_continue = (int)$max_no[0]['max_no'] + 1;
		echo json_encode(array(
			'msg'  => 'true',
			'code' => $max_no_continue
		));
		die();
	}

	public function save(){
		if($_POST){
			$data         = $this->input->post();
			$store_id     = $this->getGUID();
			$admin_parent = !empty($data['txt_admin_id'])?$data['txt_admin_id']:$this->sess_cus['admin_refer_id'];
			$arr_store = array(
				'store_id'        => $store_id, 
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
				'status'          => 2,
				'admin_id'        => $admin_parent,
				'regidate'        => date("Y-m-d H:i:s"),
				's_pk'            => !empty($data['txt_store_s_pk'])?$data['txt_store_s_pk']:'',
				'e_serial_number' => !empty($data['txt_store_e_serial_number'])?$data['txt_store_e_serial_number']:'',
				'e_user_name'     => !empty($data['txt_store_e_user_name'])?$data['txt_store_e_user_name']:'',
				'e_password'      => !empty($data['txt_store_e_password'])?$data['txt_store_e_password']:'',
				'time_zone'       => !empty($data['txt_store_timezone'])?$data['txt_store_timezone']:'0'

			);

			$this->db->where('admin_id', $admin_parent);
			$this->db->where('s_default', 1);
			$numStore = $this->db->get('store')->count();
			if($numStore <= 0){
				$arr_store['s_default'] = 1;
			}

			if($data['txt_id_store'] != ''){
				unset($arr_store['store_id']);
				unset($arr_store['regidate']);
				unset($arr_store['status']);
				$store_id = $data['txt_id_store']; 
				$this->db->where('store_id',$store_id);
				$update   = $this->db->update('store',$arr_store);
			}else{
				$save_store = $this->db->insert('store',$arr_store);
				if($save_store){
					if(isset($data['txt_add_email']) && !empty($data['txt_add_email'])){
						foreach ($data['txt_add_email'] as $key => $value) {
							$admin = $this->getGUID();
							if(isset($data['freeze_user'])){
								if($data['freeze_user'][$key] == 3)
									$freeze_user = 3;
								else
									$freeze_user = 1;
							}
							if(isset($data['allow_user'])){
								if($data['allow_user'][$key] == 1)
									$allow_user = 1;
								else
									$allow_user = 0;
							}
							$arr_admin = array(
								'admin_id'          => $admin,
								'admin_refer_id'    => $admin_parent,
								'admin_first_name'  => !empty($data['txt_add_first'][$key])?$data['txt_add_first'][$key]:'',
								'admin_name'        => !empty($data['txt_add_last'][$key])?$data['txt_add_last'][$key]:'',
								'admin_email'       => $value,
								'admin_email_login' => $value,
								'admin_status'      => $freeze_user,
								'admin_change_pass' => $allow_user,
								'admin_level'       => 2,
								'admin_regidate'    => date("Y-m-d H:i:s"),
								'admin_passwd'      => md5($data['txt_add_password'][$key]),//$this->crypt($data['txt_add_password'][$key]),
								'store_id'          => $store_id,
							);
							$save_account = $this->db->insert('admin',$arr_admin);
							if(!empty($data['txt_privileges'][$key])){
								$dataPrivileges             = json_decode($data['txt_privileges'][$key], true);
								$dataPrivileges['admin_id'] = $admin;
								$result                     = $this->db->insert('privileges', $dataPrivileges);
							}else{
								$this->db->where('admin_id', $admin_parent);
								$this->db->where('type', 1);
								$result = $this->db->get('privileges')->result_array(false);
								if(!empty($result)){
									$dataPrivileges             = $result[0];
									$dataPrivileges['admin_id'] = $admin;
									$dataPrivileges['type']     = 2;
									$dataPrivileges['id']       = $this->getGUID();
									try {
										$result = $this->db->insert('privileges', $dataPrivileges);
									} catch (Exception $e) {}
								}
							}
						}	
					}	
				}
			}
			url::redirect('store');
			exit();
		}
	}

	public function getPrivileges(){
		$adminId = $this->sess_cus['admin_refer_id'];
		$this->db->where('admin_id', $adminId);
		$this->db->where('type', 1);
		$result = $this->db->get('privileges')->result_array(false);
		if(!empty($result)){
			echo json_encode(array(
				'data'   => $result[0],
				'status' => true
			));
			die();
		}
		echo json_encode(array(
			'data'   => '',
			'status' => false
		));
		die();
	}

	public function setPrivileges($adminId){
		$this->db->where('admin_id', $adminId);
		$this->db->where('type', 1);
		$result = $this->db->get('privileges')->result_array(false);
		if(empty($result)){
			$this->db->where('admin_id', 0);
			$this->db->where('type', 0);
			$sitePrivileges = $this->db->get('privileges')->result_array(false);
			if(!empty($sitePrivileges)){
				$data             = $sitePrivileges[0];
				$data['id']       = $this->getGUID();
				$data['admin_id'] = $adminId;
				$data['type']     = 1;
				try {
					$this->db->insert('privileges', $data);
				} catch (Exception $e) {}
			}
		}
	}
}
?>