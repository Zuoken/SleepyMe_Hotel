<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  

/*
    Code by: Cameron Winters
    For: Web 2.0 & PHP Course with Kevin Browne
    Mohawk College 2015
*/


class Dbreservations_admin extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    // Returns an array of rooms booked on a specified date    
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
	
    // Returns the number of rooms
    function get_rooms_count()
    {
        $this->db->select('id');
        $this->db->from('rooms');
        $query = $this->db->count_all_results();
        return $query;
    }
}