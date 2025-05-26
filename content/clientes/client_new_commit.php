<?php
include('../../base/bd.php');

$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$numcelular = $_POST['numcelular'];
$email = $_POST['email'];
$fecha_alta = $_POST['fecha_alta'];
$estado = "alto";

// Insertar cliente
$consulta = 'INSERT INTO clientes (nombre, edad, numcelular, email, fecha_alta, estado) VALUES (' .
  '"' . $nombre . '",' . $edad . ',"' . $numcelular . '","' . $email . '","' . $fecha_alta . '","' . $estado . '")';

bd_consulta($consulta);

header('Location: ../../base/index.php?op=20');
?>
