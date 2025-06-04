<?php
$consulta = "SELECT * FROM usuarios WHERE estado!='bajo'";
$resultEditoriales = bd_consulta($consulta);
?>
<div class="title">
  <h3>Modificacion Usuario</h3>
</div>
<form class="" action="../content/usuarios/user_modify_commit.php" method="post" enctype="multipart/form-data">

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
                <label>Username:</label>
            </div>
            <div class="control">
                <input type="text" name="username[]" value="<?= $row['username'] ?>">
            </div>
        </div>

        <div class="dato">
            <div class="etiqueta">
                <label>Nombre:</label>
            </div>
            <div class="control">
                <input type="text" name="nombre[]" value="<?= $row['nombre'] ?>">
            </div>
        </div>

        <div class="dato">
            <div class="etiqueta">
                <label>Password:</label>
            </div>
            <div class="control">
                <input type="text" name="password[]" value="<?= $row['password'] ?>">
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
            <button type="reset" name="button"><a href="../base/index.php?op=80">Cancelar</a></button>
            <button type="submit" name="button">Enviar</button>
        </div>
    </div>
</form>