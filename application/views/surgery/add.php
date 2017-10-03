<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?php echo base_url('application/jquery-ui/external/jquery/jquery.js')?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('application/jquery-ui/jquery-ui.css')?>"/>
<script src="<?php echo base_url('application/jquery-ui/jquery-ui.js')?>"></script>

<script type="text/javascript">
$(document).ready(function() {
        $('input[id$=dt]').datepicker({
            dateFormat:"dd-mm-yy",
            onClose: function(dateText, inst) {
                $("#k1").focus();
            }
        });
    });
</script>
</head>
<?php
$id= $opd['id'];
$template=array('table_open'=>'<table border=1 align=center');
$this->table->set_template($template);
$this->table->set_heading(array('data'=>'Form to add patient to Surgery table', 'align'=>'center', 'colspan'=>'5'));
echo form_open('surgery/add/'.$id,'',array('id'=> $id));

$sur=array(
	//array('label'=>'DOS','name'=>'dos','maxlength'=>'10'),
	//array('label'=>'K1','name'=>'k1','maxlength'=>'5'),
	array('label'=>'K2','name'=>'k2','maxlength'=>'5'),
	array('label'=>'AL','name'=>'al','maxlength'=>'5'),
	array('label'=>'IOL','name'=>'iol','maxlength'=>'5'),
	array('label'=>'ECG','name'=>'ecg','maxlength'=>'20'),
	array('label'=>'BP','name'=>'bp','maxlength'=>'30'),
	array('label'=>'RBS','name'=>'rbs','maxlength'=>'30'),
	array('label'=>'SAC','name'=>'sac','maxlength'=>'10'),
	array('label'=>'IOP','name'=>'iop','maxlength'=>'10')
	);
echo "<table border=1 align=center>";
echo "<tr><td colspan=3 align=center>Patient's id/name: ".$opd['id']."/ ".$opd['name'].", ".$opd['add1']."</td></tr>";
echo "<tr><td>DOS</td><td>".form_input(array('name'=>'dos','id'=>'dt'))."</td></tr>";
echo "<tr><td>K1</td><td>".form_input(array('name'=>'k1','id'=>'k1'))."</td></tr>";

foreach ($sur as $sur1):
	echo "<tr><td>".$sur1['label']."</td><td colspan='2' >".form_input(array ('name'=>$sur1['name'],'maxlength'=>$sur1['maxlength']))."</td></tr>";
endforeach;
echo "<tr><td>Eye to be Operated</td><td colspan=2>".form_dropdown('eye', array('L'=>'Left','R'=>'Right'))."</td></tr>";

echo "<tr><td>GVP?</td><td>Yes".form_radio('gvp','yes',false)."</td><td>No".form_radio('gvp','no',true)."</td></tr>";
echo "<tr><td>Surgeon</td><td colspan=2>".form_dropdown('surgeon', $surgeon, 'Dr.Yakkundi')."</td></tr>";
echo "<tr><td>Remark</td><td colspan='2'>".form_textarea(array('name'=>'remark','value'=>$remark,'maxlength'=>'1000'))."</td></tr>";
echo "<tr><td colspan=3 align=center>".form_submit('submit','Submit')."</td></tr></table>";
?>
