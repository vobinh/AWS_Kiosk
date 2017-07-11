<?php
class Accounting_Controller extends Template_Controller {
	
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
		$this->reconciliations();
		url::redirect('accounting/reconciliations');
	}

	public function reconciliations($warehouse_or_store = '', $detail_type = ''){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['acc_recon'], 0, 1) == '0')){
			$this->template->content = new View('templates/noAccess');
		}else{
			$_storeId  = base64_decode($this->sess_cus['storeId']);
			$storeOnly = true;
			if((string)$_storeId == '0'){
				$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
				$this->db->where('status', 1);
				$listStore   = $this->store_model->get();
				$storeActive = 'warehouse';
				$storeOnly   = false;
			}else{
				$this->db->where('store_id', $_storeId);
				$this->db->where('status', 1);
				$listStore   = $this->store_model->get();
				$storeActive = $_storeId;
				$storeOnly   = true;
			}

			
			$detail_type  = 'purchases';
			$typeDate     = 'today';
			$typeFilter   = '1';
			$typeItemSold = '1';
			$timeFrom     = '00:00:00';
			$timeTo       = '23:59:59';
			$dateFrom     = date('m/d/Y '.$timeFrom);
			$dateTo       = date('m/d/Y '.$timeTo);

			$this->db->where('admin_id', $this->sess_cus['admin_id']);
			$this->db->where('opd_type', 2);
			$this->db->where('opd_name','acc_shifts');
			$dataShifts = $this->db->get('option_default')->result_array(false);
			if(!empty($dataShifts)){
				$dataShifts    = json_decode($dataShifts[0]['opd_value'], true);
			}else{
				$dataShifts = array(
					'Breakfast' => '9:00|11:00',
					'Lunch'     => '11:01|14:00',
					'Dinner'    => '17:00|22:00'
				);
			}

			if(isset($_POST) && !empty($_POST)){
		
				$detail_type  = $this->input->post('type_warehouse');
				$typeFilter   = $this->input->post('shift_filter');
				$typeDate     = $this->input->post('date_filter');
				$shiftFilter  = $this->input->post('shift_filter');
				$typeItemSold = $this->input->post('type_item_sold');
				$timeFrom     = $this->input->post('txt_time_from');
				$timeTo       = $this->input->post('txt_time_to');
				switch ($shiftFilter) {
					case 1:
						$timeFrom .= ':00';
						$timeTo   .= ':59';
						break;
					default:
						$timeFrom .= ':00';
						$timeTo   .= ':00';
						break;
				}

				$dateFrom    = $this->input->post('txt_date_from').' '.$timeFrom;
				$dateTo      = $this->input->post('txt_date_to').' '.$timeTo;

				$storeActive = $this->input->post('slt_store_active');
			}

			if($storeActive == 'warehouse'){
				$this->template->content = new View('reconciliation/Warhouse/index');
				$this->template->jsKiosk = new View('reconciliation/Warhouse/jsIndex');

				if($detail_type == 'purchases'){
					/* API listWHOrder */
					$this->db->select('warehouse_order.*,product.*, sub_category.sub_category_name, sub_category.category_id');
					$this->db->in('warehouse_order.mark_complete', array('0'));
					$this->db->where('warehouse_order.admin_id', $this->sess_cus['admin_refer_id']);
					$this->db->where('warehouse_order.date_mark_complete BETWEEN \''.date('Y-m-d H:i:s', strtotime($dateFrom)).'\' AND \''.date('Y-m-d H:i:s', strtotime($dateTo)).'\'');
					$this->db->join('product', array('product.pro_id' => 'warehouse_order.pro_id'),'','');
					$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','');
					$this->db->orderby('warehouse_order.w_regidate', 'desc');
					$this->db->orderby('sub_category.sub_category_name', 'asc');
					$dataOrder = $this->db->get('warehouse_order')->result_array(false);

					$dataAdjustment = $this->_adjustment(1, $dateFrom, $dateTo, $storeActive);
				}else{
					/* API listWHdistribution*/
					$detail_type = 'distribution';
					$this->db->select('product.file_id,sub_category.sub_category_name,product.pro_id,product.pro_name,product.pro_no,product.pro_cost_store,product.pro_per_store,product.pro_unit,store_order.store_price,store_order.store_order_id,store_order.mark_complete,store_order.date_mark_complete,store_order.store_unit,store_order.store_regidate,store_order.store_order_from,store.s_first,store.s_last, store.store, store_order.date_mark_warehouse_complete');
					$this->db->where('store_order.admin_id', $this->sess_cus['admin_refer_id']);
					$this->db->in('store_order.mark_complete', array('0', '1'));
					$this->db->where('store_order.store_order_from', 'warehouse');
					$this->db->where('store_order.date_mark_warehouse_complete BETWEEN \''.date('Y-m-d H:i:s', strtotime($dateFrom)).'\' AND \''.date('Y-m-d H:i:s', strtotime($dateTo)).'\'');
					$this->db->join('product', array('product.pro_id' => 'store_order.product_id'),'','');
					$this->db->join('store', array('store.store_id' => 'store_order.store_id'),'','');
					$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
					$this->db->orderby('sub_category.sub_category_name', 'ASC');
					$dataOrder = $this->db->get('store_order')->result_array(false);

					$dataAdjustment = $this->_adjustment(2, $dateFrom, $dateTo, $storeActive);
				}

				$filter                 = array();
				$filter['dateFrom']     = $dateFrom;
				$filter['dateTo']       = $dateTo;
				$filter['typeDate']     = $typeDate;
				$filter['typeFilter']   = $typeFilter;
				$filter['typedetail']   = $detail_type;
				$filter['storeActive']  = $storeActive;
				$filter['storeOnly']    = $storeOnly;
				$filter['typeItemSold'] = $typeItemSold;
				$filter['dataShifts']   = $dataShifts;

				$this->template->content->set(array(
					'listStore'      => !empty($listStore)?$listStore:'',
					'dataOrder'      => !empty($dataOrder)?$dataOrder:'',
					'dataAdjustment' => !empty($dataAdjustment)?$dataAdjustment:'',
					'dataFilter'     => $filter,
					'type'           => $detail_type
				));
			}else{
				$this->template->content = new View('reconciliation/Store/index');
				$this->template->jsKiosk = new View('reconciliation/Store/jsIndex');
				if($detail_type == 'purchases'){
					/* API listStoreOrder */
					$this->db->select('product.file_id,sub_category.sub_category_name,product.pro_name,product.pro_no,store_order.store_price,store_order.store_order_id,store_order.mark_complete,store_order.date_mark_complete,store_order.store_unit,product.pro_unit,store_order.store_regidate,store_order.store_order_from, store_order.lot');
					$this->db->in('store_order.mark_complete', array('0'));
					$this->db->where('store_order.admin_id', $this->sess_cus['admin_refer_id']);
					$this->db->where('store_order.date_mark_complete BETWEEN \''.date('Y-m-d H:i:s', strtotime($dateFrom)).'\' AND \''.date('Y-m-d H:i:s', strtotime($dateTo)).'\'');
					$this->db->where('store_order.store_id', $storeActive);
					$this->db->join('product', array('product.pro_id' => 'store_order.product_id'),'','');
					$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','');
					$this->db->orderby('sub_category.sub_category_name', 'ASC');
					$dataOrder = $this->db->get('store_order')->result_array(false);

					$dataAdjustment = $this->_adjustment(3, $dateFrom, $dateTo, $storeActive);
				}else{
					$detail_type = 'item_sold';
					$dataOrder = array();
					if($typeItemSold == '1'){
						/* API listSubMenuOrder */
						$this->db->select('sub_category.sub_category_name as name, sum(order_detail.price) as total');
						$this->db->where('order.store_id', $storeActive);
						$this->db->where('order.regidate BETWEEN \''.date('Y-m-d H:i:s', strtotime($dateFrom)).'\' AND \''.date('Y-m-d H:i:s', strtotime($dateTo)).'\'');
						$this->db->where('order.order_num IS NOT NULL');
						$this->db->join('order_detail', array('order_detail.order_id' => 'order.order_id'));
						$this->db->join('menu', array('menu.menu_id' => 'order_detail.menu_id'));
						$this->db->join('sub_category', array('sub_category.sub_category_id' => 'menu.sub_category_id'));
						$this->db->groupby('sub_category.sub_category_id');
						//$this->db->orderby('order.regidate', 'asc');
						$Details = $this->db->get('order')->result_array(false);

						/* API listSubMenuOptionOrder */
						$this->db->select('sub_category.sub_category_name as name, sum(order_option.price) as total');
						$this->db->where('order.store_id', $storeActive);
						$this->db->where('order.regidate BETWEEN \''.date('Y-m-d H:i:s', strtotime($dateFrom)).'\' AND \''.date('Y-m-d H:i:s', strtotime($dateTo)).'\'');
						$this->db->where('order.order_num IS NOT NULL');
						$this->db->join('order_option', array('order_option.order_id' => 'order.order_id'));
						$this->db->join('menu', array('menu.menu_id' => 'order_option.menu_id'));
						$this->db->join('sub_category', array('sub_category.sub_category_id' => 'menu.sub_category_id'));
						$this->db->groupby('sub_category.sub_category_id');
						//$this->db->orderby('order.regidate', 'asc');
						$optionDetails = $this->db->get('order')->result_array(false);
					}else{
						/* API listMenuOrder */
						$this->db->select('order_detail.menu_name as name, order_detail.menu_id, sum(order_detail.price) as total');
						$this->db->where('order.store_id', $storeActive);
						$this->db->where('order.regidate BETWEEN \''.date('Y-m-d H:i:s', strtotime($dateFrom)).'\' AND \''.date('Y-m-d H:i:s', strtotime($dateTo)).'\'');
						$this->db->where('order.order_num IS NOT NULL');
						$this->db->join('order_detail', array('order_detail.order_id' => 'order.order_id'));
						$this->db->groupby('order_detail.menu_id');
						$this->db->groupby('order_detail.menu_name');
						//$this->db->orderby('order.regidate', 'asc');
						$Details = $this->db->get('order')->result_array(false);
						/* API listMenuOptionOrder */
						$this->db->select('order_option.menu_name as name, order_option.menu_id, sum(order_option.price) as total');
						$this->db->where('order.store_id', $storeActive);
						$this->db->where('order.regidate BETWEEN \''.date('Y-m-d H:i:s', strtotime($dateFrom)).'\' AND \''.date('Y-m-d H:i:s', strtotime($dateTo)).'\'');
						$this->db->where('order.order_num IS NOT NULL');
						$this->db->join('order_option', array('order_option.order_id' => 'order.order_id'));
						$this->db->groupby('order_option.menu_id');
						$this->db->groupby('order_option.menu_name');
						//$this->db->orderby('order.regidate', 'asc');
						$optionDetails = $this->db->get('order')->result_array(false);
					}

					if(!empty($Details)){
						foreach ($Details as $vtDetail => $itemDetail) {
							$dataOrder[trim($itemDetail['name'])] = (!empty($dataOrder[$itemDetail['name']])?$dataOrder[$itemDetail['name']]:0) + $itemDetail['total'];
						}
						
					}

					if(!empty($optionDetails)){
						foreach ($optionDetails as $vtOption => $itemOption) {
							$dataOrder[trim($itemOption['name'])] = (!empty($dataOrder[$itemOption['name']])?$dataOrder[$itemOption['name']]:0) + $itemOption['total'];
						}
						
					}

					$dataAdjustment = $this->_adjustment(4, $dateFrom, $dateTo, $storeActive);
				}

				$filter                 = array();
				$filter['dateFrom']     = $dateFrom;
				$filter['dateTo']       = $dateTo;
				$filter['typeDate']     = $typeDate;
				$filter['typeFilter']   = $typeFilter;
				$filter['typedetail']   = $detail_type;
				$filter['storeActive']  = $storeActive;
				$filter['storeOnly']    = $storeOnly;
				$filter['typeItemSold'] = $typeItemSold;
				$filter['dataShifts']   = $dataShifts;
				$this->template->content->set(array(
					'listStore'      => !empty($listStore)?$listStore:'',
					'dataOrder'      => !empty($dataOrder)?$dataOrder:'',
					'dataAdjustment' => !empty($dataAdjustment)?$dataAdjustment:'',
					'dataFilter'     => $filter,
					'type'           => $detail_type
				));
			}
		}
	}

	public function saveShifts(){
		$data    = $this->input->post();
		$arrData = array(
			$data['txt_item_name'][0] => $data['txt_time_from'][0].'|'.$data['txt_time_to'][0],
			$data['txt_item_name'][1] => $data['txt_time_from'][1].'|'.$data['txt_time_to'][1],
			$data['txt_item_name'][2] => $data['txt_time_from'][2].'|'.$data['txt_time_to'][2]
		);

		if(!empty($data['txt_hd_id'])){
			$this->db->where('opd_id', $data['txt_hd_id']);
			$result = $this->db->update('option_default', array('opd_value' => json_encode($arrData)));
		}else{
			$arr = array(
				'opd_id'    => $this->getGUID(),
				'admin_id'  => $this->sess_cus['admin_id'],
				'opd_type'  => 2,
				'opd_name'  => 'acc_shifts',
				'opd_value' => json_encode($arrData)
			);
			$result = $this->db->insert('option_default', $arr);
		}
		url::redirect('accounting/reconciliations');
		die();
	}

	public function setShifts(){
		$adminId  = $this->sess_cus['admin_id'];
		$shiftId  = '';
		$template = new View('reconciliation/frmEditShifts');
		$title    = 'Edit Shifts';

		$this->db->where('admin_id', $adminId);
		$this->db->where('opd_type', 2);
		$this->db->where('opd_name','acc_shifts');
		$data = $this->db->get('option_default')->result_array(false);
		if(!empty($data)){
			$shiftId = $data[0]['opd_id'];
			$data    = json_decode($data[0]['opd_value'], true);
		}else{
			$data = array(
				'Breakfast' => '9:00|11:00',
				'Lunch'     => '11:01|14:00',
				'Dinner'    => '17:00|22:00'
			);
		}
		$template->set(array(
			'title'      => $title,
			'dataShifts' => $data,
			'shiftId'    => $shiftId
		));
		$template->render(true);
		die();
	}

	private function _adjustment($type='2', $dateFrom, $dateTo, $storeActive){
		if(!empty($storeActive) && $storeActive != 'warehouse')
			$this->db->where('store_id', $storeActive);
		$this->db->where('type', $type);
		$this->db->where('regidate BETWEEN \''.date('Y-m-d H:i:s', strtotime($dateFrom)).'\' AND \''.date('Y-m-d H:i:s', strtotime($dateTo)).'\'');
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$dataAdjustment = $this->db->get('adjustment')->result_array(false);
		return $dataAdjustment;
	}

	public function DateFilter(){
		$day = $this->input->post('day');
		$date_end = date('m/d/Y');
		if($day == 'today'){
			$date_to = date("m/d/Y");
		}elseif($day == '7day'){
			$date_to = date("m/d/Y", strtotime("-7 days"));
		}else{
			$date_to = date("m/d/Y", strtotime("-30 days"));
		}
		echo json_encode(array('date_end'  => $date_end,'date_to'   => $date_to));
		die();
	}

	public function addAdjustment(){
		$template = new View('reconciliation/frmAdjustment');
		$title    = 'Add Adjustment';
		$dataType = $this->input->post('dataType');
		$template->set(array(
			'title'    => $title,
			'dataType' => !empty($dataType)?$dataType:'distribution'
		));
		$template->render(true);
		die();
	}

	public function saveAdjustment(){
		$data     = $this->input->post();
		$type     = 2;
		$store_id = '';
		switch ($data['txt_data_type']) {
			case 'warehouse':
				$type = 1;
				break;
			case 'distribution':
				$type = 2;
				break;
			case 'store':
				$type = 3;
				break;
			case 'itemsold':
				$type = 4;
				break;
			default:
				$type = 2;
				break;
		}
		if(!empty($data['txt_data_using']) && $data['txt_data_using'] != 'warehouse')
			$store_id = $data['txt_data_using'];

		$dataAdjustment = array(
			'id'       => $this->getGUID(),
			'num'      => $data['txt_item_num'],
			'amount'   => !empty($data['txt_item_amount'])?number_format((float)$data['txt_item_amount'], 2, '.', ''):0.00,
			'note'     => $data['txt_item_note'],
			'regidate' => !empty($data['txt_item_note'])?date('Y-m-d H:i:s', strtotime($data['txt_item_date'])):date('Y-m-d H:i:s'),
			'store_id' => $store_id,
			'admin_id' => $this->sess_cus['admin_refer_id'],
			'type'     => $type
		);

		try {
			$result = $this->db->insert('adjustment', $dataAdjustment);
			echo json_encode(array(
				'result' => true,
				'msg'    => 'Changes saved.'
			));
			die();
		} catch (Exception $e) {}
		echo json_encode(array(
			'result' => false,
			'msg'    => 'Could not complete request.'
		));
		die();
	}
}
?>