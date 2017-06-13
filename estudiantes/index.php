<?php
 session_start();
 if (!isset($_SESSION['nocontrol'])) {
	header('location: ../index.html');
 }
 require('../../adodb/adodb.inc.php');
 require('../conexion.php');
 $misql=conectar_mysql();
 $nocontrol=$_SESSION['nocontrol'];
 $trabajo=$misql->Execute("select * from trabajo_titulacion where no_de_control='$nocontrol'");		   
 if($trabajo->RecordCount()>0)
 {
	 $script="modificar_proyecto.php";
	 $valor="Modificar el Proyecto de Titulación";
	 $boton="Modificar";
 }
 else
 {
	$script="datos_egresados.php";
	$valor="Registro del Proyecto de Titulación"; 
	$boton="Registrar";
 } 
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
		<h3>No.Control: <?php echo $nocontrol;?><p> Nombre: <?php echo $_SESSION['nom_alum'];?></h3>
	
<p><hr><p>
	<table border=1 cellspacing=0 cellpadding=0>
		<tr><th colspan=2>Función</th></tr>
		<tr><td><form action=<?php echo $script;?> method="post" class="login__form"><?php echo "<b>".$valor."</b>";?></td><td><input type="submit"  class="btn__submit" value=<?php echo $boton;?>></form></td></tr>
		<tr><td><form action="registro.pdf.php" method="post" class="login__form" target="_blank"><b>Impresión de Registro del Proyecto</b></td><td><input type="submit"  class="btn__submit" value=" Imprimir "></form></td></tr>
		<tr><td><form action="solicitud.pdf.php" method="post" class="login__form" target="_blank"><b>Impresión de la Solicitud</b></td><td><input type="submit"  class="btn__submit" value=" Imprimir "></form></td></tr>
	</table>
<p><hr><p>
	<a href="../logout.php"><img src="../img/cerrar_sesion.png" width="50%"></a>
	</div>
</body>	
</html>
