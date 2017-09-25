<html>
<body>
<?php
Print "<table border=1 width=100% cellpadding=5 cellspacing=0>";
Print "<tr bgcolor=magenta><td valign=center align=middle>";
?>

<script language="JavaScript">
function pulldown_opd()
{
var url=document.opd.selectname.options[document.opd.selectname.selectedIndex].value
var site_url='<?php echo site_url();?>';
url=site_url+"/"+url
window.location.href=url
}
</script>

<form name="opd">
<select name="selectname" size="1" onChange="pulldown_opd()">
<option value=""> OPD</option>
<option value="opd/add"> Add
<option value="opd/get_id_edit"> Edit
<option value="opd/get_id_print"> Print OPD Slip
<option value="opd/get_date_view"> View A day's Table
<option value="opd/search"> Search Patient
</select>
</form>
<?php
Print "</td>";
Print "<td  valign=centre align=middle>";
?>


<script language="JavaScript">
function pulldown_fitness()
{
var url=document.fitness.selectname.options[document.fitness.selectname.selectedIndex].value
var site_url='<?php echo site_url();?>';
url=site_url+"/"+url
window.location.href=url
}
</script>

<form name="fitness">
<select name="selectname" size="1" onChange="pulldown_fitness()">
<option value=""> Fitness</option>
<option value="fitness/get_id">Record Fitness
<option value="fitness/get_date">List Fitness
</select>
</form>
<?php
Print "</td>";
Print "<td  valign=centre align=middle>";
?>

<script language="JavaScript">
function pulldown_surgery()
{
var url=document.surgery.selectname.options[document.surgery.selectname.selectedIndex].value
var site_url='<?php echo site_url();?>';
url=site_url+"/"+url
window.location.href=url
}
</script>
<form name="surgery">
<select name="selectname" size="1" onChange="pulldown_surgery()">
<option value=""> Surgery</option>
<option value="surgery/get_id_add">Add
<option value="surgery/get_id_edit">Edit
<option value="surgery/get_id_allot">Allott IP Number
<option value="surgery/get_date">Printed Reports
</select>
</form>
<?php
Print "</td>";


Print "<td  valign=centre align=middle>";
?>
<script language="JavaScript">
function pulldown_misc()
{
var url=document.misc.selectname.options[document.misc.selectname.selectedIndex].value
var site_url='<?php echo site_url();?>';
url=site_url+"/"+url
window.location.href=url
}
</script>
<form name="misc">
<select name="selectname" size="1" onChange="pulldown_misc()">
<option value=""> Miscellaneous</option>
<option value="misc/get_dates">Reports
<option value="contacts/get_contacts">Contacts
</select>
</form>




<!--
<option value="preopchart.php">Print Pre-Op Chart
<option value="printip.php">Print IP Card

<option value="printipreg.php">Print IP Register
<option value="discharge.php">Print Discharge Sheets 
<script language="JavaScript">
function pulldown_menu3()
{
var url=document.menu3.selectname.options[document.menu3.selectname.selectedIndex].value
window.location.href=url
}
</script>
<form name="menu3">
<select name="selectname" size="1" onChange="pulldown_menu3()">
<option value=""> Miscellaneous</option>
<option value="contacts.php"> Add/Edit/View/Delet Contacts
<option value="contacts.php"> Add/Edit/View/Delet Contacts
<option value="summary.php"> Summary Reports
<option value="surdate.php"> Surgery Details on Date
<option value="surip.php"> Surgery Details on IP No
<option value="hqreport.php"> Reports for HQ
<option value="delsur.php"> Delet Records
<option value="backup.php"> Take a backup
</select>
</form> -->

<?php
Print "</td></tr></table>";
?>
</body>
</html>
	
