<?php
  $operacionValida=true;
  if($operacionValida==false){
?>
  <h2>Esta operación no se puede llevar a cabo</h2>
<?php
  }
  else{
    $consulta="DELETE from book where id=".$_GET['id'];
    $result=bd_consulta($consulta);
?>
  <h2>Se ha eliminado un registro</h2>
<?php
}
?>
