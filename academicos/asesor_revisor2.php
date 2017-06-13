<?php
 session_start();
 if (!isset($_SESSION['nomusua'])) {
	header('location: ../index.html');
 }
 
require('../../adodb/adodb.inc.php');
require('../conexion.php');

$nocontrol=$_POST['nocontrol'];

$db=conectar();
$misql=conectar_mysql();

$rt=$misql->Execute("select * from trabajo_titulacion where no_de_control='$nocontrol'");

$nombre_egresado=$rt->fields['nombre_egresado'];
$asesor=$rt->fields['asesor_interno'];
$revisor1=$rt->fields['revisor1'];
$revisor2=$rt->fields['revisor2'];
$revisor3=$rt->fields['revisor3'];
$area_academica=$rt->fields['depto_academico'];

$rp=$db->Execute("select * from personal where area_academica='$area_academica' and status_empleado='02'");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
    <link rel="stylesheet" href="../css/main2.css">
    <title>SIT...</title>
</head>
<body>
	<div class="login__container">
	 <div class="login__top">
          <img  class="login__img" src="../img/ittux.jpg" alt="">
          <h2 class="login__title"><span>Sistema Integral deTitulación</span></h2>
       </div><center>
		<h3>Impresión de Asesor-Revisores de Titulación</h3>
	
<p><hr><p>
		<form action="asesor_revisor.pdf.php" method="post" class="login__form" target="_blank">
		<b>No. Control</b>
		<input type="text" name="nocontrol" readonly value=<?php echo $nocontrol;?>>
		<b>Nombre del Estudiante</b>
		<input type="text" name="nomegresado" readonly value=<?php echo "'$nombre_egresado'";?>>
		<b>Nombre del Asesor</b>
		<select name="asesor_interno">
			<option selected>Sin Asesor Asignado</option>
		<?php
		 while(!$rp->EOF)
		 {
		  $nombrep=utf8_encode($rp->fields['apellidos_empleado']." ".$rp->fields['nombre_empleado']);
		  if($rp->fields['rfc']==$asesor)
		   echo "<option value=".$rp->fields['rfc']." selected>".$nombrep."</option>";
		  else
		   echo "<option value=".$rp->fields['rfc']." >".$nombrep."</option>";
		  $rp->MoveNext(); 
		 } 
		?>
		</select>
		<b>Nombre del 1er. Revisor</b>
		<select name="revisor1">
			<option selected>Sin Revisor Asignado</option>
		<?php
		 $rp->MoveFirst();
		 while(!$rp->EOF)
		 {
		  $nombrep=utf8_encode($rp->fields['apellidos_empleado']." ".$rp->fields['nombre_empleado']);
		  if($rp->fields['rfc']==$revisor1)
		   echo "<option value=".$rp->fields['rfc']." selected>".$nombrep."</option>";
		  else
		   echo "<option value=".$rp->fields['rfc'].">".$nombrep."</option>";
		  $rp->MoveNext(); 
		 } 
		?>
		</select>
		<b>Nombre del 2do. Revisor</b>
		<select name="revisor2">
			<option selected>Sin Revisor Asignado</option>
		<?php
		 $rp->MoveFirst();
		 while(!$rp->EOF)
		 {
		  $nombrep=utf8_encode($rp->fields['apellidos_empleado']." ".$rp->fields['nombre_empleado']);
		  if($rp->fields['rfc']==$revisor2)
		   echo "<option value=".$rp->fields['rfc']." selected>".$nombrep."</option>";
		  else
		   echo "<option value=".$rp->fields['rfc'].">".$nombrep."</option>";
		  $rp->MoveNext(); 
		 } 
		?>
		</select>
		<b>Nombre del 3er. Revisor</b><p>
			<select name="revisor3">
				<option selected>Sin Revisor Asignado</option>
		<?php
		 $rp->MoveFirst();
		 while(!$rp->EOF)
		 {
		  $nombrep=utf8_encode($rp->fields['apellidos_empleado']." ".$rp->fields['nombre_empleado']);
		  if($rp->fields['rfc']==$revisor3)
		   echo "<option value=".$rp->fields['rfc']." selected>".$nombrep."</option>";
		  else
		   echo "<option value=".$rp->fields['rfc'].">".$nombrep."</option>";
		  $rp->MoveNext(); 
		 } 
		?>
		</select><p>
	    <b>No. de Oficio</b><p>
		<input type="text" name="no_oficio" size=5 required><p>
		<input class="btn__submit" type="submit" value="IMPRIMIR OFICIO DE ASESOR-REVISORES"></form>
		<p><hr><p>
			<a href="index.php"><img src="../img/regresar.png" width=50 height=50 alt="Regresar"></a>

	</div>
</body>	
</html>
