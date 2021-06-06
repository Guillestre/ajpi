<?php

/* CLASS THAT DESCRIBE AN ADMIN USER */

class AdminUser extends User
{

	function __construct($id, $username, $password, $secretId) {
		parent::__construct($id, $username, $password, $secretId, "admin");
	}

}

?>