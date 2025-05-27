<script type="text/javascript">
  function asociarEventos() {
    var titulos = document.getElementsByTagName("th");
    titulos[2].addEventListener("click", ordenarTitulo);
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

  window.addEventListener("load", libros);
  window.addEventListener("load", asociarEventos);
</script>

<?php
$consulta = "SELECT book.id, isbn, titulo, autor.nombre as autor, tipo.tipo, lenguaje.lenguaje, book.stock, book.precio, book.estado
from book 
inner join tipo on book.tipo=tipo.id
inner join lenguaje on book.idioma=lenguaje.id
inner join autor on autor.id=book.autor 
WHERE book.estado != 'bajo'
order by titulo";
$result = bd_consulta($consulta);
?>

<table>
  <tr>
    <th>#</th>
    <th>ISBN</th>
    <th id="titulo" style="cursor:pointer">Título <span id="flechaTitulo">▼</span></th>
    <th>Autor</th>
    <th>Tipo</th>
    <th>Lenguaje</th>
    <th>Stock</th>
    <th>Precio</th>
    <th><a href="../base/index.php?op=11">+ &#128218;</a></th>
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
      <td><a href="../base/index.php?op=12&id=<?= $row['id'] ?>">&#9997;&#127995;</a></td>
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