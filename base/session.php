<?php

	session_start();
	header("Content-Type: text/html;charset=utf-8");
	if(isset($_SESSION['USER']))
	{
		$user=$_SESSION['USER'];
		//$user_type=$_SESSION['USER_TYPE'];
		$user_nombre=$_SESSION['USER_NOMBRE'];
		// if(isset($_SESSION['USER_IMAGEN']))
		// 	$user_imagen=$_SESSION['USER_IMAGEN'];
		// else
		// 	$user_imagen="../images/noimagen.png";
	}
	else
	{
		$user=false;
		$user_nombre="No ha iniciado sesión";
		$user_imagen="../images/nousuario.png";
	}
?>
