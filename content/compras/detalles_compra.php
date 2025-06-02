<script type="text/javascript">
    var compraAsc = true;

    function asociarEventos() {
        var colCompras = document.getElementsByTagName("th");
        colCompras[1].addEventListener("click", ordenarPorLibro);
        colCompras[2].addEventListener("click", ordenarPorCantidad);
        colCompras[3].addEventListener("click", ordenarPorPrecioUnitario);
        colCompras[4].addEventListener("click", ordenarPorSubtotal);
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
        document.getElementById("totalSubtotales").textContent = "Total de la compra: $" + totalSubtotales.toFixed(2);
    }

    function ordenarPorColumna(columna) {
        var datos = document.getElementsByTagName("td");
        var columnas = 5;
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
                
                // Manejo especial para números (cantidad, precio unitario, subtotal)
                if (columna === 2 || columna === 3 || columna === 4) {
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

    // Funciones específicas para cada columna
    function ordenarPorLibro() { ordenarPorColumna(1); }
    function ordenarPorCantidad() { ordenarPorColumna(2); }
    function ordenarPorPrecioUnitario() { ordenarPorColumna(3); }
    function ordenarPorSubtotal() { ordenarPorColumna(4); }

    window.addEventListener("load", calcularTotales);
    window.addEventListener("load", asociarEventos);
</script>

<style>
    .detalle-compra-container {
        width: 80%;
        margin-left: 10%;
        margin-bottom: 30px;
    }
    
    .detalle-compra-container h2 {
        margin-bottom: 25px;
        font-family: serif;
    }
    
    .detalle-compra-container p {
        margin: 8px 0;
        font-family: serif;
    }
</style>

<?php
    // Obtener el ID de la compra desde la URL
    $idCompra = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($idCompra <= 0) {
        echo "<p>Error: ID de compra no válido.</p>";
        echo "<a href='../base/index.php?op=60'>← Regresar a compras</a>";
        exit;
    }
    
    // Consulta para obtener información de la compra
    $consultaCompra = 
    "SELECT c.id, c.fecha_compra, c.total, c.comentarios,
    p.nombre AS proveedor, u.nombre AS usuario, 
    mp.nombre AS metodo_pago
    FROM compras c
    JOIN proveedores p ON c.id_proveedor = p.id
    JOIN usuarios u ON c.id_usuario = u.id
    LEFT JOIN metodos_pago mp ON c.id_metodo_pago = mp.id
    WHERE c.id = " . $idCompra . " AND c.estado = 'activo'";
    
    $resultCompra = bd_consulta($consultaCompra);
    $compra = mysqli_fetch_assoc($resultCompra);
    
    if (!$compra) {
        echo "<p>Error: Compra no encontrada.</p>";
        echo "<a href='../base/index.php?op=60'>← Regresar a compras</a>";
        exit;
    }
    
    // Consulta para obtener los detalles de la compra
    $consultaDetalles = "SELECT dc.id, dc.cantidad, dc.precio_unitario, dc.subtotal,
                               b.titulo, b.autor, b.isbn
                        FROM detalle_compras dc
                        INNER JOIN book b ON dc.id_libro = b.id
                        WHERE dc.id_compra = " . $idCompra . " AND dc.estado = 'alto'
                        ORDER BY dc.id";
    
    $resultDetalles = bd_consulta($consultaDetalles);
?>

<div class="detalle-compra-container">
    <h3>Detalle de Compra #<?= $compra['id'] ?></h3>
    <p><strong>Proveedor:</strong> <?= $compra['proveedor'] ?></p>
    <p><strong>Usuario:</strong> <?= $compra['usuario'] ?></p>
    <p><strong>Fecha de compra:</strong> <?= date('d/m/Y H:i', strtotime($compra['fecha_compra'])) ?></p>
    <p><strong>Método de pago:</strong> <?= $compra['metodo_pago'] ?: 'N/A' ?></p>
    <p><strong>Total:</strong> $<?= number_format($compra['total'], 2) ?></p>
    <?php if (!empty($compra['comentarios'])): ?>
    <p><strong>Comentarios:</strong> <?= htmlspecialchars($compra['comentarios']) ?></p>
    <?php endif; ?>
    
    <a href="../base/index.php?op=40">
        <button>Regresar a compras</button>
    </a>
</div>

<table>
    <tr>
        <th>#</th>
        <th id="libro" style="cursor:pointer">Libro <span id="flechaLibro">⇅</span></th>
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
        <td colspan="5" style="text-align: center;">No se encontraron detalles para esta compra.</td>
    </tr>
    <?php } ?>
    <tr style="background-color: #f0f0f0; font-weight: bold;">
        <td></td>
        <td id="totalRegistros">Items: <?= $i ?></td>
        <td></td>
        <td id="promedioSubtotales">Promedio por item: $0.00</td>
        <td id="totalSubtotales">Total de la compra: $0.00</td>
    </tr>
</table>