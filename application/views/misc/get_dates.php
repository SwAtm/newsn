<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?php echo base_url('application/jquery-ui/external/jquery/jquery.js')?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('application/jquery-ui/jquery-ui.css')?>"/>
<script src="<?php echo base_url('application/jquery-ui/jquery-ui.js')?>"></script>

<script type="text/javascript">

$(document).ready(function() {
        $('input[id$=sdate]').datepicker({
            dateFormat:"dd-mm-yy",
            onClose: function(dateText, inst) {
                $("#edate").focus();
            }
        });
    });



$(function() {
    $("#edate").datepicker({
		dateFormat:"dd-mm-yy",
		onClose: function(dateText, inst) {
                $("#hq").focus();
		}		
                });
});
</script>
</head>
<body>

<?php
//called by misc/get_dates
echo validation_errors();
$template=array('table_open'=>'<table border=1 align=center width=50%>');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Please enter starting and ending dates', 'align'=>'center', 'colspan'=>'2'));
echo form_open('misc/get_dates');
$this->table->add_row('Enter Starting Date',array('data'=>form_input(array('name'=>'sdate', 'id'=>'sdate')),'align'=>'center')) ;
//$this->table->add_row(form_input(array('name'=>'dos', 'id'=>'dos', 'colspan'=>'3')));
$this->table->add_row('Enter Ending Date',array('data'=>form_input(array('name'=>'edate', 'id'=>'edate')), 'align'=>'center')) ;

$this->table->add_row(array('data'=>form_submit(array('name'=>'hq','id'=>'hq', 'value'=>'Head Quarters')),'align'=>'center'),array('data'=>form_submit('dbcs','DBCS'),'align'=>'center') );
echo $this->table->generate();
echo form_close();
?>
</html>

