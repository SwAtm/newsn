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
	public function search()
	{
		$this->load->view('templates/header');
		$this->load->view('patients/search');
		$this->load->view('patients/footer');
	}
	
	public function get_list($name=null)
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run()==false):
			$this->load->view('templates/header');
			$this->load->view('patients/search');
		else:
			$name=$this->input->post('name');
			$data['patients']=$this->patients_model->get_list($name);
			$this->load->view('templates/header');
			$this->load->view('patients/list', $data);
		endif;
		}
		
	public function get_details_pid($pid=null)
	{
		if (!empty($_POST)):
			$this->form_validation->set_rules('pid','PID','required');
			if ($this->form_validation->run()==false):
				$this->load->view('templates/header');
				$this->load->view('patients/search');
				return;
			else:
			$pid=$this->input->post('pid');
			endif;
		endif;
		$data['patients']=$this->patients_model->get_details_opd($pid);
		$data['spatients']=$this->patients_model->get_details_surgery($pid);
		$this->load->view('templates/header');
		$this->load->view('patients/details',$data);
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

	public function get_list_oid($oid=null)
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
		$pid=$result->pid;
		$data['patients']=$this->patients_model->get_details_opd($pid);
		$data['spatients']=$this->patients_model->get_details_surgery($pid);
		$this->load->view('templates/header');
		$this->load->view('patients/details',$data);
		endif;
	}
	
	
	
	
	
}
	
	
		
