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
	<h1>Résultat de la recherche d'un service </h1>

	<?php
		print("Historique : <br>");
		PrintArchive($_POST["ID"].".txt"); 
	?>

	<br> <br>
	
		</div>

<?php
	$_SESSION['action'] = '';
	PrintFooter();
?>
</body>
</html>
