<?php

/*
    Code by: Cameron Winters
    For: Web 2.0 & PHP Course with Kevin Browne
    Mohawk College 2015
*/

class Admin extends CI_Controller {
	
        public function index()
        {
			$this->load->library('template');
			$TPL = '';
			$this->template->show('admin', 'Admin', $TPL);
        }
}