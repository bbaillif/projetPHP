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
		
		if ($_SESSION['action'] == 'addPatientEmergency') {
			echo '<h1>Création ou recherche nouveau patient</h1>' . "\n";
			echo '<form action="addPatientEmergency.php" method="post">'. "\n";
			echo '<input type="radio" name="value" value="searchPatientE"> Rechercher patient<br><br>';
			echo '<input type="radio" name="value" value="addPatientE"> Creer patient<br><br>';
			echo '<input type="submit" name="Choix" value="Submit" /><br>' . "\n";
		}
		
		if (isset($_POST['value'])) {
			$_SESSION['action'] = $_POST['value'];
			header('Location: ./patient.php');
			exit();
		}

		?>
		

    </div>

<?php
	PrintFooter();
?>
</body>
</html>