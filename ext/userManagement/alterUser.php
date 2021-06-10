<?php 
	$availableAdminUsers =  !is_null($adminUsers);
	$availableClientUsers =  !is_null($clientUsers);
?>

<h2>Modifier un utilisateur : </h2>

<form action="processForm.php" method="post">

	<!-- STATUS SELECTION -->

	<div>

		<input 
		type="radio" id="alterRadioCU" name="status" value="client" 
		onclick="alterUser()" 
		checked
		>

		<label for="alterRadioCU">Client</label>

		<input type="radio" id="alterRadioAU" name="status"  value="admin" 
		onclick="alterUser()"
		>

		<label for="alterRadioAU">Admin</label>
	
	</div>

	<!-- ADMIN SELECTION -->

	<div id="blockAU" hidden>
		<?php if($availableAdminUsers){
				if($availableAdminUsers && !$availableClientUsers)
					include_once "ext/userManagement/alterSelection.php";
			} else messageHandler::sendInfoMessage("Il n y'a aucun administrateurs à modifier"); 
		?>
	</div>

	<!-- USER CLIENT SELECTION -->

	<div id="blockCU" >
		<?php if($availableClientUsers){
				if(!$availableAdminUsers && $availableClientUsers)
					include_once "ext/userManagement/alterSelection.php";
			}else messageHandler::sendInfoMessage("Il n y'a aucun utilisateurs client à modifier");
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
		var blockAU = document.getElementById("blockAU");
		var blockCU = document.getElementById("blockCU");

		//radio line
		var alterRadioCU = document.getElementById("alterRadioCU");

		//Client selection
		labelNewClient = document.getElementById("labelNewClient");
		inputNewClient = document.getElementById("inputNewClient");
		submitNewClient = document.getElementById("submitNewClient");

		//Admin user selection
		labelAlterAdmin = document.getElementById("labelAlterAdmin");
		inputAlterAdmin = document.getElementById("inputAlterAdmin");

		//Client user selection
		labelAlterClient = document.getElementById("labelAlterClient");
		inputAlterClient = document.getElementById("inputAlterClient");

		//Display Block
		if (alterRadioCU.checked == true){
			blockCU.style.display = "block";
			blockAU.style.display = "none";
		} else {
			blockCU.style.display = "none";
			blockAU.style.display = "block";
		}

		//Display selection
		if (alterRadioCU.checked == true){
			labelNewClient.style.visibility = "visible";
			inputNewClient.style.visibility = "visible";
			submitNewClient.style.visibility = "visible";

			labelAlterAdmin.style.display = "none";
			inputAlterAdmin.style.display = "none";
			labelAlterClient.style.display = "block";
			inputAlterClient.style.display = "block";
		} else {
			labelNewClient.style.visibility = "hidden";
			inputNewClient.style.visibility = "hidden";
			submitNewClient.style.visibility = "hidden";

			labelAlterClient.style.display = "none";
			inputAlterClient.style.display = "none";
			labelAlterAdmin.style.display = "block";
			inputAlterAdmin.style.display = "block";
		}
	}
	alterUser();
</script>

