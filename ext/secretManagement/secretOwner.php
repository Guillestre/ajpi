<!-- EXT THAT DISPLAY SECRET INFO ABOUT THE CONNECTED USER -->

<?php

	//Get owner data
	$secretId = $user->getSecretId();
	$code = htmlspecialchars($secretDao->getCode($secretId));
	$label = htmlspecialchars($secretDao->getLabel($secretId));

	//We use TOTP
	use OTPHP\TOTP;

	//Prepare TOTP
    $totp = TOTP::create($code);
    $totp->setLabel($label);

    //Get URI from QR CODE
    $uri = $totp->getProvisioningUri();

    //set link
    $link = "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=${uri}";

    //Set link to secret page
	$refSecret = "secret.php?secretId={$secretId}";
?>



<!-- OWNER SECRET ----------------------->


<h2>Ma clé : </h2>

<div class="grid-container-userForm">

	<!-- LABEL -->

	<div class="grid-item-label" >
		<label for="ownerLabel">Votre clé actuelle : </label>
	</div>

	<div class="grid-item-text" id="ownerLabel">
		<?php print($label); ?>
	</div>

	<!-- QR CODE -->

	<div class="grid-item-label">
		<label for="ownerQRCode">QR CODE de la clé : </label>
	</div>

	<div class="grid-item-text" id="ownerQRCode">
 		<img alt="<?php echo "QR CODE clé ${label}"; ?>" src="<?php echo $link; ?>">
	</div>

</div>

<div></div>

<?php

//If user is a client, then display his secret code here
if(!$isAdmin){
?>

<!-- SECRET -->
<p>Code de la clé : </p>
<?php print("<p>" . $code . "</p>") ?>

<?php } ?>