<?php
 session_start();
 if (!isset($_SESSION['nomusua'])) {
	header('location: ../index.html');
 }

$nombre_usuario=$_SESSION['nomusua'];
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
		<h3><?php echo $nombre_usuario;?></h3>
	
<p><hr><p>
	<table border=1 cellspacing=0 cellpadding=0>
		<tr><th colspan=2>Función</th></tr>
		<tr><td><form action="noinconveniencia.php" method="post" class="login__form"><b>Carta de No Inconveniencia para la Titulación</b></td><td><input type="submit" class="btn__submit" value=" Imprimir "></form></td></tr>
	</table>
<p><hr><p>
	<a href="../logout.php"><img src="../img/cerrar_sesion.png" width="50%"></a>
	</div>
</body>	
</html>
