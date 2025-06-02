<?php
    $consulta="SELECT id, nombre from proveedores where estado != 'bajo' order by nombre";
    $resultProveedor=bd_consulta($consulta);
    
    $consulta="SELECT id, nombre from usuarios where estado != 'bajo' order by nombre";
    $resultUsuario=bd_consulta($consulta);
    
    $consulta="SELECT id, nombre from metodos_pago where estado != 'bajo' order by nombre";
    $resultMetodoPago=bd_consulta($consulta);
    
    $consulta="SELECT id, titulo, precio, stock from book where estado != 'bajo' order by titulo";
    $resultLibro=bd_consulta($consulta);
?>

<style media="screen">
/* Estilos específicos para el sistema de compras */
.libro-selector {
    background-color: #f8f9fa;
    padding: 15px;
    margin: 15px 0;
    border-radius: 8px;
    border: 2px dashed #dee2e6;
}

.libro-selector h3 {
    margin-top: 0;
    color: #495057;
    background-color: transparent;
}

.total-compra {
    background-color: #d1ecf1;
    padding: 15px;
    margin: 15px 0;
    border-radius: 8px;
    text-align: center;
    font-size: 1.2em;
    border: 2px solid #bee5eb;
}

.btn-eliminar {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: background-color 0.3s ease;
}

.btn-eliminar:hover {
    background-color: #c82333;
}

.cantidad-input {
    width: 80px !important;
    text-align: center;
}

.libro-select {
    min-width: 300px;
}

#botones button {
    margin: 5px;
    padding: 10px 15px;
    border-radius: 5px;
    border: none;
    font-weight: bold;
    cursor: pointer;
}

#botones button[type="submit"] {
    background-color: #007bff;
}

#botones button[type="submit"]:hover {
    background-color: #0056b3;
}

.mensaje-vacio {
    color: #6c757d;
    font-style: italic;
    text-align: center;
}

/* Estilos específicos para la tabla de compras usando el mismo patrón que listings.css */
.tabla-compra {
    width: 80%;
    margin-left: 10%;
    border: solid 2px;
    border-collapse: separate;
    border-radius: 10px;
    font-family: serif;
    border-spacing: 0;
    margin-top: 20px;
    margin-bottom: 20px;
}

.tabla-compra thead th {
    font-weight: 600;
    border-bottom: 2px solid #DDE2E6;
    border-right: 1px solid #DDE2E6;
    padding: 12px 20px;
    border: 1px solid;
    background-color: #CCCCCC;
}

.tabla-compra thead th:last-child {
    border-right: none;
}

.tabla-compra thead th:first-child {
    border-top-left-radius: 8px;
}

.tabla-compra thead th:last-child {
    border-top-right-radius: 8px;
}

.tabla-compra tbody td {
    padding: 12px 20px;
    border-bottom: 1px solid #EEEEEE;
    background-color: #FFFFFF;
    transition: background-color 0.3s ease;
    border-right: 1px solid #EEEEEE;
    text-align: center;
    vertical-align: middle;
}

.tabla-compra tbody td:last-child {
    border-right: none;
}

.tabla-compra tbody tr:nth-child(odd) {
    background-color: #FFFFFF;
}

.tabla-compra tbody tr:nth-child(even) {
    background-color: antiquewhite;
}

.tabla-compra .libro-nombre {
    text-align: left;
    font-weight: 500;
}

.tabla-compra tbody tr:last-child td:first-child {
    border-bottom-left-radius: 8px;
}

.tabla-compra tbody tr:last-child td:last-child {
    border-bottom-right-radius: 8px;
}
</style>

<script type="text/javascript">
    var librosCompra = [];
    var contadorLibros = 0;
    var librosData = {};

    // Cargar datos de libros disponibles
    function cargarDatosLibros() {
        <?php
            mysqli_data_seek($resultLibro, 0);
            echo "librosData = {";
            while($row=mysqli_fetch_assoc($resultLibro)){
                echo $row['id'] . ": {";
                echo "titulo: '" . addslashes($row['titulo']) . "',";
                echo "precio: " . $row['precio'] . ",";
                echo "stock: " . $row['stock'];
                echo "},";
            }
            echo "};";
        ?>
    }

    function asociarEventos(){
        document.getElementById("botonAgregar").addEventListener("click", agregarLibroCompra);
        document.getElementById("botonLimpiar").addEventListener("click", limpiarCompra);
        document.getElementById("selectLibro").addEventListener("change", verificarSeleccion);
        document.getElementById("cantidad").addEventListener("input", verificarSeleccion);
    }
    
    function verificarSeleccion() {
        var selectLibro = document.getElementById("selectLibro");
        var cantidad = document.getElementById("cantidad");
        var botonAgregar = document.getElementById("botonAgregar");
        
        var libroSeleccionado = selectLibro.value;
        var cantidadValue = parseInt(cantidad.value);
        
        if (libroSeleccionado && cantidadValue > 0) {
            botonAgregar.disabled = false;
        } else {
            botonAgregar.disabled = true;
        }
    }
    
    function agregarLibroCompra() {
        var selectLibro = document.getElementById("selectLibro");
        var cantidad = document.getElementById("cantidad");
        
        var libroId = selectLibro.value;
        var cantidadValue = parseInt(cantidad.value);
        
        if (!libroId || cantidadValue <= 0) {
            alert("Por favor selecciona un libro y una cantidad válida");
            return;
        }
        
        var libroData = librosData[libroId];
        
        // Verificar si el libro ya está en la compra
        var libroExistente = librosCompra.find(libro => libro.id == libroId);
        
        if (libroExistente) {
            // Actualizar cantidad del libro existente
            libroExistente.cantidad += cantidadValue;
            libroExistente.subtotal = libroExistente.cantidad * libroExistente.precio;
        } else {
            // Agregar nuevo libro
            var nuevoLibro = {
                id: libroId,
                titulo: libroData.titulo,
                precio: libroData.precio,
                cantidad: cantidadValue,
                subtotal: libroData.precio * cantidadValue,
                indice: ++contadorLibros
            };
            librosCompra.push(nuevoLibro);
        }
        
        // Limpiar formulario de selección
        selectLibro.value = "";
        cantidad.value = "1";
        document.getElementById("botonAgregar").disabled = true;
        
        // Actualizar tabla y total
        actualizarTablaCompra();
        actualizarTotal();
        verificarFormularioCompleto();
    }
    
    function eliminarLibroCompra(indice) {
        librosCompra = librosCompra.filter(libro => libro.indice != indice);
        actualizarTablaCompra();
        actualizarTotal();
        verificarFormularioCompleto();
        verificarSeleccion(); // Reactivar botón si es necesario
    }
    
    function actualizarTablaCompra() {
        var tbody = document.getElementById("tablaCompraBody");
        
        if (librosCompra.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="mensaje-vacio">
                        No hay libros agregados a la compra
                    </td>
                </tr>
            `;
        } else {
            var html = "";
            librosCompra.forEach(function(libro, index) {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td class="libro-nombre">${libro.titulo}</td>
                        <td>$${libro.precio.toFixed(2)}</td>
                        <td>${libro.cantidad}</td>
                        <td>$${libro.subtotal.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn-eliminar" onclick="eliminarLibroCompra(${libro.indice})">
                                🗑️ Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }
    }
    
    function actualizarTotal() {
        var total = librosCompra.reduce(function(suma, libro) {
            return suma + libro.subtotal;
        }, 0);
        
        document.getElementById("totalCompra").textContent = "$" + total.toFixed(2);
    }
    
    function limpiarCompra() {
        if (librosCompra.length > 0) {
            if (confirm("¿Estás seguro de que quieres limpiar toda la compra?")) {
                librosCompra = [];
                contadorLibros = 0;
                actualizarTablaCompra();
                actualizarTotal();
                verificarFormularioCompleto();
                
                // Limpiar selección actual
                document.getElementById("selectLibro").value = "";
                document.getElementById("cantidad").value = "1";
                document.getElementById("botonAgregar").disabled = true;
            }
        } else {
            alert("No hay libros para limpiar");
        }
    }
    
    function verificarFormularioCompleto() {
        var proveedor = document.querySelector('select[name="proveedor"]').value;
        var metodoPago = document.querySelector('select[name="metodoPago"]').value;
        var tieneLibros = librosCompra.length > 0;
        
        var botonSubmit = document.querySelector('button[type="submit"]');
        botonSubmit.disabled = !(proveedor && metodoPago && tieneLibros);
    }
    
    function validarFormulario(event) {
        if (librosCompra.length === 0) {
            event.preventDefault();
            alert("Debes agregar al menos un libro a la compra");
            return false;
        }
        
        // Agregar datos de libros al formulario como campos ocultos
        var form = document.getElementById("formCompra");
        
        // Limpiar campos ocultos anteriores
        var camposOcultos = form.querySelectorAll('input[name^="libros"]');
        camposOcultos.forEach(campo => campo.remove());
        
        // Agregar nuevos campos ocultos
        librosCompra.forEach(function(libro, index) {
            var inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'libros[' + index + '][id]';
            inputId.value = libro.id;
            form.appendChild(inputId);
            
            var inputCantidad = document.createElement('input');
            inputCantidad.type = 'hidden';
            inputCantidad.name = 'libros[' + index + '][cantidad]';
            inputCantidad.value = libro.cantidad;
            form.appendChild(inputCantidad);
            
            var inputPrecio = document.createElement('input');
            inputPrecio.type = 'hidden';
            inputPrecio.name = 'libros[' + index + '][precio]';
            inputPrecio.value = libro.precio;
            form.appendChild(inputPrecio);
        });
        
        return true;
    }
    
    window.addEventListener("load", function() {
        cargarDatosLibros();
        asociarEventos();
        document.getElementById("botonAgregar").disabled = true;
        document.querySelector('button[type="submit"]').disabled = true;
        document.getElementById("formCompra").onsubmit = validarFormulario;
        
        // Agregar eventos para verificar formulario completo
        document.querySelector('select[name="proveedor"]').addEventListener("change", verificarFormularioCompleto);
        document.querySelector('select[name="metodoPago"]').addEventListener("change", verificarFormularioCompleto);
    });
</script>

<form id="formCompra" action="../content/compras/compras_new_commit.php" method="post">
    
    <div class="dato">
        <div class="etiqueta">
            <label for="proveedor">Proveedor:</label>
        </div>
        <div class="control">
            <select name="proveedor" required>
                <option value="">Selecciona un proveedor</option>
                <?php
                    mysqli_data_seek($resultProveedor, 0);
                    while($row=mysqli_fetch_assoc($resultProveedor)){
                ?>
                <option value="<?= $row['id'] ?>"><?= $row['nombre'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="metodoPago">Método de pago:</label>
        </div>
        <div class="control">
            <select name="metodoPago" required>
                <option value="">Selecciona método de pago</option>
                <?php
                    mysqli_data_seek($resultMetodoPago, 0);
                    while($row2=mysqli_fetch_assoc($resultMetodoPago)){
                ?>
                <option value="<?= $row2['id'] ?>"><?= $row2['nombre'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="libro-selector">
        <h3>📚 Agregar libros a la compra</h3>
        
        <div class="dato">
            <div class="etiqueta">
                <label for="libro">Libro:</label>
            </div>
            <div class="control">
                <select id="selectLibro" class="libro-select">
                    <option value="">Selecciona un libro</option>
                    <?php
                        mysqli_data_seek($resultLibro, 0);
                        while($row3=mysqli_fetch_assoc($resultLibro)){
                            $stockInfo = " (Stock actual: ".$row3['stock'].")";
                    ?>
                    <option value="<?= $row3['id'] ?>">
                        <?= $row3['titulo'] . $stockInfo ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="dato">
            <div class="etiqueta">
                <label for="cantidad">Cantidad:</label>
            </div>
            <div class="control">
                <input id="cantidad" type="number" min="1" value="1" class="cantidad-input">
            </div>
        </div>

        <div class="dato">
            <div class="etiqueta">
                <label>&nbsp;</label>
            </div>
            <div class="control">
                <button type="button" id="botonAgregar" disabled>➕ Agregar libro</button>
            </div>
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="comentarios">Comentarios:</label>
        </div>
        <div class="control">
            <textarea name="comentarios" rows="3" cols="30" placeholder="Comentarios adicionales sobre la compra (opcional)"></textarea>
        </div>
    </div>

    <table class="tabla-compra">
        <thead>
            <tr>
                <th>#</th>
                <th>Libro</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody id="tablaCompraBody">
            <tr>
                <td colspan="6" class="mensaje-vacio">
                    No hay libros agregados a la compra
                </td>
            </tr>
        </tbody>
    </table>

    <div class="total-compra">
        <strong>💰 Total de la compra: <span id="totalCompra">$0.00</span></strong>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label>&nbsp;</label>
        </div>
        <div class="control" id="botones">
            <button type="button" onClick="location.href='../base/index.php?op=40'">❌ Cancelar</button>
            <button type="button" id="botonLimpiar">🗑️ Limpiar compra</button>
            <button type="submit">🛒 Realizar compra</button>
        </div>
    </div>
</form>