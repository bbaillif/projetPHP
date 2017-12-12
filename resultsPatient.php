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
		if (isset($_POST['updatePatient'])) {
			$_SESSION['action'] = 'updatePatient';
			$_SESSION['patientID'] = $_POST['patient_idx'];
			header('Location: ./patient.php');
			exit();
		}
		elseif (isset($_POST['deletePatient'])) {
			DeletePatient($_POST['patient_idx']);
			header('Location: ./patientUpdated.php');
			exit();
		}
		elseif (isset($_POST['choosePatientIntervention'])) {
			$_SESSION['patientID'] = $_POST['patient_idx'];
			$_SESSION['action'] = '';
			header('Location: ./askIntervention.php');
			exit();
		}
		elseif (isset($_POST['choosePatientEmergency'])) {
			# $_SESSION['patientID'] =$_POST['patient_idx'];
			header('Location: ./emergencyDone.php');
			exit();
		}
		elseif (isset($_POST['addPatientIntervention'])) {
			# code...
		}
	?>

	<h1>Résultats de la recherche de patient</h1>

	<?php
		if ($_SESSION['action'] =='searchPatient' 
			OR $_SESSION['action'] == 'emergencyWithExistingPatient'
			OR $_SESSION['action'] == 'addIntervention' ){
			if(empty($_POST['ssNumber'])){
				$_SESSION['action'] ='searchPatient'; 
				header('Location: ./patient.php');
				exit();
			}
			else {
				echo '<form action="resultsPatient.php" method="post">';
				$patients_array=SearchPatient($_POST);
			}
			
			foreach ($patients_array as $idx => $info_array) {
				foreach ($info_array as $info => $value) {
					echo $value . '  ';
				}
				echo '<input type="radio" name="patient_idx" value="' . $info_array['ssNumber'] . '">' ;
			}

			if ($_SESSION['action'] == 'searchPatient') {
				echo '<input type="submit" name="updatePatient" value="Modifier patient" /><br>' . "\n";
				echo '<input type="submit" name="deletePatient" value="Supprimer patient" /><br>' . "\n";
				echo '</form>';
			}
			elseif ($_SESSION['action'] == 'addIntervention') {
				echo '<input type="submit" name="choosePatientIntervention" value="Selectionner ce patient" /><br>' . "\n";
				echo '<input type="submit" name="addPatientIntervention" value="Créer un patient" /><br>' . "\n";
				echo '</form>';
			}
			elseif ($_SESSION['action'] == 'emergencyWithExistingPatient') {
				echo '<input type="submit" name="choosePatientEmergency" value="Choisir le patient sélectionné" /><br>' . "\n";
				echo '</form>';
			}
		}
	?>

	</div>

<?php
	PrintFooter();
?>
</body>
</html>