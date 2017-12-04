<?php

mysqli_report(MYSQLI_REPORT_STRICT);

	function Query($query)
	{
		#Déclaration des variables
		$error1 = "<p>Impossible de se connecter à la base de données</p>";
		$error2 = "<p>Impossible d'executer la requête </p>";
		$user = 'Lea'; 
		$pwd = 'BDE20162017'; 
		$bdd = 'projetPHP';

		#On essaye de se connecter à la base de données
		$r=mysqli_connect('localhost',$user,$pwd,$bdd);
		#Si erreur de connection
		if (mysqli_connect_errno()){  
			throw new Exception($error1); 
		}

		#On essaye d'executer la requête
		$t=mysqli_query($r,$query);
		if (gettype($t) != "boolean"){
			#Si erreur dans l'execution de la requête
			$rowcount = mysqli_num_rows($t);
			if ($rowcount == 0){ 
				throw new Exception($error2); 
			}
		} 
		else {
			#Si les query du type INSERT, UPDATE, ne marchent pas
			if ($t == False){
				throw new Exception($error2); 
			}
		}

		#On ferme la base de données
		mysqli_close($r);
		return ($t);
	}

	function WriteUserLog($chaine)
	{
		#On récupère l'ID de l'utilisateur 
		$user = $_SESSION['uid']; 
		#On ouvre le fichier, si pas créé, on le crée
		if ($f = fopen("$user.txt", "a")){
			#On écrit la chaine
			fwrite($f, $chaine); 
			#On ferme le fichier
			fclose($f); 
		}
	} 

	function WriteInterventionLog($chaine, $service)
	{
		#On ouvre le fichier, si pas créé, on le crée
		if ($f = fopen("$service.txt", "a")){
			#On écrit la chaine
			fwrite($f, $chaine); 
			#On ferme le fichier
			fclose($f); 
		}
	}

	function CheckID($ID, $mdp)
	{
		$date = date("d/m/Y H:i");
		$error = "Les informations saisies sont incorrectes. <br>Merci de bien vouloir vérifier les informations saisies."; 

		try{
			#On récupère les couple (ID, mdp) de la bdd 
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

					#On écrit dans le fichier de l'utilisateur
					WriteUserLog("$date : connection \r\n");

					#On retourne son droit
					$array_return= array('ID' => $ID, 'right' => $row[0]); 
					return($array_return);
				}
				#Sinon, on continue 
				$i = $i + 2;
			}
			#Si le couple(ID,mdp) n'est pas dans la base de données
			throw new Exception($error); 
		}catch(Exception $e){
			echo $e -> getMessage();
		}
	}    

	function PrintResults($tableau,$type)
	{
		if ($type == "checkbox")
		{
			foreach ($tableau as $value) 
			{
				print("<input type=\"checkbox\" name=\"value[]\" value=\"".$value."\" id =\"b\"> ");
				print("<label for= \"b\">".$value."\n</label> <br><br>");
			}
		}
		else
		{
			foreach ($tableau as $value) 
			{
				print("<input type=\"radio\" name=\"val\" value=\"".$value."\" id =\"b\"> ");
				print("<label for= \"b\"> ".$value."\n</label><br><br>");
			}
		}
	}
			
	function DeletePatient($numSecu)
	{
		$date = date("d/m/Y H:i");

		try{
			$r="DELETE from patient WHERE num_secu=\"$numSecu\"";
			$q=Query($r);

			#On écrit dans le fichier de l'utilisateur
			WriteUserLog("$date : suppression du patient $numSecu \r\n");
		}catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function DeleteService($nom_service)
	{
		$date = date("d/m/Y H:i");

		try{
			#On sélectionne l'ID du service de la BDD 
			$r2 = "SELECT ID_service_int FROM Service_intervention WHERE nom=\"$nom_service\"";
			$q2 = Query($r2); 
			$row = mysqli_fetch_array($q2); 

			#On supprime le service de la BDD
			$r="DELETE from Service_intervention WHERE nom=\"$nom_service\"";
			$q=Query($r);

			#On écrit dans le fichier de l'utilisateur
			WriteUserLog("$date : suppression du service $nom_service \r\n"); 

			#On écrit dans le fichier service
			WriteInterventionLog("$date : suppression du service $nom_service \r\n", $row[0]); 

		}catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function AddIntervention($serviceI, $creneau, $Idpers, $numSecu)
	{
		$date = date("d/m/Y H:i");

		try{
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

	function AddService($nomService,$type)
	{
		$date = date("d/m/Y H:i");

		#On veut ajouter un service d'intervention 
		if ($type=="intervention")
		{
			try{
				#On récupère les ID des services d'intervention
				$r1 = "SELECT ID_service_int FROM Service_intervention";
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
				$r2 = "INSERT INTO Service_intervention VALUES (\"".$IDservice."\",\"".$nomService."\")";
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
				$r1 = "SELECT ID_service_acc FROM Service_accueil";
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
				$r2 = "INSERT INTO Service_accueil VALUES (\"".$IDservice."\",\"".$nomService."\")";
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

	function SearchEmail($nom,$prenom)
	{
		try {
			$r = "SELECT mail FROM personnel NATURAL JOIN personne WHERE prenom =\"$prenom\" AND nom=\"$nom\"";
			#On essaye d'effectuer la requête
			$q = Query($r); 
			#On lit le résultat de la requête
			$array = [];
			while ($nuplet = mysqli_fetch_array($q)) {
				array_push($array, $nuplet[0]);
			}

			#On print l'email (on considère qu'une seule personne a un nom+prénom)
			return($array[0]);
		} catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function PrintArchive($fichier)
	{
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

	function FactureIntervention($service, $creneau, $secu)
	{
		$date = date("d/m/Y H:i");

		try{
			$r = "UPDATE planning SET facture=0 WHERE ID_service_int = \"$service\" AND ID_creneau = \"$creneau \" AND num_secu=\"$secu\""; 
			$q = Query($r);

			#On écrit dans le fichier de l'utilisateur
			WriteUserLog("$date : facturation  de l'intervention $creneau du patient $secu \r\n"); 

			#On écrit dans le fichier service
			WriteInterventionLog("$date : facturation  de l'intervention $creneau du patient $secu \r\n", $service); 

		} catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function SearchDay($date,$demi_journee)
	{
		#Si on regarde le matin 
		if ($demi_journee == "matin"){
			try {
				$r1 = "SELECT ID_service_int, ID_creneau, ID_personnel, num_secu FROM creneau NATURAL JOIN planning WHERE jour=\"$date\" AND heure BETWEEN \"08:30:00\" AND \"12:00:00\" "; 
				$q1 = Query($r1); 

				#On récupère les interventions du matin 
				$array=[]; 
				while ($nuplet = mysqli_fetch_array($q1)) {
					array_push($array, $nuplet[0],$nuplet[1],$nuplet[2],$nuplet[3]);
				}
				return($array);
			} catch (Exception $e){
				#Si il y a une erreur de query
				echo $e -> getMessage();
			}
		}
		elseif ($demi_journee == "apres-midi") {
			try {
				$r1 = "SELECT ID_service_int, ID_creneau, ID_personnel, num_secu FROM creneau NATURAL JOIN planning WHERE jour=\"$date\" AND heure BETWEEN \"13:30:00\" AND \"17:30:00\" "; 
				$q1 = Query($r1); 

				#On récupère les interventions du matin 
				$array=[]; 
				while ($nuplet = mysqli_fetch_array($q1)) {
					array_push($array, $nuplet[0],$nuplet[1],$nuplet[2],$nuplet[3]);
				}
				return($array);
			} catch (Exception $e){
				#Si il y a une erreur de query
				echo $e -> getMessage();
			}
		}
	}

	function Emergency($numSecu, $service){
		$jour = date("d/m/Y");
		$heure = date("H:i:s"); 
		$date = date("d/m/Y H:i");

		try{
			$r="SELECT ID_creneau FROM creneau WHERE jour = \"2017-11-14\" AND heure > \"$heure\"" ; 
			$q = Query($r); 

			#On récupère le premier créneau
			$row = mysqli_fetch_array($q); 

			#On ajoute l'intervention 
			AddIntervention($service, $row[0], $_SESSION['uid'], $numSecu); 

			#On écrit dans le fichier de l'utilisateur
			WriteUserLog("$date : ajout de l'urgence du patient $numSecu pour intervention dans $service au créneau $row[0] \r\n"); 

			#On écrit dans le fichier service
			WriteInterventionLog("$date : ajout de l'urgence $row[0] pour le patient $numSecu \r\n", $service); 

		} catch (Exception $e){
				#Si il y a une erreur de query
				echo $e -> getMessage();
		}
	}

	function CheckPatient($patient_array)
	{
		try{
			#Vérifie que le patient est pas dans la BDD
			$secu = $patient_array['ssNumber']; 
			
			$r1 = "SELECT num_secu FROM patient" ; 
			$q1 = Query($r1); 

			$array = []; 
			while ($nuplet = mysqli_fetch_array($q1)){
				array_push($array, $nuplet[0]);
			}

			if (in_array("$secu",$array)){
				#throw new Exception("Le patient existe déjà."); 
				return(False);
			}
			return(True); 
		}catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function CheckNU($patient_array)
	{
		$date = date("d/m/Y H:i");

		try{
			#Verifie que le niveau d'urgence est compatible avec la pathologie 
			$secu = $patient_array['ssNumber']; 
			$patho = $patient_array['pathology'];
			$NU = $patient_array['emergencyNumber']; 	

			$r2 = "SELECT NU_defaut FROM pathologie WHERE pathologie = \"$patho\"";
			$q2 = Query($r2);

			$row = mysqli_fetch_array($q2); 
			if ($row[0] != $NU ){
				if ($f = fopen("VerifNU.txt", "a")){
					#On écrit la chaine
					fwrite($f, "$date : $secu a un $patho avec NU=$NU"); 
					#On ferme le fichier
					fclose($f); 
				}
			}
		}catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function AddPatient ($patient_array)
	{
		$date = date("d/m/Y H:i");

		try{
			#Vérifie que toutes les informations sont présentes dans le tableau
			foreach ($patient_array as $key => $value) {
				if (empty($value)){
					throw new Exception("Il manque des infos.");
				}
			}

			#Vérifie que le patient n'existe pas déjà
			if (CheckPatient($patient_array) == False) {
				throw new Exception("Le patient existe déjà");
			}

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
			$NU = $patient_array['emergencyNumber']; 
			$r_patient = "INSERT INTO patient VALUES (\"$secu\",\"$patho\", \"$NU\")"; 
			$q_patient = query($r_patient); 

			#Check son NU 
			CheckNU($patient_array); 

			WriteUserLog("$date : ajout du patient $secu \r\n");
		} catch (Exception $e){
			#Si il y a une erreur de query ou de CheckPatient
			echo $e -> getMessage();
		}
	}

	function UpdatedUL($secu, $NU)
	{		
		try{
			#Query pour connaître la durée jusqu'à la prochaine intervention concernant le numéro de sécu dans la table Planning.  
			$r = "SELECT DATEDIFF(jour,CURRENT_DATE()) FROM planning NATURAL JOIN creneau WHERE num_secu = \"$secu\" ORDER BY jour, heure";
			$q = Query($r); 
			$row = mysqli_fetch_array($q); 
			$duree = $row[0]; 

			#MAJ du niveau d'urgence
			$update = 10 - ($duree/10); 
			$new_NU = $NU + $update; 
			$new_NU = round($new_NU); #On arrondit
			if ($new_NU > 10){
				$new_NU =10; #=10 si supérieur à 10, car 10 = le max
			}

			#Renvoie le niveau d'urgence mis-à-jour 
			return($new_NU); 
		}catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function UpdatePatient ($secu, $patient_array)
	{
		$date = date("d/m/Y H:i");

		try{
			#Vérifie que toutes les informations sont présentes dans le tableau
			foreach ($patient_array as $key => $value) {
				if (empty($value)){
					throw new Exception("Il manque des infos.");
				}
			}
			
			#Vérifie que le patient existe
			if (CheckPatient($patient_array) == True) {
				throw new Exception("Le patient n'existe pas");
			}

			#Update de la table patient 
			$patho = $patient_array['pathology'];
			$NU = $patient_array['emergencyNumber']; 
			$r_patient = "UPDATE patient SET pathologie=\"$patho\",NU=\"$NU\" WHERE num_secu = \"$secu\"";
			$q_patient = Query($r_patient); 

			#Check son NU 
			CheckNU($patient_array); 

			#On écrit dans le fichier du personnel qui a modifié 
			WriteUserLog("$date : update du patient $secu \r\n"); 
		}catch (Exception $e){
			#Si il y a une erreur de query ou de CheckPatient
			echo $e -> getMessage();
		}
	}

	function SearchFreeTime($Service_int)
	{
		try{
			#Recherche tous les IDCreneau présents dans la table Créneau qui ne sont pas dans la table Planning pour un service d'intervention donné 
			#ils sont classés par ordre chronologique grâce à ORDER BY
			$r = "SELECT ID_creneau FROM creneau WHERE ID_creneau NOT IN (SELECT ID_creneau FROM planning WHERE ID_service_int = \"$Service_int\") ORDER BY jour, heure" ; 
			$q = Query($r); 
			$array = []; 			
			while ($nuplet = mysqli_fetch_array($q)) {
				array_push($array, $nuplet[0]);
			}

			return($array); 
		}catch (Exception $e){
			#Si il y a une erreur de query 
			echo $e -> getMessage();
		}
	}  

	function PrintFreeTime ($array, $NU)
	{
		#On veut que le Num urgence soit un chiffre
		$NU =(int) $NU; 
		#On divise le tableau des créneaux tous les 5 créneaux
		$new = array_chunk($array, 5); 
		#Le max du numéro d'urgence = 10, on calcule quel tableau divisé on veut
		$n= 10 - $NU;  
		#On créé un nouveau tableau avec les 5 créneaux selon le numéro d'urgence
		$array_creneau = $new[$n]; 
		#On affiche le résultat
		PrintResults($array_creneau, "radio"); 
	}

	function UpdateIntervention($array, $new_array)
	{
		try{
			$secu = $array['ssNumber'];

			foreach ($new_array as $key => $value) {
				$r = ; 
				$q = Query($r);
			}
			 
			#writeInterventionLog()
			#writeUserLog()

		}catch (Exception $e){
			#Si il y a une erreur de query 
			echo $e -> getMessage();
		}
	}


?>