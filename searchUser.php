<?php
	require("./fonctionsBen.php");
	require("./fonctionSo.php");
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

		if ($_SESSION['action'] == 'searchMail') {
			echo '<h1>Rechercher de personnel (mail) </h1><br><br>' . "\n";
		}
		elseif ($_SESSION['action'] == 'seeLogs') {
			echo '<h1>Rechercher de personnel (historique) </h1><br><br>' . "\n";
		}
	?>

	<form method="post" action="resultsUser.php">
		<select name = "nom">
			<?php
			$array = ReturnName(); 
			$i = 0; 
			while ($i < count($array)){
				$nom = $array[$i];
				$i = $i+1;
				$prenom = $array[$i];
			 	print("<option value = \"$nom $prenom\">".$nom." ".$prenom."</option>"); 
			 	$i=$i+1;
			 } 
			?>
			Rajouter la fonction qui va imprimer tous les noms dans le formulaire 
		</select>
		<input type="submit" value="Valider">
	</form>
	
	<?php
    	PrintFooter();
    ?>

</body>

</html>

