<?php
// Verificar si se proporcionó un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  $operacionValida = false;
  $mensajeError = "ID de cliente no válido.";
} else {
  $idCliente = (int)$_GET['id'];
  
  // Verificar si el cliente existe y está activo
  $consultaCliente = "SELECT id, nombre, estado FROM clientes WHERE id = " . $idCliente;
  $resultCliente = bd_consulta($consultaCliente);
  
  if (mysqli_num_rows($resultCliente) == 0) {
    $operacionValida = false;
    $mensajeError = "El cliente no existe.";
  } else {
    $cliente = mysqli_fetch_assoc($resultCliente);
    
    if ($cliente['estado'] == 'bajo') {
      $operacionValida = false;
      $mensajeError = "El cliente ya está dado de baja.";
    } else {
      // Verificar si el cliente tiene ventas relacionadas a través de detalle_ventas
      $consultaVentas = "SELECT COUNT(*) as total FROM detalle_ventas dv 
                         INNER JOIN ventas v ON dv.id_venta = v.id 
                         WHERE v.id_cliente = " . $idCliente . " AND dv.estado = 'alto'";
      $resultVentas = bd_consulta($consultaVentas);
      $ventasCount = mysqli_fetch_assoc($resultVentas)['total'];
      
      if ($ventasCount > 0) {
        $operacionValida = false;
        $mensajeError = "No se puede dar de baja al cliente '" . htmlspecialchars($cliente['nombre']) . "' porque tiene " . $ventasCount . " venta(s) relacionada(s).";
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
    <a href="../base/index.php?op=20" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        👥 Regresar a la lista de clientes
      </button>
    </a>
  </div>
<?php
} else {
  // Proceder con la actualización del estado
  $consulta = "UPDATE clientes SET estado = 'bajo' WHERE id = " . $idCliente;
  $result = bd_consulta($consulta);
  
  if ($result) {
?>
  <div style="background-color: #e8f5e8; border: 1px solid #4caf50; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h2 style="color: #2e7d32; margin: 0 0 10px 0;">✅ Operación exitosa</h2>
    <p style="margin: 0; color: #666;">
      El cliente "<?= htmlspecialchars($cliente['nombre']) ?>" ha sido dado de baja correctamente.
    </p>
    <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
      <em>Nota: El cliente no ha sido eliminado, solo se ha cambiado su estado a "bajo".</em>
    </p>
  </div>
  
  <div style="margin-top: 20px;">
    <a href="../base/index.php?op=20" style="text-decoration: none; margin-right: 10px;">
      <button style="margin-left: 10px;">
        👥 Regresar a la lista de clientes
      </button>
    </a>
    <a href="../base/index.php?op=21" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        + 👤 Agregar nuevo cliente
      </button>
    </a>
  </div>
<?php
  } else {
?>
  <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h3 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error en la operación</h3>
    <p style="margin: 0; color: #666;">
      Ocurrió un error al intentar dar de baja al cliente. Por favor, inténtelo nuevamente.
    </p>
  </div>
  
  <div style="margin-top: 20px;">
    <a href="../base/index.php?op=20" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        👥 Regresar a la lista de clientes
      </button>
    </a>
  </div>
<?php
  }
}
?>