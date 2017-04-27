<?php
$template=array ('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_caption('Details of selected patient: ID-'.$patients[0]['id']." ".$patients[0]['name']." ".$patients[0]['add1']." ".$patients[0]['add2']." ".$patients[0]['phone']);
//echo $patients[0]['pid']." ".$patients[0]['add1']." ".$patients[0]['add2']." ".$patients[0]['phone']."<br>";
$this->table->set_heading('Opd date','ID');
foreach ($patients as $patients1):
$this->table->add_row($patients1['date'],$patients1['id']);
//echo $patients1['date']." ".$patients1['oid']."<br>";
endforeach;
echo $this->table->generate();
$this->table->set_caption('Details of surgery');
$this->table->set_heading('Date of Surgery','IP No','Operated Eye');
foreach ($spatients as $spatients1):
$this->table->add_row($spatients1['dos'],$spatients1['ipno'],$spatients1['opd_eye']);
endforeach;
echo $this->table->generate();
echo "<table align=center width=50%>";
echo "<tr><td align=center><a href=".site_url('patients/search').">Go back</a></td></tr>";
echo "</table>";
?>
