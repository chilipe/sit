<?php
 require('../adodb/adodb.inc.php');
 require('conexion.php');
 
 session_start();
 
 $usuario=$_POST['usuario'];
 $contrasena=MD5($_POST['contrasena']);
 $db=conectar();
 $result=$db->Execute("SELECT * FROM  acceso where usuario='$usuario' and contrasena='$contrasena'");
 if($result  ===  false)
	die("failed");
 echo $result->RecordCount();
 if($result->RecordCount()>0)
 {
  if($result->fields['tipo_usuario']=='DAC')
  {
   $_SESSION['nomusua']=$result->fields['nombre_usuario'];
   header('location:academicos/index.php');
  }
  else
    if($result->fields['tipo_usuario']=='DIR' || $result->fields['tipo_usuario']=='DEP')
    {
	 $_SESSION['nomusua']=$result->fields['nombre_usuario'];
     header('location:division/index.php');
    }
    else
     if($result->fields['tipo_usuario']=='ESC')
     {
	  $_SESSION['nomusua']=$result->fields['nombre_usuario'];
      header('location:escolares/index.php');
     }
     else
      header('location:index.html'); 
 }
 else
 {
	 echo "Por aca pase";
	 $contrasena=$_POST['contrasena'];
	 $misql=conectar_mysql();
	 $rt=$misql->Execute("SELECT * FROM  trabajo_titulacion where no_de_control='$usuario' and nip='$contrasena'");
	 if($rt->RecordCount()>0)
	 {
		 $_SESSION['nocontrol']=$rt->fields['no_de_control'];
		 $_SESSION['nom_alum']=$rt->fields['nombre_egresado'];
		 $_SESSION['carrera']=$rt->fields['carrera'];
		 $_SESSION['reticula']=$rt->fields['reticula'];
		 $_SESSION['email']=$rt->fields['email'];
		 $_SESSION['sexo']=$rt->fields['sexo'];
		 $_SESSION['nip']=$rt->fields['nip'];
		 header('location:estudiantes/index.php');
	 }
	 else
	 { 
	  $contrasena=$_POST['contrasena'];	  
	  $ra=$db->Execute("SELECT * FROM alumnos where no_de_control='$usuario' and nip=$contrasena");
	  echo $ra->RecordCount();
	  if($ra->RecordCount()>0)
	  {
		 $_SESSION['nocontrol']=$ra->fields['no_de_control'];
		 $_SESSION['nom_alum']=$ra->fields['nombre_alumno']." ".$ra->fields['apellido_paterno']." ".$ra->fields['apellido_materno'];
		 $_SESSION['carrera']=$ra->fields['carrera'];
		 $_SESSION['reticula']=$ra->fields['reticula'];
		 $_SESSION['email']=$ra->fields['correo_electronico'];
		 $_SESSION['sexo']=$ra->fields['sexo'];
		 $_SESSION['nip']=$ra->fields['nip'];
		 header('location:estudiantes/index.php');
	  }
	  else
		  
		header('location:index.html'); 
	}
 }
?>
