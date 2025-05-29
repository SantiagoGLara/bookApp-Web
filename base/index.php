<!DOCTYPE html>
<html>
<?php include('head.php'); ?>
<body>
    <?php
    include('header.php');
    include('menu.php');
    if (!$user) {
        include('../content/authenticate.php');
    } else {
        include('../base/pantallabienvenida.php');
    }


    ?>
    <main>
        <?php include('content.php'); ?>
    </main>
    <?php include('footer.php'); ?>
</body>
</html>
