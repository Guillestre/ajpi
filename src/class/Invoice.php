<?php

/**
 *  CLASS THAT DESCRIBE AN INVOICE 
 */

class Invoice 
{

	private $code;
	private $clientCode;
	private $date;
	private $totalExcludingTaxes;
	private $totalIncludingTaxes;
	private $description;

	/**
	 * Construct
	 * 
	 * @param string $code
	 * @param string $clientCode
	 * @param date $date
	 * @param float $totalExcludingTaxes
	 * @param float $totalIncludingTaxes
	 * @param string $description
	 */

	function __construct
	($code, $clientCode, $date, $totalExcludingTaxes, $totalIncludingTaxes, $description) {
		$this->code = $code;
		$this->clientCode = $clientCode;
		$this->date = $date;
		$this->totalExcludingTaxes = $totalExcludingTaxes;
		$this->totalIncludingTaxes = $totalIncludingTaxes;
		$this->description = $description;
	}

	/**
	 * Get invoice code
	 *
	 * @return string
	 */

	public function getCode()
	{
		return $this->code;
	}

	/**
	 * Set code
	 * 
	 * @param string $code
	 */

	public function setCode($code)
	{
		$this->code = $code;
	}

	/**
	 * Get client code
	 *
	 * @return string
	 */

	public function getClientCode()
	{
		return $this->clientCode;
	}

	/**
	 * Set client code
	 * 
	 * @param string $code
	 */

	public function setClientCode($clientCode)
	{
		$this->clientCode = $clientCode;
	}

	/**
	 * Get date
	 *
	 * @return date
	 */

	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Set date
	 * 
	 * @param string $date
	 */

	public function setDate($date)
	{
		$this->date = $date;
	}

	/**
	 * Get totalExcludingTaxes
	 *
	 * @return float
	 */

	public function getTotalExcludingTaxes()
	{
		return $this->totalExcludingTaxes;
	}

	/**
	 * Set totalExcludingTaxes
	 * 
	 * @param float
	 */

	public function setTotalExcludingTaxes($totalExcludingTaxes)
	{
		$this->totalExcludingTaxes = $totalExcludingTaxes;
	}

	/**
	 * Get totalIncludingTaxes
	 *
	 * @return float
	 */

	public function getTotalIncludingTaxes()
	{
		return $this->totalIncludingTaxes;
	}

	/**
	 * Set totalIncludingTaxes
	 * 
	 * @param float
	 */

	public function setTotalIncludingTaxes($totalIncludingTaxes)
	{
		$this->totalIncludingTaxes = $totalIncludingTaxes;
	}

	/**
	 * Get description
	 *
	 * @return string
	 */

	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set description
	 * 
	 * @param string $description
	 */

	public function setDescription($description)
	{
		$this->description = $description;
	}

}

?>