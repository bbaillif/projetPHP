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
	<h1>Créer un service</h1>
		<?php
			echo '<form action="hospitalServiceAdded.php" method="post">' . "\n";
			echo 'Ajouter un service d\'accueil : <input type="text" name="hospitalServiceToAdd">' . "\n";
			echo '<input type="submit" value="Ajouter">' . "\n";
			echo '</form>' . "\n";
			echo "<br>";
			echo '<form action="interventionServiceAdded.php" method="post">' . "\n";
			echo 'Ajouter un service d\'intervention : <input type="text" name="interventionServiceToAdd">' . "\n";
			echo 'Nombre de creneau du service d\'intervention<input type="number" name="nbcreneau" min="1" max="5">' . "\n";
			echo '<input type="submit" value="Ajouter">' . "\n";
			echo '</form>' . "\n";
		?>
	</div>

	<?php
		PrintFooter();
	?>
</body>

</html>