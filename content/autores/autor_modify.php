<?php
$idBook = $_GET['id'];
$consulta = "SELECT * FROM autor WHERE estado!='bajo'";
$resultAutores = bd_consulta($consulta);
$consulta = "SELECT id,nombre from pais";
$resultPaises = bd_consulta($consulta);

// Cargar países en un array para poder iterar varias veces
$paises = [];
while ($rowPais = mysqli_fetch_assoc($resultPaises)) {
    $paises[] = $rowPais;
}
?>
<div class="title">
  <h3>Modificacion autor</h3>
</div>

<form class="" action="../content/autores/autor_modify_commit.php" method="post" enctype="multipart/form-data">

    <input type="hidden" name="idBook" value="<?= $idBook ?>"> <!-- para enviar al commit -->

    <?php while ($row = mysqli_fetch_assoc($resultAutores)) { ?>
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
                <input type="text" name="nombre[]" value="<?= $row['nombre'] ?>">
            </div>
        </div>

        <div class="dato">
            <div class="etiqueta">
                <label>País de origen:</label>
            </div>
            <div class="control">
                <select name="nacionalidad[]">
                    <?php foreach ($paises as $pais) { ?>
                        <option value="<?= htmlspecialchars($pais['id']) ?>" <?= ($pais['id'] == $row['nacionalidad']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pais['nombre']) ?>
                        </option>
                    <?php } ?>
                </select>
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