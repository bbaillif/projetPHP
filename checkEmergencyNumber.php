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
	<h1>Anomalies des numéros d'urgence par rapport aux pathologies</h1>

	<?php 
		PrintArchive("VerifNU.txt");
	?>
	</div>

<?php
	$_SESSION['action'] = '';
	PrintFooter();
?>
</body>
</html>