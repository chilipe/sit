<?php
 session_start();
 if (!isset($_SESSION['nocontrol'])) {
	header('location: ../index.html');
}
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
          <h2 class="login__title"><span>Registro del Proyecto de Titulación</span></h2>
       </div>
	<form action="grabar_proyecto.php" method="post" class="login__form">
	<table>
<?php
 require('../../adodb/adodb.inc.php');
 require('../conexion.php');
 $db=conectar();
 $nocontrol=$_SESSION['nocontrol'];
 $nomegresado=$_SESSION['nom_alum'];
 $sexo=$_SESSION['sexo'];
 $carrera=$_SESSION['carrera'];
 $reticula=$_SESSION['reticula'];
 $nip=$_SESSION['nip'];
 //echo $reticula;
 $rc=$db->Execute("SELECT * FROM carreras where carrera='$carrera' and reticula=$reticula");
 $nom_carrera=$rc->fields['nombre_carrera'];
 echo $nip;
 echo "<b>No.Control</b><input type=text name=nocontrol value='$nocontrol' size=12 readonly>";
 echo "<b>Nombre del Estudiante</b><input type=text name=nomegresado value='$nomegresado' size=45 readonly>";
 echo "<b>Carrera</b><input type=text name=nom_carrera value='$nom_carrera' size=35 readonly>";
 $rr=$db->Execute("SELECT * FROM gtv_residencias where no_de_control='$nocontrol'");
 if($rr->RecordCount()>0)
 {
	 $nom_proy=$rr->fields['proyecto'];
	 $opcion='T';
	 $proyecto='ITRP'; 
	 $asesor=trim($rr->fields['asesor_interno']);
	 $num_estudiantes=$rr->fields['num_residentes'];
	 $revisor1=$rr->fields['revisor_1'];
	 $revisor2=$rr->fields['revisor_2'];
	 $revisor3=$rr->fields['revisor_3'];
  }
?>
<b>Opcion de Titulacion</b>
<select name='opcion'>
	<?php
		if($reticula==2010 || ($carrera=='12' || $carrera=='11' || $carrera=='13'))
			echo  "<option value='T' selected>Titulacion Integral</option>";
		else
		 if(chop($reticula)=='26' || chop($reticula)=='53' || chop($reticula)=='25' || chop($reticula)=='19' || chop($reticula)=='20' || chop($reticula)=='22' || chop($reticula)=='23' || chop($reticula)=='24')
		 {
		  echo "<option value='I'>I.- Tesis Profesional</option>";
		  echo "<option value='III'>III.- Proyecto de investigación</option>";
		  echo "<option value='X'>X.- Memoria de Residencia Profesional</option>";
		 }
		 else
		 {
		  echo "<option value='I'>I.- Tesis Profesional</option>";
		  echo "<option value='II'>II.-  Libro de Texto o Prototipos Didácticos</option>";
		  echo "<option value='III'>III.- Proyecto de investigación</option>";
		  echo "<option value='IV'>IV.-Diseño o rediseño de equipo aparato o maquinaria.</option>";
		  echo "<option value='V'>V.- Cursos Especiales de Titulación</option>";
		  echo "<option value='VII'>VII.- Memoria de Experiencia Profesional.</option>";
		  echo "<option value='X'>X.- Memoria de Residencia Profesional</option>";
		 }
	?>
</select>
<?php if(chop($reticula)=='2010' || $carrera==11 || $carrera==12 || $carrera==13){ 
echo "<b>Producto</b>";
echo "<select name='producto'>";
	echo "<option value='N' selected>Ninguno</option>";
	if($proyecto=='ITRP')
	echo "<option value='ITRP' selected>Informe Tecnico de Residencias Profesionales</option>";
	else
	echo "<option value='ITRP'>Informe Tecnico de Residencias Profesionales</option>";
	echo "<option value='PI'>Proyecto de Investigacion</option>";
	echo "<option value='PD'>Desarrollo Tecnologico</option>";
	echo "<option value='PIN'>Proyecto Integrador</option>";
	echo "<option value='PP'>Proyecto Productivo</option>";
	echo "<option value='PIT'>Proyecto de Innovacion Tecnologica</option>";
	echo "<option value='PE'>Proyecto de Empredurismo</option>";
	echo "<option value='PIED'>Proyecto Integral de Educación Dual</option>";
	echo "<option value='E'>Estancia</option>";
	echo "<option value='TT'>Tesis o Tesina</option>";
echo "</select>";
} ?>
<?php
 echo "<b>Nombre del Proyecto</b><textarea name=nom_proy required cols=80 rows=5>".utf8_encode($nom_proy)."</textarea>";
 $rag=$db->Execute("select * from alumnos_generales where no_de_control='nocontrol'");
 $domicilio=$rag->fields['domicilio_calle'].", ".$rag->fields['domicilio_colonia'].", ".$rag->fields['ciudad'];
 $telefono=$rag->fields['telefono'];
 $email=$_SESSION['email'];
 echo "<b>No. de Estudiantes</b>";
 echo "<select name=num_estudiantes>";
 for($i=1;$i<=5;$i++)
  if($i==$num_estudiantes)
   echo "<option value=".$i." selected>$i</option>";
  else 
   echo "<option value=".$i.">$i</option>";
 echo "</select>";
 $rase=$db->Execute("select * from personal where status_empleado='02' order by apellidos_empleado");
 echo "<b>Asesor Interno</b><select name=asesor_interno>";
 echo "<option selected>Sin Asesor Asignado...</option>";
 while(!$rase->EOF)
 {
	$apellido=utf8_encode($rase->fields['apellidos_empleado']);
  if($rase->fields['rfc']==$asesor)
  {
   $area_academica=$rase->fields['area_academica'];
   echo "<option value=".$rase->fields['rfc']." selected>".$apellido." ".$rase->fields['nombre_empleado']."</option>";
  }
  else
   echo "<option value=".$rase->fields['rfc'].">".$apellido." ".$rase->fields['nombre_empleado']."</option>";
  $rase->MoveNext();
 }
 echo "</select>";
 $racad=$db->Execute("select * from jefes where clave_area in ('110200','110400','110500','110600','110700','111100') order by descripcion_area");
 echo "<b>Departamento Academico:</b><select name=depto>";
 while(!$racad->EOF)
 {
	 if($racad->fields['clave_area']==$area_academica)
	  echo "<option value=".$racad->fields['clave_area']." selected>".$racad->fields['descripcion_area'].".- ".$racad->fields['jefe_area']."</option>";
	 else
	  echo "<option value=".$racad->fields['clave_area'].">".$racad->fields['descripcion_area'].".- ".$racad->fields['jefe_area']."</option>";
	 $racad->MoveNext();
 }
 echo "</select>";
?>
<b>Dirección</b>
<input type="text" name="direccion" required value=<?php echo $domicilio;?> size=65>
<b>Telefono:</b>
<input type="tel" name="telefono" required placeholder="(Lada) Número" value=<?php echo $telefono;?>>
<b>Correo Electronico:</b>
<input type="email" name="email" required value=<?php echo $email;?>>
<input class="btn__submit" type="submit" value=" GRABAR PROYECTO ">
<input type="hidden" name="sexo" value=<?php echo $sexo;?>>
<input type="hidden" name="revisor1" value=<?php echo $revisor1;?>>
<input type="hidden" name="revisor2" value=<?php echo $revisor2;?>>
<input type="hidden" name="revisor3" value=<?php echo $revisor3;?>>
<p><hr><p>
</form>
</body>	
</html
