<html>
<body>
<?php
Print "<table border=1 width=100% cellpadding=5 cellspacing=0>";
Print "<tr bgcolor=magenta><td valign=center align=middle>";
?>

<script language="JavaScript">
function pulldown_patients()
{
var url=document.patients.selectname.options[document.patients.selectname.selectedIndex].value
var site_url='<?php echo site_url();?>';
url=site_url+"/"+url
window.location.href=url
}
</script>

<form name="patients">
<select name="selectname" size="1" onChange="pulldown_patients()">
<option value=""> PATIENTS</option>
<option value="patients/add"> Add
<option value="patients/edit"> Edit
<option value="patients/view"> View
<option value="patients/view_date"> View A day's Table
<option value="patients/search"> Search Patient
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
<option value="surgery/add">Add
<option value="surgery/edit">Edit
<option value="surgery/allotip">Allott IP Number
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
	
