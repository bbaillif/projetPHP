<?php
	require("./fonctionsBen.php");
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
		print_r($_POST);
	?>

	<h1>Rédaction de fiche patient</h1>

	<form action="patient.php" method="post">
		Nom<input type="text" name="surname" /><br>
        Prénom<input type="text" name="name" /><br>
        Sexe<input type="text" name="gender" /><br>
        Numéro de sécurité sociale<input type="text" name="ssNumber" /><br>
        Date de naissance<input type="date" name="birthday" /><br>
        Pathologie<input type="text" name="pathologie" /><br>
        Niveau d'urgence<input type="number" name="emergencyLevel" min=1 max=10 /><br>
        <input type="submit" value="Valider" /><br>
    </form>

</body>

</html>