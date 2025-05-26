<?php

?>

<form class="" action="../content/clientes/client_new_commit.php" method="post" enctype="multipart/form-data">
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
            <label for="edad">Edad:</label>
        </div>
        <div class="control">
            <input type="text" name="edad" value="">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="numcelular">Número de celular:</label>
        </div>
        <div class="control">
            <input type="tel" name="numcelular"
                pattern="\d{10}" maxlength="10">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="email">Email:</label>
        </div>
        <div class="control">
            <input type="email" name="email">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="fecha_alta">Fecha:</label>
        </div>
        <div class="control">
            <input type="date" name="fecha_alta">
        </div>
    </div>

    <div class="dato">
        <div class="etiqueta">
            <label for="">&nbsp;</label>
        </div>
        <div class="control" id="botones">
            <button type="reset" name="button">Cancelar</button>
            <button type="submit" name="button">Enviar</button>
        </div>
    </div>
</form>