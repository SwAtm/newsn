<?php
tfpdf();
$base=base_url('application/images');
$pdf=new PDF_MC_Table('L', 'mm', array(297,210));
$pdf->setLeftMargin(12);
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$date=date('d-m-Y',strtotime($dos));
$pdf->Cell(0,5,'Pre-Op Chart for   '.$date,1,1,'C');
$pdf->SetWidths(array(10,10,50,10,10,16,17,17,135));
$pdf->SetHdr($hdr);
//print_r($hdr);
$pdf->Row($hdr);
foreach ($patients as $patients1):
$patient[]=array_values($patients1);
endforeach;
foreach ($patient as $patients1):
$pdf->Row($patients1);
endforeach;
$pdf->Cell(210,5,$pdf->PageNo(),0,0,'C');
$filename=SAVEPATH."Pre Op Chart- ".$date.".pdf";
$pdf->Output($filename);


//echo "Pre Op Chart printed at".SAVEPATH."<br>";
//echo "<a href=".site_url('home').">Go Home</a>";
?>

