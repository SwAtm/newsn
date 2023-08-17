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

	public function get_number($sname){
	//called by surgery/print_discharge
	$sql=$this->db->select('No');
	$sql=$this->db->from('contacts');
	$sql=$this->db->where('Name',$sname);
	$sql=$this->db->get();
	return $sql->row_array();
	
	}

}
