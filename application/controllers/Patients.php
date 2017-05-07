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

	}
	
	public function add()
	{
		
		foreach ($_POST as $key=>$value):
			if ('phone'==$key||'add2'==$key):
				continue;
			endif;
		$this->form_validation->set_rules($key, ucfirst($key), 'trim|required');
		endforeach;
		
		if ($this->form_validation->run()==false):
		$data['patients']=array(
						array('label'=>'name', 'name'=>'name','max_len'=>'30'),
						array('label'=>'address', 'name'=>'add1','max_len'=>'30'),
						array('label'=>'address', 'name'=>'add2','max_len'=>'30'),
						array('label'=>'taluq', 'name'=>'taluq','max_len'=>'30'),
						array('label'=>'district', 'name'=>'district','max_len'=>'30'),
						array('label'=>'phone', 'name'=>'phone','max_len'=>'15'),
						array('label'=>'age', 'name'=>'age','max_len'=>'2'),
						array('label'=>'sex', 'name'=>'sex', 'options'=>array (''=>'Select','M'=>'Male', 'F'=>'Female')),
						array('label'=>'language', 'name'=>'language', 'options'=>array (''=>'Select','K'=>'Kannada', 'M'=>'Marathi','H'=>'Hindi'))

						);
		$this->load->view('templates/header');
		$this->load->view('patients/add', $data);
		else:
		echo "Validated<br>";
		$y=$_POST['age'];
		$yob=Date("Y")-$y;
		$_POST['age']=$yob."-01-01";
		print_r($_POST);
		endif;	
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
	
		
