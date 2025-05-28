<?php
    $consulta="SELECT id,nombre,numcelular,email,fecha_alta FROM proveedores order by  nombre";
    $result=bd_consulta($consulta);
?>
<script type="text/javascript">
  function asociarEventos(){
    var botones=document.getElementsByClassName("botonBorrar");
    for (var f = 0; f < botones.length; f++) {
      var boton = botones[f];
      boton.addEventListener("click", validar);
    }
  }
  function validar(event){
    if(!confirm("Estas seguro de eliminar este registro?"))
      event.preventDefault();
  }
  window.addEventListener("load",asociarEventos);
</script>
<table>
    <tr>
        <th>#</th>        
        <th>Nombre</th>        
        <th>Numero Celular</th>        
        <th>Email</th>        
        <th>Fecha Alta</th>
        <th><a href="../base/index.php?op=31">+ &#128218;</a></th><!-- ADD PROVEDOR  -->
    </tr>

<?php
    $i=0;
    while($row=mysqli_fetch_assoc($result)){
        $i++;
?>
<tr>
    <td><?= $i ?></td>
    <td><?= $row['nombre'] ?></td>
    <td><?= $row['numcelular'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['fecha_alta'] ?></td>
    <!-- <td><a class="botonBorrar" href="../base/index.php ?op=33 & id=<?= $row['id'] ?>">&#128465;</a></td> -->
    <td><a href="../base/index.php?op=32&id=<?$row['id']?>">&#9997;&#127995;</a></td>
</tr>
<?php } ?>
<tr>
    <td></td><td></td><td></td><td>El total de provedores es <?=$i?></td><td></td><td></td>
</tr>
</table>

