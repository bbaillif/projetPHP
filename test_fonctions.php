<!DOCTYPE html> 
<html>  

	<p> OK </p>

	<?php
	require("C:/xampp/htdocs/Cours_PHP/projetPHP/fonctionSo.php"); 
	
	#Essai Add = ne marche pas 
	AddIntervention("A","B","C","D"); 

	#Essai Facturation #ça ne marche pas :
	$q = Query("SELECT ID_service_int, ID_creneau, ID_personnel, num_secu FROM planning WHERE ID_personnel=\"PER005\"");
	FactureIntervention($q);

	#Essai DeleteService
	#DeleteService("bla1");

	#Essai de print historique 
	#PrintArchive("service.txt"); 

	#Essai SearchEmail = OK
	#print(SearchEmail("Matin","Elisabeth"));

	#Test printresults = OK
	#$r = query("SELECT num_secu FROM patient"); 
	#printresults($r,"radio"); 

	#Essai des Write
	#WriteUserLog("ça écrit!"); 
	#WriteInterventionLog("ça écrit!","Operation"); 

	#Essai CHECKID 
	#try{
	#	print(CheckID("PER001", "mdp1"));
	#}catch(Exception $e){
	#	echo $e -> getMessage();
	#}

	#Essai AddService == OK
	#AddService("bla1","intervention");

	?> 

	<p> Coucou </p>

</html>