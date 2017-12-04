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

			if ($_SESSION['right'] == 'doctor') {
				if ($_SESSION['action'] == 'addPatient' 
					OR $_SESSION['action'] == 'searchPatient') {
					header('Location: ./patient.php');
				}
				elseif ($_SESSION['action'] == 'addIntervetion') {
					header('Location: ./askIntervetion.php');
				}
				elseif ($_SESSION['action'] == 'deleteIntervetion' 
					OR $_SESSION['action'] == 'seeFacturedIntervention') {
					header('Location: ./searchIntervention.php');
				}
			}

			if ($_SESSION['right'] == 'responsible') {
				if ($_SESSION['action'] == 'changeDay') {
					header('Location: ./searchDay.php');
				}
				elseif ($_SESSION['action'] == 'emergencyWithNewPatient'
					OR $_SESSION['action'] == 'emergencyWithExistingPatient') {
					header('Location: ./patient.php');
				}
				elseif ($_SESSION['action'] == 'emergencyWithoutPatient') {
					header('Location: ./emergencyDone.php');
				}
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
			echo '<a href="?action=changeDay">Modifier demi-journée</a><br>' . "\n";
			echo '<p>Insérer urgence</p>';
			echo '<a href="?action=emergencyWithoutPatient">Immédiate (sans patient)</a><br>' . "\n";
			echo '<a href="?action=emergencyWithNewPatient">Avec un nouveau</a><br>' . "\n";
			echo '<a href="?action=emergencyWithExistingPatient">Avec un patient connu</a><br>' . "\n";
			echo '<a href="?action=addPatient">Facturer</a><br>' . "\n";
		}
		elseif ($_SESSION['right'] == 'admin') {
			echo '<a href="?action=addPatient">Gérer service d\'accueil</a><br>' . "\n";
			echo '<a href="?action=addPatient">Gérer service d\'intervention</a><br>' . "\n";
			echo '<a href="?action=addPatient">Voir historique</a><br>' . "\n";
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