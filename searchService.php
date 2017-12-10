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
	<h1>Rechercher un service</h1>

	<form method="post" action="archiveService.php">
		<select name = "ID">
			<optgroup label="Service Accueil"> 
			<?php
				$array = ReturnService("accueil"); 
				$i = 0; 
				while ($i < count($array)){
				 	print("<option value = \"$array[$i]\">".$array[$i+1]."</option>"); 
				 	$i=$i+2;
				} 
			?>
			</optgroup>

			<optgroup label="Service Intervention"> 
			<?php
				$array = ReturnService("intervention"); 
				$i = 0; 
				while ($i < count($array)){
				 	print("<option value = \"$array[$i]\">".$array[$i+1]."</option>"); 
				 	$i=$i+2;
				} 
			?>
			</optgroup>
		</select>
		<input type="submit" value="Valider">
	</form>
	
	</div>
</body>

<?php
	PrintFooter();
?>

</html>