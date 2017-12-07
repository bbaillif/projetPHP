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
		PrintHeader();
	?>

	<h1>Annuaire électronique</h1>

	<form method="post" action="resultsSearchMail.php">
		Rechercher la personne à qui vous voulez envoyer un mail<br><br>
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

