<?php
class Ajax_progress_Controller extends Template_Controller {
	public $template;
	public function __construct(){
        parent::__construct();
    } 
	public function __call($method, $arguments){
		$this->template->content = new View('templates/'.$this->site['config']['TEMPLATE'].'/index');
		url::redirect('/');
	}
}
?>