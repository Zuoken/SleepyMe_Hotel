<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  

class Dbrooms extends CI_Model {

    var $room_no   = 0;
    var $long_desc = '';
    var $room_desc = '';
    var $rate      = 0;
    
    function __construct()
    {
        parent::__construct();
    }
    
    // Get an array of all rooms and room info
    function get_all_rooms()
    {
        $query = $this->db->get('rooms');
        return $query->result();
    }
	
    // Get single room info by room number
	function get_room($room)
	{
        $this->db->select('room_rate, long_description, room_description, room_no');
        $this->db->from('rooms');
        $this->db->where('room_no', $room);
        $query      = $this->db->get();
        $room_info  = $query->result();
        return $room_info;
	}
    
    // Get room id
    function get_room_id($room)
    {
        $this->db->select('id');
        $this->db->from('rooms');
        $this->db->where('room_no', $room);
        $query      = $this->db->get();
        $room_id    = $query->row();
        return $room_id->id;    
    }
	
    // Enter a new room into the database
    function insert_room($room_no, $room_description, $room_rate, $long_description)
    {     
        $this->db->insert('rooms', array(
               'long_description' => $long_description,
               'room_description' => $room_description,
               'room_no' => $room_no,
               'room_rate' => $room_rate
            ));        
    }
    
    // Update room info
    function update_room($room_id, $room_no, $room_desc, $rate, $long_desc)
    {
        $this->db->where('id', $room_id);   
        $this->db->update('rooms', array(
               'long_description' => $long_desc,
               'room_description' => $room_desc,
               'room_no' => $room_no,
               'room_rate' => $rate
        ));        
    }
    
    // Delete room
    function delete_room($room) {
        $this->db->delete('rooms', array('room_no' => $room));
    }
}