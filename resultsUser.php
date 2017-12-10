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
		if ($_SESSION['action'] == 'searchMail') {
			echo '<h1>Résultat de la recherche de personnel (mail) </h1><br><br>' . "\n";
		}
		elseif ($_SESSION['action'] == 'seeLogs') {
			echo '<h1>Résultat de la recherche de personnel (historique) </h1><br><br>' . "\n";
		}
	?>

	<?php
		if ($_SESSION['action'] == 'searchMail') {
			SearchEmail($_POST["ID"]);
		}
		elseif ($_SESSION['action'] == 'seeLogs') {
			print("Historique : <br>");
			PrintArchive($_POST["ID"].".txt"); 
		}
	?>

	<br> <br>
	
	</div>
</body>

<?php
	PrintFooter();
?>

</html>
