	<?php include('bd.php') ?>
	<?php include "session.php" ?>
	<?php include "global.php" ?>

<header>
	<div class="header-contenedor">
		<div class="header-titulos">
			<h1>Book Marketing App</h1>
			<h2>Books &#128218;</h2>
		</div>
		<div class="usuario-header">
			<img src="<?php echo $user_imagen ?>" alt="Usuario">
			<p><?php echo $user_nombre ?></p>
		</div>
	</div>
</header>
