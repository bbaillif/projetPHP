<?php
	require("./fonctions.php");
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Intranet Hopital Polytech</title>
	<meta charset= "utf-8"><link rel = "stylesheet" href = "aesthetic.css" > 
</head>

<body>
	<div id = "header"> 
		<?php 
			CheckUID();
			PrintHeader();
		?>
	</div>

	<div id = "body">
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
	</div>
</body>

<?php
	PrintFooter();
?>

</html>