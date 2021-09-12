# SnowTricks
OpenClassrooms Project -> Symfony blog

Voici quelques instructions très simples à suivre pour installer ce projet sur votre machine.

1.Aller sur le lien du repository GitHub :
https://github.com/qwang94/SnowTricks

2.Cliquer le bouton vert "Code"

3.Copier le lien HTTPS

4.Créer un dossier local dans lequel vous voulez installer ce projet sur votre machine et utiliser votre terminal pour naviguer dans ce dossier 

5.Saisissez la commande suivante pour initialiser votre dossier au git:
git init

6.Saississez ensuite la commande suivante pour cloner le projet dans ce dossier
git clone lienHTTPS

7.Ouvrez le dossier contenant le projet avec un éditeur de texte type VsCode

8.ajoutez un fichier .env dans le racine du projet, puis dans le fichier mettre : 
    APP_ENV=dev
    APP_SECRET=541f0c25cf7d2eb3194c863f713ac551
    MAILER_DSN=votre paramètre mailer
    DATABASE_URL="sqlite:///%kernel.project_dir%/var/snowtricks.db"  

8.Installer une extention qui se nomme "Sqlite"

9.Importer le fichier des données dans votre dossier projet

10.Faites enfin "composer install" dans votre ligne de commande pour installer toutes les dépendances

11.Mainteant le projet devrait être correctement installé sur votre machine, vous pouvez consulter le site web en faisant un "symfony serve" ou "php bin/console server:start" pour lancer le projet.
