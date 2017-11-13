<?php
	require("./fonctions.php");
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
		if(isset($_POST['username']) AND isset($_POST['password'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			#if(CheckID($username, $password)) {
			if($username == 'OK') {
				header('Location: ./index.php');
			}
			else {
				echo 'identification incorrecte, veuillez réessayer';
			}
		}
	?>

	<h1>Page d'identification</h1>

	<form action="login.php" method="post">
		<input type="text" name="username" />
        <input type="password" name="password" />
        <input type="submit" value="Valider" />
    </form>

	<?php 
		PrintFooter();
	?>

</body>

</html>