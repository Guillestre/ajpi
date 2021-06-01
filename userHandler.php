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

	<!-- REDIRECTION ------------------------------->
	<?php include "ext/redirection.php";?>

	<?php include "ext/myAccount.php"; ?>
	<div class="grid-container-forms">
		<?php include "ext/addClientForm.php"; ?>
		<?php include "ext/addAdminForm.php"; ?>
		<?php include "ext/deleteUser.php"; ?>
	</div>

</body>
</html>