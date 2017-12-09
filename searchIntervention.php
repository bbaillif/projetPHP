<?php
	require("./fonctions.php");
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Intranet Hopital Polytech</title>
	<meta charset= "utf-8">
</head>

<body>

	<?php
		CheckUID();
		PrintHeader();
		print_r($_SESSION);
	?>

	<?php

		if ($_SESSION['action'] == 'deleteIntervention') {
			echo '<h1>Recherche d\'une intervention à supprimer</h1>' . "\n";
			echo '<form action="resultsIntervention.php" method="post">'. "\n";
		}
		elseif ($_SESSION['action'] == 'seeFacturedIntervention') {
			echo '<h1>Recherche d\'une intervention facturée</h1>' . "\n";
			echo '<form action="resultsIntervention.php" method="post">'. "\n";
		}
		elseif ($_SESSION['action'] == 'factureIntervention') {
			echo '<h1>Recherche d\'une intervention à facturer</h1>' . "\n";
			echo '<form action="resultsIntervention.php" method="post">'. "\n";
		}
		else {
			header('Location: ./index.php');
		}

	?>

		Début de la recherche <input type="date" name="startingDate"/><br>
		Fin de la recherche <input type="date" name="endingDate"/><br>
		Patient <input type="text" name="patientName"/><br>
		Numéro de sécurité sociale <input type="text" name="ssNumber"/><br>

        <input type="submit" value="Valider" /><br>
    </form>

    <?php
    	PrintFooter();
    ?>

</body>

</html>