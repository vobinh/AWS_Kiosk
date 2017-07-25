<?php
class Catalogs_Controller extends Template_Controller {
	
	public $template;

	public function __construct(){

        parent::__construct();
       	$this->template = new View('templates/'.$this->site['config']['TEMPLATE'].'/index');
		$this->_get_session_template();
		if(empty($this->sess_cus['admin_id']) || $this->sess_cus['step'] != 3){
			if($this->uri->segment(2) != 'sendImg'){
				if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){    
					header('HTTP/1.1 302 Found', true, 302);
					die();
				}else
					url::redirect('login');
			}
		}
		$this->stage_model = new Stage_Model();
		$this->store_model = new Store_Model();

		$this->_getContOrder();
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

	private function _getContOrder(){
    	$this->db->select('count(store_order_id) as total');
    	$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->in('mark_complete', array(1,2));
		$totalOrder            = $this->db->get('store_order')->result_array(false);
		$this->countStoreOrder = !empty($totalOrder)?$totalOrder[0]['total']:0;
    }

	/*****************************# Stage #************************************/
	public function stage(){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['settings_stage'], 0, 1) == '0')){
			$this->template->content = new View('m_stage/index');
		}else{
			$this->template->content = new View('m_stage/index');
			$this->template->jsKiosk = new View('m_stage/jsIndex');

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
			$this->template->content->set(array(
				'listStore' => !empty($listStore)?$listStore:''
			));
		}
	}

	public function getGenerate(){
		$idStore  = base64_decode($this->sess_cus['storeId']);
		$generate = substr(number_format(time() * rand(),0,'',''),0,15);
		$this->db->select('count(menu_id) as total');
		$this->db->where('store_id', $idStore);
		$this->db->where('barcode', $generate);
		$result = $this->db->get('menu')->result_array(false);
		if(!empty($result) && $result[0]['total'] > 0)
			$this->getGenerate();
		echo json_encode($generate);
		die();
	}

	public function exportStage(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportPickUpStations_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w"); 
		fputcsv($output, array(
			'Store',
			'Pick Up Stations',
			'Added Date',
			'Update Date',
			'Status'
		));

		$idStore = base64_decode($this->sess_cus['storeId']);
		if((string)$idStore == '0'){
			$idStore = $this->_getStoreUsing();
			
		}
		
		$store_id   = base64_decode($this->sess_cus['storeId']);
		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';

		$this->db->select('stage.name, stage.created_date, stage.updated_date, stage.status, store.store');
		$this->db->in('stage.id', $idSelected);
		$this->db->join('store', array('store.store_id' => 'stage.store_id'),'','left');
		$this->db->orderby('store.store_id', 'asc');
		$this->db->orderby('stage.name', 'asc');
		$result = $this->stage_model->getStore($idStore)->result_array(false);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$item   = array();
				$item[] = $value['store'];
				$item[] = $value['name'];
				$item[] = date_format(date_create($value['created_date']), 'm/d/Y');
				$item[] = date_format(date_create($value['updated_date']), 'm/d/Y');
				$item[] = $value['status'];
				fputcsv($output, $item);
			}
			fclose($output);
		}
		die();
	}

	public function getDataStage(){
		$idStore        = base64_decode($this->sess_cus['storeId']);
		$_data          = array();
		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		$iDisplayLength = (int)$_POST['length'];
		$iDisplayStart  = (int)$_POST['start'];
		$total_items    = 0;
		$total_filter   = 0;
		$sEcho          = (int)($_POST['draw']);

		/*if($idStore == 0){
			$this->db->select('store_id');
			$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
			$this->db->where('status', 1);
			$idStore = $this->store_model->get($idStore);
			
			$idStore = array_column($idStore,'store_id');
		}*/

		if((string)$idStore == '0'){
			$idStore = $this->input->post('store_id');
			$this->_setStoreUsing($idStore);
		}

		$this->db->join('store', array('store.store_id' => 'stage.store_id'),'','left');
		$total_items    = $this->stage_model->getStore($idStore)->count();
		$total_filter   = $total_items;

		if(!empty($idStore)){
			if(!empty($iSearch)){
				$iSearch    = $this->db->escape(trim($iSearch));
				$iSearch    = substr($iSearch, 1, (strlen($iSearch)-2));
				$arr        = explode(' ',trim($iSearch));
				$dem        = count($arr);
				$sql_search = '';
				if($dem > 1){
					$sql_search = "(CONCAT_WS(' ',stage.name, store.s_first, store.s_last, store.store, stage.status) LIKE '%".$arr[0]."%'";
					for ($i=1; $i < ($dem-1) ; $i++) { 
						$sql_search .= "AND CONCAT_WS(' ',stage.name, store.s_first, store.s_last, store.store, stage.status) LIKE '%" .$arr[$i]. "%'";
					}
					$sql_search .= " AND CONCAT_WS(' ', stage.name, store.s_first, store.s_last, store.store, stage.status) LIKE '%" .$arr[$dem-1]. "%')";
				}else{
					$sql_search = "CONCAT_WS(' ', stage.name, store.s_first, store.s_last, store.store, stage.status) LIKE '%" .trim($iSearch). "%'";
				}
				$this->db->select('stage.*, store.s_first,store.s_last');
				$this->db->where('store.status', 1);
				$this->db->where($sql_search);
				$this->db->join('store', array('store.store_id' => 'stage.store_id'),'','left');
				$this->db->orderby('store.store_id', 'asc');
				$this->db->orderby('stage.name', 'asc');
				$total_filter = $this->stage_model->getStore($idStore)->count();

				$this->db->where($sql_search);
			}

			$this->db->select('stage.*, store.s_first,store.s_last, store.store');
			$this->db->join('store', array('store.store_id' => 'stage.store_id'),'','left');
			$this->db->orderby('store.store_id', 'asc');
			$this->db->orderby('stage.name', 'asc');
			$result = $this->stage_model->getStore($idStore)->result_array(false);
			if(!empty($result)){
				foreach ($result as $key => $value) {
					$_data[] = array(
						'tdID'         => $value['id'],
						'tdStore'      => $value['store'],
						'tdName'       => $value['name'],
						'tdDate'       => date_format(date_create($value['created_date']), 'm/d/Y'),
						'tdDateUpdate' => date_format(date_create($value['updated_date']), 'm/d/Y'),
						'tdStatus'     => $value['status'],
						'tdIcon'       => $value['file_id'],
						'DT_RowId'     => $value['id'],
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

	public function getEditStage(){
		$template = new View('m_stage/frmStage');
		$title    = 'Edit Pick Up Stations';
		$idEdit   = $this->input->post('id');
		$idStore  = base64_decode($this->sess_cus['storeId']);
		
		/*$this->db->select('store_id, s_first, s_last, store');
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('status', 1);
		$store  = $this->store_model->get($idStore);*/

		$stage = $this->stage_model->get($idEdit);

		$template->set(array(
			'title'   => $title,
			'idStore' => $idStore,
			'data'    => !empty($stage)?$stage[0]:''
		));
		$template->render(true);
		die();
	}

	public function getAddStage(){
		$template = new View('m_stage/frmStage');
		$title    = 'Add Pick Up Stations';
		$idStore  = base64_decode($this->sess_cus['storeId']);
		
		/*$this->db->select('store_id, s_first, s_last, store');
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('status', 1);
		$store  = $this->store_model->get($idStore);*/

		$template->set(array(
			'title'   => $title,
			'idStore' => $idStore
		));
		$template->render(true);
		die();
	}

	private function _checkStage($idStore, $name){
		$keyword = strtolower($name);
        $this->db->where("LCASE(name) LIKE '%" .$keyword. "%'");
        $result = $this->stage_model->getStore($idStore)->count();
        return $result;
	}

	private function _saveStage($data){
		$arrData = array();
		$total   = 0;
		if(!empty($data['txt_category'])){
			foreach ($data['txt_category'] as $key => $value) {
				$arrData[$value]['item'][] = $data['txt_name'][$key];
			}
		}
		if(!empty($arrData)){
			foreach ($arrData as $key => $value) {
				$arrName = $value['item'];
				$arrName = array_unique($arrName);
				if(!empty($arrName)){
					foreach ($arrName as $vt => $item) {
						$check = $this->_checkStage($key, $item);
						if($check <= 0){
							$date = date('Y-m-d H:i:s');
							$arrInput = array(
								'id'           => $this->getGUID(),
								'store_id'     => $key,
								'name'         => $item,
								'created_date' => $date,
								'updated_date' => $date,
								'file_id'      => $data['uploadfilehd'],
								'status'       => 'OPEN'
							);
							try {
								$stage = $this->stage_model->save($arrInput)->count();
								if($stage > 0)
									$total++; 
							} catch (Exception $e) {
								
							}
						}
					}
				}
			}
		}
		if($total > 0)
			$this->session->set_flash('success_msg', 'Changes saved '.$total.' items.');
		else
			$this->session->set_flash('error_msg', 'Changes saved '.$total.' items.');
		url::redirect('catalogs/stage');
		die();
	}

	private function _updateStage($data){
		$result = $this->stage_model->get($data['txt_hd_id']);
		if(!empty($result)){
			if($result[0]['name'] != $data['txt_name'][0]){
				$this->db->notin('id',  array($result[0]['id']));
				$check = $this->_checkStage($data['txt_category'][0], $data['txt_name'][0]);
				if($check > 0){
					$this->session->set_flash('error_msg', 'Item name exists.');
					url::redirect('catalogs/stage');
					die();
				}
			}
			$arrInput = array(
				'name'         => $data['txt_name'][0],
				'updated_date' => date('Y-m-d H:i:s'),
				'file_id'      => $data['uploadfilehd']
			);
			try {
				$this->db->where('id', $result[0]['id']);
				$this->stage_model->update($arrInput);
				$this->session->set_flash('success_msg', 'Changes saved.');
				url::redirect('catalogs/stage');
				die();
			} catch (Exception $e) {}
		}
		$this->session->set_flash('error_msg', 'Item not exists.');
		url::redirect('catalogs/stage');
		die();
	}

	public function saveStage(){
		$data = $this->input->post();
		if(!empty($data['txt_hd_id'])){
			$this->_updateStage($data);
		}else{
			$this->_saveStage($data);
		}
		echo kohana::Debug($data);
		die();
		
	}

	public function checkName(){
		$id   = $this->input->post('id');
		$name = $this->input->post('name');
		$store = $this->input->post('store');

		$this->db->notin('id', array($id));
		$check = $this->_checkStage($store, $name);
		if($check > 0){
			echo json_encode(array('msg' => false));
			die();
		}
		echo json_encode(array('msg' => true));
		die();
	}

	public function setStatusStage(){
		$id     = $this->input->post('id');
		$status = $this->input->post('action');
		$total  = 0;
		if(!empty($id)){
			if(is_array($id)){
				$this->db->in('id', $id);
			}else{
				$this->db->where('id', $id);
			}
			$result = $this->stage_model->update(array('status' => $status));
			$total  = $result->count();
			echo json_encode(array('msg' => true, 'total' => $total));
		}else{
			echo json_encode(array('msg' => false, 'total' => $total));
		}
		die();
	}
	/***************************# END Stage #**********************************/

	public function index(){
		$this->catalog();
	}

	// Inventory
	public function inventory(){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['operations_inventory'], 0, 1) == '0')){
			$this->template->content = new View('m_inventory/inventory');
		}else{
			$this->template->content = new View('m_inventory/inventory');
			$this->template->jsKiosk = new View('m_inventory/jsInventory');

			$this->db->where('sub_category.admin_id', $this->sess_cus['admin_refer_id']);
			$this->db->where('sub_category.category_id', $this->idInventory);
			$this->db->orderby('sub_category.sub_category_name');
			$result = $this->db->get('sub_category')->result_array(false);

			$this->template->content->set(array(
				'dataCategory' => $result
			));
		}
	}

	public function getAddInventory(){
		$template = new View('m_inventory/frmInventory');
		$title = 'Manually Add Inventory';
		$template->set(array(
			'title'     => $title
		));
		$template->render(true);
		die();
	}

	public function getEditInventory(){
		$template = new View('m_inventory/frmInventory');
		$title    = 'Edit Inventory';

		$id = $this->input->post('id');
		$arrId = explode(',', $id);
		$this->db->select('inventory.*, sub_category.sub_category_name, sub_category.category_id, product.pro_no, product.pro_unit, product.pro_cost_store, product.pro_per_store');
		$this->db->where('inventory.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('inventory.store_id', base64_decode($this->sess_cus['storeId']));
		$this->db->in('inventory.inventory_id', $arrId);
		$this->db->join('product', array('product.pro_id' => 'inventory.pro_id'),'','left');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'inventory.sub_category_id'),'','left');
		$result = $this->db->get('inventory')->result_array(false);
		$template->set(array(
			'title' => $title,
			'data'  => !empty($result)?$result:''
		));

		$template->render(true);
		die();
	}

	private function _autoDeleteInventory(){
		/* auto delete after 7days */
		$expire_day = date('Y-m-d H:i:s',strtotime(date('m/d/Y'). "-7 day"));
		$this->db->where('(i_quatity <= 0 OR (expire_day < "'.$expire_day.'" AND expire_day != "'.date('1000-01-01 00:00:00').'"))');
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('store_id', base64_decode($this->sess_cus['storeId']));
		$result = $this->db->delete('inventory');
		return $result->count();
	}

	public function deleteInventory(){
		$total = 0;
		$id    = $this->input->post('chk_inventory');
		$arrId = array();
		if(!empty($id)){
			foreach ($id as $key => $value) {
				$_temp = explode(',', $value);
				$arrId = array_merge($arrId, $_temp);
			}
			if(is_array($arrId)){
				$this->db->in('inventory_id', $arrId);
			}else{
				$this->db->where('inventory_id', $arrId);
			}
			$result = $this->db->delete('inventory');
			$total = $result->count();
			echo json_encode(array('msg' => true, 'total' => $total));
		}else{
			echo json_encode(array('msg' => false, 'total' => $total));
		}
		die();
	}

	public function exportInventory(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportInventory_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w");
		fputcsv($output, array(
			'Item Name',
			'Category',
			'SKU#',
			'Lot#',
			'Added Date',
			'Expiry Date',
			'Status',
			'Stock'
		));

		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';

		$this->db->select('inventory.inventory_id, inventory.sub_category_id, inventory.item, inventory.i_quatity, inventory.pro_id, inventory.admin_id, inventory.price, inventory.expire_day, inventory.status, inventory.file_id, inventory.regidate, inventory.lot,
				sub_category.sub_category_name, sub_category.category_id, 
				product.pro_no, product.pro_unit');
		$this->db->where('inventory.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('inventory.store_id', base64_decode($this->sess_cus['storeId']));
		$this->db->join('product', array('product.pro_id' => 'inventory.pro_id'),'','left');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'inventory.sub_category_id'),'','left');
		$this->db->in('inventory.inventory_id', $idSelected);
		$this->db->orderby('inventory.expire_day', 'asc');
		$result = $this->db->get('inventory')->result_array(false);
		
		$status = array('Expired', 'Not available', 'Expires soon', 'Low Inventory', 'Available');
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$quantity      = !empty($value['i_quatity'])?$value['i_quatity']:0;
				$expireDay     = $value['expire_day'];
				$arrExprireDay = explode(',', $expireDay);
				$addDay        = $value['regidate'];
				$arrAddDay     = explode(',', $addDay);
				if(!empty($arrExprireDay)){
					$intStatus = 0;
					$dataExp   = $arrExprireDay[0];
					$dataAdd   = $arrAddDay[0];
					foreach ($arrExprireDay as $sl => $ExprireDay) {
						$flag = false;
						if(!empty($ExprireDay) && (int)strtotime($ExprireDay) > 0){
							$date       = date_format(date_create($ExprireDay), 'm/d/Y');
							$intDate    = strtotime($date);
							$today      = strtotime(date('m/d/Y'));

							$days = (int)($intDate - $today) / (60 * 60 * 24);
							if($days < 0){
								$flag = ($intStatus < 0)?true:false;
								$intStatus = ($intStatus < 0)?0:$intStatus;//Expired
								goto setDay;
							}
						}
						if($quantity <= 0){
							$flag = ($intStatus < 1)?true:false;
							$intStatus = ($intStatus < 1)?1:$intStatus; //Not available
						}elseif($quantity <= 5){
							$flag = ($intStatus < 3)?true:false;
							$intStatus = ($intStatus < 3)?3:$intStatus; //Low Inventory
						}elseif(isset($days) && $days <= 5){
							$flag = ($intStatus < 2)?true:false;
							$intStatus = ($intStatus < 2)?2:$intStatus;//Expires soon
						}else{
							$flag = ($intStatus < 4)?true:false;
							$intStatus = ($intStatus < 4)?4:$intStatus;//Available
						}
						goto setDay;
						setDay: 
						if($flag){
							$dataExp = $ExprireDay;
							$dataAdd = $arrAddDay[$sl];
						}
					}
					if(!empty($dataExp) && (int)strtotime($dataExp) > 0){
						$dataExp    = date_format(date_create($dataExp), 'm/d/Y');
					}else{
						$dataExp    = 'No expiry set';
					}
					$dataAdd    = date_format(date_create($dataAdd), 'm/d/Y');
				}
				$item   = array();
				$item[] = $value['item'];
				$item[] = $value['sub_category_name'];
				$item[] = $value['pro_no'];
				$item[] = $value['lot'];
				$item[] = $dataAdd;
				$item[] = $dataExp;
				$item[] = $status[$intStatus];
				$item[] = $value['i_quatity'].' '.$value['pro_unit'];
				fputcsv($output, $item);
			}
			fclose($output);
		}
		die();
	}

	public function getDataInventory(){
		$type        = $this->input->post('type');
		$autoDelete  = $this->input->post('auto-delete');
		$countDelete = 0;
		if(!empty($autoDelete)){
			$countDelete = $this->_autoDeleteInventory();
		}
		if(!empty($type) && $type == 1){
			$this->db->select('GROUP_CONCAT(inventory.inventory_id) as inventory_id, inventory.sub_category_id, inventory.item, SUM(CASE WHEN (inventory.expire_day >= "'.$today = date('Y-m-d 00:00:00').'" OR inventory.expire_day = "'.date('1000-01-01 00:00:00').'") THEN inventory.i_quatity ELSE 0 END) AS i_quatity, inventory.pro_id, inventory.admin_id, inventory.price, GROUP_CONCAT(inventory.expire_day) as expire_day, inventory.status, inventory.file_id, GROUP_CONCAT(inventory.regidate) as regidate, inventory.lot,
				sub_category.sub_category_name, sub_category.category_id, 
				product.pro_no, product.pro_unit, count(product.pro_id) as sl');
			$this->db->groupby('product.pro_id');

		}else{
			$this->db->select('inventory.inventory_id, inventory.sub_category_id, inventory.item, inventory.i_quatity, inventory.pro_id, inventory.admin_id, inventory.price, inventory.expire_day, inventory.status, inventory.file_id, inventory.regidate, inventory.lot,
				sub_category.sub_category_name, sub_category.category_id, 
				product.pro_no, product.pro_unit');
		}
		$this->db->where('inventory.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('inventory.store_id', base64_decode($this->sess_cus['storeId']));
		$this->db->join('product', array('product.pro_id' => 'inventory.pro_id'),'','left');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'inventory.sub_category_id'),'','left');
		$this->db->orderby('inventory.expire_day', 'asc');
		$result = $this->db->get('inventory')->result_array(false);
		$data   = array();
		$status = array('Expired', 'Not available', 'Expires soon', 'Low Inventory', 'Available');

		if(!empty($result)){
			foreach ($result as $key => $value) {
				$quantity      = !empty($value['i_quatity'])?$value['i_quatity']:0;
				$expireDay     = $value['expire_day'];
				$arrExprireDay = explode(',', $expireDay);
				$addDay        = $value['regidate'];
				$arrAddDay     = explode(',', $addDay);
				if(!empty($arrExprireDay)){
					$intStatus = 0;
					$dataExp   = $arrExprireDay[0];
					$dataAdd   = $arrAddDay[0];
					foreach ($arrExprireDay as $sl => $ExprireDay) {
						$flag = false;
						if(!empty($ExprireDay) && (int)strtotime($ExprireDay) > 0){
							$date       = date_format(date_create($ExprireDay), 'm/d/Y');
							$intDate    = strtotime($date);
							$today      = strtotime(date('m/d/Y'));

							$days = (int)($intDate - $today) / (60 * 60 * 24);
							if($days < 0){
								$flag = ($intStatus < 0)?true:false;
								$intStatus = ($intStatus < 0)?0:$intStatus;//Expired
								goto setDay;
							}
						}
						if($quantity <= 0){
							$flag = ($intStatus < 1)?true:false;
							$intStatus = ($intStatus < 1)?1:$intStatus; //Not available
						}elseif($quantity <= 5){
							$flag = ($intStatus < 3)?true:false;
							$intStatus = ($intStatus < 3)?3:$intStatus; //Low Inventory
						}elseif(isset($days) && $days <= 5){
							$flag = ($intStatus < 2)?true:false;
							$intStatus = ($intStatus < 2)?2:$intStatus;//Expires soon
						}else{
							$flag = ($intStatus < 4)?true:false;
							$intStatus = ($intStatus < 4)?4:$intStatus;//Available
						}
						goto setDay;
						setDay: 
						if($flag){
							$dataExp = $ExprireDay;
							$dataAdd = $arrAddDay[$sl];
						}
					}
					if(!empty($dataExp) && (int)strtotime($dataExp) > 0){
						$dataExp    = date_format(date_create($dataExp), 'm/d/Y');
						$dateStrExp = 'Expires '. $dataExp;
					}else{
						$dateStrExp = 'No expiry set';
						$dataExp    = 0;
					}
					$dataAdd    = date_format(date_create($dataAdd), 'm/d/Y');
					$dateStrAdd = 'Added '.$dataAdd;
				}

				$data[] = array(
					'id'         => $value['inventory_id'],
					'category'   => $value['sub_category_name'],
					'name'       => $value['item'],
					'sku'        => 'SKU# '.$value['pro_no'],
					'lot'        => 'Lot# '.$value['lot'],
					'dateStrAdd' => $dateStrAdd,
					'dateAdd'    => $dataAdd,
					'dateStrExp' => $dateStrExp,
					'dataExp'    => $dataExp,
					'status'     => $status[$intStatus],
					'file_id'    => $value['file_id'],
					'totalStr'   => $value['i_quatity'].' '.$value['pro_unit'],
					'total'      => $value['i_quatity'],
					'sl'         => !empty($value['sl'])?(int)$value['sl']:1
				);
			}
		}
		$records                = array();
		$records["data"]        = $data;
		$records["countDelete"] = $countDelete;
		echo json_encode($records);
		die();
	}

	public function getProduct(){
		$search = $this->input->post('q');
		$select = 'SELECT product.*, sub_category.sub_category_name, sub_category.category_id, CONCAT_WS(" / ",product.pro_no, product.pro_name) as text, product.pro_id as id';
		$from   = ' FROM (product)';
		$join   = ' LEFT JOIN sub_category ON (sub_category.sub_category_id = product.sub_category_id)';
		$where  = ' WHERE product.admin_id = "'.$this->sess_cus['admin_refer_id'].'" AND product.pro_status = "1" AND (product.pro_name like "%'.$search.'%" OR product.pro_no like "%'.$search.'%")';
		$result = $this->db->query($select.$from.$join.$where)->result_array(false);
		echo json_encode($result);
		die();
	}

	public function saveInventory(){
		$data = $this->input->post('txt_hd_id');
		if(empty($data[0])){
			$this->_saveInventory();
		}else{
			$this->_editInventory();
		}
		die();
	}

	public function _saveInventory(){
		$data = $this->input->post();
		if(!empty($data['txt_product'])){
			$date = date('Y-m-d H:i:s');
			foreach ($data['txt_product'] as $key => $value) {
				$expire_day = !empty($data['txt_date'][$key])?date('Y-m-d H:i:s', strtotime($data['txt_date'][$key])):'1000-01-01 00:00:00';
				$arr = array(
					'inventory_id'    => $this->getGUID(), 
					'pro_id'          => $value, 
					'store_id'        => base64_decode($this->sess_cus['storeId']), 
					'sub_category_id' => $data['txt_sub_category'][$key], 
					'category'        => '', 
					'item'            => $data['txt_name'][$key],
					'lot'             => $data['txt_lot'][$key],
					'i_type'          => '1',
					'i_quatity'       => !empty($data['txt_qty'][$key])?$data['txt_qty'][$key]:0,
					'admin_id'        => $this->sess_cus['admin_refer_id'], 
					'price'           => !empty($data['txt_price'][$key])?$data['txt_price'][$key]:0.00, 
					'expire_day'      => $expire_day, 
					'status'          => '1', 
					'file_id'         => $data['txt_file_id'][$key], 
					'regidate'        => $date, 
				);
				try {
					$this->db->insert('inventory', $arr);

					/* save StoreOrder */
					$arrOrder = array(
						'store_order_id'     => $this->getGUID(), 
						'product_id'         => $value, 
						'store_unit'         => !empty($data['txt_qty'][$key])?$data['txt_qty'][$key]:0,
						'lot'                => $data['txt_lot'][$key],
						'store_price'        => !empty($data['txt_price'][$key])?$data['txt_price'][$key]:0.00, 
						'store_regidate'     => $date, 
						'store_status'       => 1, 
						'store_id'           => base64_decode($this->sess_cus['storeId']),
						'admin_id'           => $this->sess_cus['admin_refer_id'], 
						'store_order_from'   => 'independent_purchase', 
						'mark_complete'      => 0,
						'date_mark_complete' => $date
					);
					$this->db->insert('store_order', $arrOrder);

				} catch (Exception $e) {
					
				}
			}
		}
		$this->session->set_flash('success_msg', 'Changes saved.');
		url::redirect('catalogs/inventory');
		die();
	}

	public function _editInventory(){
		$data = $this->input->post();
		foreach ($data['txt_hd_id'] as $key => $value) {
			$this->db->where('inventory_id', $value);
			$result = $this->db->get('inventory')->result_array(false);
			if(!empty($result)){
				$expire_day = !empty($data['txt_date'][$key])?date('Y-m-d H:i:s', strtotime($data['txt_date'][$key])):'1000-01-01 00:00:00';
				$arr = array(
					'pro_id'          => $data['txt_product'][$key], 
					'store_id'        => base64_decode($this->sess_cus['storeId']), 
					'sub_category_id' => $data['txt_sub_category'][$key], 
					'category'        => '', 
					'item'            => $data['txt_name'][$key], 
					'i_type'          => '1',
					'i_quatity'       => !empty($data['txt_qty'][$key])?$data['txt_qty'][$key]:0,
					'admin_id'        => $this->sess_cus['admin_refer_id'], 
					'price'           => !empty($data['txt_price'][$key])?$data['txt_price'][$key]:0.00,
					'expire_day'      => $expire_day, 
					//'status'          => '1', 
					'file_id'         => $data['txt_file_id'][$key], 
				);
				try {
					$this->db->where('inventory_id', $value);
					$this->db->update('inventory', $arr);
					$this->session->set_flash('success_msg', 'Changes saved.');
				} catch (Exception $e) {
					$this->session->set_flash('error_msg', 'Error saved.');
				}
			}else{
				$this->session->set_flash('error_msg', 'Error saved.');
			}
		}
		url::redirect('catalogs/inventory');
		die();
	}
	// Place
	
	public function getAddOrder(){

		$template = new View('m_inventory/listPlaceOrder');
		$title = 'Place Order';

		$this->db->select('product.*, sub_category.sub_category_name, sub_category.category_id');
		$this->db->where('product.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('product.pro_status','1');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
		$this->db->orderby('sub_category.sub_category_name', 'ASC');
		$mlist_product = $this->db->get('product')->result_array(false);

		$chk_show_warhouse = true;
		if($this->sess_cus){
			if($this->sess_cus['_parent_level'] == 3)
				$chk_show_warhouse = false;
		}

		$template->set(array(
			'title'             => $title,
			'mlist_product'     => $mlist_product,
			'chk_show_warhouse' => $chk_show_warhouse
		));
		$template->render(true);
		die();
	}

	public function savePlaceOrder(){
		$data = $this->input->post();
		$_sl  = 0;
		if(!empty($data['txt_unit'])){
			$date = date('Y-m-d H:i:s');
			foreach ($data['txt_unit'] as $key => $value) {
				if(!empty($value) && is_numeric($value)){
					$lot = (string)round(microtime(true) * 1000);
					if(!empty($data['txt_order_from'][$key]) && $data['txt_order_from'][$key] == 'warehouse'){
						$mark_complete = 2; 
					}else{
						$mark_complete = 1; 
					}

					$arr = array(
						'store_order_id'   => $this->getGUID(), 
						'product_id'       => $data['txt_pro_id'][$key], 
						'store_unit'       => $value, 
						'lot'              => $lot,
						'store_price'      => !empty($data['txt_price'][$key])?$data['txt_price'][$key]:0.00, 
						'store_regidate'   => $date, 
						'store_status'     => 1, 
						'store_id'         => base64_decode($this->sess_cus['storeId']),
						'admin_id'         => $this->sess_cus['admin_refer_id'], 
						'store_order_from' => !empty($data['txt_order_from'][$key])?$data['txt_order_from'][$key]:'', 
						'mark_complete'    => $mark_complete, 
					);
					$this->db->insert('store_order', $arr);
					$_sl++;
				}
			}
		}
		if($_sl > 0){
			$this->session->set_flash('success_msg', 'Changes saved.');	
		}else{
			$this->session->set_flash('success_msg', 'Changes saved.');
		}
		url::redirect('catalogs/inventory');
		die();
	}

	// View Order

	public function viewOrder(){
		$template = new View('m_inventory/listReviewOrder');
		$title    = 'View Order';
		$template->set(array(
			'title'         => $title,
		));

		$template->render(true);
		die();
	}

	private function _autoDeleteOrder(){
		/* auto delete after 10days */
		$expire_day = date('Y-m-d H:i:s',strtotime(date('m/d/Y'). "-10 day"));
		$this->db->where('(date_mark_complete < "'.$expire_day.'" AND (date_mark_complete != "'.date('1000-01-01 00:00:00').'" OR date_mark_complete IS NOT NULL))');
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('store_id', base64_decode($this->sess_cus['storeId']));
		$result = $this->db->delete('store_order');
		return $result->count();
	}

	public function exportOrder(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportStoreOrder_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w");
		fputcsv($output, array(
			'Category',
			'Item Name',
			'SKU#',
			'Payment',
			'Qty Ordered',
			'Date Ordered',
			'Ordered From',
			'Lot #',
			'Order Status'
		));

		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';

		$this->db->select('product.file_id,sub_category.sub_category_name,product.pro_name,product.pro_no,store_order.store_price,store_order.store_order_id,store_order.mark_complete,store_order.date_mark_complete,store_order.store_unit,product.pro_unit,store_order.store_regidate,store_order.store_order_from, store_order.lot');
		$this->db->where('store_order.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->join('product', array('product.pro_id' => 'store_order.product_id'),'','');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','');
		$this->db->orderby('sub_category.sub_category_name', 'ASC');
		$this->db->in('store_order.store_order_id', $idSelected);
		$mlist_product = $this->db->get('store_order')->result_array(false);
		if(!empty($mlist_product)){
			$arr_ordered_from = array('warehouse' => 'Warehouse', 'independent_purchase' => 'Independent Purchase');
			$arr_ordered_status = array(0 => 'Complete', 1 => 'Mark as Complete', 2 => 'Waiting For a Reply', 3 => 'Warehouse Reject');
			foreach ($mlist_product as $key => $value) {
				$item   = array();
				$item[] = $value['sub_category_name'];
				$item[] = $value['pro_name'];
				$item[] = $value['pro_no'];
				$item[] = !empty($value['store_price'])?'$'.number_format($value['store_price'],2):'$'.number_format(0,2);
				$item[] = $value['store_unit'].' '.$value['pro_unit'];
				$item[] = date_format(date_create($value['store_regidate']), "m/d/Y");
				$item[] = !empty($value['store_order_from'])?$arr_ordered_from[$value['store_order_from']]:'';
				$item[] = $value['lot'];
				$item[] = !empty($value['mark_complete'])?$arr_ordered_status[(int)$value['mark_complete']]:$arr_ordered_status[0];
				fputcsv($output, $item);
			}
			fclose($output);
		}
		die();
	}

	public function jsViewOrder(){
		$hideComplete = $this->input->post('hide-complete');
		$autoDelete   = $this->input->post('auto-delete');
		$countDelete  = 0;
		if(!empty($autoDelete) && $autoDelete == 1){
			$countDelete = $this->_autoDeleteOrder();
		}
		$this->db->select('product.file_id,sub_category.sub_category_name,product.pro_name,product.pro_no,store_order.store_price,store_order.store_order_id,store_order.mark_complete,store_order.date_mark_complete,store_order.store_unit,product.pro_unit,store_order.store_regidate,store_order.store_order_from, store_order.lot');
		if(!empty($hideComplete) && $hideComplete == 1)
			$this->db->where('store_order.mark_complete <> 0');
		$this->db->where('store_order.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('store_order.store_id', $this->_getStoreUsing());
		$this->db->join('product', array('product.pro_id' => 'store_order.product_id'),'','');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','');
		$this->db->orderby('sub_category.sub_category_name', 'ASC');
		$mlist_product = $this->db->get('store_order')->result_array(false);

		$_data = array();
		$total = 0;
		if(!empty($mlist_product)){
			$arr_ordered_from = array('warehouse' => 'Warehouse', 'independent_purchase' => 'Independent Purchase');
			foreach ($mlist_product as $key => $value) {
				$total += (float)(!empty($value['store_price'])?$value['store_price']:0);
				$_data[] = array(
					"tdID"         => $value['store_order_id'],
					"tdIcon"       => $value['file_id'],
					"tdCategory"   => $value['sub_category_name'],
					"tdName"       => $value['pro_name'],
					"tdSKU"        => $value['pro_no'],
					"tdPayment"    => !empty($value['store_price'])?'$'.number_format($value['store_price'],2):'$'.number_format(0,2),
					"tdNumPayment" => !empty($value['store_price'])?$value['store_price']:0,
					"tdQty"        => $value['store_unit'].' '.$value['pro_unit'],
					"tdDate"       => date_format(date_create($value['store_regidate']), "m/d/Y"),
					"tdOrder"      => !empty($value['store_order_from'])?$arr_ordered_from[$value['store_order_from']]:'',
					"tdLot"        => $value['lot'],
					"tdComplete"   => $value['mark_complete'],
					"DT_RowId"     => $value['store_order_id'],
		    	);
			}
		}
		$records                = array();
		$records["data"]        = $_data;
		$records['total']       = number_format($total, 2,'.', '');
		$records['countDelete'] = $countDelete;
		echo json_encode($records);
		die();
	}

	public function del_store_order(){
		$id_store_order = $this->input->post('id_store_order');
		if(!is_array($id_store_order)){
			$_temp            = $id_store_order;
			$id_store_order   = array();
			$id_store_order[] = $_temp;
		}
		$this->db->in('store_order_id', $id_store_order);
		$this->db->where(array('mark_complete !=' => 1));
		$result = $this->db->delete('store_order');
		echo json_encode(array('msg' => count($result)));
		die();
	}

	public function markAsComplete(){
		$id_store_order = $this->input->post('id_store_order');
		$total          = 0;
		if(!is_array($id_store_order)){
			$_temp            = $id_store_order;
			$id_store_order   = array();
			$id_store_order[] = $_temp;
		}
		if(!empty($id_store_order)){
			foreach ($id_store_order as $key => $id_store_order) {
				$this->db->select('store_order.*, product.*, sub_category.sub_category_id, sub_category.sub_category_name');
				$this->db->where('store_order.store_order_id', $id_store_order);
				$this->db->join('product', array('product.pro_id' => 'store_order.product_id'),'','left');
				$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
				$result = $this->db->get('store_order')->result_array(false);

				if(!empty($result) && $result[0]['mark_complete'] == 1){
					$datetime = date('Y-m-d H:m:i');
					$this->db->where('store_order_id',$id_store_order);
					$update_store_order = $this->db->update('store_order',array('mark_complete' => 0, 'date_mark_complete' => $datetime));
					if($update_store_order){
						$this->_addInventory($result[0]);
						$total++;
					}
				}
			}
		}
		echo json_encode(array('msg' => $total));
		die();
	}

	private function _addInventory($data){
		$expire_day = '1000-01-01 00:00:00';
		$date       = date('Y-m-d H:i:s');
		if(!empty($data['pro_shelf_life_store']) && (int)$data['pro_shelf_life_store'] > 0){
			$expire_day = date('Y-m-d H:i:s',strtotime(date('m/d/Y'). "+".$data['pro_shelf_life_store']." day"));
		}
		$lot = (string)round(microtime(true) * 1000);
		$arr = array(
			'inventory_id'    => $this->getGUID(), 
			'pro_id'          => $data['pro_id'],
			'store_id'        => base64_decode($this->sess_cus['storeId']), 
			'sub_category_id' => $data['sub_category_id'], 
			'category'        => '', 
			'item'            => $data['pro_name'], 
			'lot'             => !empty($data['lot'])?$data['lot']:$lot,
			'i_type'          => '1',
			'i_quatity'       => !empty($data['store_unit'])?$data['store_unit']:0,
			'admin_id'        => $this->sess_cus['admin_refer_id'], 
			'price'           => !empty($data['store_price'])?$data['store_price']:0.00, 
			'expire_day'      => $expire_day, 
			'status'          => '1', 
			'file_id'         => $data['file_id'], 
			'regidate'        => $date, 
		);
		try {
			$this->db->insert('inventory', $arr);
		} catch (Exception $e) {}
	}

	// registry
	public function getAddItemRegistry(){

		$template = new View('m_inventory/Registry/frmRegistryInventory');
		$title = 'Registry New Inventory Item';

		$this->db->where('sub_category.category_id', 'aade5e56-ea11-4b5b-af93-f115d331f43e');
		$this->db->where('sub_category.admin_id', $this->sess_cus['admin_refer_id']);
		$sub_category = $this->db->get('sub_category')->result_array(false);

		$this->db->select('max(pro_no) as id');
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$product = $this->db->get('product')->result_array(false);
		if(!empty($product[0]['id'])){
			$SKU = (int)$product[0]['id'] + 1;
		}else{
			$SKU = 1000;
		}
		$template->set(array(
			'title'        => $title,
			'sub_category' => $sub_category,
			'SKU'          => $SKU,
		));
		$template->render(true);
		die();
	}

	public function getEditRegistry(){
		$template = new View('m_inventory/Registry/frmRegistryInventory');
		$title = 'Registry Edit Inventory Item';

		$this->db->where('sub_category.category_id', 'aade5e56-ea11-4b5b-af93-f115d331f43e');
		$this->db->where('sub_category.admin_id', $this->sess_cus['admin_refer_id']);
		$sub_category = $this->db->get('sub_category')->result_array(false);

		$pro_id = $this->input->post('id');
		$this->db->where('pro_id', $pro_id);
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$product = $this->db->get('product')->result_array(false);

		$template->set(array(
			'title'        => $title,
			'data'         => !empty($product)?$product[0]:'',
			'sub_category' => $sub_category
		));
		$template->render(true);
		die();
	}

	public function saveRegistry(){
		$idCategory = $this->input->post('txt_hd_id');
		if(!empty($idCategory)){
			$this->_editRegistry();
		}else{
			$this->_saveRegistry();
		}
	}

	private function _saveRegistry(){
		$data = $this->input->post();
		$arr = array(
			'pro_id'                   => $this->getGUID(), 
			'sub_category_id'          => $data['txt_sub_category'], 
			'pro_name'                 => $data['txt_item_name'], 
			'pro_no'                   => $data['txt_sku'], 
			'pro_note'                 => $data['txt_note'], 
			'pro_unit'                 => !empty($data['txt_unit'])?$data['txt_unit']:'Units',
			'pro_cost_store'           => !empty($data['txt_store_cost'])?$data['txt_store_cost']:0, 
			'pro_cost_warehouse'       => !empty($data['txt_warehouse_cost'])?$data['txt_warehouse_cost']:0, 
			'pro_per_store'            => !empty($data['txt_store_per'])?$data['txt_store_per']:0, 
			'pro_per_warehouse'        => !empty($data['txt_warehouse_per'])?$data['txt_warehouse_per']:0, 
			'pro_shelf_life_store'     => !empty($data['txt_store_day'])?$data['txt_store_day']:0, 
			'pro_shelf_life_warehouse' => !empty($data['txt_warehouse_day'])?$data['txt_warehouse_day']:0,
			'file_id'                  => $data['uploadfilehd'], 
			'pro_regidate'             => date('Y-m-d H:i:s'), 
			'pro_status'               => 1, 
			'admin_id'                 => $this->sess_cus['admin_refer_id'], 
		);
		$this->db->insert('product', $arr);
		url::redirect('catalogs/inventory');
		die();
	}

	private function _editRegistry(){
		$data = $this->input->post();
		$this->db->where('pro_id', $data['txt_hd_id']);
		$product = $this->db->get('product')->result_array(false);
		if(!empty($product)){
			$arr = array(
				'sub_category_id'          => $data['txt_sub_category'], 
				'pro_name'                 => $data['txt_item_name'], 
				'pro_no'                   => $data['txt_sku'], 
				'pro_note'                 => $data['txt_note'], 
				'pro_unit'                 => !empty($data['txt_unit'])?$data['txt_unit']:'Units',
				'pro_cost_store'           => !empty($data['txt_store_cost'])?$data['txt_store_cost']:0, 
				'pro_cost_warehouse'       => !empty($data['txt_warehouse_cost'])?$data['txt_warehouse_cost']:0, 
				'pro_per_store'            => !empty($data['txt_store_per'])?$data['txt_store_per']:0, 
				'pro_per_warehouse'        => !empty($data['txt_warehouse_per'])?$data['txt_warehouse_per']:0, 
				'pro_shelf_life_store'     => !empty($data['txt_store_day'])?$data['txt_store_day']:0, 
				'pro_shelf_life_warehouse' => !empty($data['txt_warehouse_day'])?$data['txt_warehouse_day']:0,
				'file_id'                  => $data['uploadfilehd'],
				'admin_id'                 => $this->sess_cus['admin_refer_id'], 
			);
			try {
				$this->db->where('pro_id', $data['txt_hd_id']);
				$this->db->update('product', $arr);
				/* update name warehouse and inventory */
				$this->db->where('pro_id', $data['txt_hd_id']);
				$this->db->update('warehouse', array(
					'item'            => $data['txt_item_name'],
					'sub_category_id' => $data['txt_sub_category'],
					'file_id'         => $data['uploadfilehd']
				));

				$this->db->where('pro_id', $data['txt_hd_id']);
				$this->db->update('inventory', array(
					'item'            => $data['txt_item_name'],
					'sub_category_id' => $data['txt_sub_category'],
					'file_id'         => $data['uploadfilehd']
				));

				$this->session->set_flash('success_msg', 'Changes saved.');
			} catch (Exception $e) {
				$this->session->set_flash('error_msg', 'Error Save.');
			}
			
		}else{
			$this->session->set_flash('error_msg', 'Error Save.');
			url::redirect('catalogs/inventory');
			die();
		}
		url::redirect('catalogs/inventory');
		die();
	}

	// end Inventory

	//********************* Category *********************************
	public function getFrmUpload(){
		$template = new View('m_category/frmUpload');
		$title = 'Crop Image.';
		$template->render(true);
		die();
	}

	public function sendDataImg(){
		echo kohana::Debug($_POST);
		die();
	}

	public function sendImg(){
		if (function_exists('curl_file_create')) { // php 5.5+
		  	$cFile = curl_file_create($_FILES['uploadfile']['tmp_name']);
		} else { // 
		  	$cFile = '@' . realpath($_FILES['uploadfile']['tmp_name']);
		}
		$param = array(
			'store_id'   => $this->input->post('store_id'),
			'uploadfile' => $cFile
		);

		$data = $this->kioskAPI->sendImg($param);

		echo $data;
		die();
	}

	public function category(){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['operations_category'], 0, 1) == '0')){
			$this->template->content = new View('m_category/category');
		}else{
			$this->template->content = new View('m_category/category');
			$this->template->jsKiosk = new View('m_category/jsCategory');
			$listCategory = $this->db->get('category')->result_array(false);
			$this->template->content->set(
				array(
					'listCategory' => $listCategory,
			));
		}
	}

	public function getAddCategory(){
		$template = new View('m_category/frmCategory');
		$listCategory = $this->db->get('category')->result_array(false);
		$title = 'Add Category';
		$template->set(array(
			'title'        => $title,
			'listCategory' => $listCategory
		));
		$template->render(true);
		die();
	}

	public function getEditCategory(){
		$template = new View('m_category/frmCategory');
		$id       = $this->input->post('id');
		$title    = 'Edit Category';

		$listCategory = $this->db->get('category')->result_array(false);

		$this->db->where('sub_category_id', $id);
		$dataSubCategory = $this->db->get('sub_category')->result_array(false);

		$data = !empty($dataSubCategory)?$dataSubCategory[0]:'';
		$template->set(array(
			'title'        => $title,
			'data'         => $data,
			'listCategory' => $listCategory
		));

		$template->render(true);
		die();
	}

	public function saveCategory(){
		$idCategory = $this->input->post('txt_hd_id');
		if(!empty($idCategory)){
			$this->_editCategory();
		}else{
			$this->_saveCategory();
		}	
		die();
	}

	private function _saveCategory(){

		$data     = $this->input->post();
		$store_id = base64_decode($this->sess_cus['storeId']);
		$admin_id = $this->sess_cus['admin_refer_id'];

		if(!empty($data['txt_name'])){

			foreach ($data['txt_name'] as $key => $valSubName) {
				$newSubId = $this->getGUID();
				$this->db->where('category_id',$data['txt_category'][$key]);
				$_category = $this->db->get('category')->result_array(false);
				if(!empty($_category) && ($_category[0]['category_id'] == $this->idMenu || $_category[0]['category_id'] == $this->idOptions)){
					$_dataInSub = array(
						'sub_category_id'   => $newSubId, 
						'category_id'       => $data['txt_category'][$key], 
						'sub_category_name' => $valSubName, 
						'store_id'          => $store_id, 
						'admin_id'          => $admin_id,
						'file_id'           => $data['uploadfilehd'],
						'regidate'          => date('Y-m-d H:m:i'),
						'sortorder'         => $data['txt_sortorder'][$key]
					);
				}else{
					$_dataInSub = array(
						'sub_category_id'   => $newSubId, 
						'category_id'       => $data['txt_category'][$key], 
						'sub_category_name' => $valSubName,
						'admin_id'          => $admin_id,
						'file_id'           => $data['uploadfilehd'],
						'regidate'          => date('Y-m-d H:m:i'),
						'sortorder'         => $data['txt_sortorder'][$key]
					);
				}
				$this->db->insert('sub_category', $_dataInSub);
			}

			$this->session->set_flash('success_msg', 'Changes saved.');
		}
		url::redirect('/catalogs/category');
	}

	private function _editCategory(){
		$data = $this->input->post();
		$dataSubCategory = array(
			'category_id'       => $data['txt_category'][0],
			'sub_category_name' => $data['txt_name'][0],
			'file_id'           => $data['uploadfilehd'],
			'sortorder'         => $data['txt_sortorder'][0]
		);
		$this->db->where('sub_category_id', $data['txt_hd_id']);
		$result = $this->db->update('sub_category',$dataSubCategory);
		$this->session->set_flash('success_msg', 'Changes saved.');
		url::redirect('/catalogs/category');
	}
	// End Category
	
	public function frm_standard_item(){
		$template = new View('m_menu/frm_standard_item');
		
		$store_id = base64_decode($this->sess_cus['storeId']);
		$this->db->where('store_id', $store_id);
		$this->db->where('category_id', $this->idMenu);
		$menuItem = $this->db->get('sub_category')->result_array(false);

		$this->db->where('status','OPEN');
		$listStage = $this->stage_model->getStore($store_id)->result_array(false);

		$template->set(
			array(
				'sub_category' => $menuItem,
				'listStage'    => $listStage
			)
		);
		$template->render(true);
		die();
	}

	public function frm_add_options(){
		$template = new View('m_menu/frm_add_options');
		
		$store_id = base64_decode($this->sess_cus['storeId']);
		$this->db->where('store_id', $store_id);
		$this->db->where('category_id', $this->idOptions);
		$menuItem = $this->db->get('sub_category')->result_array(false);

		$template->set(array(
			'sub_category' => $menuItem,
			'title'        => 'Add New Menu Options',
		));
		$template->render(true);
		die();
	}

	public function frm_combo_set(){
		$template = new View('m_menu/frm_combo_set');
		
		$store_id = base64_decode($this->sess_cus['storeId']);
		$this->db->where('store_id', $store_id);
		$this->db->where('category_id', $this->idMenu);
		$menuItem = $this->db->get('sub_category')->result_array(false);

		$this->db->where('status','OPEN');
		$listStage = $this->stage_model->getStore($store_id)->result_array(false);
		$template->set(
			array(
				'sub_category' => $menuItem,
				'listStage'    => $listStage
			)
		);
		$template->render(true);
		die();
	}

	public function catalog(){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['operations_menu'], 0, 1) == '0')){
			$this->template->content = new View('m_menu/catalog');
		}else{
			$this->template->content = new View('m_menu/catalog');
			$this->template->jsKiosk = new View('m_menu/jsCatalog');
		}
	}

	public function exportCategory(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportCategory_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w");
		fputcsv($output, array(
			'Category',
			'Item Name',
			'Added Date',
			'Stock'
		));

		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';

		$strSql   = "SELECT sub_category.sub_category_name, sub_category.regidate, category.catalog_name, 
		CASE sub_category.category_id 
		WHEN '".$this->idMenu."' THEN (SELECT count(menu.menu_id) FROM menu WHERE menu.store_id = sub_category.store_id AND menu.sub_category_id = sub_category.sub_category_id) 
		WHEN '".$this->idOptions."' THEN (SELECT count(menu.menu_id) FROM menu WHERE menu.store_id = sub_category.store_id AND menu.sub_category_id = sub_category.sub_category_id) 
		ELSE (SELECT count(inventory.inventory_id) FROM inventory WHERE inventory.admin_id = '".$this->sess_cus['admin_refer_id']."' AND inventory.sub_category_id = sub_category.sub_category_id) END AS total ";
		$strSql .= "FROM sub_category ";
		$strSql .= "LEFT JOIN category ON category.category_id = sub_category.category_id ";
		$strSql .= "WHERE sub_category.sub_category_id IN(".$idSelected.") AND sub_category.admin_id = '".$this->sess_cus['admin_refer_id']."' ";
		$strSql .= "ORDER BY category.catalog_name ASC, sub_category.sortorder ASC, sub_category.sub_category_name ASC";
		
		$result = $this->db->query($strSql)->result_array(false);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$item   = array();
				$item[] = $value['catalog_name'];
				$item[] = $value['sub_category_name'];
				$item[] = date_format(date_create($value['regidate']), 'm/d/Y');
				$item[] = $value['total'].' Items';
				fputcsv($output, $item);
			}
			fclose($output);
		}
		die();
	}

	public function getDataCategory(){
		$admin_refer_id        = $this->sess_cus['admin_refer_id'];
		$data                  = array();
		$store_id              = base64_decode($this->sess_cus['storeId']);
		$filter                = $this->input->post('category_type');

		if(!empty($filter) && $filter != 'all'){
			$this->db->where('category_id',$filter);
			$_category_filter = $this->db->get('category')->result_array(false);
			if( !empty($_category_filter) && ($_category_filter[0]['category_id'] == $this->idMenu || $_category_filter[0]['category_id'] == $this->idOptions)){
				$sql_where  = "WHERE admin_id = '".$admin_refer_id."' AND sub_category.store_id = '".$store_id."' AND sub_category.category_id = '".$filter."'";
			}else{
				$sql_where  = "WHERE admin_id = '".$admin_refer_id."' AND sub_category.store_id IS NULL";
			}
		}elseif(!empty($filter) && $filter == 'all'){
			$sql_where = "WHERE admin_id = '".$admin_refer_id."' AND (sub_category.store_id IS NULL OR sub_category.store_id = '".$store_id."')";
		}
		
		$sql_select   = "SELECT sub_category.*, category.category_id, category.catalog_name ";
		$sql_from     = "FROM sub_category ";
		$sql_join     = "LEFT JOIN category ON category.category_id = sub_category.category_id ";
		$sql_order    = " ORDER BY 	category.catalog_name ASC, sub_category.sortorder ASC, sub_category.sub_category_name ASC";
		$sql_query    = $sql_select.$sql_from.$sql_join.$sql_where.$sql_order;
		$dataCategory = $this->db->query($sql_query)->result_array(false);
		if(!empty($dataCategory)){
			foreach ($dataCategory as $key => $value) {
				if($value['category_id'] == $this->idMenu || $value['category_id'] == $this->idOptions ){
					/*inventoryItem*/
					$this->db->where('store_id', $value["store_id"]);
					$this->db->where('sub_category_id', $value["sub_category_id"]);
					$result = $this->db->get('menu')->count();
				}else{
					/*menuItem*/
					$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
					$this->db->where('sub_category_id', $value["sub_category_id"]);
					$result = $this->db->get('inventory')->count();
				}
				$color = (!empty($value['catalog_name']) && $value['category_id'] == $this->idMenu)?'cl-blue':'cl-orange';
				$data[] = array(
					'catalog_name'      => $value["catalog_name"],
					'category_id'       => $value["category_id"],
					'file_id'           => $value["file_id"],
					'store_id'          => $value["store_id"],
					'sub_category_id'   => $value["sub_category_id"],
					'sub_category_name' => $value["sub_category_name"],
					'sub_category_date' => date_format(date_create($value['regidate']), 'm/d/Y'),
					'total'             => $result,
					'color'             => $color
				);
			}
		}
		echo json_encode($data);
		die();
	}

	public function chk_category_name(){
		$admin_refer_id = $this->sess_cus['admin_refer_id'];
		$store_id       = base64_decode($this->sess_cus['storeId']);
		$arr_exist      = array();
		$flag           = true;
		if($_POST && !empty($_POST['txt_name'])){
			$hd_id = $this->input->post('txt_hd_id');
			foreach ($_POST['txt_name'] as $key => $value) {
				// check trung datatables
				$this->db->where('category_id',$_POST['txt_category'][$key]);
				$_category_chk = $this->db->get('category')->result_array(false);
				if(!empty($_category_chk) && ($_category_chk[0]['category_id'] == $this->idMenu || $_category_chk[0]['category_id'] == $this->idOptions)){
					$this->db->where('store_id',$store_id);
				}
				$sql = 'LCASE(sub_category_name) = "'.strtolower($value).'"';
				$this->db->where($sql);
				$this->db->where('admin_id',$admin_refer_id);
				$this->db->where('category_id',$_POST['txt_category'][$key]);
				if(!empty($hd_id))
					$this->db->notin('sub_category_id', array($hd_id));
				$_sub_category_name = $this->db->get('sub_category')->result_array(false);
				if(!empty($_sub_category_name)){
					$flag = false;
					break;
				}
			}

			if($flag)
				echo json_encode($_POST);	
			else
				echo json_encode(array());
			exit();		
		}
	}

	private function Calculator_cost_menu($menu_id){
		$this->db->select('product.pro_cost_store, product.pro_per_store, ingredient.*');
		$this->db->join('product', array('product.pro_id' => 'ingredient.item_id'),'','INNER');
		$this->db->where('ingredient.menu_id',$menu_id);
		$ingredient = $this->db->get('ingredient')->result_array(false);

		$tdCost     = 0;
		if(!empty($ingredient)){			
			foreach ($ingredient as $key => $value_ingredient) {
				$quantity_cost_store = !empty($value_ingredient['pro_per_store'])?$value_ingredient['pro_per_store']:0;
				$price_cost_store    = !empty($value_ingredient['pro_cost_store'])?$value_ingredient['pro_cost_store']:0;
				$ig_quantity         = !empty($value_ingredient['ig_quantity'])?$value_ingredient['ig_quantity']:0;
				$tdCost += ($ig_quantity * $price_cost_store) / $quantity_cost_store;
			}
		}
		return $tdCost;
	}

	private function Calculator_available_menu($menu_id, $store_id){
		$sql = "SELECT `ingredient`.`ingredient_id`, `inventory`.`item`, (CASE WHEN NOT ISNULL(ingredient.ig_quantity) THEN ingredient.ig_quantity ELSE 0 END) AS quantity_ingredient,SUM(CASE WHEN NOT ISNULL(inventory.i_quatity) THEN inventory.i_quatity ELSE 0 END) AS quantity_inventory, floor(SUM(CASE WHEN NOT ISNULL(inventory.i_quatity) THEN inventory.i_quatity ELSE 0 END) / cast((CASE WHEN NOT ISNULL(ingredient.ig_quantity) THEN ingredient.ig_quantity ELSE 0 END) AS DECIMAL(10,2))) AS quantity_again\n"
	    . "FROM (`ingredient`)\n"
	    . "INNER JOIN `inventory` ON (`inventory`.`pro_id` = `ingredient`.`item_id`)\n"
	    . "WHERE `ingredient`.`menu_id` = '".$menu_id."'\n"
	    . "AND `inventory`.`store_id` = '".$store_id."'\n"
	    . "AND (inventory.expire_day >= CURDATE() OR inventory.expire_day = '1000-01-01 00:00:00')\n"
	    . "GROUP BY `inventory`.`pro_id` ORDER BY  `quantity_again` ASC ";
	    $available = $this->db->query($sql)->result_array(false);
		return $available;
	}

	public function exportMenu(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportMenu_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w");
		fputcsv($output, array(
			'Category',
			'Item Name',
			'Price',
			'Cost',
			'Available',
			'Menu Item#',
			'Type',
			'Note / Description',
			'Status'
		));

		$store_id   = base64_decode($this->sess_cus['storeId']);
		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';

		$this->db->select('menu.*', 'sub_category.sub_category_name');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'menu.sub_category_id'));
		$this->db->where('sub_category.store_id', $store_id);
		$this->db->notin('menu.menu_status', 3);
		$this->db->in('menu.menu_id', $idSelected);
		$menu = $this->db->get('menu')->result_array(false);

		$arrStatus = array(
			1 => 'Active',
			2 => 'Inactive',
			3 => 'Delete'
		);

		if(!empty($menu)){
			foreach ($menu as $key => $value) {
				$this->db->where('menu_id',$value['menu_id']);
				$Table_Ingredient = $this->db->get('ingredient')->result_array(false);
				
				$available_unit   = 0;
				if($value['m_type'] == 3){
					$tdCost       = 0;
					$_flag        = true;
					$ArrAvailable = array();
					if(!empty($Table_Ingredient)){
						foreach ($Table_Ingredient as $key1 => $combo_ingre) {

							$tdCost_2 = $this->Calculator_cost_menu($combo_ingre['item_id']);
							$tdCost   += $tdCost_2;

							// AVAILABLE
							$available = $this->Calculator_available_menu($combo_ingre['item_id'],$store_id);
							if(!empty($available)){
								$ArrAvailable[] = $available[0]['quantity_again'];
							}else{
								$ArrAvailable[] = 0;
								break;
							}
							// END AVAILABLE
						}
						$available_unit = !empty($ArrAvailable)?min($ArrAvailable):0;
					}
					
				}else{
					$tdCost = $this->Calculator_cost_menu($value['menu_id']);

					// AVAILABLE
					$available = $this->Calculator_available_menu($value['menu_id'],$store_id);
					// if quantity in ingredient diffirent quantiy get in inventory => exist product expire_day
					if(count($available) != count($Table_Ingredient))
						$min = 0;
					else{
						if(!empty($available))
							$min = !empty($available[0]['quantity_again'])?$available[0]['quantity_again']:0;
						else
							$min = 0;
					}
					$available_unit = $min;
					// END AVAILABLE

				}
				// END COST
				
				// Type
				if($value['m_type'] == 1)
					$type_Menu = 'Standard';
				elseif($value['m_type'] == 2)
					$type_Menu = 'Options';
				else
					$type_Menu = 'Combo';

				$item   = array();
				$item[] = $value['sub_category_name'];
				$item[] = $value['m_item'];
				$item[] = '$'.number_format($value['price'],2,'.','');
				$item[] = !empty($Table_Ingredient)?('$'.number_format($tdCost,2,'.','')):'';
				$item[] = $available_unit.' Unit';
				$item[] = $value['menu_item_number'];
				$item[] = $type_Menu;
				$item[] = $value['description'];
				$item[] = !empty($value['menu_status'])?$arrStatus[$value['menu_status']]:$arrStatus[2];
				fputcsv($output, $item);
			}
			fclose($output);
		}
		die();
	}

	public function jsCatalog(){
		$store_id       = base64_decode($this->sess_cus['storeId']);
		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		
		$this->db->where('store_id', $store_id);
		$this->db->notin('menu_status', 3);
		$menuTotal      = $this->db->get('menu')->count();
	
		$iDisplayLength = (int)$this->input->post('length');
		$iDisplayStart  = (int)$this->input->post('start');
		$iTotal         = $menuTotal;
		$total_items    = $iTotal;
		$total_filter   = $iTotal;
		$sEcho          = (int)($_POST['draw']);
		$_data          = array();

		$sql_where      = "WHERE sub_category.store_id = '".$store_id."' AND menu.menu_status NOT IN(3)";
		$sql_select     = "SELECT menu.*, sub_category.sub_category_name ";
		$sql_from       = "FROM menu ";
		$sql_join       = "LEFT JOIN sub_category ON sub_category.sub_category_id = menu.sub_category_id ";

		$_sql_search = '';
		if(!empty($iSearch)){
			$iSearch = $this->db->escape(trim($iSearch));
			$iSearch = substr($iSearch, 1, (strlen($iSearch)-2));
			$arr     = explode(' ',trim($iSearch));
			$dem     = count($arr);
   			if($store_id == 0){
	   			if($dem > 1){
	    			$_sql_search = " AND (CONCAT_WS(' ',sub_category.sub_category_name,menu.m_item) LIKE '%".$arr[0]."%'";
				    for ($i=1; $i < ($dem-1) ; $i++) { 
				      $_sql_search .= " AND CONCAT_WS(' ',sub_category.sub_category_name,menu.m_item) LIKE '%" .$arr[$i]. "%'";
				    }
				    $_sql_search .= " AND CONCAT_WS(' ',sub_category.sub_category_name,menu.m_item) LIKE '%" .$arr[$dem-1]. "%')";
	   			}else{
	    			$_sql_search = " AND CONCAT_WS(' ',sub_category.sub_category_name,menu.m_item) LIKE '%" .trim($iSearch). "%'";
	   			}
	   		}else{
	   			if($dem > 1){
	    			$_sql_search = " AND (CONCAT_WS(' ',sub_category.sub_category_name,menu.m_item) LIKE '%".$arr[0]."%'";
				    for ($i=1; $i < ($dem-1) ; $i++) { 
				      $_sql_search .= " AND CONCAT_WS(' ',sub_category.sub_category_name,menu.m_item) LIKE '%" .$arr[$i]. "%'";
				    }
				    $_sql_search .= " AND CONCAT_WS(' ',sub_category.sub_category_name,menu.m_item) LIKE '%" .$arr[$dem-1]. "%')";
	   			}else{
	    			$_sql_search = " AND CONCAT_WS(' ',sub_category.sub_category_name,menu.m_item) LIKE '%" .trim($iSearch). "%'";
	   			}
	   		}

			$sql_query    = $sql_select.$sql_from.$sql_join.$sql_where.$_sql_search;
			$total_filter = $this->db->query($sql_query)->count();
		}
		
		$_sql_limit = " LIMIT ".$iDisplayStart.", ".$iDisplayLength;
		$sql_query  = $sql_select.$sql_from.$sql_join.$sql_where.$_sql_search.$_sql_limit;
		$menu       = $this->db->query($sql_query)->result_array(false);
		$arrStatus = array(
			1 => 'Active',
			2 => 'Inactive',
			3 => 'Delete'
		);
		
		if(!empty($menu)){
			foreach ($menu as $key => $value) {
				$this->db->where('menu_id',$value['menu_id']);
				$Table_Ingredient = $this->db->get('ingredient')->result_array(false);
				
				$available_unit   = 0;
				if($value['m_type'] == 3){
					$tdCost       = 0;
					$_flag        = true;
					$ArrAvailable = array();
					if(!empty($Table_Ingredient)){
						foreach ($Table_Ingredient as $key1 => $combo_ingre) {
							//$i = 1;
							
							$tdCost_2 = $this->Calculator_cost_menu($combo_ingre['item_id']);
							$tdCost   += $tdCost_2;

							//$this->db->where('menu_id',$combo_ingre['item_id']);
							//$Table_Ingredient = $this->db->get('ingredient')->result_array(false);

							// AVAILABLE
							$available = $this->Calculator_available_menu($combo_ingre['item_id'],$store_id);
							if(!empty($available)){
								$ArrAvailable[] = $available[0]['quantity_again'];
							}else{
								$ArrAvailable[] = 0;
								break;
							}
							// END AVAILABLE
						}
						$available_unit = !empty($ArrAvailable)?min($ArrAvailable):0;
					}
					
				}else{
					$tdCost = $this->Calculator_cost_menu($value['menu_id']);

					// AVAILABLE
					$available = $this->Calculator_available_menu($value['menu_id'],$store_id);
					// if quantity in ingredient diffirent quantiy get in inventory => exist product expire_day
					if(count($available) != count($Table_Ingredient))
						$min = 0;
					else{
						if(!empty($available))
							$min = !empty($available[0]['quantity_again'])?$available[0]['quantity_again']:0;
						else
							$min = 0;
					}
					$available_unit = $min;
					// END AVAILABLE

				}
				// END COST

				$ArrColor = array('level-orange','level-red','available_black');

				if($available_unit > 0 && $available_unit < 5){
					$available_color = $ArrColor[0];
				}elseif($available_unit > 5){
					$available_color = $ArrColor[2];
				}else{
					$available_color = $ArrColor[1];
				}

				// Type
				if($value['m_type'] == 1)
					$type_Menu = 'Standard';
				elseif($value['m_type'] == 2)
					$type_Menu = 'Options';
				else
					$type_Menu = 'Combo';
				$sNote = text::limit_words($value['description'], 5, '&nbsp;');
				$_data[] = array(
					"tdID"             => $value['menu_id'],
					"tdIcon"           => $value['file_id'], 
					"tdCategory"       => $value['sub_category_name'],
					"tdName"           => $value['m_item'],
					"tdPrice"          => '$'.number_format($value['price'],2,'.',''),
					"tdCost"           => !empty($Table_Ingredient)?('$'.number_format($tdCost,2,'.','')):'',
					"tdAvailable"      => $available_unit.' Unit',
					"tdAvailableColor" => $available_color,
					"tdSKU"            => $value['menu_item_number'],
					"tdType"           => $type_Menu,
					"tdNote"           => (strlen($value['description']) != strlen($sNote))?$sNote.'...':$sNote,
					"tdStatus"         => !empty($value['menu_status'])?$arrStatus[$value['menu_status']]:$arrStatus[2],
					"DT_RowId"         => $value['menu_id'],
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

	public function setStatusMenu(){
		$id     = $this->input->post('id');
		$status = $this->input->post('action');
		$total  = 0;
		if(!empty($id)){
			if(is_array($id)){
				$this->db->in('menu_id', $id);
			}else{
				$this->db->where('menu_id', $id);
			}

			$result = $this->db->update('menu', array('menu_status' => $status));
			$total  = $result->count();
			echo json_encode(array('msg' => true, 'total' => $total));
		}else{
			echo json_encode(array('msg' => false, 'total' => $total));
		}
		die();
	}

	public function getAddCatalog(){
		$template = new View('m_menu/frmCatalog');
		$title    = 'Add New Menu Item';
		$template->set(array(
			'title'        => $title,
			'newid'        => time(),
		));
		$template->render(true);
		die();
	}

	public function getItemOption(){
		$template  = new View('m_menu/itemOptions');
		$store_id  = base64_decode($this->sess_cus['storeId']);
		$idSubMenu = $this->input->post('idSubMenu');
		$this->db->where('sub_category_id',$idSubMenu);
		$this->db->where('store_id',$store_id);
		$OptionsMenu = $this->db->get('menu')->result_array(false);
		$template->set(array(
			'OptionsMenu' => $OptionsMenu,
		));
		$template->render(true);
		die();
	}

	public function getEditCatalog(){
		$template = new View('m_menu/frmEditCatalog');
		$store_id = base64_decode($this->sess_cus['storeId']);
		
		$idMenu   = $this->input->post('idMenu');
		$this->db->where('menu_id', $idMenu);
		$menu     = $this->db->get('menu')->result_array(false);

		$this->db->where('store_id', $store_id);
		if(!empty($menu[0]) && $menu[0]['m_type'] != 2)
			$this->db->where('category_id',$this->idMenu);
		else
			$this->db->where('category_id',$this->idOptions);
		$menuItem = $this->db->get('sub_category')->result_array(false);

		$this->db->select('menu_option.*');
		$this->db->where('menu_id', $idMenu);
		$menu_option = $this->db->get('menu_option')->result_array(false);


		$this->db->select('COUNT(menu_option_id) AS total_option, menu_option.sub_category_id');
		$this->db->where('menu_id', $idMenu);
		$this->db->groupby('sub_category_id');
		$Total_Option_Menu = $this->db->get('menu_option')->result_array(false);
		
		$Total_Option_Menu = count($Total_Option_Menu);

		$this->db->where('menu_id', $idMenu);
		$ingredient = $this->db->get('ingredient')->result_array(false);

		$data                      = array();
		$data['menu']              = !empty($menu)?$menu[0]:'';
		$data['menu_option']       = !empty($menu_option)?$menu_option:'';
		$data['Total_Option_Menu'] = $Total_Option_Menu;
		$data['ingredient']        = !empty($ingredient)?$ingredient:'';

		$this->db->where('status','OPEN');
		$listStage = $this->stage_model->getStore($store_id)->result_array(false);

		if(!empty($menu[0]) && $menu[0]['m_type'] != 2)
			$title = 'Edit Menu Item';
		else
			$title = 'Edit Menu Option';
		$template->set(array(
			'title'        => $title,
			'sub_category' => $menuItem,
			'data_menu'    => $data,
			'newid'        => time(),
			'listStage'    => $listStage
		));
		$template->render(true);
		die();
	}

	public function getSelectInventory(){
		$this->session->delete('inventory');
		$template  = new View('m_menu/frmSelectInventoryMenu');
		
		$idProduct = $this->input->post('idProduct');
		$qty       = $this->input->post('qty');
		$data      = array();
		if(!empty($idProduct)){
			foreach ($idProduct as $key => $value) {

				$sql_select = "SELECT product.pro_name, product.pro_no, CONCAT_WS(' / ',product.pro_no, product.pro_name) AS item, product.pro_id AS id, product.pro_unit, product.pro_id, sub_category.sub_category_name, sub_category.sub_category_id ";
				$sql_from   = "FROM product ";
				$sql_join1  = "INNER JOIN sub_category ON sub_category.sub_category_id = product.sub_category_id ";
				$sql_where  = " WHERE product.pro_id = '".$value."' ";
				$sql_query  = $sql_select.$sql_from.$sql_join1.$sql_where;
				$inventory  = $this->db->query($sql_query)->result_array(false);

				if(!empty($inventory)){
					$inventory        = $inventory[0];
					$inventory['qty'] = !empty($qty[$key])?$qty[$key]:'';
					$data[]           = $inventory;
				}
			}
		}

		$title = 'Add Inventory';
		$template->set(array(
			'title'           => $title,
			'data_ingredient' => $data,
		));
		$template->render(true);
		die();
	}

	public function getSelectOption(){
		$arr_option = array();	
		if(!empty($_POST)){
			foreach ($_POST['idParent'] as $key => $value) {
				$arr_option[$value]['idMenu'][]    = $_POST['idMenu'][$key];
				$arr_option[$value]['priceMenu'][] = !empty($_POST['priceMenu'][$key])?$_POST['priceMenu'][$key]:0;
				$arr_option[$value]['typeMenu']    = $_POST['typeMenu'][$key];
			}
		}
		$store_id = base64_decode($this->sess_cus['storeId']);
		$template = new View('m_menu/frmSelectOptions');
		$this->db->where('store_id', $store_id);
		$this->db->where('category_id',$this->idOptions);
		$menuOptions = $this->db->get('sub_category')->result_array(false);

		$title = 'Add Menu Options';
		$template->set(array(
			'title'           => $title,
			'menuOptions'     => $menuOptions,
			'dataMenuOptions' => !empty($arr_option)?$arr_option:'', 
		));
		$template->render(true);
		die();
	}

	public function getSelectMenu(){
		$template = new View('m_menu/frmSelectMenu');
		$store_id = base64_decode($this->sess_cus['storeId']);
		$idProduct = $this->input->post('idProduct');
		$data  = array();
		if(!empty($idProduct)){
			foreach ($idProduct as $key => $value) {
				$sql_select = "SELECT  CONCAT_WS(' / ',menu.menu_item_number, menu.m_item) AS text, menu.menu_id AS id ,menu.m_item AS item_name,menu.menu_item_number AS item_no,menu.file_id AS image, sub_category.sub_category_name AS category_name ";
				$sql_from   = " FROM menu";
				$sql_join   = " INNER JOIN sub_category ON sub_category.sub_category_id = menu.sub_category_id";
				$sql_where  = " WHERE menu.menu_id = '".$value."' AND menu.store_id = '".$store_id."' ";
				$sql_query  = $sql_select.$sql_from.$sql_join.$sql_where;
				$data[]     = $this->db->query($sql_query)->result_array(false);
			}
		}
		$template->set(array(
			'title' => 'Combo Options',
			'data'  => $data,
		));
		$template->render(true);
		die();
	}

	public function getMenuItem(){
		$store_id   = base64_decode($this->sess_cus['storeId']);
		$search     = $this->input->post('q');
		$sql_select = "SELECT  CONCAT_WS(' / ',menu.menu_item_number, menu.m_item) AS text, menu.menu_id AS id ,menu.m_item AS item_name,menu.menu_item_number AS item_no,menu.file_id AS image, sub_category.sub_category_name AS category_name ";
		$sql_from   = " FROM menu";
		$sql_join   = " INNER JOIN sub_category ON sub_category.sub_category_id = menu.sub_category_id";
		$sql_where  = " WHERE (CONCAT_WS(' ',menu.m_item,menu.menu_item_number)) LIKE '%".$search."%' AND menu.store_id = '".$store_id."' AND menu.m_type = 1 ";
		$sql_query  = $sql_select.$sql_from.$sql_join.$sql_where;
		$menu       = $this->db->query($sql_query)->result_array(false);

		if(!empty($menu)){
			$data = $menu;
		}else{
			$data = array();
		}
		echo json_encode($data);
		die();
	}

	public function getInventory(){
		$store_id = base64_decode($this->sess_cus['storeId']);
		$search   = $this->input->post('q');

		$sql_select = "SELECT inventory.inventory_id , product.pro_name, product.pro_no, product.pro_unit, CONCAT_WS(' / ',product.pro_no, product.pro_name) AS text, product.pro_id AS id, sub_category.sub_category_name, sub_category.sub_category_id ";
		$sql_from   = "FROM inventory ";
		$sql_join1  = "INNER JOIN product ON product.pro_id = inventory.pro_id ";
		$sql_join2  = "INNER JOIN sub_category ON sub_category.sub_category_id = product.sub_category_id ";
		$sql_group  = "GROUP BY inventory.pro_id";
		$sql_where  = " WHERE (CONCAT_WS(' ',product.pro_name,product.pro_no)) LIKE '%".$search."%' AND inventory.store_id = '".$store_id."' AND inventory.admin_id = '".$this->sess_cus['admin_refer_id']."' ";
		$sql_query  = $sql_select.$sql_from.$sql_join1.$sql_join2.$sql_where.$sql_group;
		$inventory  = $this->db->query($sql_query)->result_array(false);

		if(!empty($inventory)){
			$data = $inventory;
		}else{
			$data = array();
		}
		
		echo json_encode($data);
		die();
	}

	public function saveCatalog(){
		$txt_m_type = $this->input->post('txt_m_type');
		$id_hd      = $this->input->post('txt_hd_id');
		if(empty($id_hd)){
			$menu_id    = $this->getGUID();
			$txt_price  = $this->input->post('txt_price');
			$txt_calory = $this->input->post('txt_calory');
			$data = array(
				'menu_id'          => $menu_id,
				'store_id'         => base64_decode($this->sess_cus['storeId']), 
				'sub_category_id'  => $this->input->post('txt_sub_category'), 
				'ingredient_id'    => 0, 
				'm_item'           => $this->input->post('txt_item_name'), 
				'price'            => !empty($txt_price)?number_format($txt_price,2,'.',''):0.00, 
				'description'      => $this->input->post('txt_note'),
				'file_id'          => $this->input->post('uploadfilehd'),
				'menu_item_number' => $this->input->post('txt_sku'),
				'stage_id'         => $this->input->post('txt_stage'),
				'calory'           => !empty($txt_calory)?$txt_calory:0,
				'm_type'           => ($txt_m_type == 'combo_set')?3:(($txt_m_type == 'options_menu')?2:1),
				'menu_status'      => 1,
				'barcode'          => $this->input->post('txt_barcode')
			);

			$rs_menu = $this->db->insert('menu',$data);

			$m_inventory = $this->input->post('txt_catalog');
			$m_quantity  = $this->input->post('txt_qty');
			if(isset($m_inventory)){
				for($i = 0; $i < count($m_inventory); $i++)
				{
					if(!empty($m_inventory[$i]))
					{
						if($txt_m_type == 'combo_set'){
							$record = array(
								'ingredient_id' => $this->getGUID(),
								'item_id'       => $m_inventory[$i],
								'ig_quantity'   => 0,
								'menu_id'       => $menu_id,
						   	);
						}elseif($txt_m_type == 'standar_item'){
							$record = array(
								'ingredient_id' => $this->getGUID(),
								'item_id'       => $m_inventory[$i],
								'ig_quantity'   => !empty($m_quantity[$i])?$m_quantity[$i]:0,
								'menu_id'       => $menu_id,
						   	);
						}else{
							$record = array(
								'ingredient_id' => $this->getGUID(),
								'item_id'       => $m_inventory[$i],
								'ig_quantity'   => !empty($m_quantity[$i])?$m_quantity[$i]:0,
								'menu_id'       => $menu_id,
						   	);
						}
						
					    $this->db->insert('ingredient',$record);
					}
					
				}
			}
			
			$txt_menu_parent       = $this->input->post('txt_menu_parent');
			$txt_menu_option       = $this->input->post('txt_menu_option');
			$txt_menu_option_price = $this->input->post('txt_menu_option_price');
			$txt_menu_option_type  = $this->input->post('txt_menu_option_type');
			if(!empty($txt_menu_option)){
				foreach ($txt_menu_option as $key => $value) {
					if(!empty($value)){
						$data_option = array(
							'menu_option_id'  => $this->getGUID(), 
							'menu_id'         => $menu_id,
							'ref_menu_id'     => $value,
							'sub_category_id' => !empty($txt_menu_parent[$key])?$txt_menu_parent[$key]:'',
							'op'              => !empty($txt_menu_option_type[$key])?$txt_menu_option_type[$key]:'',
							'add_price'       => !empty($txt_menu_option_price[$key])?$txt_menu_option_price[$key]:0,
						);

						$this->db->insert('menu_option', $data_option);
					}
				}
			}
			if($menu_id)
				$this->session->set_flash('success_msg', 'Changes saved.');
		    else 
		    	$this->session->set_flash('error_msg', 'Error Save.');
			url::redirect('catalogs');
			die();
		}else{
			$txt_price  = $this->input->post('txt_price');
			$txt_calory = $this->input->post('txt_calory');
			$data = array(
				'store_id'         => base64_decode($this->sess_cus['storeId']), 
				'sub_category_id'  => $this->input->post('txt_sub_category'), 
				'ingredient_id'    => 0, 
				'm_item'           => $this->input->post('txt_item_name'), 
				'price'            => !empty($txt_price)?number_format($txt_price,2,'.',''):0.00, 
				'description'      => $this->input->post('txt_note'),
				'file_id'          => $this->input->post('uploadfilehd'),
				'menu_item_number' => $this->input->post('txt_sku'),
				'stage_id'         => $this->input->post('txt_stage'),
				'calory'           => !empty($txt_calory)?$txt_calory:0,
				'barcode'          => $this->input->post('txt_barcode')
			);
			$this->db->where('menu_id', $id_hd);
			$rs_menu = $this->db->update('menu',$data);

			/* Delete all ingredient */
			$this->db->where('menu_id', $id_hd);
			$this->db->delete('ingredient');
			
			$m_inventory = $this->input->post('txt_catalog');
			$m_quantity  = $this->input->post('txt_qty');
			if(isset($m_inventory)){
				for($i = 0; $i < count($m_inventory); $i++)
				{
					if(!empty($m_inventory[$i]))
					{
						if($txt_m_type == 'combo_set'){
							$record = array(
								'ingredient_id' => $this->getGUID(),
								'item_id'       => $m_inventory[$i],
								'ig_quantity'   => 0,
								'menu_id'       => $id_hd,
						   	);
						}elseif($txt_m_type == 'standar_item'){
							$record = array(
								'ingredient_id' => $this->getGUID(),
								'item_id'       => $m_inventory[$i],
								'ig_quantity'   => !empty($m_quantity[$i])?$m_quantity[$i]:0,
								'menu_id'       => $id_hd,
						   	);
						}else{
							$record = array(
								'ingredient_id' => $this->getGUID(),
								'item_id'       => $m_inventory[$i],
								'ig_quantity'   => !empty($m_quantity[$i])?$m_quantity[$i]:0,
								'menu_id'       => $id_hd,
						   	);
						}
					    $this->db->insert('ingredient',$record);
					}
					
				}
			}

			/* delete option */
			$this->db->where('menu_id', $id_hd);
			$this->db->delete('menu_option');

			$txt_menu_parent       = $this->input->post('txt_menu_parent');
			$txt_menu_option       = $this->input->post('txt_menu_option');
			$txt_menu_option_price = $this->input->post('txt_menu_option_price');
			$txt_menu_option_type  = $this->input->post('txt_menu_option_type');
			if(!empty($txt_menu_option)){
				foreach ($txt_menu_option as $key => $value) {
					if(!empty($value)){
						$data_option = array(
							'menu_option_id'  => $this->getGUID(), 
							'menu_id'         => $id_hd,
							'ref_menu_id'     => $value,
							'sub_category_id' => !empty($txt_menu_parent[$key])?$txt_menu_parent[$key]:'',
							'op'              => !empty($txt_menu_option_type[$key])?$txt_menu_option_type[$key]:'',
							'add_price'       => !empty($txt_menu_option_price[$key])?$txt_menu_option_price[$key]:0,
						);

						$this->db->insert('menu_option', $data_option);
					}
				}
			}
			url::redirect('catalogs');
			die();
		}
	}

	public function getAddRegistry(){
		$template  = new View('m_inventory/Registry/listRegistryInventory');
		$title     = 'Inventory Registry';

		$this->db->select('COUNT(pro_id) AS t_pro');
		$this->db->where('admin_id',$this->sess_cus['admin_refer_id']);
		$total_pro = $this->db->get('product')->result_array(false);
		$template->set(array(
			'title'     => $title,
			'total_pro' => !empty($total_pro[0])?$total_pro[0]['t_pro']:0,
		));
		$template->render(true);
		die();
	}

	public function jsRegistry(){
		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		$iDisplayLength = ((int)$_POST['length']);
		$iDisplayStart  = (int)($_POST['start']);
		$sEcho          = (int)($_POST['draw']);
		$_data          = array();
		$total_items    = (int)($_POST['_main_count']);
		$total_filter   = $total_items;

		if($total_items > 0){
			$this->db->select('product.*, sub_category.sub_category_name, sub_category.category_id');
			$this->db->where('product.admin_id', $this->sess_cus['admin_refer_id']);
			$this->db->where('product.pro_status','1');
			$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
			$this->db->limit($iDisplayLength,$iDisplayStart);
			$this->db->orderby('sub_category.sub_category_name', 'ASC');
			$mlist_product = $this->db->get('product')->result_array(false);
			

			if(!empty($mlist_product)){
				foreach ($mlist_product as $key => $value) {
					$Cost = '$'.number_format($value['pro_cost_store'],2).' per '.$value['pro_per_store'].' '.$value['pro_unit'];
					$Shelflifestore = !empty($value['pro_shelf_life_store'])?$value['pro_shelf_life_store'].' days':'';
					$_data[] = array(
						"tdID"              => !empty($value['pro_id'])?$value['pro_id']:'',
						"tdIcon"            => !empty($value['file_id'])?$value['file_id']:'',
						"tdSubCategoryName" => !empty($value['sub_category_name'])?$value['sub_category_name']:'',
						"tdProName"         => !empty($value['pro_name'])?$value['pro_name']:'',
						"tdSKU"             => !empty($value['pro_no'])?$value['pro_no']:'',
						"tdCost"            => $Cost,
						"tdUnit"            => !empty($value['pro_unit'])?$value['pro_unit']:'',
						"tdNote"            => !empty($value['pro_note'])?$value['pro_note']:'',
						"tdShelflifestore"  => $Shelflifestore,
						"DT_RowId"          => !empty($value['pro_id'])?$value['pro_id']:'',
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

	public function checkitem_no(){
		$txt_code = $this->input->post('txt_code');                           
		$store_id = base64_decode($this->sess_cus['storeId']);
		$chk_code = array();
		if(!empty($txt_code)){
			$this->db->where('store_id',$store_id);
			$this->db->where('menu_item_number',$txt_code);
			$chk_code = $this->db->get('menu')->result_array(false);
		}
			
		if(!empty($chk_code)){
			echo json_encode(array('msg' => 'false'));
			die();
		}
		echo json_encode(array('msg' => 'true'));
		die();
	}

	public function nextCode(){
		$store_id = base64_decode($this->sess_cus['storeId']);  
		$this->db->select('MAX(menu.menu_item_number) AS max_no');
		$this->db->where('store_id',$store_id);
		$max_no   = $this->db->get('menu')->result_array(false);
		
		$max_no_continue = 1000;
		if(!empty($max_no[0]['max_no']))
			$max_no_continue = (int)$max_no[0]['max_no'] + 1;
		echo json_encode(array(
			'msg'  => 'true',
			'code' => $max_no_continue
		));
		die();
	}
	
}
?>