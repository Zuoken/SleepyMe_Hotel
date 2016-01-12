<?php

/*
    Code by: Cameron Winters
    For: Web 2.0 & PHP Course with Kevin Browne
    Mohawk College 2015
*/

class Rooms extends CI_Controller {
    
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