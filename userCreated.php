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
	<h1>Utilisateur créé</h1>

	<?php 
		print_r($_POST);
		if (emptyValue($_POST)){
			header('Location: ./addUser.php');
		}
		else {
			AddUser($_POST); 
		}
	?>
	</div>

<?php
	$_SESSION['action'] = '';
	PrintFooter();
?>

</body>

</html>