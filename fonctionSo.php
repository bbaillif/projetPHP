<?php

	function Query($query)
	{
		$r=mysqli_connect('localhost','root','','commandes');
		$t=mysqli_query($r,$query);
		mysqli_close($r);
		return ($t);
	}
	
	function Printresults($tableau,$type)
	{
		if ($type = "checkbox")
		{
			while($nuplet=mysqli_fetch_array($t))
			{
				print("<input type=\"checkbox\" name=\"value[]\" value=\"".$nuplet[0]."\" id= b> ");
				print("<label for= \"b\">".$nuplet[0]."\n</label><br><br>");
			}
		}
		else
		{
			while($nuplet=mysqli_fetch_array($t))
			{
				print("<input type=\"radio\" name=\"val\" value=\"".$nuplet[0]."\" id= b> ");
				print("<label for= \"b\">".$nuplet[0]."\n</label><br><br>");
			}
		}
	}
	
	function DeletePatient($numSecu)
	{
		$r="DELETE from `Personne` WHERE `num_secu`=$numSECU";
		$q=Query($r);
		#Gestion des erreurs avec query ? 
		#WriteUserlog
	}
	
	function AddIntervention($serviceI,$creneau,$Idpers,$numSecu)
	{
		$r="INSERT INTO `Planning` (`ID_service_int`,`ID_creneau`,`ID_personnel`,`num_secu`) VALUES ("$serviceI","$creneau","$Idpers","$numSecu")";
		$q=Query($r);
		#Gestion des erreurs avec query ? 
		#WriteUserlog
		#writeInterventionlog
	}
	
	function AddService($IDservice,$nomService,$type)
	{
		if ($type="intervention")
		{
			$r="INSERT INTO `Service_intervention` VALUES ("$IDservice","$nomService")";
			#WriteUserlog
			#writeInterventionlog
		}
		else
		{
			$r="INSERT INTO `Service_accueil` VALUES ("$IDservice","$nomService")";
			#WriteUserlog
			#writeInterventionlog
		}
		$q=Query($r);
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