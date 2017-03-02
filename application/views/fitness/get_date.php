<?php
echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to list fitness', 'align'=>'center'));
echo form_open('fitness/get_details_date');
$this->table->add_row(form_label('Enter Date','date'));
$this->table->add_row(form_input('date'));
$this->table->add_row(form_submit('submit','Submit'));
echo $this->table->generate();
echo form_close();
?>
