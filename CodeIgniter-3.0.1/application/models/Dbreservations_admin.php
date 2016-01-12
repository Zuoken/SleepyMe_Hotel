<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  

class Dbreservations_admin extends CI_Model {

   	// Class variables
   	var $defineMe;
	   
    // Call the constructor
    function __construct()
    {
        parent::__construct();
    }
    
	function get_booked_ondate($date = 0)
	{
		$dateFormat = date('Y-m-d', strtotime($date));
        $this->db->select('room, arrival, departure, nights, room_description, room_rate, first_name, last_name');
        $this->db->from('reservations');
        $this->db->join('rooms', 'reservations.room = rooms.room_no');
        $this->db->where("'$dateFormat' BETWEEN `arrival` AND `departure`");
        $query = $this->db->get();
        $room_availability = $query->result();
        return $room_availability;
	}
	
    function get_rooms_count()
    {
        $this->db->select('id');
        $this->db->from('rooms');
        $query = $this->db->count_all_results();
        return $query;
    }
	
	
}