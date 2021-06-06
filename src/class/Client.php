<?php

/* CLASS THAT DESCRIBE A CLIENT */

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

	function getCode()
	{
		return $this->code;
	}

	function setCode($code)
	{
		return $this->code = $code;
	}

	function getName()
	{
		return $this->name;
	}

	function setName($name)
	{
		return $this->name = $name;
	}

	function getTitle()
	{
		return $this->title;
	}

	function setTitle($title)
	{
		return $this->title = $title;
	}

	function getAddress()
	{
		return $this->address;
	}

	function setAddress($address)
	{
		return $this->address = $address;
	}

	function getCapital()
	{
		return $this->capital;
	}

	function setCapital($capital)
	{
		return $this->capital = $capital;
	}

	function getCity()
	{
		return $this->city;
	}

	function setCity($city)
	{
		return $this->city = $city;
	}

	function getNumber()
	{
		return $this->number;
	}

	function setNumber($number)
	{
		return $this->number = $number;
	}

	function getMail()
	{
		return $this->mail;
	}

	function setMail($mail)
	{
		return $this->mail = $mail;
	}

}

?>