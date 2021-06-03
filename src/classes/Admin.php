<?php

/* CLASS THAT DESCRIBE AN ADMIN */

class Admin extends User
{

	function __construct($id, $username, $password, $secretId) {
		parent::__construct($id, $username, $password, $secretId, "Admin");
	}

}

?>