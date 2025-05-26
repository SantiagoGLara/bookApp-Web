<?php
  include('../base/bd.php');
  include('../base/global.php');

  $user=$_POST['username'];
  $password=$_POST['password'];

  $consulta="SELECT username, password, nombre from usuarios where username='".$user."' and password='".$password."'";
  $result=bd_consulta($consulta);
  $row=mysqli_fetch_assoc($result);

  if($row){
    session_start();
    $_SESSION['USER']=$user;
    $_SESSION['USER_NOMBRE']=$row['nombre'];
  }
  header('Location: ../base/index.php');
 ?>
