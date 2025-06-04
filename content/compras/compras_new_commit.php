<?php
include('../../base/bd.php');
include('../../base/global.php');
include('../../base/session.php');


// Obtener datos del formulario
$proveedor = $_POST['proveedor'];
$metodoPago = $_POST['metodoPago'];
$comentarios = isset($_POST['comentarios']) ? $_POST['comentarios'] : '';
$libros = $_POST['libros'];

// Validar que se recibieron datos necesarios
if (empty($proveedor) || empty($metodoPago) || empty($libros)) {
    header('Location: ../../base/index.php?op=40&error=datos_incompletos');
    exit();
}

// Calcular el total de la compra
$totalCompra = 0;
foreach ($libros as $libro) {
    $subtotal = $libro['cantidad'] * $libro['precio'];
    $totalCompra += $subtotal;
}

// Obtener el ID del usuario actual (asumiendo que está en sesión)
$idUsuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 1;

try {
    // Para compras NO necesitamos verificar stock, ya que estamos comprando para aumentarlo
    // Solo verificamos que los libros existan
    foreach ($libros as $libro) {
        $idLibro = $libro['id'];
        
        $consultaLibro = "SELECT id FROM book WHERE id = " . $idLibro . " AND estado != 'bajo'";
        $resultLibro = bd_consulta($consultaLibro);
        
        if (!mysqli_fetch_assoc($resultLibro)) {
            throw new Exception("Libro no encontrado ID: " . $idLibro);
        }
    }
    
    // 1. Insertar la compra principal
    $consultaCompra = "INSERT INTO compras (id_proveedor, id_usuario, fecha_compra, total, id_metodo_pago, estado, comentarios) " .
                     "VALUES (" . $proveedor . ", " . $idUsuario . ", NOW(), " . $totalCompra . ", " . $metodoPago . ", 'activo', '" . $comentarios . "')";
    
    $resultCompra = bd_consulta($consultaCompra);
    
    if (!$resultCompra) {
        throw new Exception("Error al insertar la compra");
    }
    
    // 2. Obtener el ID de la compra recién insertada
    $consultaMaxId = "SELECT MAX(id) as newid FROM compras";
    $resultMaxId = bd_consulta($consultaMaxId);
    $rowMaxId = mysqli_fetch_assoc($resultMaxId);
    $idCompra = $rowMaxId['newid'];
    
    // 3. Insertar los detalles de la compra y actualizar stock
    foreach ($libros as $libro) {
        $idLibro = $libro['id'];
        $cantidad = $libro['cantidad'];
        $precioUnitario = $libro['precio'];
        $subtotal = $cantidad * $precioUnitario;
        
        // Insertar detalle de compra
        $consultaDetalle = "INSERT INTO detalle_compras (id_compra, id_libro, cantidad, precio_unitario, subtotal, estado) " .
                          "VALUES (" . $idCompra . ", " . $idLibro . ", " . $cantidad . ", " . $precioUnitario . ", " . $subtotal . ", 'alto')";
        
        $resultDetalle = bd_consulta($consultaDetalle);
        
        if (!$resultDetalle) {
            throw new Exception("Error al insertar detalle de compra para libro ID: " . $idLibro);
        }
        
        // Actualizar stock del libro (AUMENTAR para compras)
        $consultaActualizarStock = "UPDATE book SET stock = stock + " . $cantidad . " WHERE id = " . $idLibro;
        $resultActualizar = bd_consulta($consultaActualizarStock);
        
        if (!$resultActualizar) {
            throw new Exception("Error al actualizar stock para libro ID: " . $idLibro);
        }
    }
    
    // Redireccionar con éxito
    header('Location: ../../base/index.php?op=40&success=compra_realizada&id_compra=' . $idCompra);
    
} catch (Exception $e) {
    // Log del error (opcional)
    error_log("Error en compras_new_commit.php: " . $e->getMessage());
    
    // Redireccionar con error
    header('Location: ../../base/index.php?op=40&error=error_procesamiento&mensaje=' . urlencode($e->getMessage()));
}
?>