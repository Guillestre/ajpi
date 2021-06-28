<?php

/**
 * CLASS THAT DESCRIBE AN ADMIN USER 
 */

class clientUser extends User
{
	private $clientCode;

	/**
	 * Construct
	 * 
	 * @param integer $id
	 * @param string $username
	 * @param string $password
	 * @param integer $secretId
	 * @param string $clientCode
	 */

	function __construct($id, $username, $password, $secretId, $clientCode) {
		$this->clientCode = $clientCode;
		parent::__construct($id, $username, $password, $secretId, "client");
	}

	/**
	 * Get client code
	 *
	 * @return string that correspond to the client code
	 */

	function getClientCode()
	{
		return $this->clientCode;
	}

	/**
	 * Set client code
	 * @param string $clientCode
	 */

	function setClientCode($clientCode)
	{
		return $this->clientCode = $clientCode;
	}
}

?>