<?php
class Opd extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('opd_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('table');
		$this->load->helper('pdf_helper');
		//$this->output->enable_profiler(TRUE);

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
						array('label'=>'address1', 'name'=>'add1','max_len'=>'30'),
						array('label'=>'address2', 'name'=>'add2','max_len'=>'30'),
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
		$this->load->view('opd/add', $data);
		
		
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
			$dmsic=$this->opd_model->finddate($_POST['dmy'],$_POST['dmm']);
			$_POST['dm']=$dmsic[0]."-".$dmsic[1]."-01";
		endif;
		
		if (''==$_POST['hty']||'0'==$_POST['hty'] AND ''==$_POST['htm']||'0'==$_POST['htm']):
			$_POST['htn']='';
		else:
			$dmsic=$this->opd_model->finddate($_POST['hty'],$_POST['htm']);
			$_POST['htn']=$dmsic[0]."-".$dmsic[1]."-01";
		endif;
		
		//set date
		$_POST['date']=Date('Y-m-d');
		
		//get opd
		if(!$opdno=$this->opd_model->get_max_opdno($_POST['date'])):
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
		if ($this->opd_model->add_to_db($data)):
			//get id for printing
			if ($id=$this->opd_model->get_id($data['opdno'], $data['date'])):
			$id=$id->id;
			$this->print_opd($id);
			else:
			die ("Could not get id");
			endif;
		else:
			die ("Could not add to db");
		endif;
					
			
	endif;	
	}
	
		public function print_opd($id=null, $redirect=null)
	{
		//query data from db
		if (!$data=$this->opd_model->get_details_opd($id)):
			die ("Sorry, ID not found. Pl check");
		else:
		//convert dm, htn, dob to years/months
			if ("0000-00-00"==$data['dm']):
			$data['dm']="No History";
			else:
			$dmym=$this->opd_model->finddiff($data['dm']);
			$data['dmy']=$dmym[0];
			$data['dmm']=$dmym[1];
			$data['dm']="On Rx since ".$data['dmy']." Y ".$data['dmm']." m";
			endif;
		
			if ("0000-00-00"==$data['htn']):
			$data['htn']="No History";
			else:
			$htym=$this->opd_model->finddiff($data['htn']);
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
		
		//print_r($data);
		endif;
		
		//include view file
		$this->load->view('opd/printopd',$data);
		//echo $id;
		if ("red"==$redirect):
		redirect('home/index');
		else:
		redirect('opd/add', 'refresh');
		//echo "printing";
		endif;
	}	
	
	
	public function search()
	{
		$this->load->view('templates/header');
		$this->load->view('opd/search');
		$this->load->view('templates/footer');
	}
	
	public function get_list($name=null)
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('opd/search');
		else:
			$name=$this->input->post('name');
			if ($this->opd_model->get_list($name)):
			$data['patients']=$this->opd_model->get_list($name);
			else:
			die ("Patient not found <a href=".site_url('home').">Go home</a href>");
			endif;
			$this->load->view('templates/header');
			$this->load->view('opd/list', $data);
		endif;
		}
		
	public function get_details_id($id=null)
	{
		if (!empty($_POST)):
			$this->form_validation->set_rules('id','ID','required');
			if ($this->form_validation->run()==false):
				$this->load->view('templates/header');
				$this->load->view('opd/search');
				return;
			else:
			$id=$this->input->post('id');
			endif;
		endif;
		if ($this->opd_model->get_details_opd($id)):
		$data['patients']=$this->opd_model->get_details_opd($id);
		$data['spatients']=$this->opd_model->get_details_surgery($id);
		$this->load->view('templates/header');
		$this->load->view('opd/details',$data);
		else:
		die ("Patient not found <a href=".site_url('home').">Go home</a href>");
		endif;
	}
	
	public function get_id_edit(){
		//set validation rules
		$this->form_validation->set_rules('id','ID','required');
		
		//new form or failed validation:
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('opd/get_id_edit');
			$this->load->view('templates/footer');
		else:
		//validated:
			//check if id exists
			$id=$this->input->post('id');
			if (!$this->opd_model->get_details_opd($id)):
				echo "ID not found"."<br>";
				echo "<a href=".site_url('opd/get_id_edit').">Try Again</a href>";
			else:
				//post false so that edit gets it as unsubmitted form
				//unset($_POST);
				//$_POST=array();
				redirect('opd/edit/'.$id);
			endif;
		endif;
	}
	
	public function edit($id=null){
					
			//set validation rules
			$val=array('name','add1','taluq','district','dob','sex','language');
			foreach ($val as $reqd):
			$this->form_validation->set_rules($reqd, ucfirst($reqd), 'trim|required');
			endforeach;
			//failed validation or new
			if ($this->form_validation->run()==false):	
				$id= $this->uri->segment(3);
				if (!$row=$this->opd_model->get_details_opd($id)):
				die ('Query Failed');
				endif;
				
				//$row=$this->opd_model->get_details_opd($id);
			//print_r($row);
			$data['id']=$id;
			//html_escape($row);
			if ("0000-00-00"==$row['dm']):
				$row['dmy']='';
				$row['dmm']='';
			else:
				$dmym=$this->opd_model->finddiff($row['dm']);
				$row['dmy']=$dmym[0];
				$row['dmm']=$dmym[1];
			endif;
				
			if ("0000-00-00"==$row['htn']):
				$row['hty']='';
				$row['htm']='';
			else:
				$htym=$this->opd_model->finddiff($row['htn']);
				$row['hty']=$htym[0];
				$row['htm']=$htym[1];
			endif;
				
			$year=explode('-', $row['dob']);
			$row['age']=Date('Y')-$year[0];
				
			$data['patients']=array(
					array('label'=>'name', 'name'=>'name','max_len'=>'30', 'value'=>$row['name']),
					array('label'=>'address1', 'name'=>'add1','max_len'=>'30', 'value'=>$row['add1']),
					array('label'=>'address2', 'name'=>'add2','max_len'=>'30', 'value'=>$row['add2']),
					array('label'=>'taluq', 'name'=>'taluq','max_len'=>'30', 'value'=>$row['taluq']),
					array('label'=>'district', 'name'=>'district','max_len'=>'30', 'value'=>$row['district']),
					array('label'=>'phone', 'name'=>'phone','max_len'=>'15', 'value'=>$row['phone']),
					array('label'=>'age', 'name'=>'dob','max_len'=>'2', 'value'=>$row['age']),
					array('label'=>'sex', 'name'=>'sex', 'options'=>array (''=>'Select','M'=>'Male', 'F'=>'Female'), 'value'=>$row['sex']),
					array('label'=>'language', 'name'=>'language', 'options'=>array (''=>'Select','K'=>'Kannada', 'M'=>'Marathi','H'=>'Hindi'), 'value'=>$row['language'])
					);
			$data['history']=array(
					array ('label'=>'History of DM','label1'=>'Years', 'label2'=>'Months', 'name1'=>'dmy', 'name2'=>'dmm', 'max_len'=>'2', 'val1'=>$row['dmy'], 'val2'=>$row['dmm']),
					array ('label'=>'History of HTN','label1'=>'Years', 'label2'=>'Months', 'name1'=>'hty', 'name2'=>'htm', 'max_len'=>'2', 'val1'=>$row['hty'], 'val2'=>$row['htm'])
					);
			$data['remark']=array('label'=>'remark', 'name'=>'remark', 'max_len'=>'50', 'value'=>$row['remark']);
			$this->load->view('templates/header');
			$this->load->view('opd/edit', $data);
				
			else:
			
			
			// valid
				//get dob
				$y=$_POST['dob'];
				$yob=Date("Y")-$y;
				$_POST['dob']=$yob."-01-01";
		
				//get dm and htn
				if (''==$_POST['dmy']||'0'==$_POST['dmy'] AND ''==$_POST['dmm']||'0'==$_POST['dmm']):
					$_POST['dm']='';
				else:
					$dmsic=$this->opd_model->finddate($_POST['dmy'],$_POST['dmm']);
					$_POST['dm']=$dmsic[0]."-".$dmsic[1]."-01";
				endif;
		
				if (''==$_POST['hty']||'0'==$_POST['hty'] AND ''==$_POST['htm']||'0'==$_POST['htm']):
					$_POST['htn']='';
				else:
					$dmsic=$this->opd_model->finddate($_POST['hty'],$_POST['htm']);
					$_POST['htn']=$dmsic[0]."-".$dmsic[1]."-01";
				endif;
				
				//unset unncessary post data
				$remove=array('dmy', 'dmm', 'hty', 'htm', 'submit');
				foreach ($remove as $rm):
					unset ($_POST[$rm]);
				endforeach;
				
				$id=$_POST['id'];
				unset ($_POST['id']);
				if ($this->opd_model->opd_update($_POST, $id)):
					echo "Database updated";
					echo "<a href=".site_url('home').">Go home</a href>";
				else:
					echo "<a href=".site_url('home').">Go home</a href>";
				endif;
			endif;
		
	}
		
	public function get_date_view(){
			$this->load->view('templates/header');
			$this->load->view('opd/get_date_view');	
			echo "<a href=".site_url('home').">Go home</a href>";
	
}
	public function view_date($date=null){
		//set vaidation rule
	$this->form_validation->set_rules('date', 'Date', 'required');
	
	//if ($_POST):
		//$date = isset($_POST['date']) ? $_POST['date'] : "";
	//endif;
	
	if ($this->form_validation->run()==false)	:
		$this->get_date_view();
	else:
		//$date = isset($_REQUEST["date5"]) ? $_REQUEST["date5"] : "";
		$date=$this->input->post('date');
		//print_r($date);
		$date=date('Y-m-d',strtotime($date));
		//print_r($date);
		$data['date']=$date;
		$patients=$this->opd_model->get_details_date($date);
		if (!$patients):
			die ("No OPD on this date. <br><a href=get_date_view>Continue</a>");
		else:
			//$data['mdata']=$this->opd_model->get_mdata();
			
			foreach ($patients as $patients1=>$pdata):
				$patients[$patients1]['address']=$pdata['add1'].", ".$pdata['add2'].", ".$pdata['taluq'].", ".$pdata['district'].", ".$pdata['phone'];
				array_splice($patients[$patients1],3,0,$patients[$patients1]['address']);
				unset ($patients[$patients1]['add1'], $patients[$patients1]['add2'], $patients[$patients1]['taluq'],$patients[$patients1]['phone'],$patients[$patients1]['district'],$patients[$patients1]['address'], $patients[$patients1]['date'],$patients[$patients1]['dm'],$patients[$patients1]['htn'],$patients[$patients1]['remark'],$patients[$patients1]['language']);
				$dobym=$this->opd_model->finddiff($pdata['dob']);
				$patients[$patients1]['dob']=$dobym[0];
			endforeach;
			$data['patients']=$patients;
			$data['hdr']=array('Id', 'OPD No', 'Name', 'Address','Age', 'Sex');
			$this->load->view('opd/opd_date', $data);
		endif;
	endif;
}
	
	
	public function print_opd_date($date=null)
	{
		$date=$this->uri->segment(3);
		$patients=$this->opd_model->get_details_date($date);
		foreach ($patients as $patients1=>$pdata):
				$patients[$patients1]['address']=$pdata['add1'].", ".$pdata['add2'].", ".$pdata['taluq'].", ".$pdata['district'].", ".$pdata['phone'];
				//array_splice($patients[$patients1],3,0,$patients[$patients1]['address']);
				unset ($patients[$patients1]['add1'], $patients[$patients1]['add2'], $patients[$patients1]['taluq'],$patients[$patients1]['phone'],$patients[$patients1]['district'],$patients[$patients1]['date'],$patients[$patients1]['dm'],$patients[$patients1]['htn'],$patients[$patients1]['remark'],$patients[$patients1]['language'], $patients[$patients1]['advice']);
				$dobym=$this->opd_model->finddiff($pdata['dob']);
				$patients[$patients1]['dob']=$dobym[0];
		endforeach;
		$data['patients']=$patients;
		$data['hdr']=array('Id', 'OPD No', 'Name', 'Address','Age', 'Sex');
		$data['date']=$date;
		$this->load->view('opd/opd_date_print', $data);
	
	}

		public function get_id_print(){
		//set validation rules
		$this->form_validation->set_rules('id','ID','required');
		
		//new form or failed validation:
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('opd/get_id_print');
			$this->load->view('templates/footer');
		else:
		//validated:
			//check if id exists
			$id=$this->input->post('id');
			if (!$this->opd_model->get_details_opd($id)):
				echo "ID not found"."<br>";
				echo "<a href=".site_url('home').">Go home</a href>";
			else:
				$redirect="red";
				$this->print_opd($id,$redirect);
			endif;
		endif;
	}

	
}
?>	
	
		
