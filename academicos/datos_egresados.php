<?php
 session_start();
 if (!isset($_SESSION['nomusua'])) {
	header('location: ../index.html');
}
?>
<html>
	<head>
		<title>Bienvenidos al STI...</title>
	</head>
<body>
<center>
<h2>Sistema de Titulacion Integral</h2>
	<h3>Departamentos Academicos</h3>
	<h3>Usuario: <?php echo $_SESSION['nomusua'];?></h3>
<p><hr><p>
<?php
 require('../../adodb/adodb.inc.php');
 require('../conexion.php');
 $nocontrol=$_POST['nocontrol'];
 $db=conectar();
 $ra=$db->Execute("SELECT * FROM alumnos where no_de_control='$nocontrol'");
 $nomegresado=$ra->fields['nombre_alumno']." ".$ra->fields['apellido_paterno']." ".$ra->fields['apellido_materno'];
 $carrera=$ra->fields['carrera'];
 $reticula=$ra->fields['reticula'];
 $rc=$db->Execute("SELECT * FROM carreras where carrera='$carrera' and reticula=$reticula");
 $nom_carrera=$rc->fields['nombre_carrera'];
 echo "No.Control:<input type=text name=nocontrol value='$nocontrol' size=12><p>";
 echo "Nombre del Estudiante:<input type=text name=nomegresado value='$nomegresado' size=45><p>";
 echo "Carrera: <input type=text name=nom_carrera value='$nom_carrera' size=35><p>";
 $rr=$db->Execute("SELECT * FROM gtv_residencias where no_de_control='$nocontrol'");
 if($rr->RecordCount()>0)
 {
	 $nom_proy=$rr->fields['proyecto'];
	 echo "Nombre del Proyecto:<p><textarea name=nom_proy cols=80 rows=10>".utf8_encode($nom_proy)."</textarea><p>";
	 echo "Opcion de Titulacion: <input type=text name=opcion_titula value='TITULACION INTEGRAL'><p>";
	 echo "Producto: <input type=text name=producto_titula value='INFORME TECNICO RESIDENCIA PROFESIONAL' size=45><p>";
 }
?>
<p><hr><p>
	<a href="registro_proyecto.php">Regresar...</a>
</form>
</body>	
</html
