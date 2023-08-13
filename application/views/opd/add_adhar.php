<?php
//called by opd/edit
//echo "<a href=".site_url('home').">Go home</a href>";

	
echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to add patient', 'align'=>'center', 'colspan'=>'6'));
echo form_open('opd/add_adhar',array('id'=>'add_adhar'),array('id'=> $id, 'adhar'=>$adhar));
	//echo form_hidden($data);
	foreach ($patients as $patients1):
	//print_r($patients1);
	$cell=array('data'=>
						(form_input(array('name'=>$patients1['name'], 'maxlength'=>$patients1['max_len'],'id'=>$patients1['name'], 'size'=>$patients1['max_len'],'value'=> $patients1['value'], 'readonly'=>'true'))), 
				'colspan'=>'4');
	$this->table->add_row(form_label(ucfirst($patients1['label'])), $cell);
	endforeach;

	foreach ($history as $history1):
	$cell1=array('data'=>(form_label(ucfirst($history1['label1']))), 'style'=>'width:80px');
	$cell2=array('data'=>(form_label(ucfirst($history1['label2']))), 'style'=>'width:80px');
	if(empty($history1['val1']) and empty($history1['val2'])):
	$this->table->add_row(form_label(ucfirst($history1['label'])), (form_input(array('name'=>$history1['name1'], 'size'=>$history1['max_len'],'maxlength'=>$history1['max_len'], 'value'=>$history1['val1']))),$cell1,(form_input(array('name'=>$history1['name2'], 'size'=>$history1['max_len'],'maxlength'=>$history1['max_len'], 'value'=>$history1['val2']))), $cell2 );
	else:
	$this->table->add_row(form_label(ucfirst($history1['label'])), (form_input(array('name'=>$history1['name1'], 'size'=>$history1['max_len'],'maxlength'=>$history1['max_len'], 'value'=>$history1['val1'], 'readonly'=>'true'))),$cell1,(form_input(array('name'=>$history1['name2'], 'size'=>$history1['max_len'],'maxlength'=>$history1['max_len'], 'value'=>$history1['val2'], 'readonly'=>'true'))), $cell2 );
	endif;
	endforeach;
	//$this->table->add_row(form_label($chistory['label1']), form_dropdown($chistory['name1'],$chistory['option1'], set_value($chistory['name1'],$chistory['val1'])),form_label($chistory['label2']), form_dropdown($chistory['name2'],$chistory['option1'], set_value($chistory['name2'],$chistory['val2'])), form_label($chistory['label3']), form_dropdown($chistory['name3'],$chistory['option2'], set_value($chistory['name3'],$chistory['val3'])));
$cellremark=array('data'=>form_input(array('name'=>$remark['name'], 'maxlength'=>$remark['max_len'], 'size'=>'30',  'value'=>$remark['value'])), 'colspan'=>'4');
$this->table->add_row(form_label($remark['label']),$cellremark) ; 
$cellsumbit=array('data'=>form_submit('submit','Submit'), 'colspan'=>'5', 'align'=>'center');
$this->table->add_row($cellsumbit);
//$cellhome=array('data'=>"<a href=".site_url('home').">GO back</a>", 'colspan'=>'5', 'align'=>'center');
//$this->table->add_row($cellhome);
echo $this->table->generate();
echo form_close();
?>
<script type="text/javascript" language="JavaScript">
	document.forms['add_adhar'].elements['name'].focus();
	</script>


<?php




?>
