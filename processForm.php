<?php

/* FILE THAT EXECUTE RECEIVED DATA FROM FORMS */

//Include libraries
include 'libraries/vendor/autoload.php';

//Include src files
include "src/class/MySQLConnection.php";
include "src/class/User.php";
include "src/class/AdminUser.php";
include "src/class/ClientUser.php";
include "src/class/Client.php";
include "src/class/Invoice.php";
include "src/class/Line.php";
include "src/interface/UserDao.php";
include "src/interface/SecretDao.php";
include "src/dao/UserMySQLDao.php";
include "src/dao/SecretMySQLDao.php";
include "src/dao/ClientMySQLDao.php";
include "src/util/ExtractHelper.php";

//Verify if action has been performed
if(!isset($_POST['action']))
{
	$redirection = "location:javascript://history.go(-1)";
	header($redirection);
}

//Get param from forms
$action = $_POST['action'];

//We use TOTP
use OTPHP\TOTP;

//Start session
session_start();

//Set DAO
$userDao = new UserMySQLDao();
$secretDao = new SecretMySQLDao();
$clientDao = new ClientMySQLDao();

switch($action)
{
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
			$errorMessage = urlencode($text);

			//Redirection
			$url = "Location: index.php?${status}ErrorConnection=${errorMessage}";
			header($url);
			break;
		}

		//Prepare TOTP
		$user = $userDao->getUser($username, $status);
		$code = $secretDao->getCode($user->getSecretId());
	    $totp = TOTP::create($code);

		//Check if entered otp is correct
		if(!$totp->verify($otp))
		{
			//Prepare error message
			$text = "Le code secret est incorrect";
			$errorMessage = urlencode("Cet utilisateur n'existe pas");

			//Redirection
			$url = "Location: index.php?${status}ErrorConnection=${errorMessage}";
			header($url);
			break;
		}

		//If passed all test, connect user
		$_SESSION['user'] = $user;
		$url = "Location: dashboard.php";
		header($url);
		break;

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
			"Vous ne pouvez pas mettre un nom d'utilisateur contenant que des espaces";
			$errorMessage = urlencode($text);

			//Redirection
			$url = "Location: userManagement.php?addUserError=${errorMessage}";
			header($url);
			break;
		}

		//Check if password is not empty
		if(strcmp(trim($password), "") == 0)
		{
			//Prepare error message
			$text = "Vous ne pouvez pas mettre un mot de passe contenant que des espaces";
			$errorMessage = urlencode($text);

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
			$errorMessage = urlencode($text);

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
			$clientName = utf8_encode($clientDao->getClientName($clientCode));

			//Get owner from the client
			$owner = $userDao->getClientUser($clientCode);

			//Check if chosen client is already token
			if($userDao->takenClientCode($clientCode))
			{
				//Prepare error message
				$text = "Le client {$clientName} est déjà pris par l'utilisateur {$owner->getUsername()}";
				$errorMessage = urlencode($text);

				//Redirect
				$url = "Location: userManagement.php?addUserError=${errorMessage}";
				header($url);
				break;
			}

			//Prepare success message
			$text = "L'utilisateur client ${username} a bien été enregistré";
			$successMessage = urlencode($text);

			//Create client user
			$user = new ClientUser ($id, $username, $password, $secretId, $clientCode);

		} else {

			//Prepare success message
			$text = "L'administrateur ${username} a bien été enregistré";
			$successMessage = urlencode($text);

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
			$errorMessage = urlencode($text);

			//Redirection
			$url = "Location: userManagement.php?addUserError=${errorMessage}";
			header($url);
			break;
		}

		//Redirection
		$url = "Location: userManagement.php?addUserSuccess=${successMessage}";
		header($url);
		break;

	case "deleteUser" :

		//Get status from POST
		$status = $_POST['status'];

		//Get right username according the status
		if(strcmp($status, "admin") == 0)
			$username = $_POST['adminUsername'];
		else
			$username = $_POST['clientUsername'];

		$result = $userDao->deleteUser($username, $status);

		//Check if user has been deleted
		if(!$result)
		{
			//Prepare error message
			$text = 
			"Une erreur est survenue. L'utilisateur a pas pu être supprimé";
			$errorMessage = urlencode($text);

			//Redirection
			$url = "Location: userManagement.php?deleteUserError=${errorMessage}";
			header($url);
			break;
		}

		//Prepare success message
		$text = "L'utilisateur {$username} a bien été supprimé";
		$successMessage = urlencode($text);

		//Redirection
		$url = "Location: userManagement.php?deleteUserSuccess=${successMessage}";
		header($url);

		break;

	case "deleteOwner" :

		//Get connected user
		$user = $_SESSION['user'];

		//Count how admin in database
		$nbAdmins = $userDao->countUser("admin");

		//Check if there are more than one admin
		if($nbAdmins == 1)
		{
			//Prepare error message
			$text = "Impossible. Vous êtes le seul administrateur";
			$errorMessage = urlencode($text);

			//Redirection
			$url = "Location: userManagement.php?deleteOwnerError=${errorMessage}";
			header($url);
			break;
		}

		//Delete connected user
		$result = $userDao->deleteUser($user->getUsername(), "admin");

		if(!$result)
		{
			//Prepare error message
			$text = "Une erreur est survenue. Votre compte a pas pu être supprimé";
			$errorMessage = urlencode($text);
			
			//Redirection
			$url = "Location: userManagement.php?deleteOwnerError=${errorMessage}";
			header($url);
			break;
		}

		//Prepare success message
		$text = "Votre compte a bien été supprimé";
		$successMessage = urlencode($text);

		//Redirection
		$url = "Location: index.php?deleteOwnerSuccess=${successMessage}";
		header($url);
		break;

	case "alterUsername" : case "alterPassword" : 
	case "alterSecret" : case "alterClient" :

		//Get status from POST
		$status = $_POST['status'];

		//Set username according the status
		if(strcmp($status, "admin") == 0)
			$username = $_POST['adminUsername'];
		else
			$username = $_POST['clientUsername'];

		//Set id according the status
		$id = $userDao->getId($username, $status);
		
		/* ALTER USERNAME */

		if(strcmp($action, "alterUsername") == 0){

			//Get new username from POST
			$newUsername = $_POST['newUsername'];

			//Check if new username is not empty
			if( strcmp(trim($newUsername), "") == 0 )
			{
				//Prepare message
				$text = 
				"Vous ne pouvez pas mettre un nom d'utilisateur contenant que des espaces";
				$errorMessage = urlencode($text);

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Check if new username already exist
			if($userDao->exist($newUsername, $status))
			{
				//Prepare message
				$text = "Cet utilisateur possède déjà ce nom d'utilisateur";
				$errorMessage = urlencode($text);

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}
				
			//Execute
			$result = $userDao->updateUsername($id, $newUsername, $status);

			//Check if update has succeed
			if(!$result){
				//Prepare message
				$text = 
				"Une erreur est survenue. Le nom d'utilisateur n'a pas pu être modifié";
				$errorMessage = urlencode($text);

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Prepare success message
			$text = "Le nom de l'utilisateur ${username} a été modifié";
			$successMessage = urlencode($text);

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
				//Prepare message
				$text = "Vous ne pouvez pas mettre un mot de passe contenant que des espaces";
				$errorMessage = urlencode($text);

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
				//Prepare message
				$text = "Cet utilisateur possède déjà ce mot de passe";
				$errorMessage = urlencode($text);

				//redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}
				
			//Execute
			$result = $userDao->updatePassword($id, $newPassword, $status);

			//Check if update has succeed
			if(!$result){

				//Prepare message
				$text = "Une erreur est survenue. Le mot de passe n'a pas pu être modifié";
				$errorMessage = urlencode($text);
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				
				//Redirection
				header($url);
				break;
			}

			//Prepare success message
			$text = "Le mot de passe de l'utilisateur ${username} a été modifié";
			$successMessage = urlencode($text);

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
				//Prepare message
				$text = "Cet utilisateur possède déjà cette clé";
				$errorMessage = urlencode($text);

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Make update
			$result = $userDao->updateSecretId($id, $newSecretId);

			//Check if update has succeed
			if(!$result)
			{
				//Prepare message
				$text = "Une erreur est survenue. La clé n'a pas pu être modifiée";
				$errorMessage = urlencode($text);

				//Redirection
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
			}

			//Prepare success message
			$text = "La clé de l'utilisateur ${username} a été modifiée";
			$successMessage = urlencode($text);

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
			$clientName = utf8_encode($clientDao->getClientName($newClientCode));

			//Verify if client code has already an owner
			if($userDao->takenClientCode($newClientCode))
			{
				//Get owner from the client
				$owner = $userDao->getClientUser($newClientCode);

				//Prepare message
				$text = "Le client {$clientName} est déjà lié à l'utilisateur {$owner->getUsername()}";
				$errorMessage = urlencode($text);

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
				$errorMessage = urlencode($text);

				//Redirect
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Prepare success message
			$text = 
			"L'utilisateur ${username} est maintenant lié au client ${clientName}";
			$successMessage = urlencode($text);

			//Redirect
			$url = "Location: userManagement.php?alterUserSuccess=${successMessage}";
			header($url);
			break;
		}

		break;

}
	
?>