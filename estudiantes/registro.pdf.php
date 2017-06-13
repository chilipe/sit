<?php
session_start();
 if (!isset($_SESSION['nocontrol'])) {
	header('location: ../index.html');
}

require('../funciones/funciones.pdf.php');
require('../../fpdf/fpdf.php');
require('../../adodb/adodb.inc.php');
require('../conexion.php');

$nocontrol=$_SESSION['nocontrol'];

$db=conectar();
$misql=conectar_mysql();

$actualiza=$misql->Execute("update trabajo_titulacion set imprime_registro='S' where no_de_control='$nocontrol'");


$busqueda="select * from trabajo_titulacion where no_de_control='$nocontrol'";
$registro=$misql->Execute($busqueda);

if($registro->Recordcount() == 0){
        die("<script>alert('No has Registrado tu Proyecto de Ttitulación!!!');
                self.opener=this;
                self.close();
        </script>");
}

$pdf = new FPDF();
$pdf->AddPage();

$pdf->AddFont('SoberanaSans-Regular','','SoberanaSans-Regular.php');
$pdf->AddFont('SoberanaSans-Bold','','SoberanaSans-Bold.php');
$pdf->AddFont('SoberanaSans-BoldItalic','','SoberanaSans-BoldItalic.php');
$pdf->AddFont('SoberanaSans-Light','','SoberanaSans-Light.php');
$pdf->AddFont('SoberanaSans-LightItalic','','SoberanaSans-LightItalic.php');
$pdf->AddFont('SoberanaSans-Black','','SoberanaSans-Black.php');
$pdf->AddFont('SoberanaSans-BlackItalic','','SoberanaSans-BlackItalic.php');
$pdf->AddFont('SoberanaSans-Ultra','','SoberanaSans-Ultra.php');
$pdf->AddFont('SoberanaSans-UltraItalic','','SoberanaSans-UltraItalic.php');

nvo_encabezado_oficial($pdf);

$x = 15;
$y = 55;
$w = 185;
$h = 4;

$carrera=$registro->fields['carrera'];
$reticula=$registro->fields['reticula'];

$pdf->SetXY($x, $y);
$pdf->SetFont('Arial','b','11');
$instituto="Instituto Tecnologico de Tuxtepec";
$instituto=str_replace("á","a",$instituto);
$instituto=str_replace("é","e",$instituto);
$instituto=str_replace("í","i",$instituto);
$instituto=str_replace("ó","o",$instituto);
$instituto=str_replace("ú","u",$instituto);
$instituto=str_replace("Á","A",$instituto);
$instituto=str_replace("É","E",$instituto);
$instituto=str_replace("Í","I",$instituto);
$instituto=str_replace("Ó","O",$instituto);
$instituto=str_replace("Ú","U",$instituto);

$busca_carrera="select * from carreras where carrera='$carrera'";
$carrera=$db->Execute($busca_carrera);
$nombre_carrera=$carrera->fields['nombre_carrera'];

$periodo=$registro->fields['periodo'];
$busca_periodo="select * from periodos_escolares where periodo='$periodo'";
$exec_periodo=$db->Execute($busca_periodo);

$area_academica=$registro->fields['depto_academico'];

$rfc=$registro->fields['asesor_interno'];
$busca_rfc="select * from personal where rfc='$rfc'";
$datos=$db->Execute($busca_rfc);

$nombre=$datos->fields['nombre_empleado'];
$apellidos=$datos->fields['apellidos_empleado'];

$busca_depto="select * from jefes where clave_area='$area_academica'";
$datos_depto=$db->Execute($busca_depto);


$pdf->Ln();
$pdf->SetFont('SoberanaSans-Black','','9');
$pdf->Cell($w, $h, utf8_decode("SUBDIRECCIÓN ACADEMICA"), 0, 1, 'C');
$pdf->Cell($w, $h, utf8_decode("División de Estudios Profesionales"), 0, 1, 'C');
$pdf->SetFont('SoberanaSans-Regular','','9');
$pdf->Ln(2);
$pdf->Cell($w, $h, utf8_decode("Procedimiento para Titulación"), 0, 1, 'C');
$pdf->Ln(2);
$pdf->SetFont('SoberanaSans-Black','','9');
$pdf->Cell($w, $h, "Registro de Proyecto", 0, 1, 'C');
$pdf->SetFont('SoberanaSans-Regular','','9');
$pdf->Cell($w, $h, "Referencia a la Norma ISO 9001:2008 7.5.1", 0, 1, 'C');
$pdf->Ln(4);

$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(35,$h, "Departamento: ",0,0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell($w,$h,$datos_depto->fields('descripcion_area'),0,1);
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(13, $h, "Lugar:", 0, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(115, $h,"Tuxtepec, Oax.", 0, 0);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(14, $h, "Fecha:", 0, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(0, $h, date("d")." de ".nombre_mes(date("m"))." de ".date("Y"), 0, 1,'C');
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(40, $h, "Nombre del Proyecto:", 0, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->MultiCell($w-40, $h,utf8_decode($registro->fields('nombre_proyecto')), 0, 'J');
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(40,$h,"Nombre del Asesor:",0,0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(63, $h, $nombre." ".$apellidos,0,1);
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->cell(45, $h, "Numero de Estudiantes:", 0, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(10, $h, $registro->fields('numero_egresados'), 0, 1);
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Black','','12');
$pdf->Cell($w, $h, "Datos del estudiante", 0, 1,'C');
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(30, $h+5, "Nombre:", 1, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(160, $h+5, $registro->fields('nombre_egresado'), 1, 1);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(30, $h+5, "No. de Control:", 1, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(160, $h+5, $nocontrol, 1, 1);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(30, $h+5, "Carrera:", 1, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(160, $h+5, $nombre_carrera, 1, 1);
$pdf->Ln(7);
$pdf->SetFont('SoberanaSans-Regular','','12');
$posy=$pdf->GetY();
$pdf->Rect(10,$posy-7,190,73);
$pdf->Cell(30,$h,"Observaciones:",0,0);
$opcion=$registro->fields['opcion_titulacion'];
$ropc=$misql->Execute("select * from opciones_titulacion where opcion='$opcion'");
$cadfinal=utf8_decode("Opción de Titulación: ").$ropc->fields['descripcion']."\n";
if($opcion=='T')
{
 $producto=$registro->fields['producto'];
 $rp=$misql->Execute("select * from producto where producto='$producto'");	
 $cadfinal.="Producto: ".$rp->fields['descripcion']."\n";
}
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->MultiCell(160,$h+5,$cadfinal,0,'J');


$pdf->Cell(1, $h, "", 0, 2);
$pdf->Cell(1, $h, "", 0, 2);
$pdf->Cell(1, $h, "", 0, 2);
$pdf->Cell(1, $h, "", 0, 2);
$pdf->Cell(1, $h, "", 0, 2);
$pdf->Cell(1, $h, "", 0, 2);
$pdf->Cell(1, $h, "", 0, 2);
$pdf->Cell(1, $h, "", 0, 2);
$pdf->Line(40,225,105,225);
$pdf->SetFont('SoberanaSans-Black','',10);
$pdf->SetXY($x+25,230);
$pdf->Cell(65, $h,$registro->fields('nombre_egresado'), 0, 0,'C');
$pdf->Line(118,225,188,225);
$pdf->SetXY($x+105,215);
$pdf->Cell(65,$h,"A u t o r i z o",0,1,'C');
$pdf->SetXY($x+105,230);
$pdf->Cell(65,$h,$datos_depto->fields('jefe_area'),0,1,'C');
$pdf->SetXY($x+105,234);
$pdf->Cell(65,$h,"Jefe(a) del Depto. Academico",0,1,'C');
$pdf->SetFont('SoberanaSans-Regular','',6);
$registro_sgc="REGISTRO SGC\nCódigo: ITTUX-AC-PO-008-04\nRevision: 1\nFecha Autorización: 19/Junio/2014";
$pdf->SetXY($x+150,254);
$pdf->MultiCell(45,$h-1,utf8_decode($registro_sgc),0,'J');

nvo_pie_oficial($pdf);

$pdf->Output();
?>
