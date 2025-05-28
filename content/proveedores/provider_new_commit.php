<?php
include('../../base/bd.php');
include('../../base/global.php');
$nombre=$_POST['nombre'];
$numcelular=$_POST['numcelular'];
$email=$_POST['email'];
$consulta='INSERT INTO proveedores (nombre,numcelular,email,fecha_alta,estado) values("'.$nombre.'","'.$numcelular.'","'.$email.'",NOW(),"alto")';
bd_consulta($consulta);
header('Location: ../../base/index.php?op=30');
?>