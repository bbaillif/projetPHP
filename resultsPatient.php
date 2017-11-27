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
		if (isset($_POST['updatePatient']) AND $_POST['ssNumber']) {
			$_SESSION['patientID'] = $_POST['ssNumber'];
			$_SESSION['action'] = 'updatePatient';
			header('Location: ./patient.php');
		}
		elseif (isset($_POST['deletePatient'])){
			# DeletePatient($_POST[patientID]);
			header('Location: ./patientUpdated.php');
		}
		elseif (isset($_POST['choosePatient'])) {
			$_SESSION['patientID'] = $_POST['ssNumber'];
			header('Location: ./askIntervention.php');
		}
		elseif (isset($_POST['addPatient'])) {
			$_SESSION['action'] = 'addPatientIntervetion';
			header('Location: ./patient.php');
		}
		else {
			# Do nothing
		}
	?>

	<h1>Résultats de la recherche de patient</h1>

	<form action="resultsPatient.php" method="post">
	<?php
		# PrintResults(tableau, true);
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