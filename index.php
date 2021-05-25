<!DOCTYPE html>
<html>

	<head>
		<?php
			include 'ext/header.php';
			include 'script/script_handler.php';
		?>
		<link rel="stylesheet" href="styles/logIn.css">
		<title>Accueil</title>
	</head>

	<body>

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

				<div class="grid-item-input-button">
					<input type="submit" name="logIn" value="Se connecter">
				</div>

				<?php 
					
					//Verify if user isn't already connected
					if(isset($_SESSION['username']))
						header("Location: dashboard.php");

					//Verify if button logIn has been clicked
					if(isset($_POST['logIn']))
					{
						//Make request to fetch this user
						$sql= "SELECT * FROM users WHERE username = :username"; 
						$step = $database->prepare($sql);
						$step->bindValue(":username", $_POST['username']); 
						$step->execute();

						//Retrieve number of record
						$nbResult = $step->rowCount();
						if($nbResult != 0)
						{
							//Fetch the row looked for
							$row = $step->fetch(PDO::FETCH_ASSOC);

							//Verify if entered password is correct
							if(sha1($_POST['password']) == $row['password'])
							{
								$username = $_POST['username'];
								$password = $_POST['password'];
								//Redirect user toward verify.php for second authentification
								header("Location: verify.php?username=" . urlencode($username) . "&password=" . urlencode($password));
							}
						}
						print("<div class='grid-item-input-text'>
							<p class='error_message'>Ce compte n'existe pas</p>
							</div>");
					}
					
				?>

			</div>

		</form>

	</body>

</html>
