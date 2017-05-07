<?php
//called by patients/add
echo "<a href=".site_url('home').">Go home</a href>";


echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center width=100%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to enter new patient', 'align'=>'center'));
echo form_open('patients/add');
	foreach ($patients as $patients1):
	$this->table->add_row(form_label(ucfirst($patients1['label'])), 
	(isset($patients1['options'])? (form_dropdown($patients1['name'],$patients1['options'],set_value($patients1['name']))):
	(form_input(array('name'=>$patients1['name'], 'maxlength'=>$patients1['max_len'], 'size'=>$patients1['max_len'], 'value'=>set_value($patients1['name']))))));
	endforeach;

$this->table->add_row(form_submit('submit','Submit'));
$this->table->add_row("<a href=".site_url('home').">GO back</a>");
echo $this->table->generate();
echo form_close();
?>
