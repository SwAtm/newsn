<?php
class Surgery_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_details($id=null)
	//called by fitness/get_details_id
	{
		$query=$this->db->select('*');
		$query=$this->db->from ('surgery');
		$query=$this->db->where('id',$id);
		$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return true;
		else:
		return false;
		endif;
	}
	
	

}
?>
