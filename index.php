<!DOCTYPE html>
<html>

	<head>
		<?php 
			set_time_limit(300);
			/*
			include 'script/users.php';
			include 'script/sage2016_clients.php';
			include 'script/sage2016_invoices.php';
			include 'script/sage2016_invoiceLine.php';
			
			include 'script/sage2019_clients.php';
			include 'script/sage2019_invoices.php';
			include 'script/sage2019_invoiceLine.php';
			
			include 'script/sage_clients.php';
			include 'script/sage_invoices.php';
			include 'script/sage_invoiceLine.php';

			include 'script/odoo_clients.php';
			include 'script/odoo_invoices.php';
			include 'script/odoo_invoiceLine.php';
			
			include 'script/clients.php';
			include 'script/invoices.php';
			include 'script/invoiceLine.php';
			*/
			//header("Location: dashboard.php");
			include 'ext/header.php';
			require_once __DIR__.'/vendor/autoload.php';
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
