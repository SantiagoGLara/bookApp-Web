<script type="text/javascript">
    var compraAsc = true;

    function asociarEventos() {
        var colCompras = document.getElementsByTagName("th");
        colCompras[1].addEventListener("click", ordenarPorUsuario);
        colCompras[2].addEventListener("click", ordenarPorProveedor);
        colCompras[3].addEventListener("click", ordenarPorFecha);
        colCompras[4].addEventListener("click", ordenarPorMetodo);
        colCompras[5].addEventListener("click", ordenarPorTotal);
    }

    function compras() {
        var totalCompras = 0;
        var totalElementos = document.getElementsByClassName("total");
        var promedioCompras = 0;

        for (var i = 0; i < totalElementos.length; i++) {
            var valor = parseFloat(totalElementos[i].textContent) || 0;
            totalCompras += valor;
            promedioCompras += valor;
        }

        var suma = totalElementos.length;
        promedioCompras = suma > 0 ? Math.round(promedioCompras / suma) : 0;

        document.getElementById("promedioCompras").textContent = "Promedio de compras: $" + promedioCompras;
        document.getElementById("totalCompras").textContent = "Total comprado: $" + totalCompras.toFixed(2);
    }

    function ordenarPorColumna(columna) {
        var datos = document.getElementsByTagName("td");
        var columnas = 7;
        var filas = (datos.length / columnas) - 1; // -1 para excluir fila de totales
        var matriz = new Array();
        
        for (var i = 0; i < filas; i++)
            matriz[i] = new Array();

        for (var i = 0; i < filas; i++)
            for (var j = 0; j < columnas; j++)
                matriz[i][j] = datos[i * columnas + j].innerHTML;

        ordenaMatriz(matriz, columna, filas, columnas);
        
        for (var i = 0; i < filas; i++)
            for (var j = 0; j < columnas; j++)
                datos[i * columnas + j].innerHTML = matriz[i][j];

        console.log(compraAsc);
        
        if (compraAsc)
            compraAsc = false;
        else
            compraAsc = true;
    }

    function ordenaMatriz(matriz, columna, filas, columnas) {
        for (var h = 0; h < filas - 1; h++) {
            for (var i = h + 1; i < filas; i++) {
                var comp;
                
                // Manejo especial para fechas (columna 3)
                if (columna === 3) {
                    var fechaA = new Date(matriz[h][columna].replace(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/, '$3-$2-$1 $4:$5'));
                    var fechaB = new Date(matriz[i][columna].replace(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/, '$3-$2-$1 $4:$5'));
                    comp = fechaA > fechaB ? 1 : (fechaA < fechaB ? -1 : 0);
                }
                // Manejo especial para totales (columna 5)
                else if (columna === 5) {
                    var numA = parseFloat(matriz[h][columna].replace(/[^0-9.-]/g, '')) || 0;
                    var numB = parseFloat(matriz[i][columna].replace(/[^0-9.-]/g, '')) || 0;
                    comp = numA > numB ? 1 : (numA < numB ? -1 : 0);
                }
                // Para texto normal
                else {
                    comp = matriz[h][columna].localeCompare(matriz[i][columna]);
                }

                if (compraAsc == true) {
                    if (comp == 1)
                        intercambia(matriz, i, h);
                }
                if (compraAsc == false) {
                    if (comp == -1)
                        intercambia(matriz, i, h);
                }
            }
        }
    }

    function intercambia(matriz, i, h) {
        var vector = new Array();
        var columnas = matriz[0].length;
        console.log(i, "<->", h);

        for (var x = 0; x < columnas; x++)
            vector[x] = matriz[i][x];

        for (var x = 0; x < columnas; x++)
            matriz[i][x] = matriz[h][x];

        for (var x = 0; x < columnas; x++)
            matriz[h][x] = vector[x];
    }

    function imprimeMatriz(matriz) {
        var filas = matriz.length;
        var columnas = matriz[0].length;
        for (var i = 0; i < filas; i++)
            for (var j = 0; j < columnas; j++)
                console.log(matriz[i][j]);
    }

    // Funciones específicas para cada columna
    function ordenarPorUsuario() { ordenarPorColumna(1); }
    function ordenarPorProveedor() { ordenarPorColumna(2); }
    function ordenarPorFecha() { ordenarPorColumna(3); }
    function ordenarPorMetodo() { ordenarPorColumna(4); }
    function ordenarPorTotal() { ordenarPorColumna(5); }

    window.addEventListener("load", compras);
    window.addEventListener("load", asociarEventos);
</script>

<?php
    $consulta = "SELECT compras.id, usuarios.nombre AS usuario, proveedores.nombre AS proveedor, 
                compras.fecha_compra, compras.total, metodos_pago.nombre AS metodo_pago
                FROM compras
                JOIN proveedores ON compras.id_proveedor = proveedores.id 
                JOIN usuarios ON compras.id_usuario = usuarios.id
                LEFT JOIN metodos_pago ON compras.id_metodo_pago = metodos_pago.id
                WHERE compras.estado = 'activo'
                ORDER BY compras.fecha_compra DESC";
    $result = bd_consulta($consulta);
?>

<table>
    <tr>
        <th>#</th>
        <th id="usuario" style="cursor:pointer">Usuario <span id="flechaUsuario">⇅</span></th>
        <th id="proveedor" style="cursor:pointer">Proveedor <span id="flechaProveedor">⇅</span></th>
        <th id="fecha" style="cursor:pointer">Fecha <span id="flechaFecha">⇅</span></th>
        <th id="metodo" style="cursor:pointer">Método de pago <span id="flechaMetodo">⇅</span></th>
        <th id="total" style="cursor:pointer">Total <span id="flechaTotal">⇅</span></th>
        <th><a href="../base/index.php?op=43">+ &#128218;</a></th> <!-- Nueva compra-->
    </tr>
    <?php
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $i++;
    ?>
    <tr>
        <td><?= $i ?></td>
        <td><?= $row['usuario'] ?></td>
        <td><?= $row['proveedor'] ?></td>
        <td><?= date('d/m/Y H:i', strtotime($row['fecha_compra'])) ?></td>
        <td><?= $row['metodo_pago'] ?: 'N/A' ?></td>
        <td class="total"><?= number_format($row['total'], 2) ?></td>
        <td>
            <a href="../base/index.php?op=46&id=<?= $row['id'] ?>">🔍</a>
            <a href="../base/index.php?op=45&id=<?= $row['id'] ?>">❌</a>
        </td> <!-- Ver/Cancelar compra-->
    </tr>
    <?php } ?>
    <tr>
        <td></td>
        <td></td>
        <td id="totalRegistros">Cantidad de compras: <?=$i?></td>
        <td></td>
        <td></td>
        <td id="totalCompras">Monto total de compras: $0.00</td>
        <td id="promedioCompras">Promedio de compras: $0</td>
    </tr>
</table>