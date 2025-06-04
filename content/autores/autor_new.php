<?php
$id = $_GET['id'];
$consulta = "SELECT id,nombre from pais";
$resultPaises = bd_consulta($consulta);
?>
<div class="title">
  <h3>Nuevo Autor</h3>
</div>
<form class="" action="../content/autores/autor_new_commit.php" method="post" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $id ?>"> <!-- para enviar al commit -->

    <div class="dato">
        <div class="etiqueta">
            <label for="nombre">Nombre:</label>
        </div>
        <div class="control">
            <input type="text" name="nombre" value="">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="nacionalidad">País de origen:</label>
        </div>
        <div class="control">
            <select class="" name="nacionalidad">
                <?php
                while ($row3 = mysqli_fetch_assoc($resultPaises)) {
                ?>
                    <option value="<?= $row3['id'] ?>"><?= $row3['nombre'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="comentarios">Comentarios:</label>
        </div>
        <div class="control">
            <textarea name="comentarios"></textarea>
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="">&nbsp;</label>
        </div>
        <div class="control" id="botones">
            <button type="reset" name="button"><a href="../base/index.php?op=12&id=<?= $id ?>">Cancelar</a></button>
            <button type="submit" name="button">Enviar</button>
        </div>
    </div>
</form>
<div class="etiqueta">
    <label for="">&nbsp;</label>
</div>
<div class="etiqueta">

</div>
<div class="etiqueta">
    <label for="">&nbsp;</label>
</div>
<div class="etiqueta">
    <label for="">&nbsp;</label>
</div>
<div class="etiqueta">
    <label for="">&nbsp;</label>
</div>