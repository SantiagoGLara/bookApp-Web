<!DOCTYPE html>
<html>
	<?php
error_reporting(E_ALL); // Asegúrate de mostrar todos los errores
ini_set('display_errors', 1); // Muestra errores en el navegador

echo '<pre>';
print_r($_GET);
echo '</pre>';

// El resto de tu código de index.php
?>
	<?php include('head.php'); ?>
	<body>
		<?php
		include('header.php');
		include('menu.php');
		if(!$user) include('../content/authenticate.php');
		?>
		<main>
			<?php include('content.php'); ?>
		</main>
			<?php include('footer.php'); ?>
	</body>
</html>
