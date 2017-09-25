<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?php echo base_url('application/jquery-ui/external/jquery/jquery.js')?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('application/jquery-ui/jquery-ui.css')?>"/>
<script src="<?php echo base_url('application/jquery-ui/jquery-ui.js')?>"></script>

<script type="text/javascript">
$(function() {
    $("#dt").datepicker({
		dateFormat:"dd-mm-yy"});
});
</script>
</head>


<body>
<?php
//called by opd/get_date_view

echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'List OPD', 'align'=>'center'));
echo form_open('opd/view_date', array('id'=>'getdate'));
$this->table->add_row(form_label('Enter Date','date'));
$attribute=array('name'=>'date','id'=>"dt");
//$js = 'onClick="datepicker()"';
$this->table->add_row(form_input($attribute));
$this->table->add_row(form_submit('submit','Submit'));
echo $this->table->generate();
echo form_close();
?>

</body>
</html>


