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
	<h1>Emergency done</h1>
	<?php
		if ($_SESSION['action'] == 'emergencyWithoutPatient') {
			Emergency("",$_SESSION['service']);
			echo "Urgence prise en compte";
		}
		elseif ($_SESSION['action'] == '') {
			# code...
		}
	?>

	</div>
</body>

<?php
	$_SESSION['action'] = '';
	PrintFooter();
?>

</html>

</html>