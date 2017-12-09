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

	<h1>Résultat de la recherche de personnel</h1>

	<?php
		if ($_SESSION['action'] == 'searchMail') {
			$p = $_POST["nom"];
			$array = explode(" ", $p);
			SearchEmail($array[0], $array[1]);
		}
		elseif ($_SESSION['action'] == 'seeLogs') {
			SearchUser();
			echo '<form action="logUser.php" method="post">' . "\n";
			# Faire une liste pour choisir un User
			# PrintUser();
			echo '<input type="submit" value = "Choisir utilisateur">' . "\n";
		}
	?>

	<form action="logUser.php" method="post">
		
	</form>

	<br> <br>
	
	<?php
    	PrintFooter();
    ?>

</body>

</html>
