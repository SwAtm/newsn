<?php
class Fitness_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_details_oid($oid=null)
	{
		$query=$this->db->select('*');
		$query=$this->db->from ('fitness');
		$query=$this->db->where('oid',$oid);
		$query=$this->db->get();
		if ($query->num_rows()>0):
		return $query->result_array();
		else:
		return false;
		endif;
	}
	
	public function add($data)
	{
		$this->db->insert('fitness',$data);
		return true;
	}
	
	public function update($data)
	{
		$this->db->replace('fitness',$data);
		return true;
	}

	public function get_mdata()
	{
		$query=$this->db->field_data('fitness');
		return $query;
	}

}
?>
