<?php
	require("./fonctionsBen.php");
	require("./fonctionSo.php");
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
	?>

	<?php
		# Following lines execute only if action = addPatient and first entry done
		if (CheckPatient($_POST)) {
		#if (isset($_POST['pathology'])) {
			if($_POST['pathology'] != "") {
					AddPatient($_POST);
				if ($_SESSION['action'] == 'addPatient') {
					header('Location: ./patientUpdated.php');
				}
				elseif ($_SESSION['action'] == 'addPatientIntervention') {
					$_SESSION['patientID'] = $_POST['ssNumber'];
					header('Location: ./askIntervetion.php');
				}
			}
		}
	?>

	<?php
		if ($_SESSION['action'] == 'addPatient' OR $_SESSION['action'] == 'addPatientIntervention') {
			echo '<h1>Rédaction de fiche patient</h1>' . "\n";
			echo '<form action="patient.php" method="post">'. "\n";
		}
		elseif ($_SESSION['action'] == 'searchPatient' OR $_SESSION['action'] == 'addIntervention') {
			echo '<h1>Recherche de patient</h1>'. "\n";
			echo '<form action="resultsPatient.php" method="post">'. "\n";
		}
		elseif ($_SESSION['action'] == 'updatePatient') {
			$infoPatient = FetchInfoPatient($_SESSION['patientID']);
			echo '<h1>Mise-à-jour de fiche patient</h1>' . "\n";
			echo '<form action="patient.php" method="post">'. "\n";
		}
		else {
			header('Location: ./index.php');
		}

		$infoField = InfoFieldPatient();

		# print each info field
		foreach ($infoField as $infoName => $relatedInfo) {
			echo($relatedInfo['french'] . ' <input type="' . $relatedInfo['type'] . '" name="' . $infoName);
			if (isset($infoPatient[$infoName])) {
				echo ('" value="' . $infoPatient[$infoName] . '"/><br>' . "\n");
			}
			else {
				echo('"/><br>' . "\n");
			}
		}
	?>
        <input type="submit" value="Valider" /><br>
    </form>

    <?php
    	PrintFooter();
    ?>

</body>

</html>