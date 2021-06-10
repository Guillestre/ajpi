<?php

/* FILE THAT EXECUTE RECEIVED DATA FROM FORMS */

include "ext/common.php";

//Verify if action has been performed
if(!isset($_POST['action']))
{
	$redirection = "location:javascript://history.go(-1)";
	header($redirection);
}

//Get action from FORM
$action = $_POST['action'];

//We use TOTP
use OTPHP\TOTP;

//Set DAO
$userDao = new UserMySQLDao();
$secretDao = new SecretMySQLDao();
$clientDao = new ClientMySQLDao();

switch($action)
{

	/* USER CONNECTION *****************************************/

	case "adminConnection" : case "clientConnection" :

		//Set status according connection mode
		if($action == "adminConnection")
			$status = "admin";
		else
			$status = "client";

		//Get POST values
		$username = $_POST['username'];
		$password = $_POST['password'];
		$otp = $_POST['otp'];

		//Check if entered username exist
		if(!$userDao->exist($username, $status))
		{
			//Prepare message
			$text = "Cet utilisateur existe pas";
			$errorMessage = $text;

			//Redirection
			$url = "Location: index.php?errorConnection=${errorMessage}";
			header($url);
			break;
		}

		//Prepare TOTP
		$id = $userDao->getId($username, $status);
		$user = $userDao->getUser($id, $status);
		$code = $secretDao->getCode($user->getSecretId());
	    $totp = TOTP::create($code);

		//Check if entered otp is correct
		if(!$totp->verify($otp))
		{
			//Prepare error message
			$text = "Le code secret est incorrect";
			$errorMessage = $text;

			//Redirection
			$url = "Location: index.php?errorConnection=${errorMessage}";
			header($url);
			break;
		}

		//If passed all test, connect user
		$_SESSION['user'] = $user;
		$url = "Location: dashboard.php";
		header($url);
		break;

	/* ADD USER *****************************************/

	case "addUser" :

		//Get POST values
		$username = $_POST['username'];
		$password = $_POST['password'];
		$status = $_POST['status'];
		$clientCode = $_POST['clientCode'];
		$label = $_POST['label'];
		$isAdmin = $status == "admin";

		//Check if entered username is not empty
		if(strcmp(trim($username), "") == 0)
		{
			//Prepare error message
			$text = 
			"Vous ne pouvez pas mettre un nom d'utilisateur vide";
			$errorMessage = $text;

			//Redirection
			$url = "Location: userManagement.php?addUserError=${errorMessage}";
			header($url);
			break;
		}

		//Check if password is not empty
		if(strcmp(trim($password), "") == 0)
		{
			//Prepare error message
			$text = "Vous ne pouvez pas mettre un mot de passe vide";
			$errorMessage = $text;

			//Redirection
			$url = "Location: userManagement.php?addUserError=${errorMessage}";
			header($url);
			break;
		}

		//Check if entered username already exist
		if($userDao->exist($username, $status))
		{
			//Prepare error message
			$text = "Ce nom d'utilisateur est déjà pris";
			$errorMessage = $text;

			//Redirection
			$url = "Location: userManagement.php?addUserError=${errorMessage}";
			header($url);
			break;
		}

		//Get next id
		$secretId = $secretDao->getId($label);
		$id = $userDao->getLastId($status) + 1;

		//Adapt according status
		if(!$isAdmin)
		{
			//Get client name
			$clientName = $clientDao->getClientName($clientCode);

			//Get owner from the client
			$owner = $userDao->getClientUser($clientCode);

			//Check if chosen client is already token
			if($userDao->takenClientCode($clientCode))
			{
				//Prepare error message
				$text = "Le client {$clientName} est déjà pris par l'utilisateur {$owner->getUsername()}";
				$errorMessage = $text;

				//Redirect
				$url = "Location: userManagement.php?addUserError=${errorMessage}";
				header($url);
				break;
			}

			//Prepare success message
			$text = "L'utilisateur client ${username} lié au client ${clientName} a bien été enregistré";
			$successMessage = $text;

			//Create client user
			$user = new ClientUser ($id, $username, $password, $secretId, $clientCode);

		} else {

			//Prepare success message
			$text = "L'administrateur ${username} a bien été enregistré";
			$successMessage = $text;

			//Create admin user
			$user = new AdminUser ($id, $username, $password, $secretId);

		}

		//Insert user
		$result = $userDao->insertUser($user, $status);

		//Check if user has been insert
		if(!$result)
		{
			//Prepare error message
			$text = 
			"Une erreur est survenue. L'utilisateur a pas pu être ajouté";
			$errorMessage = $text;

			//Redirection
			$url = "Location: userManagement.php?addUserError=${errorMessage}";
			header($url);
			break;
		}

		//Redirection
		$url = "Location: userManagement.php?addUserSuccess=${successMessage}";
		header($url);
		break;

	/* DELETE USER *****************************************/

	case "deleteUser" :

		//Get status from POST
		$status = $_POST['status'];

		//Get right username according the status
		if(strcmp($status, "admin") == 0)
			$id = $_POST['adminId'];
		else
			$id = $_POST['clientId'];

		//Get username
		$username = $userDao->getUser($id, $status)->getUsername();

		if(strcmp($status, "admin") == 0)
		{
			//Check if is owner
			$isOwner = $user->getId() == $id;

			//Count how many admin in database
			$nbAdmins = $userDao->countUser("admin");

			//Check if there are more than one admin
			if($nbAdmins == 1)
			{
				if($isOwner){
					//Prepare error message
					$text = "Impossible. Vous êtes le seul administrateur";
					$errorMessage = $text;

					//Redirection
					$url = "Location: userManagement.php?deleteUserError=${errorMessage}";
					header($url);
					break;
				} else {
					//Prepare error message
					$text = "Impossible. ${username} est le seul administrateur";
					$errorMessage = $text;

					//Redirection
					$url = "Location: userManagement.php?deleteUserError=${errorMessage}";
					header($url);
					break;
				}
			}

		} else
			$isOwner = false;

		//Delete user
		$result = $userDao->deleteUser($id, $status);
		
		//Check if user has been deleted
		if(!$result)
		{
			//Prepare error message
			$text = 
			"Une erreur est survenue. L'utilisateur a pas pu être supprimé";
			$errorMessage = $text;

			//Redirection
			$url = "Location: userManagement.php?deleteUserError=${errorMessage}";
			header($url);
			break;
		}

		//Prepare success message
		if(!$isOwner){
			$text = "L'utilisateur ${username} a bien été supprimé";
			$successMessage = $text;

			//Redirection
			$url = "Location: userManagement.php?deleteUserSuccess=${successMessage}";
			header($url);
		} else {
			$text = "Votre compte a bien été supprimé";
			$successMessage = $text;

			session_destroy();
			//Redirection
			$url = "Location: index.php?deleteOwnerSuccess=${successMessage}";
			header($url);
		}

		break;

	/* ALTER USER *****************************************/

	case "alterUsername" : case "alterPassword" : 
	case "alterSecret" : case "alterClient" :

		//Get status from POST
		$status = $_POST['status'];

		//Get right username according the status
		if(strcmp($status, "admin") == 0)
		{
			$id = $_POST['adminId'];

			//Check if is owner
			$isOwner = $user->getId() == $id;
		}
		else
		{
			$id = $_POST['clientId'];
			$isOwner = false;
		}

		//Set username according the status and id
		$username = $userDao->getUser($id, $status)->getUsername();
		
		/* ALTER USERNAME */

		if(strcmp($action, "alterUsername") == 0){

			//Get new username from POST
			$newUsername = $_POST['newUsername'];

			//Check if new username is not empty
			if( strcmp(trim($newUsername), "") == 0 )
			{
				//Prepare message
				$text = 
				"Vous ne pouvez pas mettre un nom d'utilisateur vide";
				$errorMessage = $text;

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Check if new username already exist
			if($userDao->exist($newUsername, $status))
			{
				//Prepare error message
				if($isOwner && strcmp($user->getUsername(), $newUsername) == 0){
					$text = "Vous posséder déjà ce nom d'utlisateur";
					$errorMessage = $text;
				} else {
					$text = "Ce nom d'utilisateur est déjà pris";
					$errorMessage = $text;
				}

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
	
				break;
			}
				
			//Execute
			$result = $userDao->updateUsername($id, $newUsername, $status);

			//Check if update has succeed
			if(!$result){
				//Prepare error message
				$text = 
				"Une erreur est survenue. Le nom d'utilisateur n'a pas pu être modifié";
				$errorMessage = $text;

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Prepare success message
			if(!$isOwner){
				$text = "Le nom de l'utilisateur ${username} est maintenant ${newUsername}";
				$successMessage = $text;
			} else {
				$text = "Votre nom d'utilisateur est maintenant ${newUsername}";
				$successMessage = $text;

				//Update owner
				$user->setUsername($newUsername);
				$_SESSION['user'] = $user;
			}

			//Redirection
			$url = "Location: userManagement.php?alterUserSuccess=${successMessage}";
			header($url);

		/* ALTER PASSWORD */

		} else if(strcmp($action, "alterPassword") == 0){

			//Get new password from POST
			$newPassword = $_POST['newPassword'];

			//Get password from the id
			$password = $userDao->getPassword($id, $status);

			//Check if newPassword is not empty
			if(strcmp(trim($newPassword), "") == 0)
			{
				//Prepare error message
				$text = "Vous ne pouvez pas mettre un mot de passe vide";
				$errorMessage = $text;

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Hash password
			$newPassword = sha1($newPassword);

			//Verify if it is the password that selected user has
			if(strcmp($newPassword, $password) == 0)
			{
				//Prepare error message
				if($isOwner && strcmp($user->getPassword(), $newPassword) == 0){
					$text = "Vous posséder déjà ce mot de passe";
					$errorMessage = $text;
				} else {
					$text = "Cet utilisateur possède déjà ce mot de passe";
					$errorMessage = $text;
				}

				//redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}
				
			//Execute
			$result = $userDao->updatePassword($id, $newPassword, $status);

			//Check if update has succeed
			if(!$result){

				//Prepare error message
				$text = "Une erreur est survenue. Le mot de passe n'a pas pu être modifié";
				$errorMessage = $text;
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				
				//Redirection
				header($url);
				break;
			}

			//Prepare success message
			if(!$isOwner){
				$text = "Le mot de passe de l'utilisateur ${username} a été modifié";
				$successMessage = $text;
			} else {
				$text = "Votre mot de passe a été modifié";
				$successMessage = $text;

				//Update owner
				$user->setPassword($newPassword);
				$_SESSION['user'] = $user;
			}

			//Redirection
			$url = "Location: userManagement.php?alterUserSuccess=${successMessage}";
			header($url);

		/* ALTER SECRET */

		} else if(strcmp($action, "alterSecret") == 0){

			//Get new label from POST
			$newLabel = $_POST['newLabel'];

			//Set secretId according the status
			$secretId = $userDao->getSecretId($id, $status);

			//Get new secret Id
			$newSecretId = $secretDao->getId($newLabel);

			//Verify if it is the secret that user has
			if(strcmp($newSecretId, $secretId) == 0)
			{
				//Prepare error message
				if($isOwner && strcmp($user->getSecretId(), $newSecretId) == 0){
					$text = "Vous posséder déjà cette clé";
					$errorMessage = $text;
				} else {
					$text = "Cet utilisateur possède déjà cette clé";
					$errorMessage = $text;
				}

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Make update
			$result = $userDao->updateSecretId($id, $newSecretId, $status);

			//Check if update has succeed
			if(!$result)
			{
				//Prepare message
				$text = "Une erreur est survenue. La clé n'a pas pu être modifiée";
				$errorMessage = $text;

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
			}

			//Prepare success message
			if(!$isOwner){
				$text = "La clé de l'utilisateur ${username} est maintenant ${newLabel}";
				$successMessage = $text;
			} else {
				$text = "Votre clé est maintenant ${newLabel}";
				$successMessage = $text;

				//Update owner
				$user->setSecretId($newSecretId);
				$_SESSION['user'] = $user;
			}

			//Prepare redirection
			$page = "userManagement.php";
			$url_p1 = "alterUserSuccess=${successMessage}";
			$url = "Location: ${page}?${url_p1}";

			header($url);

		/* ALTER CLIENT */

		} else if(strcmp($action, "alterClient") == 0){

			//Get post value
			$newClientCode = $_POST['newClient'];

			//Get client name
			$clientName = $clientDao->getClientName($newClientCode);

			//Verify if client code has already an owner
			if($userDao->takenClientCode($newClientCode))
			{
				//Get owner from the client
				$owner = $userDao->getClientUser($newClientCode);

				//Prepare message
				$text = "Le client {$clientName} est déjà lié à l'utilisateur {$owner->getUsername()}";
				$errorMessage = $text;

				//Redirect
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Update client code
			$result = $userDao->updateClientCode($id, $newClientCode);

			//If no update
			if(!$result)
			{
				//Prepare message
				$text = "Une erreur est survenue. Le client a pas pu être modifié";
				$errorMessage = $text;

				//Redirect
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Prepare success message
			$text = 
			"L'utilisateur ${username} est maintenant lié au client ${clientName}";
			$successMessage = $text;

			//Redirect
			$url = "Location: userManagement.php?alterUserSuccess=${successMessage}";
			header($url);
			break;
		}

		break;

	/* ADD OR DELETE SECRET *****************************************/

	case "addSecret" : case "deleteSecret" : 

		//Get label from POST
		$label = $_POST['label'];

		if(strcmp($action, "addSecret") == 0){

			//Check if entered label is not empty
			if(strcmp(trim($label), "") == 0) 
			{
				//Prepare error message
				$text = "Vous ne pouvez pas ajouter un label vide";
				$errorMessage = $text;

				//Redirection
				$url = "Location: secretManagement.php?addSecretError=${errorMessage}";
				header($url);
				break;
			}

			//Check if entered label already exist
			if($secretDao->exist($label))
			{
				//Prepare error message
				$text = "Cette clé existe déjà";
				$errorMessage = $text;

				//Redirection
				$url = "Location: secretManagement.php?addSecretError=${errorMessage}";
				header($url);
				break;
			}

			//Generate new secret
			$totp = TOTP::create();
	    	$totp->setLabel($label);

	    	//Get secret code
	    	$code = $totp->getSecret();

	    	//set secret object
	    	$id = $secretDao->getLastId() + 1;
	    	$secret = new Secret($id, $code, $label);

	    	//Insert secret
	    	$result = $secretDao->insertSecret($secret);

	    	if(!$result)
	    	{
	    		//Prepare error message
				$text = "Une erreur est survenue. La clé a pas pu être enregistrée";
				$errorMessage = $text;

				//Redirection
				$url = "Location: secretManagement.php?addSecretError=${errorMessage}";
				header($url);
				break;
	    	}

	    	//Prepare success message
			$text = "La clé ${label} a été enregistrée";
			$successMessage = $text;

			//Redirection
			$url = "Location: secretManagement.php?addSecretSuccess=${successMessage}";
			header($url);

		} if(strcmp($action, "deleteSecret") == 0){

			//Get secret id
			$id = $secretDao->getId($label);

			//Check if users are using this key
			if($secretDao->secretToken($id) >= 1)
			{
				//Prepare error message
				$text = "Cette clé est utilisée par des utilisateurs";
				$errorMessage = $text;

				//Redirection
				$url = "Location: secretManagement.php?deleteSecretError=${errorMessage}";
				header($url);
				break;
			}

			//delete secret
			$result = $secretDao->deleteSecret($id);
	
			//Check if secret has been deleted
			if(!$result)
			{
				//Prepare error message
				$text = "Une erreur est survenue. La clé a pas pu être supprimée";
				$errorMessage = $text;

				//Redirection
				$url = "Location: secretManagement.php?deleteSecretError=${errorMessage}";
				header($url);
				break;
			}

			//Prepare error message
			$text = "La clé ${label} a été supprimée";
			$successMessage = $text;

			//Redirection
			$url = "Location: secretManagement.php?deleteSecretSuccess=${successMessage}";
			header($url);
		}

		break;

}
	
?>