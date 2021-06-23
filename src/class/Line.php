<!-- CLASS THAT DESCRIBE A LINE ITEM -->

<?php

class Line
{
	private $articleCode;
	private $designation;
	private $amount;
	private $unitPrice;
	private $discount;
	private $totalPrice;
	private $description;

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

	public function getArticleCode()
	{
		return $this->articleCode;
	}

	public function setArticleCode($articleCode)
	{
		$this->articleCode = $articleCode;
	}

	public function getDesignation()
	{
		return $this->designation;
	}

	public function setDesignation($designation)
	{
		$this->designation = $designation;
	}

	public function getAmount()
	{
		return $this->amount;
	}

	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	public function getUnitPrice()
	{
		return $this->unitPrice;
	}

	public function setUnitPrice($unitPrice)
	{
		$this->unitPrice = $unitPrice;
	}

	public function getDiscount()
	{
		return $this->discount;
	}

	public function setDiscount($discount)
	{
		$this->discount = $discount;
	}

	public function getTotalPrice()
	{
		return $this->totalPrice;
	}

	public function setTotalPrice($totalPrice)
	{
		return $this->totalPrice = $totalPrice;
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