<?php
 session_start();
 if($_SESSION['nomusua'] || $_SESSION['nocontrol'])
 {
	 session_destroy();
	 header('location:index.html');
 }
?>
