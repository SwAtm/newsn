<?php
class Taluq_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function getall(){
	//called by opd/add
	$sql=$this->db->select('*');
	$sql=$this->db->from('taluq');
	$sql=$this->db->get();
	return $sql->result_array();
	}
}	

