<?php
include('../../base/bd.php');

$id = $_POST['id'];
$nombre = $_POST['editorial'];
$estado = "alto";

// Insertar cliente
$consulta = 'INSERT INTO editorial (editorial, estado) VALUES 
(' .  '"' . $nombre . '","' . $estado . '")';

bd_consulta($consulta);

header("Location: ../../base/index.php?op=12&id=$id");