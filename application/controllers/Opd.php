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
		$this->load->model('Taluq_model');
		$this->output->enable_profiler(TRUE);

	}
	
	public function add($adhar=null)
	{
		//validation rules
		$reqd=array('adhar', 'name', 'add1', 'taluq', 'district', 'dob', 'sex', 'language'); 
		foreach ($reqd as $key):
				$this->form_validation->set_rules($key, ucfirst($key), 'trim|required');
		endforeach;
		$data['adhar']=$adhar;	
		//new form or failed validation
	if (!isset($_POST)||$this->form_validation->run()==false):
		$taluq=$this->Taluq_model->getall();
		$option=array();
		$option=array(''=>'Select');
		foreach ($taluq as $t=>$v):
		//$option[]=array($v['name']=>$v['name']);
		$option[$v['name']]=$v['name'];
		endforeach;
		$data['patients']=array(
						array('label'=>'name', 'name'=>'name','max_len'=>'30'),
						array('label'=>'address1', 'name'=>'add1','max_len'=>'30'),
						array('label'=>'address2', 'name'=>'add2','max_len'=>'30'),
						array('label'=>'taluq', 'name'=>'taluq','options'=>$option),
						array('label'=>'district', 'name'=>'district','max_len'=>'30'),
						array('label'=>'phone', 'name'=>'phone','max_len'=>'15'),
						array('label'=>'YOB', 'name'=>'dob','max_len'=>'4'),
						array('label'=>'sex', 'name'=>'sex', 'options'=>array (''=>'Select','M'=>'Male', 'F'=>'Female')),
						array('label'=>'language', 'name'=>'language', 'options'=>array (''=>'Select','K'=>'Kannada', 'M'=>'Marathi','H'=>'Hindi'))

						);
		$data['history']=array(
						array ('label'=>'History of DM','label1'=>'Years', 'label2'=>'Months', 'name1'=>'dmy', 'name2'=>'dmm', 'max_len'=>'2'),
						array ('label'=>'History of HTN','label1'=>'Years', 'label2'=>'Months', 'name1'=>'hty', 'name2'=>'htm', 'max_len'=>'2')
						);
		$data['remark']=array('label'=>'Remark-Only critical e.g. h/o Cardiac/Psychic ailments', 'name'=>'remark', 'max_len'=>'50');
		
		$this->load->view('templates/header');
		$this->load->view('opd/add', $data);
		$this->load->view('templates/footer');
		
		
		//validated
	else:
		
		//get dob
		//$y=$_POST['dob'];
		//$yob=Date("Y")-$y;
		//$_POST['dob']=$yob."-01-01";
		$_POST['dob']=$_POST['dob']."-01-01";
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
		redirect('opd/get_adhar', 'refresh');
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
			
			die ($this->load->view('templates/header','',TRUE). "Patient not found <a href=".site_url('home').">Go home</a href>");
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
		die ($this->load->view('templates/header','',TRUE). "Patient not found <a href=".site_url('home').">Go home</a href>");
		endif;
	}
	
	public function get_id_edit(){
		//set validation rules
		$this->form_validation->set_rules('id','ID','required|numeric');
		
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
				$this->load->view('templates/header');
				$this->output->append_output("ID Not Found<br>");
				$this->output->append_output("<a href=".site_url('opd/get_id_edit').">Try Again</a href>");
				
				
				//echo "ID not found"."<br>";
				//echo "<a href=".site_url('opd/get_id_edit').">Try Again</a href>";
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
			$this->form_validation->set_rules('adhar','Adhar Number','required|numeric|regex_match[/^[0-9]{12}$/]');
			//failed validation or new
			if ($this->form_validation->run()==false):	
				$id= $this->uri->segment(3);
				if (!$row=$this->opd_model->get_details_opd($id)):
				die ('Query Failed');
				endif;
				$taluq=$this->Taluq_model->getall();
				$option=array();
				$option=array(''=>'Select');
				foreach ($taluq as $t=>$v):
				//$option[]=array($v['name']=>$v['name']);
				$option[$v['name']]=$v['name'];
				endforeach;	
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
			//$row['age']=Date('Y')-$year[0];
			$row['age']=$year[0];	
			$data['patients']=array(
					array('label'=>'adhar No', 'name'=>'adhar','max_len'=>'12', 'value'=>$row['adhar']),
					array('label'=>'name', 'name'=>'name','max_len'=>'30', 'value'=>$row['name']),
					array('label'=>'address1', 'name'=>'add1','max_len'=>'30', 'value'=>$row['add1']),
					array('label'=>'address2', 'name'=>'add2','max_len'=>'30', 'value'=>$row['add2']),
					array('label'=>'taluq', 'name'=>'taluq','max_len'=>'30', 'options'=>$option,'value'=>$row['taluq']),
					array('label'=>'district', 'name'=>'district','max_len'=>'30', 'value'=>$row['district']),
					array('label'=>'phone', 'name'=>'phone','max_len'=>'15', 'value'=>$row['phone']),
					array('label'=>'YOB', 'name'=>'dob','max_len'=>'4', 'value'=>$row['age']),
					array('label'=>'sex', 'name'=>'sex', 'options'=>array (''=>'Select','M'=>'Male', 'F'=>'Female'), 'value'=>$row['sex']),
					array('label'=>'language', 'name'=>'language', 'options'=>array (''=>'Select','K'=>'Kannada', 'M'=>'Marathi','H'=>'Hindi'), 'value'=>$row['language'])
					);
			$data['history']=array(
					array ('label'=>'History of DM','label1'=>'Years', 'label2'=>'Months', 'name1'=>'dmy', 'name2'=>'dmm', 'max_len'=>'2', 'val1'=>$row['dmy'], 'val2'=>$row['dmm']),
					array ('label'=>'History of HTN','label1'=>'Years', 'label2'=>'Months', 'name1'=>'hty', 'name2'=>'htm', 'max_len'=>'2', 'val1'=>$row['hty'], 'val2'=>$row['htm'])
					);
			//critical history
			//$data['chistory']=array('label1'=>'HIV', 'label2'=>'HbsAg', 'label3'=>'ECG', 'name1'=>'hiv', 'name2'=>'hbsag', 'name3'=>'ecg', 'val1'=>$row['hiv'], 'val2'=>$row['hbsag'], 'val3'=>$row['ecg'], 'max_len'=>'10','option1'=>array(''=>'Select','positive'=>'Positive', 'negative'=>'Negative',), 'option2'=>array(''=>'Select','changes'=>'Changes', 'wnl'=>'WNL'));
			$data['remark']=array('label'=>'remark', 'name'=>'remark', 'max_len'=>'50', 'value'=>$row['remark']);
			$this->load->view('templates/header');
			$this->load->view('opd/edit', $data);
			$this->load->view('templates/footer');	
			else:
			
			
			// valid
				//get dob
				//$y=$_POST['dob'];
				//$yob=Date("Y")-$y;
				$_POST['dob']=$_POST['dob']."-01-01";
		
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
					redirect('opd/get_id_edit', 'refresh');

				else:
					echo "Could not update <a href=".site_url('home').">Go home</a href>";
				endif;
			endif;
		
	}
		
	public function get_date_view(){
			$this->load->view('templates/header');
			$this->load->view('opd/get_date_view');	
			//echo "<a href=".site_url('home').">Go home</a href>";
			$this->load->view('templates/footer');
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
				unset ($patients[$patients1]['add1'], $patients[$patients1]['add2'], $patients[$patients1]['taluq'],$patients[$patients1]['phone'],$patients[$patients1]['district'],$patients[$patients1]['address'], $patients[$patients1]['date'],$patients[$patients1]['dm'],$patients[$patients1]['htn'],$patients[$patients1]['remark'],$patients[$patients1]['language'], $patients[$patients1]['hiv'], $patients[$patients1]['hbsag'], $patients[$patients1]['ecg'], $patients[$patients1]['adhar'], $patients[$patients1]['advice']);
				$dobym=$this->opd_model->finddiff($pdata['dob']);
				$patients[$patients1]['dob']=$dobym[0];
			endforeach;
			$data['patients']=$patients;
			$data['hdr']=array('Id', 'OPD No', 'Name', 'Address','Age', 'Sex');
			$this->load->view('templates/header');
			$this->load->view('opd/opd_date', $data);
			$this->load->view('templates/footer');
		endif;
	endif;
}
	
	
	public function print_opd_date($date=null)
	{
		$date=$this->uri->segment(3);
		$patients=$this->opd_model->get_details_date($date);
		$patientsdm=$patients;
		foreach ($patients as $patients1=>$pdata):
				$patients[$patients1]['address']=$pdata['add1'].", ".$pdata['add2'].", ".$pdata['taluq'].", ".$pdata['district'].", ".$pdata['phone'];
				//array_splice($patients[$patients1],3,0,$patients[$patients1]['address']);
				unset ($patients[$patients1]['add1'], $patients[$patients1]['add2'], $patients[$patients1]['taluq'],$patients[$patients1]['phone'],$patients[$patients1]['district'],$patients[$patients1]['date'],$patients[$patients1]['dm'],$patients[$patients1]['htn'],$patients[$patients1]['remark'],$patients[$patients1]['language'], $patients[$patients1]['advice'], $patients[$patients1]['hiv'], $patients[$patients1]['hbsag'], $patients[$patients1]['ecg'], $patients[$patients1]['adhar']);
				$dobym=$this->opd_model->finddiff($pdata['dob']);
				$patients[$patients1]['dob']=$dobym[0];
		endforeach;
		
		foreach ($patientsdm as $patients1=>$pdata):
				$patientsdm[$patients1]['name']=$pdata['name'].", ".$pdata['add1'].", ".$pdata['add2'].", ".$pdata['taluq'].", ".$pdata['district'].", ".$pdata['phone'];
				//array_splice($patients[$patients1],3,0,$patients[$patients1]['address']);
				unset ($patientsdm[$patients1]['add1'], $patientsdm[$patients1]['add2'], $patientsdm[$patients1]['taluq'],$patientsdm[$patients1]['phone'],$patientsdm[$patients1]['district'],$patientsdm[$patients1]['date'],$patientsdm[$patients1]['remark'],$patientsdm[$patients1]['language'], $patientsdm[$patients1]['advice'], $patientsdm[$patients1]['htn'], $patientsdm[$patients1]['hiv'], $patientsdm[$patients1]['hbsag'], $patientsdm[$patients1]['ecg'], $patientsdm[$patients1]['adhar']);
				$dobym=$this->opd_model->finddiff($pdata['dob']);
				$patientsdm[$patients1]['dob']=$dobym[0];
				
				if ("0000-00-00"==$patientsdm[$patients1]['dm']):
				$patientsdm[$patients1]['dm1']="No History";
				else:
				$dmym=$this->opd_model->finddiff($patientsdm[$patients1]['dm']);
				$patientsdm[$patients1]['dm1']="On Rx since ".$dmym[0]." Y ".$dmym[1]." m";
				endif;
				unset ($patientsdm[$patients1]['dm']);
				$patientsdm[$patients1]['rbs']='';
				
			
		endforeach;
		
		
		
		$data['patients']=$patients;
		$data['patientsdm']=$patientsdm;
		$data['hdr']=array('Id', 'OPD No', 'Name', 'Address','Age', 'Sex');
		$data['hdrdm']=array('Id', 'OPD No', 'NameAdd', 'Age', 'Sex', 'HO_DM');
		$data['date']=$date;
		$this->load->view('opd/opd_date_print', $data);
		$this->load->view('templates/header');
		$this->output->append_output("OPD Register printed at ".SAVEPATH."<br>");
		$this->output->append_output("<a href=".site_url('home').">Go home</a>");
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
				$this->load->view('templates/header');
				$this->output->append_output("ID not found<br>");
				$this->output->append_output("<a href=".site_url('home').">Go home</a>");
				//echo "ID not found"."<br>";
				//echo "<a href=".site_url('home').">Go home</a href>";
			else:
				$redirect="red";
				$this->print_opd($id,$redirect);
			endif;
		endif;
	}
	
		public function get_adhar(){
		
		//set validation rules
		$this->form_validation->set_rules('adhar','Adhar Number','required|numeric|regex_match[/^[0-9]{12}$/]');
		
		//new form or failed validation:
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('opd/get_adhar');
			$this->load->view('templates/footer');
		else:
		//validated:
			$adhar=$this->input->post('adhar');
			//adhar is not found in opd
			if(!$this->opd_model->get_details_adhar($adhar)):
				unset($_POST);
				$this->add($adhar);
			else:
			//adhar is found in opd.
				$detwithadhar = $this->opd_model->get_details_adhar($adhar);
				if($detwithadhar['ecg']=='changes'||$detwithadhar['hiv']=='positive'||$detwithadhar['hbsag']=='positive'):
				
				$this->load->view('templates/header');
				$this->load->view('opd/noadd',$detwithadhar);
				$this->load->view('templates/footer');
				else:
				unset($_POST);
				$this->add_adhar($detwithadhar);
				endif;
			endif;	
		endif;
		}
		
	
		public function get_id_crhistory($id=null){
		//set validation rules
		$this->form_validation->set_rules('id','ID','required');
		
		//new form or failed validation:
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('opd/get_id_crhistory');
			$this->load->view('templates/footer');
		else:
		//validated:
			//check if id exists
			$id=$this->input->post('id');
			if (!$this->opd_model->get_details_opd($id)):
				$this->load->view('templates/header');
				$this->output->append_output("ID not found<br>");
				$this->output->append_output("<a href=".site_url('home').">Go home</a>");
				//echo "ID not found"."<br>";
				//echo "<a href=".site_url('home').">Go home</a href>";
			else:
				unset($_POST);
				redirect('opd/update_crhistory/'.$id);
			endif;
		endif;
	}
	
	
	
		public function update_crhistory(){
			
			if (!isset($_POST)||empty($_POST)):		
				$id= $this->uri->segment(3);
				if (!$row=$this->opd_model->get_details_opd($id)):
					die ("Query Failed <a href=".site_url('opd/get_id_crhistory').">Try again</a>");
					
				else:
				
				//critical history
				$row['chistory']=array('label1'=>'HIV', 'label2'=>'HbsAg', 'label3'=>'ECG', 'name1'=>'hiv', 'name2'=>'hbsag', 'name3'=>'ecg', 'val1'=>$row['hiv'], 'val2'=>$row['hbsag'], 'val3'=>$row['ecg'], 'max_len'=>'10','option1'=>array(''=>'Select','positive'=>'Positive', 'negative'=>'Negative',), 'option2'=>array(''=>'Select','changes'=>'Changes', 'wnl'=>'WNL'));
				$this->load->view('templates/header');
				$this->load->view('opd/update_crhistory', $row);
				$this->load->view('templates/footer');
				endif;
			else:
				unset($_POST['submit']);
				$id=$_POST['id'];
				unset($_POST['id'])	;
				
				if ($this->opd_model->opd_update($_POST, $id)):
					redirect('opd/get_id_crhistory', 'refresh');

				else:
					echo "Could not update <a href=".site_url('home').">Go home</a href>";
				endif;
				
			endif;
		
		
		
		}
		
		public function add_adhar($row=null){
		if (!isset($_POST)||empty($_POST)):
		
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
				//$row['age']=Date('Y')-$year[0];
				$row['age']=$year[0];	
				$data['id']=$row['id'];
				$data['adhar']=$row['adhar'];
				$data['patients']=array(
						array('label'=>'name', 'name'=>'name','max_len'=>'30', 'value'=>$row['name']),
						array('label'=>'address1', 'name'=>'add1','max_len'=>'30', 'value'=>$row['add1']),
						array('label'=>'address2', 'name'=>'add2','max_len'=>'30', 'value'=>$row['add2']),
						array('label'=>'taluq', 'name'=>'taluq','max_len'=>'30', 'value'=>$row['taluq']),
						array('label'=>'district', 'name'=>'district','max_len'=>'30', 'value'=>$row['district']),
						array('label'=>'phone', 'name'=>'phone','max_len'=>'15', 'value'=>$row['phone']),
						array('label'=>'YOB', 'name'=>'dob','max_len'=>'4', 'value'=>$row['age']),
						array('label'=>'sex', 'name'=>'sex', 'max_len'=>'1', 'value'=>$row['sex']),
						array('label'=>'language', 'name'=>'language', 'max_len'=>'1', 'value'=>$row['language'])
						);
				$data['history']=array(
						array ('label'=>'History of DM','label1'=>'Years', 'label2'=>'Months', 'name1'=>'dmy', 'name2'=>'dmm', 'max_len'=>'2', 'val1'=>$row['dmy'], 'val2'=>$row['dmm']),
						array ('label'=>'History of HTN','label1'=>'Years', 'label2'=>'Months', 'name1'=>'hty', 'name2'=>'htm', 'max_len'=>'2', 'val1'=>$row['hty'], 'val2'=>$row['htm'])
						);
				
				$data['remark']=array('label'=>'remark', 'name'=>'remark', 'max_len'=>'50', 'value'=>$row['remark']);
				$this->load->view('templates/header');
				$this->load->view('opd/add_adhar', $data);
				$this->load->view('templates/footer');		
			else:
					
		
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
				
				//dob
				$_POST['dob']=$_POST['dob']."-01-01";
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
				$remove=array('id', 'dmy', 'dmm', 'hty', 'htm', 'submit');
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
}
?>	
	
		
