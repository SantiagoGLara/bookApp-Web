<?php
include('../../base/bd.php');
include('../../base/global.php');

$id=$_POST['id'];
$nombre=$_POST['nombre'];
$numcelular=$_POST['numcelular'];
$email=$_POST['email'];
$estado=$_POST['estado'];

$consulta='UPDATE proveedores SET nombre="'.$nombre.'", numcelular="'.$numcelular.'",email="'.$email.'",estado="'.$estado.'" WHERE id='.$id;

bd_consulta($consulta);
header('Location: ../../base/index.php?op=30');

?>