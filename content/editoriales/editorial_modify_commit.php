<?php
include('../../base/bd.php');
include('../../base/global.php');

$idBook = $_POST['idBook'];

$ids = $_POST['id'];                
$nombres = $_POST['editorial'];     
$estados = $_POST['estado'];        

for ($i = 0; $i < count($ids); $i++) {
    $id = $ids[$i];
    $nombre = $nombres[$i];
    $estado = isset($estados[$id]) && $estados[$id] == 'alto' ? 'alto' : 'bajo';

    // Actualizar editorial
    $consulta = 'UPDATE editorial SET editorial="' . $nombre . '", estado="' . $estado . '" WHERE id=' . $id;
    bd_consulta($consulta);

    // Si se da de baja, actualizar los libros asociados
    if ($estado == 'bajo') {
        $consultaLibros = 'UPDATE book SET editorial = 99 WHERE editorial = ' . $id;
        bd_consulta($consultaLibros);
    }
}

header("Location: ../../base/index.php?op=12&id=$idBook");

?>