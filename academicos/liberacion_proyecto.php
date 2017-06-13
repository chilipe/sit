<?php
 session_start();
 if (!isset($_SESSION['nomusua'])) {
	header('location: ../index.html');
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
		<h3>Impresión de la Liberación del Proyecto de Titulación</h3>
	
<p><hr><p>
	<table border=1 cellspacing=0 cellpadding=0>
		<tr><th>No. Control</th>
		<tr><td><form action="liberacion_proyecto.pdf.php" method="post" class="login__form" target="_blank"><input type="text" name="nocontrol" size=15 required></td>
		</tr></table>
		<input class="btn__submit" type="submit" value=" IMPRIMIR OFICIO DE LIBERACIÓN "></form>
	
<p><hr><p>
	<a href="index.php"><img src="../img/regresar.png" width=50 height=50 alt="Regresar"></a>
	</div>
</body>	
</html>
