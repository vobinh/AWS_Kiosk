<?php
class Customers_Controller extends Template_Controller {
	
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
		$this->customers_model = new Customers_Model();
		$this->user_model      = new User_Model();
		$this->store_model     = new Store_Model();
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
	public function __call($method, $arguments){
		url::redirect('/');
	}

	public function index(){
		$this->opColumnDisplay();
		$this->customers();
	}

	public function autoSave($type = 'nonDislay'){
		$result = '';
		switch ($type) {
			default:
				$data = $this->input->post('txt_non_display');
				$this->db->where('admin_id', $this->sess_cus['admin_id']);
				$this->db->where('opd_name', 'cus_nondisplay');
				$this->db->where('opd_type', 2);
				$opdData  = $this->db->get('option_default')->result_array(false);

				if(!empty($opdData)){
					$_item = array(
						'opd_value' => !empty($data)?implode(',', $data):''
					);
					try {
						$this->db->where('opd_id', $opdData[0]['opd_id']);
						$this->db->update('option_default', $_item);
						$result = array(
							'status' => true,
							'msg'    => ''
						);
						echo json_encode($result);
						die();
					} catch (Exception $e) {}
					
				}else{
					$_item = array(
						'opd_id'    => $this->getGUID(),
						'opd_name'  => 'cus_nondisplay',
						'opd_value' => !empty($data)?implode(',', $data):'',
						'admin_id'  => $this->sess_cus['admin_id'],
						'opd_type'  => 2
					);
					try {
						$this->db->insert('option_default', $_item);
						$result = array(
							'status' => true,
							'msg'    => ''
						);
						echo json_encode($result);
						die();
					} catch (Exception $e) {}
					
				}
				break;
		}
		$result = array(
			'status' => false,
			'msg'    => ''
		);
		echo json_encode($result);
		die();
	}

	public function opColumnDisplay(){
		$this->db->where('admin_id', $this->sess_cus['admin_id']);
		$this->db->where('opd_name', 'cus_nondisplay');
		$this->db->where('opd_type', 2);
		$result  = $this->db->get('option_default')->result_array(false);
		if(empty($result)){
			/* get site Default */
			$this->db->where('admin_id', 0);
			$this->db->where('opd_name', 'cus_nondisplay');
			$this->db->where('opd_type', 0);
			$result  = $this->db->get('option_default')->result_array(false);
		}
		return !empty($result[0]['opd_value'])?explode(',', $result[0]['opd_value']):array();

	}

	public function customers(){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['customers'], 0, 1) == '0')){
			$this->template->content = new View('templates/noAccess');
		}else{
			$this->template->content = new View('customers/customers');
			$this->template->jsKiosk = new View('customers/jsCustomers');
			$store_id = base64_decode($this->sess_cus['storeId']);
			if($store_id != '0'){  // admin login
				$this->db->where('store_id',$store_id);
			}else{
				$this->db->select('store_id');
				$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
				$listStore = $this->db->get('store')->result_array(false);
				if(!empty($listStore)){
					$listStore = array_column($listStore, 'store_id');
					$this->db->in('user.store_id', $listStore);
				}else{
					$this->db->in('user.store_id', array('-1'));
				}
			}

			$total_user = $this->user_model->count_user();
			$this->template->content->cus_nondisplay = $this->opColumnDisplay();
			$this->template->jsKiosk->total_user     = !empty($total_user[0])?$total_user[0]['total_user']:0;
			$this->template->jsKiosk->cus_nondisplay = json_encode($this->opColumnDisplay());
		}
	}

	public function organizations(){
		$this->template->content = new View('customers/organizations');
		$this->template->jsKiosk = new View('customers/jsCustomers_organizations');
	}

	public function exportCus(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportCustomer_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w");  
		fputcsv($output, array(
			'Associated Store', 
			'Account ID', 
			'Name', 
			'Point', 
			'Address', 
			'Phone', 
			'Added Date',
			'Notes'
		));

		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';

		$strSql = "SELECT user.u_points,  user.regidate, user.account_id, 
					CONCAT_WS(' ', account.account_first_name, account.name) AS customer_name, 
					CONCAT_WS(' ', account.account_address, account.account_address_2, account.account_city) AS address, 
					CONCAT_WS(' ', account.account_state, account.account_zip) AS location, account.phone, account.account_email, account.payment_notes, 
					store.store AS store_name ";
		$strSql .= "FROM user ";
		$strSql .= "LEFT JOIN account ON account.account_id = user.account_id ";
		$strSql .= "LEFT JOIN store ON store.store_id = user.store_id ";
		$strSql .= "WHERE user.user_id IN(".$idSelected.") ";
		$strSql .= "ORDER BY store.store_id ASC, account_no DESC";
		$result = $this->db->query($strSql)->result_array(false);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$address = $value['address'].(!empty($value['location'])?', '.$value['location']:'');
				$item   = array();
				$item[] = $value['store_name'];
				$item[] = $value['account_id'];
				$item[] = $value['customer_name'];
				$item[] = $value['u_points'];
				$item[] = $address;
				$item[] = $value['phone'];
				$item[] = date_format(date_create($value['regidate']), "m/d/Y");
				$item[] = $value['payment_notes'];
				fputcsv($output, $item);
			}
			fclose($output);
		}
		die();
	}

	public function jsCustomer(){
		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		$iDisplayLength = (int)($_POST['length']);
		$iDisplayStart  = (int)($_POST['start']); 
		$sEcho          = (int)($_POST['draw']);
		$_data          = array();
		$total_items    = (int)($_POST['_main_count']);
		$total_filter   = $total_items;
		$store_id       = base64_decode($this->sess_cus['storeId']);
		if((string)$store_id == '0'){  // superadmin login
			$listStore = $this->getAllStore();
			if(!empty($listStore)){
				$sql_where = "WHERE user.store_id IN('".implode('\',\'', $listStore)."')";
			}else{
				$sql_where = "WHERE user.store_id IN('-1')";
			}
			
		}else{               // admin login
			$sql_where      = "WHERE user.store_id = '".$store_id."'";
		}
	
		$sql_select     = "SELECT *, account.regidate as regidate, store.regidate as s_regidate ";
		$sql_from       = "FROM user ";
		$sql_join       = "LEFT JOIN account ON account.account_id = user.account_id ";
		$sql_join_store = "LEFT JOIN store ON store.store_id = user.store_id ";
		$_sql_order     = " ORDER BY store.store_id ASC, account_no DESC";

		$_sql_search = '';
		if(!empty($iSearch)){
   			$iSearch = $this->db->escape(trim($iSearch));
   			$iSearch    = substr($iSearch, 1, (strlen($iSearch)-2));
   			$arr        = explode(' ',trim($iSearch));
   			$dem        = count($arr);
   			if($store_id == 0){
	   			if($dem > 1){
	    			$_sql_search = " AND (CONCAT_WS(' ',account.account_no,account.account_first_name,account.name,account.account_address,account.account_address_2,account.account_city,account.account_state,account.account_zip,account.phone,account.account_email,account.regidate,account.payment_notes,store.s_first,store.s_last) LIKE '%".$arr[0]."%'";
				    for ($i=1; $i < ($dem-1) ; $i++) { 
				      $_sql_search .= " AND CONCAT_WS(' ',account.account_no,account.account_first_name,account.name,account.account_address,account.account_address_2,account.account_city,account.account_state,account.account_zip,account.phone,account.account_email,account.regidate,account.payment_notes,store.s_first,store.s_last) LIKE '%" .$arr[$i]. "%'";
				    }
				    $_sql_search .= " AND CONCAT_WS(' ',account.account_no,account.account_first_name,account.name,account.account_address,account.account_address_2,account.account_city,account.account_state,account.account_zip,account.phone,account.account_email,account.regidate,account.payment_notes,store.s_first,store.s_last) LIKE '%" .$arr[$dem-1]. "%')";
	   			}else{
	    			$_sql_search = " AND CONCAT_WS(' ',account.account_no,account.account_first_name,account.name,account.account_address,account.account_address_2,account.account_city,account.account_state,account.account_zip,account.phone,account.account_email,account.regidate,account.payment_notes,store.s_first,store.s_last) LIKE '%" .trim($iSearch). "%'";
	   			}
	   		}else{
	   			if($dem > 1){
	    			$_sql_search = " AND (CONCAT_WS(' ',account.account_no,account.account_first_name,account.name,account.account_address,account.account_address_2,account.account_city,account.account_state,account.account_zip,account.phone,account.account_email,account.regidate,account.payment_notes) LIKE '%".$arr[0]."%'";
				    for ($i=1; $i < ($dem-1) ; $i++) { 
				      $_sql_search .= " AND CONCAT_WS(' ',account.account_no,account.account_first_name,account.name,account.account_address,account.account_address_2,account.account_city,account.account_state,account.account_zip,account.phone,account.account_email,account.regidate,account.payment_notes) LIKE '%" .$arr[$i]. "%'";
				    }
				    $_sql_search .= " AND CONCAT_WS(' ',account.account_no,account.account_first_name,account.name,account.account_address,account.account_address_2,account.account_city,account.account_state,account.account_zip,account.phone,account.account_email,account.regidate,account.payment_notes) LIKE '%" .$arr[$dem-1]. "%')";
	   			}else{
	    			$_sql_search = " AND CONCAT_WS(' ',account.account_no,account.account_first_name,account.name,account.account_address,account.account_address_2,account.account_city,account.account_state,account.account_zip,account.phone,account.account_email,account.regidate,account.payment_notes) LIKE '%" .trim($iSearch). "%'";
	   			}
	   		}

   			$sql_query  = $sql_select.$sql_from.$sql_join.$sql_join_store.$sql_where.$_sql_search;
			$total_filter = $this->db->query($sql_query)->count();
		}
		
		$_sql_limit = " LIMIT ".$iDisplayStart.", ".$iDisplayLength;
		$sql_query  = $sql_select.$sql_from.$sql_join.$sql_join_store.$sql_where.$_sql_search.$_sql_order.$_sql_limit;
		$m_user     = $this->db->query($sql_query)->result_array(false);
		if(!empty($m_user)){
			foreach ($m_user as $key => $value) {
				$last_name  = ' '.$value['name'];
				$name       = $value['account_first_name'].$last_name;
				$address    = $value['account_address'].' '.$value['account_address_2'].' '.$value['account_city'].', '.$value['account_state'].' '.$value['account_zip'];
				
				$Store_last = ' '.$value['s_last'];
				$store_name = $value['s_first'].$Store_last;

				$_data[] = array(
					"tdID"        => !empty($value['user_id'])?$value['user_id']:'',
					"tdCust"      => !empty($value['account_no'])?$value['account_no']:'',
					"tdName"      => $name,
					"tdAccID"     => !empty($value['account_id'])?$value['account_id']:'',
					"tdPoint"     => !empty($value['u_points'])?$value['u_points']:'0',
					"tdStoreName" => $value['store'],
					"tdAddress"   => $address,
					"tdPhone"     => !empty($value['phone'])?$value['phone']:'',
					"tdEmail"     => !empty($value['account_email'])?$value['account_email']:'',
					"tdDate"      => !empty($value['regidate'])?date_format(date_create($value['regidate']), "m/d/Y"):'',
					"tdNote"      => !empty($value['payment_notes'])?$value['payment_notes']:'',
					"DT_RowId"    => !empty($value['user_id'])?$value['user_id']:'',
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

	public function getEditCustomers($type = 1){

		$template   = new View('customers/frmCustomers');

		$idCustomer = $this->input->post('idCustomer');

		switch ($type) {
			case 1:
				$title = 'Edit Customer';
				$type  = 1;
				break;
			case 2:
				$title = 'Edit Organization';
				$type  = 2;
				break;
			default:
				$title = 'Edit Customer';
				$type  = 1;
				break;
		}
		$this->db->where('user_id', $idCustomer);
		$this->db->join('account', array('account.account_id' => 'user.account_id'),'','left');
		$Customer = $this->db->get('user')->result_array(false);
		$Customer = !empty($Customer)?$Customer[0]:'';
		$data = array(
			"tdID"        => $idCustomer,
			"tdStoreID"   => !empty($Customer['store_id'])?$Customer['store_id']:'',
			"tdAccID"     => !empty($Customer['account_id'])?$Customer['account_id']:'',
			"tdCust"      => !empty($Customer['account_no'])?$Customer['account_no']:'',
			"tdFirstName" => !empty($Customer['account_first_name'])?$Customer['account_first_name']:'',
			"tdLastName"  => !empty($Customer['name'])?$Customer['name']:'',
			"tdName"      => !empty($Customer['name'])?$Customer['name']:'',
			"tdAddress"   => !empty($Customer['account_address'])?$Customer['account_address']:'',
			"tdAddress2"  => !empty($Customer['account_address_2'])?$Customer['account_address_2']:'',
			"tdCity"      => !empty($Customer['account_city'])?$Customer['account_city']:'',
			"tdState"     => !empty($Customer['account_state'])?$Customer['account_state']:'',
			"tdZip"       => !empty($Customer['account_zip'])?$Customer['account_zip']:'',
			"tdCountry"   => !empty($Customer['account_country'])?$Customer['account_country']:'',
			"tdAreaCode"  => !empty($Customer['account_area_code'])?$Customer['account_area_code']:'',
			"tdPhone"     => !empty($Customer['phone'])?$Customer['phone']:'',
			"tdEmail"     => !empty($Customer['account_email'])?$Customer['account_email']:'',
			"tdDate"      => !empty($Customer['regidate'])?$Customer['regidate']:'',
			"tdNote"      => !empty($Customer['payment_notes'])?$Customer['payment_notes']:'',
			"tdPoint"     => !empty($Customer['u_points'])?$Customer['u_points']:'',
			"infoPayment" => array(
				'pName' => !empty($Customer['payment_name'])?$Customer['payment_name']:'',
				'pCard' => !empty($Customer['payment_no'])?$Customer['payment_no']:'',
				'pDate' => !empty($Customer['payment_date'])?$Customer['payment_date']:'',
				'pCVC' =>  !empty($Customer['payment_area_code'])?$Customer['payment_area_code']:'',
			)
		);
		$this->db->where('admin_id',$this->sess_cus['admin_refer_id']);
		$store = $this->db->get('store')->result_array(false);
		$template->set(array(
			'data'  => $data,
			'title' => $title,
			'type'  => $type,
			'store' => $store
		));
		$template->render(true);
		exit();
	}

	public function getAddCustomers($type = 1){
		$template = new View('customers/frmCustomers');
		switch ($type) {
			case 1:
				$title = 'Add New Customer';
				$type  = 1;
				break;
			case 2:
				$title = 'Add New Organization';
				$type  = 2;
				break;
			default:
				$title = 'Add New Customer';
				$type  = 1;
				break;
		}

		$store = $this->store_model->getStoreAdmin($this->sess_cus['admin_refer_id']);

		$template->set(array(
			'title' => $title,
			'type'  => $type,
			'store' => $store
		));
		$template->render(true);
		die();
	}

	public function delete($type = 1){
		$user_id = $this->input->post('chk_customer');

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

	public function save($type = 1){
		//echo Kohana::debug($_POST);
		if(!empty($_POST) && $_POST){
			$account_id = $this->getGUID();
			if(isset($_POST['txt_cus_store']))
				$store_id = $_POST['txt_cus_store'];
			else
				$store_id = base64_decode($this->sess_cus['storeId']);
			$arr_customers = array(
				'account_id'         => $account_id,
				'account_no'         => !empty($_POST['txt_cus_no'])?$_POST['txt_cus_no']:'',
				'account_address'    => !empty($_POST['txt_cus_address'])?$_POST['txt_cus_address']:'',
				'account_address_2'  => !empty($_POST['txt_cus_address2'])?$_POST['txt_cus_address2']:'',
				'account_city'       => !empty($_POST['txt_cus_city'])?$_POST['txt_cus_city']:'',
				'account_state'      => !empty($_POST['txt_cus_state'])?$_POST['txt_cus_state']:'',
				'account_zip'        => !empty($_POST['txt_cus_zip'])?$_POST['txt_cus_zip']:'',
				'account_country'    => !empty($_POST['txt_cus_country'])?$_POST['txt_cus_country']:'',
				'account_area_code'  => !empty($_POST['txt_cus_code_phone'])?$_POST['txt_cus_code_phone']:'',
				'account_email'      => !empty($_POST['txt_cus_email'])?$_POST['txt_cus_email']:'',
				'account_type'       => $type,
				'account_first_name' => !empty($_POST['txt_cus_first_name'])?$_POST['txt_cus_first_name']:'',
				'payment_name'       => !empty($_POST['txt_cus_card_name'])?$_POST['txt_cus_card_name']:'',
				'payment_no'         => !empty($_POST['txt_cus_card_num'])?$_POST['txt_cus_card_num']:'',
				'payment_date'       => !empty($_POST['txt_cus_card_date'])?$_POST['txt_cus_card_date']:'',
				'payment_area_code'  => !empty($_POST['txt_cus_card_cvc'])?$_POST['txt_cus_card_cvc']:'',
				'payment_notes'      => !empty($_POST['txt_cus_card_note'])?$_POST['txt_cus_card_note']:'',
				'name'               => !empty($_POST['txt_cus_last_name'])?$_POST['txt_cus_last_name']:'',
				'phone'              => !empty($_POST['txt_cus_phone'])?$_POST['txt_cus_phone']:'',
				'status'             => 1,
				'regidate'           => date("Y-m-d H:i:s"),
			);

			if($_POST['txt_hd_id'] == ''){				
				$s_account = $this->customers_model->save($arr_customers);
				if($s_account){
					$user_id = $this->getGUID();
					$arr_user = array(
						'user_id'    => $user_id,
						'account_id' => $account_id,
						'store_id'   => $store_id,
						'u_points'   => 1,
						'u_status'   => 1,
						'u_level'    => 3,
						'regidate'   => date("Y-m-d H:i:s"),
					);
					$this->user_model->save($arr_user);
				}
			}else{
				$P_account_id = $_POST['txt_account_id'];
				unset($arr_customers['account_id']);
				unset($arr_customers['regidate']);
				unset($arr_customers['status']);
				$this->db->where('account_id',$P_account_id);
				$update_user = $this->db->update('account',$arr_customers);
				if(isset($_POST['txt_cus_store'])){
					if($update_user){
						$arr_user = array(
							'store_id'   => $store_id,
						);
						$this->db->where('account_id',$P_account_id);
						$this->db->update('user',$arr_user);
					}
				}
			}	
		}
		url::redirect('customers');
	}

	private function getAllStore(){
		$supAdmin = $this->sess_cus['admin_refer_id'];
		$this->db->select('store_id');
		$result = $this->store_model->getStoreAdmin($supAdmin);
		if(!empty($result)){
			$result = array_column($result, 'store_id');
		}
		return $result;
	}

	public function checkCode($type = 1){
		
		$storeUsing = $this->input->post('store_id');
		if($storeUsing == '')
			$storeUsing = base64_decode($this->sess_cus['storeId']);

		$txt_code = $this->input->post('txt_code');
		$store_id = $this->getAllStore();
		$chk_code = array();
		if(!empty($txt_code))
			$chk_code = $this->customers_model->chk_customers_code($txt_code,$store_id);

		if(!empty($chk_code)){
			if($chk_code[0]['store_id'] != $storeUsing){
				echo json_encode(array(
					'msg'    => 'The customer number is already being used by another affiliated restaurant.',
					'result' => false
				));
			}else{
				echo json_encode(array(
					'msg'    => 'The customer number already exists.',
					'result' => false
				));
			}
			
			die();
		}
		echo json_encode(array(
			'msg'    => '',
			'result' => true
		));
		die();
	}

	public function nextCode($type = 1){
		$store_id        = $this->getAllStore();
		$max_no          = $this->customers_model->get_max_cus_no($store_id);
		$max_no_continue = 1000;
		if(!empty($max_no['max_no']))
			$max_no_continue = (int)$max_no['max_no'] + 1;
		echo json_encode(array(
			'msg'  => 'true',
			'code' => $max_no_continue
		));
		die();
	}

	public function changeStore(){
		$storeId  = $this->input->post('slt_change_store');
		$idChange = $this->input->post('txt_id_change');
		if(!empty($storeId) && !empty($idChange) && (string)$storeId != '-1'){
			$this->db->select('store_id');
			$this->db->where('store_id', $storeId);
			$store = $this->db->get('store')->result_array(false);
			if(!empty($store)){
				try {
					$idChange   = explode(',', $idChange);
					$dataUpdate = array(
						'store_id' => $storeId
					);
					
					/* Get account_id */
					$this->db->select('distinct account_id');
					$this->db->in('user_id', $idChange);
					$account = $this->db->get('user')->result_array(false);
					/* Get account_id non update */
					$arrAccount = array();
					if(!empty($account)){
						$arrTemp = array_column($account, 'account_id');
						$this->db->select('distinct account_id');
						$this->db->in('account_id', $arrTemp);
						$this->db->where('store_id', $storeId);
						$arrUser = $this->db->get('user')->result_array(false);
						if(!empty($arrUser)){
							$arrAccount = array_column($arrUser, 'account_id');
						}
					}
					$this->db->in('user_id', $idChange);
					if(!empty($arrAccount))
						$this->db->notin('account_id', $arrAccount);
					$result = $this->db->update('user', $dataUpdate);
					$this->session->set_flash('success_msg', $result->count().' items updated.');
					url::redirect('customers');
					die();
				} catch (Exception $e) {
					
				}
			}
		}
		$this->session->set_flash('error_msg', 'Could not complete request.');
		url::redirect('customers');
		die();
	}
}
?>