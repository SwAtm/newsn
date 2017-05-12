<?php
class Patients_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_list($name)
	//called by patients/get_list
	{
		$query=$this->db->select('id, name, add1, add2, phone');
		$query=$this->db->from('patients');
		$query=$this->db->like('name',$name);
		$query=$this->db->order_by('name','asc');
		$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->result_array();
		else:
		return false;
		endif;
	}
	
	public function get_details_opd($id)
	//called by patients/get_details_id, fitness/get_details_id, fitness/add_update
	
	{
		$query=$this->db->select('*');
		$query=$this->db->from('patients');
		$query=$this->db->where('id',$id);
		$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->row_array();
		else:
		return false;
		endif;
	}

	public function get_details_surgery($id)
		//called by patients/get_details_id

	{
		$query=$this->db->select('patients.id, patients.name, patients.add1, patients.add2, patients.phone, surgery.ipno, surgery.dos, surgery.eye, surgery.surgeon');
		$query=$this->db->from('patients');
		$query=$this->db->join('surgery','patients.id=surgery.id','left');
		$query=$this->db->where('patients.id',$id);
		$query=$this->db->get();
		return $query->row_array();
		
	}
	
		public function get_mdata()
	//called by patients/add
	{
		$query=$this->db->field_data('patients');
		return $query;
	}

		public function finddate ($y,$m) 
		{
		//called by patients/add	
			
			if ($y==0):
				$y=Date("Y");
			else:
				$y=Date("Y")-$y;
			endif;
			if ($m>Date("m")):
				$m=$m-Date("m");
				$m=12-$m;
				$y=$y-1;
			elseif ($m==Date("m")):
				$m=1;
			else:
				$m=Date("m")-$m;
			endif;
		return array($y, $m);
	}
	
		public function get_max_opdno($date=null)
		//called by patients/add
		{
			$query=$this->db->select_max('opdno');
			$query=$this->db->from('patients');
			$query=$this->db->where('date', $date);
			$query=$this->db->get();
			if ($query):
				return $query->row();
			else:
				return false;
			endif;
		}
		
		public function add_to_db($data)
		//called by patients/add
	{
		$this->db->insert('patients',$data);
		return true;
	}
	
		public function get_id($opdno, $date)
		//called by patients/add
		{
			$query=$this->db->select('id');
			$query=$this->db->from ('patients');
			$query=$this->db->where('date',$date);
			$query=$this->db->where('opdno', $opdno);
			$query=$this->db->get();
			if ($query):
				return $query->row();
			else:
				return false;
			endif;
		}


		public function finddiff($rowd)
		//find diff bet today and a given date in years and months. given date in yyyy-mm-dd format.
		//called by patients/print_opd
{
		$since=explode('-',$rowd);
		$y1=$since[0];
		$m1=$since[1];
		$y2=Date('Y');
		$m2=Date('m');
			if ($y1==$y2):
				$y=0;
				if ($m1==$m2):
				$m = 1;
				else:
				$m=$m2-$m1;
				endif;
			else:
				$y=$y2-$y1;
				if($m2<$m1):
					$m=12-$m1+$m2;
					$y=$y-1;
				elseif ($m2>$m1):
					$m=$m2-$m1;
				else:
					$m=0;
				endif;
			endif;
	return array($y, $m);
}
			
	
/*	public function get_details_oid($oid)
	{
		$query=$this->db->select('patients.*, opd.oid');
		$query=$this->db->from('patients');
		$query=$this->db->join('opd', 'patients.pid=opd.pid', 'inner');
		$query=$this->db->where('opd.oid',$oid);
		$query=$this->db->get();
		if ($query && $query->num_rows()>0):
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
*/
}
?>




