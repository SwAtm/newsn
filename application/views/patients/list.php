<?php
echo "<a href=".site_url('patients/search').">Go back</a><br>";
echo "<table border align=center><tr><td>PID</td><td>Name and Address</td><td>Phone No</td></tr>";
echo "<caption><h3>List of likely patients<br>Please click on PID to get details</h3></caption>";
foreach ($patients as $patients1):
echo "<tr><td><a href=".site_url('patients/get_details_id/'.$patients1['id']).">$patients1[id]</a></td><td>$patients1[name].$patients1[add1].$patients1[add2]</td><td>$patients1[phone]</td></tr>";
endforeach;
echo "</table>";
?>
