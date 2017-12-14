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
			if (isset($_POST['appointment0'])){
				ChangeHalfDay($_SESSION['appointments'], $_POST);
				if(CheckSurbooking($_SESSION['service'])){
					if (AllBooked($_SESSION['service'])){
						header('Location: ./dayChanged.php');
						exit();
					}
					else {
						echo "Surbooking détecté, veuillez réaménager l'EDT";
						header('Location: ./changeDay.php');
						exit();
					}
				}
				else {
					header('Location: ./dayChanged.php');
					exit();
				}
			}
			else {
				$dayToChange = $_POST['dayToChange'];
				$halfDay = $_POST['halfDay'];
				$_SESSION['appointments'] = SearchDay($dayToChange, $halfDay);
				echo "<table>";
				echo "<tr>";
				echo "<th>Intervention</th>";
				echo "<th>Nom</th>";
				echo "<th>Prenom</th>";
				echo "<th>Numéro de sécurité sociale</th>";
				echo "<th>Mail du médecin</th>";
				echo "<th>Jour</th>";
				echo "<th>Ancien horaire</th>";
				echo "<th>Nouvel horaire</th>";
				echo "</tr>";

				if ($_SESSION['appointments'] != ""){
					foreach ($_SESSION['appointments'] as $line => $attributes_array) {
					echo "<tr>";
					foreach ($attributes_array as $attribute => $value) {
						echo '<td>' . $value . '</td>';
					}
					echo '<td><select name="appointment' . $line . '">';
					OptionHours($dayToChange, $halfDay, $attributes_array['heure']);
					echo '</select></td>';
					echo "</tr>";
					echo '<br>';
					}
					echo '<input type="submit" value="Valider les changements" /><br>' . "\n";
					echo '</form>';
				}
			}
		}
		elseif ($_SESSION['action'] == 'surbooking') {
			if (isset($_POST['appointment0'])){
				ChangeHalfDay($_SESSION['appointments'], $_POST);
				if(CheckSurbooking($_SESSION['service'])){
					if (AllBooked($_SESSION['service'])){
						header('Location: ./dayChanged.php');
						exit();
					}
					else {
						echo "Surbooking détecté, veuillez réaménager l'EDT";
						header('Location: ./changeDay.php');
						exit();
					}
				}
				else {
					header('Location: ./dayChanged.php');
					exit();
				}
			}
			$dayToChange = date("Y-m-d");
			if (date("H:i:s")>="13:00:00"){
				$halfDay="afternoon";
			} 
			else {
				$halfDay="morning";
			}
			$_SESSION['appointments'] = SearchDay($dayToChange, $halfDay);

			echo "<table>";
			echo "<th>Intervention</th>";
			echo "<th>Nom</th>";
			echo "<th>Prenom</th>";
			echo "<th>Numéro de sécurité sociale</th>";
			echo "<th>Mail du médecin</th>";
			echo "<th>Jour</th>";
			echo "<th>Ancien horaire</th>";
			echo "<th>Nouvel horaire</th>";
			echo "</tr>";

			if ($_SESSION['appointments'] != ""){
				foreach ($_SESSION['appointments'] as $line => $attributes_array) {
					echo "<tr>";
					foreach ($attributes_array as $attribute => $value) {
						echo '<td>' . $value . '</td>';
					}
					echo '<td><select name="appointment' . $line . '">';
					OptionHours($dayToChange, $halfDay, $attributes_array['heure']);
					echo '</select></td>';
					echo "</tr>";
					echo '<br>';
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