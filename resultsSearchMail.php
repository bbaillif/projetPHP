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
		PrintHeader();
	?>

	<h1>Annuaire électronique</h1>

	<?php
		$p = $_POST["nom"]; 
		$array = explode(" ", $p);
		SearchEmail($array[0], $array[1]);
	?>

	<br> <br>
	
	<?php
    	PrintFooter();
    ?>

</body>

</html>
