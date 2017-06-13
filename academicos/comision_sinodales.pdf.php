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
$h = 6;

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

$datos_titulacion=explode("-",$registro->fields['fecha_titulacion']);
$hora_titulacion=$registro->fields['hora_titulacion'];

$area_academica=$registro->fields['depto_academico'];

$datosd=explode("%",siglas_depto($area_academica));

$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Black','','9');
$pdf->Cell($w, $h-2, utf8_decode("SUBDIRECCIÓN ACADEMICA"), 0, 1, 'C');
$pdf->Cell($w, $h-2, utf8_decode("División de Estudios Profesionales"), 0, 1, 'C');
$pdf->SetFont('SoberanaSans-Regular','','9');
$pdf->Ln(2);
$pdf->Cell($w, $h-2, utf8_decode("Procedimiento para Titulación"), 0, 1, 'C');
$pdf->Ln(2);
$pdf->SetFont('SoberanaSans-Black','','9');
$pdf->Cell($w, $h-2, utf8_decode("Comisión para Sinodales"), 0, 1, 'C');
$pdf->SetFont('SoberanaSans-Regular','','9');
$pdf->Cell($w, $h-2, "Referencia a la Norma ISO 9001:2008 7.5.1", 0, 1, 'C');
$pdf->Ln(5);

$pdf->Cell(0,$h-2,utf8_decode("SUBDIRECCIÓN ACADÉMICA"),0,1,'R');
$pdf->Cell(0,$h-2,$datos_depto->fields['descripcion_area'],0,1,'R');
$pdf->Cell(0,$h-2,"EXPEDIENTE: ".$datosd[0]."/".substr(date("Y"),2,2),0,1,'R');
$pdf->Ln(2);
$pdf->Cell(125,$h-2,"",0,0);
$pdf->Cell(30, $h-2,"Tuxtepec, Oaxaca. ", 0, 0);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, $h-2,date("d")."/".nombre_mes(date("m"))."/".date("Y"), 0, 1,'C',TRUE);
$pdf->SetTextColor(0,0,0);
$pdf->Ln(2);
$pdf->Cell(0,$h-2,"OFICIO No.SA-".$no_oficio,0,1,'R');

$pdf->Ln(4);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell(35,$h-2,"PRESIDENTE:",0,0);
$pdf->Cell($w,$h-2,$nombre_asesor,0,1);
$pdf->Cell(35,$h-2,"SECRETARIO:",0,0);
$pdf->Cell($w,$h-2,$nombre_revisor1,0,1);
$pdf->Cell(35,$h-2,"VOCAL:",0,0);
$pdf->Cell($w,$h-2,$nombre_revisor2,0,1);
$pdf->Cell(35,$h-2,"VOCAL SUPLENTE:",0,0);
$pdf->Cell($w,$h-2,$nombre_revisor3,0,1);


$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$cad=utf8_decode("Con un cordial saludo por este medio me permito comunicar a Ustedes que han sido designados SINODALES para validar mediante el ACTO DE RECEPCION PROFESIONAL el día ");
$cad.=$datos_titulacion[2]." de ".nombre_mes($datos_titulacion[1])." de ".$datos_titulacion[0]." a las ".substr($hora_titulacion,0,5).utf8_decode(" en la Sala Magna de Titulación de este instituto ");
$cad.=utf8_decode(" la formación académica en la Carrera de ").$nombre_carrera.", el(la) C. ".$registro->fields['nombre_egresado'].utf8_decode(" con número de control ").$nocontrol." del";
$cad.=" ".utf8_decode(" del INSTITUTO TECNOLÓGICO DE TUXTEPEC, al haber cumplido los requisitos de ");
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
$cad.=utf8_decode(' con el Trabajo Profesional "'.$registro->fields('nombre_proyecto').'"');
$cad.=utf8_decode(" de acuerdo al Lineamiento de Titulación correspondiente.");
$pdf->MultiCell(0,$h,$cad,0,'J');

$pdf->Ln(8);
$pdf->Cell(0,$h,utf8_decode("Esperando cumplan la presente comisión con la responsabilidad que les caracteriza, quedo de ustedes"),0,1);
$pdf->Ln(8);
$pdf->SetFont('SoberanaSans-Black','',10);
$pdf->Cell(0,$h-2,"A T E N T A M E N T E",0,1);
$pdf->SetFont('SoberanaSans-LightItalic','',8);
$pdf->Cell(0,$h-2,utf8_decode('"CIENCIA Y TÉCNICA PRESENTES AL FUTURO"'),0,1);
$pdf->Ln(10);
$pdf->SetFont('SoberanaSans-Black','',10);
$pdf->Cell(0,$h-1,$datos_depto->fields['jefe_area'], 0, 1);
$pdf->Cell(0,$h-1,$datos_depto->fields['descripcion_area'], 0, 1);

$pdf->SetFont('SoberanaSans-Regular','',6);
$pdf->Ln(8);
$cad=utf8_decode("c.c.p. Depto. de Servicios Escolares\nDivisión de Estudios Profesionales\nArchivo\n".$datosd[1]);
$pdf->MultiCell(0,$h-3,$cad,0,'J');
$registro_sgc="REGISTRO SGC\nCódigo: ITTUX-AC-PO-008-11\nRevision: 1\nFecha Autorización: 19/Junio/2014";
$pdf->SetXY($x+150,252);
$pdf->MultiCell(160,$h-3,utf8_decode($registro_sgc),0,'J');

nvo_pie_oficial($pdf);
$pdf->Output();
?>
