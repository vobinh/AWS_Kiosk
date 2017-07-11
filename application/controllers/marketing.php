<?php
class Marketing_Controller extends Template_Controller {
	
	public $template;	

	public function __construct()
    {
        parent::__construct();
       	$this->template = new View('templates/'.$this->site['config']['TEMPLATE'].'/index');
		$this->_get_session_template();
		if(empty($this->sess_cus['admin_id']) || $this->sess_cus['step'] != 3) url::redirect('login');
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
	public function index(){
		$this->overview();
	}

	public function overview(){
		$this->template->content = new View('marketing/index');
		$this->template->jsKiosk = new View('marketing/js');
	}

	public function LoadChartMarketing(){
		header( 'Content-Type: application/json' );
		$_arr = array(
			0 => array(
				"date" =>  "04/01/2017",
                "value" => 23.5,
                "name" =>  "Pizaa"
			),
			1 => array(
				"date" =>  "04/02/2018",
                "value" =>  26.2,
                "name" =>  "Combo"
			),
			2 => array(
				"date" =>  "04/03/2019",
                "value" =>  30.1,
                "name" =>  "Alcohol"
			),
			3 => array(
				"date" =>  "04/04/2010",
                "value" =>  29.5,
                "name" =>  'Meat'
			),
			4 => array(
				"date" =>  "04/05/2011",
                "value" =>  30.6,
                "name" =>  'Nho'
			),
			5 => array(
				"date" =>  "04/06/2012",
                "value" =>  32,
                "name" =>  'Rouo'
			)
		);
		$data = array();
		foreach ($_arr as $key => $value) {
			$data[] = $value;
		}
		echo json_encode( $data );
		exit();
	}
}
?>