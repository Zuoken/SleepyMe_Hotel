<?php

/*
    Code by: Cameron Winters
    For: Web 2.0 & PHP Course with Kevin Browne
    Mohawk College 2015
*/

class Home extends CI_Controller {
	
        public function index()
        {
			$this->load->library('template');
			$TPL = '';
			$this->template->show('home', 'Home', $TPL);
        }
}