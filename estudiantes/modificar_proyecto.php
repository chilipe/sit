<?php
 session_start();
 if (!isset($_SESSION['nocontrol'])) {
	header('location: ../index.html');
}

 require('../../adodb/adodb.inc.php');
 require('../conexion.php');
 $db=conectar();
 $nocontrol=$_SESSION['nocontrol'];
 $misql=conectar_mysql();
 $rt=$misql->Execute("select * from trabajo_titulacion where no_de_control='$nocontrol'");
 $periodo=$rt->fields['periodo'];
 $nomegresado=$rt->fields['nombre_egresado'];
 $carrera=$_SESSION['carrera'];
 $reticula=$_SESSION['reticula'];
 $opcion_titulacion=$rt->fields['opcion_titulacion'];
 $producto=$rt->fields['producto'];
 $nombre_proyecto=$rt->fields['nombre_proyecto'];
 $numero_egresados=$rt->fields['numero_egresados'];
 $asesor_interno=$rt->fields['asesor_interno'];
 $depto_academico=$rt->fields['depto_academico'];
 $direccion=$rt->fields['domicilio'];
 $telefono=$rt->fields['telefono'];
 $email=$rt->fields['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
    <link rel="stylesheet" href="../css/main2.css">
    <title>SIT...</title>
</head
<body>
<center>
<p><hr><p>
	<div class="login__top">
          <img  class="login__img" src="../img/ittux.jpg" alt="">
          <h2 class="login__title"><span>Modificación del Proyecto de Titulación</span></h2>
       </div>
	<form action="modificar_proyecto2.php" method="post" class="login__form">
<b>No. de Control</b>
<input type="text" name="nocontrol" required value=<?php echo $nocontrol;?> size=12>
<b>Nombre del Egresado</b>
<input type="text" name="nomegresado" required value=<?php echo "'$nomegresado'";?> size=45>
<b>Carrera</b>
<?php
 $rc=$db->Execute("select * from carreras where carrera='$carrera' and reticula=$reticula");
 $nombre_carrera=$rc->fields['nombre_carrera'];
?>
<input type="text" name="carrera" required value=<?php echo "'$nombre_carrera'";?> size=35>
<b>Opción de Titulación</b>
<select name='opcion'>
<?php
		if($reticula==2010 || ($carrera=='12' || $carrera=='11' || $carrera=='13'))
			echo  "<option value='T' selected>Titulacion Integral</option>";
		else
		 if(chop($reticula)=='26' || chop($reticula)=='53' || chop($reticula)=='25' || chop($reticula)=='19' || chop($reticula)=='20' || chop($reticula)=='22' || chop($reticula)=='23' || chop($reticula)=='24')
		 {
		  $opc['I']="I.- Tesis Profesional";
		  $opc['III']="III.- Proyecto de investigación";
		  $opc['X']="X.- Memoria de Residencia Profesional";
		  foreach($opc as $clave=>$valor)
			echo "<option value='$clave'>$valor</option>";
		 }
		 else
		 {
		  $opc['I']="I.- Tesis Profesional";
		  $opc['II']="II.-  Libro de Texto o Prototipos Didácticos";
		  $opc['III']="III.- Proyecto de investigación";
		  $opc['IV']="IV.- Diseño o rediseño de equipo aparato o maquinaria";
		  $opc['V']="V.- Cursos Especiales de Titulación";
		  $opc['VII']="VII.- Memoria de Experiencia Profesional";
		  $opc['X']="X.- Memoria de Residencia Profesional";
		  foreach($opc as $clave=>$valor)
		   if($clave==$opcion_titulacion)
			echo "<option value='$clave' selected>$valor</option>";
		   else
		    echo "<option value='$clave'>$valor</option>";
		 }
	?>
	</select>
<?php if(chop($reticula)=='2010' || $carrera==11 || $carrera==12 || $carrera==13){ 
echo "<b>Producto</b>";
echo "<select name='producto'>";
	$prod['ITRP']="Informe Tecnico de Residencias Profesionales";
	$prod['PI']="Proyecto de Investigación";
	$prod['PD']="Desarrollo Tecnologico";
	$prod['PD']="Desarrollo Tecnologico";
    $prod['PIN']="Proyecto Integrador";
	$prod['PP']="Proyecto Productivo";
	$prod['PIT']="Proyecto de Innovacion Tecnologica";
	$prod['PE']="Proyecto de Empredurismo";
	$prod['PIED']="Proyecto Integral de Educación Dual";
	$prod['E']="Estancia";
	$prod['TT']="Tesis o Tesina";
	foreach($prod as $clave=>$valor)
		   if($clave==$producto)
			echo "<option value='$clave' selected>$valor</option>";
		   else
		    echo "<option value='$clave'>$valor</option>";
echo "</select>";
} ?>
<b>Nombre del Proyecto</b><textarea name="nom_proy" required cols=80 rows=5><?php echo $nombre_proyecto;?></textarea>
<b>No. de Estudiantes</b>
<input type="text" name="num_estudiantes" required readonly value=<?php echo $numero_egresados;?> size=2>
<?php
 $rase=$db->Execute("select * from personal where status_empleado='02' and area_academica='$depto_academico' order by apellidos_empleado");
 echo "<b>Asesor Interno</b><select name=asesor_interno>";
 while(!$rase->EOF)
 {
  $apellido=utf8_encode($rase->fields['apellidos_empleado']);
  if($rase->fields['rfc']==$asesor_interno)
  {
    echo "<option value=".$rase->fields['rfc']." selected>".$apellido." ".$rase->fields['nombre_empleado']."</option>";
  }
  else
   echo "<option value=".$rase->fields['rfc'].">".$apellido." ".$rase->fields['nombre_empleado']."</option>";
  $rase->MoveNext();
 }
 echo "</select>";
 ?>
 <b>Area Academica</b>
 <?php
  $racad=$db->Execute("select * from jefes where clave_area='$depto_academico'");
  $depto=$racad->fields['descripcion_area'].".- ".$racad->fields['jefe_area'];
 ?>
<input type="text" name="depto" required readonly value=<?php echo "'$depto'";?> size=65>
<b>Dirección</b>
<input type="text" name="direccion" required value=<?php echo "'$direccion'";?> size=65>
<b>Telefono</b>
<input type="tel" name="telefono" required placeholder="(Lada) Número" value=<?php echo "'$telefono'";?>>
<b>Correo Electronico:</b>
<input type="email" name="email" required value=<?php echo $email;?>>
<input class="btn__submit" type="submit" value=" ACTUALIZAR PROYECTO ">
<p><hr><p>
</form>
</body>	
</html
