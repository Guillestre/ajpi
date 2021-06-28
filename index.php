<!-- WELCOME PAGE WHERE USER LOG IN --> 

<?php include "ext/common.php"; ?>
<?php include 'script/scriptHandler.php'; ?>

<!DOCTYPE html>
<html lang="fr">

	<?php include 'ext/header.php'; ?>
	
	<body>

		<h1>AJPI Records</h1>

		<div class="userBox">

			<h2>Connexion : </h2>

			<form action="processForm.php" method="post">
				
				<!-- RADIO ----------------------------------->

				<div>

					<!-- USER IS A CLIENT -->

					<input 
					type="radio" id="clientConnection" name="action" value="clientConnection"
					onclick="displayClientHandler()" 
					<?php
						if(isset($_GET['status'])){
							if(strcmp($_GET['status'], "client") == 0)
								print("checked");
						} else
							print("checked");
					?>
					/>

					<label for="clientConnection">Client</label>

					<!-- USER IS AN ADMIN -->

					<input type="radio" id="adminConnection" name="action" value="adminConnection"
					onclick="displayClientHandler()"
					<?php
						if(isset($_GET['status'])){
							if(strcmp($_GET['status'], "admin") == 0)
								print("checked");
						}
					?>
					/>
					<label for="adminConnection">Staff</label>
		
				</div>

				<!-- FORM WHERE USER ENTER HIS INFORMATIONS -->

				<div class="grid-container-userForm">

					<!-- USERNAME -->

					<div class="grid-item-label">
						<label for="username">Nom d'utilisateur : </label>
					</div>

					<div class="grid-item-input-text">
						<input type="text" id="username" name="username" required />
					</div>

					<!-- PASSWORD -->

					<div class="grid-item-label">
						<label for="password">Mot de passe : </label>
					</div>

					<div class="grid-item-input-text">
						<input type="password" id="password" name="password" required />
					</div>

					<!-- SECRET CODE -->

					<div class="grid-item-label">
						<label for="otp">Code secret : </label>
					</div>

					<div class="grid-item-input-text">
						<input type="password" id="otp" name="otp" maxlength="6" size="6" required/>
					</div>

					<div class="grid-item-input-button">
						<button type="submit">
							Se connecter
						</button>
					</div>

					<!-- ERROR MESSAGES -->

					<?php
						if(isset($_GET['errorConnection'])){
							$message = htmlspecialchars($_GET['errorConnection']);
							messageHandler::sendErrorMessage($message);
						}
					?>

				</div>

			</form>

		</div>
		
		<!-- ALERT MESSAGES -->

		<?php
			if(isset($_GET['deleteOwnerSuccess']))
					messageHandler::sendSuccessMessage($_GET['deleteOwnerSuccess']);
		?>

		<?php
			if(isset($_GET['logOffSuccess']))
					messageHandler::sendSuccessMessage($_GET['logOffSuccess']);
		?>

	</body>

</html>

