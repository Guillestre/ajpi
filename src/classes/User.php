<?php

	/* CLASS THAT DESCRIBE AN ADMIN */

	abstract class User
	{

		private $id;
		private $username;
		private $password;
		private $secretId;
		private $status;

		function __construct($id, $username, $password, $secretId, $status) {
			$this->id = $id;
			$this->username = $username;
			$this->password = $password;
			$this->secretId = $secretId;
			$this->status = $status;
		}

		function getId()
		{
			return $this->id;
		}

		function setId($id)
		{
			return $this->id = $id;
		}

		function getUsername()
		{
			return $this->username;
		}

		function setUsername($username)
		{
			return $this->username = $username;
		}

		function getPassword()
		{
			return $this->password;
		}

		function setPassword($password)
		{
			return $this->password = $password ;
		}

		function getSecretId()
		{
			return $this->secretId;
		}

		function setSecretId($secretId)
		{
			return $this->secretId = $secretId;
		}

		function getStatus()
		{
			return $this->status;
		}

		function setStatus($status)
		{
			return $this->status = $status;
		}

	}

?>