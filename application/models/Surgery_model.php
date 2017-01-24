<?php
class Surgery_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_details($oid=null)
	{
		$query=$this->db->select('*');
		$query=$this->db->from ('surgery');
		$query=$this->db->where('oid',$oid);
		$query=$this->db->get();
		if ($query->num_rows()>0):
		return true;
		else:
		return false;
		endif;
	}
	
	

}
?>
