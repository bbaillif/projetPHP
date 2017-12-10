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
		if ($_SESSION['action'] == 'searchMail') {
			echo '<h1>Rechercher de personnel (mail) </h1><br><br>' . "\n";
		}
		elseif ($_SESSION['action'] == 'seeLogs') {
			echo '<h1>Rechercher de personnel (historique) </h1><br><br>' . "\n";
		}
	?>

	<form method="post" action="resultsUser.php">
		<select name = "ID">
			<?php
			$array = ReturnName(); 
			$i = 0; 
			while ($i < count($array)){
				$nom = $array[$i];
				$i = $i+1;
				$prenom = $array[$i];
				$i=$i+1; 
				$ID = $array[$i];
			 	print("<option value = \"$ID\">".$nom." ".$prenom."</option>"); 
			 	$i=$i+1;
			 } 
			?>
		</select>
		<input type="submit" value="Valider">
	</form>
	
	</div>
</body>

<?php
	PrintFooter();
?>

</html>

