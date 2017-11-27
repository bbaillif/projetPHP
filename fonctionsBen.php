<?php
	function PrintHeader() {
		echo '<a href="./index.php">Menu principal</a>' . "\n";
		echo '<br>'. "\n";
		echo '<a href="./searchMail.php">Chercher Mail</a>'. "\n";
		echo '<br>'. "\n";
	}

	function PrintFooter() {
		echo '<br>'. "\n";
		echo '<a href="./index.php">Menu principal</a>'. "\n";
		echo '<br><br>'. "\n";
		echo 'Site créé pour le projet de base de données'. "\n";
	}

	function CheckUID() {
		if (!isset($_SESSION['uid'])) {
			header('Location: ./login.php');
		}
	}

	function InfoFieldPatient() {
		$infoField['surname'] = array('french' => 'Nom','type' => 'text', 'DBentry' => 'nom');
		$infoField['name'] = array('french' => 'Prénom','type' => 'text', 'DBentry' => 'prenom');
		$infoField['gender'] = array('french' => 'Sexe','type' => 'text', 'DBentry' => 'sexe');
		$infoField['ssNumber'] = array('french' => 'Numéro de sécurité sociale','type' => 'text', 'DBentry' => 'num_secu');
		$infoField['birthday'] = array('french' => 'Date de naissance','type' => 'date', 'DBentry' => 'date_naiss');
		$infoField['pathology'] = array('french' => 'Pathologie','type' => 'text', 'DBentry' => 'pathologie');
		$infoField['emergencyLevel'] = array('french' => 'Niveau d\'urgence','type' => 'number', 'DBentry' => 'NU');
		return($infoField);
	}