<?php
	require("./fonctionsBen.php");
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
		if (isset($_POST['deleteIntervention'])) {
			# DeleteIntervention()
			header('Location: ./interventionDeleted.php');
		}
		else {
			# Do nothing
		}
	?>

	<h1>Résultats de la recherche d'intervention</h1>

	<form action="resultsIntervention.php" method="post">
	<?php
		# PrintResults(tableau, true);
		if ($_SESSION['action'] == 'searchIntervention') {
			SearchIntervention();
			PrintResults();
			echo '<input type="submit" name="deleteIntervention" value="Supprimer intervention" /><br>' . "\n";
		}
		elseif ($_SESSION['action'] == 'seeFacturedIntervention') {
			SearchInterventionF();
			PrintResults();
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