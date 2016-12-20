<?php
class Fitness extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('patients_model');
		$this->load->model('fitness_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('table');
	}

	public function get_oid()
	{
		$this->load->view('templates/header');
		$this->load->view('fitness/get_oid');
		$this->load->view('fitness/footer');
	}
	
	public function get_details_oid($oid=null)
	{
		$this->form_validation->set_rules('oid', 'OID', 'required');
		if ($this->form_validation->run()==false):
		$this->get_oid();
		else:
		$oid=$this->input->post('oid');
		$row=$this->patients_model->get_pid($oid);
		//echo $oid."<br>";
		//echo $row->pid."<br>";
		$pid=$row->pid;
		$data['patients']=$this->patients_model->get_details_opd($pid);
		//print_r($data['patients']);
		$data['fitness']=$this->fitness_model->get_details_oid($oid);
			if (!empty($data['fitness'])):
			//print_r($data['fitness']);
			$data['todo']="Update";
			else:
			$data['todo']="Add";
			endif;
			//echo $todo;
		$data['mdata']=$this->fitness_model->get_mdata();
		//print_r($data['mdata']);
		$this->load->view('templates/header');
		$this->load->view('fitness/record',$data);
		//$this->load->view('fitness/footer');
		endif;
		//echo $fitness->num_row;
	}

	public function add_update()
	{
		$post=$this->input->post();
		$todo=$post['todo'];
		$mdata=$this->fitness_model->get_mdata();
			foreach ($mdata as $mdata1):
				$data[$mdata1->name]=$post[$mdata1->name];
			endforeach;
			if ("Add"==$todo):
				$this->fitness_model->add($data);
				echo "record added";
			else:
				$this->fitness_model->update($data);
				echo "record updated";
			endif;
			echo "<a href=get_oid>Continue</a>";
			
		
	}
}



