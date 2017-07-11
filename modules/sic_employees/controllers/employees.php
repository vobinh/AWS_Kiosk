<?php
class Employees_Controller extends Template_Controller {
	
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

		$this->employee_model          = new Employee_Model();
		$this->employee_schedule_model = new Employee_schedule_Model();
		$this->store_model             = new Store_Model();
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
	/***********************# TIMECARD #********************************/
	public function listTimeCard($days = ''){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['employees_timecard'], 0, 1) == '0')){
			$this->template->content = new View('timecard/index');
		}else{
			$this->template->content = new View('timecard/index');
			$this->template->jsKiosk = new View('timecard/jsIndex');

			if($days == '' || empty($days))
				url::redirect('employees/listTimeCard/week');
			$_storeId = base64_decode($this->sess_cus['storeId']);
			if((string)$_storeId == '0'){
				$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
				$this->db->where('status', 1);
				$listStore = $this->store_model->get();
			}

			$txt_date_end     = $this->input->post('txt_date_end');
			$txt_date_to      = $this->input->post('txt_date_to');
			
			if(($txt_date_end != '' || !empty($txt_date_end)) && ($txt_date_to != '' || !empty($txt_date_to))){
				$date_to = $txt_date_to;
				$date_end = $txt_date_end;
			}else{
				$date_end = date('m/d/Y');
				if($days == 'week'){
					$date_to = date("m/d/Y", strtotime("-7 days"));
				}elseif($days == 'half_month'){
					$date_to = date("m/d/Y", strtotime("-14 days"));
				}else{
					$date_to = date("m/d/Y", strtotime("-30 days"));
				}
			}
			
			$this->template->content->set(array(
				'listStore' => !empty($listStore)?$listStore:'',
				'days'      => $days,
				'date_end'  => $date_end,
				'date_to'   => $date_to,
			));
		}
	}
	private function listDaysTimeCard($first, $last, $step = '+1 day', $output_format = 'm/d/Y' ) {
	    $dates = array();
	    $current = strtotime($first);
	    $last = strtotime($last);

	    while( $current <= $last ) {

	        $dates[] = date($output_format, $current);
	        $current = strtotime($step, $current);
	    }

	    return $dates;
	}
	public function getDataTimeCard(){
		$storeId      = base64_decode($this->sess_cus['storeId']);
		if((string)$storeId == '0')
			$storeId = $this->_getStoreUsing();
		
		$txt_date_end              = $this->input->post('txt_date_end');
		$txt_date_to               = $this->input->post('txt_date_to');

		$calendar                  = $this->getDaysTimeCard($txt_date_end,$txt_date_to);

		$records                   = array();
		$arr_data['data']          = array();
		$arr_columns['columns']    = array();
		$_data                     = array();

		$records['calendar']       = $calendar;

		$arr_columns['columns'][0] = array("title" => "<input type='checkbox' id='chk-all-timecard'>");
		$arr_columns['columns'][1] = array("title" => "Employees");

		$this->db->where('store_id', $storeId);
		$empl = $this->employee_model->get();

		if(!empty($empl)){
			$_today = date('m/d/Y');
			foreach ($empl as $key => $value) {
				$access_name = $value['first_name'].' '.$value['name'];
				$access_id   = $value['access_id'];

				$this->db->where('access_id',$value['access_id']);
				$ShedulingTimeCard = $this->db->get('employee_timecard')->result_array(false);  // API Name Is ShedulingTimeCard
				
				if(!empty($ShedulingTimeCard)){  // ACCESS HAVE VALUE IN EMPLOYEES TIME CARD

					$arr_data['data'][$key][0] = "<input class='item-select' type='checkbox' value='".$access_id."' name='chk_item[]'>";
					$arr_data['data'][$key][1] = $access_name;
					$j                      = 2;
					$TotalHoursSheduling    = 0;
					$TotalHoursWorked       = 0;

					foreach ($records['calendar']['listDays'] as $value_data) { 
						$day      = date('Y-m-d 00:00:00', strtotime($value_data));
					// GET TOTAL HOURS SHEDULING
						$timeDay_sheduling  = $this->getDayScheduling($value['access_id'], $day);
						if(!empty($timeDay_sheduling)){
							foreach ($timeDay_sheduling as $vt => $itemTime) {
								$_stare   = date_parse_from_format('Y-m-d H:i:s', $itemTime['start_time']);
								$_end     = date_parse_from_format('Y-m-d H:i:s', $itemTime['end_time']);
								
								$tsStare  = mktime($_stare['hour'], $_stare['minute'], $_stare['second'], $_stare['month'], $_stare['day'], $_stare['year']);
								$tsEnd    = mktime($_end['hour'], $_end['minute'], $_end['second'], $_end['month'], $_end['day'], $_end['year']);
								
								$distance = $tsEnd - $tsStare;
								$TotalHoursSheduling += round($distance/3600, 2);
							}
						}
					// END GET TOTAL HOURS SHEDULING

						$timeDay  = $this->getDLTimeCard($value['access_id'], $day); // API Name Is timeDay
						
					// GET TOTAL WORKED TIME CARD
						if(!empty($timeDay)){
							foreach ($timeDay as $vt => $itemTime_worked) {
								$_stare   = date_parse_from_format('Y-m-d H:i:s', $itemTime_worked['start_time']);
								$_end     = date_parse_from_format('Y-m-d H:i:s', $itemTime_worked['end_time']);
								
								$tsStare  = mktime($_stare['hour'], $_stare['minute'], $_stare['second'], $_stare['month'], $_stare['day'], $_stare['year']);
								$tsEnd    = mktime($_end['hour'], $_end['minute'], $_end['second'], $_end['month'], $_end['day'], $_end['year']);
								
								$distance = $tsEnd - $tsStare;
								$TotalHoursWorked += round($distance/3600, 2);
							}
						}
					// END GET TOTAL WORKED TIME CARD

					// FORMAT TODAY COLUMN
						$is_today = '';
						if((string)$value_data == (string)$_today)
							$is_today = 'cls-chk';
					// END FORMAT TODAY COLUMN

					// GET DATA 
						$timeTimeCard = '';
						if(!empty($timeDay)){
							foreach ($timeDay as $value_timeDay) {
								$start_time_timecard = date('H:i',strtotime($value_timeDay['start_time']));
								$end_time_timecard = date('H:i',strtotime($value_timeDay['end_time']));
								$timeTimeCard .= "<div>".$start_time_timecard." - ".$end_time_timecard."</div>";
							}
						}
						if(!empty($timeDay)){
							$arr_data['data'][$key][$j] = '<div onclick="TimeCard.openDay(\''.$value['access_id'].'\',\''.$value_data.'\')" class="scheduling '.$is_today.'">'.$timeTimeCard.'</div>';
						}else{
							$arr_data['data'][$key][$j] = '<button onclick="TimeCard.openDay(\''.$value['access_id'].'\',\''.$value_data.'\')"  class="btn btn-sm green '.$is_today.'"><i class="fa fa-plus"></i></button>';
						}
						
						$j++;
					// END GET DATA  
					}
					$arr_data['data'][$key][$j] = "<div>Sheduled: ".$TotalHoursSheduling."</div><div>Worked: ".$TotalHoursWorked."</div>";

                }else{ // ACCESS NO HAVE VALUE IN EMPLOYEES TIME CARD

					$arr_data['data'][$key][0] = "<input class='item-select' type='checkbox' value='".$access_id."' name='chk_item[]'>";
					$arr_data['data'][$key][1] = $access_name;
					$k                      = 2;
					$TotalHoursSheduling    = 0;
					$TotalHoursWorked       = 0;

					foreach ($records['calendar']['listDays'] as $value_data) { 
						// GET TOTAL HOURS SHEDULING
						$day_sheduling      = date('Y-m-d 00:00:00', strtotime($value_data));
						$timeDay_sheduling  = $this->getDayScheduling($value['access_id'], $day_sheduling);
						if(!empty($timeDay_sheduling)){
							foreach ($timeDay_sheduling as $vt => $itemTime) {
								$_stare   = date_parse_from_format('Y-m-d H:i:s', $itemTime['start_time']);
								$_end     = date_parse_from_format('Y-m-d H:i:s', $itemTime['end_time']);
								
								$tsStare  = mktime($_stare['hour'], $_stare['minute'], $_stare['second'], $_stare['month'], $_stare['day'], $_stare['year']);
								$tsEnd    = mktime($_end['hour'], $_end['minute'], $_end['second'], $_end['month'], $_end['day'], $_end['year']);
								
								$distance = $tsEnd - $tsStare;
								$TotalHoursSheduling += round($distance/3600, 2);
							}
						}
						// END GET TOTAL HOURS SHEDULING

						// FORMAT TODAY COLUMN
							$is_today = '';
							if((string)$value_data == (string)$_today)
								$is_today = 'cls-chk';
						// END FORMAT TODAY COLUMN

						$arr_data['data'][$key][$k] = '<button onclick="TimeCard.openDay(\''.$value['access_id'].'\',\''.$value_data.'\')" class="btn btn-sm green '.$is_today.'"><i class="fa fa-plus"></i></button>';
						$k++;
					}
					$arr_data['data'][$key][$k] = "<div>Sheduled: ".$TotalHoursSheduling."</div><div>Worked: ".$TotalHoursWorked."</div>";

                }    
			}
		}

		// GET COLUMN 
			$i = 2;
			if(!empty($records['calendar']['listFormat'])){	
				foreach ($records['calendar']['listFormat'] as $value_column) { 
					$arr_columns['columns'][$i] = array(
						"title" => $value_column,
	                ); 
	                $i++; 
				}
			}
			$arr_columns['columns'][$i] = array("title" => "Total Hours");
		// End GET COLUMN 

        $arr_memer = array_merge($arr_data,$arr_columns);
		echo  json_encode($arr_memer);
		die();
	}
	private function getDaysTimeCard($txt_date_end = '',$txt_date_to = ''){
		$listDays = $this->listDaysTimeCard($txt_date_to,$txt_date_end);
		$listFormat = array();
		$listDaysTimeCard = array();
		if(!empty($listDays)){
			foreach ($listDays as $key => $value) {
				$listFormat[] = date('D (m/d)', strtotime($value));
				$listDaysTimeCard[] = $value;
			}
		}

		$calendar = array(
			'listFormat' => $listFormat,
			'listDays' => $listDaysTimeCard,
		);
		return $calendar;
	}
	private function getDLTimeCard($idEmpl, $day){
		$day = date('Y-m-d',strtotime($day));
		$this->db->where('access_id', $idEmpl);
		$sql = "DATE_FORMAT(start_time,'%Y-%m-%d') = '".$day."'";
		$this->db->where($sql);
		$this->db->orderby('start_time', 'asc');
		$result = $this->db->get('employee_timecard')->result_array(false);
		return $result;
	}
	public function setStoreTimeCard(){
		$storeId = $this->input->post('storeId');
		$this->_setStoreUsing($storeId);
		exit();
	}
	public function getAddTimeCard(){
		$template = new View('timecard/frmTimeCard');
		$idEmpl   = $this->input->post('idEmpl');
		$workDay  = $this->input->post('day');
		$storeId = $this->input->post('storeId');

		$this->db->select('access_id, first_name, name');
		$empl     = $this->employee_model->get($idEmpl);
		if(!empty($empl)){
			$TimeCard = $this->getDLTimeCard($idEmpl,$workDay);
		}

		$this->db->where('store_id',$storeId);
		$this->db->where('m_status',1);
		$machine = $this->db->get('machine')->result_array(false);

		$title    = 'Manage Shifts';
		$template->set(array(
			'title'          => $title,
			'dataEmpl'       => !empty($empl)?$empl[0]:'',
			'dataTime'       => !empty($workDay)?$workDay:'',
			'TimeCard'       => !empty($TimeCard)?$TimeCard:'',
			'machine'        => !empty($machine)?$machine:''
		));
		$template->render(true);
		die();
	}
	public function saveTimeCard(){
		$emplId               = $this->input->post('txt_hd_empl');
		$workDay              = $this->input->post('txt_hd_day');
		$data                 = $this->input->post();

		$data_start_time      = array();

		if(!empty($emplId) && !empty($workDay)){
			if(!empty($data['txt_date_start']) && !empty($data['txt_date_end']) && !empty($data['txt_mechine_id'])){
				foreach ($data['txt_date_start'] as $key => $value) {
					$startTime = date('Y-m-d H:i:s',strtotime($workDay.' '.$value.':00'));
					$endTime   = date('Y-m-d H:i:s',strtotime($workDay.' '.$data['txt_date_end'][$key].':00'));
					$arrItem = array(
						'access_id'   => $emplId, 
						'machine_id'  => !empty($data['txt_mechine_id'][$key])?$data['txt_mechine_id'][$key]:'0',
						'start_time'  => $startTime, 
						'end_time'    => $endTime, 
						'update_time' => date('Y-m-d H:i:s'),
					);
					try {
						if(!empty($data['txt_hd_id'][$key]) || $data['txt_hd_id'][$key] != ''){
							$data_start_time[] = $data['txt_hd_id'][$key];
							unset($arrItem['access_id']);
							unset($arrItem['machine_id']);
							$this->db->where('access_id',$emplId);
							$this->db->where('start_time',$data['txt_hd_id'][$key]);
							$this->db->update('employee_timecard',$arrItem);          // API Name Is UpdateTimeCard
						}else{
							$data_start_time[] = $startTime;
							$this->db->insert('employee_timecard',$arrItem);          // API Name Is InsertTimeCard
						}
					} catch (Exception $e) {
						$arrMessage = false;
					}
				}
				
				// DELETE RECORD TIME USER WANT DELETE
				if(!empty($data_start_time)){
					$this->db->where('access_id', $emplId);
					$this->db->notin('start_time',$data_start_time);
					$sql = "DATE_FORMAT(start_time,'%m/%d/%Y') = '".$workDay."'";
					$this->db->where($sql);
					$arrDelete = $this->db->get('employee_timecard')->result_array(false);  // API Name Is arrDelete
					if(!empty($arrDelete)){
						foreach ($arrDelete as $value_arrDelete) {
							$this->db->where('access_id', $value_arrDelete['access_id']);
							$this->db->where('start_time',$value_arrDelete['start_time']);
							$this->db->delete('employee_timecard');                          // API Name Is DeleteDetailTimeCard
						}
					}
				}
				// END DELETE RECORD TIME USER WANT DELETE
			}else{
				$this->db->where('access_id', $emplId);
				$sql = "DATE_FORMAT(start_time,'%m/%d/%Y') = '".$workDay."'";
				$this->db->where($sql);
				$this->db->delete('employee_timecard');                             // API Name Is DeleteDetailTimeCard_ALL
			}
			
			$this->session->set_flash('success_msg', 'Changes saved.');
			$arrMessage = true;
		}else{
		    $this->session->set_flash('error_msg', 'Error Save.');
			$arrMessage = false;
		}
		echo $arrMessage;
		die();
	}
	public function PrevDayTimeCard(){
		$txt_date_end              = $this->input->post('txt_date_end');
		$txt_date_to               = $this->input->post('txt_date_to');

		$dStart = new DateTime($txt_date_to);
	   	$dEnd  = new DateTime($txt_date_end);
	   	$dDiff = $dStart->diff($dEnd);
	   	$number_day =  $dDiff->days;

	   	$date_end_prev = $txt_date_to;
	   	$date_to_prev = date('m/d/Y', strtotime("-".$number_day." day", strtotime($txt_date_to)));
	   	$arrDate = array(
	   		'date_to_prev' => $date_to_prev,
	   		'date_end_prev' => $date_end_prev,
	   	);
	   	echo json_encode($arrDate);
	   	exit();
	}
	public function NextDayTimeCard(){
		$txt_date_end              = $this->input->post('txt_date_end');
		$txt_date_to               = $this->input->post('txt_date_to');

		$dStart = new DateTime($txt_date_to);
	   	$dEnd  = new DateTime($txt_date_end);
	   	$dDiff = $dStart->diff($dEnd);
	   	$number_day =  $dDiff->days;

	   	$date_to_next = $txt_date_end;
	   	$date_end_next = date('m/d/Y', strtotime("+".$number_day." day", strtotime($txt_date_end)));

	   	$arrDate = array(
	   		'date_to_next' => $date_to_next,
	   		'date_end_next' => $date_end_next,
	   	);
	   	echo json_encode($arrDate);
	   	exit();
	}
	public function deleteTimecard(){
		$idEmpl       = $this->input->post('idEmpl');
		$txt_date_to  = $this->input->post('txt_date_to');
		$txt_date_end = $this->input->post('txt_date_end');

		$txt_date_to = date('Y-m-d',strtotime($txt_date_to));
		$txt_date_end = date('Y-m-d',strtotime($txt_date_end));

		if(!empty($idEmpl)){	
			foreach ($idEmpl as $id_access) {
				$this->db->where('access_id', $id_access);
				$sql_1 = "DATE_FORMAT(start_time,'%Y-%m-%d') >= '".$txt_date_to."'";
				$sql_2 = "DATE_FORMAT(end_time,'%Y-%m-%d') <= '".$txt_date_end."'";
				$this->db->where($sql_1);
				$this->db->where($sql_2);
				$this->db->delete('employee_timecard');                                  // API Name Is DeleteRowTimeCard
			}
			$this->session->set_flash('success_msg', 'Changes saved.');
		}
		exit();
	}
	/***********************# END TIMECARD #********************************/

	/***********************# SCHEDDULING #********************************/
	public function listScheduling(){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['employees_scheduling'], 0, 1) == '0')){
			$this->template->content = new View('scheduling/index');
		}else{
			$this->template->content = new View('scheduling/index');
			$this->template->jsKiosk = new View('scheduling/jsIndex');

			$_storeId = base64_decode($this->sess_cus['storeId']);
			if((string)$_storeId == '0'){
				$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
				$this->db->where('status', 1);
				$listStore = $this->store_model->get();
			}
			$this->template->content->set(array(
				'listStore' => !empty($listStore)?$listStore:''
			));
		}
	}

	private function getCalendar($day = ''){
		$day        = !empty($day)?$day:date('m/d/Y');
		$listDays   = $this->week_from_sunday($day);
		$listFormat = array();
		$toDay      = date('m/d/Y');
		$nextDay    = date('m/d/Y', strtotime($listDays[6]. '+1 days'));
		$preDay     = date('m/d/Y', strtotime($listDays[0]. '-1 days'));
		if(!empty($listDays)){
			foreach ($listDays as $key => $value) {
				$listFormat[] = date('D (m/d)', strtotime($value));
			}
		}
		$calendar = array(
			'actionDay'  => $day,
			'preDay'     => $preDay,
			'toDay'      => $toDay, 
			'nextDay'    => $nextDay,
			'listDays'   => $listDays,
			'listFormat' => $listFormat,
			'strFormat'  => date('F d', strtotime($listDays[0])).' - '.date('F d, Y', strtotime($listDays[6]))
		);
		return $calendar;
	}
	/*
	public function daysInWeek($weekNum){
		$result   = array();
		$datetime = new DateTime('00:00:00');
		$datetime->setISODate((int)$datetime->format('o'), $weekNum , 0);
		$interval = new DateInterval('P1D');
		$week     = new DatePeriod($datetime, $interval, 6);

	    foreach($week as $day){
	        $result[] = $day->format('D d m Y H:i:s');
	    }
	    return $result;
	}
	*/
	
	private function getDayScheduling($idEmpl, $day){
		$this->db->where('access_id', $idEmpl);
		$this->db->where('work_day', $day);
		$this->db->orderby('start_time', 'asc');
		$result = $this->db->get('employee_schedule')->result_array(false);
		return $result;
	}

	public function getDataScheduling(){
		$storeId = base64_decode($this->sess_cus['storeId']);
		$date    = $this->input->post('date');
		if(empty($date)){
			$date  = date('m/d/Y');
		}
		$calendar = $this->getCalendar($date);
		$_data    = array();
		if((string)$storeId == '0'){
			$storeId = $this->input->post('store_id');
			$this->_setStoreUsing($storeId);
		}
		$this->db->where('store_id', $storeId);
		$empl = $this->employee_model->get();

		/* API store (store.xlsx) */
		$store      = $this->store_model->get($storeId);
		$store_name = trim((!empty($store[0]['s_first'])?$store[0]['s_first']:'').' '.(!empty($store[0]['s_last'])?$store[0]['s_last']:''));
		if(!empty($empl)){
			foreach ($empl as $key => $value) {
				$_data[$key]['employees'] = $value['first_name'].' '.$value['name'];
				$_data[$key]['emplId']    = $value['access_id'];
				$_data[$key]['storeName'] = $store_name;
				$sumHours                 = 0;
				foreach ($calendar['listDays'] as $sl => $itemDay) {
					$daysInWeek = '';
					switch ($sl) {
						case 0: $daysInWeek = 'Sunday'; break;
						case 1: $daysInWeek = 'Monday'; break;
						case 2: $daysInWeek = 'Tuesday'; break;
						case 3: $daysInWeek = 'Wednesday'; break;
						case 4: $daysInWeek = 'Thursday'; break;
						case 5: $daysInWeek = 'Friday'; break;
						case 6: $daysInWeek = 'Saturday'; break;
					}

					$strDay   = '';
					$day      = date('Y-m-d 00:00:00', strtotime($itemDay));
					$timeDay  = $this->getDayScheduling($value['access_id'], $day);
					if(!empty($timeDay)){
						foreach ($timeDay as $vt => $itemTime) {
							$strDay   .= date('H:i', strtotime($itemTime['start_time'])).' - '.date('H:i', strtotime($itemTime['end_time'])).'<br>';
							
							$_stare   = date_parse_from_format('Y-m-d H:i:s', $itemTime['start_time']);
							$_end     = date_parse_from_format('Y-m-d H:i:s', $itemTime['end_time']);
							
							$tsStare  = mktime($_stare['hour'], $_stare['minute'], $_stare['second'], $_stare['month'], $_stare['day'], $_stare['year']);
							$tsEnd    = mktime($_end['hour'], $_end['minute'], $_end['second'], $_end['month'], $_end['day'], $_end['year']);
							
							$distance = $tsEnd - $tsStare;
							$sumHours += round($distance/3600, 2);
						}
					}
					$_data[$key][$daysInWeek.'time'] = $strDay;
					$_data[$key][$daysInWeek]        = $itemDay;
				}
				$_data[$key]['total'] = $sumHours;
				$_data[$key]['today'] = date('m/d/Y');
			}
		}

		$records             = array();
		$records["data"]     = $_data;
		$records['calendar'] = $calendar;
		echo json_encode($records);
		die();
	}

	public function getAddScheduling(){
		$template = new View('scheduling/frmScheduling');
		$idEmpl   = $this->input->post('idEmpl');
		$workDay  = $this->input->post('day');
		
		$this->db->select('access_id, first_name, name');
		$empl     = $this->employee_model->get($idEmpl);
		if(!empty($empl)){
			$this->db->where('work_day', date('Y-m-d 00:00:00', strtotime($workDay)));
			$this->db->where('access_id', $idEmpl);
			$this->db->orderby('start_time', 'asc');
			$scheduling = $this->employee_schedule_model->get();
		}
		$title    = 'Manage Shifts';
		$template->set(array(
			'title'          => $title,
			'dataEmpl'       => !empty($empl)?$empl[0]:'',
			'dataTime'       => $workDay,
			'dataScheduling' => !empty($scheduling)?$scheduling:''
		));
		$template->render(true);
		die();
	}

	private function _deleteScheduling($emplId, $workDay){
		$workDay = date('Y-m-d 00:00:00', strtotime($workDay));
		$this->db->where('work_day', $workDay);
		$this->db->where('access_id', $emplId);
		$this->employee_schedule_model->delete();
	}

	public function saveScheduling(){
		$emplId  = $this->input->post('txt_hd_empl');
		$workDay = $this->input->post('txt_hd_day');
		$data    = $this->input->post();
		if(!empty($emplId) && !empty($workDay)){
			/* delete all scheduling */
			$this->_deleteScheduling($emplId, $workDay);

			/* insert new scheduling */
			if(!empty($data['txt_date_start']) && !empty($data['txt_date_end'])){
				foreach ($data['txt_date_start'] as $key => $value) {
					$startTime = date('Y-m-d H:i:s',strtotime($workDay.' '.$value.':00'));
					$endTime   = date('Y-m-d H:i:s',strtotime($workDay.' '.$data['txt_date_end'][$key].':00'));
					$arrItem = array(
						'employee_schedule_id' => $this->getGUID(), 
						'access_id'            => $emplId, 
						'start_time'           => $startTime, 
						'end_time'             => $endTime, 
						'work_day'             => date('Y-m-d 00:00:00',strtotime($workDay))
					);
					try {
						$this->employee_schedule_model->save($arrItem);
					} catch (Exception $e) {}
				}
			}
			$this->session->set_flash('success_msg', 'Changes saved.');
			url::redirect('employees/listScheduling');
		}else{
		    $this->session->set_flash('error_msg', 'Error Save.');
			url::redirect('employees/listScheduling');
		}
		die();
	}

	public function setDuplicate(){
		try {
			$date        = $this->input->post('date');
			$idEmpl      = $this->input->post('idEmpl');
			
			$calendarPre = $this->getCalendar($date);
			$calendar    = $this->getCalendar($calendarPre['nextDay']);

			foreach ($calendarPre['listDays'] as $sl => $itemDay) {
				$day = date('Y-m-d 00:00:00', strtotime($itemDay));
				foreach ($idEmpl as $vt => $id_empl) {
					$this->db->where('work_day', $day);
					$this->db->where('access_id', $id_empl);
					$result  = $this->db->get('employee_schedule')->result_array(false);
					
					$workDay = $calendar['listDays'][$sl];
					/* delete scheduling exist in week */
					$this->_deleteScheduling($id_empl, $calendar['listDays'][$sl]);

					/* insert data */
					if(!empty($result)){
						foreach ($result as $k => $itemScheduling) {
							$startTime = date('Y-m-d H:i:s',strtotime($workDay.' '.date('H:i:s',strtotime($itemScheduling['start_time']))));
							$endTime   = date('Y-m-d H:i:s',strtotime($workDay.' '.date('H:i:s',strtotime($itemScheduling['end_time']))));
							$arrItem = array(
								'employee_schedule_id' => $this->getGUID(), 
								'access_id'            => $id_empl, 
								'start_time'           => $startTime, 
								'end_time'             => $endTime, 
								'work_day'             => date('Y-m-d 00:00:00',strtotime($workDay))
							);
							try {
								$this->employee_schedule_model->save($arrItem);
							} catch (Exception $e) {}
						}
					}
				}
			}
			echo json_encode( array('msg' => true) );
			die();
		} catch (Exception $e) {
			echo json_encode( array('msg' => false) );
			die();
		}
	}

	public function deleteScheduling(){
		$date        = $this->input->post('date');
		$idEmpl      = $this->input->post('idEmpl');
		$calendar    = $this->getCalendar($date);
		try {
			foreach ($calendar['listDays'] as $sl => $itemDay) {
				foreach ($idEmpl as $vt => $id_empl) {
					try {
						$this->_deleteScheduling($id_empl, $itemDay);
					} catch (Exception $e) {}
					
				}
			}
			echo json_encode( array('msg' => true) );
			die();
		} catch (Exception $e) {
			echo json_encode( array('msg' => false) );
			die();
		}
		die();
	}

	/********************# END SCHEDDULING #********************************/
	private function getAllStore(){
		$supAdmin = $this->sess_cus['admin_refer_id'];
		$this->db->select('store_id');
		$result = $this->store_model->getStoreAdmin($supAdmin);
		if(!empty($result)){
			$result = array_column($result, 'store_id');
		}
		return $result;
	}

	public function index(){
		$this->listEmployees();
	}

	public function listEmployees(){
		if($this->mPrivileges == 'NoAccess' || (is_array($this->mPrivileges) && substr($this->mPrivileges['employees_employees'], 0, 1) == '0')){
			$this->template->content = new View('listEmployees');
		}else{
			$this->template->content = new View('listEmployees');
			$this->template->jsKiosk = new View('jsListEmployees');

			$store_id = base64_decode($this->sess_cus['storeId']);
			if((string)$store_id == '0'){
				$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
				$this->db->where('status', 1);
				$listStore = $this->store_model->get();
				$store_id = $this->_getStoreUsing();
				if(empty($store_id)){
					$store_id = !empty($listStore)?$listStore[0]['store_id']:'';
					$this->_setStoreUsing($store_id);
				}
			}
			
			$this->db->where('store_id', $store_id);
			$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
			$this->db->where('status','1');
			$total_items    = $this->db->get('access')->count();
			$this->template->content->set(array(
				'listStore' => !empty($listStore)?$listStore:''
			));
			$this->template->jsKiosk->total_items = $total_items;
		}
	}

	public function jsDataEmployees(){
		$store_id = base64_decode($this->sess_cus['storeId']);

		$iSearch        = $_POST['search']['value'];
		$_isSearch      = false;
		$iDisplayLength = ((int)$_POST['length'] > 100)?100:(int)$_POST['length'];
		$iDisplayStart  = (int)($_POST['start']);
		$sEcho          = (int)($_POST['draw']);
		$_data          = array();
		$total_items    = (int)($_POST['_main_count']);
		$total_filter   = $total_items;

		if((string)$store_id == '0'){
			$store_id = $this->input->post('store_id');
			$this->_setStoreUsing($store_id);
		}
		
		$this->db->where('store_id', $store_id);
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$this->db->where('status','1');
		$total        = $this->db->get('access')->count();
		
		$total_items  = $total;
		$total_filter = $total_items;
		
		$sql_select   = "SELECT *, access.regidate as regidate,store.regidate as s_regidate ";
		$sql_from     = "FROM access ";
		$sql_where    = "WHERE access.store_id = '".$store_id."' AND access.admin_id = '".$this->sess_cus['admin_refer_id']."'";
		$sql_join     = "LEFT JOIN store ON store.store_id = access.store_id ";
		$_sql_order   = " ORDER BY access_no DESC";

		$_sql_search = '';
		if(!empty($iSearch)){
   			$iSearch = $this->db->escape(trim($iSearch));
   			$iSearch    = substr($iSearch, 1, (strlen($iSearch)-2));
   			$arr        = explode(' ',trim($iSearch));
   			$dem        = count($arr);
 
	   		if($dem > 1){
    			$_sql_search = " AND (CONCAT_WS(' ',access.name,access.first_name,access.address,access.address2,access.city,access.zip,access.state,access.email,access.note,access.access_no,access.regidate) LIKE '%".$arr[0]."%'";
			    for ($i=1; $i < ($dem-1) ; $i++) { 
			      $_sql_search .= " AND CONCAT_WS(' ',access.name,access.first_name,access.address,access.address2,access.city,access.zip,access.state,access.email,access.note,access.access_no,access.regidate) LIKE '%" .$arr[$i]. "%'";
			    }
			    $_sql_search .= " AND CONCAT_WS(' ',access.name,access.first_name,access.address,access.address2,access.city,access.zip,access.state,access.email,access.note,access.access_no,access.regidate) LIKE '%" .$arr[$dem-1]. "%')";
   			}else{
    			$_sql_search = " AND CONCAT_WS(' ',access.name,access.first_name,access.address,access.address2,access.city,access.zip,access.state,access.email,access.note,access.access_no,access.regidate) LIKE '%" .trim($iSearch). "%'";
   			}

			$sql_query    = $sql_select.$sql_from.$sql_join.$sql_where.$_sql_search.$_sql_order;
			$total_filter = $this->db->query($sql_query)->count();
		}
		
		$_sql_limit = " LIMIT ".$iDisplayStart.", ".$iDisplayLength;
		$sql_query  = $sql_select.$sql_from.$sql_join.$sql_where.$_sql_search.$_sql_order.$_sql_limit;
		$result     = $this->db->query($sql_query)->result_array(false);

		//echo kohana::Debug($result);
		//echo $this->db->last_query();

		if(!empty($result)){
			foreach ($result as $key => $value) {
				$address = $value['address'].' '.$value['address2'].' '.$value['city'].', '.$value['state'].' '.$value['zip'];
				$Store_last = ' '.$value['s_last'];
				$store_name = $value['s_first'].$Store_last;
				$_data[] = array(
					"tdID"        => $value['access_id'],
					"tdCust"      => $value['access_no'],
					'tdStoreName' => $value['store'],
					"tdName"      => (!empty($value['first_name'])?$value['first_name'].' ':'').$value['name'],
					"tdAddress"   => $address,
					"tdPhone"     => !empty($value['phone'])?$value['phone']:'',
					"tdEmail"     => $value['email'],
					"tdDate"      => date_format(date_create($value['regidate']), 'm/d/Y'),
					"tdNote"      => $value['note'],
					"tdLevel"     => $value['level'],
					"DT_RowId"    => $value['access_id'],
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

	public function getAdd(){
		$template = new View('frmEmployees');
		$title    = 'Add New Employees';
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$store    = $this->db->get('store')->result_array(false);
		$template->set(array(
			'title'   => $title,
			'store'   => $store
		));
		$template->render(true);
		die();
	}

	public function getEdit(){
		$template = new View('frmEmployees');
		$title    = 'Edit Employees';
		$id       = $this->input->post('id');

		$this->db->where('access_id', $id);
		$this->db->where('status','1');
		$result = $this->db->get('access')->result_array(false);
		$this->db->where('admin_id', $this->sess_cus['admin_refer_id']);
		$store    = $this->db->get('store')->result_array(false);
		
		$template->set(array(
			'title' => $title,
			'data'  => !empty($result)?$result[0]:'',
			'store' => $store

		));
		$template->render(true);
		die();
	}

	public function getGenerate(){
		$supAdmin = $this->sess_cus['admin_refer_id'];
		$generate = substr(number_format(time() * rand(),0,'',''),0,15);
		$this->db->select('count(menu_id) as total');
		$this->db->where('barcode', $generate);
		$this->db->where('admin_id', $supAdmin);
		$result = $this->db->get('access')->result_array(false);
		if(!empty($result) && $result[0]['total'] > 0)
			$this->getGenerate();
		echo json_encode($generate);
		die();
	}

	public function checkCode(){
		$supAdmin   = $this->sess_cus['admin_refer_id'];
		$storeUsing = $this->input->post('store_id');
		if($storeUsing == '')
			$storeUsing = base64_decode($this->sess_cus['storeId']);

		$txt_code = $this->input->post('txt_code');
		$code_old = $this->input->post('code_old');

		$this->db->where('access_no', $txt_code);
		if(!empty($code_old))
			$this->db->notin('access_no', $code_old);
		$this->db->where('admin_id', $supAdmin);
		$this->db->where('status', 1);
		$this->db->limit(1);
		$result = $this->db->get('access')->result_array(false);

		if(!empty($result)){
			if($result[0]['store_id'] != $storeUsing){
				echo json_encode(array(
					'msg'    => 'The employee number is already being used by another affiliated restaurant.',
					'result' => false
				));
			}else{
				echo json_encode(array(
					'msg'    => 'The employee number already exists.',
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

	public function nextCode(){
		$supAdmin = $this->sess_cus['admin_refer_id'];
		$code     = 1000;	
		$result   = $this->employee_model->getMaxNo($supAdmin);

		if(!empty($result['access_no'])){
			$code = (int)$result['access_no'] + 1;
		}
		echo json_encode(array(
			'msg'  => 'true',
			'code' => $code
		));
		die();
	}

	public function save(){
		$data = $this->input->post();
		if(isset($_POST['txt_empl_store']))
			$store_id = $_POST['txt_empl_store'];
		else
			$store_id = base64_decode($this->sess_cus['storeId']);
		if(!empty($data['txt_hd_id'])){
			$access_id = $data['txt_hd_id'];
			$this->db->where('access_id', $access_id);
			$empl = $this->db->get('access')->result_array(false);
			if(!empty($empl)){
				$pinCode  = !empty($data['txt_empl_pin'])?$data['txt_empl_pin']:$empl[0]['pin'];
				$regidate = $empl[0]['regidate'];
			}else{
				$this->session->set_flash('error_msg', 'Error Save.');
				url::redirect('employees');
			}
		}else{
			$access_id = $this->getGUID();
			$pinCode   = $data['txt_empl_pin'];
			$regidate  = date('Y-m-d H:i:s');
		}
		
		$arr_data = array(
			'access_id'  => $access_id, 
			'access_no'  => $data['txt_empl_no'],
			'store_id'   => $store_id,
			'admin_id'   => $this->sess_cus['admin_refer_id'],
			'name'       => $data['txt_empl_last_name'], 
			'first_name' => $data['txt_empl_first_name'], 
			'address'    => $data['txt_empl_address'], 
			'address2'   => $data['txt_empl_address2'], 
			'city'       => $data['txt_empl_city'], 
			'state'      => $data['txt_empl_state'], 
			'zip'        => $data['txt_empl_zip'], 
			'country'    => $data['txt_empl_country'], 
			'area_code'  => $data['txt_empl_code_phone'], 
			'phone'      => $data['txt_empl_phone'], 
			'email'      => $data['txt_empl_email'], 
			'note'       => $data['txt_empl_note'], 
			'pin'        => $pinCode, 
			'passwd'     => '',
			'level'      => $data['txt_empl_level'],
			'status'     => '1',
			'regidate'   => $regidate,
			'barcode'    => $data['txt_empl_barcode']
			
		);

		if(empty($data['txt_hd_id'])){
			$result = $this->db->insert('access', $arr_data);
		}else{
			unset($data['access_id']);
			$this->db->where('access_id', $access_id);
			$result = $this->db->update('access', $arr_data);
		}

		if($result)
			$this->session->set_flash('success_msg', 'Changes saved.');
	    else 
	    	$this->session->set_flash('error_msg', 'Error Save.');
		
		url::redirect('employees');
		die();
	}

	public function delete(){
		$id_empl = $this->input->post('id_empl');
		$this->db->in('access_id',$id_empl);
		$result = $this->db->update('access',array('status' => '0'));
		if($result){
			echo json_encode(array(
				'msg' => true,
			));
		}else{
			echo json_encode(array(
				'msg' => false,
			));
		}
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
					$idSelected = explode(',', $idChange);
					$idSelected = implode('","', $idSelected);
					$idSelected = '"'.$idSelected.'"';

					$dataUpdate = array(
						'store_id' => $storeId
					);
					
					$this->db->in('access_id', $idSelected);
					$result = $this->db->update('access', $dataUpdate);
					$this->session->set_flash('success_msg', $result->count().' items updated.');
					url::redirect('employees');
					die();
				} catch (Exception $e) {
					
				}
			}
		}
		$this->session->set_flash('error_msg', 'Could not complete request.');
		url::redirect('employees');
		die();
	}

}