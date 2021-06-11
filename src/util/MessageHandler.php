<?php

	/* Class that handle messages to inform the user */

	abstract class MessageHandler
	{

		public static function sendErrorMessage($message)
		{
			print("<div class='errorMessageBox'><span class='errorMessage'>");
			print($message);
			print("</div><span/>");
		}

		public static function sendSuccessMessage($message)
		{
			print("<div class='successMessageBox'><span class='successMessage'>");
			print($message);
			print("<span/></div>");
		}


		public static function sendInfoMessage($message)
		{
			print("<div class='infoMessageBox'><p class='infoMessage'>");
			print($message);
			print("</p></div>");
		}

	}

?>