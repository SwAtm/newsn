<?php
//require_once "save.php";
//require($root."fpdf17/fpdf.php");
$base=base_url('application/images');
tfpdf();
$pdf = new tFPDF('P', 'mm', array(210,297));
//$pdf->SetTopMargin(5);
//include_once "c_queries.php";
foreach($patients as $p):
$pdf->AddPage();
$pdf->SetLeftMargin(20);
$pdf->SetRightMargin(10);
$pdf->SetFont('Arial','B',18);
//$pdf->Image ($base.'/logo.jpg', '10', '10', '', '15');
$pdf->Image (IMGPATH.'logo.jpg', '20', '10', '', '15');
$pdf->Cell(50,5,'',0,0);
$pdf->Cell(7,7,$p['language'],1,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,5,'Sharada Netralaya',0,1,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,5,'Ramakrishna Mission Ashrama',0,1,'R');
$pdf->Cell(0,5,'Fort, Belgaum 590016. Ph 2430789/ 2432789',0,1,'R');
$pdf->Cell(0,0,'',1,1,'R');
$pdf->ln(5);
$pdf->Cell(0,5,'In Patient Record',0,1,'C');
$pdf->ln(5);
$pdf->Cell(50,15,'In Patient No',1,0,'L');
$pdf->Cell(50,15,'ID No  '.$p['id'],1,0,'C');
$pdf->Cell(0,15,'Date: '.$dos,1,1,'R');
$pdf->ln(5);
$pdf->Cell(0,5,'Name and Address',0,1,'L');
$pdf->MultiCell(0,5,$p['name'].", ". $p['add1'].", ". $p['add2'].", ".$p['taluq'].", ".$p['district'].",  Phone No: ".$p['phone'],0,'L');
$pdf->ln(5);

$pdf->Cell(0,5,"Age/Sex: ".$p['dob']."/".$p['sex'],0,0,'L');
if ($p['gvp']=="Yes"):
$p['eye']=$p['eye']."E Under GVP";
else:
$p['eye']=$p['eye']."E";
endif;
$pdf->Cell(0,5,"Surgery Performed: SICS ".$p['eye'],0,1,'R');
$pdf->ln(5);
$pdf->Cell(0,0,'',1,1,'C');
$pdf->ln(5);
/*
for ($i=19; $i<23; $i++):
	if ($row[$i]==0):
		$row[$i]='';
	endif;
endfor;
*/

$pdf->Cell(40,20," ",0,0,'C');
$pdf->Cell(50,20,"K1: ".($p['k1']==0?'':$p['k1']),1,0,'L');
$pdf->Cell(50,20,"K2: ".($p['k2']==0?'':$p['k2']),1,1,'L');
$pdf->Cell(40,20," ",0,0,'C');
$pdf->Cell(50,20,"Axial Length: ".($p['al']==0?'':$p['al']),1,0,'L');
$pdf->Cell(50,20,"IOL: ".($p['iol']==0?'':$p['iol']),1,1,'L');
$pdf->ln(5);
$pdf->Cell(0,10,"History and Findings",0,1,'C');
$pdf->ln(5);
	
$pdf->Cell(90,5,"History of DM: ".$p['dm'],0,0,'L');
$pdf->Cell(90,5,"Rx: ",0,1,'L');
$pdf->ln(5);
$pdf->Cell(90,5,"History of HTN: ".$p['htn'],0,0,'L');
$pdf->Cell(90,5,"Rx: ",0,1,'L');
$pdf->ln(5);
$pdf->Cell(45,10,"RBS: ".$p['rbs'],1,0,'L');
$pdf->Cell(45,10,"ECG: ".$p['ecg'],1,0,'L');
$pdf->Cell(45,10,"Sac: ".$p['sac'],1,0,'L');
$pdf->Cell(45,10,"Tension: ".$p['iop'],1,1,'L');
$pdf->Cell(90,10,"BP (mm/Hg) ",1,0,'L');
$pdf->Cell(90,10,"HR (b/mn) ",1,1,'L');
$pdf->Cell(90,10,"CVS:",1,0,'L');
$pdf->Cell(90,10,"RS:",1,1,'L');
$pdf->ln(5);

$pdf->Cell(60,5,"Any Allergies: ",0,0,'L');
$pdf->Cell(60,5,"Any wound on body: ",0,0,'L');
$pdf->Cell(60,5,"h/o Epilepsy: ",0,1,'L');
$pdf->ln(5);
$pdf->Cell(60,5,"Ear Discharge: ",0,0,'L');
$pdf->Cell(60,5,"Tooth Infection: ",0,0,'L');
$pdf->Cell(60,5,"Anxiety: ",0,1,'L');
$pdf->ln(5);
$pdf->Cell(60,5,"Temparature: ",0,0,'L');
$pdf->Cell(60,5,"Cough: ",0,0,'L');
$pdf->Cell(60,5,"Pedal Oedema: ",0,1,'L');
$pdf->ln(5);
$pdf->Cell(60,5,"Thyroid Enlargement: ",0,0,'L');
$pdf->Cell(60,5,"Loose Stools: ",0,0,'L');
$pdf->Cell(60,5,"Pallor: ",0,1,'L');

$pdf->ln(5);
$pdf->MultiCell(180,5,"Other: ".$p['remark'],0,'L');

//$pdf->Cell(0,5,"Other Findings:",0,1,'L');

$pdf->AddPage();
$pdf->SetRightMargin(20);
$pdf->SetLeftMargin(10);
$pdf->Cell(0,10,"Consent for Surgery",0,1,'C');
if ($p['eye']=="LE"||$p['eye']=="LE Under GVP"):
	$eye="Left Eye";
else:
	$eye="Right Eye";
endif;
$pdf->MultiCell(0,5,"I hereby agree whole heartedly to have CATARACT SURGERY performed on $eye and / or to receive anesthesia in Sharada Netralaya for the under mentioned patient. The procedure and risks have been explained to me in my language. If anything untoward happens during the course of anesthesia and / or operation, I also admit that neither the hospital administration nor the doctors and other employees of the hospital will be held responsible for the same.",0,'J');
$pdf->Cell(0,10,"Name of the patient: ".$p['name'],0,1,'L');
$pdf->Cell(0,10,"Name of person signing the form and relation to patient ",0,1,'L');
$pdf->ln(15);
$y=$pdf->GetY();
$pdf->line(10,$y,190,$y);
$pdf->Cell(0,10,"Patient/Guardian Signature ",0,1,'L');
$pdf->ln(15);
$y=$pdf->GetY();
$pdf->line(10,$y,190,$y);
$pdf->ln(15);
$pdf->Cell(0,10,"Operating Surgeon: ".$p['surgeon'],0,1,'L');
$pdf->ln(10);
$pdf->Cell(0,10,"Notes: Immediately after surgery ",0,1,'L');
$pdf->ln(30);
$y=$pdf->GetY();
$pdf->line(10,$y,190,$y);
$pdf->ln(30);
$pdf->Cell(0,10,"Ist Post Op ",0,0,'L');
$pdf->Cell(0,10,"Date____/_____/____________ ",0,1,'R');
$pdf->ln(30);
$pdf->Cell(0,10,"Second Post Op ",0,0,'L');
$pdf->Cell(0,10,"Date____/_____/____________ ",0,1,'R');
endforeach;

$filename=SAVEPATH."IP Cards_".$dos.".pdf";
$pdf->Output($filename);
?>

