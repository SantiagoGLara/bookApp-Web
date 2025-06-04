<?php
include('../../base/bd.php');
include('../../base/global.php');
include('../../base/session.php');


// Obtener datos del formulario
$cliente = $_POST['cliente'];
$metodoPago = $_POST['metodoPago'];
$comentarios = isset($_POST['comentarios']) ? $_POST['comentarios'] : '';
$libros = $_POST['libros'];

// Validar que se recibieron datos necesarios
if (empty($cliente) || empty($metodoPago) || empty($libros)) {
    header('Location: ../../base/index.php?op=50&error=datos_incompletos');
    exit();
}

// Calcular el total de la venta
$totalVenta = 0;
foreach ($libros as $libro) {
    $subtotal = $libro['cantidad'] * $libro['precio'];
    $totalVenta += $subtotal;
}

// Obtener el ID del usuario actual (asumiendo que está en sesión)
$idUsuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 1;

try {
    // Verificar stock disponible para todos los libros antes de proceder
    foreach ($libros as $libro) {
        $idLibro = $libro['id'];
        $cantidad = $libro['cantidad'];
        
        $consultaStock = "SELECT stock FROM book WHERE id = " . $idLibro . " AND estado != 'bajo'";
        $resultStock = bd_consulta($consultaStock);
        
        if ($rowStock = mysqli_fetch_assoc($resultStock)) {
            if ($rowStock['stock'] < $cantidad) {
                throw new Exception("Stock insuficiente para el libro ID: " . $idLibro);
            }
        } else {
            throw new Exception("Libro no encontrado ID: " . $idLibro);
        }
    }
    
    // 1. Insertar la venta principal
    $consultaVenta = "INSERT INTO ventas (id_cliente, id_usuario, fecha_venta, total, id_metodo_pago, estado, comentarios) " .
                     "VALUES (" . $cliente . ", " . $idUsuario . ", NOW(), " . $totalVenta . ", " . $metodoPago . ", 'activo', '" . $comentarios . "')";
    
    $resultVenta = bd_consulta($consultaVenta);
    
    if (!$resultVenta) {
        throw new Exception("Error al insertar la venta");
    }
    
    // 2. Obtener el ID de la venta recién insertada
    $consultaMaxId = "SELECT MAX(id) as newid FROM ventas";
    $resultMaxId = bd_consulta($consultaMaxId);
    $rowMaxId = mysqli_fetch_assoc($resultMaxId);
    $idVenta = $rowMaxId['newid'];
    
    // 3. Insertar los detalles de la venta y actualizar stock
    foreach ($libros as $libro) {
        $idLibro = $libro['id'];
        $cantidad = $libro['cantidad'];
        $precioUnitario = $libro['precio'];
        $subtotal = $cantidad * $precioUnitario;
        
        // Insertar detalle de venta
        $consultaDetalle = "INSERT INTO detalle_ventas (id_venta, id_libro, cantidad, precio_unitario, subtotal, estado) " .
                          "VALUES (" . $idVenta . ", " . $idLibro . ", " . $cantidad . ", " . $precioUnitario . ", " . $subtotal . ", 'alto')";
        
        $resultDetalle = bd_consulta($consultaDetalle);
        
        if (!$resultDetalle) {
            throw new Exception("Error al insertar detalle de venta para libro ID: " . $idLibro);
        }
        
        // Actualizar stock del libro
        $consultaActualizarStock = "UPDATE book SET stock = stock - " . $cantidad . " WHERE id = " . $idLibro;
        $resultActualizar = bd_consulta($consultaActualizarStock);
        
        if (!$resultActualizar) {
            throw new Exception("Error al actualizar stock para libro ID: " . $idLibro);
        }
    }
    
    // Redireccionar con éxito
    header('Location: ../../base/index.php?op=50&success=venta_realizada&id_venta=' . $idVenta);
    
} catch (Exception $e) {
    // Log del error (opcional)
    error_log("Error en ventas_new_commit.php: " . $e->getMessage());
    
    // Redireccionar con error
    header('Location: ../../base/index.php?op=50&error=error_procesamiento&mensaje=' . urlencode($e->getMessage()));
}
?>