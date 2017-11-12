<?php
class Surgery extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('opd_model');
		$this->load->model('fitness_model');
		$this->load->model('surgery_model');
		$this->load->model('contacts_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('table');
		$this->load->helper('pdf_helper');
		$this->load->dbutil();
		$this->load->helper('file');
//		$this->output->enable_profiler(TRUE);
		//$this->define('ENVIRONMENT', 'development');
	}
	
	
	public function get_id_add(){
		//set validation rules:
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		
		//new or failed validation
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('surgery/get_id_add');
			$this->load->view('templates/footer');
		else:
			//check if already in surgery table, fitness table.
			
			$id=$this->input->post('id');
				if ($this->surgery_model->get_details($id)):
					Die ("<a href=".site_url('home').">Record already in Surgery Table, Pl use edit option</a>");
				elseif (!$row=$this->fitness_model->get_details_id($id)):
					Die ("Record not in Fitness Table, <a href=".site_url('fitness/get_id')."> Pl add and come back</a>");
				else:
					redirect('surgery/add/'.$id);
				endif;
		
		endif;
	}
	
	public function add($id){
		
		//unsubmitted:
		
		if (!isset($_POST['submit'])):
			if (!$opd=$this->opd_model->get_details_opd($id) OR !$fitness=$this->fitness_model->get_details_id($id)):
			die ("Data not fetched");
			endif;
			
			if ($opd['remark']!==""):
				$remark=$opd['remark'].", ";
			else:
				$remark="";
			endif;
			
			foreach ($fitness as $key=>$val):
				if ("No"==ucfirst(strtolower($val)) OR "id"==$key OR "date"==$key):
					continue;
				endif;
				$remark.=ucfirst(trim($key)).': '.ucfirst(trim($val)).', ';
			endforeach;
			
			
			if ($surgeon=$this->contacts_model->get_surgeons()):
				foreach ($surgeon as $k=>$v):
					$surgeon1[$v['Hon']." ".$v['Name']]=$v['Hon']." ".$v['Name'];
				endforeach;
			else:
			die ("No surgeon found. Add atleast one in contacts table");
			endif;
			//print_r($surgeon1);
			unset ($surgeon);
			
			
			$data=array();
			$data['opd']=$opd;
			$data['remark']=$remark;
			$data['mdata']=$this->surgery_model->get_mdata();
			$data['surgeon']=$surgeon1;
			$this->load->view('templates/header');
			$this->load->view('surgery/add',$data);
			$this->load->view('templates/footer');
		else:
			$data=$_POST;
			if ($data['gvp']=="no"):
				$data['gvp']=0;
			else:
				$data['gvp']=1;
			endif;
			unset ($data['submit']);
			$data['id']=$_POST['id'];
			$data['dos']=date('Y-m-d', strtotime($data['dos']));
			if ($this->surgery_model->add($data)):
				//echo "Record added<br>";
				redirect('surgery/get_id_add','refresh');
			else:
				echo "Coulnot add record<br>";
				//echo $this->db->_error_message();

			endif;	
				
		endif;
	}
	
	public function get_id_edit(){
		
			//set validation rules:
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		
		//new or failed validation
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('surgery/get_id_edit');
			$this->load->view('templates/footer');
		else:
			
			
			
			//check if record exists in surgery table.
			
				$id=$this->input->post('id');
				if (!$surgery=$this->surgery_model->get_details($id)):
					//$this->load->view('templates/header');
					redirect('surgery/add/'.$id);
				else:
				//check if ipno already allotted.
				$surgery=$this->surgery_model->get_details($id);
					if ($surgery['ipno']!==0 and $surgery['ipno']!==null):
						die("IP No already allotted, <a href=".site_url('home').">Go Home</a>");
					endif;
				$opd=$this->opd_model->get_details_opd($id);
				
				$surgeon=$this->contacts_model->get_surgeons();
				foreach ($surgeon as $k=>$v):
					$surgeon1[$v['Hon']." ".$v['Name']]=$v['Hon']." ".$v['Name'];
				endforeach;
				
			
			
			//print_r($surgeon1);
				unset ($surgeon);
				
				
				unset($surgery['ipno']);
				$data['surgery']=$surgery;
				$data['opd']=$opd;
				$data['surgery']['dos']=date('d-m-Y',strtotime($data['surgery']['dos']));
				$data['surgeon']=$surgeon1;
				$this->load->view('templates/header');
				$this->load->view('surgery/edit',$data);
				$this->load->view('templates/footer');
				//print_r($surgery);
				endif;
		
		endif;
		
				
	}
	
	public function edit($id){
	
		//print_r($_POST);
	
		$data=$_POST;
			if ($data['gvp']=="no"):
				$data['gvp']=0;
			else:
				$data['gvp']=1;
			endif;
			unset ($data['submit']);
			$data['id']=$_POST['id'];
			$data['dos']=date('Y-m-d', strtotime($data['dos']));
			if ($this->surgery_model->update($data)):
				redirect('surgery/get_id_edit','refresh');
				/*$this->load->view('templates/header');
				$this->output->append_output("Record updated<br>");
				$this->output->append_output("<a href=".site_url('home').">Go home</a>");
				*/
			else:
				echo "Coulnot update record<br>";
				echo "<a href=".site_url('home').">Go home</a>";
				//echo $this->db->_error_message();
			endif;
	
	
	}
	
	public function get_id_allot(){
			
			//set validation rules:
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		
		//new or failed validation
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('surgery/get_id_allot');
			$this->load->view('templates/footer');
		else:
			
			//check if record exists in surgery table.
				$id=$this->input->post('id');
				if (!$surgery=$this->surgery_model->get_details($id)):
					die("ID not found<br><a href=".site_url('home').">Go home</a>");
				endif;


				//check if ipno is already allotted
				$surgery=$this->surgery_model->get_details($id);				
				if($surgery['ipno']!==0 AND $surgery['ipno']!==null):
					die("IP No already allotted<br><a href=".site_url('home').">Go home</a>");
				endif;
				
				
				//check for empty fields
				$error='';
				foreach ($surgery as $k=>$v):
					if ('remark'==$k||'ipno'==$k||'gvp'==$k):
						continue;
					endif;
					if ('0000-00-00'==$v||null==$v||''==$v||'0.00'==$v):
						$error.=$k." is empty<br>";
					endif;
				endforeach;
					if (''!==$error):
						$this->load->view('templates/header');
						$this->output->append_output($error);
						$this->output->append_output("<a href=".site_url('surgery/get_id_edit/').">Edit</a>");
							
				
					//no empty fields, all good.
					else:
						$opd=$this->opd_model->get_details_opd($id);
						$ipno=$this->surgery_model->get_max_ipno();
						$ipno=$ipno->ipno+1;
						$data['ipno']=$ipno;
						$data['id']=$id;
						$data['opd']=$opd;
						$this->load->view('templates/header');
						$this->load->view('surgery/allotip',$data);
					endif;
				
		endif;
		
		
	}

		public function allotip(){
				$data['id']=$this->input->post('id');
				$data['ipno']=$this->input->post('ipno');
				
				if ($this->surgery_model->allot_ip($data)):
					$this->load->view('templates/header');
					$this->output->append_output("IP Number Allotted<br>");
					$this->output->append_output("<a href=".site_url('home').">Go home</a>");
					
				else:
					$this->load->view('templates/header');
					$this->output->append_output("IP no not allotted<br>");
					$this->output->append_output("<a href=".site_url('home').">Go home</a>");
				endif;
	
	}

		public function get_date(){
		
			//set vaidation rule
			$this->form_validation->set_rules('dos','Date','trim|required');
			
			//new or failed validation
			if ($this->form_validation->run()==false):
				$this->load->view('templates/header');
				$this->load->view('surgery/get_date');
				$this->load->view('templates/footer');
			else:
				$dos=date('Y-m-d', strtotime($_POST['dos']));
				if (!$this->surgery_model->get_details_date($dos)):
					Die ("Nothing happend on this date. <a href=".site_url('home').">Go Home</a>");
				endif;
				
				
				if (isset($_POST['preop'])):
					$data=$this->surgery_model->get_details_opd_sur_preop($dos);
					//print_r($data);
										
					foreach ($data as $data3=>$v):
						$add1=array('Sl No'=>'');
						$data[$data3]=$add1+$data[$data3];
						$add2=array('Ord No'=>'');
						$data[$data3]=$add2+$data[$data3];
						
					endforeach;
					
					
					$i=1;
					
					
					foreach ($data as $data1=>$value):
						if ($value['gvp']==1):
						$data[$data1]['gvp']="Yes";
						else:
						$data[$data1]['gvp']="No";
						endif;
						if ($value['dm']=='0000-00-00' or $value['dm']==null):
						$data[$data1]['dm']="No";
						else:
						$data[$data1]['dm']="On Rx";
						endif;
						if ($value['htn']=='0000-00-00' or $value['htn']==null):
						$data[$data1]['htn']="No";
						else:
						$data[$data1]['htn']="On Rx";
						endif;
						if($value['remark']!==''):
							$data[$data1]['remark']=str_replace(',',' :: ',$value['remark']);
						endif;
						$data[$data1]['Sl No']=$i;
						$i++;
					endforeach;
					//$patient=$data;
					$data['patients']=$data;
					$data['dos']=$dos;	
					$data['hdr']=array('Ord No','Sl No','Name','Lng','eye','gvp','DM','HTN','Remark');
					$this->load->view('surgery/preop',$data);
					
				elseif (isset($_POST['ipcards'])):
					$data=$this->surgery_model->get_details_opd_sur_ipcard($dos);
					
					foreach ($data as $data1=>$value):
						if ($value['gvp']==1):
						$data[$data1]['gvp']="Yes";
						else:
						$data[$data1]['gvp']="No";
						endif;
						if ($value['dm']=='0000-00-00' or $value['dm']==null):
						$data[$data1]['dm']="No";
						else:
						$dmym=$this->opd_model->finddiff($value['dm']);
						$data[$data1]['dm']="On Rx since ".$dmym[0]." Years and ".$dmym[1]." months";
						endif;
						if ($value['htn']=='0000-00-00' or $value['htn']==null):
						$data[$data1]['htn']="No";
						else:
						$htnym=$this->opd_model->finddiff($value['htn']);
						$data[$data1]['htn']="On Rx since ".$htnym[0]." Years and ".$htnym[1]." months";
						endif;
						$data[$data1]['dos']=date('d-m-Y',strtotime($dos));
						$dobym=$this->opd_model->finddiff($value['dob']);
						$data[$data1]['dob']=$dobym[0];
					endforeach;
					$data['patients']=$data;	
					$data['dos']=date('d-m-Y',strtotime($dos));
					$this->load->view('surgery/ipcards',$data);
				else:
					$data['dos']=$dos;
					$data['postop1']=date('d-m-Y',strtotime($dos."+8 days"));
					$data['postop2']=date('d-m-Y',strtotime($dos."+43 days"));
					$this->load->view('surgery/confirmdates',$data);
				
					//$this->load->view('surgery/discharge',$data);
				endif;
				
			
			
			endif;

					
		}
		
		public function print_discharge($dos)
		{
		$dos=$this->uri->segment(3);
		//print_r($_POST);
		//echo $dos;
		
		$data['dos']=$dos;
		$data['discharge']=$_POST;
		if (!$patients=$this->surgery_model->get_details_opd_sur_discharge($dos)):
			Die ("No surgeries performed. <a href=".site_url('home').">Go Home</a>");
		endif;
		
		foreach ($patients as $data1=>$value):
						if ($value['gvp']==1):
						$patients[$data1]['eye']=$value['eye']."E Under GVP";
						else:
						$patients[$data1]['eye']=$value['eye']."E";
						endif;
						if ($value['dm']=='0000-00-00' or $value['dm']==null):
						$patients[$data1]['dm']="No";
						else:
						$dmym=$this->opd_model->finddiff($value['dm']);
						$patients[$data1]['dm']="On Rx since ".$dmym[0]." Years and ".$dmym[1]." months";
						endif;
						if ($value['htn']=='0000-00-00' or $value['htn']==null):
						$patients[$data1]['htn']="No";
						else:
						$htnym=$this->opd_model->finddiff($value['htn']);
						$patients[$data1]['htn']="On Rx since ".$htnym[0]." Years and ".$htnym[1]." months";
						endif;
						
						$dobym=$this->opd_model->finddiff($value['dob']);
						$patients[$data1]['dob']=$dobym[0];
					endforeach;
		$data['patients']=$patients;
		$this->load->view('surgery/discharge',$data);
		$this->load->view('surgery/ipreg',$data);
		$this->surgery_model->db_backup();
		$patients=$this->surgery_model->get_details_opd_sur_discharge($dos);
		$c=0;
		foreach ($patients as $p):
		$csv[$c]['ipno']=$p['ipno'];
		$csv[$c]['name']=$p['name'];
		$csv[$c]['address']=$p['add1'].", ".$p['add2'].", ".$p['taluq'].", ".$p['district']." Phone No: ".$p['phone'];
		$dobym=$this->opd_model->finddiff($p['dob']);
		$csv[$c]['age']=$dobym[0];
		$csv[$c]['sex']=$p['sex'];
		$csv[$c]['dos']=date('d-m-Y',strtotime($dos));
		$csv[$c]['eye']=$p['eye']."E";
		$csv[$c]['iol']=$p['iol'];
		$csv[$c]['surgeon']=$p['surgeon'];	
		$c++;
		endforeach;
		unset ($c);
		//print_r($csv);
		$fname="surgery_".date('d-m-Y',strtotime($dos));
		$this->surgery_model->write_csv($csv, $fname);
		}

}
?>
	
