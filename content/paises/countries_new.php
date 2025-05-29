
<?php
$id = $_GET['id'];
?>

<form class="" action="../content/paises/countries_new_commit.php" method="post" enctype="multipart/form-data">
    
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