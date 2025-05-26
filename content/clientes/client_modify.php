<?php
$consulta = "SELECT * from clientes where id=" . $_GET['id'];
$resultBook = bd_consulta($consulta);
$rowBook = mysqli_fetch_assoc($resultBook);
?>

<form class="" action="../content/clientes/client_modify_commit.php" method="post" enctype="multipart/form-data">

    <div class="dato">
        <div class="etiqueta">
            <label for="id">ID del usuario:</label>
        </div>
        <div class="control">
            <input type="text" name="id" value="<?= $rowBook['id'] ?>" readonly>
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="nombre">Nombre:</label>
        </div>
        <div class="control">
            <input type="text" name="nombre" value="<?= $rowBook['nombre']  ?>">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="edad">Edad:</label>
        </div>
        <div class="control">
            <input type="text" name="edad" value="<?= $rowBook['edad']  ?>">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="numcelular">Número de celular:</label>
        </div>
        <div class="control">
            <input type="tel" name="numcelular" value="<?= $rowBook['numcelular'] ?>"
                pattern="\d{10}" maxlength="10">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="email">Email:</label>
        </div>
        <div class="control">
            <input type="email" name="email" value="<?= $rowBook['email'] ?>">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="fecha_alta">Fecha de Alta:</label>
        </div>

        <div class="control">
            <input type="date" name="fecha_alta" value="<?= $rowBook['fecha_alta']  ?>">
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
            <button type="reset" name="button" onClick="location.href='../base/index.php?op=20'">Cancelar</button>
            <button type="submit" name="button">Enviar</button>
        </div>
    </div>
</form>