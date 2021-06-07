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
include "src/util/ExtractHelper.php";

//Verify if action has been performed
if(!isset($_POST['action']))
{
	$redirection = "location:javascript://history.go(-1)";
	header($redirection);
}

//Get param from forms
$action = htmlspecialchars($_POST['action']);

//We use TOTP
use OTPHP\TOTP;

//Start session
session_start();

//Set DAO
$userDao = new UserMySQLDao();
$secretDao = new SecretMySQLDao();

switch($action)
{
	case "adminConnection" : case "clientConnection" :

		//Set status
		if($action == "adminConnection")
			$status = "admin";
		else
			$status = "client";

		//Get POST values
		$username = $_POST['username'];
		$password = $_POST['password'];
		$otp = $_POST['otp'];

		//Set user
		if($userDao->exist($username, $status))
		{
			$user = $userDao->getUser($username, $status);
			$code = $secretDao->getCode($user->getSecretId());
			$label = $secretDao->getLabel($user->getSecretId());
		    $totp = TOTP::create($code);
		    if($totp->verify($otp)){
				$_SESSION['user'] = $user;
				$url = "Location: dashboard.php";
			} else {
				$errorMessage = urlencode("Le code secret est incorrect");
				$url = "Location: index.php?${status}ErrorConnection=${errorMessage}";
			}
		} else {
			$errorMessage = urlencode("Cet utilisateur n'existe pas");
			$url = "Location: index.php?${status}ErrorConnection=${errorMessage}";
		}

		header($url);
		break;

	case "addUser" :

		//Get POST values
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		$status = htmlspecialchars($_POST['status']);
		$client = htmlspecialchars($_POST['client']);
		$label = htmlspecialchars($_POST['label']);
		$safe = true;
		$isAdmin = $status == "admin";

		//Verify if its safe to insert the new user
		if($userDao->exist($username, $status))
		{
			$errorMessage = 
			urlencode(
				"Impossible. Le nom d'utilisateur {$status} '{$username}' existe déjà"
			);
			$safe = false;
		} else if(isset($client) && !$isAdmin) {

			//Extract client code
			$start = strpos($client,"(") + 1;
			$end = strpos($client,")");
			$clientCode = substr($client, $start, $end - $start);

			//Extract client name
			$start = 0;
			$end = strpos($client,"(") - 1;
			$clientName = substr($client, $start, $end - $start);

			//Verify if client code has already an owner
			if($userDao->takenClientCode($clientCode))
			{
				$safe = false;
				$owner = $userDao->getClientUser($clientCode);
				$errorMessage = urlencode(
					"Le client {$clientName} 
					est déjà pris par l'utilisateur '{$owner->getUsername()}'"
				);
			}
		}

		//If test are passed, we can insert
		if($safe)
		{

			$secretId = $secretDao->getId($label);
			$id = $userDao->getLastId($status) + 1;

			//Check new user status
			if($status == "admin")
				$user = new AdminUser ($id, $username, $password, $secretId);
			else
				$user = new ClientUser ($id, $username, $password, $secretId, $clientCode);
			
			$userDao->insertUser($user, $status); 
			$successMessage = "L'utilisateur {$status} '{$username}' a été enregistré";
			$url = "Location: userManagement.php?addUserSuccess=${successMessage}";
		} else {
			//Otherwise, send error message
			$url = "Location: userManagement.php?addUserError=${errorMessage}";
		}

		header($url);

		break;

	case "deleteUser" :

		//Get POST values
		$status = $_POST['status'];

		if(strcmp($status, "admin") == 0)
			$username = $_POST['deleteAUD'];
		else
			$username = $_POST['deleteCUD'];

		$result = $userDao->deleteUser($username, $status);

		if($result == 1)
		{
			$successMessage = urlencode("L'utilisateur {$status} '{$username}' a bien été supprimé");
			$url = 
			"Location: userManagement.php?deleteUserSuccess=${successMessage}";
		} else {
			$errorMessage = urlencode("Une erreur est survenue. L'utilisateur {$status} '${username}' n'a pas pu être supprimé");
			$url = "Location: userManagement.php?deleteUserError=${errorMessage}";
		}

		header($url);
		break;

	case "deleteOwner" :

		//Get connected user
		$user = $_SESSION['user'];

		$nbAdmins = $userDao->countUser("admin");

		if($nbAdmins > 1)
		{
			$result = $userDao->deleteUser($user->getUsername(), "admin");

			if($result == 1)
			{
				$successMessage = 
				urlencode("Votre compte a bien été supprimé");
				$url = 
				"Location: index.php?deleteMyAccountSuccess=${successMessage}";
			} else {
				$errorMessage = 
				urlencode("Une erreur est survenue. Votre compte n'a pas pu être supprimé");
				$url = 
				"Location: userManagement.php?deleteMyAccountError=${errorMessage}";
			}
		} else {
			$errorMessage = 
			urlencode("Impossible. Vous êtes le seul administrateur");
			$url = "Location: userManagement.php?deleteMyAccountError=${errorMessage}";
		}

		header($url);

		break;

	case "alterUsername" : case "alterPassword" : case "alterSecret" :

		//Get SESSION POST values
		$status = $_POST['status'];

		if(strcmp($status, "admin") == 0)
			$username = $_POST['alterAUD'];
		else
			$username = $_POST['alterCUD'];

		$id = $userDao->getId($username, $status);
		$user = $_SESSION['user'];
		
		if(strcmp($action, "alterUsername") == 0){

			//Get SESSION POST values
			$newUsername = $_POST['newUsername'];

			//Check if newUsername isnt empty
			if(trim($newUsername) == "")
			{
				$text = 
				"Vous ne pouvez pas mettre un nom d'utilisateur contenant que des espaces";
				$errorMessage = urlencode($text);
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			//Check if newUsername already exist
			if($userDao->exist($newUsername, $status))
			{
				$ownerUsername = strcmp($newUsername, $user->getUsername()) == 0;
				$ownerStatus = strcmp($status, "admin") == 0;
				$owner = $ownerUsername && $ownerStatus;
				if(!$owner)
				{
					$own = $username == $newUsername;

					if($own)
						$text = "L'utilisateur ${status} '${username}' possède déjà ce nom d'utilisateur";
					else
						$text = "Le nom d'utilisateur ${status} '${newUsername}' existe déjà";
				}
				else
					$text = "Vous posséder déjà ce nom d'utilisateur";

				$errorMessage = urlencode($text);
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}
				
			//Execute
			$result = $userDao->updateUsername($id, $newUsername, $status);

			//Check if update has succeed
			if(!$result){
				$text = "Une erreur est survenue. Le nom d'utilisateur n'a pas pu être modifié";
				$errorMessage = urlencode($text);
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			$user->setUsername($newUsername);
			$_SESSION['user'] = $user;

			if($user->getId() == $id)
				$text = "Votre nom d'utilisateur est maintenant '${newUsername}'";
			else
				$text = "Le nouveau nom d'utilisateur ${status} de '${username}' est maintenant '${newUsername}'";

			$successMessage = urlencode($text);
			$url = 
			"Location: userManagement.php?alterUserSuccess=${successMessage}";
			
			header($url);

		} else if(strcmp($action, "alterPassword") == 0){

			//Get SESSION POST values
			$newPassword = $_POST['newPassword'];

			//Check if newPassword isnt empty
			if(trim($newPassword) == "")
			{
				$text = "Vous ne pouvez pas mettre un mot de passe contenant que des espaces";
				$errorMessage = urlencode($text);
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}
				
			//Execute
			$result = $userDao->updatePassword($id, $newPassword, $status);

			//Check if update has succeed
			if($result != 1 && $result != 0){
				$text = "Une erreur est survenue. Le mot de passe n'a pas pu être modifié";
				$errorMessage = urlencode($text);
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			} else if($result == 0) {

				//Adapt alert
				if($user->getId() == $id)
					$text = "Vous avez déjà ce mot de passe";
				else
					$text = "L'utilisateur ${status} '${username}' possède déjà ce mot de passe'";

				$errorMessage = urlencode($text);
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			$user->setPassword($newPassword);
			$_SESSION['user'] = $user;

			//Adapt alert
			if($user->getId() == $id)
				$text = "Votre mot de passe est maintenant '${newPassword}'";
			else
				$text = "Le mot de passe '${username}' est maintenant '${newPassword}'";
			$successMessage = urlencode($text);
			$url = "Location: userManagement.php?alterUserSuccess=${successMessage}";
			header($url);

		} else if(strcmp($action, "alterSecret") == 0){

			//Get SESSION POST values
			$newLabel = htmlspecialchars($_POST['newLabel']);

			//Execute
			$secretId = $secretDao->getId($newLabel);
			$result = $userDao->updateSecretId($id, $newSecretId);

			//Check if update has succeed
			if($result != 1 && $result != 0){
				$text = "Une erreur est survenue. La clé n'a pas pu être modifiée";
				$errorMessage = urlencode($text);
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
			} else if($result == 0) {

				//Adapt alert
				if($user->getId() == $id)
					$text = "Vous possédez déjà la clé ${newLabel}";
				else
					$text = "'${username}' possède déjà la clé '${newLabel}'";

				$errorMessage = urlencode($text);
				$url = "Location: userManagement.php?alterUserError=${errorMessage}";
				header($url);
				break;
			}

			$user->setSecretId($newSecretId);
			$_SESSION['user'] = $user;

			//Adapt alert
			if($user->getId() == $id)
				$text = "Votre mot de passe est maintenant '${newLabel}'";
			else
				$text = "Le secret de '${username}' est maintenant '${newLabel}'";

			$successMessage = urlencode($text);
			$url = 
			"Location: userManagement.php?alterUserSuccess=${successMessage}";
			header($url);
		}

		break;

}
	
?>