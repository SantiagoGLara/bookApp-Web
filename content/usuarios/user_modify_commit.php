<?php
include('../../base/bd.php');
include('../../base/global.php');

$ids = $_POST['id'];                
$usernames = $_POST['username'];   
$nombres = $_POST['nombre'];
$passwords = $_POST['password'];
$estados = $_POST['estado'];        

for ($i = 0; $i < count($ids); $i++) {
    $id = $ids[$i];
    $username = $usernames[$i];
    $nombre = $nombres[$i];
    $password = $passwords[$i];
    $estado = isset($estados[$id]) && $estados[$id] == 'alto' ? 'alto' : 'bajo';

    $consulta = 'UPDATE usuarios SET username="' . $username . '", nombre="'.$nombre.'", password="'.$password.'" , estado="' . $estado . '" WHERE id=' . $id;
    bd_consulta($consulta);
}

header("Location: ../../base/index.php?op=80");

?>