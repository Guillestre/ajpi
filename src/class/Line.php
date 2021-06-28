<?php

/**
 * CLASS THAT DESCRIBE A LINE ITEM
 * */

class Line
{
	private $articleCode;
	private $designation;
	private $amount;
	private $unitPrice;
	private $discount;
	private $totalPrice;
	private $description;

	/**
	 * Construct
	 * 
	 * @param string $articleCode
	 * @param string $designation
	 * @param float $amount
	 * @param float $unitPrice
	 * @param float $discount
	 * @param float $totalPrice
	 * @param float $description
	 */

	function __construct($articleCode, $designation, $amount, $unitPrice, $discount, $totalPrice, $description)
	{
		$this->articleCode = $articleCode;
		$this->designation = $designation;
		$this->amount = $amount;
		$this->unitPrice = $unitPrice;
		$this->discount = $discount;
		$this->totalPrice = $totalPrice;
		$this->description = $description;
	}

	/**
	 * Get articleCode
	 *
	 * @return string
	 */

	public function getArticleCode()
	{
		return $this->articleCode;
	}

	/**
	 * Set articleCode
	 * 
	 * @param string $articleCode
	 */

	public function setArticleCode($articleCode)
	{
		$this->articleCode = $articleCode;
	}

	/**
	 * Get designation
	 *
	 * @return string
	 */

	public function getDesignation()
	{
		return $this->designation;
	}

	/**
	 * Set designation
	 * 
	 * @param string $designation
	 */

	public function setDesignation($designation)
	{
		$this->designation = $designation;
	}

	/**
	 * Get amount
	 *
	 * @return float
	 */

	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * Set amount
	 * 
	 * @param float $amount
	 */

	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	/**
	 * Get unit price
	 *
	 * @return float
	 */

	public function getUnitPrice()
	{
		return $this->unitPrice;
	}

	/**
	 * Set unit price
	 * 
	 * @param float $unitPrice
	 */

	public function setUnitPrice($unitPrice)
	{
		$this->unitPrice = $unitPrice;
	}

	/**
	 * Get discount
	 *
	 * @return float
	 */

	public function getDiscount()
	{
		return $this->discount;
	}

	/**
	 * Set discount
	 * 
	 * @param float $discount
	 */

	public function setDiscount($discount)
	{
		$this->discount = $discount;
	}

	/**
	 * Get total price
	 *
	 * @return float
	 */

	public function getTotalPrice()
	{
		return $this->totalPrice;
	}

	/**
	 * Set total price
	 * 
	 * @param float $totalPrice
	 */

	public function setTotalPrice($totalPrice)
	{
		return $this->totalPrice = $totalPrice;
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