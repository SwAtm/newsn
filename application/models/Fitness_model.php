<?php
class Fitness_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_details_id($id=null)
	//called by fitness/get_details_id
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
	//called by fitness/add_update
	{
		$this->db->insert('fitness',$data);
		return true;
	}
	
	public function update($data)
	//called by fitness/add_update
	{
		$this->db->replace('fitness',$data);
		return true;
	}

	public function get_mdata()
	//called by fitness/get_details_id, fitness/add_update
	{
		$query=$this->db->field_data('fitness');
		return $query;
	}

	public function get_details_date($date=null)
	//called by fitness/get_details_date
	{
		$query=$this->db->select('fitness.*, opd.name');
		$query=$this->db->from ('fitness');
		$query=$this->db->join ('opd','fitness.id=opd.id','inner');
		$query=$this->db->where('fitness.date',$date);
		$query=$this->db->order_by('id');
		$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->result_array();
		else:
		return false;
		endif;
	}

}
?>
