<?php 

/* CLASS THAT DESCRIBE A SECRET */

class Secret
{

	private $id;
	private $code;
	private $label;

	function __construct($id, $code, $label) {
		$this->id = $id;
		$this->code = $code;
		$this->label = $label;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function setCode($code)
	{
		$this->id = $code;
	}

	public function getLabel()
	{
		return $this->label;
	}

	public function setLabel($label)
	{
		$this->label = $label;
	}

}

?>