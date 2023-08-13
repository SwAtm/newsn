<?php
echo "Please confirm Name and ADHAR before proceeding<br>";
echo "ID: ".$id."<br>";
echo "Name: ".$name."<br>";
echo "Adhar: ".$adhar."<br>";
echo "Address: ".$add1."<br>";
echo "Sex: ".$sex."<br>";
$template=array('table_open'=>'<table border=1 align=center');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to Update Critical History', 'align'=>'center', 'colspan'=>'6'));
echo form_open('opd/update_crhistory/',array('id'=>'update_crhistory'),array('id'=> $id));
$this->table->add_row(form_label($chistory['label1']), form_dropdown($chistory['name1'],$chistory['option1'], set_value($chistory['name1'],$chistory['val1'])),form_label($chistory['label2']), form_dropdown($chistory['name2'],$chistory['option1'], set_value($chistory['name2'],$chistory['val2'])), form_label($chistory['label3']), form_dropdown($chistory['name3'],$chistory['option2'], set_value($chistory['name3'],$chistory['val3'])));
$cellsumbit=array('data'=>form_submit('submit','Submit'), 'colspan'=>'6', 'align'=>'center');
$this->table->add_row($cellsumbit);
echo $this->table->generate();
echo form_close();
?>
