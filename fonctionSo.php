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

		#On ferme la base de données
		mysqli_close($r);
		return ($t);
	}

	function WriteUserLog($chaine)
	{
		$user = "X"; #comment on fait pour récupérer le nom de l'utilisateur? 
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
		try{
			$error = "Les informations saisies sont incorrectes. <br>Merci de bien vouloir vérifier les informations saisies.";
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
					return($row[0]);
				}
				#Sinon, on continue 
				$i = $i + 2;
			}
			#Si le couple(ID,mdp) n'est pas dans la base de données
			throw new Exception($error);
			#writeUserLog()  
		}catch(Exception $e){
			echo $e -> getMessage();
		}
	}    

	function PrintResults($tableau,$type)
	{
		if ($type == "checkbox")
		{
			while($nuplet=mysqli_fetch_array($tableau))
			{
				print("<input type=\"checkbox\" name=\"value[]\" value=\"".$nuplet[0]."\" id =\"b\"> ");
				print("<label for= \"b\">".$nuplet[0]."\n</label> <br><br>");
			}
		}
		else
		{
			while($nuplet=mysqli_fetch_array($tableau))
			{
				print("<input type=\"radio\" name=\"val\" value=\"".$nuplet[0]."\" id =\"b\"> ");
				print("<label for= \"b\"> ".$nuplet[0]."\n</label><br><br>");
			}
		}
	}
			
	function DeletePatient($numSecu)
	{
		try{
			$r="DELETE from patient WHERE num_secu=\"$numSECU\"";
			$q=Query($r);
			#WriteUserlog; 
		}catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function DeleteService($nom_service)
	{
		try{
			$r="DELETE from Service_intervention WHERE nom=\"$nom_service\"";
			$q=Query($r);
			#WriteUserlog; 
			#WriteInterventionLog 
		}catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function AddIntervention($serviceI,$creneau,$Idpers,$numSecu)
	{
		try{
			$r="INSERT INTO planning VALUES ($serviceI,$creneau,$Idpers,$numSecu,\"0\")";
			$q=Query($r); 
			#WriteUserlog
			#writeInterventionlog
		}catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function AddService($nomService,$type)
	{
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
				#WriteUserlog
				#WriteInterventionlog
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
				#WriteUserlog
				#WriteInterventionlog
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

	function FactureIntervention($query_result)
	{
		try{
			$array = [];
			while ($nuplet = mysqli_fetch_array($query_result)) {
				array_push($array, $nuplet[0], $nuplet[1], $nuplet[2],$nuplet[3]);
			}
			print($array[0]);
			print($array[1]);
			print($array[2]);
			print($array[3]);
			$i = 0 ; 
			while ($i < count($array)) {
				$service = $array[$i]; 
				$creneau = $array[$i+1];
				$personnel = $array[$i+2];
				$secu = $array[$i+3];
				#l'Update ne marcge pas !! 
				$r = "UPDATE planning SET facture=\"1\" WHERE ID_service = \"$service\" AND ID_creneau = \"$creneau \" AND ID_personnel= \"$personnel\" AND num_secu=\"$secu\"";
				$q = Query($r);
				#writeInterventionLog()
				#writeUserLog()
				$i=$i+4; 
			}
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
				$array_matin = []; #ecrire l'array 
				foreach ($variable as $value) {
					$r1 = "SELECT ID_service_int, ID_personnel, num_secu FROM planning NATURAL JOIN creneau WHERE jour=$date AND heure = $value"; 
					$q1 = Query($r1); 
				}
				#code 
			} catch (Exception $e){
				#Si il y a une erreur de query
				echo $e -> getMessage();
			}
		}

		#Si on regarde le soir 
		elseif ($demi_journee == "apres-midi"){
			#code
		}
	}
?>