<?php
echo $dos."<br>";
echo $postop1."<br>";
echo $postop2."<br>";
echo form_open('surgery/print_discharge/'.$dos);

$template=array('table_open'=>'<table border=1 align=center');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Confirm Medicines', 'align'=>'center', 'colspan'=>'3'));
$this->table->add_row('Medicines', 'Times like 1-0-1', 'Days');
$this->table->add_row(form_input('m1','Ciprofloxacin'),form_input('t1','1-0-1'),form_input('d1','3 days'));
$this->table->add_row(form_input('m2','Diclofenac'),form_input('t2','1-0-1'),form_input('d2','3 days'));
$this->table->add_row(form_input('m3','Multivitamine'),form_input('t3','1-0-0'),form_input('d3','5 days'));
echo $this->table->generate();

$template=array('table_open'=>'<table border=1 align=center');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Confirm Post Op Dates', 'align'=>'center', 'colspan'=>'2'));
$this->table->add_row('Date', 'Time');
$this->table->add_row(form_input('p1',$postop1),form_input('tm1','3.00 PM'));
$this->table->add_row(form_input('p2',$postop2),form_input('tm2','3.00 PM'));
echo $this->table->generate();

$template=array('table_open'=>'<table border=1 align=center');
$this->table->set_template($template);
$this->table->add_row(form_submit('submit','Submit'));
echo $this->table->generate();
echo form_close();
?>
