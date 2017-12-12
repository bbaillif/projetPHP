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
	<h1>Urgence prise en compte</h1>
	<?php
		if ($_SESSION['action'] == 'emergencyWithoutPatient') {
			Emergency("", $_SESSION['service']);
		}
		elseif ($_SESSION['action'] == 'emergencyWithExistingPatient'
			OR $_SESSION['action'] == 'emergencyWithNewPatient') {
			Emergency($_SESSION['patientID'], $_SESSION['service']);
		}
	?>

	</div>
</body>

<?php
	$_SESSION['action'] = '';
	PrintFooter();
?>

</html>

</html>