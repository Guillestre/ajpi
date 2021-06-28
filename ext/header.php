<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">

	<?php //Set title

		switch ($currentPage) {
			case 'index.php':
				$title = "Connexion";
				break;
			
			case 'dashboard.php':
				$title = "Tableau de bord";
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

			case 'secretManagement.php':
				$title = "Clés";
				break;

			case 'secret.php':
				$secretId = $_POST['secretId'];
				$title = "Clé " . $secretDao->getLabel($secretId);
				break;
		}
		print("<title>${title}</title>");
	?>

</head>