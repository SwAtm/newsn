<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url('application/datetimepicker/jquery.datetimepicker.css')?>"/>
<script src="<?php echo base_url('application/datetimepicker/jquery.js')?>"></script>
<script src="<?php echo base_url('application/datetimepicker/jquery.datetimepicker.min.js')?>"></script>
<script src="<?php echo base_url('application/datetimepicker/jquery.datetimepicker.js')?>"></script>
<script type="text/javascript">
$(function() {
    $("#dt").datepicker();
});
</script>
</head>

</body>

<?php
//called by patients/get_date_view
echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'List OPD', 'align'=>'center'));
echo form_open('patients/view_date');
$this->table->add_row(form_label('Enter Date','date'));
$attribute=array('name'=>'date','id'=>'dt');
$js = 'onClick="datepicker()"';
$this->table->add_row(form_input($attribute,'',$js));
$this->table->add_row(form_submit('submit','Submit'));
echo $this->table->generate();
echo form_close();
?>

</body>
</html>


