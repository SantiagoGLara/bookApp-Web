<?php
$operacionValida = true;
$idCompra = $_GET['id'];

if($operacionValida == false){
?>
  <h2>Esta operación no se puede llevar a cabo</h2>
<?php
} else {
    try {
        // Verificar que la venta existe y está activa
        $consultaCompra = "SELECT id, estado FROM compras WHERE id = " . $idCompra . " AND estado = 'activo'";
        $resultCompra = bd_consulta($consultaCompra);
        
        if (mysqli_num_rows($resultCompra) == 0) {
            throw new Exception("La compra no existe o ya está cancelada");
        }
        
        // Obtener todos los detalles de la venta para restaurar el stock
        $consultaDetalles = "SELECT id_libro, cantidad FROM detalle_compras WHERE id_compra = " . $idCompra . " AND estado = 'alto'";
        $resultDetalles = bd_consulta($consultaDetalles);
        
        if (!$resultDetalles) {
            throw new Exception("Error al obtener los detalles de la compra");
        }
        
        // Restaurar stock para cada libro vendido
        while ($detalle = mysqli_fetch_assoc($resultDetalles)) {
            $idLibro = $detalle['id_libro'];
            $cantidad = $detalle['cantidad'];
            
            // Actualizar stock del libro (sumar la cantidad que se había vendido)
            $consultaActualizarStock = "UPDATE book SET stock = stock - " . $cantidad . " WHERE id = " . $idLibro;
            $resultActualizar = bd_consulta($consultaActualizarStock);
            
            if (!$resultActualizar) {
                throw new Exception("Error al actualizar stock para libro ID: " . $idLibro);
            }
        }
        
        // Cambiar estado de los detalles de venta a 'bajo'
        $consultaCambiarDetalles = "UPDATE detalle_compras SET estado = 'bajo' WHERE id_compra = " . $idCompra;
        $resultCambiarDetalles = bd_consulta($consultaCambiarDetalles);
        
        if (!$resultCambiarDetalles) {
            throw new Exception("Error al cancelar los detalles de la venta");
        }
        
        // Cambiar estado de la venta a 'cancelado'
        $consultaCancelar = "UPDATE compras SET estado = 'cancelado' WHERE id = " . $idCompra;
        $resultCancelar = bd_consulta($consultaCancelar);
        
        if (!$resultCancelar) {
            throw new Exception("Error al cancelar la compra");
        }
        
?>
  <h2>Se ha cancelado la compra correctamente</h2>
  <p>La compra ID: <?php echo $idCompra; ?> ha sido cancelada y el stock de los libros ha sido reducido.</p>
<?php
        
    } catch (Exception $e) {
        // Log del error
        error_log("Error en compras_delete.php: " . $e->getMessage());
?>
  <h2>Error al cancelar la compra</h2>
  <p><?php echo $e->getMessage(); ?></p>
<?php
    }
}
?>