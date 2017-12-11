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

	<form action="changeDay.php" method="post">
	<?php
		if ($_SESSION['action'] == 'changeDay') {
			if (!isset($_POST['dayToChange']) AND !isset($_POST['halfDay'])) {
				ChangeHalfDay($_SESSION['appointments'], $_POST);
				header('Location: ./dayChanged.php');
			}
			else {
			$dayToChange = $_POST['dayToChange'];
			$halfDay = $_POST['halfDay'];
			$_SESSION['appointments'] = SearchDay($dayToChange, $halfDay);

			foreach ($_SESSION['appointments'] as $line => $attributes_array) {
				foreach ($attributes_array as $attribute => $value) {
					echo $value . ' ';
				}
				echo '<select name="appointment' . $line . '">';
				OptionHours($dayToChange, $halfDay, $attributes_array['heure']);
				echo '</select>';
			}
			echo '<input type="submit" value="Valider les changements" /><br>' . "\n";
			echo '</form>';
		}
		}
		else {
			header('Location: ./index.php');
		}
	?>
	</div>

<?php
	PrintFooter();
?>

</body>

</html>