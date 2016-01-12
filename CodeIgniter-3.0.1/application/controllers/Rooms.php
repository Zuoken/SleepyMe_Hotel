<?php
class Rooms extends CI_Controller {
	
	// Constructors loads the DB Model
	function __construct() { 
        parent::__construct(); 
        
    } 
  
	
    public function index()
    {
		$this->load->library('template');
		$this->load->model('dbrooms');
		$this->load->helper('form');  
		$TPL['all_rooms'] = $this->dbrooms->get_all_rooms();
		$this->template->show('rooms_and_rates', 'Rooms and Rates', $TPL);
    }
}