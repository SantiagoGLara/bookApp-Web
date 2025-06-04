<?php
$consulta = "SELECT * from pais;";
$result = bd_consulta($consulta);
?>

<script type="text/javascript">
  function asociarEventos() {
    var titulos = document.getElementsByTagName("th");
    titulos[1].addEventListener("click", ordenarPais);
  }

  var paisAsc = true;

  function ordenarPais() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 2; // solo tenemos 2 columnas (# y Nombre)
    var matriz = new Array(fin - inicio);

    for (var i = inicio; i < fin; i++) {
      matriz[i - inicio] = new Array(columnas);
      for (var j = 0; j < columnas; j++) {
        matriz[i - inicio][j] = filas[i].getElementsByTagName("td")[j].innerHTML;
      }
    }

    // Ordenar la matriz por la columna del nombre del país (índice 1)
    for (var i = 0; i < matriz.length - 1; i++) {
      for (var j = i + 1; j < matriz.length; j++) {
        var a = matriz[i][1].toLowerCase();
        var b = matriz[j][1].toLowerCase();
        var condicion = paisAsc ? (a > b) : (a < b);
        if (condicion) {
          var temp = matriz[i];
          matriz[i] = matriz[j];
          matriz[j] = temp;
        }
      }
    }

    // Reescribir filas
    for (var i = inicio; i < fin; i++) {
      for (var j = 0; j < columnas; j++) {
        filas[i].getElementsByTagName("td")[j].innerHTML = matriz[i - inicio][j];
      }
    }

    // Cambiar flecha
    var flecha = document.getElementById("flechaPais");
    flecha.innerHTML = paisAsc ? "▼" : "▲";

    paisAsc = !paisAsc;
  }

  window.addEventListener("load", asociarEventos);
</script>
<div class="title">
  <h3>Listado paises</h3>
</div>

<table class="small-list">
  <tr>
    <th>#</th>
    <th id="titulo" style="cursor:pointer">País <span id="flechaPais">▼</span></th>
    
  </tr>
  <?php
  $i = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    $i++;
  ?>
    <tr>
      <td><?= $i ?></td>
      <td><?= $row['nombre'] ?></td>
    </tr>
  <?php } ?>
  <tr>
    <td></td>
    <td id="totalPaises">Total de Países: <?= $i ?></td>
  </tr>
</table>