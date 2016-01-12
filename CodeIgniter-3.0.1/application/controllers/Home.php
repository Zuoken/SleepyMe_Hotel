<?php
class Home extends CI_Controller {
	
        public function index()
        {
			$this->load->library('template');
			$TPL = '';
			$this->template->show('home', 'Home', $TPL);
        }
}