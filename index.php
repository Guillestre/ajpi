<!DOCTYPE html>
<html>

	<head>
		<?php
			include 'ext/header.php';

			include "src/user.php";
			include "src/A2F.php";
			
			include 'script/scriptHandler.php';
		?>
		<link rel="stylesheet" href="styles/logIn.css">
		<title>Accueil</title>
	</head>

	<body>

		<h1>AJPI Records</h1>

		<div class="grid-container-forms">
		<?php

			//Verify if user isn't already connected
			if(isset($_SESSION['username']))
				header("Location: dashboard.php");

			include "ext/signIn.php";
			include "ext/signUp.php";
		?>
		</div>

	</body>

</html>