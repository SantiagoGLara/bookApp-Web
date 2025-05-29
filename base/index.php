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
        // Solo muestra la pantalla de bienvenida si no hay otra página solicitada
        $showWelcome = empty($_GET) || (count($_GET) === 1 && isset($_GET['page']) && $_GET['page'] === 'bienvenida');
        if ($showWelcome) {
            include('../base/pantallabienvenida.php');
        }
    }
    ?>
    <main>
        <?php include('content.php'); ?>
    </main>
    <?php include('footer.php'); ?>
</body>
</html>