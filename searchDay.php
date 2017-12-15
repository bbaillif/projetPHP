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
		# if we come from searchDay.php 
		if ($_SESSION['action'] == 'changeDay') {
			echo '<h1>Recherche d\'une demi-journée à modifier</h1>' . "\n";
			echo '<form action="changeDay.php" method="post">'. "\n";
		}
		else {
			header('Location: ./index.php');
		}

		?>

		Jour <input type="date" name="dayToChange"/><br>
		Demi-journée <select name="halfDay">
		<option value="morning" selected="selected">Matin</option>
		<option value="afternoon">Après-midi</option>
	</select><br>

	<input type="submit" value="Valider" /><br>
</form>

</div>

<?php
PrintFooter();
?>

</body>

</html>