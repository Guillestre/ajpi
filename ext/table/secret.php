<?php 

//We use TOTP
use OTPHP\TOTP;

$emptyResult = $fetchedSecrets == NULL;

if(!$emptyResult){ ?>

	<table>

		<thead>
			<tr>
				<th>
					<button class="col-button-title" name="column" value="label">
						<?php if(strcmp($column, "label") == 0) { ?>
							<i class='fas fa-caret-<?php print $direction; ?>'> 
								Label
							</i>
						<?php } else { ?>
							Label
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
		//Prepare TOTP
		$totp = TOTP::create($secret->getCode());
		$totp->setLabel($secret->getLabel());
		
		$label = htmlspecialchars($secret->getLabel());
		$code = htmlspecialchars($secret->getCode());
		$period = htmlspecialchars($totp->getPeriod());
		$secretId = $secret->getId();
		$refSecretCode = "showSecretCode.php?secretId={$secretId}";

		if($isAdmin){
			print("
				<tr>
					<td>
						{$label}
					</td>
					<td style='font-size: 11pt;'>
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
						<a href='{$refSecretCode}'> 
							Voir code 
						</a>
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