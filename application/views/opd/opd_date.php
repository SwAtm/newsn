<?php
//called by opd/view_date
echo "<a href=".site_url('home').">Go home</a href><br>";
echo "<a href=".site_url('opd/print_opd_date/'.$date).">Print</a href><br>";
$template=array('table_open'=>'<table border=1 align=center width=100%>');
$this->table->set_template($template);
$this->table->set_caption('List Of OPD for date: '.date('d-m-Y', strtotime($date)));
$this->table->set_heading($hdr);
echo $this->table->generate($patients);
?>
