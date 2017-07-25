<?php
class Warehouse_Controller extends Template_Controller {
	
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
		
		if(empty($this->sess_cus['admin_level']) || $this->sess_cus['admin_level'] != 1 || empty($this->sess_cus['storeId']) || base64_decode($this->sess_cus['storeId']) != '0'){
			url::redirect('/');
		}
		$this->_getCountOrder();
		$this->_getCountWHOrder();
    }
    
    private function _getCountWHOrder(){
		$this->db->select('count(w_id) as total');
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('mark_complete', 1);
		$totalOrder         = $this->db->get('warehouse_order')->result_array(false);
		$this->countWHOrder = !empty($totalOrder)?$totalOrder[0]['total']:0;
    }

    private function _getCountOrder(){
    	$this->db->select('count(store_order_id) as total');
    	$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('mark_complete', 2);
		$this->db->where('store_order_from', 'warehouse');
		$totalOrder       = $this->db->get('store_order')->result_array(false);
		$this->countOrder = !empty($totalOrder)?$totalOrder[0]['total']:0;
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
		die();
	}

	public function index(){
		$this->listWarehouse();
	}

	/*============ DISTRIBUTION ==============================================================================================*/
	public function distribution(){
		$this->template->content = new View('wh_distribution/listDistribution');
		$this->template->jsKiosk = new View('wh_distribution/jsListDistribution');
	}

	private function _autoDelete(){
		/* API autoDeleteDestribution */
		$expire_day = date('Y-m-d H:i:s',strtotime(date('m/d/Y'). "-10 day"));
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('store_status', '1');
		$this->db->where('store_order_from', 'warehouse');
		$this->db->where('date_mark_complete < "'.$expire_day.'"');
		$this->db->in('mark_complete', array('0', '1', '3'));
		$result = $this->db->update('store_order', array('store_status' => 2));
		return $result->count();
	}

	public function substrId($id){
		return substr($id, 0, strlen($id) - 4);
	}

	public function exportDistribution(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportWarehouseDistribution_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w");
		fputcsv($output, array(
			'Category',
			'Item Name',
			'SKU#',
			'Ordered By',
			'Preset Cost of Purchase for Stores',
			'Actual Payment Committed by Store',
			'Quantity',
			'Total Payment',
			'Status'
		));

		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = arr::map_recursive(array($this, 'substrId'), $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';
		$strSql = "SELECT sub_category.sub_category_name, product.pro_id, product.pro_name, 
			product.pro_no, product.pro_cost_store,product.pro_per_store,product.pro_unit,store_order.store_price,
			store_order.store_order_id,store_order.mark_complete,store_order.date_mark_complete,
			store_order.store_unit,store_order.store_regidate,store_order.store_order_from,
			store.store ";
		$strSql .= "FROM store_order ";
		$strSql .= "LEFT JOIN product ON product.pro_id = store_order.product_id ";
		$strSql .= "LEFT JOIN sub_category ON sub_category.sub_category_id = product.sub_category_id ";
		$strSql .= "LEFT JOIN store ON store.store_id = store_order.store_id ";
		$strSql .= "WHERE store_order.admin_id = '".$this->sess_cus['admin_refer_id']."' ";
		$strSql .= "AND store_order.store_order_id IN(".$idSelected.") ";
		$strSql .= "ORDER BY sub_category.sub_category_name ASC";
		$result = $this->db->query($strSql)->result_array(false);
		if(!empty($result)){
			$arrStatus = array('Approved','Approved','Waiting For a Reply','Rejected');
			foreach ($result as $key => $value) {
				$_str  = '';
				$pro_per_store  = !empty($value['pro_per_store'])?(float)$value['pro_per_store']:0;
				$store_price    = !empty($value['store_price'])?(float)$value['store_price']:0;
				$pro_cost_store = !empty($value['pro_cost_store'])?(float)$value['pro_cost_store']:0;
				
				$tdCostStores   = (!empty($value['pro_cost_store'])?'$'.number_format($value['pro_cost_store'],2,'.','').' per':'').(!empty($value['pro_per_store'])?' '.$value['pro_per_store'].' '.$value['pro_unit']:'');
				$valOrder       = (float)$value['store_unit'];

				if($value['mark_complete'] != 1 && $value['mark_complete'] != 0){
					/* API totalAvailable */
					$this->db->select('pro_id, SUM(quantity) as total');
					$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
					$this->db->in('pro_id', array($value['pro_id']));
					$this->db->where('(expire_day >= "'.date('Y-m-d 00:00:00').'" OR expire_day = "1000-01-01 00:00:00")');
					$this->db->groupby('pro_id');
					$result = $this->db->get('warehouse')->result_array(false);

					$valWarehosue = !empty($result['0']['total'])?(float)$result['0']['total']:0;
					if($valOrder > $valWarehosue){
						$_str  = chr(13).'Insufficient stock '.abs($valWarehosue-$valOrder).' '.$value['pro_unit'].' required';
					}
				}

				$tdCostWarehouse = (float)number_format(($pro_per_store * $store_price) / $valOrder, 2,'.','');
				$tdCostWarehouse = '$'.number_format($tdCostWarehouse,2,'.','').' per'.(!empty($value['pro_per_store'])?' '.$value['pro_per_store'].' '.$value['pro_unit']:'');
				$quantity = $value['store_unit'].' '.$value['pro_unit'];
				
				$item   = array();
				$item[] = $value['sub_category_name'];
				$item[] = $value['pro_name'];
				$item[] = $value['pro_no'];
				$item[] = $value['store'];
				$item[] = $tdCostStores;
				$item[] = $tdCostWarehouse;
				$item[] = $quantity.$_str;
				$item[] = '$'.number_format($value['store_price'],2,'.','');
				$item[] = $arrStatus[$value['mark_complete']];
				fputcsv($output, $item);
			}
			fclose($output);
		}
		die();
	}

	public function getDataDistribution(){
		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		$iDisplayLength = (int)$_POST['length'];
		$iDisplayStart  = (int)$_POST['start'];
		/*$iOrder       = (int)($_POST['order'][0]['column']);
		$iDir           = $_POST['order'][0]['dir'];*/

		$autoDelete  = $this->input->post('auto-delete');
		$countDelete = 0;
		if(!empty($autoDelete)){
			$countDelete = $this->_autoDelete();
		}

		$this->db->select('product.file_id,sub_category.sub_category_name,product.pro_name,product.pro_no,product.pro_cost_store,product.pro_per_store,product.pro_unit,store_order.store_price,store_order.store_order_id,store_order.mark_complete,store_order.date_mark_complete,store_order.store_unit,store_order.store_regidate,store_order.store_order_from,store.s_first,store.s_last, store.store');
		$this->db->where('store_order.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('store_order.store_order_from', 'warehouse');
		if(isset($_POST['show-filter']) && !empty($_POST['show-filter'])){
			if($_POST['show-filter'] == 'approved'){
				$this->db->where('((store_order.mark_complete = 0 OR store_order.mark_complete = 1) AND store_order.store_status <> 2)');
			}elseif($_POST['show-filter'] == 'rejected'){
				$this->db->where('(store_order.mark_complete = 3 AND store_order.store_status <> 2)');
			}else{
				$this->db->where('(store_order.store_status <> 2)');
			}
		}else{
			$this->db->where('(store_order.store_status <> 2)');
		}
		$this->db->join('product', array('product.pro_id' => 'store_order.product_id'),'','');
		$this->db->join('store', array('store.store_id' => 'store_order.store_id'),'','');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
		$this->db->orderby('sub_category.sub_category_name', 'ASC');
		$total_items = $this->db->get('store_order')->count();
		

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
				$sql_search = "(CONCAT_WS(' ',sub_category.sub_category_name,product.pro_name,product.pro_no,store.s_first,store.s_last, store.store) LIKE '%".$arr[0]."%'";
				for ($i=1; $i < ($dem-1) ; $i++) { 
					$sql_search .= "AND CONCAT_WS(' ',sub_category.sub_category_name,product.pro_name,product.pro_no,store.s_first,store.s_last, store.store) LIKE '%" .$arr[$i]. "%'";
				}
				$sql_search .= " AND CONCAT_WS(' ',sub_category.sub_category_name,product.pro_name,product.pro_no,store.s_first,store.s_last, store.store) LIKE '%" .$arr[$dem-1]. "%')";
			}else{
				$sql_search = "CONCAT_WS(' ',sub_category.sub_category_name,product.pro_name,product.pro_no,store.s_first,store.s_last, store.store) LIKE '%" .trim($iSearch). "%'";
			}
			if(isset($_POST['show-filter']) && !empty($_POST['show-filter'])){
				if($_POST['show-filter'] == 'approved'){
					$this->db->where('((store_order.mark_complete = 0 OR store_order.mark_complete = 1) AND store_order.store_status <> 2)');
				}elseif($_POST['show-filter'] == 'rejected'){
					$this->db->where('(store_order.mark_complete = 3 AND store_order.store_status <> 2)');
				}else{
					$this->db->where('(store_order.store_status <> 2)');
				}
			}else{
				$this->db->where('(store_order.store_status <> 2)');
			}
			$this->db->select('product.file_id,sub_category.sub_category_name,product.pro_id,product.pro_name,product.pro_no,product.pro_cost_store,product.pro_per_store,product.pro_unit,store_order.store_price,store_order.store_order_id,store_order.mark_complete,store_order.date_mark_complete,store_order.store_unit,store_order.store_regidate,store_order.store_order_from,store.s_first,store.s_last, store.store');
			$this->db->where('store_order.admin_id', $this->sess_cus['admin_refer_id']);
			$this->db->where('store_order.store_order_from', 'warehouse');
			$this->db->where($sql_search);
			$this->db->join('product', array('product.pro_id' => 'store_order.product_id'),'','');
			$this->db->join('store', array('store.store_id' => 'store_order.store_id'),'','');
			$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
			$this->db->orderby('sub_category.sub_category_name', 'ASC');
			$total_filter = $this->db->get('store_order')->count();

			$this->db->where($sql_search);
		}
		$this->db->select('product.file_id,sub_category.sub_category_name,product.pro_id,product.pro_name,product.pro_no,product.pro_cost_store,product.pro_per_store,product.pro_unit,store_order.store_price,store_order.store_order_id,store_order.mark_complete,store_order.date_mark_complete,store_order.store_unit,store_order.store_regidate,store_order.store_order_from,store.s_first,store.s_last, store.store');
		$this->db->where('store_order.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('store_order.store_order_from', 'warehouse');

		if(isset($_POST['show-filter']) && !empty($_POST['show-filter'])){
			if($_POST['show-filter'] == 'approved'){
				$this->db->where('((store_order.mark_complete = 0 OR store_order.mark_complete = 1) AND store_order.store_status <> 2)');
			}elseif($_POST['show-filter'] == 'rejected'){
				$this->db->where('(store_order.mark_complete = 3 AND store_order.store_status <> 2)');
			}else{
				$this->db->where('(store_order.store_status <> 2)');
			}
		}else{
			$this->db->where('(store_order.store_status <> 2)');
		}

		$this->db->join('product', array('product.pro_id' => 'store_order.product_id'),'','');
		$this->db->join('store', array('store.store_id' => 'store_order.store_id'),'','');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
		$this->db->orderby('sub_category.sub_category_name', 'ASC');
		$this->db->limit($iDisplayLength,$iDisplayStart);
		$result = $this->db->get('store_order')->result_array(false);
		/* API getDataDistribution */
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$_str  = '';
				$check = false;

				$pro_per_store  = !empty($value['pro_per_store'])?(float)$value['pro_per_store']:0;
				$store_price    = !empty($value['store_price'])?(float)$value['store_price']:0;
				$pro_cost_store = !empty($value['pro_cost_store'])?(float)$value['pro_cost_store']:0;

				$tdCostStores = (!empty($value['pro_cost_store'])?'$'.number_format($value['pro_cost_store'],2,'.','').' per':'').(!empty($value['pro_per_store'])?' '.$value['pro_per_store'].' '.$value['pro_unit']:'');
				$valOrder     = (float)$value['store_unit'];

				if($value['mark_complete'] != 1 && $value['mark_complete'] != 0){
					/* API totalAvailable */
					$this->db->select('pro_id, SUM(quantity) as total');
					$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
					$this->db->in('pro_id', array($value['pro_id']));
					$this->db->where('(expire_day >= "'.date('Y-m-d 00:00:00').'" OR expire_day = "1000-01-01 00:00:00")');
					$this->db->groupby('pro_id');
					$result = $this->db->get('warehouse')->result_array(false);

					$valWarehosue = !empty($result['0']['total'])?(float)$result['0']['total']:0;

					if($valOrder > $valWarehosue){
						$_str  = '<span style="display: block;color: red;">Insufficient stock '.abs($valWarehosue-$valOrder).' '.$value['pro_unit'].' required</span>';
						$check = true;
					}
				}

				$tdCostWarehouse = (float)number_format(($pro_per_store * $store_price) / $valOrder, 2,'.','');
				if($tdCostWarehouse != $pro_cost_store){
					$tdCostWarehouse = '<span style="display: block;color: red;">$'.number_format($tdCostWarehouse,2,'.','').' per'.(!empty($value['pro_per_store'])?' '.$value['pro_per_store'].' '.$value['pro_unit']:'').'</span>';
				}else{
					$tdCostWarehouse = '<span>$'.number_format($tdCostWarehouse,2,'.','').' per'.(!empty($value['pro_per_store'])?' '.$value['pro_per_store'].' '.$value['pro_unit']:'').'</span>';
				}

				if($value['mark_complete'] == 1 || $value['mark_complete'] == 0){
            		$_btnApprove = 0;
            		$_btnReject  = 0;
            	}else if($value['mark_complete'] == 3){
            		$_btnApprove = 0;
            		$_btnReject  = 0;
            	}else{
            		if($check == true){
                		$_btnApprove = 0;
                	}else{
                		$_btnApprove = 1;
                	}
                	$_btnReject  = 1;
            	}

				$_data[] = array(
					"tdID"            => $value['store_order_id'].'|'.$_btnApprove.'|'.$_btnReject,
					"tdIcon"          => $value['file_id'],
					"tdSubCategory"   => $value['sub_category_name'],
					"tdStore"         => $value['store'],
					"tdName"          => $value['pro_name'],
					"tdSKU"           => $value['pro_no'],
					"tdCostStores"    => $tdCostStores,
					"tdCostWarehouse" => $tdCostWarehouse,
					"tdQty"           => $value['store_unit'].' '.$value['pro_unit'].$_str, 
					"tdUnit"          => $value['pro_unit'],
					"tdTotal"         => '$'.number_format($value['store_price'],2,'.',''),
					"tdStatus"        => $check,
					"tdComplete"      => $value['mark_complete'],
					"DT_RowId"        => $value['store_order_id'].'|'.$_btnApprove.'|'.$_btnReject,
		    	);
			}
		}
		$records                    = array();
		$records["data"]            = $_data;
		$records["draw"]            = $sEcho;
		$records["recordsTotal"]    = $total_items;
		$records["recordsFiltered"] = $total_filter;
		
		$this->_getCountOrder();
		$records['totalOrder']      = $this->countOrder;
		$records['countDelete']     = $countDelete;
		echo json_encode($records);
		die();
	}

	public function approveDistribution(){
		$idS_Order = $this->input->post('id_store_order');
		$total     = 0;
		if(!is_array($idS_Order)){
			$_temp       = $idS_Order;
			$idS_Order   = array();
			$idS_Order[] = $_temp;
		}
		if(!empty($idS_Order)){
			foreach ($idS_Order as $key => $idS_Order) {
				$arr = explode('|', $idS_Order);
				if((int)$arr[1] == 1){
					/* API getStoreOderId */
					$this->db->where('store_order_id', $arr[0]);
					$result = $this->db->get('store_order')->result_array(false);
					
					if(!empty($result) && $result[0]['mark_complete'] == 2){
						/* API totalAvailable */
						$this->db->select('SUM(quantity) as total');
						$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
						$this->db->where('pro_id', $result[0]['product_id']);
						$this->db->where('(expire_day >= "'.date('Y-m-d 00:00:00').'" OR expire_day = "1000-01-01 00:00:00")');
						$this->db->groupby('pro_id');
						$valWarehosue = $this->db->get('warehouse')->result_array(false);
						$valWarehosue = !empty($valWarehosue['0']['total'])?(float)$valWarehosue['0']['total']:0;
					
						$valOrder = !empty($result[0]['store_unit'])?(float)$result[0]['store_unit']:0;

						if($valOrder <= $valWarehosue){
							/* API getInventoryAvailable */
							$this->db->select('warehouse_id, quantity, expire_day, (CASE expire_day WHEN \'1000-01-01 00:00:00\' THEN 1 ELSE 0 END) as intexpire');
							$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
							$this->db->where('pro_id', $result[0]['product_id']);
							$this->db->where('(expire_day >= "'.date('Y-m-d 00:00:00').'" OR expire_day = "1000-01-01 00:00:00")');
							$this->db->where('quantity > 0');
							$this->db->orderby('intexpire', "ASC");
							$this->db->orderby('expire_day', "ASC");
							$inventory = $this->db->get('warehouse')->result_array(false);
		
							if(!empty($inventory)){
								foreach ($inventory as $key => $value) {
									$valInv = !empty($value['quantity'])?(float)$value['quantity']:0;

									$valOrder = $valInv - $valOrder;

									if($valOrder >= 0){
										/* API updateInventoryWH */
										$this->db->where('warehouse_id', $value['warehouse_id']);
										$this->db->update('warehouse', array(
											'quantity' => $valOrder, 
										));

										/* API updateStoreOder (Inventory.xlsx)*/
										$this->db->where('store_order_id', $result[0]['store_order_id']);
										$this->db->update('store_order', array(
											'mark_complete'                => 1,
											'date_mark_warehouse_complete' => date('Y-m-d H:i:s')
											// 'date_mark_complete' => date('Y-m-d H:i:s')
										));
										break;
									}else{
										$valOrder = abs($valOrder);
										/* API updateInventoryWH */
										$this->db->where('warehouse_id', $value['warehouse_id']);
										$this->db->update('warehouse', array(
											'quantity' => 0, 
										));
									}
								}
								$total++;
							}
						}
					}
				}
			}
		}
		echo json_encode(array('msg' => $total));
		die();
	}

	public function rejectDistribution(){
		$idS_Order = $this->input->post('id_store_order');
		$total     = 0;
		if(!is_array($idS_Order)){
			$_temp       = $idS_Order;
			$idS_Order   = array();
			$idS_Order[] = $_temp;
		}
		if(!empty($idS_Order)){
			foreach ($idS_Order as $key => $idS_Order) {
				$arr = explode('|', $idS_Order);
				if((int)$arr[2] == 1){
					/* API getStoreOderId */
					$this->db->where('store_order_id', $arr[0]);
					$result = $this->db->get('store_order')->result_array(false);
					if(!empty($result) && $result[0]['mark_complete'] == 2){
						/* API updateStoreOder (Inventory.xlsx)*/
						$this->db->where('store_order_id', $result[0]['store_order_id']);
						$this->db->update('store_order', array(
							'mark_complete'                => 3,
							'date_mark_warehouse_complete' => date('Y-m-d H:i:s')
							// 'date_mark_complete' => date('Y-m-d H:i:s')
						));
						$total++;
					}
				}
			}
		}
		echo json_encode(array('msg' => $total));
		die();
	}

	public function deleteDistribution(){
		$idS_Order = $this->input->post('id_store_order');
		$total     = 0;
		if(!is_array($idS_Order)){
			$_temp       = $idS_Order;
			$idS_Order   = array();
			$idS_Order[] = $_temp;
		}
		if(!empty($idS_Order)){
			foreach ($idS_Order as $key => $idS_Order) {
				$arr = explode('|', $idS_Order);
				/* API getStoreOderId */
				$this->db->where('store_order_id', $arr[0]);
				$result = $this->db->get('store_order')->result_array(false);
				if(!empty($result)){
					$this->db->where('store_order_id', $result[0]['store_order_id']);
					if($result[0]['mark_complete'] == 2){
						$this->db->update('store_order', array(
							'mark_complete'                => 3,
							'store_status'                 => 2,
							'date_mark_warehouse_complete' => date('Y-m-d H:i:s')
						));
					}else{
						/* API updateStoreOder (Inventory.xlsx)*/
						$this->db->update('store_order', array(
							'store_status' => 2,
						));
					}
					$total++;
					/*echo json_encode(array('msg' => true));
					die();*/
				}
			}
		}
		echo json_encode(array('msg' => $total));
		die();
	}
	/*============ END DISTRIBUTION ==============================================================================================*/

	/*============ INVENTORY ==============================================================================================*/
	
	public function inventory(){

		$this->template->content = new View('wh_inventory/inventory');
		$this->template->jsKiosk = new View('wh_inventory/jsInventory');

		/* API getSubCategory (Inventory.xlsx)*/
		$this->db->where('sub_category.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('sub_category.category_id', $this->idInventory);
		$this->db->orderby('sub_category.sub_category_name');
		$result = $this->db->get('sub_category')->result_array(false);

		$this->template->content->set(array(
			'dataCategory' => $result
		));
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
				$this->db->in('warehouse_id', $arrId);
			}else{
				$this->db->where('warehouse_id', $arrId);
			}
			$result = $this->db->delete('warehouse');
			$total = $result->count();
			echo json_encode(array('msg' => true, 'total' => $total));
		}else{
			echo json_encode(array('msg' => false, 'total' => $total));
		}
		die();
	}

	private function _autoDeleteInventory(){
		/* auto delete after 7days */

		/* API autoDeleteInventoryWH */
		$expire_day = date('Y-m-d H:i:s',strtotime(date('m/d/Y'). "-7 day"));
		$this->db->where('(quantity <= 0 OR (expire_day < "'.$expire_day.'" AND expire_day != "'.date('1000-01-01 00:00:00').'"))');
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$result = $this->db->delete('warehouse');
		return $result->count();
	}

	public function exportInventory(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportWarehouseInventory_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w");
		fputcsv($output, array('Item Name',
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

		$this->db->select('warehouse.warehouse_id, warehouse.sub_category_id, warehouse.item, warehouse.quantity, warehouse.pro_id, warehouse.admin_id, warehouse.price, warehouse.expire_day, warehouse.status, warehouse.file_id, warehouse.regidate, warehouse.lot,
				sub_category.sub_category_name, sub_category.category_id, 
				product.pro_no, product.pro_unit');
		$this->db->where('warehouse.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->in('warehouse.warehouse_id', $idSelected);
		$this->db->join('product', array('product.pro_id' => 'warehouse.pro_id'),'','');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'warehouse.sub_category_id'),'','left');
		$this->db->orderby('warehouse.expire_day', 'asc');
		$result = $this->db->get('warehouse')->result_array(false);
		
		$status = array('Expired', 'Not available', 'Expires soon', 'Low Inventory', 'Available');
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$quantity      = !empty($value['quantity'])?$value['quantity']:0;
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
				$item[] = $value['quantity'].' '.$value['pro_unit'];
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
			$this->db->select('GROUP_CONCAT(warehouse.warehouse_id) as warehouse_id, warehouse.sub_category_id, warehouse.item, SUM(CASE WHEN (expire_day >= "'.$today = date('Y-m-d 00:00:00').'" OR expire_day = "'.date('1000-01-01 00:00:00').'") THEN warehouse.quantity ELSE 0 END) AS quantity, warehouse.pro_id, warehouse.admin_id, warehouse.price, GROUP_CONCAT(warehouse.expire_day) as expire_day, warehouse.status, warehouse.file_id, GROUP_CONCAT(warehouse.regidate) as regidate, warehouse.lot,
				sub_category.sub_category_name, sub_category.category_id, 
				product.pro_no, product.pro_unit, count(product.pro_id) as sl');
			$this->db->groupby('product.pro_id');

		}else{
			$this->db->select('warehouse.warehouse_id, warehouse.sub_category_id, warehouse.item, warehouse.quantity, warehouse.pro_id, warehouse.admin_id, warehouse.price, warehouse.expire_day, warehouse.status, warehouse.file_id, warehouse.regidate, warehouse.lot,
				sub_category.sub_category_name, sub_category.category_id, 
				product.pro_no, product.pro_unit');
		}
		
		$this->db->where('warehouse.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->join('product', array('product.pro_id' => 'warehouse.pro_id'),'','');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'warehouse.sub_category_id'),'','left');
		$this->db->orderby('warehouse.expire_day', 'asc');
		$result = $this->db->get('warehouse')->result_array(false);

		$data   = array();
		$status = array('Expired', 'Not available', 'Expires soon', 'Low Inventory', 'Available');

		if(!empty($result)){
			foreach ($result as $key => $value) {
				$quantity      = !empty($value['quantity'])?$value['quantity']:0;
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
								$intStatus = ($intStatus < 0)?0:$intStatus; //Expired
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
					'id'         => $value['warehouse_id'],
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
					'totalStr'   => $value['quantity'].' '.$value['pro_unit'],
					'total'      => $value['quantity'],
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

	public function getAddInventory(){
		$template = new View('wh_inventory/frmInventory');
		$title = 'Manually Add Inventory';
		$template->set(array(
			'title' => $title
		));
		$template->render(true);
		die();
	}

	public function getEditInventory(){
		$template = new View('wh_inventory/frmInventory');
		$title = 'Edit Inventory';

		$id = $this->input->post('id');

		$arrId = explode(',', $id);

		/* API getWarehouseOrderId */
		$this->db->select('warehouse.*, sub_category.sub_category_name, sub_category.category_id, product.pro_no, product.pro_unit, product.pro_cost_warehouse, product.pro_per_warehouse');
		$this->db->where('warehouse.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->in('warehouse.warehouse_id', $arrId);
		$this->db->join('product', array('product.pro_id' => 'warehouse.pro_id'),'','left');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'warehouse.sub_category_id'),'','left');
		$result = $this->db->get('warehouse')->result_array(false);

		$template->set(array(
			'title' => $title,
			'data'  => !empty($result)?$result:''
		));

		$template->render(true);
		die();
	}

	public function getProduct(){
		/* API getProduct (Inventory.xlsx) */
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
					'warehouse_id'    => $this->getGUID(), 
					'merchant_id'     => '', 
					'sub_category_id' => $data['txt_sub_category'][$key], 
					'item'            => $data['txt_name'][$key],
					'lot'             => $data['txt_lot'][$key],
					'quantity'        => $data['txt_qty'][$key], 
					'pro_id'          => $value, 
					'admin_id'        => $this->sess_cus['admin_refer_id'], 
					'price'           => $data['txt_price'][$key], 
					'expire_day'      => $expire_day, 
					'status'          => '1', 
					'file_id'         => $data['txt_file_id'][$key], 
					'regidate'        => $date, 
				);
				try {
					/* API saveInventoryWH */
					$this->db->insert('warehouse', $arr);

					/* insert Order Warehouse */
					$arrOrder = array(
						'w_id'               => $this->getGUID(), 
						'pro_id'             => $value, 
						'w_unit'             => $data['txt_qty'][$key],
						'lot'                => $data['txt_lot'][$key],
						'w_price'            => $data['txt_price'][$key], 
						'w_regidate'         => $date, 
						'w_status'           => 1, 
						'mark_complete'      => 0, 
						'admin_id'           => $this->sess_cus['admin_refer_id'],
						'date_mark_complete' => $date
					);
					/* API savePlaceOrderWH */
					$this->db->insert('warehouse_order', $arrOrder);
	

					$this->session->set_flash('success_msg', 'Changes saved.');
				} catch (Exception $e) {
					$this->session->set_flash('error_msg', 'Error saved.');
				}
			}
		}
		
		url::redirect('warehouse/inventory');
		die();
	}

	public function _editInventory(){
		$data = $this->input->post();
		foreach ($data['txt_hd_id'] as $key => $value) {
			$this->db->where('warehouse_id', $value);
			$result = $this->db->get('warehouse')->result_array(false);
			if(!empty($result)){
				$expire_day = !empty($data['txt_date'][$key])?date('Y-m-d H:i:s', strtotime($data['txt_date'][$key])):'1000-01-01 00:00:00';
				$arr = array(
					'merchant_id'     => '', 
					'sub_category_id' => $data['txt_sub_category'][$key], 
					'item'            => $data['txt_name'][$key], 
					'quantity'        => $data['txt_qty'][$key], 
					'pro_id'          => $data['txt_product'][$key], 
					'admin_id'        => $this->sess_cus['admin_refer_id'], 
					'price'           => $data['txt_price'][$key], 
					'expire_day'      => $expire_day,
					//'status'          => '1', 
					'file_id'         => $data['txt_file_id'][$key],
				);
				try {
					/* API updateInventoryWH */
					$this->db->where('warehouse_id', $value);
					$this->db->update('warehouse', $arr);
					$this->session->set_flash('success_msg', 'Changes saved.');
				} catch (Exception $e) {
					$this->session->set_flash('error_msg', 'Error saved.');
				}
			}else{
				$this->session->set_flash('error_msg', 'Error saved.');
			}
		}
		url::redirect('warehouse/inventory');
		die();
	}

	public function getPlaceOrder(){
		$template = new View('wh_inventory/listPlaceOrder');
		$title = 'Place Order';
		/* API getAddOrder (Inventory.xlsx) */
		$this->db->select('product.*, sub_category.sub_category_name, sub_category.category_id');
		$this->db->where('product.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('product.pro_status','1');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
		$this->db->orderby('sub_category.sub_category_name', "ASC");
		$result = $this->db->get('product')->result_array(false);
		$template->set(array(
			'title' => $title,
			'data'  => $result
		));

		$template->render(true);
		die();
	}

	private function _autoDeleteOrder(){
		/* auto delete after 10days */

		/* API autoDeleteOrderWH */
		$expire_day = date('Y-m-d H:i:s',strtotime(date('m/d/Y'). "-10 day"));
		$this->db->where('(date_mark_complete < "'.$expire_day.'" AND (date_mark_complete != "'.date('1000-01-01 00:00:00').'" OR date_mark_complete IS NOT NULL))');
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$result = $this->db->delete('warehouse_order');
		return $result->count();
	}

	public function exportOrder(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportWarehouseOrder_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w"); 
		fputcsv($output, array(
			'Category',
			'Item Name',
			'SKU#',
			'Payment',
			'Qty Ordered',
			'Date Ordered',
			'Lot #',
			'Order Status'
		));

		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';

		$this->db->select('warehouse_order.*,product.*, sub_category.sub_category_name, sub_category.category_id');
		$this->db->where('warehouse_order.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->join('product', array('product.pro_id' => 'warehouse_order.pro_id'),'','');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','');
		$this->db->in('warehouse_order.w_id', $idSelected);
		$this->db->orderby('warehouse_order.w_regidate', 'desc');
		$this->db->orderby('sub_category.sub_category_name', 'asc');
		$dataOrder = $this->db->get('warehouse_order')->result_array(false);


		if(!empty($dataOrder)){
			$arr_ordered_from = array('warehouse' => 'Warehouse', 'independent_purchase' => 'Independent Purchase');
			$arr_ordered_status = array(0 => 'Complete', 1 => 'Mark as Complete', 2 => 'Waiting For a Reply', 3 => 'Warehouse Reject');
			foreach ($dataOrder as $key => $value) {
				$item   = array();
				$item[] = $value['sub_category_name'];
				$item[] = $value['pro_name'];
				$item[] = $value['pro_no'];
				$item[] = !empty($value['w_price'])?'$'.number_format($value['w_price'],2):'$'.number_format(0,2);
				$item[] = $value['w_unit'].' '.$value['pro_unit'];
				$item[] = date_format(date_create($value['w_regidate']), "m/d/Y");
				$item[] = $value['lot'];
				$item[] = !empty($value['mark_complete'])?$arr_ordered_status[(int)$value['mark_complete']]:$arr_ordered_status[0];
				fputcsv($output, $item);
			}
			fclose($output);
		}
		die();
	}

	public function jsViewOrder(){
		/* API getDataWareHouseOrder */
		$hideComplete = $this->input->post('hide-complete');
		$autoDelete   = $this->input->post('auto-delete');
		$countDelete  = 0;
		if(!empty($autoDelete) && $autoDelete == 1){
			/* API autoDeleteOrderWH */
			$countDelete = $this->_autoDeleteOrder();
		}

		$this->db->select('warehouse_order.*,product.*, sub_category.sub_category_name, sub_category.category_id');
		if(!empty($hideComplete) && $hideComplete == 1)
			$this->db->where('warehouse_order.mark_complete <> 0');
		$this->db->where('warehouse_order.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->join('product', array('product.pro_id' => 'warehouse_order.pro_id'),'','');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','');
		$this->db->orderby('warehouse_order.w_regidate', 'desc');
		$this->db->orderby('sub_category.sub_category_name', 'asc');
		$dataOrder = $this->db->get('warehouse_order')->result_array(false);

		$_data = array();
		$total = 0;
		if(!empty($dataOrder)){
			foreach ($dataOrder as $key => $value) {
				$total += (float)(!empty($value['w_price'])?$value['w_price']:0);
				$_data[] = array(
					"tdID"         => $value['w_id'],
					"tdIcon"       => $value['file_id'],
					"tdCategory"   => $value['sub_category_name'],
					"tdName"       => $value['pro_name'],
					"tdSKU"        => $value['pro_no'],
					"tdPayment"    => !empty($value['w_price'])?'$'.number_format($value['w_price'],2):'$'.number_format(0,2),
					"tdNumPayment" => !empty($value['w_price'])?$value['w_price']:0,
					"tdQty"        => $value['w_unit'].' '.$value['pro_unit'],
					"tdDate"       => date_format(date_create($value['w_regidate']), "m/d/Y"),
					"tdLot"        => $value['lot'],
					"tdComplete"   => $value['mark_complete'],
					"DT_RowId"     => $value['w_id'],
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

	public function getReviewOrder(){
		$template = new View('wh_inventory/listReviewOrder');
		$title    = 'Review Order';
		
		$template->set(array(
			'title'     => $title
		));

		$template->render(true);
		die();
	}

	public function del_warehouse_order(){
		/* API deleteWarehouseOrder */
		$id_warehouse_order  = $this->input->post('w_id');
		if(!is_array($id_warehouse_order)){
			$_temp            = $id_warehouse_order;
			$id_warehouse_order   = array();
			$id_warehouse_order[] = $_temp;
		}
		$this->db->in('w_id', $id_warehouse_order);
		$this->db->where(array('mark_complete !=' => 1));
		$result = $this->db->delete('warehouse_order');
		echo json_encode(array('msg' => count($result)));
		die();
	}

	public function markAsComplete(){
		$w_id     = $this->input->post('w_id');
		$total          = 0;
		if(!is_array($w_id)){
			$_temp            = $w_id;
			$w_id   = array();
			$w_id[] = $_temp;
		}
		if(!empty($w_id)){
			foreach ($w_id as $key => $w_id) {
				/* API getWarehouseOrderId */
				$this->db->select('warehouse_order.*, product.*, sub_category.sub_category_id, sub_category.sub_category_name');
				$this->db->where('warehouse_order.w_id', $w_id);
				$this->db->join('product', array('product.pro_id' => 'warehouse_order.pro_id'),'','');
				$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','');
				$result = $this->db->get('warehouse_order')->result_array(false);
				
				if(!empty($result) && $result[0]['mark_complete'] == 1){
					$datetime = date('Y-m-d H:m:i');
					$this->db->where('w_id',$w_id);
					/* API updateWarehouseOrder */
					$update_store_order = $this->db->update('warehouse_order',
						array(
							'mark_complete'      => 0, 
							'date_mark_complete' => $datetime
						)
					);
					if($update_store_order){
						/* API saveInventoryWH */
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
		/* API saveInventoryWH */
		$expire_day = '1000-01-01 00:00:00';
		$date = date('Y-m-d H:i:s');
		if(!empty($data['pro_shelf_life_warehouse']) && (int)$data['pro_shelf_life_warehouse'] > 0){
			$expire_day = date('Y-m-d H:i:s',strtotime(date('m/d/Y'). "+".$data['pro_shelf_life_warehouse']." day"));
		}
		$lot = (string)round(microtime(true) * 1000);
		$arr = array(
			'warehouse_id'    => $this->getGUID(), 
			'merchant_id'     => '', 
			'sub_category_id' => $data['sub_category_id'],
			'item'            => $data['pro_name'],
			'lot'             => !empty($data['lot'])?$data['lot']:$lot,
			'quantity'        => !empty($data['w_unit'])?$data['w_unit']:0, 
			'pro_id'          => $data['pro_id'],
			'admin_id'        => $this->sess_cus['admin_refer_id'], 
			'price'           => $data['w_price'], 
			'expire_day'      => $expire_day,
			'status'          => '1', 
			'file_id'         => $data['file_id'], 
			'regidate'        => $date, 
		);
		try {
			$this->db->insert('warehouse', $arr);
		} catch (Exception $e) {
			
		}
	}

	public function savePlaceOrder(){
		$data = $this->input->post();
		$_sl  = 0;
		if(!empty($data['txt_unit'])){
			$date = date('Y-m-d H:i:s');
			foreach ($data['txt_unit'] as $key => $value) {
				if(!empty($value) && is_numeric($value)){
					$lot = (string)round(microtime(true) * 1000);
					$arr = array(
						'w_id'          => $this->getGUID(), 
						'pro_id'        => $data['txt_pro_id'][$key], 
						'w_unit'        => $value,
						'lot'           => $lot,
						'w_price'       => $data['txt_price'][$key], 
						'w_regidate'    => $date, 
						'w_status'      => 1, 
						'mark_complete' => 1, 
						'admin_id'      => $this->sess_cus['admin_refer_id'], 
					);
					try {
						/* API savePlaceOrderWH */
						$this->db->insert('warehouse_order', $arr);
						$_sl++;
					} catch (Exception $e) {
						
					}
				}
			}
		}
		if($_sl > 0){
			$this->session->set_flash('success_msg', 'Place Order '.$_sl.' items.');	
		}else{
			$this->session->set_flash('success_msg', 'Place Order '.$_sl.' items.');
		}
		url::redirect('warehouse/inventory');
		die();
	}

	/*============ END INVENTORY ==========================================================================================*/

	/* ============ REGISTRY ==============================================================================================*/

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
		/* API saveRegistry */
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
		url::redirect('warehouse');
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
				/* API updateRegistry */
				$this->db->where('pro_id', $data['txt_hd_id']);
				$this->db->update('product', $arr);
				
				
				/* update name warehouse and inventory */
				$this->db->where('pro_id', $data['txt_hd_id']);
				$dataWH = array(
					'item'            => $data['txt_item_name'],
					'sub_category_id' => $data['txt_sub_category'],
					'file_id'         => $data['uploadfilehd']
				);
				/* API updateWarsHosueProId */
				$this->db->update('warehouse', $dataWH);
				

				$this->db->where('pro_id', $data['txt_hd_id']);
				$dataInven = array(
					'item'            => $data['txt_item_name'],
					'sub_category_id' => $data['txt_sub_category'],
					'file_id'         => $data['uploadfilehd']
				);
				/* API updateInventoryProId */
				$this->db->update('inventory', $dataInven);
				$this->session->set_flash('success_msg', 'Changes saved.');
			} catch (Exception $e) {
				$this->session->set_flash('error_msg', 'Error Save.');
			}
			
		}else{
			$this->session->set_flash('error_msg', 'Error Save.');
			url::redirect('warehouse');
			die();
		}
		url::redirect('warehouse');
		die();
	}

	public function listWarehouse(){
		$this->template->content = new View('wh_registry/listWarehouse');
		$this->template->jsKiosk = new View('wh_registry/jsListWarehouse');
	}

	public function getCatalory(){
		$search   = $this->input->post('q');
		$this->db->select('sub_category_id as id, sub_category_name as text, category_id');
		$query = 'sub_category_name like "%'.$search.'%"';
		$this->db->where($query);
		$this->db->where('category_id', $this->idInventory);
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$sub_category = $this->db->get('sub_category')->result_array(false);
		
		if(!empty($sub_category)){
			$data = $sub_category;
		}else{
			$data = array();
		}
		echo json_encode($data);
		die();
	}

	public function getAddRegistry(){

		$template = new View('wh_registry/frmRegistry');
		$title = 'Register New Inventory Item';

		/* API getSubCategoryWH */
		$this->db->where('sub_category.category_id', $this->idInventory);
		$this->db->where('sub_category.admin_id', $this->sess_cus['admin_refer_id']);
		$sub_category = $this->db->get('sub_category')->result_array(false);

		/* API getMaxProductId */
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
		$template = new View('wh_registry/frmRegistry');
		$title = 'Register Edit Inventory Item';

		$this->db->where('sub_category.category_id', $this->idInventory);
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

	public function exportRegistry(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportWarehouseRegistry_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w");
		fputcsv($output, array('Category',
			'Item Name',
			'SKU#',
			'Cost of Purchase Store',
			'Cost of Purchase Warehouse',
			'Unit',
			'Shelf Life Store',
			'Shelf Life Warehouse'
		));

		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';

		$this->db->select('product.pro_name, product.pro_no, product.pro_unit, product.pro_cost_store, 
			product.pro_cost_warehouse, product.pro_per_store, product.pro_per_warehouse,
			product.pro_shelf_life_store, product.pro_shelf_life_warehouse,
			sub_category.sub_category_name');
		$this->db->where('product.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('product.pro_status','1');
		$this->db->in('product.pro_id', $idSelected);
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
		$this->db->orderby('sub_category.sub_category_name', 'ASC');
		$result = $this->db->get('product')->result_array(false);
		if(!empty($result)){
			$rowCount = 2;
			$column = 'A';
			foreach ($result as $key => $value) {
				$tdCostStores    = (!empty($value['pro_cost_store'])?'$'.$value['pro_cost_store'].' per':'').(!empty($value['pro_per_store'])?' '.$value['pro_per_store'].' '.$value['pro_unit']:'');
				$tdCostWarehouse = (!empty($value['pro_cost_warehouse'])?'$'.$value['pro_cost_warehouse'].' per':'').(!empty($value['pro_per_warehouse'])?' '.$value['pro_per_warehouse'].' '.$value['pro_unit']:'');
				
				$item   = array();
				$item[] = $value['sub_category_name'];
				$item[] = $value['pro_name'];
				$item[] = $value['pro_no'];
				$item[] = $tdCostStores;
				$item[] = $tdCostWarehouse;
				$item[] = $value['pro_unit'];
				$item[] = !empty($value['pro_shelf_life_store'])?$value['pro_shelf_life_store'].' days':'';
				$item[] = !empty($value['pro_shelf_life_warehouse'])?$value['pro_shelf_life_warehouse'].' days':'';
				fputcsv($output, $item);
			}
			fclose($output);
		}
		die();
	}

	public function getDataRegistry(){
		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		$iDisplayLength = (int)$_POST['length'];
		$iDisplayStart  = (int)$_POST['start'];
		/*$iOrder       = (int)($_POST['order'][0]['column']);
		$iDir           = $_POST['order'][0]['dir'];*/

		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('pro_status','1');
		$total_items    = $this->db->get('product')->count();
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
				$sql_search = "(CONCAT_WS(' ',pro_name,pro_no,pro_note,pro_unit,pro_cost_store,pro_cost_warehouse,pro_per_store,pro_per_warehouse,pro_shelf_life_store,pro_shelf_life_warehouse,sub_category_name) LIKE '%".$arr[0]."%'";
				for ($i=1; $i < ($dem-1) ; $i++) { 
					$sql_search .= "AND CONCAT_WS(' ',pro_name,pro_no,pro_note,pro_unit,pro_cost_store,pro_cost_warehouse,pro_per_store,pro_per_warehouse,pro_shelf_life_store,pro_shelf_life_warehouse,sub_category_name) LIKE '%" .$arr[$i]. "%'";
				}
				$sql_search .= " AND CONCAT_WS(' ',pro_name,pro_no,pro_note,pro_unit,pro_cost_store,pro_cost_warehouse,pro_per_store,pro_per_warehouse,pro_shelf_life_store,pro_shelf_life_warehouse,sub_category_name) LIKE '%" .$arr[$dem-1]. "%')";
			}else{
				$sql_search = "CONCAT_WS(' ',pro_name,pro_no,pro_note,pro_unit,pro_cost_store,pro_cost_warehouse,pro_per_store,pro_per_warehouse,pro_shelf_life_store,pro_shelf_life_warehouse,sub_category_name) LIKE '%" .trim($iSearch). "%'";
			}
			$this->db->where('product.admin_id', $this->sess_cus['admin_refer_id']);
			$this->db->where('product.pro_status','1');
			$this->db->where($sql_search);
			$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
			$total_filter = $this->db->get('product')->count();

			$this->db->where($sql_search);
		}
		$this->db->select('product.*, sub_category.sub_category_name, sub_category.category_id');
		$this->db->where('product.admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('product.pro_status','1');
		$this->db->join('sub_category', array('sub_category.sub_category_id' => 'product.sub_category_id'),'','left');
		$this->db->orderby('sub_category.sub_category_name', 'ASC');
		$this->db->limit($iDisplayLength,$iDisplayStart);
		$result = $this->db->get('product')->result_array(false);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$tdCostStores = (!empty($value['pro_cost_store'])?'$'.$value['pro_cost_store'].' per':'').(!empty($value['pro_per_store'])?' '.$value['pro_per_store'].' '.$value['pro_unit']:'');
				$tdCostWarehouse = (!empty($value['pro_cost_warehouse'])?'$'.$value['pro_cost_warehouse'].' per':'').(!empty($value['pro_per_warehouse'])?' '.$value['pro_per_warehouse'].' '.$value['pro_unit']:'');
				$_data[] = array(
					"tdID"            => $value['pro_id'],
					"tdIcon"          => $value['file_id'],
					"tdSubCategory"   => $value['sub_category_name'],
					"tdName"          => $value['pro_name'],
					"tdSKU"           => $value['pro_no'],
					"tdCostStores"    => $tdCostStores,
					"tdCostWarehouse" => $tdCostWarehouse,
					"tdUnit"          => $value['pro_unit'],
					"tdLifeStore"     => !empty($value['pro_shelf_life_store'])?$value['pro_shelf_life_store'].' days':'',
					"tdLifeWareHouse" => !empty($value['pro_shelf_life_warehouse'])?$value['pro_shelf_life_warehouse'].' days':'',
					"DT_RowId"        => $value['pro_id'],
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

	/* ========================= END REGISTRY ==============================================================================================*/

	/* ========================= CATEGORY ==============================================================================================*/

	public function chk_category_name(){
		$admin_refer_id = $this->sess_cus['admin_refer_id'];
		$flag           = true;
		if($_POST && !empty($_POST['txt_name'])){
			$hd_id = $this->input->post('txt_hd_id');
			foreach ($_POST['txt_name'] as $key => $value) {
				$sql = 'LCASE(sub_category_name) = "'.strtolower($value).'"';
				$this->db->where($sql);
				$this->db->where('admin_id', $admin_refer_id);
				$this->db->where('category_id', $this->idInventory);
				if(!empty($hd_id))
					$this->db->notin('sub_category_id', array($hd_id));
				$_sub_category_name = $this->db->get('sub_category')->result_array(false);

				if(!empty($_sub_category_name)){
					$flag = false;
					break;
				}

			}

			if($flag) echo json_encode($_POST);	
			else echo json_encode(array());
			die();		
		}
		echo json_encode(array());
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

		$data = $this->input->post();
		if(!empty($data['txt_name'])){
			foreach ($data['txt_name'] as $key => $valSubName) {
				$newSubId = $this->getGUID();
				$_dataInSub = array(
					'sub_category_id'   => $newSubId, 
					'category_id'       => $this->idInventory, 
					'sub_category_name' => $valSubName, 
					'admin_id'          => $this->sess_cus['admin_refer_id'],
					'regidate'          => date('Y-m-d H:i:s'),
					'file_id'           => $data['uploadfilehd']
				);

				$this->db->insert('sub_category', $_dataInSub);
			}
			$this->session->set_flash('success_msg', 'Changes saved.');
		}
		url::redirect('/warehouse/category');

	}

	private function _editCategory(){
		$data   = $this->input->post();
		$sub_id = $data['txt_hd_id'];

		$this->db->where('sub_category_id', $sub_id);
		$dataSubCategory = $this->db->get('sub_category')->result_array(false);

		if(!empty($dataSubCategory)){

			$dataSubCategory = array(
				'sub_category_name' => $data['txt_name'][0],
				'file_id'           => $data['uploadfilehd']
			);

			$this->db->where('sub_category_id', $sub_id);
			$result = $this->db->update('sub_category',$dataSubCategory);

			$this->session->set_flash('success_msg', 'Changes saved.');
			url::redirect('/warehouse/category');
		}else{
			$this->session->set_flash('error_msg', 'Error saved.');
			url::redirect('/warehouse/category');
		}
	}

	public function getAddCategory(){
		$template = new View('wh_category/frmCategory');
		$title = 'Add Category';
		$template->set(array(
			'title'        => $title,
		));
		$template->render(true);
		die();
	}

	public function exportCategory(){
		header('Content-Type: text/csv; charset=utf-8');  
      	header('Content-Disposition: attachment; filename=ExportWarehouseCategory_'.date("mdYhs").'.csv');
      	$output = fopen("php://output", "w");
		fputcsv($output, array('Category',
			'Item Name',
			'Added Date',
			'Stock'
		));

		$idSelected = $this->input->post('txt_id_selected');
		$idSelected = explode(',', $idSelected);
		$idSelected = implode('","', $idSelected);
		$idSelected = '"'.$idSelected.'"';

		$strSql   = "SELECT sub_category.sub_category_name, sub_category.regidate, category.catalog_name, 
		(SELECT count(warehouse.warehouse_id) FROM warehouse WHERE warehouse.admin_id = '".$this->sess_cus['admin_refer_id']."' AND warehouse.sub_category_id = sub_category.sub_category_id) AS total ";
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
				fputcsv($output, $item);
			}
			fclose($output);
		}
		die();
	}

	public function getDataCategory(){
		$data = array();

		$filter = $this->input->post('category_type');
		if(!empty($filter) && $filter != 'all'){
			$this->db->where('category.category_id', $filter);
		}

		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('category.category_id', $this->idInventory);
		$this->db->join('category', array('category.category_id' => 'sub_category.category_id'),'','left');
		$this->db->orderby('sub_category.sub_category_name', 'ASC');
		$dataCategory = $this->db->get('sub_category')->result_array(false);

		if(!empty($dataCategory)){
			foreach ($dataCategory as $key => $value) {
				$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
				$this->db->where('sub_category_id', $value['sub_category_id']);
				$result = $this->db->get('warehouse')->count();

				$color  = 'cl-orange';
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

	public function getEditCategory(){

		$template = new View('wh_category/frmCategory');
		
		$id       = $this->input->post('id');
		$title    = 'Edit Category';

		$this->db->where('sub_category_id', $id);
		$dataSubCategory = $this->db->get('sub_category')->result_array(false);

		$data = !empty($dataSubCategory)?$dataSubCategory[0]:'';

		$template->set(array(
			'title'        => $title,
			'data'         => $data,
		));

		$template->render(true);
		die();

	}

	public function category(){
		$this->template->content = new View('wh_category/category');
		$this->template->jsKiosk = new View('wh_category/jsCategory');
		$this->template->content->set(
			array(
				'data' => '',
		));
	}

	/* =============== END CATEGORY ==============================================================================================*/

	public function delete($type = ""){

		die();
	}
}