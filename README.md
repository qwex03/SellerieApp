# Guide d'Installation

Suivez les étapes ci-dessous pour installer le projet :

1. **Cloner le projet**  
   Exécutez la commande suivante pour cloner le dépôt Git :  
   `git clone <URL_DU_PROJET>`

2. **Accéder au répertoire cloné**  
   Déplacez-vous dans le dossier cloné avec la commande :  
   `cd <NOM_DU_DOSSIER>`

3. **Installer les dépendances**  
   Installez les dépendances du projet avec Composer :  
   `composer install`

4. **Configurer la base de données**  
   Ouvrez le fichier `.env` et modifiez la ligne suivante pour refléter la configuration de votre base de données locale :  
   `DATABASE_URL="mysql://root:password@127.0.0.1:3306/nom_de_la_bdd"`

5. **Créer la base de données**  
   Créez la base de données en exécutant la commande :  
   `symfony console doctrine:database:create`

6. **Appliquer les migrations**  
   Appliquez les migrations de la base de données avec la commande :  
   `symfony console doctrine:migrations:migrate`

7. **Charger les fixtures**  
   Remplissez la base de données avec des fixtures en exécutant :  
   `symfony console doctrine:fixtures:load`

8. **Démarrer le serveur**
   `symfony server:start`
