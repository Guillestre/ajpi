<?php

/* CLASS THAT DESCRIBE AN INVOICE */

class Invoice 
{

	private $code;
	private $clientCode;
	private $date;
	private $totalExcludingTaxes;
	private $totalIncludingTaxes;
	private $description;

	function __construct
	($code, $clientCode, $date, $totalExcludingTaxes, $totalIncludingTaxes, $description) {
		$this->code = $code;
		$this->clientCode = $clientCode;
		$this->date = $date;
		$this->totalExcludingTaxes = $totalExcludingTaxes;
		$this->totalIncludingTaxes = $totalIncludingTaxes;
		$this->description = $description;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function getClientCode()
	{
		return $this->clientCode;
	}

	public function setClientCode($clientCode)
	{
		$this->clientCode = $clientCode;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function getTotalExcludingTaxes()
	{
		return $this->totalExcludingTaxes;
	}

	public function setTotalExcludingTaxes($totalExcludingTaxes)
	{
		$this->totalExcludingTaxes = $totalExcludingTaxes;
	}

	public function getTotalIncludingTaxes()
	{
		return $this->totalIncludingTaxes;
	}

	public function setTotalIncludingTaxes($totalIncludingTaxes)
	{
		$this->totalIncludingTaxes = $totalIncludingTaxes;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

}

?>