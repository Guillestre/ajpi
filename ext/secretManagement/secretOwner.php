<?php

	//Get owner data
	$username = $user->getUsername();
	$status = $user->getStatus();
	$id = $user->getId();
	$secretId = $user->getSecretId();
	$code = $secretDao->getCode($secretId);
	$label = $secretDao->getLabel($secretId);

	//We use TOTP
	use OTPHP\TOTP;

	//Prepare TOTP
    $totp = TOTP::create($code);
    $totp->setLabel($label);

    //Get URI from QR CODE
    $uri = $totp->getProvisioningUri();

    //set link
    $link = "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=${uri}";
?>

<div class="grid-container-userFormGroup">

	<!-- OWNER SECRET ----------------------->

	<div>
		<h2>Ma clé : </h2>

		<div class="grid-container-userForm">

			<div class="grid-item-label" >
				<label for="ownerLabel">Votre clé actuelle : </label>
			</div>

			<div class="grid-item-text" id="ownerLabel">
		 		<?php echo $secretDao->getLabel($user->getSecretId()); ?>
			</div>

			<div class="grid-item-label">
				<label for="ownerQRCode">QR CODE de la clé : </label>
			</div>

			<div class="grid-item-text" id="ownerQRCode">
		 		<img alt="<?php echo "QR CODE clé ${label}"; ?>" src="<?php echo $link; ?>">
			</div>

		</div>

		<div></div>

		<!-- SECRET CODE ----------------------->

		<?php if(!$isAdmin){ ?>

			code de la clé : <?php print($code); ?> 

		<?php } ?>
			
	</div>

</div>
			

	

	
