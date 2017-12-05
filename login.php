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

			#$_SESSION['uid'] = $username;

			# try to log : check password and username
			$userInfoArray = CheckID($username, $password);

			#If no error : user can access the website
			if ($userInfoArray['right'] != "" && $userInfoArray['ID'] != ""){
				$_SESSION['right'] = $userInfoArray['right'];
				$_SESSION['uid'] = $username;

				#Write in the user's file : 
				WriteUserLog("$date : connection \r\n");

				#Move onto next page
				header('Location: ./index.php');
			} 
			#If an error : user needs to try again
			else {
				echo 'Les informations saisies sont incorrectes. <br>Merci de bien vouloir réessayer.';
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