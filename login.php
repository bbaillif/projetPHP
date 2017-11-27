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
		# check if arrived here from logout
		if (isset($_GET['action'])) {
			if ($_GET['action'] == 'logout') {
				session_destroy();
				echo 'Deconnexion effectuée' . "\n";
			}
		}
		# check if arrived here by mistake (example : previous page)
		if (isset($_SESSION['uid']) AND isset($_SESSION['right'])) {
			header('Location: ./index.php');
		}
		# if Submit was clicked from this page :
		if (isset($_POST['username']) AND isset($_POST['password'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			#$userInfoArray = CheckID($username, $password);
			#if(isset($userInfoArray['error'])) {}
			#$userID = $userInfoArray['uid'];
			#$userRight = $userInfoArray['right'];
			$idPersonnel = 17111995;
			$right = 'doctor';
			#if($idPersonnel != 0) {
			if($username == 'username' AND $password == 'password') { 
			// TODO !!! A remplacer dès qu'on a CheckID
				$_SESSION['uid'] = $idPersonnel;
				$_SESSION['right'] = $right;
				header('Location: ./index.php');
			}
			else {
				echo 'Identification incorrecte, veuillez réessayer';
			}
		}
		else {
			print_r(InfoFieldPatient());
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