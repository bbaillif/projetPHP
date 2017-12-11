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
		if ($_SESSION['action'] == 'addIntervention'){
			$_SESSION['EL'] = $_POST['interventionEmergencyNumber'];
			$_SESSION['intervention'] = $_POST['intervention']; 
		}
		elseif ($_SESSION['action'] == 'nextIntervention'){
			$_SESSION['EL'] = $_SESSION['EL'] - 1; 
		}
		elseif ($_SESSION['action'] == 'chooseIntervention'){
			#on crée l'intervention
			#On va vers InterventionCreated.php  
		}
	?>

	<h1>Résultats de la recherche de créneaux libres</h1>

	<form action="resultsFreeTime.php" method="post">
	<?php
		$freeTime = SearchFreeTime($_SESSION['intervention']);
		if (!empty($freeTime)){
			if ($_SESSION['action'] == 'addIntervention') {
			print_r($freeTime); 
			$result2 = ReturnIntervention($result); 
			PrintResults($result2, "radio");
			echo '<input type="submit" name="deleteIntervention" value="Supprimer intervention" /><br>' . "\n";
			echo '<input type="submit" name="chooseIntervention" value="Choisir l\'intervention sélectionné" />       ' . "\n";
			echo '<input type="submit" name="nextIntervention" value="Voir les interventions suivantes" /><br>' . "\n";
		}
		}
		#$PrintFreeTime = PrintFreeTime($freeTime, $_SESSION['EL']);
		# SearchFreeTime
		# PrintFreeTime(tableau, true);
	?>

	</div>
</body>

<?php
	$_SESSION['action'] = '';
	PrintFooter();
?>

</html>