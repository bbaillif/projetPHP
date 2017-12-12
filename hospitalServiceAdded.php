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
		AddService($_POST["hospitalServiceToAdd"],"accueil");
	?>

	<h1>Service d'accueil ajouté</h1>

	</div>

<?php
	$_SESSION['action'] = '';
	PrintFooter();
?>
</body>
</html>