<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  

class Dbreservations extends CI_Model {

   	// Class variables
   	var $defineMe;
	   
    // Call the constructor
    function __construct()
    {
        parent::__construct();
    }
    
    // Get a list of all rooms in the system that are booked during provided times
    function get_booked_rooms($arrival = 0, $departure = 0)
    {
        $arrivalFormat = date('Y-m-d', strtotime($arrival));
        $departureFormat = date('Y-m-d', strtotime($departure));
        $this->db->select('room, arrival, departure, nights, room_description, room_rate');
        $this->db->from('reservations');
        $this->db->join('rooms', 'reservations.room = rooms.room_no');
        $this->db->where("`arrival` BETWEEN '$arrivalFormat' AND '$departureFormat' OR `departure` BETWEEN '$arrivalFormat' AND '$departureFormat'");
        $query = $this->db->get();
        $room_availability = $query->result();
        return $room_availability;
    }
    
    // Get list of all rooms that have never been booked
    function check_booked() 
    {
        $this->db->select('room_no, room_description, room_rate');
        $this->db->from('rooms');
        $this->db->where("`room_no` NOT IN (SELECT `room` FROM reservations)");
        $query = $this->db->get();
        $room_availability = $query->result();
        return $room_availability;    
    }
    
    // Get a list of all rooms in the system that are available
    function get_available_rooms($arrival = 0, $departure = 0)
    {
        $arrivalFormat = date('Y-m-d', strtotime($arrival));
        $departureFormat = date('Y-m-d', strtotime($departure));
        $this->db->distinct('room_no, room_description, room_rate');
        $this->db->from('rooms');
        $this->db->join('reservations', 'rooms.room_no = reservations.room');
        $this->db->where("`arrival` > '$departureFormat' OR `departure` < '$arrivalFormat'");
        $query = $this->db->get();
        $room_availability = $query->result();
        return $room_availability;
    }
    
    // Check if all rooms are booked on a specific date
    function rooms_available($date = 0)
    {
        // Check number of rooms booked on date
        $dateFormat = date('Y-m-d', strtotime($date));
        $this->db->select('*');
        $this->db->from('reservations');
        $this->db->where("`arrival` <= '$dateFormat' AND `departure` >= '$dateFormat'");
        $query = $this->db->get();
        $booked_count = count($query->result());
        
        // Check number of rooms available
        $this->db->select('*');
        $this->db->from('rooms');
        $query = $this->db->get();
        $available_count = count($query->result());
        
        // Returns true if rooms are available... false otherwise        
        if ($booked_count < $available_count)
        {
            return true;
        }
        else
        {
            return false;
        }        
    }
    
    // Get room information
    function get_room_info($room)
    {
        $this->db->select("*");
        $this->db->from("rooms");
        $this->db->where("`room_no` = '$room'");
        $query = $this->db->get();
        return $query->result();           
    }
    
    // Insert new reservation
    function insert_reservation($arrival, $departure, $roomSelection, $nights, $charge, $fName, $lName, $email, $cardName, $cardType, $cardNum, $expMonth, $expYear, $secCode)
    {
        $expDate = date('Y-m-d', strtotime($expYear.'-'.$expMonth));
        $this->db->insert('reservations', array(
            'room' => $roomSelection,
            'arrival' => date('Y-m-d', strtotime($arrival)),
            'departure' => date('Y-m-d', strtotime($departure)),
            'nights' => $nights,
            'charge' => $charge,
            'first_name' => $fName,
            'last_name' => $lName,
            'email' => $email,
            'cardholder_name' => $cardName,
            'card_type' => $cardType,
            'card_number' => $cardNum,
            'exp_date' => $expDate,
            'security_code' => $secCode
        ));        
    }
}