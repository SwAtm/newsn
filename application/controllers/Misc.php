<?php
class Misc extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('opd_model');
		$this->load->model('fitness_model');
		$this->load->model('surgery_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('table');
		$this->load->helper('pdf_helper');
		$this->load->dbutil();
		$this->load->helper('file');
	//	$this->output->enable_profiler(TRUE);
	}

	public function get_dates()
	{
	
	$this->form_validation->set_rules('sdate','Starting Date','trim|required');
	$this->form_validation->set_rules('edate','Ending Date','trim|required');			
			//new or failed validation
			if ($this->form_validation->run()==false):
				$this->load->view('templates/header');
				$this->load->view('misc/get_dates');
				$this->load->view('templates/footer');
			else:
			//submitted
				$sdate=date('Y-m-d',strtotime($this->input->post('sdate')));
				$edate=date('Y-m-d',strtotime($this->input->post('edate')));
				
				if (isset($_POST['hq'])):
				$sdate=date('Y-m-d',strtotime($this->input->post('sdate')));
				$edate=date('Y-m-d',strtotime($this->input->post('edate')));
				
				$mcount=$this->opd_model->count_opd('m',$sdate,$edate);
				$fcount=$this->opd_model->count_opd('f',$sdate,$edate);
				
					if (!$mcount):
						$mcount='0';
					endif;
					if (!$fcount):
						$fcount='0';
					endif;
				
				$mscount=$this->surgery_model->count_surgery('m',$sdate,$edate);
				$fscount=$this->surgery_model->count_surgery('f',$sdate,$edate);
				
					if (!$mscount):
						$mscount='0';
					endif;
					if (!$fscount):
						$fscount='0';
					endif;
				
				//var_dump($mcount, $fcount, $mscount, $fscount);
				
				$data['sdate']=$sdate;
				$data['edate']=$edate;
				$data['mcount']=$mcount;
				$data['fcount']=$fcount;
				$data['mscount']=$mscount;
				$data['fscount']=$fscount;
				
				
				$this->load->view('templates/header');
				$this->load->view('misc/hq_reports',$data);
				$this->load->view('templates/footer');
				
				else:
				
				$patients=$this->surgery_model->get_details_opd_sur_dbcs($sdate,$edate);
				$c=0;
				if (!$patients):
				die($this->load->view('templates/header','',TRUE)."No surgeries performed during this period "."<a href=".site_url('home').">Go Home</a>");
				endif;
				
				foreach ($patients as $p):
					
					$csv[$c]['slno']=($c+1);
					$csv[$c]['address']=$p['name'].", ".$p['add1'].", ".$p['add2'].", ".$p['taluq'].", ".$p['district']." Phone No: ".$p['phone'];
					$dobym=$this->opd_model->finddiff($p['dob']);
					$csv[$c]['age']=$dobym[0];
					$csv[$c]['sex']=$p['sex'];
					$csv[$c]['dos']=date('d-m-Y',strtotime($p['dos']));
					$csv[$c]['eye']=$p['eye']."E";
					$csv[$c]['iol']=$p['iol'];
					$c++;
				endforeach;
				unset ($c);
		//print_r($csv);
				$fname="dbcs_".date('M-Y',strtotime($edate));
				$this->surgery_model->write_csv($csv, $fname);
				echo "File ".$fname."generated at ".SAVEPATH."<br>";
				echo "<a href=".site_url('home').">Go Home</a>";
				endif;
			endif;
	}
	
		public function backup()
		{
		
			$this->surgery_model->db_backup();
			$this->load->view('templates/header');
			$this->output->append_output("Backup taken at ".SAVEPATH."<a href=".site_url('home')."> Home</a>");
		
		}
}
?>
