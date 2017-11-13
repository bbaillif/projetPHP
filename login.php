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
		if(isset($_POST['username']) AND isset($_POST['password'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			#$idPersonnel = CheckID($username, $password);
			$idPersonnel = 17111995;
			#if($idPersonnel != 0) {
			if($username == 'username' AND $password == 'password') { 
			// A remplacer dès qu'on a CheckID
				$_SESSION['uid'] = $idPersonnel; 
				header('Location: ./index.php');
			}
			else {
				echo 'Identification incorrecte, veuillez réessayer';
			}
		}
		else {
			session_destroy();
		}
	?>

	<h1>Page d'identification à l'Intranet</h1>

	<form action="login.php" method="post">
		<input type="text" name="username" />
        <input type="password" name="password" />
        <input type="submit" value="Valider" />
    </form>

</body>

</html>