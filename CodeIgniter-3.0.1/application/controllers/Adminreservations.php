<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
    Code by: Cameron Winters
    For: Web 2.0 & PHP Course with Kevin Browne
    Mohawk College 2015
*/

class Adminreservations extends CI_Controller {
	
	public $TPL = array();
		
	function __construct() { 
        parent::__construct(); 
        
		// Set the timezone
		date_default_timezone_set('EST');
        
		// Load the libraries, helpers, and the db model
        $this->load->library('session');  
		$this->load->library('template');
		$this->load->library('calendar', $this->config->item('admin_calendar')); 
		$this->load->helper(array('form'));
		$this->load->model('dbreservations_admin');
		
		// Calendar		
		$this->generate_calendar(date('Y'), date('m'));
    }
	
    // Loads the admin_reservations template and sends the date via TPL array
	public function index()
	{
		$this->TPL['date'] = date("F d, Y");
		$this->template->show('admin_reservations', 'Admin Reservations', $this->TPL);
	}
	
    // Generates the calendar using the Calendar library
	public function calendar($year = '2015', $month = '01')
	{
		$this->generate_calendar($year, $month);
		$this->template->show('admin_reservations', 'Admin Reservations', $this->TPL);
	}
	
    // Obtains room info from db for specified date
	public function roominfo()
	{
		$date = $this->input->post('date');
		$booked = $this->dbreservations_admin->get_booked_ondate($date);
		$room_info = array (
			'date' => date("F d, Y", strtotime($date)),
			'booked' => $booked
		);
		echo json_encode($room_info, JSON_PRETTY_PRINT);		
	}
	
    // Generates calendar using Calendar library; if a day is fully booked it is indicated to the user
	private function generate_calendar($year, $month)
	{
		$num_of_days = date("t");
		$month_data = array();
		
		for($day = 1; $day <= $num_of_days; $day++) {
			$date = date($year.'-'.$month.'-'.$day);
			$booked = $this->dbreservations_admin->get_booked_ondate($date);
			$total_rooms = $this->dbreservations_admin->get_rooms_count();
			$num_reservations = count($booked);
			if ($num_reservations >= $total_rooms) {
				$month_data[$day] = "<span href='#' id='no_rooms'>(<a id='".$date."'>$num_reservations</a>)</span>";
			} else {	
				$month_data[$day] = "(<a href='#' id='".$date."'>$num_reservations</a>)";
			} 	
		}
        
		//generates calendar HTML 
       	$this->TPL['calendar'] = $this->calendar->generate ( 
			$this->session->userdata('calendarYear'), 
			$this->session->userdata('calendarMonth'), 
				$month_data
		); 
	}
}