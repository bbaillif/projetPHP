<?php
	require("./fonctions.php");
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
		echo '<a href="./?action="searchMail">Rechercher adresse mail</a>'. "\n";
		echo '<br>'. "\n";
		echo '<a href="./login.php?action=logout">Deconnexion</a><br>'. "\n";
	?>

	<h1>Bienvenue sur le site en construction.</h1>

	<?php
		if (isset($_GET['action'])) {
			$_SESSION['action'] = $_GET['action'];

			if ($_SESSION['action'] == 'addIntervention') {
				header('Location: ./searchUser.php');
			}

			if ($_SESSION['right'] == '1') {
				if ($_SESSION['action'] == 'addPatient' 
					OR $_SESSION['action'] == 'searchPatient') {
					header('Location: ./patient.php');
				}
				elseif ($_SESSION['action'] == 'addIntervention') {
					header('Location: ./askIntervention.php');
				}
				elseif ($_SESSION['action'] == 'deleteIntervention' 
					OR $_SESSION['action'] == 'seeFacturedIntervention') {
					header('Location: ./searchIntervention.php');
				}
			}

			elseif ($_SESSION['right'] == '2') {
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
				elseif ($_SESSION['action'] == 'factureIntervention') {
					header('Location: ./searchIntervention.php');
				}
			}

			elseif ($_SESSION['right'] == '0') {
				if ($_SESSION['action'] == 'addHospitalService') {
					# verifier que le nom est valide
					# AddHospitalService($_POST($hospitalServiceToAdd));
					header('Location: ./hospitalServiceAdded.php');
				}
				elseif ($_SESSION['action'] == 'addInterventionService') {
					# verifier que le nom est valide
					# AddInterventionService($_POST($interventionServiceToAdd));
					header('Location: ./interventionServiceAdded.php');
				}
				elseif ($_SESSION['action'] == 'seeLogs') {
					header('Location: ./searchUser.php');
				}
			}

			else {
				echo "action incorrecte";
				$_SESSION['action'] = '';
			}
		}

		if ($_SESSION['right'] == '1') {
			echo '<a href="?action=addPatient">Créer patient</a><br>' . "\n";
			echo '<a href="?action=searchPatient">Rechercher patient</a><br>
' . "\n";
			echo '<a href="?action=addIntervention">Créer intervention</a><br>' . "\n";
			echo '<a href="?action=deleteIntervention">Supprimer intervention</a><br>' . "\n";
			echo '<a href="?action=seeFacturedIntervention">Voir interventions facturées</a><br>' . "\n";
		}
		elseif ($_SESSION['right'] == '2') {
			echo '<a href="?action=changeDay">Modifier demi-journée</a><br>' . "\n";
			echo '<p>Insérer urgence</p>';
			echo '<a href="?action=emergencyWithoutPatient">Immédiate (sans patient)</a><br>' . "\n";
			echo '<a href="?action=emergencyWithNewPatient">Avec un nouveau</a><br>' . "\n";
			echo '<a href="?action=emergencyWithExistingPatient">Avec un patient connu</a><br>' . "\n";
			echo '<a href="?action=factureIntervention">Facturer</a><br>' . "\n";
		}

		elseif ($_SESSION['right'] == '0') {
			echo '<form action="?addHospitalService" method="post">' . "\n";
			echo 'Ajouter service d\'accueil : <input type="text" name="hospitalServiceToAdd">' . "\n";
			echo '<input type="submit" value="Ajouter">' . "\n";
			echo '</form>' . "\n";

			echo '<form action="hospitalServiceDeleted.php" method="post">' . "\n";
			echo 'Supprimer service d\'accueil : <select name = "hospitalServiceToDetele">' . "\n";
			$array = ReturnHospitalService();
			$i = 0; 
			while ($i < count($array)){
			 	print("<option value = \"$array[$i]\">".$array[$i]."</option>"); 
			 	$i=$i+1;
			 }
			echo '</select>' . "\n";
			echo '<input type="submit" value="Supprimer">' . "\n";
			echo '</form>' . "\n";

			echo '<form action="?addInterventionService" method="post">' . "\n";
			echo 'Ajouter service d\'accueil : <input type="text" name="interventionServiceToAdd">' . "\n";
			echo '<input type="submit" value="Ajouter">' . "\n";
			echo '</form>' . "\n";

			echo '<form action="interventionServiceDeleted.php" method="post">' . "\n";
			echo 'Supprimer service d\'accueil : <select name = "interventionServiceToDetele">' . "\n";
			$array = ReturnInterventionService(); 
			$i = 0; 
			while ($i < count($array)){
			 	print("<option value = \"$array[$i]\">".$array[$i]."</option>"); 
			 	$i=$i+1;
			 }
			echo '</select>' . "\n";
			echo '<input type="submit" value="Supprimer">' . "\n";
			echo '</form>' . "\n";

			echo '<a href="?action=seeLogs">Voir historique</a><br>' . "\n";
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

	<form action="addHospitalService.php">
		Ajouter service d'accueil : <input type="text" name="serviceName">
		<input type="submit" value="Ajouter">
	</form>

</body>

</html>