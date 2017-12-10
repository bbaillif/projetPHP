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
	<h1>Supprimer un service</h1>

	<?php 
		echo '<form action="hospitalServiceDeleted.php" method="post">' . "\n";
		echo 'Supprimer service d\'accueil : <select name = "hospitalServiceToDelete">' . "\n";
		$array = ReturnService("accueil");
		$i = 0; 
		while ($i < count($array)){
			print("<option value = \"$array[$i]\">".$array[$i+1]."</option>"); 
			$i=$i+2;
		}
		echo '</select>' . "\n";
		echo '<input type="submit" value="Supprimer">' . "\n";
		echo '</form>' . "\n";

		echo '<br>';

		echo '<form action="interventionServiceDeleted.php" method="post">' . "\n";
		echo 'Supprimer service d\'intervetion : <select name = "interventionServiceToDelete">' . "\n";
		$array = ReturnService ("intervention");
		$i = 0; 
		while ($i < count($array)){
			print("<option value = \"$array[$i]\">".$array[$i+1]."</option>"); 
			$i=$i+2;
		}
		echo '</select>' . "\n";
		echo '<input type="submit" value="Supprimer">' . "\n";
		echo '</form>' . "\n";
	?>

	</div>
</body>

<?php
	PrintFooter();
?>

</html>