<?php
// Verificar si se proporcionó un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  $operacionValida = false;
  $mensajeError = "ID de proveedor no válido.";
} else {
  $idProveedor = (int)$_GET['id'];
  
  // Verificar si el proveedor existe y está activo
  $consultaProveedor = "SELECT id, nombre, estado FROM proveedores WHERE id = " . $idProveedor;
  $resultProveedor = bd_consulta($consultaProveedor);
  
  if (mysqli_num_rows($resultProveedor) == 0) {
    $operacionValida = false;
    $mensajeError = "El proveedor no existe.";
  } else {
    $proveedor = mysqli_fetch_assoc($resultProveedor);
    
    if ($proveedor['estado'] == 'bajo') {
      $operacionValida = false;
      $mensajeError = "El proveedor ya está dado de baja.";
    } else {
      // Verificar si el proveedor tiene compras relacionadas a través de detalle_compras
      $consultaCompras = "SELECT COUNT(*) as total FROM detalle_compras dc 
                         INNER JOIN compras c ON dc.id_compra = c.id 
                         WHERE c.id_proveedor = " . $idProveedor . " AND dc.estado = 'alto'";
      $resultCompras = bd_consulta($consultaCompras);
      $comprasCount = mysqli_fetch_assoc($resultCompras)['total'];
      
      if ($comprasCount > 0) {
        $operacionValida = false;
        $mensajeError = "No se puede dar de baja al proveedor '" . htmlspecialchars($proveedor['nombre']) . "' porque tiene " . $comprasCount . " compra(s) relacionada(s).";
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
    <a href="../base/index.php?op=30" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        👥 Regresar a la lista de proveedores
      </button>
    </a>
  </div>
<?php
} else {
  // Proceder con la actualización del estado
  $consulta = "UPDATE proveedores SET estado = 'bajo' WHERE id = " . $idProveedor;
  $result = bd_consulta($consulta);
  
  if ($result) {
?>
  <div style="background-color: #e8f5e8; border: 1px solid #4caf50; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h2 style="color: #2e7d32; margin: 0 0 10px 0;">✅ Operación exitosa</h2>
    <p style="margin: 0; color: #666;">
      El proveedor "<?= htmlspecialchars($proveedor['nombre']) ?>" ha sido dado de baja correctamente.
    </p>
  </div>
  
  <div style="margin-top: 20px;">
    <a href="../base/index.php?op=30" style="text-decoration: none; margin-right: 10px;">
      <button style="margin-left: 10px;">
        👥 Regresar a la lista de proveedores
      </button>
    </a>
    <a href="../base/index.php?op=31" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        + 👤 Agregar nuevo proveedor
      </button>
    </a>
  </div>
<?php
  } else {
?>
  <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h3 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error en la operación</h3>
    <p style="margin: 0; color: #666;">
      Ocurrió un error al intentar dar de baja al proveedor. Por favor, inténtelo nuevamente.
    </p>
  </div>
  
  <div style="margin-top: 20px;">
    <a href="../base/index.php?op=30" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        👥 Regresar a la lista de proveedores
      </button>
    </a>
  </div>
<?php
  }
}
?>