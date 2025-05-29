<?php
include('../../base/bd.php');
include('../../base/global.php');

$idBook = $_POST['id'];

$ids = $_POST['id'];
$nombres = $_POST['pais'];
$estados = $_POST['estado'];

for ($i = 0; $i < count($ids); $i++) {
    $id = $ids[$i];
    $nombre = $nombres[$i];
    $estado = isset($estados[$id]) && $estados[$id] == 'alto' ? 'alto' : 'bajo';

    if ($estado == 'bajo') {
        $queryVerificacion = bd_consulta('SELECT EXISTS (SELECT 1 FROM book WHERE book.pais = "' . $id . '")');
        $resultado = mysqli_fetch_row($queryVerificacion);

        if ($resultado[0] == 1) {
            echo "<script>";
            echo "alert('Eliminacion no realizada, el pais " . addslashes($nombre) . " tiene libros asociados');";
            echo "window.location.href = '../../base/index.php?op=12&id=$id';"; // en lugar del header de abajo
            echo "</script>";
            continue;
        }
    }

    $consulta = 'UPDATE pais SET `nombre`="' . $nombre . '", estado="' . $estado . '" WHERE id=' . $id;
    bd_consulta($consulta);
}

// header("Location: ../../base/index.php?op=12&id=$id"); eliminamos para poder mostrar la alerta
exit();
?>