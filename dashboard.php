<!DOCTYPE html>
<html>

	<head>
		<?php 
			include 'ext/header.php';
		?>
		<title>Rechercher</title>
	</head>

	<body>

		<?php 
			//Verify if user is connected
			if(!isset($_SESSION['username']))
				header("Refresh: 0;url= index.php");

			//Verify if logOff button has been clicked
			if(isset($_POST['logOff'])){
				session_destroy();
				header("Refresh: 0;url= index.php");
			}
			
			$currentPage = "dashboard" 
		?>

		<form action="dashboard.php" method="post">

			<div class="log_off_area">
					<input type="submit" name="logOff" value="Se déconnecter" class="logOffButton" />
			</div>

		</form>

		<form action="dashboard.php" method="post">

			<!-- FILTER ------------------------------------>
			<div class="searchGridFilter">
				<?php include 'ext/filterResearch.php';?>
				<input type="submit" id="submitButton" name="submitButton" value="Lancer recherche" class="inputButton"/>
			</div>
	
			<!-- DO RESEARCH ------------------------------->
			<?php include 'ext/doResearch.php'?>

			<!-- RESULT FROM THE RESEARCH ----------------->
			<div class="searchGridResult">
				<?php include 'ext/resultResearch.php';?>
			

		</form>

	</body>

</html>

