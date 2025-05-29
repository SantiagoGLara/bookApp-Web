<?php
$idProveedor=$_GET['id'];
$consulta = "SELECT * FROM proveedores WHERE estado!='bajo' AND id = " . $idProveedor;
$resultado = bd_consulta($consulta);
$rowBook = mysqli_fetch_assoc($resultado);
?>

<form class="" action="../content/proveedores/provider_modify_commit.php" method="post" enctype="multipart/form-data">

    <div class="dato">
        <div class="etiqueta">
            <label for="id">ID del Proveedor:</label>
        </div>
        <div class="control">
            <input type="text" name="id" value="<?= $rowBook['id'] ?>" readonly>
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="Nombre">Nombre:</label>
        </div>
        <div class="control">
            <input type="text" name="nombre" value="<?= $rowBook['nombre']  ?>">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="numtel">Numero de Telefono:</label>
        </div>
        <div class="control">
            <input type="text" name="numcelular" pattern="[0-9]{10}" 
            title="Por favor, introduce solo números (10 caracteres exactos)" placeholder="0000000000" 
            value="<?= $rowBook['numcelular']  ?>">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="email">Correo electronico:</label>
        </div>
        <div class="control">
            <input type="text" name="email" value="<?= $rowBook['email']  ?>">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="estado">Estado:</label>
        </div>
        <div class="control" id="estado">
            <input type="hidden" name="estado" value="bajo">
            <input type="checkbox" name="estado" value="alto" <?= ($rowBook['estado'] == 'alto') ? 'checked' : '' ?>>
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="">&nbsp;</label>
        </div>
        <div class="control" id="botones">
            <button type="reset" name="button" onClick="location.href='../base/index.php?op=30'">Cancelar</button>
            <button type="submit" name="button">Enviar</button>
        </div>
    </div>
</form>