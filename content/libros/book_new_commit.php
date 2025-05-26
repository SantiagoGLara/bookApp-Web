<?php
include('../../base/bd.php');
include('../../base/global.php');
$titulo = $_POST['titulo'];
$tipo = $_POST['tipo'];
$numPagina = $_POST['numpagina'];
$editorial = $_POST['editorial'];
$isbn = $_POST['isbn'];
$pais = $_POST['pais'];
$dimension = $_POST['dimension'];
$lenguaje = $_POST['lenguaje'];
$sobrecubierta = $_POST['sobrecubierta'] == "on" ? 1 : 0;
$tipoPasta = $_POST['tipo_pasta'];
$resumen = $_POST['resumen'];
$autor = $_POST['autor'];
$precio = $_POST['precio'];

$consulta = 'insert into book (titulo,tipo,paginas,editorial,isbn,pais,dimensiones,idioma,sobrecubierta,pasta_dura,resumen,precio,stock,autor)' .
  ' values( "' . $titulo . '",' . $tipo . ',' . $numPagina . ',' . $editorial . ',"' . $isbn . '",' . $pais . ',"' . $dimensiones[$dimension] . '",' . $lenguaje . ',' .
  $sobrecubierta . ',' . $tipoPasta . ',"' . $resumen . '",' . $precio . ',0,' . $autor . ')';
$consulta2 = 'select max(id) as newid from book';
$result = bd_consulta($consulta);
$result2 = bd_consulta($consulta2);
$row = mysqli_fetch_assoc($result2);
$newId = $row['newid'];
$archivo = $_FILES['portada']['tmp_name'];
$nombre = $_FILES['portada']['name'];
$extension = pathinfo($nombre, PATHINFO_EXTENSION);
$nombre = $newId . "." . $extension;
$destino = "../resources/portadas/" . $nombre;
move_uploaded_file($archivo, $destino);
$consulta3 = 'update book set imagen_portada="' . $nombre . '" where id=' . $newId;
$result = bd_consulta($consulta3);

$archivo = $_FILES['contraportada']['tmp_name'];
$nombre = $_FILES['contraportada']['name'];
$extension = pathinfo($nombre, PATHINFO_EXTENSION);
$nombre = $newId . "." . $extension;
$destino = "../resources/contraportadas/" . $nombre;
move_uploaded_file($archivo, $destino);
$consulta4 = 'update book set imagen_contraportada="' . $nombre . '" where id=' . $newId;
$result = bd_consulta($consulta4);
header('Location: ../../base/index.php?op=10');
