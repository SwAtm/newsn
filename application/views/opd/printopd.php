<?php
//called by opd/prinopd($id)
tfpdf();

$pdf = new tFPDF('P', 'mm', array(148,210));
$pdf->SetAutoPageBreak('auto',1);
$pdf->setLeftMargin(14);
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->setXY(65,7);
$pdf->cell(10,5,$language,1,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->setXY(14,33);
$pdf->Cell(120,0,'',1,1,'R');
$pdf->Cell(15,5,'ID NO:  ','L',0,'L');
$pdf->Cell(15,5,$id,'R',0,'R');
$pdf->Cell(15,5,'OPD NO:  ',0,0,'L');
$pdf->Cell(15,5,$opdno,'R',0,'R');
$pdf->Cell(15,5,'DATE:  ',0,0,'L');
$date1=date_create($date);
$date1=date_format($date1,"d-m-Y");
$pdf->Cell(15,5,$date1,'R',0,'R');
$pdf->Cell(15,5,$age,0,0,'L');
$pdf->Cell(15,5,$sex,'R',1,'L');
$pdf->Cell(120,0,'',1,1,'R');
$pdf->Cell(0,5,$name,0,1,'L');
$pdf->Cell(59,5,$add1,0,0,'L');
$pdf->Cell(59,5,$add2,0,1,'L');
$pdf->Cell(59,5,$taluq,0,0,'L');
$pdf->Cell(59,5,$district,0,1,'L');
$pdf->Cell(13,5,'Phone: ',0,0,'L');
$pdf->Cell(20,5,$phone,0,1,'L');

if ('No History'!==$dm):
$pdf->SetFont('Arial','B',9);
$pdf->setFillColor(200);
$pdf->Cell(59,5,'History of DM: '.$dm,0,0,'L',1);
$pdf->SetFont('Arial','',10);
else:
$pdf->Cell(59,5,'History of DM: '.$dm,0,0,'L');
endif;
$pdf->Cell(59,5,'History of HTN: '.$htn,0,1,'L');
$pdf->Cell(20,6,'Any Other: ',0,0,'L');
$pdf->Cell(0,6,"$remark",0,1,'L');
$pdf->ln();
$pdf->ln();
$filename=SAVEPATH."opd_".$id.".pdf";
$pdf->Output($filename);
//$cmd="$pdfprint -print-to $printer $filename";
//system($cmd);
?>

