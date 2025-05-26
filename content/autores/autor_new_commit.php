<?php
include('../../base/bd.php');

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$nacionalidad = $_POST['nacionalidad'];
$comentarios = $_POST['comentarios'];
$estado = "alto";

$consulta = 'INSERT INTO autor (nombre, nacionalidad, comentarios, estado) VALUES ("'
    . $nombre . '", "' . $nacionalidad . '", "' . $comentarios . '", "' . $estado . '")';

bd_consulta($consulta);

header("Location: ../../base/index.php?op=12&id=$id");