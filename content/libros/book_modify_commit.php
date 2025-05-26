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
$estado = $_POST['estado'];
//ahora también recibimos el ID
$id = $_POST['id'];

$consulta = "SELECT imagen_portada, imagen_contraportada from book where id=" . $id;
$result = bd_consulta($consulta);
$row = mysqli_fetch_assoc($result);

if (strlen($_FILES['portada']['name']) > 0) {
  $archivo = $_FILES['portada']['tmp_name'];
  $nombre = $_FILES['portada']['name'];
  $extension = pathinfo($nombre, PATHINFO_EXTENSION);
  $nombre = $id . "." . $extension;
  $destino = "../../resources/portadas/" . $nombre;
  move_uploaded_file($archivo, $destino);
  $portada = $nombre;
} else {
  $portada = $row['imagen_portada'];
}
if (strlen($_FILES['contraportada']['name']) > 0) {
  $archivo = $_FILES['contraportada']['tmp_name'];
  $nombre = $_FILES['contraportada']['name'];
  $extension = pathinfo($nombre, PATHINFO_EXTENSION);
  $nombre = $id . "." . $extension;
  $destino = "../../resources/contraportadas/" . $nombre;
  move_uploaded_file($archivo, $destino);
  $contraportada = $nombre;
} else {
  $contraportada = $row['imagen_contraportada'];
}

$consulta = "UPDATE book SET titulo='" . $titulo . "', tipo=" . $tipo . ", paginas=" . $numPagina .
  ", editorial=" . $editorial . ", isbn='" . $isbn . "', pais=" . $pais . ", dimensiones='" . $dimension .
  "', idioma=" . $lenguaje . ", sobrecubierta=" . $sobrecubierta . ", pasta_dura=" . $tipoPasta .
  ", resumen='" . $resumen . "', precio=" . $precio . ", autor=" . $autor .
  ", imagen_portada='" . $portada . "', imagen_contraportada='" . $contraportada . "', estado='" . $estado . "' WHERE id=" . $id;

bd_consulta($consulta);

header('Location: ../../base/index.php?op=10');
