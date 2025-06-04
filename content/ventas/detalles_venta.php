<script type="text/javascript">
    var ventaAsc = true;

    function asociarEventos() {
        var colVentas = document.getElementsByTagName("th");
        colVentas[1].addEventListener("click", ordenarPorVenta);
        colVentas[2].addEventListener("click", ordenarPorLibro);
        colVentas[3].addEventListener("click", ordenarPorCantidad);
        colVentas[4].addEventListener("click", ordenarPorPrecioUnitario);
        colVentas[5].addEventListener("click", ordenarPorSubtotal);
    }

    function calcularTotales() {
        var totalSubtotales = 0;
        var totalElementos = document.getElementsByClassName("subtotal");
        var cantidadItems = 0;

        for (var i = 0; i < totalElementos.length; i++) {
            var valor = parseFloat(totalElementos[i].textContent.replace(/[^0-9.-]/g, '')) || 0;
            totalSubtotales += valor;
            cantidadItems++;
        }

        var promedioSubtotal = cantidadItems > 0 ? (totalSubtotales / cantidadItems) : 0;

        document.getElementById("promedioSubtotales").textContent = "Promedio por item: $" + promedioSubtotal.toFixed(2);
        document.getElementById("totalSubtotales").textContent = "Total de la venta: $" + totalSubtotales.toFixed(2);
    }

    function ordenarPorColumna(columna) {
        var datos = document.getElementsByTagName("td");
        var columnas = 6;
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

        console.log(ventaAsc);
        
        if (ventaAsc)
            ventaAsc = false;
        else
            ventaAsc = true;
    }

    function ordenaMatriz(matriz, columna, filas, columnas) {
        for (var h = 0; h < filas - 1; h++) {
            for (var i = h + 1; i < filas; i++) {
                var comp;
                
                // Manejo especial para números (cantidad, precio unitario, subtotal)
                if (columna === 3 || columna === 4 || columna === 5) {
                    var numA = parseFloat(matriz[h][columna].replace(/[^0-9.-]/g, '')) || 0;
                    var numB = parseFloat(matriz[i][columna].replace(/[^0-9.-]/g, '')) || 0;
                    comp = numA > numB ? 1 : (numA < numB ? -1 : 0);
                }
                // Para texto normal
                else {
                    comp = matriz[h][columna].localeCompare(matriz[i][columna]);
                }

                if (ventaAsc == true) {
                    if (comp == 1)
                        intercambia(matriz, i, h);
                }
                if (ventaAsc == false) {
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

    // Funciones específicas para cada columna
    function ordenarPorVenta() { ordenarPorColumna(1); }
    function ordenarPorLibro() { ordenarPorColumna(2); }
    function ordenarPorCantidad() { ordenarPorColumna(3); }
    function ordenarPorPrecioUnitario() { ordenarPorColumna(4); }
    function ordenarPorSubtotal() { ordenarPorColumna(5); }

    window.addEventListener("load", calcularTotales);
    window.addEventListener("load", asociarEventos);
</script>

<style>
    .detalle-venta-container {
        width: 80%;
        margin-left: 10%;
        margin-bottom: 30px;
    }
    
    .detalle-venta-container h2 {
        margin-bottom: 25px;
        font-family: serif;
    }
    
    .detalle-venta-container p {
        margin: 8px 0;
        font-family: serif;
    }
</style>

<?php
    // Obtener el ID de la venta desde la URL
    $idVenta = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($idVenta <= 0) {
        echo "<p>Error: ID de venta no válido.</p>";
        echo "<a href='../base/index.php?op=50'>← Regresar a ventas</a>";
        exit;
    }
    
    // Consulta para obtener información de la venta
    $consultaVenta = 
    "SELECT v.id, v.fecha_venta, v.total, v.comentarios,
    c.nombre AS cliente, u.nombre AS usuario, 
    mp.nombre AS metodo_pago
    FROM ventas v
    JOIN clientes c ON v.id_cliente = c.id
    JOIN usuarios u ON v.id_usuario = u.id
    LEFT JOIN metodos_pago mp ON v.id_metodo_pago = mp.id
    WHERE v.id = " . $idVenta . " AND v.estado = 'activo'";
    
    $resultVenta = bd_consulta($consultaVenta);
    $venta = mysqli_fetch_assoc($resultVenta);
    
    if (!$venta) {
        echo "<p>Error: Venta no encontrada.</p>";
        echo "<a href='../base/index.php?op=50'>← Regresar a ventas</a>";
        exit;
    }
    
    // Consulta para obtener los detalles de la venta
    $consultaDetalles = "SELECT dv.id, dv.cantidad, dv.precio_unitario, dv.subtotal,
                               b.titulo, b.autor, b.isbn
                        FROM detalle_ventas dv
                        INNER JOIN book b ON dv.id_libro = b.id
                        WHERE dv.id_venta = " . $idVenta . " AND dv.estado = 'alto'
                        ORDER BY dv.id";
    
    $resultDetalles = bd_consulta($consultaDetalles);
?>

<div class="detalle-venta-container">
    <h3>Detalle de Venta #<?= $venta['id'] ?></h3>
    <p><strong>Cliente:</strong> <?= $venta['cliente'] ?></p>
    <p><strong>Usuario:</strong> <?= $venta['usuario'] ?></p>
    <p><strong>Fecha de venta:</strong> <?= date('d/m/Y H:i', strtotime($venta['fecha_venta'])) ?></p>
    <p><strong>Método de pago:</strong> <?= $venta['metodo_pago'] ?: 'N/A' ?></p>
    <p><strong>Total:</strong> $<?= number_format($venta['total'], 2) ?></p>
    <?php if (!empty($venta['comentarios'])): ?>
    <p><strong>Comentarios:</strong> <?= htmlspecialchars($venta['comentarios']) ?></p>
    <?php endif; ?>
    
    <a href="../base/index.php?op=50">
        <button>Regresar a ventas</button>
    </a>
</div>

<table>
    <tr>
        <th>#</th>
        <th id="venta" style="cursor:pointer">Libro <span id="flechaLibro">⇅</span></th>
        <th id="cantidad" style="cursor:pointer">Cantidad <span id="flechaCantidad">⇅</span></th>
        <th id="precioUnitario" style="cursor:pointer">Precio Unitario <span id="flechaPrecioUnitario">⇅</span></th>
        <th id="subtotal" style="cursor:pointer">Subtotal <span id="flechaSubtotal">⇅</span></th>
    </tr>
    <?php
    $i = 0;
    if (mysqli_num_rows($resultDetalles) > 0) {
        while ($row = mysqli_fetch_assoc($resultDetalles)) {
            $i++;
    ?>
    <tr>
        <td><?= $i ?></td>
        <td><?= htmlspecialchars($row['titulo']) ?></td>
        <td><?= $row['cantidad'] ?></td>
        <td>$<?= number_format($row['precio_unitario'], 2) ?></td>
        <td class="subtotal">$<?= number_format($row['subtotal'], 2) ?></td>
    </tr>
    <?php 
        }
    } else {
    ?>
    <tr>
        <td colspan="6" style="text-align: center;">No se encontraron detalles para esta venta.</td>
    </tr>
    <?php } ?>
    <tr style="background-color: #f0f0f0; font-weight: bold;">
        <td></td>
        <td id="totalRegistros">Items: <?= $i ?></td>
        <td></td>
        <td id="promedioSubtotales">Promedio por item: $0.00</td>
        <td id="totalSubtotales">Total de la venta: $0.00</td>
    </tr>
</table>