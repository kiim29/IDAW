# Documentation de l'API REST
  
## Requêtes et Endpoints possibles : users.php
  
### GET /users.php  
— Paramètres : aucun  
— Résultat : retourne tous les utilisateurs de la base (JSON)  
  
### GET /users.php  
— Paramètres : le champ identifiant de l'utilisateur qui nous intéresse (login : string)  
— Résultat : retourne toutes les infos de l'utilisateur d'identifiant id (JSON)  
  
### POST /users.php  
— Paramètres : tous les champs de l’utilisateur à créer (nom : string, age : entier, sexe : entier, taille : flottant, poids : flottant, profil : entier) sauf le champ id qui sera automatique affecté par le serveur. Les champs login, nom, age, taille et poids doivent être spécifiés  
— Résultat : retourne le code de statut HTTP 201 (Created); le champ Location de l’en-tête HTTP doit contenir l’URL de la nouvelle ressource donc son identifiant (exemple : Location:"users.php?login=aa@bb.co"); et le corps de la réponse contient toutes les infos de l’utilisateur au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  
  
### PUT /users.php  
— Paramètres : tous les nouveaux champs de l’utilisateur à modifier (login : string, nom : string, age : entier, sexe : entier, taille : flottant, poids : flottant, profil : entier). L'identifiant ne peut être modifié. Si le nom ou d'autres champs ne changent pas il faut tout de même donner une valeur (identique à l'ancienne du coup). Les champs login, nom, age, taille et poids doivent être spécifiés  
— Résultat : retourne le code de statut HTTP 200 (OK) et le corps de la réponse contient toutes les anciennes et nouvelles infos sur l’utilisateur au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  
  
### DELETE /users.php  
— Paramètres : le champ identifiant de l'utilisateur à supprimer (login)  
— Résultat : retourne le code de statut HTTP 200 (OK) et le corps de la réponse contient toutes les anciennes infos sur l’utilisateur au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  


## Requêtes et Endpoints possibles : aliments.php
  
### GET /aliments.php  
— Paramètres : aucun  
— Résultat : retourne tous les aliments de la base (JSON)  
  
### GET /aliments.php  
— Paramètres : le champ identifiant de l'aliment qui nous intéresse (id_aliment : entier)  
— Résultat : retourne toutes les infos de l'aliment d'identifiant id_aliment (JSON)  
  
### GET /aliments.php  
— Paramètres : le champ identifiant d'un type d'aliment qui nous intéresse (id_type_aliment : entier)  
— Résultat : retourne toutes les infos de tous les aliments du type voulu (JSON)  
  
### POST /aliments.php  
— Paramètres : tous les champs de l’aliment à créer (nom : string, id_type_aliment : entier, calories : entier, glucides : flottant, sucres : flottant, lipides : flottant, acides_gras : flottant, proteines : flottant, sel : flottant) sauf le champ id_aliment qui sera automatique affecté par le serveur. Les champs id_aliment, nom, id_type_aliment doivent être spécifiés  
— Résultat : retourne le code de statut HTTP 201 (Created); le champ Location de la réponse HTTP contient l’URL de la nouvelle ressource donc son identifiant (exemple : Location:"aliments.php?id_aliment=3"); et le corps de la réponse contient aussi toutes les infos du nouvel aliment au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  
  
### PUT /aliments.php  
— Paramètres : tous les nouveaux champs de l'aliment à modifier (id_aliment, nom : string, id_type_aliment : entier, calories : entier, glucides : flottant, sucres : flottant, lipides : flottant, acides_gras : flottant, proteines : flottant, sel : flottant). Les champs id_aliment, nom, id_type_aliment doivent être spécifiés. L'id_aliment ne peut être modifié  
— Résultat : retourne le code de statut HTTP 200 (OK) et le corps de la réponse contient toutes les anciennes et nouvelles infos sur l'aliment au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  
  
### DELETE /aliments.php  
— Paramètres : le champ identifiant de l'aliment à supprimer (id_aliment)  
— Résultat : retourne le code de statut HTTP 200 (OK) et le corps de la réponse contient toutes les anciennes infos sur l'aliment au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  


## Requêtes et Endpoints possibles : repas.php
  
### GET /repas.php  
— Paramètres : aucun  
— Résultat : retourne tous les repas de la base (JSON)  
  
### GET /repas.php  
— Paramètres : le champ identifiant du repas qui nous intéresse (id_repas : entier)  
— Résultat : retourne toutes les infos de l'repas d'identifiant id_repas (JSON)  
  
### GET /repas.php  
— Paramètres : le champ identifiant d'un utilisateur qui nous intéresse (id_mangeur : entier)  
— Résultat : retourne toutes les infos de tous les repas mangé par cet utilisateur (JSON)  
  
### POST /repas.php  
— Paramètres : tous les champs du repas à créer (id_mangeur : entier, id_aliment_mange : entier, qte : flottant, date : date) sauf le champ id_repas qui sera automatique affecté par le serveur. Les champs id_mangeur, id_aliment_mange et qte doivent être spécifiés  
— Résultat : retourne le code de statut HTTP 201 (Created); le champ Location de la réponse HTTP contient l’URL de la nouvelle ressource donc son identifiant (exemple : Location:"repas.php?id_repas=3"); et le corps de la réponse contient aussi toutes les infos du nouveau repas au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  
  
### PUT /repas.php  
— Paramètres : tous les nouveaux champs du repas à modifier (id_repas : entier, id_mangeur : entier, id_aliment_mange : entier, qte : flottant, date : date). Les champs id_repas, id_mangeur, id_aliment_mange et qte doivent être spécifiés. L'id_repas ne peut être modifié  
— Résultat : retourne le code de statut HTTP 200 (OK) et le corps de la réponse contient toutes les anciennes et nouvelles infos sur le repas au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  
  
### DELETE /repas.php  
— Paramètres : le champ identifiant du repas à supprimer (id_repas)  
— Résultat : retourne le code de statut HTTP 200 (OK) et le corps de la réponse contient toutes les anciennes infos sur le repas au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  



