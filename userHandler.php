<!DOCTYPE html>
<html>
<head>
	<?php
		include 'ext/header.php';
	?>
	<title>Ajouter un compte</title>
	<link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>

	<?php include 'ext/menu.php';?>

	<h1>Gérer utilisateurs</h1>

	<!-- DO RESEARCH ------------------------------->
	<?php include 'ext/doResearch.php'?>

	<div class="grid-container-forms">
		<?php include "ext/addClientForm.php"; ?>
		<?php include "ext/addAdminForm.php"; ?>
		<?php include "ext/deleteUser.php"; ?>
		<?php include "ext/myAccount.php"; ?>
	</div>

	<button type="button" onclick="history.back()">
		Retour
	</button>

	<button type="submit" onclick="location.href='dashboard.php'">
		Revenir sur les factures
	</button>

</body>
</html>