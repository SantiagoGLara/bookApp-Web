<?php
$idBook = $_GET['id'];
$consulta = "SELECT * FROM editorial WHERE estado!='bajo'";
$resultEditoriales = bd_consulta($consulta);
?>

<form class="" action="../content/editoriales/editorial_modify_commit.php" method="post" enctype="multipart/form-data">

    <input type="hidden" name="idBook" value="<?= $idBook ?>"> <!-- para enviar al commit -->

    <?php while ($row = mysqli_fetch_assoc($resultEditoriales)) { ?>
        <div class="dato">
            <div class="etiqueta">
                <label>ID:</label>
            </div>
            <div class="control">
                <input type="text" name="id[]" value="<?= $row['id'] ?>" readonly>
            </div>
        </div>

        <div class="dato">
            <div class="etiqueta">
                <label>Nombre:</label>
            </div>
            <div class="control">
                <input type="text" name="editorial[]" value="<?= $row['editorial'] ?>">
            </div>
        </div>

        <div class="dato">
            <div class="etiqueta">
                <label>Estado:</label>
            </div>
            <div class="control">
                <input type="hidden" name="estado[<?= $row['id'] ?>]" value="bajo">
                <input type="checkbox" name="estado[<?= $row['id'] ?>]" value="alto" <?= ($row['estado'] == 'alto') ? 'checked' : '' ?>>
            </div>
        </div>

        <hr>
    <?php } ?>

    <div class="dato">
        <div class="etiqueta">
            <label for="">&nbsp;</label>
        </div>
        <div class="control" id="botones">
            <button type="reset" name="button"><a href="../base/index.php?op=12&id=<?= $idBook ?>">Cancelar</a></button>
            <button type="submit" name="button">Enviar</button>
        </div>
    </div>
</form>