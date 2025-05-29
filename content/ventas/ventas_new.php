<?php
    $consulta="SELECT id, nombre from clientes where estado != 'bajo' order by nombre";
    $resultCliente=bd_consulta($consulta);
    
    $consulta="SELECT id, nombre from usuarios where estado != 'bajo' order by nombre";
    $resultUsuario=bd_consulta($consulta);
    
    $consulta="SELECT id, nombre from metodos_pago where estado != 'bajo' order by nombre";
    $resultMetodoPago=bd_consulta($consulta);
    
    $consulta="SELECT id, titulo, precio, stock from book where estado != 'bajo' order by titulo";
    $resultLibro=bd_consulta($consulta);
?>

<style media="screen">
/* Estilos específicos para el sistema de ventas */
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

.tabla-venta {
    margin: 20px 0;
    background-color: white;
}

.tabla-venta th {
    background-color: #6c757d !important;
    color: white;
    font-weight: bold;
}

.tabla-venta td {
    text-align: center;
    vertical-align: middle;
}

.tabla-venta .libro-nombre {
    text-align: left;
    font-weight: 500;
}

.total-venta {
    background-color: #d4edda;
    padding: 15px;
    margin: 15px 0;
    border-radius: 8px;
    text-align: center;
    font-size: 1.2em;
    border: 2px solid #c3e6cb;
}

.btn-eliminar {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
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
    background-color: #28a745;
}

#botones button[type="submit"]:hover {
    background-color: #218838;
}

.mensaje-vacio {
    color: #6c757d;
    font-style: italic;
    text-align: center;
}
</style>

<script type="text/javascript">
    var librosVenta = [];
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
        document.getElementById("botonAgregar").addEventListener("click", agregarLibroVenta);
        document.getElementById("botonLimpiar").addEventListener("click", limpiarVenta);
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
            // Verificar si el libro ya está en la venta
            var libroYaAgregado = librosVenta.find(libro => libro.id == libroSeleccionado);
            if (libroYaAgregado) {
                // Verificar stock disponible considerando la cantidad ya agregada
                var stockDisponible = librosData[libroSeleccionado].stock - libroYaAgregado.cantidad;
                if (cantidadValue <= stockDisponible) {
                    botonAgregar.disabled = false;
                } else {
                    botonAgregar.disabled = true;
                    alert("Stock insuficiente. Disponible: " + stockDisponible);
                }
            } else {
                // Verificar stock normal
                if (cantidadValue <= librosData[libroSeleccionado].stock) {
                    botonAgregar.disabled = false;
                } else {
                    botonAgregar.disabled = true;
                    alert("Stock insuficiente. Disponible: " + librosData[libroSeleccionado].stock);
                }
            }
        } else {
            botonAgregar.disabled = true;
        }
    }
    
    function agregarLibroVenta() {
        var selectLibro = document.getElementById("selectLibro");
        var cantidad = document.getElementById("cantidad");
        
        var libroId = selectLibro.value;
        var cantidadValue = parseInt(cantidad.value);
        
        if (!libroId || cantidadValue <= 0) {
            alert("Por favor selecciona un libro y una cantidad válida");
            return;
        }
        
        var libroData = librosData[libroId];
        
        // Verificar si el libro ya está en la venta
        var libroExistente = librosVenta.find(libro => libro.id == libroId);
        
        if (libroExistente) {
            // Actualizar cantidad del libro existente
            var nuevaCantidad = libroExistente.cantidad + cantidadValue;
            if (nuevaCantidad <= libroData.stock) {
                libroExistente.cantidad = nuevaCantidad;
                libroExistente.subtotal = libroExistente.cantidad * libroExistente.precio;
            } else {
                alert("No hay suficiente stock disponible");
                return;
            }
        } else {
            // Agregar nuevo libro
            if (cantidadValue <= libroData.stock) {
                var nuevoLibro = {
                    id: libroId,
                    titulo: libroData.titulo,
                    precio: libroData.precio,
                    cantidad: cantidadValue,
                    subtotal: libroData.precio * cantidadValue,
                    indice: ++contadorLibros
                };
                librosVenta.push(nuevoLibro);
            } else {
                alert("No hay suficiente stock disponible");
                return;
            }
        }
        
        // Limpiar formulario de selección
        selectLibro.value = "";
        cantidad.value = "1";
        document.getElementById("botonAgregar").disabled = true;
        
        // Actualizar tabla y total
        actualizarTablaVenta();
        actualizarTotal();
        verificarFormularioCompleto();
    }
    
    function eliminarLibroVenta(indice) {
        librosVenta = librosVenta.filter(libro => libro.indice != indice);
        actualizarTablaVenta();
        actualizarTotal();
        verificarFormularioCompleto();
        verificarSeleccion(); // Reactivar botón si es necesario
    }
    
    function actualizarTablaVenta() {
        var tbody = document.getElementById("tablaVentaBody");
        
        if (librosVenta.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="mensaje-vacio">
                        No hay libros agregados a la venta
                    </td>
                </tr>
            `;
        } else {
            var html = "";
            librosVenta.forEach(function(libro, index) {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td class="libro-nombre">${libro.titulo}</td>
                        <td>$${libro.precio.toFixed(2)}</td>
                        <td>${libro.cantidad}</td>
                        <td>$${libro.subtotal.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn-eliminar" onclick="eliminarLibroVenta(${libro.indice})">
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
        var total = librosVenta.reduce(function(suma, libro) {
            return suma + libro.subtotal;
        }, 0);
        
        document.getElementById("totalVenta").textContent = "$" + total.toFixed(2);
    }
    
    function limpiarVenta() {
        if (librosVenta.length > 0) {
            if (confirm("¿Estás seguro de que quieres limpiar toda la venta?")) {
                librosVenta = [];
                contadorLibros = 0;
                actualizarTablaVenta();
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
        var cliente = document.querySelector('select[name="cliente"]').value;
        var metodoPago = document.querySelector('select[name="metodoPago"]').value;
        var tieneLibros = librosVenta.length > 0;
        
        var botonSubmit = document.querySelector('button[type="submit"]');
        botonSubmit.disabled = !(cliente && metodoPago && tieneLibros);
    }
    
    function validarFormulario(event) {
        if (librosVenta.length === 0) {
            event.preventDefault();
            alert("Debes agregar al menos un libro a la venta");
            return false;
        }
        
        // Agregar datos de libros al formulario como campos ocultos
        var form = document.getElementById("formVenta");
        
        // Limpiar campos ocultos anteriores
        var camposOcultos = form.querySelectorAll('input[name^="libros"]');
        camposOcultos.forEach(campo => campo.remove());
        
        // Agregar nuevos campos ocultos
        librosVenta.forEach(function(libro, index) {
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
        document.getElementById("formVenta").onsubmit = validarFormulario;
        
        // Agregar eventos para verificar formulario completo
        document.querySelector('select[name="cliente"]').addEventListener("change", verificarFormularioCompleto);
        document.querySelector('select[name="metodoPago"]').addEventListener("change", verificarFormularioCompleto);
    });
</script>

<form id="formVenta" action="../content/ventas/ventas_new_commit.php" method="post">
    
    <div class="dato">
        <div class="etiqueta">
            <label for="cliente">Cliente:</label>
        </div>
        <div class="control">
            <select name="cliente" required>
                <option value="">Selecciona un cliente</option>
                <?php
                    mysqli_data_seek($resultCliente, 0);
                    while($row=mysqli_fetch_assoc($resultCliente)){
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
        <h3>📚 Agregar libros a la venta</h3>
        
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
                            $stockInfo = $row3['stock'] > 0 ? " (Stock: ".$row3['stock'].")" : " (Sin stock)";
                    ?>
                    <option value="<?= $row3['id'] ?>" <?= $row3['stock'] <= 0 ? 'disabled' : '' ?>>
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
            <textarea name="comentarios" rows="3" cols="30" placeholder="Comentarios adicionales sobre la venta (opcional)"></textarea>
        </div>
    </div>

    <table class="tabla-venta">
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
        <tbody id="tablaVentaBody">
            <tr>
                <td colspan="6" class="mensaje-vacio">
                    No hay libros agregados a la venta
                </td>
            </tr>
        </tbody>
    </table>

    <div class="total-venta">
        <strong>💰 Total de la venta: <span id="totalVenta">$0.00</span></strong>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label>&nbsp;</label>
        </div>
        <div class="control" id="botones">
            <button type="button" onClick="location.href='../base/index.php?op=50'">❌ Cancelar</button>
            <button type="button" id="botonLimpiar">🗑️ Limpiar venta</button>
            <button type="submit">💳 Realizar venta</button>
        </div>
    </div>
</form>