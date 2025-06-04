<?php
include('../../base/bd.php');
include('../../base/global.php');
include('../../base/session.php');

// Definir rutas constantes
define('PORTADAS_DIR', '../../resources/portadas/');
define('CONTRAPORTADAS_DIR', '../../resources/contraportadas/');

// Obtener datos del formulario de forma directa
$titulo = $_POST['titulo'];
$tipo = $_POST['tipo'];
$numPagina = $_POST['numpagina'];
$editorial = $_POST['editorial'];
$isbn = $_POST['isbn'];
$pais = $_POST['pais'];
$dimension = $_POST['dimension'];
$lenguaje = $_POST['lenguaje'];
$sobrecubierta = isset($_POST['sobrecubierta']) && $_POST['sobrecubierta'] == "on" ? 1 : 0;
$tipoPasta = isset($_POST['tipo_pasta']) ? $_POST['tipo_pasta'] : 0;
$resumen = $_POST['resumen'];
$autor = $_POST['autor'];
$precio = $_POST['precio'];
$estado = "alto";
$portada = null;
$contraportada = null;

// Validación básica simplificada
if (empty($titulo) || empty($isbn) || empty($autor) || empty($editorial)) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error de validación</h2>
        <p style="margin: 0; color: #666;">Todos los campos obligatorios deben ser completados (Título, ISBN, Autor, Editorial).</p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="javascript:history.back()" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                ← Regresar al formulario
            </button>
        </a>
    </div>
    <?php
    exit;
}

// Verificar duplicados de forma simplificada
$consultaExistencia = "SELECT COUNT(*) as total FROM book 
                       WHERE titulo = '$titulo' AND autor = $autor AND editorial = $editorial OR isbn = '$isbn' AND estado = 'alto'";
$resultExistencia = bd_consulta($consultaExistencia);
$rowExistencia = mysqli_fetch_assoc($resultExistencia);

if ($rowExistencia['total'] > 0) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">⚠️ Libro duplicado</h2>
        <p style="margin: 0; color: #666;">Ya existe un libro con la misma información en la base de datos.</p>
        <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
            <em>Por favor, verifique los datos o modifique la información para evitar duplicados.</em>
        </p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="javascript:history.back()">
            <button style="margin-left: 10px;">
                Regresar al formulario
            </button>
        </a>
        <a href="../base/index.php?op=10" style="text-decoration: none; margin-right: 10px;">
          <button style="margin-left: 10px;">
            Regresar a la lista de libros
          </button>
        </a>
    </div>
    <?php
    exit;
}

// Procesar portada si existe
if (isset($_FILES['portada']) && $_FILES['portada']['error'] == 0) {
    $extension = strtolower(pathinfo($_FILES['portada']['name'], PATHINFO_EXTENSION));
    $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    
    if (in_array($extension, $extensionesPermitidas)) {
        $portada = "temp_portada." . $extension;
    }
}

// Procesar contraportada si existe
if (isset($_FILES['contraportada']) && $_FILES['contraportada']['error'] == 0) {
    $extension = strtolower(pathinfo($_FILES['contraportada']['name'], PATHINFO_EXTENSION));
    $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    
    if (in_array($extension, $extensionesPermitidas)) {
        $contraportada = "temp_contraportada." . $extension;
    }
}

// Insertar libro con nombres temporales de imágenes
$consulta = "INSERT INTO book (titulo, tipo, paginas, editorial, isbn, pais, dimensiones, idioma, sobrecubierta, pasta_dura, resumen, precio, stock, autor, estado, imagen_portada, imagen_contraportada) 
             VALUES ('$titulo', $tipo, $numPagina, $editorial, '$isbn', $pais, '$dimension', $lenguaje, $sobrecubierta, $tipoPasta, '$resumen', $precio, 0, $autor, '$estado', " . 
             ($portada ? "'$portada'" : "NULL") . ", " . ($contraportada ? "'$contraportada'" : "NULL") . ")";

bd_consulta($consulta);

// Obtener ID del nuevo libro
$consulta2 = 'SELECT LAST_INSERT_ID() as newid';
$result2 = bd_consulta($consulta2);
$row = mysqli_fetch_assoc($result2);
$newId = $row['newid'];

// Procesar y renombrar portada con ID real
if (isset($_FILES['portada'])) {
    $extension = strtolower(pathinfo($_FILES['portada']['name'], PATHINFO_EXTENSION));
    $nombrePortada = $newId . "_portada." . $extension;
    $destinoPortada = PORTADAS_DIR . $nombrePortada;
    
    if (!file_exists(PORTADAS_DIR)) {
        mkdir(PORTADAS_DIR, 0777, true);
    }
    
    if (move_uploaded_file($_FILES['portada']['tmp_name'], $destinoPortada)) {
        $consulta3 = "UPDATE book SET imagen_portada='$nombrePortada' WHERE id=$newId";
        bd_consulta($consulta3);
    }
}

// Procesar y renombrar contraportada con ID real
if (isset($_FILES['contraportada'])) {
    $extension = strtolower(pathinfo($_FILES['contraportada']['name'], PATHINFO_EXTENSION));
    $nombreContraportada = $newId . "_contraportada." . $extension;
    $destinoContraportada = CONTRAPORTADAS_DIR . $nombreContraportada;
    
    if (!file_exists(CONTRAPORTADAS_DIR)) {
        mkdir(CONTRAPORTADAS_DIR, 0777, true);
    }
    
    if (move_uploaded_file($_FILES['contraportada']['tmp_name'], $destinoContraportada)) {
        $consulta4 = "UPDATE book SET imagen_contraportada='$nombreContraportada' WHERE id=$newId";
        bd_consulta($consulta4);
    }
}

// Mostrar mensaje de éxito
?>
<div style="background-color: #e8f5e8; border: 1px solid #4caf50; padding: 15px; margin: 10px 0; border-radius: 4px;">
    <h2 style="color: #2e7d32; margin: 0 0 10px 0;">✅ Libro agregado exitosamente</h2>
    <p style="margin: 0; color: #666;">
        El libro "<strong><?= htmlspecialchars($titulo) ?></strong>" ha sido agregado correctamente con ID: <strong><?= $newId ?></strong>
    </p>
    <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
        <em>Redirigiendo automáticamente en 3 segundos...</em>
    </p>
</div>

<div style="margin-top: 20px;">
    <a href="../../base/index.php?op=10" style="text-decoration: none; margin-right: 10px;">
        <button style="margin-left: 10px;">
            📖 Ver lista de libros
        </button>
    </a>
    <a href="../../base/index.php?op=11" style="text-decoration: none;">
        <button style="margin-left: 10px;">
            + 📚 Agregar otro libro
        </button>
    </a>
</div>

<script>
setTimeout(function() { 
    window.location.href = '../../base/index.php?op=10'; 
}, 3000);
</script>
<?php

// Redireccionar
header('refresh:3;url=../../base/index.php?op=10');
?>