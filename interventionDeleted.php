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

	<h1>Intervention supprimée</h1>

	<?php
		$_SESSION['action'] = '';
		print_r($_SESSION);
		echo '<br>'. "\n";
		DeleteIntervention($_POST["value"]);
		echo '<br>'. "\n";
		PrintFooter();
	?>

</body>

</html>