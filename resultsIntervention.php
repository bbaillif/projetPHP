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
		print_r($_POST);
		if (isset($_POST['deleteIntervention'])) {
			# AJOUTER LES ARGUMENTS DE DELETE INTERVENTION
			# DeleteIntervention();
			header('Location: ./interventionDeleted.php');
		}
		elseif (isset($_POST['deleteIntervention'])) {
			# FactureIntervention();
			header('Location: ./interventionFactured.php');
		}
		else {
			# Do nothing
		}
	?>

	<h1>Résultats de la recherche d'intervention</h1>

	<form action="resultsIntervention.php" method="post">
	<?php
		# PrintResults(tableau, true);
		if ($_SESSION['action'] == 'deleteIntervention') {
			$result = SearchIntervention($_POST);
			PrintResults($result, "radio");
			echo '<input type="submit" name="deleteIntervention" value="Supprimer intervention" /><br>' . "\n";
		}
		elseif ($_SESSION['action'] == 'seeFacturedIntervention') {
			$result = SearchInterventionF($_POST);
			if (!empty($result)){
				PrintResults($result,"list");
			}
		}
		elseif ($_SESSION['action'] == 'factureIntervention') {
			#$result = SearchInterventionNF($_POST);
			#if (!empty($result)){
			#	PrintResults($result,"list");
			#}
			echo '<input type="submit" name="factureIntervention" value="Supprimer intervention" /><br>' . "\n";
		}
		else {
			header('Location: ./index.php');
		}
	?>

	<?php
		echo '<br>'. "\n";
		print_r($_SESSION);
		echo '<br>'. "\n";
		PrintFooter();
	?>

</body>

</html>