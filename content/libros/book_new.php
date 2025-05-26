<?php
  $consulta="SELECT id, tipo from tipo";
  $result=bd_consulta($consulta);
  $consulta="SELECT id, nombre from autor";
  $resultAutores=bd_consulta($consulta);
  $consulta="SELECT id,editorial from editorial";
  $resultEditoriales=bd_consulta($consulta);
  $consulta="SELECT id,nombre from pais";
  $resultPaises=bd_consulta($consulta);
  $consulta="SELECT id,lenguaje from lenguaje";
  $resultLenguajes=bd_consulta($consulta);
?>

<script type="text/javascript">
  function asociarEventos(){
    var portada=document.getElementById("botonPortada");
    var contraportada=document.getElementById("botonContraPortada");
    portada.addEventListener("change",cargarPortada);
    contraportada.addEventListener("change",cargarContraPortada);
  }
  function cargarPortada(elemento){
    const file=elemento.target.files[0];
    console.log(file.name);
    const imagenPortada=document.getElementById("imgPortada");
    const reader = new FileReader();
    reader.onload=function(e){
      imagenPortada.src=e.target.result;
    }
    reader.readAsDataURL(file);
  }
  function cargarContraPortada(elemento){
    const file=elemento.target.files[0];
    console.log(file.name);
    const imagenPortada=document.getElementById("imgContraPortada");
    const reader = new FileReader();
    reader.onload=function(e){
      imagenPortada.src=e.target.result;
    }
    reader.readAsDataURL(file);
  }
  window.addEventListener("load",asociarEventos);
</script>
<style media="screen">
  #imgPortada, #imgContraPortada{
    display:inline-block;
    width:100px;
  }
  #numpagina, #tipo_pasta, #sobrecubierta{
    width:15%;
  }
  .archivos{
    width:50%
  }
</style>
    <form class="" action="../content/libros/book_new_commit.php" method="post" enctype="multipart/form-data">
     
      <div class="dato">
        <div class="etiqueta">
          <label for="titulo">Titulo del libro:</label>
        </div>
        <div class="control">
          <input type="text" name="titulo" value="">
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="tipo">Tipo de libro:</label>
        </div>
        <div class="control">
          <select class="" name="tipo">
          <?php
            while($row=mysqli_fetch_assoc($result)){
           ?>
            <option value="<?= $row['id'] ?>"><?= $row['tipo'] ?></option>
          <?php } ?>
          </select>
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="numpagina">Número de página:</label>
        </div>
        <div class="control">
          <input id="numpagina" type="number" name="numpagina" min="10" value="10">
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="autor">Autor:</label>
        </div>
        <div class="control">
          <select class="" name="autor">
          <?php
            while($row2=mysqli_fetch_assoc($resultAutores)){
           ?>
            <option value="<?= $row2['id'] ?>"><?= $row2['nombre'] ?></option>
          <?php } ?>
          </select>
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="editorial">Editorial:</label>
        </div>
        <div class="control">
          <select class="" name="editorial">
          <?php
            while($row2=mysqli_fetch_assoc($resultEditoriales)){
           ?>
            <option value="<?= $row2['id'] ?>"><?= $row2['editorial'] ?></option>
          <?php } ?>
          </select>
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="isbn">ISBN:</label>
        </div>
        <div class="control">
          <input name="isbn" pattern="[0-9]{13}" title="Inserte un ISBN válido" placeholder="0000000000000">
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="pais">País de origen:</label>
        </div>
        <div class="control">
          <select class="" name="pais">
          <?php
            while($row3=mysqli_fetch_assoc($resultPaises)){
           ?>
            <option value="<?= $row3['id'] ?>"><?= $row3['nombre'] ?></option>
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
            <?php for($i=1;$i<count($dimensiones);$i++) {?>
              <option value="<?= $i ?>"><?= $dimensiones[$i] ?></option>
          <?php } ?>
            <option value="99">Otro</option>
          </select>
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="lenguaje">Idioma:</label>
        </div>
        <div class="control">
          <select class="" name="lenguaje">
          <?php
            while($row4=mysqli_fetch_assoc($resultLenguajes)){
           ?>
            <option value="<?= $row4['id'] ?>"><?= $row4['lenguaje'] ?></option>
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
          <img src="../images/portadaLibro.jpeg" alt="portada" id="imgPortada" name="imgPortada">
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="contraportada">Imagen de la contraportada:</label>
        </div>
        <div class="control">
          <input type="file" id="botonContraPortada" name="contraportada" value="" accept="image/*" class="archivos">
          <img src="../images/portadaLibro.jpeg" alt="contraportada" id="imgContraPortada">
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="sobrecubierta">El libro tiene sobrecubierta:</label>
        </div>
        <div class="control" id="sobrecubierta">
          <input type="checkbox" name="sobrecubierta" checked >
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="tipo_pasta">Pasta suave:</label>
        </div>
        <div class="control" class="tipo_pasta">
          <input type="radio" name="tipo_pasta" value="0" checked>
        </div>
      </div>
      
      <div class="dato">
        <div class="etiqueta">
          <label for="tipo_pasta">Pasta dura:</label>
        </div>
        <div class="control" class="tipo_pasta">
          <input type="radio" name="tipo_pasta" value="1">
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="resumen">Resumen del libro:</label>
        </div>
        <div class="control">
          <textarea name="resumen" rows="4" cols="30"></textarea>
        </div>
      </div>

      <div class="dato">
        <div class="etiqueta">
          <label for="precio">Precio sugerido:</label>
        </div>
        <div class="control">
          <input id="precio" type="number" name="precio" value="0">
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
