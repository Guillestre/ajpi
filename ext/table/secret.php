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

				<th>
					<button class="col-button-title" name="column" value="code">
						<?php if(strcmp($column, "code") == 0) { ?>
							<i class='fas fa-caret-<?php print $direction; ?>'> 
								Code
							</i>
						<?php } else { ?>
							Code
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
		
		//Set label and code
		$label = htmlspecialchars($secret->getLabel());
		$code = htmlspecialchars($secret->getCode());

		if($isAdmin){
			print("
				<tr>
					<td>
						{$label}
					</td>
					<td>
						${code}
					</td>
				</tr>	
			");
		}
		else if($user->getSecretId() == $secret->getId())
			print("
				<tr>
					<td>
						{$label}
					</td>
					<td>
						${code}
					</td>
				</tr>		
			");
	}

	print("</table>");
} else
	messageHandler::sendInfoMessage("Aucune clés est présente");

?>