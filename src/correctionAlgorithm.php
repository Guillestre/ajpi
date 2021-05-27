<?php

	class correctionAlgorithm
	{

		private $database;
		private $table_name;

		function __construct($table_name, $database) {
			$this->database = $database;
			$this->table_name = $table_name;
		}

		public function algo_1()
		{

			/*
			*This algo will differentiate article code if there are on several lines with different total price not equal to zero
			*/

			//Get all invoiceCode
			$query = "SELECT DISTINCT invoiceCode FROM $this->table_name";
			$codes = $this->database->query($query)->fetchAll();

			//Fetch each invoice
			foreach($codes as $code){

				//Get all articles code with total price not equal to zero
				$query = "
				SELECT * FROM $this->table_name WHERE invoiceCode = '". $code['invoiceCode'] . "' 
				AND (totalPrice != 0 OR amount != 0 OR unitPrice != 0 OR discount != 0) 
				AND articleCode != '' 
				ORDER BY articleCode ASC;
				";

				$lines = $this->database->query($query)->fetchAll();
				$offset = "";

				//Fetch each article
				foreach($lines as $line)
				{
					if(!isset($articleCode))
						$articleCode = $line['articleCode'];
					else
					{
						if($line['articleCode'] == $articleCode)
						{
							$offset .= "*";
							$step=$this->database->
							prepare("UPDATE $this->table_name SET articleCode = :articleCode WHERE id = :id");
							$param = $articleCode . $offset;
							$step->bindParam(':articleCode', $param);
							$step->bindParam(':id', $line['id']);
							$step->execute();
						}
						else
						{
							$offset = "";
							$articleCode = $line['articleCode'];
						}
					}
				}
			}

		}

		public function algo_2()
		{
			/*
			*This algo will link each lines with totalPrice = 0 to their respective article code for each invoice
			*/

			//Get all invoiceCode
			$query = "SELECT DISTINCT invoiceCode FROM $this->table_name";
			$codes = $this->database->query($query)->fetchAll();

			//Fetch each invoice code
			foreach($codes as $code){

				//Get each lines from a specific invoice
				$query = "SELECT * FROM $this->table_name WHERE invoiceCode = '" . $code['invoiceCode'] . "'";
				$lines = $this->database->query($query)->fetchAll();

				//Fetch each line
				foreach($lines as $line)
				{
					//Get new articleCode
					$new_articleCode = $line['articleCode'];

					//Get current total price
					$totalPrice = $line['totalPrice'];

					//Get current unit price
					$unitPrice = $line['unitPrice'];

					//Get current discount
					$discount = $line['discount'];

					//Get current amount
					$amount = $line['amount'];

					if(!isset($current_articleCode) && TRIM($new_articleCode) != '')
						$current_articleCode = $new_articleCode;
					else if(TRIM($new_articleCode) != '' && $new_articleCode != $current_articleCode)
						$current_articleCode = $new_articleCode;

					$isComment = $totalPrice == 0 && $unitPrice == 0 && $amount == 0;

					if(isset($current_articleCode) && TRIM($new_articleCode) == '' && $isComment) 
					{
						$step=$this->database->
						prepare("UPDATE $this->table_name SET articleCode = :articleCode WHERE id = :id");
						$step->bindParam(':articleCode', $current_articleCode);
						$step->bindParam(':id', $line['id']);
						$step->execute();
					}

				}
				unset($current_articleCode);
			}

		}

		public function algo_3()
		{
			//Get all invoiceCode
			$query = "SELECT DISTINCT id, invoiceCode FROM $this->table_name";
			$codes = $this->database->query($query)->fetchAll();

			$current_invoiceCode = '';

			foreach($codes as $code){
				
				$new_invoiceCode = $code['invoiceCode'];

				if(TRIM($new_invoiceCode)  == '' && TRIM($current_invoiceCode) != '')
				{
						$step=$this->database->prepare("UPDATE $this->table_name SET invoiceCode = '" . $current_invoiceCode . "' WHERE id = " . $code['id']);
						$step->execute();
				}
				else
					$current_invoiceCode = $new_invoiceCode;
				
			}
		}

	}

?>