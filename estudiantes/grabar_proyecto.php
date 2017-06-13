<?php
 session_start();
 if (!isset($_SESSION['nocontrol'])) {
	header('location: ../index.html');
}

 require('../../adodb/adodb.inc.php');
 require('../conexion.php');
 $db=conectar();
 $periodo_actual=$db->Execute('pac_periodo_actual');
 $periodo=$periodo_actual->fields['periodo'];
 $nocontrol=$_SESSION['nocontrol'];
 $nomegresado=$_SESSION['nom_alum'];
 $sexo=$_SESSION['sexo'];
 $nip=$_SESSION['nip'];
 $carrera=$_SESSION['carrera'];
 $reticula=$_SESSION['reticula'];
 $opcion_titulacion=$_POST['opcion'];
 $producto=$_POST['producto'];
 $nombre_proyecto=strtoupper($_POST['nom_proy']);
 $numero_egresados=$_POST['num_estudiantes'];
 $asesor_interno=$_POST['asesor_interno'];
 $depto_academico=$_POST['depto'];
 $direccion=strtoupper($_POST['direccion']);
 $telefono=$_POST['telefono'];
 $email=$_POST['email'];
 $revisor1=$_POST['revisor1'];
 $revisor2=$_POST['revisor2'];
 $revisor3=$_POST['revisor3'];
 
 /*echo $periodo;
 echo $nocontrol."<p>";
 echo $nomegresado."<p>";
 echo $sexo."<p>";
 echo $carrera."<p>";
 echo $reticula."<p>";
 echo $opcion_titulacion."<p>";
 echo $producto."<p>";
 echo $nombre_proyecto."<p>";
 echo $numero_egresados."<p>";
 echo $asesor_interno."<p>";
 echo $depto_academico."<p>";
 echo $direccion."<p>";
 echo $telefono."<p>";
 echo $email."<p>";*/
 $misql=conectar_mysql();
 $sql="insert into trabajo_titulacion";
 $sql.=" values ('$periodo','$nocontrol','$nip','$nomegresado','$sexo',";
 $sql.="'$carrera','$reticula','$opcion_titulacion','$producto','$nombre_proyecto',";
 $sql.="'$numero_egresados','$asesor_interno','$depto_academico','$direccion','$telefono','$email',";
 $sql.="'$revisor1','$revisor2','$revisor3','N','N','0000-00-00','00:00:00')";
 $r=$misql->Execute($sql);
 header('location:index.php');
?>
