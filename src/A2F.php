<?php

	include './vendor/autoload.php';

	//We use TOTP
	use OTPHP\TOTP;

	abstract class A2F
	{

		static $totp;

		final public static function setSecret($secret, $label)
		{

			//Create TOTP with secret from the user
		    self::$totp = TOTP::create($secret);

		   	//Set label
		   	self::$totp->setLabel($label);

		}

		final public static function verify($otp)
		{
			return self::$totp->verify(htmlspecialchars($otp));
		}

	}


?>