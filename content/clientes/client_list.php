<?php
$consulta = "SELECT clientes.id, nombre, edad, numcelular, email, fecha_alta
from clientes 
WHERE estado != 'bajo'
order by nombre";
$result = bd_consulta($consulta);
?>

<script type="text/javascript">
  function asociarEventos() {
    var titulos = document.getElementsByTagName("th");
    titulos[1].addEventListener("click", ordenarNombre);
    titulos[2].addEventListener("click", ordenarEdad);
    titulos[3].addEventListener("click", ordenarCelular);
    titulos[4].addEventListener("click", ordenarEmail);
    titulos[5].addEventListener("click", ordenarFecha);
  }

  var nombreAsc = true;

  function ordenarNombre() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 7;
    var matriz = new Array(fin - inicio);

    for (var i = inicio; i < fin; i++) {
      matriz[i - inicio] = new Array(columnas);
      for (var j = 0; j < columnas; j++) {
        matriz[i - inicio][j] = filas[i].getElementsByTagName("td")[j].innerHTML;
      }
    }

    // Ordenar la matriz por la columna 2 (índice 1 → columna "Título")
    for (var i = 0; i < matriz.length - 1; i++) {
      for (var j = i + 1; j < matriz.length; j++) {
        var a = matriz[i][1].toLowerCase();
        var b = matriz[j][1].toLowerCase();
        var condicion = nombreAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaNombre");
    flecha.innerHTML = nombreAsc ? "▼" : "▲";

    nombreAsc = !nombreAsc;
  }

  var edadAsc = true;

  function ordenarEdad() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 7;
    var matriz = new Array(fin - inicio);

    for (var i = inicio; i < fin; i++) {
      matriz[i - inicio] = new Array(columnas);
      for (var j = 0; j < columnas; j++) {
        matriz[i - inicio][j] = filas[i].getElementsByTagName("td")[j].innerHTML;
      }
    }

    // Ordenar la matriz por la columna 2 (índice 1 → columna "Título")
    for (var i = 0; i < matriz.length - 1; i++) {
      for (var j = i + 1; j < matriz.length; j++) {
        var a = matriz[i][2].toLowerCase();
        var b = matriz[j][2].toLowerCase();
        var condicion = edadAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaEdad");
    flecha.innerHTML = edadAsc ? "▼" : "▲";

    edadAsc = !edadAsc;
  }

  var celularAsc = true;

  function ordenarCelular() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 7;
    var matriz = new Array(fin - inicio);

    for (var i = inicio; i < fin; i++) {
      matriz[i - inicio] = new Array(columnas);
      for (var j = 0; j < columnas; j++) {
        matriz[i - inicio][j] = filas[i].getElementsByTagName("td")[j].innerHTML;
      }
    }

    // Ordenar la matriz por la columna 2 (índice 1 → columna "Título")
    for (var i = 0; i < matriz.length - 1; i++) {
      for (var j = i + 1; j < matriz.length; j++) {
        var a = matriz[i][3].toLowerCase();
        var b = matriz[j][3].toLowerCase();
        var condicion = celularAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaCelular");
    flecha.innerHTML = celularAsc ? "▼" : "▲";

    celularAsc = !celularAsc;
  }

  var emailAsc = true;

  function ordenarEmail() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 7;
    var matriz = new Array(fin - inicio);

    for (var i = inicio; i < fin; i++) {
      matriz[i - inicio] = new Array(columnas);
      for (var j = 0; j < columnas; j++) {
        matriz[i - inicio][j] = filas[i].getElementsByTagName("td")[j].innerHTML;
      }
    }

    // Ordenar la matriz por la columna 2 (índice 1 → columna "Título")
    for (var i = 0; i < matriz.length - 1; i++) {
      for (var j = i + 1; j < matriz.length; j++) {
        var a = matriz[i][4].toLowerCase();
        var b = matriz[j][4].toLowerCase();
        var condicion = emailAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaEmail");
    flecha.innerHTML = emailAsc ? "▼" : "▲";

    emailAsc = !emailAsc;
  }

  var fechaAsc = true;

  function ordenarFecha() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 7;
    var matriz = new Array(fin - inicio);

    for (var i = inicio; i < fin; i++) {
      matriz[i - inicio] = new Array(columnas);
      for (var j = 0; j < columnas; j++) {
        matriz[i - inicio][j] = filas[i].getElementsByTagName("td")[j].innerHTML;
      }
    }

    // Ordenar la matriz por la columna 2 (índice 1 → columna "Título")
    for (var i = 0; i < matriz.length - 1; i++) {
      for (var j = i + 1; j < matriz.length; j++) {
        var a = matriz[i][5].toLowerCase();
        var b = matriz[j][5].toLowerCase();
        var condicion = fechaAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaFecha");
    flecha.innerHTML = fechaAsc ? "▼" : "▲";

    fechaAsc = !fechaAsc;
  }

  window.addEventListener("load", asociarEventos);
</script>

<table>
  <tr>
    <th>#</th>
    <th id="isbn" style="cursor:pointer">Nombre <span id="flechaNombre">▼</span></th>
    <th id="isbn" style="cursor:pointer">Edad <span id="flechaEdad">▼</span></th>
    <th id="isbn" style="cursor:pointer">Celular <span id="flechaCelular">▼</span></th>
    <th id="isbn" style="cursor:pointer">Email <span id="flechaEmail">▼</span></th>
    <th id="isbn" style="cursor:pointer">Fecha Alta<span id="flechaFecha">▼</span></th>
    <th><a href="../base/index.php?op=21">+ &#128218;</a></th>
  </tr>
  <?php
  $i = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    $i++;
  ?>
    <tr>
      <td><?= $i ?></td>
      <td><?= $row['nombre']  ?></td>
      <td><?= $row['edad'] ?></td>
      <td><?= $row['numcelular'] ?></td>
      <td><?= $row['email'] ?></td>
      <td><?= $row['fecha_alta'] ?></td>
      <td>
        <a href="../base/index.php?op=22&id=<?= $row['id'] ?>">&#9997;&#127995;</a>
        <a href="../base/index.php?op=23&id=<?= $row['id'] ?>">❌</a>
      </td>
    </tr>
  <?php } ?>
  <tr>
    <td></td>
    <td></td>
    <td>El total de clientes es <?= $i ?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>