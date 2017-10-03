<?php
class Contacts_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_surgeons()
	{
	$sql=$this->db->select('*');
	$sql=$this->db->from('contacts');
	$sql=$this->db->where('category','surgeon');
	$sql=$this->db->get();
	if ($sql && $sql->num_rows()>0):
	return $sql->result_array();
	else:
	return false;
	endif;
	}
}
