<?php

	/* Class that handle messages to inform the user */

	abstract class MessageHandler
	{

		public static function sendErrorMessage($message)
		{
			print("<p class='errorMessage'>");
			print(htmlspecialchars($message));
			print("<p/>");
		}

		public static function sendSuccessMessage($message)
		{
			print("<p class='successMessage'>");
			print(htmlspecialchars($message));
			print("<p/>");
		}


		public static function sendInfoMessage($message)
		{
			print("<p class='infoMessage'>");
			print(htmlspecialchars($message));
			print("<p/>");
		}

	}

?>