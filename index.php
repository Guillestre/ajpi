<!DOCTYPE html>
<html>

	<head>
		<?php
			include 'ext/header.php';
			include 'script/script_handler.php';
			include __DIR__.'/vendor/autoload.php';
		?>
		<link rel="stylesheet" href="styles/logIn.css">
		<title>Accueil</title>
	</head>

	<body>

		<h1>AJPI Records</h1>

		<div class="signInBox">

			<h2>Se connecter : </h2>

			<form action="index.php" method="post">
				
				<div class="grid-container-index">

					<div class="grid-item-label">
						<label for="username">Nom d'utilisateur : </label>
					</div>

					<div class="grid-item-input-text">
						<input type="text" id="username" name="username">
					</div>

					<div class="grid-item-label">
						<label for="password">Mot de passe : </label>
					</div>

					<div class="grid-item-input-text">
						<input type="password" id="password" name="password">
					</div>

					<div class="grid-item-label">
						<label for="password">Code secret : </label>
					</div>

					<div class="grid-item-input-text">
						<input type="password" id="otp" name="otp" maxlength="6" size="6">
					</div>

					<div class="grid-item-input-button">
						<input type="submit" name="logIn" value="Se connecter">
					</div>

					<div class="grid-item-input-button">
						<input type="submit" name="createAccount" value="Créer un compte">
					</div>

					<?php 
						
						$accountExist = false;
						$otpCorrect = false;

						//We use TOTP
						use OTPHP\TOTP;

						//Verify if user isn't already connected
						if(isset($_SESSION['username']))
							header("Location: dashboard.php");

						//Verify if logIn button has been clicked
						if(isset($_POST['logIn']))
						{

							//Store username, password and secret from the ancient form
							$username = $_POST['username'];
							$password = $_POST['password'];
							$otp = $_POST['otp'];

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

									//Create TOTP with secret from the user
								    $totp = TOTP::create($row['secret']);

								   	//Set label
								   	$totp->setLabel('AJPI');

								   	//Verify if secret code entered is correct
									if($totp->verify(htmlspecialchars($otp)))
									{

										$otpCorrect = true;

										//If code is correct, add his username into session  
										$_SESSION['username'] = $username;

										//And redirect to the dashboard
										header("Location: dashboard.php");
									}	
								}
							}
						}

					?>

				</div>

			</form>

			<?php

				if(!$accountExist)
					print("<div class='error_message'><p>Ce compte n'existe pas</p></div>");

				if(!$otpCorrect)
					print("<div class='error_message'><p>Le code secret n'est pas correct</p></div>");
	
			?>

		</div>

	</body>

</html>
