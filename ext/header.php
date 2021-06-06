<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">

	<?php //Set title

		switch ($currentPage) {
			case 'index.php':
				$title = "Connexion";
				break;
			
			case 'dashboard.php':
				$title = "Factures clients";
				break;

			case 'client.php':
				$code = $_GET['clientCode'];
				$title = "Client ${code}";
				break;

			case 'invoice.php':
				$code = $_GET['invoiceCode'];
				$title = "Facture ${code}";
				break;

			case 'userManagement.php':
				$title = "Gérer utilisateurs";
				break;

			case 'alterUser.php':
				$username = $_GET['username'];
				$title = "Modification utilisateur ${username}";
				break;
		}
		print("<title>${title}</title>");
	?>

</head>