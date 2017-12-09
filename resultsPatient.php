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

		if (isset($_POST['updatePatient'])) {
			$_SESSION['action'] = 'updatePatient';
			# $_SESSION['patientID'] = 
			header('Location: ./patient.php');
		}
		elseif (isset($_POST['deletePatient'])) {
			# DeletePatient();
			header('Location: ./patientUpdated.php');
		}
		elseif (isset($_POST['choosePatientIntervention'])) {
			# $_SESSION['patientID'] =
			header('Location: ./askIntervention.php');
		}
		elseif (isset($_POST['choosePatientEmergency'])) {
			# $_SESSION['patientID'] =
			header('Location: ./emergencyDone.php');
		}
	?>

	<h1>Résultats de la recherche de patient</h1>

	<form action="resultsPatient.php" method="post">
	<?php
		# SearchPatient();
		# PrintResults;
		if ($_SESSION['action'] == 'searchPatient') {
			echo '<input type="submit" name="updatePatient" value="Modifier patient" /><br>' . "\n";
			echo '<input type="submit" name="deletePatient" value="Supprimer patient" /><br>' . "\n";
		}
		elseif ($_SESSION['action'] == 'addIntervention') {
			echo '<input type="submit" name="choosePatientIntervention" value="Choisir le patient sélectionné" /><br>' . "\n";
			echo '<input type="submit" name="addPatient" value="Créer un patient" /><br>' . "\n";
		}
		elseif ($_SESSION['action'] == 'emergencyWithExistingPatient') {
			echo '<input type="submit" name="choosePatientEmergency" value="Choisir le patient sélectionné" /><br>' . "\n";
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