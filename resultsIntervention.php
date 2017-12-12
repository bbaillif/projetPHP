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
			DeleteIntervention($_POST['value']);
			header('Location: ./interventionDeleted.php');
		}
		elseif (isset($_POST['factureIntervention'])) {
			FactureIntervention($_POST['value']);
			header('Location: ./interventionFactured.php');
		}
		else {
			# Do nothing
		}
	?>

	<form action="resultsIntervention.php" method="post">
	<?php
		if ($_SESSION['action'] == 'deleteIntervention') {
			echo "<h1>Recherche terminée. Choisir quelle(s) intervention(s) supprimer : </h1>";
			$interventions = SearchIntervention($_POST, "", "", $_SESSION['uid']);
			foreach ($interventions as $idx => $info_array) {
				$ID_intervention = $interventions[$idx]['ID_creneau'] . ' ' . $interventions[$idx]['ID_service_int'];
				echo '<input type="radio" name="value" value="' . $ID_intervention . '">' . "\n";
				foreach ($info_array as $info => $value) {
					echo $value . '  ';
				}
			}
			echo '<input type="submit" name="deleteIntervention" value="Supprimer intervention" /><br>' . "\n";
		}
		elseif ($_SESSION['action'] == 'seeFacturedIntervention') {
			echo "<h1>Recherche terminée. Interventions facturées :</h1>";
			$interventions = SearchIntervention($_POST, "F", "", $_SESSION['uid']);
			echo "<ul>";
			foreach ($interventions as $idx => $info_array) {
				echo '<li>';
				foreach ($info_array as $info => $value) {
					echo $value . '  ';
				}
				echo '</li><br>';
			}
			echo "</ul>";
		}
		elseif ($_SESSION['action'] == 'factureIntervention') {
			echo "<h1>Recherche terminée. CHoisir quelle(s) intervention(s) facturer : </h1>";
			$interventions = SearchIntervention($_POST, "NF", $_SESSION['service'], "");
			foreach ($interventions as $idx => $info_array) {
				$ID_intervention = $interventions[$idx]['ID_creneau'] . ' ' . $interventions[$idx]['num_secu'];
				echo '<input type="radio" name="value" value="' . $ID_intervention . '">' . "\n";
				foreach ($info_array as $info => $value) {
					echo $value . '  ';
				}

			}
			echo '<input type="submit" name="factureIntervention" value="Facturer" /><br>' . "\n";

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