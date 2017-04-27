<?php
class Fitness_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_details_id($id=null)
	{
		$query=$this->db->select('*');
		$query=$this->db->from ('fitness');
		$query=$this->db->where('id',$id);
		$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->row_array();
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

	public function get_details_date($date=null)
	{
		$query=$this->db->select('*');
		$query=$this->db->from ('fitness');
		$query=$this->db->where('date',$date);
		$query=$this->db->order_by('oid');
		$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->result_array();
		else:
		return false;
		endif;
	}

}
?>
