<?php
 $consulta="SELECT id,nombre,numcelular,email,fecha_alta,estado from proveedores";
 $result=bd_consulta($consulta)
 ?>
 <form class="" action="../proveedores/provider_new_commit.php" method="post" enctype="multipart/form-data">
    <div class="dato">
        <div class="etiqueta">
            <label for="titulo">Nombre:</label> 
        </div>
        <div class="control">
          <input type="text" name="titulo" value="">
        </div>
    </div>
    <div class="dato">
        <div class="etiqueta">
            <label for="titulo">Numero de celular:</label> 
        </div>
        <div class="control">
          <input type="text" name="numcelular" value="">
        </div>
    </div>
    <div class="dato">
        <div class="etiqueta">
            <label for="titulo">Correo Electronico:</label> 
        </div>
        <div class="control">
          <input type="email" name="email" value="">
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

    
 </form>