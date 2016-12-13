<?php
echo validation_errors();
//print_r($patients);
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to record fitness', 'align'=>'center'));
$this->table->set_caption('Selected patient: PID- '.$patients[0]['pid']." || ".$patients[0]['name']." ".$patients[0]['add1']." ".$patients[0]['add2']." ".$patients[0]['phone']);
//echo $this->table->add_row($patients[0]);
echo form_open('fitness/add_update','',array('oid'=>$patients[0]['oid'], 'todo'=>$todo));
	foreach ($mdata as $mdata1):
		if ($mdata1->name=='id' || $mdata1->name=='oid'):
			continue;
		endif;
	$this->table->add_row(form_label(ucfirst($mdata1->name)));
	$this->table->add_row(form_input(array('name'=>$mdata1->name, 'maxlength'=>$mdata1->max_length, 'size'=>$mdata1->max_length, 'value'=>$fitness[0][$mdata1->name])));
	endforeach;

/*
$this->table->add_row(form_label('Chest Pain'));
//$this->table->add_row(form_checkbox(array('name'=>'cardiac_ailment','value'=>1, 'checked'=>(1==$fitness[0]['cardiac_ailment'] ? "True":""))));
$this->table->add_row(form_input('chest_pain'));
$this->table->add_row(form_label('Asthma'));
$this->table->add_row(form_checkbox(array('name'=>'asthma','value'=>1, 'checked'=>(1==$fitness[0]['asthma'] ? "True":""))));
$this->table->add_row(form_label('Seizure'));
$this->table->add_row(form_checkbox(array('name'=>'seizure','value'=>1, 'checked'=>(1==$fitness[0]['seizure'] ? "True":""))));
$this->table->add_row(form_label('Pedal Oedema'));
$this->table->add_row(form_checkbox(array('name'=>'pedal_oedema','value'=>1, 'checked'=>(1==$fitness[0]['pedal_oedema'] ? "True":""))));
$this->table->add_row(form_label('Other Ailments'));
$this->table->add_row(form_input(array('name'=>'other_ailment','value'=>($fitness[0]['other_ailment']),'size'=>100)));
$this->table->add_row(form_label('Medication'));
$this->table->add_row(form_input(array('name'=>'medication','value'=>($fitness[0]['medication']),'size'=>100)));
$this->table->add_row(form_label('H/o Alcohol'));
$this->table->add_row(form_input(array('name'=>'alcohol','value'=>($fitness[0]['alcohol']),'size'=>25)));
*/
$this->table->add_row(form_submit('submit','Submit'));
$this->table->add_row("<a href=get_oid>GO back</a>");
echo $this->table->generate();
echo form_close();
?>
