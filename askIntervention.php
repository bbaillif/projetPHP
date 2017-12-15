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
			if(empty($_SESSION['patientID'])){
				header('Location: ./patient.php');
			}
			$_SESSION['action']="addIntervention";
			$array = array('name' => "", 'surname' => "", 
				'ssNumber' => $_SESSION['patientID'], 'gender' => '', 
				'birthday' => '', 'pathology' => '', 'emergencyLevel' => '');
			$infosPatient = searchPatient($array);
			$infoPatient = $infosPatient[0];
			print '<p> Nom : '.$infoPatient['surname'].'</p>';
			print '<p> Prénom : '.$infoPatient['name'].'</p>';
			print '<p> Sexe : '.$infoPatient['gender'].' <p>'; 
			print '<p> Numéro de sécurité sociale '.$infoPatient['ssNumber'].'</p> ';
			print '<p> Date de naissance : '.$infoPatient['birthday'].' </p>'; 
			print '<p> Pathologie : '.$infoPatient['pathology'].' </p>'; 
		?>

		<form action="resultsFreeTime.php" method="post">

		Intervention demandée <select name = "intervention"> 
		<?php 
			$array = ReturnService("intervention"); 
			$i = 0; 
			while ($i < count($array)){
			 	print("<option value = \"$array[$i]\">".$array[$i+1]."</option>"); 
			 	$i=$i+2;
			} 
		?>
		</select> <br> <br>

		Numéro d'urgence lié à l'intervention <input type="number" name="interventionEmergencyNumber" value=<?php print("\"".$infoPatient['emergencyLevel']."\"")?> min = "0" max="10">

		<input type="submit" value="Valider" /><br>
		</form>

    	</div>

<?php
	PrintFooter();
?>
</body>
</html>