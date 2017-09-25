<?php
//called by surgery/get_id_add
echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to add to Surgery Table', 'align'=>'center'));
echo form_open('surgery/get_id_add', array('id'=>'getid'));
$this->table->add_row(form_label('Enter ID','id'));
$this->table->add_row(form_input(array('name'=>'id', 'id'=>'id')));
$this->table->add_row(form_submit('submit','Submit'));
echo $this->table->generate();
echo form_close();
?>
<script type="text/javascript" language="JavaScript">
	document.forms['getid'].elements['id'].focus();
	</script>

