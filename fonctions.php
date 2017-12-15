<?php

mysqli_report(MYSQLI_REPORT_STRICT);

# AddIntervention() : add intervention in planning, using the given parameters
	# String ID_service
	# String creneau : creneau ID
	# String ID_pers : personnel ID
	# String ssNumber 
# Returns nothing
function AddIntervention($ID_service, $creneau, $ID_pers, $ssNumber) {
	$date = date("d/m/Y H:i");
	$unknownPatientEmergency = False;

	# Test if an emergency patient is already "appointed" at this time
	try {
		$query = 'SELECT num_secu FROM planning WHERE ID_creneau = "' . $creneau . '"';
		$result = Query($query);
		if (!empty($result)) {
			while ($nuplet = mysqli_fetch_array($result)) {
				$num_secu = $nuplet[0];
				if ($num_secu == "") {
					echo "Patient inconnu déjà placé pour cette urgence";
					$unknownPatientEmergency = True;
				}
			}
		}
	} catch (Exception $e){ # Error of Query()
		echo $e -> getMessage();
	}
		
	try {
		if (!$unknownPatientEmergency OR $ssNumber != "") {
			$query2 = "INSERT INTO planning VALUES (\"$ID_service\", \"$creneau\", \"$ID_pers\", \"$ssNumber\" ,0)";
			$result2 = Query($query2); 
			WriteUserLog("$date : ajout de l'intervention $ID_service pour le patient $ssNumber au créneau $creneau \r\n"); 
			WriteInterventionLog("$date : ajout de l'intervention $creneau pour le patient $ssNumber \r\n", $ID_service); 
		}
	} catch (Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# AddNumSecuInt() adds a SSNumber to an intervention created by emergency without patient
	# String ssNumber
	# String IDcreneau
	# String IDservice : service intervention
# Returns nothing
function AddNumSecuInt($ssNumber, $IDcreneau, $IDservice) {
	try{
		$r =  "UPDATE planning SET num_secu =\"$ssNumber\" WHERE num_secu=\"\" AND ID_creneau=\"$IDcreneau\" AND ID_service_int=\"$IDservice\" "; 
		$q = Query($r);
	}catch(Exception $e){ # Error of Query()
		echo $e -> getMessage();
	}
}


# AddPatient(...)= add patient in the DB, given the info pattient array
	# Array patient_array : array('info' => 'value')
# Returns nothing
function AddPatient($patient_array) {
	$date = date("d/m/Y H:i");

	try{
		$ssNumber = $patient_array['ssNumber']; 
		$surname = $patient_array['surname'] ;
		$name = $patient_array['name']; 
		$gender = $patient_array['gender']; 
		$birthday = $patient_array['birthday']; 

		$query_person = "INSERT INTO personne VALUES (\"$ssNumber\",\"$surname\",\"$name\",\"$gender\",\"$birthday\")" ; 
		$result_person = Query($query_person); 
 
		$pathology = $patient_array['pathology'];
		$EL = $patient_array['emergencyLevel'];
		$query_patient = "INSERT INTO patient VALUES (\"$ssNumber\",\"$pathology\", \"$EL\")"; 
		$result_patient = Query($query_patient); 

		CheckNU($patient_array); 

		WriteUserLog("$date : ajout du patient $ssNumber \r\n");
	} catch (Exception $e){ # Error of Query()
		echo $e -> getMessage();
	}
}


# AddService() : Add a service, given his name and type
	# String service_name
	# String type : 'intervention' or 'accueil'
	# Int nb_creneaux : amount of creneau for intervention
# Returns nothing
function AddService($service_name, $type, $nb_creneaux) {
	$date = date("d/m/Y H:i");

	if ($type == "intervention")
	{
		try{
			$query = "SELECT ID_service_int FROM service_intervention";
			$result = Query($query);
			$array = [];
			while ($nuplet = mysqli_fetch_array($result)) {
				array_push($array, substr($nuplet[0], -3));
			}

			# service ID is incremented for a new service
			$n = max($array);
			$n = $n + 1;
			$n = (string) $n;

			if (strlen($n) == 1) {
				$IDservice = "INT00".$n;
			}
			elseif (strlen($n) == 2) {
				$IDservice = "INT0".$n;
			}
			elseif (strlen($n) == 3) {
				$IDservice = "INT".$n;
			}

			$query2 = "INSERT INTO service_intervention VALUES (\"" . $IDservice . "\",\"" . $service_name . "\",\"" . $nb_creneaux . "\")";
			$result2 = Query($query2);
			WriteUserLog("$date : création du service $service_name \r\n"); 
			WriteInterventionLog("$date : création du service $service_name \r\n", $IDservice); 

		} catch (Exception $e) { # Error of Query()
			echo $e -> getMessage();
		}
	}

	elseif ($type == "accueil") {
		try{
			$query = "SELECT ID_service_acc FROM service_accueil";
			$result = Query($query);
			$array = [];
			while ($nuplet = mysqli_fetch_array($result)) {
				array_push($array, substr($nuplet[0], -3));
			}

			# service ID is incremented for a new service
			$n = max($array);
			$n = $n + 1;
			$n = (string)$n;

			if (strlen($n) == 1) {
				$IDservice = "ACC00".$n;
			}
			elseif (strlen($n) == 2) {
				$IDservice = "ACC0".$n;
			}
			elseif (strlen($n) == 3) {
				$IDservice = "ACC".$n;
			}

			$query2 = "INSERT INTO service_accueil VALUES (\"".$IDservice."\",\"".$service_name."\")";
			$result2 = Query($query2);
			WriteUserLog("$date : création du service $service_name \r\n"); 
			WriteInterventionLog("$date : création du service $service_name \r\n", $IDservice);

		} catch (Exception $e) { # Error of Query()
			echo $e -> getMessage();
		}
	}
}


# AddUser() creates a user using given parameters
	# Array array_user : array('info' => 'value')
# Returns nothing
function AddUser($array_user){
	try {
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

	} catch(Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# AllBooked() checks if all creneau for a halfDay are booked
	# String ID_service_int
# Returns boolean : True if all creneau are booked ; False if not
function AllBooked($ID_service_int) {
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


# ChangeWindow creates creneaux of given minutes
function ChangeWindow($minutes){
		#déclaration des variables 
	$jour_semaine = array("lundi"=>"LU", "mardi"=>"MA", "mercredi"=>"ME", "jeudi"=>"JE", "vendredi"=>"VE");
	try{
		$r = "TRUNCATE TABLE creneau"; 
		$q = Query($r); 

		$date = date("Y-m-d");
		$day = strtotime($date); 
		while ($day < strtotime("2018-02-01")){
			$jour = dateName($date); 
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


# CheckID() : Check if user is in the user database
	# String ID : username
	# String mdp : password
# Returns Array : array('ID' => a, 'right' => b) a and b empty is user not found
function CheckID($ID, $password) {
	try {
		$query = "SELECT ID_personnel, MDP FROM personnel"; 
		$result = Query($query);
		$ID_PW_array = [];			
		while ($nuplet = mysqli_fetch_array($result)) {
			array_push($ID_PW_array, $nuplet[0],$nuplet[1]);
		}
		# array form : array('0' => 'value0', 'key0' => 'value0', '1' => 'value1', 'key1' => 'value1', ...)

		$i = 0 ; 
		$user_array = array('ID' => '', 'right'=>'');
		while ($i < count($ID_PW_array)) {
			if ($ID_PW_array[$i] == $ID && $ID_PW_array[$i+1] == $password){ # If ID ok, then get user right
				$query2 = "SELECT droit FROM personnel WHERE ID_personnel=\"".$ID."\"" ; 
				$result2 = Query($query2);
				$row = mysqli_fetch_array($result2);

				$user_array= array('ID' => $ID, 'right' => $row[0]); 
			}
			$i = $i + 2;
		}
		return($user_array);
	} catch (Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
} 


# CheckNU()= when patient emergencyLevel isn't correct looking at default given by  pathology, this is writen in a file
	# Array patient_array : array('info' => 'value')
# Returns nothing
function CheckNU($patient_array) {
	$date = date("d/m/Y H:i");

	try{
		$ssNumber = $patient_array['ssNumber']; 
		$pathology = $patient_array['pathology'];
		$real_EL = $patient_array['emergencyLevel']; 	

		$query = "SELECT NU_defaut FROM pathologie WHERE pathologie = \"$pathology\"";
		$results = Query($query);

		$default_EL = mysqli_fetch_array($results)[0];
		# we detect only if given EL is not default_EL +/- 1
		if (($default_EL - 1) != $real_EL 
			AND $default_EL != $real_EL  
			AND ($default_EL + 1) != $real_EL){ 
			if ($f = fopen("VerifNU.txt", "a")){
				fwrite($f, "$date : $ssNumber a un $pathology avec NU = $real_EL (defaut : $default_EL)\r\n"); 
				fclose($f); 
			}
		}
	} catch (Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# CheckSurbooking() : check if in the current halfday, there are more than the authorised number of creneau for an intervention service
	# String ID_service_int : intervention service ID
# Returns boolean : True if there's a surbooking ; False if no
function CheckSurbooking($ID_service_int) {
	$heure = date("H:i:s");

	try{
		#get number of creneau for service
		$r = "SELECT nb_creneaux FROM service_intervention WHERE ID_service_int = \"$ID_service_int\"";
		$q = Query($r); 
		$nb_creneaux = mysqli_fetch_array($q)[0];
 
		if ($heure < "12:30:00"){
			# get morning creneau 
			$r_nbcreneaux = "SELECT ID_creneau, COUNT(ID_creneau) FROM planning NATURAL JOIN creneau WHERE ID_service_int = \"$ID_service_int\" AND jour = CURRENT_DATE() AND heure BETWEEN \"8:00:00\" AND \"12:30:00\" GROUP BY ID_creneau"; 
		} 
		elseif ("12:30:00" < $heure){
			# get afternoon creneau 
			$r_nbcreneaux = "SELECT ID_creneau, COUNT(ID_creneau)  FROM planning NATURAL JOIN creneau WHERE ID_service_int = \"$ID_service_int\" AND jour = CURRENT_DATE() AND heure BETWEEN \"13:00:00\" AND \"18:00:00\" GROUP BY ID_creneau"; 
		}

		$q_nbcreneaux = Query($r_nbcreneaux); 
		$array_nb = []; 
		while ($nuplet = mysqli_fetch_array($q_nbcreneaux)) {
			array_push($array_nb, $nuplet[0], $nuplet[1]);
		}

		$i=0; 
		$surbooking = False;
		while ($i < count($array_nb)) {
			if ($array_nb[$i+1] > $nb_creneaux){
				$surbooking = True;
			} 
			$i = $i +2; 
		}
		return($surbooking);
	} catch (Exception $e) { # Error of Query()
		echo "Pas de surbooking";
	}
}  


# CheckUID() checks if the user is connected, meaning he has a UID
# if not he is redirected to login
# Return : Nothing
function CheckUID() {
	if (!isset($_SESSION['uid'])) {
		header('Location: ./login.php');
	}
}


function dateName($date) {
	$jour_semaine = array(1=>"lundi", 2=>"mardi", 3=>"mercredi", 4=>"jeudi", 5=>"vendredi", 6=>"samedi", 7=>"dimanche");
	$array = explode ("-", $date);
	$timestamp = mktime(0,0,0, date($array[1]), date($array[2]), date($array[0]));
	$njour = date("N",$timestamp);
	return $jour_semaine[$njour];
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


# DeleteIntervention() : delete intervention in DB using given paramaters
	# String ID_creneau_service : 'ID_creneau ID_service', to explode
# Returns nothing
function DeleteIntervention($ID_creneau_service) {
	$date = date("d/m/Y H:i");

	try {
		$pieces = explode(" ", $ID_creneau_service);
		$ID_service = $pieces[1]; 
		$ID_creneau = $pieces[0];

		$r="DELETE from planning WHERE ID_service_int=\"$ID_service\" AND ID_creneau = \"$ID_creneau\"";
		$q=Query($r);

		WriteUserLog("$date : Suppression de l'intervention du service $ID_service pour $ID_creneau \r\n");
		WriteInterventionLog("$date : Suppression de l'intervention du creneau $ID_creneau \r\n", $ID_service);

	} catch (Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# DeletePatient() : Delete the patient using his ssNumber
	# String ssNumber : patient ssNumber
# Returns nothing
function DeletePatient($numSecu) {
	$date = date("d/m/Y H:i");

	try {
		$query= "DELETE from patient WHERE num_secu=\"$numSecu\"";
		$result=Query($query);
		WriteUserLog("$date : suppression du patient ($numSecu) \r\n");
	} catch (Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# DeleteService(): delete the given service
	# String ID_service : service ID in the DB
	# String type : 'accueil' or 'intervention'
# Returns nothing
function DeleteService($ID_service, $type) {
	$date = date("d/m/Y H:i");

	try {
		if ($type == "service") {
			$query = "DELETE from service_intervention WHERE ID_service_int=\"$ID_service\"";
			$result = Query($query);
			WriteUserLog("$date : suppression du service d'intervention $ID_service \r\n"); 
			WriteInterventionLog("$date : suppression du service d'intervention $ID_service \r\n", $ID_service);
		}
		elseif ($type == "accueil") {
			$query = "DELETE from service_accueil WHERE ID_service_acc =\"$ID_service\"";
			$result = Query($query);
			WriteUserLog("$date : suppression du service d'accueil $ID_service \r\n"); 
			WriteInterventionLog("$date : suppression du service d'accueil $ID_service \r\n", $ID_service); 
		}
	} catch (Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# DeleteUser() delete a user using its ID 
	# String UID : user ID
# Returns nothing
function DeleteUser($UID){
	try {
		$r =  "DELETE FROM personnel WHERE ID_personnel=\"$UID\""; 
		$q = Query($r); 
	} catch(Exception $e) { # Error of Query() 
		echo $e -> getMessage();
	}
}


# Emergency() : create an intervention in the next creneau
	# String ssNumber : can be '' in case of emergency without patient
function Emergency($ssNumber, $service) {
	$jour = date("Y-m-d");
	$heure = date("H:i:s"); 
	$date = date("d/m/Y H:i");

	try{
		# Select next creneau
		$query = "SELECT ID_creneau FROM creneau WHERE jour = \"$jour\" AND heure > \"$heure\"" ;
		$result = Query($query);
		$row = mysqli_fetch_array($result); 

		AddIntervention($service, $row[0], $_SESSION['uid'], $ssNumber); 

		WriteUserLog("$date : ajout de l'urgence du patient $ssNumber pour intervention dans $service au créneau $row[0] \r\n"); 
		WriteInterventionLog("$date : ajout de l'urgence $row[0] pour le patient $ssNumber \r\n", $service); 
	} catch (Exception $e){ # Error of Query()
		echo "L'urgence n'a pas été ajouté. Veuillez vérifier qu’il n’est pas trop tôt ou trop tard dans la journée ou contacter le service technique.";
	}
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


# FactureIntervention() : facture an intervention (set facture to 1 in the intervention entry in the DB)
	# String creneau_ssNumber : 'IDcreneau ssNumber', to explode
# 
function FactureIntervention($creneau_ssNumber) {
	$date = date("d/m/Y H:i");

	try {
		$pieces = explode(" ", $creneau_ssNumber);
		$creneau = $pieces[0];
		$ssNumber = $pieces[1];

		$query = "UPDATE planning SET facture = 1 WHERE ID_service_int = \"".$_SESSION['service']."\" AND ID_creneau = \"$creneau \" AND num_secu=\"$ssNumber\""; 
		$result = Query($query);
		WriteUserLog("$date : facturation  de l'intervention $creneau du patient $ssNumber \r\n"); 
		WriteInterventionLog("$date : facturation  de l'intervention $creneau du patient $ssNumber \r\n", $_SESSION['service']); 
	} catch (Exception $e){ # Error of Query()
		echo $e -> getMessage();
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


# PatientUnknown() : check if patient in DB
	# Array patient_array : array('info' => 'value')
# Returns boolean : True if Patient is unknown ; False if known
function PatientUnknown($patient_array) {
	try{
		$ssNumber = $patient_array['ssNumber']; 

		$query = "SELECT num_secu FROM patient" ; 
		$result = Query($query);
		$array = [];
		while ($nuplet = mysqli_fetch_array($result)){
			array_push($array, $nuplet[0]);
		}

		$patient_unknown = True;

		if (in_array("$ssNumber",$array)){
			$patient_unknown = False;
		}

		return($patient_unknown); 

	} catch (Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# PrintArchive() : print service or user history
	# String filename
# Returns nothing
function PrintArchive($filename) {
	if (!file_exists($filename)){
		print("Pas d'historique disponible <br> \n"); 
	}
	else {
		$f = fopen($filename, "r"); 
		$line = fgets($f); 
		print('<ul>'); 

		while (!empty($line)) {
			print("<li>" . $line . "</li>"."\n"); 
			$line = fgets($f);
		}
		print("</ul>\n");

		fclose($f);
	}
}

# PrintFreeTime() : prints out 5 free time, obtained from SearchFreeTime
	# Array freetime_array : array('0' => 'ID_creneau', '1' => 'service_int', '2' = 'ID_creneau', '3' => 'service_int')
	# String or Int EL
# Returns nothing
function PrintFreeTime ($freetime_array, $EL) {	
	$EL = (int) $EL;

	# array divided every 5 creneau
	$new = array_chunk($freetime_array, 10);
	
	# calc which division of previous array we want, using EL
	$n= (10 - $EL) * 2;  

	$array_creneau = $new[$n]; 

	# get interventions corresponding to ID_creneau service_int tuples
	$result = ReturnIntervention($array_creneau); 
	$i = 0;
		while($i < count($result))
		{
			echo("<input type=\"radio\" name=\"value\" value=\"".$result[$i+1]."\" id =\"case\"> ");
			echo("<label for= \"case\"> ".$result[$i]."\n</label><br><br>");
			$i = $i+2;
		}
}


# PrintFooter() prints out all footer infos
# Return nothing
function PrintFooter() {
	echo '<div id="footer"> 2017 - projet HTML/CSS/PHP <br>';
	Debugage();
	echo 'Benoit Baillif - Solène Guiglion - Léa Wadbled</div>';
}


# PrintHeader() prints out all menu links
# Return nothing
function PrintHeader() {
	echo '<a href="./index.php" class="lien">Menu principal</a><br>' . "\n";
	echo '<a href="./?action=searchMail" class="lien">Rechercher adresse mail</a><br>'. "\n";
	echo '<a href="./login.php?action=logout" class="lien">Deconnexion</a><br>'. "\n";
}


# PrintSchedule prints out the schedule for the given service
	# String service : intervention service
# Return Nothing
function PrintSchedule($service) {
	$date = date("Y-m-d");
	$query1 = 'SELECT personne.nom, prenom, jour, heure, service_intervention.nom, mail FROM ((creneau NATURAL JOIN planning NATURAL JOIN personne) JOIN personnel ON planning.ID_personnel = personnel.ID_personnel) JOIN service_intervention ON planning.ID_service_int = service_intervention.ID_service_int WHERE jour = "' . $date . '" AND planning.ID_service_int = "' . $service . '"';
	echo "<br><br>";
	echo "<h2>Interventions du jour</h2>";
	try {
		$results = Query($query1);
		echo "<table>";
		echo "<tr>";
		echo "<th>Nom</th>";
		echo "<th>Prénom</th>";
		echo "<th>Jour</th>";
		echo "<th>Heure</th>";
		echo "<th>Service d'intervention</th>";
		echo "<th>Mail du médecin</th>";
		echo "</tr>";
		while($nuplet = mysqli_fetch_array($results)) {
			echo "<tr>";
			$i = 0;
			while ($i < 6) {
				echo '<td>' . $nuplet[$i] . '</td>' ;
				$i = $i + 1;
			}
			echo "</tr>";
		}
		echo "</table>";
	} catch (Exception $e){
			#Si erreur de la fonction Query() 
		echo $e -> getMessage();
	}
}


# Query() : execute the given query
	# String query : SQL query
# Returns mysqli lines or boolean, depending of the type of query
function Query($query) {
	# DB IDs must be changed to adapted to laptop
	$SQL_username = 'root';
	$SQL_password = '1711alphaben1995';
	$SQL_database = 'hopital';
	$SQL_connexion = mysqli_connect('localhost', $SQL_username, $SQL_password, $SQL_database);

	if (mysqli_connect_errno()){ 
		throw new Exception("<p>Impossible de se connecter à la base de données. Merci de contacter le service technique.</p>"); 
	}

	$query_result = mysqli_query($SQL_connexion,$query);

	if (gettype($query_result) != "boolean"){ # If query returns lines (SELECT)
		if (mysqli_num_rows($query_result) == 0){ 
			throw new Exception("<p>Aucun résultat ne correspond à votre recherche. </p>"); 
		}
	} 
	else { # If query returns boolean (UPDATE, DELETE)
		if ($query_result == False){ # If error of query
			throw new Exception("<p>Impossible d'executer la requête. Merci de contacter le service technique.</p>"); 
		}
	}

	mysqli_close($SQL_connexion);
	return ($query_result);
}


# ReturnIntervention() : returns interventions for given parameters
	# Array result_search : array('0' => 'IDcreneau', '1' => 'ID_service_intervention', '2' => 'IDcreneau2', ...)
# Returns Array : array('0' = > 'sentence for intervention', '1' => 'IDcreneau ID_service_intervention',, ...)
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
	} catch(Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# ReturnName() : return names of personnel
# Returns Array : array('0' => 'surname', '1' => 'name', '2' => 'ID_personnel', '3' => 'surname', ...)
function ReturnName () {
	try{
		$r = "SELECT nom, prenom, ID_personnel FROM personne NATURAL JOIN personnel"; 
		$q = Query($r); 

		$array = []; 
		while ($nuplet = mysqli_fetch_array($q)) {
			array_push($array, $nuplet[0],$nuplet[1],$nuplet[2]);
		}
		return($array); 
	} catch(Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# ReturnPathology() : returns all pathology
# Returns Array : array('0' => 'pathology', '1' => 'pathology', ...)
function ReturnPathology () {
	try {
		$r = "SELECT pathologie FROM pathologie"; 
		$q = Query($r); 

		$array = []; 
		while ($nuplet = mysqli_fetch_array($q)) {
			array_push($array, $nuplet[0]);
		}

		return($array); 
	} catch(Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# ReturnService() : returns services for a type
	# String type : 'accueil' or 'intervention'
# Returns Array : array('0' = > 'ID_service', '1' => 'service name', '2' => 'ID_service2', ...)
function ReturnService ($type) {
	try {
		if ($type == "intervention"){
			$r = "SELECT ID_service_int, nom FROM service_intervention"; 
		}

		elseif ($type == "accueil") {
			$r = "SELECT ID_service_acc, nom FROM service_accueil"; 
		}
		else {
			throw new Exception("<p>Type de service incorrect</p>"); 
		}
		$q = Query($r);
		$array = []; 
		while ($nuplet = mysqli_fetch_array($q)) {
			array_push($array, $nuplet[0], $nuplet[1]);
		}
		return($array);
	}catch(Exception $e){ # Error of Query()
		echo $e -> getMessage();
	}
}


# ReturnUsername returns name and surname of user
	# String ID_personnel
# Returns Array : array('surname' => 'value', 'name' => 'value')
function ReturnUsername($ID_personnel) {
	$query = 'SELECT nom, prenom FROM personnel NATURAL JOIN personne WHERE ID_personnel = "' . $ID_personnel . '"';
	$results = Query($query);

	$array = [];
	while ($nuplet = mysqli_fetch_array($results)) {
		$array['surname'] = $nuplet[0];
		$array['name'] = $nuplet[1];
	}
	return $array;
}


# SearchDay() : get interventions info for a halfday
	# String date
	# String halfDay : 'morning' or 'afternoon'
# Returns appointments_array : array('0' => array('info' => 'value'), '1' => ...)
function SearchDay($date,$halfDay) {
	try{
		$attributes = array('service_intervention.nom', 'personne.nom', 'prenom', 'planning.num_secu', 'mail', 'jour', 'heure');
		#Attributes must be in comprehensive order to print further
		$query = 'SELECT ';

		foreach ($attributes as $key => $attribute) {
			#Comma between each attribute, except the first one
			if ($key != 0) {
				$query = $query . ", ";
			}
			$query = $query . $attribute;
		}

		$query = $query . ' FROM ((creneau NATURAL JOIN planning NATURAL JOIN personne) JOIN personnel ON personnel.ID_personnel = planning.ID_personnel) JOIN service_intervention ON planning.ID_service_int = service_intervention.ID_service_int WHERE jour = "' . $date . '" AND heure BETWEEN ';

		if ($halfDay == "morning"){
			$query = $query . '"08:30:00" AND "12:00:00"';
		} 
		elseif ($halfDay == "afternoon") {
			$query = $query . '"13:30:00" AND "17:30:00"';
		}
		else {
			throw new Exception("<p>Demi-journée incorrecte</p>"); 
		}

		$results = Query($query);

		$appointments_array = [];
		$line = 0;
		while ($nuplet = mysqli_fetch_array($results)) {
			$appointments_array[$line] = [];
			foreach ($attributes as $key => $attribute) {
				$appointments_array[$line][$attribute] = $nuplet[$key];
			}
			$line = $line + 1;
		}
		return($appointments_array);
	} catch (Exception $e){
		echo $e -> getMessage();
	}
}


# SearchEmail() : search email using user ID
	# String user_ID
# Returns nothing
function SearchEmail($user_ID) {
	try {
		$query = "SELECT mail FROM personnel NATURAL JOIN personne WHERE ID_personnel=\"$user_ID\"";
		$result = Query($query); 

		# We consider 1 ID = 1 mail, so this will only print one mail address
		while ($nuplet = mysqli_fetch_array($result)) {
			echo ($nuplet[0]);
		}
	} catch (Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# SearchFreeTime() : returns free creneau for a given intervention service
	# String service_int
# Returns Array : array('0' => 'ID_creneau', '1' => 'service_int', '2' = 'ID_creneau', '3' => 'service_int')
function SearchFreeTime($service_int) {
	try {
		$query = "SELECT ID_creneau, COUNT(ID_creneau) FROM creneau WHERE ID_creneau IN (SELECT ID_creneau FROM planning WHERE ID_service_int = \"$service_int\") GROUP BY ID_creneau"; 
		$result = Query($query); 
		$creneau_count_array=[];
		while ($nuplet = mysqli_fetch_array($result)) {
			array_push($creneau_count_array, $nuplet[0],$nuplet[1]);
		}

		# get number of creneau taken by intervention service
		$query2 = "SELECT nb_creneaux FROM service_intervention WHERE ID_service_int = \"$service_int\"";
		$result2 = Query($query2); 
		$nb_creneaux = mysqli_fetch_array($result2)[0];

		$i=0; $notFree = "("; 
		while ($i < count($creneau_count_array)) {
			if ($creneau_count_array[$i+1] >= $nb_creneaux){
				$notFree = $notFree."\"" . $creneau_count_array[$i] . "\","; 
			} 
			$i = $i +2; 
		}
		$notFree = $notFree."\"\")";

		# Search all creneau not full
		$r3 = "SELECT ID_creneau FROM creneau WHERE ID_creneau NOT IN $notFree AND jour > CURRENT_DATE() ORDER BY jour, heure" ; ; 
		$q3 = Query($r3);
		$array = []; 			
		while ($nuplet = mysqli_fetch_array($q3)) {
			array_push($array, $nuplet[0], $service_int);
		}
		return($array); 
	} catch (Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# SearchIntervention() : search intervention given parameters
	# Array info_inter : array('startingDate' => 'value', 'endingDate' => 'value', 'ssNumber' => 'value') where value can be ''
	# String facturation : 'F' if we want factured interventions ; 'NF' if non factured one ; all intervention if other value
	# String inter_service
	# String personnel_ID
# Returns Array : array('0' => 'info_array intervention0', '1' => 'info_array intervention1', ...)
function SearchIntervention($info_inter, $facturation, $inter_service, $personnel_ID) {
	$r1 = ""; 
	$r2 = "";
	try {
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
			$r = $r . 'num_secu = "" AND ';
		}

		if (!empty($info_inter['startingDate'])) {
			if (!empty($info_inter['endingDate'])){
				$r2 = "jour BETWEEN (\"".$info_inter['startingDate']."\"AND \"".$info_inter['endingDate']."\")";
			}
			else {
				$r2 = "jour > \"".$info_inter['startingDate']."\"";
			}
		}

		elseif (empty($info_inter['startingDate'])) {
			if (!empty($info_inter['endingDate'])) {
				$r2 = "jour BETWEEN (CURRENT_DATE() AND \"".$info_inter['endingDate']."\")";
			}
			else {
				$r2 = "jour = CURRENT_DATE()";
			}
		}

		#concatenate
		if($r2 != ""){
			$r = $r . $r2;
		}
		else {
			if ($facturation == "NF" OR $facturation == "F") {
				$r = $r . "AND jour <= CURRENT_DATE()";
			}
			else {
				# Do nothing
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

	} catch (Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# SearchPatient() : search a patient in DB
	# Array patient_array : array('info' => 'value')
# Return Array : array('0' => 'info_array patient 0', '1' => 'info_array patient 1', ...)
function SearchPatient($patient_array) {
	try{
		# array for SQL attributes
		$arraySQL = array('num_secu', 'nom', 'prenom', 'sexe', 'date_naiss', 'pathologie', 'NU'); 
		$array_patient = array($patient_array['ssNumber'],
			$patient_array['surname'],
			$patient_array['name'],
			$patient_array['gender'],
			$patient_array['birthday'],
			$patient_array['pathology'],
			$patient_array['emergencyLevel']);

		$query = "SELECT * FROM patient NATURAL JOIN personne WHERE "; 

		$i = 0; 
		while ($i < count($arraySQL)) {
			if (!empty($array_patient[$i])) {
				$new_arraySQL[] = $arraySQL[$i]; 
				$new_array_patient[] = $array_patient[$i];
			}
			$i += 1; 
		}

		$query = $query . $new_arraySQL[0]." = \"" . $new_array_patient[0] . "\""; 
		$j = 1;
		while ($j < count($new_array_patient)) {
			$query = $query . " AND ".$new_arraySQL[$j] . " = \"".$new_array_patient[$j]."\""; 
			$j = $j +1; 
		}

			#On considère qu'il y a eu moins une info dans $array
			#On recherche les infos patients 
		$q = Query($query);
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

	}catch (Exception $e){ # Error of Query()
		echo $e -> getMessage();
	}
}


# UpdatedUL() : update patient EL depending on time remaining till next intervention 
	# String ssNumber
	# Int EL : current emergency level
# Returns Int new_EL : EL corrected with time
function UpdatedUL($ssNumber, $EL) {		
	try {
		# To know the time remaining till next intervention
		$r = "SELECT DATEDIFF(CURRENT_DATE(),jour) FROM planning NATURAL JOIN creneau WHERE num_secu = \"$ssNumber\" ORDER BY jour, heure";
		$q = Query($r); 
		$row = mysqli_fetch_array($q); 
		$duree = $row[0]; 

		$update = $duree / 10; 
		$new_EL = $EL + $update;
		$new_EL = round($new_EL);
		if ($new_EL > 10){ # max of EL is 10
			$new_EL = 10;
		}
		return($new_EL); 
	} catch (Exception $e) {
			#Si il y a une erreur de query
		echo $e -> getMessage();
	}
}


# UpdatePatient() : update patient data in the DB
	# Array patient_array : array('info' => 'value')
# Returns nothing
function UpdatePatient ($patient_array) {
	$date = date("d/m/Y H:i");
	$ssNumber = $patient_array['ssNumber'];

	try {
		if (PatientUnknown($patient_array)) {
			throw new Exception("Le patient n'existe pas");
		}

		$pathology = $patient_array['pathology'];
		$EL = $patient_array['emergencyLevel']; 
		$query_patient = "UPDATE patient SET pathologie = \"$pathology\", NU = \"$EL\" WHERE num_secu = \"$ssNumber\"";
		$_SESSION['query_patient'] = $query_patient;
		$result = Query($query_patient); 

		CheckNU($patient_array);

		WriteUserLog("$date : update du patient $ssNumber \r\n");
	} catch (Exception $e){ # Error of Query() or PatientUnkown()
		echo $e -> getMessage();
	}
}


# WhichService() : return service from userID
	# String UID : userID
	# String type : 'intervention' or 'accueil'
# Returns String ID_service
function WhichService($UID, $type) {
	try {
		if ($type == 'intervention') {
			$r = "SELECT ID_service_int, nom FROM respo_intervention NATURAL JOIN service_intervention WHERE ID_personnel = \"$UID\""; 
		}
		elseif ($type == 'accueil') {
			$r = "SELECT ID_service_acc, nom FROM medecin NATURAL JOIN service_accueil WHERE ID_personnel = \"$UID\""; 
		}
		$q = Query($r); 

		$row = mysqli_fetch_array($q);  

		return($row); 
	} catch(Exception $e) { # Error of Query()
		echo $e -> getMessage();
	}
}


# WriteInterventionLog() : Write intervention activity in a intervention specific file
	# String log : string to write in the file
# Returns nothing
function WriteInterventionLog($log, $service) {
	if ($f = fopen("$service.txt", "a")){ # If file doesn't exist, create it
		fwrite($f, $log); 
		fclose($f); 
	}
}


# WriteUserLog() : Write user activity in a personal file
	# String log : string to write in the file
# Returns nothing
# Uses $_SESSION['uid'] : User ID
function WriteUserLog($log) {
	$user = $_SESSION['uid']; 
		
	if ($f = fopen("$user.txt", "a")){
		fwrite($f, $log); 
		fclose($f); 
	}
} 

