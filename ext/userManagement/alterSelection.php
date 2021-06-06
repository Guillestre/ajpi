<div>

	<input 
	type="radio" id="alterUsername" name="action" value="alterUsername" 
	onclick="selection()" checked >

	<label for="alterUsername">Nom utilisateur</label>

	<input type="radio" id="alterPassword" name="action"  value="alterPassword" 
	onclick="selection()">

	<label for="alterPassword">Mot de passe</label>

	<input type="radio" id="alterLabel" name="action"  value="alterLabel" 
	onclick="selection()"
	>

	<label for="alterLabel">Clé</label>
		
</div>

<!-- USERNAME ---------------------------------------->

<div id="UB">
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="newUsername">Nouveau nom utilisateur : </label>
		</div>

		<div class="grid-item-input-text">
			<input type="text" id="newUsername" name="newUsername">
		</div>

	</div>

	<div>
		<button type="submit">
			Changer le nom d'utilisateur
		</button>
	</div>

</div>

<!-- PASSWORD ---------------------------------------->

<div id="PB">
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="newPassword">Nouveau mot de passe : </label>
		</div>

		<div class="grid-item-input-text">
			<input type="text" id="newPassword" name="newPassword">
		</div>

	</div>

	<div>
		<button type="submit">
			Changer le mot de passe
		</button>
	</div>

</div>

<!-- SECRET ---------------------------------------->

<div id="LB">
	<div class="grid-container-userForm">

		<div class="grid-item-label">
			<label for="newLabel">Nouvelle clé (A2F) : </label>
		</div>

		<div class="grid-item-input-text">
		 	<select id="newLabel" name="newLabel">
				<?php
					foreach($secrets as $secret){
						$label = $secret->getLabel();
						print("<option value='${label}'>");
						print("${label}");
						print("</option>");
					}
				?>
			</select>
		</div>

	</div>

	<div>
		<button type="submit">
			Changer la clé
		</button>
	</div>

</div>


<script>
	function selection() {

		var alterUsername = document.getElementById("alterUsername");
		var alterPassword = document.getElementById("alterPassword");
		var alterLabel = document.getElementById("alterLabel");

		var ub = document.getElementById("UB");
		var pb = document.getElementById("PB");
		var lb = document.getElementById("LB");

		if (alterUsername.checked == true){
			ub.style.display = "block";
			pb.style.display = "none";
			lb.style.display = "none";

			document.getElementById("newUsername").required = true;
			document.getElementById("newPassword").required = false;
			document.getElementById("newLabel").required = false;
		}

		if (alterPassword.checked == true){
			ub.style.display = "none";
			pb.style.display = "block";
			lb.style.display = "none";

			document.getElementById("newUsername").required = false;
			document.getElementById("newPassword").required = true;
			document.getElementById("newLabel").required = false;
		}

		if (alterLabel.checked == true){
			ub.style.display = "none";
			pb.style.display = "none";
			lb.style.display = "block";

			document.getElementById("newUsername").required = false;
			document.getElementById("newPassword").required = false;
			document.getElementById("newLabel").required = true;
		}

	}

	selection();

</script>