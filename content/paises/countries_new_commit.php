<?php
include('../../base/bd.php');

$id = $_POST['id'];
$name = $_POST['paises'];
$estado = "alto";

// Insertar cliente
$query = 'INSERT INTO pais (nombre, estado) VALUES 
(' .  '"' . $name . '","' . $estado . '")';

bd_consulta($query);

header("Location: ../../base/index.php?op=12&id=$id");
?>