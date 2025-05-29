<?php
include('../../base/bd.php');

$id = $_POST['id'];
$username = $_POST['username'];
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$estado = "alto";

// Insertar cliente
$consulta = 'INSERT INTO usuarios (username, nombre, password, estado) VALUES 
(' .  '"' . $username . '","' . $nombre . '", "'.$password.'", "'.$estado.'")';

bd_consulta($consulta);

header("Location: ../../base/index.php?op=80");