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
	<h1>Créer un utilisateur</h1>
		<?php
			echo '<form action="userCreated.php" method="post"></p>';
			echo '<p> Nom : <input type="text" name="surname"></p>';
			echo '<p> Prénom : <input type="text" name="name"></p>' ;
			echo "<p> Sexe <select name=\"gender\">
						<option value = \"\" selected hidden></option> 
						<option value=\"F\"> Femme </option> 
						<option value=\"H\"> Homme </option>
						</select> </p>"; 
			echo "<p> Numéro de sécurité sociale <input type=\"text\" name=\"ssNumber\" maxlength=\"15\"/> </p> ";
			echo "<p> Date de naissance <input type=\"date\" name=\"birthday\"/> </p>"; 
			echo "<p> Fonction <select name=\"right\">
						<option value = \"\" selected hidden></option> 
						<option value=\"1\"> Médecin </option> 
						<option value=\"2\"> Responsable </option>
						<option value=\"0\"> Administrateur </option>
						</select> </p>"; 
			echo '<p> Service : <select name = "Service">' . "\n";
			echo '<option value = \"\" selected hidden></option> ';
			echo '<optgroup label="Service Accueil">';  
			$array = ReturnService("accueil"); 
			$i = 0; 
			while ($i < count($array)){
			 	print("<option value = \"$array[$i]\">".$array[$i+1]."</option>"); 
			 	$i=$i+2;
			} 
			echo '</optgroup>'; 
			echo '<optgroup label="Service Intervention"> '; 
			$array = ReturnService("intervention"); 
			$i = 0; 
			while ($i < count($array)){
			 	print("<option value = \"$array[$i]\">".$array[$i+1]."</option>"); 
				$i=$i+2;
			};  
			echo '</optgroup></select></p>'; 
			echo '<p> Identifiant : <input type="text" name="ID"></p>';
			echo '<p> Mot-de-passe : <input type="password" name="password"></p>';
			echo '<input type="submit" value="Ajouter">' . "\n";
			echo '</form>' . "\n";
		?>
	</div>

	<?php
		PrintFooter();
	?>
</body>

</html>