<?php

mysqli_report(MYSQLI_REPORT_STRICT);

#Query($query) : Execute la requête ; renvoie une erreur si ça ne marche pas
function Query($query) {
		#Déclaration des erreurs
	$error1 = "<p>ERROR.1: Impossible de se connecter à la base de données. Merci de contacter le service technique. </p>";
	$error2 = "<p>Aucun résultat ne correspond à votre recherche. </p>";
	$error3 = "<p>ERROR.2: Impossible d'executer la requête. Merci de contacter le service technique. </p>";
		#Déclaration des variables de la base de données 
		$user = 'Lea';#'Lea'
		$pwd = "BDE20162017";#'1711alphaben1995';'BDE20162017';
		$bdd = 'projetPHP';#'hopital';

		#On essaye de se connecter à la base de données
	$r=mysqli_connect('localhost',$user,$pwd,$bdd);
		#Si erreur de connection
	if (mysqli_connect_errno()){  
		throw new Exception($error1); 
	}

		#On essaye d'executer la requête
	$t=mysqli_query($r,$query);
		#Si la requête ne renvoie pas un booléen
	if (gettype($t) != "boolean"){
			#Si erreur dans l'execution de la requête car ne renvoie rien
		$rowcount = mysqli_num_rows($t);
		if ($rowcount == 0){ 
			throw new Exception($error2); 
		}
	} 
		#Si la requête (comme UPDATE, INSERT...) renvoie un booléen
	else {
			#Si les query du type INSERT, UPDATE, ne marchent pas
		if ($t == False){
			throw new Exception($error3); 
		}
	}

		#On ferme la base de données
	mysqli_close($r);
		#On renvoie le résultat
	return ($t);
}

#WriteUserLog($chaine)= Ecrit dans un fichier au nom de l'utilisateur
function WriteUserLog($chaine) {
		#On récupère l'ID de l'utilisateur 
	$user = $_SESSION['uid']; 
		#On ouvre le fichier ; Si pas créé, on le crée
	if ($f = fopen("$user.txt", "a")){
			#On écrit la chaine
		fwrite($f, $chaine); 
			#On ferme le fichier
		fclose($f); 
	}
} 

#WriteInterventionLog($chaine)= Ecrit dans un fichier selon le service intervention
function WriteInterventionLog($chaine, $service) {
		#On ouvre le fichier ; Si pas créé, on le crée
	if ($f = fopen("$service.txt", "a")){
			#On écrit la chaine
		fwrite($f, $chaine); 
			#On ferme le fichier
		fclose($f); 
	}
}

#CheckID($ID, $mdp)= Vérifie - avant connexion - que l'utilisateur est dans la bdd
function CheckID($ID, $mdp) {
	try {
		$r1 = "SELECT ID_personnel, MDP FROM personnel"; 
		$q1 = Query($r1);
		$array = []; 			
		while ($nuplet = mysqli_fetch_array($q1)) {
			array_push($array, $nuplet[0],$nuplet[1]);
		}
			#On cherche si notre couple est dans la bdd
		$i = 0 ; 
		while ($i < count($array)) {
			if ($array[$i]==$ID && $array[$i+1]==$mdp){
					#Notre couple (ID, mdp) est dans la base de données
					#On récupère et retourne ses droits
				$r2 = "SELECT droit FROM personnel WHERE ID_personnel=\"".$ID."\"" ; 
				$q2 = Query($r2); 
				$row = mysqli_fetch_array($q2); 

					#On retourne son droit
				$array_return= array('ID' => $ID, 'right' => $row[0]); 
				return($array_return);
			}
				#Sinon, on continue 
			$i = $i + 2;
		}
			#Si le couple(ID,mdp) n'est pas dans la base de données
		$array_return= array('ID' => '', 'right'=>''); 
		return($array_return);
	}catch(Exception $e){
			#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}    

#DeletePatient($numSecu)= On supprime un patient selon son N° SECU 
function DeletePatient($numSecu) {
		#Déclaration des variables 
	$date = date("d/m/Y H:i");

	try{
			#On essaye de supprimer le patient
		$r="DELETE from patient WHERE num_secu=\"$numSecu\"";
		$q=Query($r);

			#On écrit dans le fichier de l'utilisateur
		WriteUserLog("$date : suppression du patient ($numSecu) \r\n");
	}catch (Exception $e){
			#Si il y a une erreur de query
		echo $e -> getMessage();
	}
}

#DeleteService($nom_service, $type): On supprime le service donnée en entrée 
function DeleteService($ID_service,$type) {
		#Déclaration variables
	$date = date("d/m/Y H:i");

	try{
		if ($type == "service"){
				#On supprime le service de la BDD
			$r="DELETE from service_intervention WHERE ID_service_int=\"$ID_service\"";
			$q=Query($r);

				#On écrit dans le fichier de l'utilisateur
			WriteUserLog("$date : suppression du service d'intervention $ID_service \r\n"); 

				#On écrit dans le fichier service
			WriteInterventionLog("$date : suppression du service d'intervention $ID_service \r\n", $ID_service); 
		}

		elseif ($type == "accueil") {
				#On supprime le service de la BDD
			$r="DELETE from service_accueil WHERE ID_service_acc =\"$ID_service\"";
			$q=Query($r);

				#On écrit dans le fichier de l'utilisateur
			WriteUserLog("$date : suppression du service d'accueil $ID_service \r\n"); 

				#On écrit dans le fichier service
			WriteInterventionLog("$date : suppression du service d'accueil $ID_service \r\n", $ID_service); 
		}
	}catch (Exception $e){
			#Si il y a une erreur de query
		echo $e -> getMessage();
	}
}

#AddIntervention(...)= On ajoute l'intervention selon les données en entrée
function AddIntervention($serviceI, $creneau, $Idpers, $numSecu) {
		#Déclaration des variables 
	$date = date("d/m/Y H:i");

	try{
			#On essaye d'ajouter une ligne à la table planning 
		$r="INSERT INTO planning VALUES (\"$serviceI\", \"$creneau\", \"$Idpers\", \"$numSecu\" ,0)";
		$q=Query($r); 

			#On écrit dans le fichier de l'utilisateur
		WriteUserLog("$date : ajout de l'intervention $serviceI pour le patient $numSecu au créneau $creneau \r\n"); 

			#On écrit dans le fichier service
		WriteInterventionLog("$date : ajout de l'intervention $creneau pour le patient $numSecu \r\n", $serviceI); 

	}catch (Exception $e){
			#Si il y a une erreur de query
		echo $e -> getMessage();
	}
}

#AddService(...)= Ajout d'un service dans la base de données
function AddService($nomService,$type) {
		#Déclaration des variables 
	$date = date("d/m/Y H:i");

		#On veut ajouter un service d'intervention 
	if ($type=="intervention")
	{
		try{
				#On récupère les ID des services d'intervention
			$r1 = "SELECT ID_service_int FROM service_intervention";
			$q1 = Query($r1);
			$array = [];
			while ($nuplet = mysqli_fetch_array($q1)) {
				array_push($array, substr($nuplet[0], -3));
			}

				#On récupère le numéro maximum
			$n = max($array);
				#On veut le chiffre après le maximum 
			$n = $n + 1; 
			$n = (string)$n;

				#On créé ID service 
			if (strlen($n) == 1) {
				$IDservice = "INT00".$n;
			}elseif (strlen($n) == 2) {
				$IDservice = "INT0".$n;
			}elseif (strlen($n) == 3) {
				$IDservice = "INT".$n;
			}

				#Ajout dans la base de données
			$r2 = "INSERT INTO service_intervention VALUES (\"".$IDservice."\",\"".$nomService."\")";
			$q2 = Query($r2);

				#On écrit dans le fichier de l'utilisateur
			WriteUserLog("$date : création du service $nomService \r\n"); 

				#On écrit dans le fichier service
			WriteInterventionLog("$date : création du service $nomService \r\n", $IDservice); 

		}catch (Exception $e){
				#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

		#On veut ajouter un service d'accueil 
	elseif ($type == "accueil") {
			#On récupère les ID des services d'accueil
		try{
			$r1 = "SELECT ID_service_acc FROM service_accueil";
			$q1 = Query($r1);
			$array = [];
			while ($nuplet = mysqli_fetch_array($q1)) {
				array_push($array, substr($nuplet[0], -3));
			}

				#On récupère le numéro maximum
			$n = max($array);
				#On veut le chiffre après le maximum
			$n = $n + 1;
			$n = (string)$n;

				#On créé ID service 
			if (strlen($n) == 1) {
				$IDservice = "ACC00".$n;
			}elseif (strlen($n) == 2) {
				$IDservice = "ACC0".$n;
			}elseif (strlen($n) == 3) {
				$IDservice = "ACC".$n;
			}

				#Ajout dans la base de données
			$r2 = "INSERT INTO service_accueil VALUES (\"".$IDservice."\",\"".$nomService."\")";
			$q2 = Query($r2);

				#On écrit dans le fichier de l'utilisateur
			WriteUserLog("$date : création du service $nomService \r\n"); 

				#On écrit dans le fichier service
			WriteInterventionLog("$date : création du service $nomService \r\n", $IDservice); 

		}catch (Exception $e){
				#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}
}

#SearchEmail($nom,$prenom)= Cherche l'email d'un mbre du personnel
function SearchEmail($ID) {
	try {
			#On essaye d'effectuer la requête
		$r = "SELECT mail FROM personnel NATURAL JOIN personne WHERE ID_personnel=\"$ID\"";
		$q = Query($r); 

			#On lit le résultat de la requête
		$array = [];
		while ($nuplet = mysqli_fetch_array($q)) {
			array_push($array, $nuplet[0]);
		}

			#On print l'email 
		print($array[0]);

	} catch (Exception $e){
			#Si il y a une erreur de query
		echo $e -> getMessage();
	}
}

#PrintArchive($fichier)= permet l'affichage de l'historique d'un service ou d'un membre du personnel 
function PrintArchive($fichier) {
		#On regarde si le fichier existe
	if (!file_exists($fichier)){
		print("Pas d'historique disponible <br> \n"); 
	}

		#Si le fichier existe : 
	else {
			#On ouvre le fichier
		$f = fopen($fichier, "r"); 

			#On lit la première ligne
		$l = fgets($f); 
		print('<ul>'); 

			#Jusqu'à ce que les lignes soient vides = fin fichier
		while (!empty($l)) {
				#On affiche
			print(" <li>".$l."</li>"."\n"); 
			$l = fgets($f);
		}
		print("</ul>\n");

			#On ferme le fichier
		fclose($f);
	}
}

#FactureIntervention(...)= On met l'intervention comme facturé (passe de 0 à 1)
function FactureIntervention($chaine) {
		#Déclaration des variables 
	$date = date("d/m/Y H:i");

	try{
			#On découpe la chaine
		$pieces = explode(" ", $chaine);
		$creneau = $pieces[0]; 
		$secu = $pieces[1];

			#On essaye de changer de non-facturé à facturé
		$r = "UPDATE planning SET facture = 1 WHERE ID_service_int = \"".$_SESSION['service']."\" AND ID_creneau = \"$creneau \" AND num_secu=\"$secu\""; 
		$q = Query($r);

			#On écrit dans le fichier de l'utilisateur
		WriteUserLog("$date : facturation  de l'intervention $creneau du patient $secu \r\n"); 

			#On écrit dans le fichier service
		WriteInterventionLog("$date : facturation  de l'intervention $creneau du patient $secu \r\n", $_SESSION['service']); 

	} catch (Exception $e){
			#Si il y a une erreur de query
		echo $e -> getMessage();
	}
}

#SearchDay(...)= On récupère les interventions selon la demi-journée
function SearchDay($date,$halfDay) {
	try{
		$attributes = array('ID_service_int', 'mail', 'nom', 'prenom', 'planning.num_secu', 'jour', 'heure');
		#Attributes must be in comprehensive order to print further
		$query = 'SELECT ';

		foreach ($attributes as $key => $attribute) {
			#Comma between each attribute, except the first one
			if ($key != 0) {
				$query = $query . ", ";
			}
			$query = $query . $attribute;
		}

		$query = $query . ' FROM (creneau NATURAL JOIN planning NATURAL JOIN personne) JOIN personnel ON personnel.ID_personnel = planning.ID_personnel WHERE jour = "' . $date . '" AND heure BETWEEN ';

		if ($halfDay == "morning"){
			$query = $query . '"08:30:00" AND "12:00:00"';
		} 
		elseif ($halfDay == "afternoon") {
			$query = $query . '"13:30:00" AND "17:30:00"';
		}

			$results = Query($query);

			$appointmentsArray = [];
		$line = 0;
		while ($nuplet = mysqli_fetch_array($results)) {
			$appointmentsArray[$line] = [];
			foreach ($attributes as $key => $attribute) {
				$appointmentsArray[$line][$attribute] = $nuplet[$key];
			}
			$line = $line + 1;
		}

		return($appointmentsArray);
	} catch (Exception $e){
		echo $e -> getMessage();
	}
}

#Emergency($numSecu, $service)= Quand on a une urgence, on prend le premier créneau libre ou non
function Emergency($numSecu, $service) {
		#Déclaration de variables 
	$jour = date("Y-m-d");
	$heure = date("H:i:s"); 
	$date = date("d/m/Y H:i");

	try{
			#On sélectionne les créneaux du jour après l'heure 
		$r="SELECT ID_creneau FROM creneau WHERE jour = \"$jour\" AND heure > \"$heure\"" ;
		$q = Query($r);

		$row = mysqli_fetch_array($q); 

		AddIntervention($service, $row[0], $_SESSION['uid'], $numSecu); 

		WriteUserLog("$date : ajout de l'urgence du patient $numSecu pour intervention dans $service au créneau $row[0] \r\n"); 

		WriteInterventionLog("$date : ajout de l'urgence $row[0] pour le patient $numSecu \r\n", $service); 

	} catch (Exception $e){
				#Si il y a une erreur de query
		echo "L'urgence n'a pas été ajouté. Veuillez vérifier qu’il n’est pas trop tôt ou trop tard dans la journée ou contacter le service technique.";
	}
}

#PatientUnknown($patient_array)= on vérifie si le patient n'existe pas déjà 
function PatientUnknown($patient_array) {
	try{
		$secu = $patient_array['ssNumber']; 

			#Vérifie que le patient est pas dans la BDD
		$r1 = "SELECT num_secu FROM patient" ; 
		$q1 = Query($r1); 
		$array = []; 
		while ($nuplet = mysqli_fetch_array($q1)){
			array_push($array, $nuplet[0]);
		}

		if (in_array("$secu",$array)){
			return(False);
		}
			#Le patient n'existe pas
		return(True); 

	}catch (Exception $e){
			#Si il y a une erreur de query
		echo $e -> getMessage();
	}
}

#CheckNU($patient_array)= On écrit dans un fichier quand on a un NU anormal (supérieur à ce qui a été prévu)
function CheckNU($patient_array) {
		#Declaration des variables
	$date = date("d/m/Y H:i");

	try{
		$secu = $patient_array['ssNumber']; 
		$patho = $patient_array['pathology'];
		$NU = $patient_array['emergencyLevel']; 	

			#On récupère le niveau urgence par défaut de la pathologie
		$r2 = "SELECT NU_defaut FROM pathologie WHERE pathologie = \"$patho\"";
		$q2 = Query($r2);

			#Verifie que le niveau d'urgence est compatible avec la pathologie 
		$row = mysqli_fetch_array($q2); 
		if ($row[0] != $NU ){
			if ($f = fopen("VerifNU.txt", "a")){
					#On écrit la chaine suivante
				fwrite($f, "$date : $secu a un $patho avec NU=$NU\r\n"); 
					#On ferme le fichier
				fclose($f); 
			}
		}
	}catch (Exception $e){
			#Si il y a une erreur de query
		echo $e -> getMessage();
	}
}

#AddPatient(...)= Ajout d'un patient dans la base de données
function AddPatient ($patient_array) {
		#Déclaration des variables 
	$date = date("d/m/Y H:i");

	try{
			#Ajout dans la table Personne	
		$secu = $patient_array['ssNumber']; 
		$nom = $patient_array['surname'] ;
		$prenom = $patient_array['name']; 
		$sexe = $patient_array['gender']; 
		$date_naiss = $patient_array['birthday']; 

		$r_personne = "INSERT INTO personne VALUES (\"$secu\",\"$nom\",\"$prenom\",\"$sexe\",\"$date_naiss\")" ; 
		$q_personne = query($r_personne); 

			#Ajout dans la table Patient 
		$patho = $patient_array['pathology'];
		$NU = $patient_array['emergencyLevel']; 
		$r_patient = "INSERT INTO patient VALUES (\"$secu\",\"$patho\", \"$NU\")"; 
		$q_patient = query($r_patient); 

			#Check du numéro d'urgence 
		CheckNU($patient_array); 

		WriteUserLog("$date : ajout du patient $secu \r\n");
	} catch (Exception $e){
			#Si il y a une erreur de query ou de PatientUnknown
		echo $e -> getMessage();
	}
}

#UpdatedUL($secu, $NU)= met à jour le niveau d'urgence selon le temps avant l'intervention 
function UpdatedUL($secu, $NU) {		
	try {
			#Query pour connaître la durée jusqu'à la prochaine intervention concernant le numéro de sécu dans la table Planning.  
		$r = "SELECT DATEDIFF(CURRENT_DATE(),jour) FROM planning NATURAL JOIN creneau WHERE num_secu = \"$secu\" ORDER BY jour, heure";
		$q = Query($r); 
		$row = mysqli_fetch_array($q); 
		$duree = $row[0]; 

			#MAJ du niveau d'urgence
		$update = $duree/10; 
		$new_NU = $NU + $update; 
		$new_NU = round($new_NU); #On arrondit
		if ($new_NU > 10){
			$new_NU =10; #=10 si supérieur à 10, car 10 = le max
		}

		return($new_NU); 
	} catch (Exception $e) {
			#Si il y a une erreur de query
		echo $e -> getMessage();
	}
}

function UpdatePatient ($patient_array) {
		#Déclaration des variables 
	$date = date("d/m/Y H:i");
	$secu = $patient_array['ssNumber'];

	try{
			#Vérifie que le patient existe
		if (PatientUnknown($patient_array)) {
			throw new Exception("Le patient n'existe pas");
		}

			#Update de la table patient 
		$patho = $patient_array['pathology'];
		$NU = $patient_array['emergencyLevel']; 
		$r_patient = "UPDATE patient SET pathologie = \"$patho\", NU = \"$NU\" WHERE num_secu = \"$secu\"";
		$_SESSION['r_patient'] = $r_patient;
		$q_patient = Query($r_patient); 

			#Check son NU 
		CheckNU($patient_array);

			#On écrit dans le fichier du personnel qui a modifié 
		WriteUserLog("$date : update du patient $secu \r\n");
	} catch (Exception $e){
			#Si il y a une erreur de query ou de PatientUnknown
		echo $e -> getMessage();
	}
}

#SearchFreeTime($service_int)= retourne tous les créneaux libres
function SearchFreeTime($Service_int) {
	try{
		#On compte les créneaux dans planning 
		$r1 = "SELECT ID_creneau, COUNT(ID_creneau) FROM creneau WHERE ID_creneau IN (SELECT ID_creneau FROM planning WHERE ID_service_int = \"$Service_int\") GROUP BY ID_creneau"; 
		$q1 = Query($r1); 
		$array1=[];
		while ($nuplet = mysqli_fetch_array($q1)) {
			array_push($array1, $nuplet[0],$nuplet[1]);
		}

		$r2 = "SELECT nb_creneaux FROM service_intervention WHERE ID_service_int = \"$Service_int\"";
		$q2 = Query($r2); 
		$nb_creneaux = mysqli_fetch_array($q2)[0];

		$i=0; $notFree = "("; 
		while ($i < count($array1)) {
			if ($array1[$i+1] >= $nb_creneaux){
				$notFree = $notFree."\"".$array1[$i]."\","; 
			} 
			$i = $i +2; 
		}
		$notFree = $notFree."\"\")";

		#Recherche tous les IDcreneaux qui ne sont pas plein pour un service d'intervention donné
		#Ils sont classés par ordre chronologique grâce à ORDER BY 
		$r3 = "SELECT ID_creneau FROM creneau WHERE ID_creneau NOT IN $notFree AND jour > CURRENT_DATE() ORDER BY jour, heure" ; ; 
		$q3 = Query($r3);
		$array = []; 			
		while ($nuplet = mysqli_fetch_array($q3)) {
			array_push($array, $nuplet[0], $Service_int);
		}
		return($array); 
	}catch (Exception $e){
			#Si il y a une erreur de query 
		echo $e -> getMessage();
	}
}

#PrintFreeTime(...)= affiche seulement 5 créneaux libres selon le NU 
function PrintFreeTime ($array, $NU) {	
		#On veut que le Num urgence soit un chiffre
	$NU =(int) $NU; 
		#On divise le tableau des créneaux tous les 5 créneaux
	$new = array_chunk($array, 10); 
		#Le max du numéro d'urgence = 10, on calcule quel tableau divisé on veut
	$n= (10 - $NU) * 2;  
		#On créé un nouveau tableau avec les 5 créneaux selon le numéro d'urgence
	$array_creneau = $new[$n]; 
		#On affiche le résultat
	$result = ReturnIntervention($array_creneau); 
	print_r($result);
	$i = 0;
			#On affiche toutes les données du tableau
		while($i < count($result))
		{
			echo("<input type=\"radio\" name=\"value\" value=\"".$result[$i+1]."\" id =\"case\"> ");
			echo("<label for= \"case\"> ".$result[$i]."\n</label><br><br>");
			$i=$i+2;
		}
	#return($array_creneau);
}

#SearchPatient($array)= Recherche un patient selon les infos données en entrée 
function SearchPatient($array) {
	try{
			#Déclaration de deux tableaux (avec nom colonnes SQL et infos du tableau en entrée pour remettre dans l'ordre)
		$arraySQL = array('num_secu', 'nom', 'prenom', 'sexe', 'date_naiss', 'pathologie', 'NU'); 
		$array_patient = array($array['ssNumber'], $array['surname'], $array['name'], $array['gender'], $array['birthday'], $array['pathology'], $array['emergencyLevel']);

			#création du début de la requête
		$r = "SELECT * FROM patient NATURAL JOIN personne WHERE "; 

			#On récupère les infos non-vides
		$i = 0; 
		while ($i < count($arraySQL)) {
			if (!empty($array_patient[$i])){
				$new_arraySQL[] = $arraySQL[$i]; 
				$new_array_patient[] = $array_patient[$i];
			}
			$i+=1; 
		}

			#ajout du premier élément sans 'AND'
		$r = $r.$new_arraySQL[0]." = \"".$new_array_patient[0]."\""; 

			#Ajout de toutes les autres infos dans la requête
		$j = 1;
		while ($j < count($new_array_patient)) {
			$r = $r." AND ".$new_arraySQL[$j]." = \"".$new_array_patient[$j]."\""; 
			$j = $j +1; 
		}

			#On considère qu'il y a eu moins une info dans $array
			#On recherche les infos patients 
		$q = Query($r);
		$result = []; 			
		while ($nuplet = mysqli_fetch_array($q)) {
			$tableau=[];
			$tableau['surname']=$nuplet[3];
			$tableau['name']=$nuplet[4];
			$tableau['ssNumber']=$nuplet[0];
			$tableau['gender']=$nuplet[5];
			$tableau['birthday']=$nuplet[6];
			$tableau['pathology']=$nuplet[1];
			$tableau['emergencyLevel']=$nuplet[2];
			array_push($result, $tableau);
		}
		return($result);

	}catch (Exception $e){
			#Si il y a une erreur de query 
		echo $e -> getMessage();
	}
}

#SearchIntervention(...)= On recherche les interventions selon les infos données en entrée 
function SearchIntervention($info_inter, $facturation, $inter_service, $personnel_ID) {
	$r1 = ""; 
	$r2 = "";
	try{
		
		$attributes = array('ID_creneau', 'ID_service_int', 'ID_personnel', 'num_secu', 'facture');
		$r = 'SELECT DISTINCT ';
		foreach ($attributes as $key => $attribute) {
			if ($key != 0) {
				$r = $r . ', ';
			}
			$r = $r . $attribute;
		}
		$r = $r . ' FROM planning NATURAL JOIN creneau NATURAL JOIN personne WHERE ';

		if ($inter_service != "") {
			$r = $r . 'ID_service_int = "' . $inter_service . '" AND ';
		}

		if ($personnel_ID != "") {
			$r = $r . 'ID_personnel = "' . $personnel_ID . '" AND ';
		}

		if (!empty($info_inter['ssNumber'])) {
			$r = $r . 'num_secu = "' . $info_inter['ssNumber'] . '" AND ';
		}

		if ($_SESSION['action']=='patientEmergency'){
			$r = $r . 'num_secu = "' . "". '" AND ';
		}

			#Si on a une date de début
		if (!empty($info_inter['startingDate'])) {
				#Si on a une date de fin 
			if (!empty($info_inter['endingDate'])){
				$r2 = " jour BETWEEN \"".$info_inter['startingDate']."\"AND \"".$info_inter['endingDate']."\"";
			}
				#Si on a pas de date de fin 
			else {
				$r2 = " jour > \"".$info_inter['startingDate']."\"";
			}
		}

		elseif (empty($info_inter['startingDate'])) {
			if (!empty($info_inter['endingDate'])) {
				$r2 = " jour BETWEEN CURRENT_DATE() AND \"".$info_inter['endingDate']."\"";
			}
			else {
				#Do Nothing
			}
		}

			#concatenate
		if ($r1 != ""){
			if ($r2 != ""){
				$r = $r . $r1 . " AND " . $r2 ; 
			} 
			else {
				$r = $r . $r1; 
			}
		} 
		else {
			if($r2 != ""){
				$r = $r . $r2;
			}
			else {
				if ($facturation == "NF" OR $facturation == "F") {
					$r = $r . "jour <= CURRENT_DATE()";
				}
				else {
					$r = $r . "jour >= CURRENT_DATE()";
				}
			}
		}

		if ($facturation == "F") {
			$r = $r . ' AND facture = 1';
		}
		elseif ($facturation == "NF") {
			$r = $r . ' AND facture = 0';
		}
		else {
			# no more conditions
		}

		$_SESSION['query'] = $r;
		$q = Query($r);

		$result = [];
		$line = 0;
		while ($nuplet = mysqli_fetch_array($q)) {
			$result[$line] = [];
			foreach ($attributes as $key => $attribute) {
				$result[$line][$attribute] = $nuplet[$key];
			}
			$line = $line + 1;
		}
		return($result);

	}catch (Exception $e){
		echo $e -> getMessage();
	}
}

#DeleteIntervention(...)= On supprime une intervention
function DeleteIntervention($chaine) {
		#Déclaration des variables 
	$date = date("d/m/Y H:i");

	try {
			#On découpe la chaine
		$pieces = explode(" ", $chaine);
		$ID_service = $pieces[1]; 
		$ID_creneau = $pieces[0];

			#On essaye de supprimer l'intervention 
		$r="DELETE from planning WHERE ID_service_int=\"$ID_service\" AND ID_creneau = \"$ID_creneau\"";
		$q=Query($r);

			#On écrit dans le fichier de l'utilisateur
		WriteUserLog("$date : Suppression de l'intervention du service $ID_service pour $ID_creneau \r\n");
			#On écrit dans le fichier du service concerné
		WriteInterventionLog("$date : Suppression de l'intervention du creneau $ID_creneau \r\n", $ID_service);

	} catch (Exception $e) {
			#Si il y a une erreur de query 
		echo $e -> getMessage();
	}
}

#UpdateIntervention(...)= On met à jour une intervention (notamment son heure)
function UpdateIntervention($old_array, $new_array) {
		#Déclaration des variables 
	$date = date("d/m/Y H:i");

	try {
			#Si l'heure change entre les deux tableaux 
		if ($old_array['hour'] != $new_array['hour']){
				#On recherche ID creneau pour le jour et la nouvelle heure
			$r1 = "SELECT ID_creneau FROM creneau WHERE jour =\"".$old_array['day']."\" AND heure = \"".$new_array['hour']."\"";
			$q1 = Query($r1); 
			$row = mysqli_fetch_array($q1); 
			$creneau = $row[0]; 

				#On met à jour le créneau pour cette intervention  
			$r = "UPDATE planning SET ID_creneau=\"$creneau\" WHERE ID_service_int = \"".$old_array['service_int']."\" AND num_secu=\"".$old_array['ssNumber']."\"";
			$q = Query($r); 

				#On écrit dans le fichier de l'utilisateur
			WriteUserLog("$date : Modificiation du créneau de l'invervention du service".$old_array['service_int']."\r\n");
				#On écrit dans le fichier du service concerné
			WriteInterventionLog("$date : Modificiation du créneau $creneau \r\n", $old_array['service_int']);			
		}
	} catch (Exception $e) {
			#Si il y a une erreur de query 
		echo $e -> getMessage();
	}
}

#CheckSurbooking(...) = on regarde si il y a du surbooking (2 rdv pour un créneau)
function CheckSurbooking($ID_service_int) {
		#Déclaration des variables 
	$heure = date("H:i:s");

	try{
		#On récupère le nombre de créneaux théoriques 
			$r = "SELECT nb_creneaux FROM service_intervention WHERE ID_service_int = \"$ID_service_int\"";
			$q = Query($r); 
			$nb_creneaux = mysqli_fetch_array($q)[0];

		#Si on est le matin 
		if ($heure < "12:30:00"){
			#On prend les interventions du matin 
			$r_nbcreneaux = "SELECT ID_creneau, COUNT(ID_creneau) FROM planning NATURAL JOIN creneau WHERE ID_service_int = \"$ID_service_int\" AND jour = CURRENT_DATE() AND heure BETWEEN \"8:00:00\" AND \"12:30:00\" GROUP BY ID_creneau"; 
			$q_nbcreneaux = Query($r_nbcreneaux); 
			$array_nb = []; 
			while ($nuplet = mysqli_fetch_array($q_nbcreneaux)) {
				array_push($array_nb, $nuplet[0], $nuplet[1]);
			}

		#Si c'est l'après-midi
		} elseif ("12:30:00" < $heure){
				#On prend les interventions de l'après-midi 
			$r_nbcreneaux = "SELECT ID_creneau, COUNT(ID_creneau)  FROM planning NATURAL JOIN creneau WHERE ID_service_int = \"$ID_service_int\" AND jour = CURRENT_DATE() AND heure BETWEEN \"13:00:00\" AND \"18:00:00\" GROUP BY ID_creneau"; 
			$q_nbcreneaux = Query($r_nbcreneaux); 
			$array_nb = []; 
			while ($nuplet = mysqli_fetch_array($q_nbcreneaux)) {
				array_push($array_nb, $nuplet[0], $nuplet[1]);
			}
		}

		#On check si surbooking 
		$i=0; 
		while ($i < count($array_nb)) {
			if ($array_nb[$i+1] >= $nb_creneaux){
				return(True);
			} 
			$i = $i +2; 
		}
		return(False);
	} catch (Exception $e) {
			#Si il y a une erreur de query 
		echo " ";
	}
}  

#UpdateDay(...)= On met à jour toutes les interventions 
function UpdateDay ($old,$new){
		#On lit les deux tableaux en parallèle 
	foreach ($old as $array_o) {
		$i = 0;
		while ($i<count($new)){
			$array_n = $new[$i]; 
			if ($array_o['service_int']==$array_n['service_int']&& $array_o['ssNumber']==$array_n['ssNumber'] && $array_o['day']==$array_n['day']) {
					#On met à jour l'intervention 
				UpdateIntervetion($array_o,$array_n);
			}
			$i=$i+1;
		}
	}
}

#ReturnName(...)= retourne les noms du personnel 
function ReturnName () {
	try{
		$r = "SELECT nom, prenom, ID_personnel FROM personne NATURAL JOIN personnel"; 
		$q = Query($r); 

		$array = []; 
		while ($nuplet = mysqli_fetch_array($q)) {
			array_push($array, $nuplet[0],$nuplet[1],$nuplet[2]);
		}

		return($array); 
	}catch(Exception $e){
			#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}

#WhichService($ID)= retourne le service du responsable
function WhichService($ID) {
	try{
		$r = "SELECT ID_service_int FROM respo_intervention WHERE ID_personnel = \"$ID\""; 
		$q = Query($r); 

		$row = mysqli_fetch_array($q); 
		$row = $row[0]; 

		return($row); 
	}catch(Exception $e){
			#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}

#ReturnService(...) = retourne les pathologies ;
function ReturnService ($type) {
	try{
		if ($type == "intervention"){
			$r = "SELECT ID_service_int, nom FROM service_intervention"; 
			$q = Query($r); 

			$array = []; 
			while ($nuplet = mysqli_fetch_array($q)) {
				array_push($array, $nuplet[0], $nuplet[1]);
			}
			return($array);
		}

		elseif ($type == "accueil") {
			$r = "SELECT ID_service_acc, nom FROM service_accueil"; 
			$q = Query($r); 

			$array = []; 
			while ($nuplet = mysqli_fetch_array($q)) {
				array_push($array, $nuplet[0], $nuplet[1]);
			}
			return($array);
		}
	}catch(Exception $e){
			#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}

#ReturnPathology(...) = retourne les pathologies ;
function ReturnPathology () {
	try{
		$r = "SELECT pathologie FROM pathologie"; 
		$q = Query($r); 

		$array = []; 
		while ($nuplet = mysqli_fetch_array($q)) {
			array_push($array, $nuplet[0]);
		}

		return($array); 
	}catch(Exception $e){
			#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}

#ReturnIntervention(...) = retourne les interventions selon ID_creneau
function ReturnIntervention($result_search) {
	try{
		$i= 0; 
		$result= []; 
		while ($i < count($result_search)){
			$IDcreneau = $result_search[$i]; 

			$r_date = "SELECT jour, heure FROM creneau WHERE ID_creneau = \"$IDcreneau\"";

			$q_date = Query($r_date);
			$row_date = mysqli_fetch_array($q_date); 
			$jour = $row_date[0]; 
			$heure = $row_date[1];

			$i=$i+1;
			$IDintervention = $result_search[$i];

			$r_int = "SELECT nom FROM service_intervention WHERE ID_service_int = \"$IDintervention\"";
			$_SESSION['query'] = $r_date;
			$q_int = Query($r_int); 
			$row_int = mysqli_fetch_array($q_int); 
			$service = $row_int[0]; 

			$phrase ="Intervention du $jour à $heure en $service";
			$result[]=$phrase;
			$result[]="$IDcreneau $IDintervention";
			$i = $i+1; 
		}
		return($result);
	}catch(Exception $e){
			#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}

# PrintHeader() prints out all menu links
# Return nothing
function PrintHeader() {
	echo '<a href="./index.php" class="lien">Menu principal</a><br>' . "\n";
	echo '<a href="./?action=searchMail" class="lien">Rechercher adresse mail</a><br>'. "\n";
	echo '<a href="./login.php?action=logout" class="lien">Deconnexion</a><br>'. "\n";
}

# PrintFooter() prints out all footer infos
# Return nothing
function PrintFooter() {
	echo '<div id="footer"> 2017 - projet HTML/CSS/PHP <br>';
	Debugage();
	echo 'Benoit Baillif - Solène Guiglion - Léa Wadbled</div>';
}

# CheckUID() checks if the user is connected, meaning he has a UID
# if not he is redirected to login
# Return : Nothing
function CheckUID() {
	if (!isset($_SESSION['uid'])) {
		header('Location: ./login.php');
	}
}

# OptionHours() genererate a <option> list of hours, depending on day time.
	# String day : format is YYYY-mm-dd
	# String halfDay : 'morning' or 'afternoon'
	# String pre_selected_hour : define the default (selected) option ; format is hh:mm:ss
# Return : Nothing
function OptionHours($day, $halfDay, $pre_selected_hour) {
	if ($halfDay == 'morning') {
		$query = 'SELECT * FROM creneau WHERE jour = "' . $day . '" AND heure BETWEEN "08:30:00" AND "12:00:00"';
	}
	else {
		$query = 'SELECT * FROM creneau WHERE jour = "' . $day . '" AND heure BETWEEN "13:30:00" AND "18:00:00"';
	}
	$results = Query($query);
	while ($nuplet = mysqli_fetch_array($results)) {
		$hour = $nuplet[2];
		if ($hour == $pre_selected_hour) {
			echo '<option value="' . $hour . '" selected="selected">' . $hour . '</option>';
		}
		else {
			echo '<option value="' . $hour . '">' . $hour . '</option>';
		}
	}
}

function returnPatient($array){
	$tableau=[];
	$phrase=$array['surname']." ".$array['name']." (numero de securite sociale : ".$array['ssNumber'].")";
	$value=$array['ssNumber'];
	$tableau[]=$phrase;
	$tableau[]=$value;
	return($tableau);
}

# PrintSchedule prints out the schedule for the given service
	# String service : intervention service
# Return Nothing
function PrintSchedule($service) {
			# date A CHANGER EN VERSION FINALE
	$date = date("2017-11-13");
	$query1 = 'SELECT nom, prenom, jour, heure, ID_service_int, mail FROM (creneau NATURAL JOIN planning NATURAL JOIN personne) JOIN personnel ON planning.ID_personnel = personnel.ID_personnel WHERE jour = "' . $date . '" AND ID_service_int = "' . $service . '"';
	try {
		$results = Query($query1);
		while($nuplet = mysqli_fetch_array($results)) {
			echo $nuplet[0] . ' ' . $nuplet[1] . ' ' . $nuplet[2] . ' ' . $nuplet[3] . ' ' . $nuplet[4] . ' ' . $nuplet[5];
			echo '<br>' . "\n";
		}
	} catch (Exception $e){
			#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}

# ChangeHalfDay change the hours of interventions
	# Array appointments_array : all infos about interventions ; format is appointments_array[line_idx][info_name] = String info_value
	# Array newHours : all the new hours, for each appointment ; format is newHours['appointment' . idx] = String newHour ; newHour format is hh:mm:ss
# Return Nothing
function ChangeHalfDay($appointments_array, $newHours) {
	foreach ($appointments_array as $line => $info_array) {
		$previous_hour = $info_array['heure'];
		$day = $info_array['jour'];
		$query1 = 'SELECT ID_creneau FROM creneau WHERE jour = "' . $day . '" AND heure = "' . $previous_hour . '"';
		try {
			$results1 = Query($query1);
			while ($nuplet = mysqli_fetch_array($results1)) {
				$previous_ID_creneau = $nuplet[0];
			}

			$next_hour = $newHours['appointment' . $line];
			$query2 = 'SELECT ID_creneau FROM creneau WHERE jour = "' . $day . '" AND heure = "' . $next_hour . '"';
			$results2 = Query($query2);
			while ($nuplet = mysqli_fetch_array($results2)) {
				$next_ID_creneau = $nuplet[0];
			}

			$query3 = 'UPDATE planning SET ID_creneau = "' . $next_ID_creneau . '" WHERE num_secu = "' . $info_array['planning.num_secu'] . '" AND ID_creneau = "' . $previous_ID_creneau . '"' ;
			$re = Query($query3);
		} catch (Exception $e){
			#Si erreur de la fonction Query() 
			echo $e -> getMessage();
		}
	}
}

	function changeWindow($minutes){
		#déclaration des variables 
		$jour_semaine = array("lundi"=>"LU", "mardi"=>"MA", "mercredi"=>"ME", "jeudi"=>"JE", "vendredi"=>"VE");
		try{
			$r = "TRUNCATE TABLE creneau"; 
			$q = Query($r); 

			#$date = date("Y-m-d");
			$date = "2017-11-11";
			$day = strtotime($date); 
			while ($day < strtotime("2018-02-01")){
				$jour = nom_jour($date); 
				$num_semaine = date('W',strtotime($date)); 
				
				if ($jour != "samedi" & $jour != "dimanche"){
					$heure = "8:00:00";
					$time = strtotime($heure); 
					$matin = 1;
					$aprem = 1;
					while ($time < strtotime("18:00:00")){ 
						$ID = "";
					if ($time < strtotime("12:30:00")){
						$ID = $jour_semaine[$jour].$num_semaine."M".$matin; 
						$matin=$matin+1;  
						$r_m = "INSERT INTO creneau VALUES (\"$ID\",\"$date\",\"$heure\")"; 
						$q_m = Query($r_m);
					}
					if ($time >= strtotime("13:30:00") && $time < strtotime("18:00:00")){
						$ID = $jour_semaine[$jour].$num_semaine."A".$aprem; 
						$aprem=$aprem+1; 
						$r_a = "INSERT INTO creneau VALUES (\"$ID\",\"$date\",\"$heure\")"; 
						$q_a = Query($r_a);
					}
					#ajoute le nombre de secondes désirés 
						$secondes = $minutes * 60; 
						$time=$time+$secondes;
						#date en date 
						$heure=date("H:i:s",$time);
					}
				}

				$unjour = 60 * 60 * 24; 
				#ajoute le nombre de secondes d'une journée 
				$day = $day + $unjour; 
				#transformation en date 
				$date = date("Y-m-d",$day); 
			}
		}catch(Exception $e){
			#Si erreur de la fonction Query() 
			echo $e -> getMessage();
		}
	}

	function nom_jour($date) {
		$jour_semaine = array(1=>"lundi", 2=>"mardi", 3=>"mercredi", 4=>"jeudi", 5=>"vendredi", 6=>"samedi", 7=>"dimanche");
		$array = explode ("-", $date);
 		$timestamp = mktime(0,0,0, date($array[1]), date($array[2]), date($array[0]));
		$njour = date("N",$timestamp);
		return $jour_semaine[$njour];
	}

# EmptyValue() returns True if at least one field of $_POST is empty
	# Array array
# Return boolean
function EmptyValue($array){
	$empty = False; 
	foreach ($array as $key => $value) {
		if($value == ''){
			$empty = True;
		}
	}
	return $empty;
}

# Debugage() prints out $_SESSION and $_POST
# Return Nothing
function Debugage() {
	echo '$_SESSION : ';
	if (isset($_SESSION)) {
		print_r($_SESSION);
	}
	echo '<br>$_POST : ';
	if (isset($_POST)) {
		print_r($_POST);
	}
	echo '<br>\n';
}

# AddUser 
function AddUser($array_user){
	try{
		$secu = $array_user['ssNumber']; 
		$nom = $array_user['surname'] ;
		$prenom = $array_user['name']; 
		$sexe = $array_user['gender']; 
		$date_naiss = $array_user['birthday'];
		$ID = $array_user['ID'];
		$mdp = $array_user['password'];
		$droit = $array_user['right'];
		$ID_service = $array_user['Service'];
		$mail = $nom.'.'.$prenom."@chu.fr";

		if ($droit == "1") {
			$r_medecin = "INSERT INTO medecin VALUES (\"$ID\",\"$ID_service\")"; 
			$q_medecin = Query($r_medecin) ;
		} elseif($droit =="2") {
			$r_respo = "INSERT INTO respo_intervention VALUES (\"$ID\",\"$ID_service\")"; 
			$q_respo = Query($r_respo) ;
		} 

		$r_personne = "INSERT INTO personne VALUES (\"$secu\",\"$nom\",\"$prenom\",\"$sexe\",\"$date_naiss\")" ; 
		$q_personne = Query($r_personne); 

		$r_personnel = "INSERT INTO personnel VALUES (\"$secu\",\"$ID\",\"$mdp\",\"$droit\",\"$mail\")"; 
		$q_personnel =Query($r_personnel); 

	}catch(Exception $e){
		#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}

function DeleteUser($ID){
	try{
		$r =  "DELETE FROM personnel WHERE ID_personnel=\"$ID\""; 
		$q = Query($r); 
	}catch(Exception $e){
		#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}

function AddNumSecuInt($numsecu, $IDcreneau, $IDservice) {
	try{
		$r =  "UPDATE planning SET num_secu =\"$numsecu\" WHERE num_secu=\"\" and ID_creneau=\"$IDcreneau\" AND ID_service_int=\"$IDservice\" "; 
		$q = Query($r); 
	}catch(Exception $e){
		#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}
	
#AllBooked(...) = on regarde si il y a du surbooking (trop de rdv pour un créneau)
function AllBooked($ID_service_int) {
		#Déclaration des variables 
	$heure = date("H:i:s");

	try{
		#On récupère le nombre de créneaux théoriques 
			$r = "SELECT nb_creneaux FROM service_intervention WHERE ID_service_int = \"$ID_service_int\"";
			$q = Query($r); 
			$nb_creneaux = mysqli_fetch_array($q)[0];

			$array_nb = [];

		#Si on est le matin 
		if ($heure < "12:30:00"){
			#On prend les interventions du matin 
			$r_nbcreneaux = "SELECT ID_creneau, COUNT(ID_creneau) FROM planning NATURAL JOIN creneau WHERE ID_service_int = \"$ID_service_int\" AND jour = CURRENT_DATE() AND heure BETWEEN \"8:00:00\" AND \"12:30:00\" GROUP BY ID_creneau"; 
			$q_nbcreneaux = Query($r_nbcreneaux); 
			while ($nuplet = mysqli_fetch_array($q_nbcreneaux)) {
				array_push($array_nb, $nuplet[0], $nuplet[1]);
			}

		#Si c'est l'après-midi
		} elseif ("12:30:00" < $heure){
				#On prend les interventions de l'après-midi 
			$r_nbcreneaux = "SELECT ID_creneau, COUNT(ID_creneau)  FROM planning NATURAL JOIN creneau WHERE ID_service_int = \"$ID_service_int\" AND jour = CURRENT_DATE() AND heure BETWEEN \"13:00:00\" AND \"18:00:00\" GROUP BY ID_creneau"; 
			$q_nbcreneaux = Query($r_nbcreneaux); 
			while ($nuplet = mysqli_fetch_array($q_nbcreneaux)) {
				array_push($array_nb, $nuplet[0], $nuplet[1]);
			}
		}

		#On check si surbooking 
		$i=0; $creneaux = [];
		while ($i < count($array_nb)) {
			if ($array_nb[$i+1] >= $nb_creneaux){
				$creneaux[] = $array_nb[$i]; 
			} 
			$i = $i +2; 
		}

		if(count($creneaux)==$nb_creneaux*9){
			return(True);
		}
		return(False);
	} catch (Exception $e) {
			#Si il y a une erreur de query 
		echo $e -> getMessage();
	}
}  