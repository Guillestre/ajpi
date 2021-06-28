<?php 

/**
 *  CLASS THAT DESCRIBE A SECRET 
 * */

class Secret
{

	private $id;
	private $code;
	private $label;

	/**
	 * Construct
	 * 
	 * @param integer $id
	 * @param integer $code
	 * @param integer $label
	 * */

	function __construct($id, $code, $label) {
		$this->id = $id;
		$this->code = $code;
		$this->label = $label;
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */

	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set id
	 *
	 * @param integer $id
	 */

	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * Get code
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
		$this->id = $code;
	}

	/**
	 * Get label
	 *
	 * @return string
	 */

	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * Set label
	 *
	 * @param string $label
	 */

	public function setLabel($label)
	{
		$this->label = $label;
	}

}

?>