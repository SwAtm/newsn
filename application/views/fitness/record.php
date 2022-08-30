
<?php
//called by fitness/get_details_id, fitness/add_update

echo validation_errors();
//var_dump($fitness);
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to record fitness', 'align'=>'center'));
$this->table->set_caption('Selected patient: ID- '.$patients['id']." || ".$patients['name']." ".$patients['add1']." ".$patients['add2']." ".$patients['phone']);
//echo $this->table->add_row($patients[0]);
echo form_open('fitness/add_update','',array('id'=>$patients['id'], 'todo'=>$todo));
	foreach ($mdata as $mdata1):
		if ($mdata1->name=='id'):
			continue;
		endif;
		if ($mdata1->name=='medication'):
			$this->table->add_row(form_label(ucfirst($mdata1->name." apart from for HTN and DM")));
		else:
			$this->table->add_row(form_label(ucfirst($mdata1->name)));
		endif;	
	
	$this->table->add_row(form_input(array('name'=>$mdata1->name, 'maxlength'=>$mdata1->max_length, 'size'=>$mdata1->max_length, 'value'=>$fitness[$mdata1->name], 'id'=>$mdata1->name)));
	endforeach;

$this->table->add_row(form_submit('submit','Submit'));
$this->table->add_row("<a href=get_id>GO back</a>");
echo $this->table->generate();
echo form_close();
?>
<script>
	window.onload = function(){
	document.querySelector('#chest_pain').focus();
	}
</script>

