<?php
// Verificar si se proporcionó un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  $operacionValida = false;
  $mensajeError = "ID de usuario no válido.";
} else {
  $idUsuario = (int)$_GET['id'];
  
  // Verificar si el usuario existe y está activo
  $consultaUsuario = "SELECT id, username, nombre, estado FROM usuarios WHERE id = " . $idUsuario;
  $resultUsuario = bd_consulta($consultaUsuario);
  
  if (mysqli_num_rows($resultUsuario) == 0) {
    $operacionValida = false;
    $mensajeError = "El usuario no existe.";
  } else {
    $usuario = mysqli_fetch_assoc($resultUsuario);
    
    if ($usuario['estado'] == 'bajo') {
      $operacionValida = false;
      $mensajeError = "El usuario ya está dado de baja.";
    } else {
      $operacionValida = true;
      
      // Verificar si el usuario tiene ventas relacionadas
      $consultaVentas = "SELECT COUNT(*) as total FROM ventas 
                         WHERE id_usuario = " . $idUsuario . " AND estado = 'activo'";
      $resultVentas = bd_consulta($consultaVentas);
      $ventasCount = mysqli_fetch_assoc($resultVentas)['total'];
      
      if ($ventasCount > 0) {
        $operacionValida = false;
        $mensajeError = "No se puede dar de baja al usuario '" . htmlspecialchars($usuario['nombre']) . "' porque tiene " . $ventasCount . " venta(s) activa(s) registrada(s).";
      }
      
      // Verificar si el usuario tiene compras relacionadas (solo si aún es válida la operación)
      if ($operacionValida) {
        $consultaCompras = "SELECT COUNT(*) as total FROM compras 
                           WHERE id_usuario = " . $idUsuario . " AND estado = 'activo'";
        $resultCompras = bd_consulta($consultaCompras);
        $comprasCount = mysqli_fetch_assoc($resultCompras)['total'];
        
        if ($comprasCount > 0) {
          $operacionValida = false;
          $mensajeError = "No se puede dar de baja al usuario '" . htmlspecialchars($usuario['nombre']) . "' porque tiene " . $comprasCount . " compra(s) activa(s) registrada(s).";
        }
      }
    }
  }
}

if ($operacionValida == false) {
?>
  <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h2 style="color: #d32f2f; margin: 0 0 10px 0;">⚠️ Esta operación no se puede llevar a cabo</h2>
    <p style="margin: 0; color: #666;"><?= isset($mensajeError) ? $mensajeError : "Error desconocido." ?></p>
  </div>
  
  <div style="margin-top: 20px;">
    <a href="../base/index.php?op=80" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        👥 Regresar a la lista de usuarios
      </button>
    </a>
  </div>
<?php
} else {
  // Proceder con la actualización del estado
  $consulta = "UPDATE usuarios SET estado = 'bajo' WHERE id = " . $idUsuario;
  $result = bd_consulta($consulta);
  
  if ($result) {
?>
  <div style="background-color: #e8f5e8; border: 1px solid #4caf50; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h2 style="color: #2e7d32; margin: 0 0 10px 0;">✅ Operación exitosa</h2>
    <p style="margin: 0; color: #666;">
      El usuario "<?= htmlspecialchars($usuario['nombre']) ?>" ha sido dado de baja correctamente.
    </p>
  </div>
  
  <div style="margin-top: 20px;">
    <a href="../base/index.php?op=80" style="text-decoration: none; margin-right: 10px;">
      <button style="margin-left: 10px;">
        👥 Regresar a la lista de usuarios
      </button>
    </a>
    <a href="../base/index.php?op=81" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        + 👤 Agregar nuevo usuario
      </button>
    </a>
  </div>
<?php
  } else {
?>
  <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h3 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error en la operación</h3>
    <p style="margin: 0; color: #666;">
      Ocurrió un error al intentar dar de baja al usuario. Por favor, inténtelo nuevamente.
    </p>
  </div>
  
  <div style="margin-top: 20px;">
    <a href="../base/index.php?op=80" style="text-decoration: none;">
      <button style="margin-left: 10px;">
        👥 Regresar a la lista de usuarios
      </button>
    </a>
  </div>
<?php
  }
}
?>