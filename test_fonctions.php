<!DOCTYPE html> 
<html>  

	<p> OK </p>

	<?php
	require("C:/xampp/htdocs/Cours_PHP/projetPHP/fonctionSo.php"); 
	
	$_SESSION['uid'] = "X"; 
	#Essai WriteUserLog 
	#WriteUserLog("ça écrit!!");
	#WriteInterventionLog("ça écrit!","Operation"); 
	
	#Essai CHECKID 
	#try{
	#	print(CheckID("PER001", "md1"));
	#}catch(Exception $e){
	#	echo $e -> getMessage();
	#}

	#Essai Delete Patient
	#DeletePatient("x");

	#Essai DeleteService
	#DeleteService("blabla");

	#Essai AddService == OK
	#AddService("bla1","intervention");

	#Essai Facturation #ça ne marche pas :
	#FactureIntervention("INT004","LU46M3","111023370509701");

	#Essai Add = ne marche pas 
	#AddIntervention("A","B","C","D"); 

	#Essai de print historique 
	#PrintArchive("service.txt"); 

	#Essai SearchEmail = OK
	#print(SearchEmail("Matin","Elisabeth"));

	#Test printresults = OK
	#$r = query("SELECT num_secu FROM patient"); 
	#printresults($r,"radio"); 

	#Essai de SearchDay 
	#SearchDay("2017-11-15","apres-midi");

	#Essai Emergency 
	#Emergency("num secu","INT004");

	#Essai de CheckID 
	$array_vide = array('name' => "X",
		'surname' => "Y", 
		'ssNumber' => '170125410485276', 
		'gender' => 'F', 
		'birthday' => '2017-03-06',
		 'pathology' => 'rhume', 
		 'emergencyNumber' => '3');
	try{
		CheckPatient($array_vide); 
	}catch(Exception $e){
		echo $e -> getMessage();
	}

	#Essai AddPatient 
	AddPatient($array_vide);



	?> 

	<p> Coucou </p>

</html>