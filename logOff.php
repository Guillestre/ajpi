<?php 
	session_start();
	session_unset();
	session_destroy();
	$text = "Vous avez été déconnecté";
	$successMessage = urlencode($text);
	header("Location: index.php?logOffSuccess=${successMessage}");
?>