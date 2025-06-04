<?php
include('../../base/bd.php');

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$numcelular = $_POST['numcelular'];
$email = $_POST['email'];
$estado = "alto";

// Validación básica
if (empty($nombre)) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error de validación</h2>
        <p style="margin: 0; color: #666;">El nombre del proveedor es obligatorio.</p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="javascript:history.back()" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                Regresar al formulario
            </button>
        </a>
    </div>
    <?php
    exit;
}

// Verificar si ya existe un proveedor con el mismo nombre y estado "alto"
$consultaExistencia = "SELECT COUNT(*) as total FROM proveedores 
                       WHERE nombre = '$nombre' AND estado = 'alto'";
$resultExistencia = bd_consulta($consultaExistencia);
$rowExistencia = mysqli_fetch_assoc($resultExistencia);

if ($rowExistencia['total'] > 0) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">⚠️ Proveedor duplicado</h2>
        <p style="margin: 0; color: #666;">Ya existe un proveedor activo con el nombre "<strong><?= htmlspecialchars($nombre) ?></strong>".</p>
        <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
            <em>Por favor, verifique el nombre o modifique la información para evitar duplicados.</em>
        </p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="javascript:history.back()" style="text-decoration: none; margin-right: 10px;">
            <button style="margin-left: 10px;">
                ← Regresar al formulario
            </button>
        </a>
        <a href="../../base/index.php?op=30" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                👥 Ver lista de proveedores
            </button>
        </a>
    </div>
    <?php
    exit;
}

// Insertar proveedor
$consulta = 'INSERT INTO proveedores (nombre, numcelular, email, fecha_alta, estado) VALUES (' .
  '"' . $nombre . '","' . $numcelular . '","' . $email . '",CURDATE(),"' . $estado . '")';

$result = bd_consulta($consulta);

if ($result) {
    ?>
    <div style="background-color: #e8f5e8; border: 1px solid #4caf50; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #2e7d32; margin: 0 0 10px 0;">✅ Proveedor agregado exitosamente</h2>
        <p style="margin: 0; color: #666;">
            El proveedor "<strong><?= htmlspecialchars($nombre) ?></strong>" ha sido agregado correctamente.
        </p>
    </div>

    <div style="margin-top: 20px;">
        <a href="../../base/index.php?op=30" style="text-decoration: none; margin-right: 10px;">
            <button style="margin-left: 10px;">
                👥 Ver lista de proveedores
            </button>
        </a>
        <a href="../../base/index.php?op=31" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                + 👤 Agregar otro proveedor
            </button>
        </a>
    </div>
    <?php
} else {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error al agregar proveedor</h2>
        <p style="margin: 0; color: #666;">No se pudo agregar el proveedor a la base de datos.</p>
        <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
            <em>Error: <?= htmlspecialchars(mysqli_error($bd)) ?></em>
        </p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="javascript:history.back()" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                ← Regresar al formulario
            </button>
        </a>
    </div>
    <?php
}
?>