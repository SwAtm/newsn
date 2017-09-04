<?php
//called by opd/print_opd_date($date)
//$pageadd=0;
$base=base_url('application/images');
tfpdf();
$date=date('d-m-y', strtotime($date));
//$pdf = new tFPDF('P', 'mm', array(210,297));
//$pdf->SetAutoPageBreak('auto',1);
$pdf=new PDF_MC_Table();
$pdf->setLeftMargin(12);
$pdf->AddPage();
//$y1=$pdf->getY();
$pdf->SetFont('Arial','B',10);
$pdf->Image ($base.'/logo.jpg', '10', '10', '', '15');
$pdf->Cell(0,5,'Sharada Netralaya',0,1,'R');
$pdf->Cell(0,5,'Ramakrishna Mission Ashrama',0,1,'R');
$pdf->Cell(0,5,'Fort, Belgaum 590016. Ph 2430789/ 2432789',0,1,'R');
$pdf->Cell(0,0,'',1,1,'R');
$pdf->Cell(0,5,'OPD Register for - '.$date,1,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(16,10,'ID',1,0,'L');
$pdf->Cell(16,10,'OPD NO',1,0,'C');
$pdf->Cell(50,10,'Name',1,0,'C');
$pdf->Cell(8,10,'Age',1,0,'C');
$pdf->Cell(8,10,'Sex',1,0,'C');
$pdf->Cell(90,10,'Address',1,1,'C');
//echo $header;
$pdf->SetWidths(array(16,16,50,8,8,90));
$pdf->SetHdr(array('ID','OPD NO','Name','Age','Sex','Address'));

/*foreach ($patients as $k=>$v):
$patients[$k]['address']=$v[0];
unset ($patients[$k][0]);
endforeach;*/
//print_r($patients);
foreach ($patients as $patients1):
$patient[]=array_values($patients1);
endforeach;
foreach ($patient as $patients1):
$pdf->Row($patients1);
//if ($pdf->pageadd>0):
//$pdf->cell(210,5,'add header',1,1);
//endif;
//$pageadd=0;
endforeach;
$pdf->Cell(210,5,$pdf->PageNo(),0,0,'C');

/*$y=$pdf->getY();
foreach ($patients as $k=>$v):
$pdf->setXY(94,$y);
$pdf->MultiCell(90,5,$v[0],1,'L');
$h=$pdf->getY();
$height=$h-$y;
$pdf->setXY(12,$y);
$pdf->Cell(16,$height,$v['id'],1,0,'L');
$pdf->Cell(16,$height,$v['opdno'],1,0,'C');
$pdf->MultiCell(50,5,$v['name'],1,'L');
$pdf->setXY(184,$y);
$pdf->Cell(8,$height,$v['dob'],1,0,'C');
$pdf->Cell(8,$height,$v['sex'],1,1,'C');
$y=$y+$height;
if($y+10 > 280):
	$pdf->Cell(210,5,$pdf->PageNo(),0,1,'C');
//add a new page
$pdf->AddPage($pdf->CurOrientation);
$pdf->SetFont('Arial','B',10);
$pdf->Image ($base.'/logo.jpg', '10', '10', '', '15');
$pdf->Cell(0,5,'Sharada Netralaya',0,1,'R');
$pdf->Cell(0,5,'Ramakrishna Mission Ashrama',0,1,'R');
$pdf->Cell(0,5,'Fort, Belgaum 590016. Ph 2430789/ 2432789',0,1,'R');
$pdf->Cell(0,0,'',1,1,'R');
$pdf->Cell(0,5,'OPD Register for - '.$date,1,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(16,10,"ID",1,0,'L');
$pdf->Cell(16,10,"OPD NO",1,0,'C');
$pdf->Cell(50,10,"Name",1,0,'C');
$pdf->Cell(90,10,"Address",1,0,'C');
$pdf->Cell(8,10,"Age",1,0,'C');
$pdf->Cell(8,10,"Sex",1,1,'C');
$pdf->SetFont('Arial','',10);
$y=$pdf->getY();
endif;

endforeach;
$pdf->Cell(210,5,$pdf->PageNo(),0,1,'C');
*/
$filename=SAVEPATH."OPDreg_".$date.".pdf";
$pdf->Output($filename);
echo "OPD Registered printed at".SAVEPATH."<br>";
echo "<a href=".site_url('home').">Go Home</a>";

?>
