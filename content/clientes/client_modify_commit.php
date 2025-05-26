<?php
include('../../base/bd.php');
include('../../base/global.php');

$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$numcelular = $_POST['numcelular'];
$email = $_POST['email'];
$fecha_alta = $_POST['fecha_alta'];
$estado = $_POST['estado'];
$id = $_POST['id'];

$consulta = 'UPDATE clientes SET nombre="' . $nombre . '", edad=' . $edad .
  ', numcelular="' . $numcelular . '", email="' . $email . '", fecha_alta="' . $fecha_alta . '", estado="' . $estado . '" WHERE id=' . $id;

bd_consulta($consulta);

header('Location: ../../base/index.php?op=20');

?>