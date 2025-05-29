<?php
include('../../base/bd.php');
include('../../base/global.php');

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
// Si no tienes sistema de sesiones, puedes usar un valor fijo o modificar según tu sistema
$idUsuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 1;

// Iniciar transacción para asegurar consistencia
mysqli_autocommit($conexion, false);

try {
    // 1. Insertar la venta principal
    $consultaVenta = "INSERT INTO ventas (id_cliente, id_usuario, fecha_venta, total, id_metodo_pago, estado, comentarios) VALUES (?, ?, NOW(), ?, ?, 'activo', ?)";
    
    $stmt = mysqli_prepare($conexion, $consultaVenta);
    mysqli_stmt_bind_param($stmt, "iidis", $cliente, $idUsuario, $totalVenta, $metodoPago, $comentarios);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al insertar la venta: " . mysqli_error($conexion));
    }
    
    // 2. Obtener el ID de la venta recién insertada
    $idVenta = mysqli_insert_id($conexion);
    
    // 3. Insertar los detalles de la venta y actualizar stock
    foreach ($libros as $libro) {
        $idLibro = $libro['id'];
        $cantidad = $libro['cantidad'];
        $precioUnitario = $libro['precio'];
        $subtotal = $cantidad * $precioUnitario;
        
        // Verificar stock disponible antes de proceder
        $consultaStock = "SELECT stock FROM book WHERE id = ? AND estado != 'bajo'";
        $stmtStock = mysqli_prepare($conexion, $consultaStock);
        mysqli_stmt_bind_param($stmtStock, "i", $idLibro);
        mysqli_stmt_execute($stmtStock);
        $resultStock = mysqli_stmt_get_result($stmtStock);
        
        if ($rowStock = mysqli_fetch_assoc($resultStock)) {
            if ($rowStock['stock'] < $cantidad) {
                throw new Exception("Stock insuficiente para el libro ID: " . $idLibro);
            }
        } else {
            throw new Exception("Libro no encontrado ID: " . $idLibro);
        }
        
        // Insertar detalle de venta
        $consultaDetalle = "INSERT INTO detalle_ventas (id_venta, id_libro, cantidad, precio_unitario, subtotal, estado) VALUES (?, ?, ?, ?, ?, 'activo')";
        
        $stmtDetalle = mysqli_prepare($conexion, $consultaDetalle);
        mysqli_stmt_bind_param($stmtDetalle, "iiidd", $idVenta, $idLibro, $cantidad, $precioUnitario, $subtotal);
        
        if (!mysqli_stmt_execute($stmtDetalle)) {
            throw new Exception("Error al insertar detalle de venta: " . mysqli_error($conexion));
        }
        
        // Actualizar stock del libro
        $consultaActualizarStock = "UPDATE book SET stock = stock - ? WHERE id = ?";
        $stmtActualizar = mysqli_prepare($conexion, $consultaActualizarStock);
        mysqli_stmt_bind_param($stmtActualizar, "ii", $cantidad, $idLibro);
        
        if (!mysqli_stmt_execute($stmtActualizar)) {
            throw new Exception("Error al actualizar stock: " . mysqli_error($conexion));
        }
    }
    
    // Confirmar la transacción
    mysqli_commit($conexion);
    
    // Redireccionar con éxito
    header('Location: ../../base/index.php?op=50&success=venta_realizada&id_venta=' . $idVenta);
    
} catch (Exception $e) {
    // Deshacer la transacción en caso de error
    mysqli_rollback($conexion);
    
    // Log del error (opcional)
    error_log("Error en ventas_new_commit.php: " . $e->getMessage());
    
    // Redireccionar con error
    header('Location: ../../base/index.php?op=50&error=error_procesamiento&mensaje=' . urlencode($e->getMessage()));
}

// Restaurar autocommit
mysqli_autocommit($conexion, true);

// Cerrar statements si existen
if (isset($stmt)) mysqli_stmt_close($stmt);
if (isset($stmtStock)) mysqli_stmt_close($stmtStock);
if (isset($stmtDetalle)) mysqli_stmt_close($stmtDetalle);
if (isset($stmtActualizar)) mysqli_stmt_close($stmtActualizar);

// Cerrar conexión
mysqli_close($conexion);
?>