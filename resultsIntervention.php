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
		if (isset($_POST['deleteIntervention'])) {
			DeleteIntervention($_POST['value']);
			header('Location: ./interventionDeleted.php');
		}
		elseif (isset($_POST['factureIntervention'])) {
			FactureIntervention($_POST['value']);
			header('Location: ./interventionFactured.php');
		}
		else {
			# Do nothing
		}
	?>

	<h1>Résultats de la recherche d'intervention</h1>

	<form action="resultsIntervention.php" method="post">
	<?php
		# PrintResults(tableau, true);
		if ($_SESSION['action'] == 'deleteIntervention') {
			$result = SearchIntervention($_POST);
			if (!empty($result)){
				$result2 = ReturnIntervention($result); 
				PrintResults($result2, "radio");
				echo '<input type="submit" name="deleteIntervention" value="Supprimer intervention" /><br>' . "\n";
			}
		}
		elseif ($_SESSION['action'] == 'seeFacturedIntervention') {
			$result = SearchIntervention_Facture($_POST, 1);
			if (!empty($result)){
				$result2 = ReturnIntervention($result); 
				PrintResults($result2,"list");
			}
		}
		elseif ($_SESSION['action'] == 'factureIntervention') {
			$result = SearchIntervention_Facture($_POST,0);
			if (!empty($result)){
				$result2 = ReturnInterventionNF($result); 
				PrintResults($result2,"checkbox");
				echo '<input type="submit" name="factureIntervention" value="Facturer" /><br>' . "\n";
			}
		}
		else {
			header('Location: ./index.php');
		}
	?>
	</form>
	</div>
</body>

<?php
	$_SESSION['action'] = '';
	PrintFooter();
?>

</html>