<?php
echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Search form to search patients', 'align'=>'center'));
echo form_open('patients/get_list');
$this->table->add_row(form_label('Type few characters of name','name'));
$this->table->add_row(form_input('name'));
$this->table->add_row(form_submit('submit','Submit'));
echo $this->table->generate();
echo form_close();

//$template=array('table_open'=>'<table border=1 align=center width=50%');
$this->table->set_template(array('table_open'=>'<table border=1 align=center width=50%>'));
$this->table->set_heading(array('data'=>'Search form to search patients', 'align'=>'center'));
echo form_open('patients/get_details_id');
$this->table->add_row(form_label('Type ID','id'));
$this->table->add_row(form_input('id'));
$this->table->add_row(form_submit('submit','Submit'));
echo $this->table->generate();
echo form_close();

/*
$this->table->set_template(array('table_open'=>'<table border=1 align=center width=50%>'));
$this->table->set_heading(array('data'=>'Search form to search patients', 'align'=>'center'));
echo form_open('patients/get_list_oid');
$this->table->add_row(form_label('Type OID','oid'));
$this->table->add_row(form_input('oid'));
$this->table->add_row(form_submit('submit','Submit'));
//$this->table->add_row("<a href=".site_url('home').">Go home</a>");
echo $this->table->generate();
echo form_close();
*/
?>
