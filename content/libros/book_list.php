<?php
$consulta = "SELECT book.id, isbn, titulo, autor.nombre as autor, 
tipo.tipo, lenguaje.lenguaje, book.stock, book.precio, book.estado
from book 
inner join tipo on book.tipo=tipo.id
inner join lenguaje on book.idioma=lenguaje.id
inner join autor on autor.id=book.autor 
WHERE book.estado != 'bajo'
order by titulo";
$result = bd_consulta($consulta);
?>

<script type="text/javascript">
  function asociarEventos() {
    var titulos = document.getElementsByTagName("th");
    titulos[1].addEventListener("click", ordenarISBN);
    titulos[2].addEventListener("click", ordenarTitulo);
    titulos[3].addEventListener("click", ordenarAutor);
    titulos[4].addEventListener("click", ordenarTipo);
    titulos[5].addEventListener("click", ordenarLenguaje);
    titulos[6].addEventListener("click", ordenarStock);
    titulos[7].addEventListener("click", ordenarPrecio);
  }

  function libros() {
    var stock = 0;
    var stockElementos = document.getElementsByClassName("stock");

    var promedioPrecios = 0;
    var precioElementos = document.getElementsByClassName("precio");

    for (var i = 0; i < stockElementos.length; i++) {
      stock += parseInt(stockElementos[i].textContent) || 0;
    }

    for (var i = 0; i < precioElementos.length; i++) {
      promedioPrecios += parseInt(precioElementos[i].textContent) || 0;
    }

    var suma = precioElementos.length;
    promedioPrecios = suma > 0 ? Math.round(promedioPrecios / suma) : 0;

    document.getElementById("precioProm").textContent = "Precio promedio: " + promedioPrecios;
    document.getElementById("stockTotal").textContent = "Stock: " + stock;
  }

  var isbnAsc = true;

  function ordenarISBN() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 9;
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
        var condicion = isbnAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaISBN");
    flecha.innerHTML = isbnAsc ? "▼" : "▲";

    isbnAsc = !isbnAsc;
  }

  var libroAsc = true;

  function ordenarTitulo() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 9;
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
        var condicion = libroAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaTitulo");
    flecha.innerHTML = libroAsc ? "▼" : "▲";

    libroAsc = !libroAsc;
  }

  var autorAsc = true;

  function ordenarAutor() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 9;
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
        var condicion = autorAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaAutor");
    flecha.innerHTML = autorAsc ? "▼" : "▲";

    autorAsc = !autorAsc;
  }

  var tipoAsc = true;

  function ordenarTipo() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 9;
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
        var condicion = tipoAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaTipo");
    flecha.innerHTML = tipoAsc ? "▼" : "▲";

    tipoAsc = !tipoAsc;
  }

  var lenguajeAsc = true;

  function ordenarLenguaje() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 9;
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
        var condicion = lenguajeAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaLenguaje");
    flecha.innerHTML = lenguajeAsc ? "▼" : "▲";

    lenguajeAsc = !lenguajeAsc;
  }

  var stockAsc = true;

  function ordenarStock() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 9;
    var matriz = new Array(fin - inicio);

    for (var i = inicio; i < fin; i++) {
      matriz[i - inicio] = new Array(columnas);
      for (var j = 0; j < columnas; j++) {
        matriz[i - inicio][j] = filas[i].getElementsByTagName("td")[j].innerHTML;
      }
    }

    for (var i = 0; i < matriz.length - 1; i++) {
      for (var j = i + 1; j < matriz.length; j++) {
        var a = parseInt(matriz[i][6]);
        var b = parseInt(matriz[j][6]);
        var condicion = stockAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaStock");
    flecha.innerHTML = stockAsc ? "▼" : "▲";

    stockAsc = !stockAsc;
  }

  var precioAsc = true;

  function ordenarPrecio() {
    var tabla = document.getElementsByTagName("table")[0];
    var filas = tabla.getElementsByTagName("tr");

    var inicio = 1; // saltar cabecera
    var fin = filas.length - 1; // evitar fila de totales

    var columnas = 9;
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
        var a = parseInt(matriz[i][7]);
        var b = parseInt(matriz[j][7]);
        var condicion = precioAsc ? (a > b) : (a < b);
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
    var flecha = document.getElementById("flechaPrecio");
    flecha.innerHTML = precioAsc ? "▼" : "▲";

    precioAsc = !precioAsc;
  }

  window.addEventListener("load", libros);
  window.addEventListener("load", asociarEventos);
</script>
<div class="title">
  <h3>Listado libros</h3>
</div>

<table>
  <tr>
    <th>#</th>
    <th id="isbn" style="cursor:pointer">ISBN <span id="flechaISBN">▼</span></th>
    <th id="titulo" style="cursor:pointer">Título <span id="flechaTitulo">▼</span></th>
    <th id="titulo" style="cursor:pointer">Autor <span id="flechaAutor">▼</span></th>
    <th id="titulo" style="cursor:pointer">Tipo <span id="flechaTipo">▼</span></th>
    <th id="titulo" style="cursor:pointer">Lenguaje<span id="flechaLenguaje">▼</span></th>
    <th id="titulo" style="cursor:pointer">Stock <span id="flechaStock">▼</span></th>
    <th id="titulo" style="cursor:pointer">Precio <span id="flechaPrecio">▼</span></th>
    <th><a href="../base/index.php?op=11">+&#128218;</a></th>
  </tr>
  <?php
  $i = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    $i++;
  ?>
  <tr>
      <td><?= $i ?></td>
      <td><?= $row['isbn']  ?></td>
      <td><?= $row['titulo'] ?></td>
      <td><?= $row['autor'] ?></td>
      <td><?= $row['tipo'] ?></td>
      <td><?= $row['lenguaje'] ?></td>
      <td class="stock"><?= $row['stock']  ?></td>
      <td class="precio"><?= $row['precio']  ?></td>
      <td>
        <a href="../base/index.php?op=12&id=<?= $row['id'] ?>">&#9997;&#127995;</a>
        <a href="../base/index.php?op=13&id=<?= $row['id'] ?>">❌</a>
      </td>
  </tr>

  <?php } ?>
  <tr>
    <td></td>
    <td></td>
    <td id="totalLibros">Total de libros: <?=$i?></td>
    <td></td>
    <td></td>
    <td></td>
    <td id="stockTotal">Stock:</td>
    <td id="precioProm">Precio promedio:</td>
    <td></td>
  </tr>
</table>