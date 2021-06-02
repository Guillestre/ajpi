<?php

	if(isset($_GET['errorMessage']))
		messageHandler::sendErrorMessage($_GET['errorMessage']);

	if(isset($_GET['infoMessage']))
		messageHandler::sendInfoMessage($_GET['infoMessage']);
	
?>