<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?php echo base_url('application/jquery-ui/external/jquery/jquery.js')?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('application/jquery-ui/jquery-ui.css')?>"/>
<script src="<?php echo base_url('application/jquery-ui/jquery-ui.js')?>"></script>

<script type="text/javascript">
$(function() {
    $("#dos").datepicker({
		dateFormat:"dd-mm-yy",
		showOtherMonths: true,
		selectOtherMonths: true});
});
</script>
</head>
<body>

<?php
//called by surgery/get_date
echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to Generate Surgery Reports. Please enter date', 'align'=>'center', 'colspan'=>'3'));
echo form_open('surgery/get_date');
$this->table->add_row(array('data'=>form_input(array('name'=>'dos', 'id'=>'dos')),'colspan'=>'2', 'align'=>'center')) ;
//$this->table->add_row(form_input(array('name'=>'dos', 'id'=>'dos', 'colspan'=>'3')));
$this->table->add_row(array('data'=>form_submit('preop','Pre OP Reports'),'align'=>'center'),array('data'=>form_submit('discharge','Post Op Reports'), 'align'=>'center') );
echo $this->table->generate();
echo form_close();
?>
<script>
window.onload = function() {
  var input = document.getElementById("dos").focus();
}

</script>
</html>
