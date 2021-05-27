<?php

	abstract class User
	{

		public function signIn($username, $password, $otp)
		{


			$database = mysqlConnection::getInstance();
			$accountExist = false;
			$otpCorrect = false;

			//Make request to fetch this user
			$sql= "SELECT * FROM users  WHERE username = :username AND password = :password"; 
			$step = $database->prepare($sql);
			$step->bindValue(":username", $username); 
			$step->bindValue(":password", sha1($password)); 
			$step->execute();

			//Retrieve number of record
			$nbResult = $step->rowCount();

			if($nbResult != 0)
			{
				$accountExist = true;

				//Fetch the row looked for
				$row = $step->fetch(PDO::FETCH_ASSOC);

				//Verify if entered password is correct
				if(sha1($password) == $row['password'])
				{

					//Set secret
					A2F::setSecret($row['secret'], 'AJPI');

					
				   	//Verify if secret code entered is correct
					if(A2F::verify($otp))
					{
						$otpCorrect = true;

						//If code is correct, add his username into session  
						$_SESSION['username'] = $username;

						//And redirect to the dashboard
						header("Location: dashboard.php");
					}	
				}
			}

			if(!$accountExist)
				messageHandler::sendErrorMessage("Ce compte n'existe pas");
			else if(!$otpCorrect)
				messageHandler::sendErrorMessage("Le code secret n'est pas correct");
		}

		public function signUp($username, $password)
		{

		}

	}

?>