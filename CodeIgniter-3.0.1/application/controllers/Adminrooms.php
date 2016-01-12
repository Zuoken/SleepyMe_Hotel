<?php
class Adminrooms extends CI_Controller {
	
	public function index()
	{
		$this->load->library('template');
		$TPL['room_edit'] = '';
		$this->template->show('admin_rooms', 'Admin Rooms', $TPL);
	}
		
	public function add() {
		$TPL['room_edit'] = 'add';
		$this->template->show('admin_rooms', 'Admin Rooms', $TPL);
	}
	
	public function insert() {
		$this->load->model('dbrooms');

		$room_no = $this->input->post('room_no');
		
		$room_description = $this->input->post('room_description');
		$room_rate = $this->input->post('room_rate');
		$long_description = $this->input->post('editor');

		$this->dbrooms->insert_room($room_no, $room_description, $room_rate, $long_description);
		
		$TPL['room_edit'] = 'insert';
		$this->template->show('admin_rooms', 'Admin Rooms', $TPL);
	}
	
	public function display() {
		$this->load->model('dbrooms');  
		
		$TPL['room_edit'] = 'display';
		
		$TPL['all_rooms'] = $this->dbrooms->get_all_rooms();
		$this->template->show('admin_rooms', 'Admin Rooms', $TPL);
	}
	
	public function edit($room) {
		$this->load->model('dbrooms');
		
		$TPL['room_edit'] = 'edit';
		
		$TPL['room'] = $this->dbrooms->get_room($room);
		$this->template->show('admin_rooms', 'Admin Rooms', $TPL);
	}
	
	public function delete($room) {
		$this->load->model('dbrooms');
		
		$this->dbrooms->delete_room($room);
		
		$TPL['room_edit'] = 'delete';
		$this->template->show('admin_rooms', 'Admin Rooms', $TPL);
	}
	
	public function update() {
		$this->load->model('dbrooms');

		$room_no = $this->input->post('room_no');
		$room_id = $this->dbrooms->get_room_id($room_no);
		
		$room_description = $this->input->post('room_description');
		$room_rate = $this->input->post('room_rate');
		$long_description = $this->input->post('editor');

		$this->dbrooms->update_room($room_id, $room_no, $room_description, $room_rate, $long_description);
		
		$TPL['room_edit'] = 'update';
		$this->template->show('admin_rooms', 'Admin Rooms', $TPL);
	}
}