<?php
$consulta = "SELECT id, tipo from tipo";
$result = bd_consulta($consulta);
$consulta = "SELECT id, nombre from autor";
$resultAutores = bd_consulta($consulta);
$consulta = "SELECT id,editorial from editorial where estado!='bajo'";
$resultEditoriales = bd_consulta($consulta);
$consulta = "SELECT id,nombre from pais";
$resultPaises = bd_consulta($consulta);
$consulta = "SELECT id,lenguaje from lenguaje";
$resultLenguajes = bd_consulta($consulta);
$consulta = "SELECT * from book where id=" . $_GET['id'];
$resultBook = bd_consulta($consulta);
$rowBook = mysqli_fetch_assoc($resultBook);
?>

<script type="text/javascript">
  function asociarEventos() {
    var portada = document.getElementById("botonPortada");
    var contraportada = document.getElementById("botonContraPortada");
    portada.addEventListener("change", cargarPortada);
    contraportada.addEventListener("change", cargarContraPortada);
  }

  function cargarPortada(elemento) {
    const file = elemento.target.files[0];
    console.log(file.name);
    const imagenPortada = document.getElementById("imgPortada");
    const reader = new FileReader();
    reader.onload = function(e) {
      imagenPortada.src = e.target.result;
    }
    reader.readAsDataURL(file);
  }

  function cargarContraPortada(elemento) {
    const file = elemento.target.files[0];
    console.log(file.name);
    const imagenPortada = document.getElementById("imgContraPortada");
    const reader = new FileReader();
    reader.onload = function(e) {
      imagenPortada.src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
  window.addEventListener("load", asociarEventos);
</script>

<style media="screen">
  #imgPortada,
  #imgContraPortada {
    display: inline-block;
    width: 100px;
  }

  #numpagina,
  #tipo_pasta,
  #sobrecubierta {
    width: 15%;
  }

  .archivos {
    width: 50%
  }
</style>

<form class="" action="../content/libros/book_modify_commit.php" method="post" enctype="multipart/form-data">

  <div class="dato">
    <div class="etiqueta">
      <label for="id">ID del libro:</label>
    </div>
    <div class="control">
      <input type="text" name="id" value="<?= $rowBook['id'] ?>" readonly>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="titulo">Titulo del libro:</label>
    </div>
    <div class="control">
      <input type="text" name="titulo" value="<?= $rowBook['titulo']  ?>">
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="tipo">Tipo de libro:</label>
    </div>
    <div class="control">
      <select class="" name="tipo">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <option value="<?= $row['id'] ?>" <?php if ($row['id'] == $rowBook['tipo']) echo 'selected' ?>><?= $row['tipo'] ?></option>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="numpagina">Número de página:</label>
    </div>
    <div class="control">
      <input id="numpagina" type="number" name="numpagina" min="10" value="<?= $rowBook['paginas'] ?>">
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="autor">Autor:</label>
      <label><a href="../base/index.php?op=71&id=<?= $rowBook['id'] ?>">+</a></label>
    </div>
    <div class="control">
      <select class="" name="autor">
        <?php
        while ($row2 = mysqli_fetch_assoc($resultAutores)) {
        ?>
          <option value="<?= $row2['id'] ?>" <?php if ($row2['id'] == $rowBook['autor']) echo 'selected' ?>>
            <?= $row2['nombre'] ?>
          </option>
        <?php } ?>
      </select>
      <label><a href="../base/index.php?op=72&id=<?= $rowBook['id'] ?>">&#9997;&#127995;</a></label>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="editorial">Editorial:</label>
      <label><a href="../base/index.php?op=61&id=<?= $rowBook['id'] ?>">+</a></label>
    </div>
    <div class="control">
      <select class="" name="editorial">
        <?php
        while ($row2 = mysqli_fetch_assoc($resultEditoriales)) {
        ?>
          <option value="<?= $row2['id'] ?>" <?php if ($row2['id'] == $rowBook['editorial']) echo 'selected' ?>>
            <?= $row2['editorial'] ?>
          </option>
        <?php } ?>
      </select>
      <label><a href="../base/index.php?op=62&id=<?= $rowBook['id'] ?>">&#9997;&#127995;</a></label>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="isbn">ISBN:</label>
    </div>
    <div class="control">
      <input name="isbn" pattern="[0-9]{13}" title="Inserte un ISBN válido" placeholder="0000000000000" value="<?= $rowBook['isbn'] ?>">
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="pais">País de origen:</label>
      <label><a href="../base/index.php?op=41&id=<?= $rowBook['id'] ?>">+</a></label>
    </div>
    <div class="control">
      <select class="" name="pais">
        <?php
        while ($row3 = mysqli_fetch_assoc($resultPaises)) {
        ?>
          <option value="<?= $row3['id'] ?>" <?php if ($row3['id'] == $rowBook['pais']) echo 'selected' ?>><?= $row3['nombre'] ?></option>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="dimension">Dimensiónes del libro (cm):</label>
    </div>
    <div class="control">
      <select class="" name="dimension">
        <?php for ($i = 1; $i < count($dimensiones); $i++) { ?>
          <option value="<?= $i ?>" <?php if ($dimensiones[$i] == $rowBook['dimensiones']) echo 'selected' ?>><?= $dimensiones[$i] ?></option>
        <?php } ?>
        <option value="99">Otro</option>
      </select>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="lenguaje">Idioma:</label>
      <label><a href="../base/index.php?op=51&id=<?= $rowBook['id'] ?>">+</a></label>
    </div>
    <div class="control">
      <select class="" name="lenguaje">
        <?php
        while ($row4 = mysqli_fetch_assoc($resultLenguajes)) {
        ?>
          <option value="<?= $row4['id'] ?>" <?php if ($row4['id'] == $rowBook['idioma']) echo 'selected' ?>><?= $row4['lenguaje'] ?></option>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="portada">Imagen de la portada:</label>
    </div>
    <div class="control">
      <input type="file" id="botonPortada" name="portada" value="" accept="image/*" class="archivos">
      <img src="../resources/portadas/<?= $rowBook['imagen_portada']  ?>" alt="portada" id="imgPortada" name="imgPortada">
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="contraportada">Imagen de la contraportada:</label>
    </div>
    <div class="control">
      <input type="file" id="botonContraPortada" name="contraportada" value="" accept="image/*" class="archivos">
      <img src="../resources/contraportadas/<?= $rowBook['imagen_contraportada']  ?>" alt="contraportada" id="imgContraPortada">
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="sobrecubierta">El libro tiene sobrecubierta:</label>
    </div>
    <div class="control" id="sobrecubierta">
      <input type="checkbox" name="sobrecubierta" <?php if ($rowBook['sobrecubierta'] == 1) echo 'checked' ?>>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="suave">Pasta suave:</label>
    </div>
    <div class="control" class="tipo_pasta">
      <input type="radio" id="suave" name="tipo_pasta" value=0 <?php if ($rowBook['pasta_dura'] == 0) echo 'checked' ?>>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="dura">Pasta dura:</label>
    </div>
    <div class="control" class="tipo_pasta">
      <input type="radio" id="dura" name="tipo_pasta" value=1 <?php if ($rowBook['pasta_dura'] == 1) echo 'checked' ?>>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="resumen">Resumen del libro:</label>
    </div>
    <div class="control">
      <textarea name="resumen" rows="4" cols="30"><?= $rowBook['resumen'] ?></textarea>
    </div>
  </div>

  <div class="dato">
    <div class="etiqueta">
      <label for="precio">Precio sugerido:</label>
    </div>
    <div class="control">
      <input id="precio" type="number" name="precio" value="<?= $rowBook['precio']  ?>">
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
      <button type="reset" name="button" onClick="location.href='../base/index.php?op=10'">Cancelar</button>
      <button type="submit" name="button">Enviar</button>
    </div>
  </div>

</form>