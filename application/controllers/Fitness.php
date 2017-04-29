<?php
class Fitness extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('patients_model');
		$this->load->model('fitness_model');
		$this->load->model('surgery_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('table');
	}

	public function get_id()
	{
		$this->load->view('templates/header');
		$this->load->view('fitness/get_id');
		$this->load->view('templates/footer');
	}
	
	public function get_details_id($id=null)
	{
		$this->form_validation->set_rules('id', 'ID', 'required');
		if ($this->form_validation->run()==false):
		$this->get_id();
		else:
		$id=$this->input->post('id');
		//check if id exists
			if (!$data['patients']=$this->patients_model->get_details_opd($id)):
				die ("Pl check ID. <br><a href=get_id>Continue</a>");
			endif;
		//check if already added to surgery table and accordigly steer.
			if ($this->surgery_model->get_details($id)):
				$display=$this->fitness_model->get_details_id($id);
				echo '<pre>'; print_r($display); echo '</pre>';
				die ("Patient already added to surgery table. Cannot add/edit<br><a href=get_id>Continue</a>");
			endif;
		
				
		$data['mdata']=$this->fitness_model->get_mdata();
			if ($this->fitness_model->get_details_id($id)):
				$data['fitness']=$this->fitness_model->get_details_id($id);
				$data['todo']="Update";
				$data['fitness']['date']=date('d-m-Y',strtotime($data['fitness']['date']));
			else:
			$data['todo']="Add";
			foreach ($data['mdata'] as $mdata1):
				if($mdata1->name=='date'):
				$data['fitness'][$mdata1->name]=Date("d-m-Y");
				continue;
				endif;
				
			$data['fitness'][$mdata1->name]='';
			endforeach;

			endif;
		$this->load->view('templates/header');
		$this->load->view('fitness/record',$data);
		endif;
	}

	public function add_update()
	{
		$mdata=$this->fitness_model->get_mdata();
		foreach ($mdata as $mdata1):	
			if ('remark'!==$mdata1->name):
			$this->form_validation->set_rules($mdata1->name, ucfirst($mdata1->name), 'required');
			endif;
		endforeach;
		if ($this->form_validation->run()==false):
			$id=$this->input->post('id');
			$data['todo']=$_POST['todo'];
			
			$data['patients']=$this->patients_model->get_details_opd($id);

			if (isset($data['fitness'])):
				unset($data['fitness']);
			endif;
			
			$data['mdata']=$this->fitness_model->get_mdata();
		
			foreach ($mdata as $mdata1):
			$data['fitness'][$mdata1->name]=$_POST[$mdata1->name];
			endforeach;
		
		
			$this->load->view('templates/header');
			$this->load->view('fitness/record',$data);
		


		else:
			$post=$this->input->post();
			$todo=$post['todo'];
			
			foreach ($mdata as $mdata1):
				if ($mdata1->name=='date'):
					$post[$mdata1->name]=date('Y-m-d',strtotime($post[$mdata1->name]));
				endif;
				$data[$mdata1->name]=$post[$mdata1->name];
			endforeach;
			if ("Add"==$todo):
				if ($this->fitness_model->add($data)):
				echo "record added";
				else:
				die ("Could not add record. <a href=get_id>Continue</a>");
				endif;
			else:
				if ($this->fitness_model->update($data)):
				echo "record updated ";
				else:
				die ("Could not update record. <a href=get_id>Continue</a>");
				endif;
	
			endif;
			echo "<a href=get_id>Continue</a>";
		endif;	
		
	}
	
	public function get_date()
	{
		$this->load->view('templates/header');
		$this->load->view('fitness/get_date');
		$this->load->view('templates/footer');
	}
		
	public function get_details_date($date=null)
	{
		$this->form_validation->set_rules('date', 'Date', 'required');
		if ($this->form_validation->run()==false):
			$this->get_date();
		else:
			$date=$this->input->post('date');
			//echo $date;
			$date=date('Y-m-d',strtotime($date));
			//echo $date."<br>";
			$data['fitness']=$this->fitness_model->get_details_date($date);
			if (!$data['fitness']):
				echo "No data fetched";
				$this->get_date();
			else:
			$this->load->view('templates/header');
			$this->load->view('fitness/list_date',$data);
			endif;
		endif;
	}


}
