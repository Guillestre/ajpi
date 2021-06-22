<?php 

//We use TOTP
use OTPHP\TOTP;

if(!$emptyResult){ ?>

	<table class="secretTable">

		<thead>
			<tr>

				<th>
					<button class="col-button-title" name="column" value="label">
						<?php if(strcmp($column, "label") == 0) { ?>
							<i class='fas fa-caret-<?php print $direction; ?>'> 
								Nom clé
							</i>
						<?php } else { ?>
							Nom clé
						<?php } ?>
					</button>
				</th>

			</tr>
		</thead>
<?php 

	foreach($fetchedSecrets as $secret)
	{
		//Prepare Secret
		$totp = TOTP::create($secret->getCode());
		$totp->setLabel($secret->getLabel());
		
		//Set label and id
		$label = htmlspecialchars($secret->getLabel());
		$secretId = htmlspecialchars($secret->getId());

		//Set link to secret page
		$refSecret = "secret.php?secretId={$secretId}";

		//If we are an admin
		if($isAdmin){
			print("
				<tr>
					<td>
						<a href='{$refSecret}'>
							{$label}
						</a>
					</td>
				</tr>	
			");
		}
		//If we are an user client
		else if($user->getSecretId() == $secret->getId())
			print("
				<tr>
					<td>
						<a href='{$refSecret}'>
							{$label}
						</a>
					</td>
				</tr>
			");
	}

	print("</table>");
} else
	messageHandler::sendInfoMessage("Aucune clé est présente");

?>