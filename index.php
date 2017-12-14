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
		<h1>Intranet Hopital Polytech</h1>

		<?php
		if (isset($_GET['action'])) {
			$_SESSION['action'] = $_GET['action'];

			if ($_SESSION['action'] == 'searchMail') {
				header('Location: ./searchUser.php');
				exit();
			}

			elseif ($_SESSION['right'] == '1') {
				if ($_SESSION['action'] == 'addPatient' 
					OR $_SESSION['action'] == 'searchPatient' 
					OR $_SESSION['action'] == 'updateEL') {
					header('Location: ./patient.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'addIntervention') {
					header('Location: ./patient.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'deleteIntervention' 
					OR $_SESSION['action'] == 'seeFacturedIntervention') {
					header('Location: ./searchIntervention.php');
					exit();
				}
				else {
					echo "Action incorrecte";
				}
			}

			elseif ($_SESSION['right'] == '2') {
				if ($_SESSION['action'] == 'changeDay') {
					header('Location: ./searchDay.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'surbooking') {
					header('Location: ./changeDay.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'emergencyWithNewPatient'
					OR $_SESSION['action'] == 'emergencyWithExistingPatient') {
					header('Location: ./patient.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'emergencyWithoutPatient') {
					header('Location: ./emergencyDone.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'factureIntervention') {
					header('Location: ./searchIntervention.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'patientEmergency') {
					header('Location: ./searchIntervention.php');
					exit();
				}
				else {
					echo "Action incorrecte";
				}
			}

			elseif ($_SESSION['right'] == '0') {
				if ($_SESSION['action'] == 'seeLogs') {
					header('Location: ./searchUser.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'seeServiceArchive') {
					header('Location: ./searchService.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'checkEmergencyNumber') {
					header('Location: ./checkEmergencyNumber.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'deleteService') {
					header('Location: ./deleteService.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'addService') {
					header('Location: ./addService.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'addPatient') {
					header('Location: ./patient.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'deleteIntervention') {
					header('Location: ./searchIntervention.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'addIntervention') {
					header('Location: ./patient.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'addUser') {
					header('Location: ./addUser.php');
					exit();
				}
				elseif ($_SESSION['action'] == 'deleteUser') {
					header('Location: ./searchUser.php');
					exit();
				}
				else {
					echo "Action incorrecte";
				}
			}

			else {
				echo "Droit non identifié, ou action commune incorrecte";
			}
		} #end if (isset($_GET['action']))
		else {
			# Do nothing, print menu anyway
		}

		foreach ($_SESSION as $key => $value) {
			if ($key != 'right' AND $key != 'uid' AND $key != 'service' AND $key != 'action') {
				unset($_SESSION[$key]);
			}
			elseif ($key == 'action') {
				$_SESSION['action'] = '';
			}
		}

		if ($_SESSION['right'] == '1') {
			echo '<br><br>';
			echo '<p class = "bouton"> <a href="?action=addPatient">Créer patient</a> </p>' . "\n";
			echo '<p class = "bouton"> <a href="?action=searchPatient">Rechercher patient</a> </p>' . "\n";
			echo '<p class = "bouton"> <a href="?action=updateEL">Mettre à jour le niveau d\'urgence</a> </p>' . "\n";
			echo '<p class = "bouton"> <a href="?action=addIntervention">Créer intervention</a> </p>' . "\n";
			echo '<p class = "bouton"> <a href="?action=deleteIntervention">Supprimer intervention</a> </p>' . "\n";
			echo '<p class = "bouton"> <a href="?action=seeFacturedIntervention">Voir interventions facturées</a> </p>' . "\n";
		}

		elseif ($_SESSION['right'] == '2') {
			#if (CheckSurbooking($_SESSION['service'])){
				echo "Attention : il y a un surbooking, pour le gérer cliquer <a href=\"?action=surbooking\"><u>ici</u></a>";
			#}
			PrintSchedule($_SESSION['service']);
			echo '<br>';
			echo '<p class = "bouton"> <a href="?action=changeDay">Modifier demi-journée</a> </p>' . "\n";
			echo '<p class = "bouton"> <a href="?action=emergencyWithoutPatient">Insérer une urgence immédiate (sans patient)</a> </p>' . "\n";
			echo '<p class = "bouton"> <a href="?action=patientEmergency">Ajouter un patient rentré en urgence</a> </p>' . "\n";
			echo '<p class = "bouton"> <a href="?action=emergencyWithNewPatient"> Insérer une urgence avec un nouveau patient</a> </p>' . "\n";
			echo '<p class = "bouton"> <a href="?action=emergencyWithExistingPatient"> Insérer une urgence avec un patient connu</a> </p>' . "\n";
			echo '<p class = "bouton"> <a href="?action=factureIntervention">Facturer</a> </p><br>' . "\n";
		}

		elseif ($_SESSION['right'] == '0') {
			echo '<h2> Gérer les services </h2>';
			echo '<p class = "bouton"> <a href="?action=addService">Ajouter un service</a> </p>';
			echo '<p class = "bouton"> <a href="?action=deleteService">Supprimer un service</a> </p>';
			echo '<p class = "bouton"> <a href="?action=seeServiceArchive">Voir historique des services</p></a> </p>' . "\n";	
			echo '<h2> Gérer les utilisateurs </h2>';
			echo '<p class = "bouton"> <a href="?action=addUser">Ajouter un utilisateur</a> </p>';
			echo '<p class = "bouton"> <a href="?action=deleteUser">Supprimer un utilisateur</a> </p>';
			echo '<p class = "bouton"> <a href="?action=seeLogs">Voir historique du personnel</a> </p>' . "\n";
			echo '<h2> Action technique </h2>';
			echo '<p class = "bouton"> <a href="?action=addPatient">Créer patient</a> </p>';
			echo '<p class = "bouton"> <a href="?action=addIntervention">Créer intervention</a> </p>' . "\n";					
			echo '<p class = "bouton"> <a href="?action=deleteIntervention">Supprimer intervention</a> </p>' . "\n";			
			echo '<p class = "bouton"><a href="?action=checkEmergencyNumber">Vérifier la cohérence pathologie/numéro d\'urgence</a> </p>' . "\n";
			echo '<br><br>' . "\n";
		}
		else {
			echo 'Droit non identifié';
		}

		echo '<br>'. "\n";
		?>

	</div>

	<?php
	PrintFooter();
	?>

</body>

</html>