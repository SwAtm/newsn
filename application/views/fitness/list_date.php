<?php
echo "<a href=".site_url('home').">Go home</a href><br>";
foreach ($fitness as $fitness1):
	foreach ($fitness1 as $key=>$val):
		echo ucfirst($key).": ";
		if ("No"==$val):
			echo $val."<br>";
		else:
			echo "<b>".$val."</b><br>";
		endif;
	endforeach;
	echo "===============<br>";
endforeach;
echo "<a href=".site_url('home').">Go home</a href>";
?>
