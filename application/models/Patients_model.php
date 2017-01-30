<?php
class Patients_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_list($name)
	{
		$query=$this->db->select('pid, name, add1, add2, phone');
		$query=$this->db->from('patients');
		$query=$this->db->like('name',$name);
		$query=$this->db->order_by('name','asc');
		$query=$this->db->get();
		return $query->result_array();
	}
	
	public function get_details_opd($pid)
	{
		$query=$this->db->select('patients.pid, patients.name, patients.add1, patients.add2, patients.phone, opd.oid, opd.date');
		$query=$this->db->from('patients');
		$query=$this->db->join('opd','patients.pid=opd.pid','inner');
		$query=$this->db->where('patients.pid',$pid);
		$query=$this->db->get();
		return $query->result_array();
	}

	public function get_details_surgery($pid)
	{
		$query=$this->db->select('patients.pid, patients.name, patients.add1, patients.add2, patients.phone, surgery.ipno, surgery.dos, surgery.opd_eye, surgery.Surgeon');
		$query=$this->db->from('patients');
		$query=$this->db->join('surgery','patients.pid=surgery.pid','inner');
		$query=$this->db->where('patients.pid',$pid);
		$query=$this->db->get();
		return $query->result_array();
	}
	
	public function get_details_oid($oid)
	{
		$query=$this->db->select('patients.*, opd.oid');
		$query=$this->db->from('patients');
		$query=$this->db->join('opd', 'patients.pid=opd.pid', 'inner');
		$query=$this->db->where('opd.oid',$oid);
		$query=$this->db->get();
		if ($query->num_rows()>0):
		return $query->row_array();
		else:
		return false;
		endif;
	}
	public function get_pid($oid)
	{
		$query=$this->db->select('pid');
		$query=$this->db->from ('opd');
		$query=$this->db->where('oid',$oid);
		$query=$this->db->get();
		return $query->row();
	}

}




