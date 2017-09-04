<?php
//called by opd/get_details_id
$template=array ('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_caption('Details of selected patient: ID-'.$patients['id']." ".$patients['name']." ".$patients['add1']." ".$patients['add2']." ".$patients['phone']);
//echo $patients[0]['pid']." ".$patients[0]['add1']." ".$patients[0]['add2']." ".$patients[0]['phone']."<br>";
$this->table->set_heading('Opd date','ID');
//foreach ($patients as $patients1):
$this->table->add_row($patients['date'],$patients['id']);
//echo $patients1['date']." ".$patients1['oid']."<br>";
//endforeach;
echo $this->table->generate();
$this->table->set_caption('Details of surgery');
$this->table->set_heading('Date of Surgery','IP No','Operated Eye');
//foreach ($spatients as $spatients1):
$this->table->add_row($spatients['dos'],$spatients['ipno'],$spatients['eye']);
//endforeach;
echo $this->table->generate();
echo "<table align=center width=50%>";
echo "<tr><td align=center><a href=".site_url('opd/search').">Go back</a></td></tr>";
echo "</table>";
?>
