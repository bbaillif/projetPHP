<!DOCTYPE html> 
<html>  

	<p> OK </p>

	<?php
	require("C:/xampp/htdocs/Cours_PHP/projetPHP/fonctions.php"); 
	
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
	#DeletePatient("170125410485276");

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
	$array_vide = array('name' => "A",
		'surname' => "B", 
		'ssNumber' => 'x', 
		'gender' => 'F', 
		'birthday' => '2000-01-01',
		'pathology' => 'rhume', 
		'emergencyNumber' => '6');
	#try{
	#	$r = CheckPatient($array_vide); 
	#}catch(Exception $e){
	#	echo $e -> getMessage();
	#}
	#if ($r == True){
	#	print("ça marche");
	#}else{
#		print("nop");
	#}


	#Essai AddPatient 
	#try{
	#	AddPatient($array_vide);
	#} catch (Exception $e){
	#	echo $e -> getMessage();	
	#}

	#UpdatePatient
	#try{
	#	UpdatePatient("x",$array_vide); 
	#}catch (Exception $e){
	#	echo $e -> getMessage(); 
	#}

	#try SearchFreeTime
	#$array = SearchFreeTime("INT004"); 
	#essai PrintFreeTime
	#PrintFreeTime($array,"10");

	#essai UpdatedUL
	#print(UpdatedUL("111023370509701","4"));

	#Search Patient 
	#$array = array('name' => "",
	#	'surname' => "", 
	#	'ssNumber' => '269039584447537', 
	#	'gender' => '', 
	#	'birthday' => '',
	#	'pathology' => '', 
	#	'emergencyNumber' => '');
	#SearchPatient($array);

	#SearchIntervention 
	#$array = array('startingDate' => '2017/11/10', 'endingDate' => '', 'patientName' => "Nadeau");
	#SearchIntervention($array);

	#Delete intervention 
	#DeleteIntervention("A","B");

	#Essai de Update intervention
	#$array1 = array('hour' => "09:00:00", 'service_int' => "INT004" , 'ssNumber' => "111023370509701", 'day'=>"2017/11/13");
	#$array2 = array('hour' => "17:00:00", 'service_int' => "INT004" , 'ssNumber' => "111023370509701", 'day'=>"2017/11/13");
	#UpdateIntervention($array1,$array2);

	#CheckSurbooking("INT004");

	#$old = array(array('day'=>"1",'service_int'=>2,'ssNumber'=>3),array('day'=>"3",'service_int'=>5,'ssNumber'=>7));
	#$new = array(array('day'=>"2",'service_int'=>2,'ssNumber'=>2),array('day'=>"3",'service_int'=>5,'ssNumber'=>7));
	#UpdateDay($old,$new);

	#Test ReturnMail 
	#ReturnName();

	#Test SearchInterventionF
	#$array = array('startingDate' => '2017-11-10', 'endingDate' => '', 'patientName' => "");
	#$res = SearchInterventionF($array); 
	#print(WhichService("PER001")); 

	#print_r(ReturnIntervention($res));
	$chaine = "A B" ;
	$pieces = explode(" ", $chaine);
	print($pieces[0]); 
	print($pieces[1]);
	?> 

	<p> Coucou </p>

</html>