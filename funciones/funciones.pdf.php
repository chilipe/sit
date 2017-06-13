<?php

function nvo_encabezado_oficial($pdf)
{
	$x_sep = 10;
	$y_sep = 10;
	$pdf->Image("../img/logo_hoja_sep.jpg", $x_sep, $y_sep,80,55);
	$pdf->SetFont('SoberanaSans-Light','','8');
	$pdf->SetXY(32,49);  
    //$pdf->MultiCell(150,4.5, '"2015, Año del Generalisimo José María Morelos y Pavón"'."\n", 0, 'C', 0);
	$pdf->SetFont('SoberanaSans-Light','','9');
	$pdf->SetXY(90, 33);
	$pdf->MultiCell(115, 4.9, "TECNOLÓGICO NACIONAL DE MÉXICO", 0, 'R', 0);
	$pdf->SetXY(90, 37);
	$pdf->SetFont('SoberanaSans-Light','','8');
	$pdf->MultiCell(115, 4.9, "Instituto Tecnológico de Tuxtepec", 0, 'R', 0);
    $pdf->Image("../img/escudo_nacional.jpg", 18, 110,155);
}

function encabezado_solicitud($pdf)
{
	$x_sep = 10;
	$y_sep = 10;
	$pdf->Image("../img/escudo.jpg", $x_sep, $y_sep,30,30);
	$pdf->SetFont('SoberanaSans-Light','','8');
	$pdf->SetXY(32,49);  
    //$pdf->MultiCell(150,4.5, '"2015, Año del Generalisimo José María Morelos y Pavón"'."\n", 0, 'C', 0);
	$pdf->SetFont('SoberanaSans-Light','','14');
	$pdf->SetXY(90, 21);
	$pdf->MultiCell(115, 4.9, "TECNOLÓGICO NACIONAL DE MÉXICO", 0, 'R', 0);
	$pdf->SetXY(90, 27);
	$pdf->SetFont('SoberanaSans-Light','','12');
	$pdf->MultiCell(115, 4.9, "Instituto Tecnológico de Tuxtepec", 0, 'R', 0);
    //$pdf->Image("../img/escudo_nacional.jpg", 18, 110,155);
}


function nvo_pie_oficial($pdf)
{
	$y = 258;
	$x = 7;
	$w = 120;
	$h = 6;
	$x+=40;
	$pdf->SetXY($x-2, $y+7);
	$pdf->SetFont('Helvetica','','7');
	$pdf->Cell($w, $h/3, "", 0, 2, 'C');
    $pdf->SetFont('SoberanaSans-Regular','','7');
	$pdf->Cell($w-15, $h/2,utf8_encode("Av. Dr. Victor Bravo Ahuja S/N, Col. 5 de Mayo, C.P. 68350, Tuxtepec, Oaxaca"), 0, 2, 'C');
     $pdf->Cell($w-15, $h/2,"Teléfono: (287) 5 10 44 Fax: (287) 5 18 80 e-mail: info@ittux.edu.mx", 0, 2, 'C');
    $pdf->SetFont('SoberanaSans-Black','','8');
	$pdf->Cell($w-15, $h/2, "http://www.ittux.edu.mx", 0, 2, 'C');
	$pdf->SetFont('Helvetica','','4');
	//$pdf->Image("../img/logo6.jpg", 155, 270, 30);
	//$pdf->Image("../img/logo5.jpg", 180, 270, 23);
	$pdf->Image("../img/meg.jpg", 143, 270, 16);
    $pdf->Image("../img/escudo.jpg", 13, 270, 16);
    $pdf->Image("../img/logo_calidad.jpg", 165, 266, 40);
	//$pdf->SetXY(145,266);
    //$pdf->SetFont('SoberanaSans-Regular','',4);
    //$pdf->MultiCell(60,2,"Proceso Educativo: Que comprende desde la inscripcion hasta la entrega del titulo y cedula profesional de licenciatura",0,'C');
	$pdf->SetLineWidth(0.1);
	$pdf->SetDrawColor(0);
}

function pie_solicitud($pdf)
{
	$pdf->Image("../img/logo_calidad.jpg", 130, 275, 37);
	$pdf->SetLineWidth(0.1);
	$pdf->SetDrawColor(0);
}

function nombre_mes($mes)
{
 $meses['01']="ENERO";$meses['02']="FEBRERO";$meses['03']="MARZO";$meses['04']="ABRIL";$meses['05']="MAYO";$meses['06']="JUNIO";
 $meses['07']="JULIO";$meses['08']="AGOSTO";$meses['09']="SEPTIEMBRE";$meses['10']="OCTUBRE";$meses['11']="NOVIEMBRE";$meses['12']="DICIEMBRE";
 return $meses[$mes];
}

function siglas_depto($depto)
{
 $siglasd['110600']="DSC-u%MMHC/prg*";
 $siglasd['110200']="DMM-k-u%MJFC/lmc*";
 $siglasd['110500']="DIEE-w%SRZC/lhs*";
 $siglasd['110700']="DCEA-n%LZV/psma*";
 $siglasd['110400']="DCT-i%GITT/hvha*";
 $siglasd['111100']="DQB-m%JMPP/mave*";
 return $siglasd[$depto];
}

function nombre_titulo($carrera,$sexo)
{
 $titulo['1']="INGENIER".$sexo." BIOQUIMIC".$sexo;
 $titulo['2']="INGENIER".$sexo." CIVIL";
 $titulo['3']="INGENIER".$sexo." ELECTROMECANIC".$sexo;
 $titulo['4']="LICENCIAD".$sexo." EN CONTADURIA";
 $titulo['5']="LICENCIAD".$sexo." EN ADMINISTRACION INDUSTRIAL";
 $titulo['6']="INGENIER".$sexo." EN SISTEMAS COMPUTACIONALES";
 $titulo['7']="LICENCIAD".$sexo." EN INFORMATICA";
 $titulo['8']="LICENCIAD".$sexo." EN ADMINISTRACION";
 $titulo['9']="INGENIERO".$sexo." EN ELECTRONICA";
 $titulo['11']="INGENIERO".$sexo." EN GESTION EMPRESARIAL";
 $titulo['12']="INGENIER".$sexo." INFORMATIC".$sexo;
 $titulo['13']="CONTADOR".$sexo." PUBLIC".$sexo;
 return $titulo[$carrera];
}
?>
