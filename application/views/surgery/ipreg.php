<?php
$base=base_url('application/images');
tfpdf();
$pdf = new tFPDF('P', 'mm', array(210,297));
$pdf->AddPage();
$pdf->SetFont('Arial','',14);
$pdf->Image ($base.'/logo.jpg', '10', '10', '', '15');
$pdf->ln(15);
$pdf->Cell(43,5,'Sharada Netralaya',0,0,'L');
$pdf->SetFont('Arial','',12);
$pdf->Cell(60,5,'Ramakrishna Mission Ashrama',0,0,'L');
$pdf->Cell(50,5,'Fort, Belgaum 590016. Ph 2430789/ 2432789',0,1,'L');
$pdf->Cell(0,0,'',1,1,'R');
$pdf->Cell(0,5,'In Patient Register',0,1,'C');
$pdf->Cell(0,5,"Date: ".date('d-m-Y',strtotime($dos)),0,1,'R');
$pdf->ln(5);
$pdf->Cell(20,5,'I P No',1,0,'C');
$pdf->Cell(55,5,'Name and Address',1,0,'C');
$pdf->Cell(10,5,'A/S',1,0,'C');
$pdf->Cell(35,5,'Details',1,0,'C');
$pdf->Cell(70,5,'Remark',1,1,'C');
foreach ($patients as $p):
	if($pdf->GetY() + 40 > $pdf->PageBreakTrigger):
$pdf->ln(5);
$pdf->Cell(210,5,$pdf->PageNo(),0,1,'C');
$pdf->AddPage($pdf->CurOrientation);
$pdf->Cell(0,5,"Date: ".date('d-m-Y',strtotime($dos)),0,1,'R');
$pdf->ln(5);
$pdf->Cell(20,5,'I P No',1,0,'C');
$pdf->Cell(55,5,'Name and Address',1,0,'C');
$pdf->Cell(10,5,'A/S',1,0,'C');
$pdf->Cell(35,5,'Details',1,0,'C');
$pdf->Cell(70,5,'Remark',1,1,'C');
	endif;


$x=$pdf->GetX();
$y=$pdf->GetY();
$pdf->cell(20,30,$p['ipno'],1,0,'C');
$pdf->MultiCell(55,5,$p['name'].", ".$p['add1'].", ".$p['add2'].", ".$p['taluq'].", ".$p['district'].", "." Phone No: ".$p['phone'],'J');
$pdf->Rect($x+20,$y,55,30);
$pdf->SetXY($x+75,$y);
$pdf->cell(10,15,$p['dob'],1,0,'C');
$pdf->SetXY($x+75,$y+15);
$pdf->cell(10,15,$p['sex'],1,1,'C');
$pdf->SetXY($x+85,$y);
$x=$pdf->GetX();
$y=$pdf->GetY();
$pdf->cell(35,5,"K1: ".$p['k1'],1,0,'C');
$pdf->SetXY($x,$y+5);
$pdf->cell(35,5,"K2: ".$p['k2'],1,0,'C');
$pdf->SetXY($x,$y+10);
$pdf->cell(35,5,"AL: ".$p['al'],1,0,'C');
$pdf->SetXY($x,$y+15);
$pdf->cell(35,5,"IOL: ".$p['iol'],1,0,'C');
//$pdf->SetXY($x+45,$y);
$pdf->SetXY($x,$y+20);
$pdf->cell(35,5,"Opd Eye : ",1,0,'C');
$pdf->SetXY($x,$y+25);
$pdf->cell(35,5,$p['eye'],1,0,'C');
$pdf->SetXY($x+35,$y);
$pdf->cell(70,30,"",1,1,'L');
endforeach;
$pdf->ln(5);
$pdf->Cell(210,5,$pdf->PageNo(),0,1,'C');	
$filename=SAVEPATH."IP Reg_".$dos.".pdf";
$pdf->Output($filename);
echo "IP Register And Discharge sheets printed at".SAVEPATH."<br>";
echo "<a href=".site_url('home').">Go Home</a>";

?>
