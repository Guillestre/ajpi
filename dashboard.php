<!DOCTYPE html>
<html>

	<head>
		<?php 
			include 'ext/header.php';
		?>
		<title>Rechercher</title>
	</head>

	<body>

		<form action="dashboard.php" method="post">

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
			<div class="searchGrid">

				<!-- FILTER ------------------------------------>
				<div class="searchGridFilter">
					<?php include 'ext/filterResearch.php';?>
					<input type="submit" id="submitButton" name="submitButton" value="Lancer recherche" class="inputButton"/>
				</div>

				<!-- DO RESEARCH ------------------------------->
				<?php include 'ext/doResearch.php'?>

				<!-- RESULT FROM THE RESEARCH ----------------->
				<div class="searchGridResult">
					<div class="above_result_area">
						<input type="submit" name="logOff" value="Se déconnecter" class="logOffButton" />
					</div>
					<?php include 'ext/resultResearch.php';?>
				</div>

			</div>

		</form>
	</body>

</html>

