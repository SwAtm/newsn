<?php
echo validation_errors();
//print_r($patients);
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to record fitness', 'align'=>'center'));
$this->table->set_caption('Selected patient: PID- '.$patients[0]['pid']." || OID- ". $patients[0]['oid']." || ".$patients[0]['name']." ".$patients[0]['add1']." ".$patients[0]['add2']." ".$patients[0]['phone']);
//echo $this->table->add_row($patients[0]);
echo form_open('fitness/add_update','',array('oid'=>$patients[0]['oid'], 'todo'=>$todo));
	foreach ($mdata as $mdata1):
		if ($mdata1->name=='id' || $mdata1->name=='oid'):
			continue;
		endif;
	$this->table->add_row(form_label(ucfirst($mdata1->name)));
	$this->table->add_row(form_input(array('name'=>$mdata1->name, 'maxlength'=>$mdata1->max_length, 'size'=>$mdata1->max_length, 'value'=>$fitness[0][$mdata1->name])));
	endforeach;

$this->table->add_row(form_submit('submit','Submit'));
$this->table->add_row("<a href=get_oid>GO back</a>");
echo $this->table->generate();
echo form_close();
?>
