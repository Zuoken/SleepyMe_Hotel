<?php
class Admin extends CI_Controller {
	
        public function index()
        {
			$this->load->library('template');
			$TPL = '';
			$this->template->show('admin', 'Admin', $TPL);
        }
}