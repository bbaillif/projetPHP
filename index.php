<?php
	require("./fonctionsBen.php");
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
		echo '<a href="./login.php?action=logout">Deconnexion</a><br>'. "\n";
	?>

	<h1>Bienvenue sur le site en construction.</h1>

	<?php
		if (isset($_GET['action'])) {
			$_SESSION['action'] = $_GET['action'];
			if ($_SESSION['action'] == 'addPatient') {
				header('Location: ./patient.php');
			}
			elseif ($_SESSION['action'] == 'searchPatient') {
				header('Location: ./patient.php');
			}
			elseif ($_SESSION['action'] == 'addIntervetion') {
				header('Location: ./askIntervetion.php');
			}
			elseif ($_SESSION['action'] == 'deleteIntervetion') {
				#header('Location: ./index.php');
			}
			elseif ($_SESSION['action'] == 'seeFacturedIntervention') {
				#header('Location: ./index.php');
			}
			else {
				echo "action incorrecte";
				$_SESSION['action'] = '';
			}
		}

		if ($_SESSION['right'] == 'doctor') {
			echo '<a href="?action=addPatient">Créer patient</a><br>' . "\n";
			echo '<a href="?action=searchPatient">Rechercher patient</a><br>
' . "\n";
			echo '<a href="?action=addIntervetion">Créer intervention</a><br>' . "\n";
			echo '<a href="?action=deleteIntervetion">Supprimer intervention</a><br>' . "\n";
			echo '<a href="?action=seeFacturedIntervention">Voir interventions facturées</a><br>' . "\n";
		}
		elseif ($_SESSION['right'] == 'responsible') {
			# code...
		}
		elseif ($_SESSION['right'] == 'admin') {
			# code...
		}
		else {
			echo 'ERREUR, A DEBUGER';
		}
	?>

	<?php
		echo '<br>'. "\n";
		print_r($_SESSION);
		echo '<br>'. "\n";
		PrintFooter();
	?>

</body>

</html>