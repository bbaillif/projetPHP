<?php
	require("./fonctionsBen.php");
	require("./fonctionSo.php");
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
		if ($_SESSION['action'] == 'emergencyWithoutPatient') {
			Emergency();
		}
	?>

	<h1>Urgence prise en compte</h1>

	<?php
		$_SESSION['action'] = '';
		print_r($_SESSION);
		echo '<br>'. "\n";
		PrintFooter();
	?>

</body>

</html>