<?php

	abstract class messageHandler
	{

		public static function sendErrorMessage($message)
		{
			print("<div class='errorMessageBox'><span class='errorMessage'>");
			print($message);
			print("</div><span/>");
		}


		public static function sendInfoMessage($message)
		{
			print("<div class='infoMessageBox'><p id='infoMessage'>");
			print($message);
			print("</p></div>");
		}

	}

?>