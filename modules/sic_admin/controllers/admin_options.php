<?php
class Admin_options_Controller extends Template_Controller {
	public $template;	
	public function __construct(){
        parent::__construct();
        $this->template = new View('templates/'.$this->site['config']['TEMPLATE'].'/index');
		if(empty($this->sess_admin['super_id'])){
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){    
				header('HTTP/1.1 302 Found', true, 302);
				die();
			}else
				url::redirect('/admin_login');
		}
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
		$this->template->content = new View('admin_options/index');
		$this->template->jsKiosk = new View('admin_options/jsIndex');

		$this->db->where('admin_id', 0);
		$this->db->where('type', 0);
		$data = $this->db->get('privileges')->result_array(false);

		$this->db->where('admin_id', 0);
		$this->db->where('opd_name', 'cus_nondisplay');
		$this->db->where('opd_type', 0);
		$cus_nondisplay  = $this->db->get('option_default')->result_array(false);

		$this->template->content->set(array(
			'data'           => !empty($data)?$data[0]:'',
			'cus_nondisplay' => !empty($cus_nondisplay[0]['opd_value'])?explode(',', $cus_nondisplay[0]['opd_value']):array()
		));
	}

	public function saveCusNoDisplay(){
		$myData      = array();
		$dataDefault = array(1,2,3,4,5,6,7,8);
		$data        = $this->input->post('txt_cus_nondisplay');
		if(!empty($data)){
			$myData = array_diff($dataDefault, $data);
		}
		$this->db->where('admin_id', 0);
		$this->db->where('opd_name', 'cus_nondisplay');
		$this->db->where('opd_type', 0);
		$result  = $this->db->get('option_default')->result_array(false);
		if(!empty($result)){
			$_item = array(
				'opd_value' => !empty($myData)?implode(',', $myData):''
			);
			try {
				$this->db->where('opd_id', $result[0]['opd_id']);
				$this->db->update('option_default', $_item);
				$this->session->set_flash('success_msg', 'Changes saved.');
			} catch (Exception $e) {
				$this->session->set_flash('error_msg', 'Could not complete request.');
			}
			
		}else{
			$_item = array(
				'opd_id'    => $this->getGUID(),
				'opd_name'  => 'cus_nondisplay',
				'opd_value' => !empty($myData)?implode(',', $myData):'',
				'admin_id'  => 0,
				'opd_type'  => 0
			);
			try {
				$this->db->insert('option_default', $_item);
				$this->session->set_flash('success_msg', 'Changes saved.');
			} catch (Exception $e) {
				$this->session->set_flash('error_msg', 'Could not complete request.');
			}
			
		}
		url::redirect('admin_options');
		die();
	}

	public function savePrivileges(){
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
		
		$admin_id                     = 0;
		$type                         = 0;

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
		url::redirect('admin_options');
		die();
	}
}
?>