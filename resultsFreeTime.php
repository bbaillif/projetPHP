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
		print_r($_POST); 
		print_r($_SESSION);
		if ($_SESSION['action'] == 'addIntervention'){
			if (empty($_SESSION['EL']) && empty($_SESSION['intervention'])){
				$_SESSION['EL'] = $_POST['interventionEmergencyNumber'];
				$_SESSION['intervention'] = $_POST['intervention'];
			} 
		}

		if (isset($_POST['nextIntervention'])){
			$_SESSION['action'] = 'addIntervention'; 
			$_SESSION['EL'] = $_SESSION['EL'] - 1; 
		}
		elseif (isset($_POST['chooseIntervention'])){
			#on crée l'intervention
			$ID_intervention = explode(" ",$_POST['value'])[0];
			AddIntervention($_SESSION['intervention'], $ID_intervention, $_SESSION['uid'], $_SESSION['patientID']); 
			header('Location: ./interventionCreated.php ');
		}
	?>

	<h1>Résultats de la recherche de créneaux libres</h1>

	<form action="resultsFreeTime.php" method="post">
	<?php
		$freeTime = SearchFreeTime($_SESSION['intervention']);
		if ($freeTime != array()){
			if ($_SESSION['action'] == 'addIntervention') {
			PrintFreeTime($freeTime,$_SESSION['EL']); 
			echo '<input type="submit" name="chooseIntervention" value="Choisir l\'intervention sélectionnée" />       ' . "\n";
			echo '<input type="submit" name="nextIntervention" value="Voir les interventions suivantes" /><br>' . "\n";
			}
		}
	?>

	</div>
</body>

<?php
	PrintFooter();
?>

</html>