<!DOCTYPE html>
<html>
	<head>
		<?php include 'ext/header.php'; ?>
		<title>Ajouter un compte</title>
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
				<?php include "ext/myAccount.php"; ?>
			</div>

			<div class="userFormBox">
				<?php include "ext/deleteUser.php"; ?>
			</div>
			
			<div class="userFormBox">
				<?php include "ext/addUserForm.php"; ?>
			</div>
	</div>

</body>
</html>