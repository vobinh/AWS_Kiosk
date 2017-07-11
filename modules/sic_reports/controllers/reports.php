<?php
class Reports_Controller extends Template_Controller {
	
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

	public function setStore($storeId, $type=''){
		$this->_setStoreUsing($storeId);
		if(empty($type))
			url::redirect('reports');
		else{
			switch ($type) {
				case 1:
					url::redirect('reports');
					break;
				case 2:
					url::redirect('reports/sales_reports');
					break;
				case 3:
					url::redirect('reports/products_services/today');
					break;
				case 4:
					url::redirect('reports/customers/today');
					break;
				default:
					url::redirect('reports');
					break;
			}
			
		}
		die();
	}

	public function index(){
		$this->overview();
	}

	public function overview(){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['reports_summary'], 0, 1) == '0')){
			$this->template->content = new View('Summary/index');
		}else{
			$this->template->content = new View('Summary/index');
			$this->template->jsKiosk = new View('Summary/js_summary');
			
			$storeId = base64_decode($this->sess_cus['storeId']);
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

			$totalCash        = 0;
			$totalCard        = 0;
			$totalPoint       = 0;
			$totalTax         = 0;
			$totalSales       = 0;
			$transations      = 0;
			$result           = array();

			$salesChart       = array();
			$transationsChart = array();
			$dataTransations  = array();
			$productChart     = array();
			
			$dataProdusts     = array();

			$today = date('Y-m-d');
			/* API listOrderToday */
			$this->db->where('store_id', $storeId);
			$this->db->where('DATE(regidate) = \''.$today.'\'');
			$this->db->where('order_num IS NOT NULL');
			$this->db->orderby('regidate', 'asc');
			$data = $this->db->get('order')->result_array(false);

			if(!empty($data)){
				$totalCash    = (float)array_sum(array_column($data, 'cash'));
				$totalCard    = (float)array_sum(array_column($data, 'card'));
				$totalPoint   = (float)array_sum(array_column($data, 'points'));
				$totalTax     = (float)array_sum(array_column($data, 'tax'));
				//$totalSales = (float)array_sum(array_column($data, 'price'));
				$totalSales   = $totalCash + $totalCard + $totalPoint;
				$transations  = count($data);
				foreach ($data as $key => $value) {
					$regidate     = date('H:i',strtotime($value['regidate']));
					$salesChart[] = array(
						date('H:i',strtotime($value['regidate'])),
						number_format($value['price'], 2, '.', '')
					);
					$dataTransations[$regidate] = (isset($dataTransations[$regidate])?$dataTransations[$regidate]:0) + 1;

					/* API listOrderDetail */
					$this->db->select('order_detail.menu_id, sum(quantity) as sl, menu.m_item');
					$this->db->where('order_id', $value['order_id']);
					$this->db->join('menu', array('menu.menu_id' => 'order_detail.menu_id'));
					$this->db->groupby('menu_id');
					$details = $this->db->get('order_detail')->result_array(false);
					if(!empty($details)){
						foreach ($details as $key => $value) {
							$dataProdusts[$value['m_item']] = (!empty($dataProdusts[$value['m_item']])?$dataProdusts[$value['m_item']]:0) + $value['sl'];
						}
						
					}
				}
				foreach ($dataTransations as $key => $value) {
					$transationsChart[] = array( $key, $value);
				}
			}
			
			$result['totalCash']   = $totalCash;
			$result['totalCard']   = $totalCard;
			$result['totalPoint']  = $totalPoint;
			$result['totalTax']    = $totalTax;
			$result['totalSales']  = $totalSales;
			$result['transations'] = $transations;

			if(!empty($dataProdusts)){
				arsort($dataProdusts);
				foreach ($dataProdusts as $key => $value) {
			      	$productChart[] = array('label' => $key, 'data' => $value);
			    }
			}

			$this->template->content->set(array(
				'listData'     => $result,
				'listProducst' => $dataProdusts,
				'listStore'    => !empty($listStore)?$listStore:''
			));

			$this->template->jsKiosk->set(array(
				'salesChart'       => json_encode($salesChart),
				'transationsChart' => json_encode($transationsChart),
				'productChart'     => json_encode($productChart)
			));
		}
	}	

	public function sales_reports($date = ""){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['reports_sales'], 0, 1) == '0')){
			$this->template->content = new View('Sales_Reports/index');
		}else{
			$this->template->content = new View('Sales_Reports/index');
			$this->template->jsKiosk = new View('Sales_Reports/js_sales_report');

			$storeId = base64_decode($this->sess_cus['storeId']);
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

			$usingCustomers  = array();
			$usingEmployees  = array();
			
			$usingPayment    = array('cash', 'card', 'points');
			$usingType       = '1';
			$usingDateType   = 'day';
			$usingDateSelect = '7-days';
			
			$usingDate       = array();
			$usingTax        = array();
			$arrData         = array();
			$arrAccount      = array();
			
			$toDay           = date('Y-m-d');
			$dateTo          = date('Y-m-d');
			$dateFrom        = date('Y-m-d', strtotime($dateTo.' -7 day'));

			/* Get Customer using filter and list display */
			$this->db->select('user.user_id, account.account_id, account.account_first_name, account.name');
			$this->db->where('store_id', $storeId);
			$this->db->where('account.status', 1);
			$this->db->join('account', array('account.account_id' => 'user.account_id'));
			$listCustomers = $this->db->get('user')->result_array(false);
			
			if(!empty($listCustomers)){
				$usingCustomers = array_column($listCustomers, 'user_id');
			}

			if(isset($_POST) && !empty($_POST)){
				$usingType       = $this->input->post('txt_name_type');
				$usingDateType   = $this->input->post('txt_hd_type');
				$usingDateSelect = $this->input->post('txt_hd_date');
				$usingPayment    = $this->input->post('txt_payment');
			}

			$result = array();
			$filter = array();
			if($usingDateType == 'day'){
				switch ($usingDateSelect) {
					case '14-days':
						$dateTo   = $toDay;
						$dateFrom = date('Y-m-d', strtotime($dateTo.' -14 day'));
						break;
					case '30-days':
						$dateTo   = $toDay;
						$dateFrom = date('Y-m-d', strtotime($dateTo.' -30 day'));
						break;
					case '6-months':
						$dateTo   = $toDay;
						$dateFrom = date('Y-m-d', strtotime($dateTo.' -6 month'));
						break;
					case 'week-to-date':
						$dateTo        = $toDay;
						$day           = date('w');
						$dateFrom = date('Y-m-d', strtotime('-'.$day.' days'));
						break;
					case 'month-to-date':
						$dateTo   = $toDay;
						$dateFrom = date('Y-m-d', strtotime('first day of this month', time()));
						break;
					case 'year-to-date':
						$dateTo   = $toDay;
						$dateFrom = date('Y-m-d', strtotime('first day of January', time()));
						break;
					default:
						$dateTo   = $toDay;
						$dateFrom = date('Y-m-d', strtotime($dateTo.' -7 day'));
						break;
				}
			}else{
				$dateTo   = date('Y-m-d', strtotime($this->input->post('txt_date_to')));
				$dateFrom = date('Y-m-d', strtotime($this->input->post('txt_date_from')));
			}
			
			if(!empty($usingCustomers)){
				//$this->db->in('user_id', $usingCustomers);
			}
			if(!empty($usingPayment)){
				//$this->db->select('order.*, account.account_first_name, account.name, user.account_id');
				$strPayment = '';
				$slPayment  = count($usingPayment);
				if($slPayment < 2){
					$strPayment .= $usingPayment[0].' > 0';
				}else{
					foreach ($usingPayment as $vtPayment => $itemPayment) {
						if($vtPayment == 0)
							$strPayment .= '(order.'.$itemPayment.' > 0';
						elseif($vtPayment == ($slPayment - 1))
							$strPayment .= ' OR order.'.$itemPayment.' > 0)';
						else
							$strPayment .= ' OR order.'.$itemPayment.' > 0';
					}
				}
				/* API listOrderReport */
				$this->db->where($strPayment);
				$this->db->where('order.store_id', $storeId);
				$this->db->where('DATE(order.regidate) BETWEEN \''.date('Y-m-d', strtotime($dateFrom)).'\' AND \''.date('Y-m-d', strtotime($dateTo)).'\'');
				$this->db->where('order.order_num IS NOT NULL');
				$this->db->orderby('order.regidate', 'asc');
				//$this->db->join('user', array('user.user_id' => 'order.user_id'),'','left');
				//$this->db->join('account', array('account.account_id' => 'user.account_id'),'','left');
				$data = $this->db->get('order')->result_array(false);
			}else{
				$data = array();
			}
			
			
			if(!empty($listCustomers)){
				$arrAccount = array_column($listCustomers, 'user_id');
			}
			
			if(!empty($data)){
				foreach ($data as $key => $value) {

					$regidate   = date('m/d/Y',strtotime($value['regidate']));
					$keyAccount = array_search($value['user_id'], $arrAccount);

					if(!in_array($regidate,$usingDate)){
						$usingDate[] = $regidate;
					}

					$usingTax[$regidate] = (!empty($usingTax[$regidate])?$usingTax[$regidate]:0) + $value['tax'];

					$typeName = 'sub_category_name';
					$orderId  = $value['order_id'];
					switch ($usingType) {
						case '2':
							/* API listMenuOrderByGroupId */
							$this->db->select('sum(order_detail.quantity) as totalQuantity, sum(order_detail.price) as totalPrice, order_detail.menu_name');
							$this->db->where('order_id', $orderId);
							$this->db->groupby('order_detail.menu_id');
							$this->db->groupby('order_detail.menu_name');
							$details  = $this->db->get('order_detail')->result_array(false);

							/* API listMenuOrderOptionByGroupId */
							$this->db->select('sum(order_option.quantity) as totalQuantity, sum(order_option.price) as totalPrice, order_option.menu_name');
							$this->db->where('order_id', $orderId);
							$this->db->groupby('order_option.menu_id');
							$this->db->groupby('order_option.menu_name');
							$optionDetails = $this->db->get('order_option')->result_array(false);

							$typeName = 'menu_name';
							break;
						
						default:
							/* API listSubMenuOrderByGroupId */
							$this->db->select('sum(order_detail.quantity) as totalQuantity, sum(order_detail.price) as totalPrice, menu.sub_category_id, sub_category.sub_category_name');
							$this->db->where('order_id', $orderId);
							$this->db->join('menu', array('menu.menu_id' => 'order_detail.menu_id'));
							$this->db->join('sub_category', array('sub_category.sub_category_id' => 'menu.sub_category_id'));
							$this->db->groupby('sub_category.sub_category_id');
							$details  = $this->db->get('order_detail')->result_array(false);

							/* API listSubMenuOrderOptionByGroupId */
							$this->db->select('sum(quantity) as totalQuantity, sum(order_option.price) as totalPrice, menu.sub_category_id, sub_category.sub_category_name');
							$this->db->where('order_id', $orderId);
							$this->db->join('menu', array('menu.menu_id' => 'order_option.menu_id'));
							$this->db->join('sub_category', array('sub_category.sub_category_id' => 'menu.sub_category_id'));
							$this->db->groupby('sub_category.sub_category_id');
							$optionDetails = $this->db->get('order_option')->result_array(false);
							$typeName = 'sub_category_name';
							break;
					}

					if(!empty($details)){
						foreach ($details as $vtDetail => $itemDetail) {
							$dataProdusts[$itemDetail[$typeName]][$regidate]['totalQuantity'] = (!empty($dataProdusts[$itemDetail[$typeName]][$regidate]['totalQuantity'])?$dataProdusts[$itemDetail[$typeName]][$regidate]['totalQuantity']:0) + $itemDetail['totalQuantity'];
							$dataProdusts[$itemDetail[$typeName]][$regidate]['totalPrice']    = (!empty($dataProdusts[$itemDetail[$typeName]][$regidate]['totalPrice'])?$dataProdusts[$itemDetail[$typeName]][$regidate]['totalPrice']:0) + $itemDetail['totalPrice'];
							$dataProdusts[$itemDetail[$typeName]][$regidate][$typeName]       = $itemDetail[$typeName];
						}
						
					}

					if(!empty($optionDetails)){
						foreach ($optionDetails as $vtOption => $itemOption) {
							$dataProdusts[$itemOption[$typeName]][$regidate]['totalQuantity'] = (!empty($dataProdusts[$itemOption[$typeName]][$regidate]['totalQuantity'])?$dataProdusts[$itemOption[$typeName]][$regidate]['totalQuantity']:0) + $itemOption['totalQuantity'];
							$dataProdusts[$itemOption[$typeName]][$regidate]['totalPrice']    = (!empty($dataProdusts[$itemOption[$typeName]][$regidate]['totalPrice'])?$dataProdusts[$itemOption[$typeName]][$regidate]['totalPrice']:0) + $itemOption['totalPrice'];
							$dataProdusts[$itemOption[$typeName]][$regidate][$typeName]       = $itemOption[$typeName];
						}
						
					}

					if($keyAccount >= 0 && !empty($listCustomers)){
						$_name = $listCustomers[$keyAccount]['account_first_name'].' '.$listCustomers[$keyAccount]['name'];
						$data[$key]['nameAccount'] = $_name;
					}else{
						$data[$key]['nameAccount'] = '';
					}
				}
				
				$arrSub  = array();
				if(!empty($dataProdusts)){
					foreach ($dataProdusts as $key => $value) {
						$arrTemp = array();
						foreach ($usingDate as $vt => $item) {
							if(empty($value[$item])){
								$arrTemp[$vt] = array(
									'date'              => $item,
									'sub_category_name' => $key,
									'totalQuantity'     => 0,
									'totalPrice'        => 0
								);
							}else{
								$value[$item]['date'] = $item;
								$arrTemp[$vt] = $value[$item];
							}
						}
						$arrData[$key] = $arrTemp;
					}
				}

			}
			
			$dataChart       = array();
			$dataChartGraphs = array();
			$flagGraphs      = true;
			foreach ($usingDate as $vt => $itemDate) {
				$_arrTemp = array();
				$_arrTemp['category'] = $itemDate;
				foreach ($arrData as $sl => $item) {
					$nameAccount = trim($sl);
					$_arrTemp[$nameAccount] = number_format($item[$vt]['totalPrice'],2,'.','');
					if($flagGraphs){
						$dataChartGraphs[] = array(
							'fillAlphas' => 1,
							'title'      => $nameAccount,
							'type'       => 'column',
							'valueField' => $nameAccount
						);
					}
				}
				$flagGraphs  = false;
				$dataChart[] = $_arrTemp;	
			}

			//echo kohana::Debug($usingTax);
			$result['listCustomers']  = $listCustomers;
			$result['usingCustomers'] = $usingCustomers;
			$result['usingPayment']   = $usingPayment;
			$result['dataRevenue']    = $arrData;
			$result['dataTax']        = $usingTax;
			$result['usingDate']      = $usingDate;
			$result['usingType']      = $usingType;
			$result['usingOrder']     = $data;

			$filter['dateFrom']        = !empty($dateFrom)?date('m/d/Y',strtotime($dateFrom)):date('m/d/Y');
			$filter['dateTo']          = !empty($dateTo)?date('m/d/Y',strtotime($dateTo)):date('m/d/Y');
			$filter['usingDateSelect'] = $usingDateSelect;
			$filter['usingDateType']   = $usingDateType;

			$this->template->content->set(array(
				'listData'       => $result,
				'listDataFilter' => $filter,
				'listStore'      => !empty($listStore)?$listStore:''
			));

			$this->template->jsKiosk->set(array(
				'revenueChart'       => json_encode($dataChart),
				'revenueChartGraphs' => json_encode($dataChartGraphs),
				'taxChart'           => json_encode($usingTax),
				'typeDate'           => $date
			));
		}
	}

	public function products_services($date){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['reports_products'], 0, 1) == '0')){
			$this->template->content = new View('Products_Services/index');
		}else{
			$this->template->content = new View('Products_Services/index');
			$this->template->jsKiosk = new View('Products_Services/js_products_services');
			$txt_date_from = ''; $txt_date_to = '';

			$storeId          = base64_decode($this->sess_cus['storeId']);
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

			$totalCash        = 0;
			$totalCard        = 0;
			$totalPoint       = 0;
			$totalTax         = 0;
			$totalSales       = 0;
			$transations      = 0;
			$result           = array();
			$salesChart       = array();
			$transationsChart = array();
			$custommerChart   = array();
			$dataProdusts     = array();
			switch ($date) {
				case 'week' :
					$today           = date('m/d/Y');
					$week            = $this->week_from_sunday($today);
					$dataWeek        = array();
					$dataTransations = array();

					/* API listOrderRange */
					$this->db->where('store_id', $storeId);
					$this->db->where('DATE(regidate) BETWEEN \''.date('Y-m-d', strtotime($week[0])).'\' AND \''.date('Y-m-d', strtotime($week[6])).'\'');
					$this->db->where('order_num IS NOT NULL');
					$this->db->orderby('regidate', 'asc');
					$data = $this->db->get('order')->result_array(false);
					break;
				case 'month':
					$month           = date('m');
					$year            = date('Y');
					$dataSales       = array();
					$dataTransations = array();

					/* API listOrderMonth */
					$this->db->where('store_id', $storeId);
					$this->db->where('MONTH(regidate) = \''.$month.'\' AND YEAR(regidate) = \''.$year.'\'');
					$this->db->where('order_num IS NOT NULL');
					$this->db->orderby('regidate', 'asc');
					$data = $this->db->get('order')->result_array(false);
					break;
				case 'selct_range':
					$dateTo   = $this->input->post('txt_date_to');
					$dateFrom = $this->input->post('txt_date_from');
					
					$dateFrom = !empty($dateFrom)?$dateFrom:date('m/d/Y');
					$dateTo   = !empty($dateTo)?$dateTo:date('m/d/Y');
					
					$today    = date('m/d/Y');
					
					/* API listOrderRange */
					$this->db->where('store_id', $storeId);
					$this->db->where('DATE(regidate) BETWEEN \''.date('Y-m-d', strtotime($dateFrom)).'\' AND \''.date('Y-m-d', strtotime($dateTo)).'\'');
					$this->db->where('order_num IS NOT NULL');
					$this->db->orderby('regidate', 'asc');
					$data = $this->db->get('order')->result_array(false);
					break;
				default:
					/* API listOrderToday */
					$today = date('Y-m-d');
					$this->db->where('store_id', $storeId);
					$this->db->where('DATE(regidate) = \''.$today.'\'');
					$this->db->where('order_num IS NOT NULL');
					$this->db->orderby('regidate', 'asc');
					$data = $this->db->get('order')->result_array(false);
					break;
			}
			foreach ($data as $key => $value) {
				$orderId = $value['order_id'];

				/* API listOrderDetail */
				$this->db->select('order_detail.menu_id, sum(quantity) as sl, menu.m_item');
				$this->db->where('order_id', $orderId);
				$this->db->join('menu', array('menu.menu_id' => 'order_detail.menu_id'));
				$this->db->groupby('menu_id');
				$details = $this->db->get('order_detail')->result_array(false);
				if(!empty($details)){
					foreach ($details as $key => $value) {
						$dataProdusts[$value['m_item']] = (!empty($dataProdusts[$value['m_item']])?$dataProdusts[$value['m_item']]:0) + $value['sl'];
					}
					
				}

				/* API listOrderDetailOption */
				$this->db->select('order_option.menu_id, sum(quantity) as sl, menu.m_item');
				$this->db->where('order_option.order_id', $orderId);
				$this->db->join('menu', array('menu.menu_id' => 'order_option.menu_id'));
				$this->db->groupby('menu_id');
				$optionDetails = $this->db->get('order_option')->result_array(false);
				if(!empty($optionDetails)){
					foreach ($optionDetails as $key => $value) {
						$dataProdusts[$value['m_item']] = (!empty($dataProdusts[$value['m_item']])?$dataProdusts[$value['m_item']]:0) + $value['sl'];
					}
					
				}
			}

			$result['dateFrom']    = !empty($dateFrom)?$dateFrom:date('m/d/Y');
			$result['dateTo']      = !empty($dateTo)?$dateTo:date('m/d/Y');

			//echo kohana::Debug($dataProdusts);
			$productChart = array();
			if(!empty($dataProdusts)){
				foreach ($dataProdusts as $key => $value) {
			      	$productChart[] = array('label' => $key, 'data' => $value);
			    }
			}
			$this->template->content->set(array(
				'listProduct'   => $dataProdusts,
				'txt_date_from' => !empty($dateFrom)?$dateFrom:date('m/d/Y'),
				'txt_date_to'   => !empty($dateTo)?$dateTo:date('m/d/Y'),
				'listStore'     => !empty($listStore)?$listStore:''
			));



			$this->template->jsKiosk->set(array(
				'productChart'   => json_encode($productChart)
			));
		}
	}

	public function customers($date){
		$this->template->content = new View('Customers/index');
		$this->template->jsKiosk = new View('Customers/js_customers');

		$txt_date_from = ''; 
		$txt_date_to   = ''; 
		$mType          = $date;
		$data          = array();
		$listData      = array();
		$dataChart     = array();
		$storeId       = base64_decode($this->sess_cus['storeId']);

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
		//echo $storeId;
		switch ($date) {
			case 'today':
				$today = date('Y-m-d');
				$this->db->select('order.user_id , sum(order.amount) as amount, count(order.user_id) as sl, order.store_id');
				$this->db->where('order.store_id', $storeId);
				$this->db->where('DATE(order.regidate) = \''.$today.'\'');
				$this->db->groupby('order.user_id');
				$data = $this->db->get('order')->result_array(false);
				break;
			case 'week':
				$today           = date('m/d/Y');
				$week            = $this->week_from_sunday($today);
				$dataWeek        = array();
				$dataTransations = array();
				$this->db->select('order.user_id , sum(order.amount) as amount, count(order.user_id) as sl, order.store_id');
				$this->db->where('order.store_id', $storeId);
				$this->db->where('DATE(order.regidate) BETWEEN \''.date('Y-m-d', strtotime($week[0])).'\' AND \''.date('Y-m-d', strtotime($week[6])).'\'');
				$this->db->groupby('order.user_id');
				$data = $this->db->get('order')->result_array(false);
				break;
			case 'month':
				$month           = date('m');
				$year            = date('Y');

				$this->db->select('order.user_id , sum(order.amount) as amount, count(order.user_id) as sl, order.store_id');
				$this->db->where('order.store_id', $storeId);
				$this->db->where('MONTH(order.regidate) = \''.$month.'\' AND YEAR(order.regidate) = \''.$year.'\'');
				$this->db->groupby('order.user_id');
				$data = $this->db->get('order')->result_array(false);
				break;
			default:
				$txt_date_from = !empty($_POST['txt_date_from'])?$_POST['txt_date_from']:'';
				$txt_date_to   = !empty($_POST['txt_date_to'])?$_POST['txt_date_to']:'';
				if(empty($txt_date_from))
					$txt_date_from = date('m/d/Y');
				if(empty($txt_date_to))
					$txt_date_to = date('m/d/Y');

				$this->db->select('order.user_id , sum(order.amount) as amount, count(order.user_id) as sl, order.store_id');
				$this->db->where('store_id', $storeId);
				$this->db->where('DATE(order.regidate) BETWEEN \''.date('Y-m-d', strtotime($txt_date_from)).'\' AND \''.date('Y-m-d', strtotime($txt_date_to)).'\'');
				$this->db->groupby('order.user_id');
				$data = $this->db->get('order')->result_array(false);
				break;
		}
		if(!empty($data)){
			foreach ($data as $key => $value) {
				$this->db->select("account.account_first_name, account.name");
				$this->db->where('user.user_id',$value['user_id']);
				$this->db->join('account', array('account.account_id' => 'user.account_id'));
				$result = $this->db->get('user')->result_array(false);
				if(!empty($result)){
					$arrItem    = array_merge($value, $result[0]);
					
					$name       = trim($result[0]['account_first_name'].' '.$result[0]['name']);
					$listData[] = $arrItem;
					$dataChart[] = array(
						'Name'  => $name,
						'Order' => $value['sl'],
						'Price' => !empty($value['amount'])?number_format($value['amount'], 2, '.',''):'0.00'
					);
				}
			}
		}
		//echo kohana::Debug($dataChart);

		$this->template->content->set(array(
			'txt_date_from' => $txt_date_from,
			'txt_date_to'   => $txt_date_to,
			'mType'         => $mType,
			'listData'      => $listData,
			'listStore'     => !empty($listStore)?$listStore:''
		));

		$this->template->jsKiosk->set(array(
			'dataChart'     => json_encode($dataChart),
			'mType'         => $mType,
			'txt_date_from' => $txt_date_from,
			'txt_date_to'   => $txt_date_to,
		));
	}

	public function getDetail(){
		$type     = $this->input->post('type');
		$userId   = $this->input->post('userId');
		$userName = trim($this->input->post('userName'));
		$dataFrom = $this->input->post('dataFrom');
		$dataTo   = $this->input->post('dataTo');
		switch ($type) {
			case 'today':
				$today = date('Y-m-d');
				$this->db->select('order_id, user_id, tax, amount, regidate');
				$this->db->where('order.user_id', $userId);
				$this->db->where('DATE(order.regidate) = \''.$today.'\'');
				$this->db->orderby('order.regidate', 'DESC');
				$data = $this->db->get('order')->result_array(false);
				break;
			case 'week':
				$today           = date('m/d/Y');
				$week            = $this->week_from_sunday($today);
				$dataWeek        = array();
				$dataTransations = array();
				$this->db->select('order_id, user_id, tax, amount, regidate');
				$this->db->where('order.user_id', $userId);
				$this->db->where('DATE(order.regidate) BETWEEN \''.date('Y-m-d', strtotime($week[0])).'\' AND \''.date('Y-m-d', strtotime($week[6])).'\'');
				$this->db->orderby('order.regidate', 'DESC');
				$data = $this->db->get('order')->result_array(false);
				break;
			case 'month':
				$month           = date('m');
				$year            = date('Y');

				$this->db->select('order_id, user_id, tax, amount, regidate');
				$this->db->where('order.user_id', $userId);
				$this->db->where('MONTH(order.regidate) = \''.$month.'\' AND YEAR(order.regidate) = \''.$year.'\'');
				$this->db->orderby('order.regidate', 'DESC');
				$data = $this->db->get('order')->result_array(false);
				break;
			default:
				$this->db->select('order_id, user_id, tax, amount, regidate');
				$this->db->where('order.user_id', $userId);
				$this->db->where('DATE(order.regidate) BETWEEN \''.date('Y-m-d', strtotime($dataFrom)).'\' AND \''.date('Y-m-d', strtotime($dataTo)).'\'');
				$this->db->orderby('order.regidate', 'DESC');
				$data = $this->db->get('order')->result_array(false);
				break;
		}

		$template = new View('Customers/listDetail');
		$title    = 'View Details';
		$template->set(array(
			'listData' => $data,
			'mType'    => $type,
			'dataFrom' => $dataFrom,
			'dataTo'   => $dataTo,
			'userName' => $userName
		));

		$template->render(true);
		die();
	}

	public function getDetailOrder(){
		$dataProdusts = array();
		$orderId      = $this->input->post('idOrder');
		$mainTax      = $this->input->post('mainTax');
		$mainTotal    = $this->input->post('mainTotal');
		$type         = $this->input->post('type');

		/* API listOrderById */
		$this->db->where('order_id', $orderId);
		$details = $this->db->get('order_detail')->result_array(false);
		if(!empty($details)){
			foreach ($details as $key => $value) {
				$dataProdusts[$value['menu_name']]['price']    = (!empty($dataProdusts[$value['menu_name']]['price'])?$dataProdusts[$value['menu_name']]['price']:0) + $value['price'];
				$dataProdusts[$value['menu_name']]['quantity'] = (!empty($dataProdusts[$value['menu_name']]['quantity'])?$dataProdusts[$value['menu_name']]['quantity']:0) + $value['quantity'];
			}
			
		}

		/* API listOrderOptionById */
		$this->db->where('order_option.order_id', $orderId);
		$optionDetails = $this->db->get('order_option')->result_array(false);
		if(!empty($optionDetails)){
			foreach ($optionDetails as $key => $value) {
				$dataProdusts[$value['menu_name']]['price']    = (!empty($dataProdusts[$value['menu_name']]['price'])?$dataProdusts[$value['menu_name']]['price']:0) + $value['price'];
				$dataProdusts[$value['menu_name']]['quantity'] = (!empty($dataProdusts[$value['menu_name']]['quantity'])?$dataProdusts[$value['menu_name']]['quantity']:0) + $value['quantity'];
			}
			
		}
		$template = new View('Customers/listDetailOrder');
		$template->set(array(
			'listData'  => $dataProdusts,
			'mainTax'   => $mainTax,
			'mainTotal' => $mainTotal,
			'type'      => $type
		));

		$template->render(true);
		die();
	}

	public function employees($date){
		$this->template->content = new View('Employees/index');
		$this->template->jsKiosk = new View('Employees/js_employees');
		$txt_date_from = ''; $txt_date_to = ''; $flag = '';
		if($date == 'today'){
			$flag = 'xu ly today Employees';
		}elseif($date == 'week'){
			$flag = 'xu ly week Employees';
		}elseif($date == 'month'){
			$flag = 'xu ly month Employees';
		}else{
			$txt_date_from = !empty($_POST['txt_date_from'])?$_POST['txt_date_from']:'';
			$txt_date_to = !empty($_POST['txt_date_to'])?$_POST['txt_date_to']:'';
			$flag = 'xu ly range Employees';
		}

		$this->template->content->txt_date_from = $txt_date_from;
		$this->template->content->txt_date_to = $txt_date_to;
		$this->template->content->flag = $flag;
	}

}
?>