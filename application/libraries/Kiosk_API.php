<?php
	class Kiosk_API_Core {
		public $host;
	   	public function __construct(){  
	   	}

	   	private function callAPI($param='', $router = '', $method = 'post'){
			$ch  = curl_init($this->host.$router);
			// Thiết lập có return
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			if($method == 'post'){
				// Thiết lập sử dụng POST
				curl_setopt($ch, CURLOPT_POST, count($param));

				// Thiết lập các dữ liệu gửi đi
				curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
			}

			$result = curl_exec($ch);

			curl_close($ch);
	 
			return $result;
		}

		public function callAPIJSON($param = '', $router = '', $method = 'post'){
			$data_string = json_encode($param);
			$ch          = curl_init($this->host.$router);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			if($method == 'post'){
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				    'Content-Type: application/json',
				    'Content-Length: ' . strlen($data_string))
				);
			}                                                                                                        
			$result = curl_exec($ch);

			curl_close($ch);
			return json_decode($result, true);
		}

		public function importCSV($param = '', $method = 'post'){
	   		$data = array(
				'files_id'   => '',
				'store_id'   => ''
			);
			$data   = array_merge($data, $param);
			$router = 'import/csv';
	   		return $this->callAPIJSON($data, $router, $method);
	   	}

	   	public function sendImg($param = '',$method = 'post'){
	   		$data = array(
				'store_id'   => '',
				'uploadfile' => ''
			);
			$data   = array_merge($data, $param);
			$router = 'files/up';
	   		return $this->callAPI($data, $router, $method);
	   	}

	   	public function getInventoryGroup($param = '', $method = 'post'){
	   		$data = array(
				'admin_id'   => '',
				'store_id'   => '',
				'expire_day' => ''
			);
			$data   = array_merge($data, $param);
			$router = 'inventory/group';
	   		return $this->callAPIJSON($data, $router, $method);
	   	}

	   	public function getMenuAvailable($param = '', $method = 'post'){
	   		$data = array(
				'store_id'    => '',
				'menu_id'     => '',
				'orderByWith' => 'ASC',
				'orderBy'     => 'QuantityAgain'
			);

			$data   = array_merge($data, $param);
			$router = 'ingredient/available-list';
	   		return $this->callAPIJSON($data, $router, $method);
	   	}

	   	public function getInventory($param = '', $method = 'post'){
	   		$data = array(
				'store_id' => '',
				'admin_id' => '',
				'search'   => ''
			);

			$data   = array_merge($data, $param);
			$router = 'inventory/list';
	   		return $this->callAPIJSON($data, $router, $method);
	   	}

	   	public function totalOptionMenu($param = '', $method = 'post'){
	   		$data = array(
				'menu_id' => ''
			);

			$data   = array_merge($data, $param);
			$router = 'menu-option/total';
	   		return $this->callAPIJSON($data, $router, $method);
	   	}
	}
?>