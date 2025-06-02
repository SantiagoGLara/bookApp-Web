<?php
  // Verificar si se proporcionó un ID válido
  if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $operacionValida = false;
    $mensajeError = "ID de libro no válido.";
  } else {
    $idLibro = (int)$_GET['id'];
    
    // Verificar si el libro existe y está activo
    $consultaLibro = "SELECT id, titulo, estado FROM book WHERE id = " . $idLibro;
    $resultLibro = bd_consulta($consultaLibro);
    
    if (mysqli_num_rows($resultLibro) == 0) {
      $operacionValida = false;
      $mensajeError = "El libro no existe.";
    } else {
      $libro = mysqli_fetch_assoc($resultLibro);
      
      if ($libro['estado'] == 'bajo') {
        $operacionValida = false;
        $mensajeError = "El libro ya está dado de baja.";
      } else {
        // Verificar si el libro tiene ventas relacionadas
        $consultaVentas = "SELECT COUNT(*) as total FROM detalle_ventas WHERE id_libro = " . $idLibro . " AND estado = 'alto'";
        $resultVentas = bd_consulta($consultaVentas);
        $ventasCount = mysqli_fetch_assoc($resultVentas)['total'];
        
        // Verificar si el libro tiene compras relacionadas
        $consultaCompras = "SELECT COUNT(*) as total FROM detalle_compras WHERE id_libro = " . $idLibro . " AND estado = 'alto'";
        $resultCompras = bd_consulta($consultaCompras);
        $comprasCount = mysqli_fetch_assoc($resultCompras)['total'];
        
        if ($ventasCount > 0 || $comprasCount > 0) {
          $operacionValida = false;
          $mensajeError = "No se puede dar de baja el libro '" . htmlspecialchars($libro['titulo']) . "' porque tiene ";
          
          if ($ventasCount > 0 && $comprasCount > 0) {
            $mensajeError .= $ventasCount . " venta(s) y " . $comprasCount . " compra(s) relacionada(s).";
          } elseif ($ventasCount > 0) {
            $mensajeError .= $ventasCount . " venta(s) relacionada(s).";
          } else {
            $mensajeError .= $comprasCount . " compra(s) relacionada(s).";
          }
        } else {
          $operacionValida = true;
        }
      }
    }
  }

  if ($operacionValida == false) {
?>
  <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h2 style="color: #d32f2f; margin: 0 10px 10px 0;">⚠️ Esta operación no se puede llevar a cabo</h2>
    <p style="margin: 0; color: #666;"><?= isset($mensajeError) ? $mensajeError : "Error desconocido." ?></p>
  </div>
  
  <div style="margin-top: 20px;">
    <a href="../base/index.php?op=10" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        Regresar a la lista de libros
      </button>
    </a>
  </div>
<?php
  } else {
    // Proceder con la actualización del estado
    $consulta = "UPDATE book SET estado = 'bajo' WHERE id = " . $idLibro;
    $result = bd_consulta($consulta);
    
    if ($result) {
?>
  <div style="background-color: #e8f5e8; border: 1px solid #4caf50; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h2 style="color: #2e7d32; margin: 0 0 10px 0;">✅ Operación exitosa</h2>
    <p style="margin: 0; color: #666;">
      El libro "<?= htmlspecialchars($libro['titulo']) ?>" ha sido dado de baja correctamente.
    </p>
    <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
      <em>Nota: El libro no ha sido eliminado, solo se ha cambiado su estado a "bajo".</em>
    </p>
  </div>
  
  <div style="margin-top: 20px;">
    <a href="../base/index.php?op=10" style="text-decoration: none; margin-right: 10px;">
      <button style="margin-left: 10px;">
        Regresar a la lista de libros
      </button>
    </a>
    <a href="../base/index.php?op=11" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        + &#128218; Agregar nuevo libro
      </button>
    </a>
  </div>
<?php
    } else {
?>
  <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h3 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error en la operación</h3>
    <p style="margin: 0; color: #666;">
      Ocurrió un error al intentar dar de baja el libro. Por favor, inténtelo nuevamente.
    </p>
  </div>
  
  <div style="margin-top: 20px;">
    <a href="../base/index.php?op=10" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        Regresar a la lista de libros
      </button>
    </a>
  </div>
<?php
    }
  }
?>