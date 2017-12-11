<?php
	require("./fonctions.php");
	session_start();
?>

<!DOCTYPE html>
<html>

<<head>
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
		print_r($_SESSION); 
		print_r($_POST);
		if (isset($_POST['updatePatient'])) {
			$_SESSION['action'] = 'updatePatient';
			$_SESSION['patientID'] = $_POST['value'];
			header('Location: ./patient.php');
		}
		elseif (isset($_POST['deletePatient'])) {
			DeletePatient($_POST['value']);
			header('Location: ./patientUpdated.php');
		}
		elseif (isset($_POST['choosePatientIntervention'])) {
			$_SESSION['patientID'] = $_POST['value'];
			header('Location: ./askIntervention.php');
		}
		elseif (isset($_POST['choosePatientEmergency'])) {
			# $_SESSION['patientID'] =$_POST['value'];
			header('Location: ./emergencyDone.php');
		}
	?>

	<h1>Résultats de la recherche de patient</h1>

	<form action="resultsPatient.php" method="post">
	<?php
		$tab=SearchPatient($_POST);
		
		if (!empty($tab)){
			$i=0;
		
		# PrintResults;
		if ($_SESSION['action'] == 'searchPatient') {
			echo '<form method="post">';
			while ($i < count($tab)){
				$result=returnPatient($tab[$i]);
				PrintResults($result,'radio');
				$i=$i+1;
			}
			echo '<input type="submit" name="updatePatient" value="Modifier patient" /><br>' . "\n";
			echo '<input type="submit" name="deletePatient" value="Supprimer patient" /><br>' . "\n";
			echo '</form>';
		}
		elseif ($_SESSION['action'] == 'addIntervention') {
			echo '<form method="post">';
			while ($i < count($tab)){
				$result=returnPatient($tab[$i]);
				PrintResults($result,'radio');
				$i=$i+1;
			}
			echo '<input type="submit" name="choosePatientIntervention" value="Choisir le patient sélectionné" /><br>' . "\n";
			echo '<input type="submit" name="addPatient" value="Créer un patient" /><br>' . "\n";
			echo '</form>';
		}
		elseif ($_SESSION['action'] == 'emergencyWithExistingPatient') {
			#rajouter form
			while ($i < count($tab)){
				$result=returnPatient($tab[$i]);
				PrintResults($result,'radio');
				$i=$i+1;
			}
			echo '<input type="submit" name="choosePatientEmergency" value="Choisir le patient sélectionné" /><br>' . "\n";
		}
		}
	?>

	</div>
</body>

<?php
	PrintFooter();
?>

</html>