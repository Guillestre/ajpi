<?php

	/* Class that extract things */

	abstract class ExtractHelper
	{

		public static function extractUsername($userDescription)
		{
			$start = 0;
			$end = strpos($userDescription,"(") - 1;
			$username = substr($userDescription, $start, $end - $start);
			return $username;
		}

		public static function extractStatus($userDescription)
		{
			$start = strlen($userDescription) - 7;
			$end = strlen($userDescription) - 2;
			$status = substr($userDescription, $start, $end);
			return $status;
		}

	}

?>