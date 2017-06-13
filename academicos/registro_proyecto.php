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
<form action="datos_egresados.php" method="post">
No. Control:
<input type="text" name="nocontrol" size=15><p>
<p><hr><p>
<input type="submit" value="Buscar">
</form>
<a href="index.php">Regresar...</a>
</body>	
</html>

