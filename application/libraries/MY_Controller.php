<?php 
class Controller extends Controller_Core{
	public $db;			  // Database
	public $session;	  // Session
	public $site;		  // Site information
	public $mr              = array(); // one data record
	public $mlist;		  // list data records
	public $mPrivileges;
	public $mStore;
	public $mTimeZone       = '+00:00';
	public $clientTimeZone;
	public $warning         = '';
	public $idInventory     = 'aade5e56-ea11-4b5b-af93-f115d331f43e';
	public $idMenu          = 'a6ad4c5d-882a-4d1e-ad6b-1aa9c9425e1d';
	public $idOptions       = '38775fa0-f194-11e6-a5b5-e59f06b4bb28';
	public $hostUploadImg   = 'http://kiosk.dabotop.com:8080/files/up';
	public $hostGetImg      = 'http://kiosk.dabotop.com:8080/files/down';
	public $countOrder      = '';
	public $countStoreOrder = '';
	public $countWHOrder    = '';
	public $kioskAPI        = '';
    public function __construct(){
        parent::__construct();
		$this->db       = Database::instance();// init property db use Database
		$this->session  = Session::instance(); // init property session use Session
		/* 
			* init API 
			* @host
		*/
		$this->kioskAPI = new Kiosk_API_Core();
		$this->kioskAPI->host = 'http://kiosk.dabotop.com:8080/';
		
		/**
		 * int Email
		 * @emai : tomle@techknowledge.vn
		 */
		define('MasterEmail', 'tomle@techknowledge.vn');
		
		/**
		 * int client TimeZone
		 */

		$this->clientTimeZone = $this->session->get('mTimeZone');

		if (!function_exists('array_column')) {
			function array_column(array $input, $columnKey, $indexKey = null) {
		        $array = array();
		        foreach ($input as $value) {
		            if ( !array_key_exists($columnKey, $value)) {
		                trigger_error("Key \"$columnKey\" does not exist in array");
		                return false;
		            }
		            if (is_null($indexKey)) {
		                $array[] = $value[$columnKey];
		            }
		            else {
		                if ( !array_key_exists($indexKey, $value)) {
		                    trigger_error("Key \"$indexKey\" does not exist in array");
		                    return false;
		                }
		                if ( ! is_scalar($value[$indexKey])) {
		                    trigger_error("Key \"$indexKey\" does not contain scalar value");
		                    return false;
		                }
		                $array[$value[$indexKey]] = $value[$columnKey];
		            }
		        }
		        return $array;
		    }
		}

        // get site information, config, language
		$this->site                       = array();//$this->site_model->get();
		$this->site['languages'] = array(
			'en_US' => 'US', 
			'ko_KR' => 'Korea', 
		);
		$this->site['base_url']   = url::base();
		$this->site['theme_url']  = url::base().'themes/kiosk/';
		
		$this->site['site_title'] = 'Kiosk';
		$this->site['site_name']  = 'Kiosk';
        // Get search (keyword, curpage) from session if have  
		if ($this->session->get('sess_search')){
			$this->search = $this->session->get('sess_search');
			$this->session->set_flash('sess_search',$this->search);
		}else
      		$this->search = array('keyword' => '','cur_page' => '');        
        
        $cur_page = $this->uri->segment('page');
        if ($cur_page)
        	$this->search['cur_page'] = '/page/'.$cur_page;

        if(strpos($this->uri->segment(1),"admin") === false){ 
        	//init client
        	$this->site['config']['TEMPLATE'] ='kiosk';
			$this->site['version']   = "";
			$this->init_client();
		}else{	
			// init admin
			$this->site['config']['TEMPLATE'] ='admin';		
			$this->site['site_footer'] = "";
			$this->site['version']     = "";
			$this->init_admin();
		}
    }   
  	
  	public function setSessionOption(){
  		$arrOptions = array(
			'default_format' => 'CSV',
			'close_session'  => '15i',
			'language'       => 'en_US'
		);
		if(empty($this->sess_cus['default_format'])){
	  		if(!empty($this->sess_cus['admin_id'])){
	  			$this->db->where('admin_id', $this->sess_cus['admin_id']);
				$options = $this->db->get('options')->result_array(false);
				if(empty($options)){
					$arrOptions = array(
						'op_id'          => $this->getGUID(),
						'admin_id'       => $this->sess_cus['admin_id'],
						'default_format' => 'CSV',
						'close_session'  => '15i',
						'language'       => 'en_US',
						'time_zone'      => 'utc'
					);
					try {
						$result = $this->db->insert('options', $arrOptions);
					} catch (Exception $e) { }
				}else{
					$arrOptions = array(
						'default_format' => $options[0]['default_format'],
						'close_session'  => $options[0]['close_session'],
						'language'       => $options[0]['language'],
						'time_zone'      => $options[0]['time_zone']
					);
				}

				$_sessData = array_merge(
					$this->sess_cus,
					$arrOptions
				);
				$this->session->set('sess_cus', $_sessData);
			}
		}
  	}

	public function init_client(){
		date_default_timezone_set('UTC');
		$this->set_sess_history('customer');
		$this->set_sess_history('client');
		if ($this->session->get('sess_cus')){
			$this->sess_cus = $this->session->get('sess_cus');
			$this->setSessionOption();
			if(empty($this->sess_cus['language'])){
				$this->sess_cus['language'] = 'en_US';
				$this->session->set('sess_cus', $this->sess_cus);
			}
		}else{
			$this->sess_cus = array('language' => 'en_US');
			$this->session->set('sess_cus', $this->sess_cus);
		}

		Kohana::config_set('locale.language',$this->sess_cus['language']);
		$this->site['lang_id'] = $this->sess_cus['language'];

		if(isset($this->sess_cus['storeId'])){
			$checkTax = base64_decode($this->sess_cus['storeId']);
			if($checkTax != '0'){
				$this->_setStoreUsing($checkTax);
			}
			$sId = $this->_getStoreUsing();
			if(!empty($sId))
				$this->setTaxStore($sId);
		}

		$this->_initPrivileges();
		$this->_initStore();
		$this->_initTimeZone();
	}

	private function _initTimeZone(){
		$time_zone = !empty($this->sess_cus['time_zone'])?$this->sess_cus['time_zone']:'utc';
		switch ($time_zone) {
			case 'store':
				$mTime = !empty($this->mStore['time_zone'])?$this->mStore['time_zone']:'utc';
				$arr   = array(
					'Alaskan Standard Time'  => '-09:00',
					'Central Standard Time'  => '-06:00',
					'Eastern Standard Time'  => '-05:00',
					'Hawaiian Standard Time' => '-10:00',
					'Mountain Standard Time' => '-07:00',
					'Pacific Standard Time'  => '-08:00',
					'utc'                    => '+00:00'
				);
				$this->mTimeZone = $arr[$mTime];
				break;
			case 'client':
				$this->mTimeZone = $this->clientTimeZone;
				break;
			default:
				$this->mTimeZone = '+00:00';
				break;
		}
	}

	private function _initStore(){
		if(isset($this->sess_cus['admin_id'])){
			$storeId = $this->_getStoreUsing();
			if(!empty($storeId)){
				$this->db->where('admin_id', $this->sess_cus['admin_id']);
				$this->db->where('store_id', $storeId);
				$result = $this->db->get('store')->result_array(false);
				$this->mStore = !empty($result)?$result[0]:array();
			}
		}
	}

	private function _initPrivileges(){
		if(isset($this->sess_cus['admin_id'])){
			if((string)$this->sess_cus['admin_level'] == '2'){
				$this->db->where('admin_id', $this->sess_cus['admin_id']);
				$this->db->where('type', 2);
				$result = $this->db->get('privileges')->result_array(false);
				$this->mPrivileges = !empty($result)?$result[0]:'NoAccess';
			}else{
				$this->mPrivileges = 'FullAccess';
			}
		}
	}

	public function init_admin(){	
		date_default_timezone_set('UTC');
		$this->set_sess_history('admin');
		$this->set_sess_history('client');
		if ($this->session->get('sess_admin')){
			$this->sess_admin = $this->session->get('sess_admin');
			if(empty($this->sess_cus['language'])){
				$this->sess_admin['language'] = 'en_US';
				$this->session->set('sess_admin',$this->sess_admin);
			}
		}else{
			$this->sess_admin = array('language' => 'en_US');
			$this->session->set('sess_admin',$this->sess_admin);
		}

		Kohana::config_set('locale.language',$this->sess_admin['language']);
		$this->site['lang_id'] = $this->sess_admin['language'];

		/*if(empty($this->sess_admin['super_id'])){
			if($this->uri->segment(1) != "admin_login"){
				if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){    
					header('HTTP/1.1 302 Found', true, 302);
					die();
				}else
					url::redirect('admin_login');
			}
		}*/

		//echo Kohana::debug($this->sess_admin);		
	}  
	
	public function setTaxStore($storeId){
		$this->db->where('store_id', $storeId);
		$store = $this->db->get('store')->result_array(false);
		if(!empty($store) && empty($store[0]['s_tax'])){
			$this->session->set_flash('updateTax', 'updateTax');
		}
	}

	public function udate($format = 'u', $utimestamp = null) {
        if (is_null($utimestamp))
            $utimestamp = microtime(true);

        $timestamp = floor($utimestamp);
        $milliseconds = round(($utimestamp - $timestamp) * 1000000);

        return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
    }

	public function week_from_sunday($date) {
	    // Assuming $date is in format Y-m-d
	    list($month, $day, $year) = explode("/", $date);

	    // Get the weekday of the given date
	    $wkday = date('l',mktime('0','0','0', $month, $day, $year));

	    switch($wkday) {
			case 'Sunday': $numDaysToMon    = 0; break;
			case 'Monday': $numDaysToMon    = 1; break;
			case 'Tuesday': $numDaysToMon   = 2; break;
			case 'Wednesday': $numDaysToMon = 3; break;
			case 'Thursday': $numDaysToMon  = 4; break;
			case 'Friday': $numDaysToMon    = 5; break;
			case 'Saturday': $numDaysToMon  = 6; break;
	           
	    }

	    // Timestamp of the sunday for that week
	    $sunday = mktime('0','0','0', $month, $day-$numDaysToMon, $year);

	    $seconds_in_a_day = 86400;

	    // Get date for 7 days from sunday (inclusive)
	    for($i=0; $i<7; $i++)
	    {
	        $dates[$i] = date('m/d/Y',$sunday+($seconds_in_a_day*$i));
	    }

	    return $dates;
	}

	public function _setStoreUsing($storeId){
		$this->session->set('storeUsing', $storeId);
	}

	public function _getStoreUsing(){
		return $this->session->get('storeUsing');
	}

	public function crypt($password){
		$salt     = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		$salt     = sprintf("$2y$%02d$", 10) . $salt;
		return crypt($password, $salt);
	}

	public function getGUID(){
	    if (function_exists('com_create_guid')){
	        return com_create_guid();
	    }
	    else {
	        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
		        mt_rand( 0, 0xffff ),
		        mt_rand( 0, 0x0fff ) | 0x4000,
		        mt_rand( 0, 0x3fff ) | 0x8000,
		        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		    );
	    }
	}

	/* Client TimeZone */
	public function getClientTimeZone(){
		echo '<script type="text/javascript">
		var offset = new Date().getTimezoneOffset(), o = Math.abs(offset)
		document.write((offset < 0 ? "+" : "-") + ("00" + Math.floor(o / 60)).slice(-2) + ":" + ("00" + (o % 60)).slice(-2))
		</script>';
	}

	public function set_sess_history($type){		
		if ($this->session->get('sess_his_'.$type)){				
			$this->site['history'] = $this->session->get('sess_his_'.$type);
			if ($this->_check_url_valid($this->site['history']))
			{
				$this->site['history']['back'] = $this->site['history']['current'];
				$this->site['history']['current'] = url::current(true);
			}
			$this->session->set('sess_his_'.$type,$this->site['history']);
		}
		else
			$this->session->set('sess_his_'.$type, array('back' => url::current(true),'current' => url::current(true)));
	}
	
	public function get_admin_lang(){
		return $this->site['lang_id'];
	}
	
	public function get_client_lang(){
		return $this->site['lang_id'];
	} 
	
	private function _check_url_valid($history){
		$arr_invalid = array(			
			'save','delete','download','check_login','log_out','order',
			'viewaccount','update_account','calendar',
			'wrong_pid','block_page','restrict_access',
			'captcha'
		);
		
		if ($history['current'] == url::current(true))
			return FALSE;
		
		foreach ($arr_invalid as $value)
		{
			if (strpos(url::current(true),$value) !== FALSE) return FALSE;
		}
			
		return TRUE;
	}
	
	//Search focus
    public function format_focus_search($str_search,$str_format){
        $str_temp = substr($str_format,strpos($str_format,$str_search),strlen($str_search));
        return preg_replace('#(?!<.*)(?<!\w)(' .$str_search. ')(?!\w|[^<>]*(?:</s(?:cript|tyle))?>)#is'
        , '<span style="background-color:#FF6">'.$str_temp.'</span>'
        , $str_format);
    }
    
    public function get_thumbnail_size($path_image, $max_width = 300, $max_height = 150){
    	if (is_file($path_image) && file_exists($path_image))
    	{
			$image = new Image($path_image);    	
	    	
	    	if ($image->__get('width') > $image->__get('height'))
	    	{
	    		if ($image->__get('width') > $max_width && $max_width > 0) return "width='$max_width'";
	   		}
	   		else
	   		{
	   			if ($image->__get('height') > $max_height && $max_height > 0) return "height='$max_height'";  
			}
		}	
    }
    
    public function formatBytes($bytes, $precision = 2){
	    $units = array('B', 'KB', 'MB', 'GB', 'TB');
	  
	    $bytes = max($bytes, 0);
	    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
	    $pow = min($pow, count($units) - 1);
	  
	    $bytes /= pow(1024, $pow);
	  
	    return round($bytes, $precision) . ' ' . $units[$pow];
	}
	
	protected function warning_msg($messages){
		$this->template->content = new View('templates/'.$this->site['config']['TEMPLATE'].'/warning/index');
		
		switch ($messages)
		{
			case 'wrong_pid' :
				$msg = Kohana::lang('errormsg_lang.war_wrong_pid');
				break;
				
			case 'block_page' : 
				$msg = Kohana::lang('errormsg_lang.war_page_blocked');
				break;
				
			case 'restrict_access' :
		 		$msg = Kohana::lang('errormsg_lang.war_restrict_access');
		 		break;
		 		
 			case 'empty_search' :
 				$msg = Kohana::lang('errormsg_lang.msg_no_result');
 				break;
		 		
 			default : 
 				url::redirect('home');
 				die();
		}
		
		$this->template->content->msg = $msg;			
	}

	//Int date
	public function format_int_date($int_date,$str_format){
		if(!$int_date) return false;
		return date($str_format,$int_date);
	}

	//String date
	public function format_str_date($str_date,$str_format = 'Y/m/d',$str_sep='/',$h=0,$mi=0,$s=0){
		if(!$str_date) return false;
		
		$arr = explode($str_sep, $str_date);
			
		switch($str_format)
		{
			case 'Y/m/d':	list($y,$m,$d) = $arr;break;
			
			case 'm/d/Y':	list($m,$d,$y) = $arr;break;
			
			case 'n/j/Y':	list($m,$d,$y) = $arr;break;
			
			case 'd/m/Y':	list($d,$m,$y) = $arr;break;		
		}		
		return mktime($h,$mi,$s,$m,$d,$y);
	}

	public static function format_currency($val=0, $site_lang=1,$number=2){
		$f = '';
		//if(!$val) return false;
		if ($val<0)
		{
			$val = abs($val);
			$f = "- ";
		}
		//if(!$val) return false;		
		if($site_lang == 1){
			//format English
			return $f.'$'.number_format($val,$number,".",",");
		} elseif($site_lang == 2) {
			//format Vietnam
			return number_format($val,0,",",".").' VND';
		} elseif($site_lang == 3) {
			//format Korean
			return number_format($val,0,".",",").'&#50896;';
		} elseif($site_lang == 4){
			//format Japan
			return '¥'.number_format($val,0,".",",");		
		} else {
			return $val;
		}	
	}
}