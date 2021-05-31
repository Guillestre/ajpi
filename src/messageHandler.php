<?php

	/* Class that handle messages to inform the use */

	abstract class messageHandler
	{

		public static function sendErrorMessage($message)
		{
			print("<div id='errorMessageBox'><span id='errorMessage'>");
			print($message);
			print("</div><span/>");
		}


		public static function sendInfoMessage($message)
		{
			print("<div id='infoMessageBox'><p id='infoMessage'>");
			print($message);
			print("</p></div>");
		}

	}

?>