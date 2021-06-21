<?php 

	/* FILE THAT LOG OFF USER */

	session_start();
	session_unset();
	session_destroy();
	$text = "Vous avez été déconnecté";
	$successMessage = $text;
	header("Location: index.php?logOffSuccess=${successMessage}");
?>