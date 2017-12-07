# projetPHP
Projet PHP Polytech

A modifier par rapport au dossier du 8 Novembre :
CheckID : renvoie un array contenant l'ID_personnel et le droit

Modification du 5/12/2017 : 
- modification de login.php : on utilise maintenant CheckID() 
- modification de la fonction CheckID() = on enlève l'erreur pour quand mauvais pswd/username
- modification de la fonction CheckID() = on enlève le writeUserLog et on le met dans la page login.php
- modification de index.php : changement des droits 'doctor', 'responsible', 'admin' deviennent (1,2,0) comme la BDD
- modification de index.php : correction "intervetion" en "intervention" 

Modification du 7/12/2017 : 
- Créer la page searchMail.php : fait un formulaire avec les noms du personnel 
- Créer la fonction ReturnName : qui retourne les noms du personnel
- Créer la page resultsSearchMail.php : qui print l'adresse mail 
- Ecriture de la fonction SearchInterventionF : qui retourne les interventions facturées 
- Rajout d'un type "list" dans la fonction printResults 
- Ecriture d'une fonction WhichService : pour savoir de quel service est le responsable connecté
- Modification du formulaire patient (ajout de maxlength pour le numéro social, de max pour le NU, d'un menu déroulant pour le sexe et la pathologie) 
- Ecriture de la fonction ReturnPathology : qui retourne les pathologies 

Remarque : dans resultsIntervention.php : il faut "traduire" le créneau de l'intervention en jour/date
Remarque : pour recherche intervention le numéro de sécu n'est pas pris en compte 
