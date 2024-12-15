<?php
class Surgery_model extends CI_Model{
	public function __construct()
		{		
		$this->load->database();
	}
	
	public function get_details($id=null)
	//called by fitness/get_details_id, surgery/get_id_add, surgery/get_id_allot, surgery/get_id_edit
	{
		$query=$this->db->select('*');
		$query=$this->db->from ('surgery');
		$query=$this->db->where('id',$id);
		$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->row_array();
		else:
		return false;
		endif;
	}
	
	public function get_mdata()
	//called by surgery/add
	{
		$query=$this->db->field_data('surgery');
		return $query;
	}
	
	public function add($data)
	//called by surgery/add
	{
		if ($this->db->insert('surgery',$data)):
		return true;
		else:
		return false;
		endif;
		
	}	

	public function update($data)
	//called by surgery/edit
	{
		if($this->db->replace('surgery',$data)):
		return true;
		else:
		return false;
		endif;
	}

	public function get_max_ipno()
		//called by surgery/get_id_allot
		{
			$query=$this->db->select_max('ipno');
			$query=$this->db->from('surgery');
			$query=$this->db->get();
			if ($query):
				return $query->row();
			else:
				return false;
			endif;
		}
		
	public function allot_ip($data)
	//called by surgery/allotip
	{
	$query=$this->db->where('id',$data['id']);
	$query=$this->db->update('surgery',array('ipno'=>$data['ipno']));
		if ($query):
		return true;
		else:
		return false;
		endif;
	
	
	}
	
	public function get_details_date($dos)
	//called by surgery/get_date
	{
		$query=$this->db->select('*');
		$query=$this->db->from ('surgery');
		$query=$this->db->where('dos',$dos);
		$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->row_array();
		else:
		return false;
		endif;
	}
	
	public function get_details_opd_sur_preop($dos)
	//called by surgery/get_date
	{
	$query=$this->db->select('opd.name, opd.language, surgery.eye, surgery.gvp, opd.dm, opd.htn, surgery.remark');
	$query=$this->db->from('surgery');
	$query=$this->db->join('opd','surgery.id=opd.id','inner');
	$query=$this->db->where('surgery.dos',$dos);
	$query=$this->db->order_by('opd.name','ASC');
	$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->result_array();
		else:
		return false;
		endif;
	}

	public function get_details_opd_sur_ipcard($dos)
	//called by surgery/get_date
	{
	$query=$this->db->select('opd.name, opd.add1, opd.add2, opd.taluq, opd.district, opd.phone, opd.dm, opd.htn, opd.dob, opd.sex, opd.language, surgery.id, surgery.gvp, surgery.eye, surgery.k1, surgery.k2, surgery.al, surgery.iol, surgery.bm, surgery.rbs, surgery.ecg, surgery.sac, surgery.iop, surgery.hiv, surgery.hbsag, surgery.remark, surgery.surgeon');
	$query=$this->db->from('surgery');
	$query=$this->db->join('opd','surgery.id=opd.id','inner');
	$query=$this->db->where('surgery.dos',$dos);
	$query=$this->db->order_by('opd.name','ASC');
	$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->result_array();
		else:
		return false;
		endif;
	}

	public function get_details_opd_sur_discharge($dos)
	//called by surgery/get_date, surgery/print_discharge
	{
	$query=$this->db->select('opd.name, opd.add1, opd.add2, opd.taluq, opd.district, opd.phone, opd.dm, opd.htn, opd.dob, opd.sex, opd.language, surgery.id, surgery.ipno, surgery.gvp, surgery.eye, surgery.k1, surgery.k2, surgery.al, surgery.iol, surgery.bm, surgery.surgeon ');
	$query=$this->db->from('surgery');
	$query=$this->db->join('opd','surgery.id=opd.id','inner');
	$query=$this->db->where('surgery.dos',$dos);
	$query=$this->db->where('surgery.ipno !=',0);
	$query=$this->db->where('surgery.ipno !=',null);
	$query=$this->db->order_by('surgery.ipno','ASC');
	$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->result_array();
		else:
		return false;
		endif;
	}
	
	
	public function array_sort($array, $on, $order=SORT_ASC)
	//called by surgery/get_date
	
	{

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
	public function db_backup()
	//called by surgery/get_date, misc/backup
{
       $pref=array(
		'add_drop'=> TRUE,
		'add_insert'=>TRUE,
		'foreign_key_checks'=>FALSE);
       $backup = $this->dbutil->backup($pref);  
       write_file(SAVEPATH.date('dmYHi').".zip", $backup);
}

	public function write_csv($data, $file)
	//called by surgery/discharge
	{
	$fp=fopen(SAVEPATH.$file,'w');
	foreach ($data as $fields){
	fputcsv($fp,$fields,',');
	}
	fclose($fp);

	}
	
	public function count_surgery($s, $sdate, $edate)
		{
	//called by misc/get_dates
		$query=$this->db->select('id');
		$query=$this->db->from('surgery');
		$query=$this->db->join('opd', 'opd.id=surgery.id', 'inner');
		$query=$this->db->where('surgery.dos>=',$sdate);
		$query=$this->db->where('surgery.dos<=',$edate);
		$query=$this->db->where('surgery.ipno !=',0);
		$query=$this->db->where('surgery.ipno !=',null);
		$query=$this->db->where('opd.sex',ucfirst($s));
		$m = $this->db->count_all_results();
		if ($m!=0):
		return $m;
		else:
		return false;
		endif;
	}

	public function get_details_opd_sur_dbcs($sdate,$edate)
	{
	//called by mis/get_dates
	
	$query=$this->db->select('opd.name, opd.add1, opd.add2, opd.taluq, opd.district, opd.phone, opd.dob, opd.sex, surgery.eye, surgery.iol, surgery.dos');
	$query=$this->db->from('surgery');
	$query=$this->db->join('opd','surgery.id=opd.id','inner');
	$query=$this->db->where('surgery.dos>=',$sdate);
	$query=$this->db->where('surgery.dos<=',$edate);
	$query=$this->db->where('surgery.ipno !=',0);
	$query=$this->db->where('surgery.ipno !=',null);
	$query=$this->db->order_by('surgery.ipno','ASC');
	$query=$this->db->get();
		if ($query && $query->num_rows()>0):
		return $query->result_array();
		else:
		return false;
		endif;
	

	
	}




}
?>
