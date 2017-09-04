<?php
//called by fitness/get_details_date
echo "<a href=".site_url('home').">Go home</a href><br>";
foreach ($fitness as $fitness1):
	foreach ($fitness1 as $key=>$val):
		if ("No"==ucfirst(strtolower($val))):
			//echo ucfirst(strtolower($val))."<br>";
			//echo "<br>";
			continue;
		else:
			echo ucfirst($key).": ";
			echo "<b>".ucwords(strtolower($val))."</b><br>";
		endif;
	endforeach;
	echo "===============<br>";
endforeach;
echo "<a href=".site_url('home').">Go home</a href>";
?>
