<?php
//Print_r($_POST);
echo validation_errors();
$this->table->set_template(array('table_open'=>'<table border=1 align=center width=50%>'));
$this->table->set_heading(array('data'=>'Enter ID to edit', 'align'=>'center'));
echo form_open('opd/get_id_crhistory', array('id'=>'getid'));
$this->table->add_row(form_label('Type ID','id'));
$this->table->add_row(form_input(array('name'=>'id', 'id'=>'id')));
$this->table->add_row(form_submit('continue','Submit'));
echo $this->table->generate();
echo form_close();
?>
<script type="text/javascript" language="JavaScript">
	document.forms['getid'].elements['id'].focus();
	</script>

<?php
?>
