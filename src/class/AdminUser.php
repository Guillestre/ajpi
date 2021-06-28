<?php

/**
 * CLASS THAT DESCRIBE AN ADMIN USER 
 */

class AdminUser extends User
{

	/**
	 * Construct
	 * @param integer $id
	 * @param string $username
	 * @param string $password
	 * @param integer $secretId
	 */

	function __construct($id, $username, $password, $secretId) {
		parent::__construct($id, $username, $password, $secretId, "admin");
	}

}

?>