<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Reservations extends CI_Controller {
	
	function __construct() { 
        parent::__construct(); 
		// Set the timezone
		date_default_timezone_set('EST');
		// Load the libraries, helpers, and the db model
        $this->load->library('session');  
		$this->load->library('template');
		$this->load->library('calendar'); 
		$this->load->helper(array('form'));
		$this->load->model('dbreservations');
    } 

  	public function index()
    {
		$this->session->sess_destroy();
        $this->session->set_userdata(array('step' => 'selectDate')); 
		$TPL['calendar'] = $this->calendar->generate();
		$this->template->show('reservations', 'Reservations', $TPL);
	}
	
	// Function for the Select Date section
	public function selectDate($action = 'default')
	{		
		if ($action == 'continue')
		{
			if ($_POST['arrivalDate'] != null && $_POST['departureDate'] != null)
			{
				// validation of calendar choices
				$arrival = $_POST['arrivalDate'];
				$departure = $_POST['departureDate'];
				if ($departure <= $arrival) 
				{
					$TPL['errorMsg'] = 'Departure date must be after the arrival date.';
					$this->session->set_userdata(array('step' => 'selectDate'));			
				} 
				else 
				{
					$this->session->set_userdata(
						array(
							'step' => 'selectRooms',
							'arrivalDate' => $arrival,
							'departureDate' => $departure
						)
					);
					$arrival = $this->session->userdata('arrivalDate');
					$departure = $this->session->userdata('departureDate');
					$booked = $this->dbreservations->get_booked_rooms($arrival, $departure);
					$never_booked = $this->dbreservations->check_booked();
					$available = $this->dbreservations->get_available_rooms($arrival, $departure);
					$TPL['booked'] = $booked;
					$TPL['available'] = array_merge($available, $never_booked);				
				}
			}
			else 
			{
				$TPL['errorMsg'] = 'You must select an arrival date and a departure date.';
				$this->session->set_userdata(array('step' => 'selectDate'));
			}	
		}
		elseif ($action == 'navigate')
		{
			$this->session->set_userdata(array('step' => 'selectDate'));
		}
		$TPL['calendar'] = $this->calendar->generate();
		$this->template->show('reservations', 'Reservations', $TPL);
	}
	
	// Function for the Select Rooms section
	public function selectRooms($action = 'default', $info = 0)
	{	
		$arrival = $this->session->userdata('arrivalDate');
		$departure = $this->session->userdata('departureDate');
		$booked = $this->dbreservations->get_booked_rooms($arrival, $departure);
		$never_booked = $this->dbreservations->check_booked();
		$available = $this->dbreservations->get_available_rooms($arrival, $departure);
		$TPL['booked'] = $booked;
		$TPL['available'] = array_merge($available, $never_booked);
			
		if ($action == 'info' && $info != 0)
		{
			$room_info = $this->dbreservations->get_room_info($info);
			$TPL['roomInfo'] = $room_info;
		}
		elseif($action == 'select' && $info != 0)
		{
			$room_info = $this->dbreservations->get_room_info($info);
			$rate = $room_info[0]->room_rate;
			$this->session->set_userdata(array(
				'roomSelection' => $info,
				'roomRate' => $rate
				));
		}
		elseif ($action == 'navigate')
		{
			$this->session->set_userdata(array('step' => 'selectRooms'));
		}
		elseif ($action == 'continue')
		{
			$roomSelected = $this->session->userdata('roomSelection'); 
			if ($roomSelected != null)
			{
				$this->session->set_userdata(array('step' => 'selectPayment'));
			}
			else
			{
				$TPL['errorMsg'] = 'You must select a room to continue.';	
			}
		}
		$this->template->show('reservations', 'Reservations', $TPL);
	}
	
	public function selectPayment($action = 'default')
	{
		$TPL['default'] = 'default';
		if ($action == 'continue')
		{
			$fName = $_POST['fName'];
			$lName = $_POST['lName'];
			$email = $_POST['email'];
			$cardName = $_POST['cardName'];
			$cardType = $_POST['cardType'];
			$cardNum = $_POST['cardNum'];
			$expMonth = $_POST['expDateMonth'];
			$expYear = $_POST['expDateYear'];
			$secCode = $_POST['secCode'];
			$TPL['errorMsg'] = '';
			$valid = true;
			
			// Validation of user data
			if ($fName == null)
			{
				$TPL['errorMsg'] = "<p>You must enter your first name.</p>";
				$valid = false;	
			}
			
			if ($lName == null)
			{
				$TPL['errorMsg'] .= "<p>You must enter your last name.</p>";
				$valid = false;	
			}
			
			if ($email == null)
			{
				$TPL['errorMsg'] .= "<p>You must enter your email address.</p>";
				$valid = false;	
			}
			
			if ($cardName == null)
			{
				$TPL['errorMsg'] .= "<p>You must enter your full cardholder name.</p>";
				$valid = false;	
			}
			
			if ($cardNum == null)
			{
				$TPL['errorMsg'] .= "<p>You must enter your credit card number.</p>";
				$valid = false;	
			}
			
			if ($cardType == 'select')
			{
				$TPL['errorMsg'] .= "<p>You must choose your credit card type.</p>";
				$valid = false;
			}
			
			if ($expMonth == "")
			{
				$TPL['errorMsg'] .= "<p>You must select your credit cards month of expiry.</p>";
				$valid = false;	
			}
			
			if ($expYear == "")
			{
				$TPL['errorMsg'] .= "<p>You must enter your credit cards year of expiry.</p>";
				$valid = false;	
			}
			
			if ($secCode == null)
			{
				$TPL['errorMsg'] .= "<p>You must enter your credit cards security code.</p>";
				$valid = false;	
			}
			
			if ($valid)
			{
				$this->session->set_userdata(array(
					'fName' => $fName,
					'lName' => $lName,
					'email' => $email,
					'cardName' => $cardName,
					'cardNum' => $cardNum,
					'cardType' => $cardType,
					'expMonth' => $expMonth,
					'expYear' => $expYear,
					'secCode' => $secCode,
					'step' => 'selectConfirmation'
				));
			}
		}
		elseif ($action == 'navigate')
		{
			$this->session->set_userdata(array('step' => 'selectPayment'));
		}
		$this->template->show('reservations', 'Reservations', $TPL);
	}
	
	public function selectConfirmation($action = 'default')
	{
		$TPL['default'] = 'default';
		if ($action == 'continue')
		{
			$arrival = $this->session->userdata('arrivalDate');
			$departure = $this->session->userdata('departureDate');
			$roomSelection = $this->session->userdata('roomSelection');
			$charge = $this->session->userdata('totalCharge');
			$nights = $this->session->userdata('nights');
			$fName = $this->session->userdata('fName');
			$lName = $this->session->userdata('lName');
			$email = $this->session->userdata('email');
			$cardName = $this->session->userdata('cardName');
			$cardType = $this->session->userdata('cardType');
			$cardNum = $this->session->userdata('cardNum');
			$expMonth = $this->session->userdata('expMonth');
			$expYear = $this->session->userdata('expYear');
			$secCode = $this->session->userdata('secCode');
			// Insert new reservation into database
			$this->dbreservations->insert_reservation($arrival, $departure, $roomSelection, $nights, $charge,
			$fName, $lName, $email, $cardName, $cardType, $cardNum, $expMonth, $expYear, $secCode);
			$TPL['confirmationMessage'] = "Congratulations, your room has been booked.  Enjoy your stay!";
			$this->session->set_userdata(array('step' => 'confirmed'));	
		}
		$this->template->show('reservations', 'Reservations', $TPL);
	}
}