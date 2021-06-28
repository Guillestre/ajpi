<!-- EXT THAT ALTER AN USER -->


<?php 
	$availableAdminUsers =  !is_null($adminUsers);
	$availableClientUsers =  !is_null($clientUsers);
?>

<h2>Modifier un utilisateur : </h2>

<form action="processForm.php" method="post">

	<!-- STATUS SELECTION -->

	<input 
	type="radio" id="radioAlterClient" name="status" value="client" 
	onclick="alterUser()" 
	<?php 
		if(isset($_GET['radioAlter']))
		{
			$addRadio = $_GET['radioAlter'];
			if(strcmp($addRadio, "client") == 0)
				print("checked");
		} else
			print("checked");
	?>
	/>

	<label for="radioAlterClient">Client</label>

	<input type="radio" id="radioAlterAdmin" name="status"  value="admin" 
	onclick="alterUser()"
	<?php 
		if(isset($_GET['radioAlter']))
		{
			$addRadio = $_GET['radioAlter'];
			if(strcmp($addRadio, "admin") == 0)
				print("checked");
		}
	?>
	/>

	<label for="radioAlterAdmin">Staff</label>


	<!-- ADMIN SELECTION -->

	<div id="alterBlockAdmin" hidden>
		<?php if($availableAdminUsers){
				if($availableAdminUsers && !$availableClientUsers)
					include_once "ext/userManagement/alterSelection.php";
			} else messageHandler::sendInfoMessage("Il n y'a aucun administrateur à modifier"); 
		?>
	</div>

	<!-- USER CLIENT SELECTION -->

	<div id="alterBlockClient" >
		<?php if($availableClientUsers){
				if(!$availableAdminUsers && $availableClientUsers)
					include_once "ext/userManagement/alterSelection.php";
			}else messageHandler::sendInfoMessage("Il n y'a aucun utilisateur client à modifier");
		?>
	</div>

	<?php
		if($availableAdminUsers && $availableClientUsers)
			include_once "ext/userManagement/alterSelection.php";
	?>

	<!-- MESSAGE -->

	<?php
		if(isset($_GET['alterUserSuccess']))
			messageHandler::sendSuccessMessage($_GET['alterUserSuccess']);
		else if(isset($_GET['alterUserError']))
			messageHandler::sendErrorMessage($_GET['alterUserError']);
	?>

</form>

<script>
	function alterUser() {

		//Blocks
		var alterBlockAdmin = document.getElementById("alterBlockAdmin");
		var alterBlockClient = document.getElementById("alterBlockClient");

		//radio line
		var radioAlterClient = document.getElementById("radioAlterClient");

		//Client selection
		labelAlterClient = document.getElementById("labelAlterClient");
		selectAlterClient = document.getElementById("selectAlterClient");
		buttonAlterClient = document.getElementById("buttonAlterClient");

		//Admin user selection
		labelAlterAdmin = document.getElementById("labelAlterAdmin");
		selectAlterAdmin = document.getElementById("selectAlterAdmin");

		//Client user selection
		labelAlterClientUser = document.getElementById("labelAlterClientUser");
		selectAlterClientUser = document.getElementById("selectAlterClientUser");

		//Display Block
		if (radioAlterClient.checked == true){
			alterBlockClient.style.display = "block";
			alterBlockAdmin.style.display = "none";
		} else {
			alterBlockClient.style.display = "none";
			alterBlockAdmin.style.display = "block";
		}

		//Display selection
		if (radioAlterClient.checked == true){

			//
			labelAlterClient.style.visibility = "visible";
			selectAlterClient.style.visibility = "visible";
			buttonAlterClient.style.visibility = "visible";

			labelAlterAdmin.style.display = "none";
			selectAlterAdmin.style.display = "none";
			labelAlterClientUser.style.display = "block";
			selectAlterClientUser.style.display = "block";
		} else {
			labelAlterClient.style.visibility = "hidden";
			selectAlterClient.style.visibility = "hidden";
			buttonAlterClient.style.visibility = "hidden";

			labelAlterClientUser.style.display = "none";
			selectAlterClientUser.style.display = "none";
			labelAlterAdmin.style.display = "block";
			selectAlterAdmin.style.display = "block";
		}
	}
	alterUser();
</script>

