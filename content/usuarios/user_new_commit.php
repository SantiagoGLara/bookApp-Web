<?php
include('../../base/bd.php');

// Obtener datos del formulario
$username = $_POST['username'];
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$estado = "alto";

// Validación básica - Username obligatorio
if (empty($username)) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error de validación</h2>
        <p style="margin: 0; color: #666;">El nombre de usuario es obligatorio.</p>
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

// Validación básica - Nombre obligatorio
if (empty($nombre)) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error de validación</h2>
        <p style="margin: 0; color: #666;">El nombre completo es obligatorio.</p>
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

// Validación básica - Password obligatorio
if (empty($password)) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error de validación</h2>
        <p style="margin: 0; color: #666;">La contraseña es obligatoria.</p>
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

// Verificar si ya existe un usuario con el mismo username y estado "alto"
$consultaExistencia = "SELECT COUNT(*) as total FROM usuarios 
                       WHERE username = '$username' AND estado = 'alto'";
$resultExistencia = bd_consulta($consultaExistencia);
$rowExistencia = mysqli_fetch_assoc($resultExistencia);

if ($rowExistencia['total'] > 0) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">⚠️ Usuario duplicado</h2>
        <p style="margin: 0; color: #666;">Ya existe un usuario activo con el nombre de usuario "<strong><?= htmlspecialchars($username) ?></strong>".</p>
        <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
            <em>Por favor, elija un nombre de usuario diferente.</em>
        </p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="javascript:history.back()" style="text-decoration: none; margin-right: 10px;">
            <button style="margin-left: 10px;">
                Regresar al formulario
            </button>
        </a>
        <a href="../../base/index.php?op=80" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                👥 Ver lista de usuarios
            </button>
        </a>
    </div>
    <?php
    exit;
}

// Insertar usuario
$consulta = 'INSERT INTO usuarios (username, nombre, password, estado) VALUES (' .
  '"' . $username . '","' . $nombre . '","' . $password . '","' . $estado . '")';

$result = bd_consulta($consulta);

if ($result) {
    ?>
    <div style="background-color: #e8f5e8; border: 1px solid #4caf50; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #2e7d32; margin: 0 0 10px 0;">✅ Usuario agregado exitosamente</h2>
        <p style="margin: 0; color: #666;">
            El usuario "<strong><?= htmlspecialchars($username) ?></strong>" (<strong><?= htmlspecialchars($nombre) ?></strong>) ha sido agregado correctamente.
        </p>
    </div>

    <div style="margin-top: 20px;">
        <a href="../../base/index.php?op=80" style="text-decoration: none; margin-right: 10px;">
            <button style="margin-left: 10px;">
                👥 Ver lista de usuarios
            </button>
        </a>
        <a href="../../base/index.php?op=81" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                + 👤 Agregar otro usuario
            </button>
        </a>
    </div>
    <?php
} else {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error al agregar usuario</h2>
        <p style="margin: 0; color: #666;">No se pudo agregar el usuario a la base de datos.</p>
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