<?php
class Patients extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('patients_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('table');
		$this->load->helper('pdf_helper');
	}
	
	public function add()
	{
		//validation rules
		foreach ($_POST as $key=>$value):
			if ('phone'==$key||'add2'==$key||'dmy'==$key||'dmm'==$key||'hty'==$key||'htm'==$key||'remark'==$key):
				continue;
			endif;
		$this->form_validation->set_rules($key, ucfirst($key), 'trim|required');
		endforeach;
		
		//new form or failed validation
		if ($this->form_validation->run()==false):
		$data['patients']=array(
						array('label'=>'name', 'name'=>'name','max_len'=>'30'),
						array('label'=>'address', 'name'=>'add1','max_len'=>'30'),
						array('label'=>'address', 'name'=>'add2','max_len'=>'30'),
						array('label'=>'taluq', 'name'=>'taluq','max_len'=>'30'),
						array('label'=>'district', 'name'=>'district','max_len'=>'30'),
						array('label'=>'phone', 'name'=>'phone','max_len'=>'15'),
						array('label'=>'age', 'name'=>'dob','max_len'=>'2'),
						array('label'=>'sex', 'name'=>'sex', 'options'=>array (''=>'Select','M'=>'Male', 'F'=>'Female')),
						array('label'=>'language', 'name'=>'language', 'options'=>array (''=>'Select','K'=>'Kannada', 'M'=>'Marathi','H'=>'Hindi'))

						);
		$data['history']=array(
						array ('label'=>'History of DM','label1'=>'Years', 'label2'=>'Months', 'name1'=>'dmy', 'name2'=>'dmm', 'max_len'=>'2'),
						array ('label'=>'History of HTN','label1'=>'Years', 'label2'=>'Months', 'name1'=>'hty', 'name2'=>'htm', 'max_len'=>'2')
						);
		$data['remark']=array('label'=>'remark', 'name'=>'remark', 'max_len'=>'50');
		
		$this->load->view('templates/header');
		$this->load->view('patients/add', $data);
		
		
		//validated
		else:
		
		//get dob
		$y=$_POST['dob'];
		$yob=Date("Y")-$y;
		$_POST['dob']=$yob."-01-01";
		
		//get dm and htn
		if (''==$_POST['dmy']||'0'==$_POST['dmy'] AND ''==$_POST['dmm']||'0'==$_POST['dmm']):
			$_POST['dm']='';
		else:
			$dmsic=$this->patients_model->finddate($_POST['dmy'],$_POST['dmm']);
			$_POST['dm']=$dmsic[0]."-".$dmsic[1]."-01";
		endif;
		
		if (''==$_POST['hty']||'0'==$_POST['hty'] AND ''==$_POST['htm']||'0'==$_POST['htm']):
			$_POST['htn']='';
		else:
			$dmsic=$this->patients_model->finddate($_POST['hty'],$_POST['htm']);
			$_POST['htn']=$dmsic[0]."-".$dmsic[1]."-01";
		endif;
		
		//set date
		$_POST['date']=Date('Y-m-d');
		
		//get opd
		if(!$opdno=$this->patients_model->get_max_opdno($_POST['date'])):
			$opdno=1;
		else:
			$opdno=$opdno->opdno+1;
		endif;
		$_POST['opdno']=$opdno;
		
		//unset unncessary post data
		$remove=array('dmy', 'dmm', 'hty', 'htm', 'submit');
		foreach ($remove as $rm):
		unset ($_POST[$rm]);
		endforeach;
		
		//populate $data
		foreach ($_POST as $key=>$value):
			$data[$key]=$value;
		endforeach;
		unset($_POST);
		//print_r($data);
		
				
		//add to db
		if ($this->patients_model->add_to_db($data)):
			//get id for printing
			if ($id=$this->patients_model->get_id($data['opdno'], $data['date'])):
			$id=$id->id;
			$this->print_opd($id);
			else:
			die ("Could not get id");
			endif;
		else:
			die ("Could not update db");
		endif;
					
			
		endif;	
	}
	
		public function print_opd($id=null)
	{
		//query data from db
		if (!$data=$this->patients_model->get_details_opd($id)):
			die ("Sorry, ID not found. Pl check");
		else:
		//convert dm, htn, dob to years/months
			if ("0000-00-00"==$data['dm']):
			$data['dm']="No History";
			else:
			$dmym=$this->patients_model->finddiff($data['dm']);
			$data['dmy']=$dmym[0];
			$data['dmm']=$dmym[1];
			$data['dm']="On Rx since ".$data['dmy']." Y ".$data['dmm']." m";
			endif;
		
			if ("0000-00-00"==$data['htn']):
			$data['htn']="No History";
			else:
			$htym=$this->patients_model->finddiff($data['htn']);
			$data['hty']=$htym[0];
			$data['htm']=$htym[1];
			$data['htn']="On Rx since ".$data['hty']." Y ".$data['htm']." m";
			endif;
			
			$year=explode('-', $data['dob']);
			$data['age']=Date('Y')-$year[0];
			
			
		
		
		//unset dm, htn, dob
		$remove=array('dob');
		foreach ($remove as $rem):
			unset($data[$rem]);
		endforeach;
		
		print_r($data);
		endif;
		
		//include view file
		$this->load->view('patients/printopd',$data);

			
		//echo $id;
		//redirect('patients/add', 'refresh');
		//echo "printing";
	}	
	
	
	public function search()
	{
		$this->load->view('templates/header');
		$this->load->view('patients/search');
		$this->load->view('templates/footer');
	}
	
	public function get_list($name=null)
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('patients/search');
		else:
			$name=$this->input->post('name');
			if ($this->patients_model->get_list($name)):
			$data['patients']=$this->patients_model->get_list($name);
			else:
			die ("Patient not found <a href=".site_url('home').">Go home</a href>");
			endif;
			$this->load->view('templates/header');
			$this->load->view('patients/list', $data);
		endif;
		}
		
	public function get_details_id($id=null)
	{
		if (!empty($_POST)):
			$this->form_validation->set_rules('id','ID','required');
			if ($this->form_validation->run()==false):
				$this->load->view('templates/header');
				$this->load->view('patients/search');
				return;
			else:
			$id=$this->input->post('id');
			endif;
		endif;
		if ($this->patients_model->get_details_opd($id)):
		$data['patients']=$this->patients_model->get_details_opd($id);
		$data['spatients']=$this->patients_model->get_details_surgery($id);
		$this->load->view('templates/header');
		$this->load->view('patients/details',$data);
		else:
		die ("Patient not found <a href=".site_url('home').">Go home</a href>");
		endif;
	}
	
	
	/*public function get_list_pid($pid=null)
	{
		$this->form_validation->set_rules('pid', 'PID', 'required');
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('patients/search');
		else:
		$pid=$this->input->post('pid');
		$data['patients']=$this->patients_model->get_details_opd($pid);
		$data['spatients']=$this->patients_model->get_details_surgery($pid);
		$this->load->view('templates/header');
		$this->load->view('patients/details',$data);
		endif;
	}*/	

	/*public function get_list_oid($oid=null)
	{
		$this->form_validation->set_rules('oid', 'OID', 'required');
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('patients/search');
		else:
		$oid=$this->input->post('oid');
		//echo $oid;
		$result=$this->patients_model->get_pid($oid);
		//print_r($result);
		if (!$result):
			die ("Not found <a href=".site_url('home').">Go home</a>");
		endif;
		$pid=$result->pid;
		$data['patients']=$this->patients_model->get_details_opd($pid);
		$data['spatients']=$this->patients_model->get_details_surgery($pid);
		$this->load->view('templates/header');
		$this->load->view('patients/details',$data);
		endif;
	}
		*/
	
	
	
	
}
?>	
	
		
