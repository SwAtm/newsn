<?php
//var_dump($sdate, $edate, $mcount, $fcount, $mscount, $fscount);
echo "OPD statistics for the period from ".date('d-m-Y',strtotime($sdate))." to ".date('d-m-Y',strtotime($edate))."<br>";
echo "Male: ".$mcount."<br>";
echo "Female: ".$fcount."<br>";
echo "Total: ".($mcount+$fcount)."<br>";


echo "Surgery statistics for the period from ".date('d-m-Y',strtotime($sdate))." to ".date('d-m-Y',strtotime($edate))."<br>";
echo "Male: ".$mscount."<br>";
echo "Female: ".$fscount."<br>";
echo "Total: ".($mscount+$fscount)."<br>";
?>
