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
				header("Location: index.php");

			//Verify if logOff button has been clicked
			if(isset($_POST['logOff'])){
				session_destroy();
				header("Location: index.php");
			}
			
			$currentPage = "dashboard" 
		?>

		<form action="dashboard.php" method="post">

			<div class="logoff_area">
					<input type="submit" name="logOff" value="Se déconnecter" class="logoff_button" />
			</div>

		</form>

		<form action="dashboard.php" method="post">

			<!-- FILTER ------------------------------------>
			<div class="dashboard_filter_area">
				<?php include 'ext/filterResearch.php';?>
				<input type="submit" id="submitButton" name="submitButton" value="Lancer recherche" class="research_button"/>
			</div>
	
			<!-- DO RESEARCH ------------------------------->
			<?php include 'ext/doResearch.php'?>

			<!-- RESULT FROM THE RESEARCH ----------------->
			<div class="dashboard_result_area">
				<?php include 'ext/resultResearch.php';?>
			

		</form>

	</body>

</html>

