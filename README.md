# projetPHP
Projet PHP Polytech

A modifier par rapport au dossier du 8 Novembre :
CheckID : renvoie un array contenant l'ID_personnel et le droit

Modification du 5/12/2017 : 
- modification de login.php : on utilise maintenant CheckID() 
- modification de la fonction CheckID() = on enl�ve l'erreur pour quand mauvais pswd/username
- modification de la fonction CheckID() = on enl�ve le writeUserLog et on le met dans la page login.php
- modification de index.php : changement des droits 'doctor', 'responsible', 'admin' deviennent (1,2,0) comme la BDD
- modification de index.php : correction "intervetion" en "intervention" 

Modification du 7/12/2017 : 
- Cr�er la page searchMail.php : fait un formulaire avec les noms du personnel 
- Cr�er la fonction ReturnName : qui retourne les noms du personnel
- Cr�er la page resultsSearchMail.php : qui print l'adresse mail 
- Ecriture de la fonction SearchInterventionF : qui retourne les interventions factur�es 
- Rajout d'un type "list" dans la fonction printResults 
- Ecriture d'une fonction WhichService : pour savoir de quel service est le responsable connect�
- Modification du formulaire patient (ajout de maxlength pour le num�ro social, de max pour le NU, d'un menu d�roulant pour le sexe et la pathologie) 
- Ecriture de la fonction ReturnPathology : qui retourne les pathologies 

Remarque : dans resultsIntervention.php : il faut "traduire" le cr�neau de l'intervention en jour/date
Remarque : pour recherche intervention le num�ro de s�cu n'est pas pris en compte 

Modifications du 9/12/2017 :
- searchMail renomm� en searchUser et resultsSearchMail renomm� en resultsUser, car il sert aussi � trouver l'historique de l'utilisateur en question
- lignes pour l'acc�s � la recherche de mail boug� de fonctionsBen.PrintHeader � la page index.php
- squelette du site termin�
- fusion des 2 fichiers de fonctions
- TODO : 
	-fonctions SearchInterventionNF qui retoure les intervetions non factur�es (ou trouver une autre solution)
	- comment ajouter et supprimer facilement les services d'intervention/accueil
	- configurer la recherche de mail ou historique avec ID d'utilisateur
- premier tests sur cas classique :
	- NU ne marche pas quand on ajoute un patient

Modifications du 10/12/2017:
- correction de recherche adresse mail qui ne marchait plus 
- correction le NU marche quand on ajoute un patient ! 
- traduction du cr�neau en jour/date par la fonction ReturnIntervention() 
- changement dans printResult() while au lieu d'un foreach ; changement dans DeleteIntervention (on prend en entr�e une chaine "ID_service ID_inter") 
- changement de SearchInterventionF() en SearchIntervention_Facture qui renvoie soit les interventions factur�es soit les interventions non-factur�es
- �criture de ReturnInterventionNF() 
- modification de FactureIntervention : ne prend plus le service en entr�e (on va le chercher dans $_Session) et prend une chaine en entr�e $_POST[value]
- suppression du fichier logUser puisque on affiche l'historique dans le fichier resultUser.php
- cr�ation de la fonctionnalit� : voir l'historique pour les services (cr�ation du fichier searchService.php et archiveService.php) 
- modification de l'apparence du site (il se peut qu'il y ait des $_Session['action']='' qui manquent ou soient mis en trop :/)

Tests = 
- rechercher patient : rien ne marche 
- cr�er intervention ne marche pas non plus 
- aucun emergency ne marche pas 
- modifier intervention ne marche pas non plus 

Ce qui marche : 
> M�decin 
- ajout d'un patient (MAIS ne renvoie pas d'erreur si vide, m�me si ajoute pas)
- supprimer une intervention 
- voir intervention factur�e 

> Respo 
- facturer une intervention 

> Admin 
- tout marche = ajout intervention, suppression intervention, historique du personnel et des services et verif NU 

Modification Sol�ne du 11/12/17: 
-Creation fonction returnPatient
-Modifier & suppimer patient OK 

Modification Benoit du 11/12 : 
- OK modif 1/2 journ�e 

Modifications L�a du 12/12 (matin) : 
- cr�ation des deux fonctions : changeWindow (pour changer la taille des cr�neaux de l'emploi-du-temps) et nom_jour (pour donner � une date son jour de la semaine) ; 
- modification de printFreeTime et searchFreeTime ; 
- fonctionnalit� cr�er intervention : �a marche maintenant 
- tout marche parfaitement pour le m�decin (commit 'all ok pour les fonctions du m�decin")

Modifications Benoit 12/12 (aprem/ debut de soir�e) :
- renommer EmptyPOST en EmptyValuePOST
- renommer CheckPatient en PatientUnknown
- remaniement de certaines fonctions utilisant des i / i+=1
- suppression de PrintResults, sa fonction est assur�e dans chacune des pages HTML (trop de risques de s'embrouiller sinon)
- fusion des fonctions SearchIntervention
- suppression de ReturnInterventionNF, la selection de la NF s'effectue dans le SearchIntervention
- ajout des commentaires avant les fonctions, pour identifier plus clairement leur r�le (entr�e, sortie)

Modifications du 13/12 : 
- push 1 : arrangement de toutes les fonctions m�decins (reste � faire des boucles pour les s�lections). 