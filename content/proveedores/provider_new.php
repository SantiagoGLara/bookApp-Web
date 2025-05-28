<?php
 $consulta="SELECT id,nombre,numcelular,email,fecha_alta,estado from proveedores";
 $result=bd_consulta($consulta);
 ?>
 <form class="" action="../content/proveedores/provider_new_commit.php" method="post" enctype="multipart/form-data">
    <div class="dato">
        <div class="etiqueta">
            <label for="titulo">Nombre:</label> 
        </div>
        <div class="control">
          <input type="text" name="nombre" value="">
        </div>
    </div>
    <div class="dato">
        <div class="etiqueta">
            <label for="titulo">Numero de celular:</label> 
        </div>
        <div class="control">
          <input type="text" name="numcelular" pattern="[0-9]{10}" title="Por favor, introduce solo números (10 caracteres exactos)" placeholder="0000000000">
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
          <button type="reset" name="button" onClick="location.href='../base/index.php?op=30'">Cancelar</button>
          <button type="submit" name="button">Enviar</button>
        </div>
      </div>
</form>