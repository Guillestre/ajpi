<!DOCTYPE html>
<html>

	<head>
		<?php
			include 'ext/header.php';
			include __DIR__.'/vendor/autoload.php';
		?>
		<link rel="stylesheet" href="styles/logIn.css">
		<title>Vérification</title>
	</head>

	<body>

		<form 
		action="verify.php?username=<?php echo $_GET['username'] . "&password=" . $_GET['password'] ?>" 
		method="post"
		>
			<div class="grid-container-verify">

				<div class="grid-item-label">
					<label for="otp">Code OTP : </label>
				</div>

				<div class="grid-item-input-text">
					<input type="text" id="otp" name="otp" size="6" maxlength="6">
				</div>

				<div class="grid-item-input-button">
					<input type="submit" name="validate_otp" value="Valider">
				</div>

				<?php

					//Verify if user isn't already connected
					if(isset($_SESSION['username']))
						header("Location: dashboard.php");

					//Make request to fetch the concerned user
					$sql= "SELECT * FROM users WHERE username = :username AND password = :password"; 
					$step = $database->prepare($sql);
					$step->bindValue(":username", $_GET['username']); 
					$step->bindValue(":password", sha1($_GET['password'])); 
					$step->execute();

					//Retrieve number of record
					$nbResult = $step->rowCount();

					//Verify if a result was found
					if($nbResult == 0)
						header("Location: index.php");

					//Fetch the row looked for
					$row = $step->fetch(PDO::FETCH_ASSOC);

					//We use TOTP
					use OTPHP\TOTP;

					//Create TOTP with secret from the user
				    $otp = TOTP::create($row['secret']);

				   	//Set label
				   	$otp->setLabel('AJPI');

					//Verify code entered
					if(isset($_POST['validate_otp']))
					{
						if($otp->verify(htmlspecialchars($_POST['otp'])))
						{
							//If code is correct, add his username into session  
							$_SESSION['username'] = $_GET['username'];

							//And redirect to the dashboard
							header("Location: dashboard.php");
						}
						print("<div class='grid-item-input-text'>
							<p class='error_message'>Le code n'est pas correct</p>
							</div>");
					}

				?>

			</div>

		</form>

	</body>

</html>

<?php

	function showQRCODE($otp)
	{
		//Displaying QR CODE
		$google_chart = $otp->getQrCodeUri('https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl={PROVISIONING_URI}',
		'{PROVISIONING_URI}');
		print("<img src='" . $google_chart . "'/>");
	}

?>