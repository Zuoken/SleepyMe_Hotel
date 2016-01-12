<!-- Google Maps Plugin provided by BIOSTALL: http://biostall.com/codeigniter-google-maps-v3-api-library -->
<?php
class Contact extends CI_Controller {

        public function index()
        {
			// Load the libraries
			//$this->load->library('template');
					
			// Load the Form helper
			$this->load->helper('form');
			
			// Load Google Maps
			$this->load->library('googlemaps');
			$config = array();
			$marker = array();
			$config['center'] = "21 Redwood Road, Brantford, ON";
			$config['zoom'] = '16';
			$marker['position'] = "21 Redwood Road, Brantford, ON";
			$marker['infowindow_content'] = "SleepyMe Hotel";
			$marker['animation'] = "DROP";
			$this->googlemaps->add_marker($marker); 
			$this->googlemaps->initialize($config);
			$TPL['map'] = $this->googlemaps->create_map();
			
			// Default validation message (none)
			$TPL['validation'] = "";
			
			// Load the template
			$this->template->show('contact', 'Contact', $TPL);
						 
        }
		
		// Form Validation
		public function post() {
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters("<p style='font-weight: bold; color:red;'>", '</p>'); 
			$this->form_validation->set_rules('name', 'Name', 'required|min_length[2]');
			$this->form_validation->set_rules('address', 'Address', 'required|min_length[2]');
			$this->form_validation->set_rules('postal', 'Postal Code', 'required|callback_validate_postal');
			$this->form_validation->set_rules('phone', 'Phone', 'required|callback_validate_phone');
			$this->form_validation->set_rules('email', 'E-mail', 'valid_email');
			$this->form_validation->set_rules('comment', 'Comment', 'required|min_length[2]');
			
			// Load Google Maps
			$this->load->library('googlemaps');
			$config = array();
			$marker = array();
			$config['center'] = "21 Redwood Road, Brantford, ON";
			$config['zoom'] = '16';
			$marker['position'] = "21 Redwood Road, Brantford, ON";
			$marker['infowindow_content'] = "SleepyMe Hotel";
			$marker['animation'] = "DROP";
			$this->googlemaps->add_marker($marker); 
			$this->googlemaps->initialize($config);
			$TPL['map'] = $this->googlemaps->create_map();
				
			if ($this->form_validation->run() == FALSE) {			
				// Validation error and show template
				$TPL['validation'] = "The form contains errors: <br />";
				$this->template->show('contact', 'Contact', $TPL);
			} else {
				// Validation success, send email, and show template
				$TPL['validation'] = "The form has been successfully submitted";
				
				// Load email library, set up message, and send it
				//$this->load->library('email');
				$this->load->helper('date');
				date_default_timezone_set('EST'); 
				
				$this->email->from('000299896@csunix.mohawkcollege.ca', 'SleepyMe_Form');
				$this->email->to('000299896@csunix.mohawkcollege.ca');
				$this->email->cc('browne@csunix.mohawkcollege.ca');
				
				$this->email->subject('Form Submission From SleepyMe Hotel');
				$this->email->message('Date of submission: '.standard_date('DATE_RFC1123', time())."\n".
					'Name: '.$this->input->post('name')."\n".
					'Address: '.$this->input->post('address')."\n".
					'Postal Code: '.$this->input->post('postal')."\n".
					'Phone: '.$this->input->post('phone')."\n".
					'E-mail: '.$this->input->post('email')."\n".
					'Comment: '.$this->input->post('comment')
				);

				if ( ! $this->email->send()) {
					$TPL['validation'] = 'The form submission failed';
				}

				$this->template->show('contact', 'Contact', $TPL);
			}
		}
		
		// Postal code validation
		public function validate_postal($postal) {
			$pattern = '/^[A-Za-z]\d{1}[A-Za-z]\d{1}[A-Za-z]\d{1}/';
			if (preg_match($pattern, $postal) == 1) {
				return TRUE;
			} else {
				$this->form_validation->set_message('validate_postal', 'Must be a correct Canadian postal code');
				return FALSE;
			}
		}
		
		// Phone validation
		public function validate_phone($phone) {
			$pattern ='/^\d{10}/';
			if (preg_match($pattern, $phone) == 1) {
				return TRUE;
			} else {
				$this->form_validation->set_message('validate_phone', 'Must be a 10-digit phone number');
				return FALSE;
			}
		}
}