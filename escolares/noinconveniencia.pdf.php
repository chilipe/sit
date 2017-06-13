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
$h = 7;

$carrera=$registro->fields['carrera'];
$reticula=$registro->fields['reticula'];
$nom_egre=$registro->fields['nombre_egresado'];

$busca_carrera="select * from carreras where carrera='$carrera'";
$carrera=$db->Execute($busca_carrera);
$nombre_carrera=$carrera->fields['nombre_carrera'];

$pdf->Ln();
$pdf->SetFont('SoberanaSans-Black','','9');
$pdf->Cell($w, $h-3, utf8_decode("SUBDIRECCIÓN ACADEMICA"), 0, 1, 'C');
$pdf->Cell($w, $h-3, utf8_decode("División de Estudios Profesionales"), 0, 1, 'C');
$pdf->SetFont('SoberanaSans-Regular','','9');
$pdf->Ln(2);
$pdf->Cell($w, $h-3, utf8_decode("Procedimiento para Titulación"), 0, 1, 'C');
$pdf->Ln(2);
$pdf->SetFont('SoberanaSans-Black','','9');
$pdf->Cell($w, $h-3, utf8_decode("Carta de No Inconveniencia para la Titulación"), 0, 1, 'C');
$pdf->SetFont('SoberanaSans-Regular','','9');
$pdf->Cell($w, $h-3, "Referencia a la Norma ISO 9001:2008 7.5.1", 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('SoberanaSans-Regular','','10');
$pdf->Cell(0,$h-2,utf8_decode("SUBDIRECIÓN DE PLANEACIÓN Y VINULACIÓN"),0,1,'R');
$pdf->Cell(0,$h-2,utf8_decode("DEPARTAMENTO DE SERVICIOS ESCOLARES"),0,1,'R');
$pdf->Cell(0,$h-2,utf8_decode("EXPEDIENTE: DSE-h/").substr(date("Y"),2,2),0,1,'R');
$pdf->Ln(2);
$pdf->Cell(120,$h-2,"",0,0);
$pdf->Cell(33, $h-2,"Tuxtepec, Oaxaca. ", 0, 0);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, $h-2,date("d")."/".nombre_mes(date("m"))."/".date("Y"), 0, 1,'C',TRUE);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,$h-2,"OFICIO OSE-".$no_oficio,0,1,'R');

$pdf->Ln(8);
$pdf->SetFont('SoberanaSans-Black','','10');
$pdf->Cell($w,$h-2,"M.E. JULIAN KURI MAR",0,1);
$pdf->Cell($w,$h-2,utf8_decode("JEFA DE LA DIVISIÓN DE ESTUDIOS PROFESIONALES"),0,1);
$pdf->Cell($w,$h-2,"P R E S E N T E",0,1);
$pdf->Ln(5);
$pdf->SetFont('SoberanaSans-Regular','','10');
$cad="Me permito informarle que NO EXISTE INCONVENIENTE para que el C. ".$nom_egre;
$cad.=" ".utf8_decode(" con número de control ").$nocontrol." egresado(a)  de la carrera";
$cad.=" ".$nombre_carrera.utf8_decode(" del INSTITUTO TECNOLÓGICO DE TUXTEPEC, pueda presentar su ACTO DE RECEPCIÓN PROFESIONAL al haber cumplido los requisitos reglamentarios de ");
//$cad.=' "'.utf8_decode($registro->fields('nombre_proyecto')).'" producto de ';
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
 $cad.=$ropc->fields['descripcion'];
$cad.=utf8_decode(" de acuerdo al Lineamiento para la Titulación correspondiente y a que su expediente");
$cad.=utf8_decode(" quedó integrado para tal efecto");
$pdf->MultiCell(0,$h+1,$cad,0,'J');
$pdf->Ln(2);
$pdf->Cell(0,$h,"Sin otro particular quedo de Usted",0,1);

$pdf->Ln(15);
$pdf->SetFont('SoberanaSans-Black','',10);
$pdf->Cell(0,$h-3,"A T E N T A M E N T E",0,1);
$pdf->SetFont('SoberanaSans-LightItalic','',10);
$pdf->Cell(0,$h-3,utf8_decode('"CIENCIA Y TÉCNICA PRESENTES AL FUTURO"'),0,1);
$pdf->Ln(15);
$pdf->SetFont('SoberanaSans-Black','',10);
$pdf->Cell(0,$h,utf8_decode("LIC. ANA MARIA LUNA VARGAS"), 0, 1);
$pdf->Cell(0,$h,utf8_decode("JEFA DEL DEPTO. DE SERVICIOS ESCOLARES"), 0, 1);

$pdf->SetFont('SoberanaSans-Regular','',6);
$pdf->Ln(5);
$pdf->Cell(45,$h-3,utf8_decode("C.c.p. Archivo"),0,1);
$pdf->Cell(45,$h-3,"AMLV/ehm*",0,1);
$registro_sgc="REGISTRO SGC\nCódigo: ITTUX-AC-PO-008-02\nRevision: 1\nFecha Autorización: 19/Junio/2014";
$pdf->SetXY($x+150,252);
$pdf->MultiCell(160,$h-4,utf8_decode($registro_sgc),0,'J');
nvo_pie_oficial($pdf);

$pdf->Output();
?>
