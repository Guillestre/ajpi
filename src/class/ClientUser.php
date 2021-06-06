<?php

/* CLASS THAT DESCRIBE A CLIENT USER */

class clientUser extends User
{
	private $clientCode;

	function __construct($id, $username, $password, $secretId, $clientCode) {
		$this->clientCode = $clientCode;
		parent::__construct($id, $username, $password, $secretId, "client");
	}

	function getClientCode()
	{
		return $this->clientCode;
	}

	function setClientCode($clientCode)
	{
		return $this->clientCode = $clientCode;
	}
}

?>