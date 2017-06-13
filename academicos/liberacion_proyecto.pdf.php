<?php
session_start();
 if (!isset($_SESSION['nomusua'])) {
	header('location: ../index.html');
}

require('../funciones/funciones.pdf.php');
require('../../fpdf/fpdf.php');
require('../../adodb/adodb.inc.php');
require('../conexion.php');

$nocontrol=$_POST['nocontrol'];
$nombre_estudiante=$_POST['nomegresado'];
$no_oficio=$_POST['no_oficio'];
$asesor=$_POST['asesor_interno'];

$db=conectar();
$misql=conectar_mysql();

$busqueda="select * from trabajo_titulacion where no_de_control='$nocontrol'";
$registro=$misql->Execute($busqueda);

if($registro->Recordcount() == 0){
        die("<script>alert('No hay Proyecto de Titulación Registrado para este Numero de Control!!!');
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
$h = 5;

$carrera=$registro->fields['carrera'];
$reticula=$registro->fields['reticula'];

$busca_carrera="select * from carreras where carrera='$carrera'";
$carrera=$db->Execute($busca_carrera);
$nombre_carrera=$carrera->fields['nombre_carrera'];

$area_academica=$registro->fields['depto_academico'];

$rfc=$registro->fields['asesor_interno'];
$busca_rfc="select * from personal where rfc='$rfc'";
$datos=$db->Execute($busca_rfc);
$nombre_asesor=$datos->fields['nombre_empleado']." ".$datos->fields['apellidos_empleado'];

$rfc=$registro->fields['revisor1'];
$busca_rfc="select * from personal where rfc='$rfc'";
$datos=$db->Execute($busca_rfc);
$nombre_revisor1=$datos->fields['nombre_empleado']." ".$datos->fields['apellidos_empleado'];

$rfc=$registro->fields['revisor2'];
$busca_rfc="select * from personal where rfc='$rfc'";
$datos=$db->Execute($busca_rfc);
$nombre_revisor2=$datos->fields['nombre_empleado']." ".$datos->fields['apellidos_empleado'];

$rfc=$registro->fields['revisor3'];
$busca_rfc="select * from personal where rfc='$rfc'";
$datos=$db->Execute($busca_rfc);
$nombre_revisor3=$datos->fields['nombre_empleado']." ".$datos->fields['apellidos_empleado'];


$busca_depto="select * from jefes where clave_area='$area_academica'";
$datos_depto=$db->Execute($busca_depto);


$pdf->Ln();
$pdf->SetFont('SoberanaSans-Black','','9');
$pdf->Cell($w, $h-1, utf8_decode("SUBDIRECCIÓN ACADEMICA"), 0, 1, 'C');
$pdf->Cell($w, $h-1, utf8_decode("División de Estudios Profesionales"), 0, 1, 'C');
$pdf->SetFont('SoberanaSans-Regular','','9');
$pdf->Ln(2);
$pdf->Cell($w, $h-1, utf8_decode("Procedimiento para Titulación"), 0, 1, 'C');
$pdf->Ln(2);
$pdf->SetFont('SoberanaSans-Black','','9');
$pdf->Cell($w, $h-1, utf8_decode("Liberación del Proyecto para la Titulación"), 0, 1, 'C');
$pdf->SetFont('SoberanaSans-Regular','','9');
$pdf->Cell($w, $h-1, "Referencia a la Norma ISO 9001:2008 7.5.1", 0, 1, 'C');
$pdf->Ln(5);

$pdf->Cell(125,$h-1,"",0,0);
$pdf->Cell(30, $h-1,"Tuxtepec, Oaxaca. ", 0, 0);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, $h-1,date("d")."/".nombre_mes(date("m"))."/".date("Y"), 0, 1,'C',TRUE);
$pdf->SetTextColor(0,0,0);

$pdf->Ln(4);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(20,$h,utf8_decode("M.E. JULIÁN KURI MAR"),0,1);
$pdf->Cell(20,$h,utf8_decode("JEFE DE LA DIVISIÓN DE ESTUDIOS PROFESIONALES"),0,1);
$pdf->Cell(20,$h,"P R E S E N T E",0,1);

$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(0,$h,utf8_decode("Por este medio le informo que ha sido liberado el siguiente proyecto para la Titulación:"),0,1);
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(50,$h+2,"a).- Nombre del Egresado:",0,0);
$pdf->Cell(0,$h+2,$registro->fields['nombre_egresado'],0,1);
$pdf->Cell(50,$h+2,"b).- Carrera:",0,0);
$pdf->Cell(0,$h+2,$nombre_carrera,0,1);
$pdf->Cell(50,$h+2,"c).- No. de Control:",0,0);
$pdf->Cell(0,$h+2,$nocontrol,0,1);
$pdf->Cell(50,$h+2,"d).- Nombre del Proyecto:",0,0);
$pdf->MultiCell(0,$h,'"'.utf8_decode($registro->fields('nombre_proyecto')).'"',0,'J');

$opcion=$registro->fields['opcion_titulacion'];
$ropc=$misql->Execute("select * from opciones_titulacion where opcion='$opcion'");
if($opcion=='T')
{
 $producto=$registro->fields['producto'];
 $rp=$misql->Execute("select * from producto where producto='$producto'");	
 $cad.=strtoupper($rp->fields['descripcion']);
 $cad.=strtoupper(" (".$ropc->fields['descripcion'].")");
}
else
 $cad.=strtoupper($ropc->fields['descripcion']);
$pdf->Cell(50,$h+2,"d).- Producto:",0,0);
$pdf->MultiCell(0,$h,$cad,0,'J');
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->MultiCell(0,$h,utf8_decode("Agradezco de antemano su valioso apoyo en esta importante actividad para la formación profesional de nuestros egresados"),0,'J');
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Ln(10);
$pdf->SetFont('SoberanaSans-Black','',10);
$pdf->Cell(0,$h-2,"A T E N T A M E N T E",0,1);
$pdf->SetFont('SoberanaSans-LightItalic','',8);
$pdf->Cell(0,$h-2,utf8_decode('"CIENCIA Y TÉCNICA PRESENTES AL FUTURO"'),0,1);
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Black','',10);
$pdf->Cell(0,$h-1,$datos_depto->fields['jefe_area'], 0, 1);
$pdf->Cell(0,$h-1,$datos_depto->fields['descripcion_area'], 0, 1);
$pdf->Ln(5);
$pdf->MultiCell(50,$h,$nombre_asesor,1,'C');
$pdf->SetXY(60,$pdf->GetY()-10);
$pdf->MultiCell(50,$h,$nombre_revisor1,1,'C');
$pdf->SetXY(110,$pdf->GetY()-10);
$pdf->MultiCell(50,$h,$nombre_revisor2,1,'C');
$pdf->SetXY(160,$pdf->GetY()-10);
$pdf->MultiCell(45,$h,$nombre_revisor3,1,'C');
$pdf->SetFont('SoberanaSans-Black','',8);
$pdf->Cell(50,$h,"Nombre y Firma del Asesor",1,0,'C');
$pdf->Cell(50,$h,"Nombre y Firma del Revisor",1,0,'C');
$pdf->Cell(50,$h,"Nombre y Firma del Revisor",1,0,'C');
$pdf->Cell(45,$h,"Nombre y Firma del Revisor",1,1,'C');
$pdf->SetFont('SoberanaSans-Regular','',6);
$pdf->Ln(5);
$pdf->Cell(45,$h,"C.c.p. Expediente",0,1);
$registro_sgc="REGISTRO SGC\nCódigo: ITTUX-AC-PO-008-08\nRevision: 1\nFecha Autorización: 19/Junio/2014";
$pdf->SetXY($x+150,252);
$pdf->MultiCell(160,$h-2,utf8_decode($registro_sgc),0,'J');

nvo_pie_oficial($pdf);
$pdf->Output();
?>
