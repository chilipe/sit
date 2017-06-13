<?php
 session_start();
 if (!isset($_SESSION['nocontrol'])) {
	header('location: ../index.html');
}

 require('../../adodb/adodb.inc.php');
 require('../conexion.php');

 $nocontrol=$_SESSION['nocontrol'];
 $opcion_titulacion=$_POST['opcion'];
 $producto=$_POST['producto'];
 $nombre_proyecto=strtoupper($_POST['nom_proy']);
 $asesor_interno=$_POST['asesor_interno'];
 $direccion=strtoupper($_POST['direccion']);
 $telefono=$_POST['telefono'];
 $email=$_POST['email'];

 $misql=conectar_mysql();
 $sql="update trabajo_titulacion set";
 $sql.=" opcion_titulacion='$opcion_titulacion',producto='$producto',nombre_proyecto='$nombre_proyecto',";
 $sql.="asesor_interno='$asesor_interno',domicilio='$direccion',telefono='$telefono',email='$email'";
 $sql.=" where no_de_control='$nocontrol'";
 $r=$misql->Execute($sql);
 header('location:index.php');
?>
