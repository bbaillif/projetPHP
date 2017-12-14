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
	<?php
		if (isset($_POST['deleteIntervention'])) {
			if (!empty($_POST['value'])){
				DeleteIntervention($_POST['value']);
				header('Location: ./interventionDeleted.php');
				exit();
			}
		}
		elseif (isset($_POST['factureIntervention'])) {
			if (!empty($_POST['value'])){
				FactureIntervention($_POST['value']);
				header('Location: ./interventionFactured.php');
				exit();
			}
		}
		elseif (isset($_POST['addPatientEmergency'])) {
			if (!empty($_POST['value'])){
				$_SESSION['action']= 'addPatientEmergency';
				$_SESSION['ID_intervention']= $_POST['value'];
				header('Location: ./patient.php');
				exit();
			}
		}
		elseif (isset($_POST['searchPatientEmergency'])) {
			if (!empty($_POST['value'])){
				$_SESSION['action']= 'searchPatientEmergency';
				$_SESSION['ID_intervention']= $_POST['value'];
				header('Location: ./patient.php');
				exit();
			}
		}
		else {
			# Do nothing
		}
	?>

	<form action="resultsIntervention.php" method="post">
	<?php
		if ($_SESSION['action'] == 'deleteIntervention') {
			echo "<h1>Recherche terminée. Choisir quelle intervention supprimer : </h1>";
			$interventions = SearchIntervention($_POST, "", "", $_SESSION['uid']);
			if (!empty($interventions)) {
				foreach ($interventions as $idx => $info_array) {
					$ID_intervention = $info_array['ID_creneau'] . ' ' . $info_array['ID_service_int'];
					echo '<input type="radio" name="value" value="' . $ID_intervention . '">' . "\n";
					$infosToSentence = array($info_array['ID_creneau'], $info_array['ID_service_int']);
					$sentence = ReturnIntervention($infosToSentence);
					echo $sentence[0] . "<br>\n";
				}
				echo '<input type="submit" name="deleteIntervention" value="Supprimer intervention" /><br>' . "\n";
			}
		}
		elseif ($_SESSION['action'] == 'seeFacturedIntervention') {
			echo "<h1>Recherche terminée. Interventions facturées :</h1>";
			$interventions = SearchIntervention($_POST, "F", "", $_SESSION['uid']);
			if (!empty($interventions)) {
				echo "<ul>";
				foreach ($interventions as $idx => $info_array) {
					echo '<li>';
					$infosToSentence = array($info_array['ID_creneau'], $info_array['ID_service_int']);
					$sentence = ReturnIntervention($infosToSentence);
					echo $sentence[0];
					echo '</li><br>';
				}
				echo "</ul>";
			}
		}
		elseif ($_SESSION['action'] == 'factureIntervention') {
			echo "<h1>Recherche terminée. Choisir quelle(s) intervention(s) facturer : </h1>";
			$interventions = SearchIntervention($_POST, "NF", $_SESSION['service'], "");
			if (!empty($interventions)) {
				foreach ($interventions as $idx => $info_array) {
					$ID_intervention = $interventions[$idx]['ID_creneau'] . ' ' . $interventions[$idx]['num_secu'];
					echo '<input type="radio" name="value" value="' . $ID_intervention . '">' . "\n";
					$infosToSentence = array($info_array['ID_creneau'], $info_array['ID_service_int']);
					$sentence = ReturnIntervention($infosToSentence);
					echo $sentence[0];
				}
				echo '<br><input type="submit" name="factureIntervention" value="Facturer" /><br>' . "\n";
			}
		}
		elseif ($_SESSION['action'] == 'patientEmergency') {
			echo "<h1>Recherche terminée. Choisir à quelle intervention vous voulez affilier à un patient : </h1>";
			$interventions = SearchIntervention($_POST, "", $_SESSION['service'], $_SESSION['uid']) ;
			if (!empty($interventions)) {
				foreach ($interventions as $idx => $info_array) {
					$ID_intervention = $interventions[$idx]['ID_creneau'];
					echo '<input type="radio" name="value" value="' . $ID_intervention . '">' . "\n";
					$infosToSentence = array($info_array['ID_creneau'], $info_array['ID_service_int']);
					$sentence = ReturnIntervention($infosToSentence);
					echo $sentence[0];
				}
				echo '<br><input type="submit" name="searchPatientEmergency" value="Rechercher un patient" />' . "\n";
				echo '<br><input type="submit" name="addPatientEmergency" value="Ajouter un patient" /><br>' . "\n";
			}
		}
		else {
			header('Location: ./index.php');
		}
?>
	</form>
	</div>

<?php
	PrintFooter();
?>

</body>
</html>