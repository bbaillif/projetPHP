<?php

	function Query($query)
	{
		#on essaye de se connecter à la base de données
		#il faut gérer les erreurs SQL 
		$r=mysqli_connect('localhost','Lea','BD20162017','projetPHP');
		if (mysqli_connect_error()){
			throw new Exception("<p> Impossible de se connecter à la base de données </p>");			
		}
		$t=mysqli_query($r,$query);
		if ($t == ""){
			throw new Exception("<p> Impossible d'executer la requête </p>");
		}
		mysqli_close($r);
		return ($t);
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
		$r="DELETE from `Patient` WHERE `num_secu`=$numSECU";
		$q=Query($r);
		#WriteUserlog; 
	}

	function AddIntervention($serviceI,$creneau,$Idpers,$numSecu)
	{
		$r="INSERT INTO `Planning` VALUES (\"$serviceI\",\"$creneau\",\"$Idpers\",\"$numSecu\",\"0\")";
		$q=Query($r); 
		#WriteUserlog
		#writeInterventionlog
	}

	function AddService($nomService,$type)
	{
		if ($type=="intervention")
		{
			$r1 = "SELECT ID_service_inter FROM service_intervention";
			$q1 = Query($r1);
			$array = [];
			while ($nuplet = mysqli_fetch_array($q1)) {
				array_push($array, substr($nuplet[0], -3));
			}
			$n = max($array); 
			print($n + 1); 
			#$r="INSERT INTO `Service_intervention` VALUES ("$IDservice","$nomService")";
			#WriteUserlog
			#writeInterventionlog
		}
		#else
		#{
			#$r="INSERT INTO `Service_accueil` VALUES ("$IDservice","$nomService")";
			#WriteUserlog
			#writeInterventionlog
		#}
		#$q=Query($r);
	}

	function DeleteService($nomService, $type) #ou id service ??
	{
		if ($type="intervention")
		{
			$r="DELETE from `Service_intervention` WHERE `nom`=$nomService";
		}
		else
		{
			$r="DELETE from `Service_accueil` WHERE `nom`=$nomService";
		}
		$q=Query($r);
	}
?>