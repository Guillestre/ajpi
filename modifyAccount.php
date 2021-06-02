<!DOCTYPE html>
<html>
	<head>
		<?php include 'ext/header.php'; ?>
		<title>Modifier compte</title>
		<link rel="stylesheet" href="styles/dashboard.css">
	</head>
	<body>

		<?php include 'ext/menu.php';?>

		<!-- PROCESSFORM ------------------------------->
		<?php include "ext/processForm.php";?>

		<!-- DO RESEARCH ------------------------------->
		<?php include 'ext/doResearch.php'?>

		<div class="grid-container-forms">	
			<div class="userFormBox">
				<?php include "ext/modifyUsername.php"; ?>
			</div>

			<div class="userFormBox">
				<?php include "ext/modifyPassword.php"; ?>
			</div>
			
			<div class="userFormBox">
				<?php include "ext/modifyLabel.php"; ?>
			</div>
		</div>

	</body>
</html>