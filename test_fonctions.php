<!DOCTYPE html> 
<html>  

	<p> OK </p>

	<?php
	require("C:/xampp/htdocs/Cours_PHP/projetPHP/fonctionSo.php"); 
	$requete = "SELECT nom FROM personne"; 
	$sql = Query($requete); 
	PrintResults($sql,"radio");

	AddService("blabla","intervention"); 

	?> 

	<p> Coucou </p>

</html>