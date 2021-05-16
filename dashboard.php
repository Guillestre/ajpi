<!DOCTYPE html>
<html>

	<head>
		<?php include 'ext/header.php';?>
		<title>Rechercher</title>
	</head>

	<body>

		<form action="dashboard.php" method="post">

			<?php 

				//Verify if user is connected
				if(!isset($_SESSION['username']))
					header("Location: index.php");

				//Verify if logoff button has been clicked
				if(isset($_POST['logoff'])){
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
					<input type="submit" name="logoff" value="Se déconnecter" class="inputButton" />
				</div>

				<!-- DO RESEARCH ------------------------------->
				<?php include 'ext/doResearch.php'?>

				<!-- RESULT FROM THE RESEARCH ----------------->
				<div class="searchGridResult">
					<?php include 'ext/resultResearch.php';?>
				</div>

			</div>

		</form>
	</body>

</html>

