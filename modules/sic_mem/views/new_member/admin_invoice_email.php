<?php
class Admin_invoice_email_Controller extends Template_Controller{
	
	var $mr;
	var $site;
	var $register_email_content;
	var $path_file;
	public $template = 'admin/index';
	public function __construct()
    {
        parent::__construct();
	}
	
	function _get_submit()
	{
		if($this->session->set_flash('error_msg'))
			$this->mr['error_msg'] = $this->session->set_flash('error_msg');
		if($this->session->set_flash('warning_msg'))
			$this->mr['warning_msg'] = $this->session->set_flash('warning_msg');
		if($this->session->set_flash('success_msg'))
			$this->mr['success_msg'] = $this->session->set_flash('success_msg');
		if($this->session->set_flash('info_msg'))
			$this->mr['info_msg'] = $this->session->set_flash('info_msg');
		if($this->session->set_flash('frm'))			
			$this->mr = array_merge($this->mr, $this->session->set_flash('frm'));
	}
	
	function index()
	{				
		$this->template->content = new View('admin_invoice_email/frm');
		$this->_read();
		$this->_get_submit();		
	}
	
	function _read()
	{
		$file_name = 'invoice';
		
		if($file_name)
			$path_file = $this->site['base_url'].'application/views/email_tpl/'.$file_name.'.tpl';
		else $path_file = '';
		
		if(!file_exists($path_file))
		{
			$register_email_content = file_get_contents('./application/views/email_tpl/'.$file_name.'.tpl');
		}
		
		$this->mr['register_email_content'] =$register_email_content;
		$this->template->content->mr = $this->mr;	 	
	}
	
	function _get_record()
	{
		$record = array('register_email_content' => $_POST['txt_content'],);
		if($_POST)
    	{
			$post = new Validation($_POST);
    		
			$post->pre_filter('trim', TRUE);
			$post->add_rules('txt_content','required');
			if($post->validate())
 			{
				$record = arr::overwrite($record, $post->as_array());
 				return $record; 				
			} 
			else {return false;}		
		}
	}
	
	function sm()
	{	
		$file_name = 'invoice';
		$path_file = './application/views/email_tpl/'.$file_name.'.tpl';
		$record = $this->_get_record();			
		
		if($record)
		{
			$result = file_put_contents($path_file,$record['register_email_content']);
							
			if($result)
				$this->session->set_flash('success_msg',$this->session->get('msg_data_save'));	
			else
				$this->session->set_flash('warning_msg',$this->session->get('msg_data_error'));			
		}		
		
		url::redirect('admin_invoice_email');	
		die();		
	}
}
?>