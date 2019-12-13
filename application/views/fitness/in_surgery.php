<?php
//print $display;
//called by fitness/get_details_id
foreach ($display as $k=>$v):
print $k." => ".$v."<br>";
endforeach;
print "Patient already added to surgery table. Cannot add/edit<br><a href=get_id>Continue</a>";
?>

