# API REST
  
## Requêtes et Endpoints possibles  

### GET /users.php  
— Paramètres : aucun  
— Résultat : retourne tous les utilisateurs de la base (JSON)  
  
### GET /users.php  
— Paramètres : le champ identifiant de l'utilisateur qui nous intéresse (id)  
— Résultat : retourne toutes les infos de l'utilisateur d'identifiant id (JSON)  
  
### POST /users.php  
— Paramètres : tous les champs de l’utilsateur à créer (name, email) sauf le champ id qui sera automatique affecté par le serveur  
— Résultat : retourne le code de statut HTTP 201 (Created); le champ Location de l’en-tête HTTP doit contenir l’URL de la nouvelle ressource donc son identifiant (exemple : Location: /user.php/5); et le corps de la réponse contient toutes les infos de l’utilisateur au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  
  
### PUT /users.php  
— Paramètres : tous les champs de l’utilisateur à modifier (id, nouveau name, nouvel email)  
— Résultat : retourne le code de statut HTTP 200 (OK) et le corps de la réponse contient toutes les anciennes et nouvelles infos sur l’utilisateur au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  
  
### DELETE /users.php  
— Paramètres : le champ identifiant de l'utilisateur à supprimer (id)  
— Résultat : retourne le code de statut HTTP 200 (OK) et le corps de la réponse contient toutes les anciennes infos sur l’utilisateur au format JSON  
En cas d’erreur, retourne le code d’erreur de statut HTTP adapté  





array = json_decode(file_get_contents('php://input'));