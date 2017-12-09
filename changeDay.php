<?php
	require("./fonctions.php");
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
	?>

	<h1>Demi-journée à modifier</h1>

	<form action="dayChanged.php" method="post">
	<?php
		if ($_SESSION['action'] == 'changeDay') {
			$interventions = SearchDay();
			#PrintResults();

			foreach ($interventions as $key => $value) {
				# Afficher créneaux 
				echo '<select name="'. $ . '">' . "\n";

				echo "</select>" . "\n";
			}

			echo '<input type="submit" value="Valider les changements" /><br>' . "\n";
		}
		else {
			header('Location: ./index.php');
		}
	?>

	<?php
		echo '<br>'. "\n";
		print_r($_SESSION);
		echo '<br>'. "\n";
		PrintFooter();
	?>

</body>

</html>