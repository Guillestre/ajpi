<?php

/**
 *  CLASS THAT DESCRIBE A USER 
 * */

abstract class User
{

	private $id;
	private $username;
	private $password;
	private $secretId;
	private $status;

	/**
	 * Construct
	 * 
	 * @param integer $id
	 * @param string $username
	 * @param string $password
	 * @param integer $secretId
	 * @param string $status
	 * */

	function __construct($id, $username, $password, $secretId, $status) {
		$this->username = $username;
		$this->password = $password;
		$this->secretId = $secretId;
		$this->status = $status;
		$this->id = $id;
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */

	function getId()
	{
		return $this->id;
	}

	/**
	 * Set id
	 *
	 * @param integer $id
	 */

	function setId($id)
	{
		return $this->id = $id;
	}

	/**
	 * Get username
	 *
	 * @return string
	 */

	function getUsername()
	{
		return $this->username;
	}

	/**
	 * Set username
	 *
	 * @param string $username
	 */

	function setUsername($username)
	{
		return $this->username = $username;
	}

	/**
	 * Get password
	 *
	 * @return string
	 */

	function getPassword()
	{
		return $this->password;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 */

	function setPassword($password)
	{
		return $this->password = $password ;
	}

	/**
	 * Get secret id
	 *
	 * @return integer
	 */

	function getSecretId()
	{
		return $this->secretId;
	}

	/**
	 * Set secret id
	 *
	 * @param integer $secretId
	 */

	function setSecretId($secretId)
	{
		return $this->secretId = $secretId;
	}

	/**
	 * Get status
	 *
	 * @return string
	 */

	function getStatus()
	{
		return $this->status;
	}

	/**
	 * Set status
	 *
	 * @param string $status
	 */

	function setStatus($status)
	{
		return $this->status = $status;
	}

}

?>