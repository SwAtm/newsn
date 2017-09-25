<?php
$pass=array('id'=>$id, 'ipno'=>$ipno);
echo form_open('surgery/allotip','', $pass);
echo "Patient's Id: ".$id."<br>";
echo "Patient's Name: ".$opd['name']."<br>";
echo "IP No: ".$ipno."<br>";
echo form_submit('submit','Allot');
echo form_close();
echo "<a href=".site_url('home').">Do not Allot, Home</a>";
//print_r($opd);
//print $ipno;
//print $id;
?>
