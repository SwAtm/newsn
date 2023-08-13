<?php
//called by opd/get_adhar
//echo "<a href=".site_url('home').">Go home</a href>";

echo validation_errors();
$this->table->set_template(array('table_open'=>'<table border=1 align=center width=50%>'));
$this->table->set_heading(array('data'=>'Enter Aadhaar Number', 'align'=>'center'));
echo form_open('opd/get_adhar', array('id'=>'getadhar'));
$this->table->add_row(form_label('Aadhaar Number','adhar'));
$this->table->add_row(form_input(array('name'=>'adhar', 'id'=>'adhar', 'value'=>set_value('adhar'))));
$this->table->add_row(form_submit('continue','Submit'));
echo $this->table->generate();
echo form_close();
?>
<script type="text/javascript" language="JavaScript">
	document.forms['getadhar'].elements['adhar'].focus();
	</script>

<?php
?>

