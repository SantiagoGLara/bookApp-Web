<?php
$operacionValida = true;
$idVenta = $_GET['id'];

if($operacionValida == false){
?>
  <h2>Esta operación no se puede llevar a cabo</h2>
<?php
} else {
    try {
        // Verificar que la venta existe y está activa
        $consultaVenta = "SELECT id, estado FROM ventas WHERE id = " . $idVenta . " AND estado = 'activo'";
        $resultVenta = bd_consulta($consultaVenta);
        
        if (mysqli_num_rows($resultVenta) == 0) {
            throw new Exception("La venta no existe o ya está cancelada");
        }
        
        // Obtener todos los detalles de la venta para restaurar el stock
        $consultaDetalles = "SELECT id_libro, cantidad FROM detalle_ventas WHERE id_venta = " . $idVenta . " AND estado = 'alto'";
        $resultDetalles = bd_consulta($consultaDetalles);
        
        if (!$resultDetalles) {
            throw new Exception("Error al obtener los detalles de la venta");
        }
        
        // Restaurar stock para cada libro vendido
        while ($detalle = mysqli_fetch_assoc($resultDetalles)) {
            $idLibro = $detalle['id_libro'];
            $cantidad = $detalle['cantidad'];
            
            // Actualizar stock del libro (sumar la cantidad que se había vendido)
            $consultaActualizarStock = "UPDATE book SET stock = stock + " . $cantidad . " WHERE id = " . $idLibro;
            $resultActualizar = bd_consulta($consultaActualizarStock);
            
            if (!$resultActualizar) {
                throw new Exception("Error al actualizar stock para libro ID: " . $idLibro);
            }
        }
        
        // Cambiar estado de los detalles de venta a 'bajo'
        $consultaCambiarDetalles = "UPDATE detalle_ventas SET estado = 'bajo' WHERE id_venta = " . $idVenta;
        $resultCambiarDetalles = bd_consulta($consultaCambiarDetalles);
        
        if (!$resultCambiarDetalles) {
            throw new Exception("Error al cancelar los detalles de la venta");
        }
        
        // Cambiar estado de la venta a 'cancelado'
        $consultaCancelar = "UPDATE ventas SET estado = 'cancelado' WHERE id = " . $idVenta;
        $resultCancelar = bd_consulta($consultaCancelar);
        
        if (!$resultCancelar) {
            throw new Exception("Error al cancelar la venta");
        }
        
?>
  <h2>Se ha cancelado la venta correctamente</h2>
  <p>La venta ID: <?php echo $idVenta; ?> ha sido cancelada y el stock de los libros ha sido restaurado.</p>
<?php
        
    } catch (Exception $e) {
        // Log del error
        error_log("Error en ventas_delete.php: " . $e->getMessage());
?>
  <h2>Error al cancelar la venta</h2>
  <p><?php echo $e->getMessage(); ?></p>
<?php
    }
}
?>