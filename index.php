<!DOCTYPE html>
<html>

	<head>
		<?php
			include 'ext/header.php';
			include 'script/script_handler.php';
			include __DIR__.'/vendor/autoload.php';
		?>
		<link rel="stylesheet" href="styles/logIn.css">
		<title>Accueil</title>
	</head>

	<body>

		<h1>AJPI Records</h1>

		<div class="grid-container-forms">
		<?php
			include "ext/signIn.php";
			include "ext/signUp.php";
		?>
		</div>

	</body>

</html>
