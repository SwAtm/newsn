<?php
//called by opd/edit
//echo "<a href=".site_url('home').">Go home</a href>";

	
echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to edit patient', 'align'=>'center', 'colspan'=>'6'));
echo form_open('opd/edit/'.$id,array('id'=>'edit'),array('id'=> $id));
	//echo form_hidden($data);
	foreach ($patients as $patients1):
	//print_r($patients1);
	$cell=array('data'=>
						(isset($patients1['options'])? 
						(form_dropdown($patients1['name'],$patients1['options'],set_value($patients1['name'],$patients1['value']))):
						(form_input(array('name'=>$patients1['name'], 'maxlength'=>$patients1['max_len'],'id'=>$patients1['name'], 'size'=>$patients1['max_len'],'value'=> htmlspecialchars_decode(set_value($patients1['name'],$patients1['value'])))))), 
				'colspan'=>'4');
	$this->table->add_row(form_label(ucfirst($patients1['label'])), $cell);
	endforeach;

	foreach ($history as $history1):
	$cell1=array('data'=>(form_label(ucfirst($history1['label1']))), 'style'=>'width:80px');
	$cell2=array('data'=>(form_label(ucfirst($history1['label2']))), 'style'=>'width:80px');
	$this->table->add_row(form_label(ucfirst($history1['label'])), (form_input(array('name'=>$history1['name1'], 'size'=>$history1['max_len'],'maxlength'=>$history1['max_len'], 'value'=>$history1['val1']))),$cell1,(form_input(array('name'=>$history1['name2'], 'size'=>$history1['max_len'],'maxlength'=>$history1['max_len'], 'value'=>$history1['val2']))), $cell2 );
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
	document.forms['edit'].elements['name'].focus();
	</script>


<?php




?>
