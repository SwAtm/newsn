<?php
tfpdf();
$base=base_url('application/images');
$pdf=new PDF_MC_Table('L', 'mm', array(297,210));
$pdf->setLeftMargin(12);
$date=date('d-m-Y',strtotime($dos));
$pdf->AddFont('brh_deve','','brh_deve.ttf','true');
$pdf->AddFont('brhknd','','brhknd.ttf','true');
foreach ($patients as $p):
$pdf->AddPage();
//page4
$pdf->SetFont('brh_deve','',12);
$pdf->SetXY(10,10);
$pdf->MultiCell(59,8,"9. LMü AÉPûuÉŽÉlÉÇiÉU QûÉåYrÉÉsÉÉ jÉÉåQåû iÉåsÉ sÉÉuÉÑ zÉMüiÉÉ uÉ NûÉåOåû MåüxÉ  QûÉåtrÉÉiÉ eÉÉhÉÉU lÉÉÌWû rÉÉÍcÉ MüÉVûeÉÏ bÉåElÉ MåüxÉ ÌuÉÇcÉÂ zÉMüiÉÉ.
10. uÉeÉlÉSÉU uÉxiÉÑ EcÉsÉÑ lÉrÉå, irÉÉqÉÑVåû QûÉåtrÉÉuÉU iÉÉhÉ mÉQûhÉå zÉYrÉ AÉWåû.
11. sÉWûÉlÉ qÉÑsÉÉÇcrÉÉ oÉUÉåoÉU ZÉåVÒû lÉrÉå. 
12. BmÉUåzÉlÉ MåüsÉåsÉÉ QûÉåVûÉ cÉÉåVÕû lÉrÉå.			
13. kÉÔVûû uÉ kÉÔU rÉÉmÉÉxÉÔlÉ SÕU UWûÉuÉå.
14. jÉÇQûÏ, mÉQûxÉå, ZÉÉåMüsÉÉ AjÉuÉÉ qÉsÉÉuÉUÉåkÉ fÉÉsrÉÉxÉ iÉÉoÉQûiÉÉåoÉ CsÉÉeÉ MüÂlÉ brÉÉuÉÉ.
15. erÉÉmÉÉxÉÔlÉ qÉÉlÉ AjÉuÉÉ QûÉåYrÉÉsÉÉ aÉcÉMüÉ AjÉuÉÉ ÌWûxÉMüÉ oÉxÉåsÉ AzÉÏ WûÉsÉcÉÉsÉ MüÂ lÉrÉå, ES|: qÉxÉÉeÉ, mÉëuÉÉxÉ, uÉaÉæUå.
16. uÉååSlÉÉ WûÉåiÉ AxÉsrÉÉxÉ AjÉuÉÉ QûÉåtrÉÉcÉÏ SØ¹Ï MüqÉÏ fÉÉsrÉÉxÉ iÉÉoÉQûiÉÉåoÉ QûÊYOûUÉÇcÉÉ xÉssÉÉ brÉÉuÉÉ.",0,'J');
$pdf->SetFont('brhknd','',12);
$pdf->SetXY(79,10);
$pdf->MultiCell(59,8,"9. MAzÀÄ ªÁgÀzÀ £ÀAvÀgÀ vÀ¯ÉUÉ ¸Àé®à JuÉÚ ºÀZÀÑ§ºÀÄzÀÄ ªÀÄvÀÄÛ ¸ÀtÚ PÀÆzÀ®Ä PÀtÂÚ£À M¼ÀUÉ ºÉÆÃUÀzÀAvÉ vÀ¯É ¨ÁZÀ§ºÀÄzÀÄ.
10. ªÁåAiÀiÁªÀÄ ªÀiÁqÀ¨ÁgÀzÀÄ ªÀÄvÀÄÛ ¨sÁgÀ JvÀÛ ¨ÁgÀzÀÄ, EzÀjAzÀ PÀtÂÚUÉ vÉÆAzÀgÉAiÀiÁUÀÄvÀÛzÉ.
11. ¸ÀtÚ ªÀÄPÀÌ¼ÉÆA¢UÉ DqÀ¨ÉÃrj.
12. D¥ÀgÉÃ±À£ï DVgÀÄªÀ PÀtÚ£ÀÄß wPÀÄÌªÀÅzÀ£ÀÄß/GdÄÓªÀÅzÀ£ÀÄß ªÀiÁqÀ¨ÉÃr.
13. zsÀÆ¼ÀÄ ªÀÄvÀÄÛ ºÉÆUÉ¬ÄAzÀ zÀÆgÀ«j.
14. ¤ªÀÄUÉ PÉªÀÄÄä, ²ÃvÀ CxÀªÁ ªÀÄ®§zsÀÝvÉ EzÀÝ°è PÀÆqÀ¯ÉÃ aQvÉì ¥ÀqÉ¬Äj.
15. vÀ¯ÉAiÀÄ ªÉÄÃ¯É vÀPÀët dUÀÄÎ«PÉ GAmÁUÀ§ºÀÄzÁzÀ ZÀlÄªÀnPÉ, CAzÀgÉ vÀ¯ÉAiÀÄ ªÀÄ¸Áeï, ¥ÀæªÁ¸À ªÀÄÄAvÁzÀªÀ£ÀÄß ªÀiÁqÀ¨ÉÃrj.
16. PÀtÄÚUÀ¼À°è £ÉÆÃªÀÅAiÀiÁzÀgÉ CxÀªÁ PÁtÂ¸ÀÄªÀÅzÀÄ(zÀÈ¶Ö) PàrªÉÄAiÀiÁUÀÄwÛzÀÝgÉ, PÀÆqÀ¯ÉÃ ¤ªÀÄä qÁPÀÖgÀgÀ£ÀÄß ¸ÀA¥ÀQð¹j.",0,'J');
//page1
$xd=158;
$pdf->SetXY(158,10);
$pdf->Image ($base.'/logo.jpg', '158', '10', '', '15');
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,5,'Sharada Netralaya',0,1,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,5,'Ramakrishna Mission Ashrama',0,1,'R');
$pdf->Cell(0,5,'Fort, Belgaum 590016',0,1,'R');
$pdf->Cell(0,5,'Ph 2430789/2432789||Mobile: 81973 74808',0,1,'R');
$pdf->SetX($xd);
$pdf->Cell(0,0,'',1,1,'R');
$pdf->ln(2);
$pdf->SetX($xd);
$pdf->Cell(128,5,"Discharge Card for IP No ".$p['ipno'],0,1,'C');
$pdf->ln(3);
$pdf->SetX($xd);
$pdf->Cell(128,5,"Name: ".$p['name'],0,1,'L');
$pdf->SetX($xd);
$pdf->MultiCell(128,5,"Address: ".$p['add1'].", ". $p['add2'].", ".$p['taluq'].", "."Phone: ".$p['phone'],0);
$pdf->ln(2);
$pdf->SetX($xd);
$pdf->Cell(64,5,"Age/Sex: ".$p['dob']."/".$p['sex'],0,0);
$pdf->cell(64,5,"DOS: ".$date,0,1,'R');
$pdf->ln(2);
$pdf->SetX($xd);
$pdf->Cell(128,5,"Surgery Performed: SICS ".$p['eye'],0,1);
$pdf->ln(5);
$pdf->SetX($xd);
$pdf->Cell(128,5, "Post Operative Medicines",0,1,'C');
$pdf->ln(5);
$pdf->SetX($xd+12);
$pdf->cell(60,8,$discharge['m1'],1,0);
$pdf->cell(20,8,$discharge['t1'],1,0);
$pdf->cell(25,8,$discharge['d1'],1,1);

$pdf->SetX($xd+12);
$pdf->cell(60,8,$discharge['m2'],1,0);
$pdf->cell(20,8,$discharge['t2'],1,0);
$pdf->cell(25,8,$discharge['d2'],1,1);

$pdf->SetX($xd+12);
$pdf->cell(60,8,$discharge['m3'],1,0);
$pdf->cell(20,8,$discharge['t3'],1,0);
$pdf->cell(25,8,$discharge['d3'],1,1);

$pdf->SetX($xd+12);
$pdf->cell(105,8,"Eye Drop-Ciplox-D/Oflox-D: As on Page 2 for 6 weeks",1,1);

$pdf->ln(10);
$pdf->SetX($xd+12);
$pdf->cell(60,8,"First Post Op Date",1,0);
$pdf->cell(45,8, $discharge['p1']." at ".$discharge['tm1'],1,1);

$pdf->SetX($xd+12);
$pdf->cell(60,8,"Second Post Op Date",1,0);
$pdf->cell(45,8, $discharge['p2']." at ".$discharge['tm2'],1,1);


$pdf->ln(10);
$pdf->SetX($xd+12);
$pdf->cell(105,8,"Post Operative Vision",1,1,'C');

$pdf->SetX($xd+12);
$pdf->cell(35,8, "Date",1,0,'C');
$pdf->cell(35,8, "RE",1,0,'C');
$pdf->cell(35,8, "LE",1,1,'C');

$pdf->SetX($xd+12);
$pdf->cell(35,8,$discharge['p1'],1,0,'C');
$pdf->cell(35,8, "6/",1,0);
$pdf->cell(35,8, "6/",1,1);

$pdf->SetX($xd+12);
$pdf->cell(35,8,$discharge['p2'],1,0,'C');
$pdf->cell(35,8, "6/",1,0);
$pdf->cell(35,8, "6/",1,1);

//page 2
$pdf->AddPage();
$pdf->Cell(20,8,"Date",1,0,'C');
$pdf->Cell(108,8,"Time",1,1,'C');
$pdf->Rect(12,18,20,32);
$pdf->Rect(32,18,108,32);

$pdf->SetFont('Arial','',10);
$dosf=date_create($date);
date_add($dosf, date_interval_create_from_date_string('1 day'));
$date=date_format($dosf,"d-m-Y");

$pdf->Cell(20,12,$date,0,0);

$pdf->SetFont('brh_deve','',12);
$pdf->MultiCell(108,6,"xÉMüÉVûÏ 08.00 || xÉMüÉVûÏ 10.00 || SÒmÉÉUÏ 12.00 || SÒmÉÉUÏ 02.00 || xÉÇkrÉÉ. 04.00 || xÉÇkrÉÉ. 06.00 || UÉÌ§É 08.00
",0,1);

$pdf->SetFont('Arial','',10);
$pdf->Cell(20,8,"TO",0,0,'C');
$pdf->Cell(108,8,"8 AM-10 AM-12 NOON-2 PM-4 PM-6 PM-8 PM",0,1);


//$dos=date_create($dos);
date_add($dosf, date_interval_create_from_date_string('6 days'));
$date=date_format($dosf,"d-m-Y");
$pdf->Cell(20,12,$date,0,0);

$pdf->SetFont('brhknd','',12);
$pdf->MultiCell(108,6,"¨É¼ÀUÉÎ 08.00 || ¨É¼ÀUÉÎ 10.00 || ªÀÄzsÁåºÀß 12.00 || ªÀÄzsÁåºÀß  02.00 || ¸ÁAiÀÄAPÁ® 04.00 || ¸ÁAiÀÄAPÁ® 06.00 || gÁwæ 08.00",0,1);
$pdf->SetFont('Arial','',10);

//
$pdf->Rect(12,50,20,32);
$pdf->Rect(32,50,108,32);
date_add($dosf, date_interval_create_from_date_string('1 day'));
$date=date_format($dosf,"d-m-Y");
$pdf->Cell(20,12,$date,0,0);

$pdf->SetFont('brh_deve','',12);
$pdf->MultiCell(108,6,"xÉMüÉVûÏ 08.00 || xÉMüÉVûÏ 11.00 || SÒmÉÉUÏ 02.00 || xÉÇkrÉÉMüÉVûÏ 05.00 || UÉÌ§É 08.00
",0,1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,8,"TO",0,0,'C');
$pdf->Cell(108,8,"8 AM-11 AM-2 PM-5 PM-8 PM",0,1);
date_add($dosf, date_interval_create_from_date_string('6 days'));
$date=date_format($dosf,"d-m-Y");
$pdf->Cell(20,12,$date,0,0);
$pdf->SetFont('brhknd','',12);
$pdf->MultiCell(108,6,"¨¨É¼ÀUÉÎ 08.00 || ¨É¼ÀUÉÎ 11.00 || ªÀÄzsÁåºÀß 02.00 || ¸ÁAiÀÄAPÁ® 05.00 || gÁwæ 08.00
",0,1);
$pdf->SetFont('Arial','',10);

$pdf->Rect(12,82,20,32);
$pdf->Rect(32,82,108,32);
date_add($dosf, date_interval_create_from_date_string('1 day'));
$date=date_format($dosf,"d-m-Y");
$pdf->Cell(20,12,$date,0,0);

$pdf->SetFont('brh_deve','',12);
$pdf->Cell(108,12,"xÉMüÉVûÏ 08.00 || SÒmÉÉUÏ 12.00 || xÉÇkrÉÉMüÉVûÏ 04.00 || UÉÌ§É 08.00
",0,1);
$pdf->SetFont('Arial','',10);


$pdf->Cell(20,8,"TO",0,0,'C');
$pdf->Cell(108,8,"8 AM-12 NOON-4 PM-8 PM",0,1);
date_add($dosf, date_interval_create_from_date_string('6 days'));
$date=date_format($dosf,"d-m-Y");
$pdf->Cell(20,12,$date,0,0);
$pdf->SetFont('brhknd','',12);
$pdf->Cell(108,12,"¨É¼ÀUÉÎ 08.00 || ªÀÄzsÁåºÀß 12.00 || ¸ÁAiÀÄAPÁ® 04.00 || gÁwæ 08.00
",0,1);
$pdf->SetFont('Arial','',10);


$pdf->Rect(12,114,20,32);
$pdf->Rect(32,114,108,32);
date_add($dosf, date_interval_create_from_date_string('1 day'));
$date=date_format($dosf,"d-m-Y");
$pdf->Cell(20,12,$date,0,0);

$pdf->SetFont('brh_deve','',12);
$pdf->Cell(108,12,"xÉMüÉVûÏ 08.00 || SÒmÉÉUÏ 02.00 || UÉÌ§É 08.00
",0,1);
$pdf->SetFont('Arial','',10);


$pdf->Cell(20,8,"TO",0,0,'C');
$pdf->Cell(108,8,"8 AM-2 PM-8 PM",0,1);
date_add($dosf, date_interval_create_from_date_string('20 days'));
$date=date_format($dosf,"d-m-Y");
$pdf->Cell(20,12,$date,0,0);
$pdf->SetFont('brhknd','',12);
$pdf->MultiCell(108,12,"¨É¼ÀUÉÎ 08.00 || ªÀÄzsÁåºÀß 02.00 || gÁwæ 08.00
",0,1);
//page 3
$pdf->SetFont('brh_deve','',12);
$pdf->SetXY(158,10);
$pdf->MultiCell(59,8,"1. AÉæwÉkÉÉcÉÉ QûÉåtrÉÉiÉ EmÉrÉÉåaÉ MüUhrÉÉmÉÔuÉÏï WûÉiÉ xuÉcNû kÉÑiÉsÉåsÉå WûuÉåiÉ.
2. AÉæwÉkÉ QûÉåtrÉÉcrÉÉ ZÉÉsÉcrÉÉ mÉÉmÉhÉÏcrÉÉ AÉiÉ bÉÉsÉÉuÉå. 
3. AÉæwÉkÉ Tü£ü BmÉUåzÉlÉ MåüsÉåsrÉÉ QûÉåtrÉÉiÉ LMüÉuÉåVûÏ LMü ÌMÇüuÉÉ SÉålÉ jÉåÇoÉ bÉÉsÉÉuÉå.
4. AÉrÉç QíûÊmÉ xÉÇmÉsrÉÉxÉ SÒMüÉlÉÉiÉÔlÉ ZÉUåSÏ MüÂlÉ brÉÉuÉå
5. QûÉåtrÉÉcrÉÉ xÉÇU¤ÉhÉÉxÉÉPûÏ xÉWûÉ AÉPûuÉQåû MüÉrÉqÉ MüÉVûÉ cÉwqÉÉ sÉÉuÉÉuÉÉ
6. BmÉUåzÉlÉ MåüsÉåsrÉÉ QûÉåtrÉÉcrÉÉ oÉÉeÉÔcrÉÉ MÑüzÉÏuÉU fÉÉåmÉÔ lÉrÉå.
7. xÉWûÉ AÉPûuÉQåû QûÉåYrÉÉuÉÃlÉ AÉÇbÉÉåVû MüÂ lÉrÉå AjÉuÉÉ BmÉUåzÉlÉ MåüsÉåsÉÉ QûÉåVûÉ kÉÑuÉÔ lÉrÉå.
8. ÌSuÉxÉÉiÉÔlÉ iÉÏlÉ uÉåVûÉ mÉÉhrÉÉiÉ ÍpÉeÉuÉÑlÉ ÌmÉVûsÉåsrÉÉ MüÉmÉxÉÉlÉå QûÉåVåû xuÉcNû MüUÉuÉå uÉ ÍpÉeÉuÉÑlÉ ÌmÉVûsÉåsrÉÉ ÂqÉÉsÉÉlÉå iÉÉåÇQû mÉÑxÉÉuÉå.
",0,'J');
$pdf->SetFont('brhknd','',12);
$pdf->SetXY(227,10);
$pdf->MultiCell(59,8,"1. L qÁæ¥ï G¥ÀAiÉÆÃV¸ÀÄªÀ ªÉÆzÀ®Ä PÉÊUÀ¼À£ÀÄß ZÉ£ÁßV vÉÆ¼ÉzÀÄPÉÆ¼Àî¨ÉÃPÀÄ.
2. L qÁæ¥ï£ÀÄß PÀtÂÚ£À PÉ¼ÀgÀ¥ÉàAiÀÄ M¼ÀUÉ ºÁPÀ¨ÉÃPÀÄ. 
3. L qÁæ¥ï C£ÀÄß PÉÃªÀ® D¥ÀgÉÃ±À£ï DzÀ PÀtÂÚUÉ ªÀiÁvÀæ ºÁPÀ¨ÉÃPÀÄ. 
4. L qÁæ¥ï SÁ°AiÀiÁzÀ°è ºÉÆ¸ÀzÀ£ÀÄß PÉÆAqÀÄPÉÆ½î.
5. PÀtÄÚUÀ¼À ¸ÀAgÀPÀëuÉUÁV DgÀÄªÁgÀUÀ¼À PÁ® PÀ¥ÀÅ à PÀ£ÀßqÀPÀ ºÁQPÉÆ½îj.
6. D¥ÀgÉÃ±À£ï DVgÀÄªÀ PÀtÂÚ£À PÀqÉ vÀ¯É ElÄÖ ªÀÄ®UÀ¨ÉÃr.
7. D¥ÀgÉÃ±À£ï DzÁUÀ DgÀÄ ªÁgÀ vÀ¯ÉUÉ ¸Áß£À ªÀiÁqÀ¨ÉÃrj ªÀÄvÀÄÛ D PÀtÂÚUÉ ¤ÃgÀ£ÀÄßß ºÁPÀ¨ÉÃr.
8. ¢£ÀPÉÌ ªÀÄÆgÀÄ ¨Áj ºÀwÛAiÀÄ£ÀÄß ªÉÆzÀ®Ä vÉÆ¼ÉzÀÄ CzÀ£ÀÄß ZÉ£ÁßV »Ar, £ÀAvÀgÀ PÀtÚ£ÀÄß MgÉ¹. ¤Ãj¤AzÀ MzÉÝ ªÀiÁr  »ArzÀ §mÉÖAiÀÄ°è ªÀÄÄRªÀ£ÀÄß MgÉ¹PÉÆ½î. ",0,'J');

endforeach;
$filename=SAVEPATH."Discharge- ".$dos.".pdf";
$pdf->Output($filename);

?>
