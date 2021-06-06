<?php 
include "ext/common.php";
include "ext/search/fetchData.php";
$redirection = "location: userManagement.php";

//Check presence of parameters
$set = isset($_GET['id']) && isset($_GET['username']) && isset($_GET['status']);
$empty = trim($_GET['id']) == "" || trim($_GET['username']) == "" || trim($_GET['status']) == "";

if(!$set || $empty)
	header($redirection);

//Get parameters
$username = $_GET['username'];
$id = $_GET['id'];
$status = $_GET['status'];

//Check status
if(!in_array($status, $availableStatus))
	header($redirection);

//Check if id and username matches together
$match = $userDao->match($id, $username, $status);

if(!$match)
	header($redirection);

?>

<!DOCTYPE html>
<html>

	<?php include "ext/header.php" ?>

	<body>

		<h2> Modification de <?php echo "{$username} ({$status})"; ?> </h2>

		<div class="grid-container-forms">	

			<div class="userFormBox">
				<?php include "ext/userManagement/alterUsername.php"; ?>
			</div>

			<div class="userFormBox">
				<?php include "ext/userManagement/alterPassword.php"; ?>
			</div>

			<div class="userFormBox">
				<?php include "ext/userManagement/alterSecret.php"; ?>
			</div>
			
		</div>

		<button onclick="window.location.href='userManagement.php';">
			Retour
		</button>

	</body>

	<?php include "ext/footer.php" ?>

</html>