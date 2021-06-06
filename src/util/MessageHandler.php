<?php

	/* Class that handle messages to inform the user */

	abstract class MessageHandler
	{

		public static function sendErrorMessage($message)
		{
			print("<div id='errorMessageBox'><span id='errorMessage'>");
			print($message);
			print("</div><span/>");
		}

		public static function sendSuccessMessage($message)
		{
			print("<div id='successMessageBox'><span id='successMessage'>");
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