<?php
include('../../base/bd.php');
include('../../base/global.php');

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$numcelular = $_POST['numcelular'];
$email = $_POST['email'];
$estado = $_POST['estado'];
$id = $_POST['id'];

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

// Validar que el ID sea válido
if (empty($id) || !is_numeric($id)) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error de validación</h2>
        <p style="margin: 0; color: #666;">ID de proveedor inválido.</p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="../../base/index.php?op=30" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                👥 Ver lista de proveedores
            </button>
        </a>
    </div>
    <?php
    exit;
}

// Verificar si ya existe otro proveedor con el mismo nombre y estado "alto" (excluyendo el actual)
if ($estado == 'alto') {
    $consultaExistencia = "SELECT COUNT(*) as total FROM proveedores 
                           WHERE nombre = '$nombre' AND estado = 'alto' AND id != $id";
    $resultExistencia = bd_consulta($consultaExistencia);
    $rowExistencia = mysqli_fetch_assoc($resultExistencia);

    if ($rowExistencia['total'] > 0) {
        ?>
        <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
            <h2 style="color: #d32f2f; margin: 0 0 10px 0;">⚠️ Proveedor duplicado</h2>
            <p style="margin: 0; color: #666;">Ya existe otro proveedor activo con el nombre "<strong><?= htmlspecialchars($nombre) ?></strong>".</p>
            <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
                <em>Por favor, verifique el nombre o modifique la información para evitar duplicados.</em>
            </p>
        </div>
        
        <div style="margin-top: 20px;">
            <a href="javascript:history.back()" style="text-decoration: none; margin-right: 10px;">
                <button style="margin-left: 10px;">
                    Regresar al formulario
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
}

// Verificar que el proveedor existe antes de actualizar
$consultaExiste = "SELECT COUNT(*) as total FROM proveedores WHERE id = $id";
$resultExiste = bd_consulta($consultaExiste);
$rowExiste = mysqli_fetch_assoc($resultExiste);

if ($rowExiste['total'] == 0) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Proveedor no encontrado</h2>
        <p style="margin: 0; color: #666;">El proveedor que intenta modificar no existe en la base de datos.</p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="../../base/index.php?op=30" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                👥 Ver lista de proveedores
            </button>
        </a>
    </div>
    <?php
    exit;
}

// Actualizar proveedor
$consulta = 'UPDATE proveedores SET nombre="' . $nombre . '", numcelular="' . $numcelular . 
            '", email="' . $email . '", estado="' . $estado . '" WHERE id=' . $id;

$result = bd_consulta($consulta);

if ($result) {
    ?>
    <div style="background-color: #e8f5e8; border: 1px solid #4caf50; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #2e7d32; margin: 0 0 10px 0;">✅ Proveedor modificado exitosamente</h2>
        <p style="margin: 0; color: #666;">
            El proveedor "<strong><?= htmlspecialchars($nombre) ?></strong>" ha sido actualizado correctamente.
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
                + 👤 Agregar nuevo proveedor
            </button>
        </a>
    </div>
    <?php
} else {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error al modificar proveedor</h2>
        <p style="margin: 0; color: #666;">No se pudo actualizar la información del proveedor en la base de datos.</p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="javascript:history.back()" style="text-decoration: none; margin-right: 10px;">
            <button style="margin-left: 10px;">
                Regresar al formulario
            </button>
        </a>
        <a href="../../base/index.php?op=30" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                👥 Ver lista de proveedores
            </button>
        </a>
    </div>
    <?php
}
?>