<?php

/**
 *  CLASS THAT DESCRIBE A CLIENT 
 * */

class Client
{

	private $code;
	private $name;
	private $title;
	private $address;
	private $capital;
	private $city;
	private $number;
	private $mail;


	/**
	 * Construct
	 * 
	 * @param string $code
	 * @param string $name
	 * @param string $address
	 * @param string $capital
	 * @param string $city
	 * @param string $number
	 * @param string $mail
	 */

	function __construct
	($code, $name, $title, $address, $capital, $city, $number, $mail) {
		$this->code = $code;
		$this->name = $name;
		$this->title = $title;
		$this->address = $address;
		$this->capital = $capital;
		$this->city = $city;
		$this->number = $number;
		$this->mail = $mail;
	}

	/**
	 * Get code
	 * 
	 * @return string
	 */

	function getCode()
	{
		return $this->code;
	}

	/**
	 * Set code
	 * 
	 * @param string $code
	 */

	function setCode($code)
	{
		return $this->code = $code;
	}

	/**
	 * Get name
	 * 
	 * @return string
	 */

	function getName()
	{
		return $this->name;
	}

	/**
	 * Set name
	 * 
	 * @param string $name
	 */

	function setName($name)
	{
		return $this->name = $name;
	}

	/**
	 * Get title
	 * 
	 * @return string
	 */

	function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set title
	 * 
	 * @param string $title
	 */

	function setTitle($title)
	{
		return $this->title = $title;
	}

	/**
	 * Get address
	 * 
	 * @return string
	 */

	function getAddress()
	{
		return $this->address;
	}

	/**
	 * Set address
	 * 
	 * @param string $address
	 */

	function setAddress($address)
	{
		return $this->address = $address;
	}

	/**
	 * Get capital
	 * 
	 * @return string
	 */

	function getCapital()
	{
		return $this->capital;
	}

	/**
	 * Set capital
	 * 
	 * @param string $capital
	 */

	function setCapital($capital)
	{
		return $this->capital = $capital;
	}

	/**
	 * Get city
	 * 
	 * @return string
	 */

	function getCity()
	{
		return $this->city;
	}

	/**
	 * Set city
	 * 
	 * @param string $city
	 */

	function setCity($city)
	{
		return $this->city = $city;
	}

	/**
	 * Get number
	 * 
	 * @return string
	 */

	function getNumber()
	{
		return $this->number;
	}

	/**
	 * Set number
	 * 
	 * @param string $number
	 */

	function setNumber($number)
	{
		return $this->number = $number;
	}

	/**
	 * Get mail
	 * 
	 * @param $mail
	 */

	function getMail()
	{
		return $this->mail;
	}

	/**
	 * Set mail
	 * 
	 * @param string $mail
	 */

	function setMail($mail)
	{
		return $this->mail = $mail;
	}

}

?>