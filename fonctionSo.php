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
		#Si erreur dans l'execution de la requête
		if ($t == ""){ 
			throw new Exception($error2); 
		}

		#On ferme la base de données
		mysqli_close($r);
		return ($t);
	}

	function WriteUserLog(chaine){
		#Ecrit chaine dans un fichier log au nom de l'utilisateur  Créé le fichier s'il n'existe pas 
	} 

	function WriteInterventionLog(chaine, service) {
		#Ecrit chaine dans un fichier log au nom du service d'intervention  Créé le fichier s'il n'existe pas  function
	}

	function CheckID($ID, $mdp){
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
			$r="DELETE from `Patient` WHERE `num_secu`=$numSECU";
			$q=Query($r);
			#WriteUserlog; 
		}catch (Exception $e){
			#Si il y a une erreur de query
			echo $e -> getMessage();
		}
	}

	function AddIntervention($serviceI,$creneau,$Idpers,$numSecu)
	{
		try{
		$r="INSERT INTO `Planning` VALUES (\"$serviceI\",\"$creneau\",\"$Idpers\",\"$numSecu\",\"0\")";
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

?>