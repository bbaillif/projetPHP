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

		if isset($_POST['interventionEmergencyNumber']) {
			$_SESSION['emergencyNumber'] = $_POST['interventionEmergencyNumber'];
			$_SESSION['falseEmergencyNumber'] = $_POST['interventionEmergencyNumber'];
		}
		else {
			$_SESSION['falseEmergencyNumber'] += 1;
		}
	?>

	<h1>Résultats de la recherche de créneaux libres</h1>

	<form action="resultsFreeTime.php" method="post">
	<?php
		# SearchFreeTime
		# PrintFreeTime(tableau, true);
		if ($_SESSION['action'] == 'searchPatient') {
			echo '<input type="submit" name="updatePatient" value="Modifier patient" /><br>' . "\n";
			echo '<input type="submit" name="deletePatient" value="Supprimer patient" /><br>' . "\n";
		}
		elseif ($_SESSION['action'] == 'addIntervention') {
			echo '<input type="submit" name="choosePatient" value="Choisir le patient sélectionné" /><br>' . "\n";
			echo '<input type="submit" name="addPatient" value="Créer un patient" /><br>' . "\n";
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