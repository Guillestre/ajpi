<!DOCTYPE html>
<html>

	<head>
		<?php
			include 'ext/header.php';
			include 'vendor/autoload.php';
			include 'script/script_handler.php';
		?>
		<title>Accueil</title>
	</head>

	<body>

		<form action="index.php" method="post">
			
			<label for="username">Nom d'utilisateur : </label>
			<input type="text" id="username" name="username" size="30">
			<br/>
			<label for="password">Mot de passe : </label>
			<input type="password" id="password" name="password" size="30">
			<br/>
			<input type="submit" name="logIn" value="Se connecter">
	
		</form>

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
				print("Ce compte n'existe pas");
			}
			
		?>

	</body>

</html>
