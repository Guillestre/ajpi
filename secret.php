<!-- FILE THAT DISPLAY INFORMATIONS ABOUT A SPECIFIC KEY -->

<?php include "ext/common.php"; ?>
<?php include 'ext/search/fetchData.php'?>

<!DOCTYPE html>
<html lang="fr">

	<!-- HEADER -->

	<?php include 'ext/header.php'; ?>

	<body>

		<!-- MENU -->

		<?php include 'ext/menu.php';?>


		<!-- RESULT -->

		<?php

			//We use TOTP
			use OTPHP\TOTP;

			//Set redirection to previous page
			$redirection = "location:javascript://history.go(-1)";

			//Check if secret id from url exist
			if(!isset($_GET['secretId']))
				header($redirection);

			//Get secretId from GET
			$secretId = $_GET['secretId'];

			//Check if secret id is not empty
			if(strcmp(trim($secretId), "") == 0)
				header($redirection);

			//Get data from the key
			$label = $secretDao->getLabel($secretId);
			$code = $secretDao->getCode($secretId);

			//Check if the key exist
			if(!$secretDao->exist($label))
				header($redirection);

			//Prepare TOTP
		    $totp = TOTP::create($code);
		    $totp->setLabel($label);

		    //Get URI from QR CODE
		    $uri = $totp->getProvisioningUri();

		    //set link
    		$link = "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=${uri}";
		?>

		<h1> Clé <?php print($label);?> </h1>

		<div class="userBox">

			<!-- QR CODE -->

			<div class="grid-container-userForm">

				<div class="grid-item-label">
					<label for="ownerQRCode">QR CODE de la clé : </label>
				</div>

				<div class="grid-item-text" id="ownerQRCode">
			 		<img alt="<?php echo "QR CODE clé ${label}"; ?>" src="<?php echo $link; ?>">
				</div>

			</div>

			<div></div>
			
			<!-- SECRET -->

			<p>Code de la clé : </p>
			<?php print("<p>" . $code . "</p>") ?>
				
		</div>

		<!-- FOOTER -->

		<div class="footer">

			<div>
				<button onclick="history.back()">
					Retour
				</button>
			</div>
			
		</div>

	</body>

	<?php include "ext/footer.php" ?>

</html>
