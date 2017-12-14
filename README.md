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

Modifications du 9/12/2017 :
- searchMail renommé en searchUser et resultsSearchMail renommé en resultsUser, car il sert aussi à trouver l'historique de l'utilisateur en question
- lignes pour l'accès à la recherche de mail bougé de fonctionsBen.PrintHeader à la page index.php
- squelette du site terminé
- fusion des 2 fichiers de fonctions
- TODO : 
	-fonctions SearchInterventionNF qui retoure les intervetions non facturées (ou trouver une autre solution)
	- comment ajouter et supprimer facilement les services d'intervention/accueil
	- configurer la recherche de mail ou historique avec ID d'utilisateur
- premier tests sur cas classique :
	- NU ne marche pas quand on ajoute un patient

Modifications du 10/12/2017:
- correction de recherche adresse mail qui ne marchait plus 
- correction le NU marche quand on ajoute un patient ! 
- traduction du créneau en jour/date par la fonction ReturnIntervention() 
- changement dans printResult() while au lieu d'un foreach ; changement dans DeleteIntervention (on prend en entrée une chaine "ID_service ID_inter") 
- changement de SearchInterventionF() en SearchIntervention_Facture qui renvoie soit les interventions facturées soit les interventions non-facturées
- écriture de ReturnInterventionNF() 
- modification de FactureIntervention : ne prend plus le service en entrée (on va le chercher dans $_Session) et prend une chaine en entrée $_POST[value]
- suppression du fichier logUser puisque on affiche l'historique dans le fichier resultUser.php
- création de la fonctionnalité : voir l'historique pour les services (création du fichier searchService.php et archiveService.php) 
- modification de l'apparence du site (il se peut qu'il y ait des $_Session['action']='' qui manquent ou soient mis en trop :/)

Tests = 
- rechercher patient : rien ne marche 
- créer intervention ne marche pas non plus 
- aucun emergency ne marche pas 
- modifier intervention ne marche pas non plus 

Ce qui marche : 
> Médecin 
- ajout d'un patient (MAIS ne renvoie pas d'erreur si vide, même si ajoute pas)
- supprimer une intervention 
- voir intervention facturée 

> Respo 
- facturer une intervention 

> Admin 
- tout marche = ajout intervention, suppression intervention, historique du personnel et des services et verif NU 

Modification Solène du 11/12/17: 
-Creation fonction returnPatient
-Modifier & suppimer patient OK 

Modification Benoit du 11/12 : 
- OK modif 1/2 journée 

Modifications Léa du 12/12 (matin) : 
- création des deux fonctions : changeWindow (pour changer la taille des créneaux de l'emploi-du-temps) et nom_jour (pour donner à une date son jour de la semaine) ; 
- modification de printFreeTime et searchFreeTime ; 
- fonctionnalité créer intervention : ça marche maintenant 
- tout marche parfaitement pour le médecin (commit 'all ok pour les fonctions du médecin")

Modifications Benoit 12/12 (aprem/ debut de soirée) :
- renommer EmptyPOST en EmptyValuePOST
- renommer CheckPatient en PatientUnknown
- remaniement de certaines fonctions utilisant des i / i+=1
- suppression de PrintResults, sa fonction est assurée dans chacune des pages HTML (trop de risques de s'embrouiller sinon)
- fusion des fonctions SearchIntervention
- suppression de ReturnInterventionNF, la selection de la NF s'effectue dans le SearchIntervention
- ajout des commentaires avant les fonctions, pour identifier plus clairement leur rôle (entrée, sortie)

Modifications du 13/12 : 
- push 1 : arrangement de toutes les fonctions médecins (reste à faire des boucles pour les sélections). 
- modif de la fonction Emergency pour ne pas qu'elle affiche l'erreur de Query ; 
> ajout des autres fonctionnalités à l'administrateur : ajouter/retirer des interventions ; ajouter patients ; ajout/suppression d'utilisateur. 
- push 2 = présence de boucle partout ; fonctionnalités médecins/respo/admin marchent toutes (toutes testées!!) 

MANQUE ENCORE (par rapport aux spécifications) : 
> tableau de l'EDT (responsables)
> modification du NU d'urgence par rapport à son intervention (médecin)
> on a des créneaux de 30 minutes, il faudrait pouvoir gérer que des interventions soient moins de 30 minutes... 
> gérer le surbooking (utiliser la table surbooking) 
> est-ce qu'on gére ajouter des informations sur un patient arrivé en urgence (sans patient?)

Modifications du 14/12 : 
- ajout du nombre de créneaux 
"ALTER TABLE service_intervention ADD nb_creneaux INT(1)"
UPDATE service_intervention SET nb_creneaux=2 WHERE nom='radiologie'
UPDATE service_intervention SET nb_creneaux=1 WHERE nom='IRM'
UPDATE service_intervention SET nb_creneaux=3 WHERE nom='laboratoire'
UPDATE service_intervention SET nb_creneaux=1 WHERE nom='opération'
- modifications de SearchFreeTime => prend en compte le nombre de créneaux maintenant
- modifications de CheckSurbooking => prend en compte le nombre de créneaux maintenant
- écriture de gérer le surbooking mais ça ne marche pas :( 
- mettre à jour le NU : ok !

> à finir : EDT et checksurbooking  

Modifications du 14/12 soirée (Ben) : 
- Affichage de tableau pour les interventions
- Urgence sans patient génère une intervention avec un patient sans num_secu.
Dans ma BDD, j'ai mis une personne avec comme nom Inconnu et prenom Inconnu associé à ce numéro d'urgence
- Si on refait urgence sans patient alors qu'on a déjà un patient inconnu à ce créneau, ça ne créé pas d'autre urgence, le chef d'intervetion doit d'abord associer un patient.
-Surbooking OK 