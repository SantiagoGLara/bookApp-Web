<?php
include('../../base/bd.php');
include('../../base/global.php');

$idBook = $_POST['idBook'];

$ids = $_POST['id'];
$nombres = $_POST['nombre'];
$nacionalidades = $_POST['nacionalidad']; 
$estados = $_POST['estado'];

for ($i = 0; $i < count($ids); $i++) {
    $id = $ids[$i];
    $nombre = $nombres[$i];
    $nacionalidad = $nacionalidades[$i];
    $estado = isset($estados[$id]) && $estados[$id] == 'alto' ? 'alto' : 'bajo';

    $consulta = 'UPDATE autor SET nombre="' . $nombre . '", nacionalidad=' . $nacionalidad . ', estado="' . $estado . '" WHERE id=' . $id;
    bd_consulta($consulta);

    if ($estado == 'bajo') {
        $consultaLibros = 'UPDATE book SET autor = 99 WHERE autor = ' . $id;
        bd_consulta($consultaLibros);
    }
}

header("Location: ../../base/index.php?op=12&id=$idBook");
?>