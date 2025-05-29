<?php
$consulta = "SELECT usuarios.id, username, nombre, password, foto, estado
from usuarios
WHERE estado != 'bajo'
order by username";
$result = bd_consulta($consulta);
?>
<table>
  <tr>
    <th>#</th>
    <th>Username</th>
    <th>Nombre</th>
    <th>Password</th>
    <!-- <th>Foto</th> -->
    <th><a href="../base/index.php?op=81">+ &#128218;</a></th>
  </tr>
  <?php
  $i = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    $i++;
  ?>
    <tr>
      <td><?= $i ?></td>
      <td><?= $row['username']  ?></td>
      <td><?= $row['nombre'] ?></td>
      <td><?= $row['password'] ?></td>
      <!-- <td></?= $row['foto'] ?></td> -->
      <td><a href="../base/index.php?op=82&id=<?= $row['id'] ?>">&#9997;&#127995;</a></td>
    </tr>
  <?php } ?>
  <tr>
    <td></td>
    <td>El total de usuarios es <?= $i ?></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>