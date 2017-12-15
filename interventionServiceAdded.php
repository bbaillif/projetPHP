<?php
	require("./fonctions.php");
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Intranet Hopital Polytech</title>
	<meta charset= "utf-8">
	<link rel = "stylesheet" href = "aesthetic.css" > 
</head>

<body>
	<div id = "header"> 
		<?php 
			CheckUID();
			PrintHeader();
		?>
	</div>

	<div id = "body">
	<?php
		if(!empty($_POST["interventionServiceToAdd"]) AND !empty($_POST['nbcreneau'])){
			AddService($_POST["interventionServiceToAdd"],"intervention", $_POST['nbcreneau']);
		}
		else {
			header("Location: ./addService.php");
			exit();
		}
	?>

	<h1>Service d'intervention ajouté</h1>

	</div>

<?php
	$_SESSION['action'] = '';
	PrintFooter();
?>
</body>
</html>