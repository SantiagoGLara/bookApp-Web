<?php
include('../../base/bd.php');
include('../../base/global.php');

// Obtener datos del formulario
$titulo = $_POST['titulo'];
$tipo = $_POST['tipo'];
$numPagina = $_POST['numpagina'];
$editorial = $_POST['editorial'];
$isbn = $_POST['isbn'];
$pais = $_POST['pais'];
$dimension = $_POST['dimension'];
$lenguaje = $_POST['lenguaje'];
$sobrecubierta = $_POST['sobrecubierta'] == "on" ? 1 : 0;
$tipoPasta = $_POST['tipo_pasta'];
$resumen = $_POST['resumen'];
$autor = $_POST['autor'];
$precio = $_POST['precio'];
$estado = $_POST['estado'];
$id = $_POST['id'];

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
                Regresar al formulario
            </button>
        </a>
    </div>
    <?php
    exit;
}

// Verificar duplicados excluyendo el libro actual
$consultaExistencia = "SELECT COUNT(*) as total FROM book 
                       WHERE (titulo = '$titulo' AND autor = $autor AND editorial = $editorial OR isbn = '$isbn') 
                       AND estado = 'alto' AND id != $id";
$resultExistencia = bd_consulta($consultaExistencia);
$rowExistencia = mysqli_fetch_assoc($resultExistencia);

if ($rowExistencia['total'] > 0) {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">⚠️ Libro duplicado</h2>
        <p style="margin: 0; color: #666;">Ya existe otro libro con la misma información en la base de datos.</p>
        <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
            <em>Por favor, verifique los datos o modifique la información para evitar duplicados.</em>
        </p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="javascript:history.back()" style="text-decoration: none; margin-right: 10px;">
            <button style="margin-left: 10px;">
                Regresar al formulario
            </button>
        </a>
        <a href="../../base/index.php?op=10" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                Ver lista de libros
            </button>
        </a>
    </div>
    <?php
    exit;
}

// Obtener imágenes actuales
$consulta = "SELECT imagen_portada, imagen_contraportada from book where id=" . $id;
$result = bd_consulta($consulta);
$row = mysqli_fetch_assoc($result);

// Procesar portada si se subió una nueva
if (isset($_FILES['portada']) && $_FILES['portada']['error'] == 0) {
    $extension = strtolower(pathinfo($_FILES['portada']['name'], PATHINFO_EXTENSION));
    $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    
    if (in_array($extension, $extensionesPermitidas)) {
        $nombrePortada = $id . "_portada." . $extension;
        $destinoPortada = "../../resources/portadas/" . $nombrePortada;
        
        if (!file_exists("../../resources/portadas/")) {
            mkdir("../../resources/portadas/", 0777, true);
        }
        
        if (move_uploaded_file($_FILES['portada']['tmp_name'], $destinoPortada)) {
            $portada = $nombrePortada;
        } else {
            $portada = $row['imagen_portada'];
        }
    } else {
        $portada = $row['imagen_portada'];
    }
} else {
    $portada = $row['imagen_portada'];
}

// Procesar contraportada si se subió una nueva
if (isset($_FILES['contraportada']) && $_FILES['contraportada']['error'] == 0) {
    $extension = strtolower(pathinfo($_FILES['contraportada']['name'], PATHINFO_EXTENSION));
    $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    
    if (in_array($extension, $extensionesPermitidas)) {
        $nombreContraportada = $id . "_contraportada." . $extension;
        $destinoContraportada = "../../resources/contraportadas/" . $nombreContraportada;
        
        if (!file_exists("../../resources/contraportadas/")) {
            mkdir("../../resources/contraportadas/", 0777, true);
        }
        
        if (move_uploaded_file($_FILES['contraportada']['tmp_name'], $destinoContraportada)) {
            $contraportada = $nombreContraportada;
        } else {
            $contraportada = $row['imagen_contraportada'];
        }
    } else {
        $contraportada = $row['imagen_contraportada'];
    }
} else {
    $contraportada = $row['imagen_contraportada'];
}

// Actualizar libro
$consulta = "UPDATE book SET titulo='$titulo', tipo=$tipo, paginas=$numPagina, editorial=$editorial, isbn='$isbn', 
             pais=$pais, dimensiones='$dimension', idioma=$lenguaje, sobrecubierta=$sobrecubierta, pasta_dura=$tipoPasta, 
             resumen='$resumen', precio=$precio, autor=$autor, imagen_portada='$portada', 
             imagen_contraportada='$contraportada', estado='$estado' WHERE id=$id";

$result = bd_consulta($consulta);

if ($result) {
    ?>
    <div style="background-color: #e8f5e8; border: 1px solid #4caf50; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #2e7d32; margin: 0 0 10px 0;">✅ Libro modificado exitosamente</h2>
        <p style="margin: 0; color: #666;">
            El libro "<strong><?= htmlspecialchars($titulo) ?></strong>" ha sido actualizado correctamente.
        </p>
    </div>

    <div style="margin-top: 20px;">
        <a href="../../base/index.php?op=10" style="text-decoration: none; margin-right: 10px;">
            <button style="margin-left: 10px;">
                Ver lista de libros
            </button>
        </a>
        <a href="../../base/index.php?op=11" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                + 📚 Agregar nuevo libro
            </button>
        </a>
    </div>
    <?php
} else {
    ?>
    <div style="background-color: #ffebee; border: 1px solid #f44336; padding: 15px; margin: 10px 0; border-radius: 4px;">
        <h2 style="color: #d32f2f; margin: 0 0 10px 0;">❌ Error al modificar</h2>
        <p style="margin: 0; color: #666;">No se pudo actualizar el libro en la base de datos.</p>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="javascript:history.back()" style="text-decoration: none;">
            <button style="margin-left: 10px;">
                Regresar al formulario
            </button>
        </a>
    </div>
    <?php
}
?>