<?php
class Home_Controller extends Template_Controller {
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
		$this->order_model = new Order_Model();
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
	} 
    
	public function index(){
		$type = $this->input->post('txt_type');
		$type = !empty($type)?$type:'today';

		$storeId = $this->input->post('slt_store_active');
		if(!empty($storeId)){
			$this->_setStoreUsing($storeId);
		}
		$this->dashboard($type);
	}

	public function gotoStore($id){
		if((string)$this->sess_cus['admin_level'] == '1'){
			if($id == 'QWRkbWluaXN0cmF0b3I='){
				/* login Addministrator */
				$data  = array();
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
				die();
			}else{
				$this->db->where('store_id', $id);
				$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
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
		}
		url::redirect('/');
		die();
	}

	public function convert_from_another_time($source, $type = 'l', $dest_timezone = 0){
		$hms             = explode(":", $this->mTimeZone);
		$source_timezone = (int)((((int)$hms[0] < 0)?'-':'+').(abs($hms[0]) + ($hms[1]/60)));
		$source          = new DateTime($source);
		switch ($type) {
			case 's': // Convert Server -> Client
				$offset  = $dest_timezone - $source_timezone;
				break;
			
			default: // Convert Server <- Client
				$offset  = $source_timezone - $dest_timezone;
				break;
		}
	    if($offset == 0)
	        return $source->format('Y-m-d H:i:s');
		$target  = new DateTime($source->format('Y-m-d H:i:s'));
		$minutes = floor($offset) * 60 + round(60*($offset - floor($offset)));
	    $target->modify($minutes." minutes");
	    return $target->format('Y-m-d H:i:s');
	}

	public function dashboard($type = 'today'){
		$this->template->content = new View('/dashboard/index');
		$this->template->jsKiosk = new View('/dashboard/indexJS');

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

		$this->setTaxStore($storeId);
		
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
		$userChart        = array();
		
		$dataWeek         = array();
		$dataTransations  = array();
		$dataCustomer     = array();
		$dataFormat       = 'm/d/Y';
		switch ($type) {
			case 'week' :
				$today           = date('m/d/Y');
				$week            = $this->week_from_sunday($today);
				
				/* API listOrderRange */
				$this->db->where('store_id', $storeId);
				$this->db->where('DATE(regidate) BETWEEN \''.date('Y-m-d', strtotime($week[0])).'\' AND \''.date('Y-m-d', strtotime($week[6])).'\'');
				$this->db->where('order_num IS NOT NULL');
				$this->db->orderby('regidate', 'asc');
				$data = $this->db->get('order')->result_array(false);

				/* API listUserRange */
				$this->db->where('store_id', $storeId);
				$this->db->where('DATE(regidate) BETWEEN \''.date('Y-m-d', strtotime($week[0])).'\' AND \''.date('Y-m-d', strtotime($week[6])).'\'');
				$this->db->orderby('regidate', 'asc');
				$dataUser = $this->db->get('user')->result_array(false);

				$dataFormat = 'm/d/Y';
				break;
			case 'month':
				$month           = date('m');
				$year            = date('Y');

				/* API listOrderMonth */
				$this->db->where('store_id', $storeId);
				$this->db->where('MONTH(regidate) = \''.$month.'\' AND YEAR(regidate) = \''.$year.'\'');
				$this->db->where('order_num IS NOT NULL');
				$this->db->orderby('regidate', 'asc');
				$data = $this->db->get('order')->result_array(false);
				
				/* API listUserMonth */
				$this->db->where('store_id', $storeId);
				$this->db->where('MONTH(regidate) = \''.$month.'\' AND YEAR(regidate) = \''.$year.'\'');
				$this->db->orderby('regidate', 'asc');
				$dataUser = $this->db->get('user')->result_array(false);

				$dataFormat = 'm/d/Y';
				break;
			case 'range':
				$dateTo          = $this->input->post('txt_date_to');
				$dateFrom        = $this->input->post('txt_date_from');
				$today           = date('m/d/Y');

				/* API listOrderRange */
				$this->db->where('store_id', $storeId);
				$this->db->where('DATE(regidate) BETWEEN \''.date('Y-m-d', strtotime($dateFrom)).'\' AND \''.date('Y-m-d', strtotime($dateTo)).'\'');
				$this->db->where('order_num IS NOT NULL');
				$this->db->orderby('regidate', 'asc');
				$data = $this->db->get('order')->result_array(false);

				/* API listUserRange */
				$this->db->where('store_id', $storeId);
				$this->db->where('DATE(regidate) BETWEEN \''.date('Y-m-d', strtotime($dateFrom)).'\' AND \''.date('Y-m-d', strtotime($dateTo)).'\'');
				$this->db->orderby('regidate', 'asc');
				$dataUser = $this->db->get('user')->result_array(false);

				$dataFormat = 'm/d/Y';
				break;
			default:
				$today = date('Y-m-d');
    			
				/* API listOrderToday */
				$this->db->where('store_id', $storeId);
				$this->db->where('DATE(regidate) = \''.$today.'\'');
				$this->db->where('order_num IS NOT NULL');
				$this->db->orderby('regidate', 'asc');
				$data = $this->db->get('order')->result_array(false);
				
				/* API listUserToday */
				$this->db->where('store_id', $storeId);
				$this->db->where('DATE(regidate) = \''.$today.'\'');
				$this->db->orderby('regidate', 'asc');
				$dataUser   = $this->db->get('user')->result_array(false);
				$dataFormat = 'H:i';
				break;
		}

		if(!empty($data)){
			$totalCash    = (float)array_sum(array_column($data, 'cash'));
			$totalCard    = (float)array_sum(array_column($data, 'card'));
			$totalPoint   = (float)array_sum(array_column($data, 'points'));
			$totalTax     = (float)array_sum(array_column($data, 'tax'));
			//$totalSales = (float)array_sum(array_column($data, 'price'));
			$totalSales   = $totalCash + $totalCard + $totalPoint;
			$transations  = count($data);
			foreach ($data as $key => $value) {
				$regidate = date($dataFormat, strtotime($this->convert_from_another_time($value['regidate'])));

				$dataSales[$regidate]       = (isset($dataSales[$regidate])?$dataSales[$regidate]:0) + ((float)$value['price'] + (float)$value['tax']);
				$dataTransations[$regidate] = (isset($dataTransations[$regidate])?$dataTransations[$regidate]:0) + 1;
			}

			foreach ($dataSales as $key => $value) {
				$salesChart[] = array($key, number_format((float)$value, 2, '.', ''));
			}

			foreach ($dataTransations as $key => $value) {
				$transationsChart[] = array($key, $value);
			}
		}

		if(!empty($dataUser)){
			foreach ($dataUser as $key => $value) {
				$regidate                = date($dataFormat, strtotime($this->convert_from_another_time($value['regidate'])));
				$dataCustomer[$regidate] = (isset($dataCustomer[$regidate])?$dataCustomer[$regidate]:0) + 1;
			}

			foreach ($dataCustomer as $key => $value) {
				$custommerChart[] = array($key, $value);
			}
		}

		$result['totalCash']   = $totalCash;
		$result['totalCard']   = $totalCard;
		$result['totalPoint']  = $totalPoint;
		$result['totalTax']    = $totalTax;
		$result['totalSales']  = $totalSales;
		$result['transations'] = $transations;
		$result['totalUser']   = !empty($dataUser)?count($dataUser):0;
		$result['type']        = $type;
		$result['dateFrom']    = !empty($dateFrom)?$dateFrom:date('m/d/Y');
		$result['dateTo']      = !empty($dateTo)?$dateTo:date('m/d/Y');


		$this->template->content->set(array(
			'listData'  => $result,
			'listStore' => !empty($listStore)?$listStore:''
		));

		$this->template->jsKiosk->set(array(
			'salesChart'       => json_encode($salesChart),
			'transationsChart' => json_encode($transationsChart),
			'custommerChart'   => json_encode($custommerChart),
			'typeDate'         => $type
		));
	}	

	public function setlanguages($languages='en_US'){
		$_arrLang               = array('en_US', 'ko_KR');
		if(!in_array($languages, $_arrLang))
			$languages = 'en_US';
		$_sessData              = $this->sess_cus;
		$_sessData['lang_code'] = $languages;
		$this->session->set('sess_cus', $_sessData);

		$_linkBack = !empty($this->sess_his_client->back)?$this->sess_his_client->back:'/';
		url::redirect($_linkBack);
	}

	
}
?>