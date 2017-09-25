<?php
//called by fitness/get_id
echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to record fitness', 'align'=>'center'));
echo form_open('fitness/get_details_id',array('id'=>'getid'));
$this->table->add_row(form_label('Enter ID','id'));
$this->table->add_row(form_input(array('name'=>'id', 'id'=>'id')));
$this->table->add_row(form_submit('submit','Submit'));
echo $this->table->generate();
echo form_close();
?>
<script type="text/javascript" language="JavaScript">
	document.forms['getid'].elements['id'].focus();
	</script>

