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
				echo "<a href=".site_url('home').">Go home</a href>";
			else:
				//post false so that edit gets it as unsubmitted form
				$_POST=false;
				$this->edit($id);
			endif;
		endif;
	}
	
	public function edit($id=null){
		
		if (!$_POST):
		//unsubmitted	
			$row=$this->opd_model->get_details_opd($id);
			//print_r($row);
			$data['id']=$id;
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
		//submitted, set rules
		foreach ($_POST as $key=>$value):
			if ('phone'==$key||'add2'==$key||'dmy'==$key||'dmm'==$key||'hty'==$key||'htm'==$key||'remark'==$key):
				continue;
			endif;
		$this->form_validation->set_rules($key, ucfirst($key), 'trim|required');
		endforeach;
			
		//invalid
			if ($this->form_validation->run()==false):
				$id=$this->input->post('id');
				//$this->load->view('templates/header');
				//$this->load->view('opd/edit', $id);
				$_POST=false;
				$this->edit($id);	
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
		endif;
			
	
	}
