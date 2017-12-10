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
	<h1> Résumé patient choisi </h1>

		<?php 
			$infoField = InfoFieldPatient();
			#$infoPatient = FetchInfoPatient($_SESSION['patientID']);
			foreach ($infoField as $infoName => $relatedInfo) {
				echo($relatedInfo['french'] . ' : ' . $infoPatient[$infoName] . "\n");
			}
		?>

		<form action="resultsFreeTime.php" method="post">
		Numéro d'urgence lié à l'intervention <input type="number" name="interventionEmergencyNumber" value=<?php $infoPatient['ssNumber']?> >
		<input type="submit" value="Valider" /><br>
		</form>

    	</div>
</body>

<?php
	PrintFooter();
?>

</html>