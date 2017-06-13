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

$actualiza=$misql->Execute("update trabajo_titulacion set imprime_solicitud='S' where no_de_control='$nocontrol'");

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

encabezado_solicitud($pdf);

$x = 15;
$y = 43;
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
$pdf->Cell($w, $h, "Solicitud del Estudiante", 0, 1, 'C');
$pdf->SetFont('SoberanaSans-Regular','','9');
$pdf->Cell($w, $h, "Referencia a la Norma ISO 9001:2008 7.5.1", 0, 1, 'C');
$pdf->Ln(4);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(0, $h,"Tuxtepec, Oaxaca a ".date("d")." de ".nombre_mes(date("m"))." de ".date("Y"), 0, 1,'R');
$pdf->Ln(5);
$pdf->Cell(0,$h,utf8_decode("M.E. JULIÁN KURI MAR"),0,1);
$pdf->Cell(0,$h,utf8_decode("JEFE DE LA DIVISIÓN DE ESTUDIOS PROFESIONALES"),0,1);
$pdf->Cell(0,$h,"P R E S E N T E",0,1);
$pdf->Ln(3);
$pdf->Cell(95,$h,"",0,0);
$pdf->Cell(0,$h,utf8_decode("ATN: M.A. HEIDY ARCURI SALINAS"),0,1);
$pdf->Cell(95,$h,"",0,0);
$pdf->Cell(0,$h,utf8_decode("COORDINADORA DE APOYO A LA TITULACION"),0,1);
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(0,$h,utf8_decode("Por medio de la presente solicito autorización para iniciar trámites de titulación:"),0,1);
$pdf->Ln(3);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(40, $h+5, "Nombre del Estudiante:", 0, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(150, $h+5, $registro->fields('nombre_egresado'), 0, 1);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(40, $h+5, "Carrera:", 0, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(150, $h+5, $nombre_carrera, 0, 1);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(40, $h+5, "No. de Control:", 0, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(150, $h+5, $nocontrol, 0, 1);
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(40, $h, "Nombre del Proyecto:", 0, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->MultiCell($w-40, $h,utf8_decode($registro->fields('nombre_proyecto')), 0, 'J');
$pdf->SetFont('SoberanaSans-Regular','','12');
$posy=$pdf->GetY();
$pdf->Cell(40,$h,"Producto:",0,0);
$opcion=$registro->fields['opcion_titulacion'];
$ropc=$misql->Execute("select * from opciones_titulacion where opcion='$opcion'");
if($opcion=='T')
{
 $producto=$registro->fields['producto'];
 $rp=$misql->Execute("select * from producto where producto='$producto'");	
 $cadfinal=strtoupper($rp->fields['descripcion'])."\n";
}
$cadfinal.=strtoupper($ropc->fields['descripcion'])."\n";
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->MultiCell(160,$h+5,$cadfinal,0,'J');
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(0,$h,utf8_decode("En espera de dictamen correspondiente, quedo a sus órdenes"),0,1);
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Black','',10);
$pdf->Cell(0,$h,"A T E N T A M E N T E",0,1);
$pdf->Ln(10);
$pdf->Cell(0, $h,$registro->fields('nombre_egresado'), 0, 1);
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(60, $h+5,utf8_decode("Dirección:"), 1, 0);
$pdf->SetFont('SoberanaSans-Black','','7.5');
$pdf->Cell(130, $h+5, $registro->fields('domicilio'), 1, 1);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(60, $h+5, utf8_decode("Teléfono particular o de contacto:"), 1, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(130, $h+5, $registro->fields('telefono'), 1, 1);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(60, $h+5, utf8_decode("Correo Electrónico del estudiante:"), 1, 0);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(130, $h+5, $registro->fields('email'), 1, 1);
$pdf->SetFont('SoberanaSans-Regular','',6);
$registro_sgc="REGISTRO SGC\nCódigo: ITTUX-AC-PO-008-05\nRevision: 1\nFecha Autorización: 19/Junio/2014";
$pdf->SetXY($x+150,264);
$pdf->MultiCell(40,$h-1,utf8_decode($registro_sgc),0,'J');
pie_solicitud($pdf);

$pdf->Output();
?>
