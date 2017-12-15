<!DOCTYPE html> 
<html>  

	<p>Page réservée aux tests du site</p>

	<?php
	require("./fonctions.php");

	$_SESSION['uid'] = "test";
	
	#AddIntervention("INT001", "VE50A7", "PER005", "");

	#AddNumSecuInt("123456789101111", "VE50A7", "INT001")

	#$patient_array = array('name' => "prénomtest",
	#	'surname' => "nomtest", 
	#	'ssNumber' => '123456789012345', 
	#	'gender' => 'H', 
	#	'birthday' => '2000-01-01',
	#	'pathology' => 'rhume', 
	#	'emergencyLevel' => '6');

	#AddPatient($patient_array);

	#AddService("bla1","accueil", 4);

	#$user_array = array('name' => "prénomtest",
	#	'surname' => "nomtest", 
	#	'ssNumber' => '123456789012345', 
	#	'gender' => 'H', 
	#	'birthday' => '2000-01-01',
	#	'right' => '2',
	#	'Service' => 'INT001',
	#	'ID' => 'IDtest',
	#	'password' => 'PWtest');
	#AddUser($user_array);

	if (AllBooked("INT001")) {
		echo "Booked";
	}
	else {
		echo "NotBooked";
	}

	#$_SESSION['uid'] = "X"; 
	#$_SESSION['service'] = "INT004"; 
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
	#$array_vide = array('name' => "A",
	#	'surname' => "B", 
	#	'ssNumber' => 'x', 
	#	'gender' => 'F', 
	#	'birthday' => '2000-01-01',
	#	'pathology' => 'rhume', 
	#	'emergencyNumber' => '6');
	
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


	#UpdatePatient
	#try{
	#	UpdatePatient("x",$array_vide); 
	#}catch (Exception $e){
	#	echo $e -> getMessage(); 
	#}

	#try SearchFreeTime
	#$array = SearchFreeTime("INT004"); 
	#essai PrintFreeTime
	#$a = PrintFreeTime($array,"10");
	#print_r($a);
	#print_r(ReturnIntervention($a));

	#essai UpdatedUL
	#UpdatedUL("111023370509701",2);

	#Search Patient 
	#$array = array('name' => "",
	#	'surname' => "", 
	#	'ssNumber' => '269039584447537', 
	#	'gender' => '', 
	#	'birthday' => '',
	#	'pathology' => '', 
	#	'emergencyLevel' => '');
	#SearchPatient($array);
	
	#SearchIntervention 
	#$array = array('startingDate' => '2017/11/10', 'endingDate' => '', 'patientName' => "Nadeau");
	#SearchIntervention($array);

	#Delete intervention 
	#DeleteIntervention("A","B");

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
	#$arr = array('0' => 'JE50A6', '1' => "INT004");
	#print_r(ReturnIntervention($arr));
	#$chaine = "A B" ;
	#$pieces = explode(" ", $chaine);
	#print($pieces[0]); 
	#print($pieces[1]);

	#Test FactureIntervention 
	#$c = "MA46A9 D";
	#FactureIntervention($c);

	#if ("08:00:00" < "08:10:00"){
	#	print("ok");
	#}
	#print(date('W',strtotime("2018-01-01")));

	#changeWindow(30);
	#Test AddNumSecuInt
	#AddNumSecuInt('2288', 'JE50M9', 'INT001');
	?> 

</html>