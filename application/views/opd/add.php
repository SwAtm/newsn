<?php
//called by opd/add
echo "<a href=".site_url('home').">Go home</a href>";


echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to enter new patient', 'align'=>'center', 'colspan'=>'5'));
echo form_open('opd/add');
	foreach ($patients as $patients1):
	$cell=array('data'=>(isset($patients1['options'])? (form_dropdown($patients1['name'],$patients1['options'],set_value($patients1['name']))):
	(form_input(array('name'=>$patients1['name'], 'maxlength'=>$patients1['max_len'], 'size'=>$patients1['max_len'], 'value'=>set_value($patients1['name']))))), 'colspan'=>'4');
	$this->table->add_row(form_label(ucfirst($patients1['label'])), $cell);
	endforeach;

	foreach ($history as $history1):
	$cell1=array('data'=>(form_label(ucfirst($history1['label1']))), 'style'=>'width:80px');
	$cell2=array('data'=>(form_label(ucfirst($history1['label2']))), 'style'=>'width:80px');
	$this->table->add_row(form_label(ucfirst($history1['label'])), (form_input(array('name'=>$history1['name1'], 'size'=>$history1['max_len'],'maxlength'=>$history1['max_len'], 'value'=>set_value($history1['name1'])))),$cell1,(form_input(array('name'=>$history1['name2'], 'size'=>$history1['max_len'],'maxlength'=>$history1['max_len'], 'value'=>set_value($history1['name2'])))), $cell2 );
	endforeach;

$cellremark=array('data'=>form_input(array('name'=>$remark['name'], 'maxlength'=>$remark['max_len'], 'size'=>'30',  'value'=>set_value($remark['name']))), 'colspan'=>'4');
$this->table->add_row(form_label($remark['label']),$cellremark) ; 
$cellsumbit=array('data'=>form_submit('submit','Submit'), 'colspan'=>'5', 'align'=>'center');
$this->table->add_row($cellsumbit);
$cellhome=array('data'=>"<a href=".site_url('home').">GO back</a>", 'colspan'=>'5', 'align'=>'center');
$this->table->add_row($cellhome);
echo $this->table->generate();
echo form_close();
?>
