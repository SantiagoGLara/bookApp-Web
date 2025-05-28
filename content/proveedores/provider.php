<?php
    $consulta="SELECT id,nombre,numcelular,email,fecha_alta FROM proveedores order by nombre";
    $result=bd_consulta($consulta);
?>
<script type="text/javascript">
    // Esta función se ejecuta cuando la página ha cargado completamente.
    function asociarEventos() {
        // Obtenemos el encabezado de la columna "Nombre" directamente por su ID.
        // Esto es más seguro que usar getElementsByTagName("th")[1] porque evita problemas si el orden de los TH cambia.
        var nombreHeader = document.getElementById("nombreColumna"); // Asegúrate de que este ID esté en tu TH de "Nombre"
        if (nombreHeader) { // Verificamos que el elemento exista antes de intentar añadir el evento
            nombreHeader.addEventListener("click", ordenarNombre);
        } else {
            console.error("El elemento con ID 'nombreColumna' no fue encontrado.");
        }
    }

    // Variable para controlar el orden de la ordenación (ascendente/descendente)
    var nombreAsc = true;

    function ordenarNombre() {
        var tabla = document.getElementsByTagName("table")[0]; // La primera tabla en el documento
        var filas = tabla.getElementsByTagName("tr");

        // Los datos empiezan en la segunda fila (índice 1) y la última fila es la de totales.
        var inicio = 1; // Saltar la fila de la cabecera (<th>)
        // Restamos 2 para la fila de totales, ya que las filas de datos empiezan en el índice 1, y la última es de totales.
        // Si tienes una sola fila de totales al final, entonces `filas.length - 1` es el último TR.
        // Si tu última fila NO es parte de los datos a ordenar, `filas.length - 2` es correcto para el último dato.
        // Si la última fila es 'El total de provedores es...', entonces el último dato es `filas.length - 2`.
        var fin = filas.length - 1; // Evitar la última fila de totales

        // Número de columnas en la tabla (asumiendo que es fijo)
        var columnas = 6; // Ajusta esto al número real de columnas de datos en tus TR (incluyendo el último <td> del enlace)

        // Creamos una matriz para almacenar los datos de las filas, excluyendo cabecera y totales
        var matriz = new Array(fin - inicio);

        // Llenar la matriz con los datos de la tabla
        for (var i = inicio; i < fin; i++) {
            matriz[i - inicio] = new Array(columnas);
            var celdas = filas[i].getElementsByTagName("td");
            for (var j = 0; j < columnas; j++) {
                // Asegúrate de que la celda exista antes de intentar acceder a innerHTML
                if (celdas[j]) {
                    matriz[i - inicio][j] = celdas[j].innerHTML;
                } else {
                    matriz[i - inicio][j] = ""; // Asignar vacío si la celda no existe
                }
            }
        }

        // Ordenar la matriz por la columna "Nombre" (que es el índice 1, ya que "#" es el 0)
        // Usamos un algoritmo de burbuja simple para ordenar
        for (var i = 0; i < matriz.length - 1; i++) {
            for (var j = i + 1; j < matriz.length; j++) {
                // Convertimos a minúsculas para una ordenación insensible a mayúsculas/minúsculas
                var a = matriz[i][1].toLowerCase(); // Columna del nombre (índice 1)
                var b = matriz[j][1].toLowerCase(); // Columna del nombre (índice 1)

                // Determinamos la condición de ordenación (ascendente o descendente)
                var condicion = nombreAsc ? (a > b) : (a < b);
                if (condicion) {
                    // Intercambiar filas si la condición se cumple
                    var temp = matriz[i];
                    matriz[i] = matriz[j];
                    matriz[j] = temp;
                }
            }
        }

        // Reescribir las filas de la tabla con los datos ordenados
        for (var i = inicio; i < fin; i++) {
            var celdas = filas[i].getElementsByTagName("td");
            for (var j = 0; j < columnas; j++) {
                if (celdas[j]) { // Verificamos que la celda exista
                    celdas[j].innerHTML = matriz[i - inicio][j];
                }
            }
        }

        // Cambiar la dirección de la flecha para indicar el nuevo orden
        var flecha = document.getElementById("flechaNombre");
        if (flecha) {
            flecha.innerHTML = nombreAsc ? "▲" : "▼"; // Si estaba ascendente, ahora la flecha apunta hacia arriba
        }

        // Invertir el estado de ordenación para el próximo clic
        nombreAsc = !nombreAsc;
    }

    // Cuando la ventana haya cargado completamente, se asocian los eventos
    window.addEventListener("load", asociarEventos);
</script>

<table>
    <tr>
        <th>#</th>
        <th id="nombreColumna" style="cursor:pointer">Nombre <span id="flechaNombre">▼</span></th>
        <th>Numero Celular</th>
        <th>Email</th>
        <th>Fecha Alta</th>
        <th><a href="../base/index.php?op=31">+ &#128218;</a></th>
    </tr>

<?php
    $i=0;
    while($row=mysqli_fetch_assoc($result)){
        $i++;
?>
    <tr>
        <td><?= $i ?></td>
        <td><?= $row['nombre'] ?></td>
        <td><?= $row['numcelular'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['fecha_alta'] ?></td>
        <td><a href="../base/index.php?op=32&id=<?=$row['id']?>">&#9997;&#127995;</a></td>
    </tr>
<?php } ?>
    <tr>
        <td></td><td></td><td></td><td>El total de provedores es <?=$i?></td><td></td><td></td>
    </tr>
</table>